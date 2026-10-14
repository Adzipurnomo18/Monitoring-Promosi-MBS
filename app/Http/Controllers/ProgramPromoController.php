<?php

namespace App\Http\Controllers;

use App\Models\EventPromosi;
use App\Models\MetodeKesepakatan;
use App\Models\Outlet;
use App\Models\ProgramPromo;
use App\Models\ProgramPromoOutlet;
use App\Models\SaranaPromosi;
use App\Models\Supplier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProgramPromoController extends Controller
{
    /**
     * Display a listing of promotional programs with filters.
     */
    public function index(Request $request): View
    {
        $query = ProgramPromo::with(['supplier', 'eventPromosi', 'metodeKesepakatan', 'programPromoOutlets.outlet'])
            ->latest('id');

        // Filter: Keyword search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_program', 'like', "%{$search}%")
                    ->orWhere('judul_program', 'like', "%{$search}%")
                    ->orWhereHas('supplier', function ($sq) use ($search) {
                        $sq->where('nama_supplier', 'like', "%{$search}%");
                    });
            });
        }

        // Filter: Status
        if ($status = $request->input('status')) {
            if ($status !== 'semua') {
                $query->where('status', $status);
            }
        }

        // Filter: Supplier
        if ($supplierId = $request->input('supplier_id')) {
            $query->where('supplier_id', $supplierId);
        }

        // Filter: Tahun
        if ($tahun = $request->input('tahun')) {
            $query->where('tahun', $tahun);
        }

        $programs = $query->paginate(10)->withQueryString();

        // Summary Stats
        $stats = [
            'total' => ProgramPromo::count(),
            'berjalan' => ProgramPromo::where('status', 'berjalan')->count(),
            'siap_tagih' => ProgramPromo::where('status', 'siap_tagih')->count(),
            'ditagih' => ProgramPromo::where('status', 'ditagih')->count(),
            'lunas' => ProgramPromo::where('status', 'lunas')->count(),
            'total_nilai' => ProgramPromo::sum('total_nilai'),
        ];

        $suppliers = Supplier::orderBy('nama_supplier')->get();
        $statuses = [
            'draft' => 'Draft',
            'diajukan' => 'Diajukan',
            'disetujui' => 'Disetujui',
            'berjalan' => 'Berjalan',
            'realisasi' => 'Realisasi',
            'verifikasi' => 'Verifikasi',
            'konfirmasi_supplier' => 'Konfirmasi Supplier',
            'siap_tagih' => 'Siap Tagih',
            'ditagih' => 'Ditagih',
            'lunas' => 'Lunas',
        ];

        return view('program.index', compact('programs', 'stats', 'suppliers', 'statuses'));
    }

    /**
     * Show the form for creating a new promotional program.
     */
    public function create(): View
    {
        $suppliers = Supplier::where('is_active', 1)->orderBy('nama_supplier')->get();
        $events = EventPromosi::orderByDesc('tahun')->get();
        $metodes = MetodeKesepakatan::orderBy('nama_metode')->get();
        $outlets = Outlet::with('perusahaan')->where('is_active', 1)->orderBy('nama_outlet')->get();
        $saranas = SaranaPromosi::orderBy('nama_sarana')->get();

        // Auto-generate nomor program format: PFM-YYMM-XXXX
        $countThisYear = ProgramPromo::whereYear('created_at', now()->year)->count() + 1;
        $autoNomor = 'PFM-'.now()->format('ym').'-'.str_pad((string) $countThisYear, 4, '0', STR_PAD_LEFT);

        return view('program.create', compact('suppliers', 'events', 'metodes', 'outlets', 'saranas', 'autoNomor'));
    }

    /**
     * Store a newly created promotional program.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul_program' => ['required', 'string', 'max:255'],
            'supplier_id' => ['required', 'exists:supplier,id'],
            'metode_kesepakatan_id' => ['required', 'exists:metode_kesepakatan,id'],
            'event_promosi_id' => ['nullable', 'exists:event_promosi,id'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'status' => ['required', 'in:draft,diajukan,disetujui,berjalan'],
            'catatan' => ['nullable', 'string'],
            'outlets' => ['required', 'array', 'min:1'],
            'outlets.*' => ['exists:outlet,id'],
            'alokasi' => ['nullable', 'array'],
        ], [
            'judul_program.required' => 'Judul program promo wajib diisi.',
            'supplier_id.required' => 'Pilih supplier rekanan promosi.',
            'metode_kesepakatan_id.required' => 'Pilih metode kesepakatan.',
            'tanggal_mulai.required' => 'Tanggal mulai promo wajib ditentukan.',
            'tanggal_selesai.required' => 'Tanggal selesai promo wajib ditentukan.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
            'outlets.required' => 'Pilih minimal satu outlet / cabang yang berpartisipasi.',
            'outlets.min' => 'Pilih minimal satu outlet / cabang yang berpartisipasi.',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $countThisYear = ProgramPromo::whereYear('created_at', now()->year)->count() + 1;
            $nomorProgram = 'PFM-'.now()->format('ym').'-'.str_pad((string) $countThisYear, 4, '0', STR_PAD_LEFT);

            // Hitung total nilai alokasi outlet
            $totalNilai = 0;
            $outletAllocations = $request->input('alokasi', []);
            foreach ($validated['outlets'] as $outletId) {
                $val = floatval($outletAllocations[$outletId] ?? 0);
                $totalNilai += $val;
            }

            // Jika form alokasi belum diisi spesifik, fallback ke default nilai jika ada
            if ($totalNilai <= 0 && $request->filled('total_nilai_manual')) {
                $totalNilai = floatval($request->input('total_nilai_manual'));
            }

            $program = ProgramPromo::create([
                'nomor_program' => $nomorProgram,
                'judul_program' => $validated['judul_program'],
                'tahun' => (int) date('Y', strtotime($validated['tanggal_mulai'])),
                'supplier_id' => $validated['supplier_id'],
                'event_promosi_id' => $validated['event_promosi_id'] ?: null,
                'metode_kesepakatan_id' => $validated['metode_kesepakatan_id'],
                'status' => $validated['status'],
                'tanggal_mulai' => $validated['tanggal_mulai'],
                'tanggal_selesai' => $validated['tanggal_selesai'],
                'total_nilai' => $totalNilai,
                'nilai_realisasi' => 0,
                'catatan' => $validated['catatan'] ?? null,
            ]);

            // Insert relasi outlet
            foreach ($validated['outlets'] as $outletId) {
                $alokasiVal = floatval($outletAllocations[$outletId] ?? ($totalNilai / count($validated['outlets'])));
                ProgramPromoOutlet::create([
                    'program_promo_id' => $program->id,
                    'outlet_id' => $outletId,
                    'status_realisasi_outlet' => 'menunggu_outlet',
                    'nilai_alokasi' => $alokasiVal,
                ]);
            }
        });

        return redirect()->route('program.index')->with('success', 'Program Promosi berhasil dibuat dan didaftarkan ke sistem!');
    }

    /**
     * Display the specified program detail (JSON or modal data).
     */
    public function show(ProgramPromo $programPromo): JsonResponse
    {
        $programPromo->load([
            'supplier',
            'eventPromosi',
            'metodeKesepakatan',
            'programPromoOutlets.outlet.perusahaan',
            'tagihanAr',
        ]);

        return response()->json([
            'success' => true,
            'data' => $programPromo,
        ]);
    }

    /**
     * Update status of promotional program.
     */
    public function updateStatus(Request $request, ProgramPromo $programPromo): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:draft,diajukan,disetujui,berjalan,realisasi,verifikasi,konfirmasi_supplier,siap_tagih,ditagih,lunas'],
        ]);

        $programPromo->update([
            'status' => $validated['status'],
        ]);

        return back()->with('success', "Status program {$programPromo->nomor_program} berhasil diperbarui menjadi {$validated['status']}.");
    }
}

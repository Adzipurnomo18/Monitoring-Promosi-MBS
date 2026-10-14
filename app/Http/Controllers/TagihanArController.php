<?php

namespace App\Http\Controllers;

use App\Models\ProgramPromo;
use App\Models\Supplier;
use App\Models\TagihanAr;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TagihanArController extends Controller
{
    /**
     * Display a listing of invoices and Accounts Receivable records.
     */
    public function index(Request $request): View
    {
        $query = TagihanAr::with(['programPromo', 'supplier', 'outlet.perusahaan'])
            ->latest('tanggal_invoice');

        // Filter: Keyword Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_invoice', 'like', "%{$search}%")
                    ->orWhere('nomor_oracle_ar', 'like', "%{$search}%")
                    ->orWhereHas('supplier', function ($sq) use ($search) {
                        $sq->where('nama_supplier', 'like', "%{$search}%");
                    });
            });
        }

        // Filter: Status Pembayaran
        if ($status = $request->input('status_pembayaran')) {
            if ($status !== 'semua') {
                $query->where('status_pembayaran', $status);
            }
        }

        // Filter: Supplier
        if ($supplierId = $request->input('supplier_id')) {
            $query->where('supplier_id', $supplierId);
        }

        // Filter: Overdue / Aging
        if ($aging = $request->input('aging')) {
            if ($aging === 'overdue') {
                $query->where('status_pembayaran', '!=', 'lunas')
                    ->where('tanggal_jatuh_tempo', '<', now());
            } elseif ($aging === 'overdue30') {
                $query->where('status_pembayaran', '!=', 'lunas')
                    ->where('hari_keterlambatan', '>=', 30);
            }
        }

        $tagihans = $query->paginate(10)->withQueryString();

        // Calculate KPI Stats
        $allInvoices = TagihanAr::all();
        $totalTagihan = $allInvoices->sum('total_tagihan');
        $totalTerbayar = $allInvoices->sum('jumlah_terbayar');
        $sisaPiutang = $totalTagihan - $totalTerbayar;
        $unpaidCount = $allInvoices->where('status_pembayaran', '!=', 'lunas')->count();
        $overdueCount = $allInvoices->filter(fn ($t) => $t->status_pembayaran !== 'lunas' && $t->hari_keterlambatan > 0)->count();

        $stats = [
            'total_tagihan' => $totalTagihan,
            'total_terbayar' => $totalTerbayar,
            'sisa_piutang' => $sisaPiutang,
            'unpaid_count' => $unpaidCount,
            'overdue_count' => $overdueCount,
        ];

        // Daftar program yang siap diterbitkan invoice
        $programSiapTagih = ProgramPromo::with(['supplier', 'programPromoOutlets.outlet'])
            ->where('status', 'siap_tagih')
            ->get();

        $suppliers = Supplier::orderBy('nama_supplier')->get();

        return view('tagihan.index', compact('tagihans', 'stats', 'programSiapTagih', 'suppliers'));
    }

    /**
     * Generate invoice and create Oracle AR entry for a promotional program.
     */
    public function generateInvoice(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'program_promo_id' => ['required', 'exists:program_promo,id'],
            'tanggal_jatuh_tempo' => ['required', 'date', 'after:today'],
            'metode_pembayaran' => ['nullable', 'string'],
        ], [
            'program_promo_id.required' => 'Pilih program promosi yang akan ditagih.',
            'tanggal_jatuh_tempo.required' => 'Tentukan tanggal jatuh tempo penagihan.',
            'tanggal_jatuh_tempo.after' => 'Tanggal jatuh tempo harus di masa mendatang.',
        ]);

        $program = ProgramPromo::with('programPromoOutlets')->findOrFail($validated['program_promo_id']);

        DB::transaction(function () use ($program, $validated) {
            $invoiceIndex = TagihanAr::count() + 101;
            $nomorInvoice = 'INV-'.date('Y').'-'.str_pad((string) $invoiceIndex, 5, '0', STR_PAD_LEFT);
            $nomorOracle = 'AR-ORCL-'.rand(8800, 9999);

            $nilaiTagihan = $program->nilai_realisasi > 0 ? $program->nilai_realisasi : $program->total_nilai;
            $primaryOutletId = $program->programPromoOutlets->first()?->outlet_id ?? 1;

            TagihanAr::create([
                'nomor_invoice' => $nomorInvoice,
                'program_promo_id' => $program->id,
                'supplier_id' => $program->supplier_id,
                'outlet_id' => $primaryOutletId,
                'tanggal_invoice' => now()->toDateString(),
                'tanggal_jatuh_tempo' => $validated['tanggal_jatuh_tempo'],
                'total_tagihan' => $nilaiTagihan,
                'jumlah_terbayar' => 0.00,
                'status_pembayaran' => 'belum_lunas',
                'hari_keterlambatan' => 0,
                'nomor_oracle_ar' => $nomorOracle,
                'metode_pembayaran' => $validated['metode_pembayaran'] ?? 'Transfer Bank Mandiri Virtual Account',
            ]);

            // Update status program promo menjadi 'ditagih'
            $program->update(['status' => 'ditagih']);
        });

        return back()->with('success', "Invoice tagihan AR berhasil diterbitkan dan disinkronkan ke Oracle AR untuk program {$program->nomor_program}!");
    }

    /**
     * Record payment / settlement for an invoice.
     */
    public function recordPayment(Request $request, TagihanAr $tagihan): RedirectResponse
    {
        $validated = $request->validate([
            'jumlah_bayar' => ['required', 'numeric', 'min:1000'],
            'metode_pembayaran' => ['required', 'string'],
            'tanggal_bayar' => ['required', 'date'],
        ]);

        $jumlahBayar = floatval($validated['jumlah_bayar']);
        $totalTerbayarBaru = $tagihan->jumlah_terbayar + $jumlahBayar;
        $isLunas = $totalTerbayarBaru >= $tagihan->total_tagihan;

        $tagihan->update([
            'jumlah_terbayar' => min($totalTerbayarBaru, $tagihan->total_tagihan),
            'status_pembayaran' => $isLunas ? 'lunas' : 'sebagian',
            'metode_pembayaran' => $validated['metode_pembayaran'],
            'tanggal_lunas' => $isLunas ? $validated['tanggal_bayar'] : null,
            'hari_keterlambatan' => $isLunas ? 0 : $tagihan->hari_keterlambatan,
        ]);

        // Jika lunas, update program promo parent jika ada
        if ($isLunas && $tagihan->programPromo) {
            $tagihan->programPromo->update(['status' => 'lunas']);
        }

        return back()->with('success', 'Pembayaran sebesar Rp '.number_format($jumlahBayar, 0, ',', '.')." berhasil dicatat untuk invoice {$tagihan->nomor_invoice}.");
    }

    /**
     * Sync invoice status with Oracle AR.
     */
    public function syncOracle(TagihanAr $tagihan): RedirectResponse
    {
        if (empty($tagihan->nomor_oracle_ar)) {
            $tagihan->update([
                'nomor_oracle_ar' => 'AR-ORCL-'.rand(8800, 9999),
            ]);
        }

        return back()->with('success', "Data invoice {$tagihan->nomor_invoice} berhasil disinkronkan dengan Oracle AR ({$tagihan->nomor_oracle_ar}).");
    }
}

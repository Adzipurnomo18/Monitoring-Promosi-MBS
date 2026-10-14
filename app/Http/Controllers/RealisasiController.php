<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\ProgramPromo;
use App\Models\ProgramPromoOutlet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RealisasiController extends Controller
{
    /**
     * Display a listing of outlet realizations & verification queue.
     */
    public function index(Request $request): View
    {
        $query = ProgramPromoOutlet::with(['programPromo.supplier', 'programPromo.metodeKesepakatan', 'outlet.perusahaan'])
            ->latest('id');

        // Filter: Keyword
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('programPromo', function ($pq) use ($search) {
                    $pq->where('nomor_program', 'like', "%{$search}%")
                        ->orWhere('judul_program', 'like', "%{$search}%");
                })->orWhereHas('outlet', function ($oq) use ($search) {
                    $oq->where('nama_outlet', 'like', "%{$search}%")
                        ->orWhere('ou_code', 'like', "%{$search}%");
                });
            });
        }

        // Filter: Outlet
        if ($outletId = $request->input('outlet_id')) {
            $query->where('outlet_id', $outletId);
        }

        // Filter: Status Realisasi
        if ($status = $request->input('status_realisasi')) {
            if ($status !== 'semua') {
                $query->where('status_realisasi_outlet', $status);
            }
        }

        // Filter: Program Promo
        if ($programId = $request->input('program_id')) {
            $query->where('program_promo_id', $programId);
        }

        $realisasis = $query->paginate(12)->withQueryString();

        // Stats
        $stats = [
            'total' => ProgramPromoOutlet::count(),
            'menunggu_outlet' => ProgramPromoOutlet::where('status_realisasi_outlet', 'menunggu_outlet')->count(),
            'sudah_realisasi' => ProgramPromoOutlet::where('status_realisasi_outlet', 'sudah_realisasi')->count(),
            'revisi' => ProgramPromoOutlet::where('status_realisasi_outlet', 'revisi')->count(),
            'total_alokasi' => ProgramPromoOutlet::sum('nilai_alokasi'),
        ];

        $outlets = Outlet::orderBy('nama_outlet')->get();
        $programs = ProgramPromo::orderBy('nomor_program')->get();

        return view('realisasi.index', compact('realisasis', 'stats', 'outlets', 'programs'));
    }

    /**
     * Update realization data & proof uploaded by outlet or admin.
     */
    public function update(Request $request, ProgramPromoOutlet $realisasi): RedirectResponse
    {
        $validated = $request->validate([
            'status_realisasi_outlet' => ['required', 'in:menunggu_outlet,sudah_realisasi,revisi'],
            'tanggal_realisasi' => ['nullable', 'date'],
            'catatan_outlet' => ['nullable', 'string', 'max:500'],
            'foto_bukti' => ['nullable', 'string', 'max:255'],
        ]);

        $realisasi->update([
            'status_realisasi_outlet' => $validated['status_realisasi_outlet'],
            'tanggal_realisasi' => $validated['tanggal_realisasi'] ?? now()->toDateString(),
            'catatan_outlet' => $validated['catatan_outlet'] ?? $realisasi->catatan_outlet,
            'foto_bukti' => $validated['foto_bukti'] ?? $realisasi->foto_bukti,
        ]);

        // Cek apakah seluruh outlet dalam program ini sudah realisasi
        $parentProgram = $realisasi->programPromo;
        if ($parentProgram) {
            $totalOutlets = $parentProgram->programPromoOutlets()->count();
            $completedOutlets = $parentProgram->programPromoOutlets()
                ->where('status_realisasi_outlet', 'sudah_realisasi')
                ->count();

            // Hitung akumulasi realisasi
            $totalRealisasiNilai = $parentProgram->programPromoOutlets()
                ->where('status_realisasi_outlet', 'sudah_realisasi')
                ->sum('nilai_alokasi');

            $parentProgram->update([
                'nilai_realisasi' => $totalRealisasiNilai,
            ]);

            // Jika semua outlet sudah selesai, update program jadi 'siap_tagih'
            if ($totalOutlets > 0 && $totalOutlets === $completedOutlets && in_array($parentProgram->status, ['berjalan', 'realisasi', 'verifikasi'])) {
                $parentProgram->update(['status' => 'siap_tagih']);
            }
        }

        return back()->with('success', 'Status realisasi outlet berhasil diperbarui!');
    }

    /**
     * HO Approval / Verifikasi Cepat.
     */
    public function verify(Request $request, ProgramPromoOutlet $realisasi): RedirectResponse
    {
        $action = $request->input('action', 'approve');

        if ($action === 'approve') {
            $realisasi->update([
                'status_realisasi_outlet' => 'sudah_realisasi',
                'tanggal_realisasi' => now()->toDateString(),
                'catatan_outlet' => ($realisasi->catatan_outlet ? $realisasi->catatan_outlet.' | ' : '').'Diverifikasi HO pada '.now()->format('d/m/Y H:i'),
            ]);

            // Update parent program's nilai_realisasi
            $parentProgram = $realisasi->programPromo;
            if ($parentProgram) {
                $completedSum = $parentProgram->programPromoOutlets()
                    ->where('status_realisasi_outlet', 'sudah_realisasi')
                    ->sum('nilai_alokasi');
                $parentProgram->update(['nilai_realisasi' => $completedSum]);
            }

            return back()->with('success', "Realisasi untuk {$realisasi->outlet->nama_outlet} telah disetujui & diverifikasi HO.");
        } else {
            $catatan = $request->input('catatan', 'Perlu perbaikan bukti display.');
            $realisasi->update([
                'status_realisasi_outlet' => 'revisi',
                'catatan_outlet' => $catatan,
            ]);

            return back()->with('success', "Realisasi untuk {$realisasi->outlet->nama_outlet} ditandai memerlukan revisi.");
        }
    }
}

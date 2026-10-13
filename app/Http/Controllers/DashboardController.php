<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the Monitoring Promosi dashboard.
     */
    public function index(Request $request): View
    {
        // 1. KPI Summary
        $summary = DB::table('dashboard_summary')->where('tahun', 2026)->first() ?? (object) [
            'total_program_berjalan' => 27,
            'program_berakhir_7_hari' => 4,
            'realisasi_belum_ditagih' => 408300000,
            'program_masuk_akrual' => 24,
            'tagihan_belum_lunas' => 455900000,
            'invoice_belum_lunas' => 113,
            'tagihan_lewat_30_hari' => 70200000,
            'diterima_tahun_berjalan' => 1820000000,
            'total_pembayaran_selesai' => 268,
            'last_pos_sync' => '2026-10-12 06:00:00',
            'last_oracle_sync' => '2026-10-12 07:00:00',
        ];

        // 2. Workflow Stages (Alur program per tahap)
        $stages = DB::table('workflow_stages')
            ->orderBy('urutan')
            ->get();

        // 3. Perlu Tindakan (Action Items / SLA)
        $perluTindakan = DB::table('perlu_tindakan')
            ->where('is_resolved', 0)
            ->get();

        // 4. Umur Tagihan Belum Lunas
        $umurTagihan = DB::table('umur_tagihan')
            ->orderBy('urutan')
            ->get();

        // 5. Rekap Supplier AR
        $supplierAr = DB::table('rekap_supplier_ar')
            ->orderBy('urutan')
            ->get();

        // 6. Ringkasan Per Outlet
        $outletSummary = DB::table('rekap_outlet_dashboard as rod')
            ->join('outlet as o', 'rod.outlet_id', '=', 'o.id')
            ->join('perusahaan as p', 'o.perusahaan_id', '=', 'p.id')
            ->select(
                'rod.*',
                'o.nama_outlet',
                'o.ou_code',
                'p.nama_perusahaan'
            )
            ->orderBy('rod.urutan')
            ->get();

        // 7. Master filter options
        $perusahaanList = DB::table('perusahaan')->get();
        $outletList = DB::table('outlet')->get();
        $supplierList = DB::table('supplier')->get();

        // 8. Monthly Trends for Chart
        $monthlyTrend = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            'program' => [220, 225, 240, 225, 270, 270, 220, 245, 220, 200, 245, 365],
            'realisasi' => [160, 155, 160, 155, 185, 190, 185, 190, 165, 155, 200, 200],
            'tagihan' => [50, 90, 90, 100, 140, 110, 120, 160, 160, 165, 150, 230],
            'pembayaran' => [50, 80, 115, 110, 180, 140, 160, 170, 180, 175, 195, 305],
            'trendline' => [100, 110, 130, 140, 160, 175, 210, 190, 235, 285, 290, 290],
        ];

        // 9. Donut Distribution Stages
        $distributionStages = [
            ['name' => 'Draft', 'count' => 18, 'percentage' => 34, 'color' => '#94a3b8'],
            ['name' => 'Diajukan', 'count' => 6, 'percentage' => 11, 'color' => '#0284c7'],
            ['name' => 'Disetujui', 'count' => 4, 'percentage' => 7, 'color' => '#14b8a6'],
            ['name' => 'Berjalan', 'count' => 27, 'percentage' => 25, 'color' => '#10b981'],
            ['name' => 'Realisasi', 'count' => 6, 'percentage' => 11, 'color' => '#f59e0b'],
            ['name' => 'Verifikasi', 'count' => 4, 'percentage' => 7, 'color' => '#f97316'],
            ['name' => 'Konfirmasi Supplier', 'count' => 6, 'percentage' => 11, 'color' => '#8b5cf6'],
            ['name' => 'Siap Tagih', 'count' => 8, 'percentage' => 14, 'color' => '#ef4444'],
        ];

        // 10. Realisasi vs Tagihan vs Pembayaran
        $comparisonMetrics = [
            'total_program' => ['label' => 'Total Program', 'value' => 'Rp 1,25 M', 'percent' => 100, 'color' => 'bg-blue-600'],
            'realisasi' => ['label' => 'Realisasi', 'value' => 'Rp 846,2 jt', 'percent' => 68, 'color' => 'bg-emerald-500'],
            'tagihan' => ['label' => 'Tagihan', 'value' => 'Rp 723,1 jt', 'percent' => 58, 'color' => 'bg-amber-500'],
            'pembayaran' => ['label' => 'Pembayaran', 'value' => 'Rp 611,9 jt', 'percent' => 49, 'color' => 'bg-indigo-600'],
        ];

        return view('dashboard', compact(
            'summary',
            'stages',
            'perluTindakan',
            'umurTagihan',
            'supplierAr',
            'outletSummary',
            'perusahaanList',
            'outletList',
            'supplierList',
            'monthlyTrend',
            'distributionStages',
            'comparisonMetrics'
        ));
    }
}

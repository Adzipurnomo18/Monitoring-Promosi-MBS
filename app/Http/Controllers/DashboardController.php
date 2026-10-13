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

        return view('dashboard', compact(
            'summary',
            'stages',
            'perluTindakan',
            'umurTagihan',
            'supplierAr',
            'outletSummary',
            'perusahaanList',
            'outletList',
            'supplierList'
        ));
    }
}

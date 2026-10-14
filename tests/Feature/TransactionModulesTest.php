<?php

namespace Tests\Feature;

use App\Models\EventPromosi;
use App\Models\MetodeKesepakatan;
use App\Models\Outlet;
use App\Models\Perusahaan;
use App\Models\ProgramPromo;
use App\Models\ProgramPromoOutlet;
use App\Models\Supplier;
use App\Models\TagihanAr;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionModulesTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected Supplier $supplier;

    protected Outlet $outlet;

    protected MetodeKesepakatan $metode;

    protected EventPromosi $event;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        $perusahaan = Perusahaan::create([
            'kode_perusahaan' => 'SPK',
            'nama_perusahaan' => 'PT Surya Pratama Keramindo',
        ]);

        $this->outlet = Outlet::create([
            'perusahaan_id' => $perusahaan->id,
            'nama_outlet' => 'Pekanbaru',
            'ou_code' => 'PKU_HO',
            'kota' => 'Pekanbaru',
        ]);

        $this->supplier = Supplier::create([
            'kode_supplier' => 'SUP-MULIA',
            'nama_supplier' => 'Signature by Mulia',
            'kategori' => 'Keramik & Granit',
            'status_customer_ar' => 'terdaftar',
            'status_alamat_tagih' => 'lengkap',
        ]);

        $this->metode = MetodeKesepakatan::create([
            'kode_metode' => 'MK-ENDCAP',
            'nama_metode' => 'Sewa End Cap Premium',
            'deskripsi' => 'Sewa rak display',
        ]);

        $this->event = EventPromosi::create([
            'nama_event' => 'Promo Awal Tahun 2026',
            'tahun' => 2026,
            'tanggal_mulai' => now()->toDateString(),
            'tanggal_selesai' => now()->addDays(60)->toDateString(),
        ]);
    }

    public function test_program_promo_page_is_accessible(): void
    {
        $response = $this->get(route('program.index'));
        $response->assertStatus(200);
        $response->assertSee('Daftar Program Promosi');
    }

    public function test_create_program_page_is_accessible(): void
    {
        $response = $this->get(route('program.create'));
        $response->assertStatus(200);
        $response->assertSee('Form Pengajuan Program Promo');
    }

    public function test_can_create_new_promotional_program(): void
    {
        $payload = [
            'judul_program' => 'Test Promo Granit Nasional 2026',
            'supplier_id' => $this->supplier->id,
            'metode_kesepakatan_id' => $this->metode->id,
            'event_promosi_id' => $this->event->id,
            'status' => 'berjalan',
            'tanggal_mulai' => now()->toDateString(),
            'tanggal_selesai' => now()->addDays(30)->toDateString(),
            'outlets' => [$this->outlet->id],
            'alokasi' => [
                $this->outlet->id => 15000000,
            ],
            'catatan' => 'Uji coba otomatisasi fitur program promo.',
        ];

        $response = $this->post(route('program.store'), $payload);

        $response->assertRedirect(route('program.index'));
        $this->assertDatabaseHas('program_promo', [
            'judul_program' => 'Test Promo Granit Nasional 2026',
            'supplier_id' => $this->supplier->id,
        ]);
    }

    public function test_realisasi_page_is_accessible(): void
    {
        $program = ProgramPromo::create([
            'nomor_program' => 'PFM-2601-TEST',
            'judul_program' => 'Promo Test Realisasi',
            'tahun' => 2026,
            'supplier_id' => $this->supplier->id,
            'metode_kesepakatan_id' => $this->metode->id,
            'status' => 'berjalan',
            'tanggal_mulai' => now()->toDateString(),
            'tanggal_selesai' => now()->addDays(30)->toDateString(),
            'total_nilai' => 20000000,
        ]);

        ProgramPromoOutlet::create([
            'program_promo_id' => $program->id,
            'outlet_id' => $this->outlet->id,
            'status_realisasi_outlet' => 'menunggu_outlet',
            'nilai_alokasi' => 20000000,
        ]);

        $response = $this->get(route('realisasi.index'));
        $response->assertStatus(200);
        $response->assertSee('Realisasi & Verifikasi Promosi');
    }

    public function test_tagihan_ar_page_is_accessible(): void
    {
        $program = ProgramPromo::create([
            'nomor_program' => 'PFM-2601-TAGIH',
            'judul_program' => 'Promo Siap Tagih',
            'tahun' => 2026,
            'supplier_id' => $this->supplier->id,
            'metode_kesepakatan_id' => $this->metode->id,
            'status' => 'siap_tagih',
            'tanggal_mulai' => now()->toDateString(),
            'tanggal_selesai' => now()->addDays(30)->toDateString(),
            'total_nilai' => 10000000,
        ]);

        TagihanAr::create([
            'nomor_invoice' => 'INV-2026-TEST01',
            'program_promo_id' => $program->id,
            'supplier_id' => $this->supplier->id,
            'outlet_id' => $this->outlet->id,
            'tanggal_invoice' => now()->toDateString(),
            'tanggal_jatuh_tempo' => now()->addDays(30)->toDateString(),
            'total_tagihan' => 10000000,
            'jumlah_terbayar' => 0,
            'status_pembayaran' => 'belum_lunas',
        ]);

        $response = $this->get(route('tagihan.index'));
        $response->assertStatus(200);
        $response->assertSee('Tagihan AR (Accounts Receivable)');
    }
}

<?php

namespace Tests\Feature;

use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasterDataModulesTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_metode_kesepakatan_is_accessible_and_can_be_stored(): void
    {
        $response = $this->get(route('master.metode'));
        $response->assertStatus(200);
        $response->assertSee('Master Metode Kesepakatan');

        $storeResponse = $this->post(route('master.metode.store'), [
            'kode_metode' => 'MK-TEST-01',
            'nama_metode' => 'Sewa Rak Display Khusus',
            'deskripsi' => 'Testing metode kesepakatan',
        ]);

        $storeResponse->assertRedirect();
        $this->assertDatabaseHas('metode_kesepakatan', [
            'kode_metode' => 'MK-TEST-01',
            'nama_metode' => 'Sewa Rak Display Khusus',
        ]);
    }

    public function test_event_promosi_is_accessible_and_can_be_stored(): void
    {
        $response = $this->get(route('master.event'));
        $response->assertStatus(200);
        $response->assertSee('Master Event Promosi');

        $storeResponse = $this->post(route('master.event.store'), [
            'nama_event' => 'MBS Super Festival 2026',
            'tahun' => 2026,
            'tanggal_mulai' => now()->toDateString(),
            'tanggal_selesai' => now()->addDays(30)->toDateString(),
            'deskripsi' => 'Pameran promo bahan bangunan terbesar',
        ]);

        $storeResponse->assertRedirect();
        $this->assertDatabaseHas('event_promosi', [
            'nama_event' => 'MBS Super Festival 2026',
        ]);
    }

    public function test_sarana_promosi_is_accessible_and_can_be_stored(): void
    {
        $response = $this->get(route('master.sarana'));
        $response->assertStatus(200);
        $response->assertSee('Sarana Promosi');

        $storeResponse = $this->post(route('master.sarana.store'), [
            'kode_sarana' => 'SRN-TEST-01',
            'nama_sarana' => 'Display Pintu Masuk Granit',
            'kategori_sarana' => 'Floor Display',
            'lokasi' => 'Pintu Masuk Utama',
            'tarif_standar' => 8500000,
        ]);

        $storeResponse->assertRedirect();
        $this->assertDatabaseHas('sarana_promosi', [
            'kode_sarana' => 'SRN-TEST-01',
        ]);
    }

    public function test_supplier_is_accessible_and_can_toggle_ar_status(): void
    {
        $supplier = Supplier::create([
            'kode_supplier' => 'SUP-INLITE-TEST',
            'nama_supplier' => 'Inlite Lighting Solution',
            'kategori' => 'Listrik & Pencahayaan',
            'status_customer_ar' => 'belum_terdaftar',
            'status_alamat_tagih' => 'belum_lengkap',
        ]);

        $response = $this->get(route('master.supplier'));
        $response->assertStatus(200);
        $response->assertSee('Customer AR');

        // Toggle AR to 'terdaftar'
        $toggleResponse = $this->post(route('master.supplier.toggle', $supplier->id), [
            'action' => 'ar',
        ]);

        $toggleResponse->assertRedirect();
        $this->assertDatabaseHas('supplier', [
            'id' => $supplier->id,
            'status_customer_ar' => 'terdaftar',
        ]);
    }
}

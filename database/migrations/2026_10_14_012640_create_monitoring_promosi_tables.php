<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('perusahaan')) {
            Schema::create('perusahaan', function (Blueprint $table) {
                $table->id();
                $table->string('kode_perusahaan', 20)->unique();
                $table->string('nama_perusahaan', 150);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('outlet')) {
            Schema::create('outlet', function (Blueprint $table) {
                $table->id();
                $table->foreignId('perusahaan_id')->constrained('perusahaan')->cascadeOnDelete();
                $table->string('nama_outlet', 100);
                $table->string('ou_code', 30)->unique();
                $table->string('kota', 100);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('supplier')) {
            Schema::create('supplier', function (Blueprint $table) {
                $table->id();
                $table->string('kode_supplier', 30)->unique();
                $table->string('nama_supplier', 150);
                $table->string('kategori', 100)->default('Bahan Bangunan');
                $table->string('kontak_person', 100)->nullable();
                $table->string('email', 100)->nullable();
                $table->string('telepon', 50)->nullable();
                $table->string('status_customer_ar', 50)->default('terdaftar');
                $table->string('status_alamat_tagih', 50)->default('lengkap');
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('metode_kesepakatan')) {
            Schema::create('metode_kesepakatan', function (Blueprint $table) {
                $table->id();
                $table->string('kode_metode', 30)->unique();
                $table->string('nama_metode', 100);
                $table->text('deskripsi')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('event_promosi')) {
            Schema::create('event_promosi', function (Blueprint $table) {
                $table->id();
                $table->string('nama_event', 150);
                $table->unsignedInteger('tahun')->default(2026);
                $table->date('tanggal_mulai');
                $table->date('tanggal_selesai');
                $table->text('deskripsi')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('sarana_promosi')) {
            Schema::create('sarana_promosi', function (Blueprint $table) {
                $table->id();
                $table->string('kode_sarana', 30)->unique();
                $table->string('nama_sarana', 150);
                $table->string('kategori_sarana', 100);
                $table->string('lokasi', 100)->default('Area Toko');
                $table->decimal('tarif_standar', 15, 2)->default(0.00);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('program_promo')) {
            Schema::create('program_promo', function (Blueprint $table) {
                $table->id();
                $table->string('nomor_program', 50)->unique();
                $table->string('judul_program', 255);
                $table->unsignedInteger('tahun')->default(2026);
                $table->foreignId('supplier_id')->constrained('supplier');
                $table->foreignId('event_promosi_id')->nullable()->constrained('event_promosi')->nullOnDelete();
                $table->foreignId('metode_kesepakatan_id')->constrained('metode_kesepakatan');
                $table->string('status', 50)->default('draft');
                $table->date('tanggal_mulai');
                $table->date('tanggal_selesai');
                $table->decimal('total_nilai', 15, 2)->default(0.00);
                $table->decimal('nilai_realisasi', 15, 2)->default(0.00);
                $table->text('catatan')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('program_promo_outlet')) {
            Schema::create('program_promo_outlet', function (Blueprint $table) {
                $table->id();
                $table->foreignId('program_promo_id')->constrained('program_promo')->cascadeOnDelete();
                $table->foreignId('outlet_id')->constrained('outlet')->cascadeOnDelete();
                $table->string('status_realisasi_outlet', 50)->default('menunggu_outlet');
                $table->decimal('nilai_alokasi', 15, 2)->default(0.00);
                $table->date('tanggal_realisasi')->nullable();
                $table->string('foto_bukti', 255)->nullable();
                $table->text('catatan_outlet')->nullable();
                $table->timestamps();
                $table->unique(['program_promo_id', 'outlet_id']);
            });
        }

        if (! Schema::hasTable('tagihan_ar')) {
            Schema::create('tagihan_ar', function (Blueprint $table) {
                $table->id();
                $table->string('nomor_invoice', 50)->unique();
                $table->foreignId('program_promo_id')->nullable()->constrained('program_promo')->nullOnDelete();
                $table->foreignId('supplier_id')->constrained('supplier');
                $table->foreignId('outlet_id')->constrained('outlet');
                $table->date('tanggal_invoice');
                $table->date('tanggal_jatuh_tempo');
                $table->decimal('total_tagihan', 15, 2)->default(0.00);
                $table->decimal('jumlah_terbayar', 15, 2)->default(0.00);
                $table->string('status_pembayaran', 50)->default('belum_lunas');
                $table->integer('hari_keterlambatan')->default(0);
                $table->string('nomor_oracle_ar', 50)->nullable();
                $table->string('metode_pembayaran', 100)->nullable();
                $table->date('tanggal_lunas')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihan_ar');
        Schema::dropIfExists('program_promo_outlet');
        Schema::dropIfExists('program_promo');
        Schema::dropIfExists('sarana_promosi');
        Schema::dropIfExists('event_promosi');
        Schema::dropIfExists('metode_kesepakatan');
        Schema::dropIfExists('supplier');
        Schema::dropIfExists('outlet');
        Schema::dropIfExists('perusahaan');
    }
};

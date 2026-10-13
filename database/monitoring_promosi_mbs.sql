-- ==============================================================
-- DATABASE: monitoring_promosi_mbs
-- SISTEM INFORMASI MONITORING PROMOSI - MITRA BANGUNAN SUPERMARKET (MBS GROUP)
-- DUMMY DATA BERDASARKAN DASHBOARD RESMI MBS
-- ==============================================================

SET FOREIGN_KEY_CHECKS = 0;

-- --------------------------------------------------------------
-- 1. Tabel Perusahaan (Company Master)
-- --------------------------------------------------------------
DROP TABLE IF EXISTS `perusahaan`;
CREATE TABLE `perusahaan` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode_perusahaan` VARCHAR(20) NOT NULL UNIQUE,
  `nama_perusahaan` VARCHAR(150) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `perusahaan` (`id`, `kode_perusahaan`, `nama_perusahaan`) VALUES
(1, 'SPK', 'PT Surya Pratama Keramindo'),
(2, 'SKK', 'PT Surya Kencana Keramindo'),
(3, 'SMB', 'PT Surya Mandiri Bangunan'),
(4, 'KMK', 'PT Karya Mandiri Keramindo');

-- --------------------------------------------------------------
-- 2. Tabel Outlet (Branches / Store Outlets)
-- --------------------------------------------------------------
DROP TABLE IF EXISTS `outlet`;
CREATE TABLE `outlet` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `perusahaan_id` BIGINT UNSIGNED NOT NULL,
  `nama_outlet` VARCHAR(100) NOT NULL,
  `ou_code` VARCHAR(30) NOT NULL UNIQUE,
  `kota` VARCHAR(100) NOT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_outlet_perusahaan` FOREIGN KEY (`perusahaan_id`) REFERENCES `perusahaan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `outlet` (`id`, `perusahaan_id`, `nama_outlet`, `ou_code`, `kota`) VALUES
(1, 1, 'Jambi', 'JMB_DIST', 'Jambi'),
(2, 1, 'Pakuan Baru', 'JB2_DIST', 'Jambi'),
(3, 1, 'Pekanbaru', 'PKU_HO', 'Pekanbaru'),
(4, 2, 'Palembang', 'PLB_HO', 'Palembang'),
(5, 2, 'Kertapati', 'PL2_DIST', 'Palembang'),
(6, 2, 'Lubuklinggau', 'LLG_HO', 'Lubuklinggau'),
(7, 2, 'Lampung', 'LPG_HO', 'Bandar Lampung'),
(8, 2, 'Cibubur', 'CBB_HO', 'Bogor'),
(9, 2, 'Semarang', 'SMG_HO', 'Semarang'),
(10, 3, 'Cikarang', 'CKR_DIST', 'Bekasi / Cikarang'),
(11, 4, 'Bekasi', 'BKS_HO', 'Bekasi');

-- --------------------------------------------------------------
-- 3. Tabel Supplier (Vendors / Principals)
-- --------------------------------------------------------------
DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode_supplier` VARCHAR(30) NOT NULL UNIQUE,
  `nama_supplier` VARCHAR(150) NOT NULL,
  `kategori` VARCHAR(100) DEFAULT 'Bahan Bangunan',
  `kontak_person` VARCHAR(100) DEFAULT NULL,
  `email` VARCHAR(100) DEFAULT NULL,
  `telepon` VARCHAR(50) DEFAULT NULL,
  `status_customer_ar` ENUM('terdaftar', 'belum_terdaftar') NOT NULL DEFAULT 'terdaftar',
  `status_alamat_tagih` ENUM('lengkap', 'belum_lengkap') NOT NULL DEFAULT 'lengkap',
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `supplier` (`id`, `kode_supplier`, `nama_supplier`, `kategori`, `status_customer_ar`, `status_alamat_tagih`) VALUES
(1, 'SUP-MULIA', 'Signature by Mulia', 'Keramik & Granit', 'terdaftar', 'lengkap'),
(2, 'SUP-TOTO', 'TOTO', 'Sanitary & Fitting', 'terdaftar', 'lengkap'),
(3, 'SUP-NIPPON', 'Nippon Paint', 'Cat & Pelapis', 'terdaftar', 'lengkap'),
(4, 'SUP-INLITE', 'Inlite', 'Pencahayaan & Listrik', 'belum_terdaftar', 'belum_lengkap'),
(5, 'SUP-AVIAN', 'Avian', 'Cat & Kimia Bangunan', 'terdaftar', 'lengkap'),
(6, 'SUP-JOTUN', 'Jotun', 'Cat & Pelapis Industri', 'terdaftar', 'belum_lengkap'),
(7, 'SUP-ESSENZA', 'Essenza', 'Granit Tile', 'terdaftar', 'belum_lengkap'),
(8, 'SUP-KIA', 'KIA', 'Keramik Lantai & Dinding', 'terdaftar', 'lengkap'),
(9, 'SUP-DANAPAINT', 'Danapaint', 'Cat & Thinner', 'terdaftar', 'lengkap');

-- --------------------------------------------------------------
-- 4. Tabel Metode Kesepakatan (Agreement Type Master)
-- --------------------------------------------------------------
DROP TABLE IF EXISTS `metode_kesepakatan`;
CREATE TABLE `metode_kesepakatan` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode_metode` VARCHAR(30) NOT NULL UNIQUE,
  `nama_metode` VARCHAR(100) NOT NULL,
  `deskripsi` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `metode_kesepakatan` (`id`, `kode_metode`, `nama_metode`, `deskripsi`) VALUES
(1, 'MK-LISTING', 'Listing Fee Baru', 'Biaya listing item baru masuk ke toko MBS'),
(2, 'MK-SEWA-GONDOLA', 'Sewa Gondola Display', 'Sewa rak gondola reguler display produk per bulan'),
(3, 'MK-ENDCAP', 'Sewa End Cap Premium', 'Sewa rak ujung lorong (end cap) display eksklusif'),
(4, 'MK-DISKON-SUPP', 'Diskon Partisipasi Supplier', 'Sharing diskon promosi potongan langsung konsumen'),
(5, 'MK-FLYER', 'Partisipasi Katalog / Flyer Promo', 'Kontribusi pencantuman di katalog promosi cetak & digital'),
(6, 'MK-EVENT-TEMATIK', 'Event Tematik & Booth Promosi', 'Partisipasi stand pameran khusus saat event berlangsung');

-- --------------------------------------------------------------
-- 5. Tabel Event Promosi (Promotional Events Master)
-- --------------------------------------------------------------
DROP TABLE IF EXISTS `event_promosi`;
CREATE TABLE `event_promosi` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_event` VARCHAR(150) NOT NULL,
  `tahun` INT UNSIGNED NOT NULL DEFAULT 2026,
  `tanggal_mulai` DATE NOT NULL,
  `tanggal_selesai` DATE NOT NULL,
  `deskripsi` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `event_promosi` (`id`, `nama_event`, `tahun`, `tanggal_mulai`, `tanggal_selesai`, `deskripsi`) VALUES
(1, 'Promo Awal Tahun 2026', 2026, '2026-01-01', '2026-02-28', 'Promo serentak pembuka tahun di seluruh cabang MBS'),
(2, 'Gebyar Bangunan Ramadhan 2026', 2026, '2026-03-01', '2026-04-15', 'Program belanja bahan bangunan menyambut hari raya'),
(3, 'Festival Keramik & Granit Nasional', 2026, '2026-05-01', '2026-06-30', 'Pameran brand keramik terkemuka dengan cashback spesial'),
(4, 'MBS Super Anniversary Promo', 2026, '2026-07-01', '2026-08-31', 'Peringatan ulang tahun Mitra Bangunan Supermarket');

-- --------------------------------------------------------------
-- 6. Tabel Sarana Promosi (Promotion Facilities / Spaces)
-- --------------------------------------------------------------
DROP TABLE IF EXISTS `sarana_promosi`;
CREATE TABLE `sarana_promosi` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode_sarana` VARCHAR(30) NOT NULL UNIQUE,
  `nama_sarana` VARCHAR(150) NOT NULL,
  `kategori_sarana` VARCHAR(100) NOT NULL,
  `lokasi` VARCHAR(100) DEFAULT 'Area Toko',
  `tarif_standar` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sarana_promosi` (`id`, `kode_sarana`, `nama_sarana`, `kategori_sarana`, `lokasi`, `tarif_standar`) VALUES
(1, 'SRN-GON-A', 'Gondola Utama Lorong Cat & Semen', 'Gondola', 'Hall Depan Lantai 1', 5000000.00),
(2, 'SRN-END-01', 'End Cap Granit Luxury', 'End Cap', 'Ujung Lorong Keramik', 8500000.00),
(3, 'SRN-FLOOR-01', 'Floor Display Area Entrance', 'Floor Display', 'Pintu Masuk Utama', 12000000.00),
(4, 'SRN-FACADE-EXT', 'Banner Facade Luar Gedung MBS', 'Banner Exterior', 'Dinding Luar Depan', 15000000.00),
(5, 'SRN-MOBILE-KSR', 'Hanging Mobile Area Kasir', 'Hanging Mobile', 'Atas Jalur Pembayaran', 3500000.00);

-- --------------------------------------------------------------
-- 7. Tabel Program Promo (Core Promotion Program)
-- --------------------------------------------------------------
DROP TABLE IF EXISTS `program_promo`;
CREATE TABLE `program_promo` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nomor_program` VARCHAR(50) NOT NULL UNIQUE,
  `judul_program` VARCHAR(255) NOT NULL,
  `tahun` INT UNSIGNED NOT NULL DEFAULT 2026,
  `supplier_id` BIGINT UNSIGNED NOT NULL,
  `event_promosi_id` BIGINT UNSIGNED NULL,
  `metode_kesepakatan_id` BIGINT UNSIGNED NOT NULL,
  `status` ENUM(
    'draft',
    'diajukan',
    'disetujui',
    'berjalan',
    'realisasi',
    'verifikasi',
    'konfirmasi_supplier',
    'siap_tagih',
    'ditagih',
    'lunas'
  ) NOT NULL DEFAULT 'draft',
  `tanggal_mulai` DATE NOT NULL,
  `tanggal_selesai` DATE NOT NULL,
  `total_nilai` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
  `nilai_realisasi` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
  `catatan` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_promo_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`),
  CONSTRAINT `fk_promo_event` FOREIGN KEY (`event_promosi_id`) REFERENCES `event_promosi` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_promo_metode` FOREIGN KEY (`metode_kesepakatan_id`) REFERENCES `metode_kesepakatan` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------------
-- 8. Tabel Relasi Program Promo ke Outlet
-- --------------------------------------------------------------
DROP TABLE IF EXISTS `program_promo_outlet`;
CREATE TABLE `program_promo_outlet` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `program_promo_id` BIGINT UNSIGNED NOT NULL,
  `outlet_id` BIGINT UNSIGNED NOT NULL,
  `status_realisasi_outlet` ENUM('menunggu_outlet', 'sudah_realisasi', 'revisi') NOT NULL DEFAULT 'menunggu_outlet',
  `nilai_alokasi` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
  `tanggal_realisasi` DATE DEFAULT NULL,
  `foto_bukti` VARCHAR(255) DEFAULT NULL,
  `catatan_outlet` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_program_outlet` (`program_promo_id`, `outlet_id`),
  CONSTRAINT `fk_ppo_program` FOREIGN KEY (`program_promo_id`) REFERENCES `program_promo` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_ppo_outlet` FOREIGN KEY (`outlet_id`) REFERENCES `outlet` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------------
-- 9. Tabel Tagihan AR (Invoices / Accounts Receivable)
-- --------------------------------------------------------------
DROP TABLE IF EXISTS `tagihan_ar`;
CREATE TABLE `tagihan_ar` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nomor_invoice` VARCHAR(50) NOT NULL UNIQUE,
  `program_promo_id` BIGINT UNSIGNED NULL,
  `supplier_id` BIGINT UNSIGNED NOT NULL,
  `outlet_id` BIGINT UNSIGNED NOT NULL,
  `tanggal_invoice` DATE NOT NULL,
  `tanggal_jatuh_tempo` DATE NOT NULL,
  `total_tagihan` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
  `jumlah_terbayar` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
  `status_pembayaran` ENUM('belum_lunas', 'sebagian', 'lunas') NOT NULL DEFAULT 'belum_lunas',
  `hari_keterlambatan` INT NOT NULL DEFAULT 0,
  `nomor_oracle_ar` VARCHAR(50) DEFAULT NULL,
  `metode_pembayaran` VARCHAR(50) DEFAULT NULL,
  `tanggal_lunas` DATE DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_ar_program` FOREIGN KEY (`program_promo_id`) REFERENCES `program_promo` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_ar_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`),
  CONSTRAINT `fk_ar_outlet` FOREIGN KEY (`outlet_id`) REFERENCES `outlet` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------------
-- 10. Tabel Perlu Tindakan (Action Items / SLA Alerts)
-- --------------------------------------------------------------
DROP TABLE IF EXISTS `perlu_tindakan`;
CREATE TABLE `perlu_tindakan` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `kategori` ENUM('Kritis', 'Penting', 'Perhatian', 'Info') NOT NULL,
  `judul` VARCHAR(255) NOT NULL,
  `rincian` TEXT NOT NULL,
  `link_url` VARCHAR(255) DEFAULT '#',
  `is_resolved` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `perlu_tindakan` (`id`, `kategori`, `judul`, `rincian`, `link_url`) VALUES
(1, 'Kritis', 'Invoice lewat jatuh tempo lebih dari 30 hari', '5 invoice · Rp 70,2 jt · terbanyak Nippon Paint', '/tagihan-ar?filter=overdue30'),
(2, 'Penting', 'Promo selesai lebih dari 14 hari tetapi belum ditagih', '15 program · Rp 292,4 jt · terlama PFM-2607-0018 (53 hari)', '/program-promo?filter=selesai_belum_tagih'),
(3, 'Penting', 'Supplier belum punya alamat tagih di OU', 'Jotun di PL2_DIST, LLG_HO - Essenza di SMG_HO - Inlite belum jadi customer AR', '/supplier-ar?filter=incomplete_address'),
(4, 'Perhatian', 'Menunggu konfirmasi supplier lebih dari 7 hari', '1 program · Rp 7,0 jt', '/program-promo?filter=waiting_supplier_7d'),
(5, 'Perhatian', 'Outlet belum konfirmasi realisasi', 'Pekanbaru, Lampung, Cibubur, Jambi +7 lainnya · 5 program', '/realisasi?filter=pending_outlet'),
(6, 'Info', 'Kontrak sarana promosi berakhir dalam 30 hari', '3 kontrak · siapkan perpanjangan ke supplier', '/sarana-promosi?filter=expiring_30d');

-- --------------------------------------------------------------
-- 11. Tabel Ringkasan KPI Dashboard (Tabel Agregat Snapshot)
-- --------------------------------------------------------------
DROP TABLE IF EXISTS `dashboard_summary`;
CREATE TABLE `dashboard_summary` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tahun` INT UNSIGNED NOT NULL DEFAULT 2026,
  `total_program_berjalan` INT UNSIGNED NOT NULL DEFAULT 27,
  `program_berakhir_7_hari` INT UNSIGNED NOT NULL DEFAULT 4,
  `realisasi_belum_ditagih` DECIMAL(15,2) NOT NULL DEFAULT 408300000.00,
  `program_masuk_akrual` INT UNSIGNED NOT NULL DEFAULT 24,
  `tagihan_belum_lunas` DECIMAL(15,2) NOT NULL DEFAULT 455900000.00,
  `invoice_belum_lunas` INT UNSIGNED NOT NULL DEFAULT 113,
  `tagihan_lewat_30_hari` DECIMAL(15,2) NOT NULL DEFAULT 70200000.00,
  `diterima_tahun_berjalan` DECIMAL(15,2) NOT NULL DEFAULT 1820000000.00,
  `total_pembayaran_selesai` INT UNSIGNED NOT NULL DEFAULT 268,
  `last_pos_sync` DATETIME DEFAULT '2026-10-12 06:00:00',
  `last_oracle_sync` DATETIME DEFAULT '2026-10-12 07:00:00',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `dashboard_summary` (`id`, `tahun`, `total_program_berjalan`, `program_berakhir_7_hari`, `realisasi_belum_ditagih`, `program_masuk_akrual`, `tagihan_belum_lunas`, `invoice_belum_lunas`, `tagihan_lewat_30_hari`, `diterima_tahun_berjalan`, `total_pembayaran_selesai`) 
VALUES (1, 2026, 27, 4, 408300000.00, 24, 455900000.00, 113, 70200000.00, 1820000000.00, 268);

-- --------------------------------------------------------------
-- 12. Tabel Workflow Tahap Promosi (Status Pipeline)
-- --------------------------------------------------------------
DROP TABLE IF EXISTS `workflow_stages`;
CREATE TABLE `workflow_stages` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode_tahap` VARCHAR(30) NOT NULL UNIQUE,
  `nama_tahap` VARCHAR(50) NOT NULL,
  `badge_warna` VARCHAR(30) NOT NULL,
  `total_program` INT UNSIGNED NOT NULL DEFAULT 0,
  `total_nilai` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
  `keterangan_waktu` VARCHAR(100) NOT NULL,
  `urutan` INT UNSIGNED NOT NULL DEFAULT 1,
  `is_terlama` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `workflow_stages` (`id`, `kode_tahap`, `nama_tahap`, `badge_warna`, `total_program`, `total_nilai`, `keterangan_waktu`, `urutan`, `is_terlama`) VALUES
(1, 'draft', 'Draft', 'gray', 18, 340700000.00, 'mulai + 40 hari lagi', 1, 0),
(2, 'diajukan', 'Diajukan', 'blue', 6, 83300000.00, 'mulai + 16 hari lagi', 2, 0),
(3, 'disetujui', 'Disetujui', 'emerald', 4, 64500000.00, 'mulai + 3 hari lagi', 3, 0),
(4, 'berjalan', 'Berjalan', 'emerald', 27, 631700000.00, 'sesuai periode promo', 4, 0),
(5, 'realisasi', 'Realisasi', 'amber', 6, 66700000.00, 'rata-rata 3 hari', 5, 0),
(6, 'verifikasi', 'Verifikasi', 'amber', 4, 48000000.00, 'rata-rata 3 hari', 6, 0),
(7, 'konfirmasi_supplier', 'Konfirmasi Supplier', 'purple', 6, 174300000.00, 'rata-rata 5 hari', 7, 0),
(8, 'siap_tagih', 'Siap Tagih', 'orange', 8, 110400000.00, 'rata-rata 12 hari - terlama', 8, 1),
(9, 'ditagih', 'Ditagih', 'cyan', 30, 572100000.00, 'rata-rata 31 hari sejak ditagih', 9, 0),
(10, 'lunas', 'Lunas', 'emerald', 30, 789400000.00, 'dibayar rata-rata 64 hari', 10, 0);

-- --------------------------------------------------------------
-- 13. Tabel Umur Tagihan (Aging AR Schedule)
-- --------------------------------------------------------------
DROP TABLE IF EXISTS `umur_tagihan`;
CREATE TABLE `umur_tagihan` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `kategori_umur` VARCHAR(50) NOT NULL UNIQUE,
  `total_nilai` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
  `jumlah_invoice` INT UNSIGNED NOT NULL DEFAULT 0,
  `persentase` DECIMAL(5,2) NOT NULL DEFAULT 0.00,
  `urutan` INT UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `umur_tagihan` (`id`, `kategori_umur`, `total_nilai`, `jumlah_invoice`, `persentase`, `urutan`) VALUES
(1, 'Belum jatuh tempo', 212300000.00, 54, 46.57, 1),
(2, 'Lewat 1–30 hari', 173300000.00, 54, 38.01, 2),
(3, 'Lewat 31–60 hari', 70200000.00, 5, 15.40, 3),
(4, 'Lewat 61–90 hari', 0.00, 0, 0.00, 4),
(5, 'Lewat > 90 hari', 0.00, 0, 0.00, 5);

-- --------------------------------------------------------------
-- 14. Tabel Rekap Tagihan Per Supplier
-- --------------------------------------------------------------
DROP TABLE IF EXISTS `rekap_supplier_ar`;
CREATE TABLE `rekap_supplier_ar` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_supplier` VARCHAR(150) NOT NULL,
  `total_nilai` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
  `jumlah_invoice` INT UNSIGNED NOT NULL DEFAULT 0,
  `persentase_bar` DECIMAL(5,2) NOT NULL DEFAULT 0.00,
  `urutan` INT UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `rekap_supplier_ar` (`id`, `nama_supplier`, `total_nilai`, `jumlah_invoice`, `persentase_bar`, `urutan`) VALUES
(1, 'Signature by Mulia', 110200000.00, 30, 72.00, 1),
(2, 'TOTO', 75800000.00, 26, 50.00, 2),
(3, 'Nippon Paint', 71100000.00, 3, 47.00, 3),
(4, 'Inlite', 46800000.00, 17, 31.00, 4),
(5, 'Avian', 41300000.00, 4, 27.00, 5),
(6, 'Lainnya (4 supplier)', 110700000.00, 33, 73.00, 6);

-- --------------------------------------------------------------
-- 15. Tabel Rekap Ringkasan Per Outlet
-- --------------------------------------------------------------
DROP TABLE IF EXISTS `rekap_outlet_dashboard`;
CREATE TABLE `rekap_outlet_dashboard` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `outlet_id` BIGINT UNSIGNED NOT NULL,
  `program_berjalan` INT UNSIGNED NOT NULL DEFAULT 0,
  `realisasi_belum_ditagih` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
  `tagihan_belum_lunas` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
  `status_konfirmasi` VARCHAR(50) NOT NULL DEFAULT 'Menunggu outlet',
  `urutan` INT UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_rod_outlet` FOREIGN KEY (`outlet_id`) REFERENCES `outlet` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `rekap_outlet_dashboard` (`id`, `outlet_id`, `program_berjalan`, `realisasi_belum_ditagih`, `tagihan_belum_lunas`, `status_konfirmasi`, `urutan`) VALUES
(1, 1, 15, 32800000.00, 61800000.00, 'Menunggu outlet', 1),
(2, 2, 14, 63600000.00, 47500000.00, 'Menunggu outlet', 2),
(3, 3, 19, 23500000.00, 20400000.00, 'Menunggu outlet', 3),
(4, 4, 12, 28500000.00, 23200000.00, 'Menunggu outlet', 4),
(5, 5, 19, 31500000.00, 68400000.00, 'Menunggu outlet', 5),
(6, 6, 17, 17000000.00, 63400000.00, 'Menunggu outlet', 6),
(7, 7, 18, 35000000.00, 40200000.00, 'Menunggu outlet', 7),
(8, 8, 21, 32400000.00, 21100000.00, 'Menunggu outlet', 8),
(9, 9, 18, 48800000.00, 33700000.00, 'Menunggu outlet', 9),
(10, 10, 20, 70500000.00, 23400000.00, 'Menunggu outlet', 10),
(11, 11, 16, 24600000.00, 52900000.00, 'Menunggu outlet', 11);

-- --------------------------------------------------------------
-- 16. Insert Sampel Program Promosi Realistis
-- --------------------------------------------------------------
INSERT INTO `program_promo` (`id`, `nomor_program`, `judul_program`, `tahun`, `supplier_id`, `event_promosi_id`, `metode_kesepakatan_id`, `status`, `tanggal_mulai`, `tanggal_selesai`, `total_nilai`, `nilai_realisasi`, `catatan`) VALUES
(1, 'PFM-2601-0001', 'Display Signature Granit 60x60 Season 1', 2026, 1, 1, 3, 'berjalan', '2026-01-01', '2026-03-31', 45000000.00, 45000000.00, 'Sewa End Cap di 5 Cabang Utama'),
(2, 'PFM-2601-0002', 'Promo Sanitair TOTO New Year Fair', 2026, 2, 1, 4, 'berjalan', '2026-01-15', '2026-02-28', 55000000.00, 55000000.00, 'Partisipasi Diskon 10% All Series'),
(3, 'PFM-2602-0003', 'Gebyar Cat Nippon Paint Ramadhan Ready', 2026, 3, 2, 2, 'berjalan', '2026-02-01', '2026-04-30', 38000000.00, 38000000.00, 'Sewa Gondola Hall Depan'),
(4, 'PFM-2607-0018', 'Avian Roadshow & Floor Display Pekanbaru', 2026, 5, 4, 6, 'siap_tagih', '2026-07-01', '2026-08-15', 29240000.00, 29240000.00, 'Promo selesai lewat 14 hari belum ditagih (terlama 53 hari)'),
(5, 'PFM-2603-0005', 'Listing Fee Produk Baru Inlite LED Eco', 2026, 4, 2, 1, 'konfirmasi_supplier', '2026-03-01', '2026-05-31', 17000000.00, 17000000.00, 'Menunggu konfirmasi alamat tagih AR'),
(6, 'PFM-2604-0006', 'Jotun Exterior Paint Facade Banner', 2026, 6, 2, 3, 'berjalan', '2026-03-10', '2026-06-10', 42000000.00, 42000000.00, 'Banner Outdoor Cabang Lampung & Kertapati'),
(7, 'PFM-2604-0007', 'Essenza Tile Launching Special Booth', 2026, 7, 3, 6, 'realisasi', '2026-04-01', '2026-05-31', 25000000.00, 25000000.00, 'Verifikasi foto display outlet Semarang'),
(8, 'PFM-2605-0008', 'KIA Keramik Ramadan Fair Cashback', 2026, 8, 2, 4, 'verifikasi', '2026-04-10', '2026-05-20', 31500000.00, 31500000.00, 'Pengecekan nota penjualan kasir POS');

-- Hubungkan Program ke Outlet
INSERT INTO `program_promo_outlet` (`program_promo_id`, `outlet_id`, `status_realisasi_outlet`, `nilai_alokasi`) VALUES
(1, 1, 'menunggu_outlet', 9000000.00),
(1, 4, 'menunggu_outlet', 9000000.00),
(1, 7, 'menunggu_outlet', 9000000.00),
(1, 8, 'menunggu_outlet', 9000000.00),
(1, 10, 'menunggu_outlet', 9000000.00),
(2, 3, 'menunggu_outlet', 15000000.00),
(2, 5, 'menunggu_outlet', 20000000.00),
(2, 9, 'menunggu_outlet', 20000000.00),
(3, 2, 'menunggu_outlet', 12000000.00),
(3, 6, 'menunggu_outlet', 13000000.00),
(3, 11, 'menunggu_outlet', 13000000.00);

-- --------------------------------------------------------------
-- 17. Insert Sampel Tagihan AR
-- --------------------------------------------------------------
INSERT INTO `tagihan_ar` (`nomor_invoice`, `program_promo_id`, `supplier_id`, `outlet_id`, `tanggal_invoice`, `tanggal_jatuh_tempo`, `total_tagihan`, `jumlah_terbayar`, `status_pembayaran`, `hari_keterlambatan`, `nomor_oracle_ar`) VALUES
('INV-2026-00101', 1, 1, 1, '2026-01-20', '2026-02-20', 12500000.00, 0.00, 'belum_lunas', 0, 'AR-ORCL-8801'),
('INV-2026-00102', 2, 2, 4, '2026-01-25', '2026-02-25', 18400000.00, 0.00, 'belum_lunas', 12, 'AR-ORCL-8802'),
('INV-2026-00103', 3, 3, 2, '2025-12-10', '2026-01-10', 25000000.00, 0.00, 'belum_lunas', 42, 'AR-ORCL-8803'),
('INV-2026-00104', 3, 3, 5, '2025-12-15', '2026-01-15', 30200000.00, 0.00, 'belum_lunas', 37, 'AR-ORCL-8804'),
('INV-2026-00105', 3, 3, 7, '2025-12-20', '2026-01-20', 15000000.00, 0.00, 'belum_lunas', 32, 'AR-ORCL-8805'),
('INV-2026-00106', 4, 5, 3, '2026-01-10', '2026-02-10', 29240000.00, 0.00, 'belum_lunas', 18, 'AR-ORCL-8806');

-- --------------------------------------------------------------
-- 18. Tabel Pengguna (Users Admin & Staf HO)
-- --------------------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `role` VARCHAR(50) NOT NULL DEFAULT 'Admin Promosi - HO',
  `departemen` VARCHAR(100) NOT NULL DEFAULT 'Marketing & Promotion HO',
  `avatar` VARCHAR(255) DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `remember_token` VARCHAR(100) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `role`, `departemen`, `password`) VALUES
(1, 'Admin Promosi', 'admin@mitrabangunan.com', 'Admin Promosi - HO', 'Marketing & Promotion HO', '$2y$12$4sE4/b99h2r4hL4QhQ9eQOvh5mQk76/1j5Yw5W1gGjK6rX1Y3C1aG'), -- password: password / admin123
(2, 'Adzi Purnomo', 'adzi@mitrabangunan.com', 'Admin Promosi - HO', 'Head Office - MBS Group', '$2y$12$4sE4/b99h2r4hL4QhQ9eQOvh5mQk76/1j5Yw5W1gGjK6rX1Y3C1aG');

-- --------------------------------------------------------------
-- 19. Tabel Framework Laravel (Sessions, Cache, Password Reset)
-- --------------------------------------------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;

-- ==============================================================
-- SELESAI IMPORT STRUKTUR & DATA MONITORING PROMOSI MBS
-- ==============================================================

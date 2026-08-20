-- SIKOPIM Database Export
-- Generated on 2026-08-20 02:42:33

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `arahan`;
CREATE TABLE `arahan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nomor_arahan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi_arahan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pimpinan` enum('wali_kota','wakil_wali_kota','sekda','asisten') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'wali_kota',
  `ditujukan_kepada` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_arahan` date NOT NULL,
  `deadline` date DEFAULT NULL,
  `prioritas` enum('rendah','sedang','tinggi','urgent') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sedang',
  `status` enum('belum_selesai','sedang_berjalan','selesai','melewati_deadline') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'belum_selesai',
  `file_arahan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `arahan_created_by_foreign` (`created_by`),
  CONSTRAINT `arahan_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `arahan` VALUES 
(1, 'AR/001/2026', 'Percepatan Digitalisasi Layanan Publik', 'Seluruh OPD agar segera melakukan transformasi digital pada pelayanan publik sesuai dengan roadmap Smart City Kota Bandung.', 'wali_kota', 'Seluruh OPD Kota Bandung', '2026-08-13', '2026-09-17', 'tinggi', 'sedang_berjalan', NULL, 1, '2026-08-18 02:33:38', '2026-08-18 02:33:38', NULL),
(2, 'AR/002/2026', 'Peningkatan Kualitas Dokumentasi Kegiatan', 'Tim dokumentasi agar meningkatkan kualitas foto dan video kegiatan pimpinan, menggunakan standar yang telah ditetapkan.', 'sekda', 'Bagian Protokol dan Komunikasi Pimpinan', '2026-08-08', '2026-08-15', 'urgent', 'melewati_deadline', NULL, 1, '2026-08-18 02:33:38', '2026-08-18 02:33:38', NULL);

DROP TABLE IF EXISTS `arsip`;
CREATE TABLE `arsip` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nomor_arsip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `kategori` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'lainnya',
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` bigint DEFAULT NULL,
  `file_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_dokumen` date DEFAULT NULL,
  `tahun` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('aktif','inaktif','arsip_permanen') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `is_rahasia` tinyint(1) NOT NULL DEFAULT '0',
  `views` int NOT NULL DEFAULT '0',
  `uploaded_by` bigint unsigned DEFAULT NULL,
  `kegiatan_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `arsip_uploaded_by_foreign` (`uploaded_by`),
  KEY `arsip_kegiatan_id_foreign` (`kegiatan_id`),
  CONSTRAINT `arsip_kegiatan_id_foreign` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatan` (`id`) ON DELETE SET NULL,
  CONSTRAINT `arsip_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `arsip` VALUES 
(1, 'ARS/001/2026', 'Dokumen Arsip 1', 'Deskripsi arsip nomor 1', 'laporan', 'arsip/dummy_1.pdf', 'dokumen_1.pdf', 4095106, 'application/pdf', '2026-07-16', '2026', 'aktif', 0, 0, 1, NULL, '2026-08-18 02:33:38', '2026-08-18 02:33:38', NULL),
(2, 'ARS/002/2026', 'Dokumen Arsip 2', 'Deskripsi arsip nomor 2', 'sk', 'arsip/dummy_2.pdf', 'dokumen_2.pdf', 1243911, 'application/pdf', '2026-05-19', '2026', 'aktif', 0, 0, 1, NULL, '2026-08-18 02:33:38', '2026-08-18 02:33:38', NULL),
(3, 'ARS/003/2026', 'Dokumen Arsip 3', 'Deskripsi arsip nomor 3', 'foto', 'arsip/dummy_3.pdf', 'dokumen_3.pdf', 1070409, 'application/pdf', '2026-05-17', '2026', 'aktif', 0, 0, 1, NULL, '2026-08-18 02:33:38', '2026-08-18 02:33:38', NULL),
(4, 'ARS/004/2026', 'Dokumen Arsip 4', 'Deskripsi arsip nomor 4', 'surat_masuk', 'arsip/dummy_4.pdf', 'dokumen_4.pdf', 4617540, 'application/pdf', '2026-05-28', '2026', 'aktif', 0, 0, 1, NULL, '2026-08-18 02:33:38', '2026-08-18 02:33:38', NULL),
(5, 'ARS/005/2026', 'Dokumen Arsip 5', 'Deskripsi arsip nomor 5', 'foto', 'arsip/dummy_5.pdf', 'dokumen_5.pdf', 1282482, 'application/pdf', '2026-07-10', '2026', 'aktif', 0, 0, 1, NULL, '2026-08-18 02:33:38', '2026-08-18 02:33:38', NULL),
(6, 'ARS/006/2026', 'Dokumen Arsip 6', 'Deskripsi arsip nomor 6', 'surat_masuk', 'arsip/dummy_6.pdf', 'dokumen_6.pdf', 462530, 'application/pdf', '2026-05-11', '2026', 'aktif', 0, 0, 1, NULL, '2026-08-18 02:33:38', '2026-08-18 02:33:38', NULL),
(7, 'ARS/007/2026', 'Dokumen Arsip 7', 'Deskripsi arsip nomor 7', 'surat_masuk', 'arsip/dummy_7.pdf', 'dokumen_7.pdf', 3934844, 'application/pdf', '2026-07-17', '2026', 'aktif', 0, 0, 1, NULL, '2026-08-18 02:33:38', '2026-08-18 02:33:38', NULL),
(8, 'ARS/008/2026', 'Dokumen Arsip 8', 'Deskripsi arsip nomor 8', 'laporan', 'arsip/dummy_8.pdf', 'dokumen_8.pdf', 3550374, 'application/pdf', '2026-07-31', '2026', 'aktif', 0, 0, 1, NULL, '2026-08-18 02:33:38', '2026-08-18 02:33:38', NULL),
(9, 'ARS/009/2026', 'Dokumen Arsip 9', 'Deskripsi arsip nomor 9', 'foto', 'arsip/dummy_9.pdf', 'dokumen_9.pdf', 355618, 'application/pdf', '2026-05-24', '2026', 'aktif', 0, 0, 1, NULL, '2026-08-18 02:33:38', '2026-08-18 02:33:38', NULL),
(10, 'ARS/010/2026', 'Dokumen Arsip 10', 'Deskripsi arsip nomor 10', 'laporan', 'arsip/dummy_10.pdf', 'dokumen_10.pdf', 1472325, 'application/pdf', '2026-07-20', '2026', 'aktif', 0, 0, 1, NULL, '2026-08-18 02:33:38', '2026-08-18 02:33:38', NULL),
(11, '001', 'Peresmian Warkop ADD', 'testing', 'surat_masuk', 'arsip/CKvaI3N9s34tM1f7NoDWmzZJtJX2hVzYmDByY5RE.pdf', 'RANCANGAN_PROKER_HMIF_2025-2026.pdf', 351965, 'application/pdf', '2026-08-19', '2026', 'aktif', 0, 0, 1, NULL, '2026-08-19 08:52:31', '2026-08-19 08:52:31', NULL);

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `daftar_hadir`;
CREATE TABLE `daftar_hadir` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kegiatan_id` bigint unsigned NOT NULL,
  `personel_id` bigint unsigned DEFAULT NULL,
  `nama_peserta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instansi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_hadir` enum('hadir','tidak_hadir','izin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'hadir',
  `jam_hadir` time DEFAULT NULL,
  `tanda_tangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `daftar_hadir_kegiatan_id_foreign` (`kegiatan_id`),
  KEY `daftar_hadir_personel_id_foreign` (`personel_id`),
  CONSTRAINT `daftar_hadir_kegiatan_id_foreign` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `daftar_hadir_personel_id_foreign` FOREIGN KEY (`personel_id`) REFERENCES `personel` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `dokumentasi`;
CREATE TABLE `dokumentasi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kegiatan_id` bigint unsigned DEFAULT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `tipe` enum('foto','video','dokumen') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'foto',
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_size` bigint DEFAULT NULL,
  `tanggal_dokumentasi` date NOT NULL,
  `fotografer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `uploaded_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dokumentasi_kegiatan_id_foreign` (`kegiatan_id`),
  KEY `dokumentasi_uploaded_by_foreign` (`uploaded_by`),
  CONSTRAINT `dokumentasi_kegiatan_id_foreign` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatan` (`id`) ON DELETE SET NULL,
  CONSTRAINT `dokumentasi_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `galeri_arsip`;
CREATE TABLE `galeri_arsip` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe` enum('foto','video','notulensi') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'foto',
  `akses` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'publik',
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `durasi_detik` int DEFAULT NULL,
  `jumlah_foto` int NOT NULL DEFAULT '1',
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `tanggal_kegiatan` date DEFAULT NULL,
  `kegiatan_id` bigint unsigned DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `galeri_arsip_kode_unique` (`kode`),
  KEY `galeri_arsip_kegiatan_id_foreign` (`kegiatan_id`),
  KEY `galeri_arsip_created_by_foreign` (`created_by`),
  CONSTRAINT `galeri_arsip_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `galeri_arsip_kegiatan_id_foreign` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatan` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `galeri_arsip` VALUES 
(1, '#KG-231005', 'Peresmian Taman Kota Tahap II Bersama Wali Kota', 'foto', 'publik', NULL, NULL, NULL, 1, 'Dokumentasi foto peresmian taman kota tahap II', '2023-10-12', NULL, 1, '2026-08-18 08:24:36', '2026-08-18 08:24:36'),
(2, '#KG-231004', 'Konferensi Pers Evaluasi Kinerja Kuartal', 'video', 'internal', NULL, NULL, 225, 1, 'Rekaman video konferensi pers evaluasi kinerja Q3', '2023-10-10', NULL, 1, '2026-08-18 08:24:36', '2026-08-18 08:24:36'),
(3, '#KG-230928', 'Rapat Paripurna DPRD Pembahasan Anggaran', 'foto', 'publik', NULL, NULL, NULL, 12, 'Album foto rapat paripurna pembahasan APBD', '2023-09-28', NULL, 1, '2026-08-18 08:24:36', '2026-08-18 08:24:36'),
(4, '#KG-230915', 'Tinjauan Lapangan Proyek Infrastruktur Jalan Tol', 'foto', 'internal', NULL, NULL, NULL, 1, 'Dokumentasi kunjungan lapangan proyek infrastruktur', '2023-09-15', NULL, 1, '2026-08-18 08:24:36', '2026-08-18 08:24:36'),
(5, '#KG-230901', 'Sosialisasi Program Ketahanan Pangan Daerah', 'video', 'publik', NULL, NULL, 485, 1, 'Video dokumentasi sosialisasi program ketahanan pangan', '2023-09-01', NULL, 1, '2026-08-18 08:24:36', '2026-08-18 08:24:36'),
(6, '#KG-230820', 'Notulensi Rapat Koordinasi Pengembangan UMKM', 'notulensi', 'internal', NULL, NULL, NULL, 1, 'Dokumen notulensi rapat koordinasi UMKM', '2023-08-20', NULL, 1, '2026-08-18 08:24:36', '2026-08-18 08:24:36'),
(7, '#KG-230810', 'Notulensi Forum Musyawarah Perencanaan Pembangunan', 'notulensi', 'publik', NULL, NULL, NULL, 1, 'Dokumen resmi Musrenbang tahun 2023', '2023-08-10', NULL, 1, '2026-08-18 08:24:36', '2026-08-18 08:24:36'),
(8, '#KG-230805', 'Kunjungan Kerja ke Sentra Industri Kreatif', 'foto', 'publik', NULL, NULL, NULL, 8, 'Album foto kunjungan kerja ke industri kreatif lokal', '2023-08-05', NULL, 1, '2026-08-18 08:24:36', '2026-08-18 08:24:36'),
(9, '#KG-260009', 'Taman Maluku', 'foto', 'publik', 'galeri-arsip/XmgzoasJxHbxaJmFJKwRsNu2ZQcK8E1TfjFrpABj.png', 'RobloxScreenShot20250520_165204486.png', NULL, 1, 'TAMLUKKKKK', '2026-08-18', NULL, 1, '2026-08-18 08:33:53', '2026-08-18 08:33:53'),
(10, '#KG-260010', 'Warkop ADD', 'foto', 'publik', 'galeri-arsip/30OpRUw8tI6p5U9hUPkxVYemZqkc2c0dWrcsVHzb.png', 'RobloxScreenShot20260512_215529644.png', NULL, 1, 'Warkop The Best', '2026-08-18', NULL, 1, '2026-08-18 08:42:26', '2026-08-18 08:42:26'),
(11, '#KG-260011', 'Warkop ADD', 'video', 'internal', 'galeri-arsip/GvppbgMXOy088W1o1Q54wrShEpBJZz2vvnz8JDg2.mp4', 'INDONESIA RAYA - FULL HD.mp4', 110, 1, 'testing', '2026-08-19', NULL, 1, '2026-08-19 05:19:56', '2026-08-19 05:19:56'),
(12, '#KG-260012', 'Taman Maluku', 'foto', 'publik', 'galeri-arsip/Qst8VABgKgMmFZyLunfejZje4v48Vcc2e8BjFNNt.png', 'Screenshot 2025-02-09 154052.png', NULL, 1, 'testing', '2026-08-19', NULL, 1, '2026-08-19 05:21:06', '2026-08-19 05:21:06');

DROP TABLE IF EXISTS `instansi`;
CREATE TABLE `instansi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_instansi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pemerintah_daerah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_lengkap` text COLLATE utf8mb4_unicode_ci,
  `email_kontak` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_telepon` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `instansi` VALUES 
(1, 'Bagian Protokol dan Komunikasi Pimpinan', 'Pemerintah Kota Bandung', 'Jl. Wastukencana No.2, Babakan Ciamis, Kec. Sumur Bandung, Kota Bandung, Jawa Barat 40117', 'prokopim@bandung.go.id', '(022) 4208000', NULL, NULL, '2026-08-18 02:33:38', '2026-08-18 02:33:38');

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `kegiatan`;
CREATE TABLE `kegiatan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nomor_agenda` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_mulai` datetime NOT NULL,
  `tanggal_selesai` datetime DEFAULT NULL,
  `pimpinan` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'terjadwal',
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'rapat',
  `foto_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kegiatan_created_by_foreign` (`created_by`),
  CONSTRAINT `kegiatan_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `kegiatan` VALUES 
(1, NULL, 'Rapat Koordinasi Pengelolaan Sampah', 'Rapat koordinasi lintas dinas terkait pengelolaan sampah Kota Bandung', 'Balai Kota Bandung', '2026-08-18 09:30:00', '2026-08-18 12:00:00', '\"wali_kota\"', 'berlangsung', 'rapat', NULL, 1, '2026-08-18 02:33:38', '2026-08-18 02:33:38', NULL),
(2, NULL, 'Audiensi UMKM Lokal', 'Audiensi dengan perwakilan UMKM lokal Kota Bandung', 'Pendopo Kota Bandung', '2026-08-18 13:00:00', '2026-08-18 15:00:00', '\"wakil_wali_kota\"', 'terjadwal', 'audiensi', NULL, 1, '2026-08-18 02:33:38', '2026-08-18 02:33:38', NULL),
(3, NULL, 'Peresmian Taman Kota Tegalega', 'Peresmian revitalisasi Taman Kota Tegalega', 'Taman Tegalega, Bandung', '2026-08-19 09:00:00', '2026-08-19 11:00:00', '\"wali_kota\"', 'terjadwal', 'peresmian', NULL, 1, '2026-08-18 02:33:38', '2026-08-18 02:33:38', NULL),
(4, NULL, 'Kegiatan Rutin 1', NULL, 'Balai Kota Bandung', '2026-08-17 09:00:00', NULL, '\"wakil_wali_kota\"', 'selesai', 'audiensi', NULL, 1, '2026-08-18 02:33:38', '2026-08-18 02:33:38', NULL),
(5, NULL, 'Kegiatan Rutin 2', NULL, 'Balai Kota Bandung', '2026-08-16 09:00:00', NULL, '\"wakil_wali_kota\"', 'selesai', 'kunjungan', NULL, 1, '2026-08-18 02:33:38', '2026-08-18 02:33:38', NULL),
(6, NULL, 'Kegiatan Rutin 3', NULL, 'Balai Kota Bandung', '2026-08-15 09:00:00', NULL, '\"wali_kota\"', 'selesai', 'audiensi', NULL, 1, '2026-08-18 02:33:38', '2026-08-18 02:33:38', NULL),
(7, NULL, 'Kegiatan Rutin 4', NULL, 'Balai Kota Bandung', '2026-08-14 09:00:00', NULL, '\"sekda\"', 'selesai', 'audiensi', NULL, 1, '2026-08-18 02:33:38', '2026-08-18 02:33:38', NULL),
(8, NULL, 'Kegiatan Rutin 5', NULL, 'Balai Kota Bandung', '2026-08-13 09:00:00', NULL, '\"sekda\"', 'selesai', 'audiensi', NULL, 1, '2026-08-18 02:33:38', '2026-08-18 02:33:38', NULL),
(9, NULL, 'Kegiatan Rutin 6', NULL, 'Balai Kota Bandung', '2026-08-12 09:00:00', NULL, '\"sekda\"', 'selesai', 'acara', NULL, 1, '2026-08-18 02:33:38', '2026-08-18 02:33:38', NULL),
(10, NULL, 'Kegiatan Rutin 7', NULL, 'Balai Kota Bandung', '2026-08-11 09:00:00', NULL, '\"sekda\"', 'selesai', 'acara', NULL, 1, '2026-08-18 02:33:38', '2026-08-18 02:33:38', NULL),
(11, NULL, 'Kegiatan Rutin 8', NULL, 'Balai Kota Bandung', '2026-08-10 09:00:00', NULL, '\"wali_kota\"', 'selesai', 'rapat', NULL, 1, '2026-08-18 02:33:38', '2026-08-18 02:33:38', NULL),
(12, NULL, 'Kegiatan Rutin 9', NULL, 'Balai Kota Bandung', '2026-08-09 09:00:00', NULL, '\"wali_kota\"', 'selesai', 'kunjungan', NULL, 1, '2026-08-18 02:33:38', '2026-08-18 02:33:38', NULL),
(13, NULL, 'Kegiatan Rutin 10', NULL, 'Balai Kota Bandung', '2026-08-08 09:00:00', NULL, '\"wali_kota\"', 'selesai', 'kunjungan', NULL, 1, '2026-08-18 02:33:38', '2026-08-18 02:33:38', NULL),
(14, 'AG-20260818-014', 'Rapat Pimpinan', 'Testing', 'Gedung DPRD Kota Bandung', '2026-08-22 10:00:00', '2026-08-22 14:00:00', '[\"wali_kota\"]', 'terjadwal', 'rapat', NULL, 1, '2026-08-18 03:03:27', '2026-08-18 03:03:27', NULL),
(15, 'AG-20260818-014', 'Rapat Pimpinan', 'Testing', 'Gedung DPRD Kota Bandung', '2026-08-22 10:00:00', '2026-08-22 14:00:00', '[\"wali_kota\"]', 'terjadwal', 'rapat', NULL, 1, '2026-08-18 03:04:53', '2026-08-18 03:04:53', NULL),
(16, 'AG-20260818-016', 'Kawal Narisa', 'test', 'Balai Kota Bandung', '2026-08-29 14:21:00', '2026-08-29 16:28:00', '[\"pkk1\"]', 'terjadwal', 'rapat', NULL, 1, '2026-08-18 03:10:45', '2026-08-18 03:10:45', NULL),
(17, 'AG-20260818-001', 'solat', 'tes', 'Gedung DPRD Kota Bandung', '2026-08-19 14:39:00', '2026-08-19 16:39:00', '[\"dwp\"]', 'terjadwal', 'rapat', NULL, 1, '2026-08-18 03:39:43', '2026-08-18 03:39:43', NULL),
(18, 'AG-20260818-001', 'Rapat Pimpinan', 'Rapat Pimpinan', 'Gedung DPRD Kota Bandung', '2026-08-22 14:28:00', '2026-08-22 17:27:00', '[\"wali_kota\"]', 'terjadwal', 'rapat', NULL, 1, '2026-08-18 07:25:02', '2026-08-18 07:25:02', NULL);

DROP TABLE IF EXISTS `laporan`;
CREATE TABLE `laporan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `tipe` enum('kegiatan','penugasan','arsip','dokumentasi','custom') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'kegiatan',
  `periode_mulai` date DEFAULT NULL,
  `periode_selesai` date DEFAULT NULL,
  `file_laporan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','final') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `laporan_created_by_foreign` (`created_by`),
  CONSTRAINT `laporan_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `login_history`;
CREATE TABLE `login_history` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `perangkat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('berhasil','gagal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'berhasil',
  `login_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `login_history_user_id_foreign` (`user_id`),
  CONSTRAINT `login_history_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `login_history` VALUES 
(1, 1, '192.168.1.105', NULL, 'Chrome on Windows', 'berhasil', '2023-10-24 08:15:00', '2026-08-18 02:33:38', '2026-08-18 02:33:38'),
(2, 1, '114.125.xx.xx', NULL, 'Safari on iPhone', 'berhasil', '2023-10-23 17:30:00', '2026-08-18 02:33:38', '2026-08-18 02:33:38'),
(3, 1, '10.8.0.42', NULL, 'Firefox on macOS', 'gagal', '2023-10-20 09:00:00', '2026-08-18 02:33:39', '2026-08-18 02:33:39'),
(4, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Chrome on Windows', 'berhasil', '2026-08-18 02:34:01', '2026-08-18 02:34:01', '2026-08-18 02:34:01'),
(5, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Chrome on Windows', 'berhasil', '2026-08-18 07:24:04', '2026-08-18 07:24:04', '2026-08-18 07:24:04'),
(6, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Chrome on Windows', 'berhasil', '2026-08-19 04:48:36', '2026-08-19 04:48:36', '2026-08-19 04:48:36'),
(7, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'Chrome on Windows', 'berhasil', '2026-08-20 01:29:15', '2026-08-20 01:29:15', '2026-08-20 01:29:15');

DROP TABLE IF EXISTS `media_sosial`;
CREATE TABLE `media_sosial` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` enum('infografis','videografis','media_luar_ruang') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'infografis',
  `platform` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'instagram',
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_publikasi` date DEFAULT NULL,
  `status` enum('dipublikasi','draft','dijadwalkan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'dipublikasi',
  `link_post` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `media_sosial_created_by_foreign` (`created_by`),
  CONSTRAINT `media_sosial_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `media_sosial` VALUES 
(1, 'Capaian Kinerja Triwulan III 2023', 'infografis', 'instagram', 'Ringkasan infografis mengenai pencapaian target kinerja pembangunan daerah...', NULL, NULL, '2023-10-24', 'dipublikasi', NULL, 1, '2026-08-18 07:16:41', '2026-08-18 07:16:41'),
(2, 'Alur Pelayanan Administrasi Kependudukan', 'infografis', 'facebook', 'Edukasi warga terkait prosedur baru pembuatan izin dan administrasi...', NULL, NULL, '2023-10-20', 'draft', NULL, 1, '2026-08-18 07:16:41', '2026-08-18 07:16:41'),
(3, 'Pertumbuhan Sektor Pariwisata', 'infografis', 'website', 'Data tren kunjungan wisatawan domestik dan mancanegara tahun...', NULL, NULL, '2023-10-15', 'dipublikasi', NULL, 1, '2026-08-18 07:16:41', '2026-08-18 07:16:41'),
(4, 'Highlight Penataan Ruang Terbuka Hijau', 'videografis', 'youtube', 'Liputan dan rekapitulasi progres renovasi taman dan fasilitas umum kota.', NULL, NULL, '2023-10-22', 'dipublikasi', NULL, 1, '2026-08-18 07:16:41', '2026-08-18 07:16:41'),
(5, 'Sosialisasi Program Pengurangan Sampah', 'videografis', 'tiktok', 'Video edukasi singkat gerakan pilah sampah dari sumbernya untuk generasi muda.', NULL, NULL, '2023-10-18', 'dipublikasi', NULL, 1, '2026-08-18 07:16:41', '2026-08-18 07:16:41'),
(6, 'Baliho Hari Jadi Kota Bandung ke-213', 'media_luar_ruang', 'billboard', 'Desain materi billboard promosi rangkaian acara HUT Kota Bandung di titik-titik protokol.', NULL, NULL, '2023-10-12', 'dipublikasi', NULL, 1, '2026-08-18 07:16:41', '2026-08-18 07:16:41'),
(7, 'Videotron Layanan Darurat 112', 'media_luar_ruang', 'videotron', 'Materi tayang LED Videotron simpang lima terkait nomor darurat respon cepat 24 jam.', NULL, NULL, '2023-10-10', 'dipublikasi', NULL, 1, '2026-08-18 07:16:41', '2026-08-18 07:16:41');

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` VALUES 
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_01_000001_create_users_table', 1),
(5, '2024_01_01_000002_create_instansi_table', 1),
(6, '2024_01_01_000003_create_kegiatan_table', 1),
(7, '2024_01_01_000004_create_personel_table', 1),
(8, '2024_01_01_000005_create_penugasan_table', 1),
(9, '2024_01_01_000006_create_notulensi_table', 1),
(10, '2024_01_01_000007_create_arahan_table', 1),
(11, '2024_01_01_000008_create_arsip_table', 1),
(12, '2024_01_01_000009_create_dokumentasi_table', 1),
(13, '2024_01_01_000010_create_daftar_hadir_table', 1),
(14, '2024_01_01_000011_create_supporting_tables', 1),
(15, '2026_08_18_035006_create_sambutan_table', 2),
(16, '2026_08_18_071500_create_media_sosial_table', 3),
(17, '2026_08_18_082000_create_galeri_arsip_table', 4),
(18, '2026_08_19_083356_modify_kategori_in_arsip_table', 5);

DROP TABLE IF EXISTS `notifikasi`;
CREATE TABLE `notifikasi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe` enum('info','warning','success','error') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'info',
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifikasi_user_id_foreign` (`user_id`),
  CONSTRAINT `notifikasi_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `notulensi`;
CREATE TABLE `notulensi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kegiatan_id` bigint unsigned DEFAULT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_rapat` datetime NOT NULL,
  `tempat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `peserta` text COLLATE utf8mb4_unicode_ci,
  `agenda` text COLLATE utf8mb4_unicode_ci,
  `isi_notulensi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `kesimpulan` text COLLATE utf8mb4_unicode_ci,
  `tindak_lanjut` text COLLATE utf8mb4_unicode_ci,
  `file_notulensi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','final') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `notulis_id` bigint unsigned DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notulensi_kegiatan_id_foreign` (`kegiatan_id`),
  KEY `notulensi_notulis_id_foreign` (`notulis_id`),
  KEY `notulensi_created_by_foreign` (`created_by`),
  CONSTRAINT `notulensi_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  CONSTRAINT `notulensi_kegiatan_id_foreign` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatan` (`id`) ON DELETE SET NULL,
  CONSTRAINT `notulensi_notulis_id_foreign` FOREIGN KEY (`notulis_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `penugasan`;
CREATE TABLE `penugasan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kegiatan_id` bigint unsigned NOT NULL,
  `personel_id` bigint unsigned NOT NULL,
  `peran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('ditugaskan','dikonfirmasi','berlangsung','selesai','tidak_hadir') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ditugaskan',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `assigned_by` bigint unsigned DEFAULT NULL,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penugasan_kegiatan_id_foreign` (`kegiatan_id`),
  KEY `penugasan_personel_id_foreign` (`personel_id`),
  KEY `penugasan_assigned_by_foreign` (`assigned_by`),
  CONSTRAINT `penugasan_assigned_by_foreign` FOREIGN KEY (`assigned_by`) REFERENCES `users` (`id`),
  CONSTRAINT `penugasan_kegiatan_id_foreign` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `penugasan_personel_id_foreign` FOREIGN KEY (`personel_id`) REFERENCES `personel` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `penugasan` VALUES 
(1, 1, 6, 'Protokol', 'dikonfirmasi', NULL, 1, NULL, '2026-08-18 02:33:38', '2026-08-18 02:33:38'),
(2, 1, 5, 'Fotografer', 'dikonfirmasi', NULL, 1, NULL, '2026-08-18 02:33:38', '2026-08-18 02:33:38'),
(3, 2, 1, 'MC', 'ditugaskan', NULL, 1, NULL, '2026-08-18 02:33:38', '2026-08-18 02:33:38'),
(4, 2, 3, 'Videografer', 'ditugaskan', NULL, 1, NULL, '2026-08-18 02:33:38', '2026-08-18 02:33:38'),
(5, 3, 6, 'Protokol', 'ditugaskan', NULL, 1, NULL, '2026-08-18 02:33:38', '2026-08-18 02:33:38'),
(6, 3, 2, 'Fotografer', 'ditugaskan', NULL, 1, NULL, '2026-08-18 02:33:38', '2026-08-18 02:33:38'),
(7, 3, 3, 'Videografer', 'ditugaskan', NULL, 1, NULL, '2026-08-18 02:33:38', '2026-08-18 02:33:38'),
(8, 3, 1, 'MC', 'ditugaskan', NULL, 1, NULL, '2026-08-18 02:33:38', '2026-08-18 02:33:38'),
(9, 3, 1, 'Protokol', 'ditugaskan', NULL, 1, NULL, '2026-08-18 02:33:38', '2026-08-18 02:33:38'),
(10, 1, 1, 'Protokol', 'ditugaskan', NULL, 1, NULL, '2026-08-18 02:33:38', '2026-08-18 02:33:38'),
(11, 3, 2, 'MC', 'ditugaskan', NULL, 1, NULL, '2026-08-18 02:33:38', '2026-08-18 02:33:38'),
(12, 3, 3, 'MC', 'ditugaskan', NULL, 1, NULL, '2026-08-18 02:33:38', '2026-08-18 02:33:38'),
(13, 1, 6, 'Protokol', 'ditugaskan', 'testing
Tenggat Waktu: 2026-08-20T19:06', 1, NULL, '2026-08-19 08:09:51', '2026-08-19 08:09:51'),
(14, 17, 6, 'Fotografer', 'ditugaskan', 'testing
Tenggat Waktu: 2026-08-20T17:00', 1, NULL, '2026-08-19 08:10:45', '2026-08-19 08:10:45');

DROP TABLE IF EXISTS `penugasan_log`;
CREATE TABLE `penugasan_log` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `penugasan_id` bigint unsigned NOT NULL,
  `aksi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penugasan_log_penugasan_id_foreign` (`penugasan_id`),
  KEY `penugasan_log_user_id_foreign` (`user_id`),
  CONSTRAINT `penugasan_log_penugasan_id_foreign` FOREIGN KEY (`penugasan_id`) REFERENCES `penugasan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `penugasan_log_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `personel`;
CREATE TABLE `personel` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bidang` enum('protokol','mc','fotografer','videografer','notulis','dokumentasi','lainnya') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'protokol',
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_ketersediaan` enum('standby','bertugas','cuti','tidak_aktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'standby',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `personel_user_id_foreign` (`user_id`),
  CONSTRAINT `personel_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `personel` VALUES 
(1, 2, 'Siti Nurhayati', '19900101201001 2 001', 'Protokol / MC', 'mc', '0813-1111-2222', NULL, 'bertugas', '2026-08-18 02:33:38', '2026-08-18 02:33:38'),
(2, 3, 'Budi Kurniawan', '19880615201501 1 002', 'Fotografer', 'fotografer', '0814-2222-3333', NULL, 'standby', '2026-08-18 02:33:38', '2026-08-18 02:33:38'),
(3, 4, 'Fajar Nugraha', '19921020201601 1 003', 'Videografer', 'videografer', '0815-3333-4444', NULL, 'bertugas', '2026-08-18 02:33:38', '2026-08-18 02:33:38'),
(4, 5, 'Dina Wulandari', '19951215202001 2 004', 'Notulis', 'notulis', '0816-4444-5555', NULL, 'cuti', '2026-08-18 02:33:38', '2026-08-18 02:33:38'),
(5, 6, 'Rizky Ramadhan', '19940315202001 1 005', 'Fotografer', 'fotografer', '0817-5555-6666', NULL, 'bertugas', '2026-08-18 02:33:38', '2026-08-18 02:33:38'),
(6, 7, 'Andi Pratama', '19910822201801 1 006', 'Protokol', 'protokol', '0818-6666-7777', NULL, 'bertugas', '2026-08-18 02:33:38', '2026-08-19 08:10:45');

DROP TABLE IF EXISTS `sambutan`;
CREATE TABLE `sambutan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nomor_surat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_surat` date NOT NULL,
  `asal_instansi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `perihal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_singkat` text COLLATE utf8mb4_unicode_ci,
  `tanggal_terima` date DEFAULT NULL,
  `tenggat_waktu` date DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_urgensi` enum('biasa','segera','penting') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'biasa',
  `instruksi_disposisi` text COLLATE utf8mb4_unicode_ci,
  `petugas_id` bigint unsigned DEFAULT NULL,
  `jenis` enum('permohonan','hasil') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'permohonan',
  `status` enum('draft','diproses','selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sambutan` VALUES 
(1, '009', '2026-08-16', 'PROKOPIM', 'Surat Audiensi', NULL, '2026-08-18', '2026-08-19', NULL, NULL, 'biasa', 'Testing', 1, 'permohonan', 'diproses', 1, '2026-08-18 04:36:52', '2026-08-18 04:36:52', NULL),
(2, '001', '2026-08-24', 'DINAS PENDIDIKAN', 'Sambutan Closing INNOVENTURE 2026 HMIF UNIKOM', NULL, '2026-08-18', '2026-08-21', 'sambutan/4q6l0mxDtO607HglIxJ7T8gdp8n9IO0eCAUcZehI.pdf', '[016][SU]_Surat_Undangan_Tikomdik_Jabar.pdf', 'penting', 'Melakukan dokumentasi pimpinan', 2, 'permohonan', 'diproses', 1, '2026-08-18 04:55:50', '2026-08-18 07:27:31', '2026-08-18 07:27:31'),
(3, '001', '2026-08-24', 'DINAS PENDIDIKAN', 'Sambutan MPLS', NULL, '2026-08-18', '2026-08-21', 'sambutan/TsaBuDEIOMdsI4kRg7zOefxeVxDttmiPVQQdYDl9.pdf', 'TERMS OF REFERENCE (ToR) Speaker INNOVENTREU 2025.pdf', 'penting', 'Melakukan Dokumentasi', 2, 'permohonan', 'diproses', 1, '2026-08-18 07:26:52', '2026-08-18 07:27:31', '2026-08-18 07:27:31');

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

INSERT INTO `sessions` VALUES 
('3IJK2yz2h7qmoT8BB76ZwwrW3ZDnjDQIjrv06HH4', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'eyJfdG9rZW4iOiI3TXFIY2I2ZkYyTXhHSE5sTzJPZFBHVE5RV0ZBWFM4TUczUW5XTVN6IiwidXJsIjpbXSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9rb211bmlrYXNpLXBpbXBpbmFuXC9tZWRpYS1zb3NpYWwiLCJyb3V0ZSI6Im1lZGlhLXNvc2lhbC5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxfQ==', 1787192723);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('super_admin','admin','operator','personel') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'operator',
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_nip_unique` (`nip`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` VALUES 
(1, 'Budi Santoso, S.STP., M.Si.', '19850720200501 1 003', 'admin', 'admin.prokopim@bandung.go.id', '0812-3456-7890', 'Administrator Prokopim', 'super_admin', NULL, NULL, '$2y$12$P6udojC.SdrQUB5gBhDCFOnIh4EbwT0AFOSWqsHnKKQL56MFwVgZ.', 1, NULL, '2026-08-18 02:33:37', '2026-08-18 02:33:37'),
(2, 'Siti Nurhayati', '19900101201001 2 001', 'siti.n', 'siti.n@bandung.go.id', '0813-1111-2222', 'Protokol / MC', 'operator', NULL, NULL, '$2y$12$JEwuVTHZXHyaxCdFLTQgqu7dcM5QDG5xAkqMzfKBhIRE1tX08Q6FC', 1, NULL, '2026-08-18 02:33:37', '2026-08-18 02:33:37'),
(3, 'Budi Kurniawan', '19880615201501 1 002', 'budi.k', 'budi.k@bandung.go.id', '0814-2222-3333', 'Fotografer', 'operator', NULL, NULL, '$2y$12$z9H30fWxzr3UwdVZXH35Xu/MV2wUSLR7HepGEyOLABlGqZxsb6WCa', 1, NULL, '2026-08-18 02:33:37', '2026-08-18 02:33:37'),
(4, 'Fajar Nugraha', '19921020201601 1 003', 'fajar.n', 'fajar.n@bandung.go.id', '0815-3333-4444', 'Videografer', 'operator', NULL, NULL, '$2y$12$wdIm1wIcOtpYoH6kxM08rO03fSQckEJiBRJnJxzHEYGQrXE2o/Jsy', 1, NULL, '2026-08-18 02:33:37', '2026-08-18 02:33:37'),
(5, 'Dina Wulandari', '19951215202001 2 004', 'dina.w', 'dina.w@bandung.go.id', '0816-4444-5555', 'Notulis', 'operator', NULL, NULL, '$2y$12$F/iJK4HD79NvskOd7GlNuOkmz8XGwWdLHRGdiGdDJBSaczmsfikHa', 1, NULL, '2026-08-18 02:33:38', '2026-08-18 02:33:38'),
(6, 'Rizky Ramadhan', '19940315202001 1 005', 'rizky.r', 'rizky.r@bandung.go.id', '0817-5555-6666', 'Fotografer', 'operator', NULL, NULL, '$2y$12$Yd.7vM83JPJZ7tII7ST2nOBrc.smHWRR2XNSruwZiub46TZiNhBk6', 1, NULL, '2026-08-18 02:33:38', '2026-08-18 02:33:38'),
(7, 'Andi Pratama', '19910822201801 1 006', 'andi.p', 'andi.p@bandung.go.id', '0818-6666-7777', 'Protokol', 'operator', NULL, NULL, '$2y$12$SE65ezJ5pAFI8A4o0wwBaObI.zKJhoW8PyrCeE6upJ/XXRiB6nAJq', 1, NULL, '2026-08-18 02:33:38', '2026-08-18 02:33:38');

SET FOREIGN_KEY_CHECKS=1;

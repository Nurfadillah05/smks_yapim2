-- =====================================================================
-- DATABASE : smks_yapim2
-- Website  : SMKS Indonesia Membangun 2 Medan (SMK BM & PAR YAPIM Medan)
-- Cara import: buka http://localhost/phpmyadmin -> tab Import -> pilih file ini
-- =====================================================================

CREATE DATABASE IF NOT EXISTS `smks_yapim2`
  DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `smks_yapim2`;

-- ---------------------------------------------------------------------
-- Tabel admin (untuk login halaman admin)
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id`         INT(11) NOT NULL AUTO_INCREMENT,
  `nama`       VARCHAR(100) NOT NULL,
  `username`   VARCHAR(50)  NOT NULL UNIQUE,
  `password`   VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Akun bawaan ->  username : admin      password : admin123
INSERT INTO `admin` (`nama`, `username`, `password`) VALUES
('Administrator YAPIM', 'admin', '$2a$10$iVXIlkXgy/FtzrALLNddnOEZOjJnwVafxHXhOuV/bMu9D0cFLMx9S');

-- ---------------------------------------------------------------------
-- Tabel galeri
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `galeri`;
CREATE TABLE `galeri` (
  `id`         INT(11) NOT NULL AUTO_INCREMENT,
  `judul`      VARCHAR(150) NOT NULL,
  `kategori`   VARCHAR(80)  DEFAULT NULL,
  `tanggal`    DATE         DEFAULT NULL,
  `deskripsi`  TEXT         DEFAULT NULL,
  `gambar`     VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `galeri` (`judul`, `kategori`, `tanggal`, `deskripsi`, `gambar`) VALUES
('Upacara HUT RI ke-80', '17 Agustus', '2025-08-17', 'Seluruh siswa dan guru mengikuti upacara bendera memperingati Hari Kemerdekaan Republik Indonesia di lapangan sekolah.', ''),
('Praktik Administrasi Kantor', 'Administrasi Perkantoran', '2025-03-11', 'Siswa Administrasi Perkantoran melakukan praktik pengelolaan dokumen dan pelayanan administrasi.', ''),
('Kunjungan Industri', 'Akuntansi & Perkantoran', '2025-05-20', 'Kunjungan industri ke perusahaan mitra untuk mengenal dunia kerja secara langsung.', '');

-- ---------------------------------------------------------------------
-- Tabel prestasi
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `prestasi`;
CREATE TABLE `prestasi` (
  `id`         INT(11) NOT NULL AUTO_INCREMENT,
  `nama_lomba` VARCHAR(150) NOT NULL,
  `juara`      VARCHAR(80)  DEFAULT NULL,
  `tingkat`    VARCHAR(80)  DEFAULT NULL,
  `tahun`      VARCHAR(10)  DEFAULT NULL,
  `peraih`     VARCHAR(150) DEFAULT NULL,
  `deskripsi`  TEXT         DEFAULT NULL,
  `gambar`     VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `prestasi` (`nama_lomba`, `juara`, `tingkat`, `tahun`, `peraih`, `deskripsi`, `gambar`) VALUES
('Lomba Kompetensi Siswa (LKS) Akuntansi', 'Juara 1', 'Kota Medan', '2025', 'Siswa Kelas XI AK', 'Menyelesaikan siklus akuntansi perusahaan dagang dengan nilai tertinggi.', ''),
('Lomba Administrasi Perkantoran', 'Juara 2', 'Provinsi Sumatera Utara', '2025', 'Siswa Kelas XII Adm. Perkantoran', 'Kompetisi keterampilan administrasi dan pelayanan perkantoran.', ''),
('Turnamen Bola Basket Pelajar', 'Juara 3', 'Kota Medan', '2024', 'Tim Basket YAPIM', 'Tim putra sekolah berhasil melaju sampai babak semifinal.', ''),
('Olimpiade Bahasa Inggris', 'Harapan 1', 'Kota Medan', '2024', 'Siswa Kelas X', 'Kompetisi speech dan story telling antar SMK se-Kota Medan.', '');

-- ---------------------------------------------------------------------
-- Tabel instagram (postingan/video terbaru yang ditampilkan di beranda)
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `instagram`;
CREATE TABLE `instagram` (
  `id`         INT(11) NOT NULL AUTO_INCREMENT,
  `judul`      VARCHAR(150) NOT NULL,
  `caption`    TEXT         DEFAULT NULL,
  `link`       VARCHAR(255) DEFAULT NULL,
  `gambar`     VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `instagram` (`judul`, `caption`, `link`, `gambar`) VALUES
('Keseruan class meeting', 'Momen kebersamaan siswa YAPIM di akhir semester.', 'https://www.instagram.com/smk_bm_par_yapimedan/', ''),
('Praktik Administrasi', 'Belajar langsung menerapkan keterampilan administrasi perkantoran.', 'https://www.instagram.com/smk_bm_par_yapimedan/', ''),
('Penerimaan siswa baru', 'Pendaftaran siswa baru sudah dibuka, daftar sekarang!', 'https://www.instagram.com/smk_bm_par_yapimedan/', '');

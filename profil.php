<?php
require_once __DIR__ . '/config/koneksi.php';
$judul_halaman = 'Profil | SMKS Indonesia Membangun 2 Medan';
$halaman_aktif = 'profil';
require_once __DIR__ . '/includes/header.php';
require __DIR__ . '/sections/sambutan.php';
require __DIR__ . '/sections/sejarah.php';
require __DIR__ . '/sections/visimisi.php';
require __DIR__ . '/sections/struktur.php';

require_once __DIR__ . '/includes/footer.php';
?>

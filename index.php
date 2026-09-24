<?php

require_once __DIR__ . '/config/koneksi.php';

// Bersihkan postingan Instagram yang sudah lewat 7 hari secara otomatis.
bersihkanInstagramKadaluarsa($pdo, 7);

$judul_halaman = 'Beranda | SMKS Indonesia Membangun 2 Medan';

$halaman_aktif = 'beranda';

require_once __DIR__ . '/includes/header.php';

/* =====================================================================
 * URUTAN BAGIAN DI BERANDA
 * Urutan di bawah ini SAMA dengan urutan menu di navbar
 * (lihat includes/header.php), jadi kalau mau memindah bagian,
 * pindahkan juga menunya.
 * ===================================================================== */

// 1. Beranda
require __DIR__ . '/sections/hero.php';

// 2. Profil (sambutan kepala sekolah)
require __DIR__ . '/sections/sambutan.php';

// 3. Sejarah
require __DIR__ . '/sections/sejarah.php';

// 4. Visi & Misi
require __DIR__ . '/sections/visimisi.php';

// (struktur organisasi termasuk bagian profil)
require __DIR__ . '/sections/struktur.php';

// 5. Jurusan
require __DIR__ . '/sections/jurusan.php';

// 6. Prestasi
require __DIR__ . '/sections/prestasi.php';

// 7. Galeri
require __DIR__ . '/sections/galeri.php';

// (motto dan video Instagram ada di antara galeri dan ekstrakurikuler)
require __DIR__ . '/sections/motto.php';
require __DIR__ . '/sections/instagram.php';

// 8. Ekstrakurikuler & 9. Fasilitas — masing-masing section berdiri sendiri
// dan mengikuti anchor menu navbar.
require __DIR__ . '/sections/fasilitas.php';
require __DIR__ . '/sections/ekstrakurikuler.php';

// 10. Kontak
require __DIR__ . '/sections/kontak.php';

// FOOTER
require_once __DIR__ . '/includes/footer.php';

<?php
if (!isset($pdo)) {
    require_once __DIR__ . '/../config/koneksi.php';
}

require_once __DIR__ . '/data.php';
require_once __DIR__ . '/ikon.php';

$judul_halaman = isset($judul_halaman) ? $judul_halaman : $sekolah['nama'];
$halaman_aktif = isset($halaman_aktif) ? $halaman_aktif : 'beranda';

$beranda = 'index.php';

// angka versi supaya browser selalu ambil css/js TERBARU, bukan yang
// tersimpan di cache (kalau ada revisi tampilan, angka ini otomatis
// berubah karena mengikuti waktu file terakhir diubah)
$versi_aset = @filemtime(__DIR__ . '/../assets/css/style.css') ?: time();
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="description"
      content="<?= e($sekolah['nama']) ?> — <?= e($sekolah['sub_nama']) ?>.">

<title><?= e($judul_halaman) ?></title>

<link rel="icon" href="assets/img/logo.png">

<!-- huruf dari Google Fonts: Plus Jakarta Sans untuk judul, Inter untuk teks, Playfair Display untuk judul bagian jurusan -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&family=Plus+Jakarta+Sans:wght@500;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="assets/css/style.css?v=<?= $versi_aset ?>">

<!-- tanda bahwa JavaScript aktif (dipakai untuk animasi muncul saat digulir) -->
<script>document.documentElement.className += ' js';</script>
</head>

<body>

<a class="lewati" href="#konten">Lewati ke isi halaman</a>

<?php
/* =========================================================
   DAFTAR MENU
   Urutannya sama dengan urutan bagian di halaman beranda
   (lihat index.php). Kalau mau menambah menu, tambahkan satu
   baris di sini dan pastikan bagiannya punya id yang sama.
   ========================================================= */
$menu_kiri = [
    ['id' => 'hero',      'ikon' => 'beranda',  'teks' => 'Beranda',       'url' => 'index.php#hero'],
    ['id' => 'profil',    'ikon' => 'profil',   'teks' => 'Profil',        'url' => 'profil.php'],
    ['id' => 'sejarah',   'ikon' => 'sejarah',  'teks' => 'Sejarah',       'url' => 'sejarah.php'],
    ['id' => 'visi-misi', 'ikon' => 'visi',     'teks' => 'Visi &amp; Misi','url' => 'visimisi.php'],
    ['id' => 'jurusan',   'ikon' => 'jurusan',  'teks' => 'Jurusan',       'url' => 'jurusan-list.php'],
];
$menu_kanan = [
    ['id' => 'prestasi',        'ikon' => 'prestasi',  'teks' => 'Prestasi',         'url' => 'prestasi.php'],
    ['id' => 'galeri',          'ikon' => 'galeri',    'teks' => 'Galeri',           'url' => 'galeri.php'],
    ['id' => 'fasilitas',       'ikon' => 'fasilitas', 'teks' => 'Fasilitas',        'url' => 'fasilitas.php'],
    ['id' => 'ekstrakurikuler', 'ikon' => 'bintang',   'teks' => 'Ekstrakurikuler',  'url' => 'ekstrakurikuler.php'],
    ['id' => 'kontak',          'ikon' => 'kontak',    'teks' => 'Kontak',           'url' => 'kontak.php'],
];

function cetakMenu($daftar, $beranda, $halaman_aktif)
{
    foreach ($daftar as $m) {
        $aktif = ($m['id'] === 'hero' && $halaman_aktif === 'beranda')
              || ($m['id'] === 'jurusan' && $halaman_aktif === 'jurusan')
              || ($m['id'] === $halaman_aktif);
        ?>
            <li>
                <a class="navlink<?= $aktif ? ' aktif' : '' ?>"
                   href="<?= e($m['url']) ?>"
                   data-seksi="<?= $m['id'] ?>">

                    <span class="navlink__ikon"><?= ikon($m['ikon'], 18) ?></span>

                    <span class="navlink__teks"><?= $m['teks'] ?></span>
                </a>
            </li>
        <?php
    }
}
?>

<!-- =========================================================
     BAR INFORMASI ATAS
========================================================= -->
<div class="bar-info">

    <div class="wadah wadah--lebar bar-info__isi">

        <a class="bar-info__item bar-info__alamat"
           href="<?= e($sekolah['maps']) ?>"
           target="_blank"
           rel="noopener">

            <?= ikon('pin', 15) ?>

            <span><?= e($sekolah['alamat']) ?></span>

        </a>

        <div class="bar-info__kanan">

            <a class="bar-info__item"
               href="tel:<?= preg_replace('/\s/', '', $sekolah['telepon'][0]) ?>">

                <?= ikon('telepon', 15) ?>

                <span><?= e($sekolah['telepon'][0]) ?></span>

            </a>

            <a class="bar-info__item bar-info__ig"
               href="<?= e($sekolah['ig_link']) ?>"
               target="_blank"
               rel="noopener"
               aria-label="Instagram <?= e($sekolah['ig_user']) ?>"
               title="Instagram @<?= e($sekolah['ig_user']) ?>">
                <?= ikon('instagram', 18) ?>
            </a>

            <span class="bar-info__pisah" aria-hidden="true"></span>

            <button class="bar-info__cari"
                    type="button"
                    data-buka-cari
                    aria-label="Cari di halaman ini">

                <?= ikon('cari', 15) ?>

                <span>Cari</span>

            </button>

            <a class="bar-info__admin"
               href="admin/login.php">

                <?= ikon('admin', 15) ?>

                <span>Admin</span>

            </a>

        </div>

    </div>

</div>


<!-- =========================================================
     NAVBAR
     Menu kiri | LOGO (tepat di tengah) | menu kanan
========================================================= -->
<header class="navbar" id="navbar">

    <nav class="wadah wadah--lebar navbar__isi" aria-label="Menu utama">

        <!-- tombol cari (hanya tampil di HP) -->
        <button class="navcari navcari--hp"
                type="button"
                data-buka-cari
                aria-label="Cari di halaman ini">

            <?= ikon('cari', 20) ?>

        </button>


        <!-- ================= LOGO TENGAH ================= -->
        <a class="navlogo"
           href="<?= $beranda ?>"
           aria-label="Beranda <?= e($sekolah['singkat']) ?>">

            <img src="assets/img/logo.png"
                 alt="Logo <?= e($sekolah['singkat']) ?>"
                 class="navlogo__img"
                 data-fallback="logo">

        </a>


        <div class="navpanel" id="navPanel">

            <!-- ================= MENU KIRI ================= -->
            <ul class="navmenu navmenu--kiri">
                <?php cetakMenu($menu_kiri, $beranda, $halaman_aktif); ?>
            </ul>

            <!-- ================= MENU KANAN ================= -->
            <ul class="navmenu navmenu--kanan">
                <?php cetakMenu($menu_kanan, $beranda, $halaman_aktif); ?>
            </ul>

            <!-- tombol admin (hanya tampil di HP) -->
            <a class="tombol tombol--admin navpanel__admin"
               href="admin/login.php">

                <?= ikon('admin', 17) ?>

                Admin

            </a>

        </div>


        <!-- ================= BURGER HP ================= -->
        <button class="navburger"
                type="button"
                id="tombolBurger"
                aria-label="Buka menu"
                aria-expanded="false"
                aria-controls="navPanel">

            <span></span>
            <span></span>
            <span></span>

        </button>

    </nav>

</header>


<!-- =========================================================
     PENCARIAN
========================================================= -->
<div class="caribox" id="kotakCari" hidden>

    <div class="caribox__isi">

        <div class="caribox__input">

            <?= ikon('cari', 20) ?>

            <input type="search"
                   id="inputCari"
                   placeholder="Cari jurusan, prestasi, fasilitas, kontak…"
                   autocomplete="off">

            <button type="button"
                    id="tutupCari"
                    aria-label="Tutup pencarian">

                <?= ikon('tutup', 20) ?>

            </button>

        </div>

        <div class="caribox__hasil"
             id="hasilCari">

            <p class="caribox__kosong">
                Ketik kata kunci, misalnya
                <b>jurusan</b>
                atau
                <b>kantin</b>.
            </p>

        </div>

    </div>

</div>


<main id="konten">
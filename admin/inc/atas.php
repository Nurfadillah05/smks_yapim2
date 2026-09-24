<?php
/* =====================================================================
 * BAGIAN ATAS HALAMAN ADMIN (sidebar + judul)
 * Sebelum memanggil file ini, isi dulu:
 *   $judul_admin  -> judul halaman
 *   $menu_aktif   -> 'dasbor' / 'galeri' / 'prestasi' / 'instagram'
 * ===================================================================== */

$judul_admin = $judul_admin ?? 'Dasbor';
$menu_aktif  = $menu_aktif  ?? 'dasbor';
$notif       = ambilPesan();

$menu = [
    ['kunci' => 'dasbor',    'label' => 'Dasbor',    'url' => 'index.php',     'ikon' => 'beranda'],
    ['kunci' => 'galeri',    'label' => 'Galeri',    'url' => 'galeri.php',    'ikon' => 'galeri'],
    ['kunci' => 'prestasi',  'label' => 'Prestasi',  'url' => 'prestasi.php',  'ikon' => 'prestasi'],
    ['kunci' => 'instagram', 'label' => 'Instagram', 'url' => 'instagram.php', 'ikon' => 'instagram'],
];
$versi_aset = @filemtime(__DIR__ . '/../../assets/css/admin.css') ?: time();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($judul_admin) ?> | Admin SMK YAPIM 2 Medan</title>
<link rel="icon" href="../assets/img/logo.png">
<link rel="stylesheet" href="../assets/css/admin.css?v=<?= $versi_aset ?>">
</head>
<body class="admin-elegan">
<div class="tata">

  <!-- ====== SIDEBAR ====== -->
  <aside class="samping" id="samping">
    <div class="samping__merek">
      <img src="../assets/img/logo.png" alt="Logo" onerror="this.style.display='none'">
      <div>
        <strong>Admin YAPIM</strong>
        <span>SMK YAPIM 2 Medan</span>
      </div>
    </div>

    <nav class="samping__menu">
      <?php foreach ($menu as $m): ?>
        <a class="samping__tautan <?= $menu_aktif === $m['kunci'] ? 'aktif' : '' ?>" href="<?= $m['url'] ?>">
          <?= ikon($m['ikon'], 19) ?> <span><?= $m['label'] ?></span>
        </a>
      <?php endforeach; ?>
    </nav>

    <div class="samping__bawah">
      <a class="samping__tautan" href="../index.php" target="_blank"><?= ikon('link', 19) ?> <span>Lihat website</span></a>
      <a class="samping__tautan samping__tautan--keluar" href="logout.php"><?= ikon('keluar', 19) ?> <span>Keluar</span></a>
    </div>
  </aside>

  <!-- ====== ISI ====== -->
  <div class="isi">
    <header class="isi__kepala">
      <button class="isi__burger" type="button" id="bukaSamping" aria-label="Buka menu">
        <span></span><span></span><span></span>
      </button>
      <div>
        <h1><?= e($judul_admin) ?></h1>
        <p>Halo, <?= e($_SESSION['admin_nama'] ?? 'Admin') ?> 👋</p>
      </div>
    </header>

    <?php if ($notif): ?>
      <div class="notif notif--<?= e($notif['jenis']) ?>"><?= e($notif['teks']) ?></div>
    <?php endif; ?>

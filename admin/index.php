<?php
/* ============ DASBOR ADMIN ============ */
require_once __DIR__ . '/auth.php';
wajibLogin();

$jumlah = [
    'galeri'    => (int) ambilSatu($pdo, "SELECT COUNT(*) AS n FROM galeri")['n'],
    'prestasi'  => (int) ambilSatu($pdo, "SELECT COUNT(*) AS n FROM prestasi")['n'],
    'instagram' => (int) ambilSatu($pdo, "SELECT COUNT(*) AS n FROM instagram")['n'],
];

$galeriTerbaru   = ambilSemua($pdo, "SELECT * FROM galeri ORDER BY id DESC LIMIT 4");
$prestasiTerbaru = ambilSemua($pdo, "SELECT * FROM prestasi ORDER BY id DESC LIMIT 4");

$judul_admin = 'Dasbor';
$menu_aktif  = 'dasbor';
require __DIR__ . '/inc/atas.php';
?>

<div class="kartu-angka">
  <a class="angka angka--biru" href="galeri.php">
    <span class="angka__ikon"><?= ikon('galeri', 24) ?></span>
    <span class="angka__isi"><b><?= $jumlah['galeri'] ?></b><small>Foto galeri</small></span>
  </a>
  <a class="angka angka--emas" href="prestasi.php">
    <span class="angka__ikon"><?= ikon('prestasi', 24) ?></span>
    <span class="angka__isi"><b><?= $jumlah['prestasi'] ?></b><small>Prestasi siswa</small></span>
  </a>
  <a class="angka angka--ungu" href="instagram.php">
    <span class="angka__ikon"><?= ikon('instagram', 24) ?></span>
    <span class="angka__isi"><b><?= $jumlah['instagram'] ?></b><small>Postingan Instagram</small></span>
  </a>
</div>

<div class="dua-kolom">
  <div class="panel">
    <div class="panel__kepala">
      <h2>Galeri terbaru</h2>
      <a class="tbl tbl--kecil" href="galeri.php">Kelola</a>
    </div>
    <?php if (empty($galeriTerbaru)): ?>
      <p class="hampa">Belum ada foto galeri.</p>
    <?php else: ?>
      <ul class="daftar-ringkas">
        <?php foreach ($galeriTerbaru as $g): $img = gambarAdmin($g['gambar'], 'galeri'); ?>
          <li>
            <span class="mini-foto"><?= $img ? '<img src="' . e($img) . '" alt="">' : ikon('foto', 18) ?></span>
            <span><b><?= e($g['judul']) ?></b><small><?= e($g['kategori']) ?></small></span>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </div>

  <div class="panel">
    <div class="panel__kepala">
      <h2>Prestasi terbaru</h2>
      <a class="tbl tbl--kecil" href="prestasi.php">Kelola</a>
    </div>
    <?php if (empty($prestasiTerbaru)): ?>
      <p class="hampa">Belum ada prestasi.</p>
    <?php else: ?>
      <ul class="daftar-ringkas">
        <?php foreach ($prestasiTerbaru as $p): $img = gambarAdmin($p['gambar'], 'prestasi'); ?>
          <li>
            <span class="mini-foto"><?= $img ? '<img src="' . e($img) . '" alt="">' : ikon('prestasi', 18) ?></span>
            <span><b><?= e($p['nama_lomba']) ?></b><small><?= e(trim($p['juara'] . ' ' . $p['tingkat'])) ?></small></span>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </div>
</div>

<?php require __DIR__ . '/inc/bawah.php'; ?>

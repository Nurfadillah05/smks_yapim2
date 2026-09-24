<?php
/* =====================================================================
 * HALAMAN JURUSAN
 * Alamatnya:  jurusan.php?j=akuntansi   dan   jurusan.php?j=administrasi-perkantoran
 * Isi halaman diambil dari includes/data.php, jadi tampilannya sama
 * tetapi isinya berbeda tiap jurusan.
 * ===================================================================== */

require_once __DIR__ . '/config/koneksi.php';
require_once __DIR__ . '/includes/data.php';

$slug = isset($_GET['j']) ? $_GET['j'] : 'akuntansi';
if (!isset($jurusan[$slug])) {
    $slug = 'akuntansi';   // kalau alamatnya salah ketik, arahkan ke jurusan pertama
}
$j     = $jurusan[$slug];
$lain  = ($slug === 'akuntansi') ? 'administrasi-perkantoran' : 'akuntansi';

$judul_halaman = $j['nama_polos'] . ' | SMKS Indonesia Membangun 2 Medan';
$halaman_aktif = 'jurusan';

require_once __DIR__ . '/includes/header.php';
?>

<!-- ============ KEPALA HALAMAN JURUSAN ============
     Tampilan mengikuti contoh di PDF: kolase foto di kiri, penjelasan
     jurusan di kanan, lalu kotak "Kerja Sama" yang bisa dibuka-tutup. -->
<?php
$t     = $j['tema'];
$gaya  = '--jd:' . e($t['utama']) . ';--jdg:' . e($t['gelap']) . ';--jdt:' . e($t['terang']) . ';--jdp:' . e($t['pucat']);
$kerja = $j['kerjasama'];
?>
<section class="jd jd--<?= e($slug) ?>" style="<?= $gaya ?>">
  <!-- Detail jurusan: hanya 4 foto kolase + deskripsi + tombol kerja sama. -->

  <span class="jd__lingkar" aria-hidden="true"></span>

  <div class="wadah jd__grid">

    <!-- kolase foto kegiatan -->
    <div class="jd__kolase reveal" data-anim="kiri" aria-hidden="true">
      <span class="jd__kotak jd__kotak--tua"></span>
      <span class="jd__kotak jd__kotak--muda"></span>
      <span class="jd__titik"></span>
      <?php foreach (array_slice($j['kegiatan'], 0, 4) as $i => $k): ?>
        <span class="jd__foto jd__foto--<?= $i + 1 ?>">
          <img src="<?= e($k['foto']) ?>" alt="" loading="lazy" data-fallback="kegiatan">
        </span>
      <?php endforeach; ?>
    </div>

    <!-- penjelasan jurusan -->
    <div class="jd__teks reveal" data-anim="kanan" style="--tunda:120ms">
      <p class="jd__label">Jurusan</p>
      <h1 class="jd__judul"><?= $j['judul'] ?></h1>
      <p class="jd__sub"><?= e($j['sub']) ?></p>
      <p class="jd__uraian"><?= e($j['uraian']) ?></p>

      <button class="jd__tombol" type="button" id="tombolKerjasama" aria-controls="kerjaIsi" aria-expanded="false">
        <span><?= e($kerja['tombol']) ?></span> <?= ikon('chevron', 18) ?>
      </button>
    </div>
  </div>

  <!-- kotak kerja sama (bisa dibuka dan ditutup) -->
  <div class="wadah jd__kerja-wadah">
    <div class="kerja reveal tutup" id="kerjaSama">
      <button class="kerja__kepala" type="button" id="kerjaKepala" aria-expanded="false" aria-controls="kerjaIsi">
        <span class="kerja__ikon" aria-hidden="true"><?= ikon($j['ikon_mitra'], 22) ?></span>
        <span class="kerja__judul">
          <strong><?= $kerja['judul'] ?></strong>
          <small><?= e($kerja['sub']) ?></small>
        </span>
        <span class="kerja__panah" aria-hidden="true"><?= ikon('chevron', 20) ?></span>
      </button>

      <div class="kerja__isi" id="kerjaIsi">
        <div class="kerja__dalam">
          <ul class="kerja__daftar">
            <?php foreach ($j['mitra'] as $i => $m):
                  $logo = logoMitra($m['nama'], isset($m['logo']) ? $m['logo'] : '');
            ?>
            <li style="--tunda: <?= $i * 70 ?>ms">
              <a class="mitra-chip" href="<?= e($m['link']) ?>" target="_blank" rel="noopener"
                 title="Cari <?= e($m['nama']) ?> di Google">
                <span class="mitra-chip__logo mitra-chip__logo--<?= $i % 4 ?>">
                  <?php if ($logo): ?>
                    <img src="<?= e($logo) ?>" alt="" loading="lazy" data-tanpa-pengganti>
                  <?php else: ?>
                    <?= e(inisialMitra($m['nama'])) ?>
                  <?php endif; ?>
                </span>
                <span class="mitra-chip__nama"><?= e($m['nama']) ?></span>
              </a>
            </li>
            <?php endforeach; ?>
          </ul>

          <p class="kerja__catatan">
            <span class="kerja__catatan-ikon" aria-hidden="true"><?= ikon('info', 18) ?></span>
            <span><?= e($kerja['catatan']) ?></span>
          </p>
        </div>
      </div>
    </div>
  </div>

</section>

<!-- ============ PENGHUBUNG KE JURUSAN BERIKUTNYA ============ -->
<div class="jd__pindah">
  <p>Ingin melihat jurusan lainnya?</p>
  <a class="tombol tombol--garis" href="jurusan.php?j=<?= e($lain) ?>">
    <?= $jurusan[$lain]['judul'] ?> <?= ikon('panah_kanan', 16) ?>
  </a>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

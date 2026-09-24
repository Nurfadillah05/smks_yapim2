<?php
/* Fasilitas berdiri sendiri agar menu langsung membuka halaman fokus. */
?>
<section class="potensi seksi potensi--mandiri" id="fasilitas">
  <div class="potensi__dekor" aria-hidden="true"></div>
  <div class="wadah">
    <div class="seksi__kepala seksi__kepala--tengah reveal" data-anim="atas">
      <p class="seksi__label">Fasilitas Sekolah</p>
      <h2 class="seksi__judul">Ruang Belajar yang Mendukung</h2>
      <p class="seksi__ket">Berbagai fasilitas yang mendukung proses belajar, praktik, dan kegiatan siswa.</p>
    </div>
    <div class="potensi__mandiri-list" data-geser>
      <div class="potensi-geser__jalur potensi-geser__jalur--icon" data-geser-jalur tabindex="0" aria-label="Geser daftar fasilitas sekolah">
        <?php foreach ($fasilitas as $i => $f): ?>
          <article class="icon-potensi reveal" data-anim="zoom" style="--tunda: <?= min($i, 4) * 70 ?>ms" tabindex="0" role="button" aria-label="<?= e($f['nama']) ?>">
            <span class="icon-potensi__lingkaran"><?= ikon($f['icon'], 30) ?></span>
            <span class="icon-potensi__nama"><?= e($f['nama']) ?></span>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="potensi__titik" data-geser-titik aria-hidden="true"><?php for ($i = 0; $i < count($fasilitas); $i++): ?><i></i><?php endfor; ?></div>
  </div>
</section>

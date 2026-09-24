<?php
/* Fasilitas berdiri sendiri agar menu langsung membuka halaman fokus. */
?>
<section class="potensi seksi potensi--mandiri potensi--ekstra" id="ekstrakurikuler">
  <div class="potensi__dekor" aria-hidden="true"></div>
  <div class="wadah">
    <div class="seksi__kepala seksi__kepala--tengah reveal" data-anim="atas">
      <p class="seksi__label">Ekstrakurikuler</p>
      <h2 class="seksi__judul">Kembangkan Minat dan Bakat</h2>
      <p class="seksi__ket">Pilihan kegiatan yang membantu siswa mengembangkan minat, bakat, karakter, dan pengalaman.</p>
    </div>
    <div class="potensi__mandiri-list" data-geser>
      <div class="potensi-geser__jalur potensi-geser__jalur--icon" data-geser-jalur tabindex="0" aria-label="Geser daftar ekstrakurikuler">
        <?php foreach ($ekstrakurikuler as $i => $x): ?>
          <article class="icon-potensi reveal" data-anim="zoom" style="--tunda: <?= min($i, 4) * 70 ?>ms" tabindex="0" role="button" aria-label="<?= e($x['nama']) ?>">
            <span class="icon-potensi__lingkaran"><?= ikon($x['icon'], 30) ?></span>
            <span class="icon-potensi__nama"><?= e($x['nama']) ?></span>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="potensi__titik" data-geser-titik aria-hidden="true"><?php for ($i = 0; $i < count($ekstrakurikuler); $i++): ?><i></i><?php endfor; ?></div>
  </div>
</section>

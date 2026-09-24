<?php /* ============ BAGIAN 2 : SAMBUTAN KEPALA SEKOLAH ============ */ ?>
<section class="sambutan seksi" id="profil">
  <div class="wadah sambutan__wrap">

    <!-- JUDUL -->
    <div class="sambutan__heading reveal" data-anim="atas">
      <p class="seksi__label">Tentang Kami</p>
      <h2 class="seksi__judul">Sambutan Kepala Sekolah</h2>
    </div>

    <div class="sambutan__grid">

      <!-- FOTO KEPALA SEKOLAH -->
      <div class="sambutan__foto reveal" data-anim="kiri">

        <!-- dekorasi biru -->
        <div class="sambutan__shape"></div>

        <!-- aksen kuning -->
        <span class="sambutan__dot sambutan__dot--one"></span>
        <span class="sambutan__dot sambutan__dot--two"></span>

        <!-- titik-titik dekorasi -->
        <div class="sambutan__dots">
          <i></i><i></i><i></i>
          <i></i><i></i><i></i>
          <i></i><i></i><i></i>
        </div>

        <!-- FOTO IBU -->
        <div class="sambutan__foto-box">
          <img
            class="sambutan__gambar"
            src="<?= $kepsek['foto'] ?>"
            alt="<?= e($kepsek['nama']) ?>"
            data-fallback="orang"
          >
        </div>

        <!-- NAMA -->
        <div class="sambutan__kartu-nama">
          <strong><?= e($kepsek['nama']) ?></strong>
          <span><?= e($kepsek['jabatan']) ?></span>
        </div>

      </div>


      <!-- ISI SAMBUTAN -->
      <div class="sambutan__teks reveal" data-anim="kanan">

        <div class="sambutan__box">

          <!-- ikon kutip -->
          <div class="sambutan__quote-icon">
            <?= ikon('bintang', 18) ?>
          </div>

          <p class="sambutan__salam">
            <?= e($kepsek['salam']) ?>
          </p>

          <?php foreach ($kepsek['paragraf'] as $p): ?>
            <p class="sambutan__paragraf">
              <?= $p ?>
            </p>
          <?php endforeach; ?>

          <!-- TANDA TANGAN -->
          <div class="sambutan__ttd">
            <span class="sambutan__garis"></span>

            <div class="sambutan__ttd-info">
              <strong><?= e($kepsek['nama']) ?></strong>

              <span>
                <?= e($kepsek['jabatan']) ?>
                <?= e($sekolah['singkat']) ?>
              </span>
            </div>
          </div>

        </div>

      </div>

    </div>
  </div>
</section>
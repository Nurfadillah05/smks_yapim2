<?php /* ============ BAGIAN 11 : KONTAK ============
 * Tampilan kartu kontak dibuat lebih hidup: tiap info (alamat,
 * telepon, email, instagram) jadi kartu kecil sendiri yang bisa
 * disentuh langsung, ditambah peta di sebelahnya.
 */ ?>
<section class="kontak seksi" id="kontak">
  <div class="wadah">
    <div class="seksi__kepala seksi__kepala--tengah reveal">
      <p class="seksi__label">Hubungi Kami</p>
      <h2 class="seksi__judul">Mampir atau hubungi sekolah kami</h2>
      <p class="seksi__ket">Kami senang menerima kunjungan, pertanyaan, maupun kerja sama. Silakan pilih cara yang paling mudah untukmu.</p>
    </div>

    <div class="kontak__wrap">

      <div class="kontak__kartu-grid">

        <a class="kontak-mini reveal" data-anim="zoom" href="<?= e($sekolah['maps']) ?>" target="_blank" rel="noopener" style="--tunda:0ms">
          <span class="kontak-mini__ikon"><?= ikon('pin', 22) ?></span>
          <span class="kontak-mini__isi">
            <strong>Alamat</strong>
            <small><?= e($sekolah['alamat']) ?></small>
          </span>
        </a>

        <a class="kontak-mini reveal" data-anim="zoom" href="tel:<?= preg_replace('/\s/', '', $sekolah['telepon'][0]) ?>" style="--tunda:80ms">
          <span class="kontak-mini__ikon"><?= ikon('telepon', 22) ?></span>
          <span class="kontak-mini__isi">
            <strong>Telepon</strong>
            <small><?= e($sekolah['telepon'][0]) ?> / <?= e($sekolah['telepon'][1]) ?></small>
          </span>
        </a>

        <a class="kontak-mini reveal" data-anim="zoom" href="mailto:<?= e($sekolah['email']) ?>" style="--tunda:160ms">
          <span class="kontak-mini__ikon"><?= ikon('mail', 22) ?></span>
          <span class="kontak-mini__isi">
            <strong>Email</strong>
            <small><?= e($sekolah['email']) ?></small>
          </span>
        </a>

        <a class="kontak-mini reveal" data-anim="zoom" href="<?= e($sekolah['ig_link']) ?>" target="_blank" rel="noopener" style="--tunda:240ms">
          <span class="kontak-mini__ikon kontak-mini__ikon--emas"><?= ikon('instagram', 22) ?></span>
          <span class="kontak-mini__isi">
            <strong>Instagram</strong>
            <small>@<?= e($sekolah['ig_user']) ?></small>
          </span>
        </a>

      </div>

      <div class="kontak__peta reveal" data-anim="kanan">
        <iframe
          src="<?= e($sekolah['maps_embed']) ?>"
          title="Peta lokasi <?= e($sekolah['singkat']) ?>"
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"></iframe>
        <a class="kontak__buka" href="<?= e($sekolah['maps']) ?>" target="_blank" rel="noopener">
          Buka di Google Maps <?= ikon('panah_kanan', 15) ?>
        </a>
      </div>

    </div>
  </div>
</section>

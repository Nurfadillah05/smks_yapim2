<?php /* ============ HERO SECTION ============ */ ?>

<section class="hero" id="hero">

  <!-- Dekorasi background -->
  <div class="hero__dekor" aria-hidden="true">
    <span class="hero__orb hero__orb--1"></span>
    <span class="hero__orb hero__orb--2"></span>
    <span class="hero__orb hero__orb--3"></span>
    <span class="hero__dots"></span>
    <span class="hero__line"></span>
  </div>

  <div class="wadah hero__grid">

    <!-- ================= TEKS KIRI ================= -->
    <div class="hero__teks">

      <span class="hero__garis"></span>

      <p class="hero__salam">
        Selamat Datang di
      </p>

      <h1 class="hero__judul">
        SMKS INDONESIA
        <span>MEMBANGUN 2 MEDAN</span>
      </h1>

      <p class="hero__nama-resmi">
        SMK BISNIS MANAJEMEN DAN PARIWISATA YAPIM MEDAN
      </p>

      <p class="hero__uraian">
        Membentuk generasi unggul, berkarakter, dan siap bersaing di
        dunia kerja melalui pendidikan vokasi yang berkualitas.
      </p>

      <a class="tombol tombol--utama tombol--turun" href="#profil">
        <span>Jelajahi Sekolah Kami</span>
        <span class="tombol__panah">
          <?= ikon('panah_bawah', 18) ?>
        </span>
      </a>

      <!-- indikator slide/dekorasi -->
      <div class="hero__indikator" aria-hidden="true">
        <span class="aktif"></span>
        <span></span>
        <span></span>
      </div>

    </div>


    <!-- ================= FOTO GEDUNG ================= -->
    <div class="hero__visual">

      <div class="hero__foto">

        <img
          class="hero__foto-desktop"
          src="assets/img/gedung-sekolah.png"
          alt="Gedung SMKS Indonesia Membangun 2 Medan"
        >

        <?php
          /* Dua foto khusus HP.
           * Foto kedua boleh diganti dengan assets/img/foto-hero.jpg.
           * Kalau file belum ada, otomatis memakai foto gedung yang sudah tersedia,
           * jadi slider HP tetap punya tepat dua foto dan tidak rusak.
           */
          $fotoHeroMobile = file_exists(__DIR__ . '/../assets/img/foto-hero.jpg')
              ? 'assets/img/foto-hero.jpg'
              : 'assets/img/gedung-sekolah.png';
        ?>
        <img
          class="hero__foto-mobile hero__foto-mobile--1"
          src="assets/img/foto-sejarah.jpg"
          alt="Foto sekolah"
          aria-hidden="true"
        >
        <img
          class="hero__foto-mobile hero__foto-mobile--2"
          src="<?= e($fotoHeroMobile) ?>"
          alt="Foto sekolah"
          aria-hidden="true"
        >

        <div class="hero__foto-overlay"></div>

      </div>

      <!-- bentuk kuning sebagai pemisah -->
      <div class="hero__kuning"></div>

    </div>

  </div>


  <!-- ================= 4 FEATURE ================= -->
  <div class="wadah hero__feature-wadah">

    <ul class="keunggulan">

      <?php foreach ($keunggulan as $i => $k): ?>

        <li
          class="keunggulan__item"
          style="--tunda: <?= $i * 120 ?>ms"
        >

          <span class="keunggulan__ikon">
            <?= ikon($k['icon'], 24) ?>
          </span>

          <span class="keunggulan__teks">
            <span class="keunggulan__judul">
              <?= $k['judul'] ?>
            </span>

            <span class="keunggulan__sub">
              <?= $k['sub'] ?>
            </span>
          </span>

        </li>

      <?php endforeach; ?>

    </ul>

  </div>


  <!-- Scroll indicator -->
  <div class="hero__scroll" aria-hidden="true">
    <span></span>
    <small>Scroll<br>Down</small>
  </div>

</section>
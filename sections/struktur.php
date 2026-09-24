<?php /* ============ BAGIAN 9 : STRUKTUR ORGANISASI ============ */ ?>
<section class="struktur seksi" id="struktur">
  <div class="wadah">
    <div class="struktur__papan reveal">
      <div class="struktur__kepala">
        <p class="seksi__label">Struktur Organisasi</p>
        <h2 class="seksi__judul"><?= $sekolah['nama'] ?></h2>
        <p class="seksi__ket">Susunan pengelolaan sekolah ditampilkan sebagai ikon agar tetap jelas meskipun belum tersedia foto setiap pengurus.</p>
      </div>
      <div class="struktur__bagan">
        <div class="simpul simpul--utama">
          <span class="simpul__jabatan"><?= $struktur['kepala']['jabatan'] ?></span>
          <span class="simpul__nama"><?= $struktur['kepala']['nama'] ?></span>
        </div>
        <span class="garis garis--tegak" aria-hidden="true"></span>
        <div class="simpul simpul--utama">
          <span class="simpul__jabatan"><?= $struktur['wakil']['jabatan'] ?></span>
          <span class="simpul__nama"><?= $struktur['wakil']['nama'] ?></span>
        </div>
        <span class="garis garis--tegak" aria-hidden="true"></span>
        <span class="garis garis--cabang" aria-hidden="true"></span>
        <div class="struktur__cabang">
          <?php foreach ($struktur['program'] as $s): ?>
          <div class="simpul simpul--cabang">
            <span class="simpul__jabatan"><?= $s['jabatan'] ?></span>
            <span class="simpul__nama"><?= $s['nama'] ?></span>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

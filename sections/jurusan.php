<?php /* ============ BAGIAN 5 : KOMPETENSI KEAHLIAN (DUA PROGRAM KEAHLIAN) ============
   Tampilan mengikuti contoh di PDF: judul di tengah, dua kartu foto besar
   dengan bentuk warna di belakangnya, lalu tombol "Lihat Selengkapnya".
   Isi kartu (nama, foto, warna) diambil dari $jurusan di includes/data.php.
   ================================================================================ */ ?>
<section class="program" id="jurusan">

  <!-- hiasan latar (tidak berisi teks penting) -->
  <span class="program__hias program__hias--garis" aria-hidden="true"></span>
  <span class="program__hias program__hias--cincin" aria-hidden="true"></span>
  <span class="program__hias program__hias--busur-kiri" aria-hidden="true"></span>
  <span class="program__hias program__hias--busur-kanan" aria-hidden="true"></span>
  <span class="program__slogan" aria-hidden="true">Pendidikan<br>berkualitas<br>untuk masa<br>depan</span>

  <div class="wadah">

    <div class="program__kepala reveal">
      <p class="program__label"><span>Kompetensi Keahlian</span></p>
      <h2 class="program__judul">Dua Program Keahlian</h2>
      <p class="program__sub">SMKS Indonesia Membangun 2 Medan</p>
    </div>

    <div class="program__grid">
      <?php $n = 0; foreach ($jurusan as $slug => $j):
            $k = $j['kartu'];
            $gaya = '--k:' . e($k['utama']) . ';--kg:' . e($k['gelap']) . ';--kt:' . e($k['terang'])
                  . ';--tunda:' . ($n * 160) . 'ms';
            $arah = ($n % 2 === 0) ? 'kiri' : 'kanan';
            $n++;
      ?>
      <a class="pkartu pkartu--<?= e($slug) ?> reveal" data-anim="<?= $arah ?>"
         href="jurusan.php?j=<?= e($slug) ?>" style="<?= $gaya ?>"
         aria-label="Lihat selengkapnya jurusan <?= e($j['nama_polos']) ?>">

        <span class="pkartu__foto">
          <span class="pkartu__blob pkartu__blob--1" aria-hidden="true"></span>
          <span class="pkartu__blob pkartu__blob--2" aria-hidden="true"></span>

          <span class="pkartu__bingkai">
            <img src="<?= e($j['cover']) ?>" alt="Siswa program keahlian <?= e($j['nama_polos']) ?>"
                 loading="lazy" data-fallback="jurusan">
          </span>

          <span class="pkartu__ikon" aria-hidden="true"><?= ikon($j['ikon'], 22) ?></span>
        </span>

        <span class="pkartu__isi">
          <span class="pkartu__label">Jurusan</span>
          <span class="pkartu__nama"><?= $j['judul'] ?></span>
          <span class="pkartu__tombol">Lihat Selengkapnya <?= ikon('panah_kanan', 16) ?></span>
        </span>
      </a>
      <?php endforeach; ?>
    </div>

    <div class="program__kaki reveal" aria-hidden="true">
      <span>SMKS Indonesia Membangun 2 Medan</span>
      <i></i>
      <span>Disiplin &nbsp;|&nbsp; Terampil &nbsp;|&nbsp; Berkarakter</span>
    </div>

  </div>
</section>

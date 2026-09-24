<?php
/* ============ BAGIAN 5 : GALERI ============
 * Data diambil dari tabel `galeri` (bisa tambah / ubah / hapus di admin).
 */
$data_galeri = ambilSemua($pdo, "SELECT * FROM galeri ORDER BY COALESCE(tanggal, created_at) DESC, id DESC");
?>
<section class="galeri seksi" id="galeri">
  <div class="wadah">
    <div class="galeri__panel reveal" data-anim="zoom">

      <div class="galeri__kepala">
        <div>
          <p class="seksi__label seksi__label--terang">Dokumentasi Kegiatan</p>
          <h2 class="seksi__judul seksi__judul--terang">Galeri Sekolah</h2>
        </div>
        <a class="tombol tombol--emas" href="#galeri-daftar">Lihat semua <?= ikon('panah_kanan', 16) ?></a>
      </div>

      <?php if (empty($data_galeri)): ?>
        <p class="kosong kosong--terang">Belum ada foto kegiatan. Tambahkan lewat halaman admin.</p>
      <?php else: ?>

      <div class="galeri__strip karusel" id="galeri-daftar" data-geser>
        <div class="galeri__jalur karusel__jalur" data-geser-jalur tabindex="0" aria-label="Foto galeri sekolah">
          <?php foreach ($data_galeri as $i => $g):
                $img = gambarUpload($g['gambar'], 'galeri'); ?>
          <figure class="kartu-galeri reveal" data-anim="zoom" style="--tunda: <?= min($i, 3) * 90 ?>ms">
            <div class="kartu-galeri__foto"
                 data-zoom
                 data-zoom-gambar="<?= e($img) ?>"
                 data-zoom-judul="<?= e($g['judul']) ?>"
                 data-zoom-ket="<?= e(trim(tanggalIndo($g['tanggal']) . ($g['deskripsi'] ? ' — ' . $g['deskripsi'] : ''))) ?>"
                 tabindex="0" role="button" aria-label="Perbesar foto <?= e($g['judul']) ?>">
              <?php if ($img): ?>
                <img src="<?= e($img) ?>" alt="<?= e($g['judul']) ?>" loading="lazy" draggable="false">
              <?php else: ?>
                <span class="foto-kosong"><?= ikon('foto', 30) ?></span>
              <?php endif; ?>

              <!-- label transparan berisi nama kegiatan -->
              <span class="kartu-galeri__pita"><?= e($g['kategori'] ?: $g['judul']) ?></span>

              <span class="kartu-galeri__detail">
                <?= ikon('zoom', 15) ?> Lihat detail
              </span>
            </div>
            <figcaption>
              <h3><?= e($g['judul']) ?></h3>
              <p><?= e(tanggalIndo($g['tanggal'])) ?></p>
            </figcaption>
          </figure>
          <?php endforeach; ?>
        </div>

        <div class="galeri__kontrol">
          <div class="karusel__progres karusel__progres--terang" aria-hidden="true"><span></span></div>
          <div class="karusel__tombol">
            <button class="geser__tombol" type="button" data-geser-kiri aria-label="Geser galeri ke kiri"><?= ikon('panah_kiri', 20) ?></button>
            <button class="geser__tombol" type="button" data-geser-kanan aria-label="Geser galeri ke kanan"><?= ikon('panah_kanan', 20) ?></button>
          </div>
        </div>
      </div>
      <?php endif; ?>

      <!-- kotak putih melengkung -->
      <div class="galeri__kaki">
        <p class="galeri__kaki-label">Dokumentasi</p>
        <h3 class="galeri__kaki-judul">Kegiatan Siswa YAPIM</h3>
        <p class="galeri__kaki-ket">Kegiatan belajar, praktik jurusan, upacara, sampai lomba antar sekolah, semuanya terekam di sini.</p>
      </div>

    </div>
  </div>
</section>

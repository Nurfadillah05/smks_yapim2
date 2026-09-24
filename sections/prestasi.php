<?php
/* ============ BAGIAN 4 : PRESTASI ============
 * Datanya diambil dari tabel `prestasi`. Admin bisa menambah sebanyak
 * apa pun, susunannya tetap rapi karena tingginya diatur otomatis:
 * setiap kelompok 4 kartu mengikuti pola lengkung (2 kartu di tengah
 * dibuat sedikit lebih naik dari 2 kartu di kanan-kirinya), jadi kalau
 * admin menambah prestasi baru, tampilannya tetap mengikuti pola awal.
 * Web hanya menampilkan 4 kartu sekali pandang; sisanya terlihat lewat
 * geser kanan/kiri. Kalau jumlah prestasi 4 atau kurang, kartu-kartu
 * otomatis diposisikan di tengah.
 */
$data_prestasi   = ambilSemua($pdo, "SELECT * FROM prestasi ORDER BY created_at DESC, id DESC");
$prestasi_pusat  = count($data_prestasi) <= 4;
?>
<section class="prestasi seksi" id="prestasi">
  <div class="wadah">
    <div class="seksi__kepala seksi__kepala--tengah reveal">
      <p class="seksi__label">Prestasi Siswa</p>
      <h2 class="seksi__judul">Hasil latihan yang dibawa pulang</h2>
      <p class="seksi__ket">Geser ke samping untuk melihat semua prestasi. Klik salah satu untuk memperbesar.</p>
    </div>
  </div>

  <?php if (empty($data_prestasi)): ?>
    <div class="wadah"><p class="kosong">Belum ada prestasi yang ditambahkan. Masuk ke halaman admin untuk menambahkannya.</p></div>
  <?php else: ?>

  <div class="geser karusel" data-geser>
    <button class="geser__tombol geser__tombol--kiri" type="button" data-geser-kiri aria-label="Geser ke kiri"><?= ikon('panah_kiri', 20) ?></button>

    <div class="geser__jalur<?= $prestasi_pusat ? ' geser__jalur--pusat' : '' ?>" data-geser-jalur tabindex="0" aria-label="Daftar prestasi">
      <?php foreach ($data_prestasi as $i => $p):
            $img       = gambarUpload($p['gambar'], 'prestasi');
            $ket       = trim(($p['juara'] ? $p['juara'] . ' — ' : '') . $p['nama_lomba']);
            // pola lengkung per kelompok 4 kartu: posisi ke-2 & ke-3 (tengah) naik
            $posisi    = $i % 4;
            $kartuNaik = ($posisi === 1 || $posisi === 2) ? 1 : 0;
      ?>
      <article class="kartu-prestasi reveal" data-anim="zoom" style="--tunda: <?= min($i, 4) * 90 ?>ms" data-naik="<?= $kartuNaik ?>"
               data-zoom
               data-zoom-gambar="<?= e($img) ?>"
               data-zoom-judul="<?= e($ket) ?>"
               data-zoom-ket="<?= e(trim($p['tingkat'] . ($p['tahun'] ? ' • ' . $p['tahun'] : '') . ($p['peraih'] ? ' • ' . $p['peraih'] : '') . ' ' . $p['deskripsi'])) ?>"
               tabindex="0" role="button" aria-label="Perbesar prestasi <?= e($p['nama_lomba']) ?>">
        <div class="kartu-prestasi__foto">
          <?php if ($img): ?>
            <img src="<?= e($img) ?>" alt="<?= e($p['nama_lomba']) ?>" loading="lazy" draggable="false">
          <?php else: ?>
            <span class="foto-kosong" data-fallback="prestasi"><?= ikon('prestasi', 34) ?></span>
          <?php endif; ?>
          <span class="kartu-prestasi__zoom"><?= ikon('zoom', 18) ?></span>
        </div>

        <div class="kartu-prestasi__label">
          <?php if ($p['juara']): ?><span class="pil"><?= e($p['juara']) ?></span><?php endif; ?>
          <h3><?= e($p['nama_lomba']) ?></h3>
          <p>
            <?= e($p['tingkat']) ?><?= $p['tahun'] ? ' • ' . e($p['tahun']) : '' ?>
          </p>
        </div>
      </article>
      <?php endforeach; ?>
    </div>

    <button class="geser__tombol geser__tombol--kanan" type="button" data-geser-kanan aria-label="Geser ke kanan"><?= ikon('panah_kanan', 20) ?></button>

    <div class="wadah karusel__kontrol karusel__kontrol--sendiri">
      <div class="karusel__progres" aria-hidden="true"><span></span></div>
    </div>
  </div>
  <?php endif; ?>
</section>

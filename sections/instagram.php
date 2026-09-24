<?php
/* ============ MEDIA SOSIAL INSTAGRAM ============
 * Maksimal 6 postingan aktif. Postingan yang berumur lebih dari 7 hari
 * otomatis dihapus dari database + file gambarnya saat website diakses.
 * Desktop menampilkan 3 kartu; sisanya tersembunyi dan dapat digeser.
 */
bersihkanInstagramKadaluarsa($pdo, 7);
$data_ig = ambilSemua($pdo, "SELECT * FROM instagram WHERE created_at >= (NOW() - INTERVAL 7 DAY) ORDER BY created_at DESC, id DESC");
?>
<section class="ig seksi" id="instagram">
  <div class="wadah ig__layout">
    <div class="ig__teks reveal" data-anim="kiri">
      <p class="seksi__label">Media Sosial</p>
      <h2 class="seksi__judul">Ikuti keseharian kami di Instagram</h2>
      <p class="seksi__ket">Lihat kegiatan terbaru siswa dan sekolah. Tiga postingan ditampilkan terlebih dahulu, sisanya tinggal digeser ke kiri atau kanan.</p>
      <a class="tombol tombol--utama ig__ikuti" href="<?= e($sekolah['ig_link']) ?>" target="_blank" rel="noopener">
        <?= ikon('instagram', 18) ?> <span>@<?= e($sekolah['ig_user']) ?></span>
      </a>
    </div>

    <?php if (empty($data_ig)): ?>
      <div class="ig__kosong"><p class="kosong">Belum ada postingan yang ditampilkan.</p></div>
    <?php else: ?>
      <div class="ig__media karusel" data-geser>
        <div class="karusel__jalur" data-geser-jalur tabindex="0" aria-label="Video dan postingan Instagram">
          <?php foreach ($data_ig as $i => $ig):
                $img  = gambarUpload($ig['gambar'], 'instagram');
                $link = $ig['link'] ?: $sekolah['ig_link'];
          ?>
          <a class="kartu-ig reveal" data-anim="zoom" href="<?= e($link) ?>" target="_blank" rel="noopener" style="--tunda: <?= min($i, 4) * 90 ?>ms">
            <span class="kartu-ig__foto">
              <?php if ($img): ?>
                <img src="<?= e($img) ?>" alt="<?= e($ig['judul']) ?>" loading="lazy" draggable="false">
              <?php else: ?>
                <span class="foto-kosong"><?= ikon('instagram', 28) ?></span>
              <?php endif; ?>
              <span class="kartu-ig__play"><?= ikon('play', 30) ?></span>
            </span>
            <span class="kartu-ig__isi">
              <strong><?= e($ig['judul']) ?></strong>
              <?php if (!empty($ig['caption'])): ?><small><?= e($ig['caption']) ?></small><?php endif; ?>
            </span>
          </a>
          <?php endforeach; ?>
        </div>
        <div class="karusel__kontrol ig__kontrol">
          <div class="karusel__progres" aria-hidden="true"><span></span></div>
          <div class="karusel__tombol">
            <button class="geser__tombol" type="button" data-geser-kiri aria-label="Geser ke kiri"><?= ikon('panah_kiri', 20) ?></button>
            <button class="geser__tombol" type="button" data-geser-kanan aria-label="Geser ke kanan"><?= ikon('panah_kanan', 20) ?></button>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>

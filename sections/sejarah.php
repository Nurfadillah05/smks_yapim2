<?php
/* ============ SEJARAH SEKOLAH ============
 * Untuk mengganti tulisan sejarah, cukup ubah isi di bawah ini.
 * - $sejarah_tahun   : tahun yang tampil di lencana pada foto
 * - $sejarah_paragraf: setiap baris = satu paragraf
 *                      (paragraf pertama tampil sedikit lebih besar)
 */
$sejarah_tahun = '1996';

$sejarah_paragraf = [
    'SMK Bisnis Manajemen dan Pariwisata YAPIM Medan merupakan bagian dari YAPIM Taruna Medan yang terus berkembang dalam memberikan pendidikan kejuruan bagi generasi muda.',
    'Sekolah ini dikembangkan sejak tahun 1996 dengan tujuan memberikan pendidikan yang mengutamakan keterampilan, kedisiplinan, tanggung jawab, serta kesiapan siswa memasuki dunia kerja.',
    'Seiring perkembangan kebutuhan dunia pendidikan dan dunia kerja, sekolah terus melakukan pengembangan pada pembelajaran, fasilitas, kegiatan siswa, serta kerja sama dengan dunia usaha dan dunia industri.',
];
?>
<section class="sejarah seksi" id="sejarah">

    <div class="wadah sejarah__grid">

        <!-- ================= FOTO SEJARAH ================= -->
        <!-- GANTI src di bawah jika ingin memakai foto sejarah khusus. -->
        <div class="sejarah__visual reveal" data-anim="kiri">

            <div class="sejarah__foto">
                <img src="assets/img/foto-sejarah.jpg"
                     alt="Foto sejarah SMKS Indonesia Membangun 2 Medan"
                     loading="lazy">
            </div>

            <div class="sejarah__lencana">
                <small>Sejak</small>
                <strong><?= e($sejarah_tahun) ?></strong>
            </div>

        </div>


        <!-- ================= TULISAN ================= -->
        <div class="sejarah__isi">

            <div class="sejarah__kepala reveal" data-anim="kanan">

                <p class="seksi__label">Sejarah Sekolah</p>

                <h2 class="seksi__judul">
                    Perjalanan SMKS Indonesia Membangun 2 Medan
                </h2>

            </div>

            <div class="sejarah__teks">
                <?php foreach ($sejarah_paragraf as $i => $teks): ?>
                    <p class="sejarah__paragraf<?= $i === 0 ? ' sejarah__paragraf--awal' : '' ?> reveal"
                       data-anim="kanan"
                       style="--tunda: <?= ($i + 1) * 130 ?>ms">
                        <?= e($teks) ?>
                    </p>
                <?php endforeach; ?>
            </div>

        </div>

    </div>

</section>

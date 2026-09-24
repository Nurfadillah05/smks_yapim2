</main>
<!-- /#konten -->


<!-- =========================================================
     FOOTER
========================================================= -->
<footer class="site-footer">

    <div class="footer-container">

        <!-- =================================================
             IDENTITAS SEKOLAH
        ================================================== -->
        <div class="footer-brand footer-column">

            <!-- LOGO SEKOLAH -->
            <div class="footer-brand__logo">
                <img
                    src="assets/img/logo.png"
                    alt="Logo SMKS Indonesia Membangun 2 Medan"
                >
            </div>

            <!-- NAMA SEKOLAH -->
            <div class="footer-brand__name">

                <h3>
                    SMKS INDONESIA<br>
                    MEMBANGUN 2 MEDAN
                </h3>

                <p>
                    SMK BISNIS MANAJEMEN DAN<br>
                    PARIWISATA YAPIM MEDAN
                </p>

            </div>

            <!-- AKREDITASI -->
            <div class="footer-accreditation">

                <span class="footer-accreditation__label">
                    AKREDITASI
                </span>

                <strong>
                    <?= e($sekolah['akreditasi']) ?> (UNGGUL)
                </strong>

            </div>

            <!-- GARIS -->
            <div class="footer-brand__line"></div>

            <!-- SLOGAN -->
            <p class="footer-brand__slogan">
                Pilihan masa depan yang
                <span class="footer-brand__highlight">cerah, kompeten, dan berkarakter.</span>
            </p>

        </div>


        <!-- =================================================
             QUICK MENU
        ================================================== -->
        <div class="footer-menu footer-column">

            <h3 class="footer-title">
                <span></span>
                Quick Menu
            </h3>

            <ul class="footer-links">
                <li><a href="index.php#hero"><span class="footer-menu__icon footer-icon--home"><?= ikon('beranda', 16) ?></span><span>Beranda</span></a></li>
                <li><a href="profil.php"><span class="footer-menu__icon footer-icon--profile"><?= ikon('profil', 16) ?></span><span>Profil</span></a></li>
                <li><a href="sejarah.php"><span class="footer-menu__icon footer-icon--history"><?= ikon('sejarah', 16) ?></span><span>Sejarah</span></a></li>
                <li><a href="visimisi.php"><span class="footer-menu__icon footer-icon--visi"><?= ikon('visi', 16) ?></span><span>Visi &amp; Misi</span></a></li>
                <li><a href="jurusan-list.php"><span class="footer-menu__icon footer-icon--study"><?= ikon('jurusan', 16) ?></span><span>Jurusan</span></a></li>
                <li><a href="prestasi.php"><span class="footer-menu__icon footer-icon--prestasi"><?= ikon('prestasi', 16) ?></span><span>Prestasi</span></a></li>
                <li><a href="galeri.php"><span class="footer-menu__icon footer-icon--gallery"><?= ikon('galeri', 16) ?></span><span>Galeri</span></a></li>
                <li><a href="fasilitas.php"><span class="footer-menu__icon footer-icon--building"><?= ikon('fasilitas', 16) ?></span><span>Fasilitas</span></a></li>
                <li><a href="ekstrakurikuler.php"><span class="footer-menu__icon footer-icon--extra"><?= ikon('bintang', 16) ?></span><span>Ekstrakurikuler</span></a></li>
                <li><a href="kontak.php"><span class="footer-menu__icon footer-icon--contact"><?= ikon('kontak', 16) ?></span><span>Kontak</span></a></li>
            </ul>

        </div>


        <!-- =================================================
             HUBUNGI KAMI
        ================================================== -->
        <div class="footer-contact footer-column">

            <h3 class="footer-title">
                <span></span>
                Hubungi Kami
            </h3>

            <ul class="footer-contact__list">


                <!-- ================= ALAMAT ================= -->
                <li>

                    <div class="footer-contact__icon footer-contact__icon--location">
                        <?= ikon('pin', 18) ?>
                    </div>

                    <div>

                        <small>Alamat</small>

                        <a
                            href="<?= e($sekolah['maps']) ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            <?= e($sekolah['alamat']) ?>
                        </a>

                    </div>

                </li>


                <!-- ================= TELEPON ================= -->
                <li>

                    <div class="footer-contact__icon footer-contact__icon--phone">
                        <?= ikon('telepon', 18) ?>
                    </div>

                    <div>

                        <small>Telepon</small>

                        <a href="tel:0617864701">
                            061 7864 701
                        </a>

                        <a href="tel:0617864702">
                            061 7864 702
                        </a>

                    </div>

                </li>


                <!-- ================= EMAIL ================= -->
                <li>

                    <div class="footer-contact__icon footer-contact__icon--email">
                        <?= ikon('email', 18) ?>
                    </div>

                    <div>

                        <small>Email</small>

                        <a href="mailto:<?= e($sekolah['email']) ?>">
                            <?= e($sekolah['email']) ?>
                        </a>

                    </div>

                </li>


                <!-- ================= INSTAGRAM ================= -->
                <li>

                    <div class="footer-contact__icon footer-contact__icon--instagram">
                        <?= ikon('instagram', 18) ?>
                    </div>

                    <div>

                        <small>Instagram</small>

                        <a
                            href="<?= e($sekolah['ig_link']) ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            <?= e($sekolah['ig_user']) ?>
                        </a>

                    </div>

                </li>

            </ul>

        </div>


        <!-- =================================================
             ILUSTRASI GEDUNG
        ================================================== -->
        <div class="footer-building footer-column">

            <div class="footer-building__text">

                <span>
                    Sekolah Pilihan
                </span>

                <strong>
                    Masa Depan Cerah
                </strong>

            </div>


            <!-- =================================================
                 GAMBAR ILUSTRASI GEDUNG
                 FILE:
                 assets/img/footer-gedung.png
            ================================================== -->
            <img
                src="assets/img/ilustrasi-gedung.png"
                alt="Ilustrasi gedung SMKS Indonesia Membangun 2 Medan"
                loading="lazy"
            >


            <!-- GARIS BAWAH GEDUNG -->
            <div class="footer-building__line"></div>

        </div>

    </div>


    <!-- =====================================================
         FOOTER BOTTOM
    ====================================================== -->
    <div class="footer-bottom">

        <div class="footer-bottom__container">

            <p>
                &copy; <?= date('Y') ?>
                SMKS Indonesia Membangun 2 Medan.
                Seluruh hak cipta dilindungi.
            </p>

            <p>
                SMK Bisnis Manajemen dan Pariwisata YAPIM Medan
            </p>

        </div>

    </div>

</footer>


<!-- =========================================================
     TOMBOL KEMBALI KE ATAS
========================================================= -->
<button
    class="ke-atas"
    id="keAtas"
    type="button"
    aria-label="Kembali ke atas"
>
    <?= ikon('panah_atas', 20) ?>
</button>


<!-- =========================================================
     LIGHTBOX
========================================================= -->
<div
    class="lightbox"
    id="lightbox"
    hidden
>

    <!-- TUTUP -->
    <button
        class="lightbox__tutup"
        id="lightboxTutup"
        aria-label="Tutup"
    >
        <?= ikon('tutup', 24) ?>
    </button>


    <!-- SEBELUMNYA -->
    <button
        class="lightbox__nav lightbox__nav--kiri"
        id="lightboxKiri"
        aria-label="Sebelumnya"
    >
        <?= ikon('panah_kiri', 22) ?>
    </button>


    <!-- BERIKUTNYA -->
    <button
        class="lightbox__nav lightbox__nav--kanan"
        id="lightboxKanan"
        aria-label="Berikutnya"
    >
        <?= ikon('panah_kanan', 22) ?>
    </button>


    <!-- ISI LIGHTBOX -->
    <figure class="lightbox__isi">

        <img
            id="lightboxImg"
            alt=""
            data-tanpa-pengganti
        >

        <figcaption>

            <h4 id="lightboxJudul"></h4>

            <p id="lightboxKet"></p>

        </figcaption>

    </figure>

</div>


<!-- =========================================================
     JAVASCRIPT
========================================================= -->
<script src="assets/js/main.js?v=<?= isset($versi_aset) ? $versi_aset : time() ?>"></script>

</body>
</html>

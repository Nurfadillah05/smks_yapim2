/* =====================================================================
   SMKS INDONESIA MEMBANGUN 2 MEDAN — script halaman publik
   Semuanya ditulis polos tanpa library tambahan, jadi tetap jalan
   walaupun komputer sedang tidak terhubung internet.
   ===================================================================== */
(function () {
  'use strict';

  var $  = function (s, induk) { return (induk || document).querySelector(s); };
  var $$ = function (s, induk) { return Array.prototype.slice.call((induk || document).querySelectorAll(s)); };

  /* ------------------------------------------------------------------
   * 1. GAMBAR PENGGANTI
   * Kalau file foto belum diletakkan di folder assets/img, kotaknya
   * tetap rapi (tidak muncul ikon gambar rusak).
   * ---------------------------------------------------------------- */
  function pasangPengganti(img) {
    var label = img.getAttribute('data-fallback') || 'foto';
    var ganti = document.createElement('span');
    ganti.className = 'gambar-pengganti';
    ganti.textContent = 'Letakkan gambar: ' + (img.getAttribute('src') || label);
    if (img.parentNode) img.parentNode.replaceChild(ganti, img);
  }

  $$('img').forEach(function (img) {
    // gambar di dalam kotak perbesar diisi belakangan lewat script,
    // jadi jangan pernah diganti placeholder
    if (img.hasAttribute('data-tanpa-pengganti')) return;
    // kalau alamat gambarnya memang kosong, biarkan saja (bukan gambar rusak)
    if (!img.getAttribute('src')) return;

    img.addEventListener('error', function () { pasangPengganti(img); });
    if (img.complete && img.naturalWidth === 0) pasangPengganti(img);
  });

  /* ------------------------------------------------------------------
   * 2. ANIMASI MUNCUL SAAT DIGULIR
   * Bagian yang belum terlihat disembunyikan dulu (lewat CSS), lalu
   * muncul dengan animasi ketika digulir sampai ke sana. Kartu di
   * dalam kotak geser (ekstrakurikuler, galeri, dll.) baru muncul
   * ketika digeser sampai kelihatan.
   * ---------------------------------------------------------------- */
  var elemenReveal = $$('.reveal');
  var kurangiGerak = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if ('IntersectionObserver' in window && !kurangiGerak) {
    var pengamat = new IntersectionObserver(function (baris) {
      baris.forEach(function (b) {
        if (b.isIntersecting) {
          b.target.classList.add('tampil');
          pengamat.unobserve(b.target);
        }
      });
    }, { threshold: 0.18, rootMargin: '0px 0px -6% 0px' });
    elemenReveal.forEach(function (el) { pengamat.observe(el); });
  } else {
    elemenReveal.forEach(function (el) { el.classList.add('tampil'); });
  }

  /* ------------------------------------------------------------------
   * 3. NAVBAR: mengecil saat digulir, menu untuk layar kecil,
   *    dan penanda menu yang sedang dibuka
   * ---------------------------------------------------------------- */
  var navbar  = $('#navbar');
  var burger  = $('#tombolBurger');
  var keAtas  = $('#keAtas');

  // menu di navbar yang menuju bagian di halaman ini
  var tautanMenu = $$('.navlink[data-seksi]').map(function (a) {
    return { a: a, el: document.getElementById(a.getAttribute('data-seksi')) };
  }).filter(function (t) { return t.el; });

  var menungguFrame = false;
  function saatGulir() {
    var y = window.pageYOffset || document.documentElement.scrollTop;
    if (navbar) navbar.classList.toggle('mengecil', y > 60);
    if (keAtas) keAtas.classList.toggle('tampak', y > 480);

    // tandai menu sesuai bagian yang sedang dilihat
    if (tautanMenu.length) {
      var batas = y + (navbar ? navbar.offsetHeight : 80) + window.innerHeight * 0.25;
      var aktif = tautanMenu[0];
      tautanMenu.forEach(function (t) {
        var atas = t.el.getBoundingClientRect().top + y;
        if (atas <= batas) aktif = t;
      });
      // sampai di dasar halaman: tandai menu terakhir yang ada
      if (window.innerHeight + y >= document.documentElement.scrollHeight - 4) {
        aktif = tautanMenu[tautanMenu.length - 1];
      }
      tautanMenu.forEach(function (t) { t.a.classList.toggle('aktif', t === aktif); });
    }
    menungguFrame = false;
  }
  function jadwalkanGulir() {
    if (!menungguFrame) { menungguFrame = true; window.requestAnimationFrame(saatGulir); }
  }
  window.addEventListener('scroll', jadwalkanGulir, { passive: true });
  window.addEventListener('resize', jadwalkanGulir);
  saatGulir();

  function tutupMenuHp() {
    if (!navbar || !burger) return;
    navbar.classList.remove('menu-terbuka');
    burger.classList.remove('buka');
    burger.setAttribute('aria-expanded', 'false');
  }
  if (burger && navbar) {
    burger.addEventListener('click', function () {
      var buka = navbar.classList.toggle('menu-terbuka');
      burger.classList.toggle('buka', buka);
      burger.setAttribute('aria-expanded', buka ? 'true' : 'false');
    });
    $$('.navpanel a').forEach(function (a) { a.addEventListener('click', tutupMenuHp); });
    // klik di luar menu = menutup menu
    document.addEventListener('click', function (e) {
      if (navbar.classList.contains('menu-terbuka') && !navbar.contains(e.target)) tutupMenuHp();
    });
    window.addEventListener('resize', function () { if (window.innerWidth > 1100) tutupMenuHp(); });
  }

  if (keAtas) {
    keAtas.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  /* ------------------------------------------------------------------
   * 4. PENCARIAN ISI HALAMAN
   * ---------------------------------------------------------------- */
  var kotakCari  = $('#kotakCari');
  var inputCari  = $('#inputCari');
  var hasilCari  = $('#hasilCari');
  var tutupCari  = $('#tutupCari');

  // daftar tujuan pencarian
  var daftarCari = [
    { judul: 'Beranda',                       ket: 'Tampilan utama sekolah',                       url: 'index.php#hero',                 kunci: 'beranda utama home depan' },
    { judul: 'Sambutan Kepala Sekolah',       ket: 'Profil dan kata sambutan',                     url: 'profil.php',               kunci: 'profil sambutan kepala sekolah vera panjaitan tentang kami' },
    { judul: 'Sejarah Sekolah',               ket: 'Perjalanan sekolah sejak berdiri',             url: 'sejarah.php',              kunci: 'sejarah perjalanan berdiri yayasan yapim taruna 1996' },
    { judul: 'Visi & Misi',                   ket: 'Arah dan tujuan sekolah',                      url: 'visimisi.php',            kunci: 'visi misi tujuan' },
    { judul: 'Akuntansi (AK)',                 ket: 'Program keahlian',                             url: 'jurusan.php?j=akuntansi',              kunci: 'akuntansi keuangan laporan kerja sama dunia usaha dan industri' },
    { judul: 'Administrasi Perkantoran',      ket: 'Program keahlian',                             url: 'jurusan.php?j=administrasi-perkantoran', kunci: 'administrasi perkantoran kantor arsip surat pelayanan dunia usaha dan industri' },
    { judul: 'Ekstrakurikuler',               ket: 'Karate, futsal, voli, tari, dance, PMR',       url: 'ekstrakurikuler.php',      kunci: 'ekstrakurikuler ekskul karate futsal voli tari dance pmr organisasi olahraga seni' },
    { judul: 'Prestasi',                      ket: 'Daftar prestasi siswa',                        url: 'prestasi.php',             kunci: 'prestasi juara lomba lks penghargaan' },
    { judul: 'Galeri',                        ket: 'Dokumentasi kegiatan sekolah',                 url: 'galeri.php',               kunci: 'galeri foto dokumentasi kegiatan 17 agustus' },
    { judul: 'Instagram',                     ket: 'Postingan terbaru sekolah',                    url: 'index.php#instagram',            kunci: 'instagram media sosial video ig reels' },
    { judul: 'Fasilitas',                     ket: 'Ruang praktik, lab komputer, hotel mini',      url: 'fasilitas.php',            kunci: 'fasilitas lab laboratorium komputer hotel mini lobby kelas guru basket kantin ruang praktik' },
    { judul: 'Struktur Organisasi',           ket: 'Susunan pengurus sekolah',                     url: 'index.php#struktur',             kunci: 'struktur organisasi kepala wakil program jurusan' },
    { judul: 'Kontak',                        ket: 'Alamat, telepon, email, peta',                 url: 'kontak.php',               kunci: 'kontak alamat telepon email instagram maps lokasi air bersih medan' },
    { judul: 'Halaman Admin',                 ket: 'Masuk untuk mengelola isi website',            url: 'admin/login.php',                kunci: 'admin login masuk kelola' }
  ];

  function bukaCari() {
    if (!kotakCari) return;
    kotakCari.hidden = false;
    document.body.style.overflow = 'hidden';
    setTimeout(function () { inputCari.focus(); }, 40);
  }
  function tutupPanelCari() {
    if (!kotakCari) return;
    kotakCari.hidden = true;
    document.body.style.overflow = '';
    inputCari.value = '';
    gambarHasil('');
  }
  function gambarHasil(kata) {
    if (!hasilCari) return;
    kata = kata.trim().toLowerCase();
    if (kata === '') {
      hasilCari.innerHTML = '<p class="caribox__kosong">Ketik kata kunci, misalnya <b>jurusan</b> atau <b>kantin</b>.</p>';
      return;
    }
    var cocok = daftarCari.filter(function (d) {
      return (d.judul + ' ' + d.ket + ' ' + d.kunci).toLowerCase().indexOf(kata) !== -1;
    });
    if (cocok.length === 0) {
      hasilCari.innerHTML = '<p class="caribox__kosong">Tidak ada yang cocok dengan “' + kata.replace(/[<>]/g, '') + '”. Coba kata lain.</p>';
      return;
    }
    hasilCari.innerHTML = cocok.map(function (d) {
      return '<a href="' + d.url + '"><strong>' + d.judul + '</strong><small>' + d.ket + '</small></a>';
    }).join('');
  }

  $$('[data-buka-cari]').forEach(function (t) { t.addEventListener('click', function () { tutupMenuHp(); bukaCari(); }); });
  if (tutupCari)  tutupCari.addEventListener('click', tutupPanelCari);
  if (inputCari)  inputCari.addEventListener('input', function () { gambarHasil(this.value); });
  if (kotakCari)  kotakCari.addEventListener('click', function (e) { if (e.target === kotakCari) tutupPanelCari(); });

  /* ------------------------------------------------------------------
   * HERO MOBILE — tepat dua foto khusus HP, berganti setiap 3 detik.
   * Desktop tidak ikut berganti.
   * ---------------------------------------------------------------- */
  (function heroMobileFotos(){
    var hero = document.querySelector('.hero');
    if (!hero) return;
    var fotos = hero.querySelectorAll('.hero__foto-mobile');
    if (fotos.length !== 2) return;

    var aktif = 0;
    fotos[0].style.opacity = '1';
    fotos[1].style.opacity = '0';

    setInterval(function(){
      if (window.innerWidth > 900) return;
      var berikut = aktif === 0 ? 1 : 0;
      fotos[aktif].style.opacity = '0';
      fotos[berikut].style.opacity = '1';
      aktif = berikut;
    }, 3000);
  })();

  /* ------------------------------------------------------------------
   * 5. GESER KE SAMPING (ekstrakurikuler, prestasi, galeri, video IG)
   * Bisa lewat tombol panah, diseret dengan tetikus, digeser dengan
   * jari di HP, atau lewat tombol panah keyboard. Ada garis kemajuan
   * di bawahnya supaya kelihatan masih ada isi di sebelahnya.
   * ---------------------------------------------------------------- */
  $$('[data-geser]').forEach(function (bungkus) {
    var jalur = $('[data-geser-jalur]', bungkus);
    if (!jalur) return;

    var kiri   = $('[data-geser-kiri]', bungkus);
    var kanan  = $('[data-geser-kanan]', bungkus);
    var garis  = $('.karusel__progres span', bungkus);

    function langkah() {
      var kartu = jalur.firstElementChild;
      var jarak = parseFloat(window.getComputedStyle(jalur).columnGap) || 20;
      return kartu ? kartu.getBoundingClientRect().width + jarak : 300;
    }

    function perbarui() {
      var maks = jalur.scrollWidth - jalur.clientWidth;
      var pos  = jalur.scrollLeft;
      var muat = maks <= 4;                         // semua kartu sudah kelihatan
      bungkus.classList.toggle('karusel--tanpa-gulir', muat);
      if (kiri)  kiri.disabled  = muat || pos <= 2;
      if (kanan) kanan.disabled = muat || pos >= maks - 2;
      if (garis) {
        var lebar = jalur.scrollWidth ? Math.min(1, jalur.clientWidth / jalur.scrollWidth) : 1;
        var kiriPersen = maks > 0 ? (pos / maks) * (1 - lebar) * 100 : 0;
        garis.style.width = (lebar * 100) + '%';
        garis.style.left  = kiriPersen + '%';
      }
    }
    jalur.addEventListener('scroll', perbarui, { passive: true });
    window.addEventListener('resize', perbarui);
    window.addEventListener('load', perbarui);
    perbarui();

    if (kiri)  kiri.addEventListener('click',  function () { jalur.scrollBy({ left: -langkah(), behavior: 'smooth' }); });
    if (kanan) kanan.addEventListener('click', function () { jalur.scrollBy({ left:  langkah(), behavior: 'smooth' }); });

    // tombol panah keyboard
    jalur.addEventListener('keydown', function (e) {
      if (e.key === 'ArrowLeft')  { e.preventDefault(); jalur.scrollBy({ left: -langkah(), behavior: 'smooth' }); }
      if (e.key === 'ArrowRight') { e.preventDefault(); jalur.scrollBy({ left:  langkah(), behavior: 'smooth' }); }
    });

    // seret dengan tetikus (di layar sentuh sudah otomatis bisa digeser)
    var menyeret = false, mulaiX = 0, mulaiGulir = 0, bergerak = false;
    jalur.addEventListener('mousedown', function (e) {
      if (e.button !== 0) return;
      menyeret = true; bergerak = false;
      mulaiX = e.pageX; mulaiGulir = jalur.scrollLeft;
    });
    window.addEventListener('mouseup', function () {
      if (!menyeret) return;
      menyeret = false;
      jalur.classList.remove('menyeret');
    });
    window.addEventListener('mousemove', function (e) {
      if (!menyeret) return;
      var selisih = e.pageX - mulaiX;
      if (!bergerak && Math.abs(selisih) > 5) { bergerak = true; jalur.classList.add('menyeret'); }
      if (bergerak) jalur.scrollLeft = mulaiGulir - selisih;
    });
    // supaya klik tidak ikut terpicu setelah diseret
    jalur.addEventListener('click', function (e) {
      if (bergerak) { e.preventDefault(); e.stopPropagation(); bergerak = false; }
    }, true);
  });

  /* ------------------------------------------------------------------
   * 5b. KARTU YANG BISA DIBALIK (fasilitas & ekstrakurikuler)
   * Nama kegiatan/fasilitas tampil dulu; keterangannya baru muncul
   * kalau kartu disentuh atau ditekan Enter/spasi (untuk HP dan
   * keyboard, karena :hover saja tidak berlaku di layar sentuh).
   * ---------------------------------------------------------------- */
  $$('[data-balik]').forEach(function (kartu) {
    var balikkan = function (e) {
      if (e) { e.preventDefault(); }
      kartu.classList.toggle('terbuka');
    };
    kartu.addEventListener('click', balikkan);
    kartu.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' || e.key === ' ') { balikkan(e); }
    });
  });

  /* ------------------------------------------------------------------
   * 6. KOTAK PERBESAR GAMBAR (lightbox)
   * ---------------------------------------------------------------- */
  var lightbox     = $('#lightbox');
  var lbImg        = $('#lightboxImg');
  var lbJudul      = $('#lightboxJudul');
  var lbKet        = $('#lightboxKet');
  var lbTutup      = $('#lightboxTutup');
  var lbKiri       = $('#lightboxKiri');
  var lbKanan      = $('#lightboxKanan');
  var daftarZoom   = $$('[data-zoom]');
  var indeksAktif  = 0;

  // panah kiri/kanan hanya berpindah di antara foto satu bagian
  // (misalnya sesama foto galeri), tidak loncat ke bagian lain
  function kelompokZoom(i) {
    var asal = daftarZoom[i] && daftarZoom[i].closest('section');
    return daftarZoom.map(function (el, n) { return { el: el, n: n }; })
      .filter(function (o) { return o.el.closest('section') === asal; })
      .map(function (o) { return o.n; });
  }
  function geserZoom(arah) {
    var kel = kelompokZoom(indeksAktif);
    var posisi = kel.indexOf(indeksAktif);
    tampilkanZoom(kel[(posisi + arah + kel.length) % kel.length]);
  }

  function tampilkanZoom(i) {
    if (!lightbox || daftarZoom.length === 0) return;
    indeksAktif = (i + daftarZoom.length) % daftarZoom.length;
    var el  = daftarZoom[indeksAktif];
    var src = el.getAttribute('data-zoom-gambar');

    lbJudul.textContent = el.getAttribute('data-zoom-judul') || '';
    lbKet.textContent   = el.getAttribute('data-zoom-ket')   || '';

    if (src) {
      lbImg.src = src;
      lbImg.alt = el.getAttribute('data-zoom-judul') || '';
      lbImg.style.display = '';
    } else {
      // datanya belum punya foto, tampilkan keterangan saja
      lbImg.removeAttribute('src');
      lbImg.style.display = 'none';
      lbKet.textContent = (lbKet.textContent ? lbKet.textContent + ' — ' : '') +
        'Foto belum diunggah. Tambahkan lewat halaman admin.';
    }

    lightbox.hidden = false;
    document.body.style.overflow = 'hidden';
  }
  function tutupZoom() {
    if (!lightbox) return;
    lightbox.hidden = true;
    document.body.style.overflow = '';
  }

  daftarZoom.forEach(function (el, i) {
    el.addEventListener('click', function (e) {
      e.preventDefault();
      tampilkanZoom(i);
    });
    el.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); tampilkanZoom(i); }
    });
  });

  if (lbTutup) lbTutup.addEventListener('click', tutupZoom);
  if (lbKiri)  lbKiri.addEventListener('click',  function () { geserZoom(-1); });
  if (lbKanan) lbKanan.addEventListener('click', function () { geserZoom(1); });
  if (lightbox) lightbox.addEventListener('click', function (e) { if (e.target === lightbox) tutupZoom(); });

  /* ------------------------------------------------------------------
   * 6b. TAB VISI & MISI
   * Klik tombol Visi atau Misi, isi di bawahnya berganti.
   * ---------------------------------------------------------------- */
  $$('.vm').forEach(function (kotak) {
    var tombol = $$('[data-vm-btn]', kotak);
    var konten = $$('[data-vm-konten]', kotak);

    function pilihTab(nama) {
      tombol.forEach(function (b) {
        var aktif = b.getAttribute('data-vm-btn') === nama;
        b.classList.toggle('vm__btn--aktif', aktif);
        b.setAttribute('aria-selected', aktif ? 'true' : 'false');
      });
      konten.forEach(function (k) {
        var aktif = k.getAttribute('data-vm-konten') === nama;
        k.hidden = !aktif;
        k.classList.toggle('vm__konten--aktif', aktif);
      });
    }

    tombol.forEach(function (b) {
      b.addEventListener('click', function () {
        pilihTab(b.getAttribute('data-vm-btn'));
      });
    });
  });

  /* ------------------------------------------------------------------
   * 7. KOTAK KERJA SAMA (halaman jurusan)
   * Kotak ini terbuka waktu halaman dimuat. Klik judulnya untuk
   * menutup / membuka lagi. Tombol hijau di atasnya membuka kotak
   * (kalau sedang tertutup) lalu menggulir halaman ke sana.
   * ---------------------------------------------------------------- */
  var kotakKerja  = $('#kerjaSama');
  var kepalaKerja = $('#kerjaKepala');
  var isiKerja    = $('#kerjaIsi');
  var tombolKerja = $('#tombolKerjasama');

  function aturKerja(buka) {
    if (!kotakKerja || !kepalaKerja || !isiKerja) return;
    kotakKerja.classList.toggle('tutup', !buka);
    kepalaKerja.setAttribute('aria-expanded', buka ? 'true' : 'false');
    // supaya tautan di dalam kotak yang tertutup tidak ikut terfokus lewat keyboard
    if ('inert' in isiKerja) isiKerja.inert = !buka;
  }
  // Kerja sama sengaja tertutup saat halaman pertama dibuka.
  if (kotakKerja) aturKerja(false);

  if (kepalaKerja) {
    kepalaKerja.addEventListener('click', function () {
      aturKerja(kotakKerja.classList.contains('tutup'));
    });
  }
  if (tombolKerja && kotakKerja) {
    tombolKerja.addEventListener('click', function () {
      aturKerja(true);
      kotakKerja.scrollIntoView({ behavior: kurangiGerak ? 'auto' : 'smooth', block: 'start' });
    });
  }

  /* ------------------------------------------------------------------
   * VISI / MISI — tampil satu panel setelah diklik
   * ------------------------------------------------------------------ */
  document.querySelectorAll('[data-vm-tab]').forEach(function (tab) {
    tab.addEventListener('click', function () {
      const pilihan = tab.getAttribute('data-vm-tab');
      document.querySelectorAll('[data-vm-tab]').forEach(function (b) {
        const aktif = b.getAttribute('data-vm-tab') === pilihan;
        b.classList.toggle('aktif', aktif);
        b.setAttribute('aria-selected', aktif ? 'true' : 'false');
      });
      document.querySelectorAll('.vm-card[role="tabpanel"]').forEach(function (panel) {
        const aktif = panel.id === 'panel-' + pilihan;
        panel.hidden = !aktif;
        panel.classList.toggle('vm-aktif', aktif);
      });
    });
  });

  /* ------------------------------------------------------------------
   * 8. TOMBOL ESC menutup semua kotak yang terbuka
   * ---------------------------------------------------------------- */
  document.addEventListener('keydown', function (e) {
    if (e.key !== 'Escape') return;
    if (lightbox   && !lightbox.hidden)   tutupZoom();
    if (kotakCari  && !kotakCari.hidden)  tutupPanelCari();
  });

  /* ------------------------------------------------------------------
   * 9. Panah kiri/kanan untuk berpindah gambar saat lightbox terbuka
   * ---------------------------------------------------------------- */
  document.addEventListener('keydown', function (e) {
    if (!lightbox || lightbox.hidden) return;
    if (e.key === 'ArrowLeft')  geserZoom(-1);
    if (e.key === 'ArrowRight') geserZoom(1);
  });

})();

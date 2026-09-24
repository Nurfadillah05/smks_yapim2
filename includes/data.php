<?php
/* =====================================================================
 * DATA SEKOLAH (bagian yang jarang berubah)
 * Semua tulisan di beranda yang bukan dari database ada di file ini,
 * jadi kalau mau ganti kalimat tinggal edit di sini saja.
 * ===================================================================== */

$sekolah = [
    'nama'       => 'SMKS Indonesia Membangun 2 Medan',
    'sub_nama'   => 'SMK Bisnis Manajemen dan Pariwisata YAPIM Medan',
    'singkat'    => 'SMK YAPIM 2 MEDAN',
    'akreditasi' => 'A',
    'alamat'     => 'Jl. Air Bersih No. 59, Medan Kota',
    'maps'       => 'https://www.google.com/maps/search/?api=1&query=Jl.+Air+Bersih+No.+59+Medan+Kota',
    'maps_embed' => 'https://maps.google.com/maps?q=Jl.%20Air%20Bersih%20No.%2059%20Medan%20Kota&t=&z=16&ie=UTF8&iwloc=&output=embed',
    'telepon'    => ['061 7864 701', '061 7864 702'],
    'email'      => 'Smk_bmpar@yahoo.com',
    'ig_user'    => 'SMK_BM_PAR_YAPIMEDAN',
    'ig_link'    => 'https://www.instagram.com/smk_bm_par_yapimedan/',
    'motto'      => 'Unggul dalam prestasi, bersama kita bisa, YAPIM TARUNA JAYA!!!',
    'visi'       => 'Menjadi lembaga pendidikan swasta unggul untuk meningkatkan kwalitas sumber daya manusia yang mampu menghadapi tantangan zaman yang selalu berubah.',
    'misi'       => 'Mendidik siswa mengembangkan potensi agar dapat berpikir kreatif dan kritis sehingga memiliki kecerdasan intelektual, emosional dan sosial.',
];

/* ---------------------------------------------------------------------
 * Rincian Visi (10 poin) dan Misi (11 poin)
 * Dipakai di sections/visimisi.php dengan tampilan accordion
 * (klik Visi atau Misi, baru daftarnya muncul), jadi walaupun poinnya
 * banyak, tampilan di layar tetap rapi.
 * ------------------------------------------------------------------- */
$visi_poin = [
    'Beriman dan bertakwa',
    'Berkarakter dan berkewargaan',
    'Kompeten',
    'Kritis',
    'Kreatif',
    'Kolaboratif',
    'Mandiri',
    'Sehat',
    'Komunikatif',
    'Siap bekerja, melanjutkan pendidikan, dan berwirausaha',
];

$misi_poin = [
    'Menyelenggarakan pembelajaran yang berpusat pada peserta didik',
    'Menerapkan Pembelajaran Mendalam',
    'Meningkatkan kemampuan literasi dan numerasi peserta didik',
    'Mengembangkan delapan dimensi Profil Lulusan',
    'Meningkatkan kompetensi kejuruan peserta didik',
    'Memperkuat link and match dengan dunia usaha, dunia industri, dan dunia kerja',
    'Membangun budaya kerja profesional',
    'Meningkatkan kompetensi dan profesionalisme pendidik',
    'Menciptakan lingkungan sekolah yang aman, nyaman, sehat, inklusif, dan berbudaya positif',
    'Mengembangkan budaya kewirausahaan dan inovasi',
    'Melaksanakan evaluasi dan perbaikan kurikulum secara berkelanjutan dengan menggunakan data Rapor Pendidikan, hasil asesmen, hasil PKL, masukan peserta didik, guru, orang tua, komite sekolah, dan mitra dunia kerja.',
];

/* ---------------------------------------------------------------------
 * Kepala sekolah — sambutan bersifat umum (tidak menggunakan salam agama)
 * ------------------------------------------------------------------- */
$kepsek = [
    'nama'    => 'Vera Panjaitan, S.P, M.Pd',
    'jabatan' => 'Kepala Sekolah',
    'foto'    => 'assets/img/kepala-sekolah.png',
    'salam'   => 'Salam sejahtera bagi kita semua.',
    'paragraf' => [
        'Terima kasih sudah berkunjung ke laman resmi SMKS Indonesia Membangun 2 Medan. Sekolah kami hadir untuk menyiapkan lulusan yang kompeten, berkarakter, dan siap bekerja maupun melanjutkan pendidikan.',
        'Melalui dua program keahlian, Akuntansi dan Administrasi Perkantoran, siswa belajar melalui teori dan praktik nyata dengan didampingi guru yang berpengalaman di bidangnya.',
        'Kami percaya setiap anak punya potensi. Tugas kami menumbuhkannya. Selamat bergabung, dan mari bertumbuh bersama di YAPIM.',
    ],
];

/* ---------------------------------------------------------------------
 * Empat keunggulan di bawah hero
 * ------------------------------------------------------------------- */
$keunggulan = [
    ['icon' => 'topi',    'judul' => 'Kompeten',   'sub' => '& Profesional'],
    ['icon' => 'bintang', 'judul' => 'Berkarakter','sub' => '& Berakhlak'],
    ['icon' => 'koper',   'judul' => 'Siap Kerja', 'sub' => '& Berwirausaha'],
    ['icon' => 'globe',   'judul' => 'Berwawasan', 'sub' => 'Global'],
];

/* ---------------------------------------------------------------------
 * Program keahlian + foto kegiatan + mitra industri
 * slug dipakai di alamat: jurusan.php?j=akuntansi
 * ------------------------------------------------------------------- */
$jurusan = [
    'akuntansi' => [
        'nama'      => 'Akuntansi',
        'nama_polos'=> 'Akuntansi',
        'tagline'   => 'Cermat mengelola angka, rapi mengelola kantor.',
        'warna'     => '#1c4d9c',
        'cover'     => 'assets/img/jurusan-akuntansi.png',

        /* ---- tampilan baru (kartu beranda + halaman detail jurusan) ---- */
        'judul'      => 'Akuntansi (AK)',
        'ikon'       => 'kalkulator',
        'ikon_mitra' => 'bank',
        // warna kartu di beranda: utama, gelap, terang
        'kartu'      => ['utama' => '#0f3c82', 'gelap' => '#08214a', 'terang' => '#dbe6f8'],
        // warna halaman detail: utama, gelap, terang, pucat
        'tema'       => ['utama' => '#12a15a', 'gelap' => '#0a7d44', 'terang' => '#d5f1df', 'pucat' => '#eef9f2'],
        'sub'        => 'Teliti dalam Angka, Siap untuk Masa Depan',
        'uraian'     => 'Jurusan Akuntansi membekali siswa dengan keterampilan pencatatan, pengelolaan, dan pelaporan keuangan yang sesuai dengan dunia kerja. Melalui pembelajaran teori dan praktik, siswa dilatih untuk teliti, disiplin, dan mampu menggunakan aplikasi akuntansi modern.',
        'kerjasama' => [
            'tombol'  => 'Lihat Kerja Sama dengan PT',
            'judul'   => 'Kerja Sama Dunia Usaha & Industri',
            'sub'     => 'Jurusan Akuntansi',
            'catatan' => 'Kerja sama ini membuka peluang praktik, pelatihan, kunjungan industri, dan pengembangan kompetensi yang selaras dengan kebutuhan dunia kerja.',
        ],
        'deskripsi' => 'Program keahlian Akuntansi membekali siswa dengan kemampuan menyusun laporan keuangan, mengoperasikan aplikasi akuntansi, mengelola arsip, serta melayani administrasi perkantoran sesuai standar dunia kerja.',
        'kegiatan'  => [
            [
                'foto'      => 'assets/img/kegiatan/ak-1.jpg',
                'judul'     => 'Praktik siklus akuntansi',
                'deskripsi' => 'Siswa menyusun jurnal, buku besar, sampai laporan keuangan perusahaan dagang secara manual dan digital.',
            ],
            [
                'foto'      => 'assets/img/kegiatan/ak-2.png',
                'judul'     => 'Laboratorium komputer akuntansi',
                'deskripsi' => 'Latihan mengolah data keuangan memakai aplikasi akuntansi dan spreadsheet yang dipakai perusahaan.',
            ],
            [
                'foto'      => 'assets/img/kegiatan/ak-3.png',
                'judul'     => 'Simulasi kantor dan kearsipan',
                'deskripsi' => 'Praktik menerima tamu, menangani surat masuk dan keluar, serta menata arsip di ruang praktik perkantoran.',
            ],
            [
                'foto'      => 'assets/img/kegiatan/ak-4.jpg',
                'judul'     => 'Praktik kerja lapangan',
                'deskripsi' => 'Siswa magang di perusahaan mitra untuk merasakan langsung ritme kerja bagian keuangan dan administrasi.',
            ],
        ],
        'mitra' => [
            ['nama' => 'PT Hotel Emerald Garden',      'link' => 'https://www.google.com/search?q=Hotel+Emerald+Garden+Medan'],
            ['nama' => 'PT Tolan Tiga Indonesia',      'link' => 'https://www.google.com/search?q=PT+Tolan+Tiga+Indonesia'],
            ['nama' => 'PT Mitra Telekomunikasi',      'link' => 'https://www.google.com/search?q=PT+Mitra+Telekomunikasi+Medan'],
            ['nama' => 'PT Torganda',                  'link' => 'https://www.google.com/search?q=PT+Torganda'],
            ['nama' => 'Hotel Savadia',                'link' => 'https://www.google.com/search?q=Hotel+Savadia+Medan'],
            ['nama' => 'PT Ramayana Lestari Sentosa Tbk', 'link' => 'https://www.google.com/search?q=PT+Ramayana+Lestari+Sentosa+Tbk'],
            ['nama' => 'PT Astra International Tbk',   'link' => 'https://www.google.com/search?q=PT+Astra+International+Tbk'],
        ],
    ],

    'administrasi-perkantoran' => [
        'nama'      => 'Administrasi Perkantoran',
        'nama_polos'=> 'Administrasi Perkantoran',
        'tagline'   => 'Terampil mengelola administrasi, siap memasuki dunia kerja.',
        'warna'     => '#1b58b8',
        'cover'     => 'assets/img/kegiatan/ak-3.png',
        'judul'     => 'Administrasi Perkantoran',
        'ikon'      => 'admin',
        'ikon_mitra' => 'admin',
        'kartu'     => ['utama' => '#1b58b8', 'gelap' => '#0b2f6a', 'terang' => '#dbe9fb'],
        'tema'      => ['utama' => '#1b58b8', 'gelap' => '#0d3c86', 'terang' => '#dbe9fb', 'pucat' => '#eef5fd'],
        'sub'       => 'Rapi Mengelola Administrasi, Siap Berkarya',
        'uraian'    => 'Program keahlian Administrasi Perkantoran membekali siswa dengan keterampilan pengelolaan dokumen, surat-menyurat, arsip, pelayanan tamu, dan penggunaan aplikasi perkantoran sesuai kebutuhan dunia kerja.',
        'kerjasama' => [
            'tombol'  => 'Lihat Kerja Sama Dunia Usaha & Industri',
            'judul'   => 'Kerja Sama Dunia Usaha & Industri',
            'sub'     => 'Jurusan Administrasi Perkantoran',
            'catatan' => 'Kerja sama diarahkan untuk mendukung praktik, kunjungan industri, pelatihan, dan penguatan kompetensi administrasi sesuai kebutuhan dunia kerja.',
        ],
        'deskripsi' => 'Program keahlian Administrasi Perkantoran melatih siswa mengelola arsip, surat, dokumen, pelayanan tamu, dan pekerjaan administrasi dengan memanfaatkan teknologi perkantoran.',
        'kegiatan' => [
            ['foto'=>'assets/img/kegiatan/ak-3.png','judul'=>'Simulasi kantor','deskripsi'=>'Praktik pelayanan tamu, komunikasi, dan alur kerja administrasi kantor.'],
            ['foto'=>'assets/img/kegiatan/ak-2.png','judul'=>'Aplikasi perkantoran','deskripsi'=>'Latihan mengolah dokumen, data, dan administrasi digital menggunakan komputer.'],
            ['foto'=>'assets/img/kegiatan/ak-1.jpg','judul'=>'Pengelolaan dokumen','deskripsi'=>'Latihan menyusun surat, dokumen, dan arsip secara rapi dan sistematis.'],
            ['foto'=>'assets/img/kegiatan/ak-4.jpg','judul'=>'Praktik kerja lapangan','deskripsi'=>'Pengalaman kerja langsung untuk memahami budaya kerja profesional dan pelayanan administrasi.'],
        ],
        'mitra' => [
            ['nama'=>'PT Tolan Tiga Indonesia','link'=>'https://www.google.com/search?q=PT+Tolan+Tiga+Indonesia'],
            ['nama'=>'PT Mitra Telekomunikasi','link'=>'https://www.google.com/search?q=PT+Mitra+Telekomunikasi+Medan'],
            ['nama'=>'PT Torganda','link'=>'https://www.google.com/search?q=PT+Torganda'],
            ['nama'=>'PT Ramayana Lestari Sentosa Tbk','link'=>'https://www.google.com/search?q=PT+Ramayana+Lestari+Sentosa+Tbk'],
            ['nama'=>'PT Astra International Tbk','link'=>'https://www.google.com/search?q=PT+Astra+International+Tbk'],
        ],
    ],
];

/* ---------------------------------------------------------------------
 * Fasilitas (tampil sebagai ikon)
 * ------------------------------------------------------------------- */
$fasilitas = [
    ['icon' => 'kalkulator','nama' => 'Ruang Praktik Akuntansi & Perkantoran', 'ket' => 'Simulasi kantor lengkap dengan perangkat kearsipan.'],
    ['icon' => 'komputer',  'nama' => 'Laboratorium Komputer', 'ket' => 'Unit komputer untuk praktik aplikasi perkantoran dan akuntansi.'],
    ['icon' => 'hotel',     'nama' => 'Hotel Mini YAPIM',      'ket' => 'Kamar praktik housekeeping dan front office.'],
    ['icon' => 'lobby',     'nama' => 'Lobby',                 'ket' => 'Ruang penerimaan tamu sekaligus tempat praktik pelayanan.'],
    ['icon' => 'kelas',     'nama' => 'Ruang Kelas',           'ket' => 'Kelas yang terang dan nyaman untuk belajar teori.'],
    ['icon' => 'guru',      'nama' => 'Ruang Guru',            'ket' => 'Tempat konsultasi siswa dengan wali kelas dan guru mapel.'],
    ['icon' => 'basket',    'nama' => 'Lapangan Basket',       'ket' => 'Sarana olahraga sekaligus lapangan upacara.'],
    ['icon' => 'kantin',    'nama' => 'Kantin',                'ket' => 'Kantin sekolah dengan menu sehat dan harga pelajar.'],
];

/* ---------------------------------------------------------------------
 * Struktur organisasi
 * ------------------------------------------------------------------- */
$struktur = [
    'kepala'  => ['jabatan' => 'Kepala Sekolah',        'nama' => 'Vera Panjaitan, S.P, M.Pd'],
    'wakil'   => ['jabatan' => 'Wakil Kepala Sekolah',  'nama' => 'Elfrida Siagian, S.Pd'],
    'program' => [
        ['jabatan' => 'Kepala Program Jurusan<br>Akuntansi', 'nama' => 'Dra. Lasmaida Manurung'],
        ['jabatan' => 'Kepala Program Jurusan<br>Administrasi Perkantoran',        'nama' => 'Agustiani Sumbarwati'],
    ],
];

/* ---------------------------------------------------------------------
 * Ekstrakurikuler (tampil sebagai kartu yang bisa digeser)
 * Mau menambah? Salin satu baris, ganti icon, nama, dan ket.
 * Nama icon yang tersedia ada di includes/ikon.php
 * ------------------------------------------------------------------- */
$ekstrakurikuler = [
    ['icon' => 'karate',  'nama' => 'Karate',            'ket' => 'Melatih teknik bela diri, disiplin, dan rasa percaya diri.'],
    ['icon' => 'futsal',  'nama' => 'Futsal',            'ket' => 'Latihan rutin untuk kerja sama tim, kecepatan, dan sportivitas.'],
    ['icon' => 'voli',    'nama' => 'Voli',              'ket' => 'Melatih kekompakan, ketangkasan, dan semangat bertanding.'],
    ['icon' => 'tari',    'nama' => 'Tari',              'ket' => 'Melestarikan seni gerak dan melatih keberanian tampil di depan umum.'],
    ['icon' => 'dance',   'nama' => 'Dance',             'ket' => 'Wadah menyalurkan kreativitas lewat gerak dan musik.'],
    ['icon' => 'pmr',     'nama' => 'PMR',               'ket' => 'Belajar pertolongan pertama, kepedulian, dan kerja sosial.'],
    ['icon' => 'profil',  'nama' => 'Organisasi Siswa',  'ket' => 'Melatih kepemimpinan, kerja sama, tanggung jawab, dan komunikasi.'],
    ['icon' => 'jurusan', 'nama' => 'Kegiatan Kejuruan', 'ket' => 'Kegiatan pendukung pembelajaran yang berkaitan dengan kompetensi keahlian.'],
];

<?php
/* =====================================================================
 * IKON SVG
 * Dipanggil dengan: <?= ikon('beranda') ?>
 * Semua ikon digambar langsung di halaman, jadi tetap muncul walau
 * komputer tidak terhubung internet.
 * ===================================================================== */

function ikon($nama, $ukuran = 20)
{
    $p = [
        // --- menu utama -------------------------------------------------
        'beranda'   => '<path d="M3 10.5 12 3l9 7.5"/><path d="M5 9.8V20a1 1 0 0 0 1 1h4v-6h4v6h4a1 1 0 0 0 1-1V9.8"/>',
        'profil'    => '<circle cx="9" cy="8" r="3.2"/><path d="M2.5 20c.6-3.6 3.3-5.5 6.5-5.5s5.9 1.9 6.5 5.5"/><path d="M17 5.5a3 3 0 0 1 0 5.6"/><path d="M18.4 20c-.2-1.6-.7-2.9-1.5-3.9"/>',
        'visi'      => '<circle cx="12" cy="12" r="8.5"/><circle cx="12" cy="12" r="4"/><circle cx="12" cy="12" r="1.2" fill="currentColor"/>',
        'fasilitas' => '<path d="M3 20h18"/><path d="M5 20V9l7-5 7 5v11"/><path d="M10 20v-5h4v5"/>',
        'galeri'    => '<rect x="3" y="4.5" width="18" height="15" rx="2.5"/><circle cx="8.5" cy="10" r="1.6"/><path d="m4 17 4.5-4.2 3.4 3.1 3-2.7L20 17"/>',
        'prestasi'  => '<path d="M8 3h8v5a4 4 0 0 1-8 0Z"/><path d="M8 4.5H5.5V6a3 3 0 0 0 3 3"/><path d="M16 4.5h2.5V6a3 3 0 0 1-3 3"/><path d="M12 12v4"/><path d="M8.5 21h7l-1-4h-5Z"/>',
        'kontak'    => '<path d="M6.5 3.5h2l1.6 3.8-1.7 1.4a12.5 12.5 0 0 0 6 6l1.4-1.7 3.8 1.6v2a2 2 0 0 1-2.2 2C10.5 18 6 13.5 4.5 5.7a2 2 0 0 1 2-2.2Z"/>',
        'jurusan'   => '<path d="m12 4 9 4.2-9 4.2-9-4.2Z"/><path d="M6.5 10v4.6c0 1.6 2.6 2.9 5.5 2.9s5.5-1.3 5.5-2.9V10"/><path d="M21 8.2v5"/>',
        'admin'     => '<path d="M12 3.2 5 6v5.2c0 4.3 2.9 8.1 7 9.6 4.1-1.5 7-5.3 7-9.6V6Z"/><path d="m9.2 12.2 2 2 3.6-3.8"/>',
        'cari'      => '<circle cx="11" cy="11" r="6.5"/><path d="m16 16 4.5 4.5"/>',
        'tutup'     => '<path d="m6 6 12 12M18 6 6 18"/>',
        'panah_bawah'=> '<path d="M12 4.5v14"/><path d="m6 13 6 6 6-6"/>',
        'panah_kanan'=> '<path d="M4.5 12h14"/><path d="m13 6 6 6-6 6"/>',
        'panah_kiri' => '<path d="M19.5 12h-14"/><path d="m11 6-6 6 6 6"/>',
        'panah_atas' => '<path d="M12 19.5v-14"/><path d="m6 11 6-6 6 6"/>',
        'plus'      => '<path d="M12 5v14M5 12h14"/>',
        'pensil'    => '<path d="M4 20h4L19 9a2.1 2.1 0 0 0-3-3L5 17Z"/><path d="m14.5 6.5 3 3"/>',
        'hapus'     => '<path d="M4.5 6.5h15"/><path d="M9 6.5V4.8A1.3 1.3 0 0 1 10.3 3.5h3.4A1.3 1.3 0 0 1 15 4.8v1.7"/><path d="M6.5 6.5 7.4 20a1.3 1.3 0 0 0 1.3 1.2h6.6A1.3 1.3 0 0 0 16.6 20l.9-13.5"/>',
        'keluar'    => '<path d="M14.5 7.5V5.2a1.7 1.7 0 0 0-1.7-1.7H5.7A1.7 1.7 0 0 0 4 5.2v13.6a1.7 1.7 0 0 0 1.7 1.7h7.1a1.7 1.7 0 0 0 1.7-1.7v-2.3"/><path d="M9.5 12h11"/><path d="m17 8.5 3.5 3.5L17 15.5"/>',
        'foto'      => '<rect x="3" y="5.5" width="18" height="13" rx="2.5"/><circle cx="12" cy="12" r="3.3"/>',
        'zoom'      => '<circle cx="11" cy="11" r="6.5"/><path d="m16 16 4.5 4.5"/><path d="M8.5 11h5M11 8.5v5"/>',
        'link'      => '<path d="M10 13.8a4 4 0 0 0 5.7 0l2.6-2.6a4 4 0 0 0-5.7-5.7l-1.2 1.2"/><path d="M14 10.2a4 4 0 0 0-5.7 0l-2.6 2.6a4 4 0 0 0 5.7 5.7l1.2-1.2"/>',
        'mail'      => '<rect x="3" y="5.5" width="18" height="13" rx="2.5"/><path d="m4 7 8 5.6L20 7"/>',
        'telepon'   => '<path d="M6.5 3.5h2l1.6 3.8-1.7 1.4a12.5 12.5 0 0 0 6 6l1.4-1.7 3.8 1.6v2a2 2 0 0 1-2.2 2C10.5 18 6 13.5 4.5 5.7a2 2 0 0 1 2-2.2Z"/>',
        'pin'       => '<path d="M12 21s7-5.6 7-11a7 7 0 1 0-14 0c0 5.4 7 11 7 11Z"/><circle cx="12" cy="10" r="2.6"/>',
        'instagram' => '<rect x="3.5" y="3.5" width="17" height="17" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17" cy="7" r="1.1" fill="currentColor" stroke="none"/>',
        'play'      => '<circle cx="12" cy="12" r="9"/><path d="m10 8.5 6 3.5-6 3.5Z"/>',
        'sekolah'   => '<path d="M3 20.5h18"/><path d="M5 20.5V10l7-4.5 7 4.5v10.5"/><path d="M10 20.5V15h4v5.5"/><path d="M12 5.5V3"/>',

        // --- keunggulan hero -------------------------------------------
        'topi'      => '<path d="m12 4 9 4.2-9 4.2-9-4.2Z"/><path d="M6.5 10v4.6c0 1.6 2.6 2.9 5.5 2.9s5.5-1.3 5.5-2.9V10"/>',
        'bintang'   => '<path d="m12 3.5 2.6 5.4 5.9.8-4.3 4.1 1.1 5.9L12 16.9l-5.3 2.8 1.1-5.9-4.3-4.1 5.9-.8Z"/>',
        'koper'     => '<rect x="3" y="7.5" width="18" height="12" rx="2.5"/><path d="M9 7.5V5.8A1.8 1.8 0 0 1 10.8 4h2.4A1.8 1.8 0 0 1 15 5.8v1.7"/><path d="M3 13h18"/>',
        'globe'     => '<circle cx="12" cy="12" r="8.5"/><path d="M3.5 12h17"/><path d="M12 3.5c2.3 2.4 3.5 5.4 3.5 8.5s-1.2 6.1-3.5 8.5c-2.3-2.4-3.5-5.4-3.5-8.5S9.7 5.9 12 3.5Z"/>',

        // --- fasilitas --------------------------------------------------
        'kalkulator'=> '<rect x="5" y="3" width="14" height="18" rx="2.5"/><path d="M8 7.5h8"/><circle cx="9" cy="12" r=".9" fill="currentColor" stroke="none"/><circle cx="12" cy="12" r=".9" fill="currentColor" stroke="none"/><circle cx="15" cy="12" r=".9" fill="currentColor" stroke="none"/><circle cx="9" cy="16" r=".9" fill="currentColor" stroke="none"/><circle cx="12" cy="16" r=".9" fill="currentColor" stroke="none"/><circle cx="15" cy="16" r=".9" fill="currentColor" stroke="none"/>',
        'komputer'  => '<rect x="2.5" y="4.5" width="19" height="12" rx="2"/><path d="M8.5 20.5h7"/><path d="M12 16.5v4"/>',
        'hotel'     => '<path d="M3 20.5h18"/><path d="M4.5 20.5V5A1.5 1.5 0 0 1 6 3.5h12A1.5 1.5 0 0 1 19.5 5v15.5"/><path d="M8 7.5h2M14 7.5h2M8 11.5h2M14 11.5h2"/><path d="M10 20.5v-4h4v4"/>',
        'lobby'     => '<path d="M3 20.5h18"/><path d="M5 20.5v-6.2a2 2 0 0 1 2-2h2.5v8.2"/><path d="M9.5 16.3H5"/><path d="M14 20.5V6.5a2 2 0 0 1 2-2h1a2 2 0 0 1 2 2v14"/>',
        'kelas'     => '<rect x="3" y="4" width="18" height="11" rx="2"/><path d="M7 19.5h10"/><path d="M12 15v4.5"/><path d="M7 8h7"/><path d="M7 11h4"/>',
        'guru'      => '<circle cx="9" cy="7.5" r="3"/><path d="M3.5 19.5c.5-3.2 2.9-5 5.5-5s5 1.8 5.5 5"/><rect x="15" y="5" width="6" height="8" rx="1.2"/>',
        'basket'    => '<circle cx="12" cy="12" r="8.5"/><path d="M12 3.5v17"/><path d="M3.5 12h17"/><path d="M5.5 6c3.5 3 3.5 9 0 12"/><path d="M18.5 6c-3.5 3-3.5 9 0 12"/>',
        'kantin'    => '<path d="M6 3v7a2.5 2.5 0 0 0 5 0V3"/><path d="M8.5 12.5V21"/><path d="M17 3c-1.6 1.2-2.5 3-2.5 5.2 0 1.6.9 2.6 2.5 2.8V21"/>',

        // --- menu & ekstrakurikuler (tambahan) -------------------------
        'sejarah'   => '<path d="M3.5 12a8.5 8.5 0 1 0 2.6-6.1"/><path d="M3.5 4.5v4.2h4.2"/><path d="M12 7.8V12l2.8 1.8"/>',
        'karate'    => '<circle cx="8.5" cy="4.6" r="2"/><path d="M9 7.2 10 13"/><path d="M9.4 8.6 5.4 10.6"/><path d="M9.4 8.6 14.6 7.4"/><path d="M10 13l-2 6.8"/><path d="M10 13l8.6-1.6"/><path d="M18.6 11.4l1.4 2.4"/>',
        'futsal'    => '<circle cx="12" cy="12" r="8.5"/><path d="m12 8.3 3.4 2.5-1.3 4h-4.2l-1.3-4Z"/><path d="M12 8.3V3.6"/><path d="m15.4 10.8 4.3-1.4"/><path d="m14.1 14.8 2.7 3.6"/><path d="m9.9 14.8-2.7 3.6"/><path d="m8.6 10.8-4.3-1.4"/>',
        'voli'      => '<circle cx="12" cy="12" r="8.5"/><path d="M12 3.5c-1.3 3.3-1 6.5 1.3 9.3 1.5 1.8 3.7 3 6.6 3.4"/><path d="M4.2 9.2c3.6.1 6.4 1.4 8.3 3.5"/><path d="M8.3 19.2c.4-3 2-5.3 4.9-6.6"/>',
        'tari'      => '<circle cx="12" cy="4.8" r="2"/><path d="M12 7v5"/><path d="M12 8.6c-2.1-.3-4.4-1.6-5.6-4.2"/><path d="M12 8.6c2.1-.3 4.4-1.6 5.6-4.2"/><path d="m12 12-5 8.5h10Z"/>',
        'dance'     => '<path d="M9 17.5V6l10-2v11.5"/><circle cx="6.5" cy="17.5" r="2.5"/><circle cx="16.5" cy="15.5" r="2.5"/>',
        // --- tampilan jurusan (tambahan) ---------------------------------
        'chevron'   => '<path d="m6 9 6 6 6-6"/>',
        'bank'      => '<path d="M3 9.5 12 4l9 5.5"/><path d="M4.5 20.5h15"/><path d="M6.5 10.5v7M10 10.5v7M14 10.5v7M17.5 10.5v7"/><path d="M4 9.5h16"/>',
        'info'      => '<circle cx="12" cy="12" r="9"/><path d="M12 11v5.2"/><circle cx="12" cy="7.9" r=".9" fill="currentColor" stroke="none"/>',
        'lonceng'   => '<path d="M12 6V4.3"/><path d="M10 4.3h4"/><path d="M4.5 17.5a7.5 7.5 0 0 1 15 0"/><path d="M3 17.5h18"/><path d="M4.5 20.5h15"/>',
        'pmr'       => '<path d="M12 20.5s-7.5-4.4-7.5-10A4.3 4.3 0 0 1 12 7.6a4.3 4.3 0 0 1 7.5 2.9c0 5.6-7.5 10-7.5 10Z"/><path d="M12 10.4v4.6"/><path d="M9.7 12.7h4.6"/>',
    ];

    $isi = isset($p[$nama]) ? $p[$nama] : $p['beranda'];

    return '<svg class="ikon" width="' . (int)$ukuran . '" height="' . (int)$ukuran . '" viewBox="0 0 24 24" '
         . 'fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" '
         . 'stroke-linejoin="round" aria-hidden="true">' . $isi . '</svg>';
}


/* ---------------------------------------------------------------------
 * LOGO / INISIAL MITRA
 * Kalau ada file logo di assets/img/mitra/ dengan nama sesuai nama
 * mitra (huruf kecil, spasi jadi tanda minus), logo itu yang dipakai.
 * Contoh: "PT Astra International Tbk"  ->  pt-astra-international-tbk.png
 * Kalau belum ada, otomatis tampil kotak berisi inisial mitra.
 * ------------------------------------------------------------------- */
function slugMitra($nama)
{
    $s = strtolower(html_entity_decode((string)$nama, ENT_QUOTES, 'UTF-8'));
    $s = preg_replace('/[^a-z0-9]+/', '-', $s);
    return trim($s, '-');
}

function logoMitra($nama, $logo = '')
{
    $dir = __DIR__ . '/../assets/img/mitra/';
    if ($logo && file_exists(__DIR__ . '/../' . $logo)) {
        return $logo;
    }
    foreach (['png', 'jpg', 'jpeg', 'webp', 'svg'] as $ext) {
        $file = slugMitra($nama) . '.' . $ext;
        if (file_exists($dir . $file)) {
            return 'assets/img/mitra/' . $file;
        }
    }
    return '';
}

function inisialMitra($nama)
{
    $nama  = html_entity_decode((string)$nama, ENT_QUOTES, 'UTF-8');
    $nama  = preg_replace('/\(.*?\)/', '', $nama);
    $kata  = preg_split('/\s+/', trim($nama));
    $lewat = ['pt', 'tbk', 'hotel', 'grand', 'medan', 'cv'];
    $inti  = [];
    foreach ($kata as $k) {
        if ($k !== '' && !in_array(strtolower($k), $lewat, true)) $inti[] = $k;
    }
    if (!$inti) $inti = $kata;
    if (count($inti) === 1) {
        return strtoupper(substr($inti[0], 0, 2));
    }
    return strtoupper(substr($inti[0], 0, 1) . substr($inti[1], 0, 1));
}

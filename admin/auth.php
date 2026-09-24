<?php
/* =====================================================================
 * PENGAMAN HALAMAN ADMIN
 * File ini dipanggil paling atas di setiap halaman admin.
 * ===================================================================== */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../includes/ikon.php';

/* ---------- Pesan singkat (muncul sekali lalu hilang) ---------- */
function pesan($jenis, $teks)
{
    $_SESSION['pesan'] = ['jenis' => $jenis, 'teks' => $teks];
}
function ambilPesan()
{
    if (empty($_SESSION['pesan'])) return null;
    $p = $_SESSION['pesan'];
    unset($_SESSION['pesan']);
    return $p;
}

/* ---------- Token supaya form tidak bisa dikirim dari luar ---------- */
function token()
{
    if (empty($_SESSION['token'])) {
        $_SESSION['token'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['token'];
}
function cekToken()
{
    if (empty($_POST['token']) || empty($_SESSION['token']) || !hash_equals($_SESSION['token'], $_POST['token'])) {
        pesan('gagal', 'Sesi form sudah kedaluwarsa. Silakan coba lagi.');
        header('Location: ' . basename($_SERVER['PHP_SELF']));
        exit;
    }
}

/* ---------- Wajib login ---------- */
function wajibLogin()
{
    if (empty($_SESSION['admin_id'])) {
        header('Location: login.php');
        exit;
    }
}

/* ---------------------------------------------------------------------
 * UPLOAD GAMBAR
 * $berkas   -> $_FILES['gambar']
 * $folder   -> 'galeri' / 'prestasi' / 'instagram'
 * Hasil     -> ['ok' => true, 'nama' => 'xxx.jpg']  atau ['ok'=>false,'pesan'=>'...']
 * ------------------------------------------------------------------- */
function uploadGambar($berkas, $folder)
{
    $maksByte = 4 * 1024 * 1024;

    if (!is_array($berkas) || !isset($berkas['error'])) {
        return ['ok' => false, 'pesan' => 'kosong'];
    }

    if ((int)$berkas['error'] === UPLOAD_ERR_NO_FILE) {
        return ['ok' => false, 'pesan' => 'kosong'];
    }

    if ((int)$berkas['error'] !== UPLOAD_ERR_OK) {
        switch ((int)$berkas['error']) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                return ['ok' => false, 'pesan' => 'Upload gagal. Ukuran foto maksimal 4 MB.'];
            case UPLOAD_ERR_PARTIAL:
                return ['ok' => false, 'pesan' => 'Upload foto tidak selesai. Silakan coba lagi.'];
            case UPLOAD_ERR_NO_TMP_DIR:
                return ['ok' => false, 'pesan' => 'Upload gagal. Folder sementara PHP tidak tersedia.'];
            case UPLOAD_ERR_CANT_WRITE:
                return ['ok' => false, 'pesan' => 'Upload gagal. Server tidak dapat menulis file.'];
            case UPLOAD_ERR_EXTENSION:
                return ['ok' => false, 'pesan' => 'Upload dihentikan oleh konfigurasi server.'];
            default:
                return ['ok' => false, 'pesan' => 'Upload foto gagal. Silakan coba lagi.'];
        }
    }

    if (!isset($berkas['tmp_name'], $berkas['size'], $berkas['name'])) {
        return ['ok' => false, 'pesan' => 'Data upload tidak lengkap. Silakan pilih foto lagi.'];
    }

    if ((int)$berkas['size'] > $maksByte) {
        return ['ok' => false, 'pesan' => 'Upload gagal. Ukuran foto maksimal 4 MB.'];
    }

    if (!is_uploaded_file($berkas['tmp_name'])) {
        return ['ok' => false, 'pesan' => 'File upload tidak valid. Silakan pilih foto dari perangkat Anda.'];
    }

    $ekstensiDiizinkan = [
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png'  => 'image/png',
        'webp' => 'image/webp',
        'gif'  => 'image/gif',
    ];

    $ekstensi = strtolower(pathinfo($berkas['name'], PATHINFO_EXTENSION));
    if (!isset($ekstensiDiizinkan[$ekstensi])) {
        return ['ok' => false, 'pesan' => 'Format foto harus JPG, JPEG, PNG, WEBP, atau GIF.'];
    }

    $ukuranGambar = @getimagesize($berkas['tmp_name']);
    if ($ukuranGambar === false || empty($ukuranGambar['mime'])) {
        return ['ok' => false, 'pesan' => 'File yang dipilih bukan foto yang valid.'];
    }

    $tipe = strtolower((string)$ukuranGambar['mime']);
    if (!in_array($tipe, array_values($ekstensiDiizinkan), true)) {
        return ['ok' => false, 'pesan' => 'Tipe file gambar tidak diizinkan. Gunakan JPG, PNG, WEBP, atau GIF.'];
    }

    // Pastikan ekstensi dan MIME tidak bertentangan.
    if ($ekstensiDiizinkan[$ekstensi] !== $tipe) {
        return ['ok' => false, 'pesan' => 'Ekstensi file tidak sesuai dengan tipe gambar.'];
    }

    $tujuanFolder = __DIR__ . '/../uploads/' . $folder;
    if (!is_dir($tujuanFolder)) {
        if (!@mkdir($tujuanFolder, 0777, true) && !is_dir($tujuanFolder)) {
            return ['ok' => false, 'pesan' => 'Upload gagal. Folder uploads/' . $folder . ' tidak dapat dibuat.'];
        }
    }

    if (!is_writable($tujuanFolder)) {
        return ['ok' => false, 'pesan' => 'Upload gagal. Folder uploads/' . $folder . ' tidak dapat ditulis.'];
    }

    $kode = bin2hex(random_bytes(4));
    $namaDasar = $folder . '-' . date('Ymd-His') . '-' . $kode;

    /*
     * Optimasi hanya jika GD benar-benar tersedia.
     * Kalau GD tidak ada, file asli tetap disimpan selama <= 4 MB.
     */
    $gdTersedia = function_exists('imagecreatefromstring')
        && function_exists('imagecreatetruecolor')
        && function_exists('imagecopyresampled')
        && function_exists('imagejpeg')
        && function_exists('imagesx')
        && function_exists('imagesy')
        && function_exists('imageinterlace');

    if ($gdTersedia && $tipe !== 'image/gif') {
        $isiFile = @file_get_contents($berkas['tmp_name']);
        $sumber = $isiFile !== false ? @imagecreatefromstring($isiFile) : false;

        if ($sumber !== false) {
            $lebar = imagesx($sumber);
            $tinggi = imagesy($sumber);
            $maks = 1600;
            $skala = min(1, $maks / max($lebar, $tinggi));
            $baruLebar = max(1, (int)round($lebar * $skala));
            $baruTinggi = max(1, (int)round($tinggi * $skala));
            $tujuan = $tujuanFolder . '/' . $namaDasar . '.jpg';
            $tujuanImg = imagecreatetruecolor($baruLebar, $baruTinggi);
            $putih = imagecolorallocate($tujuanImg, 255, 255, 255);
            imagefill($tujuanImg, 0, 0, $putih);
            imagecopyresampled($tujuanImg, $sumber, 0, 0, 0, 0, $baruLebar, $baruTinggi, $lebar, $tinggi);
            imageinterlace($tujuanImg, true);
            $sukses = @imagejpeg($tujuanImg, $tujuan, 82);
            imagedestroy($tujuanImg);
            imagedestroy($sumber);

            if ($sukses && is_file($tujuan) && filesize($tujuan) > 0) {
                return ['ok' => true, 'nama' => basename($tujuan)];
            }

            if (is_file($tujuan)) {
                @unlink($tujuan);
            }
        }
    }

    // Fallback utama: simpan file asli tanpa GD.
    $ekstensiSimpan = $ekstensi === 'jpeg' ? 'jpg' : $ekstensi;
    $namaAsli = $namaDasar . '.' . $ekstensiSimpan;
    $tujuanAsli = $tujuanFolder . '/' . $namaAsli;

    if (!@move_uploaded_file($berkas['tmp_name'], $tujuanAsli)) {
        return ['ok' => false, 'pesan' => 'Upload gagal. Foto tidak dapat disimpan ke folder uploads/' . $folder . '.'];
    }

    if (!is_file($tujuanAsli) || filesize($tujuanAsli) <= 0) {
        @unlink($tujuanAsli);
        return ['ok' => false, 'pesan' => 'Upload gagal. File foto tidak ditemukan setelah disimpan.'];
    }

    return ['ok' => true, 'nama' => $namaAsli];
}

/* ---------- Hapus file gambar lama ---------- */
function hapusGambar($nama, $folder)
{
    if (empty($nama)) return;
    $jalur = __DIR__ . '/../uploads/' . $folder . '/' . $nama;
    if (is_file($jalur)) @unlink($jalur);
}

/* ---------- Alamat gambar untuk ditampilkan di halaman admin ---------- */
function gambarAdmin($nama, $folder)
{
    if (!empty($nama) && is_file(__DIR__ . '/../uploads/' . $folder . '/' . $nama)) {
        return '../uploads/' . $folder . '/' . $nama;
    }
    return '';
}

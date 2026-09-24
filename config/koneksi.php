<?php
/* =====================================================================
 * KONEKSI DATABASE (XAMPP / MySQL)
 * Kalau MySQL-mu pakai password, tinggal isi $db_pass di bawah.
 * ===================================================================== */

$db_host = 'localhost';
$db_name = 'smks_yapim2';
$db_user = 'root';
$db_pass = '';          // default XAMPP kosong

try {
    $pdo = new PDO(
        "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4",
        $db_user,
        $db_pass,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    die(
        '<div style="font-family:system-ui;padding:40px;max-width:640px;margin:60px auto;
              border-left:6px solid #c0392b;background:#fff3f2;color:#333;border-radius:8px">
            <h2 style="margin:0 0 10px">Database belum terhubung</h2>
            <p>Pastikan <b>Apache</b> dan <b>MySQL</b> di XAMPP sudah Start, lalu import file
               <code>database/smks_yapim2.sql</code> lewat phpMyAdmin.</p>
            <p style="color:#888;font-size:14px">Pesan sistem: ' . htmlspecialchars($e->getMessage()) . '</p>
         </div>'
    );
}

/* ---------------------------------------------------------------------
 * Fungsi bantuan yang dipakai di banyak file
 * ------------------------------------------------------------------- */

// Membersihkan output supaya aman dari kode berbahaya
function e($teks)
{
    return htmlspecialchars((string)$teks, ENT_QUOTES, 'UTF-8');
}

// Ambil semua baris dari sebuah tabel
function ambilSemua(PDO $pdo, $sql, $params = [])
{
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

// Ambil satu baris
function ambilSatu(PDO $pdo, $sql, $params = [])
{
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetch();
}

/* Menentukan alamat gambar.
 * - kalau kolom gambar terisi  -> ambil dari folder uploads/
 * - kalau kosong               -> pakai gambar cadangan (placeholder)        */
function gambarUpload($namaFile, $folder, $base = '')
{
    if (!empty($namaFile) && file_exists(__DIR__ . '/../uploads/' . $folder . '/' . $namaFile)) {
        return $base . 'uploads/' . $folder . '/' . $namaFile;
    }
    return '';
}

/* Hapus postingan Instagram yang sudah melewati masa tayang.
 * Tidak membutuhkan cron: pembersihan dilakukan ketika halaman/admin diakses.
 */
function bersihkanInstagramKadaluarsa(PDO $pdo, $hari = 49)
{
    $hari = max(1, (int)$hari);
    $lama = ambilSemua($pdo, "SELECT id, gambar FROM instagram WHERE created_at < (NOW() - INTERVAL {$hari} DAY)");
    if (!$lama) return;

    foreach ($lama as $row) {
        if (!empty($row['gambar'])) {
            $file = __DIR__ . '/../uploads/instagram/' . basename($row['gambar']);
            if (is_file($file)) @unlink($file);
        }
    }
    $pdo->exec("DELETE FROM instagram WHERE created_at < (NOW() - INTERVAL {$hari} DAY)");
}


// Format tanggal Indonesia
function tanggalIndo($tgl)
{
    if (empty($tgl) || $tgl === '0000-00-00') return '';
    $bulan = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli',
              'Agustus','September','Oktober','November','Desember'];
    $t = date_create($tgl);
    if (!$t) return '';
    return date_format($t, 'j') . ' ' . $bulan[(int)date_format($t, 'n')] . ' ' . date_format($t, 'Y');
}

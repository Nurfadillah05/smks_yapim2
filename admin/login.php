<?php
/* ============ HALAMAN MASUK ADMIN ============ */
require_once __DIR__ . '/auth.php';

// kalau sudah login, langsung ke dasbor
if (!empty($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

$galat = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $sandi    = $_POST['password'] ?? '';

    if ($username === '' || $sandi === '') {
        $galat = 'Isi username dan password dulu.';
    } else {
        $admin = ambilSatu($pdo, "SELECT * FROM admin WHERE username = ? LIMIT 1", [$username]);

        if ($admin && password_verify($sandi, $admin['password'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id']   = $admin['id'];
            $_SESSION['admin_nama'] = $admin['nama'];
            header('Location: index.php');
            exit;
        }
        $galat = 'Username atau password salah.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Masuk Admin | SMK YAPIM 2 Medan</title>
<link rel="icon" href="../assets/img/logo.png">
<link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="halaman-masuk">

<div class="masuk">
  <div class="masuk__kiri">
    <img src="../assets/img/logo.png" alt="Logo sekolah" class="masuk__logo" onerror="this.style.display='none'">
    <h1>Panel Admin</h1>
    <p>SMKS Indonesia Membangun 2 Medan<br><span>SMK Bisnis Manajemen dan Pariwisata YAPIM Medan</span></p>
    <ul class="masuk__daftar">
      <li><?= ikon('instagram', 17) ?> Kelola postingan Instagram</li>
      <li><?= ikon('galeri', 17) ?> Kelola foto galeri</li>
      <li><?= ikon('prestasi', 17) ?> Kelola prestasi siswa</li>
    </ul>
  </div>

  <div class="masuk__kanan">
    <h2>Masuk ke akun admin</h2>
    <p class="masuk__ket">Gunakan akun yang diberikan sekolah.</p>

    <?php if ($galat): ?>
      <div class="notif notif--gagal"><?= e($galat) ?></div>
    <?php endif; ?>

    <form method="post" autocomplete="off" class="form">
      <label class="form__baris">
        <span>Username</span>
        <input type="text" name="username" value="<?= e($_POST['username'] ?? '') ?>" required autofocus>
      </label>

      <label class="form__baris">
        <span>Password</span>
        <input type="password" name="password" id="sandi" required>
      </label>

      <label class="form__cek">
        <input type="checkbox" id="lihatSandi"> <span>Tampilkan password</span>
      </label>

      <button class="tbl tbl--utama tbl--penuh" type="submit"><?= ikon('admin', 17) ?> Masuk</button>
    </form>

    <a class="masuk__balik" href="../index.php"><?= ikon('panah_kiri', 15) ?> Kembali ke website</a>
  </div>
</div>

<script>
  document.getElementById('lihatSandi').addEventListener('change', function () {
    document.getElementById('sandi').type = this.checked ? 'text' : 'password';
  });
</script>
</body>
</html>

<?php
/* ============ KELOLA GALERI (tambah / ubah / hapus) ============ */
require_once __DIR__ . '/auth.php';
wajibLogin();

$folder = 'galeri';
$batasGaleri = 20; // batasi jumlah foto aktif agar halaman tetap ringan

/* ---------- Simpan data (tambah atau ubah) ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['aksi'] ?? '') === 'simpan') {
    cekToken();

    $id        = (int)($_POST['id'] ?? 0);
    $judul     = trim($_POST['judul'] ?? '');
    $kategori  = trim($_POST['kategori'] ?? '');
    $tanggal   = trim($_POST['tanggal'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');

    if ($judul === '') {
        pesan('gagal', 'Judul kegiatan wajib diisi.');
        header('Location: galeri.php');
        exit;
    }
    $tanggal = $tanggal !== '' ? $tanggal : null;

    if ($id === 0) {
        $jumlahSekarang = (int)($pdo->query("SELECT COUNT(*) FROM galeri")->fetchColumn() ?: 0);
        if ($jumlahSekarang >= $batasGaleri) {
            pesan('gagal', "Batas galeri sudah penuh (maksimal {$batasGaleri} foto). Hapus foto lama sebelum menambah yang baru.");
            header('Location: galeri.php');
            exit;
        }
    }

    // proses gambar
    $unggah    = uploadGambar($_FILES['gambar'] ?? null, $folder);
    $adaGambar = $unggah['ok'];
    if (!$adaGambar && $unggah['pesan'] !== 'kosong') {
        pesan('gagal', $unggah['pesan']);
        header('Location: galeri.php');
        exit;
    }

    if ($id > 0) {
        $lama = ambilSatu($pdo, "SELECT * FROM galeri WHERE id = ?", [$id]);
        if (!$lama) {
            pesan('gagal', 'Data tidak ditemukan.');
            header('Location: galeri.php');
            exit;
        }
        $namaGambar = $adaGambar ? $unggah['nama'] : $lama['gambar'];

        try {
            $stmt = $pdo->prepare("UPDATE galeri SET judul=?, kategori=?, tanggal=?, deskripsi=?, gambar=? WHERE id=?");
            $stmt->execute([$judul, $kategori, $tanggal, $deskripsi, $namaGambar, $id]);

            if ($adaGambar && $lama['gambar'] !== $namaGambar) {
                hapusGambar($lama['gambar'], $folder);
            }
            pesan('sukses', $adaGambar ? 'Foto berhasil diupload dan disimpan.' : 'Data galeri berhasil diperbarui.');
        } catch (Throwable $e) {
            if ($adaGambar) {
                hapusGambar($namaGambar, $folder);
            }
            pesan('gagal', 'Data galeri gagal disimpan. Foto lama tetap aman.');
        }
    } else {
        $namaGambar = $adaGambar ? $unggah['nama'] : '';
        try {
            $stmt = $pdo->prepare("INSERT INTO galeri (judul, kategori, tanggal, deskripsi, gambar) VALUES (?,?,?,?,?)");
            $stmt->execute([$judul, $kategori, $tanggal, $deskripsi, $namaGambar]);
            pesan('sukses', $adaGambar ? 'Foto berhasil diupload dan disimpan.' : 'Data galeri berhasil ditambahkan.');
        } catch (Throwable $e) {
            if ($adaGambar) {
                hapusGambar($namaGambar, $folder);
            }
            pesan('gagal', 'Data galeri gagal disimpan. Foto tidak dimasukkan ke database.');
        }
    }

    header('Location: galeri.php');
    exit;
}

/* ---------- Hapus data ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['aksi'] ?? '') === 'hapus') {
    cekToken();
    $id   = (int)($_POST['id'] ?? 0);
    $lama = ambilSatu($pdo, "SELECT * FROM galeri WHERE id = ?", [$id]);
    if ($lama) {
        hapusGambar($lama['gambar'], $folder);
        $pdo->prepare("DELETE FROM galeri WHERE id = ?")->execute([$id]);
        pesan('sukses', 'Foto galeri berhasil dihapus.');
    } else {
        pesan('gagal', 'Data tidak ditemukan.');
    }
    header('Location: galeri.php');
    exit;
}

/* ---------- Data untuk halaman ---------- */
$ubah = null;
if (isset($_GET['ubah'])) {
    $ubah = ambilSatu($pdo, "SELECT * FROM galeri WHERE id = ?", [(int)$_GET['ubah']]);
}
$data = ambilSemua($pdo, "SELECT * FROM galeri ORDER BY id DESC");

$judul_admin = 'Kelola Galeri';
$menu_aktif  = 'galeri';
require __DIR__ . '/inc/atas.php';
?>

<!-- ====== FORM ====== -->
<div class="panel" id="form">
  <div class="panel__kepala">
    <h2><?= $ubah ? 'Ubah foto galeri' : 'Tambah foto galeri' ?></h2>
    <?php if ($ubah): ?><a class="tbl tbl--kecil" href="galeri.php">Batal ubah</a><?php endif; ?>
  </div>

  <form method="post" enctype="multipart/form-data" class="form form--grid">
    <input type="hidden" name="token" value="<?= token() ?>">
    <input type="hidden" name="aksi"  value="simpan">
    <input type="hidden" name="id"    value="<?= $ubah ? (int)$ubah['id'] : 0 ?>">

    <label class="form__baris">
      <span>Judul kegiatan *</span>
      <input type="text" name="judul" required value="<?= e($ubah['judul'] ?? '') ?>" placeholder="Contoh: Upacara HUT RI ke-80">
    </label>

    <label class="form__baris">
      <span>Nama kegiatan pada label foto</span>
      <input type="text" name="kategori" value="<?= e($ubah['kategori'] ?? '') ?>" placeholder="Contoh: 17 Agustus">
    </label>

    <label class="form__baris">
      <span>Tanggal kegiatan</span>
      <input type="date" name="tanggal" value="<?= e($ubah['tanggal'] ?? '') ?>">
    </label>

    <label class="form__baris">
      <span>Gambar (maksimal 4 MB) <?= $ubah ? '(kosongkan kalau tidak diganti)' : '' ?></span>
      <input type="file" name="gambar" accept="image/*" data-pratinjau="pratinjauGaleri" data-maks-mb="4">
    </label>

    <label class="form__baris form__baris--lebar">
      <span>Deskripsi</span>
      <textarea name="deskripsi" rows="3" placeholder="Ceritakan singkat kegiatannya."><?= e($ubah['deskripsi'] ?? '') ?></textarea>
    </label>

    <div class="form__baris form__baris--lebar">
      <span>Pratinjau</span>
      <div class="pratinjau" id="pratinjauGaleri">
        <?php $imgUbah = $ubah ? gambarAdmin($ubah['gambar'], $folder) : ''; ?>
        <?php if ($imgUbah): ?>
          <img src="<?= e($imgUbah) ?>" alt="Pratinjau">
        <?php else: ?>
          <span class="pratinjau__kosong"><?= ikon('foto', 26) ?> Belum ada gambar dipilih</span>
        <?php endif; ?>
      </div>
    </div>

    <div class="form__aksi form__baris--lebar">
      <button class="tbl tbl--utama" type="submit"><?= ikon('plus', 17) ?> <?= $ubah ? 'Simpan perubahan' : 'Simpan' ?></button>
    </div>
  </form>
</div>

<!-- ====== DAFTAR ====== -->
<div class="panel">
  <div class="panel__kepala">
    <h2>Daftar galeri (<?= count($data) ?>)</h2>
  </div>

  <?php if (empty($data)): ?>
    <p class="hampa">Belum ada foto. Tambahkan lewat formulir di atas.</p>
  <?php else: ?>
  <div class="tabel-gulir">
    <table class="tabel">
      <thead>
        <tr><th>Foto</th><th>Judul</th><th>Label</th><th>Tanggal</th><th>Aksi</th></tr>
      </thead>
      <tbody>
        <?php foreach ($data as $d): $img = gambarAdmin($d['gambar'], $folder); ?>
        <tr>
          <td><span class="mini-foto mini-foto--besar"><?= $img ? '<img src="' . e($img) . '" alt="">' : ikon('foto', 20) ?></span></td>
          <td>
            <b><?= e($d['judul']) ?></b>
            <?php if ($d['deskripsi']): ?><small class="sel-ket"><?= e($d['deskripsi']) ?></small><?php endif; ?>
          </td>
          <td><?= e($d['kategori']) ?></td>
          <td><?= e(tanggalIndo($d['tanggal'])) ?></td>
          <td>
            <div class="aksi">
              <a class="tbl tbl--kecil" href="galeri.php?ubah=<?= (int)$d['id'] ?>#form"><?= ikon('pensil', 15) ?> Ubah</a>
              <form method="post" data-konfirmasi="Hapus foto ini dari galeri?">
                <input type="hidden" name="token" value="<?= token() ?>">
                <input type="hidden" name="aksi" value="hapus">
                <input type="hidden" name="id" value="<?= (int)$d['id'] ?>">
                <button class="tbl tbl--kecil tbl--merah" type="submit"><?= ikon('hapus', 15) ?> Hapus</button>
              </form>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</div>

<?php require __DIR__ . '/inc/bawah.php'; ?>

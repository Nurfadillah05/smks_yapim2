<?php
/* ============ KELOLA PRESTASI (tambah / ubah / hapus) ============ */
require_once __DIR__ . '/auth.php';
wajibLogin();

$folder = 'prestasi';
$batasPrestasi = 8; // cukup untuk carousel tanpa membuat beranda terlalu berat

/* ---------- Simpan ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['aksi'] ?? '') === 'simpan') {
    cekToken();

    $id         = (int)($_POST['id'] ?? 0);
    $nama_lomba = trim($_POST['nama_lomba'] ?? '');
    $juara      = trim($_POST['juara'] ?? '');
    $tingkat    = trim($_POST['tingkat'] ?? '');
    $tahun      = trim($_POST['tahun'] ?? '');
    $peraih     = trim($_POST['peraih'] ?? '');
    $deskripsi  = trim($_POST['deskripsi'] ?? '');

    if ($nama_lomba === '') {
        pesan('gagal', 'Nama lomba wajib diisi.');
        header('Location: prestasi.php');
        exit;
    }

    if ($id === 0) {
        $jumlahSekarang = (int)($pdo->query("SELECT COUNT(*) FROM prestasi")->fetchColumn() ?: 0);
        if ($jumlahSekarang >= $batasPrestasi) {
            pesan('gagal', "Batas prestasi sudah penuh (maksimal {$batasPrestasi} foto). Hapus prestasi lama sebelum menambah yang baru.");
            header('Location: prestasi.php');
            exit;
        }
    }

    $unggah    = uploadGambar($_FILES['gambar'] ?? null, $folder);
    $adaGambar = $unggah['ok'];
    if (!$adaGambar && $unggah['pesan'] !== 'kosong') {
        pesan('gagal', $unggah['pesan']);
        header('Location: prestasi.php');
        exit;
    }

    if ($id > 0) {
        $lama = ambilSatu($pdo, "SELECT * FROM prestasi WHERE id = ?", [$id]);
        if (!$lama) {
            pesan('gagal', 'Data tidak ditemukan.');
            header('Location: prestasi.php');
            exit;
        }
        $namaGambar = $adaGambar ? $unggah['nama'] : $lama['gambar'];
        try {
            $stmt = $pdo->prepare("UPDATE prestasi SET nama_lomba=?, juara=?, tingkat=?, tahun=?, peraih=?, deskripsi=?, gambar=? WHERE id=?");
            $stmt->execute([$nama_lomba, $juara, $tingkat, $tahun, $peraih, $deskripsi, $namaGambar, $id]);

            if ($adaGambar && $lama['gambar'] !== $namaGambar) {
                hapusGambar($lama['gambar'], $folder);
            }
            pesan('sukses', $adaGambar ? 'Foto berhasil diupload dan disimpan.' : 'Data prestasi berhasil diperbarui.');
        } catch (Throwable $e) {
            if ($adaGambar) {
                hapusGambar($namaGambar, $folder);
            }
            pesan('gagal', 'Data prestasi gagal disimpan. Foto lama tetap aman.');
        }
    } else {
        $namaGambar = $adaGambar ? $unggah['nama'] : '';
        try {
            $stmt = $pdo->prepare("INSERT INTO prestasi (nama_lomba, juara, tingkat, tahun, peraih, deskripsi, gambar) VALUES (?,?,?,?,?,?,?)");
            $stmt->execute([$nama_lomba, $juara, $tingkat, $tahun, $peraih, $deskripsi, $namaGambar]);
            pesan('sukses', $adaGambar ? 'Foto berhasil diupload dan disimpan.' : 'Data prestasi berhasil ditambahkan.');
        } catch (Throwable $e) {
            if ($adaGambar) {
                hapusGambar($namaGambar, $folder);
            }
            pesan('gagal', 'Data prestasi gagal disimpan. Foto tidak dimasukkan ke database.');
        }
    }

    header('Location: prestasi.php');
    exit;
}

/* ---------- Hapus ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['aksi'] ?? '') === 'hapus') {
    cekToken();
    $id   = (int)($_POST['id'] ?? 0);
    $lama = ambilSatu($pdo, "SELECT * FROM prestasi WHERE id = ?", [$id]);
    if ($lama) {
        hapusGambar($lama['gambar'], $folder);
        $pdo->prepare("DELETE FROM prestasi WHERE id = ?")->execute([$id]);
        pesan('sukses', 'Prestasi berhasil dihapus.');
    } else {
        pesan('gagal', 'Data tidak ditemukan.');
    }
    header('Location: prestasi.php');
    exit;
}

$ubah = null;
if (isset($_GET['ubah'])) {
    $ubah = ambilSatu($pdo, "SELECT * FROM prestasi WHERE id = ?", [(int)$_GET['ubah']]);
}
$data = ambilSemua($pdo, "SELECT * FROM prestasi ORDER BY id DESC");

$judul_admin = 'Kelola Prestasi';
$menu_aktif  = 'prestasi';
require __DIR__ . '/inc/atas.php';
?>

<div class="panel" id="form">
  <div class="panel__kepala">
    <h2><?= $ubah ? 'Ubah prestasi' : 'Tambah prestasi' ?></h2>
    <?php if ($ubah): ?><a class="tbl tbl--kecil" href="prestasi.php">Batal ubah</a><?php endif; ?>
  </div>
  <p class="panel__ket">Maksimal <b><?= $batasPrestasi ?> prestasi</b> agar halaman tetap ringan. Di beranda hanya 4 kartu yang terlihat sekaligus; sisanya digeser dan 2 kartu tengah otomatis dibuat lebih tinggi.</p>

  <form method="post" enctype="multipart/form-data" class="form form--grid">
    <input type="hidden" name="token" value="<?= token() ?>">
    <input type="hidden" name="aksi"  value="simpan">
    <input type="hidden" name="id"    value="<?= $ubah ? (int)$ubah['id'] : 0 ?>">

    <label class="form__baris form__baris--lebar">
      <span>Nama lomba *</span>
      <input type="text" name="nama_lomba" required value="<?= e($ubah['nama_lomba'] ?? '') ?>" placeholder="Contoh: Lomba Kompetensi Siswa (LKS) Akuntansi">
    </label>

    <label class="form__baris">
      <span>Juara</span>
      <input type="text" name="juara" value="<?= e($ubah['juara'] ?? '') ?>" placeholder="Contoh: Juara 1">
    </label>

    <label class="form__baris">
      <span>Tingkat</span>
      <input type="text" name="tingkat" value="<?= e($ubah['tingkat'] ?? '') ?>" placeholder="Contoh: Kota Medan">
    </label>

    <label class="form__baris">
      <span>Tahun</span>
      <input type="text" name="tahun" value="<?= e($ubah['tahun'] ?? '') ?>" placeholder="Contoh: 2025">
    </label>

    <label class="form__baris">
      <span>Peraih</span>
      <input type="text" name="peraih" value="<?= e($ubah['peraih'] ?? '') ?>" placeholder="Contoh: Siswa Kelas XI AK">
    </label>

    <label class="form__baris">
      <span>Gambar <?= $ubah ? '(kosongkan kalau tidak diganti)' : '' ?></span>
      <input type="file" name="gambar" accept="image/*" data-pratinjau="pratinjauPrestasi" data-maks-mb="4">
      <small class="form__hint">Format JPG/PNG/WEBP/GIF, maksimal 4 MB. Foto akan dioptimalkan hanya jika GD tersedia; jika tidak, file asli disimpan.</small>
    </label>

    <label class="form__baris form__baris--lebar">
      <span>Deskripsi</span>
      <textarea name="deskripsi" rows="3" placeholder="Keterangan singkat prestasi."><?= e($ubah['deskripsi'] ?? '') ?></textarea>
    </label>

    <div class="form__baris form__baris--lebar">
      <span>Pratinjau</span>
      <div class="pratinjau" id="pratinjauPrestasi">
        <?php $imgUbah = $ubah ? gambarAdmin($ubah['gambar'], $folder) : ''; ?>
        <?php if ($imgUbah): ?>
          <img src="<?= e($imgUbah) ?>" alt="Pratinjau">
        <?php else: ?>
          <span class="pratinjau__kosong"><?= ikon('prestasi', 26) ?> Belum ada gambar dipilih</span>
        <?php endif; ?>
      </div>
    </div>

    <div class="form__aksi form__baris--lebar">
      <button class="tbl tbl--utama" type="submit"><?= ikon('plus', 17) ?> <?= $ubah ? 'Simpan perubahan' : 'Simpan' ?></button>
    </div>
  </form>
</div>

<div class="panel">
  <div class="panel__kepala">
    <h2>Daftar prestasi (<?= count($data) ?>)</h2>
  </div>

  <?php if (empty($data)): ?>
    <p class="hampa">Belum ada prestasi. Tambahkan lewat formulir di atas.</p>
  <?php else: ?>
  <div class="tabel-gulir">
    <table class="tabel">
      <thead>
        <tr><th>Foto</th><th>Nama lomba</th><th>Juara</th><th>Tingkat</th><th>Tahun</th><th>Aksi</th></tr>
      </thead>
      <tbody>
        <?php foreach ($data as $d): $img = gambarAdmin($d['gambar'], $folder); ?>
        <tr>
          <td><span class="mini-foto mini-foto--besar"><?= $img ? '<img src="' . e($img) . '" alt="">' : ikon('prestasi', 20) ?></span></td>
          <td>
            <b><?= e($d['nama_lomba']) ?></b>
            <?php if ($d['peraih']): ?><small class="sel-ket"><?= e($d['peraih']) ?></small><?php endif; ?>
          </td>
          <td><?= e($d['juara']) ?></td>
          <td><?= e($d['tingkat']) ?></td>
          <td><?= e($d['tahun']) ?></td>
          <td>
            <div class="aksi">
              <a class="tbl tbl--kecil" href="prestasi.php?ubah=<?= (int)$d['id'] ?>#form"><?= ikon('pensil', 15) ?> Ubah</a>
              <form method="post" data-konfirmasi="Hapus prestasi ini?">
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

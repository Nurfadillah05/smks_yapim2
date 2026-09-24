<?php
/* ============ KELOLA POSTINGAN INSTAGRAM ============
 * Semua postingan di sini tampil di beranda (bisa digeser ke samping).
 */
require_once __DIR__ . '/auth.php';
wajibLogin();

// Bersihkan otomatis postingan yang sudah lewat 7 hari.
bersihkanInstagramKadaluarsa($pdo, 7);

$folder = 'instagram';

// batas jumlah postingan aktif yang boleh tampil di beranda sekaligus,
// dan lama postingan bertahan sebelum otomatis hilang dari beranda
$batasAktifIg = 6;
$batasHariIg  = 7; // 7 hari

/* ---------- Simpan ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['aksi'] ?? '') === 'simpan') {
    cekToken();

    $id      = (int)($_POST['id'] ?? 0);
    $judul   = trim($_POST['judul'] ?? '');
    $caption = trim($_POST['caption'] ?? '');
    $link    = trim($_POST['link'] ?? '');

    if ($judul === '') {
        pesan('gagal', 'Judul postingan wajib diisi.');
        header('Location: instagram.php');
        exit;
    }
    if ($link !== '' && !filter_var($link, FILTER_VALIDATE_URL)) {
        pesan('gagal', 'Link harus berupa alamat lengkap, contohnya https://www.instagram.com/p/xxxx/');
        header('Location: instagram.php');
        exit;
    }

    // hanya postingan baru (bukan sedang mengubah) yang kena batas maksimal 6 aktif
    if ($id === 0) {
        // $batasHariIg konstanta tetap di atas (bukan input pengguna), aman disisipkan langsung
        $aktif = ambilSatu(
            $pdo,
            "SELECT COUNT(*) AS jml FROM instagram WHERE created_at >= (NOW() - INTERVAL {$batasHariIg} DAY)"
        );
        if ((int)($aktif['jml'] ?? 0) >= $batasAktifIg) {
            pesan('gagal', "Batas unggahan Instagram di beranda sudah penuh (maksimal {$batasAktifIg} postingan aktif). Hapus salah satu postingan lama, atau tunggu postingan yang sudah lewat {$batasHariIg} hari otomatis hilang dari beranda.");
            header('Location: instagram.php');
            exit;
        }
    }

    $unggah    = uploadGambar($_FILES['gambar'] ?? null, $folder);
    $adaGambar = $unggah['ok'];
    if (!$adaGambar && $unggah['pesan'] !== 'kosong') {
        pesan('gagal', $unggah['pesan']);
        header('Location: instagram.php');
        exit;
    }

    if ($id > 0) {
        $lama = ambilSatu($pdo, "SELECT * FROM instagram WHERE id = ?", [$id]);
        if (!$lama) {
            pesan('gagal', 'Data tidak ditemukan.');
            header('Location: instagram.php');
            exit;
        }
        $namaGambar = $adaGambar ? $unggah['nama'] : $lama['gambar'];
        try {
            $stmt = $pdo->prepare("UPDATE instagram SET judul=?, caption=?, link=?, gambar=? WHERE id=?");
            $stmt->execute([$judul, $caption, $link, $namaGambar, $id]);

            if ($adaGambar && $lama['gambar'] !== $namaGambar) {
                hapusGambar($lama['gambar'], $folder);
            }
            pesan('sukses', $adaGambar ? 'Foto berhasil diupload dan disimpan.' : 'Postingan berhasil diperbarui.');
        } catch (Throwable $e) {
            if ($adaGambar) {
                hapusGambar($namaGambar, $folder);
            }
            pesan('gagal', 'Postingan gagal disimpan. Foto lama tetap aman.');
        }
    } else {
        $namaGambar = $adaGambar ? $unggah['nama'] : '';
        try {
            $stmt = $pdo->prepare("INSERT INTO instagram (judul, caption, link, gambar) VALUES (?,?,?,?)");
            $stmt->execute([$judul, $caption, $link, $namaGambar]);
            pesan('sukses', $adaGambar ? 'Foto berhasil diupload dan disimpan.' : 'Postingan berhasil ditambahkan dan langsung tampil di beranda.');
        } catch (Throwable $e) {
            if ($adaGambar) {
                hapusGambar($namaGambar, $folder);
            }
            pesan('gagal', 'Postingan gagal disimpan. Foto tidak dimasukkan ke database.');
        }
    }

    header('Location: instagram.php');
    exit;
}

/* ---------- Hapus ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['aksi'] ?? '') === 'hapus') {
    cekToken();
    $id   = (int)($_POST['id'] ?? 0);
    $lama = ambilSatu($pdo, "SELECT * FROM instagram WHERE id = ?", [$id]);
    if ($lama) {
        hapusGambar($lama['gambar'], $folder);
        $pdo->prepare("DELETE FROM instagram WHERE id = ?")->execute([$id]);
        pesan('sukses', 'Postingan berhasil dihapus.');
    } else {
        pesan('gagal', 'Data tidak ditemukan.');
    }
    header('Location: instagram.php');
    exit;
}

$ubah = null;
if (isset($_GET['ubah'])) {
    $ubah = ambilSatu($pdo, "SELECT * FROM instagram WHERE id = ?", [(int)$_GET['ubah']]);
}
$data = ambilSemua($pdo, "SELECT * FROM instagram ORDER BY id DESC");

$judul_admin = 'Kelola Instagram';
$menu_aktif  = 'instagram';
require __DIR__ . '/inc/atas.php';
?>

<div class="panel" id="form">
  <div class="panel__kepala">
    <h2><?= $ubah ? 'Ubah postingan' : 'Tambah postingan' ?></h2>
    <?php if ($ubah): ?><a class="tbl tbl--kecil" href="instagram.php">Batal ubah</a><?php endif; ?>
  </div>
  <p class="panel__ket">Maksimal <b><?= $batasAktifIg ?> postingan aktif</b> sekaligus di beranda (hanya 3 kartu yang tampil sekali pandang, sisanya digeser). Postingan otomatis <b>hilang sendiri dari beranda setelah <?= $batasHariIg ?> hari (7 x 24 jam)</b> sejak diunggah — kalau ingin tetap tampil, tambahkan ulang postingannya.</p>

  <form method="post" enctype="multipart/form-data" class="form form--grid">
    <input type="hidden" name="token" value="<?= token() ?>">
    <input type="hidden" name="aksi"  value="simpan">
    <input type="hidden" name="id"    value="<?= $ubah ? (int)$ubah['id'] : 0 ?>">

    <label class="form__baris">
      <span>Judul postingan *</span>
      <input type="text" name="judul" required value="<?= e($ubah['judul'] ?? '') ?>" placeholder="Contoh: Praktik di Hotel Mini">
    </label>

    <label class="form__baris">
      <span>Link postingan Instagram</span>
      <input type="url" name="link" value="<?= e($ubah['link'] ?? '') ?>" placeholder="https://www.instagram.com/p/xxxxxxx/">
    </label>

    <label class="form__baris">
      <span>Gambar / cuplikan video <?= $ubah ? '(kosongkan kalau tidak diganti)' : '' ?></span>
      <input type="file" name="gambar" accept="image/*" data-pratinjau="pratinjauIg" data-maks-mb="4">
    </label>

    <label class="form__baris form__baris--lebar">
      <span>Caption singkat</span>
      <textarea name="caption" rows="3" placeholder="Tulisan pendek di bawah judul."><?= e($ubah['caption'] ?? '') ?></textarea>
    </label>

    <div class="form__baris form__baris--lebar">
      <span>Pratinjau</span>
      <div class="pratinjau" id="pratinjauIg">
        <?php $imgUbah = $ubah ? gambarAdmin($ubah['gambar'], $folder) : ''; ?>
        <?php if ($imgUbah): ?>
          <img src="<?= e($imgUbah) ?>" alt="Pratinjau">
        <?php else: ?>
          <span class="pratinjau__kosong"><?= ikon('instagram', 26) ?> Belum ada gambar dipilih</span>
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
    <h2>Daftar postingan (<?= count($data) ?>)</h2>
  </div>
  <p class="panel__ket">Status <span class="lencana lencana--hijau" style="padding:1px 8px">Tampil di beranda</span> berarti postingan berumur kurang dari <?= $batasHariIg ?> hari. Setelah lewat, statusnya berubah menjadi kedaluwarsa dan otomatis tidak lagi tampil di beranda (datanya tetap tersimpan di sini, tinggal hapus manual kalau memang sudah tidak diperlukan).</p>

  <?php if (empty($data)): ?>
    <p class="hampa">Belum ada postingan. Tambahkan lewat formulir di atas.</p>
  <?php else: ?>
  <div class="tabel-gulir">
    <table class="tabel">
      <thead>
        <tr><th>Gambar</th><th>Judul</th><th>Link</th><th>Status</th><th>Aksi</th></tr>
      </thead>
      <tbody>
        <?php foreach ($data as $i => $d): $img = gambarAdmin($d['gambar'], $folder); ?>
        <tr>
          <td><span class="mini-foto mini-foto--besar"><?= $img ? '<img src="' . e($img) . '" alt="">' : ikon('instagram', 20) ?></span></td>
          <td>
            <b><?= e($d['judul']) ?></b>
            <?php if ($d['caption']): ?><small class="sel-ket"><?= e($d['caption']) ?></small><?php endif; ?>
          </td>
          <td>
            <?php if ($d['link']): ?>
              <a class="tautan" href="<?= e($d['link']) ?>" target="_blank" rel="noopener"><?= ikon('link', 14) ?> Buka</a>
            <?php else: ?>
              <span class="sel-ket">—</span>
            <?php endif; ?>
          </td>
          <td>
            <?php $kedaluwarsa = (strtotime($d['created_at']) < strtotime("-{$batasHariIg} days")); ?>
            <?php if ($kedaluwarsa): ?>
              <span class="lencana lencana--merah">Kedaluwarsa (&gt;<?= $batasHariIg ?> hari)</span>
            <?php else: ?>
              <span class="lencana lencana--hijau">Tampil di beranda</span>
            <?php endif; ?>
          </td>
          <td>
            <div class="aksi">
              <a class="tbl tbl--kecil" href="instagram.php?ubah=<?= (int)$d['id'] ?>#form"><?= ikon('pensil', 15) ?> Ubah</a>
              <form method="post" data-konfirmasi="Hapus postingan ini?">
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

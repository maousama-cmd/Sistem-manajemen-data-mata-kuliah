<?php
// Nilai default: variabel normalnya dikirim oleh MataKuliahController
$errors    = $errors ?? [];
$mk        = $mk ?? ['IdMataKuliah' => 0];
$kode      = $kode ?? '';
$nama      = $nama ?? '';
$prodi     = $prodi ?? '';
$smt       = $smt ?? '';
$sks       = $sks ?? '';
$status    = $status ?? 'Aktif';
$prodiList = $prodiList ?? ['D3 Komputerisasi Akuntansi', 'D3 Manajemen Informatika', 'S1 Sistem Informasi', 'S1 Teknik Informatika', 'S1 Rekayasa Perangkat Lunak'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Edit Mata Kuliah</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="topbar">
    <div class="topbar-in">
        <span class="logo">MK</span>
        <div><strong>Manajemen Mata Kuliah</strong><small>STMIK IKMI Cirebon</small></div>
    </div>
</header>
<div class="wrap">
    <h1>Edit Mata Kuliah</h1>
    <p class="sub">Semua kolom wajib diisi.</p>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-err"><ul>
            <?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err, ENT_QUOTES, 'UTF-8') ?></li><?php endforeach; ?>
        </ul></div>
    <?php endif; ?>

    <form class="card" method="POST" action="index.php?action=edit&id=<?= (int)$mk['IdMataKuliah'] ?>">
        <input type="hidden" name="id" value="<?= (int)$mk['IdMataKuliah'] ?>">
        <div class="row">
            <div>
                <label for="kode">Kode mata kuliah</label>
                <input class="form-control" type="text" id="kode" name="kode" placeholder="Kode..." maxlength="20" required
                       value="<?= htmlspecialchars($kode, ENT_QUOTES, 'UTF-8') ?>">
            </div>
            <div>
                <label for="nama">Nama mata kuliah</label>
                <input class="form-control" type="text" id="nama" name="nama" placeholder="Nama..." maxlength="100" required
                       value="<?= htmlspecialchars($nama, ENT_QUOTES, 'UTF-8') ?>">
            </div>
        </div>

        <label for="prodi">Program Studi:</label>
        <select id="prodi" name="prodi" required class="form-control">
            <option value="">-- Pilih Program Studi --</option>
            <?php foreach ($prodiList as $p): ?>
                <option value="<?= htmlspecialchars($p, ENT_QUOTES, 'UTF-8') ?>" <?= ($prodi == $p) ? 'selected' : '' ?>><?= htmlspecialchars($p, ENT_QUOTES, 'UTF-8') ?></option>
            <?php endforeach; ?>
        </select>

        <div class="row">
            <div>
                <label for="smt">Semester (1-8)</label>
                <input class="form-control" type="number" id="smt" name="smt" min="1" max="8" required
                       value="<?= htmlspecialchars($smt, ENT_QUOTES, 'UTF-8') ?>">
            </div>
            <div>
                <label for="sks">SKS (1-6)</label>
                <input class="form-control" type="number" id="sks" name="sks" min="1" max="6" required
                       value="<?= htmlspecialchars($sks, ENT_QUOTES, 'UTF-8') ?>">
            </div>
        </div>

        <label>Status Mata Kuliah:</label>
        <div class="radio-group">
            <span><input type="radio" id="aktif" name="status" value="Aktif" <?= ($status == 'Aktif') ? 'checked' : '' ?> required>
            <label for="aktif">Aktif</label></span>
            <span><input type="radio" id="tidak_aktif" name="status" value="Tidak Aktif" <?= ($status == 'Tidak Aktif') ? 'checked' : '' ?>>
            <label for="tidak_aktif">Tidak Aktif</label></span>
        </div>

        <div class="form-actions">
            <button class="btn" type="submit">Simpan perubahan</button>
            <a class="btn btn-light" href="index.php">Batal</a>
        </div>
    </form>
</div>
</body>
</html>

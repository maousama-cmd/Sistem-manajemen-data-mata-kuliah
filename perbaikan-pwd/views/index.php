<?php
// Nilai default: variabel normalnya dikirim oleh MataKuliahController
$mata_kuliah = $mata_kuliah ?? [];
$msg         = $msg ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Data Mata Kuliah</title>
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
    <h1>Data Mata Kuliah</h1>
    <p class="sub">Kelola mata kuliah aktif dan tidak aktif.</p>

    <?php
    $total  = count($mata_kuliah);
    $aktif  = count(array_filter($mata_kuliah, fn($r) => $r['Status'] == 'Aktif'));
    $nonaktif = $total - $aktif;
    $sksAktif = array_sum(array_map(fn($r) => $r['Status'] == 'Aktif' ? (int)$r['SKS'] : 0, $mata_kuliah));
    ?>
    <div class="stats">
        <div class="stat"><b><?= $total ?></b><span>Total mata kuliah</span></div>
        <div class="stat stat-ok"><b><?= $aktif ?></b><span>Aktif</span></div>
        <div class="stat stat-bad"><b><?= $nonaktif ?></b><span>Tidak aktif</span></div>
        <div class="stat"><b><?= $sksAktif ?></b><span>Total SKS aktif</span></div>
    </div>

    <?php
    $pesan = ['created'=>'Mata kuliah berhasil ditambahkan.', 'updated'=>'Mata kuliah berhasil diperbarui.',
              'deleted'=>'Mata kuliah berhasil dihapus.', 'notfound'=>'Data mata kuliah tidak ditemukan.'];
    if (isset($pesan[$msg])): ?>
        <div class="alert alert-ok"><?= htmlspecialchars($pesan[$msg], ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <div class="bar">
        <span class="count">Daftar mata kuliah</span>
        <a class="btn" href="index.php?action=create">Tambah mata kuliah</a>
    </div>

    <div class="table-scroll">
    <table>
        <thead>
            <tr><th>No</th><th>Kode</th><th>Nama Mata Kuliah</th><th>Program Studi</th><th>Smt</th><th>SKS</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody>
        <?php if (!$mata_kuliah): ?>
            <tr><td colspan="8" class="empty">Belum ada data. Klik "Tambah mata kuliah" untuk memulai.</td></tr>
        <?php endif; ?>
        <?php $no = 1; foreach ($mata_kuliah as $row):
            $b = ($row['Status'] == 'Aktif') ? 'badge-success' : 'badge-danger'; ?>
            <tr>
                <td><?= $no++ ?></td>
                <td class="kode"><?= htmlspecialchars($row['KodeMataKuliah'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($row['NamaMataKuliah'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><span class="prodi"><?= htmlspecialchars($row['ProgramStudi'], ENT_QUOTES, 'UTF-8') ?></span></td>
                <td><?= htmlspecialchars($row['Semester'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($row['SKS'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><span class="badge <?= $b ?>"><?= htmlspecialchars($row['Status'], ENT_QUOTES, 'UTF-8') ?></span></td>
                <td class="actions">
                    <a class="btn btn-sm btn-light" href="index.php?action=edit&id=<?= (int)$row['IdMataKuliah'] ?>">Edit</a>
                    <a class="btn btn-sm btn-danger" href="index.php?action=delete&id=<?= (int)$row['IdMataKuliah'] ?>"
                       onclick="return confirm('Yakin ingin menghapus mata kuliah ini?');">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</div>
</body>
</html>

<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/MataKuliah.php';

class MataKuliahController {
    private $model;
    private $prodiList = ['D3 Komputerisasi Akuntansi', 'D3 Manajemen Informatika', 'S1 Sistem Informasi', 'S1 Teknik Informatika', 'S1 Rekayasa Perangkat Lunak'];

    public function __construct() {
        $pdo = (new Database())->getConnection();
        $this->model = new MataKuliah($pdo);
    }

    public function index() {
        $mata_kuliah = $this->model->getAll();
        $msg = $_GET['msg'] ?? '';
        require __DIR__ . '/../views/index.php';
    }

    public function create() {
        $errors = [];
        $kode = $nama = $prodi = '';
        $smt = $sks = '';
        $status = 'Aktif';
        $prodiList = $this->prodiList;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->ambilInput();
            $errors = $this->validasi($data);
            if (!$errors) {
                try {
                    $this->model->create($data);
                    header('Location: index.php?msg=created'); exit;
                } catch (PDOException $e) {
                    $errors[] = $this->pesanError($e);
                }
            }
            $kode = $data['kode']; $nama = $data['nama']; $prodi = $data['prodi'];
            $smt = $data['smt'];   $sks = $data['sks'];   $status = $data['status'];
        }
        require __DIR__ . '/../views/create.php';
    }

    public function edit() {
        $id = (int)($_GET['id'] ?? 0);
        $mk = $this->model->getById($id);
        if (!$mk) { header('Location: index.php?msg=notfound'); exit; }

        $errors = [];
        $prodiList = $this->prodiList;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->ambilInput();
            $errors = $this->validasi($data);
            if (!$errors) {
                try {
                    $this->model->update($id, $data);
                    header('Location: index.php?msg=updated'); exit;
                } catch (PDOException $e) {
                    $errors[] = $this->pesanError($e);
                }
            }
            $mk = array_merge($mk, [
                'KodeMataKuliah'=>$data['kode'], 'NamaMataKuliah'=>$data['nama'],
                'ProgramStudi'=>$data['prodi'], 'Semester'=>$data['smt'],
                'SKS'=>$data['sks'], 'Status'=>$data['status']]);
        }
        $kode = $mk['KodeMataKuliah']; $nama = $mk['NamaMataKuliah'];
        $prodi = $mk['ProgramStudi'];  $smt = $mk['Semester'];
        $sks = $mk['SKS'];             $status = $mk['Status'];
        require __DIR__ . '/../views/edit.php';
    }

    public function delete() {
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) { $this->model->delete($id); }
        header('Location: index.php?msg=deleted'); exit;
    }

    private function ambilInput() {
        return [
            'kode'   => trim($_POST['kode'] ?? ''),
            'nama'   => trim($_POST['nama'] ?? ''),
            'prodi'  => $_POST['prodi'] ?? '',
            'smt'    => $_POST['smt'] ?? '',
            'sks'    => $_POST['sks'] ?? '',
            'status' => $_POST['status'] ?? '',
        ];
    }

    private function validasi($d) {
        $e = [];
        if ($d['kode'] === '' || strlen($d['kode']) > 20)  $e[] = 'Kode mata kuliah wajib diisi (maks. 20 karakter).';
        if ($d['nama'] === '' || strlen($d['nama']) > 100) $e[] = 'Nama mata kuliah wajib diisi (maks. 100 karakter).';
        if (!in_array($d['prodi'], $this->prodiList, true)) $e[] = 'Pilih program studi yang tersedia.';
        if (!ctype_digit((string)$d['smt']) || $d['smt'] < 1 || $d['smt'] > 8) $e[] = 'Semester harus angka 1 sampai 8.';
        if (!ctype_digit((string)$d['sks']) || $d['sks'] < 1 || $d['sks'] > 6) $e[] = 'SKS harus angka 1 sampai 6.';
        if (!in_array($d['status'], ['Aktif', 'Tidak Aktif'], true)) $e[] = 'Pilih status mata kuliah.';
        return $e;
    }

    private function pesanError(PDOException $e) {
        if ($e->getCode() == 23000) return 'Kode atau nama mata kuliah sudah terdaftar.';
        return 'Terjadi kesalahan database. Silakan coba lagi.';
    }
}

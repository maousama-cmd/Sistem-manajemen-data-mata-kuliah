<?php
require_once __DIR__ . '/controllers/MataKuliahController.php';

try {
    $controller = new MataKuliahController();
    $action = $_GET['action'] ?? 'index';

    switch ($action) {
        case 'create': $controller->create(); break;
        case 'edit':   $controller->edit();   break;
        case 'delete': $controller->delete(); break;
        default:       $controller->index();
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo 'Koneksi atau query database gagal. Periksa config/Database.php dan pastikan database.sql sudah diimport.';
}

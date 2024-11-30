<?php
// Mulai sesi untuk memastikan admin sudah login
session_start();

// Cek apakah yang mengakses halaman ini adalah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

// Koneksi database
include 'db.php';

// Cek jika ada parameter 'id' yang dikirim melalui URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Persiapkan query untuk menandai izin sebagai dihapus
    $sql = "UPDATE izin SET deleted = 1 WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameter dan eksekusi query
        $stmt->bind_param("i", $id); // "i" untuk integer (id)
        
        if ($stmt->execute()) {
            // Redirect kembali ke halaman data izin dengan pesan sukses
            header('Location: admin_dashboard.php?status=success');
        } else {
            echo "Terjadi kesalahan saat menandai izin sebagai dihapus.";
        }
        
        $stmt->close();
    } else {
        echo "Terjadi kesalahan pada query.";
    }
} else {
    echo "ID izin tidak ditemukan.";
}

$conn->close();
?>

<?php
// Pastikan koneksi database sudah terhubung
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $feedback = $_POST['feedback'];

    // Update status dan feedback, set processed ke 1
    $sql = "UPDATE izin SET status = ?, feedback = ?, processed = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssi', $status, $feedback, $id);

    if ($stmt->execute()) {
        // Redirect setelah berhasil ke halaman admin
        header('Location: admin_dashboard.php');  // Ganti dengan halaman admin yang sesuai
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

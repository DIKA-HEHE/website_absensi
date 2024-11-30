<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $keterangan = $_POST['keterangan'];
    $lama_izin = $_POST['lama_izin'];

    // Update data izin
    $sql = "UPDATE izin SET keterangan = '$keterangan', lama_izin = $lama_izin WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        header('Location: admin_dashboard.php'); // Kembali ke halaman admin
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

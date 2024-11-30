<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data yang dikirimkan
    $id = $_POST['id'];
    $status = $_POST['status'];
    $feedback = $_POST['feedback'];

    // Update status, feedback, dan set processed ke 1
    $sql = "UPDATE izin SET status = ?, feedback = ?, processed = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssi', $status, $feedback, $id);

    if ($stmt->execute()) {
        // Redirect setelah berhasil
        header('Location: admin_dashboard.php');
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

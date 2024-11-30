<?php
// Mengatur konfigurasi koneksi database
$host = "localhost";     // Host MySQL (biasanya localhost)
$username = "root";      // Username MySQL
$password = "";          // Password MySQL (kosongkan jika belum diubah)
$dbname = "19021_webabsensi";  // Nama database yang telah Anda buat

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $dbname);

// Cek apakah terjadi kesalahan pada koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset untuk menghindari masalah dengan karakter
$conn->set_charset("utf8");

// Menampilkan pesan koneksi berhasil (opsional)
echo "Connected successfully";
?>

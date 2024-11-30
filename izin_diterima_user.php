<?php
// Koneksi database
include 'db.php';

// Ambil data izin yang diterima
$sql = "SELECT * FROM izin WHERE status = 'approved' ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Izin Diterima</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('img/DJI_0334-min-scaled.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            font-family: 'Arial', sans-serif;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Navbar tetap di atas menggunakan position fixed */
        .navbar {
            position: fixed; /* Agar navbar tetap di atas */
            top: 0; /* Posisi navbar di bagian atas */
            width: 100%; /* Memastikan navbar memenuhi lebar layar */
            background-color: rgba(0, 51, 102, 0.8);
            z-index: 1000; /* Membuat navbar berada di atas elemen lain */
            padding: 10px 0; /* Memberikan padding pada navbar */
        }

        body {
            background: url('img/DJI_0334-min-scaled.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            font-family: 'Arial', sans-serif;
            color: #fff;
            margin-top: 70px; /* Memberikan jarak di atas untuk menghindari tertutup navbar */
        }

        /* Tabel styling */
        .container {
            margin-top: 20px; /* Memberikan ruang antara navbar dan tabel */
        }
        /* Mengubah tombol logout menjadi merah */
        /* Navbar dengan Flexbox */
        .navbar .container-fluid {
            display: flex;
            justify-content: space-between; /* Menyebarkan item navbar ke kiri dan kanan */
            align-items: center; /* Menjaga item navbar berada di tengah secara vertikal */
        }

        /* Tombol logout di flexbox */
        .navbar .navbar-nav {
            display: flex;
            margin-left: auto; /* Mengatur agar tombol logout berada di pojok kanan */
        }

        /* Tombol Logout Merah */
        .navbar .nav-item .nav-link.logout {
            background-color: #d9534f; /* Warna merah */
            color: white; /* Warna teks putih */
            border-radius: 5px;
            padding: 10px 20px;
            font-weight: bold;
            text-align: center;
            margin-left: 10px; /* Memberikan jarak antara item navbar */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .navbar .nav-item .nav-link.logout:hover {
            background-color: #c9302c; /* Warna merah lebih gelap saat hover */
            color: white;
        }

        /* Mengatur agar navbar item lainnya berada di kiri */
        .navbar .navbar-nav .nav-item {
            margin-right: 15px; /* Memberikan jarak antar item navbar */
        }

        /* Styling untuk box yang menyatukan kedua judul */
        .box-title {
            background-color: rgba(255, 255, 255, 0.85); /* Transparansi pada box judul */
            color: #000;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            font-size: 24px;
            margin-bottom: 10px; /* Mengurangi margin bawah agar lebih dekat dengan tabel */
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1); /* Shadow seperti tabel */
        }

        table {
            background-color: rgba(255, 255, 255, 0.85);
            border-radius: 10px;
            width: 100%;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        th, td {
            text-align: center;
            padding: 12px;
        }

        th {
            background-color: #0066cc;
            color: #000; /* Mengubah warna teks header menjadi hitam */
            font-weight: bold;
        }

        td {
            background-color: #f9f9f9;
        }

        .table img {
            border-radius: 10px;
        }

        /* Footer */
        footer {
            background-color: rgba(0, 51, 102, 0.8);
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        /* Responsive */
        @media (max-width: 768px) {
            h2 {
                font-size: 24px;
            }

            table {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Absensi Sistem</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="user_dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="izin_diterima_user.php">Izin Diterima</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="izin_ditolak_user.php">Izin Ditolak</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="user_izin.php">Status Izin</a> <!-- Halaman status izin aktif -->
                </li>
                <li class="nav-item">
                    <a class="nav-link logout" href="logout.php">Logout</a> <!-- Tombol Logout -->
                </li>
            </ul>
        </div>
    </div>
</nav>


    <div class="container mt-5">
        <!-- Box untuk kedua judul "Izin Diterima" dan "Data Izin yang Telah Diterima" -->
        <div class="box-title">
            Izin Diterima - Data Izin yang Telah Diterima
        </div>

        <hr>

        <?php if ($result->num_rows > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Keterangan</th>
                        <th>Lama Izin</th>
                        <th>Foto</th>
                        <th>Status</th>
                        <th>Feedback</th> <!-- Kolom untuk Feedback -->
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['nama']; ?></td>
                            <td><?php echo $row['kelas']; ?></td>
                            <td><?php echo $row['keterangan']; ?></td>
                            <td><?php echo $row['lama_izin']; ?> hari</td>
                            <td>
                                <?php if ($row['foto']): ?>
                                    <img src="uploads/<?php echo $row['foto']; ?>" alt="Foto Izin" width="100">
                                <?php endif; ?>
                            </td>
                            <td><?php echo ($row['status'] == 'approved') ? 'Izin Diterima' : 'Izin Ditolak'; ?></td>
                            <td>
                                <!-- Menampilkan feedback dari admin -->
                                <?php echo ($row['feedback']) ? $row['feedback'] : 'Belum ada feedback.'; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center">Belum ada izin yang diterima.</p>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; Dika@2024. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

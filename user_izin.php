<?php
// Koneksi database
include 'db.php';

// Query untuk mengambil data izin yang sudah diproses
$sql = "SELECT * FROM izin ORDER BY id DESC LIMIT 1";  // Ambil data izin terakhir
$result = $conn->query($sql);
$izin = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Izin Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Mengatur latar belakang halaman */
        body {
            background: url('img/DJI_0334-min-scaled.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            font-family: 'Arial', sans-serif;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            margin-top: 0;
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

        /* Mengatur agar isi konten tidak tertutup oleh navbar */
        body {
            margin-top: 70px; /* Memberikan jarak di atas untuk menghindari tertutup navbar */
        }

        /* Menambahkan box untuk status izin */
        .status-box {
            background-color: rgba(255, 255, 255, 0.85); /* Transparansi pada box status */
            color: #000;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .status-box p {
            font-size: 16px;
            margin-bottom: 10px;
        }

        /* Styling untuk status izin */
        .status-approved {
            color: green;
            font-weight: bold;
        }

        .status-rejected {
            color: red;
            font-weight: bold;
        }

        .status-pending {
            color: orange;
            font-weight: bold;
        }

        /* Styling untuk gambar bukti izin */
        img.img-fluid {
            border-radius: 10px;
            max-width: 100%;
            margin-top: 10px;
        }

        /* Styling tombol */
        .btn {
            margin-right: 10px;
        }

        /* Responsif */
        @media (max-width: 768px) {
            h2 {
                font-size: 24px;
            }

            .status-box {
                padding: 15px;
            }

            .btn {
                font-size: 14px;
            }
        }
        
        /* Footer styling */
        footer {
            background-color: rgba(0, 51, 102, 0.8);
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: relative;
            bottom: 0;
            width: 100%;
        }

    </style>
</head>
<body>
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
                    <a class="nav-link active" href="user_izin.php">Riwayat Izin</a> <!-- Halaman status izin aktif -->
                </li>
                <li class="nav-item">
                    <a class="nav-link logout" href="logout.php">Logout</a> <!-- Tombol Logout -->
                </li>
            </ul>
        </div>
    </div>
</nav>

    <div class="container mt-5">
        <h2>Riwayat Izin Hari Ini</h2>
        <a href="user_dashboard.php" class="btn btn-primary">Kembali ke Dashboard</a>
       

        <hr>

        <?php if ($izin): ?>
            <!-- Menampilkan status izin (diterima atau ditolak) -->
            <div class="status-box">
                <p><strong>Status Izin:</strong> 
                    <?php 
                    if ($izin['status'] == 'approved') {
                        echo "<span class='status-approved'>Izin Diterima</span>";
                    } elseif ($izin['status'] == 'rejected') {
                        echo "<span class='status-rejected'>Izin Ditolak</span>";
                    } else {
                        echo "<span class='status-pending'>Izin Masih Pending</span>";
                    }
                    ?>
                </p>
                
                <!-- Menampilkan feedback dari admin -->
                <p><strong>Feedback dari Admin:</strong> 
                    <?php echo ($izin['feedback']) ? $izin['feedback'] : 'Belum ada feedback.'; ?>
                </p>

                <!-- Menampilkan data lainnya -->
                <p><strong>Keterangan Izin:</strong> <?php echo $izin['keterangan']; ?></p>
                <p><strong>Lama Izin:</strong> <?php echo $izin['lama_izin']; ?> hari</p>

                <?php if ($izin['foto']): ?>
                    <p><strong>Foto Bukti Izin:</strong></p>
                    <img src="uploads/<?php echo $izin['foto']; ?>" alt="Foto Izin" class="img-fluid">
                <?php endif; ?>
            </div>

        <?php else: ?>
            <p>Anda belum mengajukan izin atau izin Anda belum diproses oleh admin.</p>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; Dika@2024. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

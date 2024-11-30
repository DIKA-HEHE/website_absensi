<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header('Location: login.php');
    exit;
}

include 'db.php';

// Proses jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $nis = $_POST['nis'];
    $kelas = $_POST['kelas'];
    $keterangan = $_POST['keterangan'];
    $lama_izin = $_POST['lama_izin'];

    // Proses upload file
    $foto = $_FILES['foto']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($foto);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file gambar
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["foto"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $error = "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Cek ukuran file
    if ($_FILES["foto"]["size"] > 500000) {
        $error = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Cek format file
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Jika semuanya OK, upload file
    if ($uploadOk == 0) {
        $error = "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            // Insert data ke database
            $sql = "INSERT INTO izin (nama, nis, kelas, keterangan, lama_izin, foto) 
                    VALUES ('$nama', '$nis', '$kelas', '$keterangan', '$lama_izin', '$foto')";
            if ($conn->query($sql) === TRUE) {
                $success = "Data berhasil disubmit!";
            } else {
                $error = "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            $error = "Sorry, there was an error uploading your file.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.min.css" rel="stylesheet">
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



        /* Form styling */
        .form-container {
            background-color: rgba(255, 255, 255, 0.85);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 900px;
            margin: auto; /* Membuat form berada di tengah secara horizontal */
        }

        .form-container h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
            font-size: 24px;
        }

        .form-label {
            font-weight: bold;
            color: #333;
        }

        .form-control, .form-select {
            border-radius: 20px;
            box-shadow: none;
            border: 1px solid #ddd;
            margin-bottom: 15px;
            padding: 12px;
            font-size: 16px;
            color: #333; /* Set text color to black */
        }

        .form-control:focus, .form-select:focus {
            border-color: #0066cc;
            box-shadow: 0 0 5px rgba(0, 102, 204, 0.7);
        }

        .btn-primary {
            background-color: #0066cc;
            border: none;
            width: 100%;
            padding: 15px;
            border-radius: 20px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #005bb5;
        }

        .alert {
            margin-top: 20px;
            text-align: center;
            padding: 15px;
            border-radius: 10px;
        }

        footer {
            background-color: rgba(0, 51, 102, 0.8); /* Transparansi pada footer */
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .form-container {
                margin-top: 30px;
                padding: 20px;
            }

            .form-container h2 {
                font-size: 20px;
            }

            .btn-primary {
                font-size: 16px;
            }
        }

        /* Style untuk form horizontal */
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center; /* Membuat form inputan berada di tengah secara horizontal */
        }

        .form-group {
            flex: 1;
            min-width: 250px;
            text-align: center; /* Menjaga agar inputan di tengah */
        }

        .form-group input, .form-group select {
            width: 100%;
        }

        /* Centering the entire form */
        .form-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
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


    <div class="container mt-5 d-flex justify-content-center align-items-center">
        <div class="form-container">
            <h2>Form Izin</h2>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="nis" class="form-label">NIS</label>
                        <input type="text" class="form-control" id="nis" name="nis" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="kelas" class="form-label">Kelas</label>
                        <input type="text" class="form-control" id="kelas" name="kelas" required>
                    </div>
                    <div class="form-group">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <select class="form-select" id="keterangan" name="keterangan" required>
                            <option value="Sakit">Sakit</option>
                            <option value="Izin">Izin</option>
                            <option value="Alpa">Alpa</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="lama_izin" class="form-label">Lama Izin (Hari)</label>
                        <input type="number" class="form-control" id="lama_izin" name="lama_izin" required min="1">
                    </div>
                    <div class="form-group">
                        <label for="foto" class="form-label">Upload Foto</label>
                        <input type="file" class="form-control" id="foto" name="foto" required>
                        <div class="form-text">Format foto yang diperbolehkan: jpg, jpeg, png, gif</div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; Dika@2024. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

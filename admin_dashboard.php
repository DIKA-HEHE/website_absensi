<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

// Koneksi database
include 'db.php';

// Ambil data izin dari database yang belum dihapus
$sql = "SELECT * FROM izin WHERE deleted = 0";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
        }

        .navbar {
            background-color: #003366;
        }

        .navbar-brand {
            color: #fff;
            font-weight: bold;
        }

        .navbar-brand:hover {
            color: #ddd;
        }

        .table th {
            background-color: #003366;
            color: #fff;
        }

        .table td {
            vertical-align: middle;
        }

        .status-badge {
            padding: 0.5em;
            border-radius: 5px;
            font-size: 0.9em;
        }

        .status-pending {
            background-color: orange;
            color: #fff;
        }

        .status-approved {
            background-color: green;
            color: #fff;
        }

        .status-rejected {
            background-color: red;
            color: #fff;
        }

        footer {
            background-color: #003366;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Dashboard Admin</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Konten -->
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Welcome, Admin</h2>
        </div>

        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Data Izin User</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>NIS</th>
                            <th>Kelas</th>
                            <th>Keterangan</th>
                            <th>Lama Izin</th>
                            <th>Foto</th>
                            <th>Status</th>
                            <th>Feedback</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['nama']; ?></td>
                                <td><?php echo $row['nis']; ?></td>
                                <td><?php echo $row['kelas']; ?></td>
                                <td><?php echo $row['keterangan']; ?></td>
                                <td><?php echo $row['lama_izin']; ?> hari</td>
                                <td>
                                    <!-- Thumbnail -->
                                    <a href="uploads/<?php echo $row['foto']; ?>" target="_blank">
                                        <img src="uploads/<?php echo $row['foto']; ?>" alt="Foto Izin" width="100" class="img-thumbnail" data-bs-toggle="modal" data-bs-target="#fotoModal<?php echo $row['id']; ?>">
                                    </a>

                                    <!-- Modal untuk menampilkan foto -->
                                    <div class="modal fade" id="fotoModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="fotoModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="fotoModalLabel<?php echo $row['id']; ?>">Foto Izin</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <img src="uploads/<?php echo $row['foto']; ?>" alt="Foto Izin" class="img-fluid">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge 
                                        <?php 
                                            if ($row['status'] == 'approved') echo 'status-approved'; 
                                            elseif ($row['status'] == 'rejected') echo 'status-rejected'; 
                                            else echo 'status-pending';
                                        ?>">
                                        <?php echo ucfirst($row['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <form method="POST" action="update_status.php">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select name="status" class="form-select" id="status">
                                                <option value="pending" <?php echo ($row['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                                <option value="approved" <?php echo ($row['status'] == 'approved') ? 'selected' : ''; ?>>Approved</option>
                                                <option value="rejected" <?php echo ($row['status'] == 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="feedback" class="form-label">Feedback</label>
                                            <textarea name="feedback" class="form-control" rows="3"><?php echo $row['feedback']; ?></textarea>
                                        </div>
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="edit_izin.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="delete_izin.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus izin ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; Dika@2024. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

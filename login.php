<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Enkripsi password menggunakan MD5

    // Cek apakah username dan password sesuai
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Redirect berdasarkan peran
        if ($user['role'] == 'admin') {
            header('Location: admin_dashboard.php');
        } else {
            header('Location: user_dashboard.php');
        }
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom right, #4facfe, #00f2fe);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
            margin: 0;
        }
        .login-card {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            padding: 40px 30px;
            width: 100%;
            max-width: 400px;
        }
        .login-card h2 {
            margin-bottom: 20px;
            font-weight: bold;
            color: #333;
            text-align: center;
        }
        .form-control {
            border-radius: 10px;
            border: 1px solid #ccc;
            box-shadow: none;
        }
        .form-control:focus {
            border-color: #00aaff;
            box-shadow: 0 0 5px rgba(0, 170, 255, 0.5);
        }
        .btn-primary {
            background: linear-gradient(to right, #4facfe, #00f2fe);
            border: none;
            width: 100%;
            border-radius: 10px;
            padding: 10px;
            font-weight: bold;
            transition: 0.3s ease-in-out;
        }
        .btn-primary:hover {
            background: linear-gradient(to right, #00f2fe, #4facfe);
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(0, 170, 255, 0.5);
        }
        .alert {
            margin-top: 15px;
            text-align: center;
        }
        .input-group-text {
            border-radius: 10px 0 0 10px;
            background-color: #eaf4fc;
            border: none;
        }
        .input-group-text i {
            color: #00aaff;
        }
        .btn-outline-secondary {
            border: none;
            background-color: #eaf4fc;
            color: #00aaff;
        }
        .btn-outline-secondary:hover {
            background-color: #d0eaff;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>Welcome Back!</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" required>
                    <button type="button" class="btn btn-outline-secondary" id="show-password">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>

    <script>
        const showPasswordBtn = document.getElementById('show-password');
        const passwordField = document.getElementById('password');

        showPasswordBtn.addEventListener('click', function() {
            if (passwordField.type === "password") {
                passwordField.type = "text";
                showPasswordBtn.innerHTML = '<i class="bi bi-eye-slash"></i>';
            } else {
                passwordField.type = "password";
                showPasswordBtn.innerHTML = '<i class="bi bi-eye"></i>';
            }
        });
    </script>
</body>
</html>

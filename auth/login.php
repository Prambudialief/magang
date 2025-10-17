<?php
session_start();
include "../service/connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role']; // role dipilih dari radio button

    if ($role === 'Mentor') {
        // cek ke tabel mentor
        $result = mysqli_query($conn, "SELECT * FROM mentor WHERE email='$email' LIMIT 1");
        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['mentor_id'] = $user['id'];
            $_SESSION['role'] = 'Mentor';
            $_SESSION['nama'] = $user['nama'];

            header("Location: ../mentor/dashboard.php");
            exit;
        } else {
            echo "<script>alert('Email atau password salah untuk Mentor'); window.location='login.php';</script>";
            exit;
        }

    } else {
        // cek ke tabel users (Admin & Peserta)
        $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND role='$role' LIMIT 1");
        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['nama'] = $user['nama'];

            if ($user['role'] === 'Admin') {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: ../peserta/dashboard.php");
            }
            exit;
        } else {
            echo "<script>alert('Email atau password salah'); window.location='login.php';</script>";
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
    <link rel="icon" href="../image/adminpro.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
<main>
    <div class="container-fluid mt-5" style="font-family: initial;">
        <div class="container text-center">
            <h1 class="fs-3">MagangHub</h1>
            <p>Platform manajemen magang untuk Peserta, Mentor, dan Admin</p>
        </div>
        <div class="container d-flex justify-content-center mt-5">
            <div class="card shadow-lg" style="max-width: 450px; width:100%;">
                <div class="card-body p-4">
                    <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="masuk-tab" href="login.php" role="tab">Masuk</a>
                        </li>

                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="masuk-tab" href="register.php" role="tab">Daftar</a>
                        </li>
                    </ul>
                    <form method="post" action="login.php">
                        <!-- Pilih Role -->
                        <div class="btn-group w-100 mb-3" role="group">
                            <input type="radio" class="btn-check" name="role" id="peserta" value="Peserta" checked>
                            <label class="btn btn-outline-primary" for="peserta"><i class="bi bi-person"></i> Peserta</label>

                            <input type="radio" class="btn-check" name="role" id="mentor" value="Mentor">
                            <label class="btn btn-outline-success" for="mentor"><i class="bi bi-people"></i> Mentor</label>

                            <input type="radio" class="btn-check" name="role" id="admin" value="Admin">
                            <label class="btn btn-outline-danger" for="admin"><i class="bi bi-shield-lock"></i> Admin</label>
                        </div>

                        <div class="mb-3 text-start">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="nama@email.com" required>
                        </div>
                        <div class="mb-3 text-start">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan password" required>
                        </div>
                        <button type="submit" id="submitBtn" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const radios = document.querySelectorAll('input[name="role"]');
        const submitBtn = document.getElementById('submitBtn');

        function updateButton(role) {
            submitBtn.textContent = `Masuk Sebagai ${role}`;
            submitBtn.className = "btn w-100";

            if (role === "Peserta") {
                submitBtn.classList.add("btn-primary");
            } else if (role === "Mentor") {
                submitBtn.classList.add("btn-success");
            } else if (role === "Admin") {
                submitBtn.classList.add("btn-danger");
            }
        }

        updateButton(document.querySelector('input[name="role"]:checked').value);

        radios.forEach(radio => {
            radio.addEventListener('change', function() {
                updateButton(this.value);
            });
        });
    });
</script>
</body>
</html>

<?php
session_start();
include "../service/connection.php";

if (!isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

$role = $_SESSION['role'];
$nama = $_SESSION['nama'] ?? '';

$user = [];

if ($role === 'Mentor') {
    $id = $_SESSION['mentor_id'];
    $query = mysqli_query($conn, "SELECT * FROM mentor WHERE id = '$id' LIMIT 1");
    $user = mysqli_fetch_assoc($query);
} else {
    $id = $_SESSION['user_id'];
    $query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$id' LIMIT 1");
    $user = mysqli_fetch_assoc($query);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Profil Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../image/adminpro.jpg">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .profile-card {
            max-width: 500px;
            margin: 60px auto;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .profile-header {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 30px 20px;
        }

        .profile-header.mentor {
            background-color: #28a745;
        }

        .profile-header.admin {
            background-color: #dc3545;
        }

        .profile-header h2 {
            margin: 10px 0 5px 0;
        }

        .profile-body {
            background-color: white;
            padding: 25px;
        }

        .profile-body .info {
            margin-bottom: 12px;
        }

        .info-label {
            font-weight: bold;
            color: #555;
        }

        .btn-logout {
            background-color: #6c757d;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 20px;
            text-decoration: none;
        }

        .btn-logout:hover {
            background-color: #5a6268;
        }
    </style>
</head>

<body>

    <div class="profile-card">
        <div class="profile-header <?php echo strtolower($role); ?>">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="User" width="80" height="80" class="rounded-circle bg-light p-2 mb-2">
            <h2><?php echo htmlspecialchars($nama); ?></h2>
            <p><?php echo htmlspecialchars($role); ?></p>
        </div>
        <div class="profile-body">
            <?php if ($role === 'Peserta'): ?>
                <div class="info">
                    <span class="info-label">Nama:</span> <?php echo htmlspecialchars($user['nama'] ?? '-'); ?>
                </div>
                <div class="info">
                    <span class="info-label">Email:</span> <?php echo htmlspecialchars($user['email'] ?? '-'); ?>
                </div>
                <div class="info">
                    <span class="info-label">Status:</span> Peserta Magang
                </div>
            <?php endif; ?>
            <?php if ($role === 'Mentor'): ?>
                <div class="info">
                    <span class="info-label">Nama:</span> <?php echo htmlspecialchars($user['nama'] ?? '-'); ?>
                </div>
                <div class="info">
                    <span class="info-label">Email:</span> <?php echo htmlspecialchars($user['email'] ?? '-'); ?>
                </div>
                <div class="info">
                    <span class="info-label">Bidang:</span> <?php echo htmlspecialchars($user['bidang_keahlian'] ?? '-'); ?>
                </div>
                <div class="info">
                    <span class="info-label">Status:</span> Mentor
                </div>
            <?php endif; ?>
            <?php if ($role === 'Admin'): ?>
                <div class="info">
                    <span class="info-label">Nama:</span> <?php echo htmlspecialchars($user['nama'] ?? '-'); ?>
                </div>
                <div class="info">
                    <span class="info-label">Email:</span> <?php echo htmlspecialchars($user['email'] ?? '-'); ?>
                </div>
                <div class="info">
                    <span class="info-label">Status:</span> Administrator Sistem
                </div>
            <?php endif; ?>
            <div class="text-center mt-4">
                <a href="../auth/login.php" class="btn-logout">Logout</a>
            </div>
        </div>
    </div>

</body>

</html>
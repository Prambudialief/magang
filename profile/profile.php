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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil Pengguna</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../image/adminpro.jpg">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .profile-card {
            width: 100%;
            max-width: 480px;
            margin: 40px auto;
            border-radius: 16px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .profile-header {
            color: white;
            text-align: center;
            padding: clamp(20px, 5vw, 32px);
        }

        .profile-header.peserta {
            background-color: #007bff;
        }

        .profile-header.mentor {
            background-color: #28a745;
        }

        .profile-header.admin {
            background-color: #dc3545;
        }

        .profile-header img {
            width: clamp(70px, 18vw, 90px);
            height: clamp(70px, 18vw, 90px);
            object-fit: cover;
        }

        .profile-header h2 {
            font-size: clamp(1.1rem, 4vw, 1.5rem);
            margin-top: 10px;
        }

        .profile-header p {
            font-size: clamp(0.9rem, 3vw, 1rem);
            margin-bottom: 0;
        }

        .profile-body {
            background-color: white;
            padding: clamp(18px, 5vw, 28px);
        }

        .info {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 12px;
            font-size: 0.95rem;
        }

        .info-label {
            min-width: 90px;
            font-weight: 600;
            color: #555;
        }

        .btn-logout {
            background-color: #6c757d;
            color: white;
            border-radius: 10px;
            padding: 10px 26px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-logout:hover {
            background-color: #5a6268;
        }
    </style>
</head>

<body>

<div class="container px-3">
        <div class="profile-card">
            <div class="profile-header <?php echo strtolower($role); ?>">
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
                     class="rounded-circle bg-light p-2 mb-2"
                     alt="User">

                <h2><?php echo htmlspecialchars($nama); ?></h2>
                <p><?php echo htmlspecialchars($role); ?></p>
            </div>

            <div class="profile-body">
                <?php if ($role === 'Peserta'): ?>
                    <div class="info">
                        <span class="info-label">Nama</span>
                        <span><?php echo htmlspecialchars($user['nama'] ?? '-'); ?></span>
                    </div>
                    <div class="info">
                        <span class="info-label">Email</span>
                        <span><?php echo htmlspecialchars($user['email'] ?? '-'); ?></span>
                    </div>
                    <div class="info">
                        <span class="info-label">Status</span>
                        <span>Peserta Magang</span>
                    </div>
                <?php endif; ?>

                <?php if ($role === 'Mentor'): ?>
                    <div class="info">
                        <span class="info-label">Nama</span>
                        <span><?php echo htmlspecialchars($user['nama'] ?? '-'); ?></span>
                    </div>
                    <div class="info">
                        <span class="info-label">Email</span>
                        <span><?php echo htmlspecialchars($user['email'] ?? '-'); ?></span>
                    </div>
                    <div class="info">
                        <span class="info-label">Bidang</span>
                        <span><?php echo htmlspecialchars($user['bidang_keahlian'] ?? '-'); ?></span>
                    </div>
                    <div class="info">
                        <span class="info-label">Status</span>
                        <span>Mentor</span>
                    </div>
                <?php endif; ?>

                <?php if ($role === 'Admin'): ?>
                    <div class="info">
                        <span class="info-label">Nama</span>
                        <span><?php echo htmlspecialchars($user['nama'] ?? '-'); ?></span>
                    </div>
                    <div class="info">
                        <span class="info-label">Email</span>
                        <span><?php echo htmlspecialchars($user['email'] ?? '-'); ?></span>
                    </div>
                    <div class="info">
                        <span class="info-label">Status</span>
                        <span>Administrator Sistem</span>
                    </div>
                <?php endif; ?>

                <div class="text-center mt-4">
                    <a href="../auth/login.php" class="btn-logout">Logout</a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
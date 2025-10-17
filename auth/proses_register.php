<?php
include "../service/connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $konfirmasi = $_POST['konfirmasi'];
    $role = $_POST['role'];

    // Validasi: hanya Peserta boleh daftar lewat register.php
    if ($role !== "Peserta") {
        die("Hanya Peserta yang boleh daftar melalui halaman ini!");
    }

    if ($password !== $konfirmasi) {
        die("Password tidak sama!");
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (nama, email, password, role) VALUES ('$nama','$email','$hashedPassword','Peserta')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Pendaftaran berhasil sebagai Peserta'); window.location='login.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

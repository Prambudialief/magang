<?php
session_start();
include '../service/connection.php';
include '../service/log.php';
if (!isset($_SESSION['mentor_id'])) {
    header("Location: ../auth/login.php");
    exit;
}
$mentor_id = (int) $_SESSION['mentor_id'];

// ========== CREATE / INSERT ==========
if (isset($_POST['simpan'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $deadline = $_POST['deadline'];

    // Upload file soal jika ada
    $file_soal = "";
    if (!empty($_FILES['file_soal']['name'])) {
        $fileName = time() . "_" . basename($_FILES['file_soal']['name']);
        $targetPath = "../uploads/tugas/" . $fileName;

        if (move_uploaded_file($_FILES['file_soal']['tmp_name'], $targetPath)) {
            $file_soal = $fileName;
        }
    }

    $sql = "INSERT INTO tugas (mentor_id, judul, deskripsi, file_soal, deadline) 
            VALUES ('$mentor_id', '$judul', '$deskripsi', '$file_soal', '$deadline')";
    mysqli_query($conn, $sql);

    addLog($conn, $mentor_id, "mentor", "Menambahkan tugas: $judul");

    header("Location: manajemenTugas.php");
    exit;
}

// ========== UPDATE ==========
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $deadline = $_POST['deadline'];
    $file_soal = $_POST['old_file'];

    // Jika upload file baru
    if (!empty($_FILES['file_soal']['name'])) {
        $fileName = time() . "_" . basename($_FILES['file_soal']['name']);
        $targetPath = "../uploads/tugas/" . $fileName;

        if (move_uploaded_file($_FILES['file_soal']['tmp_name'], $targetPath)) {
            $file_soal = $fileName;
        }
    }

    $sql = "UPDATE tugas 
            SET judul='$judul', deskripsi='$deskripsi', deadline='$deadline', file_soal='$file_soal'
            WHERE id='$id' AND mentor_id='$mentor_id'";
    mysqli_query($conn, $sql);
    addLog($conn, $mentor_id, "mentor", "Mengedit tugas: $judul");
    header("Location: manajemenTugas.php");
    exit;
}

// ========== DELETE ==========
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM tugas WHERE id='$id' AND mentor_id='$mentor_id'");
    addLog($conn, $mentor_id, "mentor", "Menghapus tugas: $id");
    header("Location: manajemenTugas.php");
    exit;
}
?>
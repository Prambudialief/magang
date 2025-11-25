<?php
session_start();
include "../service/connection.php";
include "../service/log.php";
if (!isset($_SESSION['mentor_id'])) {
    header("Location: ../auth/login.php");
    exit;
}
$mentor_id = (int) $_SESSION['mentor_id'];

if (isset($_POST['simpan'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    
    $file_materi = "";
    if (!empty($_FILES['file_materi']['name'])) {
        $fileName = time() . "_" . basename($_FILES['file_materi']['name']);
        $targetPath = "../uploads/materi/" . $fileName;

        if (move_uploaded_file($_FILES['file_materi']['tmp_name'], $targetPath)) {
            $file_materi = $fileName;
        }
    }

    $sql = "INSERT INTO materi (mentor_id, judul, deskripsi, file_materi) 
            VALUES ('$mentor_id', '$judul', '$deskripsi', '$file_materi')";
    mysqli_query($conn, $sql);
    addLog($conn, $mentor_id, "mentor", "Menambahkan materi: $judul");
    header("Location: materi.php");
    exit;
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $file_materi = $_POST['old_file'];

    if (!empty($_FILES['file_materi']['name'])) {
        $fileName = time() . "_" . basename($_FILES['file_materi']['name']);
        $targetPath = "../uploads/materi/" . $fileName;

        if (move_uploaded_file($_FILES['file_materi']['tmp_name'], $targetPath)) {
            $file_materi = $fileName;
        }
    }

    $sql = "UPDATE materi SET judul='$judul', deskripsi='$deskripsi', file_materi='$file_materi'
            WHERE id='$id' AND mentor_id='$mentor_id'";
    mysqli_query($conn, $sql);
    addLog($conn, $mentor_id, "mentor", "Mengupdate materi: $judul");
    header("Location: materi.php");
    exit;
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM materi WHERE id='$id' AND mentor_id='$mentor_id'");
    addLog($conn, $mentor_id, "mentor", "Menghapus materi: $id");
    header("Location: materi.php");
    exit;
}

?>
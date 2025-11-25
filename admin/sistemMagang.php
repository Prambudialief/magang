<?php
session_start();

include "../service/connection.php";
include "../service/log.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

// CREATE (Tambah Data)
if (isset($_POST['simpan'])) {
    $judul      = $_POST['judul'];
    $deskripsi  = $_POST['deskripsi'];

    $image      = $_FILES['image']['name'];
    $tmp        = $_FILES['image']['tmp_name'];
    $folder     = "../uploadMagang/";

    $newName = uniqid() . "_" . $image;

    if (move_uploaded_file($tmp, $folder . $newName)) {
        $query = "INSERT INTO program_magang (judul, image, deskripsi) 
                  VALUES ('$judul', '$newName', '$deskripsi')";
        mysqli_query($conn, $query);
        addLog($conn, $_SESSION['user_id'], "admin", "Menambahkan Program Magang: $judul");
        header("Location: programMagang.php");
    }
}

// DELETE (Hapus Data)
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    $result = mysqli_query($conn, "SELECT judul, image FROM program_magang WHERE id='$id'");
    $row = mysqli_fetch_assoc($result);
    $judul  = $row['judul'];

    if ($row && file_exists("../uploadMagang/" . $row['image']))
     { unlink("../uploadMagang/" . $row['image']); }

    mysqli_query($conn, "DELETE FROM program_magang WHERE id='$id'");
    addLog($conn, $_SESSION['user_id'], "admin", "Menghapus Program Magang: $judul");
    header("Location: programMagang.php");
}

// UPDATE (Edit Data)
if (isset($_POST['update'])) {
    $id         = $_POST['id'];
    $judul      = $_POST['judul'];
    $old_image  = $_POST['old_image'];
    $deskripsi  = $_POST['deskripsi'];

    // cek apakah upload gambar baru
    if ($_FILES['image']['name'] != "") {
        $fileName = $_FILES['image']['name'];
        $tmpName  = $_FILES['image']['tmp_name'];
        $targetDir = "../uploadMagang/";
        $newName = uniqid() . "_" . $fileName;
        $targetFile = $targetDir . $newName;

        if (move_uploaded_file($tmpName, $targetFile)) {
            if (file_exists("../uploadMagang/$old_image")) {
                unlink("../uploadMagang/$old_image");
            }
            $image = $newName;
        } else {
            $image = $old_image; // kalau gagal upload, tetap pakai lama
        }
    } else {
        $image = $old_image; // tidak upload → pakai lama
    }
    
    $query = "UPDATE program_magang SET 
                judul='$judul',
                deskripsi='$deskripsi',
                image='$image'
              WHERE id='$id'";
    mysqli_query($conn, $query);
    addLog($conn, $_SESSION['user_id'], "admin", "Mengedit Program Magang: $judul");
    header("Location: programMagang.php");
    exit;
}

?>

<?php
session_start();
include '../template_mentor/header.php';
include '../template_mentor/navbar.php';
include '../template_mentor/sidebar.php';

if (!isset($_SESSION['mentor_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$mentor_id = $_SESSION['mentor_id'];
$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM tugas WHERE id='$id' AND mentor_id='$mentor_id'");
$row = mysqli_fetch_assoc($result);

if (!$row) {
    die("Data tidak ditemukan");
}

?>

<div class="container-fluid px-4 mt-4">
    <h3 class="mt-4">Edit Tugas</h3>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Edit Tugas Untuk Peserta</li>
    </ol>
    <form action="manajemenTugas.php" enctype="multipart/form-data" method="post">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <input type="hidden" name="old_file" value="<?= $row['file_soal']; ?>">
        <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control" value="<?php echo $row['judul'];?>"required>
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <input type="text" name="deskripsi" class="form-control" value="<?php echo $row['deskripsi'];?>"required>
        </div>
        <div class="mb-3">
            <label class="form-label">File Soal</label>
            <?php if ($row['file_soal']):?> 
                <a href="../uploads/tugas/<?=$row['file_soal'];?>"target="_blank">Lihat File Lama</a><br>
            <?php endif; ?>
            <input type="file" name="file_soal" class="form-control">
        </div>
        <div class="mb-3">
                <label class="form-tabel">Deadline</label>
                <input type="date" name="deadline" class="form-control" value="<?php echo $row['deadline'];?>" required>
        </div>
        <button type="submit" name="update" class="btn btn-success">Update</button>
        <a href="manajemenTugas.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php
include '../template_mentor/footer.php';
?>
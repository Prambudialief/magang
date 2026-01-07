<?php
include '../auth/auth_check.php';
include '../template/header.php';
include '../template/navbar.php';
include '../template/sidebar.php';
if (!isset($_GET['id'])) {
    die("ID tidak ditemukan.");
}

$id = $_GET['id'];

// query data berdasarkan id
$result = mysqli_query($conn, "SELECT * FROM program_magang WHERE id='$id'");
$row = mysqli_fetch_assoc($result);

if (!$row) {
    die("Data dengan ID $id tidak ditemukan.");
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4 text-center fw-bold">Edit Program Magang</h1>
    <div class="container-fluid px-4">
        <form method="POST" enctype="multipart/form-data" action="programMagang.php">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="mb-3">
                <label class="form-label">Judul</label>
                <input type="text" class="form-control" name="judul" value="<?php echo $row['judul']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-control" name="deskripsi" required><?php echo $row['deskripsi']; ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Image</label><br>
                <!-- tampilkan gambar lama -->
                <img src="../uploadMagang/<?php echo $row['image']; ?>" width="100" class="mb-2"><br>
                <!-- upload gambar baru (tidak wajib) -->
                <input class="form-control" type="file" name="image">
                <input type="hidden" name="old_image" value="<?php echo $row['image']; ?>">
            </div>
            <button type="submit" name="update" class="btn btn-success">Update</button>
            <a href="programMagang.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?php
include '../template/footer.php';
?>
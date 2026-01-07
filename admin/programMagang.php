<?php
include 'sistemMagang.php';
include '../template/header.php';
include '../template/navbar.php';
include '../template/sidebar.php';
?>

<div class="container-fluid px-4">
    <h2 class="mt-3 text-center fw-bold">Program Magang</h2>
    <p class="text-center">Kelola Program Magang Pusdatin</p>
    <div class="container-fluid px-4">
        <form method="POST" enctype="multipart/form-data" action="sistemMagang.php">
            <div class="mb-3">
                <label class="form-label">Judul</label>
                <input type="text" class="form-control" name="judul" required>
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">Masukkan Gambar</label>
                <input class="form-control" type="file" name="image">
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-control" name="deskripsi" required></textarea>
            </div>
            <button type="submit" name="simpan" class="btn btn-primary mt-1 mb-3">Tambah</button>
        </form>
    </div>
</div>

<div class="container-fluid px-4" style="max-width:1200px;">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Image</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include "../service/connection.php";
                $result = mysqli_query($conn, "SELECT * FROM program_magang");
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>" . $row['id'] . "</td>
                        <td>" . $row['judul'] . "</td>
                        <td><img src='../uploadMagang/" . $row['image'] . "'width='100'></td>
                        <td>" . $row['deskripsi'] . "</td>
                        <td>
                            <a href='editMagang.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm mb-2'>Edit</a>
                            <a href='sistemMagang.php?hapus=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin hapus?\")'>Hapus</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include '../template/footer.php'
?>
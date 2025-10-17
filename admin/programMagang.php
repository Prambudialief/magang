<?php
include '../auth/auth_check.php';
include '../template/header.php';
include '../template/navbar.php';
include '../template/sidebar.php';
include 'sistemMagang.php';
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Program Magang</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Program magang pages</li>
    </ol>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Program</h1>
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
            <button type="submit" name="simpan" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

<div class="container-fluid px-4">
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
                            <a href='editMagang.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                            <a href='sistemMagang.php?hapus=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin hapus?\")'>Hapus</a>
                        </td>
                    </tr>";
        }
        ?>
    </tbody>
    </table>
</div>

<?php
include '../template/footer.php'
?>
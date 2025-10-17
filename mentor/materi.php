<?php
include "sistemMateri.php";
include "../template_mentor/header.php";
include "../template_mentor/navbar.php";
include "../template_mentor/sidebar.php";
?>
<div class="container-fluid">
    <h2 class="text-center mt-3">Manajemen Materi</h2>

    <form method="POST" enctype="multipart/form-data" class="mb-4">
        <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">File materi</label>
            <input type="file" name="file_materi" class="form-control">
        </div>
        <button type="submit" name="simpan" class="btn btn-primary">Tambah</button>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>File Soal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM materi WHERE mentor_id='$mentor_id' ORDER BY created_at DESC");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td>{$row['judul']}</td>
                <td>{$row['deskripsi']}</td>
                <td>";
                if ($row['file_materi']) {
                    echo "<a href='../uploads/materi/{$row['file_materi']}' target='_blank'>Download</a>";
                } else {
                    echo "-";
                }
            echo "</td>
                <td>
                    <a href='editMateri.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                    <a href='sistemMateri.php?hapus={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin hapus?\")'>Hapus</a>
                </td>
            </tr>";
        }
        ?>
        </tbody>
        </tbody>
    </table>
</div>

<?php
include "../template_mentor/footer.php";
?>
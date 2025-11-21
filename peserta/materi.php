<?php
include "../template_user/header.php";
include "../template_user/navbar.php";
include "../template_user/sidebar.php";
$result = $conn->query("
    SELECT m.id, m.judul, m.file_materi, m.deskripsi, mentor.nama 
    FROM materi m
    JOIN mentor ON m.mentor_id = mentor.id
    ORDER BY m.created_at DESC
");

?>

<div class="container mt-4">
    <h2>Daftar Materi</h2>
    <table class="table table-bordered">
        <thead>
            <tr><th>No</th><th>Judul</th><th>Deskripsi</th><th>Mentor</th><th>File</th></tr>
        </thead>
        <tbody>
            <?php $no=1; while($row=$result->fetch_assoc()){ ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['judul']) ?></td>
                    <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><a href="../uploads/materi/<?= $row['file_materi'] ?>" class="btn btn-success btn-sm" target="_blank">Download</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php
include "../template_user/footer.php";
?>
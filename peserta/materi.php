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
    <h2 class="mb-3 fw-bold text-center">Daftar Materi</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="text-center">
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Mentor</th>
                    <th style="width: 120px;">File</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; while($row=$result->fetch_assoc()){ ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td style="word-wrap: break-word; white-space:normal;">
                            <?= htmlspecialchars($row['judul']) ?>
                        </td>
                        <td style="word-wrap: break-word; white-space:normal;">
                            <?= htmlspecialchars($row['deskripsi']) ?>
                        </td>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td class="text-center">
                            <a href="../uploads/materi/<?= $row['file_materi'] ?>" target="_blank" 
                               class="btn btn-success btn-sm w-100">
                                Download
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>


<?php
include "../template_user/footer.php";
?>
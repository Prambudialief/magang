<?php
include '../auth/auth_check_mentor.php';
include "../template_mentor/header.php";
include "../template_mentor/navbar.php";
include "../template_mentor/sidebar.php";
$result = mysqli_query($conn, "SELECT * FROM users WHERE role = 'peserta' ORDER BY created_at DESC")
?>

<div class="container-fluid px-4 mt-4">
    <h1 class="text-center">Chat Peserta</h1>
    <div class="card mx-auto mt-4" style="width: 80rem;">
        <div class="card-header">
            Daftar Peserta
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Tanggal Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['nama'] ?></td>
                            <td><?= $row['email'] ?></td>
                            <td><?= date('d-m-Y H:i', strtotime($row['created_at'])) ?></td>
                            <td><a href="chatPesertaku.php?peserta_id=<?= $row['id'] ?>" class="btn btn-success">Chat</a>                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include "../template_mentor/footer.php";
?>
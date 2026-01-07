<?php
include '../auth/auth_check_mentor.php';
include '../template_mentor/header.php';
include '../template_mentor/navbar.php';
include '../template_mentor/sidebar.php';

$result = mysqli_query($conn, "SELECT * FROM users WHERE role = 'peserta' ORDER BY created_at DESC")
?>

<h2 class="text-center fw-bold">Peserta Magang</h2>

<!-- List Data -->
<div class="card mx-auto mt-4" style="max-width:1200px;">
    <div class="card-header text-center" style="background-color: #0088FF; color: white;">
        Daftar Peserta
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Tanggal Daftar</th>
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
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include '../template_mentor/footer.php';
?>
<?php
include "../auth/auth_check.php";
include '../template/header.php';
include '../template/navbar.php';
include '../template/sidebar.php';

$result = mysqli_query($conn, "SELECT * FROM users WHERE role = 'peserta' ORDER BY created_at DESC")
?>

<h2>Manajemen Peserta</h2>

<!-- List Data -->
<div class="card">
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
                </tr>
            </thead>
            <tbody>
            <?php 
            $no = 1;
            while($row = mysqli_fetch_assoc($result)) { ?>
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

<?php
include '../template/footer.php';
?>
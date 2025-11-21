<?php
include "../auth/auth_check.php";
include '../template/header.php';

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $query = "DELETE FROM users WHERE id = $id AND role = 'peserta'";
    if (mysqli_query($conn, $query)) {
        header("Location: manajemenPeserta.php");
        exit;
    } else {
        die("Gagal menghapus data: " . mysqli_error($conn));
    }
}

$result = mysqli_query($conn, "SELECT * FROM users WHERE role = 'peserta' ORDER BY created_at DESC");

include '../template/navbar.php';
include '../template/sidebar.php';
?>

<h2>Manajemen Peserta</h2>

<!-- List Data -->
<div class="card">
    <div class="card-header">
        Daftar Peserta
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <a href="cetakManajemen.php" class="btn btn-outline-primary mb-2 mt-2" target="_blank">Export By Pdf</a>
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
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= date('d-m-Y H:i', strtotime($row['created_at'])) ?></td>
                    <td>
                        <a href="?delete=<?= $row['id'] ?>" 
                           onclick="return confirm('Yakin ingin menghapus peserta ini?')" 
                           class="btn btn-danger btn-sm">
                           Hapus
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include '../template/footer.php';
?>

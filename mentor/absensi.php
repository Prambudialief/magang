<?php
include "../auth/auth_check_mentor.php";
include "../service/connection.php";

$mentor_id = (int) $_SESSION['user_id'];

$filter_tanggal = $_GET['tanggal'] ?? null;
$query = "SELECT a.id, u.nama AS peserta_nama, a.tanggal, a.waktu, a.absensi, a.deskripsi
          FROM absen a
          JOIN users u ON a.peserta_id = u.id
          WHERE a.mentor_id = ?
          ";

if (!empty($filter_tanggal)) {
    $query .= " AND a.tanggal = ? ";
}

$query .= " ORDER BY a.tanggal DESC, a.waktu DESC";

$stmt = $conn->prepare($query);
if (!empty($filter_tanggal)) {
    $stmt->bind_param("is", $mentor_id, $filter_tanggal);
} else {
    $stmt->bind_param("i", $mentor_id);
}

$stmt->execute();
$result = $stmt->get_result();

include "../template_mentor/header.php";
include "../template_mentor/navbar.php";
include "../template_mentor/sidebar.php";
?>

<div class="container-fluid mt-4">
    <h2 class="text-center fw-bold mb-4">Daftar Absensi Peserta</h2>

    <form method="GET" class="d-flex justify-content-center mb-3">
        <input type="date" name="tanggal" class="form-control w-25 me-2" value="<?= htmlspecialchars($filter_tanggal ?? '') ?>">
        <button type="submit" class="btn btn-primary">Filter</button>
        <?php if ($filter_tanggal): ?>
            <a href="absensi.php" class="btn btn-secondary ms-2">Reset</a>
        <?php endif; ?>
    </form>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Peserta</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Status</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>{$no}</td>";
                            echo "<td>" . htmlspecialchars($row['peserta_nama']) . "</td>";
                            echo "<td>" . date("d-m-Y", strtotime($row['tanggal'])) . "</td>";
                            echo "<td>" . date("H:i:s", strtotime($row['waktu'])) . "</td>";
                            echo "<td><span class='badge bg-primary'>" . htmlspecialchars($row['absensi']) . "</span></td>";
                            echo "<td>" . (!empty($row['deskripsi']) ? htmlspecialchars($row['deskripsi']) : '-') . "</td>";
                            echo "</tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center text-muted'>Belum ada data absensi</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include "../template_mentor/footer.php";
?>

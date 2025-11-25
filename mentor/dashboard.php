<?php
include '../auth/auth_check_mentor.php';
include '../template_mentor/header.php';
include '../template_mentor/navbar.php';
include '../template_mentor/sidebar.php';
$total_peserta_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role = 'peserta'");
$total_peserta_data = mysqli_fetch_assoc($total_peserta_query);
$total_peserta = $total_peserta_data['total'];

$result = mysqli_query($conn, "SELECT * FROM users WHERE role = 'peserta' ORDER BY created_at DESC");

$total_tugas_query = mysqli_query($conn, "SELECT COUNT(*) AS totalTugas FROM tugas");
$total_tugas_data = mysqli_fetch_assoc($total_tugas_query);
$total_tugas = $total_tugas_data['totalTugas'];

$result = mysqli_query($conn, "SELECT * FROM tugas ORDER BY created_at DESC");

$mentor_id = $_SESSION['mentor_id'];

// Hitung jumlah jawaban yang belum dinilai
$query_perlu_dinilai = "
    SELECT COUNT(j.id) AS total_belum_dinilai
    FROM jawaban j
    JOIN tugas t ON j.tugas_id = t.id
    WHERE t.mentor_id = $mentor_id
    AND j.nilai IS NULL
";
$result_perlu_dinilai = $conn->query($query_perlu_dinilai)->fetch_assoc();
$total_belum_dinilai = $result_perlu_dinilai['total_belum_dinilai'] ?? 0;

?>

<div class="container-fluid px-4 mt-2">
    <div class="container text-center">
        <h2 class="fw-bold">Dashboard Mentor</h2>
        <p>Kelola Tugas Secara Menyeluruh</p>
    </div>
    <div class="row justify-content-center">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4 shadow-lg">
                <div class="card-body d-flex flex-column align-items-center">
                    <h5 class="mb-2">Peserta Magang</h5>
                    <h2 class="fw-bold"><?php echo $total_peserta; ?></h2>
                    <small>Orang</small>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="manajemenPeserta.php">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body d-flex flex-column align-items-center">
                    <h5 class="mb-2">Total Tugas</h5>
                    <h2 class="fw-bold"><?php echo $total_tugas; ?></h2>
                    <small>Tugas</small>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="manajemenTugas.php">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body d-flex flex-column align-items-center">
                <h5 class=" mb-2">Perlu Dinilai</h5>
                <h2 class="fw-bold"><?php echo $total_belum_dinilai; ?></h2>
                <small>Penilaian</small>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="manajemenTugas.php">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include '../template_mentor/footer.php';
?>
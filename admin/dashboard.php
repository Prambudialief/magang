<?php
include '../auth/auth_check.php';
include '../template/header.php';
include '../template/navbar.php';
include '../template/sidebar.php';
$total_peserta_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role = 'peserta'");
$total_peserta_data = mysqli_fetch_assoc($total_peserta_query);
$total_peserta = $total_peserta_data['total'];

$result = mysqli_query($conn, "SELECT * FROM users WHERE role = 'peserta' ORDER BY created_at DESC");

$result_mentor = mysqli_query($conn, "SELECT COUNT(*) AS total FROM mentor");
$data_mentor = mysqli_fetch_assoc($result_mentor);
$total_mentor = $data_mentor['total'];

$total_program = mysqli_query($conn, "SELECT COUNT(*) AS totalProg FROM program_magang");
$total_program_data = mysqli_fetch_assoc($total_program);
$total_program_query = $total_program_data['totalProg'];

$result = mysqli_query($conn, "SELECT * FROM program_magang");
?>

<div class="container-fluid px-4 mt-2">
    <div class="container">
        <h2 class="text-center fw-bold mt-3 mb-2">Dashboard Admin</h2>
        <p class="text-center">Kelola Sistem MagangHub secara menyeluruh</p>
    </div>
    <div class="row justify-content-center">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body d-flex flex-column align-items-center">
                    <h5 class="mb-2">Total Peserta</h5>
                    <h2 class="mb-2"><?php echo $total_peserta ?></h2>
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
                    <h5 class="mb-2">Total Mentor</h5>
                    <h2 class="mb-2"><?php echo $total_mentor ?></h2>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body d-flex flex-column align-items-center">
                    <h5 class="mb-2">Total Program</h5>
                    <h2 class="mb-2"><?php echo $total_program_query ?></h2>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include '../template/footer.php'
?>
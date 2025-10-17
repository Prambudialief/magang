<?php
include '../auth/auth_check_mentor.php';
include '../template_mentor/header.php';
include '../template_mentor/navbar.php';
include '../template_mentor/sidebar.php';
?>

<div class="container-fluid px-4 mt-2">
    <div class="container">
        <h1>Mentor Dashboard</h1>
        <p>Kelola Tugas Secara Menyeluruh</p>
    </div>
    <div class="container">
        <h1>Manajemen Pengguna</h1>
        <p>Kelola Semua Pengguna dalam sistem MagangHub</p>
    </div>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">Peserta Magang</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">Manajemen Tugas</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">Chat Peserta</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include '../template_mentor/footer.php';
?>
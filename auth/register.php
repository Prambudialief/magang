<?php
session_start();
include "../service/connection.php";
include "proses_register.php";
$path = "C:/xampp/htdocs/magang/image/logo.jpg";
$base64 = '';
if (file_exists($path)) {
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Register</title>
    <link rel="icon" href="../image/adminpro.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<main>
    <div class="container-fluid mt-5" style="font-family: initial;">
        <div class="container text-center mt-4">
            <img src="<?php echo $base64; ?>" alt="Logo" class="brand-logo" style="width: 130px; height:130px; object-fit:cover; margin-top:20px;">
            <div>
                <p class="mb-0 text-muted">Platform manajemen magang Basarnas untuk Peserta, Mentor, dan Admin</p>
            </div>
        </div>
        <div class="container d-flex justify-content-center mt-5">
            <div class="card shadow-lg" style="max-width: 450px; width:100%;">
                <div class="card-body p-4">
                    <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="masuk-tab" href="login.php" role="tab">Masuk</a>
                        </li>

                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="masuk-tab" href="register.php" role="tab">Daftar</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <!-- Tab Daftar -->
                        <div class="tab-pane fade show active" id="daftar" role="tabpanel">
                            <form method="post" action="proses_register.php">
                                <div class="btn-group w-100 mb-3" role="group">
                                    <input type="radio" class="btn-check" name="role" id="peserta" value="Peserta" checked>
                                    <label class="btn btn-outline-primary" for="peserta"><i class="bi bi-person"></i> Peserta</label>
                                </div>
                                <!-- Form -->
                                <div class="mb-3 text-start">
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama lengkap">
                                </div>
                                <div class="mb-3 text-start">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="nama@email.com">
                                </div>
                                <div class="mb-3 text-start">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password">
                                </div>
                                <div class="mb-3 text-start">
                                    <label for="konfirmasi" class="form-label">Konfirmasi Password</label>
                                    <input type="password" class="form-control" id="konfirmasi" name="konfirmasi" placeholder="Konfirmasi password">
                                </div>
                                <button type="submit" id="submitBtn" class="btn btn-primary w-100">
                                    Daftar sebagai Peserta
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../asset/sb-admin/js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
<script src="assets/demo/chart-area-demo.js"></script>
<script src="assets/demo/chart-bar-demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
<script src="../asset/sb-admin/js/datatables-simple-demo.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const radios = document.querySelectorAll('input[name="role"]');
        const submitBtn = document.getElementById('submitBtn');

        function updateButton(role) {
            submitBtn.textContent = `Daftar sebagai ${role}`;
            submitBtn.className = "btn w-100"; // reset class

            if (role === "Peserta") {
                submitBtn.classList.add("btn-primary");
            } else if (role === "Mentor") {
                submitBtn.classList.add("btn-success");
            } else if (role === "Admin") {
                submitBtn.classList.add("btn-danger");
            }
        }

        // Set default sesuai radio yang dicentang
        updateButton(document.querySelector('input[name="role"]:checked').value);

        // Event listener saat berubah
        radios.forEach(radio => {
            radio.addEventListener('change', function() {
                updateButton(this.value);
            });
        });
    });
</script>

</html>
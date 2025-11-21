<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<style>
    .active-menu {
  background-color: rgba(0, 136, 255, 1) !important;
  color: #fff !important;
  border-radius: 8px;
  transition: background-color 0.3s ease;
}

.active-menu i {
  color: #fff !important;
}

.nav-link:hover {
  background-color: rgba(0, 136, 255, 0.8);
  color: #fff !important;
  border-radius: 8px;
}
</style>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav sb-sidenav-light">
            <div style="background-color:rgb(255, 255, 255);" class="sb-sidenav-menu border">
                <div class="nav">
                    <div class="mt-3">
                        <a class="nav-link <?php if ($current_page == 'dashboard.php') echo 'active-menu'; ?>" href="../mentor/dashboard.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                            Dashboard
                        </a>
                    </div>
                    <div class="mt-3">
                        <a class="nav-link <?php if ($current_page == 'manajemenPeserta.php') echo 'active-menu'; ?>" href="../mentor/manajemenPeserta.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                            Peserta Magang
                        </a>
                    </div>
                    <div class="mt-3">
                        <a class="nav-link <?php if ($current_page == 'materi.php') echo 'active-menu'; ?>" href="../mentor/materi.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                            Manajemen Materi
                        </a>
                    </div>
                    <div class="mt-3">
                        <a class="nav-link <?php if ($current_page == 'manajemenTugas.php') echo 'active-menu'; ?>" href="../mentor/manajemenTugas.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-person"></i></div>
                            Manajemen Tugas
                        </a>
                    </div>
                    <div class="mt-3">
                        <a class="nav-link <?php if ($current_page == 'chatPeserta.php') echo 'active-menu'; ?>" href="../mentor/chatPeserta.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-comment"></i></div>
                            Chat Peserta
                        </a>
                    </div>
                </div>
            </div>
            <div style="background-color: #EFEEEA;" class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                Mentor
            </div>
        </nav>
    </div>

    <div id="layoutSidenav_content">
        <main>
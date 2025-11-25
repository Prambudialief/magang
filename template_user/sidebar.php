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

.active-menu {
  color: #fff !important;
}

.nav-link:hover {
  background-color: rgba(0, 136, 255, 0.8);
  color: #fff !important;
  border-radius: 8px;
}
.icon-img {
  width: 20px;
  height: 20px;
  transition: filter 0.3s ease;
}

/* Hover nav */
.nav-link:hover .icon-img {
  filter: brightness(0) invert(1);
}

/* Aktif menu */
.active-menu .icon-img {
  filter: brightness(0) invert(1);
}

</style>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav sb-sidenav-light">
            <div style="background-color:rgb(255, 255, 255);" class="sb-sidenav-menu border">
                <div class="nav">
                    <div class="mt-3">
                        <a class="nav-link <?php if ($current_page == 'dashboard.php') echo 'active-menu'; ?>" href="../peserta/dashboard.php">
                            <div class="sb-nav-link-icon"><img src="../image/Home.png" class="icon-img" style="width: 20px; height:20px;"></div>
                            Dashboard
                        </a>
                    </div>
                    <div class="mt-3">
                        <a class="nav-link <?php if ($current_page == 'berita.php') echo 'active-menu'; ?>" href="../peserta/berita.php">
                            <div class="sb-nav-link-icon"><img src="../image/Berita Peserta.png" class="icon-img" style="width: 20px; height:20px;" alt=""></div>
                            Berita
                        </a>
                    </div>
                    <div class="mt-3">
                        <a class="nav-link <?php if ($current_page == 'materi.php') echo 'active-menu'; ?>" href="../peserta/materi.php">
                            <div class="sb-nav-link-icon"><img src="../image/Materi Peserta dan Mentor.png" class="icon-img" style="width: 20px; height:20px;" alt=""></div>
                            Materi
                        </a>
                    </div>
                    <div class="mt-3">
                        <a class="nav-link <?php if ($current_page == 'manajemenTugas.php') echo 'active-menu'; ?>" href="../peserta/manajemenTugas.php">
                            <div class="sb-nav-link-icon"><img src="../image/Tugas peserta dan manajemen tugas mentor.png" class="icon-img" style="width: 20px; height:20px;" alt=""></div>
                            Tugas
                        </a>
                    </div>
                    <div class="mt-3">
                        <a class="nav-link <?php if ($current_page == 'chatMentor.php') echo 'active-menu'; ?>" href="../peserta/chatMentor.php">
                            <div class="sb-nav-link-icon"><img src="../image/Chat Peserta dan Mentor.png" class="icon-img" style="width: 20px; height:20px;" alt=""></div>
                            Chat Mentor
                        </a>
                    </div>
                </div>
            </div>

            <div style="background-color: #EFEEEA;" class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                Peserta
            </div>
        </nav>
    </div>

    <div id="layoutSidenav_content">
        <main>
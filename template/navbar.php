<?php
$path = "C:/xampp/htdocs/magang/image/logo.jpg";
$base64 = '';
if (file_exists($path)) {
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $imageData = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($imageData);
}
?>
<nav class="sb-topnav navbar navbar-expand navbar-white bg-white border">
    <img src="<?php echo $base64; ?>" class="img-fluid" style="max-width: 40px; height: 40px;">
    <a style="color: black;" class="navbar-brand ps-3" href="../index/index.php">MagangHub</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <div class="input-group">
            <input class="form-control" type="text" placeholder="Search..." />
            <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
        </div>
    </form>

    <!-- Navbar User -->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" data-bs-toggle="dropdown"><i style="color: black;" class="fas fa-user fa-fw"></i></a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><hr class="dropdown-divider" /></li>
                <li><a class="dropdown-item text-center" href="../profile/profile.php">Profile</a></li>
                <li><a class="dropdown-item text-center" href="../auth/login.php">Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>

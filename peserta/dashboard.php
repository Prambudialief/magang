<?php
include "../auth/auth_check.php";
include '../template_user/header.php';
include '../template_user/navbar.php';
include '../template_user/sidebar.php';
?>

<style>
    body {
        background-color: #f8f9fa;
    }

    .program-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .program-title {
        font-weight: 700;
        text-align: center;
        margin-bottom: 40px;
        color: #333;
    }

    .program-card {
        background: #fff;
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        padding: 20px;
    }

    .program-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .program-card img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        border-radius: 12px;
        margin-bottom: 15px;
    }

    .program-card h5 {
        font-weight: 600;
        color: #212529;
        margin-bottom: 10px;
    }

    .program-card p {
        color: #6c757d;
        font-size: 15px;
    }

    @media (max-width: 768px) {
        .program-card img {
            height: 180px;
        }
    }
</style>

<div class="program-container">
    <h1 class="program-title">Program Magang</h1>
    <div class="row g-4">
        <?php
        include "../service/connection.php";
        $result = mysqli_query($conn, "SELECT * FROM program_magang");
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <div class="col-md-4 col-sm-6">
                <div class="program-card text-center">
                    <img src="../uploadMagang/<?php echo $row['image']; ?>" alt="<?php echo $row['judul']; ?>">
                    <h5><?php echo $row['judul']; ?></h5>
                    <p><?php echo $row['deskripsi']; ?></p>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php
include '../template_user/footer.php';
?>

<?php
session_start();
include "../service/connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$peserta_id = $_SESSION['user_id'];

// Pastikan ada tugas_id
if (!isset($_GET['tugas_id'])) {
    die("Tugas tidak ditemukan.");
}
$tugas_id = intval($_GET['tugas_id']);

// Ambil detail tugas
$tugas = $conn->query("SELECT * FROM tugas WHERE id=$tugas_id")->fetch_assoc();
if (!$tugas) {
    die("Tugas tidak ditemukan.");
}

// Ambil jawaban peserta ini
$sql = "
    SELECT *
    FROM jawaban
    WHERE tugas_id=$tugas_id AND peserta_id=$peserta_id
    ORDER BY submitted_at DESC
    LIMIT 1
";
$jawaban = $conn->query($sql)->fetch_assoc();

include "../template_user/header.php";
include "../template_user/navbar.php";
include "../template_user/sidebar.php";
?>

<div class="container mt-4">
    <h2>Jawaban Saya</h2>
    <h5>Tugas: <?= htmlspecialchars($tugas['judul']) ?></h5>
    <p><?= nl2br(htmlspecialchars($tugas['deskripsi'])) ?></p>
    <hr>

    <?php if ($jawaban): ?>
        <p><strong>Jawaban Teks:</strong><br><?= nl2br(htmlspecialchars($jawaban['jawaban_text'])) ?></p>
        <p><strong>File Jawaban:</strong> 
            <?php if ($jawaban['file_jawaban']): ?>
                <a href="../uploads/jawaban/<?= htmlspecialchars($jawaban['file_jawaban']) ?>" target="_blank">Download</a>
            <?php else: ?>
                -
            <?php endif; ?>
        </p>
        <p><strong>Waktu Submit:</strong> <?= $jawaban['submitted_at'] ?></p>
        <p><strong>Nilai:</strong> <?= $jawaban['nilai'] !== null ? $jawaban['nilai'] : "-" ?></p>
    <?php else: ?>
        <p class="text-danger">Anda belum mengumpulkan jawaban untuk tugas ini.</p>
    <?php endif; ?>
</div>

<?php
include "../template_user/footer.php";
?>

<?php
include "../auth/auth_check.php"; // ambil data session user
include "../template_user/header.php";
include "../template_user/navbar.php";
include "../template_user/sidebar.php";

// Pastikan parameter tugas ada
if (!isset($_GET['id'])) {
    die("Tugas tidak ditemukan.");
}

$tugas_id = intval($_GET['id']);
$peserta_id = $_SESSION['user_id']; 

$tugas = $conn->query("SELECT * FROM tugas WHERE id = $tugas_id")->fetch_assoc();
if (!$tugas) {
    die("Tugas tidak ditemukan.");
}

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jawaban_text = $_POST['jawaban_text'];
    $file_jawaban = null;

    // Upload file jika ada
    if (!empty($_FILES['file_jawaban']['name'])) {
        $targetDir = "../uploads/jawaban/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $file_jawaban = time() . "_" . basename($_FILES["file_jawaban"]["name"]);
        $targetFile = $targetDir . $file_jawaban;

        if (move_uploaded_file($_FILES["file_jawaban"]["tmp_name"], $targetFile)) {
            // sukses upload
        } else {
            echo "<div class='alert alert-danger'>Gagal upload file jawaban.</div>";
            $file_jawaban = null;
        }
    }

    // Cek apakah peserta sudah submit sebelumnya
    $cek = $conn->query("SELECT id FROM jawaban WHERE tugas_id=$tugas_id AND peserta_id=$peserta_id");
    if ($cek->num_rows > 0) {
        // update jawaban
        $sql = "UPDATE jawaban SET jawaban_text=?, file_jawaban=?, submitted_at=NOW() 
                WHERE tugas_id=? AND peserta_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $jawaban_text, $file_jawaban, $tugas_id, $peserta_id);
    } else {
        // insert jawaban baru
        $sql = "INSERT INTO jawaban (tugas_id, peserta_id, jawaban_text, file_jawaban) 
                VALUES (?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiss", $tugas_id, $peserta_id, $jawaban_text, $file_jawaban);
    }

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Jawaban berhasil dikumpulkan!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}
?>

<div class="container mt-4">
    <h2>Kumpul Jawaban</h2>
    <hr>
    <h5><?= htmlspecialchars($tugas['judul']) ?></h5>
    <p><?= nl2br(htmlspecialchars($tugas['deskripsi'])) ?></p>
    <?php if ($tugas['file_soal']): ?>
        <p>File Soal: 
            <a href="../uploads/tugas/<?= $tugas['file_soal'] ?>" target="_blank">Download</a>
        </p>
    <?php endif; ?>
    <p><strong>Deadline:</strong> <?= $tugas['deadline'] ?></p>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Jawaban Teks</label>
            <textarea name="jawaban_text" class="form-control" rows="5"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Upload File Jawaban (opsional)</label>
            <input type="file" name="file_jawaban" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Kumpulkan</button>
    </form>
</div>

<?php
include "../template_user/footer.php";
?>

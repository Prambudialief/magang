<?php
session_start();
include "../service/connection.php";

// Pastikan mentor sudah login
if (!isset($_SESSION['mentor_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$mentor_id = $_SESSION['mentor_id'];

// Pastikan ada id jawaban
if (!isset($_GET['id'])) {
    die("Jawaban tidak ditemukan.");
}
$jawaban_id = intval($_GET['id']);

// Ambil detail jawaban + tugas untuk validasi
$sql = "
    SELECT 
        j.id AS jawaban_id,
        j.jawaban_text,
        j.file_jawaban,
        j.nilai,
        j.submitted_at,
        u.nama AS peserta_nama,
        t.judul AS tugas_judul,
        t.mentor_id
    FROM jawaban j
    JOIN users u ON j.peserta_id = u.id
    JOIN tugas t ON j.tugas_id = t.id
    WHERE j.id = $jawaban_id
";

$result = $conn->query($sql);

// Jika query gagal → tampilkan error
if (!$result) {
    die("Query Error: " . $conn->error);
}

$data = $result->fetch_assoc();

// Jika data kosong → hentikan
if (!is_array($data)) {
    die("Data jawaban tidak ditemukan.");
}

// Validasi mentor
if (intval($data['mentor_id']) !== intval($mentor_id)) {
    die("Jawaban bukan milik Anda.");
}

// Jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nilai = floatval($_POST['nilai']);
    $stmt = $conn->prepare("UPDATE jawaban SET nilai=? WHERE id=?");
    $stmt->bind_param("di", $nilai, $jawaban_id);

    if ($stmt->execute()) {
        $pesan = "<div class='alert alert-success'>Nilai berhasil disimpan!</div>";
    } else {
        $pesan = "<div class='alert alert-danger'>Terjadi kesalahan: " . $conn->error . "</div>";
    }
}

include "../template_mentor/header.php";
include "../template_mentor/navbar.php";
include "../template_mentor/sidebar.php";
?>

<div class="container mt-4">
    <h2>Penilaian Jawaban</h2>
    <hr>
    <?php if (isset($pesan)) echo $pesan; ?>

    <h5>Tugas: <?= htmlspecialchars($data['tugas_judul']) ?></h5>
    <p><strong>Peserta:</strong> <?= htmlspecialchars($data['peserta_nama']) ?></p>
    <p><strong>Jawaban Teks:</strong><br><?= nl2br(htmlspecialchars($data['jawaban_text'])) ?></p>
    <p><strong>File Jawaban:</strong>
        <?php if ($data['file_jawaban']): ?>
            <a href="../uploads/jawaban/<?= htmlspecialchars($data['file_jawaban']) ?>" target="_blank">Download</a>
        <?php else: ?>
            -
        <?php endif; ?>
    </p>
    <p><strong>Waktu Submit:</strong> <?= $data['submitted_at'] ?></p>

    <form method="POST" class="mt-3">
        <div class="mb-3">
            <label class="form-label">Nilai</label>
            <input type="number" name="nilai" class="form-control" step="0.01" value="<?= isset($data['nilai']) ? htmlspecialchars($data['nilai']) : '' ?>"
            required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Nilai</button>
        <a href="manajemenTugas.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?php
include "../template_mentor/footer.php";
?>

<?php
session_start();
include "../service/connection.php";

// pastikan peserta login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Peserta') {
    header("Location: ../auth/login.php");
    exit;
}
$peserta_id = (int) $_SESSION['user_id'];

// kirim pesan
if (isset($_POST['kirim'])) {
    $mentor_id = (int) $_POST['mentor_id'];
    $pesan = trim($_POST['pesan']);

    if ($mentor_id > 0 && $pesan !== '') {
        $stmt = $conn->prepare("INSERT INTO chat (mentor_id, peserta_id, pengirim, pesan) VALUES (?, ?, 'peserta', ?)");
        $stmt->bind_param("iis", $mentor_id, $peserta_id, $pesan);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: chatMentorku.php?mentor_id={$mentor_id}");
    exit;
}

// jika belum pilih mentor → tampilkan daftar mentor
if (!isset($_GET['mentor_id'])) {
    $res = $conn->query("SELECT id, nama, email, created_at FROM mentor ORDER BY created_at DESC");

    include "../template_peserta/header.php";
    include "../template_peserta/navbar.php";
    include "../template_peserta/sidebar.php";
    ?>
    <div class="container mt-4">
        <h2>Daftar Mentor</h2>
        <table class="table table-bordered">
            <thead>
                <tr><th>No</th><th>Nama</th><th>Email</th><th>Tgl Daftar</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                <?php $no=1; while($row=$res->fetch_assoc()){ ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= date("d-m-Y H:i", strtotime($row['created_at'])) ?></td>
                    <td><a href="chatMentorku.php?mentor_id=<?= $row['id'] ?>" class="btn btn-success btn-sm">Chat</a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php
    include "../template_peserta/footer.php";
    exit;
}

// jika sudah pilih mentor
$mentor_id = (int) $_GET['mentor_id'];

// ambil data mentor
$stmt = $conn->prepare("SELECT id, nama FROM mentor WHERE id=? LIMIT 1");
$stmt->bind_param("i", $mentor_id);
$stmt->execute();
$resMentor = $stmt->get_result();
$mentor = $resMentor->fetch_assoc();
$stmt->close();

if (!$mentor) {
    header("Location: chatMentorku.php");
    exit;
}

// ambil semua chat peserta <-> mentor
$stmt = $conn->prepare("
    SELECT * FROM chat 
    WHERE mentor_id=? AND peserta_id=? 
    ORDER BY created_at ASC
");
$stmt->bind_param("ii", $mentor_id, $peserta_id);
$stmt->execute();
$chats = $stmt->get_result();
$stmt->close();

// tampilkan UI
include "../template_user/header.php";
include "../template_user/navbar.php";
include "../template_user/sidebar.php";
?>

<div class="container mt-4">
    <h2>Chat dengan Mentor: <?= htmlspecialchars($mentor['nama']) ?></h2>
    <div class="card mt-3">
        <div class="card-body chat-box" style="height:420px;overflow-y:auto;background:#f8f9fa;">
            <?php while($row=$chats->fetch_assoc()){ ?>
                <?php if ($row['pengirim'] === 'peserta') { ?>
                    <!-- bubble peserta -->
                    <div class="d-flex justify-content-end mb-2">
                        <div class="p-2 rounded bg-success text-white" style="max-width:70%;">
                            <?= nl2br(htmlspecialchars($row['pesan'])) ?>
                            <div class="text-end" style="font-size:0.75em;opacity:0.8;">
                                <?= date("d-m-Y H:i", strtotime($row['created_at'])) ?>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <!-- bubble mentor -->
                    <div class="d-flex justify-content-start mb-2">
                        <div class="p-2 rounded bg-light" style="max-width:70%;">
                            <strong><?= htmlspecialchars($mentor['nama']) ?>:</strong><br>
                            <?= nl2br(htmlspecialchars($row['pesan'])) ?>
                            <div class="text-muted" style="font-size:0.75em;">
                                <?= date("d-m-Y H:i", strtotime($row['created_at'])) ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>

        <div class="card-footer">
            <form method="POST" class="d-flex">
                <input type="hidden" name="mentor_id" value="<?= $mentor_id ?>">
                <input type="text" name="pesan" class="form-control" placeholder="Tulis pesan..." required>
                <button type="submit" name="kirim" class="btn btn-success ms-2">Kirim</button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function(){
    let box = document.querySelector('.chat-box');
    if(box) box.scrollTop = box.scrollHeight;
});
</script>

<?php include "../template_user/footer.php"; ?>

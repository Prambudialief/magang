<?php
session_start();
include "../service/connection.php";

// pastikan mentor login
if (!isset($_SESSION['mentor_id'])) {
    header("Location: ../auth/login.php");
    exit;
}
$mentor_id = (int) $_SESSION['mentor_id'];

// kirim pesan
if (isset($_POST['kirim'])) {
    $peserta_id = (int) $_POST['peserta_id'];
    $pesan = trim($_POST['pesan']);

    if ($peserta_id > 0 && $pesan !== '') {
        $stmt = $conn->prepare("INSERT INTO chat (mentor_id, peserta_id, pengirim, pesan) VALUES (?, ?, 'mentor', ?)");
        $stmt->bind_param("iis", $mentor_id, $peserta_id, $pesan);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: chatPesertaku.php?peserta_id={$peserta_id}");
    exit;
}

// jika belum pilih peserta → tampilkan daftar peserta
if (!isset($_GET['peserta_id'])) {
    $res = $conn->query("SELECT id, nama, email, created_at FROM users WHERE role='Peserta' ORDER BY created_at DESC");

    include "../template_mentor/header.php";
    include "../template_mentor/navbar.php";
    include "../template_mentor/sidebar.php";
    ?>
    <div class="container mt-4">
        <h2>Daftar Peserta</h2>
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
                    <td><a href="chatPesertaku.php?peserta_id=<?= $row['id'] ?>" class="btn btn-success btn-sm">Chat</a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php
    include "../template_mentor/footer.php";
    exit;
}

// jika sudah pilih peserta
$peserta_id = (int) $_GET['peserta_id'];

// ambil data peserta
$stmt = $conn->prepare("SELECT id, nama FROM users WHERE id=? AND role='Peserta' LIMIT 1");
$stmt->bind_param("i", $peserta_id);
$stmt->execute();
$resPeserta = $stmt->get_result();
$peserta = $resPeserta->fetch_assoc();
$stmt->close();

if (!$peserta) {
    header("Location: chatPesertaku.php");
    exit;
}

// ambil semua chat mentor <-> peserta
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
include "../template_mentor/header.php";
include "../template_mentor/navbar.php";
include "../template_mentor/sidebar.php";
?>

<div class="container mt-4">
    <h2>Chat dengan Peserta: <?= htmlspecialchars($peserta['nama']) ?></h2>
    <div class="card mt-3">
        <div class="card-body chat-box" style="height:420px;overflow-y:auto;background:#f8f9fa;">
            <?php while($row=$chats->fetch_assoc()){ ?>
                <?php if ($row['pengirim'] === 'mentor') { ?>
                    <!-- bubble mentor -->
                    <div class="d-flex justify-content-end mb-2">
                        <div class="p-2 rounded bg-primary text-white" style="max-width:70%;">
                            <?= nl2br(htmlspecialchars($row['pesan'])) ?>
                            <div class="text-end" style="font-size:0.75em;opacity:0.8;">
                                <?= date("d-m-Y H:i", strtotime($row['created_at'])) ?>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <!-- bubble peserta -->
                    <div class="d-flex justify-content-start mb-2">
                        <div class="p-2 rounded bg-light" style="max-width:70%;">
                            <strong><?= htmlspecialchars($peserta['nama']) ?>:</strong><br>
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
                <input type="hidden" name="peserta_id" value="<?= $peserta_id ?>">
                <input type="text" name="pesan" class="form-control" placeholder="Tulis pesan..." required>
                <button type="submit" name="kirim" class="btn btn-primary ms-2">Kirim</button>
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

<?php include "../template_mentor/footer.php"; ?>

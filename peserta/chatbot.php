<?php
header('Content-Type: application/json');

// Ambil pesan dari user
$userMessage = strtolower(trim($_POST['message'] ?? ''));

// Daftar pertanyaan dan jawaban (bisa dikembangkan nanti)
$responses = [
    "halo" => "Halo juga! 👋 Saya Asisten MagangHub, siap membantu kamu!",
    "tugas" => "Untuk Tugas Kamu Bisa Lihat di menu tugas ya.",
    "materi" => "Untuk materi kamu bisa lihat di menu materi ya.",
    "izin" => "Untuk izin, buka menu <b>chat</b> lalu kamu bisa izin disana",
    "terima kasih" => "Sama-sama! 😊 Senang bisa membantu kamu."
];

// Default jawaban
$response = "Maaf, saya belum mengerti pertanyaan kamu. Coba gunakan kata kunci seperti 'upload laporan', 'deadline', atau 'izin'.";

// Cari kecocokan kata
foreach ($responses as $key => $reply) {
    if (strpos($userMessage, $key) !== false) {
        $response = $reply;
        break;
    }
}

// Kirim sebagai JSON
echo json_encode(["reply" => $response]);
?>

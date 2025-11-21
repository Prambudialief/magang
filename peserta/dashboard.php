<?php
include "../auth/auth_check.php";
include '../template_user/header.php';
include '../template_user/navbar.php';
include '../template_user/sidebar.php';

$peserta_id = $_SESSION['user_id'];


$total_tugas = $conn->query("SELECT COUNT(*) AS total FROM tugas")->fetch_assoc()['total'];

$tugas_selesai = $conn->query("
    SELECT COUNT(*) AS total 
    FROM jawaban 
    WHERE peserta_id = $peserta_id AND nilai IS NOT NULL
")->fetch_assoc()['total'];

$tugas_belum = $total_tugas - $tugas_selesai;

$sql = "
  SELECT 
      m.id, 
      m.judul, 
      m.file_soal, 
      m.deskripsi, 
      m.deadline, 
      mentor.nama AS nama_mentor,
      j.id AS jawaban_id,
      j.nilai
  FROM tugas m
  JOIN mentor ON m.mentor_id = mentor.id
  LEFT JOIN jawaban j ON j.tugas_id = m.id AND j.peserta_id = $peserta_id
  ORDER BY m.created_at DESC
  LIMIT 5
";

$result = $conn->query($sql);

$tugas_terbaru = [];
if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $tugas_terbaru[] = $row;
  }
}
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

  #chatbot-toggle {
    position: fixed;
    bottom: 25px;
    right: 25px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    font-size: 28px;
    cursor: pointer;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    transition: all 0.3s ease;
  }

  #chatbot-toggle:hover {
    background-color: #0056b3;
  }

  #chatbot-container {
    position: fixed;
    bottom: 100px;
    right: 30px;
    width: 320px;
    background-color: white;
    border-radius: 15px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    display: none;
    flex-direction: column;
    overflow: hidden;
    font-family: "Segoe UI", sans-serif;
    z-index: 1000;
  }

  #chatbot-header {
    background-color: #007bff;
    color: white;
    padding: 12px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  #chatbot-header .bot-icon {
    width: 28px;
    height: 28px;
    margin-right: 10px;
  }

  #chatbot-header .bot-title {
    flex: 1;
    font-weight: bold;
    font-size: 15px;
  }

  #chatbot-header button {
    background: none;
    border: none;
    color: white;
    font-size: 18px;
    cursor: pointer;
  }

  #chatbot-body {
    padding: 10px;
    height: 300px;
    overflow-y: auto;
    background-color: #f9f9f9;
  }

  .message {
    padding: 8px 12px;
    border-radius: 10px;
    margin: 5px 0;
    display: inline-block;
    max-width: 80%;
  }

  .message.bot {
    background-color: #e9ecef;
    color: #000;
    align-self: flex-start;
  }

  .message.user {
    background-color: #007bff;
    color: white;
    align-self: flex-end;
    text-align: right;
  }

  #chatbot-input {
    display: flex;
    padding: 10px;
    border-top: 1px solid #ddd;
    background-color: #fff;
  }

  #chatbot-input input {
    flex: 1;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 20px;
    outline: none;
  }

  #chatbot-input button {
    background-color: #007bff;
    border: none;
    color: white;
    border-radius: 50%;
    width: 35px;
    height: 35px;
    margin-left: 8px;
    cursor: pointer;
    font-size: 16px;
  }

  #chatbot-input button:hover {
    background-color: #0056b3;
  }

  @media (max-width: 768px) {
    .program-card img {
      height: 180px;
    }
  }
</style>
<div class="container-fluid px-4">
  <h1 class="mt-4 text-center fw-bold">Dashboard Peserta</h1>
  <p class="text-center">Selamat datang, <?php echo htmlspecialchars($_SESSION['nama']); ?> 👋</p>
  <div class="container mt-5">
    <div class="row justify-content-center g-4">

      <div class="col-md-7">
        <div class="card p-4 shadow-sm border-0" style="border-radius: 20px;">
          <h4 class="card-title fw-bold mb-3">
            <i class="fa-solid fa-clock text-primary me-2"></i> Tugas Terbaru
          </h4>
          <div class="card-body">
            <?php if (!empty($tugas_terbaru)) : ?>
              <ul class="list-group list-group-flush">
                <?php foreach ($tugas_terbaru as $tugas) : ?>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                      <strong><?php echo htmlspecialchars($tugas['judul']); ?></strong><br>
                      <small class="text-muted">
                        Dari: <?php echo htmlspecialchars($tugas['nama_mentor']); ?> |
                        Deadline: <?php echo htmlspecialchars(date('d M Y', strtotime($tugas['deadline']))); ?>
                      </small>
                    </div>

                    
                    <?php if ($tugas['jawaban_id']) : ?>
                      <span class="badge bg-success">Dikumpulkan</span>
                    <?php else : ?>
                      <a href="manajemenTugas.php?id=<?php echo $tugas['id']; ?>" class="btn btn-sm btn-primary">
                        Kumpulkan
                      </a>
                    <?php endif; ?>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php else : ?>
              <p class="text-muted">Belum ada tugas terbaru dari mentor.</p>
            <?php endif; ?>
          </div>

        </div>
      </div>

      <div class="col-md-5">
        <div class="card shadow-lg border-0" style="border-radius: 20px;">
          <div class="card-body text-center">
            <h4 class="card-title fw-bold mb-3">
              <i class="bi bi-bar-chart-fill text-primary me-2"></i> Statistik
            </h4>
            <p class="card-subtitle text-muted mb-4">
              Ringkasan statistik Anda,
              <span class="fw-semibold text-dark">
                <?php echo htmlspecialchars($_SESSION['nama']); ?>
              </span>
            </p>

            <div class="d-flex flex-column align-items-center gap-4 mt-3">
              <div class="p-3 rounded-4 w-100 shadow-sm d-flex align-items-center justify-content-between"
                style="background-color:#e7f1ff; border:solid #0d6efd;">
                <div class="d-flex align-items-center">
                  <i class="fa-solid fa-paper-plane text-primary fs-3 me-3"></i>
                  <span class="fw-bold text-primary">Total Tugas</span>
                </div>
                <h3 class="fw-bold mb-0 text-dark"><?php echo $total_tugas; ?></h3>
              </div>

              <div class="p-3 rounded-4 w-100 shadow-sm d-flex align-items-center justify-content-between"
                style="background-color:#e9fbe7; border:solid #198754;">
                <div class="d-flex align-items-center">
                  <i class="fa-solid fa-circle-check text-success fs-3 me-3"></i>
                  <span class="fw-bold text-success">Tugas Selesai</span>
                </div>
                <h3 class="fw-bold mb-0 text-dark"><?php echo $tugas_selesai; ?></h3>
              </div>

              <div class="p-3 rounded-4 w-100 shadow-sm d-flex align-items-center justify-content-between"
                style="background-color:#fff6e7; border:solid #ffc107;">
                <div class="d-flex align-items-center">
                  <i class="fa-solid fa-hourglass-half text-warning fs-3 me-3"></i>
                  <span class="fw-bold text-warning">Belum Selesai</span>
                </div>
                <h3 class="fw-bold mb-0 text-dark"><?php echo $tugas_belum; ?></h3>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

</div>

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

<div id="chatbot-container">
  <div id="chatbot-header">
    <img src="https://cdn-icons-png.flaticon.com/512/4712/4712027.png" alt="Bot" class="bot-icon">
    <span class="bot-title">Asisten MagangHub</span>
    <button id="chatbot-close">×</button>
  </div>

  <div id="chatbot-body">
    <div id="chat-messages">
      <div class="message bot">Halo! Saya Asisten MagangHub 😊<br>Ada yang bisa saya bantu hari ini?</div>
    </div>
  </div>

  <div id="chatbot-input">
    <input type="text" id="user-input" placeholder="Tulis pesan..." autocomplete="off" />
    <button id="send-btn">➤</button>
  </div>
</div>

<button id="chatbot-toggle">
  💬
</button>


<script>
  const toggle = document.getElementById("chatbot-toggle");
  const container = document.getElementById("chatbot-container");
  const closeBtn = document.getElementById("chatbot-close");
  const sendBtn = document.getElementById("send-btn");
  const input = document.getElementById("user-input");
  const chatMessages = document.getElementById("chat-messages");

  toggle.onclick = () => container.style.display = "flex";
  closeBtn.onclick = () => container.style.display = "none";

  sendBtn.onclick = sendMessage;
  input.addEventListener("keypress", (e) => {
    if (e.key === "Enter") sendMessage();
  });

  function sendMessage() {
    let message = input.value.trim();
    if (!message) return;
    input.value = "";

    addMessage(message, "user");

    fetch("chatbot.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "message=" + encodeURIComponent(message)
      })
      .then(res => res.json())
      .then(data => {
        addMessage(data.reply, "bot");
      })
      .catch(() => {
        addMessage("Terjadi kesalahan pada server.", "bot");
      });
  }

  function addMessage(text, sender) {
    const msgDiv = document.createElement("div");
    msgDiv.classList.add("message", sender);
    msgDiv.innerHTML = text;
    chatMessages.appendChild(msgDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight;
  }
</script>

<?php
include '../template_user/footer.php';
?>
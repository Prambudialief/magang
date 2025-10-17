<?php
include "../auth/auth_check.php";
include "../template_user/header.php";
include "../template_user/navbar.php";
include "../template_user/sidebar.php";

$peserta_id = $_SESSION['user_id']; // ambil id peserta dari session

// Ambil semua tugas beserta nama mentor + nilai jawaban peserta
$result = $conn->query("
    SELECT 
        m.id, 
        m.judul, 
        m.file_soal, 
        m.deskripsi, 
        m.deadline, 
        mentor.nama, 
        j.id AS jawaban_id,
        j.nilai
    FROM tugas m
    JOIN mentor ON m.mentor_id = mentor.id
    LEFT JOIN jawaban j ON j.tugas_id = m.id AND j.peserta_id = $peserta_id
    ORDER BY m.created_at DESC
");
?>

<div class="container-fluid px-4">
    <div class="mt-3">
        <h1 class="text-center fw-bold">Daftar Tugas</h1>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Mentor</th>
                        <th>Deadline</th>
                        <th>File Soal</th>
                        <th>Aksi</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['judul']) . "</td>";
                    echo "<td>" . nl2br(htmlspecialchars($row['deskripsi'])) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                    echo "<td>" . date("d-m-Y", strtotime($row['deadline'])) . "</td>";
                    echo "<td>";
                        if (!empty($row['file_soal'])) {
                            echo "<a href='../uploads/tugas/" . htmlspecialchars($row['file_soal']) . "' target='_blank' class='btn btn-sm btn-success'>Download</a>";
                        } else {
                            echo "-";
                        }
                    echo "</td>";

                    echo "<td>";
                        // Jika nilai sudah ada → disable tombol kumpul jawaban
                        if (!is_null($row['nilai'])) {
                            echo "<button class='btn btn-secondary btn-sm' disabled>Sudah Dinilai</button> ";
                        } else {
                            echo "<a href='kumpulJawaban.php?id={$row['id']}' class='btn btn-primary btn-sm'>Kumpulkan Jawaban</a> ";
                        }
                        echo "<a href='lihatJawabanSaya.php?tugas_id={$row['id']}' class='btn btn-info btn-sm'>Lihat Jawaban</a>";
                    echo "</td>";

                    // Kolom nilai
                    echo "<td>";
                        if (!is_null($row['nilai'])) {
                            echo "<span class='badge bg-success'>" . htmlspecialchars($row['nilai']) . "</span>";
                        } else {
                            echo "<span class='badge bg-warning'>Belum Dinilai</span>";
                        }
                    echo "</td>";

                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include "../template_user/footer.php";
?>

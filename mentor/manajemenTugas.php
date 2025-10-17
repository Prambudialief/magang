<?php
include 'sistemTugas.php';
include '../template_mentor/header.php';
include '../template_mentor/navbar.php';
include '../template_mentor/sidebar.php';
?>

<div class="container">
    <h2>Manajemen Tugas</h2>
    <hr>

    <!-- Form Tambah Tugas -->
    <form method="POST" enctype="multipart/form-data" class="mb-4">
        <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">File Soal (opsional)</label>
            <input type="file" name="file_soal" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Deadline</label>
            <input type="date" name="deadline" class="form-control" required>
        </div>
        <button type="submit" name="simpan" class="btn btn-primary">Tambah</button>
    </form>

    <!-- Tabel Daftar Tugas -->
    <h4>Daftar Tugas</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>File Soal</th>
                <th>Deadline</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM tugas WHERE mentor_id='$mentor_id' ORDER BY created_at DESC");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td>{$row['judul']}</td>
                <td>{$row['deskripsi']}</td>
                <td>";
                if ($row['file_soal']) {
                    echo "<a href='../uploads/tugas/{$row['file_soal']}' target='_blank'>Download</a>";
                } else {
                    echo "-";
                }
            echo "</td>
                <td>{$row['deadline']}</td>
                <td>
                    <a href='editTugas.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                    <a href='sistemTugas.php?hapus={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin hapus?\")'>Hapus</a>
                </td>
            </tr>";
        }
        ?>
        </tbody>
    </table>

    <!-- Tabel Jawaban Peserta -->
    <h4 class="mt-5">Jawaban Peserta</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peserta</th>
                <th>Tugas</th>
                <th>Jawaban Teks</th>
                <th>File Jawaban</th>
                <th>Waktu Submit</th>
                <th>Nilai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sql = "
            SELECT j.*, u.nama AS peserta_nama, t.judul AS tugas_judul
            FROM jawaban j
            JOIN users u ON j.peserta_id = u.id
            JOIN tugas t ON j.tugas_id = t.id
            WHERE t.mentor_id='$mentor_id'
            ORDER BY j.submitted_at DESC
        ";
        $resJawaban = mysqli_query($conn, $sql);
        $no = 1;
        while ($row = mysqli_fetch_assoc($resJawaban)) {
            echo "<tr>
                <td>{$no}</td>
                <td>{$row['peserta_nama']}</td>
                <td>{$row['tugas_judul']}</td>
                <td>" . nl2br(htmlspecialchars($row['jawaban_text'])) . "</td>
                <td>";
                if ($row['file_jawaban']) {
                    echo "<a href='../uploads/jawaban/{$row['file_jawaban']}' target='_blank'>Download</a>";
                } else {
                    echo "-";
                }
            echo "</td>
                <td>{$row['submitted_at']}</td>
                <td>" . ($row['nilai'] !== null ? $row['nilai'] : "-") . "</td>
                <td><a href='nilaiJawaban.php?id={$row['id']}' class='btn btn-sm btn-primary'>Beri Nilai</a></td>
            </tr>";
            $no++;
        }
        ?>
        </tbody>
    </table>
</div>

<?php
include '../template_mentor/footer.php';
?>

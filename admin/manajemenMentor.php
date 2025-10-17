<?php
include "../auth/auth_check.php";
include "../template/header.php";
include "../template/navbar.php";
include "../template/sidebar.php";

// ================== CREATE ==================
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // hash biar aman
    $bidang = $_POST['bidang_keahlian'];

    // upload foto
    $foto = null;
    if ($_FILES['foto']['name'] != "") {
        $targetDir = "../uploads/";
        $foto = time() . "_" . basename($_FILES["foto"]["name"]);
        $targetFile = $targetDir . $foto;
        move_uploaded_file($_FILES["foto"]["tmp_name"], $targetFile);
    }

    $query = "INSERT INTO mentor (nama, email, password, bidang_keahlian, foto)
              VALUES ('$nama','$email','$password','$bidang','$foto')";
    mysqli_query($conn, $query) or die(mysqli_error($conn));
    header("Location: manajemenMentor.php");
    exit;
}

// ================== UPDATE ==================
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $bidang = $_POST['bidang_keahlian'];

    // optional update password
    $password_sql = "";
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $password_sql = ", password='$password'";
    }

    // upload foto baru jika ada
    $foto_sql = "";
    if ($_FILES['foto']['name'] != "") {
        $targetDir = "../uploads/";
        $foto = time() . "_" . basename($_FILES["foto"]["name"]);
        $targetFile = $targetDir . $foto;
        move_uploaded_file($_FILES["foto"]["tmp_name"], $targetFile);
        $foto_sql = ", foto='$foto'";
    }

    $query = "UPDATE mentor SET nama='$nama', email='$email', bidang_keahlian='$bidang' 
              $password_sql $foto_sql WHERE id=$id";
    mysqli_query($conn, $query) or die(mysqli_error($conn));
    header("Location: manajemenMentor.php");
    exit;
}

// ================== DELETE ==================
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM mentor WHERE id=$id") or die(mysqli_error($conn));
    header("Location: manajemenMentor.php");
    exit;
}

// ================== READ ==================
$result = mysqli_query($conn, "SELECT * FROM mentor");
?>
<h2>Manajemen Mentor</h2>

<!-- Form Tambah -->
<div class="card mb-4">
    <div class="card-header">Tambah Mentor</div>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Bidang Keahlian</label>
                <input type="text" name="bidang_keahlian" class="form-control" placeholder="UI/UX, Backend, Frontend">
            </div>
            <div class="mb-3">
                <label>Foto</label>
                <input type="file" name="foto" class="form-control">
            </div>
            <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

<!-- List Data -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Foto</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Keahlian</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td>
                <?php if ($row['foto']) { ?>
                    <img src="../uploads/<?= $row['foto'] ?>" width="60">
                <?php } else { ?>
                    -
                <?php } ?>
            </td>
            <td><?= $row['nama'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['bidang_keahlian'] ?></td>
            <td>
                <!-- Edit Form Modal -->
                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit<?= $row['id'] ?>">Edit</button>
                <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus?')" class="btn btn-danger btn-sm">Hapus</a>

                <!-- Modal -->
                <div class="modal fade" id="edit<?= $row['id'] ?>" tabindex="-1">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5>Edit Mentor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>
                      <div class="modal-body">
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <div class="mb-3">
                                <label>Nama</label>
                                <input type="text" name="nama" class="form-control" value="<?= $row['nama'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="<?= $row['email'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Password (kosongkan jika tidak ganti)</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Bidang Keahlian</label>
                                <input type="text" name="bidang_keahlian" class="form-control" value="<?= $row['bidang_keahlian'] ?>">
                            </div>
                            <div class="mb-3">
                                <label>Foto</label>
                                <input type="file" name="foto" class="form-control">
                            </div>
                            <button type="submit" name="update" class="btn btn-success">Update</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<?php
include "../template/footer.php";
?>
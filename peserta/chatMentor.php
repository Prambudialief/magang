<?php
include "../auth/auth_check.php";
include "../template_user/header.php";
include "../template_user/navbar.php";
include "../template_user/sidebar.php";
$result = mysqli_query($conn, "SELECT * FROM mentor")
?>

<div class="container-fluid px-4 mt-4">
    <h1 class="text-center fw-bold">Chat mentor</h1>
    <div class="card mx-auto mt-4" style="max-width:1200px;">
        <div class="card-header">
            Daftar mentor
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Keahlian</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row['nama'] ?></td>
                                <td><?= $row['bidang_keahlian'] ?></td>
                                <td> <?php if ($row['foto']) { ?>
                                        <img src="../uploads/<?= $row['foto'] ?>"class="img-fluid" style="width:60px; height:60px; object-fit:cover;">
                                    <?php } else { ?>
                                        -
                                    <?php } ?>
                                </td>
                                <td><a href="chatMentorku.php?mentor_id=<?= $row['id'] ?>" class="btn btn-success btn-sm w-100">Chat</a> </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include "../template_user/footer.php";
?>
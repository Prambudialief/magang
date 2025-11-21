<?php
include '../template_user/header.php';
include '../template_user/navbar.php';
include '../template_user/sidebar.php';
?>

<div class="container p-3">
    <h2 class="mt-3 text-center fw-bold">Daftar Berita Basarnas</h2>
    <p class="mt-2 text-center">Beragam Informasi Operasi SAR Aktif dari Basarnas</p>

    <?php
    $url = "https://qrsar.basarnas.go.id/services/aktif_opssar";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    if ($data && is_array($data)) {
        echo '<div class="row">';

        foreach ($data as $item) {
            $no_berita = htmlspecialchars($item['no_berita'] ?? '-');
            $nama_kansar = htmlspecialchars($item['nama_kansar'] ?? '-');
            $nama_berita = htmlspecialchars($item['nama_berita'] ?? '-');
            $jenis = htmlspecialchars($item['jenis_kecelakaan'] ?? '-');
            $sub = htmlspecialchars($item['sub_kecelakaan'] ?? '-');
            $tgl_kejadian = htmlspecialchars($item['tgl_kejadian'] ?? '-');
            $tgl_lapor = htmlspecialchars($item['tgl_lapor'] ?? '-');

            echo '
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">' . $nama_berita . '</h5>
                        <p class="card-text mb-1"><strong>No. Berita:</strong> ' . $no_berita . '</p>
                        <p class="card-text mb-1"><strong>Kantor SAR:</strong> ' . $nama_kansar . '</p>
                        <p class="card-text mb-1"><strong>Jenis:</strong> ' . $jenis . '</p>
                        <p class="card-text mb-1"><strong>Sub Jenis:</strong> ' . $sub . '</p>
                        <p class="card-text mb-1"><strong>Tanggal Kejadian:</strong> ' . $tgl_kejadian . '</p>
                        <p class="card-text mb-1"><strong>Tanggal Lapor:</strong> ' . $tgl_lapor . '</p>
                    </div>
                </div>
            </div>';
        }

        echo '</div>';
    } else {
        echo '<div class="alert alert-warning text-center">Gagal memuat data dari API.</div>';
    }
    ?>
</div>

<?php
include '../template_user/footer.php';
?>

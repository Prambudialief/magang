<?php
require __DIR__ . '/../vendor/autoload.php';
include '../service/connection.php';


use Dompdf\Dompdf;

$result = mysqli_query($conn, "SELECT * FROM mentor");

$html = '<h2 style="text-align:center;">Data Peserta</h2>';
$html .= '<table border="1" cellspacing="0" cellpadding="5" width="100%">
            <thead>
              <tr>
                <th>Foto</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Keahlian</th>
              </tr>
            </thead>
            <tbody>';

while ($row = mysqli_fetch_assoc($result)) {
    if (!empty($row['foto']) && file_exists("../uploads/" . $row['foto'])) {
        $fotoPath = "../uploads/" . $row['foto'];
        $fotoData = base64_encode(file_get_contents($fotoPath));
        $fotoSrc = 'data:image/jpeg;base64,' . $fotoData;
        $fotoTag = "<img src='$fotoSrc' width='60'>";
    } else {
        $fotoTag = "-";
    }
    $html .= "<tr>
                 <td style='text-align:center;'>$fotoTag</td>
                <td>{$row['nama']}</td>
                <td>{$row['email']}</td>
                <td>{$row['bidang_keahlian']}</td>
                </tr>";
}

$html .= '</tbody></table>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

$dompdf->stream("Data Mentor.pdf", ["Attachment" => false]);

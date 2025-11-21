<?php
require __DIR__ . '/../vendor/autoload.php';
include '../service/connection.php';


use Dompdf\Dompdf;

$result = mysqli_query($conn, "SELECT * FROM users WHERE role = 'peserta'");

$html = '<h2 s="texttyle-align:center;">Data Peserta</h2>';
$html .= '<table border="1" cellspacing="0" cellpadding="5" width="100%">
            <thead>
              <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Tanggal Daftar</th>
              </tr>
            </thead>
            <tbody>';
while ($row = mysqli_fetch_assoc($result)) {
    $html .= "<tr>
                <td>{$row['nama']}</td>
                <td>{$row['email']}</td>
                <td>{$row['created_at']}</td>
                </tr>";
}

$html .= '</tbody></table>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

$dompdf->stream("Data Peserta.pdf", ["Attachment" => false]);
?>
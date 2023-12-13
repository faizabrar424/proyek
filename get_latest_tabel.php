<?php
include 'koneksi.php';

$query = "SELECT ketinggian_air, waktu FROM bendungan ORDER BY waktu DESC LIMIT 10";
$result = mysqli_query($koneksi, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = array(
        'ketinggian_air' => $row['ketinggian_air'],
        'waktu' => $row['waktu']
    );
}

header('Content-Type: application/json');
echo json_encode($data);
?>

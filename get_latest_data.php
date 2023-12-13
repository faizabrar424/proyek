<?php
include 'koneksi.php';

$sql_ID = mysqli_query($koneksi,"SELECT MAX(ID) FROM bendungan");
$data_ID = mysqli_fetch_array($sql_ID);
$ID_akhir = $data_ID['MAX(ID)'];
$ID_awal = $ID_akhir - 5;

$tgl_waktu = mysqli_query($koneksi, "SELECT waktu FROM bendungan WHERE ID>='$ID_awal' AND ID<='$ID_akhir' ORDER BY ID ASC");
$ketinggian_air = mysqli_query($koneksi, "SELECT ketinggian_air FROM bendungan WHERE ID>='$ID_awal' AND ID<='$ID_akhir' ORDER BY ID ASC");

$tgl_waktu_array = array();
$ketinggian_air_array = array();

while ($row = mysqli_fetch_array($tgl_waktu)) {
    $tgl_waktu_array[] = $row['waktu'];
}

while ($row = mysqli_fetch_array($ketinggian_air)) {
    $ketinggian_air_array[] = $row['ketinggian_air'];
}

$data = array(
    'labels' => $tgl_waktu_array,
    'ketinggian_air' => $ketinggian_air_array
);

// Mengirim data dalam format JSON
header('Content-Type: application/json');
echo json_encode($data);
?>

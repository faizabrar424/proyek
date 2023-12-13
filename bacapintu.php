<?php
include "koneksi.php";

$sql = mysqli_query($koneksi, "SELECT * FROM kontrol");
$data = mysqli_fetch_array($sql);
$pintu = $data['pintu'];

echo $pintu
?>
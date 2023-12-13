<?php
include "koneksi.php";

$posisi = $_GET['posisi'];
if ($posisi === "90") {
    // ubah field servo untuk terbuka setengah
    mysqli_query($koneksi, "UPDATE kontrol SET pintu=90");
    // berikan respons
    echo "Terbuka setengah";
} else if ($posisi === "180") {
    // ubah field servo untuk terbuka
    mysqli_query($koneksi, "UPDATE kontrol SET pintu=180");
    // berikan respons
    echo "Terbuka";
} else if ($posisi === "0") { 
    // ubah field servo untuk tertutup jika diperlukan
    mysqli_query($koneksi, "UPDATE kontrol SET pintu=0");
    echo "Tertutup";
} else {
    echo "Kondisi tidak valid";
}


?>


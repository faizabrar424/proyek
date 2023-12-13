
<?php
    include "koneksi.php";

    $ketinggian_air = $_GET['jarak'];
    
    mysqli_query($koneksi, "ALTER TABLE bendungan AUTO_INCREMENT=1");
    
    $simpan = mysqli_query($koneksi, "INSERT INTO bendungan(ketinggian_air)VALUES('$ketinggian_air')");
    
    if ($simpan) {
        echo "Berhasil disimpan";
    } else {
        echo "Gagal tersimpan";
    }    
?>


<?php
include 'koneksi.php';
$rows = mysqli_query($koneksi, "SELECT * FROM bendungan ORDER BY waktu DESC"); // Mengubah urutan data
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>WLDM - DataTables</title>
  <link href="vendor/huruf/css/all.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <style>
    .nav-item.active .nav-link:hover{color: rgb(76, 96, 218);}
  </style>
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
        <div class="sidebar-brand-icon">
          <img src="img/logo/bendungan_putih.svg">
        </div>
        <div class="sidebar-brand-text mx-3">WLDM</div>
      </a>
      
      <li class="nav-item active">
        <a class="nav-link" href="dashboard.php">
          <i class="fas fa-10x fa-brands fa-codepen"></i>
          <span>Dashboard</span></a>
      </li>
      <hr class="sidebar-divider">


      <li class="nav-item active">
        <a class="nav-link" href="datatables.php">
          <i class="fas fa-fw fa-solid fa-table-list"></i>
          <span>Table</span>
        </a>
      </li>
    </ul>
    <hr class="sidebar-divider">
    <!-- Sidebar -->

    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <nav class=" navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
          <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <ul class="navbar-nav ml-auto">
            <div class="topbar-divider d-sm-block"></div>
            <li class="nav-item active">
              <a class="nav-link" href="logout.php">
                <i class="fa-solid fa-right-from-bracket" style="margin-right: 15px;"></i>
                <span>Log Out</span></a>
            </li>
          </ul>
        </nav>
        <!-- Topbar -->


        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Table</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item">Table</li>
            </ol>
          </div>

        
          <!-- Tabel -->
          <div class="row">
            <!-- Datatables -->
            <div class="col-lg-10">
                <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Ketinggian Air</h6>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush" id="tabel_bendungan">
                    <thead class="thead-light">
                        <tr>
                        <th>No</th>
                        <th>Ketinggian Air</th>
                        <th>Tanggal & waktu</th>
                        <th>Status Ketinggian</th>
                        </tr>
                    </thead>
                    <tbody id="realtime_data"> <!-- Gunakan id ini untuk menyimpan data realtime -->
                        <!-- Di sini akan diperbarui oleh JavaScript -->
                    </tbody>
                    </table>
                </div>
                </div>
            </div>
            </div>
        </div>
        <!---Container Fluid-->
      </div>

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>copyright &copy; <script> document.write(new Date().getFullYear()); </script> - developed by
              <b>Faiz</a></b>
            </span>
          </div>
        </div>
      </footer>
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Kode JavaScript untuk tabel -->
  <script>
    $(document).ready(function() {
       // $('#tabel_bendungan').DataTable();
       // $('#dataTableHover').DataTable(); From dataTable with Hover
         
         function fetchDataAndUpdateTable() {
        fetch('get_latest_tabel.php') // Ganti dengan endpoint yang sesuai
          .then(response => response.json())
          .then(data => {
            // Hapus data lama dari tabel
            $('#realtime_data').empty();

            // Memberikan nomor secara otomatis
            let i = 1; // Mulai dari nomor 1

            // Loop melalui data baru dan tambahkan ke tabel
            data.forEach(row => {
              const newRow = `
                <tr>
                  <td>${i}</td>
                  <td>${row.ketinggian_air} cm</td>
                  <td>${row.waktu}</td>
                  <td>${getStatusButton(row.ketinggian_air)}</td>
                </tr>
              `;
              $('#realtime_data').append(newRow);
              i++; // Tambahkan 1 setiap kali loop
            });
          })
          .catch(error => console.error('Error:', error));
      }

      function getStatusButton(ketinggian) {
        if (ketinggian <= 8) {
          return '<button class="btn btn-success btn-block"><strong><i class="fa-solid fa-water"></i> AMAN</strong></button>';
        } else if (ketinggian >= 9 && ketinggian <= 11) {
          return '<button class="btn btn-warning btn-block"><strong><i class="fa-solid fa-water"></i> SIAGA</strong></button>';
        } else {
          return '<button class="btn btn-danger btn-block"><strong><i class="fa-solid fa-water"></i> BAHAYA</strong></button>';
        }
      }

      fetchDataAndUpdateTable(); // Ambil data pertama kali
      setInterval(fetchDataAndUpdateTable, 5000); // Ambil data setiap 5 detik
    });
  </script>
</body>

</html>
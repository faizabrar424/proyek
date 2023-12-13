<?php
    include 'koneksi.php';
    
    $sql_ID = mysqli_query($koneksi,"SELECT MAX(ID) FROM bendungan");
    $data_ID = mysqli_fetch_array($sql_ID);
    $ID_akhir = $data_ID['MAX(ID)'];
    $ID_awal = $ID_akhir - 5;
    
    $tgl_waktu = mysqli_query($koneksi, "SELECT waktu FROM bendungan WHERE ID>='$ID_awal' AND ID<='$ID_akhir' ORDER BY ID ASC");
    $ketinggian_air = mysqli_query($koneksi, "SELECT ketinggian_air FROM bendungan WHERE ID>='$ID_awal' AND ID<='$ID_akhir' ORDER BY ID ASC");
    
?>

Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

var ctx = document.getElementById("grafik_air");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: [],
    datasets: [{
      label: "Ketinggian Air",
      lineTension: 0.3,
      backgroundColor: "rgba(78, 115, 223, 0.5)",
      borderColor: "rgba(78, 115, 223, 1)",
      pointRadius: 3,
      pointBackgroundColor: "rgba(78, 115, 223, 1)",
      pointBorderColor: "rgba(78, 115, 223, 1)",
      pointHoverRadius: 3,
      pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
      pointHoverBorderColor: "rgba(78, 115, 223, 1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      data: [],
    }],
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 10,
        right: 25,
        top: 25,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          suggestedMin: 0,
          suggestedMax: 20,
          maxTicksLimit: 5,
          padding: 10,
          callback: function(value, index, values) {
          return value + ' cm'; // Menambahkan ' cm' di sini
          }
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }],
    },
    legend: {
      display: false
    },
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      intersect: false,
      mode: 'index',
      caretPadding: 10,
      callbacks: {
        label: function(tooltipItem, chart) {
          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
          return datasetLabel + ': ' + tooltipItem.yLabel + ' cm';
        }
      }
    }
  }
});

function fetchDataAndUpdateChart() {
  fetch('get_latest_data.php')
    .then(response => response.json())
    .then(data => {
      myLineChart.data.labels = data.labels;
      myLineChart.data.datasets[0].data = data.ketinggian_air;
      myLineChart.update();
    })
    .catch(error => console.error('Error:', error));
}

fetchDataAndUpdateChart(); // Ambil data pertama kali
setInterval(fetchDataAndUpdateChart, 1000); // Ambil data setiap  detik

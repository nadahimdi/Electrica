<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Client Space</title>
   
</head>
<?php

include "../Fournisseur/connect.php";
    $crudObject = new CRUD(); 

session_start();


if (!isset($_SESSION['client_id'])) {

    header("Login.php");
    exit();
  }
  $client = $crudObject-> countClientRows();
  $rec =$crudObject->countreclamationRows();
 $dataAnomalies =$crudObject->countAnomalies();
 $dataNormales=$crudObject->countNormales();
?>
<body>

<section id="sidebar">
       <div class="brand">
        <img src="../images/log.png" class="logo"> <p class="p"> ELECTRICA</p></div>
        <ul class="side-menu">
            
            <li> <a href="client_dashboard.php" ><i class='bx bxs-dashboard icon' style='color:#e80808' ></i> Dashboard</a></li>
            <li class="divider"><div class="text">Main</div></li>
            <li> <a href="Client_Consommation.php"><i class='bx bx-line-chart icon'  style='color:#f70808' ></i>Consumptions</a></li>
            <li>
                 <a href="Facture_Client.php"><i class='bx bxs-inbox icon' style='color:#e80808' ></i> INVOICES </a>
            </li>

            <li> <a href="Client_claims.php"><i class='bx bx-error-alt icon' style='color:#f70808'  ></i>Claims</a></li>
          
       
        </ul>
        <div class="ads">
            <div class="wrapper">
                <a href="../logout.php" class="btn-upgrade">Logout</a>
            </div>
        </div>
    </section>





<!--NAVBAR-->
<section id="content">
    <div class="Title">
        
    <h1 class="p"> ELECTRICA</h1></div>


    <main>
        <h1 class="title">Dashboard</h1>
        <div class="chart">
            <div id="chart"></div>
        </div>
  
        <div class="info-data">
          <div class="card">
            <div class="head">
                <div>
                    <h2> <?php echo"".$client.""?> </h2>
                    <p> Clients </p>
                </div>
                <i class="bx bx-trending-up icon "></i>
            </div>
            <span class="progress" data-value="60%"></span>
      
          </div>
          <div class="card">
            <div class="head">
                <div>
                    <h2> <?php echo"".$rec.""?> </h2>
                    <p> Reclamations </p>
                </div>
                <i class="bx bx-trending-down icon down"></i>
            </div>
            <span class="progress" data-value="70%"></span>
          
          </div>
          <div class="card">
            <div class="head">
                <div>
                    <h2> 4</h2>
                    <p> Anomalies </p>
                </div>
                <i class="bx bx-trending-up icon"></i>
            </div>
            <span class="progress" data-value="10%"></span>
        
          </div>
        </div>
        <div class="info-data">

        </div>

    <div class="data">
         <div class="content-data">
            <div class="head">
       

            
        </div>
         </div>
        </div>
    </main>
</section>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="script.js"></script>

<script>
var options = {
    series: [<?php echo $dataNormales;?>, <?php echo $dataAnomalies; ?>],
    labels: ['Facture normale', 'Facture anomalie'],
    chart: {
        type: 'donut',
    },
    title: {
        text: 'Etat de Vos facture ',
    },
    colors: ['#FF0000', '#A0A0A0'], // Red and Grey colors
    responsive: [{
        breakpoint: 480,
        options: {
            chart: {
                width: 150 // Adjust the width as needed
            },
            legend: {
                position: 'bottom'
            }
        }
    }]
};

var chart = new ApexCharts(document.querySelector("#chart"), options);
chart.render();

</script>
</body>
</html>
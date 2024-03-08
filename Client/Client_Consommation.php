<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="dashboard.css">
    <title>Fournisseur Space</title>
    <?php
include "../Fournisseur/connect.php";
$crudObject = new CRUD(); 

session_start();

if (!isset($_SESSION['client_id'])) {
    header("Location: Login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $compteur = htmlspecialchars($_POST["compteur"]);
    $date = htmlspecialchars($_POST["date"]);
    $client_id = $_SESSION['client_id'];
    $uploadedFileName = '';

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
        $uploadedFileName = basename($_FILES['photo']['name']);
        $uploadDirectory = '../images/';
        $destinationPath = $uploadDirectory . $uploadedFileName;

        // ... Your existing code ...

if (move_uploaded_file($_FILES['photo']['tmp_name'], $destinationPath)) {
  $crudObject->insertConsumption($client_id, $compteur, $date, $uploadedFileName);
  
  $factureType = $crudObject->getFactureType($client_id); // Assuming you have a method to get the facture type
  
  $message = ($factureType === 'anomalie') ? 'Your Consumptions will be treated.' : 'You can install your facture.';
  $icon = ($factureType === 'anomalie') ? 'error' : 'success';

  echo "<script>
      window.onload = function() {
          Swal.fire({
              position: 'end',
              icon: '{$icon}',
              title: '{$message}',
              showConfirmation: false,
              timer: 2000
          }).then(function() {
              window.location.href = 'Client_Consommation.php';
          });
      }
  </script>";
} else {
  echo 'Failed to move the uploaded file.';
}

// ... Your existing code ...

    } else {
        echo 'File upload error.';
    }
}
?>


</head>
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

            <li> <a href="Facture_client.php"><i class='bx bx-error-alt icon' style='color:#f70808'  ></i>Claims</a></li>
          
       
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
    <h1 class="p fw-bold">Add Consumption</h1></div>
    <main>
        <h1 class="title p fw-bold"></h1>
        <div id="chartContainer"></div>
        
        <div>

        </div>

        <div class="formulaire">
  <div class="modal-content">
        <form id="saveConsumptions" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST"   enctype="multipart/form-data">
  
      <div class="modal-body">
        <div id="errorMessage" class="alert alert-warning d-none"></div>
        <div class="mb-3">
          <label for="compteur">Compteur</label>
          <input type="text" name="compteur" class="form-control" placeholder="Enter consumption" required>
        </div>
        <div class="mb-3">
          <label for="date">Date</label>
          <input type="date" name="date" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="photo">Photo</label>
          <input type="file" name="photo" class="form-control"  required>
        </div>
      </div>
      <div class="modal-footer">
      <div class="card">
            <button class="btn btn-danger custom-button-width float-end" style="background-color: #ff0000;" data-bs-toggle="modal" data-bs-target="#ConsumptionsAddModal">Consumptions ADD</button>



            </div>
    </div>
     
    </form>
  </div>
</div>
</div>
  
</section>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="script.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" ></script>

    
</main>
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</body>
</html>

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
    include "connect.php";
    $crudObject = new CRUD(); 

session_start();
if (!isset($_SESSION['fournisseur_id'])) {
    header("Login.php");
    exit();
  }


if(isset($_GET['live_search'])&&$_GET['live_search'] !== ""){
    $filtervalues = $_GET['live_search'];
    $FactureData = $crudObject->getannuelleDataSearch($filtervalues);
    $pages = 1;
}


elseif (!isset($_GET['live_search']) || $_GET['live_search'] === ""){
$FactureData1 = $crudObject->getannuelleData();
$numRows = count($FactureData1);
$pages = ceil($numRows/20);



if(isset($_GET['page'])){
    $page=$_GET['page'];
}
else{
    $page=1;
}

$startinglimit=($page-1)*20;
$FactureData = $crudObject->getannuelleDataFetch($startinglimit);}


?>

</head>
<body>

<!-- ADD YEARLY CONSUMPTION -->

<div class="modal fade" id="ConsumptionAddModal" tabindex="-1" aria-labelledby="ConsumptionAddModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="ConsumptionAddModal">ADD consumption</h1>
      

      </div>
      <form id="saveConsumption">
         <div class="mb-3">
          <label for="textfile"> ADD CONSUMPTION FILES</label>
          <input type="file" name="textfile" class="form-control"  required>
        </div>
    
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger">Save File</button>
      </div>
       
      </form>
    </div>
  </div>
  </div>




<section id="sidebar">
       <div class="brand">
        <img src="../images/log.png" class="logo"> <p class="p"> ELECTRICA</p></div>
        <ul class="side-menu">
            
            <li> <a href="fournisseur_dashboard.php" ><i class='bx bxs-dashboard icon' style='color:#e80808' ></i> Dashboard</a></li>
            <li class="divider"><div class="text">Main</div></li>
            <li> <a href="Ajouter_Client.php"><i class='bx bx-message-square-add icon' style='color:#e80808' ></i>Client</a></li>
            <li> <a href="anomalie.php"><i class='bx bx-message-square-add icon' style='color:#e80808' ></i>anomalie</a></li>
            <li>
                 <a href="Facture.php"><i class='bx bxs-inbox icon' style='color:#e80808' ></i> INVOICES </a>
            </li>

            <li> <a href="Claim.php"><i class='bx bx-error-alt icon' style='color:#f70808'  ></i>Claims</a></li>
         
            <li> <a href="yearly.php"><i class='bx bxs-hourglass-bottom icon' style='color:#f70c0c'  ></i> Yearly Consumption</a></li>
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
    <h1 class="p fw-bold">Yearly Consumptions</h1></div>
    <nav>
    <i class='bx bx-menu toggle-sidebar'></i>
    <form method="GET" action="">
        <div class="form-group">
            <input type="text"  id="live_search" value="<?php if(isset($_GET['live_search'])){echo $_GET['live_search'];}?>" name="live_search"  placeholder='Search...'> 
            <button type="submit" ><i class='bx bx-search icon'></i></button>
        
        </div>
    
    </form>
    
</nav>
    <main>
    <div class="pop-image">
    <span>&times;</span>
    <img src="" alt="" id="popupImage">
</div>
        <h1 class="title p fw-bold">Yearly Consumption</h1>
        <div id="chartContainer"></div>


        <div class="table-container">
        <div class="container">
        <div class="row">
        <div class="col-md-2">
            <div class="card">
            <button class="btn btn-danger custom-button-width float-end" style="background-color: #ff0000;" data-bs-toggle="modal" data-bs-target="#ConsumptionAddModal">ADD</button>

            </div>
</div>
</div>
</div>
<div>
<p>   </p>

</div>

            
            <table id="myTable"class="table">
               <thead>
                   <tr>
                       
                       <th>Facture</th>
                       <th>Client</th>
                       <th> CIN </th>
                       <th>Consomation</th>
                
                       <th>Gap</th>
                       <th>Year</th>
                     
                       
                   </tr>
               </thead>
               <tbody>
                <?php
                $reversedFactureData = array_reverse($FactureData);

               foreach ($reversedFactureData as $row) {

                $id_client=$row['client_id'];
                $clientInfo = $crudObject->searchClientByID($id_client);
          

?>
    <tr>
    <td data-label='id'><?php echo $row['id']; ?></td>
        <td data-label='nom'> <?php
        // Use the client information retrieved from the searchClient function
        echo $clientInfo[0]['nom'] . ' ' . $clientInfo[0]['prenom'];
        ?>
    </td>
    <td data-label='client_id'><?php echo $clientInfo[0]['CIN']; ?></td>
     
        <td data-label='consommation_monsuelle'><?php echo $row['consommation']; ?></td>
   
        <td data-label='Compteur'><?php echo $row['difference']; ?></td>
        <td data-label='Compteur'><?php echo $row['annee']; ?></td>
      
   
    </tr>
<?php


}


?>


    </tbody>
    
            </table>
           
            <?php




for ($btn = 1; $btn <= $pages; $btn++) {
    echo '<button style="background-color: #e80808; color: #ffffff; border: 1px solid #e80808; padding: 5px 10px; margin: 10px 5px 10px;"><a href="Facture.php?page=' . $btn . '" style="text-decoration: none; color: #ffffff;">' . $btn . '</a></button>';}
?>
           </div>
        <div>

        </div>
        <div class="pop-image">
    <span>&times;</span>
    <img src="" alt="" id="popupImage">
  
</section>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="script.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" ></script>
</main>
<script>
 
 $(document).on('submit', '#saveConsumption', function (e) {
    e.preventDefault();

    var formData = new FormData(this);
    formData.append("save_Consumption", true);

    $.ajax({
        type: "POST",
        url: "AddConsumption.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            try {
                var res = JSON.parse(response);

                if (res.status == 422) {
                    $('#errorMessage').removeClass('d-none');
                    $('#errorMessage').text(res.message);
                } else if (res.status == 200) {
                    Swal.fire({
                        position: 'end',
                        icon: 'success',
                        title: 'SuccessFully added',
                        showConfirmation: false,
                        timer: 2000
                    })
                    $('#errorMessage').addClass('d-none');
                    $('#ConsumptionAddModal').modal('hide');
                    $('#saveConsumption')[0].reset();
                    $('#myTable').load(location.href + " #myTable");
                }

                else if (res.status == 409) {
                    Swal.fire({
                        position: 'end',
                        icon: 'error',
                        title: 'Client Already exists',
                        showConfirmation: false,
                        timer: 2000
                    })
                    $('#errorMessage').addClass('d-none');
                    $('#ConsumptionAddModal').modal('hide');
                    $('#saveConsumption')[0].reset();
                    $('#myTable').load(location.href + " #myTable");
                }
                else if (res.status == 401) {
                    Swal.fire({
                        position: 'end',
                        icon: 'error',
                        title: 'Failed To add , The Gap is way Too big',
                        showConfirmation: false,
                        timer: 2000
                    })
                    $('#errorMessage').addClass('d-none');
                    $('#ConsumptionAddModal').modal('hide');
                    $('#saveConsumption')[0].reset();
                    $('#myTable').load(location.href + " #myTable");
                }
            } catch (error) {
                console.error('Error parsing JSON response:', error);
            }
        }
    });
});


</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</body>
</html>















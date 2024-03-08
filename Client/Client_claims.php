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
  header("Login.php");
  exit();
}
$client_id = $_SESSION['client_id'];
if(isset($_GET['live_search'])&&$_GET['live_search'] !== ""){
    $filtervalues = $_GET['live_search'];
    $clientData = $crudObject->getClientRecDataSearch($client_id,$filtervalues);
    $pages = 1;
   
}


elseif (!isset($_GET['live_search']) || $_GET['live_search'] === ""){
$clientData1 = $crudObject->getClientRecData($client_id);
$numRows = count($clientData1);
$pages = ceil($numRows/20);



if(isset($_GET['page'])){
    $page=$_GET['page'];
}
else{
    $page=1;
}
echo'we are here';
$startinglimit=($page-1)*20;
$clientData = $crudObject->getClientRecDataFetch($client_id,$startinglimit);}
?>

</head>
<body>
<!-- CLIENT ADD -->
<div class="modal fade" id="ClientAddModal" tabindex="-1" aria-labelledby="ClientAddModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="ClientAddModal">ADD Claim</h1>
      

      </div>
      <form id="saveClient">
  <div class="modal-body">
    <div id="errorMessage" class="alert alert-warning d-none"></div>

    <!-- List of Choices (Radio Buttons) -->
    <div class="mb-3">
      <label for="choice">Select a Category:</label>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="category" id="externalLeakage" value="externalLeakage">
        <label class="form-check-label" for="externalLeakage">External Leakage</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="category" id="internalLeakage" value="internalLeakage">
        <label class="form-check-label" for="internalLeakage">Internal Leakage</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="category" id="invoices" value="invoices">
        <label class="form-check-label" for="invoices">Invoices</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="category" id="others" value="others" checked>
        <label class="form-check-label" for="others">Others</label>
      </div>
    </div>

    <!-- Textarea for Additional Information -->
    <div class="mb-3">
      <label for="additionalText">Additional Information:</label>
      <textarea class="form-control" name="additionalText" id="additionalText" rows="3"></textarea>
    </div>
  </div>

  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-danger">Claim</button>
  </div>
</form>

    </div>
  </div>
</div>





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
    <h1 class="p fw-bold">OUR CLIENTS</h1></div>
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
        <h1 class="title p fw-bold"></h1>
        <div id="chartContainer"></div>


        <div class="table-container">
        <div class="container">
    <div class="row">
        <div class="col-md-2">
            <div class="card">
            <button class="btn btn-danger custom-button-width float-end" style="background-color: #ff0000;" data-bs-toggle="modal" data-bs-target="#ClientAddModal">CLaim</button>



            </div>
        </div>
    </div>
</div>
<div>
<p>   </p>
</div>
            
            <table id="myTable"class="table">
               <thread>
                   <tr>
                 
                       <th>Type</th>
                       <th>Problem</th>
                       <th>Date</th>
                       <th>status</th>
                       <th>Respond</th>
                   </tr>
               </thread>
               <tbody>
                <?php
                $reversedClientData = array_reverse($clientData);

               foreach ($reversedClientData as $row) {
?>
    <tr>
    <td data-label='type'><?php echo $row['type']; ?></td>
        <td data-label='contenue'><?php echo $row['contenue']; ?></td>
        <td data-label='date_saisie'><?php echo $row['date_saisie']; ?></td>
        <td data-label='status'><?php echo $row['status']; ?></td>
        <td data-label='contenue_reponse'><?php echo $row['contenue_reponse']; ?></td>
       
    </tr>
<?php


}


?>


    </tbody>
    
            </table>

            <?php




for ($btn = 1; $btn <= $pages; $btn++) {
    echo '<button style="background-color: #e80808; color: #ffffff; border: 1px solid #e80808; padding: 5px 10px; margin: 10px 5px 10px;"><a href="Ajouter_Client.php?page=' . $btn . '" style="text-decoration: none; color: #ffffff;">' . $btn . '</a></button>';}
?>
           </div>
        <div>

        </div>
  
</section>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="script.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" ></script>
</main>
<script>
  $(document).on('submit', '#saveClient', function (e) {
    e.preventDefault();

    var formData = new FormData(this);
    formData.append("save_client", true);

    $.ajax({
        type: "POST",
        url: "AddClaims.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            var res = jQuery.parseJSON(response);

            if (res.status == 422) {
                $('#errorMessage').removeClass('d-none');
                $('#errorMessage').text(res.message);
            } else if (res.status == 200) {
                $('#errorMessage').addClass('d-none');
                $('#ClientAddModal').modal('hide');
                $('#saveClient')[0].reset();
                $('#myTable').load(location.href + " #myTable");
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});


</script>

</script>
</body>
</html>






























































































































































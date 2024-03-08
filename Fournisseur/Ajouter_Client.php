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

if (!isset($_SESSION['fournisseur_id'])) {
  header("Login.php");
  exit();
}

if(isset($_GET['live_search'])&&$_GET['live_search'] !== ""){
    $filtervalues = $_GET['live_search'];
    $clientData = $crudObject->getClientDataSearch($filtervalues);
    $pages = 1;
}


elseif (!isset($_GET['live_search']) || $_GET['live_search'] === ""){
$clientData1 = $crudObject->getClientData();
$numRows = count($clientData1);
$pages = ceil($numRows/20);



if(isset($_GET['page'])){
    $page=$_GET['page'];
}
else{
    $page=1;
}

$startinglimit=($page-1)*20;
$clientData = $crudObject->getClientDataFetch($startinglimit);}
?>

</head>
<body>
<!-- CLIENT ADD -->
<div class="modal fade" id="ClientAddModal" tabindex="-1" aria-labelledby="ClientAddModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="ClientAddModal">ADD CLIENT</h1>
      

      </div>
      <form id="saveClient">
      <div class="modal-body">
        <div id="errorMessage" class="alert alert-warning d-none"></div>
      <div class="mb-3">
        <label for=""> First Name </label>
        <input type="text" name="First" class="form-control" >
      </div>
      <div class="mb-3">
        <label for=""> Last Name </label>
        <input type="text" name="Last" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for=""> Email </label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for=""> CIN </label>
        <input type="text" name="CIN" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for=""> address  </label>
        <input type="text" name="adresse" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for=""> Password </label>
        <input type="password" name="password"  class="form-control" required>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger">Save Client</button>
      </div>
      
      </form>
    </div>
  </div>
</div>




<!-- CLIENT MODIFY -->
<div class="modal fade" id="ClientEditModal" tabindex="-1" aria-labelledby="ClientEditModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="ClientEditModal">Modify CLIENT</h1>
      

      </div>
      <form id="updateClient">
      <div class="modal-body">
        <div id="errorMessageUpdate" class="alert alert-warning d-none"></div>
        <div class="mb-3">
       
        <input type="hidden" name="Client_id"  id="Client_id"  class="form-control" >
      </div>
      <div class="mb-3">
        <label for=""> First Name </label>
        <input type="text" name="First"  id="First"  class="form-control" >
      </div>
      <div class="mb-3">
        <label for=""> Last Name </label>
        <input type="text" name="Last"  id="Last"class="form-control" required>
      </div>
      <div class="mb-3">
        <label for=""> Email </label>
        <input type="email" name="email" id="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for=""> CIN </label>
        <input type="text" name="CIN"  id="CIN" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for=""> address  </label>
        <input type="text" name="adresse"  id="adresse" class="form-control" required>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger">Modify Client</button>
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
        <h1 class="title p fw-bold">Our newest Clients</h1>
        <div id="chartContainer"></div>


        <div class="table-container">
        <div class="container">
    <div class="row">
        <div class="col-md-2">
            <div class="card">
            <button class="btn btn-danger custom-button-width float-end" style="background-color: #ff0000;" data-bs-toggle="modal" data-bs-target="#ClientAddModal">Client ADD</button>



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
                       <th>ID</th>
                       <th>FULL NAME</th>
                       <th>EMAIL</th>
                       <th>address</th>
                       <th>CIN</th>
                       <th>ACTION</th>
                   </tr>
               </thread>
               <tbody>
                <?php
                $reversedClientData = array_reverse($clientData);

               foreach ($reversedClientData as $row) {
?>
    <tr>
        <td data-label='Client_id'><?php echo $row['ID']; ?></td>
        <td data-label='Full_Name'><?php echo $row['prenom'] . " " . $row['nom']; ?></td>
        <td data-label='Email'><?php echo $row['email']; ?></td>
        <td data-label='adresse'><?php echo $row['adresse']; ?></td>
        <td data-label='CIN'><?php echo $row['CIN']; ?></td>
        <td data-label='Action'><button type="button" class="editClientBtn"value="<?php echo $row['ID']; ?>">MODIFY</button></td>
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
        url: "AddClient.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            try {
                var res = JSON.parse(response);

                if (res.status == 422) {
                    Swal.fire({
                        position: 'end',
                        icon: 'error',
                        title: 'an error was encouneterd the client was not added .',
                        showConfirmation: false,
                        timer: 2000
                    }).then(function() {
                        window.location.href = 'Login.php';
                    });
                } else if (res.status == 200) {
                  Swal.fire({
                        position: 'end',
                        icon: 'success',
                        title: 'The client wa successfuly added .',
                        showConfirmation: false,
                        timer: 2000
                    })
                    $('#errorMessage').addClass('d-none');
                    $('#ClientAddModal').modal('hide');
                    $('#saveClient')[0].reset();
                    $('#myTable').load(location.href + " #myTable");
                }
            } catch (error) {
                console.error('Error parsing JSON response:', error);
            }
        }
    });
});






    $(document).on('click', '.editClientBtn', function () {
    var Client_id = $(this).val();
    $.ajax({
        type: "GET",
        url: "AddClient.php?Client_id=" + Client_id,
        success: function (response) {
            var res = jQuery.parseJSON(response); // Corrected function name
            if (res.status == 422) {
                alert(res.message);
            } else if (res.status == 200) { // Corrected variable name
                $('#Client_id').val(res.data.ID);
                $('#Last').val(res.data.nom);
                $('#First').val(res.data.prenom);
                $('#email').val(res.data.email);
                $('#CIN').val(res.data.CIN);
                $('#adresse').val(res.data.adresse);

                $('#ClientEditModal').modal('show');
            }
        }
    });
});






$(document).on('submit', '#updateClient', function (e) {
    e.preventDefault();

    var formData = new FormData(this);
    formData.append("update_client", true);

    $.ajax({
        type: "POST",
        url: "AddClient.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            var res= jQuery.parseJSON(response);

            if (res.status == 422) {
                $('#errorMessageUpdate').removeClass('d-none');
                $('#errorMessageUpdate').text(res.message);
            } else if (res.status == 200) {
              Swal.fire({
                        position: 'end',
                        icon: 'success',
                        title: 'The client wa successfuly updated .',
                        showConfirmation: false,
                        timer: 2000
                    })
                $('#errorMessageUpdate').addClass('d-none');
                $('#ClientEditModal').modal('hide');
                $('#updateClient')[0].reset();
                $('#myTable').load(location.href + " #myTable");
            }
        }
    });
});



</script>

</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</body>
</html>






























































































































































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


  if (isset($_POST['pdf_button'])) {
    $factureId = $_POST['facture_id'];
    $client_id = $_POST['client_id'];
    $factureInfo = $crudObject->getFactureInfoById($factureId);
    $clientInfo = $crudObject->getClientInfoById($client_id);
    $_SESSION['client_info'] = $clientInfo ;
    $_SESSION['facture_info'] = $factureInfo;
    header("Location: ../Facture_generator.php");
    exit();
}


if(isset($_GET['live_search'])&&$_GET['live_search'] !== ""){
    $filtervalues = $_GET['live_search'];
    $FactureData = $crudObject->getFactureDataSearch($filtervalues);
    $pages = 1;
}


elseif (!isset($_GET['live_search']) || $_GET['live_search'] === ""){
$FactureData1 = $crudObject->getFactureData();
$numRows = count($FactureData1);
$pages = ceil($numRows/20);



if(isset($_GET['page'])){
    $page=$_GET['page'];
}
else{
    $page=1;
}

$startinglimit=($page-1)*20;
$FactureData = $crudObject->getFactureDataFetch($startinglimit);}
?>

</head>
<body>

<!-- Facture MODIFY -->

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
    <h1 class="p fw-bold">INVOICES</h1></div>
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
        <h1 class="title p fw-bold">INVOICES</h1>
        <div id="chartContainer"></div>


        <div class="table-container">
        <div class="container">
</div>
<div>
<p>   </p>

</div>

            
            <table id="myTable"class="table">
               <thead>
                   <tr>
                       <th>ID</th>
                       <th>Client</th>
                       <th>CIN</th>
                       <th>Consomation</th>
                      <th>Date</th>
                       <th>Compteur</th>
                       <th>Photo</th>
                       <th>Action</th>
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
        <td data-label='id'><?php echo $row['id']; ?>
    </td>

    <td data-label='nom'> <?php
        // Use the client information retrieved from the searchClient function
        echo $clientInfo[0]['nom'] . ' ' . $clientInfo[0]['prenom'];
        ?>
    </td>
    <td data-label='client_id'><?php echo $clientInfo[0]['CIN']; ?></td>
        <td data-label='consommation_monsuelle'><?php echo $row['consommation_monsuelle']; ?></td>
        <td data-label='date_saisie'><?php echo $row['date_saisie']; ?></td>
        <td data-label='Compteur'><?php echo $row['Compteur']; ?></td>
        <td data-label='photo' class='compteur'><img src='../images/<?php echo $row['photo_path']; ?>'   class='small-image'></td>
        <td data-label='Action'>
        <form method="post" action="">
        <input type="hidden" name="client_id" id="client_id" value="<?php echo $row['client_id']; ?>">
        <input type="hidden" name="facture_id" id="facture_id" value="<?php echo $row['id']; ?>">
        <button type="submit" name="pdf_button">PDF </button>
    </form></td>
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
     



document.querySelectorAll('.compteur img').forEach(image => {
    image.onclick = () => {
        const imageUrl = image.src;
        document.getElementById('popupImage').src = imageUrl;
        document.querySelector('.pop-image').style.display = 'block';
    }
    document.querySelector('.pop-image span').onclick = () =>{
        document.querySelector('.pop-image').style.display ='none';
    }
});

</script>


</body>
</html>















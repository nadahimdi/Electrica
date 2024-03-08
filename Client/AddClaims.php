

<?php
include "../Fournisseur/connect.php";
$crudObject = new CRUD();

session_start();

if (!isset($_SESSION['client_id'])) {
    header("Location: Login.php");
    exit();
}

if (isset($_POST['save_client'])) {
    $selectedCategory = isset($_POST['category']) ? $_POST['category'] : null;
    $additionalText = isset($_POST['additionalText']) ? $_POST['additionalText'] : null;
    $type = $selectedCategory;
 
    $contenue = $additionalText;
    $contenue_reponse = "";

    try {
        $client_id = $_SESSION['client_id'];
        $date_saisie = date("Y-m-d");
        $fournisseur_id = null;
        $status = 'pending';
        $stmt = $crudObject->handle->prepare("INSERT INTO reclamation (client_id, contenue, date_saisie, fournisseur_id, status, contenue_reponse, type) 
                                             VALUES (:client_id, :contenue, :date_saisie, :fournisseur_id, :status, :contenue_reponse, :type)");

        $stmt->bindParam(':client_id', $client_id, PDO::PARAM_INT);
        $stmt->bindParam(':contenue', $contenue);
        $stmt->bindParam(':date_saisie', $date_saisie);
        $stmt->bindParam(':fournisseur_id', $fournisseur_id);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':contenue_reponse', $contenue_reponse);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $res = array('status' => 200, 'message' => 'The Reclamation has been added successfully');
            echo json_encode($res);
        } else {
            $res = array('status' => 500, 'message' => 'The Reclamation has not been added');
            echo json_encode($res);
        }
    } catch (PDOException $e) {
        $errorMessage = $e->getMessage();
        $res = array('status' => 500, 'message' => 'An error occurred during the database operation: ' . $errorMessage);
        echo json_encode($res);
    }
}
?>

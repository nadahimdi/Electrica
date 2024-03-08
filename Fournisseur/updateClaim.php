<?php
include "connect.php";
session_start();
if(isset($_GET['id'])){
    $id = $_GET['id'];

    try {
        $crud = new CRUD(); // Assuming CRUD is your database interaction class

        $stmt = $crud->handle->prepare("SELECT * FROM reclamation WHERE id = :id  ");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $res = array();
     
        if ($stmt->rowCount() > 0) {
            // anomalie found
            $anomalieData = $stmt->fetch(PDO::FETCH_ASSOC);

            $res['status'] = 200;
            $res['message'] = 'reclamation fetched successfully by ID';
            $res['data'] = $anomalieData;
        } else {
            // anomalie not found
            $res['status'] = 404;
            $res['message'] = 'reclamation not found';
        }

        echo json_encode($res);
    } catch (PDOException $e) {
        // Database error
        $res['status'] = 500;
        $res['message'] = 'Ann error occurred during the database operation';
    
        // Log detailed error
        echo json_encode($res);
    }
}





if (isset($_POST['update_claim'])) {
    $id = $_POST['id'];
    $Respond = $_POST['Respond'];
    $status = 'done';
    $fournisseur_id=$_SESSION['fournisseur_id'];

    if ($Respond == null) {
        $res = array('status' => 422, 'message' => 'You have to respond');
    } else {
        try {
            $crud = new CRUD(); // Instantiate the CRUD class

            // Output the SQL query for debugging
            $stmt = $crud->handle->prepare("UPDATE reclamation SET contenue_reponse = :Respond , status = :status, fournisseur_id=:fournisseur_id WHERE id = :id ");
            $stmt->bindParam(':Respond', $Respond);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':fournisseur_id', $fournisseur_id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $res = array('status' => 200, 'message' => 'The reclamation is updated successfully');
            } else {
                $res = array('status' => 500, 'message' => 'The reclamation has not been updated');
            }
        } catch (PDOException $e) {
            // Output any PDO exceptions for debugging
            $res = array('status' => 500, 'message' => 'An error occurred during the database operation');
            $res['pdo_exception'] = $e->getMessage();
        }
    }

    echo json_encode($res);
}

<?php
include "connect.php";
if(isset($_GET['id'])){
    $id = $_GET['id'];

    try {
        $crud = new CRUD(); // Assuming CRUD is your database interaction class

        $stmt = $crud->handle->prepare("SELECT * FROM facture WHERE id = :id  and type = 'anomalie' ");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $res = array();
     
        if ($stmt->rowCount() > 0) {
            // anomalie found
            $anomalieData = $stmt->fetch(PDO::FETCH_ASSOC);

            $res['status'] = 200;
            $res['message'] = 'anomalie fetched successfully by ID';
            $res['data'] = $anomalieData;
        } else {
            // anomalie not found
            $res['status'] = 404;
            $res['message'] = 'anomalie not found';
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






if (isset($_POST['update_anomalie'])) {
    $id = $_POST['id'];
    $Compteur = $_POST['Compteur'];

    if ($Compteur == null) {
        $res = array('status' => 422, 'message' => 'All values are required');
    } else {
        try {
            $crud = new CRUD(); // Instantiate the CRUD class

            // Use the updateAnomalie method to handle the update and calculations
            $result = $crud->updateAnomalie($id, $Compteur);

            // Return the result as a JSON response
            echo json_encode($result);
            exit(); // Ensure that no additional content is output
        } catch (PDOException $e) {
            // Output any PDO exceptions for debugging
            $res = array('status' => 500, 'message' => 'An error occurred during the database operation');
            $res['pdo_exception'] = $e->getMessage();

            // Return the error as a JSON response
            echo json_encode($res);
            exit(); // Ensure that no additional content is output
        }
    }
}



?>

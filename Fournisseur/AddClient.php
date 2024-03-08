<?php
include "connect.php";
if(isset($_GET['Client_id'])){
    $Client_id = $_GET['Client_id'];

    try {
        $crud = new CRUD(); // Assuming CRUD is your database interaction class

        $stmt = $crud->handle->prepare("SELECT * FROM client WHERE ID = :Client_id");
        $stmt->bindParam(':Client_id', $Client_id);
        $stmt->execute();

        $res = array();

        if ($stmt->rowCount() > 0) {
            // Client found
            $clientData = $stmt->fetch(PDO::FETCH_ASSOC);

            $res['status'] = 200;
            $res['message'] = 'Client fetched successfully by ID';
            $res['data'] = $clientData;
        } else {
            // Client not found
            $res['status'] = 404;
            $res['message'] = 'Client not found';
        }

        echo json_encode($res);
    } catch (PDOException $e) {
        // Database error
        $res['status'] = 500;
        $res['message'] = 'An error occurred during the database operation';
        echo json_encode($res);
    }
}



if (isset($_POST['save_client'])) {
    $first_name = $_POST['First'];
    $last_name = $_POST['Last'];
    $email = $_POST['email'];
    $cin = $_POST['CIN'];
    $adresse=$_POST['adresse'];
    $password = $_POST['password'];

    if ($first_name == null || $last_name == null || $email == null || $cin == null || $password == null || $adresse==null) {
        $res = array('status' => 422, 'message' => 'All values are required');
        echo json_encode($res);
    }else {
        try {
            $crud = new CRUD(); // Instantiate the CRUD class

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $crud->handle->prepare("INSERT INTO client (nom, prenom, email, CIN, password, adresse) VALUES (:nom, :prenom, :email, :CIN, :password, :adresse)");

            $stmt->bindParam(':nom', $last_name);
            $stmt->bindParam(':prenom', $first_name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':CIN', $cin);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':adresse', $adresse);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $res = array('status' => 200, 'message' => 'The Client is updated successfully');
                echo json_encode($res);
            } else {
                $res= array('status' => 500, 'message' => 'The Client has not been updated');
                echo json_encode($res);
            }
        } catch (PDOException $e) {
            $res = array('status' => 500, 'message' => 'An error occurred during the database operation');
            echo json_encode($res);
        }
    }
}





if (isset($_POST['update_client'])) {
    $Client_id = $_POST['Client_id'];
    $first_name = $_POST['First'];
    $last_name = $_POST['Last'];
    $email = $_POST['email'];
    $cin = $_POST['CIN'];
    $adresse=$_POST['adresse'];
  

    if ($first_name == null || $last_name == null || $email == null || $cin == null  || $adresse==null) {
        $res = array('status' => 422, 'message' => 'All values are required');
        echo json_encode($res);
    } else {
        try {
            $crud = new CRUD(); // Instantiate the CRUD class

          

            $stmt = $crud->handle->prepare("UPDATE client SET nom=:last_name, prenom=:first_name, email=:email, CIN=:cin, adresse=:adresse  WHERE ID=:Client_id");

            $stmt->bindParam(':Client_id', $Client_id);
            $stmt->bindParam(':last_name', $last_name);
            $stmt->bindParam(':first_name', $first_name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':cin', $cin);
            $stmt->bindParam(':adresse', $adresse);
          

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $res = array('status' => 200, 'message' => 'The Client is updated successfully');
                echo json_encode($res);
            } else {
                $res= array('status' => 500, 'message' => 'The Client has not been updated');
                echo json_encode($res);
            }
        } catch (PDOException $e) {
            $res = array('status' => 500, 'message' => 'An error occurred during the database operation');
            echo json_encode($res);
        }
    }
}

?>

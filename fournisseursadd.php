<?php
include "connect.php";

$crud = new CRUD(); 
$ID="3";
$email = "nada@email.com";
$telephone = "123456789";
$password = "nadanadahimdi";
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$cin = "1234";

if (filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match("/^[0-9]{9}$/", $telephone)) {

    $stmt = $crud->handle->prepare("INSERT INTO fournisseur (ID,email, telephone, password, CIN) VALUES (:ID,:email, :telephone, :password, :CIN)");
    $stmt->bindParam(':ID', $ID);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telephone', $telephone);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':CIN', $cin);

    $stmt->execute();
    echo "Fournisseur added successfully!";
} else {

    echo "Invalid data. Please check your inputs.";
}
?>

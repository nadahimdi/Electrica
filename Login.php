<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">


    <title>Login</title>
    <?php
session_start();

include "connect.php";
$crudObject = new CRUD(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cin = $_POST['CIN'];
    $password = trim($_POST['password']);


    // Check in the fournisseur table
    $hashedPasswordFournisseur = $crudObject->getHashedPasswordFournisseur($cin);

    
    if ($hashedPasswordFournisseur && password_verify($password, $hashedPasswordFournisseur)) {
        $_SESSION['fournisseur_id'] = $crudObject->getFournisseurIdByCIN($cin);
        // Fournisseur login successful

        header("Location: Fournisseur/fournisseur_dashboard.php");
        exit();
    } else {
        // Check in the client table
        $hashedPasswordClient = $crudObject->getHashedPasswordClient($cin);

        if ($hashedPasswordClient && password_verify($password, $hashedPasswordClient)) {

            // Client login successful
            $_SESSION['client_id'] = $crudObject->getClientIdByCIN($cin);
            header("Location: Client/client_dashboard.php");
            exit();
        } else {
            // Display SweetAlert popup for non-existing user
            echo "<script>
            window.onload = function() {
                Swal.fire({
                    position: 'end',
                    icon: 'error',
                    title: 'Utilisateur non trouvé. Veuillez vérifier vos informations de connexion.',
                    showConfirmation: false,
                    timer: 2000
                }).then(function() {
                    window.location.href = 'Login.php';
                });
            }
        </script>
        ";
        }
    }
}
?>

</head>

<body>

    <div class="wrapper">
        <div class="form-wrapper sign-on"> 
         </div>
     <div class="form-wrapper sign-in"> 
        
     <form action="login.php" method="post">

            <h2> Login </h2>
            <div class="input-group">
                
                <input type="text" name="CIN" required>
              
                <label for="" name="CIN"> <div class="icon"><img src="images/email.png">CIN
                    </div></label>

            </div>
            <div class="input-group">
                <input type="password" name="password" required>
                <label name="password"for=""> <div class="icon"><img src="images/password.png"> Password</div></label>
            </div>
            <button type="submit" class="btn"> Login</button>

        </form>
     </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</body>


</html>
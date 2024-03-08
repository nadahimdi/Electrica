<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

if (!isset($_SESSION['client_id'])) {
    header("Location: Login.php");
    exit();
}

use Dompdf\Dompdf;
use Dompdf\Options;

if (isset($_SESSION['facture_info'])) {
    // Retrieve facture information from the session
    $factureInfo = $_SESSION['facture_info'];
    $clientInfo = $_SESSION['client_info'];

    // Access individual column values
    $nom = $clientInfo[0]['nom']; 
    $prenom = $clientInfo[0]['prenom'];
    $CIN = $clientInfo[0]['CIN'];
    $adresse = $clientInfo[0]['adresse'];
    $email = $clientInfo[0]['email'];
    $factureId = $factureInfo[0]['id'];
    $clientId = $factureInfo[0]['client_id'];
    $HT = $factureInfo[0]['prix_HT'];
    $TTC = $factureInfo[0]['prix_TTC'];
    $consommationMonsuelle = $factureInfo[0]['consommation_monsuelle'];
    $dateSaisie = $factureInfo[0]['date_saisie'];
    $date = new DateTime($dateSaisie);

// Subtract one month
$date->modify('-1 month');
$dateString = $date->format('Y-m-d'); // Adjust the format as needed

    $photoPath = $factureInfo[0]['photo_path'];
    $compteur = $factureInfo[0]['Compteur'];
     echo"".$photoPath."";
    $options = new Options();
    $options->set('chroot', realpath(''));
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);
    $options->set('isFontSubsettingEnabled', true);
    $options->set('isHtml5ParserEnabled', true);
    $dompdf = new Dompdf($options);
    $dompdf->setPaper('letter', 'portrait');

    // Define your HTML content dynamically
    $html = <<<HTML
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Aloha!</title>
        <style type="text/css">
            * {
                font-family: Verdana, Arial, sans-serif;
            }
            table {
                margin-top:50px;
                font-size: x-small;
                align-items:center;
            }
            .brand {
            text-align: center;
            display: flex; /* Add display: flex; to make children (logo and text) inline */
            align-items: center; /* Vertically align children in the center */
        }
        .logo {
            max-width: 200px; /* Set the maximum width for the logo */
            height: auto; /* Maintain aspect ratio */
            margin-right: 10px; /* Add some margin for separation */
        }

            thead tr {
            background-color: red;
            color: white;
        }
            tfoot tr td {
                margin-top:50px;
                margin-left:100px;
                font-weight: bold;
                font-size: x-small;
            }

         .info{
                margin-top:50px;
                margin-left:50px;
               
            }
            .inforo{
                margin-top:50px;
                margin-right:50px;
               
            }


            .gray {
                background-color: red;
            }
        </style>
    </head>
    <body>
    <div class="brand">
        <img src="logo.png" class="logo"> </div>
        <table width="100%">
            <tr>
            
                <td align="left">
                <div class="info">
                    <h3> CLIENT</h3>
                    <pre>
                        <div>First Name : $nom </div> 
                        <div>Last Name : $prenom </div> 
                        <div>addresse : $adresse </div> 
                     
                      
                    </pre>
                    </div> 
                </td>
             
                <td align="right">
                <div class="inforo">
                    <h3> ELECTRICA, innovation sparks life. </h3>
                    <pre>
                     ELECTRICA, innovation sparks life. 
                       addresse:456 Oak Avenue,
                         Townsville,
                        Countyland,
                      Postal Code

                      
                    </pre>
                    </div> 
                </td>
            </tr>
        </table>

        <table width="100%">
            <tr>
                <td><strong>From:</strong>$dateString</td>
                <td><strong>To:</strong>$dateSaisie</td>
            </tr>
        </table>

        <br/>

        <table width="100%">
            <thead style="background-color: lightgray;">
                <tr>
                    <th>#</th>
                    <th>Code Facture</th>
                    <th>Date</th>
                    <th>Photo</th>
                    <th>Consommation</th>
                    <th>Prix</th>
                </tr>
            </thead>
            <tbody>
            <tr>
    <th scope="row">1</th>
    <td>$factureId</td>
    <td align="right">$dateSaisie</td>
    
    <td style="text-align: center;" align="center"><img   src="images/$photoPath"  alt="Client Photo" style="max-width: 30%; height: auto; margin-top: 20px;"></td>


    <td align="right">$consommationMonsuelle kwh</td>
    <td align="right">$HT DH</td>
    </tr>

           
           
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="3"></td>
                    <td align="right">HT</td>
                    <td align="right">$HT DH</td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td align="right">TTC </td>
                    <td align="right" class="gray">$TTC DH</td>
                </tr>
            </tfoot>
        </table>

    </body>
    </html>
    HTML;

    $dompdf->loadHtml($html);
    $dompdf->render();
    $dompdf->stream();
} else {
    // Redirect to an error page or handle the case where facture information is not found
    header("Location: ErrorPage.php");
    exit();
}
?>

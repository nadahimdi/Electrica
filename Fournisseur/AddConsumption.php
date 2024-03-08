<?php
include "connect.php";

// Initialize variables
$uploadedFile = $_FILES['textfile'];
$crudObject = new CRUD();

if (isset($_POST['save_Consumption'])) {
    try {
        // Check if file is uploaded successfully
        if ($uploadedFile['error'] === UPLOAD_ERR_OK) {
            $fileName = $uploadedFile['name'];
            $fileTmpName = $uploadedFile['tmp_name'];

            // Read the contents of the uploaded file
            $fileContents = file_get_contents($fileTmpName);

            // Parse the contents of the file
            $lines = explode("\n", $fileContents);
            $clientId = $consumption = $year = $dateSaisie = '';

            foreach ($lines as $line) {
                $parts = explode(':', $line);
                if (count($parts) === 2) {
                    $key = trim($parts[0]);
                    $value = trim($parts[1]);

                    switch ($key) {
                        case 'ID_Client':
                            $clientId = $value;
                            break;
                        case 'Consumption':
                            $consumption = $value;
                            break;
                        case 'Annee':
                            $year = $value;
                            break;
                        case 'Date_saisie':
                            $dateSaisie = $value;
                            break;
                        // Add more cases as needed
                    }
                }
            }

            // Check if a record already exists for the client and year
            if ($crudObject->checkConsommationAnnuelleExists($clientId, $year)) {
                // Respond with a valid JSON
                echo json_encode(array('status' => 409, 'message' => 'A record already exists for the client and year'));
            } else {
                // Calculate the difference using your logic
                // For example, get the difference from the facture table
                $factureData = $crudObject->getFactureDataForYear($clientId, $year);
                $difference = $consumption - $factureData['Compteur'];
                // Replace this with the actual difference calculation

                // Determine the status based on the difference
                $status = ($difference > 50 || $difference < -50) ? 'refuser' : 'accepter';

                if ($status === 'accepter') {
                    // Store the data in the consommation_annuelle table
                    $crudObject->addConsommationAnnuelle($clientId, $consumption, $year, $difference, $status, $dateSaisie);
                    
                    // Respond with a valid JSON
                    echo json_encode(array('status' => 200, 'message' => 'Consumption data saved successfully'));
                } else {
                    // Respond with a valid JSON for the "refuser" case
                    echo json_encode(array('status' => 401, 'message' => 'Consumption data not saved. Status is "refuser"'));
                }
            }
        } else {
            // Respond with a valid JSON
            echo json_encode(array('status' => 422, 'message' => 'File upload failed'));
        }
    } catch (Exception $e) {
        // Respond with a valid JSON
        echo json_encode(array('status' => 500, 'message' => 'An error occurred during the operation', 'error' => $e->getMessage()));
    }
}
?>

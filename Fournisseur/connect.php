<?php

class CRUD {
    public $handle;

    public function __construct() {
        $server = "127.0.0.1";
        $username = "root";
        $password = "";
        $db = "electrica";

        try {
            $this->handle = new PDO("mysql:host=$server;dbname=$db", $username, $password);
            $this->handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Oops. Something went wrong in the database.");
        }
    }
    public function countClientRows() {
        try {
            $stmt = $this->handle->prepare("SELECT COUNT(*) as row_count FROM client");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['row_count'];
        } catch (PDOException $e) {
            // Handle the exception
            return 0;
        }
    }
    public function countreclamationRows() {
        try {
            $stmt = $this->handle->prepare("SELECT COUNT(*) as row_count FROM reclamation");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['row_count'];
        } catch (PDOException $e) {
            // Handle the exception
            return 0;
        }
    }


    public function countAnomalies() {
        try {
            $stmt = $this->handle->prepare("SELECT COUNT(*) as anomaly_count FROM facture WHERE type = 'anomalie'");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['anomaly_count'];
        } catch (PDOException $e) {
            // Gérer l'exception
            return 0;
        }
    }
    
    public function countNormales() {
        try {
            $stmt = $this->handle->prepare("SELECT COUNT(*) as anomaly_count FROM facture WHERE type = 'facture'");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['anomaly_count'];
        } catch (PDOException $e) {
            // Gérer l'exception
            return 0;
        }
    }


    public function getClientData() {
        try {
            $stmt = $this->handle->query("SELECT ID, nom, prenom, email, CIN, adresse FROM client ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
           
            return array(); // Retourner un tableau vide en cas d'erreur
        }
    }



    public function getAnomalieData() {
        try {
            $stmt = $this->handle->query("SELECT id, client_id, consommation_monsuelle, date_saisie, photo_path,Compteur FROM facture WHERE type = 'anomalie' ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
           
            return array(); // Retourner un tableau vide en cas d'erreur
        }
    }



    public function getRecData() {
        try {
            $stmt = $this->handle->query("SELECT * FROM reclamation WHERE status = 'pending' ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
           
            return array(); // Retourner un tableau vide en cas d'erreur
        }
    }



    public function getAnomalieDataFetch($startingLimit) {
        try {
            $stmt = $this->handle->prepare("SELECT id, client_id, consommation_monsuelle, date_saisie, photo_path, Compteur FROM facture WHERE type = 'anomalie' LIMIT :startingLimit, 20");
            $stmt->bindParam(':startingLimit', $startingLimit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return array(); // Return an empty array in case of an error
        }
    }




    public function getRecDataFetch($startingLimit) {
        try {
            $stmt = $this->handle->prepare("SELECT * FROM reclamation WHERE status = 'pending' LIMIT :startingLimit, 20");
            $stmt->bindParam(':startingLimit', $startingLimit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return array(); // Return an empty array in case of an error
        }
    }


    public function getAnomalieDataSearch($filtervalues) {
        try {
            // Using CONCAT_WS to concatenate with spaces between columns
            $stmt = $this->handle->prepare("SELECT id, client_id, consommation_monsuelle, date_saisie, photo_path,Compteur FROM facture WHERE type = 'anomalie' AND CONCAT_WS(' ',client_id,date_saisie) LIKE :filtervalues");
            
            // Adding percent signs to the search term to make it a fuzzy search
            $filtervalues = "%" . $filtervalues . "%";
    
            $stmt->bindParam(':filtervalues', $filtervalues, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return array(); // Return an empty array in case of an error
        }
    }



    public function getRecDataSearch($filtervalues) {
        try {
            // Using CONCAT_WS to concatenate with spaces between columns
            $stmt = $this->handle->prepare("SELECT * FROM reclamation WHERE status = 'pending' AND CONCAT_WS(' ',client_id,date_saisie) LIKE :filtervalues");
            
            // Adding percent signs to the search term to make it a fuzzy search
            $filtervalues = "%" . $filtervalues . "%";
    
            $stmt->bindParam(':filtervalues', $filtervalues, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return array(); // Return an empty array in case of an error
        }
    }
    
    







    public function getFactureData() {
        try {
            $stmt = $this->handle->query("SELECT id, client_id, consommation_monsuelle, date_saisie, photo_path,Compteur FROM facture WHERE type = 'facture' ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
           
            return array(); // Retourner un tableau vide en cas d'erreur
        }
    }


    public function getannuelleData() {
        try {
            $stmt = $this->handle->query("SELECT * FROM consommation_annuelle ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
           
            return array(); // Retourner un tableau vide en cas d'erreur
        }
    }
    



    public function getFactureInfoById($factureId) {
        try {
            $stmt = $this->handle->prepare("SELECT * FROM facture WHERE type = 'facture' AND id=:id");
            $stmt->bindParam(':id', $factureId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return array(); // Return an empty array in case of an error
        }
    }

 
    public function getClientInfoById($client_id) {
        try {
            $stmt = $this->handle->prepare("SELECT nom, prenom, email, CIN , adresse FROM client WHERE ID = :client_id");
            $stmt->bindParam(':client_id', $client_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return array(); // Return an empty array in case of an error
        }
    }
    

    public function getFactureClientData($client_id){
        try {
            $stmt = $this->handle->prepare("SELECT id, client_id, consommation_monsuelle, date_saisie, photo_path, Compteur FROM facture WHERE type = 'facture' AND client_id = :client_id");
            $stmt->bindParam(':client_id', $client_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return array(); // Return an empty array in case of an error
        }
    }
    


   



    public function getFactureClientDataFetch($client_id, $startingLimit) {
        try {
            $stmt = $this->handle->prepare("SELECT id, client_id, consommation_monsuelle, date_saisie, photo_path, Compteur FROM facture WHERE type = 'facture' AND client_id = :client_id LIMIT :startingLimit, 20");
            $stmt->bindParam(':client_id', $client_id, PDO::PARAM_INT);
            $stmt->bindParam(':startingLimit', $startingLimit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return array(); // Return an empty array in case of an error
        }
    }
    



    public function getFactureDataFetch($startingLimit) {
        try {
            $stmt = $this->handle->prepare("SELECT id, client_id, consommation_monsuelle, date_saisie, photo_path, Compteur FROM facture WHERE type = 'facture' LIMIT :startingLimit, 20");
            $stmt->bindParam(':startingLimit', $startingLimit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return array(); // Return an empty array in case of an error
        }
    }
// Inside your CRUD class


    public function addConsommationAnnuelle($clientId, $consumption, $year, $difference, $status, $dateSaisie) {
        try {
            $stmt = $this->handle->prepare("INSERT INTO consommation_annuelle (client_id, consommation, annee, difference, status, date_saisie) 
                                            VALUES (:client_id, :consumption, :year, :difference, :status, :date_saisie)");

            $stmt->bindParam(':client_id', $clientId);
            $stmt->bindParam(':consumption', $consumption);
            $stmt->bindParam(':year', $year);
            $stmt->bindParam(':difference', $difference);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':date_saisie', $dateSaisie);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true; // Successfully added data
            } else {
                return false; // Failed to add data
            }
        } catch (PDOException $e) {
            // Handle the exception, log it, or return an error message
            return false;
        }
    }

    // ...


    public function getFactureDataForYear($client_id, $annee) {
        $mois = 12;
        try {
            $stmt = $this->handle->prepare("SELECT * FROM facture WHERE client_id = :client_id AND YEAR(date_saisie) = :annee AND mois=:mois");
            $stmt->bindParam(':client_id', $client_id);
            $stmt->bindParam(':annee', $annee);
            $stmt->bindParam(':mois', $mois);
            $stmt->execute();
    
            // Fetch the first (and only) row
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // If there is no result, return an empty array
            return $result ? $result : array();
        } catch (PDOException $e) {
            // Handle the exception, log, or throw it further
            return array();
        }
    }
    


    public function getannuelleDataFetch($startingLimit) {
        try {
            $stmt = $this->handle->prepare("SELECT * FROM consommation_annuelle LIMIT :startingLimit, 20");
            $stmt->bindParam(':startingLimit', $startingLimit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return array(); // Return an empty array in case of an error
        }
    }
    

    public function getFactureDataSearch($filtervalues) {
        try {
            // Using CONCAT_WS to concatenate with spaces between columns
            $stmt = $this->handle->prepare("SELECT id, client_id, consommation_monsuelle, date_saisie, photo_path, Compteur FROM facture WHERE type = 'facture' AND CONCAT_WS(' ', client_id, date_saisie) LIKE :filtervalues");
            
            // Adding percent signs to the search term to make it a fuzzy search
            $filtervalues = "%" . $filtervalues . "%";
    
            $stmt->bindParam(':filtervalues', $filtervalues, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return array(); // Return an empty array in case of an error
        }
    }





    public function getannuelleDataSearch($filtervalues) {
        try {
            // Using CONCAT_WS to concatenate with spaces between columns
            $stmt = $this->handle->prepare("SELECT * FROM consommation_annuelle  CONCAT_WS(' ', annee, client_id) LIKE :filtervalues");
            
            // Adding percent signs to the search term to make it a fuzzy search
            $filtervalues = "%" . $filtervalues . "%";
    
            $stmt->bindParam(':filtervalues', $filtervalues, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return array(); // Return an empty array in case of an error
        }
    }
    


    

    public function getFactureClientDataSearch($client_id,$filtervalues){
        try {
            // Using CONCAT_WS to concatenate with spaces between columns
            $stmt = $this->handle->prepare("SELECT id, client_id, consommation_monsuelle, date_saisie, photo_path, Compteur FROM facture WHERE client_id=:client_id AND type = 'facture' AND CONCAT_WS(' ', client_id, date_saisie) LIKE :filtervalues");
            
            // Adding percent signs to the search term to make it a fuzzy search
            $filtervalues = "%" . $filtervalues . "%";
            $stmt->bindParam(':client_id', $client_id, PDO::PARAM_STR);
            $stmt->bindParam(':filtervalues', $filtervalues, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return array(); // Return an empty array in case of an error
        }
    }
    



    public function getClientDataFetch($startingLimit) {
        try {
            $stmt = $this->handle->query("SELECT ID, nom, prenom, email, CIN, adresse FROM client LIMIT " . $startingLimit . ", 20");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return array(); // Return an empty array in case of an error
        }
    }
    








    public function getClientDataSearch($filtervalues) {
        try {
            // Using CONCAT_WS to concatenate with spaces between columns
            $stmt = $this->handle->prepare("SELECT ID, nom, prenom, email, CIN, adresse FROM client WHERE CONCAT_WS(' ', ID,nom, prenom, email, CIN) LIKE :filtervalues");
            
            // Adding percent signs to the search term to make it a fuzzy search
            $filtervalues = "%" . $filtervalues . "%";
    
            $stmt->bindParam(':filtervalues', $filtervalues, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return array(); // Return an empty array in case of an error
        }
    }


  





    public function getClientRecDataFetch($client_id, $startingLimit) {
        try {
            $stmt = $this->handle->prepare("SELECT * FROM reclamation WHERE client_id=:client_id LIMIT :startingLimit, 20");
            $stmt->bindParam(':client_id', $client_id, PDO::PARAM_STR);
            $stmt->bindParam(':startingLimit', $startingLimit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return array(); // Return an empty array in case of an error
        }
    }
    


    

    public function getClientRecDataSearch($client_id, $filtervalues) {
     
        try {
          
    
            $stmt = $this->handle->prepare("SELECT * FROM reclamation WHERE client_id=:client_id AND CONCAT_WS(' ', id, client_id, contenue, date_saisie, fournisseur_id, status, contenue_reponse) LIKE :filtervalues");
    
          
    
            $filtervalues = "%" . $filtervalues . "%";
            $stmt->bindParam(':client_id', $client_id, PDO::PARAM_STR);
            $stmt->bindParam(':filtervalues', $filtervalues, PDO::PARAM_STR);
    
          
    
            $stmt->execute();
    
          
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
           
            return array(); // Return an empty array in case of an error
        }
    }
    
    



   
    public function getClientRecData($client_id) {
        try {
            $stmt = $this->handle->prepare("SELECT * FROM reclamation WHERE client_id=:client_id");
            $stmt->bindParam(':client_id', $client_id, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return array(); // Return an empty array in case of an error
        }
    }


    



    public function searchClientByCIN($searchCIN) {
        try {
            $stmt = $this->handle->prepare("SELECT ID, nom, prenom, email, CIN, adresse FROM client WHERE CIN = :search_cin");
            $stmt->bindParam(':search_cin', $searchCIN);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Gérer l'exception, enregistrer l'erreur, et retourner une réponse appropriée
            // Par exemple: error_log($e->getMessage());
            return array(); // Retourner un tableau vide en cas d'erreur
        }
    }


    public function searchClientByID($searchID) {
        try {
            $stmt = $this->handle->prepare("SELECT * FROM client WHERE ID = :searchID");
            $stmt->bindParam(':searchID', $searchID);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Gérer l'exception, enregistrer l'erreur, et retourner une réponse appropriée
            // Par exemple: error_log($e->getMessage());
            return array(); // Retourner un tableau vide en cas d'erreur
        }
    }




    private function getCompteurMoisPrecedent($client_id, $mois) {
        // Calculate the month of the previous month
        $moisPrecedent = $mois - 1;
    
        $stmt = $this->handle->prepare("SELECT Compteur FROM facture WHERE client_id = ? AND mois = ?");
        $stmt->bindParam(1, $client_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $moisPrecedent, PDO::PARAM_INT);
        $stmt->execute();
    
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($result) {
            return $result['Compteur'];
        } else {
            return 0;
        }
    }
    


        // Existing methods...
    
        public function updateAnomalie($id, $newCompteur) {
            try {
                // Get the existing anomalie details
                $anomalieDetails = $this->getAnomalieDetailsById($id);
    
                if (!$anomalieDetails) {
                    return array('status' => 404, 'message' => 'Anomalie not found');
                }
    
                // Perform calculations
                $client_id = $anomalieDetails['client_id'];
                $mois = $anomalieDetails['mois'];
                $consommationMoisPrecedent = $this->getCompteurMoisPrecedent($client_id, $mois);
    
                $consommationMensuelle = ($mois == 1) ? $newCompteur : ($newCompteur - $consommationMoisPrecedent);
    
                // Update the anomalie in the database
                $stmt = $this->handle->prepare("UPDATE facture SET Compteur=:Compteur, consommation_monsuelle=:consommation_mensuelle, type='facture' WHERE id=:id and type = 'anomalie'");
                $stmt->bindParam(':Compteur', $newCompteur);
                $stmt->bindParam(':consommation_mensuelle', $consommationMensuelle);
                $stmt->bindParam(':id', $id); 
                $stmt->execute();
    
                if ($stmt->rowCount() > 0) {
                    return array('status' => 200, 'message' => 'The anomalie is updated successfully');
                } else {
                    return array('status' => 500, 'message' => 'The anomalie has not been updated');
                }
            } catch (PDOException $e) {
                // Output any PDO exceptions for debugging
                return array('status' => 500, 'message' => 'An error occurred during the database operation', 'pdo_exception' => $e->getMessage());
            }
        }
    
        // Inside your CRUD class or wherever you handle database operations
public function checkConsommationAnnuelleExists($clientId, $year) {
    try {
        $stmt = $this->handle->prepare("SELECT COUNT(*) FROM consommation_annuelle WHERE client_id = ? AND annee = ?");
        $stmt->bindParam(1, $clientId, PDO::PARAM_INT);
        $stmt->bindParam(2, $year, PDO::PARAM_INT);
        $stmt->execute();

        $count = $stmt->fetchColumn();

        return ($count > 0);
    } catch (PDOException $e) {
        // Handle any exceptions here, log or return false based on your error handling strategy
        return false;
    }
}

        // Additional methods...
    
        private function getAnomalieDetailsById($id) {
            $stmt = $this->handle->prepare("SELECT * FROM facture WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
    
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    
    
    private function insertIntoFacture($client_id, $consommationMensuelle, $mois, $photo_path, $date_saisie, $status_f, $prix_HT, $prix_TTC, $Compteur, $type) {
        $sql = "INSERT INTO facture (client_id, consommation_monsuelle, mois, photo_path, date_saisie, status_f, prix_HT, prix_TTC, Compteur, type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->handle->prepare($sql);
        $stmt->bindParam(1, $client_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $consommationMensuelle, PDO::PARAM_STR);
        $stmt->bindParam(3, $mois, PDO::PARAM_INT);
        $stmt->bindParam(4, $photo_path, PDO::PARAM_STR);
        $stmt->bindParam(5, $date_saisie, PDO::PARAM_STR);
        $stmt->bindParam(6, $status_f, PDO::PARAM_STR);
        $stmt->bindParam(7, $prix_HT, PDO::PARAM_STR);
        $stmt->bindParam(8, $prix_TTC, PDO::PARAM_STR);
        $stmt->bindParam(9, $Compteur, PDO::PARAM_INT);
        $stmt->bindParam(10, $type, PDO::PARAM_STR);

        $stmt->execute();
    }


    public function insertConsumption($client_id,$compteur, $date, $uploadedFileName) {
        $mois = date('m', strtotime($date));
        $status_f = 'non_payee';
        $consommationMensuelle = ($mois == 1) ? $compteur : ($compteur - $this->getCompteurMoisPrecedent($client_id,$mois));
        if ($consommationMensuelle <= 100) {
            $prixUnitaire = 0.8;
        } elseif ($consommationMensuelle <= 200) {
            $prixUnitaire = 0.9;
        } else {
            $prixUnitaire = 1.0;
        }
        $prixHT = $consommationMensuelle * $prixUnitaire;
        $prixTTC = $prixHT * 1.14;
        $type = ($consommationMensuelle < 0) ? 'anomalie' : 'facture';

        // Insérer les valeurs calculées dans la base de données
        $this->insertIntoFacture($client_id, $consommationMensuelle, $mois, $uploadedFileName, $date, $status_f, $prixHT, $prixTTC, $compteur, $type);
    }
// Add this method to your CRUD class
public function getFactureType($client_id) {
    try {
        $stmt = $this->handle->prepare("SELECT type FROM facture WHERE client_id = :client_id ORDER BY id DESC LIMIT 1");
        $stmt->bindParam(':client_id', $client_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the result is not empty and has the 'type' key
        if ($result && isset($result['type'])) {
            return $result['type'];
        }

        // Return a default value or handle the case when no result is found
        return 'default';
    } catch (PDOException $e) {
        // Handle the exception if needed
        return 'default';
    }
}


}







?>

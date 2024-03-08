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

    public function getHashedPasswordFournisseur($cin) {
        try {
            $stmt = $this->handle->prepare("SELECT password FROM fournisseur WHERE CIN=:CIN");
            $stmt->bindParam(':CIN', $cin);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($result) {
                return $result['password'];
            } else {
                return null; // CIN not found in the fournisseur table
            }
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getHashedPasswordClient($cin) {
        try {
            $stmt = $this->handle->prepare("SELECT password FROM client WHERE CIN=:CIN");
            $stmt->bindParam(':CIN', $cin);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($result) {
                return $result['password'];
            } else {
                return null; // CIN not found in the client table
            }
        } catch (PDOException $e) {
            return null;
        }
    }




public function getClientIdByCIN($cin) {
    try {
        $stmt = $this->handle->prepare("SELECT ID FROM client WHERE CIN = :cin");
        $stmt->bindParam(':cin', $cin);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            return $result['ID'];
        } else {
            return null;  
        }
    } catch (PDOException $e) {
        // Handle the exception, log the error, and return null
        // For example: error_log($e->getMessage());
        return null;
    }
}




public function getFournisseurIdByCIN($cin) {
    try {
        $stmt = $this->handle->prepare("SELECT id FROM fournisseur WHERE CIN = :cin");
        $stmt->bindParam(':cin', $cin);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            return $result['id'];
        } else {
            return null;  
        }
    } catch (PDOException $e) {
        // Handle the exception, log the error, and return null
        // For example: error_log($e->getMessage());
        return null;
    }
}
}
?>

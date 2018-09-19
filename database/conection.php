<?php
class Conection{

    private $serverName;
    private $user;
    private $pass;
    private $database;
    private $dbs;
    
    public function __construct() {
        // Agregar los datos de SQL Server
        $this->serverName = "DESKTOP-58GUPHB\SQLEXPRESS";
        $this->database = "dbreferido";
        $this->user = "userreferido";
        $this->pass = "passreferido**";
    }

    function initConection() {
        try {
            $this->dbs = new PDO(
                "sqlsrv:server=".$this->serverName.";Database=".$this->database,
                $this->user,
                $this->pass,
                array(
                    //PDO::ATTR_PERSISTENT => true,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                )
            );
        }
        catch(PDOException $e) {
            die("Error conectando con SQL Server: " . $e->getMessage());
        } 
    }

    function runQuery($sql) {
        if($stmt = $this->dbs->prepare($sql)){
            if($stmt->execute()){
                return $stmt;
            }
            // die('Error al ejecutar el Query [' . $stmt->error . ']');
        }
    }

    function closeConection() {
        $this->dbs = null;
    }

    function getlastInsertId(){
        // Obtener el id del ultimo dato guardado
        return $this->dbs->lastInsertId();
    }

}

?>
<?php 
require_once ("conection.php");
class Productos{
	private $conection;
    private $nameTable;

    public function __construct(){
        $this->conection = new Conection;
        $this->nameTable = "producto";
    }

    public function getAll(){
        $this->conection->initConection();
        $query = "SELECT id_producto, nombre, descripcion, estado FROM {$this->nameTable}";
        return $this->conection->runquery($query);
    }

    public function getID($id){
        $this->conection->initConection();
        $query = "SELECT id_producto, nombre, descripcion, estado FROM ".$this->nameTable." WHERE id_producto = ".$id.";";
        return $this->conection->runquery($query);
    }

    public function create($data){
        $this->conection->initConection();
        $query = "INSERT INTO ".$this->nameTable." (nombre, descripcion, estado) 
                VALUES ('".$data['nombre']."', '".$data['descripcion']."', ".$data['estado'].");";
        return $this->conection->runquery($query);
    }

    public function edit($id, $data){
        $this->conection->initConection();
        $query = "UPDATE ".$this->nameTable." SET nombre = '".$data['nombre']."', descripcion = '".$data['descripcion']."', 
                estado = ".$data['estado']." WHERE id_producto = ".$id.";";
        return $this->conection->runquery($query);
    }

    public function delete(){

    }
}


?>
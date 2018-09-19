<?php 
require_once ("conection.php");
class Productos{
	private $conection;
    private $nameTable;

    public function __construct(){
        $this->conection = new Conection;
        // Nombre de la tabla en la base de datos
        $this->nameTable = "producto";
    }

    public function getAll(){
        $this->conection->initConection();
        // Agregar o cambiar * los campos que tiene la tabla
        $query = "SELECT * FROM {$this->nameTable}";
        return $this->conection->runquery($query);
    }

    public function getID($id){
        $this->conection->initConection();
        // Agregar o cambiar * los campos que tiene la tabla
        $query = "SELECT * FROM ".$this->nameTable." WHERE id_producto = ".$id.";";
        return $this->conection->runquery($query);
    }

    public function create($data){
        $this->conection->initConection();
        // Agregar o cambiar los campos que tiene la tabla
        $query = "INSERT INTO ".$this->nameTable." (nombre, descripcion, estado) 
                VALUES ('".$data['nombre']."', '".$data['descripcion']."', ".$data['estado'].");";
        return $this->conection->runquery($query);
    }

    public function edit($id, $data){
        $this->conection->initConection();
        // Agregar o cambiar los campos que tiene la tabla
        $query = "UPDATE ".$this->nameTable." SET nombre = '".$data['nombre']."', descripcion = '".$data['descripcion']."', 
                estado = ".$data['estado']." WHERE id_producto = ".$id.";";
        return $this->conection->runquery($query);
    }

    public function delete($id){
        $this->conection->initConection();
        // Cambiar el id de la tabla
        $query ="DELETE FROM ".$this->nameTable." WHERE id =".$id.";";
        return $this->conection->runquery($query);
    }
}


?>
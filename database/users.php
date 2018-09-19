<?php 
require_once ("conection.php");
class Users{
	private $conection;
    private $nameTable;

    public function __construct(){
        $this->conection = new Conection;
        $this->nameTable = "usuario";
    }

    public function getAll(){
        $this->conection->initConection();
        $query = "SELECT id_usuario, username, nombre, apellido, numero_empleado, admin, estado FROM {$this->nameTable}";
        return $this->conection->runquery($query);
    }

    public function getID($id){
        $this->conection->initConection();
        $query = "SELECT id_usuario, username, password, nombre, apellido, numero_empleado, admin, estado FROM ".$this->nameTable." WHERE id_usuario = ".$id.";";
        return $this->conection->runquery($query);
    }

    public function create($data){
        $this->conection->initConection();
        $query = "INSERT INTO ".$this->nameTable." (username, password, nombre, apellido, numero_empleado, admin, estado) 
                VALUES ('".$data['usuario']."', '".password_hash($data['password'], PASSWORD_DEFAULT)."', '".$data['nombre']."', 
                '".$data['apellido']."', ".$data['numero_empleado'].", ".$data['rol'].", ".$data['estado'].");";
        return $this->conection->runquery($query);
    }

    public function edit($id, $data){
        $this->conection->initConection();
        $pass = (!empty($data['password']))? ",password =  '".password_hash($data['password'], PASSWORD_DEFAULT)."'": "";
        $query = "UPDATE ".$this->nameTable." SET username = '".$data['usuario']."', nombre = '".$data['nombre']."', 
                apellido = '".$data['apellido']."', numero_empleado = ".$data['numero_empleado'].", admin = ".$data['rol'].", 
                estado = ".$data['estado']." ".$pass."  WHERE id_usuario = ".$id.";";
        return $this->conection->runquery($query);
    }
    
    public function editPassword($id, $actualPass, $nuevoPass){
        $this->conection->initConection();
        $result = $this->getID($id);
        $user = $result->fetch();
        if(password_verify($actualPass, $user['password'])){
            $query = "UPDATE ".$this->nameTable." SET password = '".password_hash($nuevoPass, PASSWORD_DEFAULT)."' WHERE id_usuario = ".$id.";";
            return $this->conection->runquery($query);
        } else {
            return false;
        }
    }

    public function delete(){

    }

    public function login($user, $pass){
        $this->conection->initConection();
        $query = "SELECT id_usuario, username, password, nombre, apellido, numero_empleado, admin, estado FROM ".$this->nameTable." 
                WHERE username = '".$user."';";
        $result =  $this->conection->runquery($query);
        $user = $result->fetch();

        if($user) {
            if(password_verify($pass, $user['password'])){
                $_SESSION['login'] = True;
                $_SESSION['id'] = $user['id_usuario'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['nombre'] = $user['nombre'];
                $_SESSION['apellido'] = $user['apellido'];
                $_SESSION['numero_empleado'] = $user['numero_empleado'];
                $_SESSION['admin'] = $user['admin'];
                
                return true;
            }else {
                return false;
            }
        }else {
            return false;
        }
    }

    public function getReferidosUsuario($idUsuario){
        $this->conection->initConection();
        $query ="SELECT c.id_cliente, c.primer_nombre, c.segundo_nombre, c.primer_apellido, c.segundo_apellido,
                c.fecha_nacimiento, c.dpi, c.telefono, c.celular, c.estado 
                FROM referencia r INNER JOIN cliente c ON c.id_cliente = r.id_cliente 
                WHERE id_usuario =".$idUsuario;
                // GROUP BY c.id_cliente;";
        // echo $query;    
        return $this->conection->runquery($query);
    }
}


?>
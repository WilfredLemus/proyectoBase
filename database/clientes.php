<?php 
require_once ("conection.php");
date_default_timezone_set('America/Guatemala');

class Clientes{
	private $conection;
    private $nameTable;

    public function __construct(){
        $this->conection = new Conection;
        $this->nameTable = "cliente";
    }


    public function getAll(){
        $this->conection->initConection();
        $query = "SELECT * FROM {$this->nameTable}";
        return $this->conection->runquery($query);
    }

    public function getID($id){
        $this->conection->initConection();
        $query = "SELECT * FROM ".$this->nameTable." WHERE id_cliente = ".$id.";";
        return $this->conection->runquery($query);
    }

    public function create($data){
        $result = $this->checkClienteExiste($data);
        $cliente = $result->fetch();
        if($cliente){
            return array('code'=> 2, 'data'=> $cliente);
        }else{
            $this->conection->initConection();
            $Fnacimiento = DateTime::createFromFormat('d/m/Y', $data['fecha_nacimiento'])->format('Y-m-d');
            $query = "INSERT INTO ".$this->nameTable." 
                    (primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
                    fecha_nacimiento, dpi, telefono, celular, 
                    direccion, estado) 
                    VALUES 
                    ('".$data['primer_nombre']."', '".$data['segundo_nombre']."', '".$data['primer_apellido']."', '".$data['segundo_apellido']."', 
                    '".$Fnacimiento."', ".((empty($data['dpi']))?'null':$data['dpi']).", ".((empty($data['telefono']))?'null':$data['telefono']).", ".((empty($data['celular']))?'null':$data['celular']).",
                    '".$data['direccion']."', 1);";
            // echo $query;SELECT LAST_INSERT_ID();
            if($this->conection->runquery($query)){
                // $result = $this->conection->runquery("SELECT SCOPE_IDENTITY()");
                $idCliente = $this->conection->getlastInsertId();
                $clienteResponse = array('id_cliente'=>$idCliente, 'primer_nombre'=>$data['primer_nombre'], 'primer_apellido'=>$data['primer_apellido']);
                if($data['referencia']>0){
                    if($this->agregarReferencia($idCliente, $data['referencia'], $data['notas'], $_SESSION['id'])){
                        return array('code'=> 1, 'data'=> $clienteResponse);
                    }else {
                        return array('code'=> 3, 'data'=> $clienteResponse);
                    };
                }else {
                    return array('code'=> 1, 'data'=> $clienteResponse);
                }
            }else {
                return array('code'=> 4, 'data'=> '');
            }
        }
    }

    public function edit($id, $data){
        $this->conection->initConection();
        $Fnacimiento = DateTime::createFromFormat('d/m/Y', $data['fecha_nacimiento'])->format('Y-m-d');
        $estado = ((isset($data['estado']))? ",estado = ".$data['estado']: "");
        $query = "UPDATE ".$this->nameTable." SET
                primer_nombre = '".$data['primer_nombre']."', segundo_nombre = '".$data['segundo_nombre']."', primer_apellido = '".$data['primer_apellido']."',
                segundo_apellido = '".$data['segundo_apellido']."', fecha_nacimiento = '".$Fnacimiento."', dpi = ".((empty($data['dpi']))?'null':$data['dpi']).",
                telefono = ".((empty($data['telefono']))?'null':$data['telefono']).", celular = ".((empty($data['celular']))?'null':$data['celular']).", direccion = '".$data['direccion']."' 
                ".$estado." WHERE id_cliente = ".$id.";";
        return $this->conection->runquery($query);
    }

    public function buscarCliente($data){
        $this->conection->initConection();
        $Snombre = ((empty($data['segundo_nombre']))? "": "OR segundo_nombre LIKE '".$data['segundo_nombre']."' ");
        $Sapellido = ((empty($data['segundo_apellido']))? "": "OR segundo_apellido LIKE '".$data['segundo_apellido']."' ");
        $dpi = ((empty($data['dpi']))? "": "AND dpi = ".$data['dpi']);
        if(!empty($data['fecha_nacimiento'])){
            $FechaFormat = DateTime::createFromFormat('d/m/Y', $data['fecha_nacimiento'])->format('Y-m-d');
            $Fnacimiento = "AND fecha_nacimiento ='".$FechaFormat."'";
        }else {
            $Fnacimiento = "";
        }
        
        $query = "SELECT * FROM ".$this->nameTable." WHERE primer_nombre LIKE '%".$data['primer_nombre']."%' OR primer_apellido LIKE '%".$data['primer_apellido']."%' 
                ".$Snombre." ".$Sapellido." ".$dpi." ".$Fnacimiento.";";
        
        // echo $query;
        return $this->conection->runquery($query);
    }

    public function delete(){

    }

    public function agregarReferencia($idCliente, $idProducto, $notas, $idUsuario){
        $hoy = date("Y-m-d H:i:s");
        $this->conection->initConection();
        $query = "INSERT INTO referencia (fecha, id_cliente, id_producto, id_usuario, notas, estado) 
                VALUES ('".$hoy."', ".$idCliente.", ".$idProducto.", ".$idUsuario.", '".$notas."', 1);";
        return $this->conection->runquery($query);
    }


    public function checkClienteExiste($data){
        $Fnacimiento = DateTime::createFromFormat('d/m/Y', $data['fecha_nacimiento'])->format('Y-m-d');
        $this->conection->initConection();
        $query = "SELECT id_cliente, primer_nombre, primer_apellido, fecha_nacimiento FROM ".$this->nameTable." 
                WHERE primer_nombre = '".$data['primer_nombre']."' AND primer_apellido = '".$data['primer_apellido']."' 
                AND fecha_nacimiento = '".$Fnacimiento."' ;";
        // return $this->conection->runquery($query);
        // $result =  
        return $this->conection->runquery($query);
        
    }

    public function getProductosNoReferidos($idCliente){
        $this->conection->initConection();
        $query = "SELECT id_producto, nombre FROM producto WHERE estado = 1 
                AND id_producto NOT IN 
                (SELECT id_producto FROM referencia WHERE estado = 1 AND id_cliente = ".$idCliente.")";
        return $this->conection->runquery($query);
    }

    public function getClienteReferencias($idCliente){
        $this->conection->initConection();
        $query ="SELECT r.id_referencia, r.fecha, r.notas, r.estado, r.comentario_estado, p.nombre as nombre_producto, 
                u.nombre as nombre_usuario, u.id_usuario as id_usuario, id_usuario_estado, u2.nombre as nombre_estado
                FROM referencia r INNER JOIN producto p ON p.id_producto = r.id_producto 
                INNER JOIN usuario u ON u.id_usuario = r.id_usuario
                LEFT JOIN usuario u2 ON u2.id_usuario = r.id_usuario_estado
                WHERE id_cliente =".$idCliente." ORDER BY r.fecha DESC;";
        return $this->conection->runquery($query);
    }

    public function getClienteBitacoras($idCliente){
        $this->conection->initConection();
        $query ="SELECT b.id_bitacora, b.fecha, b.comentario, b.id_usuario, u.nombre as nombre_usuario 
                FROM bitacora b INNER JOIN usuario u ON u.id_usuario = b.id_usuario 
                WHERE id_cliente =".$idCliente." ORDER BY b.fecha DESC;";
        return $this->conection->runquery($query);
    }

    public function deleteReferencia($idReferencia){
        $this->conection->initConection();
        $query ="DELETE FROM referencia WHERE id_referencia =".$idReferencia.";";
        return $this->conection->runquery($query);
    }

    public function cambiarEstadoReferencia($idReferencia, $estado, $comentarioEstado, $idUsuario){
        $this->conection->initConection();
        $query ="UPDATE referencia SET estado =".$estado.", comentario_estado = '".$comentarioEstado."',
                id_usuario_estado = ".$idUsuario." WHERE id_referencia =".$idReferencia.";";
        return $this->conection->runquery($query);
    }

    public function agregarBitacora($idCliente, $comentario, $idUsuario){
        $hoy = date("Y-m-d H:i:s");
        $this->conection->initConection();
        $query = "INSERT INTO bitacora (fecha, id_cliente, id_usuario, comentario) 
                VALUES ('".$hoy."', ".$idCliente.", ".$idUsuario.", '".$comentario."');";
        return $this->conection->runquery($query);
    }

    public function deleteBitacora($idBitacora){
        $this->conection->initConection();
        $query ="DELETE FROM bitacora WHERE id_bitacora =".$idBitacora.";";
        return $this->conection->runquery($query);
    }
    
}


?>
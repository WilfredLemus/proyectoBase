<?php 
require_once("./functions.php");

if(is_ajax()){
    session_start();
    require_once ("../database/clientes.php");
    
    function getProductosNoReferenciados(){
        if(isset($_POST['idCliente'])){
            $clientesDB = new Clientes;
            $result = $clientesDB->getProductosNoReferidos($_POST['idCliente']);
            $prods = array();
            foreach($result as $producto) {
                $prods[] = array(
                            'id'=> $producto['id_producto'], 
                            'nombre'=> $producto['nombre']
                        );
            }

            echo json_encode($prods);
        }
    }
    
    
    
    function getClienteReferencias(){
        if(isset($_POST['idCliente'])){
            $clientesDB = new Clientes;
            $result = $clientesDB->getClienteReferencias($_POST['idCliente']);
            $refe = array();
            foreach($result as $cliente) {
                $refe[] = array(
                            'id'=> $cliente['id_referencia'], 
                            'fecha'=> DateTime::createFromFormat('Y-m-d H:i:s.u',$cliente["fecha"])->format('d/m/Y H:i:s'), 
                            'notas'=> $cliente['notas'], 
                            'estado'=> $cliente['estado'], 
                            'id_usuario'=> $cliente['id_usuario'],
                            'nombre_producto'=> $cliente['nombre_producto'], 
                            'nombre_usuario'=> $cliente['nombre_usuario'],
                            'nombre_estado'=> $cliente['nombre_estado'], 
                            'comentario_estado'=> $cliente['comentario_estado'],
                        );
            }

            echo json_encode($refe);
        }
    }

    function getClienteBitacoras(){
        if(isset($_POST['idCliente'])){
            $clientesDB = new Clientes;
            $result = $clientesDB->getClienteBitacoras($_POST['idCliente']);
            $bita = array();
            // 'fecha'=> DateTime::createFromFormat('Y-m-d time',$bitacora["fecha"])->format('d/m/Y H:i:s'), 
            foreach($result as $bitacora) {
                $bita[] = array(
                            'id'=> $bitacora['id_bitacora'], 
                            'fecha'=> DateTime::createFromFormat('Y-m-d H:i:s.u',$bitacora["fecha"])->format('d/m/Y H:i:s'),
                            'comentario'=> $bitacora['comentario'], 
                            'id_usuario'=> $bitacora['id_usuario'],
                            'nombre_usuario'=> $bitacora['nombre_usuario']
                        );
            }

            echo json_encode($bita);
        }
    }


    function setClienteReferencia(){
        if(isset($_POST['idCliente'], $_POST['dataReferencia'])){
            $clientesDB = new Clientes;
            if($clientesDB->agregarReferencia($_POST['idCliente'], $_POST['dataReferencia']['producto'], $_POST['dataReferencia']['notas'], $_SESSION['id'])){
                return getClienteReferencias();
            }
        }
    }


    function deleteReferencia(){
        if(isset($_POST['idReferencia'])){
            $clientesDB = new Clientes;
            if($clientesDB->deleteReferencia($_POST['idReferencia'])){
                return getClienteReferencias();
            }
        }
    }

    function cambiarEstadoReferencia(){
        if(isset($_POST['idReferencia'], $_POST['estadoReferencia'], $_POST['comentarioEstadoReferencia'])){
            $clientesDB = new Clientes;
            if($clientesDB->cambiarEstadoReferencia($_POST['idReferencia'], $_POST['estadoReferencia'], $_POST['comentarioEstadoReferencia'], $_SESSION['id'])){
                return getClienteReferencias();
            }
        }
    }

    function addBitacora(){
        if(isset($_POST['idCliente'], $_POST['comentarios'])){
            $clientesDB = new Clientes;
            if($clientesDB->agregarBitacora($_POST['idCliente'], $_POST['comentarios'], $_SESSION['id'])){
                return getClienteBitacoras();
            }
        }
    }

    function deleteBitacora(){
        if(isset($_POST['idBitacora'])){
            $clientesDB = new Clientes;
            if($clientesDB->deleteBitacora($_POST['idBitacora'])){
                return getClienteBitacoras();
            }
        }
    }



    switch($_POST['act']){
        case '1':
            getProductosNoReferenciados();
        break;
        case '2':
           getClienteReferencias();
        break;
        case '3':
           getClienteBitacoras();
        break;
        case '4':
           setClienteReferencia();
        break;
        case '5':
           deleteReferencia();
        break;
        case '6':
            cambiarEstadoReferencia();
        break;
        case '7':
            addBitacora();
        break;
        case '8':
            deleteBitacora();
        break;
    }


}

?>
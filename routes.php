<?php
$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);
$request_uri = trim( $request_uri[0], "/" );
$request_uri = explode( "/", $request_uri );

switch ($request_uri[0]) {
    case '':
        require 'app/clientes/index.php';
        break;
    case 'usuarios':
        require 'app/users/index.php';
        break;
    case 'productos':
        require 'app/productos/index.php';
        break;
    case 'clientes':
        require 'app/clientes/index.php';
        break;
    case 'login':
        require 'app/users/login.php';
        break;
    case 'logout':
        session_destroy();
        session_unset();
        echo '<script type="text/javascript">window.location.href = "/";</script>';
        // require 'app/users/logout.php';
        break;
    default:
        // header('HTTP/1.0 404 Not Found');
        require 'app/404.php';
        break;
}
?>
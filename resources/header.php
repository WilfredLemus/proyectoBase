<header class="main-header">
    <a href="/" class="logo">
        <span class="logo-mini">
            <img src="/statics/img/guayacan.png" height="27" alt="Logo Guayacan">
        </span>
        <span class="logo-lg">
            <img src="/statics/img/guayacan.png" height="60" alt="Logo Guayacan">
        </span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown messages-menu">
                    <a href="/clientes/buscar" title="Buscar Cliente" data-toggle="tooltip">
                        <i class="fa fa-search"></i>
                        <span class="hidden-xs"> Buscar Cliente</span>
                    </a>
                </li>
                <li class="dropdown messages-menu">
                    <a href="/clientes/nuevo" title="Agregar Cliente" data-toggle="tooltip">
                        <i class="fa fa-id-badge"></i>
                        <span class="hidden-xs"> Agregar Cliente</span>
                    </a>
                </li>
                <li class="dropdown messages-menu">
                    <a href="/usuarios/mis-referidos" title="Mis Referidos" data-toggle="tooltip">
                        <i class="fa fa-id-card"></i>
                        <span class="hidden-xs"> Mis Referidos</span>
                    </a>
                </li>
                <?php 
                echo '
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="hidden-xs">'.$_SESSION['nombre'].' '.$_SESSION['apellido'].'</span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="/statics/img/user.png" class="img-circle" alt="User Image">
                            <p>
                                '.$_SESSION['nombre'].' '.$_SESSION['apellido'].'
                                <small>'.$_SESSION['username'].'</small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="/usuarios/mi-perfil/" class="btn btn-default btn-flat btn-block"><i class="fa fa-address-card-o"></i> Perfil</a>
                            </div>
                            <div class="pull-right">
                                <a href="/logout" class="btn btn-danger btn-flat btn-block"><i class="fa fa-sign-out"></i> Salir</a>
                            </div>
                        </li>
                    </ul>
                </li>';
                ?>
            </ul>
        </div>
    </nav>
</header>
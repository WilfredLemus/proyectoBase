<?php
session_start();
date_default_timezone_set('America/Guatemala');

if(isset($_SESSION['login'])) {

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistema de Referidos | Cooperativa Guayacán</title>
    <link rel="shortcut icon" href="/statics/img/guayacan.png">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="/statics/dist/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/statics/dist/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/statics/dist/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="/statics/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="/statics/dist/css/skins/_all-skins.min.css">
    <!-- <link rel="stylesheet" href="/statics/dist/bower_components/morris.js/morris.css"> -->
    <!-- <link rel="stylesheet" href="/statics/dist/bower_components/jvectormap/jquery-jvectormap.css"> -->
    <link rel="stylesheet" href="/statics/dist/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="/statics/dist/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="/statics/dist/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="/statics/dist/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- <link rel="stylesheet" href="/statics/dist/plugins/iCheck/all.css"> -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style>[v-cloak] { display:none; }</style>
</head>
<!-- Agregar sidebar-collapse minimizar aside -->
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <?php 
    include_once("resources/header.php");
    include_once("resources/aside.php");
    ?>

    <div class="content-wrapper">
        <?php require_once "routes.php";?>
    </div>
    <footer class="main-footer">
        <strong>Sistema de Referidos</strong>
        <div class="pull-right hidden-xs">
            <b>Version</b> 0.0.1
        </div>
    </footer>
    <!-- Add the sidebar's background. This div must be placed
        immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>

<script src="/statics/dist/bower_components/jquery/dist/jquery.min.js"></script>
<script src="/statics/dist/bower_components/jquery-ui/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="/statics/dist/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/statics/dist/bower_components/moment/min/moment.min.js"></script>
<script src="/statics/dist/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="/statics/dist/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="/statics/dist/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="/statics/dist/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/statics/dist/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="/statics/dist/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="/statics/dist/bower_components/fastclick/lib/fastclick.js"></script>
<script src="/statics/dist/plugins/input-mask/jquery.inputmask.js"></script>
<script src="/statics/dist/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="/statics/dist/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script src="/statics/dist/js/adminlte.min.js"></script>
<!-- <script src="/statics/dist/bower_components/raphael/raphael.min.js"></script> -->
<!-- <script src="/statics/dist/bower_components/morris.js/morris.min.js"></script> -->
<!-- <script src="/statics/dist/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script> -->
<!-- <script src="/statics/dist/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script> -->
<!-- <script src="/statics/dist/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script> -->
<!-- <script src="/statics/dist/bower_components/jquery-knob/dist/jquery.knob.min.js"></script> -->
<!-- <script src="/statics/dist/plugins/iCheck/icheck.min.js"></script> -->


<!-- Vuejs -->
<!-- development version, includes helpful console warnings -->
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<!-- production version, optimized for size and speed -->
<!-- <script src="https://cdn.jsdelivr.net/npm/vue"></script> -->
<script src="/statics/js/app.js"></script>
<script>
  $(function () {
    $('.tableData').DataTable({
        "language": {
            "url": "/statics/dist/Spanish.json"
        },
        "iDisplayLength": 25,
    });
    $('[data-mask]').inputmask();
    // $('input[type="checkbox"].minimal').iCheck({
    //   checkboxClass: 'icheckbox_minimal-blue'    
    // });
  })
</script>
</body>

</html>

<?php 
    
}else {
    include_once("app/users/login.php");
}

?>
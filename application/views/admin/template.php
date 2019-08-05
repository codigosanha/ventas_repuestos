<!DOCTYPE html>
<html lang="es">
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistema de Ventas de Repuestos</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/template/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/template/jquery-ui/jquery-ui.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/template/alertify/themes/alertify.core.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/template/alertify/themes/alertify.default.css">

      <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/template/Ionicons/css/ionicons.min.css">
     <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/template/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- DataTables Export-->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/template/datatables-export/css/buttons.dataTables.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/template/font-awesome/css/font-awesome.min.css">
    <!--Select 2-->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/template/select2/dist/css/select2.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/template/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/template/dist/css/skins/_all-skins.min.css">
    
    <link rel="stylesheet" href="<?php echo base_url();?>assets/template/sweetalert/sweetalert.css">
    
    <link rel="stylesheet" href="<?php echo base_url();?>assets/template/jquery/jquery-confirm.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/template/backend/css/style.css">
    <!-- jQuery 3 -->
    <script src="<?php echo base_url();?>assets/template/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/template/sweetalert/sweetalert.min.js"></script>
</head>
<body class="hold-transition skin-black sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <header class="main-header">
            <!-- Logo -->
            <a href="<?php echo base_url(); ?>" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>G</b>C</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>Compras y Ventas</b></span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button" id="collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- Notifications: style can be found in dropdown.less -->
                        <li style="padding: 15px;">
                            <b>Sucursal:</b> 
                            <?php if ($this->session->userdata("sucursal")): ?>
                                <?php echo get_record("sucursales","id=".$this->session->userdata("sucursal"))->nombre;?>
                            <?php else: ?>
                                <?php echo "General";?>
                            <?php endif ?>
                        </li>
                    
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?php echo base_url()?>assets/template/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                                <span class="hidden-xs"><?php echo $this->session->userdata("username")?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header">
                                    <img src="<?php echo base_url()?>assets/template/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image" text-align="center">
                <p>
                 <span text-align="center" class="hidden-xs"><?php echo $this->session->userdata("username")?></span>  
                </p>
                 <p><small>Sistema de Compras y Ventas con Control de Inventario</small></p>
                <br>
                 <li class="user-footer">
                <div class="pull-right">
                  <a href="<?php echo base_url(); ?>auth/logout" class="btn btn-default btn-flat">Cerrar Sesion</a>
                </div>
                    </li>
                                   
                                    <!-- /.row -->
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <aside class="main-sidebar" id="side-bar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">      
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu" data-widget="tree">

                    <li class="header">Menu</li>
                          <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                             <img src="<?php echo base_url();?>img/cloud.png" alt="Avatar" /> 
                        </div>
                        <div class="pull-left info">
                            <p><?php echo $this->session->userdata("username")?></p>
                            <p><i class="fa fa-circle text-success"></i> En Linea</p>
                        </div>
                    </div>
                    <?php echo $this->backend_lib->getMenu();?>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <?php echo $contenido;?>
                <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright &copy; 2018 <a href="#"></a>.</strong> All rights
            reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

<!-- Highcharts -->
<script src="<?php echo base_url();?>assets/template/highcharts/highcharts.js"></script>
<script src="<?php echo base_url();?>assets/template/highcharts/exporting.js"></script>
<script src="<?php echo base_url();?>assets/template/jquery-print/jquery.print.js"></script>

<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url();?>assets/template/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/template/jquery-ui/jquery-ui.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url();?>assets/template/select2/dist/js/select2.full.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url();?>assets/template/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url();?>assets/template/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/template/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- DataTables Export -->
<script src="<?php echo base_url();?>assets/template/datatables-export/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url();?>assets/template/datatables-export/js/buttons.flash.min.js"></script>
<script src="<?php echo base_url();?>assets/template/datatables-export/js/jszip.min.js"></script>
<script src="<?php echo base_url();?>assets/template/datatables-export/js/pdfmake.min.js"></script>
<script src="<?php echo base_url();?>assets/template/datatables-export/js/vfs_fonts.js"></script>
<script src="<?php echo base_url();?>assets/template/datatables-export/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url();?>assets/template/datatables-export/js/buttons.print.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url();?>assets/template/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url();?>assets/template/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url();?>assets/template/dist/js/demo.js"></script>
<script src="<?php echo base_url();?>assets/template/alertify/lib/alertify.min.js"></script>

<script src="<?php echo base_url();?>assets/template/jquery/jquery-confirm.min.js"></script>
<script src="<?php echo base_url();?>assets/template/jsbarcode/JsBarcode.all.min.js"></script>
<script>
    var base_url = "<?php echo base_url();?>";

</script>
<script src="<?php echo base_url();?>assets/template/backend/script.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistema de Compras y Ventas | Dashboard</title>
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
    
    <style>
        .menu-notificaciones li{
            padding: 7px;
        }
        .menu-notificaciones li span a{
            text-decoration: : none;
            color: #BDBBBA;
        }
        .menu-notificaciones li span a:hover{
            color: #848484;
        }
        .navbar-nav>.notifications-menu>.dropdown-menu>li .menu>li>a, .navbar-nav>.messages-menu>.dropdown-menu>li .menu>li>a, .navbar-nav>.tasks-menu>.dropdown-menu>li .menu>li>a{
            white-space: normal;
        }
       
        .contenido{
            width: 280px;
        }
        .contenido label{
            margin-bottom: 0px;
        }
        .contenido p{
            margin: 0px;
        }
        .impresion{
            padding: 10px;
        }
        @page { size: auto;  margin: 0mm;}
        @media (max-width: 480px) {
            .input-cantidad {
                width: 60px !important;
            }
        }
    </style>
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
                    
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?php echo base_url()?>assets/template/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                                <span class="hidden-xs"><?php echo $this->session->userdata("nombre")?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header">
                                    <img src="<?php echo base_url()?>assets/template/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image" text-align="center">
                <p>
                 <span text-align="center" class="hidden-xs"><?php echo $this->session->userdata("nombre")?></span>  
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
                            <p><?php echo $this->session->userdata("nombre")?></p>
                            <p><i class="fa fa-circle text-success"></i> En Linea</p>
                        </div>
                    </div>
                    <li><a href="<?php echo base_url();?>backend/dashboard"></i> Dashboard</a></li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-database"></i> <span>Almacén</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?php echo base_url();?>almacen/bodegas"><i class="fa fa-circle-o"></i> Bodegas</a></li>
                            <li><a href="<?php echo base_url();?>almacen/traslados"><i class="fa fa-circle-o"></i> Traslados</a></li>
                            <li><a href="<?php echo base_url();?>almacen/devoluciones"><i class="fa fa-circle-o"></i> Devoluciones</a></li>
                            <li><a href="<?php echo base_url();?>almacen/productos"><i class="fa fa-circle-o"></i> Productos</a></li>
                            <li><a href="<?php echo base_url();?>almacen/categorias"><i class="fa fa-circle-o"></i> Categorias</a></li>
                            <li><a href="<?php echo base_url();?>almacen/calidades"><i class="fa fa-circle-o"></i> Calidades</a></li>
                            <li><a href="<?php echo base_url();?>almacen/subcategorias"><i class="fa fa-circle-o"></i> Subcategorias</a></li>
                            <li><a href="<?php echo base_url();?>almacen/marcas"><i class="fa fa-circle-o"></i> Marcas</a></li>
                            <li><a href="<?php echo base_url();?>almacen/fabricantes"><i class="fa fa-circle-o"></i> Fabricantes</a></li>
                            <li><a href="<?php echo base_url();?>almacen/modelos"><i class="fa fa-circle-o"></i> Modelos</a></li>
                            <li><a href="<?php echo base_url();?>almacen/años"><i class="fa fa-circle-o"></i> Años</a></li>
                            <li><a href="<?php echo base_url();?>almacen/presentaciones"><i class="fa fa-circle-o"></i> Presentaciones</a></li>
                            <li><a href="<?php echo base_url();?>almacen/proveedores"><i class="fa fa-circle-o"></i> Proveedores</a></li>
                            <li><a href="<?php echo base_url();?>almacen/ajuste"><i class="fa fa-circle-o"></i> Ajuste de Inventario</a></li>

                        </ul>
                    </li>

                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-calculator"></i> <span>Caja</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?php echo base_url();?>caja/apertura_cierre"><i class="fa fa-circle-o"></i> Aperturas y Cierre</a></li>
                            <li><a href="<?php echo base_url();?>caja/gastos"><i class="fa fa-circle-o"></i> Gastos</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-cart-plus"></i> <span>Movimientos</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?php echo base_url();?>movimientos/compras"><i class="fa fa-circle-o"></i> Compras</a></li>
                            <li><a href="<?php echo base_url();?>movimientos/ventas"><i class="fa fa-circle-o"></i> Ventas</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-print"></i> <span>Reportes</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?php echo base_url();?>reportes/reportes_ventas"><i class="fa fa-circle-o"></i> Reportes de Ventas x Fecha</a></li>
                            <li><a href="<?php echo base_url();?>reportes/productos_vendidos"><i class="fa fa-circle-o"></i> Reporte de Productos Vendidos x Fecha</a></li>
                            <li><a href="<?php echo base_url();?>reportes/reportes_compras"><i class="fa fa-circle-o"></i> Reporte de Compras x Fecha</a></li>
                            <li><a href="<?php echo base_url();?>reportes/reportes_ganancias"><i class="fa fa-circle-o"></i> Reporte de Ganancias</a></li>
                            <li><a href="<?php echo base_url();?>reportes/reportes_inventario"><i class="fa fa-circle-o"></i> Reporte de Inventario con indicador de stock critico</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo base_url();?>backend/cuentas_cobrar"><i class="fa fa-money"></i> Cuentas por Cobrar</a></li>
                    <li><a href="<?php echo base_url();?>backend/cuentas_pagar"><i class="fa fa-money"></i> Cuentas por Pagar</a></li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-user"></i> <span>Administrador</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?php echo base_url();?>administrador/usuarios"><i class="fa fa-circle-o"></i> Usuarios</a></li>
                            <li><a href="<?php echo base_url();?>administrador/permisos"><i class="fa fa-circle-o"></i> Permisos</a></li>
                            <li><a href="<?php echo base_url();?>administrador/clave_permiso"><i class="fa fa-circle-o"></i> Clave de Permiso Especial</a></li>
                            <li><a href="<?php echo base_url();?>administrador/correos"><i class="fa fa-circle-o"></i> Correos</a></li>
                            <li><a href="<?php echo base_url();?>administrador/cupones"><i class="fa fa-circle-o"></i> Cupones</a></li>
                            <li><a href="<?php echo base_url();?>administrador/tarjetas"><i class="fa fa-circle-o"></i> Tarjetas</a></li>
                            <li><a href="<?php echo base_url();?>administrador/comprobantes"><i class="fa fa-circle-o"></i> Comprobantes</a></li>
                            <li><a href="<?php echo base_url();?>administrador/sucursales"><i class="fa fa-circle-o"></i> Sucursales</a></li>
                        </ul>
                    </li>
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

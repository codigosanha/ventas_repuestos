
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Devoluciones
        <small>Listado</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-solid">
            <div class="box-body">
                <input type="hidden" id="modulo" value="inventario/devoluciones">
                <div class="row">
                    <div class="col-md-12">
                      
                        <a href="<?php echo base_url();?>inventario/devoluciones/add" class="btn btn-primary btn-flat"><span class="fa fa-plus"></span> Agregar Devolución</a>
                      
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                        <table id="tableSimple" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>N° de Comprobante</th>
                                    <th>Desde que Sucursal</th>
                                    <th>Desde que Bodega</th>
                                    <th>Fecha</th>
                                    <th>Usuario</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($devoluciones)):?>
                                    <?php foreach($devoluciones as $devolucion):?>
                                        <?php $venta = get_record("ventas", "id='$devolucion->venta_id'")?>
                                        <tr>
                                            <td><?php echo $devolucion->id;?></td>
                                            <td><?php echo $venta->numero_comprobante;?></td>
                                            <td><?php echo get_record("sucursales","id=".$devolucion->sucursal_id)->nombre;?></td>
                                            <td><?php echo get_record("bodegas","id=".$devolucion->bodega_id)->nombre;?></td>
                                            <td><?php echo $devolucion->fecha;?></td>
                                            <td><?php echo get_record("usuarios","id=".$devolucion->usuario_id)->username;?></td>
                                            
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-view" data-toggle="modal" data-target="#modal-default" value="<?php echo $devolucion->id;?>">
                                                        <span class="fa fa-search"></span>
                                                    </button>
                                                   
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                <?php endif;?>
                            </tbody>
                        </table>
                       </div>
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Informacion de la devolucion</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

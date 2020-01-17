
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Traslados
        <small>Listado</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-solid">
            <div class="box-body">
                <input type="hidden" id="modulo" value="inventario/traslados">
                <div class="row">
                    <div class="col-md-12">
                        <?php if ($permisos->insert): ?>
                            <a href="<?php echo base_url();?>inventario/traslados/add" class="btn btn-primary btn-flat"><span class="fa fa-plus"></span> Agregar Traslado</a>
                        <?php endif ?>
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
                                    <th>Sucursal Envio</th>
                                    <th>Bodega Envio</th>
                                    <th>Sucursal Recibe</th>
                                    <th>Bodega Recibe</th>
                                    <th>Fecha</th>
                                    <th>Usuario</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($traslados)):?>
                                    <?php foreach($traslados as $traslado):?>
                                        <tr>
                                            <td><?php echo $traslado->id;?></td>
                                            <td><?php echo get_record("sucursales","id=".$traslado->sucursal_envio)->nombre;?></td>
                                            <td><?php echo get_record("bodegas","id=".$traslado->bodega_envio)->nombre;?></td>
                                            <td><?php echo get_record("sucursales","id=".$traslado->sucursal_recibe)->nombre;?></td>
                                            <td><?php echo get_record("bodegas","id=".$traslado->bodega_recibe)->nombre;?></td>
                                            <td><?php echo $traslado->fecha;?></td>
                                            <td><?php echo get_record("usuarios","id=".$traslado->usuario_id)->username;?></td>
                                            <td>
                                                <?php if ($traslado->estado): ?>
                                                    <span class="label label-success">Procesado</span>
                                                <?php else: ?>
                                                    <span class="label label-danger">Anulado</span>
                                                <?php endif ?>
                                                
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-view btn-sm" data-toggle="modal" data-target="#modal-default" value="<?php echo $traslado->id;?>">
                                                        <span class="fa fa-search"></span>
                                                    </button>
                                                    <?php if ($permisos->delete): ?>
                                                        <?php if ($traslado->estado): ?>
                                                            <a href="<?php echo base_url()?>inventario/traslados/deshabilitar/<?php echo $traslado->id;?>" class="btn btn-danger btn-remove btn-sm"><span class="fa fa-times"></span></a>
                                                        <?php endif ?>
                                                    <?php endif ?> 
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
  <div class="modal-dialog" style="width: 310px !important;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Información del Traslado</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary btn-print">Imprimir</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

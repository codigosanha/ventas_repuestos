
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Bodegas
        <small>Listado</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-solid">
            <div class="box-body">
                <input type="hidden" id="modulo" value="almacen/bodegas">
                <div class="row">
                    <div class="col-md-12">
                      
                        <a href="<?php echo base_url();?>almacen/bodegas/add" class="btn btn-primary btn-flat"><span class="fa fa-plus"></span> Agregar Bodega</a>
                      
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
                                    <th>Bodega</th>
                                    <?php if (!$this->session->userdata("sucursal")): ?>
                                        <th>Sucursal</th>
                                    <?php endif ?>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($bodegas)):?>
                                    <?php foreach($bodegas as $bodega):?>
                                        <tr>
                                            <td><?php echo $bodega->id;?></td>
                                            <td><?php echo get_record("bodegas","id=".$bodega->bodega_id)->nombre;?></td>
                                            <?php if (!$this->session->userdata("sucursal")): ?>
                                                <td><?php echo get_record("sucursales","id=".$bodega->sucursal_id)->nombre;?></td>
                                            <?php endif ?>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-view" data-toggle="modal" data-target="#modal-default" value="<?php echo $bodega->id;?>">
                                                        <span class="fa fa-search"></span>
                                                    </button>
                                                    <?php if ($this->session->userdata("total_access")): ?>
                                                        <a href="<?php echo base_url();?>almacen/bodegas/delete/<?php echo $bodega->id;?>" class="btn btn-danger btn-remove"><span class="fa fa-remove"></span></a>
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
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Informacion de la Bodega</h4>
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

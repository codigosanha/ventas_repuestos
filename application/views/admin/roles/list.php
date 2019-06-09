
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Roles
        <small>Listado</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-solid">
            <div class="box-body">
                <input type="hidden" id="modulo" value="administrador/roles">
                <div class="row">
                    <div class="col-md-12">
                      
                        <a href="<?php echo base_url();?>administrador/roles/add" class="btn btn-primary btn-flat"><span class="fa fa-plus"></span> Agregar Rol</a>
                      
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
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
                                    <th>Acceso Total</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($roles)):?>
                                    <?php foreach($roles as $rol):?>
                                        <tr>
                                            <td><?php echo $rol->id;?></td>
                                            <td><?php echo $rol->nombre;?></td>
                                            <td><?php echo $rol->descripcion;?></td>
                                            <td>
                                                <?php if ($rol->total_access): ?>
                                                    <span class="label label-success"><i class="fa fa-check"></i></span>
                                                <?php else: ?>
                                                    <span class="label label-danger"><i class="fa fa-times"></i></span>
                                                <?php endif ?>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-view" data-toggle="modal" data-target="#modal-default" value="<?php echo $rol->id;?>">
                                                        <span class="fa fa-search"></span>
                                                    </button>
                                                    
                                                    <a href="<?php echo base_url()?>administrador/roles/edit/<?php echo $rol->id;?>" class="btn btn-warning"><span class="fa fa-pencil"></span></a>
                                                    <a href="<?php echo base_url();?>administrador/roles/delete/<?php echo $rol->id;?>" class="btn btn-danger btn-remove"><span class="fa fa-remove"></span></a>
                                                  
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
        <h4 class="modal-title">Informacion de la Calidad</h4>
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

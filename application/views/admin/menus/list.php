
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Menús
        <small>Listado</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-solid">
            <div class="box-body">
                <input type="hidden" id="modulo" value="administrador/menus">
                <div class="row">
                    <div class="col-md-12">
                        <?php if ($permisos->insert): ?>
                            <a href="<?php echo base_url();?>administrador/menus/add" class="btn btn-primary btn-flat"><span class="fa fa-plus"></span> Agregar Menú</a>
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
                                    <th>Nombre</th>
                                    <th>URL</th>
                                    <th>Icono</th>
                                    <th>Menú Padre</th>
                                    <th>Orden</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($menus)):?>
                                    <?php foreach($menus as $menu):?>
                                        <tr>
                                            <td><?php echo $menu->id;?></td>
                                            <td><?php echo $menu->nombre;?></td>
                                            <td><?php echo $menu->url;?></td>
                                            <td><?php echo $menu->icono;?></td>
                                            <td><?php echo $menu->parent ? get_record("menus","id=$menu->parent")->nombre : '';?></td>
                                            <td><?php echo $menu->orden;?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-view btn-sm" data-toggle="modal" data-target="#modal-default" value="<?php echo $menu->id;?>">
                                                        <span class="fa fa-search"></span>
                                                    </button>
                                                    <?php if ($permisos->update): ?>
                                                        <a href="<?php echo base_url()?>administrador/menus/edit/<?php echo $menu->id;?>" class="btn btn-warning btn-sm"><span class="fa fa-pencil"></span></a>
                                                    <?php endif ?>
                                                    <?php if ($permisos->delete): ?>
                                                        <a href="<?php echo base_url();?>administrador/menus/delete/<?php echo $menu->id;?>" class="btn btn-danger btn-remove btn-sm"><span class="fa fa-remove"></span></a>
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
        <h4 class="modal-title">Informacion de la Menú</h4>
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

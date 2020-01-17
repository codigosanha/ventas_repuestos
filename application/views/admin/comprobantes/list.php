
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Comprobantes
        <small>Listado</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-solid">
            <div class="box-body">
                <input type="hidden" id="modulo" value="administrador/comprobantes">
                <div class="row">
                    <div class="col-md-12">
                        <?php if ($permisos->insert): ?>
                            <a href="<?php echo base_url();?>administrador/comprobantes/add" class="btn btn-primary btn-flat"><span class="fa fa-plus"></span> Agregar Comprobante</a>
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
                                    <th>Comprobante</th>
                                    <?php if (!$this->session->userdata("sucursal")): ?>
                                        <th>Sucursal</th>
                                    <?php endif ?>
                                    <th>Serie</th>
                                    <th>Numero Inicial</th>
                                    <th>Limite</th>
                                    <th>Disponibilidad</th>
                                    <th>Fecha Aprobacion SAT</th>
                                    <th>Fecha Vencimiento SAT</th>
                                    <th>Dias de Vencimiento</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($comprobantes)):?>
                                    <?php foreach($comprobantes as $c):?>
                                        <tr>
                                            <td><?php echo $c->id;?></td>
                                            <td><?php echo get_record("comprobantes","id=".$c->comprobante_id)->nombre;?></td>
                                            <?php if (!$this->session->userdata("sucursal")): ?>
                                                <td><?php echo get_record("sucursales","id=".$c->sucursal_id)->nombre;?></td>
                                            <?php endif ?>
                                            <td><?php echo $c->serie;?></td>
                                            <td><?php echo $c->numero_inicial;?></td>
                                            <td><?php echo $c->limite;?></td>
                                            <td><?php echo $c->limite-$c->realizados;?></td>
                                            <td><?php echo $c->fecha_aprobacion_sat;?></td>
                                            <td><?php echo $c->fecha_vencimiento_sat;?></td>
                                            <td><?php echo $c->dias_vencimiento;?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-view btn-sm" data-toggle="modal" data-target="#modal-default" value="<?php echo $c->id;?>">
                                                        <span class="fa fa-search"></span>
                                                    </button>
                                                    <?php if ($permisos->update): ?>
                                                        <a href="<?php echo base_url()?>administrador/comprobantes/edit/<?php echo $c->id;?>" class="btn btn-warning btn-sm"><span class="fa fa-pencil"></span></a>
                                                    <?php endif ?>
                                                    <?php if ($this->session->userdata("total_access")): ?>
                                                        <?php if ($c->estado): ?>
                                                            <a href="<?php echo base_url();?>administrador/comprobantes/deshabilitar/<?php echo $c->id;?>" class="btn btn-danger btn-remove btn-sm"><span class="fa fa-remove"></span></a>
                                                        <?php else: ?>
                                                            <a href="<?php echo base_url();?>administrador/comprobantes/habilitar/<?php echo $c->id;?>" class="btn btn-success btn-habilitar btn-sm"><span class="fa fa-check"></span></a>
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
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Informacion del Comprobante</h4>
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

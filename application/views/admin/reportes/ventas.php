
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Reportes
        <small>Ventas</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-solid">
            <div class="box-body">
                <input type="hidden" id="modulo" value="reportes/ventas">

                <div class="row">
                    <form action="<?php echo current_url();?>" method="POST" class="form-horizontal">
                        <div class="form-group">
                            <label for="" class="col-md-1 control-label">Desde:</label>
                            <div class="col-md-3">
                                <input type="date" class="form-control" name="fechainicio" value="<?php echo !empty($fechainicio) ? $fechainicio:date("Y-m-d");?>">
                            </div>
                            <label for="" class="col-md-1 control-label">Hasta:</label>
                            <div class="col-md-3">
                                <input type="date" class="form-control" name="fechafin" value="<?php  echo !empty($fechafin) ? $fechafin:date("Y-m-d");?>">
                            </div>
                            <div class="col-md-4">
                                <input type="submit" name="buscar" value="Buscar" class="btn btn-primary">
                                <a href="<?php echo base_url(); ?>reportes/ventas" class="btn btn-danger">Restablecer</a>
                            </div>
                        </div>
                    </form>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tableSimple" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre Cliente</th>
                                    <th>Tipo Comprobante</th>
                                    <th>Numero del Comprobante</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Sucursal</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($ventas)): ?>
                                    <?php foreach($ventas as $venta):?>
                                            
                                            <tr>
                                                <td><?php echo $venta->id;?></td>
                                                <td><?php echo get_record("clientes","id=".$venta->cliente_id)->nombres;?></td>
                                                <td><?php echo get_record("comprobantes","id=".$venta->comprobante_id)->nombre;?></td>
                                                <?php 
                                                $caja = get_record("caja","id=".$venta->caja_id);
                                                $comprobante = get_record("comprobantes","id=".$venta->comprobante_id);?>
                                                <td><?php echo get_record("comprobante_sucursal","comprobante_id='$venta->comprobante_id' and sucursal_id='$caja->sucursal_id'")->serie."-".$venta->numero_comprobante;?></td>
                                                <td><?php echo $venta->fecha;?></td>
                                                <td><?php echo $venta->total;?></td>
                                                <td>
                                                    <?php if ($venta->estado == "1") {
                                                        echo '<span class="label label-success">Procesada</span>';
                                                    } else {
                                                        echo '<span class="label label-danger">Anulado</span>';
                                                    } ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        
                                                        echo get_record("sucursales","id=".$caja->sucursal_id)->nombre;

                                                     ?>

                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-info btn-info-venta" value="<?php echo $venta->id;?>" data-toggle="modal" data-target="#modal-venta"><span class="fa fa-search"></span></button>
                                                    
                                                        
                                                    <?php if ($venta->estado): ?>
                                                        <?php if ($comprobante->permitir_anular): ?>
                                                            <a href="<?php echo base_url();?>movimientos/ventas/anular/<?php echo $venta->id;?>" class="btn btn-danger btn-anular-venta"><span class="fa fa-remove"></span></a>
                                                        <?php endif ?>
                                                    <?php endif ?>
                                                    
                                                        
                                                    
                                                        
                                                    
                                                </td>
                                            </tr>
                                                
                                        
                                        
                                      
                                    <?php endforeach;?>
                                <?php endif ?>
                            </tbody>
                        </table>
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

<div class="modal fade" id="modal-venta">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Informacion de la venta</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary btn-print"><span class="fa fa-print"> </span>Imprimir</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

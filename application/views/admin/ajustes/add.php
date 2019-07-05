

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

        <h1>

        Ajustes de Inventario

        <small>Nuevo</small>

        </h1>

    </section>

    <!-- Main content -->

    <section class="content">
        <!-- Default box -->
        <div class="box box-solid">
            <div class="box-body">
                <form action="<?php echo base_url();?>inventario/ajuste/store" method="POST"> 
                <div class="row">
                    <?php if ($this->session->userdata("sucursal")): ?>
                        <input type="hidden" name="sucursal_id" value="<?php echo $this->session->userdata("sucursal");?>" id="sucursal">
                    <?php else: ?>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Sucursal:</span>
                                    <select name="sucursal_id" id="sucursal" class="form-control">
                                        <option value="">Seleccione...</option>
                                        <?php foreach ($sucursales as $sucursal): ?>
                                            <option value="<?php echo $sucursal->id;?>"><?php echo $sucursal->nombre;?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                    <div class="col-md-4">
                        <?php if ($this->session->userdata("sucursal")): ?>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">bodega:</span>
                                    <select name="bodega_id" id="bodega" class="form-control">
                                        <option value="">Seleccione...</option>
                                        <?php foreach ($bodegas as $b): ?>
                                            <option value="<?php echo $b->bodega_id;?>"><?php echo get_record("bodegas","id=".$b->bodega_id)->nombre;?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">bodega:</span>
                                    <select name="bodega_id" id="bodega" class="form-control">
                                        <option value="">Seleccione...</option>
                                    </select>
                                </div>
                            </div>
                        <?php endif ?>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <button type="button" class="btn btn-primary btn-flat" id="btn-ver-productos"><span class="fa fa-eye"></span> Ver Productos</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <table  class="table table-bordered table-hover" id="tbInventario">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Stock BD</th>
                                    <th>Stock Fisico</th>
                                    <th>Diferencia de Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>

                        </table>

                        <button type="submit" class="btn btn-success btn-flat" id="btn-inventario" disabled="disabled">

                            <span class="fa fa-save"></span>

                            Guardar

                        </button>

                        <a href="<?php echo base_url();?>inventario/ajuste" class="btn btn-danger">Volver</a>
                    </div>

                </div>
                </form>
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

        <h4 class="modal-title">Informacion de la Categoria</h4>

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



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Traslados
        <small>Nuevo</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-3">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Establecer Sucursales - Bodegas</h3>
                    </div>
                    <form action="#" method="POST" id="form-consultar-productos-sb-envio">
                        <div class="box-body">
                            <?php if (!$this->session->userdata("sucursal")): ?>
                                <div class="form-group">
                                    <label for="">Sucursal de Envio</label>
                                    <select name="sucursal_envio" id="sucursal_envio" class="form-control" required="required">
                                        <option value="">Seleccione...</option>
                                        <?php foreach ($sucursales as $sucursal): ?>
                                            <option value="<?php echo $sucursal->id;?>"><?php echo $sucursal->nombre;?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            <?php else: ?>
                                <input type="hidden" name="sucursal_envio" id="sucursal_envio" value="<?php echo $this->session->userdata("sucursal");?>">
                            <?php endif ?>
                            <div class="form-group">
                                <label for="">Bodega de Envio</label>
                                <select name="bodega_envio" id="bodega_envio" class="form-control" required="required">
                                    <option value="">Seleccione...</option>
                                    <?php foreach ($bodegas as $b): ?>
                                        <option value="<?php echo $b->bodega_id;?>"><?php echo get_record("bodegas","id=".$b->bodega_id)->nombre;?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Sucursal Recibe</label>
                                <select name="sucursal_recibe" id="sucursal_recibe" class="form-control" required="required">
                                    <option value="">Seleccione...</option>
                                    <?php foreach ($sucursales as $sucursal): ?>
                                        <option value="<?php echo $sucursal->id;?>"><?php echo $sucursal->nombre;?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Bodega Recibe</label>
                                <select name="bodega_recibe" id="bodega_recibe" class="form-control" required="required">
                                    <option value="">Seleccione...</option>
                                    <?php foreach ($bodegas as $bodega): ?>
                                        <option value="<?php echo $bodega->id;?>"><?php echo $bodega->nombre;?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Mostrar Productos</button>
                            </div>

                        </div>
                    </form>
                    <div id="content-productos-nuevos" style="display: none;">
                    </div>
                    <div id="content-productos-existentes" style="display: none;">
                    </div>
                    <div id="infoProducto"></div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Productos de la sucursal y bodega de envio</h3>
                    </div>
                    <div class="box-body">
                        
                        <form action="<?php echo base_url() ?>inventario/traslados/store" method="POST" id="form-save-traslado">
                            <div class="form-group text-right" id="buttons" style="display: none;">
                                <button type="button" id="check-all-productos-traslado" class="btn btn-primary">Marcar todos</button>
                                <button type="submit" class="btn btn-success btn-flat">
                                    <span class="fa fa-save"></span> 
                                    Guardar
                                </button>
                                <a href="<?php echo base_url();?>inventario/traslados" class="btn btn-danger btn-flat">Volver</a>
                            </div>
                        </form>
                        

                        <p class="text-center text-muted">Marque e introduzca la cantidad del producto a trasladar
                        
                        <input type="hidden" id="id_sucursal_envio" name="id_sucursal_envio">
                        <input type="hidden" id="id_bodega_envio" name="id_bodega_envio">
                        <input type="hidden" id="status-check-all-productos-traslado"  value="0">
                        <input type="hidden" id="productos_existentes"  >
                        <input type="hidden" id="productos_no_existentes"  >
                        <input type="hidden" id="bsp_ids"  >
                        <input type="hidden" id="stocks"  >
                        <table class="table table-bordered" id="tbTraslados">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Codigo Barra</th>
                                    <th>Nombre</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

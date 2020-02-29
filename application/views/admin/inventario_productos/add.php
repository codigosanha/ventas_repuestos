
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Inventariar Productos
        <small>Nuevo</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-solid">
            <div class="box-body">
                <form action="<?php echo base_url();?>inventario/productos/store" method="POST">
                <div class="row">
                    <?php if($this->session->flashdata("error")):?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <p><i class="icon fa fa-ban"></i><?php echo $this->session->flashdata("error"); ?></p>
                            
                         </div>
                    <?php endif;?>
                    <div class="col-md-8">
                        
                        <?php if ($this->session->userdata("sucursal")): ?>
                            <input type="hidden" name="sucursal_id" value="<?php echo $this->session->userdata("sucursal");?>" id="sucursal">
                        <?php else: ?>
                            <div class="form-group">
                                <label for="sucursal_id">Sucursal:</label>
                                <select name="sucursal_id" id="sucursal" class="form-control">
                                    <option value="">Seleccione...</option>
                                    <?php foreach ($sucursales as $sucursal): ?>
                                        <option value="<?php echo $sucursal->id;?>"><?php echo $sucursal->nombre;?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        <?php endif ?>
                        <?php if ($this->session->userdata("sucursal")): ?>
                            <div class="form-group">
                                <label for="bodega_id">Bodega:</label>
                                <select name="bodega_id" id="bodega" class="form-control">
                                    <option value="">Seleccione...</option>
                                    <?php foreach ($bodegas as $b): ?>
                                        <option value="<?php echo $b->bodega_id;?>"><?php echo get_record("bodegas","id=".$b->bodega_id)->nombre;?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        <?php else: ?>
                            <div class="form-group">
                                <label for="bodega_id">Bodega:</label>
                                <select name="bodega_id" id="bodega" class="form-control">
                                    <option value="">Seleccione...</option>
                                </select>
                            </div>
                        <?php endif ?>
                        <p class="text-center">Seleccione los nuevos productos a inventariar</p>
                        <table id="tableSimple" class="table table-bordered tbProductos">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Nombre</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($productos)): ?>
                                    <?php foreach ($productos as $producto): ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="checkProducto" id="<?php echo "p".$producto->id;?>" value="<?php echo $producto->id?>" disabled="disabled" class="checkProducto">
                                            </td>
                                            <td><?php echo $producto->nombre;?></td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </tbody>
                        </table>
                        <div id="productos-seleccionados">
                            
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-flat" id="btn-guardar">Guardar</button>
                            <a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>" class="btn btn-danger btn-flat">Volver</a>
                            <button type="button" class="btn btn-primary btn-check-all-products" disabled="disabled">Marcar todos</button>
                        </div>
                            
                    </div>
                    <div class="col-md-4">
                        <p><strong>Productos Agregados</strong></p>
                        <p class="text-muted">Los productos se visualizaran luego de seleccionar una bodega</p>
                        <table class="table table-bordered" id="tbProductosExistentes">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
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


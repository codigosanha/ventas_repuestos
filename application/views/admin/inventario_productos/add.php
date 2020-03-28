
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
                        <table id="tbProductosInventario" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Codigo de Barras</th>
                                    <th>Nombre</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>

                        <div id="productos_registrados">
                            
                        </div>
                        <div id="productos_nuevos">
                            
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-success btn-flat" id="btn-guardar-inventario">Guardar</button>
                            <a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>" class="btn btn-danger btn-flat">Volver</a>
                            <button type="button" class="btn btn-primary btn-check-all-products" disabled="disabled">Marcar productos aún no inventariados</button>
                        </div>
                            
                    </div>
                    <div class="col-md-4">
                        <p>
                            <b>NOTA:</b> <br>
                            Los productos que ya estan inventariorados en la <b>sucursal - bodega</b> seleccionado, serán representados por un <input type="checkbox" disabled="disabled" checked="checked"></p>
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


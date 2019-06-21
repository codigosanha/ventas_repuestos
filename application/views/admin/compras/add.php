<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Compras
        <small>Nueva</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-solid">
            <div class="box-body">
                <form action="<?php echo base_url();?>movimientos/compras/store" method="POST">
                    <div class="row">
                    <!--Inicio Primer Columna-->
                        <div class="col-md-9">
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
                            <div class="form-group">
                                <label for="">Producto:</label>
                                <div class="input-group barcode">
                                    <div class="input-group-addon">
                                        <i class="fa fa-barcode"></i>
                                    </div>
                                    <input type="text" class="form-control" id="searchProductoCompra" placeholder="Buscar por codigo de barras o nombre del proucto">
                                </div>
                            
                            </div>
                        
                            <div class="form-group">
                                <table id="tbcompras" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Codigo</th>
                                            <th>Nombre</th>
                                            
                                            <th>Precios</th>
                                            <th>P. Compra</th>
                                            <th>Cantidad</th>
                                            <th>Importe</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                
                                    </tbody>
                                </table>
                            </div>
                      
                        </div>
                        <!--Inicio 2da Columna-->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="comprobante_id">Comprobante:</label>
                                <select name="comprobante_id" id="comprobante_id" class="form-control">
                                    <option value="">Seleccione...</option>
                                    <?php foreach ($comprobantes as $comprobante): ?>
                                        <option value="<?php echo $comprobante->id;?>"><?php echo $comprobante->nombre;?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Tipo de Pago:</label>
                                <select name="tipo_pago" id="tipo_pago" class="form-control" required>
                                    <option value="">Seleccione...</option>
                                    <option value="1">Contado</option>
                                    <option value="2">Credito</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Serie:</label>
                                <input type="text" class="form-control" id="serie" name="serie" placeholder="Escriba la Serie">
                            </div>
                            <div class="form-group">
                                <label for="">No. Comprobante:</label>
                                <input type="text" class="form-control"  name="numero_comprobante" placeholder="Escriba el No. de Factura">
                            </div>      
                            <div class="form-group">
                                <label for="">Fecha de Compra:</label>
                                <input type="date" class="form-control" name="fecha" value="<?php echo date("Y-m-d");?>" required>
                            </div>
                            <div class="form-group">
                                <select name="proveedor_id" id="proveedor_id" class="form-control">
                                    <option value="">Seleccione...</option>
                                    <?php foreach ($proveedores as $proveedor): ?>
                                        <option value="<?php echo $proveedor->id;?>"><?php echo $proveedor->nombre;?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Subtotal:</span>
                                    <input type="text" class="form-control" placeholder="0.00" name="subtotal" readonly="readonly">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Total:</span>
                                    <input type="text" class="form-control" placeholder="0.00" name="total" readonly="readonly">
                                </div>
                            </div>
                        </div>
                    <!--Fin de Primer Columna-->
                    </div>

                    <div class="row">
                        <div class="col-md-12 form-group">
                            <button type="submit" class="btn btn-success btn-flat" id="btn-guardar-compra"><i class="fa fa-save"></i> Guardar Compra</button>
                            <a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>" class="btn btn-danger btn-flat"><i class="fa fa-times"></i> Cancelar</a>
                        </div>
                    </div>
                </form>
                <!--end row1-->
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
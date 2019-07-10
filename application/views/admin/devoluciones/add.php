
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Devoluciones
        <small>Nuevo</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2">
                        <form action="<?php echo base_url();?>inventario/devoluciones/getVenta" method="POST" id="form-search-venta">
                            <?php if (!$this->session->userdata("sucursal")): ?>
                                <div class="form-group">
                                    <label for="">Sucursal</label>
                                    <select name="sucursal" id="sucursal-devolucion" class="form-control">
                                        <option value="">Seleccione...</option>
                                        <?php foreach ($sucursales as $sucursal): ?>
                                            <option value="<?php echo $sucursal->id;?>"><?php echo $sucursal->nombre;?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            <?php else: ?>
                                <input type="hidden" name="sucursal" value="<?php echo $this->session->userdata('sucursal');?>">
                            <?php endif ?>
                            
                            <div class="form-group">
                                <label for="">Bodega:</label>
                                <select name="bodega" id="bodega" class="form-control">
                                    <option value="">Seleccione...</option>
                                    <?php foreach ($bodegas as $bodega): ?>
                                        <option value="<?php echo $bodega->id;?>"><?php echo $bodega->nombre;?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Tipo de Comprobante:</label>
                                <select name="comprobante" id="comprobante" class="form-control">
                                    <option value="">Seleccione...</option>
                                    <?php foreach ($comprobantes as $comprobante): ?>
                                        <option value="<?php echo $comprobante->id;?>"><?php echo $comprobante->nombre;?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Numero del Comprobante</label>
                                <input type="text" class="form-control" id="numero_comprobante" placeholder="Numero del Comprobante" name="numero_comprobante">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success btn-block btn-flat" type="submit">Comprobar</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-5">
                        <p><strong>Información de la venta</strong></p>
                        <p><strong>Numero de Comprobante:</strong><span id="numero_comprobante">000000000A</span></p>
                        <p><strong>Fecha:</strong><span id="numero_comprobante">000000000A</span></p>
                        <p><strong>Bodega:</strong><span id="numero_comprobante">000000000A</span></p>
                        <p><strong>Sucursal:</strong><span id="numero_comprobante">000000000A</span></p>
                        <p><strong>Bodega:</strong><span id="numero_comprobante">000000000A</span></p>
                        <p><strong>PRODUCTOS</strong></p>
                        <table class="table table-bordered" id="tbVentaProductos">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th width="10%">Cantidad</th>
                                    <th width="10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-5">
                        <p>Productos a devolver</p>
                        <table class="table table-bordered" id="tbDevolucion">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad Max</th>
                                    <th width="10%">Cantidad</th>
                                    <th width="10%"></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
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

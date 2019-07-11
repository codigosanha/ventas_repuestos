
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
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">COMPROBACIÓN DE COMPROBANTE</div>
                            <div class="panel-body">
                                <form action="<?php echo base_url();?>inventario/devoluciones/getVenta" method="POST" id="form-search-venta">
                                    <div class="row">
                                        <?php if (!$this->session->userdata("sucursal")): ?>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="">Sucursal</label>
                                                    <select name="sucursal" id="sucursal-devolucion" class="form-control">
                                                        <option value="">Seleccione...</option>
                                                        <?php foreach ($sucursales as $sucursal): ?>
                                                            <option value="<?php echo $sucursal->id;?>"><?php echo $sucursal->nombre;?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <input type="hidden" name="sucursal" value="<?php echo $this->session->userdata('sucursal');?>">
                                        <?php endif ?>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Bodega:</label>
                                                <select name="bodega" id="bodega" class="form-control">
                                                    <option value="">Seleccione...</option>
                                                    <?php foreach ($bodegas as $bodega): ?>
                                                        <option value="<?php echo $bodega->id;?>"><?php echo $bodega->nombre;?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Tipo de Comprobante:</label>
                                                <select name="comprobante" id="comprobante" class="form-control">
                                                    <option value="">Seleccione...</option>
                                                    <?php foreach ($comprobantes as $comprobante): ?>
                                                        <option value="<?php echo $comprobante->id;?>"><?php echo $comprobante->nombre;?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Numero del Comprobante</label>
                                                <input type="text" class="form-control" id="numero_comprobante" placeholder="Numero del Comprobante" name="numero_comprobante">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <button class="btn btn-success btn-flat" type="submit">Comprobar</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="info-venta" style="display: none;">
                    
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                INFORMACIÓN DE LA VENTA
                            </div>
                            <div class="panel-heading">
                                <table class="table table-bordered" >
                                    <tbody>
                                        <tr>
                                            <th>Numero del Comprobante:</th>
                                            <td class="numero_comprobante"></td>
                                        </tr>
                                        <tr>
                                            <th>Fecha:</th>
                                            <td class="fecha"></td>
                                        </tr>
                                        <tr>
                                            <th>Bodega</th>
                                            <td class="bodega"></td>
                                        </tr>
                                        <tr>
                                            <th>Sucursal:</th>
                                            <td class="sucursal"></td>
                                        </tr>
                                        <tr>
                                            <th>Cliente:</th>
                                            <td class="cliente"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-bordered" id="tbVentaProductos">
                                    <caption class="text-center">DETALLE DE VENTA</caption>
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
                        </div>
                       
                    </div>
                    <div class="col-md-6">
                        <form action="<?php echo base_url();?>inventario/devoluciones/store" method="POST">
                        <h4>PRODUCTOS A DEVOLVER</h4>
                        <input type="hidden" name="idVenta" id="idVenta">
                        <input type="hidden" name="bodega_venta" id="bodega_venta">
                        <input type="hidden" name="sucursal_venta" id="sucursal_venta">
                        <div class="form-group">
                            <label for="">Bodega:</label>
                            <select name="bodega_devolucion" id="bodega_devolucion" class="form-control" required="required">
                                <option value="">Seleccione...</option>

                            </select>
                        </div>
                        <table class="table table-bordered" id="tbDevolucion">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad Max</th>
                                    <th>Cantidad</th>
                                    <th width="10%"></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <button type="submit" class="btn btn-success btn-flat" id="btnGuardarDevolucion">Guardar</button>
                        </form>
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

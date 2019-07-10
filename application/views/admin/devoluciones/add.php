
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
                            <div class="panel-heading">Compruebe Comprobante</div>
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
                <div class="row">
                    
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Información de la venta
                            </div>
                            <div class="panel-heading">
                                <dl class="dl-horizontal">
                                    <dt>Numero del Comprobante:</dt>
                                    <dd class="numero_comprobante">sdsdsdsdsd</dd>
                                    <dt>Fecha:</dt>
                                    <dd class="fecha">ssss</dd>
                                    
                                    <dt>Bodega:</dt>
                                    <dd class="bodega">ss</dd>
                                    <dt>Sucursal:</dt>
                                    <dd class="sucursal"></dd>
                                    <dt>Cliente:</dt>
                                    <dd class="cliente"></dd>
                                </dl>
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

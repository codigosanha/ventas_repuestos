<?php $predeterminado = ''; $iva = "0";?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Ventas
        <small>Nuevo</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-solid">
            <div class="box-body">
                <input type="hidden" id="modulo" value="movimientos/ventas">
                <form action="<?php echo base_url();?>movimientos/ventas/store" method="POST" id="form-add-venta">
                    <div class="row">

                        <div class="col-md-9">
                            <?php if ($this->session->userdata("sucursal")): ?>
                                <input type="hidden" name="sucursal_id" value="<?php echo $this->session->userdata("sucursal");?>" id="sucursal-venta">
                            <?php else: ?>
                                <div class="form-group">
                                    <label for="sucursal_id">Sucursal:</label>
                                    <select name="sucursal_id" id="sucursal-venta" class="form-control">
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
                                    <input type="text" class="form-control" id="searchProductoVenta" placeholder="Buscar por codigo de barras o nombre del proucto">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modal-productos" id="btn-buscarProductos">
                                            <span class="fa fa-search"></span>
                                            Buscar
                                        </button>
                                      </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <table id="tbventas" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Codigo</th>
                                            <th>Imagen</th>
                                            <th>Nombre</th>
                                            <th>Localicacion</th>
                                            <th>Precios</th>
                                            <th>P. Venta</th>
                                            <th>Stock Max.</th>
                                            <th>Cantidad</th>
                                            <th>Importe</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-flat" id="btn-save-venta">
                                    <i class="fa fa-save"></i> 
                                    Guardar
                                </button>
                                <a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>" class="btn btn-danger btn-flat"><i class="fa fa-times"></i> Cancelar</a>
                            </div>
                      
                        </div>
                        <!--Inicio 2da Columna-->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Comprobante:</label>
                                <select name="comprobante_id" id="comprobanteVenta" class="form-control" required>
                                    <option value="">Seleccione...</option>
                                    <?php if ($this->session->userdata("sucursal")): ?>
                                        <?php foreach ($comprobantes as $c): ?>
                                            <option value="<?php echo $c->comprobante_id;?>"><?php echo get_record("comprobantes","id='$c->comprobante_id'")->nombre;?></option>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </select>
                                <input type="hidden" id="iva" value="0">
                            </div>
                            <div class="form-group">
                                <label for="">Fecha:</label>
                                <input type="date" class="form-control" name="fecha" value="<?php echo date("Y-m-d");?>" required>
                            </div>  
                            <div class="form-group">
                                <label for="">Cliente:</label>
                                <div class="input-group">
                                    <input type="hidden" name="idcliente" id="idcliente">
                                    <input type="text" class="form-control" " id="cliente" required="required">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modal-default" ><span class="fa fa-search"></span> Buscar</button>
                                    </span>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label for="">Forma de Pago</label>
                                <select name="tipo_pago" id="tipo_pago" class="form-control" required="required">
                                    <option value="1">Efectivo</option>
                                    <option value="2">Tarjeta de Credito</option>
                                    <option value="3">Pago Mixto</option>
                                    <option value="4">Credito</option>
                                </select>
                            </div>
                            <div class="form-group" id="content-tarjeta" style="display: none;">
                                <label for="">Tarjeta</label>
                                <select name="tarjeta" id="tarjeta" class="form-control">
                                    <?php foreach ($tarjetas as $tarjeta): ?>
                                        <option value="<?php echo $tarjeta->id?>"><?php echo $tarjeta->nombre;?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group" id="content-monto-tarjeta" style="display: none;">
                                <label for="">Monto de tarjeta</label>
                                <input type="text" name="monto_tarjeta" id="monto_tarjeta" class="form-control">
                            </div>

                            <div class="form-group" id="content-monto-efectivo" style="display: none;">
                                <label for="">Monto de Efectivo</label>
                                <input type="text" name="monto_efectivo" id="monto_efectivo" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Monto Recibido:</label>
                                <input type="text" class="form-control" id="monto_recibido" name="monto_recibido">
                            </div> 
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Subtotal:</span>
                                    <input type="text" class="form-control" placeholder="0.00" name="subtotal" readonly="readonly">
                                </div>
                            </div> 
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">IVA:</span>
                                    <input type="text" class="form-control" placeholder="0.00" name="iva" readonly="readonly">
                                </div>
                            </div> 
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Descuento:</span>
                                    <input type="text" class="form-control" placeholder="descuento" name="descuento" id="descuento" value="0.00" readonly="readonly">
                                    <span class="input-group-btn">
                                        <button class="btn btn-danger" id="btn-descuento" type="button" data-toggle="modal" data-target="#modal-default2">
                                            Aplicar
                                        </button>
                                    </span>
                                </div>
                            </div> 
                            <div class="form group">
                                <div class="input-group">
                                    <span class="input-group-addon">Total:</span>
                                    <input type="text" class="form-control" placeholder="0.00" name="total" readonly="readonly">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Cambio:</span>
                                    <input type="text" class="form-control" placeholder="0.00" name="cambio" readonly="readonly">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Fin de Primer Columna-->
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

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Clientes</h4>
            </div>
            <div class="modal-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#tab_1" data-toggle="tab">Listado</a></li>
                      <li><a href="#tab_2" data-toggle="tab">Registrar</a></li>
                      
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <table id="example1" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Cedula</th>
                                        
                                        <th>Nombre</th>
                                        <th>Apellidos</th>
                                        <th>Opcion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($clientes)):?>
                                        <?php foreach($clientes as $cliente):?>
                                            <tr>
                                                <td><?php echo $cliente->cedula;?></td>
                                                <td><?php echo $cliente->nombres;?></td>
                                                <td><?php echo $cliente->apellidos;?></td>
                                                <?php $datacliente = $cliente->id."*".$cliente->nombres."*".$cliente->apellidos."*".$cliente->cedula."*".$cliente->telefono."*".$cliente->direccion."*".$cliente->nit;?>
                                                <td>
                                                    <button type="button" class="btn btn-success btn-check" value="<?php echo $datacliente;?>"><span class="fa fa-check"></span></button>
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                    <?php endif;?>
                                </tbody>
                            </table>

                        </div>
                      <!-- /.tab-pane -->
                      <div class="tab-pane" id="tab_2">
                        <form action="<?php echo base_url();?>movimientos/ventas/savecliente" method="POST" id="form-cliente">
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                                
                            </div>
                            <div class="form-group">
                                <label for="tipocliente">Tipo de Cliente</label>
                                <select name="tipocliente" id="tipocliente" class="form-control" required>
                                    <option value="">Seleccione...</option>
                                    <?php foreach ($tipoclientes as $tipocliente) :?>
                                        <option value="<?php echo $tipocliente->id;?>" ><?php echo $tipocliente->nombre ?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tipodocumento">Tipo de Documento</label>
                                <select name="tipodocumento" id="tipodocumento" class="form-control" required>
                                    <option value="">Seleccione...</option>
                                    <?php foreach ($tipodocumentos as $tipodocumento) :?>
                                        <option value="<?php echo $tipodocumento->id;?>" ><?php echo $tipodocumento->nombre ?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="numero">No. de Documento:</label>
                                <input type="text" class="form-control" id="numero" name="numero" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="telefono">Telefono:</label>
                                <input type="text" class="form-control" id="telefono" name="telefono">
                            </div>
                            <div class="form-group">
                                <label for="direccion">Direccion:</label>
                                <input type="text" class="form-control" id="direccion" name="direccion">
                            </div>
                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-flat">Guardar y Seleccionar</button>
                            </div>
                        </form>
                      </div>
                      <!-- /.tab-pane -->
                      
                    </div>
                    <!-- /.tab-content -->
                </div>


                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal fade" id="modal-default2">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Datos del Administrador</h4>
            </div>
            <div class="modal-body">

                <form action="#" method="POST" id="form-comprobar-password">
                    <div class="form-group">
                        <label for="">Introduzca Contraseña</label>
                        <input type="password" name="password" class="form-control" placeholder="Contraseña...">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Comprobar</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cerrar</button>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal fade" id="modal-venta">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Informacion de la Venta</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary btn-flat btn-print-venta"><span class="fa fa-print"></span> Imprimir</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modal-image">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
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
<div class="modal fade" id="modal-productos" style="z-index: 1400;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Busqueda de Productos</h4>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url();?>movimientos/ventas/searchProducto" method="POST" id="formSearchProducto">
            <div class="row">
                <div class="form-group col-md-3">
                    <select name="year" id="year" class="form-control">
                        <option value="">Seleccione Año...</option>
                        <?php foreach ($years as $year): ?>
                            <option value="<?php echo $year->id?>"><?php echo $year->year;?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <select name="marca" id="marca" class="form-control">
                        <option value="">Seleccione Marca...</option>
                        <?php foreach ($marcas as $marca): ?>
                            <option value="<?php echo $marca->id?>"><?php echo $marca->nombre;?></option>
                        <?php endforeach ?>

                    </select>
                </div>
                <div class="form-group col-md-3">
                    <select name="modelo" id="modelo" class="form-control">
                        <option value="">Seleccione Modelo...</option>
                        <?php foreach ($modelos as $modelo): ?>
                            <option value="<?php echo $modelo->id?>"><?php echo $modelo->nombre;?></option>
                        <?php endforeach ?>

                    </select>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-bordered" id="tbProductos">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Imagen</th>
                        <th>Producto</th>
                        <th>Localizacion</th>
                        <th>Categoria</th>
                        <th>Año</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Compatibilidades</th>
                        <th width="10">&nbsp;</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <ul class="pagination"></ul>
        </div>  
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
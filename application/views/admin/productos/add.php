
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Productos
        <small>Nuevo</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-solid">
            <div class="box-body">
                <div id="html-select-marcas" style="display: none;">
                   
                    <select name="marcas[]" class="marcas form-control" required="required">
                        <option value="">Seleccione</option>
                        <?php foreach ($marcas as $marca): ?>
                            <option value="<?php echo $marca->id; ?>"><?php echo $marca->nombre; ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div id="html-select-modelos" style="display: none;">
                    <select name="modelos[]" class="modelos form-control" required="required">
                        <option value="">Seleccione</option>
                    </select>
                </div>
                <div id="html-select-range" style="display: none;">
                    <select name="range_year[]" class="range_year form-control">
                        <option value="0">Año</option>
                        <option value="1">Rango de Años</option>
                        
                    </select>
                </div>
                <div id="html-years" style="display: none;">
                    
                        <input type="text" name="year_from[]" class="form-control year_from" value="1975">
                        <span style="display: none">-</span>

                        <input name="year_until[]" class="form-control year_until" style="display: none; " value="<?php echo date("Y"); ?>">
                    
                </div>
                <div id="html-button" style="display: none;">
                    <button type="button" class="btn btn-danger btn-remove-compatibilidad">
                        <span class="fa fa-times"></span>
                    </button>
                </div>
                
                <form action="<?php echo base_url();?>almacen/productos/store" method="POST" enctype="multipart/form-data">
                    <?php if($this->session->flashdata("error")):?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <p><i class="icon fa fa-ban"></i><?php echo $this->session->flashdata("error"); ?></p>
                            
                         </div>
                    <?php endif;?>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group <?php echo !empty(form_error('codigo_barras')) ? 'has-error':'';?>">
                                <label for="codigo_barras">Codigo de Barra:</label>
                                <input type="text" class="form-control" id="codigo_barras" name="codigo_barras" required value="<?php echo set_value('codigo_barras') ?:"00".($last_id + 1);?>">
                                <?php echo form_error("codigo_barras","<span class='help-block'>","</span>");?>
                            </div>
                                
                            <div class="form-group <?php echo !empty(form_error('nombre')) ? 'has-error':'';?>">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required value="<?php echo set_value('nombre');?>">
                                <?php echo form_error("nombre","<span class='help-block'>","</span>");?>
                            </div>

                            
                                
                                    
                        </div>
                        <div class="col-md-4">
                            <div class="form-group ">
                                <label for="descripcion">Descripcion:</label>
                                <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                            </div>
                            <div class="form-group">
                                <label for="calidad_id">Calidad:</label>
                                <select name="calidad_id" id="calidad_id" class="form-control" required>
                                    <option value="">Seleccione...</option>
                                    <?php foreach($calidades as $calidad):?>

                                        <option value="<?php echo $calidad->id?>"><?php echo $calidad->nombre;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Imagen del producto:</label>
                                <input type="file" name="imagen" class="form-control" accept=".jpg, .png, .gif">
                            </div>
                            <div class="form-group ">
                                <label for="stock_minimo">Stock Minimo:</label>
                                <input type="text" class="form-control" id="stock_minimo" name="stock_minimo">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="">Compatibilidad</label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="compatibilidad" value="1" checked>Definir marcas, modelos y años
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="compatibilidad" value="0"> Establecer como genérico
                                </label>
                            </div>
                        </div>
                    </div>
               
                    <div class="row">
                        <div class="col-md-12">
                            <div id="content-compatibilidad" style="background-color: #f5f5f5;padding: 10px 0px; margin-bottom:10px; ">
                            <div class="form-group text-center">
                                <button type="button" class="btn btn-primary btn-add-compatibilidad">
                                    <span class="fa fa-plus"></span>
                                    Agregar Compatibilidad
                                </button>
                            </div> 
                            <table class="table table-bordered" id="tbCompatibilidades">
                                <thead>
                                    <tr>
                                        <th>Marca</th>
                                        <th>Modelo</th>
                                        <th width="180px">Año/Rango de Año</th>
                                        <th width="250px;">Valor del Año</th>
                                        <th width="10px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Productos a Asociar</label>
                                <input type="text" id="productosA" class="form-control">
                            </div>
                            <table class="table table-bordered" id="tbAsociados">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th style="width:20%;">Cantidad</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Tipo de Precios </label>
                                <span class="text-muted">(Selecione un tipo de precio y agreguelo al producto)</span>
                                <div class="input-group">
                                    <select name="tipo_precios" id="tipo_precios" class="form-control">
                                        <option value="">Seleccione..</option>
                                        <?php foreach ($tipo_precios as $tp): ?>
                                            <option value='<?php echo json_encode($tp) ?>'><?php echo $tp->nombre ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-success btn-agregar-precio">Agregar</button>
                                    </span>
                                   
                                </div>
                                
                            </div>
                            <table class="table table-bordered" id="tbPrecios">
                                <thead>
                                    <tr>
                                        <th>Tipo Precio</th>
                                        <th style="width:20%;">P.Compra</th>
                                        <th style="width:20%;">P.Venta</th>
                                        <th style="width:5%;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                            <p class="text-muted">Nota: Si no se declara un tipo de precio para este producto, la información de este no se visualizara en la parte de compras y ventas</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-flat">Guardar</button>
                                <a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>" class="btn btn-danger btn-flat">Volver</a>
                            </div>
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

<div class="modal fade" id="modal-tipo-precios">
  	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
          		</button>
        		<h4 class="modal-title">Tipo de Precios</h4>
      		</div>
      		<div class="modal-body">
        		<p>Seleccione los tipo de precios que se va establecer para este producto.</p>
        		<table class="table table-bordered">
        			<tbody>
        				<thead>
        					<th></th>
        					<th>Nombre</th>
        					<th>Descripcion</th>
        				</thead>
        				<tbody>
        					<?php if (!empty($tipo_precios)): ?>
        						<?php foreach ($tipo_precios as $tp): ?>
        							<tr>
        								<td>
        									<input type="checkbox" name="checkPrecio" class="checkPrecio"> value="<?php echo $tp->id?>">
        								</td>
        								<td><?php echo $tp->nombre;?></td>
        								<td><?php echo $tp->descripcion;?></td>
        							</tr>
        						<?php endforeach ?>
        					<?php endif ?>
        				</tbody>
        			</tbody>
        		</table>
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
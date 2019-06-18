
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Productos
        <small>Editar</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-solid">
            <div class="box-body">
                
                <form action="<?php echo base_url();?>almacen/productos/update" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="idProducto" name="idProducto" value="<?php echo $producto->id;?>">
                    <?php if($this->session->flashdata("error")):?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <p><i class="icon fa fa-ban"></i><?php echo $this->session->flashdata("error"); ?></p>
                            
                         </div>
                    <?php endif;?>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="categoria_id">Categoria:</label>
                                <select name="categoria_id" id="categoria_id" class="form-control" required>
                                    <option value="">Seleccione...</option>
                                    <?php foreach($categorias as $categoria):?>

                                        <?php 
                                            $selected ='';
                                            if (set_value('categoria_id') && $categoria->id == set_value('categoria_id')){
                                                $selected = 'selected';
                                            }else{
                                                if ($categoria->id == $producto->categoria_id) {
                                                    $selected = 'selected';
                                                }
                                            }
                                        ?>

                                        <option value="<?php echo $categoria->id?>" <?php echo $selected;?>><?php echo $categoria->nombre;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="form-group <?php echo !empty(form_error('codigo_barras')) ? 'has-error':'';?>">
                                <label for="codigo_barras">Codigo de Barra:</label>
                                <input type="text" class="form-control" id="codigo_barras" name="codigo_barras" required value="<?php echo set_value('codigo_barras')?:$producto->codigo_barras;?>">
                                <?php echo form_error("codigo_barras","<span class='help-block'>","</span>");?>
                            </div>
                                
                            <div class="form-group <?php echo !empty(form_error('nombre')) ? 'has-error':'';?>">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required value="<?php echo set_value('nombre')?:$producto->nombre;?>">
                                <?php echo form_error("nombre","<span class='help-block'>","</span>");?>
                            </div>
                            <div class="form-group">
                                <label for="fabricante_id">Fabricante:</label>
                                <select name="fabricante_id" id="fabricante_id" class="form-control" required>
                                    <option value="">Seleccione...</option>
                                    <?php foreach($fabricantes as $fabricante):?>
                                        <?php 
                                            $selected ='';
                                            if (set_value('fabricante_id') && $fabricante->id == set_value('fabricante_id')){
                                                $selected = 'selected';
                                            }else{
                                                if ($fabricante->id == $producto->fabricante_id) {
                                                    $selected = 'selected';
                                                }
                                            }
                                        ?>
                                        <option value="<?php echo $fabricante->id?>" <?php echo $selected;?>><?php echo $fabricante->nombre;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="year_id">Año:</label>
                                <select name="year_id" id="year_id" class="form-control" required>
                                    <option value="">Seleccione...</option>
                                    <?php foreach($years as $year):?>
                                        <?php 
                                            $selected ='';
                                            if (set_value('year_id') && $year->id == set_value('year_id')){
                                                $selected = 'selected';
                                            }else{
                                                if ($year->id == $producto->year_id) {
                                                    $selected = 'selected';
                                                }
                                            }
                                        ?>
                                        <option value="<?php echo $year->id?>" <?php echo $selected;?>><?php echo $year->year;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        
                            <div class="form-group">
                                <label for="">Imagen del producto:</label>
                                <input type="file" name="imagen" required="required" class="form-control" accept=".jpg, .png, .gif">
                            </div>
                                
                            <div class="form-group ">
                                <label for="stock_minimo">Stock Minimo:</label>
                                <input type="text" class="form-control" id="stock_minimo" name="stock_minimo" required="required" value="<?php echo set_value('stock_minimo')?:$producto->stock_minimo;?>">
                            </div>
                        
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="subcategoria_id">Subcategoria:</label>
                                <select name="subcategoria_id" id="subcategoria_id" class="form-control" required>
                                    <option value="">Seleccione...</option>
                                    <?php foreach($subcategorias as $subcategoria):?>
                                        <?php 
                                            $selected ='';
                                            if (set_value('subcategoria_id') && $subcategoria->id == set_value('subcategoria_id')){
                                                $selected = 'selected';
                                            }else{
                                                if ($subcategoria->id == $producto->subcategoria_id) {
                                                    $selected = 'selected';
                                                }
                                            }
                                        ?>
                                        <option value="<?php echo $subcategoria->id?>" <?php echo $selected;?>><?php echo $subcategoria->nombre;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            
                            <div class="form-group ">
                                <label for="descripcion">Descripcion:</label>
                                <input type="text" class="form-control" id="descripcion" name="descripcion" required value="<?php echo set_value('descripcion')?:$producto->descripcion;?>">
                            </div>
                            <div class="form-group">
                                <label for="modelo_id">Modelo:</label>
                                <select name="modelo_id" id="modelo_id" class="form-control" required>
                                    <option value="">Seleccione...</option>
                                    <?php foreach($modelos as $modelo):?>
                                        <?php 
                                            $selected ='';
                                            if (set_value('modelo_id') && $modelo->id == set_value('modelo_id')){
                                                $selected = 'selected';
                                            }else{
                                                if ($modelo->id == $producto->modelo_id) {
                                                    $selected = 'selected';
                                                }
                                            }
                                        ?>
                                        <option value="<?php echo $modelo->id?>" <?php echo $selected;?>><?php echo $modelo->nombre;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="presentacion_id">Presentacion:</label>
                                <select name="presentacion_id" id="presentacion_id" class="form-control" required>
                                    <option value="">Seleccione...</option>
                                    <?php foreach($presentaciones as $presentacion):?>
                                        <?php 
                                            $selected ='';
                                            if (set_value('presentacion_id') && $presentacion->id == set_value('presentacion_id')){
                                                $selected = 'selected';
                                            }else{
                                                if ($presentacion->id == $producto->presentacion_id) {
                                                    $selected = 'selected';
                                                }
                                            }
                                        ?>
                                        <option value="<?php echo $presentacion->id?>" <?php echo $selected;?>><?php echo $presentacion->nombre;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="marca_id">Marca:</label>
                                <select name="marca_id" id="marca_id" class="form-control" required>
                                    <option value="">Seleccione...</option>
                                    <?php foreach($marcas as $marca):?>
                                        <?php 
                                            $selected ='';
                                            if (set_value('marca_id') && $marca->id == set_value('marca_id')){
                                                $selected = 'selected';
                                            }else{
                                                if ($marca->id == $producto->marca_id) {
                                                    $selected = 'selected';
                                                }
                                            }
                                        ?>
                                        <option value="<?php echo $marca->id?>" <?php echo $selected;?>><?php echo $marca->nombre;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="calidad_id">Calidad:</label>
                                <select name="calidad_id" id="calidad_id" class="form-control" required>
                                    <option value="">Seleccione...</option>
                                    <?php foreach($calidades as $calidad):?>
                                        <?php 
                                            $selected ='';
                                            if (set_value('calidad_id') && $calidad->id == set_value('calidad_id')){
                                                $selected = 'selected';
                                            }else{
                                                if ($calidad->id == $producto->calidad_id) {
                                                    $selected = 'selected';
                                                }
                                            }
                                        ?>
                                        <option value="<?php echo $calidad->id?>" <?php echo $selected;?>><?php echo $calidad->nombre;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>

                            <?php 
                                $selecteds = array();

                                if (!empty($compatibilidades)){
                                    foreach ($compatibilidades as $compatibilidad){
                                        $selecteds[] = $compatibilidad->modelo_id;
                                    }
                                }

                                $modelosFormatted = array();

                                if (!empty($modelos)) {
                                    foreach ($modelos as $m) {
                                        $modelosFormatted[$m->id] = $m->nombre; 
                                    }
                                }
                            ?>

                            <div class="form-group">
                                <label for="modelos">Compatibilidad:</label>
                                <?php echo form_multiselect('modelos[]', $modelosFormatted, $selecteds, 'id="modelos" class="form-control select2"');?>
                               
                            </div>
                            
                        </div>
                        <div class="col-md-4">
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
                                    <?php if (!empty($productos_asociados)): ?>
                                        <?php foreach ($productos_asociados as $pa): ?>
                                            <tr>
                                                <td><input type="hidden" name="idProductosA[]" value="<?php echo $pa->producto_asociado;?>"> <?php echo get_record("productos","id=".$pa->producto_asociado)->nombre;?></td>
                                                <td><input type="number" name="cantidadesA[]" class="form-control"  value="1" min="1" value="<?php echo $pa->cantidad;?>"></td>
                                                <td><button type="button" class="btn btn-danger btn-quitarAsociado"><i class="fa fa-times"></i></button></td>
                                            </tr>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </tbody>
                            </table>
                            
                            <div class="form-group">
                                <label for="">Tipo de Precios</label>
                                <input type="text" id="tipo_precios" class="form-control">
                            </div>
                            <table class="table table-bordered" id="tbPrecios">
                                <thead>
                                    <tr>
                                        <th>Tipo Precio</th>
                                        <th>P.Compra</th>
                                        <th>P.Venta</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($precios)): ?>
                                        <?php foreach ($precios as $precio): ?>
                                            <tr>
                                                <td><input type="hidden" name="idPrecios[]" value="<?php echo $precio->precio_id;?>"> <?php echo get_record("precios","id=".$precio->precio_id)->nombre;?></td>
                                                <td><input type="text" name="preciosC[]" class="form-control" value="<?php echo $precio->precio_compra;?>"></td>
                                                <td><input type="text" name="preciosV[]" class="form-control" value="<?php echo $precio->precio_venta;?>"></td>
                                                <td><button type="button" class="btn btn-danger btn-quitarAsociado"><i class="fa fa-times"></i></button></td>
                                            </tr>
                                        <?php endforeach ?>
                                    <?php endif ?>
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
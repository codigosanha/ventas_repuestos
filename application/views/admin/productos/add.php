
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
                
                <form action="<?php echo base_url();?>mantenimiento/productos/store" method="POST" enctype="multipart/form-data">
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

                                        <option value="<?php echo $categoria->id?>"><?php echo $categoria->nombre;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="form-group <?php echo !empty(form_error('codigo_barras')) ? 'has-error':'';?>">
                                <label for="codigo_barras">Codigo de Barra:</label>
                                <input type="text" class="form-control" id="codigo_barras" name="codigo_barras" required value="<?php echo set_value('codigo_barras');?>">
                                <?php echo form_error("codigo_barras","<span class='help-block'>","</span>");?>
                            </div>
                                
                            <div class="form-group <?php echo !empty(form_error('nombre')) ? 'has-error':'';?>">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required value="<?php echo set_value('nombre');?>">
                                <?php echo form_error("nombre","<span class='help-block'>","</span>");?>
                            </div>
                            <div class="form-group">
                                <label for="fabricante_id">Fabricante:</label>
                                <select name="fabricante_id" id="fabricante_id" class="form-control" required>
                                    <option value="">Seleccione...</option>
                                    <?php foreach($fabricantes as $fabricante):?>

                                        <option value="<?php echo $fabricante->id?>"><?php echo $fabricante->nombre;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="year_id">Año:</label>
                                <select name="year_id" id="year_id" class="form-control" required>
                                    <option value="">Seleccione...</option>
                                    <?php foreach($years as $year):?>

                                        <option value="<?php echo $year->id?>"><?php echo $year->year;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        
                            <div class="form-group">
                                <label for="">Imagen del producto:</label>
                                <input type="file" name="imagen" required="required" class="form-control" accept=".jpg, .png, .gif">
                            </div>
                                
                            <div class="form-group ">
                                <label for="stockminimo">Stock Minimo:</label>
                                <input type="text" class="form-control" id="stockminimo" name="stockminimo">
                            </div>
                        
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="subcategoria_id">Subcategoria:</label>
                                <select name="subcategoria_id" id="subcategoria_id" class="form-control" required>
                                    <option value="">Seleccione...</option>
                                </select>
                            </div>
                            
                            <div class="form-group ">
                                <label for="descripcion">Descripcion:</label>
                                <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                            </div>
                            <div class="form-group">
                                <label for="modelo_id">Modelo:</label>
                                <select name="modelo_id" id="modelo_id" class="form-control" required>
                                    <option value="">Seleccione...</option>
                                    <?php foreach($modelos as $modelo):?>

                                        <option value="<?php echo $modelo->id?>"><?php echo $modelo->nombre;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="presentacion">Presentacion:</label>
                                <select name="presentacion" id="presentacion" class="form-control" required>
                                    <option value="">Seleccione...</option>
                                    <?php foreach($presentaciones as $presentacion):?>
                                        <option value="<?php echo $presentacion->id?>"><?php echo $presentacion->nombre;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="marca">Marca:</label>
                                <select name="marca" id="marca" class="form-control" required>
                                    <option value="">Seleccione...</option>
                                    <?php foreach($marcas as $marca):?>
                                        <option value="<?php echo $marca->id?>"><?php echo $marca->nombre;?></option>
                                    <?php endforeach;?>
                                </select>
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
                            <div class="form-group">
                                <label for="modelos">Compatibilidad:</label>
                                <select name="modelos[]" id="modelos" class="form-control select2" multiple="multiple">
                                    <option value="">Seleccione...</option>
                                    <?php foreach($modelos as $modelo):?>

                                        <option value="<?php echo $modelo->id?>"><?php echo $modelo->nombre;?></option>
                                    <?php endforeach;?>
                                </select>
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
                                    
                                </tbody>
                            </table>

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

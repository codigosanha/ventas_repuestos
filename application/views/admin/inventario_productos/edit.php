
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Producto
        <small>Editar</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php if($this->session->flashdata("error")):?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <p><i class="icon fa fa-ban"></i><?php echo $this->session->flashdata("error"); ?></p>
                                
                             </div>
                        <?php endif;?>
                        <form action="<?php echo base_url();?>inventario/productos/update" method="POST">
                            <input type="hidden" value="<?php echo $producto->id;?>" name="idProducto">
                            <div class="form-group">
                                <label for="nombre">Sucursal:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo get_record('sucursales','id='.$producto->sucursal_id)->nombre;?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="descripcion">Bodega:</label>
                                <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?php echo get_record('bodegas','id='.$producto->bodega_id)->nombre;?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="descripcion">Producto:</label>
                                <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?php echo get_record('productos','id='.$producto->producto_id)->nombre;?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="descripcion">Localización:</label>
                                <input type="text" class="form-control" id="localizacion" name="localizacion" placeholder="Localizacion del producto"value="<?php echo $producto->localizacion;?>">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-flat">Guardar</button>
                                <a href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>" class="btn btn-danger btn-flat">Volver</a>
                            </div>
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

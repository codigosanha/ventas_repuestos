
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Modulos
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
                        <form action="<?php echo base_url();?>almacen/modelos/update" method="POST">
                            <input type="hidden" value="<?php echo $modelo->id;?>" name="idModulo">
                            <div class="form-group <?php echo form_error('nombre') == true ? 'has-error': '';?>">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo set_value('nombre')?:$modelo->nombre?>">
                                <?php echo form_error("nombre","<span class='help-block'>","</span>");?>
                            </div>
                            
                            <div class="form-group">
                                <label for="marca_id">Marca:</label>
                                <select name="marca_id" id="marca_id" class="form-control" required="required">
                                    <option value="">Seleccione</option>
                                    <?php foreach ($marcas as $marca): ?>
                                        <?php 
                                            $selected = "";
                                            if ($marca->id == $modelo->marca_id) {
                                                $selected = "selected";
                                            }
                                        ?>
                                        <option value="<?php echo $marca->id; ?>" <?php echo $selected ?>><?php echo $marca->nombre ?></option>
                                    <?php endforeach ?>
                                </select>
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

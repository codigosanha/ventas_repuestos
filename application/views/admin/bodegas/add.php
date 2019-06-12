
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Bodegas
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
                        <?php if($this->session->flashdata("error")):?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <p><i class="icon fa fa-ban"></i><?php echo $this->session->flashdata("error"); ?></p>
                                
                             </div>
                        <?php endif;?>
                        <form action="<?php echo base_url();?>almacen/bodegas/store" method="POST">
                            <div class="form-group">
                                <label for="bodega_id">Tipo de Bodega:</label>
                                <select name="bodega_id" id="bodega_id" class="form-control">
                                    <option value="">Seleccione...</option>
                                    <?php foreach ($bodegas as $bodega): ?>
                                        <option value="<?php echo $bodega->id;?>"><?php echo $bodega->nombre;?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <?php if ($this->session->userdata("sucursal")): ?>
                                <input type="hidden" name="sucursal_id" value="<?php echo $this->session->userdata("sucursal");?>">
                            <?php else: ?>
                                <div class="form-group">
                                    <label for="sucursal_id">Tipo de Bodega:</label>
                                    <select name="sucursal_id" id="sucursal_id" class="form-control">
                                        <option value="">Seleccione...</option>
                                        <?php foreach ($sucursales as $sucursal): ?>
                                            <option value="<?php echo $sucursal->id;?>"><?php echo $sucursal->nombre;?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            <?php endif ?>
                            
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

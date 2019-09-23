
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Traslados
        <small>Nuevo</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-solid">
            <div class="box-body">
                <?php if($this->session->flashdata("error")):?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <p><i class="icon fa fa-ban"></i><?php echo $this->session->flashdata("error"); ?></p>
                        
                     </div>
                <?php endif;?>
                <form action="<?php echo base_url();?>inventario/traslados/store" method="POST">
                    <div class="row">
                        <?php if (!$this->session->userdata("sucursal")): ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Sucursal de Envio</label>
                                    <select name="sucursal_envio" id="sucursal_envio" class="form-control">
                                        <option value="">Seleccione...</option>
                                        <?php foreach ($sucursales as $sucursal): ?>
                                            <option value="<?php echo $sucursal->id;?>"><?php echo $sucursal->nombre;?></option>
                                        <?php endforeach ?>
                                    </select>
                                    
                                </div>
                            </div>
                        <?php else: ?>
                            <input type="hidden" name="sucursal_envio" value="<?php echo $this->session->userdata("sucursal");?>">
                        <?php endif ?>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Bodega de Envio</label>
                                <select name="bodega_envio" id="bodega_envio" class="form-control">
                                    <option value="">Seleccione...</option>
                                    <?php foreach ($bodegas as $b): ?>
                                        <option value="<?php echo $b->bodega_id;?>"><?php echo get_record("bodegas","id=".$b->bodega_id)->nombre;?></option>
                                    <?php endforeach ?>
                                </select>
                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Sucursal Recibe</label>
                                <select name="sucursal_recibe" id="sucursal_recibe" class="form-control">
                                    <option value="">Seleccione...</option>
                                    <?php foreach ($sucursales as $sucursal): ?>
                                        <option value="<?php echo $sucursal->id;?>"><?php echo $sucursal->nombre;?></option>
                                    <?php endforeach ?>
                                </select>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Bodega Recibe</label>
                                <select name="bodega_recibe" id="bodega_recibe" class="form-control">
                                    <option value="">Seleccione...</option>
                                    <?php foreach ($bodegas as $bodega): ?>
                                        <option value="<?php echo $bodega->id;?>"><?php echo $bodega->nombre;?></option>
                                    <?php endforeach ?>
                                </select>
                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Producto:</label>
                                <div class="input-group barcode">
                                    <div class="input-group-addon">
                                        <i class="fa fa-barcode"></i>
                                    </div>
                                    <input type="text" class="form-control" id="searchProductoTraslado" placeholder="Buscar por codigo de barras o nombre del proucto">
                                </div>
                            
                            </div>
                            <div class="form-group">
                                <table class="table table-bordered" id="tbTraslado">
                                    <thead>
                                        <tr>
                                            <th>Codigo Barra</th>
                                            <th>Nombre</th>
                                            <th>Cantidad</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-flat" id="btn-guardar-traslado">
                                    <span class="fa fa-save"></span> 
                                    Guardar
                                </button>
                                <a href="<?php echo base_url();?>inventario/traslados" class="btn btn-danger btn-flat">Volver</a>
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

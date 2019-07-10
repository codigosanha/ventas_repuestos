
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
                    <div class="col-md-2">
                        <form action="<?php echo base_url();?>inventario/devoluciones/getVenta" method="POST" id="form-search-venta">
                            <?php if (!$this->session->userdata("sucursal")): ?>
                                <div class="form-group">
                                    <label for="">Sucursal</label>
                                    <select name="sucursal" id="sucursal-devolucion" class="form-control">
                                        <option value="">Seleccione...</option>
                                        <?php foreach ($sucursales as $sucursal): ?>
                                            <option value="<?php echo $sucursal->id;?>"><?php echo $sucursal->nombre;?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            <?php else: ?>
                                <input type="hidden" name="sucursal" value="<?php echo $this->session->userdata('sucursal');?>">
                            <?php endif ?>
                            
                            <div class="form-group">
                                <label for="">Bodega:</label>
                                <select name="bodega" id="bodega" class="form-control">
                                    <option value="">Seleccione...</option>
                                    <?php foreach ($bodegas as $bodega): ?>
                                        <option value="<?php echo $bodega->id;?>"><?php echo $bodega->nombre;?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Tipo de Comprobante:</label>
                                <select name="comprobante" id="comprobante" class="form-control">
                                    <option value="">Seleccione...</option>
                                    <?php foreach ($comprobantes as $comprobante): ?>
                                        <option value="<?php echo $comprobante->id;?>"><?php echo $comprobante->nombre;?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Numero del Comprobante</label>
                                <input type="text" class="form-control" id="numero_comprobante" placeholder="Numero del Comprobante" name="numero_comprobante">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success btn-block btn-flat" type="submit">Comprobar</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-5">
                        <p><strong>Información de la venta</strong></p>
                        <p><strong>Numero de Comprobante:</strong><span id="numero_comprobante">000000000A</span></p>
                        <p><strong>Fecha:</strong><span id="numero_comprobante">000000000A</span></p>
                        <p><strong>Bodega:</strong><span id="numero_comprobante">000000000A</span></p>
                        <p><strong>Sucursal:</strong><span id="numero_comprobante">000000000A</span></p>
                        <p><strong>Bodega:</strong><span id="numero_comprobante">000000000A</span></p>
                        <p><strong>PRODUCTOS</strong><span id="numero_comprobante">000000000A</span></p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <?php if($this->session->flashdata("error")):?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <p><i class="icon fa fa-ban"></i><?php echo $this->session->flashdata("error"); ?></p>
                                
                             </div>
                        <?php endif;?>
                        <form action="<?php echo base_url();?>almacen/calidades/store" method="POST">
                            <div class="form-group <?php echo form_error('nombre') == true ? 'has-error':''?>">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo set_value('nombre')?:''?>" required="required">
                                <?php echo form_error("nombre","<span class='help-block'>","</span>");?>
                            </div>
                            <div class="form-group">
                                <label for="descripcion">Descripcion:</label>
                                <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?php echo set_value('descripcion')?:''?>">
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

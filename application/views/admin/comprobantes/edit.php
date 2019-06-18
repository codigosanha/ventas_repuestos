
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Comprobantes
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
                        <form action="<?php echo base_url();?>administrador/comprobantes/update" method="POST">
                            <input type="hidden" name="idComprobante" value="<?php echo $comprobante->id;?>">
                            <div class="form-group">
                                <label for="comprobante_id">Tipo de Comprobante:</label>
                                <select name="comprobante_id" id="comprobante_id" class="form-control">
                                    <option value="">Seleccione...</option>
                                    <?php foreach ($comprobantes as $c): ?>
                                        <?php 
                                            $selected ='';
                                            
                                            if ($c->id == $comprobante->comprobante_id) {
                                                $selected = 'selected';
                                            }
                                            
                                        ?>
                                        <option value="<?php echo $c->id;?>" <?php echo $selected;?>><?php echo $c->nombre;?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <?php if ($this->session->userdata("sucursal")): ?>
                                <input type="hidden" name="sucursal_id" value="<?php echo $this->session->userdata("sucursal");?>">
                            <?php else: ?>
                                <div class="form-group">
                                    <label for="sucursal_id">Sucursal:</label>
                                    <select name="sucursal_id" id="sucursal_id" class="form-control">
                                        <option value="">Seleccione...</option>
                                        <?php foreach ($sucursales as $sucursal): ?>
                                            <?php 
                                                $selected ='';
                                                
                                                if ($sucursal->id == $comprobante->sucursal_id) {
                                                    $selected = 'selected';
                                                }
                                                
                                            ?>
                                            <option value="<?php echo $sucursal->id;?>" <?php echo $selected;?>><?php echo $sucursal->nombre;?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            <?php endif ?>
                            <div class="form-group">
                                <label for="serie">Serie:</label>
                                <input type="text" class="form-control" id="serie" name="serie" value="<?php echo $comprobante->serie;?>">
                            </div>
                            <div class="form-group">
                                <label for="numero_inicial">Numero Inicial:</label>
                                <input type="text" class="form-control" id="numero_inicial" name="numero_inicial" value="<?php echo $comprobante->numero_inicial;?>">
                            </div>

                            <div class="form-group">
                                <label for="limite">Limite:</label>
                                <input type="text" class="form-control" id="limite" name="limite" value="<?php echo $comprobante->limite;?>">
                            </div>
                            <div class="form-group">
                                <label for="fecha_aprobacion_sat">Fecha Aprobacion de SAT:</label>
                                <input type="date" class="form-control" id="fecha_aprobacion_sat" name="fecha_aprobacion_sat" value="<?php echo $comprobante->fecha_aprobacion_sat;?>">
                            </div>
                            <div class="form-group">
                                <label for="fecha_vencimiento_sat">Fecha Vencimiento SAT:</label>
                                <input type="date" class="form-control" id="fecha_vencimiento_sat" name="fecha_vencimiento_sat" value="<?php echo $comprobante->fecha_vencimiento_sat;?>">
                            </div>
                            <div class="form-group">
                                <label for="dias_vencimiento">Dias de Vencimiento:</label>
                                <input type="number" class="form-control" id="dias_vencimiento" name="dias_vencimiento" value="<?php echo $comprobante->dias_vencimiento;?>">
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

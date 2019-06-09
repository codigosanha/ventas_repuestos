
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Usuarios
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
                        <form action="<?php echo base_url();?>administrador/usuarios/update" method="POST">
                            <input type="hidden" name="idUsuario" value="<?php echo $usuario->id ?>">
                            <div class="form-group">
                                <label for="nombres">Nombres:</label>
                                <input type="text" id="nombres" name="nombres" class="form-control" value="<?php echo set_value('nombres') ?: $usuario->nombres;?>">
                            </div>
                            <div class="form-group">
                                <label for="apellidos">Apellidos:</label>
                                <input type="text" id="apellidos" name="apellidos" class="form-control" value="<?php echo set_value('apellidos') ?: $usuario->apellidos;?>">
                            </div>
                            <div class="form-group">
                                <label for="telefono">Telefono:</label>
                                <input type="text" id="telefono" name="telefono" class="form-control" value="<?php echo set_value('telefono') ?: $usuario->telefono;?>">
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="text" id="email" name="email" class="form-control" value="<?php echo set_value('email') ?: $usuario->email;?>">
                            </div>
                            <div class="form-group">
                                <label for="username">Usuario:</label>
                                <input type="text" id="username" name="username" class="form-control" value="<?php echo set_value('username') ?: $usuario->username;?>">
                            </div>
                           
                            <div class="form-group">
                                <label for="rol_id">Roles:</label>
                                <select name="rol_id" id="rol_id" class="form-control">
                                    <?php foreach($roles as $rol):?>
                                        <?php 
                                            $selected = '';
                                            if (set_value('sucursal_id') && set_value('sucursal_id') == $sucursal->id) {
                                               $selected = 'selected';
                                            } else {
                                                if ($usuario->rol_id == $rol->id) {
                                                    $selected = 'selected';
                                                }
                                            }
                                         ?>
                                        <option value="<?php echo $rol->id;?>" <?php echo $selected;?>><?php echo $rol->nombre;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="sucursal_id">Sucursales:</label>
                                <select name="sucursal_id" id="sucursal_id" class="form-control">
                                    <?php foreach($sucursales as $sucursal):?>
                                        <?php 
                                            $selected = '';
                                            if (set_value('sucursal_id') && set_value('sucursal_id') == $sucursal->id) {
                                               $selected = 'selected';
                                            } else {
                                                if ($usuario->sucursal_id == $sucursal->id) {
                                                    $selected = 'selected';
                                                }
                                            }
                                         ?>
                                        <option value="<?php echo $sucursal->id;?>" <?php echo $selected;?>><?php echo $sucursal->nombre;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-success" value="Guardar">
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

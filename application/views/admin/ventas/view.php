<div class="contenido-venta">
	<div class="form-group text-center">
		<label for="">Tienda Repuestos</label><br>
		<p>
		<img src="<?php echo base_url();?>img/cloud.png" height="64" width="64"> 
		</p>
		3a. Calle 1-06 Zona 1, 2do. Nivel Farmacia Batres Don Paco
		Santa Cruz del Quiche
	</div>
	<?php $caja = get_record("caja","id='$venta->caja_id'");?>
	<?php $comprobante_sucursal = get_record("comprobante_sucursal","comprobante_id='$venta->comprobante_id' and sucursal_id='$caja->sucursal_id'");?>
	<?php $comprobante = get_record("comprobantes","id=".$venta->comprobante_id);?>
	<div class="form-group text-center">
		<label for=""><?php echo $comprobante->nombre;?></label><br>
		<?php echo $comprobante_sucursal->serie ." - ".$venta->numero_comprobante;?>
	</div>
	<div class="form-group">
		<p><b>Estado: </b><?php if ($venta->estado == "1") {
                                                    echo '<span class="label label-success">Procesada</span>';
                                                }else{
                                                    echo '<span class="label label-danger">Anulado</span>';
                                                } ?>
                                            <br>

        <?php $cliente = get_record("clientes","id=".$venta->cliente_id);?>
		<b>Cliente: </b><?php echo $cliente->nombres;?><br>
		<b>No. Cedula: </b><?php echo $cliente->cedula;?><br>
		<b>Fecha: </b><?php echo $venta->fecha;?></p>
	</div>

	<div class="form-group">
		<table width="100%" cellpadding="10" cellspacing="0" border="0">
			<thead>
				<tr>
					<th>Cant.</th>
					<th>Producto</th>
					<th style="text-align: right;">Importe</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($detalles as $detalle):?>
				<tr>
					<td><?php echo $detalle->cantidad;?></td>
					<td><?php echo get_record("productos","id=".$detalle->producto_id)->nombre;?></td>
					<td style="text-align: right;"><?php echo $detalle->importe;?></td>
				</tr>
				<?php endforeach;?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2">Subtotal:</td>
					<td style="text-align: right;"><?php echo $venta->subtotal;?></td>
				</tr>
				<!--
				<tr>
					<td colspan="2">iva:</td>
					<td style="text-align: right;">?php echo $venta->iva;?></td>
				</tr>
			-->
				<tr>
					<td colspan="2">Descuento:</td>
					<td style="text-align: right;"><?php echo $venta->descuento;?></td>
				</tr>
				<tr>
					<th colspan="2">TOTAL:</th>
					<th style="text-align: right;"><?php echo $venta->total;?></th>
				</tr>
			</tfoot>
		</table>
	</div>
	<div class="form-group text-center">
        <p>
        	Gracias por tu preferencia!!! <br>
        	Recuerda visitarnos en:<br>
        	www.ventasrepuestos.com</i><br>
        	<i class="fa fa-facebook-square"> Ventas Repuestos</i></p>
    </div>
</div>
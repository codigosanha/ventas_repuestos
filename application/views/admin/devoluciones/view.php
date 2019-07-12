<?php $venta = get_record("ventas","id='$devolucion->venta_id'");?>
<p><strong>Venta:</strong> <?php echo $venta->numero_comprobante; ?></p>
<p><strong>Fecha:</strong> <?php echo $devolucion->fecha; ?></p>
<p><strong>Desde que Sucursal:</strong> <?php echo get_record("sucursales","id=".$devolucion->sucursal_id)->nombre; ?></p>
<p><strong>Desde que Bodega:</strong> <?php echo get_record("bodegas","id=".$devolucion->bodega_id)->nombre; ?></p>
<p><strong>Usuario:</strong> <?php echo get_record("usuarios","id=".$devolucion->usuario_id)->username; ?></p>
<p><strong>PRODUCTOS DEVUELTOS</strong></p>
<table class="table table-bordered">
	<thead>
		<tr>
			<th>Producto</th>
			<th>Cantidad</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($productos as $producto): ?>
			<tr>
				<td><?php echo get_record("productos","id=".$producto->producto_id)->nombre ?></td>
				<td><?php echo $producto->cantidad;?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
<div class="contenido">
<h4 class="text-center">TRASLADO DE PRODUCTOS</h4>
<p><strong>Sucursal Envio:</strong> <?php echo get_record("sucursales","id=".$traslado->sucursal_envio)->nombre; ?></p>
<p><strong>Bodega Envio:</strong> <?php echo get_record("bodegas","id=".$traslado->bodega_envio)->nombre; ?></p>
<p><strong>Sucursal Recibe:</strong> <?php echo get_record("sucursales","id=".$traslado->sucursal_recibe)->nombre; ?></p>
<p><strong>Bodega Recibe:</strong> <?php echo get_record("bodegas","id=".$traslado->bodega_recibe)->nombre; ?></p>
<p><strong>Fecha:</strong> <?php echo $traslado->fecha; ?></p>
<p><strong>Usuario:</strong> <?php echo get_record("usuarios","id=".$traslado->usuario_id)->username; ?></p>
<br>
<p class="text-center"><strong>Productos</strong></p>
<div class="form-group">
	<table width="100%" cellpadding="10" cellspacing="0" border="0">
		<thead>
			<tr>
				<th>Cant.</th>
				<th>Producto</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($productos as $p):?>
			<tr>
				<td><?php echo $p->cantidad;?></td>
				<td><?php echo get_record("productos","id=".$p->producto_id)->nombre;?></td>
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
</div>
</div>
<p><strong>Nombre:</strong> <?php echo $producto->codigo_barras;?></p>
<p><strong>Nombre:</strong> <?php echo $producto->nombre;?></p>
<p><strong>Descripcion:</strong> <?php echo $producto->descripcion;?></p>
<p><strong>Stock Minimo:</strong> <?php echo $producto->stock_minimo;?></p>
<p><strong>Calidad:</strong> <?php echo get_record("calidades","id=".$producto->calidad_id)->nombre;?></p>

<?php $compatibilidades = get_records("compatibilidades","producto_id='$producto->id'");?>
<?php if (!empty($compatibilidades) && $producto->compatibilidades): ?>
	<p class="text-center"><strong>Marcas, modelos y años compatibles</strong></p>
	<table class="table table-bordered">
		<thead>
			<tr>
				
				<th>Marca</th>
				<th>Modelo</th>
				<th>Año</th>
			</tr>
		</thead>
		<tbody>

		<?php foreach ($compatibilidades as $compatibilidad): ?>
			<tr>
				<td><?php echo get_record("marcas","id=".$compatibilidad->marca_id)->nombre;?></td>
				<td><?php echo get_record("modelos","id=".$compatibilidad->modelo_id)->nombre;?></td>
				<?php if ($compatibilidad->range_year): ?>
					<td><?php echo $compatibilidad->year_from." - ".$compatibilidad->year_until;?></td>
				<?php else: ?>
					<td><?php echo $compatibilidad->year_from;?></td>
				<?php endif ?>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	
<?php endif ?>
<?php $precios = get_records("producto_precio","producto_id='$producto->id'");?>
<?php if (!empty($precios)): ?>
	
	<table class="table table-bordered">
		<caption class="text-center"><strong>Tipo de Precios</strong></caption>
		<thead>
			<tr>
				
				<th>Nombre</th>
				<th>Precio Compra</th>
				<th>Precio Venta</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($precios as $precio): ?>
				<tr>
					<td><?php echo get_record("precios","id=".$precio->precio_id)->nombre;?></td>
					<td><?php echo $precio->precio_compra;?></td>
					<td><?php echo $precio->precio_venta;?></td>
				</tr>
			<?php endforeach ?>
			
		</tbody>
	</table>
<?php endif ?>
<?php $productosA = get_records("productos_asociados","producto_original='$producto->id'");?>
<?php if (!empty($productosA)): ?>
	
	<table class="table table-bordered">
		<caption class="text-center"><strong>Productos Asociados</strong></caption>
		<thead>
			<tr>
				
				<th>Nombre</th>
				<th>Catnidad</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($productosA as $productoA): ?>
				<tr>
					
					<td><?php echo $productoA->nombre;?></td>
					<td><?php echo $productoA->cantidad;?></td>
				</tr>
			<?php endforeach ?>
			
		</tbody>
	</table>
<?php endif ?>
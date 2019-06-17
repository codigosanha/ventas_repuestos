
<p><strong>Nombre:</strong> <?php echo $producto->nombre;?></p>
<p><strong>Descripcion:</strong> <?php echo $producto->descripcion;?></p>
<p><strong>Stock Minimo:</strong> <?php echo $producto->stock_minimo;?></p>
<p><strong>Categoria:</strong> <?php echo get_record("categorias","id=".$producto->categoria_id)->nombre;?></p>
<p><strong>Subcategoria:</strong> <?php echo get_record("subcategorias","id=".$producto->subcategoria_id)->nombre;?></p>
<p><strong>fabricante:</strong> <?php echo get_record("fabricantes","id=".$producto->fabricante_id)->nombre;?></p>
<p><strong>marca:</strong> <?php echo get_record("marcas","id=".$producto->marca_id)->nombre;?></p>
<p><strong>modelo:</strong> <?php echo get_record("modelos","id=".$producto->modelo_id)->nombre;?></p>
<p><strong>year:</strong> <?php echo get_record("years","id=".$producto->year_id)->year;?></p>
<p><strong>calidad:</strong> <?php echo get_record("calidades","id=".$producto->calidad_id)->nombre;?></p>
<p><strong>presentacion:</strong> <?php echo get_record("presentaciones","id=".$producto->presentacion_id)->nombre;?></p>
<?php $compatibilidades = get_records("compatibilidades","producto_id='$producto->id'");?>
<?php if (!empty($compatibilidades)): ?>
	<p><strong>Modelo compatibles</strong></p>
	<ul>
		<?php foreach ($compatibilidades as $compatibilidad): ?>
			<li><?php echo get_record("modelos","id=".$compatibilidad->modelo_id)->nombre;?></li>
		<?php endforeach ?>
	</ul>
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
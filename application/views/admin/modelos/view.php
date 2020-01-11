<p><strong>Nombre:</strong> <?php echo $modelo->nombre; ?></p>
<p><strong>Marca: </strong><?php echo get_record("marcas", "id='$modelo->marca_id'")->nombre; ?></p>
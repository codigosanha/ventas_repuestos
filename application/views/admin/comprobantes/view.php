<p><strong>Sucursal:</strong> <?php echo get_record("sucursales", "id=".$bodega->sucursal_id)->nombre; ?></p>
<p><strong>Bodega:</strong> <?php echo get_record("bodegas", "id=".$bodega->bodega_id)->nombre; ?></p>

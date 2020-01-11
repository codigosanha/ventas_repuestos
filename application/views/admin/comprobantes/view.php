

<p><strong>Comprobante:</strong> <?php echo get_record("comprobantes", "id='$comprobante->comprobante_id'")->nombre; ?></p>
<p><strong>Sucursal:</strong> <?php echo get_record("sucursales", "id='$comprobante->sucursal_id'")->nombre; ?></p>
<p><strong>Limite:</strong> <?php echo $comprobante->limite; ?></p>
<p><strong>Fecha de Aprobacion SAT:</strong> <?php echo $comprobante->fecha_aprobacion_sat; ?></p>
<p><strong>Fecha de Vencimiento SAT:</strong> <?php echo $comprobante->fecha_vencimiento_sat; ?></p>

<p><strong>Días de Vencimiento:</strong> <?php echo $comprobante->dias_vencimiento; ?></p>
<p><strong>Cantidad Realizadas:</strong> <?php echo $comprobante->realizados; ?></p>
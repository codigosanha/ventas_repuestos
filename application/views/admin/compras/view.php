<div class="row">
    <div class="col-xs-12">
        <div class="form-group">
            <table class="table table-bordered" width="100%">
                <tbody>
                    <tr>
                        <th colspan="7" class="text-center">Informacion del Proveedor</th>
                    </tr>
                    <?php $proveedor = get_record("proveedores","id=".$compra->proveedor_id);?>
                    <tr>
                        <th>Proveedor:</th>
                        <td colspan="2"><?php echo $proveedor->nombre;?></td>
                        <th>Serie:</th>
                        <td><?php echo $compra->serie;?></td>
                        <th>No. Comprobante</th>
                        <td><?php echo $compra->numero_comprobante;?></td>
                    </tr>
                    <tr>
                        <th>NIT:</th>
                        <td><?php echo $proveedor->nit;?></td>
                        <th>Comprobante:</th>
                        <td colspan="2"><?php echo get_record("comprobantes","id=".$compra->comprobante_id)->nombre;?></td>
                        <th>Tipo Pago</th>
                        <td><?php echo $compra->tipo_pago == 1 ? "Efectivo":"Credito";?></td>
                    </tr>
                    <tr>
                        <th>Direccion:</th>
                        <td colspan="4"><?php echo $proveedor->direccion;?></td>
                        <th>Fecha Compra:</th>
                        <td><?php echo $compra->fecha;?></td>
                    </tr>
                </tbody>
            </table>
            <br>
            <table class="table table-bordered" width="100%">
                <tbody>
                    <tr>
                        <th colspan="4" class="text-center">Detalle de la Compra</th>
                    </tr>
                    <tr>
                        <th>Cantidad</th>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Importe</th>
                    </tr>
                    <?php foreach ($detalles as $detalle): ?>
                        <tr>
                            <td><?php echo $detalle->cantidad;?></td>
                            <td><?php echo get_record("productos","id=".$detalle->producto_id)->nombre;?></td>
                            <td><?php echo $detalle->precio;?></td>
                            <td><?php echo $detalle->importe;?></td>
                        </tr>
                    <?php endforeach ?>
                    <tr>
                        <th colspan="3" class="text-right">Subtotal:</th>
                        <td><?php echo $compra->subtotal; ?></td>
                    </tr>
                    
                    <tr>
                        <th colspan="3" class="text-right">Total:</th>
                        <td><?php echo $compra->total; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
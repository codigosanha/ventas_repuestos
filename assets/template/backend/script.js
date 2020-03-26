$(document).ready(function () {
    $("#reestablecer-filtro").on("click", function(){
        $("#year").val(null);
        $("#marca").val(null);
        $("#modelo").val(null);
        cargarProductos();

    });
    $(document).ready(function(){
        $(".year_from,.year_until").datepicker({
                format: "yyyy",
                viewMode: "years", 
                minViewMode: "years",
                autoclose: true
            });
    });
    
    $('.select2').select2();
    //new code - Compra
    var datatable_spanish  = {
            "lengthMenu": "Mostrar _MENU_ registros por pagina",
            "zeroRecords": "No se encontraron resultados en su busqueda",
            "searchPlaceholder": "Buscar registros",
            "info": "Mostrando registros de _START_ al _END_ de un total de  _TOTAL_ registros",
            "infoEmpty": "No existen registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "search": "Buscar:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
        };
    var config_print = {
            globalStyles: true,
            mediaPrint: false,
            stylesheet: null,
            noPrintSelector: ".no-print",
            append: null,
            prepend: null,
            manuallyCopyFormValues: true,
            deferred: $.Deferred(),
            timeout: 750,
            title: "  ",
            doctype: '<!doctype html>'
        };

    $(".btn-cotizador").on("click", function(){
        $("#tbCotizador tbody").html(null);
        $("#tbventas tbody tr").each(function(){
           
            html = "<tr>";
            html += "<td>"+$(this).children("td:eq(7)").find("input").val()+"</td>";
            html += "<td>"+$(this).children("td:eq(2)").text()+"</td>";
            html += '<td class="text-right">'+$(this).children("td:eq(8)").text()+'</td>';
            html += "</tr>";
            $("#tbCotizador tbody").append(html);
        });

        var total = $("input[name=total]").val();
        $("#celdaTotal").text(total);

    });

    $("#btn-guardar-traslado").on("click", function(){
        if ($("#tbTraslado tbody tr").length == 0) {
            swal("Error", "Debe indicar al menos un producto en el detalle del traslado","error");
            return false;
        }
    });

    $("input[name=compatibilidad]").on("change", function(){
        if ($(this).val() == "1"){
            $("#content-compatibilidad").show();
            $(".marcas").attr("required","required");
            $(".modelo").attr("required","required");
            $(".range_year").attr("required","required");
        } else{
            $("#content-compatibilidad").hide();
            $(".marcas").removeAttr("required");
            $(".modelos").removeAttr("required");
            $(".range_year").removeAttr("required");
        }
    });
    $(document).on("click", ".btn-remove-compatibilidad", function(){
        $(this).closest("tr").remove();
    });
    $(document).on("change", ".marcas", function(){
        var value = $(this).val();
        var column = $(this).closest("tr").children("td:eq(1)").find("select");
        $.ajax({
            url :  base_url + "almacen/productos/get_modelos",
            type: "POST",
            data:{marca_id: value},
            dataType: "json",
            success: function (data) {
                var html = "";
                $.each(data, function(key, value){
                    html += "<option value='"+value.id+"'>"+value.nombre+"</option>"
                });
                console.log(html);

                column.html(html);
            }
        });
    });

    $(document).on("change", "#marca", function(){
        var value = $(this).val();
        $.ajax({
            url :  base_url + "movimientos/ventas/get_modelos",
            type: "POST",
            data:{marca_id: value},
            dataType: "json",
            success: function (data) {
                var html = "<option value=''>Seleccione Modelo</option>";
                $.each(data, function(key, value){
                    html += "<option value='"+value.id+"'>"+value.nombre+"</option>"
                });
              

                $("#modelo").html(html);
                cargarProductos();
            }
        });
    });
    $(document).on("change", ".range_year", function(){
        var value = $(this).val();

        if (value == "1") {
            $(this).closest("tr").children("td:eq(3)").find("span").show();
            $(this).closest("tr").children("td:eq(3)").find(".year_until").show();
        }else{
            $(this).closest("tr").children("td:eq(3)").find("span").hide();
            $(this).closest("tr").children("td:eq(3)").find(".year_until").hide();
        }
        
    });
    $(document).on("click",".btn-add-compatibilidad", function(){
        var select_marcas = $("#html-select-marcas").html();
        var select_modelos = $("#html-select-modelos").html();
        var select_range = $("#html-select-range").html();
        var html_years = $("#html-years").html();
        var html_button = $("#html-button").html();

        var html = "<tr>";
        html += "<td>"+select_marcas+"</td>"
        html += "<td>"+select_modelos+"</td>"
        html += "<td>"+select_range+"</td>"
        html += "<td>"+html_years+"</td>"
        html += "<td>"+html_button+"</td>"
        html += "</tr>"

        $("#tbCompatibilidades tbody").append(html);
        $(document).ready(function(){
        $(".year_from,.year_until").datepicker({
                format: "yyyy",
                viewMode: "years", 
                minViewMode: "years",
                autoclose: true
            });
    });
    });
    $(document).on("click", ".btn-check-all-products", function(){
        productos = $(this).val();
        infoRestantes = productos.split(",");
        for (i=0; i < infoRestantes.length;i++) {
            $('#tableSimple').DataTable().$("#p"+infoRestantes[i]).prop('checked', true);
            input = "<input type='hidden' name='idProductos[]' value='"+infoRestantes[i]+"' id='pa"+infoRestantes[i]+"'>";
            $("#productos-seleccionados").append(input);
        }
    });
    $(document).on("click", ".checkProducto", function(){
        idProducto = $(this).val();
        if ($(this).is(":checked")) {
            
            input = "<input type='hidden' name='idProductos[]' value='"+idProducto+"' id='pa"+idProducto+"'>";
            $("#productos-seleccionados").append(input);
        }else{
            $("#pa"+idProducto).remove();
        }
        
    });
    $(document).on("click",".show-image",function(){
        var info = $(this).attr("data-href");
        var data = info.split("*");
        $("#modal-image .modal-title").text(data[0]);
        imagen = "<img class='img-responsive' src='"+base_url+"assets/imagenes_productos/"+data[1]+"' style='width:100%;'>";
        $("#modal-image .modal-body").html(imagen);
    })
    $("#year,#modelo").on("change", function(){
        cargarProductos();
    });
    $("#btn-buscarProductos").on("click", function(){
        cargarProductos();
    });
    $(document).on("click",".btn-cerrar-caja", function(){
        idCaja = $(this).val();
        $("#idCaja").val(idCaja);
    });
    $("#btnGuardarDevolucion").on("click", function(){
        var productos = $("#tbDevolucion tbody tr").length;
        if (productos == 0) {
            swal("Error","Debe haber al menos un producto a devolver","error");
            return false;
        } 
    });
    $("#form-search-venta").submit(function(e){
        e.preventDefault();
        var dataForm = $(this).serialize();
        var url = $(this).attr("action");
        $.ajax({
            url: url,
            type: "POST",
            data: dataForm,
            dataType: "json",
            success: function(data){
                if (data!="0") {
                    $("#info-venta").show();
                    $(".numero_comprobante").text(data.venta.numero_comprobante);
                    $(".bodega").text(data.venta.bodega);
                    $(".sucursal").text(data.venta.sucursal);
                    $(".cliente").text(data.venta.cliente);
                    $(".fecha").text(data.venta.fecha);
                    $("#bodega_venta").val(data.venta.bodega_id);
                    $("#sucursal_venta").val(data.venta.sucursal_id);
                    $("#idVenta").val(data.venta.venta_id);
                    html = "";
                    $.each(data.detalles, function(key, value){
                        html += "<tr>";
                        html += "<td>"+value.producto+"</td>"
                        html += "<td>"+value.cantidad+"</td>"
                        html += "<td><button class='btn btn-warning btn-sm btn-devolver' value='"+JSON.stringify(value)+"'><span class='fa fa-check'></span></button></td>"
                        html += "</tr>"; 
                    });
                    $("#tbVentaProductos tbody").html(html);
                    options = "<option value=''>Seleccione...</option>";
                    $.each(data.bodegas, function(key, value){
                        options += "<option value='"+value.bodega_id+"'>"+value.nombre+"</option>"; 
                    });
                    $("#bodega_devolucion").html(options);

                }else{
                    swal("Error","No se ha encontrado ninguna venta","error");
                    $("#info-venta").hide();
                }
            }
        });
    });
    $(document).on("click",".btn-devolver", function(){
        var producto = JSON.parse($(this).val());
        html = "<tr>";
        html += "<td><input type='hidden' name='idProductos[]' value='"+producto.producto_id+"'>"+producto.producto+"</td>"
        html += "<td>"+producto.cantidad+"</td>";
        html += "<td><input type='text' name='cantidades[]' style='width:60px;' required='required'></td>";
        html += "<td><button type='button' class='btn btn-danger btn-sm btn-delprod'><span class='fa fa-times'></span></button></td>";
        html += "</tr>";
        $("#tbDevolucion").append(html);
    });

    $("#form-consultar-productos-sb-envio").submit(function(e){
        e.preventDefault();
        var sucursal = $("#sucursal_envio").val();
        var bodega = $("#bodega_envio").val();

        $("#id_sucursal_envio").val(sucursal);
        $("#id_bodega_envio").val(bodega);

        cargarProductosTraslados();

    });

    $("#check-all-productos-traslado").on("click", function(){
        var idProductos = $(this).val();
        var dataProductos = idProductos.split(',');
        console.log(dataProductos);
        dataProductos.forEach( function(valor, indice, array) {

            var inputProducto = "<input type='hidden' name='productos[]' id='p-"+valor+"' value='"+valor+"'>";
            var inputCantidad = "<input type='hidden' name='cantidades[]' id='c-"+valor+"' value='0'>";
            $("#productos_trasladados").append(inputProducto + inputCantidad);
        });
    });
    $("#searchProductoTraslado").autocomplete({
        source:function(request, response){
            var sucursal = $("#sucursal_envio").val();
            var bodega = $("#bodega_envio").val();
            $.ajax({
                url: base_url+"inventario/traslados/getProductos",
                type: "POST",
                dataType:"json",
                data:{ valor: request.term, sucursal_id:sucursal, bodega_id:bodega},
                success:function(data){
                    response(data);
                }
            });
        },
        minLength:2,
        select:function(event, ui){
            
            html = "<tr>";
            html +="<td><input type='hidden' name='idProductos[]' value='"+ui.item.producto_id+"'>"+ui.item.codigo_barras+"</td>";
            html +="<td>"+ui.item.nombre+"</td>";
            html +="<td><input type='text' name='cantidades[]'  style='width:60px;'></td>";
            html +="<td><button type='button' class='btn btn-danger btn-remove-producto-compra'><span class='fa fa-times'></span></button></td>";
            html +="</tr>"

            $("#tbTraslado tbody").append(html);
            //sumarCompra();
            this.value = "";
            return false;

        },
    });
    $(document).on("change", "#sucursal_envio", function(){
        var sucursal_id = $(this).val();
        $.ajax({
            url: base_url + "inventario/traslados/getBodegas",
            type: "POST",
            data:{idSucursal:sucursal_id},
            dataType:"json",
            success: function(data){
                bodegas = "<option value=''>Seleccione...</option>";

                $.each(data, function(key, value){
                    bodegas += "<option value='"+value.bodega_id+"'>"+value.nombre+"</option>";
                });

                $("#bodega_envio").html(bodegas);
            }
        });
    });
    $(document).on("change", "#sucursal_recibe", function(){
        var sucursal_id = $(this).val();
        $.ajax({
            url: base_url + "inventario/traslados/getBodegas",
            type: "POST",
            data:{idSucursal:sucursal_id},
            dataType:"json",
            success: function(data){
                bodegas = "<option value=''>Seleccione...</option>";

                $.each(data, function(key, value){
                    bodegas += "<option value='"+value.bodega_id+"'>"+value.nombre+"</option>";
                });

                $("#bodega_recibe").html(bodegas);
            }
        });
    });
    $(document).on("click", ".btn-view-ajuste", function(){
        id = $(this).val();
        showAjuste(id);

    });
    $("#form-add-ajuste").submit(function(e){
        e.preventDefault();
        $("body").prepend("<div class='loader'></div>");
   
        var url = $(this).attr("action");
        var idproductos = $("#tbInventarioSB").DataTable().$("input[name='productos[]']")
              .map(function(){return $(this).val();}).get();
        var stocks_fisico = $("#tbInventarioSB").DataTable().$("input[name='stocks_fisico[]']")
              .map(function(){return $(this).val();}).get();
        var stocks_bd = $("#tbInventarioSB").DataTable().$("input[name='stocks_bd[]']")
              .map(function(){return $(this).val();}).get();
        var stocks_diferencia = $("#tbInventarioSB").DataTable().$("input[name='stocks_diferencia[]']")
              .map(function(){return $(this).val();}).get();
        var sucursal_id = $("#sucursal").val();
        var bodega_id = $("#bodega").val();
        var dataForm = {
            productos: JSON.stringify(idproductos),
            stocks_bd: JSON.stringify(stocks_bd),
            stocks_fisico: JSON.stringify(stocks_fisico),
            stocks_diferencia: JSON.stringify(stocks_diferencia),
            bodega_id: bodega_id,
            sucursal_id: sucursal_id,
        };

        $.ajax({
            url: url,
            type: "POST",
            data: dataForm,
            success: function(data){
                if (data == "0") {
                    swal("Error!","No se pudo guardar el Ajuste");
                }else{
                    $(".loader").hide();
                    showAjuste(data);
                }
            }
        });

        
    });
    
    $(document).on("keyup mouseup", ".stocks_fisico", function(){
        stocks_fisico = Number($(this).val());
        stocks_bd = Number($(this).closest("tr").find("td:eq(2)").text());
        diferencia_stock = stocks_fisico-stocks_bd;
        $(this).closest("tr").find("td:eq(4)").children('input').val(diferencia_stock);
    });
    $("#btn-ver-productos").on("click", function(){
        var bodega_id = $("#bodega").val();
        var sucursal_id = $("#sucursal").val();
        var dataForm = {
            bodega_id: bodega_id,
            sucursal_id: sucursal_id
        };
        $.ajax({
            url: base_url + "inventario/ajuste/searchProductos",
            type: "POST",
            data: dataForm,
            dataType: "json",
            success: function(data){
                $('#tbInventarioSB').dataTable( {
                    "aaData": data,
                    "destroy": true,
                    "columns": [
                        { "data": "codigo_barras" },
                        {
                            mRender: function (data, type, row) {
                                
                                var input = '<input type="hidden" name="productos[]" value="'+row.producto_id+'">';
                               
                                return input + row.nombre;
                            }
                        },
                        {
                            mRender: function (data, type, row) {
                                
                                var input = '<input type="hidden" name="stocks_bd[]" value="'+row.stock+'">';
                               
                                return input + row.stock;
                            }
                        },
                        {
                            mRender: function (data, type, row) {
                                
                                var input = '<input type="text" name="stocks_fisico[]" class="form-control stocks_fisico" value="'+row.stock+'">';
                               
                                return input;
                            }
                        },
                        {
                            mRender: function (data, type, row) {
                                
                                var input = '<input type="text" name="stocks_diferencia[]" class="form-control" value="0" readonly="readonly">';
                               
                                return input;
                            }
                        },
                    ],
                    "pageLength": 25,
                    "language": datatable_spanish,
                    "order": [[ 1, "asc" ]]
                });
   
                /*html = "";
                $.each(data, function(key, value){
                        html +='<tr><td>';
                        html += value.codigo_barras;
                        html +='</td>';
                        html +='<td>';
                        html +='<input type="hidden" name="productos[]" value="'+value.producto_id+'">';
                        html += value.nombre;
                        html +='</td>';
                        html +='<td>';
                        html +='<input type="hidden" name="stocks_bd[]" value="'+value.stock+'">';
                        html += value.stock;
                        html +='</td>';
                        html +='<td>';
                        html +='<input type="text" name="stocks_fisico[]" class="form-control stocks_fisico" value="'+value.stock+'">';
                        html +='</td>';
                        html +='<td>';
                        html +='<input type="text" name="stocks_diferencia[]" class="form-control" value="0" readonly="readonly">';
                        html +='</td></tr>';
                });*/
                if (!data.length) {
                    $("#btn-inventario").attr("disabled","disabled");
                } else{
                    $("#btn-inventario").removeAttr("disabled");
                }
                //$("#tbInventarioSB tbody").html(html);
            }
        });
    });
    $(document).on("click",".btn-selected", function(){
        data = JSON.parse($(this).val());
        html = "<tr>";
        html +="<td><input type='hidden' name='idProductos[]' value='"+data.producto_id+"'>"+data.codigo_barras+"</td>";
        html +="<td><a href='#modal-image' data-toggle='modal' class='show-image' data-href='"+data.nombre+"*"+data.imagen+"'><img src='"+base_url+"assets/imagenes_productos/"+data.imagen+"' class='img-responsive' style='width:50px;'></a></td>";
        html +="<td><a href='#modal-info-producto' data-toggle='modal' data-href='"+data.producto_id+"' class='btn-info-producto'>"+data.nombre+"</a></td>";
        html +="<td>"+data.localizacion+"</td>";

        precios = "<option value=''>Seleccione</option>";
        precio = '';
        cantidad = '';
        var selected = '';
        $.each(data.precios, function(key, value){
            
            if (value.seleccion_venta == "1") {
                selected = 'selected';
                precio = value.precio_venta;
                cantidad = 1;
            }else{
                selected = '';
            }
            precios += "<option value='"+value.precio_venta+"' "+selected+">"+value.nombre+"</option>";
        });
        html +="<td><select class='form-control' id='preciosVentas'>"+precios+"</select></td>";
        html +="<td><input type='text' name='precios[]'  style='width:60px;' value='"+precio+"'></td>";
        html +="<td>"+data.stock+"</td>";
        html +="<td><input type='text' name='cantidades[]' class='cantidadesVenta' style='width:60px;' value='"+cantidad+"'></td>";
        importe = '';
        if (precio != '') {
            importe = Number(precio) * Number(cantidad);
        }
        html +="<td><input type='hidden' name='importes[]' value='"+importe.toFixed(2)+"'><p>"+importe.toFixed(2)+"</p></td>";
        html +="<td><button type='button' class='btn btn-danger btn-remove-producto-compra'><span class='fa fa-times'></span></button></td>";
        html +="</tr>"

        $("#tbventas tbody").append(html);
        sumarVenta();
        
    });
    $("#formSearchProducto").submit(function(e){
        e.preventDefault();
        var dataForm = $(this).serialize();
        var url = $(this).attr("action");
        sucursal_id = $("#sucursal-venta").val();
        bodega_id = $("#bodega").val();

        if (bodega_id) {
            $.ajax({
                url: url,
                type: "POST",
                dataType: "json",
                data: dataForm + "&sucursal_id="+sucursal_id+"&bodega_id="+bodega_id,
                success: function(data){
                    //alert(data);
                    $('#tbProductos').dataTable( {
                        "aaData": data,
                        "columns": [
                            { "data": "nombre" },
                            { "data": "codigo_barras" },
                            { "data": "codigo_barras" },
                            { "data": "codigo_barras" },
                            { "data": "codigo_barras" },
                            { "data": "codigo_barras" },
                            { "data": "codigo_barras" },
                            { "data": "codigo_barras" },
                            { "data": "codigo_barras" },
                        ]
                    })
                }
            });
        }else{
            swal("Error", "Debe seleccionar una bodega", "error");
        }
    });
    $(document).on("click", ".btn-abonar", function(){
        idCuenta = $(this).val();
        num_documento = $(this).closest("tr").children("td:eq(1)").text();
        monto = $(this).closest("tr").children("td:eq(4)").text();
        monto_abonado = $(this).closest("tr").children("td:eq(5)").text();
        saldo_pendiente = $(this).closest("tr").children("td:eq(6)").text();
        $("#idCuenta").val(idCuenta);
        $("#num_documento").val(num_documento);
        $("#monto_abonado").val(monto_abonado);
        $("#monto").val(monto);
        $("#saldo_pendiente").val(saldo_pendiente);
    });

    $(document).on("click", ".btn-pagos", function(){
        idCuenta = $(this).attr("data-href");
        num_documento = $(this).closest("tr").find("td:eq(1)").text();
        texto = "<strong>Nro de Comprobante: </strong>"+num_documento;
        $("p.num_documento").html(texto);
        modulo = $("#modulo").val();
        $.ajax({
            url: base_url + modulo + "/pagosByCuenta/"+idCuenta,
            type: "POST",
            dataType: "json",
            success: function(data){
                html = "";
                $.each(data, function(key, value){
                    html += "<tr>";
                    html += "<td>"+value.monto+"</td>";
                    html += "<td>"+value.fecha+"</td>";
                    html += "</tr>";
                });
                $("#tbpagos tbody").html(html);
            }
        });
    });
    $(document).on("click",".btn-anular-venta",function(e){
        e.preventDefault();
        var url = $(this).attr("href");
        swal({
                title:"Esta seguro de anular la venta?",
                text: "Esta operacion es irreversible",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                confirmButtonText: "Eliminar",
                cancelButtonText: "Cancelar",
                closeOnConfirm: true,
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href = url;
                    }
                return false;
            });
       
    });
    $("#btn-save-venta").on("click", function(){
        var total = Number($("input[name=total]").val());
        if (total == 0) {
            swal("Error","El detalle de la venta debe contar con al menos un producto","error");

            return false;
        }

    });
    $("#tipo_pago").on("change", function(){
        tipo_pago = $(this).val();
        switch(tipo_pago){
            case '1' :
                $("#content-monto-efectivo").hide();
                $("#content-tarjeta").hide();
                $("#content-monto-tarjeta").hide();

                $("#monto_tarjeta").removeAttr("required");
                $("#monto_efectivo").removeAttr("required");
                break;
            case '2' :
                $("#content-monto-efectivo").hide();
                $("#content-tarjeta").show();
                $("#content-monto-tarjeta").hide();
                $("#monto_tarjeta").removeAttr("required");
                $("#monto_efectivo").removeAttr("required");
                break;
            case '3' :
                $("#content-monto-efectivo").hide();
                $("#content-tarjeta").show();
                $("#content-monto-tarjeta").show();
                $("#monto_tarjeta").attr("required","required");
                $("#monto_efectivo").removeAttr("required");
                break;
            default:
                $("#content-monto-efectivo").show();
                $("#content-tarjeta").hide();
                $("#content-monto-tarjeta").hide();
                $("#monto_tarjeta").removeAttr("required");
                $("#monto_efectivo").removeAttr("required");
                break;
        }
    });
    $(document).on("change", "#precios", function(){
        precio_compra = $(this).val();
        cantidad = $(this).closest("tr").children("td:eq(4)").find("input").val();
        importe = precio_compra*cantidad;
        $(this).closest("tr").children("td:eq(3)").find("input").val(precio_compra);
        $(this).closest("tr").children("td:eq(5)").find("input").val(importe.toFixed(2));
        $(this).closest("tr").children("td:eq(5)").find("p").text(importe.toFixed(2));

    });
    $(document).on("change", "#preciosVentas", function(){
        precio_venta = $(this).val();
        cantidad = $(this).closest("tr").children("td:eq(7)").find("input").val();
        stock = $(this).closest("tr").children("td:eq(6)").text();
        importe = precio_venta*cantidad;
        $(this).closest("tr").children("td:eq(5)").find("input").val(precio_venta);
        $(this).closest("tr").children("td:eq(8)").find("input").val(importe.toFixed(2));
        $(this).closest("tr").children("td:eq(8)").find("p").text(importe.toFixed(2));
        sumarVenta();
    });
    $(document).on("click", ".btn-procesar", function(){
        $("#tableSimple tbody tr input:enabled").each(function(){
            html = "";
            if($(this).is(':checked')) {  
                id = $(this).val();
                nombre = $(this).closest("tr").children("td:eq(1)").text();
                html +="<tr>";
                html +="<td><input type='hidden' name='idProductos[]' value='"+id+"'>"+nombre+"</td>";
                html +='<td><button type="button" class="btn btn-danger btn-quitarAsociado"><i class="fa fa-times"></i></button></td>';

                html +="</tr>";
            } 
            $("#tbProductosNuevos tbody").append(html);
        });
    });

    $(document).on("change", "#sucursal", function(){
        var sucursal_id = $(this).val();
        $.ajax({
            url: base_url + "inventario/productos/getBodegas",
            type: "POST",
            data:{idSucursal:sucursal_id},
            dataType:"json",
            success: function(data){
                bodegas = "<option value=''>Seleccione...</option>";

                $.each(data, function(key, value){
                    bodegas += "<option value='"+value.bodega_id+"'>"+value.nombre+"</option>";
                });

                $("#bodega").html(bodegas);
            }
        });
    });
    $(document).on("change", "#sucursal-devolucion", function(){
        var sucursal_id = $(this).val();
        $.ajax({
            url: base_url + "inventario/devoluciones/getBodegas",
            type: "POST",
            data:{idSucursal:sucursal_id},
            dataType:"json",
            success: function(data){
                bodegas = "<option value=''>Seleccione...</option>";

                $.each(data, function(key, value){
                    bodegas += "<option value='"+value.bodega_id+"'>"+value.nombre+"</option>";
                });

                $("#bodega").html(bodegas);
            }
        });
    });

    $(document).on("change", "#sucursal-venta", function(){
        var sucursal_id = $(this).val();
        $.ajax({
            url: base_url + "movimientos/ventas/getBodegasAndComprobantes",
            type: "POST",
            data:{idSucursal:sucursal_id},
            dataType:"json",
            success: function(data){
                bodegas = "<option value=''>Seleccione...</option>";

                $.each(data.bodegas, function(key, value){
                    selected = "";
                    if (value.seleccion_ventas == 1) {
                        selected = "selected";
                    }
                    bodegas += "<option value='"+value.bodega_id+"' "+selected+">"+value.nombre+"</option>";
                });

                $("#bodega").html(bodegas);

                comprobantes = "<option value=''>Seleccione...</option>";

                $.each(data.comprobantes, function(key, value){
                    selected = "";
                    if (value.seleccion_ventas == 1) {
                        selected = "selected";
                    }
                    comprobantes += "<option value='"+value.comprobante_id+"' "+selected+" >"+value.nombre+"</option>";
                });

                $("#comprobanteVenta").html(comprobantes);
            }
        });
    });

    $(document).on("change", "#bodega", function(){
        var bodega_id = $(this).val();
        var sucursal_id = $("#sucursal").val();
        $.ajax({
            url: base_url + "inventario/productos/getProductos",
            type: "POST",
            data:{idBodega:bodega_id,idSucursal:sucursal_id},
            dataType:"json",
            success: function(data){
                productos = "";
                //$("input[type=checkbox]").removeAttr("disabled");
                $('#tableSimple').DataTable().$('input[type=checkbox]').removeAttr('disabled');

                $('#tableSimple').DataTable().$('input[type=checkbox]').prop('checked', false);
                //$("input[type=checkbox]").prop("checked",false);
                $.each(data.productosRegistrados, function(key, value){
                    productos += "<tr><td>"+value.nombre+"</td></tr>";
                    $('#tableSimple').DataTable().$("#p"+value.producto_id).attr("disabled","disabled");
                    $('#tableSimple').DataTable().$("#p"+value.producto_id).prop('checked', true);

                });

                $(".btn-check-all-products").removeAttr("disabled");
                $(".btn-check-all-products").val(data.productosRestantes);

                $("#tbProductosExistentes tbody").html(productos);
            }
        });
    });

    $(document).on("click",".btn-view-barcode", function(){
        codigo_barra = $(this).val();
        cantidad = $(this).closest("tr").find("td:eq(9)").text();
        html = "<div class='row'>";
        for (var i = 1; i <= Number(cantidad); i++) {
            html += "<div class='col-xs-6'>";
            html += "<svg id='barcode"+i+"'></svg>";
            html += "</div>";
        }
        html += "</div>";
        $("#modal-default .modal-body").html(html);
        for (var i = 1; i <= Number(cantidad); i++) {
            JsBarcode("#barcode"+i, codigo_barra, {
              
              displayValue: true
            });
        }
    });

    $(".btn-info-compra").on("click", function(){
        idCompra = $(this).val();
        $.ajax({
            url:base_url + "movimientos/compras/view",
            type: "POST",
            data: {id:idCompra},
            success:function(resp){
                $("#modal-compra .modal-body").html(resp);
            }
        });
    });
    $(".btn-info-venta").on("click", function(){
        idVenta = $(this).val();
        $.ajax({
            url:base_url + "movimientos/ventas/view/"+idVenta,
            type: "POST",
            
            success:function(resp){
                $("#modal-venta .modal-body").html(resp);
            }
        });
    });
    $("#codigo_barras").keypress(function(event){
        if (event.which == '10' || event.which == '13') {
            event.preventDefault();
        }
    });
    $('#searchProductoVenta').keypress(function(event){
        codigo_barra = $(this).val();

        if (event.which == '10' || event.which == '13') {

            var sucursal_id = $("#sucursal-venta").val();
            var bodega_id = $("#bodega").val();
            
            var dataForm = {
                bodega_id: bodega_id,
                sucursal_id: sucursal_id,
                codigo_barra: codigo_barra
            };
            $.ajax({
                url: base_url+"movimientos/ventas/getProductoByCode",
                type: "POST",
                dataType:"json",
                data: dataForm,
                success:function(data){
                
                    if (data =="0") {
                        swal({
                            position: 'center',
                            type: 'warning',
                            title: 'El codigo de barra no esta registrado o no cuenta con stock disponible',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }else{
                        html = "<tr>";
                        if (Number(data.stock) > 0) {
                            html +="<td><input type='hidden' name='idProductos[]' value='"+data.producto_id+"'>"+data.codigo_barras+"</td>";
                        }else{
                            html +="<td>"+data.codigo_barras+"</td>";
                        }
                        
                        html +="<td><a href='#modal-image' data-toggle='modal' class='show-image' data-href='"+data.nombre+"*"+data.imagen+"'><img src='"+base_url+"assets/imagenes_productos/"+data.imagen+"' class='img-responsive' style='width:50px;'></a></td>";
                        html +="<td><a href='#modal-info-producto' data-toggle='modal' data-href='"+data.producto_id+"' class='btn-info-producto'>"+data.nombre+"</a></td>";                        
                        html +="<td>"+data.localizacion+"</td>";
                    
                        precios = "<option value=''>Seleccione</option>";
                        precio = '';
                        cantidad = '';
                        var selected = '';
                        $.each(data.precios, function(key, value){
                            
                            if (value.seleccion_venta == "1") {
                                selected = 'selected';
                                precio = value.precio_venta;
                                cantidad = 1;
                            }else{
                                selected = '';
                            }
                            precios += "<option value='"+value.precio_venta+"' "+selected+">"+value.nombre+"</option>";
                        });
                        html +="<td><select class='form-control' id='preciosVentas'>"+precios+"</select></td>";
                        
                        if (Number(data.stock) > 0) {
                            html +="<td><input type='text' name='precios[]'  style='width:60px;' value='"+precio+"'></td>";
                        }else{
                            html +="<td><input type='text'  style='width:60px;' value='"+precio+"'></td>";
                        }

                        html +="<td>"+data.stock+"</td>";
                        
                        if (Number(data.stock) > 0) {
                            html +="<td><input type='text' name='cantidades[]' class='cantidadesVenta' style='width:60px;' value='"+cantidad+"'></td>";
                        }else{
                            html +="<td><input type='text' style='width:60px;' value='0' disabled></td>";
                        }
                        importe = 0.00;
                        if (precio != '') {
                            importe = Number(precio) * Number(cantidad);
                        }
                        if (Number(data.stock) > 0) {
                            html +="<td><input type='hidden' name='importes[]' value='"+importe.toFixed(2)+"'><p>"+importe.toFixed(2)+"</p></td>";
                        }else{
                            html +="<td><p>0.00</p></td>";
                        }
                        
                        html +="<td><button type='button' class='btn btn-danger btn-remove-producto-compra'><span class='fa fa-times'></span></button></td>";
                        html +="</tr>"

                        $("#tbventas tbody").append(html);
                        sumarVenta();
                    }
                    
                }
            });
            $('#searchProductoVenta').val(null);
            event.preventDefault();
        }
    });
    $('#searchProductoCompra').keypress(function(event){
        codigo_barra = $(this).val();

        if (event.which == '10' || event.which == '13') {
            var sucursal_id = $("#sucursal").val();
            var bodega_id = $("#bodega").val();
            
            var dataForm = {
                bodega_id: bodega_id,
                sucursal_id: sucursal_id,
                codigo_barra: codigo_barra
            };
            
            $.ajax({
                url: base_url+"movimientos/compras/getProductoByCode",
                type: "POST",
                dataType:"json",
                data: dataForm,
                success:function(data){
                
                    if (data =="0") {
                        swal({
                            position: 'center',
                            type: 'warning',
                            title: 'El codigo de barra no esta registrado o no cuenta con stock disponible',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }else{
                        html = "<tr>";
                        html +="<td><input type='hidden' name='idProductos[]' value='"+data.producto_id+"'>"+data.codigo_barras+"</td>";
                        html +="<td><a href='#modal-info-producto' data-toggle='modal' data-href='"+data.producto_id+"' class='btn-info-producto'>"+data.nombre+"</a></td>";
                        precios = "<option value=''>Seleccione</option>";
                        $.each(data.precios, function(key, value){
                            precios += "<option value='"+value.precio_compra+"'>"+value.nombre+"</option>";
                        });
                        html +="<td><select class='form-control' id='precios'>"+precios+"</select></td>";
                        html +="<td><input type='text' name='precios[]'  style='width:60px;'></td>";

                        html +="<td><input type='text' name='cantidades[]' class='cantidadesCompra' value='1' style='width:60px;'></td>";
                        html +="<td><input type='hidden' name='importes[]'><p></p></td>";
                        html +="<td><button type='button' class='btn btn-danger btn-remove-producto-compra'><span class='fa fa-times'></span></button></td>";
                        html +="</tr>"

                        $("#tbcompras tbody").append(html);
                        sumarCompra();
                    }
                    
                }
            });
            $('#searchProductoCompra').val(null);
            event.preventDefault();
        }
    });
    $(document).on("click",".btn-remove-producto-compra", function(){
        modulo = $("#modulo").val();
        if (modulo == "ventas") {
            $(this).closest("tr").remove();
            sumarVenta();
        }else{
            $(this).closest("tr").remove();
            sumarCompra();
        }
        
    });

    $("#comprobante").on("change", function(){
        optionSelected = $(this).val();
        infoOptionSelected = optionSelected.split("*");
        if (optionSelected == '') {
            $("#comprobante_id").val(null);
            $("#iva").val(0);
        }else{
            $("#comprobante_id").val(infoOptionSelected[0]);
            $("#iva").val(infoOptionSelected[2]);
        }
        sumarCompra();
    });
    $("#form-add-venta").submit(function(e){
        e.preventDefault();
        var dataForm = $(this).serialize();
        var url = $(this).attr("action");
        $.ajax({
            url: url,
            type: "POST",
            data: dataForm,
            success: function(resp){
                if (resp != "0") {
                    $("#modal-venta").modal("show");
                    $("#modal-venta .modal-body").html(resp);
                    cleanFormVenta();
                    
                } else {
                    swal("Error","No se pudo guardar la venta", "error");
                }
            }
        });
    });

    function cleanFormVenta(){
        $("#form-add-venta")[0].reset();
        $("#idcliente").val(null);
        $("#tbventas tbody").html("");

    }

    function sumarCompra(){
        subtotal = 0;
        $("#tbcompras tbody tr").each(function(){
            subtotal = subtotal + Number($(this).children("td:eq(5)").find('input').val());
        });

        $("input[name=subtotal]").val(subtotal.toFixed(2));

        $("input[name=total]").val(subtotal.toFixed(2));
    }
    $(document).on("keyup mouseup","#tbcompras input.cantidadesCompra", function(){
        cantidad = Number($(this).val());
        precio = Number($(this).closest("tr").find("td:eq(3)").find("input").val());
        importe = cantidad * precio;
        $(this).closest("tr").find("td:eq(5)").children("p").text(importe.toFixed(2));
        $(this).closest("tr").find("td:eq(5)").children("input").val(importe.toFixed(2));
        sumarCompra();
    });
    $(document).on("keyup mouseup","#tbventas input.cantidadesVenta", function(){

        cantidad = $(this).val();
        precio = Number($(this).closest("tr").children("td:eq(5)").find("input").val());
        stock = Number($(this).closest("tr").find("td:eq(6)").text());

        if (cantidad!='') {
            if (cantidad == 0) {
                alertify.error("El valor ingresada no puede ser menor a la unidad");
                $(this).val('1');
                importe = precio;
            }else if(cantidad > stock){
                alertify.error("El valor ingresada no puede sobrepasar el stock");
                $(this).val(stock);
                importe = precio * stock;
            }else{
                importe = Number(cantidad) * precio;
            }
        }else{
            importe = 0;
        }

        $(this).closest("tr").find("td:eq(8)").children("p").text(importe.toFixed(2));
        $(this).closest("tr").find("td:eq(8)").children("input").val(importe.toFixed(2));
        sumarVenta();
        
          
    });

    $("#btn-guardar-compra").on("click", function(){
        cantidadproductos = Number($("#tbcompras tbody tr").length);
        if (cantidadproductos == 0) {
            swal({
                    position: 'center',
                    type: 'warning',
                    title: 'La compra debe contar por lo menos con un detalle',
                    showConfirmButton: false,
                    timer: 1500
                    });
            return false;
        }

    });

    $("#btn-guardar-venta").on("click", function(){
        cantidadproductos = Number($("#tbventas tbody tr").length);
        if (cantidadproductos == 0) {
            swal({
                    position: 'center',
                    type: 'warning',
                    title: 'La venta debe contar por lo menos con un detalle',
                    showConfirmButton: false,
                    timer: 1500
                    });
            return false;
        }

    });


    $("#comprobanteVenta").on("change", function(){
        optionSelected = $(this).val();
        infoOptionSelected = optionSelected.split("*");
        if (optionSelected == '') {
            $("#comprobante_id").val(null);
            $("#iva").val(0);
        }else{
            $("#comprobante_id").val(infoOptionSelected[0]);
            $("#iva").val(infoOptionSelected[2]);
        }
        sumarVenta();
    });

    function sumarVenta(){
        subtotal = 0;
        $("#tbventas tbody tr").each(function(){
            subtotal = subtotal + Number($(this).children("td:eq(8)").find('input').val());
        });

        $("input[name=subtotal]").val(subtotal.toFixed(2));
        descuento = Number($("#descuento").val());
        porcentaje = Number($("#iva").val());
        iva = subtotal * (porcentaje/100);
        $("input[name=iva]").val(iva.toFixed(2));
        total = subtotal + iva - descuento;
        $("input[name=total]").val(total.toFixed(2));
    }

    $("#monto_recibido").on("keyup", function(){
        monto_recibido = Number($(this).val());
        total = Number($("input[name=total]").val());
        $("input[name=cambio]").val((monto_recibido - total).toFixed(2));
    });


    //old code
    $("#cantEliminar").on("keyup",function(){
        if ($(this).val() != "") {
            value = Number($(this).val());
            maxValue = Number($(this).attr("max"));
            if (value==0) {
                alertify.error("Valor no permitido");
                $(this).val(null);
            }

            if (value!=0 && value < 1) {
                alertify.error("Ud. no puede ingresar un numero menor a 1");
                $(this).val("1");
            }

            if (value > maxValue) {
                alertify.error("Ud. no puede ingresar un numero mayor a "+ maxValue);
                $(this).val(maxValue);
            }
        }
    });
    
       //Para Ocultar el Menu Automaticamente
    //$("#side-bar").mouseleave(function() {
      //  $("#collapse").trigger("click");
    //});

    $("#showCaracteres").on("change", function(){

        if ($(this).is(':checked')) {
            $("#clave").attr("type","text");
        }
        else{
            $("#clave").attr("type","password");
        }
        
    })
    $(document).on("click","#change-password",function(){

        $("input[name=idusuario]").val($(this).val());

    });
    $(document).on("submit","#form-change-password",function(e){
        e.preventDefault();
        info = $(this).serialize();
        newpassword = $("input[name=newpassword]").val();
        repeatpassword = $("input[name=repeatpassword]").val();
        if (newpassword != repeatpassword) {
            error = '<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> La contraseñas ingresadas no coindicen</div>';
            $(".error").html(error);
        }else{
            $.ajax({
                url: base_url + "administrador/usuarios/changepassword",
                type: "POST",
                data: info,
                success: function(resp){
                    swal({
                            position: 'center',
                            type: 'success',
                            title: 'La contraseña se ha modificado correctamente',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    window.location.href = base_url + resp;
                }
            });
        }
    })

    $(document).on("submit","#form-clave", function(e){
        e.preventDefault();
        data = $(this).serialize();
        $.ajax({
            url :  base_url + "movimientos/ordenes/checkClave",
            type:"POST",
            data : data,
            success:function(resp){
             
                if (resp=="1") {
                    location.reload();
                }else if(resp =="2"){
                    window.location.href = base_url + "movimientos/ordenes";
                }else{
                    alertify.error("La clave de permiso ingresada no es valida");
                }
            }
        });
    });

    $(document).on("click", ".btn-delete", function(e){
        e.preventDefault();
        url = $(this).attr("href");
        swal({
                title:"Esta seguro que desea eliminar este registro?",
                text: "Esta operacion es irreversible",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                confirmButtonText: "Eliminar",
                cancelButtonText: "Cancelar",
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            },
            function(isConfirm){
                if(isConfirm){
                    $.ajax({
                        url: url,
                        type: "POST",
                        success: function(resp){
                            window.location.href = base_url + resp;
                        }
                    });
                    }
                return false;
            });
        });


       


    $(document).on("click",".btn-cerrar-imp", function(){
        
        window.location.href = base_url + "movimientos/ordenes";
        
    });



    $(document).on("click",".btn-cerrar", function(){
        if ($("#estadoPedido").val() == "1") {
            window.location.href = base_url + "movimientos/ordenes";
        }else{
            location.reload();
        }
    });


    $("#categoria_id").on("change", function(){
        id = $(this).val(); 
        $.ajax({
            url: base_url + "almacen/productos/getSubcategorias",
            type: "POST", 
            data:{idCategoria:id},
            dataType:"json",
            success:function(resp){
                html = "<option value=''>Seleccione...</option>";
                $.each(resp,function(key, value){
                    html += "<option value='"+value.id+"'>"+value.nombre+"</option>";
                });

                $("#subcategoria_id").html(html);
            }

        });
    });



    $("#monto_efectivo").on("keyup", function(){
        valor  = Number($(this).val());
        ventas = Number($("#monto_ventas").val());
        apertura = Number($("#monto_apertura").val());
        monto = ventas + apertura;
        if (valor == monto) {
            $("#observacion").val("Cuadre de Caja conforme");
        }else{
            $("#observacion").val("Cuadre de Caja no conforme");
        }
    });



    $("#btnActualizarApertura").on("click", function(){
        $("#panelApertura").hide();
        $("#formActualizarApertura").show();
    });

    $(".menu-notificaciones li").on("click", function(){
        return false;
    })

    $(".remove-notificacion").on("click", function(e){
        e.preventDefault();
        id = $(this).attr("href");
        $(this).parent().parent().remove();
        $.ajax({
            url: base_url + "notificaciones/delete",
            data: {id:id},
            type: "POST",
            success:function(resp){
                if (resp > 0 ) {
                    $(".notifications-menu a span").text(resp);
                    $(".notifications-menu ul li.header").text("Tienes "+resp+" notificaciones");
                }else{
                    $(".notifications-menu a span").remove();
                    $(".notifications-menu ul li.header").text("Tienes 0 notificaciones");
                    $(".notifications-menu ul li.footer").remove();
                }
            }
        });


        return false;
    });

    $("input[name=condicion]").click(function() {
        condicion = $(this).val();
        if (condicion == "0") {
            $("input[name=stock]").attr("disabled","disabled");
            $("input[name=stockminimo]").attr("disabled","disabled");
            $("input[name=stock]").val(null);
            $("input[name=stockminimo]").val(null);
        }else{
            $("input[name=stock]").removeAttr("disabled");
            $("input[name=stockminimo]").removeAttr("disabled");
        }
    });

    $("#descuento").on("keyup",function(){
        sumarVenta();
    });
    $("#form-comprobar-password").submit(function(e){
        e.preventDefault();
        data = $(this).serialize();
        $.ajax({
            url: base_url + "movimientos/ventas/comprobarPassword",
            type:"POST",
            data: data,
            //dataType: "json",
            success:function(resp){
                
                if (resp == 1) {
                    $('#modal-default2').modal('hide');
                    $("#descuento").removeAttr("readonly");
                    
                    
                } else {
                    alertify.error("La contraseña no es válida");
                }      
            }
        });
    });

    $("#btn-pagar").on("click", function(){
        idventa = $(this).val();
        $.ajax({
            url: base_url + "movimientos/ventas/pagar",
            type:"POST",
            data: {id:idventa},
            //dataType: "json",
            success:function(resp){
                window.location.href = base_url + resp;         
            }
        });
    });
    $("#form-venta").submit(function(e){
        $('button[type=submit]').attr('disabled','disabled');
        $('button[type=submit]').text('Procesando...');
        e.preventDefault();

        cantidadProductos = $("#tbpago tbody tr").length;

        if (cantidadProductos < 1) {
            alertify.error("Agregue productos a pagar");
        }else{
            setEstado();
            data = $(this).serialize();
            ruta = $(this).attr("action");
            $.ajax({
                url: ruta,
                type:"POST",
                data: data,
                //dataType: "json",
                success:function(resp){
                    if (resp != "0") {
                        alertify.success("La informacion de la venta fue actualizada");
                        $("#modal-venta").modal({backdrop: 'static', keyboard: false});
                        $("#modal-venta .modal-body").html(resp);
                    }else{
                        alertify.error("No se pudo actualizar la informacion de la venta");
                    }            
                }
            });
        }

        
    });
    $("#form-cierre").submit(function(e){
        e.preventDefault();

        data = $(this).serialize();
        ruta = $(this).attr("action");
        if ($("#monto_apertura").val() == "") {
            alertify.error("Es necesario establece una apertura de caja.");
        }else{
            alertify.confirm("¿Estas seguro de cerrar la caja?", function(e){
                if (e) 
                {
                    $.ajax({
                        url: ruta,
                        type:"POST",
                        data: data,
                        success:function(resp){
                            
                            window.location.href = base_url + resp;
                            
                        }
                    });

                }
            });
        }
        
    });
    $(document).on("submit", "#form-cliente", function(e){
        e.preventDefault();
        data = $(this).serialize();
        ruta = $(this).attr("action");
        $.ajax({
            url: ruta,
            type:"POST",
            data: data,
            dataType: "json",
            success:function(resp){
                console.log(resp);
                if (resp.status=="1") {
                    $('#tbClientes').dataTable( {
                        "aaData": resp.clientes,
                        "destroy": true,
                        "columns": [
                            { "data": "cedula" },
                            { "data": "nombres" },
                            { "data": "apellidos" },
                            {
                                mRender: function (data, type, row) {
                                    
                                    var btnCheck = '<button type="button" class="btn btn-success" value="'+JSON.stringify(row)+'"><span class="fa fa-check"></span></button>';
                                   
                                    
                                    return btnCheck;
                                }
                            } 
                        ],
                        "language": datatable_spanish,
                        "order": [[ 1, "asc" ]]
                    });
                    //alertify.success("El cliente se registro correctamente");
                    $('#modal-default').modal('hide');
                  
                    $("#cliente").val(resp.cliente.nombres);
                    $("#idcliente").val(resp.cliente.id);
                    $("#form-cliente")[0].reset();



                } else{
                    $("#alert-error-cliente").show();
                    $("#alert-error-cliente").html(resp.error);
                }
                
                
                
            }
        });

    });

    var year = (new Date).getFullYear();
    if ($("#grafico").length) {
         datagrafico(base_url);
         datagraficoMeses(base_url,year);
    }
   
    
    $("#year").on("change",function(){
        yearselect = $(this).val();
        datagrafico(base_url,yearselect);
    });
    $(document).on("click",".btn-remove",function(e){
        e.preventDefault();
        var url = $(this).attr("href");
        swal({
                title:"Esta seguro deshabilitar el registro?",
                text: "Esta operacion es irreversible",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                confirmButtonText: "Aceptar",
                cancelButtonText: "Cancelar",
                closeOnConfirm: true,
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href = url;
                    }
                return false;
            });
       
    });
    $(document).on("click",".btn-habilitar",function(e){
        e.preventDefault();
        var url = $(this).attr("href");
        swal({
                title:"Esta seguro habilitar el registro?",
                text: "Esta operacion es irreversible",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                confirmButtonText: "Aceptar",
                cancelButtonText: "Cancelar",
                closeOnConfirm: true,
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href = url;
                    }
                return false;
            });
       
    });

     $(document).on("click",".btn-info-producto", function(e){
        e.preventDefault();
        var id = $(this).attr("data-href");
        var modulo = $("#modulo").val();
        $.ajax({
            url: base_url + modulo+"/infoProducto/" + id,
            type:"POST",
            success:function(resp){
                $("#modal-info-producto .modal-body").html(resp);
                //alert(resp);
            }

        });

    });
    $(document).on("click", ".btn-view-corte-caja", function(){
        idCaja = $(this).val();
        $.ajax({
            url: base_url + "caja/apertura_cierre/viewCorte/" + idCaja,
            type: "POST",
            success: function(resp){
                $("#modal-corte .modal-body").html(resp);
            }
        });
    });
  
    $(".btn-view-cliente").on("click", function(){
        var cliente = $(this).val(); 
        //alert(cliente);
        var infocliente = cliente.split("*");
        html = "<p><strong>Nombre:</strong>"+infocliente[1]+"</p>"
        html += "<p><strong>Tipo de Contribuyente:</strong>"+infocliente[4]+"</p>"
        html += "<p><strong>Tipo de Documento:</strong>"+infocliente[5]+"</p>"
        html += "<p><strong>Numero  de Documento:</strong>"+infocliente[6]+"</p>"
        html += "<p><strong>Telefono:</strong>"+infocliente[3]+"</p>"
        html += "<p><strong>Direccion:</strong>"+infocliente[2]+"</p>"
        $("#modal-default .modal-body").html(html);
    });
    $(document).on("click", ".btn-view", function(){
        modulo = $("#modulo").val();
        var id = $(this).val();
        $.ajax({
            url: base_url + modulo+"/view/" + id,
            type:"POST",
            success:function(resp){
                $("#modal-default .modal-body").html(resp);
                //alert(resp);
            }

        });

    });
    $(".btn-view-usuario").on("click", function(){
        var id = $(this).val();
        $.ajax({
            url: base_url + "administrador/usuarios/view/"+id,
            type:"POST",

            success:function(resp){
                $("#modal-default .modal-body").html(resp);
                //alert(resp);
            }

        });

    });

    $(document).on("click", ".btn-edit-mesa", function(){
        id = $(this).val();
        numero = $(this).closest("tr").find("td:eq(0)").text();
        $("#idMesa").val(id);
        $("#numero").val(numero);
    });
    
    $('#table-with-buttons').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: $("h3").text(),
                exportOptions: {
                    columns: [ 0, 1,2, 3, 4, 5,6]
                },
            }
        ],

        language: datatable_spanish
    });
    $('#inventario').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: "Inventario Quicheladas",
                exportOptions: {
                    columns: [ 2, 4 ]
                },
            },
            {
                extend: 'pdfHtml5',
                title: "Inventario Quicheladas",
                exportOptions: {
                    columns: [2, 4]
                },
                
            },
            {
                extend: 'print',
                title: "Inventario Quicheladas",
                text: 'Imprimir',
                exportOptions: {
                    columns: [2, 4]
                }
                
            }
        ],

        language: datatable_spanish
    });

    $('#inventario-productos').DataTable( {
       dom: 'Bfrtip',
         "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 4 ).footer() ).html(
                'Q. '+pageTotal +' ( Q. '+ total +' total)'
            );
        },
        buttons: [
            {
                extend: 'excelHtml5',
                title: "Inventario Productos",
                exportOptions: {
                    columns: [ 1, 4 ]
                },
            },
            {
                extend: 'pdfHtml5',
                title: "Inventario Productos",
                exportOptions: {
                    columns: [1, 4]
                },
                
            },
            {
                extend: 'print',
                title: "Inventario ¨Productos",
                text: 'Imprimir',
                exportOptions: {
                    columns: [1, 4]
                }
                
            }
        ],
        language: datatable_spanish
    });
    
    $('#tableSimple, .tableSimple').DataTable({
        "pageLength": 25,
        "language": datatable_spanish
    });
    $('#tbClientes').DataTable({
        "language": datatable_spanish,
        "order": [[ 1, "asc" ]]
    });
    if ($("#tbInventario").length) {
        var permisos = JSON.parse($("#permisos").val());
        $('#tbInventario').DataTable({
                "processing": true,
                "serverSide": true,
                "destroy": true,
                "ajax":{
                    "url": base_url + "inventario/productos/getInventario",
                    "dataType": "json",
                    "type": "POST",
                },
                columns: [
                    {"data" : "index"},
                    {"data" : "sucursal"},
                    {"data" : "bodega"},
                    {"data" : "codigo_barras"},
                    {"data" : "nombre"},
                    {"data" : "stock"},
                    {"data" : "localizacion"},
                  
                    {
                        mRender: function (data, type, row) {
                            var btnBarcode = '<a href="'+base_url+'inventario/productos/barcode/'+row.id+'" class="btn btn-default btn-sm" target="_blank"><span class="fa fa-barcode"></span></a>';
                            var btnView = '<button type="button" class="btn btn-info btn-view btn-sm" data-toggle="modal" data-target="#modal-default" value="'+row.id+'"><span class="fa fa-search"></span></button>';

                            var btnEdit = '';
                            if (permisos.update) {
                                btnEdit = '<a href="'+base_url+'inventario/productos/edit/'+row.id+'" class="btn btn-warning btn-sm"><span class="fa fa-pencil"></span></a>';
                            }
                            var btnDelete = '';
                            if (permisos.delete) {
                                if (row.estado) {
                                    btnDelete = '<a href="'+base_url+'inventario/productos/deshabilitar/'+row.id+'" class="btn btn-danger btn-remove btn-sm"><span class="fa fa-remove"></span></a>';
                                }else{
                                    btnDelete='<a href="'+base_url+'inventario/productos/habilitar/'+row.id+'" class="btn btn-success btn-habilitar btn-sm"><span class="fa fa-check"></span></a>';
                                }
                            }
                            return '<div class="btn-group" >'+ btnBarcode+ btnView+btnEdit+btnDelete+'</div>';
                        }
                    }

                ],
                "language": datatable_spanish,
                "order": [[ 0, "desc" ]],
                "pageLength": 50,
                

            });
    }

    function cargarProductos(){
      $.fn.DataTable.ext.pager.numbers_length = 10;
        bodega = $("#bodega").val();
        sucursal = $("#sucursal-venta").val();
        marca = $("#marca").val();
        year = $("#year").val();
        modelo = $("#modelo").val();


        $('#tbSearch').DataTable({
            "processing": true,
            "serverSide": true,
            "destroy": true,
            "ajax":{
                "url": base_url + "movimientos/ventas/searchProductos",
                "dataType": "json",
                "type": "POST",
                "data": {
                    bodega:bodega, 
                    sucursal:sucursal, 
                    marca:marca, 
                    year:year, 
                    modelo:modelo, 
                }
            },
            columns: [
                {"data" : "codigo_barras"},
                {
                    mRender: function (data, type, row) {
                        
                        var image = "<a href='#modal-image' data-toggle='modal' class='show-image' data-href='"+row.nombre+"*"+row.imagen+"'><span class='fa fa-picture-o fa-3x'></span></a>";
                        return image;
                    }
                },
                {
                    mRender: function (data, type, row) {
                        
                        var producto = '<a href="#modal-info-producto" data-toggle="modal" data-href="'+row.producto_id+'" class="btn-info-producto">'+row.nombre+'</a>';
                        return producto;
                    }
                },
                {"data" : "stock"},
                {"data" : "listPrecios"},
                {"data" : "localizacion"},
                
                {"data" : "year"},
                {"data" : "marca"},
                {"data" : "modelo"},
                {
                    mRender: function (data, type, row) {
                        var button = '';
                        if (row.stock > 0) {
                            button = "<button type='button' class='btn btn-success btn-sm btn-selected' value='"+JSON.stringify(row)+"'><span class='fa fa-check'></span></button>";
                        }
                         
                        return button;
                    }
                }

            ],
            "columnDefs": [ {
                "targets": [4,5,6,7,8],
                "orderable": false
                } ],
            "language": datatable_spanish,
            "order": [[ 2, "asc" ]],
            "pageLength": 50,
            

        });
       
    }

    function cargarProductosTraslados(){
        
        sucursal = $("#id_sucursal_envio").val();
        bodega = $("#id_bodega_envio").val();
        //obteniendo los id de los productos de la sucursal - bodega de envio
        getIdProductosSBE(sucursal, bodega);

        $('#tbTraslados').DataTable({
            "processing": true,
            "serverSide": true,
            "destroy": true,
            "ajax":{
                "url": base_url + "inventario/traslados/searchProductos",
                "dataType": "json",
                "type": "POST",
                "data": {
                    bodega:bodega, 
                    sucursal:sucursal,
                }
            },
            columns: [
                {
                    mRender: function (data, type, row) {
                        
                        var checkbox = "<input type='checkbox' value='"+row.producto_id+"' class='check-producto'>";
                        return checkbox;
                    }
                },
                {"data" : "codigo_barras"},
                {"data" : "nombre"},
                {
                    mRender: function (data, type, row) {
                        
                        var input = '<input type="text" class="form-control" class="cantidad" disabled>';
                        return input;
                    }
                }

            ],
            "language": datatable_spanish,
            "order": [[ 2, "asc" ]],
            "pageLength": 50,
        });
       
    }

    function getIdProductosSBE(sucursal, bodega){
        $.ajax({
            url: base_url + "inventario/traslados/getIdProductosSBE",
            type: "POST",
            data: {
                bodega:bodega,
                sucursal:sucursal
            },
            dataType:'json',
            success: function(resp){
                $("#check-all-productos-traslado").val(resp);
            }
        });
    }

    $(document).on('show.bs.modal', '.modal', function () {
    var zIndex = 1040 + (10 * $('.modal:visible').length);
    $(this).css('z-index', zIndex);
    setTimeout(function() {
        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
    }, 0);
});
    $(document).on('hidden.bs.modal', '.modal', function () {
    $('.modal:visible').length && $(document.body).addClass('modal-open');
});
    $('.example1').DataTable({
        "language": datatable_spanish
    });

    $(document).ready(function () {
        /*var url_complete = base_url + "filemanager/archivos/getArchivos";
        if (uri_segment != '') {
            url_complete = base_url + "filemanager/archivos/getArchivos/"+uri_segment;
        }*/
        if ($("#tableProductos").length) {
            var permisos = JSON.parse($("#permisos").val());
        $('#tableProductos').DataTable({
            "pageLength": 25,
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": base_url + "almacen/productos/getProducts",
                "dataType": "json",
                "type": "POST",
            },
            "columns": [
                { "data": "id" },
                {
                    mRender: function (data, type, row) {
                        var barcode = '<img src="'+base_url +'assets/barcode/'+ row.codigo_barras+ '.png" alt="'+row.codigo_barras+'">';
                        return barcode;
                    }


                },
                {
                    mRender: function (data, type, row) {
                       
                        var image = "<a href='#modal-image' data-toggle='modal' class='show-image' data-href='"+row.nombre+"*"+row.imagen+"'><span class='fa fa-picture-o fa-3x'></span></a>";
                        return image;
                    }
                },
                { "data": "nombre" },
                { "data": "calidad" },
                { "data": "stock_minimo" },
                {
                    mRender: function (data, type, row) {
                        
                        var btnView = '<button type="button" class="btn btn-info btn-sm btn-view" data-toggle="modal" data-target="#modal-default" value="'+row.id+'">';
                        btnView += '<span class="fa fa-search"></span>';
                        btnView += '</button>';
                        var btnEditar = '';
                        if (permisos.update) {
                            btnEditar = '<a href="'+base_url+'almacen/productos/edit/'+row.id+'" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-pencil"></i></a>';
                        }
                        var btnHabilitar = '';
                        var btnDeshabilitar ='';
                        if (permisos.delete) {
                            if (row.estado=="1") {
                                btnDeshabilitar ='<a href="'+base_url+'almacen/productos/deshabilitar/'+row.id+'" class="btn btn-danger btn-sm btn-flat btn-remove"><i class="fa fa-times"></i></a>';

                            }else{
                                btnHabilitar ='<a href="'+base_url+'almacen/productos/habilitar/'+row.id+'" class="btn btn-success btn-sm btn-flat btn-habilitar"><i class="fa fa-pencil"></i></a>';
                            }
                        }
                        
                        return '<div class="btn-group">' + btnView+ btnEditar +' '+ btnHabilitar+' '+btnDeshabilitar+ "</div>";
                    }
                } 
            ],
            "language": datatable_spanish,
     
        });
        }
        
    });

    $('.sidebar-menu').tree();


    $(document).on("click",".btn-check",function(){
        cliente = JSON.parse($(this).val());
      
        $("#idcliente").val(cliente.id);
        $("#cliente").val(cliente.nombres);
        $("#modal-default").modal("hide");
    });
    $("#proveedor").autocomplete({
        source:function(request, response){
            $.ajax({
                url: base_url+"movimientos/compras/getProveedores",
                type: "POST",
                dataType:"json",
                data:{ valor: request.term},
                success:function(data){
                    response(data);
                }
            });
        },
        minLength:2,
        select:function(event, ui){

            data = ui.item.id +"*"+ ui.item.nit + "*"+ ui.item.label;
            $("#idproveedor").val(ui.item.id);

            
        },
    });
    $("#searchProductoCompra").autocomplete({
        source:function(request, response){
            var sucursal = $("#sucursal").val();
            var bodega = $("#bodega").val();
            $.ajax({
                url: base_url+"movimientos/compras/getProductos",
                type: "POST",
                dataType:"json",
                data:{ valor: request.term, sucursal_id:sucursal, bodega_id:bodega},
                success:function(data){
                    response(data);
                }
            });
        },
        minLength:2,
        select:function(event, ui){
            
            html = "<tr>";
            html +="<td><input type='hidden' name='idProductos[]' value='"+ui.item.producto_id+"'>"+ui.item.codigo_barras+"</td>";
            html +="<td><a href='#modal-info-producto' data-toggle='modal' data-href='"+ui.item.producto_id+"' class='btn-info-producto'>"+ui.item.nombre+"</a></td>";
            precios = "<option value=''>Seleccione</option>";
            $.each(ui.item.precios, function(key, value){
                precios += "<option value='"+value.precio_compra+"'>"+value.nombre+"</option>";
            });
            html +="<td><select class='form-control' id='precios'>"+precios+"</select></td>";
            html +="<td><input type='text' name='precios[]'  style='width:60px;'></td>";

            html +="<td><input type='text' name='cantidades[]' class='cantidadesCompra' value='1' style='width:60px;'></td>";
            html +="<td><input type='hidden' name='importes[]'><p></p></td>";
            html +="<td><button type='button' class='btn btn-danger btn-remove-producto-compra'><span class='fa fa-times'></span></button></td>";
            html +="</tr>"

            $("#tbcompras tbody").append(html);
            //sumarCompra();
            this.value = "";
            return false;

        },
    });

    $("#searchProductoVenta").autocomplete({
        source:function(request, response){
            var sucursal = $("#sucursal-venta").val();
            var bodega = $("#bodega").val();
            $.ajax({
                url: base_url+"movimientos/ventas/getProductos",
                type: "POST",
                dataType:"json",
                data:{ valor: request.term, sucursal_id:sucursal, bodega_id:bodega},
                success:function(data){
                    response(data);
                }
            });
        },
        minLength:2,
        select:function(event, ui){
            html = "<tr>";
            if (Number(ui.item.stock) > 0) {
                html +="<td><input type='hidden' name='idProductos[]' value='"+ui.item.producto_id+"'>"+ui.item.codigo_barras+"</td>";
            }else{
                html +="<td>"+ui.item.codigo_barras+"</td>";
            }
            
            html +="<td><a href='#modal-image' data-toggle='modal' class='show-image' data-href='"+ui.item.nombre+"*"+ui.item.imagen+"'><img src='"+base_url+"assets/imagenes_productos/"+ui.item.imagen+"' class='img-responsive' style='width:50px;'></a></td>";
            html +="<td><a href='#modal-info-producto' data-toggle='modal' data-href='"+ui.item.producto_id+"' class='btn-info-producto'>"+ui.item.nombre+"</a></td>";
            html +="<td>"+ui.item.localizacion+"</td>";
            precios = "<option value=''>Seleccione</option>";
            precio = '';
            cantidad = '';
            var selected = '';
            $.each(ui.item.precios, function(key, value){
                
                if (value.seleccion_venta == "1") {
                    selected = 'selected';
                    precio = value.precio_venta;
                    cantidad = 1;
                }else{
                    selected = '';
                }
                precios += "<option value='"+value.precio_venta+"' "+selected+">"+value.nombre+"</option>";
            });
            html +="<td><select class='form-control' id='preciosVentas'>"+precios+"</select></td>";
            if (Number(ui.item.stock) > 0) {
                html +="<td><input type='text' name='precios[]'  style='width:60px;' value='"+precio+"'></td>";
            }else{
                html +="<td><input type='text' style='width:60px;' value='"+precio+"'></td>";
            }
            
            html +="<td>"+ui.item.stock+"</td>";
            if (Number(ui.item.stock) > 0) {
                html +="<td><input type='text' name='cantidades[]' class='cantidadesVenta' style='width:60px;' value='"+cantidad+"'></td>";
            }else{
                html +="<td><input type='text'  style='width:60px;' value='0' disabled></td>";
            }
            
            importe = 0.00;
            if (precio != '') {
                importe = Number(precio) * Number(cantidad);
            }

            if (Number(ui.item.stock) > 0) {
                html +="<td><input type='hidden' name='importes[]' value='"+importe.toFixed(2)+"'><p>"+importe.toFixed(2)+"</p></td>";
            }else{
                html +="<td><input type='hidden' value='0.00'><p>0.00</p></td>";
            }
            
            html +="<td><button type='button' class='btn btn-danger btn-remove-producto-compra'><span class='fa fa-times'></span></button></td>";
            html +="</tr>"

            $("#tbventas tbody").append(html);
            sumarVenta();
            this.value = "";
            return false;
        },
    });


    
    //autcompletador para productos asociados
    $("#productosA").autocomplete({
        source:function(request, response){
            $.ajax({
                url: base_url+"almacen/productos/getProductos",
                type: "POST",
                dataType:"json",
                data:{ valor: request.term},
                success:function(data){
                    response(data);
                }
            });
        },
        minLength:2,
        select:function(event, ui){

            html =  '<tr>'+
                        '<td><input type="hidden" name="idProductosA[]" value="'+ ui.item.id +'">'+ ui.item.label +'</td>'+
                        '<td><input type="number" name="cantidadesA[]" class="form-control"  value="1" min="1"></td>'+
                        '<td><button type="button" class="btn btn-danger btn-quitarAsociado"><i class="fa fa-times"></i></button></td>'+
                    '</tr>';
            $("#tbAsociados tbody").append(html);
        },
    });

    $(document).on("click", ".btn-agregar-precio", function(){
        if ($("#tipo_precios").val()!="") {
            var value = JSON.parse($("#tipo_precios").val());

            if (verificarExistenciaPrecio(value.id)) {
                swal("Error", "El Tipo de precio seleccionado ya fue agregado", "error");
            }else{
                html =  '<tr>'+
                    '<td><input type="hidden" name="idPrecios[]" value="'+ value.id +'">'+ value.nombre +'</td>'+
                    '<td><input type="text" name="preciosC[]" class="form-control input-xs" required="required"></td>'+
                    '<td><input type="text" name="preciosV[]" class="form-control input-xs" required="required"></td>'+

                    '<td><button type="button" class="btn btn-danger btn-quitarAsociado"><i class="fa fa-times"></i></button></td>'+
                '</tr>';
                $("#tbPrecios tbody").append(html);
            }
        }
    });

    function verificarExistenciaPrecio(idPrecio){
        var existencia = false;
        $('input[name^="idPrecios"]').each(function() {
            if ($(this).val() == idPrecio) {
                existencia = true;
            }
        });
        return existencia;
    }

    $(document).on("click", ".btn-quitarprod", function(){
        data = $(this).val();
        info = data.split("*");
        $("#idOrden").val(info[0]);
        $("#idProducto").val(info[1]);
        $("#cantEliminar").val(info[2]);
        $("#cantEliminar").attr('max',info[2]);
        $("#idPedidoProd").val(info[3]);


    })

    $(document).on("click",".btn-quitarAsociado", function(){
        $(this).closest("tr").remove();
    });
    
    $(document).on("click",".btn-delprod", function(){
        $(this).closest("tr").remove();
    });

    $("#btn-agregar").on("click",function(){
        data = $(this).val();
        if (data !='') {
            infoproducto = data.split("*");
            html = "<tr>";
            html += "<td><input type='hidden' name='idproductos[]' value='"+infoproducto[0]+"'>"+infoproducto[1]+"</td>";
            html += "<td>"+infoproducto[2]+"</td>";
            html += "<td><input type='hidden' name='precios[]' value='"+infoproducto[3]+"'>"+infoproducto[3]+"</td>";
            html += "<td>"+infoproducto[4]+"</td>";
            html += "<td><input type='number' min='0' name='cantidades[]' value='1' class='cantidades'></td>";
            html += "<td><input type='hidden' name='importes[]' value='"+infoproducto[3]+"'><p>"+infoproducto[3]+"</p></td>";
            html += "</tr>";
            $("#tbventas tbody").append(html);
            sumar();
            $("#btn-agregar").val(null);
            $("#producto").val(null);

        }else{
            alertify.error("Seleccione un producto...");
        }
    });

    $(document).on("click",".btn-remove-producto", function(){
        $(this).closest("tr").remove();
        sumar();
    });
    $(document).on("click",".btn-remove-producto", function(){
        $(this).closest("tr").remove();
        sumar();
    });
    $(document).on("keyup mouseup","#tbventas input.cantidades", function(){
        cantidad = Number($(this).val());
        precio = Number($(this).closest("tr").find("td:eq(2)").text());
        stock = Number($(this).closest("tr").find("td:eq(3)").text());

        if (cantidad > stock) {
            $(this).val(stock);
            alertify.error("La cantidad ingresada no debe sobrepasar el stock del producto");
            importe = stock * precio;
            $(this).closest("tr").find("td:eq(5)").children("p").text(importe.toFixed(2));
            $(this).closest("tr").find("td:eq(5)").children("input").val(importe.toFixed(2));
            sumar();
        }
        else{
           
            importe = cantidad * precio;
            $(this).closest("tr").find("td:eq(5)").children("p").text(importe.toFixed(2));
            $(this).closest("tr").find("td:eq(5)").children("input").val(importe.toFixed(2));
            sumar();
        }
    });
    $(document).on("click",".btn-view-venta",function(){
        valor_id = $(this).val();
        $.ajax({
            url: base_url + "movimientos/ventas/view",
            type:"POST",
            dataType:"html",
            data:{id:valor_id},
            success:function(data){
                $("#modal-venta .modal-body").html(data);
            }
        });
    });
    $(document).on("click",".btn-print-pedido",function(){
        $(".contenido-pedido").addClass("impresion");
        $(".contenido-pedido").print(config_print);


    });

    $(document).on("click",".btn-print",function(){
        
        $(".modal-body").print(config_print);


    });
    $(document).on("click",".btn-print-venta",function(){
        $("#modal-venta .modal-body").print(config_print);
    });
    $(document).on("click",".btn-print-cotizador",function(){
        $("#modal-cotizador .modal-body").print(config_print);
    });
    $(document).on("click",".btn-print-cierre",function(){
        $(".contenido").addClass("impresion");
        $(".contenido").print(config_print);
    });

    $(document).on("click",".btn-print-barcode",function(){
        $("#modal-barcode .modal-body").print(config_print);
    });
})

function generarnumero(numero){
    if (numero>= 99999 && numero< 999999) {
        return Number(numero)+1;
    }
    if (numero>= 9999 && numero< 99999) {
        return "0" + (Number(numero)+1);
    }
    if (numero>= 999 && numero< 9999) {
        return "00" + (Number(numero)+1);
    }
    if (numero>= 99 && numero< 999) {
        return "000" + (Number(numero)+1);
    }
    if (numero>= 9 && numero< 99) {
        return "0000" + (Number(numero)+1);
    }
    if (numero < 9 ){
        return "00000" + (Number(numero)+1);
    }
}



function sumar(){
    subtotal = 0;
    $("#tbpago tbody tr").each(function(){
        subtotal = subtotal + Number($(this).find("td:eq(3)").text());
    });

    $("input[name=subtotal]").val(subtotal.toFixed(2));
    porcentaje = Number($("#igv").val());
    igv = subtotal * (porcentaje/100);
    $("input[name=iva]").val(igv.toFixed(2));
    descuento = Number($("input[name=descuento]").val());
    total = subtotal + igv - descuento;
    $("input[name=total]").val(total.toFixed(2));

    $(".subtotal").text(subtotal.toFixed(2));
    $(".iva").text(igv.toFixed(2));
    $(".descuento").text(descuento.toFixed(2));
    $(".total").text(total.toFixed(2));

}
function datagrafico(base_url){
    /*namesMonth= ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Set","Oct","Nov","Dic"];*/
    $.ajax({
        url: base_url + "grafico/getData",
        type:"POST",
        dataType:"json",
        success:function(data){
            var dias = new Array();
            var montos = new Array();
            $.each(data,function(key, value){
                dias.push(value.fecha);
                valor = Number(value.monto);
                montos.push(valor);
            });
            graficar(dias,montos);
        }
    });
}
function datagraficoMeses(base_url,year){
    namesMonth= ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Set","Oct","Nov","Dic"];
    $.ajax({
        url: base_url + "dashboard/getData",
        type:"POST",
        data:{year: year},
        dataType:"json",
        success:function(data){
            var meses = new Array();
            var montos = new Array();
            $.each(data,function(key, value){
                meses.push(namesMonth[value.mes - 1]);
                valor = Number(value.monto);
                montos.push(valor);
            });
            graficarMeses(meses,montos,year);
        }
    });
}

function graficar(dias,montos){
    Highcharts.chart('grafico', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Monto acumulado por ventas diarias'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: dias,
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Monto Acumulado (Quetzales)'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">Monto: </td>' +
            '<td style="padding:0"><b>{point.y:.2f} Quetzales</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        },
        series:{
            dataLabels:{
                enabled:true,
                formatter:function(){
                    return Highcharts.numberFormat(this.y,2)
                }

            }
        }
    },
    series: [{
        name: 'Dias',
        data: montos

    }]
});
}
function graficarMeses(meses,montos,year){
    Highcharts.chart('graficoMeses', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Monto acumulado por las ventas de los meses'
    },
    subtitle: {
        text: 'Año:' + year
    },
    xAxis: {
        categories: meses,
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Monto Acumulado (soles)'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">Monto: </td>' +
            '<td style="padding:0"><b>{point.y:.2f} soles</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        },
        series:{
            dataLabels:{
                enabled:true,
                formatter:function(){
                    return Highcharts.numberFormat(this.y,2)
                }

            }
        }
    },
    series: [{
        name: 'Meses',
        data: montos

    }]
});
}

function descontarStock(id,stock,asociado){
    alert(id + " " +stock + " "+asociado);

    $.ajax({
        url : base_url + "movimientos/ventas/descontarStock",
        type: "POST",
        data: {idproducto:id,stock:stock,asociado:asociado},
        success: function(resp){
            alert(resp);
        }

    });
}

function comprobar(){
    var contador=0;
 
    // Recorremos todos los checkbox para contar los que estan seleccionados
    $("#tborden input[type=checkbox]").each(function(){
        if($(this).is(":checked"))
            contador++;
    });
    totalfilas = $("#tborden tbody tr").length;

    if (totalfilas == contador) {
        $("#estadoPedido").val("1");
    }else{
        $("#estadoPedido").val("0");
    }

} 

function setEstado(){

    sumaValor = 0;
    $(".cantidades").each(function(){
        
        valor = Number($(this).val());
        
        sumaValor = sumaValor + valor;
    });

    sumaPag = Number($("#sumaPag").val());
    sumaCant = Number($("#sumaCant").val());
    totalPag = sumaValor + sumaPag;

    if (sumaCant != totalPag) {
        $("#estadoPedido").val("0");
    }else{
        $("#estadoPedido").val("1");
    }
}


function pad(n, width, z) {
  z = z || '0';
  n = n + '';
  return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
}

function validate(e) {
  var ev = e || window.event;
  var key = ev.keyCode || ev.which;
  key = String.fromCharCode( key );
  var regex = /[0-9]/;
  if( !regex.test(key) ) {
    ev.returnValue = false;
    if(ev.preventDefault) ev.preventDefault();
  }
}

function showCorte(id){
    $.ajax({
        url: base_url + "caja/apertura_cierre/viewCorte/" + id,
        type: "POST",
        success: function(resp){
            $("#modal-corte").modal("show");
            $("#modal-corte .modal-body").html(resp);
        }
    });
}

function showAjuste(id){
        $.ajax({
            url: base_url + "inventario/ajuste/view/" + id,
            type: "POST",
            success: function(resp){
                $("#modal-ajuste").modal("show");
                $("#modal-ajuste .modal-body").html(resp);
            }
        });
    }
<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Ventas extends CI_Controller {

	private $permisos;
	public function __construct(){
		parent::__construct();
		$this->permisos = $this->backend_lib->control();
		$this->load->model("Comun_model");
		$this->load->model("Ventas_model");
	}

	public function index()
	{
		if ($this->session->userdata("sucursal")) {
			$ventas = $this->Comun_model->get_records("ventas","sucursal_id=".$this->session->userdata("sucursal"));
		}else{
			$ventas = $this->Comun_model->get_records("ventas");
		}

		$contenido_interno  = array(
			"permisos" => $this->permisos,
			"ventas" => $ventas,
			"cajas_abiertas" => count($this->Comun_model->get_records("caja","estado=1")), 
		);

		$contenido_externo = array(
			"title" => "ventas", 
			"contenido" => $this->load->view("admin/ventas/list", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);

	}

	public function add(){
		if ($this->session->userdata("sucursal")) {
			$bodegas = $this->Comun_model->get_records("bodega_sucursal","estado=1 and sucursal_id=".$this->session->userdata("sucursal"));
		}else{
			$bodegas = $this->Comun_model->get_records("bodega_sucursal", "estado=1");
		}
		$sucursales = $this->Comun_model->get_records("sucursales");
		foreach ($sucursales as $sucursal) {
			if ($this->Comun_model->get_record("caja","sucursal_id='$sucursal->id' and estado=1")) {
				$sucursalesDisponibles[] = $sucursal;
			}
		}
		$contenido_interno  = array(
			"bodegas" => $bodegas,
			"sucursales" => $sucursalesDisponibles,
			//"permisos" => $this->permisos,
			"comprobantes" => $this->Comun_model->get_records("comprobante_sucursal","estado=1 and sucursal_id=".$this->session->userdata("sucursal")), 
			"proveedores" => $this->Comun_model->get_records("proveedores","estado=1"),
			"tarjetas" => $this->Comun_model->get_records("tarjetas","estado=1"),
			"clientes" => $this->Comun_model->get_records("clientes","estado=1"),
			"years" => $this->Comun_model->get_records("years","estado=1"),
			"marcas" => $this->Comun_model->get_records("marcas","estado='1' ORDER BY nombre"),
			"modelos" => $this->Comun_model->get_records("modelos","estado=1"),
			"permisos" => $this->permisos,
		);
		$contenido_externo = array(
			"title" => "ventas", 

			"contenido" => $this->load->view("admin/ventas/add",$contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function store(){

		$comprobante_id = $this->input->post("comprobante_id");
		$tipo_pago = $this->input->post("tipo_pago");
		$cliente_id = $this->input->post("idcliente");
		$fecha = date("Y-m-d H:i:s");
		$subtotal = $this->input->post("subtotal");
		$descuento = $this->input->post("descuento");
		$iva = $this->input->post("iva");
		$total = $this->input->post("total");
		$sucursal_id = $this->input->post("sucursal_id");
		$bodega_id = $this->input->post("bodega_id");
		$caja = $this->Comun_model->get_record("caja","sucursal_id='$sucursal_id' and estado='1'");
		$comprobante = $this->Comun_model->get_record("comprobante_sucursal","comprobante_id='$comprobante_id' and sucursal_id='$sucursal_id'");

		$idProductos = $this->input->post("idProductos");
		$precios = $this->input->post("precios");
		$cantidades = $this->input->post("cantidades");
		$importes = $this->input->post("importes");

		switch ($tipo_pago) {
			case '1':
				$monto_efectivo = $total;
				$monto_credito = 0;
				$monto_tarjeta = 0;
				$tarjeta_id = 0;
				break;
			case '2':
				$monto_efectivo = 0;
				$monto_credito = 0;
				$monto_tarjeta = $total;
				$tarjeta_id = $this->input->post("tarjeta");
				break;
			case '3':
				
				$monto_credito = 0;
				$monto_tarjeta = $this->input->post("monto_tarjeta");
				$monto_efectivo = $total - $monto_tarjeta;
				$tarjeta_id = $this->input->post("tarjeta");
				break;

			default:
				if (!empty($this->input->post("monto_efectivo"))) {
					$monto_efectivo = $this->input->post("monto_efectivo");
				}else{
					$monto_efectivo = 0;
				}
				
				$monto_tarjeta = 0;
				$monto_credito = $total - $monto_efectivo;
				$tarjeta_id = 0;
				break;
		}

		$data  = array(
			"fecha" => $fecha, 
			"numero_comprobante" => str_pad($comprobante->realizados + 1, 8, "0", STR_PAD_LEFT), 
			"comprobante_id" => $comprobante_id, 
			"subtotal" => $subtotal, 
			"descuento" => $descuento, 
			"iva" => $iva, 
			"total" => $total, 
			"tipo_pago" => $tipo_pago, 
			"cliente_id" => $cliente_id,
			"caja_id" => $caja->id,
			'monto_efectivo' => $monto_efectivo,
			'monto_credito' => $monto_credito,
			'monto_tarjeta' => $monto_tarjeta,
			'tarjeta_id' => $tarjeta_id,
			'bodega_id' => $bodega_id,
			'sucursal_id' => $sucursal_id,
			"estado" => "1"
		);
		$venta = $this->Comun_model->insert("ventas", $data);
		if ($venta) {
			if ($tipo_pago == 4) {
				$this->saveCuentaCobrar($venta);
			}

			$this->saveDetalle($venta->id, $idProductos, $precios, $cantidades, $importes);
			$this->updateStock($bodega_id, $sucursal_id, $idProductos, $cantidades);
			$this->updateComprobante($comprobante);

			$dataVenta = array(
				"venta" => $venta,
				"detalles" => $this->Comun_model->get_records("detalle_venta","venta_id='$venta->id'")
			); 

			$this->load->view("admin/ventas/view",$dataVenta);

			//redirect(base_url()."movimientos/ventas");
		}
		else{
			echo "0";
			/*$this->session->set_flashdata("error","No se pudo guardar la informacion");
			redirect(base_url()."movimientos/ventas/add");*/
		}
		
	}

	protected function updateComprobante($comprobante){
		$dataComprobante = array(
			"realizados" => $comprobante->realizados + 1
		);

		$this->Comun_model->update("comprobante_sucursal","id='$comprobante->id'",$dataComprobante);
	}

	protected function saveDetalle($venta_id, $productos, $precios, $cantidades, $importes){
		for ($i=0; $i < count($productos) ; $i++) { 
			$dataDetalle = array(
				"producto_id" => $productos[$i],
				"venta_id" => $venta_id,
				"cantidad" => $cantidades[$i],
				"precio" =>  $precios[$i],
				"importe" => $importes[$i],
			);
			$this->Comun_model->insert("detalle_venta", $dataDetalle);
		}
	}

	protected function updateStock($bodega_id, $sucursal_id, $productos, $cantidades){
		for ($i=0; $i < count($productos) ; $i++) { 
			$bsp = $this->Comun_model->get_record("bodega_sucursal_producto","bodega_id='$bodega_id' and sucursal_id='$sucursal_id' and producto_id='$productos[$i]'");
			$data = array(
				"stock" => $bsp->stock - $cantidades[$i] 
			);
			$this->Comun_model->update("bodega_sucursal_producto","id='$bsp->id'",$data);
		}
	}

	protected function saveCuentaCobrar($venta){
		$dataCuenta = array(
			"venta_id" => $venta->id,
			"monto" => $venta->monto_credito,
			"fecha" => date("Y-m-d"),
			"estado" => "0"
		);
		$this->Comun_model->insert("cuentas_cobrar", $dataCuenta);
	}


	public function view($id){
		$data  = array(
			"venta" => $this->Comun_model->get_record("ventas", "id=$id"), 
			"detalles" => $this->Comun_model->get_records("detalle_venta", "venta_id='$id'"), 
		);
		$this->load->view("admin/ventas/view",$data);
	}

	public function habilitar($id){
		$data  = array(
			"estado" => "1", 
		);
		$this->Comun_model->update("ventas","id=$id",$data);
		echo "movimientos/ventas";
	}

	public function anular($id){
		$data  = array(
			"estado" => "0", 
		);
		$this->Comun_model->update("ventas","id=$id",$data);
		$this->return_stock($id);
		
		redirect(base_url()."movimientos/ventas");
	}

	protected function return_stock($id){
		$venta = $this->Comun_model->get_record("ventas","id='$id'");
		$detalles = $this->Comun_model->get_records("detalle_venta","venta_id='$id'");
		foreach ($detalles as $detalle) {
			$bsp = $this->Comun_model->get_record("bodega_sucursal_producto","bodega_id='$venta->bodega_id' and sucursal_id='$venta->sucursal_id' and producto_id='$detalle->producto_id'");
			$data = array(
				"stock" => $bsp->stock + $detalle->cantidad
			);

			$this->Comun_model->update("bodega_sucursal_producto","id='$bsp->id'",$data);
		}
	}

	public function getProductos(){
		$valor = $this->input->post("valor");
		$sucursal_id = $this->input->post("sucursal_id");
		$bodega_id = $this->input->post("bodega_id");
		$productos = $this->Ventas_model->getProductos($sucursal_id,$bodega_id, $valor);
		$data = array();
		foreach ($productos as $p) {
			
			$producto = get_record("productos", "id=".$p->producto_id);
			$data[] = array(
				"producto_id" => $p->producto_id,
				"label" => $producto->codigo_barras ." - ".$producto->nombre,
				"nombre" => $producto->nombre,
				"codigo_barras" => $producto->codigo_barras,
				"stock" => $p->stock,
				"precios" => $this->Ventas_model->getPrecios($p->producto_id),
				"imagen" => $producto->imagen,
				"localizacion" => $p->localizacion
			);
		}
		echo json_encode($data);

	}

	public function getBodegasAndComprobantes(){
		$sucursal_id = $this->input->post("idSucursal");
		$bodegas = $this->Comun_model->get_records("bodega_sucursal", "sucursal_id='$sucursal_id' and estado=1");
		$comprobantes = $this->Comun_model->get_records("comprobante_sucursal", "sucursal_id='$sucursal_id' and estado=1 and limite > realizados and fecha_vencimiento_sat >= '".date('Y-m-d')."'");
		$dataBodegas = array();
		foreach ($bodegas as $b) {
			$bodega = get_record("bodegas", "id=".$b->bodega_id);
			$dataBodegas[] = array(
				'bodega_id' => $b->bodega_id,
				'nombre' => $bodega->nombre, 
				'seleccion_ventas' => $bodega->seleccion_ventas, 
			);
		}
		$dataComprobantes = array();
		foreach ($comprobantes as $c) {
			$comprobante = get_record("comprobantes", "id=".$c->comprobante_id);
			$dataComprobantes[] = array(
				'comprobante_id' => $c->comprobante_id,
				'nombre' =>$comprobante->nombre, 
				'seleccion_ventas' =>$comprobante->seleccion_ventas, 
			);
		}
		echo json_encode(array(
			'bodegas' => $dataBodegas,
			"comprobantes" => $dataComprobantes
		));
	}

	public function searchProductos()
	{

		$columns = array( 
                            0 =>'p.codigo_barras', 
                            1=> 'p.imagen',
                            2=> 'p.nombre',
                            3=> 'bsp.stock',
                            4=> 'p.nombre',
                            5=> 'p.nombre',
							6=> 'p.nombre',
							7=> 'p.nombre',
                            8=> 'p.nombre',
							9=> 'p.nombre',
                        );
		$year =$this->input->post("year");
		$marca = $this->input->post("marca");
		$modelo = $this->input->post("modelo");
		$sucursal_id = $this->input->post("sucursal");
		$bodega_id = $this->input->post("bodega");

		$limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  
        $totalData = $this->Ventas_model->allproducts_count($year,$marca,$modelo,$sucursal_id,$bodega_id);
            
        $totalFiltered = $totalData; 
            
        if(empty($this->input->post('search')['value']))
        {            
            $productos = $this->Ventas_model->allproducts($limit,$start,$order,$dir,$year,$marca,$modelo,$sucursal_id,$bodega_id);
        }
        else {
            $search = $this->input->post('search')['value']; 

            $productos =  $this->Ventas_model->products_search($limit,$start,$search,$order,$dir,$year,$marca,$modelo,$sucursal_id,$bodega_id);

            $totalFiltered = $this->Ventas_model->products_search_count($search,$year,$marca,$modelo,$sucursal_id,$bodega_id);
        }

        $data = array();
        if(!empty($productos))
        {
        	foreach ($productos as $p) {
				if ($p->range_year) {
					$year = $p->year_from ."-".$p->year_until; 
				}else{
					$year = $p->year_from;
				}

				$listPrecios = "";
				$precios = $this->Ventas_model->getPrecios($p->id);
				foreach ($precios as $precio) {
					$listPrecios .="<b>".$precio->nombre."</b> - ". $precio->precio_venta."</br>";
				}
			
				$data[] = array(
					"producto_id" => $p->id,
					"nombre" => $p->nombre,
					"codigo_barras" => $p->codigo_barras,
					"stock" => $p->stock,
					"precios" => $this->Ventas_model->getPrecios($p->id),
					"listPrecios" => $listPrecios,
					"imagen" => $p->imagen,
					"localizacion" => $p->localizacion,
					"year" => $year != null ? $year:"Genérico",
					"marca" => $p->marca != null ? $p->marca :"Genérico",
					"modelo" => $p->modelo != null ? $p->modelo:"Genérico",				
				);
			}
        }
          
        $json_data = array(
                    "draw"            => intval($this->input->post('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
	}

	public function searchProductos2(){
		$year =$this->input->post("year");
		$marca = $this->input->post("marca");
		$modelo = $this->input->post("modelo");
		$sucursal_id = $this->input->post("sucursal");
		$bodega_id = $this->input->post("bodega");
		

		$productos = $this->Ventas_model->searchProducto($sucursal_id,$bodega_id,$year,$marca,$modelo);
		$data = array();
		foreach ($productos as $p) {
			if ($p->range_year) {
				$year = $p->year_from ."-".$p->year_until; 
			}else{
				$year = $p->year_from;
			}

			$listPrecios = "";
			$precios = $this->Ventas_model->getPrecios($p->id);
			foreach ($precios as $precio) {
				$listPrecios .="<b>".$precio->nombre."</b> - ". $precio->precio_venta."</br>";
			}
		
			$data[] = array(
				"producto_id" => $p->id,
				"nombre" => $p->nombre,
				"codigo_barras" => $p->codigo_barras,
				"stock" => $p->stock,
				"precios" => $this->Ventas_model->getPrecios($p->id),
				"listPrecios" => $listPrecios,
				"imagen" => $p->imagen,
				"localizacion" => $p->localizacion,
				"year" => $year != null ? $year:"Genérico",
				"marca" => $p->marca != null ? $p->marca :"Genérico",
				"modelo" => $p->modelo != null ? $p->modelo:"Genérico",				
			);
		}
		echo json_encode($data);

	}

	public function getProductoByCode(){
		$codigo_barra = $this->input->post("codigo_barra");
		$bodega_id = $this->input->post("bodega_id");
		$sucursal_id = $this->input->post("sucursal_id");
		$productoEncontrado = $this->Ventas_model->getProductoByCode($codigo_barra,$sucursal_id,$bodega_id);

		if ($productoEncontrado != false) {
			$producto = get_record("productos", "id=".$productoEncontrado->producto_id);
			$data = array(
				"producto_id" => $productoEncontrado->producto_id,
				"nombre" => $producto->nombre,
				"codigo_barras" => $producto->codigo_barras,
				"imagen" => $producto->imagen,
				"stock" => $productoEncontrado->stock,
				"precios" => $this->Ventas_model->getPrecios($productoEncontrado->producto_id),
				"imagen" => $producto->imagen,
				"localizacion" => $productoEncontrado->localizacion
			);
			echo json_encode($data);
		}else{
			echo "0";
		}
	}

	public function getProductosPorParametros()
	{

		$columns = array( 
                            0 =>'id', 
                            1 =>'rnc',
                            2=> 'razon_social',
                            3=> 'id',
                        );
		$bodega = $this->input->post('bodega');
		$sucursal = $this->input->post('sucursal');
		$marca = $this->input->post('marca');
		$year = $this->input->post('year');
		$modelo = $this->input->post('modelo');
		$limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  
        $totalData = $this->Ventas_model->allproducts_count();
            
        $totalFiltered = $totalData; 
            
        if(empty($this->input->post('search')['value']))
        {            
            $productos = $this->Ventas_model->allclients($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value']; 

            $productos =  $this->Ventas_model->clients_search($limit,$start,$search,$order,$dir);

            $totalFiltered = $this->Ventas_model->clients_search_count($search);
        }

        $data = array();
        if(!empty($productos))
        {
            foreach ($productos as $p)
            {
            	$producto = get_record("productos", "id=".$p->producto_id);
                
                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($this->input->post('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
	}

	public function get_modelos(){
		$marca_id = $this->input->post("marca_id");
		$modelos = $this->Comun_model->get_records("modelos", "marca_id='".$marca_id."' ORDER BY nombre");
		echo json_encode($modelos);
	}

	public function infoProducto($producto_id){
		$data  = array(
			"producto" => $this->Comun_model->get_record("productos", "id=$producto_id"), 
			"existencias" => $this->Ventas_model->getExistenciasProducto($producto_id)
		);
		$this->load->view("admin/ventas/infoProducto",$data);
	}

	public function savecliente(){
		$nombres = $this->input->post("nombres");
		$apellidos = $this->input->post("apellidos");
		$dpi = $this->input->post("dpi");
		$telefono = $this->input->post("telefono");
		$direccion = $this->input->post("direccion");
		$nit = $this->input->post("nit");
		$this->form_validation->set_rules("nombres","Nombres","required");
		if (!empty($dpi)) {
			$this->form_validation->set_rules("dpi","DPI","is_unique[clientes.cedula]");
		}
		
		if (!empty($nit)) {
			$this->form_validation->set_rules("nit","NIT","is_unique[clientes.nit]");
		}

		$cliente = "";
		$error = "";

		if ($this->form_validation->run()==TRUE) {

			$data  = array(
				"nombres" => $nombres, 
				"apellidos" => $apellidos,
				"telefono" => $telefono,
				"direccion" => $direccion,
				"nit" => $nit,
				"cedula" => $dpi,
				"estado" => "1"
			);
			$cliente = $this->Comun_model->insert("clientes", $data);
			if ($cliente) {
				$status = "1";
				
			}
			else{
				$status = "0";
				$error = "No se pudo registrar el cliente";
			}
		}
		else{
			$status = "0";
			$error =  validation_errors();
		}

		echo json_encode(array(
			'status' => $status,
			'error' => $error,
			'cliente' => $cliente,
			'clientes' => $this->Comun_model->get_records('clientes', "estado='1'")
		));
	}

	public function comprobarPassword(){
		$password = sha1($this->input->post("password"));
		$sucursal = $this->session->userdata("sucursal");

		$checkPassword = $this->Comun_model->get_record("usuarios","sucursal_id='$sucursal' && password='$password'");

		if ($checkPassword) {
			echo "1";
		}else{
			echo "0";
		}
	}
}

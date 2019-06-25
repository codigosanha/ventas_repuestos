<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Ventas extends CI_Controller {

	//private $permisos;
	public function __construct(){
		parent::__construct();
		//$this->permisos = $this->backend_lib->control();
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
			//"permisos" => $this->permisos,
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
			$bodegas = $this->Comun_model->get_records("bodega_sucursal","sucursal_id=".$this->session->userdata("sucursal"));
		}else{
			$bodegas = $this->Comun_model->get_records("bodega_sucursal");
		}
		$contenido_interno  = array(
			"bodegas" => $bodegas,
			"sucursales" => $this->Comun_model->get_records("sucursales"),
			//"permisos" => $this->permisos,
			"comprobantes" => $this->Comun_model->get_records("comprobante_sucursal","sucursal_id=".$this->session->userdata("sucursal")), 
			"proveedores" => $this->Comun_model->get_records("proveedores"),
			"tarjetas" => $this->Comun_model->get_records("tarjetas"),
			"clientes" => $this->Comun_model->get_records("clientes"),
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

			redirect(base_url()."movimientos/ventas");
		}
		else{
			$this->session->set_flashdata("error","No se pudo guardar la informacion");
			redirect(base_url()."movimientos/ventas/add");
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

	public function deshabilitar($id){
		$data  = array(
			"estado" => "0", 
		);
		$this->Comun_model->update("ventas","id=$id",$data);
		echo "movimientos/ventas";
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
			);
		}
		echo json_encode($data);

	}

	public function getBodegasAndComprobantes(){
		$sucursal_id = $this->input->post("idSucursal");
		$bodegas = $this->Comun_model->get_records("bodega_sucursal", "sucursal_id='$sucursal_id'");
		$comprobantes = $this->Comun_model->get_records("comprobante_sucursal", "sucursal_id='$sucursal_id'");
		$dataBodegas = array();
		foreach ($bodegas as $b) {
			$dataBodegas[] = array(
				'bodega_id' => $b->bodega_id,
				'nombre' => get_record("bodegas", "id=".$b->bodega_id)->nombre, 
			);
		}
		$dataComprobantes = array();
		foreach ($comprobantes as $c) {
			$dataComprobantes[] = array(
				'comprobante_id' => $c->comprobante_id,
				'nombre' => get_record("comprobantes", "id=".$c->comprobante_id)->nombre, 
			);
		}
		echo json_encode(array(
			'bodegas' => $dataBodegas,
			"comprobantes" => $dataComprobantes
		));
	}
}

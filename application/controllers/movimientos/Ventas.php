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
		$serie = $this->input->post("serie");
		$numero_comprobante = $this->input->post("numero_comprobante");
		$fecha = $this->input->post("fecha");
		$proveedor_id = $this->input->post("proveedor_id");
		$subtotal = $this->input->post("subtotal");
		$total = $this->input->post("total");
		$sucursal_id = $this->input->post("sucursal_id");
		$bodega_id = $this->input->post("bodega_id");

		$idProductos = $this->input->post("idProductos");
		$precios = $this->input->post("precios");
		$cantidades = $this->input->post("cantidades");
		$importes = $this->input->post("importes");

		$data  = array(
			"fecha" => $fecha, 
			"serie" => $serie, 
			"numero_comprobante" => $numero_comprobante, 
			"comprobante_id" => $comprobante_id, 
			"subtotal" => $subtotal, 
			"total" => $total, 
			"tipo_pago" => $tipo_pago, 
			"proveedor_id" => $proveedor_id,
			"sucursal_id" => $sucursal_id,
			"estado" => "1"
		);
		$compra = $this->Comun_model->insert("ventas", $data);
		if ($compra) {
			if ($tipo_pago == 2) {
				$this->saveCuentaPagar($compra);
			}

			$this->saveDetalle($compra->id, $idProductos, $precios, $cantidades, $importes);
			$this->updateStock($bodega_id, $sucursal_id, $idProductos, $cantidades);

			redirect(base_url()."movimientos/ventas");
		}
		else{
			$this->session->set_flashdata("error","No se pudo guardar la informacion");
			redirect(base_url()."movimientos/ventas/add");
		}
		
	}

	protected function saveDetalle($compra_id, $productos, $precios, $cantidades, $importes){
		for ($i=0; $i < count($productos) ; $i++) { 
			$dataDetalle = array(
				"producto_id" => $productos[$i],
				"compra_id" => $compra_id,
				"cantidad" => $cantidades[$i],
				"precio" =>  $precios[$i],
				"importe" => $importes[$i],
			);
			$this->Comun_model->insert("detalle_compra", $dataDetalle);
		}
	}

	protected function updateStock($bodega_id, $sucursal_id, $productos, $cantidades){
		for ($i=0; $i < count($productos) ; $i++) { 
			$bsp = $this->Comun_model->get_record("bodega_sucursal_producto","bodega_id='$bodega_id' and sucursal_id='$sucursal_id' and producto_id='$productos[$i]'");
			$data = array(
				"stock" => $bsp->stock + $cantidades[$i] 
			);
			$this->Comun_model->update("bodega_sucursal_producto","id='$bsp->id'",$data);
		}
	}

	protected function saveCuentaPagar($compra){
		$dataCuenta = array(
			"compra_id" => $compra->id,
			"monto" => $compra->total,
			"fecha" => date("Y-m-d"),
			"estado" => "0"
		);
		$this->Comun_model->insert("cuentas_pagar", $dataCuenta);
	}


	public function view($id){
		$data  = array(
			"compra" => $this->Comun_model->get_record("ventas", "id=$id"), 
			"detalles" => $this->Comun_model->get_records("detalle_compra", "compra_id='$id'"), 
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
		$productos = $this->Compras_model->getProductos($sucursal_id,$bodega_id, $valor);
		$data = array();
		foreach ($productos as $p) {
			$producto = get_record("productos", "id=".$p->producto_id);
			$data[] = array(
				"producto_id" => $p->producto_id,
				"label" => $producto->codigo_barras ." - ".$producto->nombre,
				"nombre" => $producto->nombre,
				"codigo_barras" => $producto->codigo_barras,
				"stock" => $p->stock,
				"precios" => $this->Compras_model->getPrecios($p->producto_id),
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

<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Compras extends CI_Controller {

	private $permisos;
	public function __construct(){
		parent::__construct();
		$this->permisos = $this->backend_lib->control();
		$this->load->model("Comun_model");
		$this->load->model("Compras_model");
	}

	public function index()
	{
		$contenido_interno  = array(
			"permisos" => $this->permisos,
			"compras" => $this->Comun_model->get_records("compras"), 
		);

		$contenido_externo = array(
			"title" => "Compras", 
			"contenido" => $this->load->view("admin/compras/list", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);

	}

	public function add(){
		if ($this->session->userdata("sucursal")) {
			$bodegas = $this->Comun_model->get_records("bodega_sucursal","estado=1 and sucursal_id=".$this->session->userdata("sucursal"));
		}else{
			$bodegas = $this->Comun_model->get_records("bodega_sucursal","estado=1");
		}
		$contenido_interno  = array(
			"bodegas" => $bodegas,
			"sucursales" => $this->Comun_model->get_records("sucursales","estado=1"),
			//"permisos" => $this->permisos,
			"comprobantes" => $this->Comun_model->get_records("comprobantes","estado=1"), 
			"proveedores" => $this->Comun_model->get_records("proveedores","estado=1"), 
		);
		$contenido_externo = array(
			"title" => "compras", 
			"contenido" => $this->load->view("admin/compras/add",$contenido_interno, TRUE)
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
		$compra = $this->Comun_model->insert("compras", $data);
		if ($compra) {
			if ($tipo_pago == 2) {
				$this->saveCuentaPagar($compra);
			}

			$this->saveDetalle($compra->id, $idProductos, $precios, $cantidades, $importes);
			$this->updateStock($bodega_id, $sucursal_id, $idProductos, $cantidades);

			redirect(base_url()."movimientos/compras");
		}
		else{
			$this->session->set_flashdata("error","No se pudo guardar la informacion");
			redirect(base_url()."movimientos/compras/add");
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
			"compra" => $this->Comun_model->get_record("compras", "id=$id"), 
			"detalles" => $this->Comun_model->get_records("detalle_compra", "compra_id='$id'"), 
		);
		$this->load->view("admin/compras/view",$data);
	}

	public function habilitar($id){
		$data  = array(
			"estado" => "1", 
		);
		$this->Comun_model->update("compras","id=$id",$data);
		echo "movimientos/compras";
	}

	public function deshabilitar($id){
		$data  = array(
			"estado" => "0", 
		);
		$this->Comun_model->update("compras","id=$id",$data);
		echo "movimientos/compras";
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

	public function getProductoByCode(){
		$codigo_barra = $this->input->post("codigo_barra");
		$bodega_id = $this->input->post("bodega_id");
		$sucursal_id = $this->input->post("sucursal_id");
		$productoEncontrado = $this->Compras_model->getProductoByCode($codigo_barra,$sucursal_id,$bodega_id);

		if ($productoEncontrado != false) {
			$producto = get_record("productos", "id=".$productoEncontrado->producto_id);
			$data = array(
				"producto_id" => $productoEncontrado->producto_id,
				"nombre" => $producto->nombre,
				"codigo_barras" => $producto->codigo_barras,
				"imagen" => $producto->imagen,
				"stock" => $productoEncontrado->stock,
				"precios" => $this->Compras_model->getPrecios($productoEncontrado->producto_id),
			);
			echo json_encode($data);
		}else{
			echo "0";
		}
	}
}

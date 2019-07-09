<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Traslados extends CI_Controller {

	//private $permisos;
	public function __construct(){
		parent::__construct();
		//$this->permisos = $this->backend_lib->control();
		$this->load->model("Comun_model");
		$this->load->model("Compras_model");
		
	}

	public function index()
	{
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"traslados" => $this->Comun_model->get_records("traslados"), 
		);

		$contenido_externo = array(
			"title" => "traslados", 
			"contenido" => $this->load->view("admin/traslados/list", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);

	}

	public function add(){
		$contenido_interno = array(
			"sucursales" => $this->Comun_model->get_records("sucursales"),
			"bodegas" => $this->Comun_model->get_records("bodega_sucursal", "sucursal_id=".$this->session->userdata("sucursal")),
		);
		$contenido_externo = array(
			"title" => "traslados", 
			"contenido" => $this->load->view("admin/traslados/add",$contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function store(){

		$sucursal_envio = $this->input->post("sucursal_envio");
		$bodega_envio = $this->input->post("bodega_envio");
		$sucursal_recibe = $this->input->post("sucursal_recibe");
		$bodega_recibe = $this->input->post("bodega_recibe");
		$productos = $this->input->post("idProductos");
		$cantidades = $this->input->post("cantidades");


		$data  = array(
			"sucursal_envio" => $sucursal_envio, 
			"sucursal_recibe" => $sucursal_recibe,
			"bodega_envio" => $bodega_envio, 
			"bodega_recibe" => $bodega_recibe,
			"estado" => "1",
			"usuario_id" => $this->session->userdata("id"),
			"fecha" => date("Y-m-d H:i:s")
		);
		$traslado = $this->Comun_model->insert("traslados", $data);
		if ($traslado) {
			for ($i=0; $i < count($productos); $i++) { 
				$data_traslados = array(
					"producto_id" => $productos[$i],
					"traslado_id" => $traslado->id,
					"cantidad" => $cantidades[$i]
				);
				$this->Comun_model->insert("traslados_productos",$data_traslados);
				$existe_producto_bodega_recibe = $this->Comun_model->get_record("bodega_sucursal_producto","bodega_id='$bodega_recibe' and sucursal_id='$sucursal_recibe' and producto_id='$productos[$i]'");
				if ($existe_producto_bodega_recibe) {
					$data_producto_bodega_recibe = array(
						"stock" => $existe_producto_bodega_recibe->stock + $cantidades[$i]
					);
					$this->Comun_model->update("bodega_sucursal_producto", "id='$existe_producto_bodega_recibe->id'",$data_producto_bodega_recibe);
				}else{
					$data_add_producto_bodega_recibe = array(
						"bodega_id" => $bodega_recibe,
						"sucursal_id" => $sucursal_recibe,
						"producto_id" => $productos[$i],
						"stock" => $cantidades[$i],
					);
					$this->Comun_model->insert("bodega_sucursal_producto", $data_add_producto_bodega_recibe);
				}
				$producto_bodega_envio = $this->Comun_model->get_record("bodega_sucursal_producto","bodega_id='$bodega_envio' and sucursal_id='$sucursal_envio' and producto_id='$productos[$i]'");
				$data_producto_bodega_envio = array(
					"stock" => $producto_bodega_envio->stock - $cantidades[$i]
				);
				$this->Comun_model->update("bodega_sucursal_producto","id='$producto_bodega_envio->id'",$data_producto_bodega_envio);
			}
			redirect(base_url()."inventario/traslados");
		}
		else{
			$this->session->set_flashdata("error","No se pudo guardar la informacion");
			redirect(base_url()."inventario/traslados/add");
		}
		
	}

	public function edit($id){
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"calidad" => $this->Comun_model->get_record("traslados","id=$id"), 
		);

		$contenido_externo = array(
			"title" => "traslados", 
			"contenido" => $this->load->view("admin/traslados/edit", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function update(){
		$idCalidad = $this->input->post("idCalidad");
		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");

		$sucursalActual = $this->Comun_model->get_record("traslados","id=$idCalidad");

		if ($nombre == $sucursalActual->nombre) {
			$is_unique_nombre = "";
		}else{
			$is_unique_nombre = "|is_unique[traslados.nombre]";
		}

		$this->form_validation->set_rules("nombre","Nombre","required".$is_unique_nombre);

		if ($this->form_validation->run()==TRUE) {
			$data = array(
				"nombre" => $nombre,
				"descripcion" => $descripcion,
			);

			if ($this->Comun_model->update("traslados","id=$idCalidad",$data)) {
				redirect(base_url()."inventario/traslados");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."inventario/traslados/edit/".$idCalidad);
			}
		}else{
			$this->edit($idCalidad);
		}

		
	}

	public function view($id){
		$data  = array(
			"traslado" => $this->Comun_model->get_record("traslados", "id=$id"),
			"productos" => $this->Comun_model->get_records("traslados_productos","traslado_id='$id'") 
		);
		$this->load->view("admin/traslados/view",$data);
	}

	public function habilitar($id){
		$data  = array(
			"estado" => "1", 
		);
		$this->Comun_model->update("traslados","id=$id",$data);
		//echo "inventario/traslados";
		redirect(base_url()."inventario/traslados");
	}

	public function deshabilitar($id){
		$data  = array(
			"estado" => "0", 
		);
		$this->Comun_model->update("traslados","id=$id",$data);
		$traslado = $this->Comun_model->get_record("traslados","id='$id'");
		$productos = $this->Comun_model->get_records("traslados_productos","traslado_id='$id'");
		foreach ($productos as $p) {
			$bodega_recibe = $this->Comun_model->get_record("bodega_sucursal_producto","bodega_id='$traslado->bodega_recibe' and sucursal_id='$traslado->sucursal_recibe' and producto_id='$p->producto_id'");
			$dataBodegaRecibe = array(
				"stock" => $bodega_recibe->stock - $p->cantidad
			);	
			$this->Comun_model->update("bodega_sucursal_producto","id='$bodega_recibe->id'",$dataBodegaRecibe);
			$bodega_envio = $this->Comun_model->get_record("bodega_sucursal_producto","bodega_id='$traslado->bodega_envio' and sucursal_id='$traslado->sucursal_envio' and producto_id='$p->producto_id'");
			$dataBodegaEnvio = array(
				"stock" => $bodega_envio->stock + $p->cantidad
			);	
			$this->Comun_model->update("bodega_sucursal_producto","id='$bodega_envio->id'",$dataBodegaEnvio);
		}
		//echo "inventario/traslados";
		redirect(base_url()."inventario/traslados");
	}

	public function getBodegas(){
		$sucursal_id = $this->input->post("idSucursal");
		$bodegas = $this->Comun_model->get_records("bodega_sucursal", "sucursal_id='$sucursal_id'");
		$data = array();
		foreach ($bodegas as $b) {
			$data[] = array(
				"bodega_id" => $b->bodega_id,
				"nombre" => get_record("bodegas","id=".$b->bodega_id)->nombre
			);
		}
		echo json_encode($data);
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
}

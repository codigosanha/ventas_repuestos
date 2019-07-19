<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Productos extends CI_Controller {

	//private $permisos;
	public function __construct(){
		parent::__construct();
		//$this->permisos = $this->backend_lib->control();
		$this->load->model("Comun_model");
		
	}

	public function index()
	{
		if ($this->session->userdata("sucursal")) {
			$bodegas = $this->Comun_model->get_records("bodega_sucursal","sucursal_id=".$this->session->userdata("sucursal"));
		}else{
			$bodegas = $this->Comun_model->get_records("bodega_sucursal");
		}

		if ($this->session->userdata("sucursal")) {
			$productos = $this->Comun_model->get_records("bodega_sucursal_producto","sucursal_id=".$this->session->userdata("sucursal"));
		}else{
			$productos = $this->Comun_model->get_records("bodega_sucursal_producto");
		}
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"bodegas" => $bodegas,
			"productos" => $productos,
			"sucursales" => $this->Comun_model->get_records("sucursales")
		);

		$contenido_externo = array(
			"title" => "Productos", 
			"contenido" => $this->load->view("admin/inventario_productos/list", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);

	}

	public function add(){
		if ($this->session->userdata("sucursal")) {
			$bodegas = $this->Comun_model->get_records("bodega_sucursal","sucursal_id=".$this->session->userdata("sucursal"));
		}else{
			$bodegas = $this->Comun_model->get_records("bodega_sucursal");
		}

		if ($this->session->userdata("sucursal")) {
			$productos = $this->Comun_model->get_records("bodega_sucursal_producto","sucursal_id=".$this->session->userdata("sucursal"));
		}else{
			$productos = $this->Comun_model->get_records("bodega_sucursal_producto");
		}
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"bodegas" => $bodegas,
			"productos" => $this->Comun_model->get_records("productos"),
			"sucursales" =>  $this->Comun_model->get_records("sucursales")
		);
		$contenido_externo = array(
			"title" => "calidades", 
			"contenido" => $this->load->view("admin/inventario_productos/add",$contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function store(){

		$bodega_id = $this->input->post("bodega_id");
		$sucursal_id = $this->input->post("sucursal_id");
		$idProductos = $this->input->post("idProductos");

		for ($i=0; $i < count($idProductos); $i++) { 
			$existe_producto = $this->Comun_model->get_record("bodega_sucursal_producto","bodega_id='$bodega_id' and sucursal_id='$sucursal_id' and producto_id='$idProductos[$i]'");
			if (!$existe_producto) {
				$data  = array(
					"bodega_id" => $bodega_id, 
					"sucursal_id" => $sucursal_id,
					"producto_id" => $idProductos[$i],
					"estado" => "1"
				);
				$this->Comun_model->insert("bodega_sucursal_producto",$data);		
			}
		}

		redirect(base_url()."inventario/productos");

	}

	public function edit($id){
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"producto" => $this->Comun_model->get_record("bodega_sucursal_producto","id=$id"), 
		);

		$contenido_externo = array(
			"title" => "Productos", 
			"contenido" => $this->load->view("admin/inventario_productos/edit", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function update(){
		$idProducto = $this->input->post("idProducto");
		$localizacion = $this->input->post("localizacion");
	
		$data = array(
			"localizacion" => $localizacion,
		);

		if ($this->Comun_model->update("bodega_sucursal_producto","id=$idProducto",$data)) {
			redirect(base_url()."inventario/productos");
		}
		else{
			$this->session->set_flashdata("error","No se pudo actualizar la informacion");
			redirect(base_url()."inventario/productos/edit/".$idProducto);
		}
	}

	public function view($id){
		$data  = array(
			"calidad" => $this->Comun_model->get_record("calidades", "id=$id"), 
		);
		$this->load->view("admin/inventario_productos/view",$data);
	}

	public function habilitar($id){
		$data  = array(
			"estado" => "1", 
		);
		$this->Comun_model->update("bodega_sucursal_producto","id=$id",$data);
		redirect(base_url()."inventario/productos");
	}

	public function deshabilitar($id){
		$data  = array(
			"estado" => "0", 
		);
		$this->Comun_model->update("bodega_sucursal_producto","id=$id",$data);
		redirect(base_url()."inventario/productos");
	}

	public function getBodegas(){
		$sucursal_id = $this->input->post("idSucursal");
		$bodegas = $this->Comun_model->get_records("bodega_sucursal", "sucursal_id='$sucursal_id' and estado=1");
		$data = array();
		foreach ($bodegas as $b) {
			$data[] = array(
				'bodega_id' => $b->bodega_id,
				'nombre' => get_record("bodegas", "id=".$b->bodega_id)->nombre, 
			);
		}
		echo json_encode($data);
	}

	public function getProductos(){
		$sucursal_id = $this->input->post("idSucursal");
		$bodega_id = $this->input->post("idBodega");
		$productos = $this->Comun_model->get_records("bodega_sucursal_producto","sucursal_id='$sucursal_id' and bodega_id='$bodega_id'");
		$data = array();
		foreach ($productos as $p) {
			$data[] = array(
				"producto_id" => $p->producto_id,
				"nombre" => get_record("productos", "id=".$p->producto_id)->nombre
			);
		}
		echo json_encode($data);

	}
}

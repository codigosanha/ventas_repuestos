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

		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");
		$this->form_validation->set_rules("nombre","Nombre","required|is_unique[calidades.nombre]");

		if ($this->form_validation->run()==TRUE) {

			$data  = array(
				"nombre" => $nombre, 
				"descripcion" => $descripcion,
				"estado" => "1"
			);

			if ($this->Comun_model->insert("calidades", $data)) {
				redirect(base_url()."inventario/productos");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."inventario/productos/add");
			}
		}
		else{
			$this->add();
		}
	}

	public function edit($id){
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"calidad" => $this->Comun_model->get_record("calidades","id=$id"), 
		);

		$contenido_externo = array(
			"title" => "calidades", 
			"contenido" => $this->load->view("admin/inventario_productos/edit", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function update(){
		$idCalidad = $this->input->post("idCalidad");
		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");

		$sucursalActual = $this->Comun_model->get_record("calidades","id=$idCalidad");

		if ($nombre == $sucursalActual->nombre) {
			$is_unique_nombre = "";
		}else{
			$is_unique_nombre = "|is_unique[calidades.nombre]";
		}

		$this->form_validation->set_rules("nombre","Nombre","required".$is_unique_nombre);

		if ($this->form_validation->run()==TRUE) {
			$data = array(
				"nombre" => $nombre,
				"descripcion" => $descripcion,
			);

			if ($this->Comun_model->update("calidades","id=$idCalidad",$data)) {
				redirect(base_url()."inventario/productos");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."inventario/productos/edit/".$idCalidad);
			}
		}else{
			$this->edit($idCalidad);
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
		$this->Comun_model->update("calidades","id=$id",$data);
		echo "inventario/productos";
	}

	public function deshabilitar($id){
		$data  = array(
			"estado" => "0", 
		);
		$this->Comun_model->update("calidades","id=$id",$data);
		echo "inventario/productos";
	}

	public function getBodegas(){
		$sucursal_id = $this->input->post("idSucursal");
		$bodegas = $this->Comun_model->get_records("bodega_sucursal", "sucursal_id='$sucursal_id'");
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

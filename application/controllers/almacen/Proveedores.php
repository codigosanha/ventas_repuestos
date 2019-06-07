<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Proveedores extends CI_Controller {

	//private $permisos;
	public function __construct(){
		parent::__construct();
		//$this->permisos = $this->backend_lib->control();
		$this->load->model("Comun_model");
		
	}

	public function index()
	{
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"proveedores" => $this->Comun_model->get_records("proveedores"), 
		);

		$contenido_externo = array(
			"title" => "proveedores", 
			"contenido" => $this->load->view("admin/proveedores/list", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);

	}

	public function add(){
		$contenido_externo = array(
			"title" => "proveedores", 
			"contenido" => $this->load->view("admin/proveedores/add","", TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function store(){

		$nombre = $this->input->post("nombre");
		$nit = $this->input->post("nit");
		$direccion = $this->input->post("direccion");
		$telefono = $this->input->post("telefono");
		$email = $this->input->post("email");
		$this->form_validation->set_rules("nombre","Nombre","required|is_unique[proveedores.nombre]");
		$this->form_validation->set_rules("nit","NIT","required|is_unique[proveedores.nit]");

		if ($this->form_validation->run()==TRUE) {

			$data  = array(
				"nombre" => $nombre, 
				"nit" => $nit, 
				"direccion" => $direccion, 
				"telefono" => $telefono, 
				"email" => $email, 
				"estado" => "1"
			);

			if ($this->Comun_model->insert("proveedores", $data)) {
				redirect(base_url()."almacen/proveedores");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."almacen/proveedores/add");
			}
		}
		else{
			$this->add();
		}
	}

	public function edit($id){
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"proveedor" => $this->Comun_model->get_record("proveedores","id=$id"), 
		);

		$contenido_externo = array(
			"title" => "proveedores", 
			"contenido" => $this->load->view("admin/proveedores/edit", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function update(){
		$idProveedor = $this->input->post("idProveedor");
		$nombre = $this->input->post("nombre");
		$nit = $this->input->post("nit");
		$direccion = $this->input->post("direccion");
		$telefono = $this->input->post("telefono");
		$email = $this->input->post("email");
		$proveedorActual = $this->Comun_model->get_record("proveedores","id=$idProveedor");

		if ($nombre == $proveedorActual->nombre) {
			$is_unique_nombre = "";
		}else{
			$is_unique_nombre = "|is_unique[proveedores.nombre]";
		}

		if ($nit == $proveedorActual->nit) {
			$is_unique_nit = "";
		}else{
			$is_unique_nit = "|is_unique[proveedores.nit]";
		}


		$this->form_validation->set_rules("nombre","Nombre","required".$is_unique_nombre);
		$this->form_validation->set_rules("nit","NIT","required".$is_unique_nit);

		if ($this->form_validation->run()==TRUE) {
			$data = array(
				"nombre" => $nombre, 
				"nit" => $nit, 
				"direccion" => $direccion, 
				"telefono" => $telefono, 
				"email" => $email, 
			);

			if ($this->Comun_model->update("proveedores","id=$idProveedor",$data)) {
				redirect(base_url()."almacen/proveedores");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."almacen/proveedores/edit/".$idProveedor);
			}
		}else{
			$this->edit($idProveedor);
		}

		
	}

	public function view($id){
		$data  = array(
			"proveedor" => $this->Comun_model->get_record("proveedores", "id=$id"), 
		);
		$this->load->view("admin/proveedores/view",$data);
	}

	public function habilitar($id){
		$data  = array(
			"estado" => "1", 
		);
		$this->Comun_model->update("proveedores","id=$id",$data);
		echo "almacen/proveedores";
	}

	public function deshabilitar($id){
		$data  = array(
			"estado" => "0", 
		);
		$this->Comun_model->update("proveedores","id=$id",$data);
		echo "almacen/proveedores";
	}
}

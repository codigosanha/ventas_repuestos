<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Tipo_precios extends CI_Controller {

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
			"precios" => $this->Comun_model->get_records("precios"), 
		);

		$contenido_externo = array(
			"title" => "precios", 
			"contenido" => $this->load->view("admin/tipo_precios/list", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);

	}

	public function add(){
		$contenido_externo = array(
			"title" => "precios", 
			"contenido" => $this->load->view("admin/tipo_precios/add","", TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function store(){

		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");
		$this->form_validation->set_rules("nombre","Nombre","required|is_unique[precios.nombre]");

		if ($this->form_validation->run()==TRUE) {

			$data  = array(
				"nombre" => $nombre, 
				"descripcion" => $descripcion,
				"estado" => "1"
			);

			if ($this->Comun_model->insert("precios", $data)) {
				redirect(base_url()."almacen/tipo_precios");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."almacen/tipo_precios/add");
			}
		}
		else{
			$this->add();
		}
	}

	public function edit($id){
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"precio" => $this->Comun_model->get_record("precios","id=$id"), 
		);

		$contenido_externo = array(
			"title" => "precios", 
			"contenido" => $this->load->view("admin/tipo_precios/edit", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function update(){
		$idPrecio = $this->input->post("idPrecio");
		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");

		$sucursalActual = $this->Comun_model->get_record("precios","id=$idPrecio");

		if ($nombre == $sucursalActual->nombre) {
			$is_unique_nombre = "";
		}else{
			$is_unique_nombre = "|is_unique[precios.nombre]";
		}

		$this->form_validation->set_rules("nombre","Nombre","required".$is_unique_nombre);

		if ($this->form_validation->run()==TRUE) {
			$data = array(
				"nombre" => $nombre,
				"descripcion" => $descripcion,
			);

			if ($this->Comun_model->update("precios","id=$idPrecio",$data)) {
				redirect(base_url()."almacen/tipo_precios");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."almacen/tipo_precios/edit/".$idPrecio);
			}
		}else{
			$this->edit($idPrecio);
		}

		
	}

	public function view($id){
		$data  = array(
			"precio" => $this->Comun_model->get_record("precios", "id=$id"), 
		);
		$this->load->view("admin/tipo_precios/view",$data);
	}

	public function habilitar($id){
		$data  = array(
			"estado" => "1", 
		);
		$this->Comun_model->update("precios","id=$id",$data);
		//echo "almacen/tipo_precios";
		redirect(base_url()."almacen/tipo_precios");
	}

	public function deshabilitar($id){
		$data  = array(
			"estado" => "0", 
		);
		$this->Comun_model->update("precios","id=$id",$data);
		//echo "almacen/tipo_precios";
		redirect(base_url()."almacen/tipo_precios");
	}
}

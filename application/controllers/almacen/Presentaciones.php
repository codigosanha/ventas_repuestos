<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Presentaciones extends CI_Controller {

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
			"presentaciones" => $this->Comun_model->get_records("presentaciones"), 
		);

		$contenido_externo = array(
			"title" => "presentaciones", 
			"contenido" => $this->load->view("admin/presentaciones/list", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);

	}

	public function add(){
		$contenido_externo = array(
			"title" => "presentaciones", 
			"contenido" => $this->load->view("admin/presentaciones/add","", TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function store(){

		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");
		$this->form_validation->set_rules("nombre","Nombre","required|is_unique[presentaciones.nombre]");

		if ($this->form_validation->run()==TRUE) {

			$data  = array(
				"nombre" => $nombre, 
				"descripcion" => $descripcion,
				"estado" => "1"
			);

			if ($this->Comun_model->insert("presentaciones", $data)) {
				redirect(base_url()."almacen/presentaciones");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."almacen/presentaciones/add");
			}
		}
		else{
			$this->add();
		}
	}

	public function edit($id){
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"presentacion" => $this->Comun_model->get_record("presentaciones","id=$id"), 
		);

		$contenido_externo = array(
			"title" => "presentaciones", 
			"contenido" => $this->load->view("admin/presentaciones/edit", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function update(){
		$idPresentacion = $this->input->post("idPresentacion");
		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");

		$sucursalActual = $this->Comun_model->get_record("presentaciones","id=$idPresentacion");

		if ($nombre == $sucursalActual->nombre) {
			$is_unique_nombre = "";
		}else{
			$is_unique_nombre = "|is_unique[presentaciones.nombre]";
		}

		$this->form_validation->set_rules("nombre","Nombre","required".$is_unique_nombre);

		if ($this->form_validation->run()==TRUE) {
			$data = array(
				"nombre" => $nombre,
				"descripcion" => $descripcion,
			);

			if ($this->Comun_model->update("presentaciones","id=$idPresentacion",$data)) {
				redirect(base_url()."almacen/presentaciones");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."almacen/presentaciones/edit/".$idPresentacion);
			}
		}else{
			$this->edit($idPresentacion);
		}

		
	}

	public function view($id){
		$data  = array(
			"presentacion" => $this->Comun_model->get_record("presentaciones", "id=$id"), 
		);
		$this->load->view("admin/presentaciones/view",$data);
	}

	public function habilitar($id){
		$data  = array(
			"estado" => "1", 
		);
		$this->Comun_model->update("presentaciones","id=$id",$data);
		echo "almacen/presentaciones";
	}

	public function deshabilitar($id){
		$data  = array(
			"estado" => "0", 
		);
		$this->Comun_model->update("presentaciones","id=$id",$data);
		echo "almacen/presentaciones";
	}
}

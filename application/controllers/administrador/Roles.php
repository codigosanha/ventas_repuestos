<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Roles extends CI_Controller {

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
			"roles" => $this->Comun_model->get_records("roles"), 
		);

		$contenido_externo = array(
			"title" => "roles", 
			"contenido" => $this->load->view("admin/roles/list", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);

	}

	public function add(){
		$contenido_externo = array(
			"title" => "roles", 
			"contenido" => $this->load->view("admin/roles/add","", TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function store(){

		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");
		if ($this->input->post("total_access")) {
			$total_access = "1";
		}else{
			$total_access = "0";
		}
		
		$this->form_validation->set_rules("nombre","Nombre","required|is_unique[roles.nombre]");

		if ($this->form_validation->run()==TRUE) {

			$data  = array(
				"nombre" => $nombre, 
				"descripcion" => $descripcion,
				"total_access" => $total_access,
				"estado" => "1"
			);

			if ($this->Comun_model->insert("roles", $data)) {
				redirect(base_url()."administrador/roles");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."administrador/roles/add");
			}
		}
		else{
			$this->add();
		}
	}

	public function edit($id){
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"rol" => $this->Comun_model->get_record("roles","id=$id"), 
		);

		$contenido_externo = array(
			"title" => "roles", 
			"contenido" => $this->load->view("admin/roles/edit", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function update(){
		$idRol = $this->input->post("idRol");
		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");
		if ($this->input->post("total_access")) {
			$total_access = "1";
		}else{
			$total_access = "0";
		}
		$rolActual = $this->Comun_model->get_record("roles","id=$idRol");

		if ($nombre == $rolActual->nombre) {
			$is_unique_nombre = "";
		}else{
			$is_unique_nombre = "|is_unique[roles.nombre]";
		}

		$this->form_validation->set_rules("nombre","Nombre","required".$is_unique_nombre);

		if ($this->form_validation->run()==TRUE) {
			$data = array(
				"nombre" => $nombre,
				"descripcion" => $descripcion,
				"total_access" => $total_access,
			);

			if ($this->Comun_model->update("roles","id=$idRol",$data)) {
				redirect(base_url()."administrador/roles");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."administrador/roles/edit/".$idRol);
			}
		}else{
			$this->edit($idRol);
		}

		
	}

	public function view($id){
		$data  = array(
			"rol" => $this->Comun_model->get_record("roles", "id=$id"), 
		);
		$this->load->view("admin/roles/view",$data);
	}

	public function habilitar($id){
		$data  = array(
			"estado" => "1", 
		);
		$this->Comun_model->update("roles","id=$id",$data);
		echo "administrador/roles";
	}

	public function deshabilitar($id){
		$data  = array(
			"estado" => "0", 
		);
		$this->Comun_model->update("roles","id=$id",$data);
		echo "administrador/roles";
	}
}

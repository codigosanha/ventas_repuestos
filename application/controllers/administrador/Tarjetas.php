<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Tarjetas extends CI_Controller {

	private $permisos;
	public function __construct(){
		parent::__construct();
		$this->permisos = $this->backend_lib->control();
		$this->load->model("Comun_model");
		
	}

	public function index()
	{
		$contenido_interno  = array(
			"permisos" => $this->permisos,
			"tarjetas" => $this->Comun_model->get_records("tarjetas"), 
		);

		$contenido_externo = array(
			"title" => "tarjetas", 
			"contenido" => $this->load->view("admin/tarjetas/list", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);

	}

	public function add(){
		$contenido_externo = array(
			"title" => "tarjetas", 
			"contenido" => $this->load->view("admin/tarjetas/add","", TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function store(){

		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");
		$this->form_validation->set_rules("nombre","Nombre","required|is_unique[tarjetas.nombre]");

		if ($this->form_validation->run()==TRUE) {

			$data  = array(
				"nombre" => $nombre, 
				"descripcion" => $descripcion,
				"estado" => "1"
			);

			if ($this->Comun_model->insert("tarjetas", $data)) {
				redirect(base_url()."administrador/tarjetas");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."administrador/tarjetas/add");
			}
		}
		else{
			$this->add();
		}
	}

	public function edit($id){
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"tarjeta" => $this->Comun_model->get_record("tarjetas","id=$id"), 
		);

		$contenido_externo = array(
			"title" => "tarjetas", 
			"contenido" => $this->load->view("admin/tarjetas/edit", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function update(){
		$idTarjjeta = $this->input->post("idTarjjeta");
		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");

		$tarjetaActual = $this->Comun_model->get_record("tarjetas","id=$idTarjjeta");

		if ($nombre == $tarjetaActual->nombre) {
			$is_unique_nombre = "";
		}else{
			$is_unique_nombre = "|is_unique[tarjetas.nombre]";
		}

		$this->form_validation->set_rules("nombre","Nombre","required".$is_unique_nombre);

		if ($this->form_validation->run()==TRUE) {
			$data = array(
				"nombre" => $nombre,
				"descripcion" => $descripcion,
			);

			if ($this->Comun_model->update("tarjetas","id=$idTarjjeta",$data)) {
				redirect(base_url()."administrador/tarjetas");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."administrador/tarjetas/edit/".$idTarjjeta);
			}
		}else{
			$this->edit($idTarjjeta);
		}

		
	}

	public function view($id){
		$data  = array(
			"tarjeta" => $this->Comun_model->get_record("tarjetas", "id=$id"), 
		);
		$this->load->view("admin/tarjetas/view",$data);
	}

	public function habilitar($id){
		$data  = array(
			"estado" => "1", 
		);
		$this->Comun_model->update("tarjetas","id=$id",$data);
		//echo "administrador/tarjetas";
		redirect(base_url()."administrador/tarjetas");
	}

	public function deshabilitar($id){
		$data  = array(
			"estado" => "0", 
		);
		$this->Comun_model->update("tarjetas","id=$id",$data);
		//echo "administrador/tarjetas";
		redirect(base_url()."administrador/tarjetas");
	}
}

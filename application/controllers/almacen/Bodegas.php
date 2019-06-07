<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Bodegas extends CI_Controller {

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
			"bodegas" => $this->Comun_model->get_records("bodegas"), 
		);

		$contenido_externo = array(
			"title" => "Bodegas", 
			"contenido" => $this->load->view("admin/bodegas/list", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);

	}

	public function add(){
		$contenido_externo = array(
			"title" => "Bodegas", 
			"contenido" => $this->load->view("admin/bodegas/add","", TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function store(){

		$nombre = $this->input->post("nombre");
		$this->form_validation->set_rules("nombre","Nombre","required|is_unique[bodegas.nombre]");

		if ($this->form_validation->run()==TRUE) {

			$data  = array(
				"nombre" => $nombre, 
				"estado" => "1"
			);

			if ($this->Comun_model->insert("bodegas", $data)) {
				redirect(base_url()."almacen/bodegas");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."almacen/bodegas/add");
			}
		}
		else{
			$this->add();
		}
	}

	public function edit($id){
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"bodega" => $this->Comun_model->get_record("bodegas","id=$id"), 
		);

		$contenido_externo = array(
			"title" => "bodegas", 
			"contenido" => $this->load->view("admin/bodegas/edit", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function update(){
		$idBodega = $this->input->post("idBodega");
		$nombre = $this->input->post("nombre");

		$sucursalActual = $this->Comun_model->get_record("bodegas","id=$idBodega");

		if ($nombre == $sucursalActual->nombre) {
			$is_unique_nombre = "";
		}else{
			$is_unique_nombre = "|is_unique[bodegas.nombre]";
		}

		$this->form_validation->set_rules("nombre","Nombre","required".$is_unique_nombre);

		if ($this->form_validation->run()==TRUE) {
			$data = array(
				"nombre" => $nombre,
			);

			if ($this->Comun_model->update("bodegas","id=$idBodega",$data)) {
				redirect(base_url()."almacen/bodegas");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."almacen/bodegas/edit/".$idBodega);
			}
		}else{
			$this->edit($idBodega);
		}

		
	}

	public function view($id){
		$data  = array(
			"bodega" => $this->Comun_model->get_record("bodegas", "id=$id"), 
		);
		$this->load->view("admin/bodegas/view",$data);
	}

	public function habilitar($id){
		$data  = array(
			"estado" => "1", 
		);
		$this->Comun_model->update("bodegas","id=$id",$data);
		echo "almacen/bodegas";
	}

	public function deshabilitar($id){
		$data  = array(
			"estado" => "0", 
		);
		$this->Comun_model->update("bodegas","id=$id",$data);
		echo "almacen/bodegas";
	}
}

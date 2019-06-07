<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Years extends CI_Controller {

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
			"years" => $this->Comun_model->get_records("years"), 
		);

		$contenido_externo = array(
			"title" => "years", 
			"contenido" => $this->load->view("admin/years/list", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);

	}

	public function add(){
		$contenido_externo = array(
			"title" => "Años", 
			"contenido" => $this->load->view("admin/years/add","", TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function store(){

		$year = $this->input->post("year");
		$descripcion = $this->input->post("descripcion");
		$this->form_validation->set_rules("year","Nombre","required|is_unique[years.year]");

		if ($this->form_validation->run()==TRUE) {

			$data  = array(
				"year" => $year, 
				"descripcion" => $descripcion,
				"estado" => "1"
			);

			if ($this->Comun_model->insert("years", $data)) {
				redirect(base_url()."almacen/years");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."almacen/years/add");
			}
		}
		else{
			$this->add();
		}
	}

	public function edit($id){
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"año" => $this->Comun_model->get_record("years","id=$id"), 
		);

		$contenido_externo = array(
			"title" => "Años", 
			"contenido" => $this->load->view("admin/years/edit", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function update(){
		$idYear = $this->input->post("idYear");
		$year = $this->input->post("year");
		$descripcion = $this->input->post("descripcion");

		$yearActual = $this->Comun_model->get_record("years","id=$idYear");

		if ($year == $yearActual->year) {
			$is_unique_year = "";
		}else{
			$is_unique_year = "|is_unique[years.year]";
		}

		$this->form_validation->set_rules("year","Año","required".$is_unique_year);

		if ($this->form_validation->run()==TRUE) {
			$data = array(
				"year" => $year,
				"descripcion" => $descripcion,
			);

			if ($this->Comun_model->update("years","id=$idYear",$data)) {
				redirect(base_url()."almacen/years");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."almacen/years/edit/".$idYear);
			}
		}else{
			$this->edit($idAño);
		}

		
	}

	public function view($id){
		$data  = array(
			"year" => $this->Comun_model->get_record("years", "id=$id"), 
		);
		$this->load->view("admin/years/view",$data);
	}

	public function habilitar($id){
		$data  = array(
			"estado" => "1", 
		);
		$this->Comun_model->update("years","id=$id",$data);
		echo "almacen/years";
	}

	public function deshabilitar($id){
		$data  = array(
			"estado" => "0", 
		);
		$this->Comun_model->update("years","id=$id",$data);
		echo "almacen/years";
	}
}

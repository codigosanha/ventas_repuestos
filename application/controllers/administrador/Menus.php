<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Menus extends CI_Controller {

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
			"menus" => $this->Comun_model->get_records("menus"), 
		);

		$contenido_externo = array(
			"title" => "Menús", 
			"contenido" => $this->load->view("admin/menus/list", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);

	}

	public function add(){
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"menus" => $this->Comun_model->get_records("menus","parent=0"), 
		);
		$contenido_externo = array(
			"title" => "menus", 
			"contenido" => $this->load->view("admin/menus/add",$contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function store(){

		$nombre = $this->input->post("nombre");
		$url = $this->input->post("url");
		$icono = $this->input->post("icono");
		$parent = $this->input->post("parent");
		$orden = $this->input->post("orden");

		$this->form_validation->set_rules("nombre","Nombre","required|is_unique[menus.nombre]");
		if ($parent) {
			$this->form_validation->set_rules("url","URL","required|is_unique[menus.url]");
		}

		if ($this->form_validation->run()==TRUE) {

			$data  = array(
				"nombre" => $nombre, 
				"url" => $url,
				"icono" => $icono,
				"parent" => $parent,
				"orden" => $orden,
				"estado" => "1"
			);

			if ($this->Comun_model->insert("menus", $data)) {
				redirect(base_url()."administrador/menus");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."administrador/menus/add");
			}
		}
		else{
			$this->add();
		}
	}

	public function edit($id){
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"menu" => $this->Comun_model->get_record("menus","id=$id"),
			"menus" => $this->Comun_model->get_records("menus","parent=0"), 
		);

		$contenido_externo = array(
			"title" => "menus", 
			"contenido" => $this->load->view("admin/menus/edit", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function update(){
		$idMenu = $this->input->post("idMenu");
		$nombre = $this->input->post("nombre");
		$url = $this->input->post("url");
		$icono = $this->input->post("icono");
		$parent = $this->input->post("parent");
		$orden = $this->input->post("orden");

		$menuActual = $this->Comun_model->get_record("menus","id=$idMenu");

		if ($nombre == $menuActual->nombre) {
			$is_unique_nombre = "";
		}else{
			$is_unique_nombre = "|is_unique[menus.nombre]";
		}
		if ($url == $menuActual->url) {
			$is_unique_url = "";
		}else{
			$is_unique_url = "|is_unique[menus.url]";
		}
		$this->form_validation->set_rules("nombre","Nombre","required".$is_unique_nombre);
		$this->form_validation->set_rules("url","URL","required".$is_unique_url);

		if ($this->form_validation->run()==TRUE) {
			$data = array(
				"nombre" => $nombre, 
				"url" => $url,
				"icono" => $icono,
				"parent" => $parent,
				"orden" => $orden,
			);

			if ($this->Comun_model->update("menus","id=$idMenu",$data)) {
				redirect(base_url()."administrador/menus");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."administrador/menus/edit/".$idMenu);
			}
		}else{
			$this->edit($idMenu);
		}

		
	}

	public function view($id){
		$data  = array(
			"menu" => $this->Comun_model->get_record("menus", "id=$id"), 
		);
		$this->load->view("admin/menus/view",$data);
	}

	public function habilitar($id){
		$data  = array(
			"estado" => "1", 
		);
		$this->Comun_model->update("menus","id=$id",$data);
		echo "administrador/menus";
	}

	public function deshabilitar($id){
		$data  = array(
			"estado" => "0", 
		);
		$this->Comun_model->update("menus","id=$id",$data);
		echo "administrador/menus";
	}
}

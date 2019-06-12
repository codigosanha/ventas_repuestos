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
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"productos" => $this->Comun_model->get_records("productos"), 
		);

		$contenido_externo = array(
			"title" => "productos", 
			"contenido" => $this->load->view("admin/productos/list", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);

	}

	public function add(){
		$contenido_externo = array(
			"title" => "productos", 
			"contenido" => $this->load->view("admin/productos/add","", TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function store(){

		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");
		$this->form_validation->set_rules("nombre","Nombre","required|is_unique[productos.nombre]");

		if ($this->form_validation->run()==TRUE) {

			$data  = array(
				"nombre" => $nombre, 
				"descripcion" => $descripcion,
				"estado" => "1"
			);

			if ($this->Comun_model->insert("productos", $data)) {
				redirect(base_url()."almacen/productos");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."almacen/productos/add");
			}
		}
		else{
			$this->add();
		}
	}

	public function edit($id){
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"producto" => $this->Comun_model->get_record("productos","id=$id"), 
		);

		$contenido_externo = array(
			"title" => "productos", 
			"contenido" => $this->load->view("admin/productos/edit", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function update(){
		$idProducto = $this->input->post("idProducto");
		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");

		$sucursalActual = $this->Comun_model->get_record("productos","id=$idProducto");

		if ($nombre == $sucursalActual->nombre) {
			$is_unique_nombre = "";
		}else{
			$is_unique_nombre = "|is_unique[productos.nombre]";
		}

		$this->form_validation->set_rules("nombre","Nombre","required".$is_unique_nombre);

		if ($this->form_validation->run()==TRUE) {
			$data = array(
				"nombre" => $nombre,
				"descripcion" => $descripcion,
			);

			if ($this->Comun_model->update("productos","id=$idProducto",$data)) {
				redirect(base_url()."almacen/productos");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."almacen/productos/edit/".$idProducto);
			}
		}else{
			$this->edit($idProducto);
		}

		
	}

	public function view($id){
		$data  = array(
			"producto" => $this->Comun_model->get_record("productos", "id=$id"), 
		);
		$this->load->view("admin/productos/view",$data);
	}

	public function habilitar($id){
		$data  = array(
			"estado" => "1", 
		);
		$this->Comun_model->update("productos","id=$id",$data);
		echo "almacen/productos";
	}

	public function deshabilitar($id){
		$data  = array(
			"estado" => "0", 
		);
		$this->Comun_model->update("productos","id=$id",$data);
		echo "almacen/productos";
	}
}

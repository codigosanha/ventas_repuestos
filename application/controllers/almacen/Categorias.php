<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias extends CI_Controller {

	//private $permisos;
	public function __construct(){
		parent::__construct();
		//$this->permisos = $this->backend_lib->control();
		$this->load->model("Comun_model");
		
	}

	public function index()
	{
		$contenido_interno  = array(
			//'permisos' => $this->permisos,
			'categorias' => $this->Comun_model->get_records('categorias'), 
		);

		$contenido_externo = array(
			'title' => 'categorias', 
			'contenido' => $this->load->view("admin/categorias/list", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);

	}

	public function add(){
		$contenido_externo = array(
			'title' => 'Categorias', 
			'contenido' => $this->load->view("admin/categorias/add", '', TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function store(){

		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");
		$this->form_validation->set_rules("nombre","Nombre","required|is_unique[categorias.nombre]");

		if ($this->form_validation->run()==TRUE) {

			$data  = array(
				'nombre' => $nombre, 
				'descripcion' => $descripcion,
				'estado' => "1"
			);

			if ($this->Comun_model->insert('categorias', $data)) {
				redirect(base_url()."almacen/categorias");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."almacen/categorias/add");
			}
		}
		else{
			$this->add();
		}
	}

	public function edit($id){
		$contenido_interno  = array(
			//'permisos' => $this->permisos,
			'categoria' => $this->Comun_model->get_record('categorias',"id=$id"), 
		);

		$contenido_externo = array(
			'title' => 'categorias', 
			'contenido' => $this->load->view("admin/categorias/edit", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function update(){
		$idCategoria = $this->input->post("idCategoria");
		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");

		$sucursalActual = $this->Comun_model->get_record('categorias',"id=$idCategoria");

		if ($nombre == $sucursalActual->nombre) {
			$is_unique_nombre = "";
		}else{
			$is_unique_nombre = "|is_unique[categorias.nombre]";
		}

		$this->form_validation->set_rules("nombre","Nombre","required".$is_unique_nombre);

		if ($this->form_validation->run()==TRUE) {
			$data = array(
				'nombre' => $nombre,
				'descripcion' => $descripcion,
			);

			if ($this->Comun_model->update('categorias',"id=$idCategoria",$data)) {
				redirect(base_url()."almacen/categorias");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."almacen/categorias/edit/".$idCategoria);
			}
		}else{
			$this->edit($idCategoria);
		}

		
	}

	public function view($id){
		$data  = array(
			'categoria' => $this->Comun_model->get_record("categorias", "id=$id"), 
		);
		$this->load->view("admin/categorias/view",$data);
	}

	public function habilitar($id){
		$data  = array(
			'estado' => "1", 
		);
		$this->Comun_model->update("categorias","id=$id",$data);
		echo "almacen/categorias";
	}

	public function deshabilitar($id){
		$data  = array(
			'estado' => "0", 
		);
		$this->Comun_model->update("categorias","id=$id",$data);
		echo "almacen/categorias";
	}
}

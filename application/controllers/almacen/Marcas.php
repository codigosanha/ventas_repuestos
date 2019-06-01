<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marcas extends CI_Controller {

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
			'marcas' => $this->Comun_model->get_records('marcas'), 
		);

		$contenido_externo = array(
			'title' => 'Marcas', 
			'contenido' => $this->load->view("admin/marcas/list", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);

	}

	public function add(){
		$contenido_externo = array(
			'title' => 'Marcas', 
			'contenido' => $this->load->view("admin/marcas/add", '', TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function store(){

		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");
		$this->form_validation->set_rules("nombre","Nombre","required|is_unique[marcas.nombre]");

		if ($this->form_validation->run()==TRUE) {

			$data  = array(
				'nombre' => $nombre, 
				'descripcion' => $descripcion,
				'estado' => "1"
			);

			if ($this->Comun_model->insert('marcas', $data)) {
				redirect(base_url()."almacen/marcas");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."almacen/marcas/add");
			}
		}
		else{
			$this->add();
		}
	}

	public function edit($id){
		$contenido_interno  = array(
			//'permisos' => $this->permisos,
			'marca' => $this->Comun_model->get_record('marcas',"id=$id"), 
		);

		$contenido_externo = array(
			'title' => 'marcas', 
			'contenido' => $this->load->view("admin/marcas/edit", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function update(){
		$idMarca = $this->input->post("idMarca");
		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");

		$marcaActual = $this->Comun_model->get_record('marcas',"id=$idMarca");

		if ($nombre == $marcaActual->nombre) {
			$is_unique_nombre = "";
		}else{
			$is_unique_nombre = "|is_unique[marcas.nombre]";
		}

		$this->form_validation->set_rules("nombre","Nombre","required".$is_unique_nombre);

		if ($this->form_validation->run()==TRUE) {
			$data = array(
				'nombre' => $nombre,
				'descripcion' => $descripcion,
			);

			if ($this->Comun_model->update('marcas',"id=$idMarca",$data)) {
				redirect(base_url()."almacen/marcas");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."almacen/marcas/edit/".$idMarca);
			}
		}else{
			$this->edit($idMarca);
		}

		
	}

	public function view($id){
		$data  = array(
			'marca' => $this->Comun_model->get_record("categorias", "id=$id"), 
		);
		$this->load->view("admin/marcas/view",$data);
	}

	public function habilitar($id){
		$data  = array(
			'estado' => "1", 
		);
		$this->Comun_model->update("categorias","id=$id",$data);
		echo "almacen/marcas";
	}

	public function deshabilitar($id){
		$data  = array(
			'estado' => "0", 
		);
		$this->Comun_model->update("categorias","id=$id",$data);
		echo "almacen/marcas";
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fabricantes extends CI_Controller {

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
			'fabricantes' => $this->Comun_model->get_records('fabricantes'), 
		);

		$contenido_externo = array(
			'title' => 'fabricantes', 
			'contenido' => $this->load->view("admin/fabricantes/list", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);

	}

	public function add(){
		$contenido_externo = array(
			'title' => 'fabricantes', 
			'contenido' => $this->load->view("admin/fabricantes/add", '', TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function store(){

		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");
		$this->form_validation->set_rules("nombre","Nombre","required|is_unique[fabricantes.nombre]");

		if ($this->form_validation->run()==TRUE) {

			$data  = array(
				'nombre' => $nombre, 
				'descripcion' => $descripcion,
				'estado' => "1"
			);

			if ($this->Comun_model->insert('fabricantes', $data)) {
				redirect(base_url()."almacen/fabricantes");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."almacen/fabricantes/add");
			}
		}
		else{
			$this->add();
		}
	}

	public function edit($id){
		$contenido_interno  = array(
			//'permisos' => $this->permisos,
			'fabricante' => $this->Comun_model->get_record('fabricantes',"id=$id"), 
		);

		$contenido_externo = array(
			'title' => 'fabricantes', 
			'contenido' => $this->load->view("admin/fabricantes/edit", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function update(){
		$idFabricante = $this->input->post("idFabricante");
		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");

		$fabricanteActual = $this->Comun_model->get_record('fabricantes',"id=$idFabricante");

		if ($nombre == $fabricanteActual->nombre) {
			$is_unique_nombre = "";
		}else{
			$is_unique_nombre = "|is_unique[fabricantes.nombre]";
		}

		$this->form_validation->set_rules("nombre","Nombre","required".$is_unique_nombre);

		if ($this->form_validation->run()==TRUE) {
			$data = array(
				'nombre' => $nombre,
				'descripcion' => $descripcion,
			);

			if ($this->Comun_model->update('fabricantes',"id=$idFabricante",$data)) {
				redirect(base_url()."almacen/fabricantes");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."almacen/fabricantes/edit/".$idFabricante);
			}
		}else{
			$this->edit($idFabricante);
		}

		
	}

	public function view($id){
		$data  = array(
			'fabricante' => $this->Comun_model->get_record("fabricantes", "id=$id"), 
		);
		$this->load->view("admin/fabricantes/view",$data);
	}

	public function habilitar($id){
		$data  = array(
			'estado' => "1", 
		);
		$this->Comun_model->update("fabricantes","id=$id",$data);
		echo "almacen/fabricantes";
	}

	public function deshabilitar($id){
		$data  = array(
			'estado' => "0", 
		);
		$this->Comun_model->update("fabricantes","id=$id",$data);
		echo "almacen/fabricantes";
	}
}

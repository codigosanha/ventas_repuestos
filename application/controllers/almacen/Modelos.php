<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modelos extends CI_Controller {

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
			'modelos' => $this->Comun_model->get_records('modelos'), 
		);

		$contenido_externo = array(
			'title' => 'Modelos', 
			'contenido' => $this->load->view("admin/modelos/list", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);

	}

	public function add(){
		$contenido_externo = array(
			'title' => 'Modelos', 
			'contenido' => $this->load->view("admin/modelos/add", '', TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function store(){

		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");
		$this->form_validation->set_rules("nombre","Nombre","required|is_unique[modelos.nombre]");

		if ($this->form_validation->run()==TRUE) {

			$data  = array(
				'nombre' => $nombre, 
				'descripcion' => $descripcion,
				'estado' => "1"
			);

			if ($this->Comun_model->insert('modelos', $data)) {
				redirect(base_url()."almacen/modelos");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."almacen/modelos/add");
			}
		}
		else{
			$this->add();
		}
	}

	public function edit($id){
		$contenido_interno  = array(
			//'permisos' => $this->permisos,
			'modelo' => $this->Comun_model->get_record('modelos',"id=$id"), 
		);

		$contenido_externo = array(
			'title' => 'Modelos', 
			'contenido' => $this->load->view("admin/modelos/edit", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function update(){
		$idModulo = $this->input->post("idModulo");
		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");

		$modeloActual = $this->Comun_model->get_record('modelos',"id=$idModulo");

		if ($nombre == $modeloActual->nombre) {
			$is_unique_nombre = "";
		}else{
			$is_unique_nombre = "|is_unique[modelos.nombre]";
		}

		$this->form_validation->set_rules("nombre","Nombre","required".$is_unique_nombre);

		if ($this->form_validation->run()==TRUE) {
			$data = array(
				'nombre' => $nombre,
				'descripcion' => $descripcion,
			);

			if ($this->Comun_model->update('modelos',"id=$idModulo",$data)) {
				redirect(base_url()."almacen/modelos");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."almacen/modelos/edit/".$idModulo);
			}
		}else{
			$this->edit($idModulo);
		}

		
	}

	public function view($id){
		$data  = array(
			'modelo' => $this->Comun_model->get_record("modelos", "id=$id"), 
		);
		$this->load->view("admin/modelos/view",$data);
	}

	public function habilitar($id){
		$data  = array(
			'estado' => "1", 
		);
		$this->Comun_model->update("modelos","id=$id",$data);
		echo "almacen/modelos";
	}

	public function deshabilitar($id){
		$data  = array(
			'estado' => "0", 
		);
		$this->Comun_model->update("modelos","id=$id",$data);
		echo "almacen/modelos";
	}
}

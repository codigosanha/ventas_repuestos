<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subcategorias extends CI_Controller {

	//private $permisos;
	public function __construct(){
		parent::__construct();
		//$this->permisos = $this->backend_lib->control();
		$this->load->model("Comun_model");
		$this->load->helper("functions");
		
	}

	public function index()
	{
		$contenido_interno  = array(
			//'permisos' => $this->permisos,
			'subcategorias' => $this->Comun_model->get_records('subcategorias'), 
		);

		$contenido_externo = array(
			'title' => 'Subcategorias', 
			'contenido' => $this->load->view("admin/subcategorias/list", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);

	}

	public function add(){
		$contenido_interno  = array(
			//'permisos' => $this->permisos,
			'categorias' => $this->Comun_model->get_records('categorias'), 
		);

		$contenido_externo = array(
			'title' => 'subcategorias', 
			'contenido' => $this->load->view("admin/subcategorias/add", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function store(){

		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");
		$categoria_id = $this->input->post("categoria_id");
		$this->form_validation->set_rules("nombre","Nombre","required|is_unique[subcategorias.nombre]");

		if ($this->form_validation->run()==TRUE) {

			$data  = array(
				'nombre' => $nombre, 
				'descripcion' => $descripcion,
				'estado' => "1",
				'categoria_id' => $categoria_id,
			);

			if ($this->Comun_model->insert('subcategorias', $data)) {
				redirect(base_url()."almacen/subcategorias");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."almacen/subcategorias/add");
			}
		}
		else{
			$this->add();
		}
	}

	public function edit($id){
		$contenido_interno  = array(
			//'permisos' => $this->permisos,
			'subcategoria' => $this->Comun_model->get_record('subcategorias',"id=$id"), 
			'categorias' => $this->Comun_model->get_records('categorias'),

		);

		$contenido_externo = array(
			'title' => 'subcategorias', 
			'contenido' => $this->load->view("admin/subcategorias/edit", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function update(){
		$idSubcategoria = $this->input->post("idSubcategoria");
		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");
		$categoria_id = $this->input->post("categoria_id");
		$categoriaActual = $this->Comun_model->get_record('subcategorias',"id=$idSubcategoria");

		if ($nombre == $categoriaActual->nombre) {
			$is_unique_nombre = "";
		}else{
			$is_unique_nombre = "|is_unique[subcategorias.nombre]";
		}

		$this->form_validation->set_rules("nombre","Nombre","required".$is_unique_nombre);

		if ($this->form_validation->run()==TRUE) {
			$data = array(
				'nombre' => $nombre,
				'descripcion' => $descripcion,
				'categoria_id' => $categoria_id,
			);

			if ($this->Comun_model->update('subcategorias',"id=$idSubcategoria",$data)) {
				redirect(base_url()."almacen/subcategorias");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."almacen/subcategorias/edit/".$idSubcategoria);
			}
		}else{
			$this->edit($idSubcategoria);
		}

		
	}

	public function view($id){
		$data  = array(
			'subcategoria' => $this->Comun_model->get_record("subcategorias", "id=$id"), 
		);
		$this->load->view("admin/subcategorias/view",$data);
	}

	public function habilitar($id){
		$data  = array(
			'estado' => "1", 
		);
		$this->Comun_model->update("subcategorias","id=$id",$data);
		//echo "almacen/subcategorias";
		redirect(base_url()."almacen/subcategorias");
	}

	public function deshabilitar($id){
		$data  = array(
			'estado' => "0", 
		);
		$this->Comun_model->update("subcategorias","id=$id",$data);
		//echo "almacen/subcategorias";
		redirect(base_url()."almacen/subcategorias");
	}
}

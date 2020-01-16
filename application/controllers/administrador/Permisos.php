<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Permisos extends CI_Controller {

	private $permisos;
	public function __construct(){
		parent::__construct();
		$this->permisos = $this->backend_lib->control();
		$this->load->model("Comun_model");
		
	}

	public function index()
	{
		$contenido_interno  = array(
			"permits" => $this->permisos,
			"permisos" => $this->Comun_model->get_records("permisos"), 
		);

		$contenido_externo = array(
			"title" => "Permisos", 
			"contenido" => $this->load->view("admin/permisos/list", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);

	}

	public function add(){
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"menus" => $this->Comun_model->get_records("menus","estado=1"), 
			"roles" => $this->Comun_model->get_records("roles","estado=1"), 
		);
		$contenido_externo = array(
			"title" => "permisos", 
			"contenido" => $this->load->view("admin/permisos/add",$contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function store(){

		$menu_id = $this->input->post("menu_id");
		$rol_id = $this->input->post("rol_id");
		$read = $this->input->post("read");
		$insert = $this->input->post("insert");
		$update = $this->input->post("update");
		$delete = $this->input->post("delete");

		$existe_permiso_rol = $this->Comun_model->get_record("permisos","menu_id='$menu_id' && rol_id='$rol_id'");

		if ($existe_permiso_rol) {
			$this->session->set_flashdata("error","El permiso ya fue registrado");
			redirect(base_url()."administrador/permisos/add");
		}else{
			$data = array(
				'menu_id' => $menu_id, 
				'rol_id' => $rol_id,
				'read' => $read,
				'insert' => $insert,
				'update' => $update,
				'delete' => $delete,
			);
			if ($this->Comun_model->insert("permisos", $data)) {
				redirect(base_url()."administrador/permisos");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."administrador/permisos/add");
			}
		}

		
		
	}

	public function edit($id){
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"permiso" => $this->Comun_model->get_record("permisos","id=$id"), 
		);

		$contenido_externo = array(
			"title" => "permisos", 
			"contenido" => $this->load->view("admin/permisos/edit", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function update(){
		$idPermiso = $this->input->post("idPermiso");
		$read = $this->input->post("read");
		$insert = $this->input->post("insert");
		$update = $this->input->post("update");
		$delete = $this->input->post("delete");

		$data = array(
			"read" => $read,
			"insert" => $insert,
			"update" => $update,
			"delete" => $delete,
		);

		if ($this->Comun_model->update("permisos","id=$idPermiso",$data)) {
			redirect(base_url()."administrador/permisos");
		}
		else{
			$this->session->set_flashdata("error","No se pudo actualizar la informacion");
			redirect(base_url()."administrador/permisos/edit/".$idPermiso);
		}


		
	}

	public function view($id){
		$data  = array(
			"permiso" => $this->Comun_model->get_record("permisos", "id=$id"), 
		);
		$this->load->view("admin/permisos/view",$data);
	}

	public function habilitar($id){
		$data  = array(
			"estado" => "1", 
		);
		$this->Comun_model->update("permisos","id=$id",$data);
		echo "administrador/permisos";
	}

	public function deshabilitar($id){
		$data  = array(
			"estado" => "0", 
		);
		$this->Comun_model->update("permisos","id=$id",$data);
		echo "administrador/permisos";
	}
}

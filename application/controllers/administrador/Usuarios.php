<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Usuarios extends CI_Controller {

	private $permisos;
	public function __construct(){
		parent::__construct();
		$this->permisos = $this->backend_lib->control();
		$this->load->model("Comun_model");
		
	}

	public function index()
	{
		
		$contenido_interno  = array(
			"permisos" => $this->permisos,
			"usuarios" => $this->Comun_model->get_records("usuarios"), 
		);
		$contenido_externo = array(
			"title" => "usuarios", 
			"contenido" => $this->load->view("admin/usuarios/list", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);

	}

	public function add(){
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"roles" => $this->Comun_model->get_records("roles","estado=1"), 
			"sucursales" => $this->Comun_model->get_records("sucursales","estado=1"), 
		);

		$contenido_externo = array(
			"title" => "Usuarios", 
			"contenido" => $this->load->view("admin/usuarios/add",$contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function store(){

		$nombres = $this->input->post("nombres");
		$apellidos = $this->input->post("apellidos");
		$email = $this->input->post("email");
		$telefono = $this->input->post("telefono");
		$username = $this->input->post("username");
		$password = $this->input->post("password");
		$rol_id = $this->input->post("rol_id");
		$sucursal_id = $this->input->post("sucursal_id");
		$this->form_validation->set_rules("email","Email","required|is_unique[usuarios.email]");
		$this->form_validation->set_rules("username","Username","required|is_unique[usuarios.username]");

		if ($this->form_validation->run()==TRUE) {

			$data  = array(
				"nombres" => $nombres, 
				"apellidos" => $apellidos, 
				"email" => $email, 
				"password" => sha1($password), 
				"username" => $username, 
				"telefono" => $telefono, 
				"rol_id" => $rol_id, 
				"sucursal_id" => $sucursal_id, 
				"estado" => "1"
			);

			if ($this->Comun_model->insert("usuarios", $data)) {
				redirect(base_url()."administrador/usuarios");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."administrador/usuarios/add");
			}
		}
		else{
			$this->add();
		}
	}

	public function edit($id){
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"usuario" => $this->Comun_model->get_record("usuarios","id=$id"), 
			"roles" => $this->Comun_model->get_records("roles","estado=1"), 
			"sucursales" => $this->Comun_model->get_records("sucursales","estado=1"), 
		);

		$contenido_externo = array(
			"title" => "usuarios", 
			"contenido" => $this->load->view("admin/usuarios/edit", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function update(){
		$idUsuario = $this->input->post("idUsuario");
		$nombres = $this->input->post("nombres");
		$apellidos = $this->input->post("apellidos");
		$email = $this->input->post("email");
		$telefono = $this->input->post("telefono");
		$username = $this->input->post("username");
		$rol_id = $this->input->post("rol_id");
		$sucursal_id = $this->input->post("sucursal_id");

		$usuarioActual = $this->Comun_model->get_record("usuarios","id=$idUsuario");

		if ($email == $usuarioActual->email) {
			$is_unique_email = "";
		}else{
			$is_unique_email = "|is_unique[usuarios.email]";
		}

		if ($username == $usuarioActual->username) {
			$is_unique_username = "";
		}else{
			$is_unique_username = "|is_unique[usuarios.username]";
		}

		$this->form_validation->set_rules("email","Email","required".$is_unique_email);
		$this->form_validation->set_rules("username","Username","required".$is_unique_username);

		if ($this->form_validation->run()==TRUE) {
			$data = array(
				"nombres" => $nombres, 
				"apellidos" => $apellidos, 
				"email" => $email, 
				"username" => $username, 
				"telefono" => $telefono, 
				"rol_id" => $rol_id, 
				"sucursal_id" => $sucursal_id, 
			);

			if ($this->Comun_model->update("usuarios","id=$idUsuario",$data)) {
				redirect(base_url()."administrador/usuarios");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."administrador/usuarios/edit/".$idUsuario);
			}
		}else{
			$this->edit($idUsuario);
		}

		
	}

	public function view($id){
		$data  = array(
			"usuario" => $this->Comun_model->get_record("usuarios", "id=$id"), 
		);
		$this->load->view("admin/usuarios/view",$data);
	}

	public function habilitar($id){
		$data  = array(
			"estado" => "1", 
		);
		$this->Comun_model->update("usuarios","id=$id",$data);
		//echo "administrador/usuarios";
		redirect(base_url()."administrador/usuarios");
	}

	public function deshabilitar($id){
		$data  = array(
			"estado" => "0", 
		);
		$this->Comun_model->update("usuarios","id=$id",$data);
		//echo "administrador/usuarios";
		redirect(base_url()."administrador/usuarios");
	}
}

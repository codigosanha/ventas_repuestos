<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Clientes extends CI_Controller {

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
			"clientes" => $this->Comun_model->get_records("clientes"), 
		);

		$contenido_externo = array(
			"title" => "Clientes", 
			"contenido" => $this->load->view("admin/clientes/list", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);

	}

	public function add(){
		$contenido_externo = array(
			"title" => "Clientes", 
			"contenido" => $this->load->view("admin/clientes/add","", TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function store(){

		$nombres = $this->input->post("nombres");
		$apellidos = $this->input->post("apellidos");
		$cedula = $this->input->post("cedula");
		$telefono = $this->input->post("telefono");
		$direccion = $this->input->post("direccion");
		$nit = $this->input->post("nit");
		$this->form_validation->set_rules("cedula","Cedula","required|is_unique[clientes.cedula]");
		if ($nit) {
			$this->form_validation->set_rules("nit","NIT","required|is_unique[clientes.nit]");
		}

		if ($this->form_validation->run()==TRUE) {

			$data  = array(
				"nombres" => $nombres, 
				"apellidos" => $apellidos,
				"telefono" => $telefono,
				"direccion" => $direccion,
				"nit" => $nit,
				"cedula" => $cedula,
				"estado" => "1"
			);

			if ($this->Comun_model->insert("clientes", $data)) {
				redirect(base_url()."almacen/clientes");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."almacen/clientes/add");
			}
		}
		else{
			$this->add();
		}
	}

	public function edit($id){
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"cliente" => $this->Comun_model->get_record("clientes","id=$id"), 
		);

		$contenido_externo = array(
			"title" => "Clientes", 
			"contenido" => $this->load->view("admin/clientes/edit", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function update(){
		$idCliente = $this->input->post("idCliente");
		$nombres = $this->input->post("nombres");
		$apellidos = $this->input->post("apellidos");
		$cedula = $this->input->post("cedula");
		$telefono = $this->input->post("telefono");
		$direccion = $this->input->post("direccion");
		$nit = $this->input->post("nit");

		$clienteActual = $this->Comun_model->get_record("clientes","id=$idCliente");

		if ($cedula == $clienteActual->cedula) {
			$is_unique_cedula = "";
		}else{
			$is_unique_cedula = "|is_unique[clientes.cedula]";
		}
		$is_unique_nit = "";
		if ($nit) {
			if ($nit == $clienteActual->nit) {
				$is_unique_nit = "";
			}else{
				$is_unique_nit = "|is_unique[clientes.nit]";
			}

			$this->form_validation->set_rules("nit","NIT","required".$is_unique_nit);
		}

		$this->form_validation->set_rules("cedula","Cedula","required".$is_unique_cedula);
		

		if ($this->form_validation->run()==TRUE) {
			$data = array(
				"nombres" => $nombres, 
				"apellidos" => $apellidos,
				"telefono" => $telefono,
				"direccion" => $direccion,
				"nit" => $nit,
				"cedula" => $cedula,
			);

			if ($this->Comun_model->update("clientes","id=$idCliente",$data)) {
				redirect(base_url()."almacen/clientes");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."almacen/clientes/edit/".$idCliente);
			}
		}else{
			$this->edit($idCliente);
		}

		
	}

	public function view($id){
		$data  = array(
			"cliente" => $this->Comun_model->get_record("clientes", "id=$id"), 
		);
		$this->load->view("admin/clientes/view",$data);
	}

	public function habilitar($id){
		$data  = array(
			"estado" => "1", 
		);
		$this->Comun_model->update("clientes","id=$id",$data);
		//echo "almacen/clientes";
		redirect(base_url()."almacen/clientes");
	}

	public function deshabilitar($id){
		$data  = array(
			"estado" => "0", 
		);
		$this->Comun_model->update("clientes","id=$id",$data);
		//echo "almacen/clientes";
		redirect(base_url()."almacen/clientes");
	}
}

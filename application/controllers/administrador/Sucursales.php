<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sucursales extends CI_Controller {

	private $permisos;
	public function __construct(){
		parent::__construct();
		$this->permisos = $this->backend_lib->control();
		$this->load->model("Comun_model");
		
	}

	public function index()
	{
		$contenido_interno  = array(
			'permisos' => $this->permisos,
			'sucursales' => $this->Comun_model->get_records('sucursales'), 
		);

		$contenido_externo = array(
			'title' => 'Sucursales', 
			'contenido' => $this->load->view("admin/sucursales/list", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);

	}

	public function add(){
		$contenido_externo = array(
			'title' => 'Sucursales', 
			'contenido' => $this->load->view("admin/sucursales/add", '', TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function store(){

		$nombre = $this->input->post("nombre");
		$ubicacion = $this->input->post("ubicacion");
		$telefono = $this->input->post("telefono");
		$email = $this->input->post("email");
		$clave_especial = $this->input->post("clave_especial");
		$correo_remitente = $this->input->post("correo_remitente");

		$this->form_validation->set_rules("nombre","Nombre","required|is_unique[sucursales.nombre]");
		$this->form_validation->set_rules("email","Email","required|is_unique[sucursales.email]");

		if ($this->form_validation->run()==TRUE) {

			$data  = array(
				'nombre' => $nombre, 
				'ubicacion' => $ubicacion,
				'telefono' => $telefono,
				'email' => $email,
				'clave_especial' => $clave_especial,
				'correo_remitente' => $correo_remitente,
				'estado' => "1"
			);

			if ($this->Comun_model->insert('sucursales', $data)) {
				redirect(base_url()."administrador/sucursales");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."administrador/sucursales/add");
			}
		}
		else{
			$this->add();
		}
	}

	public function edit($id){
		$contenido_interno  = array(
			//'permisos' => $this->permisos,
			'sucursal' => $this->Comun_model->get_record('sucursales',"id=$id"), 
		);

		$contenido_externo = array(
			'title' => 'Sucursales', 
			'contenido' => $this->load->view("admin/sucursales/edit", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function update(){
		$idSucursal = $this->input->post("idSucursal");
		$nombre = $this->input->post("nombre");
		$ubicacion = $this->input->post("ubicacion");
		$telefono = $this->input->post("telefono");
		$email = $this->input->post("email");
		$clave_especial = $this->input->post("clave_especial");
		$correo_remitente = $this->input->post("correo_remitente");

		$sucursalActual = $this->Comun_model->get_record('sucursales',"id=$idSucursal");

		if ($nombre == $sucursalActual->nombre) {
			$is_unique_nombre = "";
		}else{
			$is_unique_nombre = "|is_unique[sucursales.nombre]";
		}

		if ($email == $sucursalActual->email) {
			$is_unique_email = "";
		}else{
			$is_unique_email = "|is_unique[sucursales.email]";
		}

		$this->form_validation->set_rules("nombre","Nombre","required".$is_unique_nombre);
		$this->form_validation->set_rules("email","Email","required".$is_unique_email);

		if ($this->form_validation->run()==TRUE) {
			$data = array(
				'nombre' => $nombre, 
				'ubicacion' => $ubicacion,
				'telefono' => $telefono,
				'email' => $email,
				'clave_especial' => $clave_especial,
				'correo_remitente' => $correo_remitente,
			);

			if ($this->Comun_model->update('sucursales',"id=$idSucursal",$data)) {
				redirect(base_url()."administrador/sucursales");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."administrador/sucursales/edit/".$idSucursal);
			}
		}else{
			$this->edit($idSucursal);
		}

		
	}

	public function view($id){
		$data  = array(
			'sucursal' => $this->Comun_model->get_record("sucursales", "id=$id"), 
		);
		$this->load->view("admin/sucursales/view",$data);
	}

	public function habilitar($id){
		$data  = array(
			'estado' => "1", 
		);
		$this->Comun_model->update("sucursales","id=$id",$data);
		echo "administrador/sucursales";
	}

	public function deshabilitar($id){
		$data  = array(
			'estado' => "0", 
		);
		$this->Comun_model->update("sucursales","id=$id",$data);
		echo "administrador/sucursales";
	}
}

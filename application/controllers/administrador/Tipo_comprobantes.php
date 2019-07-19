<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Tipo_comprobantes extends CI_Controller {

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
			"comprobantes" => $this->Comun_model->get_records("comprobantes"), 
			"comprobante_venta" => $this->Comun_model->get_record("comprobantes","seleccion_ventas='1'"),
		);

		$contenido_externo = array(
			"title" => " Tipos de Comprobantes", 
			"contenido" => $this->load->view("admin/tipo_comprobantes/list", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);

	}

	public function add(){
		$contenido_externo = array(
			"title" => "Tipos de Comprobantes", 
			"contenido" => $this->load->view("admin/tipo_comprobantes/add","", TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function store(){

		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");
		if ($this->input->post("permitir_anular")) {
			$permitir_anular = "1";
		}else{
			$permitir_anular = "0";
		}
		$this->form_validation->set_rules("nombre","Nombre","required|is_unique[comprobantes.nombre]");

		if ($this->form_validation->run()==TRUE) {

			$data  = array(
				"nombre" => $nombre, 
				"descripcion" => $descripcion,
				"permitir_anular" => $permitir_anular,
				"estado" => "1"
			);

			if ($this->Comun_model->insert("comprobantes", $data)) {
				redirect(base_url()."administrador/tipo_comprobantes");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."administrador/tipo_comprobantes/add");
			}
		}
		else{
			$this->add();
		}
	}

	public function edit($id){
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"comprobante" => $this->Comun_model->get_record("comprobantes","id=$id"), 
		);

		$contenido_externo = array(
			"title" => "Tipo de Comprobantes", 
			"contenido" => $this->load->view("admin/tipo_comprobantes/edit", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function update(){
		$idComprobante = $this->input->post("idComprobante");
		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");
		if ($this->input->post("permitir_anular")) {
			$permitir_anular = "1";
		}else{
			$permitir_anular = "0";
		}
		$comprobanteActual = $this->Comun_model->get_record("comprobantes","id=$idComprobante");

		if ($nombre == $comprobanteActual->nombre) {
			$is_unique_nombre = "";
		}else{
			$is_unique_nombre = "|is_unique[comprobantes.nombre]";
		}

		$this->form_validation->set_rules("nombre","Nombre","required".$is_unique_nombre);

		if ($this->form_validation->run()==TRUE) {
			$data = array(
				"nombre" => $nombre,
				"descripcion" => $descripcion,
				"permitir_anular" => $permitir_anular,
			);

			if ($this->Comun_model->update("comprobantes","id=$idComprobante",$data)) {
				redirect(base_url()."administrador/tipo_comprobantes");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."administrador/tipo_comprobantes/edit/".$idComprobante);
			}
		}else{
			$this->edit($idComprobante);
		}

		
	}

	public function view($id){
		$data  = array(
			"comprobante" => $this->Comun_model->get_record("comprobantes", "id=$id"), 
		);
		$this->load->view("admin/tipo_comprobantes/view",$data);
	}

	public function habilitar($id){
		$data  = array(
			"estado" => "1", 
		);
		$this->Comun_model->update("comprobantes","id=$id",$data);
		//echo "administrador/tipo_comprobantes";
		redirect(base_url()."administrador/tipo_comprobantes");
	}

	public function deshabilitar($id){
		$data  = array(
			"estado" => "0", 
		);
		$this->Comun_model->update("comprobantes","id=$id",$data);
		//echo "administrador/tipo_comprobantes";
		redirect(base_url()."administrador/tipo_comprobantes");
	}
	public function set_comprobante_venta(){
		$comprobante_venta = $this->input->post("comprobante_venta");
		$dataUpdate = array('seleccion_ventas' => 0, );
		$dataSeleccion  = array(
			'seleccion_ventas' => 1, 
		);
		$this->Comun_model->update("comprobantes","",$dataUpdate);
		if ($this->Comun_model->update("comprobantes","id=$comprobante_venta",$dataSeleccion)) {
			redirect(base_url()."administrador/tipo_comprobantes");
		}else{
			$this->session->set_flashdata("error","No se pudo actualizar la informacion");
			redirect(base_url()."administrador/tipo_comprobantes");
		}
	}
}

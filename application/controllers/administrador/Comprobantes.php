<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Comprobantes extends CI_Controller {

	private $permisos;
	public function __construct(){
		parent::__construct();
		$this->permisos = $this->backend_lib->control();
		$this->load->model("Comun_model");
		
	}

	public function index()
	{
		if ($this->session->userdata("sucursal")) {
			$comprobantes = $this->Comun_model->get_records("comprobante_sucursal","sucursal_id=".$this->session->userdata("sucursal"));
		}else{
			$comprobantes = $this->Comun_model->get_records("comprobante_sucursal");
		}

		$contenido_interno  = array(
			"permisos" => $this->permisos,
			"comprobantes" => $comprobantes, 
		);

		$contenido_externo = array(
			"title" => "Comprobantes", 
			"contenido" => $this->load->view("admin/comprobantes/list", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);

	}

	public function add(){
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"comprobantes" => $this->Comun_model->get_records("comprobantes"),
			"sucursales" => $this->Comun_model->get_records("sucursales")
		);
		$contenido_externo = array(
			"title" => "Comprobantes", 
			"contenido" => $this->load->view("admin/comprobantes/add",$contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function store(){

		$sucursal_id = $this->input->post("sucursal_id");
		$comprobante_id = $this->input->post("comprobante_id");
		$serie = $this->input->post("serie");
		$numero_inicial = $this->input->post("numero_inicial");
		$limite = $this->input->post("limite");
		$fecha_aprobacion_sat = $this->input->post("fecha_aprobacion_sat");
		$fecha_vencimiento_sat = $this->input->post("fecha_vencimiento_sat");
		$dias_vencimiento = $this->input->post("dias_vencimiento");

		$comprobante = $this->Comun_model->get_record("comprobantes","id='$comprobante_id'");
		$sucursal = $this->Comun_model->get_record("sucursales","id='$sucursal_id'");
		if ($this->Comun_model->get_record("comprobante_sucursal","comprobante_id='$comprobante_id' and sucursal_id='$sucursal_id'")) {
			$this->session->set_flashdata("error","El comprobante ".$comprobante->nombre ." ya fue agregado a la sucusarl ".$sucursal->nombre);
			redirect(base_url()."administrador/comprobantes/add");
		}else{
			$data  = array(
				"sucursal_id" => $sucursal_id, 
				"comprobante_id" => $comprobante_id,
				"serie" => $serie,
				"numero_inicial" => $numero_inicial,
				"limite" => $limite,
				"fecha_aprobacion_sat" => $fecha_aprobacion_sat,
				"fecha_vencimiento_sat" => $fecha_vencimiento_sat,
				"dias_vencimiento" => $dias_vencimiento,
				"estado" => "1"
			);

			if ($this->Comun_model->insert("comprobante_sucursal", $data)) {
				redirect(base_url()."administrador/comprobantes");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."administrador/comprobantes/add");
			}
		}

		
	}

	public function edit($id){
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"comprobante" => $this->Comun_model->get_record("comprobante_sucursal","id=$id"),
			"comprobantes" => $this->Comun_model->get_records("comprobantes"),
			"sucursales" => $this->Comun_model->get_records("sucursales") 
		);

		$contenido_externo = array(
			"title" => "Comprobantes", 
			"contenido" => $this->load->view("admin/comprobantes/edit", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function update(){
		$idComprobante = $this->input->post("idComprobante");
		$sucursal_id = $this->input->post("sucursal_id");
		$comprobante_id = $this->input->post("comprobante_id");
		$serie = $this->input->post("serie");
		$numero_inicial = $this->input->post("numero_inicial");
		$limite = $this->input->post("limite");
		$fecha_aprobacion_sat = $this->input->post("fecha_aprobacion_sat");
		$fecha_vencimiento_sat = $this->input->post("fecha_vencimiento_sat");
		$dias_vencimiento = $this->input->post("dias_vencimiento");
		

		$data = array(
			"sucursal_id" => $sucursal_id, 
			"comprobante_id" => $comprobante_id,
			"serie" => $serie,
			"numero_inicial" => $numero_inicial,
			"limite" => $limite,
			"fecha_aprobacion_sat" => $fecha_aprobacion_sat,
			"fecha_vencimiento_sat" => $fecha_vencimiento_sat,
			"dias_vencimiento" => $dias_vencimiento,
		);

		if ($this->Comun_model->update("comprobante_sucursal","id=$idComprobante",$data)) {
			redirect(base_url()."administrador/comprobantes");
		}
		else{
			$this->session->set_flashdata("error","No se pudo actualizar la informacion");
			redirect(base_url()."administrador/comprobantes/edit/".$idComprobante);
		}		
	}

	public function view($id){
		$data  = array(
			"comprobante" => $this->Comun_model->get_record("comprobante_sucursal", "id=$id"), 
		);
		$this->load->view("admin/comprobantes/view",$data);
	}

	public function habilitar($id){
		$data  = array(
			"estado" => "1", 
		);
		$this->Comun_model->update("comprobante_sucursal","id=$id",$data);
		//echo "administrador/comprobantes";
		redirect(base_url()."administrador/comprobantes");
	}

	public function deshabilitar($id){
		$data  = array(
			"estado" => "0", 
		);
		$this->Comun_model->update("comprobante_sucursal","id=$id",$data);
		//echo "administrador/comprobantes";
		redirect(base_url()."administrador/comprobantes");
	}
}

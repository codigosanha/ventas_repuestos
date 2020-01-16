<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ventas extends CI_Controller {
	private $permisos;
	public function __construct(){
		parent::__construct();
		$this->permisos = $this->backend_lib->control();
		$this->load->model("Comun_model");
	}

	public function index(){
		$fechainicio = $this->input->post("fechainicio");
		$fechafin = $this->input->post("fechafin");
		if ($this->input->post("buscar")) {

			if ($this->session->userdata("sucursal")) {
				$ventas = $this->Comun_model->get_records("ventas","DATE(fecha) >= '$fechainicio' and DATE(fecha)<='$fechafin' and sucursal_id=".$this->session->userdata("sucursal"));
			}else{
				$ventas = $this->Comun_model->get_records("ventas","DATE(fecha) >= '$fechainicio' and DATE(fecha)<='$fechafin'");
			}
		}
		else{
			if ($this->session->userdata("sucursal")) {
				$ventas = $this->Comun_model->get_records("ventas","sucursal_id=".$this->session->userdata("sucursal"));
			}else{
				$ventas = $this->Comun_model->get_records("ventas");
			}
		}

		$contenido_interno  = array(
			"permisos" => $this->permisos,
			"ventas" => $ventas,
			"fechainicio" => $fechainicio,
			"fechafin" => $fechafin
		);

		$contenido_externo = array(
			"title" => "Ventas", 
			"contenido" => $this->load->view("admin/reportes/ventas", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function view($id){
		$data  = array(
			"venta" => $this->Comun_model->get_record("ventas", "id=$id"), 
			"detalles" => $this->Comun_model->get_records("detalle_venta", "venta_id='$id'"), 
		);
		$this->load->view("admin/ventas/view",$data);
	}
}
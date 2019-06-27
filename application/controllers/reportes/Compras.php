<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compras extends CI_Controller {
//private $permisos;
	public function __construct(){
		parent::__construct();
		//$this->permisos = $this->backend_lib->control();
		$this->load->model("Comun_model");
	}

	public function index(){
		$fechainicio = $this->input->post("fechainicio");
		$fechafin = $this->input->post("fechafin");
		if ($this->input->post("buscar")) {

			if ($this->session->userdata("sucursal")) {
				$compras = $this->Comun_model->get_records("compras","DATE(fecha) >= '$fechainicio' and DATE(fecha)<='$fechafin' and sucursal_id=".$this->session->userdata("sucursal"));
			}else{
				$compras = $this->Comun_model->get_records("compras","DATE(fecha) >= '$fechainicio' and DATE(fecha)<='$fechafin'");
			}
		}
		else{
			if ($this->session->userdata("sucursal")) {
				$compras = $this->Comun_model->get_records("compras","sucursal_id=".$this->session->userdata("sucursal"));
			}else{
				$compras = $this->Comun_model->get_records("compras");
			}
		}

		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"compras" => $compras,
			"fechainicio" => $fechainicio,
			"fechafin" => $fechafin
		);

		$contenido_externo = array(
			"title" => "Compras", 
			"contenido" => $this->load->view("admin/reportes/compras", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function view($id){
		$data  = array(
			"compra" => $this->Comun_model->get_record("compras", "id=$id"), 
			"detalles" => $this->Comun_model->get_records("detalle_compra", "compra_id='$id'"), 
		);
		$this->load->view("admin/compras/view",$data);
	}
}
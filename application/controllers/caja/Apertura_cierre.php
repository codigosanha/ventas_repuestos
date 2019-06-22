<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Apertura_cierre extends CI_Controller {

	//private $permisos;
	public function __construct(){
		parent::__construct();
		//$this->permisos = $this->backend_lib->control();
		$this->load->model("Comun_model");
		
	}

	public function index()
	{
		$numero_sucursales = count($this->Comun_model->get_records("sucursales"));
		$cajas_abiertas = count($this->Comun_model->get_records("caja","estado=1"));

		$caja_abierta = $this->Comun_model->get_record("caja","sucursal_id=".$this->session->userdata("sucursal"));

		$sucursalesDisponibles = array();

		$sucursales = $this->Comun_model->get_records("sucursales");
		foreach ($sucursales as $sucursal) {
			if (!$this->Comun_model->get_record("caja","sucursal_id='$sucursal->id' and estado=1")) {
				$sucursalesDisponibles[] = $sucursal;
			}
		}

		if ($this->session->userdata("sucursal")) {
			$cajas = $this->Comun_model->get_records("caja","sucursal_id=".$this->session->userdata("sucursal"));
		}else{
			$cajas = $this->Comun_model->get_records("caja");
		}

		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"cajas" => $cajas,
			"numero_sucursales" => $numero_sucursales,
			"cajas_abiertas" => $cajas_abiertas,
			"caja_abierta" => $caja_abierta,
			"sucursales" => $sucursalesDisponibles
			
		);

		$contenido_externo = array(
			"title" => "Caja", 
			"contenido" => $this->load->view("admin/caja/aperturas_cierres", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);

	}

	public function add(){
		$contenido_externo = array(
			"title" => "caja", 
			"contenido" => $this->load->view("admin/caja/add","", TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function store(){

		$sucursal_id = $this->input->post("sucursal_id");
		$monto_apertura = $this->input->post("monto_apertura");

		$data  = array(
			"sucursal_id" => $sucursal_id, 
			"usuario_id" => $this->session->userdata("id"),
			"monto_apertura" => $monto_apertura,
			"fecha_apertura" => date("Y-m-d H:i:s"),
			"estado" => "1"
		);

		if ($this->Comun_model->insert("caja", $data)) {
			redirect(base_url()."caja/apertura_cierre");
		}
		else{
			$this->session->set_flashdata("error","No se pudo guardar la informacion");
			redirect(base_url()."caja/apertura_cierre");
		}
		
	}

	public function edit($id){
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"calidad" => $this->Comun_model->get_record("caja","id=$id"), 
		);

		$contenido_externo = array(
			"title" => "caja", 
			"contenido" => $this->load->view("admin/caja/edit", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function update(){
		$idCalidad = $this->input->post("idCalidad");
		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");

		$sucursalActual = $this->Comun_model->get_record("caja","id=$idCalidad");

		if ($nombre == $sucursalActual->nombre) {
			$is_unique_nombre = "";
		}else{
			$is_unique_nombre = "|is_unique[calidades.nombre]";
		}

		$this->form_validation->set_rules("nombre","Nombre","required".$is_unique_nombre);

		if ($this->form_validation->run()==TRUE) {
			$data = array(
				"nombre" => $nombre,
				"descripcion" => $descripcion,
			);

			if ($this->Comun_model->update("caja","id=$idCalidad",$data)) {
				redirect(base_url()."almacen/calidades");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."almacen/calidades/edit/".$idCalidad);
			}
		}else{
			$this->edit($idCalidad);
		}

		
	}

	public function view($id){
		$data  = array(
			"calidad" => $this->Comun_model->get_record("caja", "id=$id"), 
		);
		$this->load->view("admin/caja/view",$data);
	}

	public function habilitar($id){
		$data  = array(
			"estado" => "1", 
		);
		$this->Comun_model->update("caja","id=$id",$data);
		echo "almacen/calidades";
	}

	public function deshabilitar($id){
		$data  = array(
			"estado" => "0", 
		);
		$this->Comun_model->update("caja","id=$id",$data);
		echo "almacen/calidades";
	}
}

<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Gastos extends CI_Controller {

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
		$caja_abierta = $this->Comun_model->get_record("caja","estado=1 and sucursal_id=".$this->session->userdata("sucursal"));
		$sucursalesDisponibles = array();

		$sucursales = $this->Comun_model->get_records("sucursales");
		foreach ($sucursales as $sucursal) {
			if ($this->Comun_model->get_record("caja","sucursal_id='$sucursal->id' and estado=1")) {
				$sucursalesDisponibles[] = $sucursal;
			}
		}
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"numero_sucursales" => $numero_sucursales,
			"cajas_abiertas" => $cajas_abiertas,
			"caja_abierta" => $caja_abierta,
			"sucursales" => $sucursalesDisponibles,
			"gastos" => $this->Comun_model->get_records("gastos"),
		);

		$contenido_externo = array(
			"title" => "gastos", 
			"contenido" => $this->load->view("admin/gastos/list", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);

	}

	public function add(){
		$contenido_externo = array(
			"title" => "gastos", 
			"contenido" => $this->load->view("admin/gastos/add","", TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function store(){

		$nombre = $this->input->post("nombre");
		$monto = $this->input->post("monto");
		$observaciones = $this->input->post("observaciones");
		$sucursal_id = $this->input->post("sucursal_id");
		$caja_abierta = $this->Comun_model->get_record("caja","estado=1 and sucursal_id='$sucursal_id'");

		$data  = array(
			"nombre" => $nombre, 
			"monto" => $monto,
			"observaciones" => $observaciones,
			"sucursal_id" => $sucursal_id,
			"usuario_id" => $this->session->userdata("id"),
			"fecha" => date("Y-m-d H:i:s"),
			"caja_id" => $caja_abierta->id
		);

		if ($this->Comun_model->insert("gastos", $data)) {
			redirect(base_url()."caja/gastos");
		}
		else{
			$this->session->set_flashdata("error","No se pudo guardar la informacion");
			redirect(base_url()."caja/gastos");
		}
		
	}

	public function edit($id){
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"calidad" => $this->Comun_model->get_record("gastos","id=$id"), 
		);

		$contenido_externo = array(
			"title" => "gastos", 
			"contenido" => $this->load->view("admin/gastos/edit", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function update(){
		$idCalidad = $this->input->post("idCalidad");
		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");

		$sucursalActual = $this->Comun_model->get_record("gastos","id=$idCalidad");

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

			if ($this->Comun_model->update("gastos","id=$idCalidad",$data)) {
				redirect(base_url()."caja/gastos");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."caja/gastos/edit/".$idCalidad);
			}
		}else{
			$this->edit($idCalidad);
		}

		
	}

	public function view($id){
		$data  = array(
			"calidad" => $this->Comun_model->get_record("gastos", "id=$id"), 
		);
		$this->load->view("admin/gastos/view",$data);
	}

	public function habilitar($id){
		$data  = array(
			"estado" => "1", 
		);
		$this->Comun_model->update("gastos","id=$id",$data);
		//echo "caja/gastos";
		redirect(base_url()."caja/gastos");
	}

	public function deshabilitar($id){
		$data  = array(
			"estado" => "0", 
		);
		$this->Comun_model->update("gastos","id=$id",$data);
		//echo "caja/gastos";
		redirect(base_url()."caja/gastos");
	}
	public function delete($id){
		
		$this->Comun_model->delete("gastos","id=$id");
		//echo "caja/gastos";
		redirect(base_url()."caja/gastos");
	}
}

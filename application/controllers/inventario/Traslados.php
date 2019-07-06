<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Traslados extends CI_Controller {

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
			"traslados" => $this->Comun_model->get_records("traslados"), 
		);

		$contenido_externo = array(
			"title" => "traslados", 
			"contenido" => $this->load->view("admin/traslados/list", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);

	}

	public function add(){
		$contenido_interno = array(
			"sucursales" => $this->Comun_model->get_records("sucursales"),
			"bodegas" => $this->Comun_model->get_records("bodega_sucursal", "sucursal_id=".$this->session->userdata("sucursal")),
		);
		$contenido_externo = array(
			"title" => "traslados", 
			"contenido" => $this->load->view("admin/traslados/add",$contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function store(){

		$sucursal_envio = $this->input->post("sucursal_envio");
		$bodega_envio = $this->input->post("bodega_envio");
		$sucursal_recibe = $this->input->post("sucursal_recibe");
		$bodega_recibe = $this->input->post("bodega_recibe");
		$productos = $this->input->post("productos");
		$cantidades = $this->input->post("cantidades");


		$data  = array(
			"sucursal_envio" => $sucursal_envio, 
			"sucursal_recibe" => $sucursal_recibe,
			"bodega_envio" => $bodega_envio, 
			"bodega_recibe" => $bodega_recibe,
			"estado" => "1"
		);
		$traslado = $this->Comun_model->insert("traslados", $data);
		if ($traslado) {
			redirect(base_url()."inventario/traslados");
		}
		else{
			$this->session->set_flashdata("error","No se pudo guardar la informacion");
			redirect(base_url()."inventario/traslados/add");
		}
		
	}

	public function edit($id){
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"calidad" => $this->Comun_model->get_record("traslados","id=$id"), 
		);

		$contenido_externo = array(
			"title" => "traslados", 
			"contenido" => $this->load->view("admin/traslados/edit", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function update(){
		$idCalidad = $this->input->post("idCalidad");
		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");

		$sucursalActual = $this->Comun_model->get_record("traslados","id=$idCalidad");

		if ($nombre == $sucursalActual->nombre) {
			$is_unique_nombre = "";
		}else{
			$is_unique_nombre = "|is_unique[traslados.nombre]";
		}

		$this->form_validation->set_rules("nombre","Nombre","required".$is_unique_nombre);

		if ($this->form_validation->run()==TRUE) {
			$data = array(
				"nombre" => $nombre,
				"descripcion" => $descripcion,
			);

			if ($this->Comun_model->update("traslados","id=$idCalidad",$data)) {
				redirect(base_url()."inventario/traslados");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."inventario/traslados/edit/".$idCalidad);
			}
		}else{
			$this->edit($idCalidad);
		}

		
	}

	public function view($id){
		$data  = array(
			"calidad" => $this->Comun_model->get_record("traslados", "id=$id"), 
		);
		$this->load->view("admin/traslados/view",$data);
	}

	public function habilitar($id){
		$data  = array(
			"estado" => "1", 
		);
		$this->Comun_model->update("traslados","id=$id",$data);
		//echo "inventario/traslados";
		redirect(base_url()."inventario/traslados");
	}

	public function deshabilitar($id){
		$data  = array(
			"estado" => "0", 
		);
		$this->Comun_model->update("traslados","id=$id",$data);
		//echo "inventario/traslados";
		redirect(base_url()."inventario/traslados");
	}
}

<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Compras extends CI_Controller {

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
			"compras" => $this->Comun_model->get_records("compras"), 
		);

		$contenido_externo = array(
			"title" => "Compras", 
			"contenido" => $this->load->view("admin/compras/list", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);

	}

	public function add(){
		if ($this->session->userdata("sucursal")) {
			$bodegas = $this->Comun_model->get_records("bodega_sucursal","sucursal_id=".$this->session->userdata("sucursal"));
		}else{
			$bodegas = $this->Comun_model->get_records("bodega_sucursal");
		}
		$contenido_interno  = array(
			"bodegas" => $bodegas,
			"sucursales" => $this->Comun_model->get_records("sucursales"),
			//"permisos" => $this->permisos,
			"comprobantes" => $this->Comun_model->get_records("comprobantes"), 
			"proveedores" => $this->Comun_model->get_records("proveedores"), 
		);
		$contenido_externo = array(
			"title" => "compras", 
			"contenido" => $this->load->view("admin/compras/add",$contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function store(){

		$comprobante_id = $this->input->post("comprobante_id");
		$tipo_pago = $this->input->post("tipo_pago");
		$serie = $this->input->post("serie");
		$numero_comprobante = $this->input->post("numero_comprobante");
		$fecha = $this->input->post("fecha");
		$proveedor_id = $this->input->post("proveedor_id");
		$subtotal = $this->input->post("subtotal");
		$total = $this->input->post("total");
		$sucursal_id = $this->input->post("sucursal_id");
		$bodega_id = $this->input->post("bodega_id");

		$this->form_validation->set_rules("nombre","Nombre","required|is_unique[compras.nombre]");

		if ($this->form_validation->run()==TRUE) {

			$data  = array(
				"nombre" => $nombre, 
				"descripcion" => $descripcion,
				"estado" => "1"
			);

			if ($this->Comun_model->insert("compras", $data)) {
				redirect(base_url()."movimientos/compras");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."movimientos/compras/add");
			}
		}
		else{
			$this->add();
		}
	}

	public function edit($id){
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"compra" => $this->Comun_model->get_record("compras","id=$id"), 
		);

		$contenido_externo = array(
			"title" => "compras", 
			"contenido" => $this->load->view("admin/compras/edit", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function update(){
		$idCompra = $this->input->post("idCompra");
		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");

		$sucursalActual = $this->Comun_model->get_record("compras","id=$idCompra");

		if ($nombre == $sucursalActual->nombre) {
			$is_unique_nombre = "";
		}else{
			$is_unique_nombre = "|is_unique[compras.nombre]";
		}

		$this->form_validation->set_rules("nombre","Nombre","required".$is_unique_nombre);

		if ($this->form_validation->run()==TRUE) {
			$data = array(
				"nombre" => $nombre,
				"descripcion" => $descripcion,
			);

			if ($this->Comun_model->update("compras","id=$idCompra",$data)) {
				redirect(base_url()."movimientos/compras");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."movimientos/compras/edit/".$idCompra);
			}
		}else{
			$this->edit($idCompra);
		}

		
	}

	public function view($id){
		$data  = array(
			"compra" => $this->Comun_model->get_record("compras", "id=$id"), 
		);
		$this->load->view("admin/compras/view",$data);
	}

	public function habilitar($id){
		$data  = array(
			"estado" => "1", 
		);
		$this->Comun_model->update("compras","id=$id",$data);
		echo "movimientos/compras";
	}

	public function deshabilitar($id){
		$data  = array(
			"estado" => "0", 
		);
		$this->Comun_model->update("compras","id=$id",$data);
		echo "movimientos/compras";
	}
}

<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Bodegas extends CI_Controller {

	private $permisos;
	public function __construct(){
		parent::__construct();
		$this->permisos = $this->backend_lib->control();
		$this->load->model("Comun_model");
		
	}

	public function index()
	{
		if ($this->session->userdata("sucursal")) {
			$bodegas = $this->Comun_model->get_records("bodega_sucursal","sucursal_id=".$this->session->userdata("sucursal"));
		}else{
			$bodegas = $this->Comun_model->get_records("bodega_sucursal");
		}

		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"bodegas" => $bodegas,
			"permisos" => $this->permisos,

		);

		$contenido_externo = array(
			"title" => "Bodegas", 
			"contenido" => $this->load->view("admin/bodegas/list", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);

	}

	public function add(){
		$bodegas = $this->Comun_model->get_records("bodegas","estado=1");
		$sucursales = $this->Comun_model->get_records("sucursales","estado=1");
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"bodegas" => $bodegas,
			"sucursales" => $sucursales,
		);

		$contenido_externo = array(
			"title" => "Bodegas", 
			"contenido" => $this->load->view("admin/bodegas/add",$contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function store(){

		$sucursal_id = $this->input->post("sucursal_id");
		$bodega_id = $this->input->post("bodega_id");

		$existe_bodega_sucursal = $this->Comun_model->get_record("bodega_sucursal","sucursal_id='$sucursal_id' && bodega_id='$bodega_id'");

		if ($existe_bodega_sucursal) {
			$this->session->set_flashdata("error","La bodega ".get_record("bodegas","id=$existe_bodega_sucursal->bodega_id")->nombre." ya fue registrado para la sucursal ".get_record("sucursales","id=$existe_bodega_sucursal->sucursal_id")->nombre);
			redirect(base_url()."almacen/bodegas/add");
		}else{
			$data  = array(
				"sucursal_id" => $sucursal_id, 
				"bodega_id" => $bodega_id,
				"estado" => "1"
			);

			if ($this->Comun_model->insert("bodega_sucursal", $data)) {
				redirect(base_url()."almacen/bodegas");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."almacen/bodegas/add");
			}
		}
	}

	public function edit($id){
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"bodega" => $this->Comun_model->get_record("bodegas","id=$id"), 
		);

		$contenido_externo = array(
			"title" => "bodegas", 
			"contenido" => $this->load->view("admin/bodegas/edit", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function update(){
		$idBodega = $this->input->post("idBodega");
		$nombre = $this->input->post("nombre");

		$sucursalActual = $this->Comun_model->get_record("bodegas","id=$idBodega");

		if ($nombre == $sucursalActual->nombre) {
			$is_unique_nombre = "";
		}else{
			$is_unique_nombre = "|is_unique[bodegas.nombre]";
		}

		$this->form_validation->set_rules("nombre","Nombre","required".$is_unique_nombre);

		if ($this->form_validation->run()==TRUE) {
			$data = array(
				"nombre" => $nombre,
			);

			if ($this->Comun_model->update("bodegas","id=$idBodega",$data)) {
				redirect(base_url()."almacen/bodegas");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."almacen/bodegas/edit/".$idBodega);
			}
		}else{
			$this->edit($idBodega);
		}

		
	}

	public function view($id){
		$data  = array(
			"bodega" => $this->Comun_model->get_record("bodega_sucursal", "id=$id"), 
		);
		$this->load->view("admin/bodegas/view",$data);
	}

	public function habilitar($id){
		$data  = array(
			"estado" => "1", 
		);
		$this->Comun_model->update("bodega_sucursal","id=$id",$data);
		//echo "almacen/bodegas";
		redirect(base_url()."almacen/bodegas");
	}

	public function deshabilitar($id){
		$data  = array(
			"estado" => "0", 
		);
		$this->Comun_model->update("bodega_sucursal","id=$id",$data);
		//echo "almacen/bodegas";
		redirect(base_url()."almacen/bodegas");
	}
}

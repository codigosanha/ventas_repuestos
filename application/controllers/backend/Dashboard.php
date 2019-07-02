<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct();
		
		$this->load->model("Ventas_model");
		$this->load->model("Permisos_model");

	}
	public function index()
	{
		$contenido_interno = array(
			"cantVentas" => $this->Backend_model->rowCount("ventas"),
			"cantUsuarios" => $this->Backend_model->rowCount("usuarios"),
			"cantClientes" => $this->Backend_model->rowCount("clientes"),
			"cantProductos" => $this->Backend_model->rowCount("productos"),
			'productoslast' => $this->Ventas_model->getLastProductos(),
			
		);
		$contenido_externo = array(
			'title' => 'Principal', 
			'contenido' => $this->load->view("admin/dashboard", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function getData(){
		$year = $this->input->post("year");
		$resultados = $this->Ventas_model->montosMeses($year);
		echo json_encode($resultados);
	}

}
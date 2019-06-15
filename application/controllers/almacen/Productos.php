<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Productos extends CI_Controller {

	//private $permisos;
	public function __construct(){
		parent::__construct();
		//$this->permisos = $this->backend_lib->control();
		$this->load->model("Comun_model");
		$this->load->model("Productos_model");
	}

	public function index()
	{
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"productos" => $this->Comun_model->get_records("productos"), 
		);

		$contenido_externo = array(
			"title" => "productos", 
			"contenido" => $this->load->view("admin/productos/list", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);

	}

	public function add(){
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"categorias" => $this->Comun_model->get_records("categorias"), 
			"years" => $this->Comun_model->get_records("years"), 
			"presentaciones" => $this->Comun_model->get_records("presentaciones"), 
			"modelos" => $this->Comun_model->get_records("modelos"), 
			"marcas" => $this->Comun_model->get_records("marcas"), 
			"fabricantes" => $this->Comun_model->get_records("fabricantes"), 
			"calidades" => $this->Comun_model->get_records("calidades"), 

		);
		$contenido_externo = array(
			"title" => "productos", 
			"contenido" => $this->load->view("admin/productos/add",$contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function store(){

		$codigo_barras = $this->input->post("codigo_barras");
		$year_id = $this->input->post("year_id");
		$fabricante_id = $this->input->post("fabricante_id");
		$modelo_id = $this->input->post("modelo_id");
		$calidad_id = $this->input->post("calidad_id");
		$nombre = $this->input->post("nombre");
		$categoria_id = $this->input->post("categoria_id");
		$subcategoria_id = $this->input->post("subcategoria_id");
		$descripcion = $this->input->post("descripcion");
		$marca_id = $this->input->post("marca_id");
		$presentacion_id = $this->input->post("presentacion_id");
		$stock_minimo = $this->input->post("stock_minimo");

		$modelos = $this->input->post("modelos");


		$this->form_validation->set_rules("nombre","Nombre","required|is_unique[productos.nombre]");

		if ($this->form_validation->run()==TRUE) {

			$data  = array(
				"nombre" => $nombre, 
				"descripcion" => $descripcion,
				"estado" => "1"
			);

			if ($this->Comun_model->insert("productos", $data)) {
				redirect(base_url()."almacen/productos");
			}
			else{
				$this->session->set_flashdata("error","No se pudo guardar la informacion");
				redirect(base_url()."almacen/productos/add");
			}
		}
		else{
			$this->add();
		}
	}

	public function edit($id){
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"producto" => $this->Comun_model->get_record("productos","id=$id"), 
		);

		$contenido_externo = array(
			"title" => "productos", 
			"contenido" => $this->load->view("admin/productos/edit", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function update(){
		$idProducto = $this->input->post("idProducto");
		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");

		$sucursalActual = $this->Comun_model->get_record("productos","id=$idProducto");

		if ($nombre == $sucursalActual->nombre) {
			$is_unique_nombre = "";
		}else{
			$is_unique_nombre = "|is_unique[productos.nombre]";
		}

		$this->form_validation->set_rules("nombre","Nombre","required".$is_unique_nombre);

		if ($this->form_validation->run()==TRUE) {
			$data = array(
				"nombre" => $nombre,
				"descripcion" => $descripcion,
			);

			if ($this->Comun_model->update("productos","id=$idProducto",$data)) {
				redirect(base_url()."almacen/productos");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."almacen/productos/edit/".$idProducto);
			}
		}else{
			$this->edit($idProducto);
		}

		
	}

	public function view($id){
		$data  = array(
			"producto" => $this->Comun_model->get_record("productos", "id=$id"), 
		);
		$this->load->view("admin/productos/view",$data);
	}

	public function habilitar($id){
		$data  = array(
			"estado" => "1", 
		);
		$this->Comun_model->update("productos","id=$id",$data);
		echo "almacen/productos";
	}

	public function deshabilitar($id){
		$data  = array(
			"estado" => "0", 
		);
		$this->Comun_model->update("productos","id=$id",$data);
		echo "almacen/productos";
	}

	public function getSubcategorias(){
		$categoria_id = $this->input->post("idCategoria");
		$subcategorias = $this->Comun_model->get_records("subcategorias","categoria_id='$categoria_id'");
		echo json_encode($subcategorias);
	}

	public function getProductos(){
		$valor = $this->input->post("valor");
		$productos = $this->Productos_model->getProductos($valor);
		$data  = array();

        foreach ($productos as $p) {
            $dataProducto['id'] = $p->id;
            $dataProducto['nombre'] = $p->nombre;
            $dataProducto['label'] = $p->nombre;
            $data [] = $dataProducto;
        }
        echo json_encode($data);
	}
}

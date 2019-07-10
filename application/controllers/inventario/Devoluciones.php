<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Devoluciones extends CI_Controller {

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
			"devoluciones" => $this->Comun_model->get_records("devoluciones"), 
		);

		$contenido_externo = array(
			"title" => "devoluciones", 
			"contenido" => $this->load->view("admin/devoluciones/list", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);

	}

	public function add(){
		$contenido_interno = array(
			"sucursales" => $this->Comun_model->get_records("sucursales","estado=1"), 
			"comprobantes" => $this->Comun_model->get_records("comprobantes","estado=1"), 
		);
		$contenido_externo = array(
			"title" => "devoluciones", 
			"contenido" => $this->load->view("admin/devoluciones/add",$contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function store(){
		$idVenta = $this->input->post("idVenta");
		$idProductos = $this->input->post("idProductos");
		$cantidades = $this->input->post("cantidades");
		$sucursal = $this->input->post("sucursal_venta");
		$bodega_venta = $this->input->post("bodega_venta");
		$bodega_devolucion = $this->input->post("bodega_devolucion");
		$dataDevolucion = array(
			"venta_id" => $idVenta,
			"fecha" => date("Y-m-d H:i:s"),
			"bodega_id" => $bodega_venta,
			"sucursal_id" => $sucursal,
			"usuario_id" => $this->session->userdata("id"),
			"estado"=> "1"
		);
		$devolucion = $this->Comun_model->insert("devoluciones",$dataDevolucion);

		if ($devolucion) {
			for ($i=0; $i < count($idProductos); $i++) { 
				$dataDevolucionProductos = array(
					"devolucion_id" => $devolucion->id,
					"producto_id" => $idProductos[$i],
					"cantidad" => $cantidades[$i]
				);
				$this->Comun_model->insert("devoluciones_productos",$dataDevolucionProductos);
				$producto_bodega_venta = $this->Comun_model->get_record("bodega_sucursal_producto","sucursal_id='$sucursal' and bodega_id='$bodega_venta' and producto_id='$idProductos[$i]'");
				$dataProductoBodegaVenta = array(
					"stock" => $producto_bodega_venta->stock - $cantidades[$i]
				);
				$this->Comun_model->update("bodega_sucursal_producto","id='$producto_bodega_venta->id'", $dataProductoBodegaVenta);

				$producto_bodega_devolucion = $this->Comun_model->get_record("bodega_sucursal_producto","sucursal_id='$sucursal' and bodega_id='$bodega_devolucion' and producto_id='$idProductos[$i]'");
				if ($producto_bodega_devolucion) {
					$dataProductoBodegaDevolucion = array(
						"stock" => $producto_bodega_devolucion->stock + $cantidades[$i]
					);
					$this->Comun_model->update("bodega_sucursal_producto","id='$producto_bodega_devolucion->id'", $dataProductoBodegaDevolucion);
				}else{
					$dataAddProductoBodegaDevolucion = array(
						"stock" => $cantidades[$i],
						"bodega_id" => $bodega_devolucion,
						"sucursal_id" => $sucursal,
						"producto_id" => $idProductos[$i],
						"estado" => "1"
					);
					$this->Comun_model->insert("bodega_sucursal_producto",$dataAddProductoBodegaDevolucion);
				}
			}
			$this->session->set_flashdata("success","La devolución de producto(s) fue registrada con éxito");
			redirect(base_url()."inventario/devoluciones");
		} else{
			$this->session->set_flashdata("error","No se pudo registrar la devolución");
			redirect(base_url()."inventario/devoluciones");
		}
	}

	public function edit($id){
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"calidad" => $this->Comun_model->get_record("devoluciones","id=$id"), 
		);

		$contenido_externo = array(
			"title" => "devoluciones", 
			"contenido" => $this->load->view("admin/devoluciones/edit", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function update(){
		$idCalidad = $this->input->post("idCalidad");
		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");

		$sucursalActual = $this->Comun_model->get_record("devoluciones","id=$idCalidad");

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

			if ($this->Comun_model->update("devoluciones","id=$idCalidad",$data)) {
				redirect(base_url()."inventario/devoluciones");
			}
			else{
				$this->session->set_flashdata("error","No se pudo actualizar la informacion");
				redirect(base_url()."inventario/devoluciones/edit/".$idCalidad);
			}
		}else{
			$this->edit($idCalidad);
		}

		
	}

	public function view($id){
		$data  = array(
			"calidad" => $this->Comun_model->get_record("devoluciones", "id=$id"), 
		);
		$this->load->view("admin/devoluciones/view",$data);
	}

	public function habilitar($id){
		$data  = array(
			"estado" => "1", 
		);
		$this->Comun_model->update("devoluciones","id=$id",$data);
		//echo "inventario/devoluciones";
		redirect(base_url()."inventario/devoluciones");
	}

	public function deshabilitar($id){
		$data  = array(
			"estado" => "0", 
		);
		$this->Comun_model->update("devoluciones","id=$id",$data);

		$devolucion = $this->Comun_model->get_record("devoluciones","id='$id'");
		$productos = $this->Comun_model->get_records("devoluciones_productos","devolucion_id='$id'");
		
		//echo "inventario/devoluciones";
		redirect(base_url()."inventario/devoluciones");
	}

	public function getBodegas(){
		$sucursal_id = $this->input->post("idSucursal");
		$bodegas = $this->Comun_model->get_records("bodega_sucursal", "sucursal_id='$sucursal_id' and estado=1");
		$data = array();
		foreach ($bodegas as $b) {
			$data[] = array(
				'bodega_id' => $b->bodega_id,
				'nombre' => get_record("bodegas", "id=".$b->bodega_id)->nombre, 
			);
		}
		echo json_encode($data);
	}

	public function getVenta(){
		$comprobante = $this->input->post("comprobante");
		$sucursal = $this->input->post("sucursal");
		$bodega = $this->input->post("bodega");
		$numero_comprobante = $this->input->post("numero_comprobante");

		$venta = $this->Comun_model->get_record("ventas", "bodega_id='$bodega' and sucursal_id='$sucursal' and comprobante_id='$comprobante' and numero_comprobante='$numero_comprobante'");
		$cliente = get_record("clientes","id='$venta->cliente_id'");
		$dataVenta = array(
			"numero_comprobante" => $venta->numero_comprobante,
			"venta_id" => $venta->id,
			"fecha" => $venta->fecha,
			"sucursal_id" => $venta->sucursal_id,
			"sucursal" => get_record("sucursales","id='$venta->sucursal_id'")->nombre,
			"bodega_id" => $venta->bodega_id,
			"bodega" => get_record("bodegas","id='$venta->bodega_id'")->nombre,
			"cliente" => $cliente->nombres ." ". $cliente->apellidos,
		);
		$productos = $this->Comun_model->get_records("detalle_venta","venta_id='$venta->id'");
		$dataProductos = array();
		foreach ($productos as $p) {
			$dataProductos[] = array(
				"producto" => get_record("productos","id='$p->producto_id'")->nombre,
				"producto_id" => $p->producto_id,
				"cantidad" => $p->cantidad,
			);
		}
		echo json_encode(array(
			"venta" => $dataVenta,
			"detalles" => $dataProductos
		));
	}
}

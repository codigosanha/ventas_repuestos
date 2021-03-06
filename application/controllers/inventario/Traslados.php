<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Traslados extends CI_Controller {

	private $permisos;
	public function __construct(){
		parent::__construct();
		$this->permisos = $this->backend_lib->control();
		$this->load->model("Comun_model");
		$this->load->model("Compras_model");
		$this->load->model("Traslados_model");
	}

	public function index()
	{
		$contenido_interno  = array(
			"permisos" => $this->permisos,
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
		$productos = json_decode($this->input->post("productos"));
		$productos_nuevos = json_decode($this->input->post("productos_nuevos"));
		$cantidades_nuevas = json_decode($this->input->post("cantidades_nuevas"));
		$productos_existentes = json_decode($this->input->post("productos_existentes"));
		$cantidades_existentes = json_decode($this->input->post("cantidades_existentes"));

		$data  = array(
			"sucursal_envio" => $sucursal_envio, 
			"sucursal_recibe" => $sucursal_recibe,
			"bodega_envio" => $bodega_envio, 
			"bodega_recibe" => $bodega_recibe,
			"estado" => "1",
			"usuario_id" => $this->session->userdata("id"),
			"fecha" => date("Y-m-d H:i:s")
		);
		$traslado = $this->Comun_model->insert("traslados", $data);
		if ($traslado) {
			$traslados_nuevos_productos = [];
			$traslados_productos_existentes = [];
			$dataDetalleTraslado = [];
			//Guardar Detalle traslados

			//Guardar nuevos productos
			for ($i=0; $i < count($productos_nuevos); $i++) { 
				$data_producto_nuevos = array(
					"bodega_id" => $bodega_recibe,
					"sucursal_id" => $sucursal_recibe,
					"producto_id" => $productos_nuevos[$i],
					"stock" => $cantidades_nuevas[$i],
					'estado'=> 1
				);
				$detalleTraslado = array(
					"producto_id" => $productos_nuevos[$i],
					"traslado_id" => $traslado->id,
					"cantidad" => $cantidades_nuevas[$i]
				);
				$traslados_nuevos_productos[] = $data_producto_nuevos;
				$dataDetalleTraslado[] = $detalleTraslado;
			}

			//Guardar productos existentes
			for ($i=0; $i < count($productos_existentes); $i++) { 
				$cantidad = 0;
				$bsp_id = '';
				for ($j=0; $j < count($productos); $j++) { 
					$producto_existente = $productos[$j];
					$dataProductoExistente = explode('-', $producto_existente);
					if ($productos_existentes[$i] == $dataProductoExistente[0] ) {
						$cantidad = $dataProductoExistente[2];
						$bsp_id = $dataProductoExistente[1];
						break;
					}
				}
				$data_producto_existentes = array(
					'id' => $bsp_id,
					"stock" => $cantidades_existentes[$i] + $cantidad,
					'estado'=> 1
				);
				$detalleTraslado = array(
					"producto_id" => $productos_existentes[$i],
					"traslado_id" => $traslado->id,
					"cantidad" => $cantidades_existentes[$i]
				);
				$traslados_productos_existentes[] = $data_producto_existentes;
				$dataDetalleTraslado[] = $detalleTraslado;
			}
			if (!empty($dataDetalleTraslado)) {
				$this->Traslados_model->saveDetalleTraslado($dataDetalleTraslado);
			}
			if (!empty($traslados_nuevos_productos)) {
				$this->Traslados_model->saveTrasladosNuevosProductos($traslados_nuevos_productos);
			}
			if (!empty($traslados_productos_existentes)) {
				$this->Traslados_model->updateTrasladosProductosExistentes($traslados_productos_existentes);
			}
			
			
			echo "inventario/traslados";
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
			"traslado" => $this->Comun_model->get_record("traslados", "id=$id"),
			"productos" => $this->Comun_model->get_records("traslados_productos","traslado_id='$id'") 
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
		$traslado = $this->Comun_model->get_record("traslados","id='$id'");
		$productos = $this->Comun_model->get_records("traslados_productos","traslado_id='$id'");
		foreach ($productos as $p) {
			$bodega_recibe = $this->Comun_model->get_record("bodega_sucursal_producto","bodega_id='$traslado->bodega_recibe' and sucursal_id='$traslado->sucursal_recibe' and producto_id='$p->producto_id'");
			$dataBodegaRecibe = array(
				"stock" => $bodega_recibe->stock - $p->cantidad
			);	
			$this->Comun_model->update("bodega_sucursal_producto","id='$bodega_recibe->id'",$dataBodegaRecibe);
			$bodega_envio = $this->Comun_model->get_record("bodega_sucursal_producto","bodega_id='$traslado->bodega_envio' and sucursal_id='$traslado->sucursal_envio' and producto_id='$p->producto_id'");
			$dataBodegaEnvio = array(
				"stock" => $bodega_envio->stock + $p->cantidad
			);	
			$this->Comun_model->update("bodega_sucursal_producto","id='$bodega_envio->id'",$dataBodegaEnvio);
		}
		//echo "inventario/traslados";
		redirect(base_url()."inventario/traslados");
	}

	public function getBodegas(){
		$sucursal_id = $this->input->post("idSucursal");
		$bodegas = $this->Comun_model->get_records("bodega_sucursal", "sucursal_id='$sucursal_id'");
		$data = array();
		foreach ($bodegas as $b) {
			$data[] = array(
				"bodega_id" => $b->bodega_id,
				"nombre" => get_record("bodegas","id=".$b->bodega_id)->nombre
			);
		}
		echo json_encode($data);
	}

	public function searchProductos()
	{

		$columns = array( 
                        0 =>'p.producto_id', 
                        1=> 'p.codigo_barras',
                        2=> 'p.nombre',
                        3=> 'b.nombre',
                    );
		$sucursal_id = $this->input->post("sucursal");
		$bodega_id = $this->input->post("bodega");
		$sucursal_recibe = $this->input->post("sucursal_recibe");
		$bodega_recibe = $this->input->post("bodega_recibe");

		$limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  
        $totalData = $this->Traslados_model->allproducts_count($sucursal_id,$bodega_id);
            
        $totalFiltered = $totalData; 
            
        if(empty($this->input->post('search')['value']))
        {            
            $productos = $this->Traslados_model->allproducts($limit,$start,$order,$dir,$sucursal_id,$bodega_id);
        }
        else {
            $search = $this->input->post('search')['value']; 

            $productos =  $this->Traslados_model->products_search($limit,$start,$search,$order,$dir,$sucursal_id,$bodega_id);

            $totalFiltered = $this->Traslados_model->products_search_count($search,$sucursal_id,$bodega_id);
        }

        $data = array();
        if(!empty($productos))
        {
        	foreach ($productos as $p) {

        		$checkProductoSucursalBodega = $this->Comun_model->get_record("bodega_sucursal_producto", "producto_id='$p->producto_id' AND bodega_id='$bodega_recibe' AND sucursal_id='$sucursal_recibe'");
        		$stock = 0;
        		$bsp_id = '';
        		if ($checkProductoSucursalBodega) {
        			$bsp_id = $checkProductoSucursalBodega->id;
        			$stock = $checkProductoSucursalBodega->stock;
        		}

				$data[] = array(
					"producto_id" => $p->producto_id,
					"nombre" => $p->nombre,
					"codigo_barras" => $p->codigo_barras,
					'bsp_id' => $bsp_id,
					'stock' => $stock
				);
			}
        }
          
        $json_data = array(
                    "draw"            => intval($this->input->post('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
	}

	public function getIdProductosSBE(){
		$bodega_id = $this->input->post("bodega");
		$sucursal_id = $this->input->post("sucursal");
		$bodega_recibe = $this->input->post("bodega_recibe");
		$sucursal_recibe = $this->input->post("sucursal_recibe");

		$idProductosSBE = $this->Traslados_model->getProductosBySB($bodega_id,$sucursal_id);
		$idProductosSBR = $this->Traslados_model->getProductosBySB($bodega_recibe,$sucursal_recibe);

		$productos_existentes = [];
		$productos_no_existentes = [];

		$bsp_ids = [];
		$stocks = [];

		for ($i=0; $i < count($idProductosSBE); $i++) { 
			$check = 0;
			$k = 0;
			for ($j=0; $j < count($idProductosSBR) ; $j++) { 
				if ($idProductosSBE[$i]['producto'] == $idProductosSBR[$j]['producto']) {
					$check = 1;
					$k=$j;
					break;
				}
			}

			if ($check) {
				$productos_existentes[] = $idProductosSBE[$i]['producto'];
				$bsp_ids[] = $idProductosSBR[$k]['bsp_id'];
				$stocks[] = $idProductosSBR[$k]['stock'];

			}else{
				$productos_no_existentes[] = $idProductosSBE[$i]['producto'];
			}
		}

		echo json_encode([
			"productos_existentes" => $productos_existentes,
			"productos_no_existentes" => $productos_no_existentes,
			"bsp_ids" => $bsp_ids,
			"stocks" => $stocks,
		]);
	}
}

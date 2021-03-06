<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Ajuste extends CI_Controller {

	private $permisos;
	public function __construct(){
		parent::__construct();
		$this->permisos = $this->backend_lib->control();
		$this->load->model("Comun_model");
		$this->load->model("Productos_model");
		$this->load->model("Ajuste_model");
	}

	public function index()
	{
		$contenido_interno  = array(
			"permisos" => $this->permisos,
			"ajustes" => $this->Comun_model->get_records("ajustes"), 
		);
		$contenido_externo = array(
			"title" => "ajustes", 
			"contenido" => $this->load->view("admin/ajustes/list", $contenido_interno, TRUE)
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
			//"permisos" => $this->permisos,
			"sucursales" => $this->Comun_model->get_records("sucursales"),
			"bodegas" => $bodegas,
		);
		$contenido_externo = array(
			"title" => "ajustes", 
			"contenido" => $this->load->view("admin/ajustes/add",$contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function store(){

		$usuario_id = $this->session->userdata("id");
		$fecha = date("Y-m-d H:i:s");
		$bsp_ids = json_decode($this->input->post("bsp_ids"));
		$productos = json_decode($this->input->post("productos"));
		$localizaciones = json_decode($this->input->post("localizaciones"));
		$stocks_bd = json_decode($this->input->post("stocks_bd"));
		$stocks_fisico = json_decode($this->input->post("stocks_fisico"));
		$stocks_diferencia = json_decode($this->input->post("stocks_diferencia"));
		$bodega_id = $this->input->post("bodega_id");
		$sucursal_id = $this->input->post("sucursal_id");



		$data  = array(
			'fecha' => $fecha, 
			'usuario_id' => $usuario_id,
			"bodega_id" => $bodega_id,
			"sucursal_id" => $sucursal_id,
		);

		$ajuste = $this->Comun_model->insert("ajustes", $data);

		if ($ajuste) {
			//ini_set('max_execution_time', 0); 
			//ini_set('memory_limit','2048M');
			$this->saveAjusteProductos($ajuste->id,$bsp_ids,$productos,$localizaciones,$stocks_bd,$stocks_fisico,$stocks_diferencia,$bodega_id,$sucursal_id);
			echo $ajuste->id;
		}
		else{
			echo "0";
		}
	}

	protected function saveAjusteProductos($ajuste_id,$bsp_ids,$productos,$localizaciones,$stocks_bd,$stocks_fisico,$stocks_diferencia,$bodega_id,$sucursal_id){

		$dataAjusteProductos = [];
		$dataUpdateStocks = [];

		for ($i=0; $i < count($productos); $i++) { 
			$dataAjusteProducto = array(
				'ajuste_id' => $ajuste_id,
				'producto_id' => $productos[$i],
				'stock_bd' => $stocks_bd[$i],
				'stock_fisico' => $stocks_fisico[$i],
				'diferencia_stock' => $stocks_diferencia[$i]
			);
			$dataAjusteProductos[] = $dataAjusteProducto;

			$dataStock = array(
				'id' =>  $bsp_ids[$i],
				'stock' => $stocks_fisico[$i],
				'localizacion' => $localizaciones[$i]
			);
			$dataUpdateStocks[] = $dataStock;
		}

		if (!empty($dataAjusteProductos)) {
			$this->Ajuste_model->saveAjusteProductos($dataAjusteProductos);
		}

		if (!empty($dataUpdateStocks)) {
			$this->Ajuste_model->updateStockProductos($dataUpdateStocks);
		}
	} 

	public function view($ajuste_id){
		$data = array(
			'ajuste' => $this->Comun_model->get_record("ajustes","id='$ajuste_id'"),
			'productos' => $this->Comun_model->get_records("ajustes_productos","ajuste_id='$ajuste_id'"),
		);

		$this->load->view("admin/ajustes/view", $data);
	}

	public function edit($id){
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"ajuste" => $this->Comun_model->get_record("ajustes","id=$id"), 
			"ajustes" => $this->Comun_model->get_records("ajustes_productos","ajuste_id=$id"), 
		);

		$contenido_externo = array(
			"title" => "ajustes", 
			"contenido" => $this->load->view("admin/ajustes/edit", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}
	public function update(){
		$ajustes = $this->input->post("ajustes");
		$productos = $this->input->post("productos");
		$stocks_fisico = $this->input->post("stocks_fisico");
		$stocks_diferencia = $this->input->post("stocks_diferencia");
		$bodega_id = $this->input->post("bodega_id");
		$sucursal_id = $this->input->post("sucursal_id");

		for ($i=0; $i < count($ajustes); $i++) { 
			$data = array(
				'stock_fisico' => $stocks_fisico[$i],
				'diferencia_stock' => $stocks_diferencia[$i],
			);

			$dataProducto = array(
				'stock' => $stocks_fisico[$i]
			);

			$this->Comun_model->update("bodega_sucursal_producto","producto_id='".$productos[$i]."' and bodega_id='$bodega_id' and sucursal_id='$sucursal_id'", $dataProducto);
			$this->Comun_model->update("ajustes_productos","id=".$ajustes[$i],$data);
		}
		$this->session->set_flashdata("success",$idAjuste);
		redirect(base_url()."inventario/ajuste");
	}

	public function habilitar($id){
		$data  = array(
			"estado" => "1", 
		);
		$this->Comun_model->update("ajustes","id=$id",$data);
		redirect(base_url()."inventario/ajuste");
	}

	public function deshabilitar($id){
		$data  = array(
			"estado" => "0", 
		);
		$this->Comun_model->update("ajustes","id=$id",$data);
		redirect(base_url()."inventario/ajuste");
	}
	public function searchProductos(){
		$columns = array( 
                        0 =>'p.codigo_barras', 
                        1=> 'p.nombre',
                        2=> 'p.nombre',
                        3=> 'p.nombre',
                        4=> 'p.nombre',
                    );
		$sucursal_id = $this->input->post("sucursal");
		$bodega_id = $this->input->post("bodega");

		$limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  
        $totalData = $this->Ajuste_model->allproducts_count($sucursal_id,$bodega_id);
            
        $totalFiltered = $totalData; 
            
        if(empty($this->input->post('search')['value']))
        {            
            $productos = $this->Ajuste_model->allproducts($limit,$start,$order,$dir,$sucursal_id,$bodega_id);
        }
        else {
            $search = $this->input->post('search')['value']; 

            $productos =  $this->Ajuste_model->products_search($limit,$start,$search,$order,$dir,$sucursal_id,$bodega_id);

            $totalFiltered = $this->Ajuste_model->products_search_count($search,$sucursal_id,$bodega_id);
        }

        $data = array();
        if(!empty($productos))
        {
        	foreach ($productos as $p) {
				$data[] = array(
					"producto_id" => $p->producto_id,
					"nombre" => $p->nombre,
					"codigo_barras" => $p->codigo_barras,
					'bsp_id' => $p->id,
					'stock' => $p->stock,
					'localizacion' => $p->localizacion,
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

	public function productosBySucursalBodega(){
		$sucursal_id = $this->input->post("sucursal");
		$bodega_id = $this->input->post("bodega");
		$productos = $this->Ajuste_model->productosBySucursalBodega($sucursal_id, $bodega_id);
		echo json_encode($productos);
	}
}

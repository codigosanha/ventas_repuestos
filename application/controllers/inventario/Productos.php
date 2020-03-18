<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Productos extends CI_Controller {

	private $permisos;
	public function __construct(){
		parent::__construct();
		$this->permisos = $this->backend_lib->control();
		$this->load->model("Comun_model");
		$this->load->model("Inventario_model");
	}

	public function index()
	{
		if ($this->session->userdata("sucursal")) {
			$bodegas = $this->Comun_model->get_records("bodega_sucursal","sucursal_id=".$this->session->userdata("sucursal"));
		}else{
			$bodegas = $this->Comun_model->get_records("bodega_sucursal");
		}

		if ($this->session->userdata("sucursal")) {
			$productos = $this->Comun_model->get_records("bodega_sucursal_producto","sucursal_id=".$this->session->userdata("sucursal"));
		}else{
			$productos = $this->Comun_model->get_records("bodega_sucursal_producto");
		}
		$contenido_interno  = array(
			"permisos" => $this->permisos,
			"bodegas" => $bodegas,
			"productos" => $productos,
			"sucursales" => $this->Comun_model->get_records("sucursales")
		);

		$contenido_externo = array(
			"title" => "Productos", 
			"contenido" => $this->load->view("admin/inventario_productos/list", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function getInventario()
	{
		$columns = array( 
							0 => 'bsp.id', 
                            1 => 's.nombre', 
                            2 => 'b.nombre',
                            3 => 'p.codigo_barras',
                            4 => 'p.nombre',
                            5 => 'bsp.stock',
                            6 => 'bsp.localizacion',
                        );

		$limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  
        $totalData = $this->Inventario_model->allproductos_count();
            
        $totalFiltered = $totalData; 
            
        if(empty($this->input->post('search')['value']))
        {            
            $productos = $this->Inventario_model->allproductos($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value']; 

            $productos =  $this->Inventario_model->productos_search($limit,$start,$search,$order,$dir);

            $totalFiltered = $this->Inventario_model->productos_search_count($search);
        }

        $data = array();
        if(!empty($productos))
        {
            foreach ($productos as $key=>$p)
            {
            	$nestedData['index'] = $key+1;
                $nestedData['id'] = $p->id;
                $nestedData['sucursal'] = get_record("sucursales","id=".$p->sucursal_id)->nombre;
                $nestedData['bodega'] = get_record("bodegas","id=".$p->bodega_id)->nombre;

                $producto = get_record("productos","id=".$p->producto_id);

                $nestedData['nombre'] = $producto->nombre;
                $nestedData['codigo_barras'] = $producto->codigo_barras;
                $nestedData['stock'] = $p->stock;
                $nestedData['localizacion'] = $p->localizacion;
               	$nestedData['estado'] = $p->estado;
                $data[] = $nestedData;
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

	public function add(){
		if ($this->session->userdata("sucursal")) {
			$bodegas = $this->Comun_model->get_records("bodega_sucursal","sucursal_id=".$this->session->userdata("sucursal"));
		}else{
			$bodegas = $this->Comun_model->get_records("bodega_sucursal");
		}

		if ($this->session->userdata("sucursal")) {
			$productos = $this->Comun_model->get_records("bodega_sucursal_producto","sucursal_id=".$this->session->userdata("sucursal"));
		}else{
			$productos = $this->Comun_model->get_records("bodega_sucursal_producto");
		}
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"bodegas" => $bodegas,
			"productos" => $this->Comun_model->get_records("productos"),
			"sucursales" =>  $this->Comun_model->get_records("sucursales")
		);
		$contenido_externo = array(
			"title" => "calidades", 
			"contenido" => $this->load->view("admin/inventario_productos/add",$contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function store(){

		$bodega_id = $this->input->post("bodega_id");
		$sucursal_id = $this->input->post("sucursal_id");
		$idProductos = $this->input->post("idProductos");
		$data = [];
		
		for ($i=0; $i < count($idProductos); $i++) { 
			$data[] = [
				"bodega_id" => $bodega_id, 
				"sucursal_id" => $sucursal_id,
				"producto_id" => $idProductos[$i],
				"estado" => "1"
			]; 
		}

		if (!empty($data)) {
			$this->Inventario_model->saveInventario($data);
		}

		redirect(base_url()."inventario/productos");
	}

	public function edit($id){
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"producto" => $this->Comun_model->get_record("bodega_sucursal_producto","id=$id"), 
		);

		$contenido_externo = array(
			"title" => "Productos", 
			"contenido" => $this->load->view("admin/inventario_productos/edit", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function update(){
		$idProducto = $this->input->post("idProducto");
		$localizacion = $this->input->post("localizacion");
	
		$data = array(
			"localizacion" => $localizacion,
		);

		if ($this->Comun_model->update("bodega_sucursal_producto","id=$idProducto",$data)) {
			redirect(base_url()."inventario/productos");
		}
		else{
			$this->session->set_flashdata("error","No se pudo actualizar la informacion");
			redirect(base_url()."inventario/productos/edit/".$idProducto);
		}
	}

	public function view($id){
		$data  = array(
			"calidad" => $this->Comun_model->get_record("calidades", "id=$id"), 
		);
		$this->load->view("admin/inventario_productos/view",$data);
	}

	public function habilitar($id){
		$data  = array(
			"estado" => "1", 
		);
		$this->Comun_model->update("bodega_sucursal_producto","id=$id",$data);
		redirect(base_url()."inventario/productos");
	}

	public function deshabilitar($id){
		$data  = array(
			"estado" => "0", 
		);
		$this->Comun_model->update("bodega_sucursal_producto","id=$id",$data);
		redirect(base_url()."inventario/productos");
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

	public function getProductos(){
		$sucursal_id = $this->input->post("idSucursal");
		$bodega_id = $this->input->post("idBodega");
		$productos = $this->Comun_model->get_records("productos");
		$dataProductosRestantes = array();
		foreach ($productos as $producto) {
			$existe_producto = $this->Comun_model->get_record("bodega_sucursal_producto","sucursal_id='$sucursal_id' and bodega_id='$bodega_id' and producto_id='$producto->id'");
			if (!$existe_producto) {
				$dataProductosRestantes[] = $producto->id;
			}
		}
		$productosRegistrados = $this->Comun_model->get_records("bodega_sucursal_producto","sucursal_id='$sucursal_id' and bodega_id='$bodega_id'");
		$dataProductosRegistrados = array();
		foreach ($productosRegistrados as $p) {
			$dataProductosRegistrados[] = array(
				"producto_id" => $p->producto_id,
				"nombre" => get_record("productos", "id=".$p->producto_id)->nombre
			);
		}
		echo json_encode(array(
			'productosRegistrados' => $dataProductosRegistrados,
			'productosRestantes' => $dataProductosRestantes
		));

	}


	public function barcode($id){
		$producto_inventario = $this->Comun_model->get_record("bodega_sucursal_producto","id='$id'");
		$producto = $this->Comun_model->get_record("productos","id='$producto_inventario->producto_id'");

		$this->generateBarCode($producto->codigo_barras);

		$data["localizacion"] = $producto_inventario->localizacion;
		$data["nombre_producto"] = $producto->nombre;
		$data["codigo_barras"] = $producto->codigo_barras;

		$this->load->library('pdfgenerator');
        
        $html = $this->load->view('admin/inventario_productos/barcode',$data, true);
        $filename = 'Codigo de Barras';
        $customPaper = array(0, 0, 192, 96);
        $this->pdfgenerator->generate($html, $filename, true, $customPaper, 'portrait');
	}


	protected function generateBarCode($codigo_barras){
		$this->load->library('zend');
	   	$this->zend->load('Zend/Barcode');
	   	$barcodeOptions = array(
		    'text' => $codigo_barras, 
		    'withQuietZones' => false,
		    'barThickWidth'	=>4,
			'barThinWidth'=>2,
			
		 
		);
	   	$file = Zend_Barcode::draw('code128', 'image', $barcodeOptions, array());
	   	//$code = time().$code;
	   	$store_image = imagepng($file,"./assets/barcode/{$codigo_barras}.png");
	}
}

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


	public function getProducts()
	{
		$columns = array( 
							0 => 'p.id', 
                            1 => 'p.codigo_barras', 
                            2 => 'p.imagen',
                            3 => 'p.nombre',
                            4 => 'c.nombre',
                            5 => 'p.stock_minimo',
                        );

		$limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  
        $totalData = $this->Productos_model->allproductos_count();
            
        $totalFiltered = $totalData; 
            
        if(empty($this->input->post('search')['value']))
        {            
            $productos = $this->Productos_model->allproductos($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value']; 

            $productos =  $this->Productos_model->productos_search($limit,$start,$search,$order,$dir);

            $totalFiltered = $this->Productos_model->productos_search_count($search);
        }

        $data = array();
        if(!empty($productos))
        {
            foreach ($productos as $producto)
            {

                $nestedData['id'] = $producto->id;
                $nestedData['nombre'] = $producto->nombre;
                $nestedData['imagen'] = $producto->imagen;
                $nestedData['codigo_barras'] = $producto->codigo_barras;
                $nestedData['calidad'] = $producto->calidad;
                $nestedData['stock_minimo'] = $producto->stock_minimo;
               
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
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"years" => $this->Comun_model->get_records("years","estado=1"), 
			"modelos" => $this->Comun_model->get_records("modelos","estado=1 "), 
			"marcas" => $this->Comun_model->get_records("marcas","estado='1' ORDER BY nombre"), 
			"calidades" => $this->Comun_model->get_records("calidades","estado='1' ORDER BY nombre"), 
			"tipo_precios" => $this->Comun_model->get_records("precios","estado='1' ORDER BY nombre"), 
			"last_id" => $this->Productos_model->last_id()

		);
		$contenido_externo = array(
			"title" => "productos", 
			"contenido" => $this->load->view("admin/productos/add",$contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function store(){

		$codigo_barras = $this->input->post("codigo_barras");
		$calidad_id = $this->input->post("calidad_id");
		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");
		$stock_minimo = $this->input->post("stock_minimo");

		$marcas = $this->input->post("marcas");
		$modelos = $this->input->post("modelos");
		$range_year = $this->input->post("range_year");
		$year_until = $this->input->post("year_until");
		$year_from = $this->input->post("year_from");
		$idProductosA = $this->input->post("idProductosA");
		$cantidadesA = $this->input->post("cantidadesA");
		$idPrecios = $this->input->post("idPrecios");
		$preciosC = $this->input->post("preciosC");
		$preciosV = $this->input->post("preciosV");
		$compatibilidad = $this->input->post("compatibilidad");

		$this->form_validation->set_rules("nombre","Nombre","required|is_unique[productos.nombre]");

		if ($this->form_validation->run()==TRUE) {
			$data  = array(
				"nombre" => $nombre, 
				"descripcion" => $descripcion,
				"calidad_id" => $calidad_id,
				"stock_minimo" => $stock_minimo,
				"codigo_barras" => $codigo_barras,
				"estado" => "1",
				"compatibilidades" => $compatibilidad
			);
			$producto = $this->Comun_model->insert("productos", $data);
			if ($producto) {
				$imagen = 'image_default.jpg';
				if (!empty($_FILES['imagen']['name'])) {
					$config['upload_path']          = './assets/imagenes_productos/';
	                $config['allowed_types']        = 'gif|jpg|png';

	                $this->load->library('upload', $config);
	                if ($this->upload->do_upload('imagen'))
	                {
	  					$data = array('upload_data' => $this->upload->data());
	                    $imagen = $data['upload_data']['file_name'];
	                } 
				}
				$data  = array('imagen' => $imagen);
				$this->Comun_model->update("productos","id=".$producto->id,$data);
				$this->generateBarCode($codigo_barras);
				if ($compatibilidad && !empty($modelos)) {
					$this->saveCompatibilidades($producto->id,$modelos,$marcas,$range_year,$year_from,$year_until);
				}else{
					$data = array(
						'producto_id' => $producto->id,
					);
					$this->Comun_model->insert("compatibilidades",$data);
				}
				if (!empty($idProductosA)) {
					$this->saveAsociados($producto->id,$idProductosA,$cantidadesA);
				}
				if (!empty($idPrecios)) {
					$this->savePrecios($producto->id,$idPrecios,$preciosC,$preciosV);
				}
				
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
	protected function savePrecios($producto_id,$idPrecios,$preciosC,$preciosV){
		for ($i=0; $i < count($idPrecios) ; $i++) { 
			$data = array(
				'producto_id' => $producto_id, 
				'precio_id' => $idPrecios[$i],
				'precio_compra' => $preciosC[$i],
				'precio_venta' => $preciosV[$i],
				'estado' => '1'
			);
			$this->Comun_model->insert("producto_precio",$data);
		}
	}

	protected function saveCompatibilidades($producto_id,$modelos,$marcas,$range_year,$year_from,$year_until){

		for ($i=0; $i < count($modelos) ; $i++) { 
			$concat_year = "";
			if ($range_year[$i]) {
				for ($j=$year_from[$i]; $j <= $year_until[$i] ; $j++) { 
					$concat_year .= $j.",";
				}
			}else{
				$concat_year = $year_from[$i];
			}
			$data = array(
				'producto_id' => $producto_id, 
				'modelo_id' => $modelos[$i],
				'marca_id' => $marcas[$i],
				'range_year' => $range_year[$i],
				'year_from' => $year_from[$i],
				'year_until' => $year_until[$i],
				'concat_year' => $concat_year,
			);
			$this->Comun_model->insert("compatibilidades",$data);
		}
	}

	protected function saveAsociados($producto_id,$productosA, $cantidadesA){
		for ($i=0; $i < count($productosA) ; $i++) { 
			$data = array(
				'producto_original' => $producto_id, 
				'producto_asociado' => $productosA[$i],
				'cantidad' => $cantidadesA[$i]
			);
			$this->Comun_model->insert("productos_asociados",$data);
		}
	}

	public function edit($id){
		$producto = $this->Comun_model->get_record("productos","id=$id");
		$contenido_interno  = array(
			//"permisos" => $this->permisos,
			"producto" => $producto,
			"marcas" => $this->Comun_model->get_records("marcas","estado=1"), 
			"calidades" => $this->Comun_model->get_records("calidades","estado=1"), 
			"tipo_precios" => $this->Comun_model->get_records("precios","estado=1"), 
			"compatibilidades" => $this->Comun_model->get_records("compatibilidades","producto_id='$id'"),
			"productos_asociados" => $this->Comun_model->get_records("productos_asociados","producto_original='$id'"),
			"precios" => $this->Comun_model->get_records("producto_precio","producto_id='$id' and estado=1"),
		);

		$contenido_externo = array(
			"title" => "productos", 
			"contenido" => $this->load->view("admin/productos/edit", $contenido_interno, TRUE)
		);
		$this->load->view("admin/template",$contenido_externo);
	}

	public function update(){
		$idProducto = $this->input->post("idProducto");
		$codigo_barras = $this->input->post("codigo_barras");
		$calidad_id = $this->input->post("calidad_id");
		$nombre = $this->input->post("nombre");
		$descripcion = $this->input->post("descripcion");
		$stock_minimo = $this->input->post("stock_minimo");
		$compatibilidad = $this->input->post("compatibilidad");
		$marcas = $this->input->post("marcas");
		$modelos = $this->input->post("modelos");
		$range_year = $this->input->post("range_year");
		$year_until = $this->input->post("year_until");
		$year_from = $this->input->post("year_from");
		$idProductosA = $this->input->post("idProductosA");
		$cantidadesA = $this->input->post("cantidadesA");
		$idPrecios = $this->input->post("idPrecios");
		$preciosC = $this->input->post("preciosC");
		$preciosV = $this->input->post("preciosV");

		$productoActual = $this->Comun_model->get_record("productos","id=$idProducto");

		if ($nombre == $productoActual->nombre) {
			$is_unique_nombre = "";
		}else{
			$is_unique_nombre = "|is_unique[productos.nombre]";
		}

		$this->form_validation->set_rules("nombre","Nombre","required".$is_unique_nombre);

		if ($this->form_validation->run()==TRUE) {
			$producto = $this->Comun_model->get_record("productos","id='$idProducto'");
			
			$data = array(
				"nombre" => $nombre,
				"descripcion" => $descripcion,
				"calidad_id" => $calidad_id,
				"stock_minimo" => $stock_minimo,
				"codigo_barras" => $codigo_barras,
				"compatibilidades" => $compatibilidad
			);

			if ($this->Comun_model->update("productos","id=$idProducto",$data)) {
				$imagen = $producto->imagen;
				if (!empty($_FILES['imagen']['name'])) {
					$config['upload_path']          = './assets/imagenes_productos/';
	                $config['allowed_types']        = 'gif|jpg|png';

	                $this->load->library('upload', $config);
	                if ($this->upload->do_upload('imagen'))
	                {
	  					$data = array('upload_data' => $this->upload->data());
	                    $imagen = $data['upload_data']['file_name'];
	                    if ($producto->imagen != "image_default.jpg") {
	                    	unlink("assets/imagenes_productos/".$producto->imagen);
	                    }
	                    
	                } 
				}

				$data  = array('imagen' => $imagen);
				$this->Comun_model->update("productos","id=$idProducto",$data);
				$this->generateBarCode($codigo_barras);

				$this->Comun_model->delete("compatibilidades","producto_id='$idProducto'");
				$this->Comun_model->delete("productos_asociados","producto_original='$idProducto'");

				$this->Comun_model->delete("producto_precio","producto_id='$idProducto'");

				if ($compatibilidades && !empty($modelos)) {
					$this->saveCompatibilidades($producto->id,$modelos,$marcas,$range_year,$year_from,$year_until);
				} else{
					$data = array(
						'producto_id' => $producto->id,
					);
					$this->Comun_model->insert("compatibilidades",$data);
				}
				if (!empty($idProductosA)) {
					$this->saveAsociados($idProducto,$idProductosA,$cantidadesA);
				}
				if (!empty($idPrecios)) {
					$this->savePrecios($idProducto,$idPrecios,$preciosC,$preciosV);
				}
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
		$subcategorias = $this->Comun_model->get_records("subcategorias","categoria_id='$categoria_id' and estado=1");
		echo json_encode($subcategorias);
	}

	public function getProductos(){
		$valor = $this->input->post("valor");
		$productos = $this->Comun_model->get_records("productos","nombre LIKE '%".$valor."%' and estado=1");
		$data  = array();

        foreach ($productos as $p) {
            $dataProducto['id'] = $p->id;
            $dataProducto['nombre'] = $p->nombre;
            $dataProducto['label'] = $p->nombre;
            $data [] = $dataProducto;
        }
        echo json_encode($data);
	}

	public function getPrecios(){
		$valor = $this->input->post("valor");
		$precios = $this->Comun_model->get_records("precios","nombre LIKE '%".$valor."%' and estado=1");
		$data  = array();

        foreach ($precios as $p) {
            $dataPrecio['id'] = $p->id;
            $dataPrecio['nombre'] = $p->nombre;
            $dataPrecio['label'] = $p->nombre;
            $data [] = $dataPrecio;
        }
        echo json_encode($data);
	}

	protected function generateBarCode($codigo_barras){
		$this->load->library('zend');
	   	$this->zend->load('Zend/Barcode');
	   	$file = Zend_Barcode::draw('code128', 'image', array('text' => $codigo_barras), array());
	   	//$code = time().$code;
	   	$store_image = imagepng($file,"./assets/barcode/{$codigo_barras}.png");
	}

	public function get_modelos(){
		$marca_id = $this->input->post("marca_id");
		$modelos = $this->Comun_model->get_records("modelos", "marca_id='".$marca_id."' ORDER BY nombre");
		echo json_encode($modelos);
	}
}

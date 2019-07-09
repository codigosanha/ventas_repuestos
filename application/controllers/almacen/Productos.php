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
			"categorias" => $this->Comun_model->get_records("categorias","estado=1"), 
			"years" => $this->Comun_model->get_records("years","estado=1"), 
			"presentaciones" => $this->Comun_model->get_records("presentaciones","estado=1"), 
			"modelos" => $this->Comun_model->get_records("modelos","estado=1"), 
			"marcas" => $this->Comun_model->get_records("marcas","estado=1"), 
			"fabricantes" => $this->Comun_model->get_records("fabricantes","estado=1"), 
			"calidades" => $this->Comun_model->get_records("calidades","estado=1"), 
			"tipo_precios" => $this->Comun_model->get_records("precios","estado=1"), 

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
		$idProductosA = $this->input->post("idProductosA");
		$cantidadesA = $this->input->post("cantidadesA");
		$idPrecios = $this->input->post("idPrecios");
		$preciosC = $this->input->post("preciosC");
		$preciosV = $this->input->post("preciosV");

		$this->form_validation->set_rules("nombre","Nombre","required|is_unique[productos.nombre]");

		if ($this->form_validation->run()==TRUE) {
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
			$data  = array(
				"nombre" => $nombre, 
				"descripcion" => $descripcion,
				"fabricante_id" => $fabricante_id,
				"year_id" => $year_id,
				"marca_id" => $marca_id,
				"modelo_id" => $modelo_id,
				"calidad_id" => $calidad_id,
				"presentacion_id" => $presentacion_id,
				"stock_minimo" => $stock_minimo,
				"categoria_id" => $categoria_id,
				"subcategoria_id" => $subcategoria_id,
				"codigo_barras" => $codigo_barras,
				"imagen" => $imagen,
				"estado" => "1"
			);
			$producto = $this->Comun_model->insert("productos", $data);
			if ($producto) {
				$this->generateBarCode($codigo_barras);
				if (!empty($modelos)) {
					$this->saveCompatibilidades($producto->id,$modelos);
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

	protected function saveCompatibilidades($producto_id,$modelos){
		for ($i=0; $i < count($modelos) ; $i++) { 
			$data = array(
				'producto_id' => $producto_id, 
				'modelo_id' => $modelos[$i],
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
			"categorias" => $this->Comun_model->get_records("categorias","estado=1"),
			"subcategorias" => $this->Comun_model->get_records("subcategorias","categoria_id='$producto->categoria_id' and estado=1"),
			"years" => $this->Comun_model->get_records("years","estado=1"), 
			"presentaciones" => $this->Comun_model->get_records("presentaciones","estado=1"), 
			"modelos" => $this->Comun_model->get_records("modelos","estado=1"), 
			"marcas" => $this->Comun_model->get_records("marcas","estado=1"), 
			"fabricantes" => $this->Comun_model->get_records("fabricantes","estado=1"), 
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
			$imagen = $producto->imagen;
			if (!empty($_FILES['imagen']['name'])) {
				$config['upload_path']          = './assets/imagenes_productos/';
                $config['allowed_types']        = 'gif|jpg|png';

                $this->load->library('upload', $config);
                if ($this->upload->do_upload('imagen'))
                {
  					$data = array('upload_data' => $this->upload->data());
                    $imagen = $data['upload_data']['file_name'];
                    unlink("assets/imagenes_productos/".$producto->imagen);
                } 
			}
			$data = array(
				"nombre" => $nombre,
				"descripcion" => $descripcion,
				"fabricante_id" => $fabricante_id,
				"year_id" => $year_id,
				"marca_id" => $marca_id,
				"modelo_id" => $modelo_id,
				"calidad_id" => $calidad_id,
				"presentacion_id" => $presentacion_id,
				"stock_minimo" => $stock_minimo,
				"categoria_id" => $categoria_id,
				"subcategoria_id" => $subcategoria_id,
				"codigo_barras" => $codigo_barras,
				"imagen" => $imagen
			);

			if ($this->Comun_model->update("productos","id=$idProducto",$data)) {

				$this->generateBarCode($codigo_barras);

				$this->Comun_model->delete("compatibilidades","producto_id='$idProducto'");
				$this->Comun_model->delete("productos_asociados","producto_original='$idProducto'");

				$this->Comun_model->delete("producto_precio","producto_id='$idProducto'");

				if (!empty($modelos)) {
					$this->saveCompatibilidades($idProducto,$modelos);
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
		$subcategorias = $this->Comun_model->get_records("subcategorias","categoria_id='$categoria_id'");
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
}

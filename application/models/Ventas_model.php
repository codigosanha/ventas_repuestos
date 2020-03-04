<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ventas_model extends CI_Model {
	function __construct() {
        parent::__construct(); 
    }

    function allproducts_count2($bodega,$sucursal)
    {   
    	$this->db->where("bodega_id",$bodega);
    	$this->db->where("sucursal_id",$sucursal);
    	$query = $this->db->get("bodega_sucursal_producto");
        return $query->num_rows();  

    }
    
    function allproducts2($limit,$start,$col,$dir)
    {   
    	$this->db->
       $query = $this
                ->db
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get('clientes_juridicos');
        
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
    }
   
    function clients_search($limit,$start,$search,$col,$dir)
    {
        $query = $this
                ->db
                ->like('rnc',$search)
                ->or_like('razon_social',$search)
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get('clientes_juridicos');
        
       
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }

    function clients_search_count($search)
    {
        $query = $this
                ->db
                ->like('rnc',$search)
                ->or_like('razon_social',$search)
                ->get('clientes_juridicos');
    
        return $query->num_rows();
    } 

	public function getVentas(){
		$this->db->select("v.*,c.nombre,tc.nombre as tipocomprobante, u.nombres");
		$this->db->from("ventas v");
		$this->db->join("clientes c","v.cliente_id = c.id");
		$this->db->join("tipo_comprobante tc","v.tipo_comprobante_id = tc.id");
		$this->db->join("usuarios u","v.usuario_id = u.id");
		
		$resultados = $this->db->get();
		if ($resultados->num_rows() > 0) {
			return $resultados->result();
		}else
		{
			return false;
		}
	}
	public function getVentasbyDate($fechainicio,$fechafin){
		$this->db->select("v.*,c.nombre,tc.nombre as tipocomprobante, u.nombres");
		$this->db->from("ventas v");
		$this->db->join("clientes c","v.cliente_id = c.id");
		$this->db->join("tipo_comprobante tc","v.tipo_comprobante_id = tc.id");
		$this->db->join("usuarios u","v.usuario_id = u.id");
		$this->db->where("v.fecha >=",$fechainicio);
		$this->db->where("v.fecha <=",$fechafin);
		$resultados = $this->db->get();
		if ($resultados->num_rows() > 0) {
			return $resultados->result();
		}else
		{
			return false;
		}
	}

	public function getVenta($id){
		$this->db->select("v.*,c.nombre,c.direccion,c.telefono,c.num_documento as documento,tc.nombre as tipocomprobante,tc.serie,tc.iva as porcentaje");
		$this->db->from("ventas v");
		$this->db->join("clientes c","v.cliente_id = c.id");
		$this->db->join("tipo_comprobante tc","v.tipo_comprobante_id = tc.id");
		$this->db->where("v.id",$id);
		$resultado = $this->db->get();
		return $resultado->row();
	}

	public function getDetalle($id){
		$this->db->select("dt.*,p.codigo_barras,p.nombre,p.stock,m.nombre as marca");
		$this->db->from("detalle_venta dt");
		$this->db->join("productos p","dt.producto_id = p.id");
		$this->db->join("marca m","p.marca_id = m.id");
		$this->db->where("dt.venta_id",$id);
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function getComprobantes(){
		$resultados = $this->db->get("tipo_comprobante");
		return $resultados->result();
	}
	public function getTipoPagos(){
		$resultados = $this->db->get("tipo_pago");
		return $resultados->result();
	}

	public function getComprobante($idcomprobante){
		$this->db->where("id",$idcomprobante);
		$resultado = $this->db->get("tipo_comprobante");
		return $resultado->row();
	}


	public function getProductos($sucursal, $bodega, $valor){
		$this->db->select("bsp.*");
		$this->db->from("bodega_sucursal_producto bsp");
		$this->db->join("productos p", "bsp.producto_id = p.id");
		$this->db->where("bsp.sucursal_id",$sucursal);
		$this->db->where("bsp.bodega_id",$bodega);
		$this->db->where("bsp.stock >=",0);
		$this->db->where("bsp.estado",1);
		$this->db->like("CONCAT(p.codigo_barras,'',p.nombre)",$valor);
		$resultados = $this->db->get();
		return $resultados->result();
	}
	public function getPrecios($producto){
		$this->db->select("pp.*,p.nombre,p.seleccion_venta");
		$this->db->from("producto_precio pp");
		$this->db->join("precios p", "pp.precio_id = p.id");
		$this->db->where("pp.producto_id",$producto);
		$resultados = $this->db->get();
		return $resultados->result();
	}
	

	public function getProductoByCode($codigo_barra,$sucursal_id,$bodega_id){
		$this->db->select("bsp.*");
		$this->db->from("bodega_sucursal_producto bsp");
		$this->db->join("productos p", "bsp.producto_id = p.id");
		$this->db->where("bsp.sucursal_id", $sucursal_id);
		$this->db->where("bsp.bodega_id", $bodega_id);
		$this->db->where("p.codigo_barras", $codigo_barra);
		$this->db->where("bsp.stock >= ",0);
		$this->db->where("bsp.estado",1);
		$resultados = $this->db->get();
		if ($resultados->num_rows() > 0) {
			return $resultados->row();
		}else{
			return false;
		}
		
	}

	public function getproductosA($valor){
		$this->db->select("id,codigo_barras,nombre as label,precio,stock");
		$this->db->from("productos");
		$this->db->like("nombre",$valor);
		$resultados = $this->db->get();
		return $resultados->result_array();
	}

	public function save($data){
		return $this->db->insert("ventas",$data);
	}

	public function lastID(){
		return $this->db->insert_id();
	}

	public function updateComprobante($idcomprobante,$data){
		$this->db->where("id",$idcomprobante);
		$this->db->update("tipo_comprobante",$data);
	}

	public function save_detalle($data){
		$this->db->insert("detalle_venta",$data);
	}

	public function years(){
		$this->db->select("YEAR(fecha) as year");
		$this->db->from("ventas");
		$this->db->group_by("year");
		$this->db->order_by("year","desc");
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function montos(){
		$this->db->select("DATE(fecha) as fecha, SUM(total) as monto");
		$this->db->from("ventas");
		$this->db->where("estado","1");
		$this->db->group_by("DATE(fecha)");
		$this->db->order_by("DATE(fecha)");
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function montosMeses($year){
		$this->db->select("MONTH(fecha) as mes, SUM(total) as monto");
		$this->db->from("ventas");
		$this->db->where("fecha >=",$year."-01-01");
		$this->db->where("fecha <=",$year."-12-31");
		$this->db->where("estado","1");
		$this->db->group_by("mes");
		$this->db->order_by("mes");
		$resultados = $this->db->get();
		return $resultados->result();
	}


	public function savecliente($data){
		if ($this->db->insert("clientes",$data)) {
			return $this->db->insert_id();
		}
		else{
			return false;
		}
	}

	public function stockminimo(){
		$this->db->where("estado","1");
		$query = $this->db->get("productos");
		$return = array();

	    foreach ($query->result() as $producto)
	    {
	    	if ($producto->stock <= $producto->stock_minimo) {
	    		$return[$producto->id] = $producto;
	    	}
	        
	    }

	    return $return;

	}

	public function deleteDetail($id){
		$this->db->where("venta_id",$id);
		return $this->db->delete("detalle_venta");
	}

	public function update($id,$data){
		$this->db->where("id",$id);
		return $this->db->update("ventas",$data);
	}

	public function comprobarPassword($password){
		$this->db->where("clave_permiso", $password);
		$resultados  = $this->db->get("configuraciones");
		if ($resultados->num_rows() > 0) {
			return $resultados->row();
		}
		else{
			return false;
		}
	}

	public function saveNotificacion($data){
		$this->db->insert("notificaciones",$data);
	}

	public function updateNotificacion($id,$data){
		$this->db->where("id",$id);
		return $this->db->update("notificaciones",$data);
	}

	public function getProducts(){
		$this->db->select("p.*,c.nombre as categoria");
		$this->db->from("productos p");
		$this->db->join("categorias c","p.categoria_id = c.id");
		$this->db->where("p.estado","1");
		$resultados = $this->db->get();

		$productos = array();
		foreach ($resultados->result_array() as $resultado) {
			$productos[$resultado['id']] = $resultado;
		}

		return $productos;
	}

	public function productosVendidos($fechainicio, $fechafin){
		$this->db->select("p.id, p.nombre,SUM(dv.cantidad) as totalVendidos");
		$this->db->from("detalle_venta dv");
		$this->db->join("productos p", "dv.producto_id = p.id");
		$this->db->join("ventas v", "dv.venta_id = v.id");
		$this->db->where("DATE(v.fecha) >=", $fechainicio);
		$this->db->where("DATE(v.fecha) <=", $fechafin);
		if ($this->session->userdata("sucursal")) {
			$this->db->where("v.sucursal_id", $this->session->userdata("sucursal"));
		}
		$this->db->group_by("dv.producto_id");
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function getLastProductos(){
		$this->db->select("p.*");
		$this->db->from("productos p");
		$this->db->order_by('id',"desc");
		$this->db->limit(5);
		$resultados = $this->db->get();
		return $resultados->result();
	}
	
	public function getProductosStockMinimo(){
		$this->db->select("p.*");
		$this->db->from("productos p");

		$this->db->where("p.estado","1");
		$this->db->where("stock <", 10);
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function getProductosmasVendidos(){
		$this->db->select("p.id, p.codigo_barras, p.nombre, p.stock, p.precio,SUM(dv.cantidad) as totalVendidos");
		$this->db->from("detalle_venta dv");
		$this->db->join("productos p", "dv.producto_id = p.id");
		$this->db->join("ventas v", "dv.venta_id = v.id");
		
		$this->db->order_by("totalVendidos", "desc"); 
		$this->db->limit(10);
		$this->db->group_by("dv.producto_id");
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function searchProducto($sucursal_id,$bodega_id,$year,$marca,$modelo){
		$this->db->select("p.*,bsp.stock,bsp.localizacion,mar.nombre as marca,mod.nombre as modelo, c.year_from,c.year_until, c.range_year");
		$this->db->from("compatibilidades c");
		$this->db->join("productos p","c.producto_id = p.id");
		$this->db->join("bodega_sucursal_producto bsp","bsp.producto_id = p.id");
		$this->db->join("marcas mar","c.marca_id = mar.id", "left");
		$this->db->join("modelos mod","c.modelo_id = mod.id", "left");
		$this->db->where("bsp.sucursal_id",$sucursal_id);
		$this->db->where("bsp.bodega_id",$bodega_id);
		$this->db->where("p.estado","1");
		$this->db->where("bsp.estado","1");
		$this->db->where("bsp.stock >=", 1);
		if (!empty($year)) {
			$this->db->like("c.concat_year",$year);
		}
		if (!empty($marca)) {
			$this->db->where("c.marca_id",$marca);
		}
		if (!empty($modelo)) {
			$this->db->where("c.modelo_id",$modelo);
		}
		$this->db->group_by("c.producto_id");
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function getCompatibilidadesProducto($producto_id){
		$this->db->select("m.nombre");
		$this->db->from("compatibilidades c");
		$this->db->join("modelos m","c.modelo_id = m.id");
		$this->db->where("c.producto_id",$producto_id);
		$resultados = $this->db->get();
		return $resultados->result();
	}	


	function allproducts_count($year,$marca,$modelo,$sucursal_id,$bodega_id)
    {   
        $this->db->select("p.*");
		$this->db->from("compatibilidades c");
		$this->db->join("productos p","c.producto_id = p.id");
		$this->db->join("bodega_sucursal_producto bsp","bsp.producto_id = p.id");
		$this->db->join("marcas mar","c.marca_id = mar.id", "left");
		$this->db->join("modelos mod","c.modelo_id = mod.id", "left");
		$this->db->where("bsp.sucursal_id",$sucursal_id);
		$this->db->where("bsp.bodega_id",$bodega_id);
		$this->db->where("p.estado","1");
		$this->db->where("bsp.estado","1");
		$this->db->where("bsp.stock >=", 0);
		if (!empty($year)) {
			$this->db->like("c.concat_year",$year);
		}
		if (!empty($marca)) {
			$this->db->where("c.marca_id",$marca);
		}
		if (!empty($modelo)) {
			$this->db->where("c.modelo_id",$modelo);
		}
		$this->db->group_by("c.producto_id");
		$resultados = $this->db->get();
		return $resultados->num_rows();

    }
    
    function allproducts($limit,$start,$col,$dir,$year,$marca,$modelo,$sucursal_id,$bodega_id)
    {   


    	$this->db->select("p.*,bsp.stock,bsp.localizacion,mar.nombre as marca,mod.nombre as modelo, c.year_from,c.year_until, c.range_year");
		$this->db->from("compatibilidades c");
		$this->db->join("productos p","c.producto_id = p.id");
		$this->db->join("bodega_sucursal_producto bsp","bsp.producto_id = p.id");
		$this->db->join("marcas mar","c.marca_id = mar.id", "left");
		$this->db->join("modelos mod","c.modelo_id = mod.id", "left");
		$this->db->where("bsp.sucursal_id",$sucursal_id);
		$this->db->where("bsp.bodega_id",$bodega_id);
		$this->db->where("p.estado","1");
		$this->db->where("bsp.estado","1");
		$this->db->where("bsp.stock >=", 0);
		if (!empty($year)) {
			$this->db->like("c.concat_year",$year);
		}
		if (!empty($marca)) {
			$this->db->where("c.marca_id",$marca);
		}
		if (!empty($modelo)) {
			$this->db->where("c.modelo_id",$modelo);
		}
		$this->db->group_by("c.producto_id");
		$this->db->limit($limit,$start);
		$this->db->order_by($col,$dir);

		$resultados = $this->db->get();
       
        
        if($resultados->num_rows()>0)
        {
            return $resultados->result(); 
        }
        else
        {
            return null;
        }
        
    }
   
    function products_search($limit,$start,$search,$col,$dir,$year,$marca,$modelo,$sucursal_id,$bodega_id)
    {
    	$this->db->select("p.*,bsp.stock,bsp.localizacion,mar.nombre as marca,mod.nombre as modelo, c.year_from,c.year_until, c.range_year");
		$this->db->from("compatibilidades c");
		$this->db->join("productos p","c.producto_id = p.id");
		$this->db->join("bodega_sucursal_producto bsp","bsp.producto_id = p.id");
		$this->db->join("marcas mar","c.marca_id = mar.id", "left");
		$this->db->join("modelos mod","c.modelo_id = mod.id", "left");
		$this->db->where("bsp.sucursal_id",$sucursal_id);
		$this->db->where("bsp.bodega_id",$bodega_id);
		$this->db->where("p.estado","1");
		$this->db->where("bsp.estado","1");
		$this->db->where("bsp.stock >=", 0);
		if (!empty($year)) {
			$this->db->like("c.concat_year",$year);
		}
		if (!empty($marca)) {
			$this->db->where("c.marca_id",$marca);
		}
		if (!empty($modelo)) {
			$this->db->where("c.modelo_id",$modelo);
		}
		$this->db->like('p.nombre',$search);
		$this->db->or_like('p.codigo_barras',$search);
		$this->db->group_by("c.producto_id");
		$this->db->limit($limit,$start);
		$this->db->order_by($col,$dir);

		$resultados = $this->db->get();
       
        
        if($resultados->num_rows()>0)
        {
            return $resultados->result(); 
        }
        else
        {
            return null;
        }

      
    }

    function products_search_count($search,$year,$marca,$modelo,$sucursal_id,$bodega_id)
    {
       $this->db->select("p.*");
		$this->db->from("compatibilidades c");
		$this->db->join("productos p","c.producto_id = p.id");
		$this->db->join("bodega_sucursal_producto bsp","bsp.producto_id = p.id");
		$this->db->join("marcas mar","c.marca_id = mar.id", "left");
		$this->db->join("modelos mod","c.modelo_id = mod.id", "left");
		$this->db->where("bsp.sucursal_id",$sucursal_id);
		$this->db->where("bsp.bodega_id",$bodega_id);
		$this->db->where("p.estado","1");
		$this->db->where("bsp.estado","1");
		$this->db->where("bsp.stock >=", 0);
		if (!empty($year)) {
			$this->db->like("c.concat_year",$year);
		}
		if (!empty($marca)) {
			$this->db->where("c.marca_id",$marca);
		}
		if (!empty($modelo)) {
			$this->db->where("c.modelo_id",$modelo);
		}
		$this->db->like('p.nombre',$search);
		$this->db->or_like('p.codigo_barras',$search);
		$this->db->group_by("c.producto_id");


		$resultados = $this->db->get();
       
        
        if($resultados->num_rows()>0)
        {
            return $resultados->result(); 
        }
        else
        {
            return null;
        }
    } 

    public function getExistenciasProducto($producto_id){
    	$this->db->select("bsp.*, b.nombre as bodega, s.nombre as sucursal");
    	$this->db->from("bodega_sucursal_producto bsp");
    	$this->db->join("bodegas b", "bsp.bodega_id = b.id");
    	$this->db->join("sucursales s", "bsp.sucursal_id = s.id");
    	$this->db->where("bsp.producto_id", $producto_id);
    	$this->db->where("bsp.estado", "1");
    	$this->db->order_by("bsp.sucursal_id");
    	$resultados = $this->db->get();
    	return $resultados->result();
    }


}
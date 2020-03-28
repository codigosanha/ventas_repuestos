<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventario_model extends CI_Model {
	public function save($data){
		if ($this->db->insert("inventarios", $data)) {
			return $this->db->insert_id();
		}
		else{
			return false;
		}
	}
	public function saveDetalleInventario($data){
		return $this->db->insert("inventario_producto", $data);
	}

	public function getInventario($month, $year){
		$this->db->where("month",$month);
		$this->db->where("year", $year);
		$resultado = $this->db->get("inventarios");
		if ($resultado->num_rows() > 0) {
			return $resultado->row();
		}
		return false;
	}	

	public function getProductos($idinventario){
		$this->db->select("p.nombre, m.nombre as marca,ip.*");
		$this->db->from("inventario_producto ip");
		$this->db->join("productos p", "ip.producto_id = p.id");
		$this->db->join("marca m", "p.marca_id = m.id");
		$this->db->where("ip.inventario_id", $idinventario);
		$query = $this->db->get();
	    $return = array();

	    foreach ($query->result() as $producto)
	    {
	        $return[$producto->id] = $producto;
	        $return[$producto->id]->venta = $this->sumaVentas($producto->producto_id);
	        $return[$producto->id]->compra = $this->sumaCompras($producto->producto_id); // Get the categories sub categories
	    }

	    return $return;
	}
	public function sumaVentas($producto_id)
	{
	    $this->db->select("SUM(dv.cantidad) as total");
	    $this->db->from("detalle_venta dv");
	    $this->db->join("ventas v", "dv.venta_id = v.id");
	    $this->db->where("v.fecha >=","2018-10-01");
	    $this->db->where("v.fecha <=","2018-10-31");
	    $this->db->where("v.estado !=","0");
	    $this->db->where("dv.producto_id", $producto_id);
	    $this->db->group_by("dv.producto_id");
	    $resultado = $this->db->get();
	    if ($resultado->num_rows() > 0) {
	    	return $resultado->row()->total;
	    }
	    return 0;
	}

	public function sumaCompras($producto_id)
	{
	    $this->db->select("SUM(dc.cantidad) as total");
	    $this->db->from("detalle_compra dc");
	    $this->db->join("compras c", "dc.compra_id = c.id");
	    $this->db->where("c.fecha >=","2018-10-01");
	    $this->db->where("c.fecha <=","2018-10-31");
	    $this->db->where("dc.producto_id", $producto_id);
	    $this->db->group_by("dc.producto_id");
	    $resultado = $this->db->get();
	    if ($resultado->num_rows() > 0) {
	    	return $resultado->row()->total;
	    }

	    return 0;

	}

	public function years(){
		$this->db->select("year");
		$this->db->group_by("year");
		$this->db->order_by("year","desc");
		$resultados = $this->db->get("inventarios");
		return $resultados->result();
	}


	function allproductos_count()
    {   

        $this->db->select("bsp.*");
    	$this->db->from("bodega_sucursal_producto bsp");
    	if ($this->session->userdata("sucursal")) {
    		$this->db->where("bsp.sucursal_id", $this->session->userdata("sucursal"));
    	}
    	$query = $this->db->get();
    
        return $query->num_rows();  

    }
    
    function allproductos($limit,$start,$col,$dir)
    {   
    	$this->db->select("bsp.*");
    	$this->db->from("bodega_sucursal_producto bsp");
    	if ($this->session->userdata("sucursal")) {
    		$this->db->where("bsp.sucursal_id", $this->session->userdata("sucursal"));
    	}
    	$this->db->join("bodegas b", "bsp.bodega_id = b.id");
    	$this->db->join("sucursales s", "bsp.sucursal_id = s.id");
    	$this->db->join("productos p", "bsp.producto_id = p.id");
        	
    	$this->db->limit($limit,$start);
    	$this->db->order_by($col,$dir);
    	$query = $this->db->get();
      
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
    }
   
    function productos_search($limit,$start,$search,$col,$dir)
    {
    	$this->db->select("bsp.*");
    	$this->db->from("bodega_sucursal_producto bsp");
    	if ($this->session->userdata("sucursal")) {
    		$this->db->where("bsp.sucursal_id", $this->session->userdata("sucursal"));
    	}
    	$this->db->join("bodegas b", "bsp.bodega_id = b.id");
    	$this->db->join("sucursales s", "bsp.sucursal_id = s.id");
    	$this->db->join("productos p", "bsp.producto_id = p.id");

    	$this->db->like("p.nombre", $search);
    	$this->db->or_like("p.codigo_barras", $search);
    	$this->db->or_like("b.nombre", $search);
    	$this->db->or_like("s.nombre", $search);
    	$this->db->or_like("bsp.stock", $search);
    	$this->db->or_like("bsp.localizacion", $search);
    	$this->db->or_like("bsp.id", $search);

    	$this->db->limit($limit,$start);
    	$this->db->order_by($col,$dir);
    	$query = $this->db->get();
        
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }

    function productos_search_count($search)
    {
    	$this->db->select("bsp.*");
    	$this->db->from("bodega_sucursal_producto bsp");
    	if ($this->session->userdata("sucursal")) {
    		$this->db->where("bsp.sucursal_id", $this->session->userdata("sucursal"));
    	}
    	$this->db->join("bodegas b", "bsp.bodega_id = b.id");
    	$this->db->join("sucursales s", "bsp.sucursal_id = s.id");
    	$this->db->join("productos p", "bsp.producto_id = p.id");

    	$this->db->like("p.nombre", $search);
    	$this->db->or_like("p.codigo_barras", $search);
    	$this->db->or_like("b.nombre", $search);
    	$this->db->or_like("s.nombre", $search);
    	$this->db->or_like("bsp.stock", $search);
    	$this->db->or_like("bsp.localizacion", $search);
    	$this->db->or_like("bsp.id", $search);
    	
    	$query = $this->db->get();
        return $query->num_rows();
    } 

    public function last_id(){
       $last_row=$this->db->select('id')->order_by('id',"desc")->limit(1)->get('productos')->row();
       
       return $last_row->id;
    }

    public function saveInventario($data){
        return $this->db->insert_batch('bodega_sucursal_producto', $data); 
    }

    public function getProductosBySB($bodega_id, $sucursal_id){
        $this->db->select("bsp.producto_id,bsp.stock,bsp.id");
        $this->db->from("bodega_sucursal_producto bsp");
        $this->db->join("productos p","bsp.producto_id = p.id");
        $this->db->where("bsp.sucursal_id",$sucursal_id);
        $this->db->where("bsp.bodega_id",$bodega_id);
        $this->db->where("p.estado","1");
        $this->db->where("bsp.estado","1");

        $query = $this->db->get();

        $array = [];
        foreach ($query->result() as $bsp) {
            $array[] = [
                'producto' => $bsp->producto_id,
                'stock' => $bsp->stock,
                'bsp_id' => $bsp->id,
            ];
        }
        

        return $array;
    }

    public function getProductosNoRegistrados($bodega_id, $sucursal_id){
        $sql = "SELECT id FROM productos WHERE estado='1' AND id NOT IN (SELECT producto_id FROM bodega_sucursal_producto WHERE bodega_id ='$bodega_id' AND sucursal_id='$sucursal_id')";

        $query = $this->db->query($sql);
        $array = [];
        foreach ($query->result() as $row)
        {
            $array[] = $row->id;
        }
        return $array;
    }


}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajuste_model extends CI_Model {

	function allproducts_count($sucursal_id,$bodega_id)
    {   
        $this->db->select("bsp.id,bsp.producto_id,p.nombre, p.codigo_barras, bsp.stock, bsp.localizacion ");
		$this->db->from("bodega_sucursal_producto bsp");
		$this->db->join("productos p","bsp.producto_id = p.id");
		$this->db->where("bsp.sucursal_id",$sucursal_id);
		$this->db->where("bsp.bodega_id",$bodega_id);
		$this->db->where("p.estado","1");
		$this->db->where("bsp.estado","1");
		$resultados = $this->db->get();
		return $resultados->num_rows();

    }
    
    function allproducts($limit,$start,$col,$dir,$sucursal_id,$bodega_id)
    {   
    	$this->db->select("bsp.id,bsp.producto_id,p.nombre, p.codigo_barras, bsp.stock, bsp.localizacion ");
		$this->db->from("bodega_sucursal_producto bsp");
		$this->db->join("productos p","bsp.producto_id = p.id");
		$this->db->where("bsp.sucursal_id",$sucursal_id);
		$this->db->where("bsp.bodega_id",$bodega_id);
		$this->db->where("p.estado","1");
		$this->db->where("bsp.estado","1");
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
   
    function products_search($limit,$start,$search,$col,$dir,$sucursal_id,$bodega_id)
    {
    	$this->db->select("bsp.id,bsp.producto_id,p.nombre, p.codigo_barras, bsp.stock, bsp.localizacion ");
		$this->db->from("bodega_sucursal_producto bsp");
		$this->db->join("productos p","bsp.producto_id = p.id");
		$this->db->where("bsp.sucursal_id",$sucursal_id);
		$this->db->where("bsp.bodega_id",$bodega_id);
		$this->db->where("p.estado","1");
		$this->db->where("bsp.estado","1");
		$this->db->like('p.nombre',$search);
		$this->db->or_like('p.codigo_barras',$search);
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

    function products_search_count($search,$sucursal_id,$bodega_id)
    {
       	 $this->db->select("bsp.id,bsp.producto_id,p.nombre, p.codigo_barras, bsp.stock, bsp.localizacion ");
		$this->db->from("bodega_sucursal_producto bsp");
		$this->db->join("productos p","bsp.producto_id = p.id");
		$this->db->where("bsp.sucursal_id",$sucursal_id);
		$this->db->where("bsp.bodega_id",$bodega_id);
		$this->db->where("p.estado","1");
		$this->db->where("bsp.estado","1");
		$this->db->like('p.nombre',$search);
		$this->db->or_like('p.codigo_barras',$search);

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

    function productosBySucursalBodega($sucursal_id,$bodega_id)
    {
    	$this->db->select("bsp.id,bsp.producto_id,p.nombre, p.codigo_barras, bsp.stock, bsp.localizacion ");
		$this->db->from("bodega_sucursal_producto bsp");
		$this->db->join("productos p","bsp.producto_id = p.id");
		$this->db->where("bsp.sucursal_id",$sucursal_id);
		$this->db->where("bsp.bodega_id",$bodega_id);
		$this->db->where("p.estado","1");
		$this->db->where("bsp.estado","1");
		

		$this->db->order_by("p.nombre","asc");

		$resultados = $this->db->get();
        return $resultados->result(); 
    }

    public function saveAjusteProductos($data){
    	return $this->db->insert_batch('ajustes_productos', $data); 
    }
    public function updateStockProductos($data){
    	$this->db->update_batch('bodega_sucursal_producto',$data, 'id');
    }

}

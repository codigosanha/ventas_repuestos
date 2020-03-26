<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Traslados_model extends CI_Model {

	function allproducts_count($sucursal_id,$bodega_id)
    {   
        $this->db->select("bsp.producto_id,p.nombre, p.codigo_barras, ");
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
    	$this->db->select("bsp.producto_id,p.nombre, p.codigo_barras, ");
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
    	$this->db->select("bsp.producto_id,p.nombre, p.codigo_barras, ");
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
       	 $this->db->select("bsp.producto_id,p.nombre, p.codigo_barras, ");
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

    public function getIdProductosSBE($bodega_id, $sucursal_id){
    	$this->db->select("p.id");
    	$this->db->from("bodega_sucursal_producto bsp");
		$this->db->join("productos p","bsp.producto_id = p.id");
		$this->db->where("bsp.sucursal_id",$sucursal_id);
		$this->db->where("bsp.bodega_id",$bodega_id);
		$this->db->where("p.estado","1");
		$this->db->where("bsp.estado","1");

		$query = $this->db->get();

		$array = [];
		foreach ($query->result() as $producto) {
			$array[] = $producto->id;
		}
		

		return $array;
    }
}
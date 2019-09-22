<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos_model extends CI_Model {

	public function getProductos($search){
		$this->db->like('nombre', $search);
		$this->db->where("estado",1);
		$resultados = $this->db->get("productos");
		return $resultados->result();
	}

	function allproductos_count()
    {   
        $this->db->select("p.*,c.nombre as calidad");
    	$this->db->from("productos p");
    	$this->db->join("calidades c", "p.calidad_id = c.id");
    	$query = $this->db->get();
    
        return $query->num_rows();  

    }
    
    function allproductos($limit,$start,$col,$dir)
    {   
    	$this->db->select("p.*,c.nombre as calidad");
    	$this->db->from("productos p");
    	$this->db->join("calidades c", "p.calidad_id = c.id");
    	
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
    	$this->db->select("p.*,c.nombre as calidad");
    	$this->db->from("productos p");
    	$this->db->join("calidades c", "p.calidad_id = c.id");
    	$this->db->like("p.nombre", $search);
    	$this->db->or_like("p.stock_minimo", $search);
    	$this->db->or_like("c.nombre", $search);
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
    	$this->db->select("p.*,c.nombre as calidad");
    	$this->db->from("productos p");
    	$this->db->join("calidades c", "p.calidad_id = c.id");
    	$this->db->like("p.nombre", $search);
    	$this->db->or_like("p.stock_minimo", $search);
    	$this->db->or_like("c.nombre", $search);
    	
    	$query = $this->db->get();
        return $query->num_rows();
    } 

   

}
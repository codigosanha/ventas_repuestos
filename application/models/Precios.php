<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Precios_model extends CI_Model {

	public function getProductos($search){
		$this->db->like('nombre', $search);
		$this->db->where("estado",1);
		$resultados = $this->db->get("productos");
		return $resultados->result();
	}

}
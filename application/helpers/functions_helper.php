
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
if(!function_exists('getCategoria'))
{
	function getCategoria($categoria_id)
	{
	    //asignamos a $ci el super objeto de codeigniter
		//$ci será como $this
		$ci =& get_instance();
		$ci->db->where('id',$categoria_id);
		$query = $ci->db->get('categorias');
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return false;
	 
	}
}

if(!function_exists('get_record'))
{
	function get_record($table,$where = '')
	{
	    //asignamos a $ci el super objeto de codeigniter
		//$ci será como $this
		$ci =& get_instance();
		if ($where) {
			$ci->db->where($where);
		}
		$query = $ci->db->get($table);
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return false;
	 
	}
}


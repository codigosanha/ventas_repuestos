
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

if(!function_exists('get_records'))
{
	function get_records($table,$where = '')
	{
	    //asignamos a $ci el super objeto de codeigniter
		//$ci será como $this
		$ci =& get_instance();
		if ($where) {
			$ci->db->where($where);
		}
		$query = $ci->db->get($table);
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return array();
	 
	}
}

if(!function_exists('getNumeroVentas'))
{
	function getNumeroVentas($idCaja)
	{
	    //asignamos a $ci el super objeto de codeigniter
		//$ci será como $this
		$ci =& get_instance();

		$ci->db->where('caja_id',$idCaja);
		$query = $ci->db->get('ventas');
		return $query->num_rows();
	 
	}
}

if(!function_exists('getMontoVentas'))
{
	function getMontoVentas($idCaja)
	{
	    //asignamos a $ci el super objeto de codeigniter
		//$ci será como $this
		$ci =& get_instance();
		$ci->db->select('SUM(total) as total');
		$ci->db->from('ventas');
		$ci->db->where('caja_id',$idCaja);
		$ci->db->group_by('caja_id');
		$query = $ci->db->get();
		if ($query->num_rows() > 0 ) {
			return number_format($query->row()->total, 2, '.', '');
		}
		return '0.00';
	 
	}
}

if(!function_exists('getMontos'))
{
	function getMontos($campo,$idCaja)
	{
	    //asignamos a $ci el super objeto de codeigniter
		//$ci será como $this
		$ci =& get_instance();
		$ci->db->select('SUM('.$campo.') as total');
		$ci->db->from('ventas');
		$ci->db->where('caja_id',$idCaja);
		$ci->db->group_by('caja_id');
		$query = $ci->db->get();
		if ($query->num_rows() > 0 ) {
			return number_format($query->row()->total, 2, '.', '');
		}
		return '0.00';
	 
	}
}
if(!function_exists('getTotalDescuentos'))
{
	function getTotalDescuentos($idCaja)
	{
	    //asignamos a $ci el super objeto de codeigniter
		//$ci será como $this
		$ci =& get_instance();
		$ci->db->select('SUM(descuento) as total');
		$ci->db->from('ventas');
		$ci->db->where('caja_id',$idCaja);
		$ci->db->group_by('caja_id');
		$query = $ci->db->get();
		if ($query->num_rows() > 0 ) {
			return number_format($query->row()->total, 2, '.', '');
		}
		return '0.00';
	 
	}
}

if(!function_exists('getGastos'))
{
	function getGastos($idCaja)
	{
	    //asignamos a $ci el super objeto de codeigniter
		//$ci será como $this
		$ci =& get_instance();
		$ci->db->select('SUM(monto) as monto');
		$ci->db->from('gastos');
		$ci->db->where('caja_id',$idCaja);
		$ci->db->group_by('caja_id');
		$query = $ci->db->get();
		if ($query->num_rows() > 0 ) {
			return $query->row()->monto;
		}
		return '0.00';
	 
	}
}
if(!function_exists('getTotalAbonos'))
{
	function getTotalAbonos($idCuenta)
	{
	    //asignamos a $ci el super objeto de codeigniter
		//$ci será como $this
		$ci =& get_instance();

		$ci->db->where('cuenta_cobrar_id',$idCuenta);
		$query = $ci->db->get('cobros');
		$total = 0;
		foreach ($query->result() as $row) {
			$total = $total + $row->monto;
		}

		return $total;
	 
	}
}

if(!function_exists('getTotalAbonosProveedores'))
{
	function getTotalAbonosProveedores($idCuenta)
	{
	    //asignamos a $ci el super objeto de codeigniter
		//$ci será como $this
		$ci =& get_instance();

		$ci->db->where('cuenta_pagar_id',$idCuenta);
		$query = $ci->db->get('pagos');
		$total = 0;
		foreach ($query->result() as $row) {
			$total = $total + $row->monto;
		}

		return $total;
	 
	}
}
if(!function_exists('getTotalTarjeta'))
{
	function getTotalTarjeta($idCaja,$idTarjeta)
	{
	    //asignamos a $ci el super objeto de codeigniter
		//$ci será como $this
		$ci =& get_instance();
		$ci->db->select('SUM(monto_tarjeta) as total');
		$ci->db->from('ventas');
		$ci->db->where('caja_id',$idCaja);
		$ci->db->where('tarjeta_id',$idTarjeta);
		$ci->db->group_by('caja_id');
		$query = $ci->db->get();
		if ($query->num_rows() > 0 ) {
			return number_format($query->row()->total, 2, '.', '');
		}
		return '0.00';
	 
	}
}
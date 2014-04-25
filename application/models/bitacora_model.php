<?php

/**
 * 
 * 
 * @author Jesus Rodriguez
 * @version 
 */	

class Bitacora_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
 function get_logs($num, $offset) {
 	$select = "usuario.usuario, bitacora.ip, bitacora.url, bitacora.modulo, bitacora.accion, 
			   bitacora.detalle, to_char(bitacora.fecha_creacion, 'DD-MM-YYYY a las HH:MI AM') " ;
	$this->db->select($select, FALSE); 
  	$this->db->join('usuario', 'bitacora.id_usuario = usuario.id_usuario', 'left');
  	$this->db->order_by("bitacora.id_bitacora", "DESC"); 
	$query = $this->db->get('bitacora',$num, $offset);
	#$this->db->select("id, url, accion, desc"); 
 	#$query = $this->db->get('view_log', $num, $offset);	
    return $query;
  }
  
  function get_logs_user($id, $num, $offset){
  	$select = "usuario.usuario, bitacora.ip, bitacora.url, bitacora.modulo, bitacora.accion, 
			   bitacora.detalle, to_char(bitacora.fecha_creacion, 'DD-MM-YYYY a las HH:MI AM') " ;
	$this->db->select($select, FALSE); 
  	$this->db->join('usuario', 'bitacora.id_usuario = usuario.id_usuario', 'left');
  	$this->db->order_by("bitacora.id_bitacora", "DESC"); 
	$query = $this->db->get_where('bitacora', array('bitacora.id_usuario' => $id), $num, $offset);
			
	$data = $query->result_array();
	$num_rows = $query->num_rows();
	if ($num_rows > 0 )
		return $data ;
	else 
		return 0;			
  }
  
  function count_logs_user($id_usuario) {
	$sql = "SELECT COUNT(id_usuario) as logs FROM bitacora WHERE id_usuario = $id_usuario" ;
	#die($sql) ;
  	$query = $this->db->query($sql);
  	$logs = $query->row();
  	return $logs->logs; 
  }

}
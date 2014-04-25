<?php

/**
* 
* @package  Sipres 
* @category Model CodeIgniter 
* @uses     Acciones asociadas al Modelo en cuestión
* @author   Jesus A. Rodriguez R. en <jesus.rodriguez937@mppre.gob.ve>
* @since    31/03/2014 a las 10:06:45 AM
*
*/

class Maestro_model extends CI_Model {

	function __construct()	{
        parent::__construct();  		
    }
    
	function get_detalle ($tabla) {		
		//$this->db->order_by($nombre_campo, "ASC");
		$this->db->select("id_$tabla as id, nombre_$tabla as nombre");
		$query = $this->db->get($tabla);
		$data = $query->result_array();
		return $data ; 		
	}
	
	function duplicado() {
		$id_tabla		= $this->input->post('id_tabla') ;
		$nombre		 	= strtoupper(trim($this->input->post('nombre'))) ;
		$nombre_tabla	= $this->maestro[$id_tabla]['nombre_tabla'];		
		$query = $this->db->get_where($nombre_tabla, array("nombre_$nombre_tabla" => $nombre));
		#die('Valor: '.$query->num_rows);
		if ($query->num_rows() >= 1) {
			return true; 
		}
		return false;
	}    
	
	function agregar(){
		$id_tabla		= $this->input->post('id_tabla') ;
		$nombre		 	= to_mayuscula(trim($this->input->post('nombre'))) ;
		$nombre_tabla	= $this->maestro[$id_tabla]['nombre_tabla'];
		$id 			= $this->input->post('id_row') ; 				
		$row 			= array("nombre_$nombre_tabla" => $nombre);		
		$insert = $this->db->insert($nombre_tabla, $row);		
		#return $this->db->affected_rows();
		return $this->db->insert_id();
	}
	
	function modificar(){
		$id				= $this->input->post('id_row') ;
		$id_tabla		= $this->input->post('id_tabla') ;
		$nombre		 	= to_mayuscula(trim($this->input->post('nombre'))) ;
		$nombre_tabla	= $this->maestro[$id_tabla]['nombre_tabla'];				
		$row 			= array("nombre_$nombre_tabla" => $nombre);
						
		$query = $this->db->get_where($nombre_tabla, array("id_$nombre_tabla" => $id), 1);

		if ($query->num_rows() > 1) {
			return false; 
		}
		else {
			$this->db->where("id_$nombre_tabla", $id);		
			$update = $this->db->update($nombre_tabla, $row);		
			return $this->db->affected_rows();
		}		
	}


	function get_registro($tabla, $criterio){		 		
  		$query = $this->db->get_where($tabla, $criterio, 1); 		
		$data = $query->row();
		return $data ; 		
	}

	function update_record($tabla, $campos, $criterio){
		$row 			= $campos;		
		$this->db->where($criterio);		
		$update = $this->db->update($tabla, $row);		
		return $this->db->affected_rows();	
	}	
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
* @package  Sipres 
* @category Model CodeIgniter  
* @uses     Acciones asociadas en base de datos del modelo en cuestión
* @author   Jesus A. Rodriguez R. en <jesus.rodriguez937@mppre.gob.ve>
* @since    20/03/2014 a las 03:13:04 PM
*
*/

class Heredero_model extends CI_Model {
    function __construct()	{
        parent::__construct();         
    }
    
	function get_list($id_tramite) {		
		$sql = "
		SELECT
		h.id_heredero, h.nombres, h.apellidos, h.cedula, p.nombre_parentesco as parentesco, b.nombre_banco as banco,
		h.num_cheque, h.monto as monto,
		u.usuario, TO_CHAR(h.fecha_creacion, 'DD-MM-YYYY HH:MI AM') as fecha_creacion,
		TO_CHAR(h.fecha_emision, 'DD-MM-YYYY') as fecha_emision,
		TO_CHAR(h.fecha_entrega, 'DD-MM-YYYY') as fecha_entrega
		FROM herederos h 
		LEFT JOIN parentesco p ON (p.id_parentesco = h.id_parentesco)
		LEFT JOIN banco b ON (b.id_banco = h.id_banco)
		INNER JOIN usuario u ON (u.id_usuario = h.id_usuario)
		WHERE h.id_tramite = $id_tramite	";
		$row = $this->db->query($sql);
		if ($row->num_rows() > 0)	
			return $row->result();
		else
			return FALSE;
	}
	
	function get_list_($id_tramite) {		
		$sql = "
		SELECT
		h.id_heredero, h.nombres, h.apellidos, h.cedula, p.nombre_parentesco as parentesco, b.nombre_banco as banco,
		h.num_cheque, trim(to_char(h.monto,'99999999999999999D99')) as monto,
		u.usuario, TO_CHAR(h.fecha_creacion, 'DD-MM-YYYY HH:MI AM') as fecha_creacion,
		TO_CHAR(h.fecha_emision, 'DD-MM-YYYY') as fecha_emision,
		TO_CHAR(h.fecha_entrega, 'DD-MM-YYYY') as fecha_entrega
		FROM herederos h 
		LEFT JOIN parentesco p ON (p.id_parentesco = h.id_parentesco)
		LEFT JOIN banco b ON (b.id_banco = h.id_banco)
		INNER JOIN usuario u ON (u.id_usuario = h.id_usuario)
		WHERE h.id_tramite = $id_tramite	";
		$row = $this->db->query($sql);
		if ($row->num_rows() > 0)	
			return $row->result_array();
		else
			return FALSE;
	}
    
	function insertar() {		
		$row = array(
			'id_tramite'		=> (int) $this->input->post('id_tramite_h'),
			'cedula'			=>	to_mayuscula($this->input->post('cedula_h')),
			'nombres'			=>	to_mayuscula($this->input->post('nombres_h')),
			'apellidos'			=>	to_mayuscula($this->input->post('apellidos_h')),
			'id_parentesco'		=> (int) $this->input->post('id_parentesco'),
			'id_banco'			=> (int) $this->input->post('id_banco_h'),
			'num_cheque'		=>	to_mayuscula($this->input->post('num_cheque_h')),
			'monto'				=>	to_moneda_bd($this->input->post('monto_cheque_h')),
			'fecha_emision'	=>	date_to_pg($this->input->post('fecha_emision_h')),
			'fecha_entrega'	=>	date_to_pg($this->input->post('fecha_entrega_h')),
			'id_usuario'		=>	(int) $this->session->userdata('id_usuario')
		) ;
		$this->db->insert('herederos', $row);			
		if ($this->db->affected_rows()>0)
			return $this->db->insert_id();
		else 
			return FALSE;	
		
	} 
	
    function eliminar($id_heredero) {
		 $this->db->delete('herederos', array('id_heredero' => $id_heredero)); 
		 if ($this->db->affected_rows()>0)
			return TRUE;
		else 
			return FALSE;
	}
	
	function actualizar() {
		$id_tramite		= $this->input->post('id_tramite_h') ;
		$id_heredero	= $this->input->post('id_heredero') ;
		$row = array(			
			'cedula'			=>	to_mayuscula($this->input->post('cedula_h')),
			'nombres'			=>	to_mayuscula($this->input->post('nombres_h')),
			'apellidos'			=>	to_mayuscula($this->input->post('apellidos_h')),
			'id_parentesco'		=> (int) $this->input->post('id_parentesco'),
			'id_banco'			=> (int) $this->input->post('id_banco_h'),
			'num_cheque'		=>	to_mayuscula($this->input->post('num_cheque_h')),
			'monto'				=>	to_moneda_bd($this->input->post('monto_cheque_h')),
			'fecha_emision'	=>	date_to_pg($this->input->post('fecha_emision_h')),
			'fecha_entrega'	=>	date_to_pg($this->input->post('fecha_entrega_h'))
		) ;
		$this->db->where('id_heredero',$id_heredero);
		$update = $this->db->update('herederos', $row);
		if ($this->db->affected_rows()>0)
			return TRUE ;
		else 
			return FALSE ;	
	}
	
	function get($id_heredero) {
		$sql = "
		SELECT
		h.id_heredero, h.nombres, h.apellidos, h.cedula, 
		h.id_parentesco, p.nombre_parentesco as parentesco,
		h.id_banco, b.nombre_banco as banco,
		h.num_cheque, h.monto as monto,
		TO_CHAR(h.fecha_emision, 'DD-MM-YYYY') as fecha_emision,
		TO_CHAR(h.fecha_entrega, 'DD-MM-YYYY') as fecha_entrega,
		h.id_usuario,u.usuario, 
		TO_CHAR(h.fecha_creacion, 'DD-MM-YYYY HH:MI AM') as fecha_creacion
		FROM herederos h 
		LEFT JOIN parentesco p ON (p.id_parentesco = h.id_parentesco)
		LEFT JOIN banco b ON (b.id_banco = h.id_banco)
		INNER JOIN usuario u ON (u.id_usuario = h.id_usuario)
		WHERE h.id_heredero =  $id_heredero";
		$rs = $this->db->query($sql);
		if ($rs->num_rows() > 0)	
			return   $rs->row(); 
		else
			return FALSE;
	}
	
}

/* End of file heredero_model.php */
/* Location: /application/models/heredero_model.php */
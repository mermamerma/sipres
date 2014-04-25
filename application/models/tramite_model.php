<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
* @package  Sipres 
* @category Model CodeIgniter  
* @uses     Acciones asociadas en base de datos del modelo en cuestión
* @author   Jesus A. Rodriguez R. en <jesus.rodriguez937@mppre.gob.ve>
* @since    17/03/2014 a las 11:01:39 AM
*
*/

class Tramite_model extends CI_Model {
    function __construct()	{
        parent::__construct();         
    }
    
    function get_lista($cedula) {		
		$sql = "
		SELECT t.id_tramite, t.cedula, t.id_trabajador, t.id_empleado, TO_CHAR(t.fecha_inicio, 'DD-MM-YYYY HH:MI AM') AS fecha_creacion, 
		et.nombre_estatus_tramite AS estatus, CASE WHEN t.id_trabajador > 0 AND t.id_empleado = 0 THEN 'SIGEFIRRHH' ELSE 'RRHH' END AS ORIGEN,
		u.usuario, u_asig.usuario as usuario_asignado
		FROM tramite t 
		LEFT JOIN estatus_tramite et ON (et.id_estatus_tramite = t.id_estatus_tramite ) 
		LEFT JOIN usuario u ON (u.id_usuario = t.id_usuario) 
		LEFT JOIN usuario u_asig ON (u_asig.id_usuario = t.id_usuario_asignado) 
		WHERE t.cedula = '$cedula'	";
		$row = $this->db->query($sql);
		if ($row->num_rows() > 0)	
			return $row->result();
		else
			return FALSE;
	}
    
	function insertar() {
		$id_trabajador	= $this->input->post('id_trabajador');
		$id_empleado	= $this->input->post('id_empleado');
		$id_cedula		= $this->input->post('id_cedula');
		
		$row = array(
		# Datos Trabajador
		'id_trabajador'			=>	(int) $id_trabajador,
		'id_empleado'			=>	(int) $id_empleado,
		'cedula'				=>	$id_cedula,
		'fecha_ingreso'			=>	date_to_pg($this->input->post('fecha_ingreso')),
		'fecha_egreso'			=>	date_to_pg($this->input->post('fecha_egreso')),
		'telf_residencial'		=>	$this->input->post('telf_residencial'),			
		'telf_celular'			=>	$this->input->post('telf_celular'),
		'correo_alt'			=>	$this->input->post('correo_alt'),
		'fecha_ingreso'			=>	date_to_pg($this->input->post('fecha_ingreso')),
		'fecha_egreso'			=>	date_to_pg($this->input->post('fecha_egreso')),
		# Datos Trámite
		'id_estatus_tramite'	=>	(int) $this->input->post('id_estatus_tramite'),
		'id_motivo_egreso'		=>	(int) $this->input->post('id_motivo_egreso'),
		'id_usuario_asignado'	=>	(int) $this->input->post('id_usuario_asignado'),
		# 'fecha_inicio'		=>	por defecto función now() en la BD,
		'fecha_asignacion'		=>	date_to_pg($this->input->post('fecha_asignacion')),
		'num_djp'				=>	$this->input->post('num_djp'),
		'fecha_djp'				=>	date_to_pg($this->input->post('fecha_djp')),
		'monto_viejo_regimen'	=>	to_moneda_bd($this->input->post('monto_viejo_regimen')),  
		'monto_ley_mayo'		=>	to_moneda_bd($this->input->post('monto_ley_mayo')),
		'monto_prest_fide'		=>	to_moneda_bd($this->input->post('monto_prest_fide')),
		'monto_total_prest'		=>	to_moneda_bd($this->input->post('monto_total_prest')),
		'observaciones'			=>	str_replace("\r\n"," ",$this->input->post('observaciones')),
		# Movimientos MRE
		'fecha_firma_coord'		=>	date_to_pg($this->input->post('fecha_firma_coord')),
		'fecha_firma_dir'		=>	date_to_pg($this->input->post('fecha_firma_dir')),
		'fecha_firma_dir_gral'	=>	date_to_pg($this->input->post('fecha_firma_dir_gral')),
		'fecha_env_admin'		=>	date_to_pg($this->input->post('fecha_env_admin')),
		'fecha_env_acreencia'	=>	date_to_pg($this->input->post('fecha_env_acreencia')),
		# Movimientos MINFI
		'num_memo_admin'		=>	$this->input->post('num_memo_admin'),
		'nun_memo_env_fnza'		=>	$this->input->post('nun_memo_env_fnza'),
		'fecha_env_fnza_pri_vez'=>	date_to_pg($this->input->post('fecha_env_fnza_pri_vez')),
		'fecha_devol_fnza'		=>	date_to_pg($this->input->post('fecha_devol_fnza')),
		'num_memo_sgd_vez_fnza'	=>	$this->input->post('num_memo_sgd_vez_fnza'),
		'fecha_env_fnza_sgd_vez'=>	date_to_pg($this->input->post('fecha_env_fnza_sgd_vez')),
		# Movimientos Cierre
		'num_memo_env_psto'		=>	$this->input->post('num_memo_env_psto'),
		'fecha_env_psto'		=>	date_to_pg($this->input->post('fecha_env_psto')),
		'disp_bs'				=>	to_moneda_bd($this->input->post('disp_bs')),
		'num_memo_sin_disp'		=>	$this->input->post('num_memo_sin_disp'),		
		'fecha_devol_sin_disp'	=>	date_to_pg($this->input->post('fecha_devol_sin_disp')),		
		'fecha_env_exp'			=>	date_to_pg($this->input->post('fecha_env_exp')),
		# Tipo de Pago
		'id_tipo_pago'			=>	(int) $this->input->post('id_tipo_pago'),
		# Datos Cheque
		'fecha_remision_chq'	=>	date_to_pg($this->input->post('fecha_remision_chq')),
		'num_listado'			=>	$this->input->post('num_listado'),
		'fecha_listado'			=>	date_to_pg($this->input->post('fecha_listado')),
		'id_banco_cheque'		=>	(int) $this->input->post('id_banco_cheque'),
		'num_cheque'			=>	$this->input->post('num_cheque'),
		'monto_cheque'			=>	to_moneda_bd($this->input->post('monto_cheque')),
		'fecha_entrg_benefi'	=>	date_to_pg($this->input->post('fecha_entrg_benefi')),
		# Datos Transferencia
		'id_banco_transfe'		=>	(int) $this->input->post('id_banco_transfe'),
		'num_cta_transfe'		=>	$this->input->post('num_cta_transfe'),
		'monto_transfe'			=>	to_moneda_bd($this->input->post('monto_trasnfe')),
		'fecha_transfe'			=>	date_to_pg($this->input->post('fecha_transfe')),
		'num_confirm_transfe'	=>	$this->input->post('num_confirm_transfe'),
		# Datos Cierre
		'num_memo_cierre'		=>	$this->input->post('num_memo_cierre'),
		'fecha_memo_cierre'		=>	date_to_pg($this->input->post('fecha_memo_cierre')),
		'vvnd_bvf'				=>	to_moneda_bd($this->input->post('vvnd_bvf')),
		'fecha_pago_vaca'		=>	date_to_pg($this->input->post('fecha_pago_vaca')),
		'id_tipo_pago_vaca'		=>	(int) $this->input->post('id_tipo_pago_vaca'),
		'id_usuario'			=>	(int) $this->session->userdata('id_usuario')				
		);	
		//var_dump($row); exit;
		$this->db->insert('tramite', $row);	
		#die($this->db->last_query());
		if ($this->db->affected_rows()>0)
			return $this->db->insert_id();
		else 
			return FALSE;		
	}
	
	function actualizar() {
		$id_tramite		= (int) $this->input->post('id_tramite') ;
		$id_trabajador	= (int) $this->input->post('id_trabajador');
		$id_empleado	= (int) $this->input->post('id_empleado');
		$id_cedula		= $this->input->post('id_cedula');
		
		$row = array(
		# Datos Trabajador
		'id_trabajador'			=>	(int) $id_trabajador,
		'id_empleado'			=>	(int) $id_empleado,
		'cedula'				=>	$id_cedula,
		'fecha_ingreso'			=>	date_to_pg($this->input->post('fecha_ingreso')),
		'fecha_egreso'			=>	date_to_pg($this->input->post('fecha_egreso')),
		'telf_residencial'		=>	$this->input->post('telf_residencial'),			
		'telf_celular'			=>	$this->input->post('telf_celular'),
		'correo_alt'			=>	$this->input->post('correo_alt'),
		'fecha_ingreso'			=>	date_to_pg($this->input->post('fecha_ingreso')),
		'fecha_egreso'			=>	date_to_pg($this->input->post('fecha_egreso')),
		# Datos Trámite
		'id_estatus_tramite'	=>	(int) $this->input->post('id_estatus_tramite'),
		'id_motivo_egreso'		=>	(int) $this->input->post('id_motivo_egreso'),
		'id_usuario_asignado'	=>	(int) $this->input->post('id_usuario_asignado'),		
		'fecha_asignacion'		=>	date_to_pg($this->input->post('fecha_asignacion')),
		'num_djp'				=>	$this->input->post('num_djp'),
		'fecha_djp'				=>	date_to_pg($this->input->post('fecha_djp')),
		'monto_viejo_regimen'	=>	to_moneda_bd($this->input->post('monto_viejo_regimen')),  
		'monto_ley_mayo'		=>	to_moneda_bd($this->input->post('monto_ley_mayo')),
		'monto_prest_fide'		=>	to_moneda_bd($this->input->post('monto_prest_fide')),
		'monto_total_prest'		=>	to_moneda_bd($this->input->post('monto_total_prest')),
		'observaciones'			=>	str_replace("\r\n"," ",$this->input->post('observaciones')),
		# Movimientos MRE
		'fecha_firma_coord'		=>	date_to_pg($this->input->post('fecha_firma_coord')),
		'fecha_firma_dir'		=>	date_to_pg($this->input->post('fecha_firma_dir')),
		'fecha_firma_dir_gral'	=>	date_to_pg($this->input->post('fecha_firma_dir_gral')),
		'fecha_env_admin'		=>	date_to_pg($this->input->post('fecha_env_admin')),
		'fecha_env_acreencia'	=>	date_to_pg($this->input->post('fecha_env_acreencia')),
		# Movimientos MINFI
		'num_memo_admin'		=>	$this->input->post('num_memo_admin'),
		'nun_memo_env_fnza'		=>	$this->input->post('nun_memo_env_fnza'),
		'fecha_env_fnza_pri_vez'=>	date_to_pg($this->input->post('fecha_env_fnza_pri_vez')),
		'fecha_devol_fnza'		=>	date_to_pg($this->input->post('fecha_devol_fnza')),
		'num_memo_sgd_vez_fnza'	=>	$this->input->post('num_memo_sgd_vez_fnza'),
		'fecha_env_fnza_sgd_vez'=>	date_to_pg($this->input->post('fecha_env_fnza_sgd_vez')),
		# Movimientos Cierre
		'num_memo_env_psto'		=>	$this->input->post('num_memo_env_psto'),
		'fecha_env_psto'		=>	date_to_pg($this->input->post('fecha_env_psto')),
		'disp_bs'				=>	to_moneda_bd($this->input->post('disp_bs')),
		'num_memo_sin_disp'		=>	$this->input->post('num_memo_sin_disp'),		
		'fecha_devol_sin_disp'	=>	date_to_pg($this->input->post('fecha_devol_sin_disp')),		
		'fecha_env_exp'			=>	date_to_pg($this->input->post('fecha_env_exp')),
		# Tipo de Pago
		'id_tipo_pago'			=>	(int) $this->input->post('id_tipo_pago'),
		# Datos Cheque
		'fecha_remision_chq'	=>	date_to_pg($this->input->post('fecha_remision_chq')),
		'num_listado'			=>	$this->input->post('num_listado'),
		'fecha_listado'			=>	date_to_pg($this->input->post('fecha_listado')),
		'id_banco_cheque'		=>	(int) $this->input->post('id_banco_cheque'),
		'num_cheque'			=>	$this->input->post('num_cheque'),
		'monto_cheque'			=>	to_moneda_bd($this->input->post('monto_cheque')),
		'fecha_entrg_benefi'	=>	date_to_pg($this->input->post('fecha_entrg_benefi')),
		# Datos Transferencia
		'id_banco_transfe'		=>	(int) $this->input->post('id_banco_transfe'),
		'num_cta_transfe'		=>	$this->input->post('num_cta_transfe'),
		'monto_transfe'			=>	to_moneda_bd($this->input->post('monto_transfe')),
		'fecha_transfe'			=>	date_to_pg($this->input->post('fecha_transfe')),
		'num_confirm_transfe'	=>	$this->input->post('num_confirm_transfe'),
		# Datos Cierre
		'num_memo_cierre'		=>	$this->input->post('num_memo_cierre'),
		'fecha_memo_cierre'		=>	date_to_pg($this->input->post('fecha_memo_cierre')),
		'vvnd_bvf'				=>	to_moneda_bd($this->input->post('vvnd_bvf')),
		'fecha_pago_vaca'		=>	date_to_pg($this->input->post('fecha_pago_vaca')),
		'id_tipo_pago_vaca'		=>	(int) $this->input->post('id_tipo_pago_vaca'),
		# Herederos
		'observ_herederos'		=>	str_replace("\r\n"," ",$this->input->post('observ_herederos')),
		);
		$this->db->where('id_tramite',$id_tramite);
		$update = $this->db->update('tramite', $row);
		if ($this->db->affected_rows()>0)
			return TRUE ;
		else 
			return FALSE ;	
	}
	
	function insert_historico($id_tramite) {
		$row = array(
		# Datos Trabajador
		'id_tramite'			=>	(int) $id_tramite,
		'id_estatus_tramite'	=>	(int) $this->input->post('id_estatus_tramite'),
		'id_usuario'			=>	(int) $this->session->userdata('id_usuario')
		);
		$this->db->insert('historico_tramite', $row);	
	}
	
   	function comenzado($id_trabajador, $id_empleado) {		
		$sql = "select id_tramite from tramite where id_trabajador = $id_trabajador AND id_empleado = $id_empleado";
		$row = $this->db->query($sql);
		if ($row->num_rows() > 0)	
			return TRUE;
		else
			return FALSE;
	}
	
	function get_tramite($id_tramite) {
		$sql = "
		SELECT
		t.id_tramite, t.id_trabajador, t.id_empleado, t.cedula, t.telf_residencial,
		t.fecha_ingreso, t.fecha_egreso,
		t.telf_celular, t.correo_alt,
		-- TRAMITE
		t.id_estatus_tramite, et.nombre_estatus_tramite as estatus_tramite,
		t.id_motivo_egreso, me.nombre_motivo_egreso as motivo_egreso,
		t.id_usuario_asignado, u.usuario as usuario_asignado,
		TO_CHAR(t.fecha_inicio, 'DD-MM-YYYY HH:MI AM') AS fecha_inicio, t.fecha_asignacion, t.num_djp, t.fecha_djp, t.monto_viejo_regimen,
		t.monto_ley_mayo, t.monto_prest_fide, t.monto_total_prest, t.observaciones,
		-- MOV MRE
		t.fecha_firma_coord, t.fecha_firma_dir, t.fecha_firma_dir_gral, t.fecha_env_admin, t.num_memo_admin,t.fecha_env_acreencia, 
		-- MOV FIN
		t.nun_memo_env_fnza, t.fecha_env_fnza_pri_vez, t.fecha_devol_fnza, t.num_memo_sgd_vez_fnza, t.fecha_env_fnza_sgd_vez, 
		-- MOV CIERRE
		t.num_memo_env_psto, t.fecha_env_psto, t.disp_bs, t.num_memo_sin_disp,
		t.fecha_devol_sin_disp,t.fecha_env_exp,
		-- PAGO
		t.id_tipo_pago, tpgo.nombre_tipo_pago as tipo_pago,
		-- CHEQUE
		t.fecha_remision_chq, t.num_listado, t.fecha_listado,
		t.id_banco_cheque, bco_cheque.nombre_banco as banco_cheque, t.num_cheque, t.monto_cheque, t.fecha_entrg_benefi,
		-- TRANSFERENCIA
		t.id_banco_transfe, bco_transfe.nombre_banco as banco_transfe, num_cta_transfe, monto_transfe,
		t.fecha_transfe, num_confirm_transfe,
		-- CIERRE 
		t.num_memo_cierre, t.fecha_memo_cierre,
		t.vvnd_bvf, t.fecha_pago_vaca, t.id_tipo_pago_vaca, tpgo_vaca.nombre_tipo_pago_vaca,
		-- Otros
		t.id_usuario,
		t.observ_herederos
		FROM
		tramite t
		LEFT Join usuario u ON t.id_usuario_asignado = u.id_usuario
		LEFT Join estatus_tramite et ON t.id_estatus_tramite = et.id_estatus_tramite
		LEFT Join motivo_egreso me ON t.id_motivo_egreso = me.id_motivo_egreso
		LEFT Join tipo_pago tpgo ON t.id_tipo_pago = tpgo.id_tipo_pago
		LEFT Join banco bco_cheque ON t.id_banco_cheque = bco_cheque.id_banco
		LEFT Join tipo_pago_vaca tpgo_vaca ON t.id_tipo_pago_vaca = tpgo_vaca.id_tipo_pago_vaca
		LEFT Join banco bco_transfe ON t.id_banco_transfe = bco_transfe.id_banco
		WHERE t.id_tramite = $id_tramite "	;
		$rs = $this->db->query($sql);
		if ($rs->num_rows() > 0)	
			return   $rs->row(); 
		else
			return FALSE;
	}
	
	function get_historico($id_tramite) {
		$sql = "
		SELECT
		h.id_log_tramite as id, 
		e.nombre_estatus_tramite as estatus,
		u.usuario,
		TO_CHAR(h.fecha_creacion, 'DD-MM-YYYY HH:MI AM') AS fecha
		FROM
		historico_tramite h
		LEFT Join usuario u ON h.id_usuario = u.id_usuario
		LEFT Join estatus_tramite e ON h.id_estatus_tramite = e.id_estatus_tramite
		WHERE h.id_tramite = $id_tramite		" ;
		$row = $this->db->query($sql);
		if ($row->num_rows() > 0)	
			return $row->result();
		else
			return FALSE;
	}
	
	function get_historico_($id_tramite) {
		$sql = "
		SELECT
		h.id_log_tramite as id, 
		e.nombre_estatus_tramite as estatus,
		u.usuario,
		TO_CHAR(h.fecha_creacion, 'DD-MM-YYYY HH:MI AM') AS fecha
		FROM
		historico_tramite h
		LEFT Join usuario u ON h.id_usuario = u.id_usuario
		LEFT Join estatus_tramite e ON h.id_estatus_tramite = e.id_estatus_tramite
		WHERE h.id_tramite = $id_tramite		ORDER BY h.id_log_tramite ASC" ;
		$row = $this->db->query($sql);
		if ($row->num_rows() > 0)	
			return $row->result_array();
		else
			return FALSE;
	}

	function buscar_reporte(){
		$algo = array();
		#$sql = "SELECT * FROM v_tramite_maestro" ;
		#$sql = "SELECT * FROM tramite" ;
		// Asigno las variables del formulario
		$cedula					= $this->input->post('cedula') ;
		$nombres				= $this->input->post('nombres') ;
		$apellidos				= $this->input->post('apellidos') ;
		$id_estatus_tramite		= (int) $this->input->post('id_estatus_tramite') ;
		$id_motivo_egreso		= (int) $this->input->post('id_motivo_egreso') ;
		$id_usuario				= (int) $this->input->post('id_usuario') ;
		$id_usuario_asignado	= (int) $this->input->post('id_usuario_asignado') ;
		$id_tipo_pago			= (int) $this->input->post('id_tipo_pago') ;
		$id_banco_cheque		= (int) $this->input->post('id_banco_cheque') ;
		$id_banco_transfe		= (int) $this->input->post('id_banco_transfe') ;
		
		$fecha_inicio_begin		= $this->input->post('fecha_inicio_begin') ;
		$fecha_inicio_end		= $this->input->post('fecha_inicio_end') ;
		
		$fecha_asignacion_begin		= $this->input->post('fecha_asignacion_begin') ;
		$fecha_asignacion_end		= $this->input->post('fecha_asignacion_end') ;
		
		$this->db->select('*',FALSE);
		$this->db->from('v_tramite_maestro');		
		
		// Armar los condicionales
		($cedula != '')?					$this->db->where('cedula', $cedula): null; 
		($nombres != '')?					$this->db->like('nombres', $nombres): null; 
		($apellidos != '')?					$this->db->like('apellidos', $apellidos): null; 
		($id_estatus_tramite != '')?		$this->db->where('id_estatus_tramite', $id_estatus_tramite): null; 
		($id_motivo_egreso != '')?			$this->db->where('id_motivo_egreso', $id_motivo_egreso): null; 
		($id_usuario != '')?				$this->db->where('id_usuario', $id_usuario): null; 
		($id_usuario_asignado != '')?		$this->db->where('id_usuario_asignado', $id_usuario_asignado): null; 
		
		($fecha_inicio_begin != '')?		$this->db->where('fecha_inicio >=', $fecha_inicio_begin): null; 
		($fecha_inicio_end != '')?			$this->db->where('fecha_inicio <=', $fecha_inicio_end): null; 
		
		($fecha_asignacion_begin != '')?	$this->db->where('fecha_asignacion >=', $fecha_asignacion_begin): null; 
		($fecha_asignacion_end != '')?		$this->db->where('fecha_asignacion <=', $fecha_asignacion_end): null; 
		
		($id_tipo_pago != '')?				$this->db->where('id_tipo_pago', $id_tipo_pago): null; 
		($id_banco_cheque != '')?			$this->db->where('id_banco_cheque', $id_banco_cheque): null; 
		($id_banco_transfe != '')?			$this->db->where('id_banco_transfe', $id_banco_transfe): null; 
		
		//$subQuery = $this->db->_compile_select();
		$this->db->order_by('cedula::int', 'ASC', FALSE);		
		$query = $this->db->get();		
		#die ($subQuery);		
		
		if ($query->num_rows() > 0)				
			return $query->result();
		else
			return $algo;
	}
	
}

/* End of file tramite_model.php */
/* Location: /application/models/tramite_model.php */
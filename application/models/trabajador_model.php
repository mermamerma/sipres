<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
* @package  Prestaciones 
* @category Model CodeIgniter  
* @uses     Acciones asociadas en base de datos del modelo en cuestión
* @author   Jesus A. Rodriguez R. en <jesus.rodriguez937@mppre.gob.ve>
* @since    10/07/2013 a las 05:09:21 PM
*
*/

class Trabajador_model extends CI_Model {
    
	function __construct()	{
        parent::__construct();  
		$this->sigefirrhh = $this->load->database('sigefirrhh',TRUE);
		$this->rrhh = $this->load->database('rrhh',TRUE);
    }
	
	function __destruct() {
		$this->sigefirrhh->close();
		$this->rrhh->close();
	}
		    
	function get_datos_sigefirrhh($cedula) {				
		$sql = "
		SELECT p.id_personal, t.id_trabajador, 0 as id_empleado, p.cedula, 
		p.primer_nombre || ' ' || p.segundo_nombre as nombres,  p.primer_apellido || ' ' || p.segundo_apellido as apellidos,
		CASE WHEN p.sexo='M' THEN 'Masculino' WHEN p.sexo='F' THEN 'Femenino'ELSE '-' END AS sexo, 
		c.descripcion_cargo as cargo, lp.nombre as adscripcion, d.nombre as dependencia, tp.nombre as tipo_personal, 
		TO_CHAR(t.fecha_ingreso, 'DD-MM-YYYY') as fecha_ingreso, TO_CHAR(t.fecha_egreso, 'DD-MM-YYYY') as fecha_egreso,
		CASE WHEN t.estatus = 'E' THEN 'EGRESADO' 
		WHEN t.estatus = 'S' THEN 'SUSPENDIDO' 
		WHEN t.estatus = 'A' THEN 'ACTIVO'
		END, LOWER(p.email) AS correo, 'SIGEFIRRHH' as origen
		FROM trabajador t
		LEFT JOIN cargo c USING(id_cargo) 
		LEFT JOIN tipopersonal tp USING(id_tipo_personal) 
		LEFT JOIN personal p USING(id_personal)
		LEFT JOIN dependencia d using(id_dependencia)
		LEFT JOIN lugarpago lp using(id_lugar_pago)		
		WHERE 1 = 1
		AND id_tipo_personal IN (20,1,13,100,101,14,51)
		and id_personal = (SELECT id_personal FROM personal WHERE  cedula = $cedula)
		ORDER BY t.id_trabajador ASC 
		";
		$row = $this->sigefirrhh->query($sql);
		if ($row->num_rows() > 0)	
			return $row->row();
		else
			return FALSE;
	}
    
	function get_movimientos_sigefirrhh($cedula) {				
		$sql = "
		SELECT p.id_personal, t.id_trabajador, 0 as id_empleado, p.cedula, 
		p.primer_nombre || ' ' || p.segundo_nombre as nombres,  p.primer_apellido || ' ' || p.segundo_apellido as apellidos,
		CASE WHEN p.sexo='M' THEN 'Masculino' WHEN p.sexo='F' THEN 'Femenino'ELSE '-' END AS sexo, 
		c.descripcion_cargo as cargo, lp.nombre as adscripcion, d.nombre as dependencia, tp.nombre as tipo_personal, 
		TO_CHAR(t.fecha_ingreso, 'DD-MM-YYYY') as fecha_ingreso, TO_CHAR(t.fecha_egreso, 'DD-MM-YYYY') as fecha_egreso,
		CASE WHEN t.estatus = 'E' THEN 'EGRESADO' 
		WHEN t.estatus = 'S' THEN 'SUSPENDIDO' 
		WHEN t.estatus = 'A' THEN 'ACTIVO'
		ELSE	'Sin definir' END   AS estatus,
		LOWER(p.email) AS correo,
		'SIGEFIRRHH' as origen
		FROM trabajador t
		INNER JOIN cargo c USING(id_cargo) 
		INNER JOIN tipopersonal tp USING(id_tipo_personal) 
		INNER JOIN personal p USING(id_personal)
		INNER JOIN dependencia d using(id_dependencia)
		INNER JOIN lugarpago lp using(id_lugar_pago)
		--WHERE estatus = 'E' 
		WHERE 1 = 1
		AND id_tipo_personal IN (20,1,13,100,101,14,51,81)
		and id_personal = (SELECT id_personal FROM personal WHERE  cedula = $cedula )
		ORDER BY t.id_trabajador ASC 
		";
		
		$row = $this->sigefirrhh->query($sql);
		if ($row->num_rows() > 0)	
			return $row->result();
		else
			return FALSE;
	}
	
	function get_movimientos_rrhh($cedula) {				
		$sql = "
		SELECT ''::text as correo, * from get_movimientos_rrhh('$cedula') as movimientos
		(cedula varchar, nombres varchar, apellidos varchar, id_trabajador int4, id_empleado int4,
		fecha_ingreso text, fecha_egreso text, fecha_mov date, 
		adscripcion varchar, dependencia text, cargo varchar, tipo_personal varchar, sexo text, estatus text, origen text) 
		";
		$row = $this->rrhh->query($sql);
		if ($row->num_rows() > 0)	
			return $row->result();
		else
			return FALSE;
	}
	
	function get_reg_sigefirrhh($cedula) {				
		$sql = "
		SELECT p.id_personal, 0 as id_empleado, p.cedula, 
		p.primer_nombre || ' ' || p.segundo_nombre as nombres,  p.primer_apellido || ' ' || p.segundo_apellido as apellidos,
		CASE WHEN p.sexo='M' THEN 'MASCULINO' WHEN p.sexo='F' THEN 'FEMENINO' ELSE '-' END AS sexo,
		TO_CHAR(P.fecha_nacimiento, 'DD-MM-YYYY') as fecha_nacimiento,  'SIGEFIRRHH' as origen
		FROM personal p 
		WHERE 
		p.cedula = $cedula
		";
		$row = $this->sigefirrhh->query($sql);
		if ($row->num_rows() > 0)			
			return $row->row();
		else
			return FALSE;
	}
		
	function get_trabajador_sigefirrhh ($id_trabajador) {
		$sql = "
		SELECT p.id_personal, t.id_trabajador, 0 as id_empleado, p.cedula, 
		p.primer_nombre || ' ' || p.segundo_nombre as nombres,  p.primer_apellido || ' ' || p.segundo_apellido as apellidos,
		CASE WHEN p.sexo='M' THEN 'Masculino' WHEN p.sexo='F' THEN 'Femenino'ELSE '-' END AS sexo, 
		c.descripcion_cargo as cargo, lp.nombre as adscripcion, d.nombre as dependencia, tp.nombre as tipo_personal, 
		TO_CHAR(t.fecha_ingreso, 'DD-MM-YYYY') as fecha_ingreso, TO_CHAR(t.fecha_egreso, 'DD-MM-YYYY') as fecha_egreso,
		CASE WHEN t.estatus = 'E' THEN 'EGRESADO' 
		WHEN t.estatus = 'S' THEN 'SUSPENDIDO' 
		WHEN t.estatus = 'A' THEN 'ACTIVO'
		ELSE	'Sin definir' END   AS estatus, LOWER(p.email) AS correo, 'SIGEFIRRHH' as origen
		FROM trabajador t
		INNER JOIN cargo c USING(id_cargo) 
		INNER JOIN tipopersonal tp USING(id_tipo_personal) 
		INNER JOIN personal p USING(id_personal)
		INNER JOIN dependencia d using(id_dependencia)
		INNER JOIN lugarpago lp using(id_lugar_pago)
		WHERE 1 = 1
		--AND id_tipo_personal IN (20,1,13,100,101,14,51)
		AND t.id_trabajador = $id_trabajador
		ORDER BY t.id_trabajador ASC " ;
		$row = $this->sigefirrhh->query($sql);
		if ($row->num_rows() > 0)			
			#return $row->row();
			return $row->row();
		else
			return FALSE;
	}
	
	function get_reg_rrhh($cedula) {
		$sql = "
		SELECT  e.id as id_empleado, 0 as id_personal, 0 as id_trabajador, e.cedula, 
		e.nombres as nombres, e.apellidos as apellidos, 
		CASE WHEN e.sexo='M' THEN 'MASCULINO' WHEN e.sexo='F' THEN 'FEMENINO' ELSE	'' END AS sexo, 
		nt.nomina_tipo as tipo_personal, c.cargo, '' as dependencia,
		TO_CHAR(n.fecha_ing, 'DD-MM-YYYY') as fecha_ingreso, '' as fecha_egreso, 'RRHH' as origen, e.correo
		from empleados e 
		LEFT JOIN nominas n ON (n.id_empleado = e.id)
		LEFT JOIN cargos c ON (n.id_cargo = c.id)
		LEFT JOIN nominas_tipo nt ON (nt.id = n.id_tipo_nomina)
		where cedula = '$cedula' 
		ORDER BY n.fecha_mov DESC LIMIT 1 " ;		
		$row = $this->rrhh->query($sql);
		if ($row->num_rows() > 0)			
			return $row->row();
		else
			return FALSE;
	}
	
	function get_trabajador_rrhh($cedula, $id_trabajador, $id_empleado) {
		$sql = "
		SELECT ''::text as correo, * from get_movimientos_rrhh('$cedula') as movimientos
		(cedula varchar, nombres varchar, apellidos varchar, id_trabajador int4, id_empleado int4, 
		fecha_ingreso text, fecha_egreso text, fecha_mov date,
		adscripcion varchar, dependencia text, cargo varchar, 
		tipo_personal varchar, sexo text, estatus text, origen text) 
		WHERE id_trabajador = $id_trabajador  AND id_empleado = $id_empleado		" ;				
		$row = $this->rrhh->query($sql);
		if ($row->num_rows() > 0)			
			return $row->row();
		else
			return FALSE;
	}
	
	function insertar_tramite() {
		$id_trabajador = $this->input->post('id_trabajador');
		$id_empleado   = $this->input->post('id_empleado');
		
		$row = array(
		# Datos Trabajador
		'id_trabajador'			=>	(int) $id_trabajador,
		'id_empleado'			=>	(int) $id_empleado,
		'cedula'				=>	$cedula,
		'telf_residencial'		=>	$this->input->post('telf_residencial'),			
		'telf_celular'			=>	$this->input->post('telf_celular'),
			         	'correo_alt'			=>	$this->input->post('correo_alt'),
		# Datos Trámite
		'id_estatus_tramite'	=>	(int) $this->input->post('id_estatus_tramite'),
		'id_motivo_egreso'		=>	(int) $this->input->post('id_motivo_egreso'),
		'id_usuario_asignado'	=>	(int) $this->input->post('id_usuario_asignado'),
		'fecha_inicio'			=>	now_db_datetime(),
		'fecha_asignacion'		=>	date_to_pg($this->input->post('fecha_asignacion')),
		'num_djp'				=>	$this->input->post('num_djp'),
		'fecha_djp'				=>	date_to_pg($this->input->post('fecha_djp')),
		'monto_viejo_regimen'	=>	to_moneda_bd($this->input->post('monto_viejo_regimen')),  
		'monto_ley_mayo'		=>	to_moneda_bd($this->input->post('monto_ley_mayo')),
		'monto_prest_fide'		=>	to_moneda_bd($this->input->post('monto_prest_fide')),
		'monto_total_prest'		=>	to_moneda_bd($this->input->post('monto_total_prest')),
		'observaciones'			=>	$this->input->post('observaciones'),
		# Movimientos MRE
		'fecha_firma_coord'		=>	date_to_pg($this->input->post('fecha_firma_coord')),
		'fecha_firma_dir'		=>	date_to_pg($this->input->post('fecha_firma_dir')),
		'fecha_firma_dir_gral'	=>	date_to_pg($this->input->post('fecha_firma_dir_gral')),
		'fecha_env_admin'		=>	date_to_pg($this->input->post('fecha_env_admin')),
		# Movimientos MF
		'num_memo_admin'		=>	$this->input->post('num_memo_admin'),
		'nun_memo_env_fnza'		=>	$this->input->post('nun_memo_env_fnza'),
		'fecha_env_fnza_pri_vez'=>	date_to_pg($this->input->post('fecha_env_fnza_pri_vez')),
		'fecha_devol_fnza'		=>	date_to_pg($this->input->post('fecha_devol_fnza')),
		'num_memo_sgd_vez_fnza'	=>	$this->input->post('num_memo_sgd_vez_fnza'),
		'fecha_env_fnza_sgd_vez'=>	date_to_pg($this->input->post('fecha_env_fnza_sgd_vez')),
		# Datos Cheque
		'fecha_remision_chq'	=>	date_to_pg($this->input->post('fecha_remision_chq')),
		'num_listado'			=>	$this->input->post('num_listado'),
		'fecha_listado'			=>	date_to_pg($this->input->post('fecha_listado')),		
		'num_cheque'			=>	$this->input->post('mum_cheque'),
		'monto_cheque'			=>	to_moneda_bd($this->input->post('monto_cheque')),
		'fecha_entrg_benefi'	=>	date_to_pg($this->input->post('fecha_entrg_benefi')),
		# Datos Cierre
		'num_memo_cierre'		=>	$this->input->post('num_memo_cierre'),
		'fecha_memo_cierre'		=>	date_to_pg($this->input->post('fecha_memo_cierre')),
		'vvnd_bvf'				=>	$this->input->post('vvnd_bvf'),
		'num_memo_env_psto'		=>	$this->input->post('num_memo_env_psto'),
		'fecha_env_psto'		=>	date_to_pg($this->input->post('fecha_env_psto')),
		'disp_bs'				=>	to_moneda_bd($this->input->post('disp_bs')),
		'num_memo_sin_disp'		=>	$this->input->post('num_memo_sin_disp'),
		'fecha_devol_sin_disp'	=>	date_to_pg($this->input->post('fecha_devol_sin_disp')),
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
}

/* End of file personal_model.php */
/* Location: /application/models/personal_model.php */
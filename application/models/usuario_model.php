<?php

/**
 * 
 * 
 * @author Jesus Rodriguez
 * @version 
 */	

class Usuario_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->sigefirrhh = $this->load->database('sigefirrhh',TRUE);
		$this->rrhh = $this->load->database('rrhh',TRUE);
		$this->load->library('adldap');
		#$this->sigefirrhh = $this->load->database('sigefirrhh',TRUE);
	}
	
	function __destruct() {
		$this->sigefirrhh->close();
		$this->rrhh->close();
		#$this->sigefirrhh->close();
	}
	
	function validar_en_sistema(){		
		$this->db->where('usuario',$this->input->post('usuario'));		
		$this->db->limit(1);
		$query = $this->db->get('usuario');	
		
		if ($query->num_rows == 1) {
			return true;
		}
		else {
			return false;
		}
	}

	function get_datos($criterio, $campo = 'cedula') {
		$buscar	= ($campo == 'id_personal')? " AND id_personal = $criterio " : " AND cedula = $criterio ";		
			
		$sql = "
		SELECT p.id_personal,p.cedula,
		c.descripcion_cargo as cargo, p.fecha_nacimiento,
		p.primer_nombre || ' ' || p.segundo_nombre as nombres, 
		p.primer_apellido || ' ' || p.segundo_apellido as apellidos,
		CASE 
			WHEN p.sexo='M' THEN 'Masculino'
			WHEN p.sexo='F' THEN 'Femenino'
			ELSE	'-'
		END AS sexo, LOWER(p.email) AS correo
		FROM trabajador t
		INNER JOIN cargo c USING(id_cargo) 
		INNER JOIN tipopersonal tp USING(id_tipo_personal) 
		INNER JOIN personal p USING(id_personal)				
		WHERE id_personal = (SELECT id_personal FROM personal WHERE 1 = 1 $buscar ) 
		AND t.estatus='A' ";
		#die($sql);
		$row = $this->sigefirrhh->query($sql);
		if ($row->num_rows()>0)			
			return $row->row();
		else
			return FALSE;
	}
	
	function validar_en_ldap($usuario, $password) {
		$res = $this->adldap->authenticate($usuario,$password);
		return $res ;
		//return true;		
	}
	
	function existe_en_ldap($usuario) {
		$flag = $this->adldap->user_exist($usuario);
		return $flag;
	}
    
	function get_usuario($usuario) {		
		$usuario = $this->db->get_where('usuario', array('usuario' => $usuario, 'id_estatus' => 1), 1);
		return $usuario->row();
		
	}

	function get_nombre_usuario($id) {
		$this->db->select("usuario");		
		$query = $this->db->get_where('usuario', array('id_usuario' => $id), 1);
		$usuario = $query->row();
		if ($query->num_rows() == 1 )
			return $usuario->usuario;
		else 
			return "Usuario no definido bajo el ID => $id";
		
	}
	
	function get_usuario_por_id($id_usuario) {							
		$usuario = $this->db->get_where('usuario', array('id_usuario' => $id_usuario), 1);
		$num_rows = $usuario->num_rows();
		if ($num_rows > 0)
			return $usuario->row();
		else
			return FALSE;
		
	}
	
	function listar_usaurios() {
		$query = $this->db->query("
			SELECT
			usuario.id_usuario, usuario.usuario,
			uc.usuario as creador,
			rol.nombre_rol as rol,
			CASE 
			WHEN usuario.id_estatus = 1 THEN 'good_bit.png'
			WHEN usuario.id_estatus = 2 THEN 'bad_bit.png'
			END as img_estatus
			FROM
			usuario	
			INNER Join rol  USING(id_rol)
			INNER Join usuario uc ON (usuario.id_usuario_creador = uc.id_usuario)
			WHERE usuario.id_usuario NOT IN (0)
			ORDER BY usuario.usuario ASC ");
		$data = $query->result_array();
		return $data ;		
	}

	function listar_usaurios_1() {
		$query = $this->db->query("
		SELECT
		usuarios.id,
		usuarios.usuario,
		usuarios.nombres,
		usuarios.apellidos,
		uc.usuario as 'creador',
		coordinaciones.nombre as 'coordinacion',
		accesos.nombre as 'acceso',
		IF(usuarios.id_estatus = 1,'Activo','Inactivo') as 'estatus',
		IF(usuarios.id_estatus = 1,'good_bit.png','bad_bit.png') as 'img'
		FROM
		usuarios
		INNER Join coordinaciones ON usuarios.id_coordinacion = coordinaciones.id
		LEFT Join accesos 				ON usuarios.id_acceso = accesos.id
		INNER Join usuarios uc 		ON uc.id = usuarios.id_creador
		ORDER BY usuarios.usuario ASC
		");
		$data = $query->result_object();
		return $data ;		
		
	}
	
	function insertar() {
		$row = array(
		'id_personal'			=>	$this->input->post('id_personal'),
		'id_rol'				=>	$this->input->post('id_rol'),		
		'usuario'				=>	$this->input->post('usuario'),			
		'id_estatus'			=>	$this->input->post('id_estatus'),
		'id_usuario_creador'	=>	$this->session->userdata('id_usuario'),
		'fecha_creacion'		=>	now_db_datetime(),
		'fecha_actualizacion'	=>	now_db_datetime()
		);	
		$this->db->insert('usuario', $row);	
		if ($this->db->affected_rows()>0)
			return $this->db->insert_id();
		else 
			return FALSE;		
	}
	
	function editar() {
		$usuario = array(
		'usuario'				=> $this->input->post('usuario'),
		'id_estatus'			=> $this->input->post('id_estatus'),
		'id_rol'				=> $this->input->post('id_rol'),
		'fecha_actualizacion'	=> now_db_datetime()
		);
		$this->db->where('id_usuario', $this->input->post('id_usuario'));
		$update = $this->db->update('usuario', $usuario);
		if ($this->db->affected_rows()>0)
			return TRUE ;
		else 
			return FALSE ;	
	}
	
	function duplicado($donde){
		$query = $this->db->get_where('usuario', $donde); 
		if ($query->num_rows() > 0) 
			return TRUE;
		else 
			return FALSE;
	}
	
	function duplicado_edit($usuario, $id_usuario){
		
		$this->db->where('usuario', $usuario); 
		$this->db->where_not_in('id_usuario', $id_usuario);	
		$query = $this->db->get('usuario');	
		if ($query->num_rows() > 0) 
			return TRUE;
		else 
			return FALSE;
	}

    function listar_usaurios_obj() {
		$query = $this->db->query("
		SELECT
		usuarios.id,
		usuarios.usuario,
		usuarios.nombres,
		usuarios.apellidos,
		uc.usuario as 'creador',
		coordinaciones.nombre as 'coordinacion',
		accesos.nombre as 'acceso',
                usuarios.fecha_creacion,
                usuarios.fecha_actualizacion,
		IF(usuarios.id_estatus = 1,'Activo','Inactivo') as 'estatus',
		IF(usuarios.id_estatus = 1,'good_bit.png','bad_bit.png') as 'img'
		FROM
		usuarios
		INNER Join coordinaciones ON usuarios.id_coordinacion = coordinaciones.id
		LEFT Join accesos 				ON usuarios.id_acceso = accesos.id
		INNER Join usuarios uc 		ON uc.id = usuarios.id_creador
		ORDER BY usuarios.usuario ASC
		");
		return $query ;		
	}
        
}



<?php

/**
* 
* @package  Prestaciones 
* @category Model CodeIgniter  
* @uses     Acciones asociadas en base de datos del modelo en cuestión
* @author   Jesus A. Rodriguez R. en <jesus.rodriguez937@mppre.gob.ve>
* @since    09/07/2013 a las 02:39:25 PM
*
*/

class Crud_model extends CI_Model {
	function __construct()	{
        parent::__construct();         
    }
	
	function __destruct() {

}

	// FUNCIONES GENERALES: CREATE, READ, UPDATE, DELETE
	function listar_registros($tabla,$donde=0,$ordonde=0) {
		if ($donde!=0) $this->db->where($donde);
		if ($ordonde!=0) $this->db->or_where($ordonde);
		$query = $this->db->get($tabla);
		return $query;
	}
	
	function contar_items($tabla, $datos)   {
		$this->db->where($datos);
		$this->db->from($tabla);
		return $this->db->count_all_results();
   }
   
	function buscar_item($tabla, $datos)  {
		$this->db->or_where($datos);
		$this->db->from($tabla);
		echo $this->db->count_all_results();
	}
	
	function encontrar($tabla, $donde) {
		$query = $this->db->get_where($tabla, $donde); 
		if ($query->num_rows() > 0) 
			return TRUE;
		else 
			return FALSE;
	}
	
	function insertar($tabla, $datos)   {
		$this->db->insert($tabla, $datos);
		if ($this->db->affected_rows()>0)
			return $this->db->insert_id();
		else 
			return FALSE;
   }
   
	function eliminar($tabla, $donde)   {
		$this->db->delete($tabla, $donde);
		if ($this->db->affected_rows()>0)
			return TRUE;
		else 
			return FALSE;
   }
   
	function actualizar($tabla, $datos, $donde)   {
		$this->db->update($tabla, $datos, $donde);  
		if ($this->db->affected_rows()>0){return true;}
		else {return false;}
   }
   
	function listar_tablas()   {
		$tables = $this->db->list_tables();
		return $tables;
   }
   
	function listar_campos($tabla)   {
		$campos = $this->db->field_data($tabla);
		return $campos;
   }
   
	function agregar_campo($tabla, $comando)   {
		$sql = "ALTER TABLE $tabla ADD COLUMN $comando";
		$query = $this->db->query($sql);
		return $query;        
   }
   
	function borrar_campo($tabla, $campo)   {
		$sql = "ALTER TABLE $tabla DROP COLUMN $campo";
		$query = $this->db->query($sql);
		return $query;        
   }
   
	// EJECUTA COMANDOS SQL
	function ventana_sql($sql)	  { 
		$query = $this->db->query($sql);
		if (is_bool($query))return $query;
		return $query->result_array();        
	}

}    


/* End of file crud.php */
/* Location: /application/models/crud.php */
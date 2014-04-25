<?php

/**
 * 
 * 
 * @author Jesús Rodríguez
 * @version 
 */	

class Bitacora extends CI_Controller {

	function __construct() {
		parent::__construct();	
		is_logged_in();
		$this->load->model('bitacora_model');		
	}
	    	
	function listar() {		
		// load pagination class
    	$this->load->library('pagination');
    	$config['base_url'] 		= base_url().'/bitacora/listar/';
   		$total_rows 				= $this->db->count_all('bitacora');
		$this->config->set_item('enable_query_strings',FALSE);
   		$config['total_rows'] 		= $total_rows;
    	$config['per_page'] 		= 25;
		$data['results']			= array();
		$data['total_rows']			= $total_rows;		
		$data['inicio']				= $config['per_page'];	
		$data['fin']				= $this->uri->segment(3);
    	$this->pagination->initialize($config);    	
	
		$data['results'] = $this->bitacora_model->get_logs($config['per_page'],$this->uri->segment(3));				
		
		$this->load->library('table');
				
		$this->table->set_heading('Usuario', 'IP', 'URL', 'Modulo', 'Acción','Detalle','Fecha');	
		$tmpl = array ('table_open'=>'<table border="0" cellpadding="4" cellspacing="0"   class="display" id="datatable">');
		$this->table->set_template($tmpl); 	

		register_log('Acceso',"Acceso a la Bitácora");  
		$data ['main_content'] 		= 'sistema/bitacora/view_log';  
		$this->load->view('sistema/template',$data);  	
    }

	function usuario() {
		$this->load->model('usuario_model');
		$this->load->library('pagination');
		$id_usuario = $this->uri->segment(3);
		$usuario = $this->usuario_model->get_usuario_por_id($id_usuario);
		$this->config->set_item('enable_query_strings',FALSE);
		$total_rows 				= $this->bitacora_model->count_logs_user($id_usuario);  
		$config['uri_segment'] 		= 4;  	
    	$config['base_url'] 		= base_url().'/bitacora/usuario/'.$id_usuario;   		   		
   		$config['total_rows'] 		= $total_rows;   		     		    	
    	$config['per_page'] 		= 20;
    	$data['total_rows']			= $total_rows;
    	$data['usuario']			= $usuario;
		$data['results']			= array();				
		$data['inicio']					= $config['per_page'];	
		$data['fin']					= $this->uri->segment(3);
    	$this->pagination->initialize($config);    	
	
		$data['results'] = $this->bitacora_model->get_logs_user($this->uri->segment(3),$config['per_page'],$this->uri->segment(4));				
		$total = count($data['results']);
		$this->load->library('table');
				
		$this->table->set_heading('usuario', 'IP', 'Ruta', 'Controlador', 'Tipo', 'Descripción','Fecha');	
		$tmpl = array ('table_open'=>'<table border="0" cellpadding="4" cellspacing="0"   class="display" id="datatable">');
		$this->table->set_template($tmpl); 	

		register_log('Acceso',"Acceso a la Bitacora del Usuario => $usuario->usuario");  
		$data ['main_content'] 		= 'sistema/bitacora/view_log_user';  
		$this->load->view('sistema/template',$data);  	
    }
} ### FIN DE CLASE



<?php

/**
 * 
 * 
 * @author Jesus Rodriguez
 * @version 
 */	

class Site extends CI_Controller {

	function __construct()
	{
		parent::__construct();	
		is_logged_in();
	}
	
    function index()    
    {
    	register_log('Acceso',"Acceso al Inicio"); 
    	$data ['main_content'] 	= 'sistema/inicio';
    	$data ['usuario'] 		= $this->session->userdata('usuario');    	
    	$this->load->view('sistema/template',$data);
    }   	
    
    
}

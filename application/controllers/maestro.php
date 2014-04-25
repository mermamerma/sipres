<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
* @package  Sipres 
* @category Controller CodeIgniter 
* @uses     Acciones asociadas al controlador en cuestión
* @author   Jesus A. Rodriguez R. en <jesus.rodriguez937@mppre.gob.ve>
* @since    31/03/2014 a las 09:57:45 AM
*
*/

class Maestro extends CI_Controller {
	var $maestro = array();
    
	function __construct()	{		
        parent::__construct();
		is_logged_in();
		$this->load->model('maestro_model');
		$this->load->library('table');
		$this->maestro[] =array('desc' => 'BANCOS',						'nombre_tabla'=>'banco'); // 0
		$this->maestro[] =array('desc' => 'ESTATUS DE LOS TRÁMITES',	'nombre_tabla'=>'estatus_tramite');	// 1
		$this->maestro[] =array('desc' => 'MOTIVOS DE EGRESO',			'nombre_tabla'=>'motivo_egreso'); // 2
		$this->maestro[] =array('desc' => 'PARENTESCOS',				'nombre_tabla'=>'parentesco'); // 3
		$this->maestro[] =array('desc' => 'TIPOS DE PAGO',				'nombre_tabla'=>'tipo_pago'); // 4
		$this->maestro[] =array('desc' => 'TIPOS DE PAGO DE VACACIONES','nombre_tabla'=>'tipo_pago_vaca'); // 5
		
    }
	
	public function index() {
    	$img = "<img src='".base_url()."public/images/lupa.png' align='absmiddle'/>";
    	$link = "<a href='#' onclick=javascript:detalle_maestro" ;
    	
    	$this->table->set_template(array ( 'table_open'  => '<table cellspacing="1"  class="display" id="datatable">' )); 
    	$this->table->set_heading(array('Tabla', '-'));
    	$this->table->add_row(array($this->maestro[0]['desc'],	"$link(0);>$img</a>"));    	
    	$this->table->add_row(array($this->maestro[1]['desc'],	"$link(1);>$img</a>"));
    	$this->table->add_row(array($this->maestro[2]['desc'],	"$link(2);>$img</a>"));
    	$this->table->add_row(array($this->maestro[3]['desc'],	"$link(3);>$img</a>"));
		$this->table->add_row(array($this->maestro[4]['desc'],	"$link(4);>$img</a>"));
    	$this->table->add_row(array($this->maestro[5]['desc'],	"$link(4);>$img</a>"));
    	
		$data ['tabla'] = $this->table->generate(); 
		$data ['main_content'] 		= 'sistema/maestro/maestro'; 
		register_log('Acceso',"Acceso al listado Maestro Pricipal");
		$this->load->view('sistema/template',$data);
    }
    
   	function detalle() {		
		$id_tabla = $this->uri->segment(3);
		$data ['id_tabla']	 	= $id_tabla;
		$data ['nombre_tabla']	= $this->maestro[$id_tabla]['nombre_tabla'];
		$data ['desc'] 			= ucfirst(to_minuscula($this->maestro[$id_tabla]['desc']));
		$data ['tabla'] 		= $this->_datatable_detalle($id_tabla);			
		$data ['main_content'] 	= 'sistema/maestro/detalle_maestro'; 
		register_log('Accesos',"Acceso al listado Maestro - {$data['desc']} ");
		$this->load->view('sistema/template',$data);
	}
	
	function _datatable_detalle($tabla) {    
        $tabla_html = " <table cellspacing='1'  class='display' id='datatable'><thead><tr><th>Nombre</th><th>Opciones</th></tr></thead>";       
        $rows = $this->maestro_model->get_detalle($this->maestro[$tabla]['nombre_tabla'])  ;                    
        foreach ($rows as $key=> $row) {
                    $id         = $row['id'];
                    $nombre     = str_replace(' ','_',$row['nombre']);
                    $img        = "<img src='".base_url()."public/images/editar.png' align='absmiddle'/>";
                    $link       = "<a href='#' onclick=javascript:frm_maestro($id,'$nombre',$tabla);>$img</a>";
                    $tabla_html .= "<tr id='row_{$row['id']}'><td id='row_td1_{$row['id']}'>{$row['nombre']}</td><td id='row_td2_{$row['id']}'>$link</td></tr>";
        }       
        $tabla_html .= "</table>";
        return $tabla_html;
    }
	
	function procesar() { 
    	$id_tabla 		= $this->input->post('id_tabla') ;
    	$nombre_tabla	= $this->maestro[$id_tabla]['nombre_tabla'];
    	$nombre 		= strtoupper(trim($this->input->post('nombre'))) ;
    	$id		 		= $this->input->post('id_row');
    	$str 			= '';
    	$img 			= "<img src='".base_url()."public/images/editar.png' align='absmiddle'/>";
    	$nombre_prepared = str_replace(' ','_',$nombre);    	
    	$accion			= ($this->input->post('id_row') == '') ? 'agregar' : 'modificar';
    	
    	if (!$this->maestro_model->duplicado()) {
    		if ($this->input->post('id_row') == '') {
    			if (!$this->maestro_model->duplicado()) {
	    			$id = $this->maestro_model->agregar() ;
	    			$accion = 'agregar';
    				register_log('Inserción',"Se agregó un nuevo registro en la tabla $nombre_tabla bajo el ID => $id",1);    	 	
   					$str  	= dialog('Información','¡Registro Agregado Satisfactoriamente!',2);
   					$link	= "<a href='#' onclick=javascript:frm_maestro($id,'$nombre_prepared',$id_tabla);>$img</a>";
   					#$str 	.= "<script>$('#datatable').dataTable().fnAddData( ['$nombre', \"$link\" ] );	</script>";   				
   					$str 	.= "<script>$( \"#datatable tbody\" ).append(\"<tr style='background-color:#A2FFA2'><td id='row_td1_$id'>$nombre</td><td id='row_td2_$id'>$link</td></tr>\");</script>";
    			}    		
    		}
    		else {   		
    			$this->maestro_model->modificar();
    			$accion = 'modificar';
    			register_log('Actualización',"Se modificó un registro en la tabla $nombre_tabla bajo el ID => $id",1);
    			$link	= "<a href='#' onclick=javascript:frm_maestro($id,'$nombre_prepared',$id_tabla);>$img</a>";
    	 		$str  	= dialog('Información','¡Registro Modificado Satisfactoriamente!',2);    	 	
				$str	.= "<script>$(\"#row_td1_$id\").html(\"$nombre\"); $(\"#row_td2_$id\").html(\"$link\");</script>";
    		}
    	} else {
    		 	register_log('Error',"Se intentó $accion un registro con nombre duplicado en la tabla $nombre_tabla",1);
    			$str  	= dialog('Información',"¡Error, el valor \"$nombre\" ya existe con el mismo nombre!",1); 
    	}
    	    	
		echo code_line($str);
    }
    
    
}

/* End of file maestro.php */
/* Location: /application/controllers/maestro.php */
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
* @package  Sipres 
* @category Controller CodeIgniter 
* @uses     Acciones asociadas al controlador en cuestión
* @author   Jesus A. Rodriguez R. en <jesus.rodriguez937@mppre.gob.ve>
* @since    08/04/2014 a las 12:25:13 PM
*
*/

class Reporte extends CI_Controller {
    function __construct()	{		
        parent::__construct();
		is_logged_in();
		$this->load->model('tramite_model');
		$this->load->library('parser');	
    }
    
	function formulario() {
		$data['accion'] = 'Generar Reporte';
		$data['icon'] = 'application_view_tile.png';
		$data['script'] = '';
		register_log('Acceso',"Acceso al formulario para generar reporte");	
		
		$data ['main_content'] 		= 'reporte/formulario';  
		$this->load->view('sistema/template',$data);  
	}
    
	function buscar() {
		sleep(1);
		$data = array();
		register_log('Busqueda',"Se realizó una busqueda para generar reporte",1);	
		$data['tramites'] = $this->tramite_model->buscar_reporte();		
		$tabla = $this->load->view('reporte/resultado_busqueda', $data,TRUE);
		echo $tabla;
	}
    
	function imprimir() {		
		$modo = $this->input->post('modo') ;
		$data['tramites']	= $this->tramite_model->buscar_reporte();
		$data['titulo']		= $this->input->post('titulo');
		register_log('Busqueda',"Se generó un reporte en modo $modo",1);
		if ($modo == 'PDF') {
			$tabla = $this->load->view('reporte/resultado_busqueda_pdf', $data,TRUE);
			$this->load->library('pdf');
			$this->pdf->AddPage('L');
			$this->pdf->SetFontSize(8);			
			$this->pdf->writeHTML($tabla, true, false, false, false, ''); 
			#die($tabla);
			$this->pdf->setFooterText('Generado por: '.$this->session->userdata('usuario').' el '.get_now_full());
			$this->pdf->Output('reporte.pdf', 'I'); 	
			register_log('Generación',"Se generó un reporte en formato PDF");
		}
		elseif($modo == 'XLS') {
			//$this->output->set_content_type('application/json');
			$tabla = $this->load->view('reporte/resultado_busqueda_xls', $data,TRUE);			
			$headers = ''; // just creating the var for field headers to append to below
			#header("Content-type: application/x-msdownload; harset=utf-8");
			header("Content-Type: application/vnd.ms-excel; charset=utf-8");
			header("Content-Disposition: attachment; filename=reporte.xls");
          echo "$headers\n$tabla";  
		}
	}
}

/* End of file reporte.php */
/* Location: /application/controllers/reporte.php */
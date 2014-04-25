<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****
* 
* @package  Sipres 
* @category Controller CodeIgniter 
* @uses     Acciones asociadas al controlador en cuestión
* @author   Jesus A. Rodriguez R. en <jesus.rodriguez937@mppre.gob.ve>
* @since    25/03/2014 a las 10:49:44 AM
*
*/

class Heredero extends CI_Controller {
    function __construct()	{
        parent::__construct();
		is_logged_in();
		$this->load->model('heredero_model');
    }
    
	function eliminar() {
		$response = '';
		$id_heredero = (int) $this->uri->segment(3) ; 
		$result = $this->heredero_model->eliminar($id_heredero);
		if ($result === TRUE) {
			register_log('Eliminación',"Se Eliminó Heredero con el ID => $id_heredero",1);
			$remove_tr = "$('#tr_heredero_$id_heredero').remove();" ;
			$response .= mensaje("¡Heredero Eliminado Satisfactoriamente!");
			$response .= "<script>$remove_tr</script>";
			echo $response;
		}
		else
			echo mensaje('Error al tratar de eliminar Heredero...!!!');
	}
	
	function guardar() {
		$id_heredero	=  $this->input->post('id_heredero');
		$id_tramite		= (int) $this->input->post('id_tramite_h') ;
				
		if($id_heredero == '') {
			$id_heredero = $this->heredero_model->insertar();
			$herederos		= $this->heredero_model->get_list($id_tramite);
			$data['herederos'] = $herederos ;			
			$herederos	= $this->heredero_model->get_list($id_tramite);
			register_log('Inserción',"Se Insertó Heredero con el ID => $id_heredero",1);
			$tabla_herederos = $this->load->view('tramite/heredero/tabla', $data, TRUE);
			$tabla_herederos = code_line($tabla_herederos);			
			$response  = '';
			$response .= mensaje('¡Heredero Registrado Satisfactoriamente!') ;
			$response .= "<script> $('#wraper_herederos').html('$tabla_herederos');</script>";
			echo $response;
		}
		else {			
			$rs = $this->heredero_model->actualizar();
			$herederos	= $this->heredero_model->get_list($id_tramite);
			$data['herederos'] = $herederos ;
			$tabla_herederos = $this->load->view('tramite/heredero/tabla', $data, TRUE);
			register_log('Actualización',"Se Actualizó Heredero con el ID => $id_heredero",1);
			$tabla_herederos = code_line($tabla_herederos);			
			$response  = '';
			$response .= mensaje('¡Heredero Actualizado Satisfactoriamente!') ;
			$response .= "<script> $('#wraper_herederos').html('$tabla_herederos');</script>";
			echo $response;
		}
			
	}
    
    function editar() {
		$id_heredero	=  $this->uri->segment(3); 
		$heredero		= $this->heredero_model->get($id_heredero); 
		$data['heredero'] = $heredero ;
		$set_edit		= $this->load->view('tramite/heredero/set_edit', $data, TRUE);
		$response  = '';
		$response .= code_line($set_edit);
		echo $response ;		
	}
}

/* End of file heredero.php */
/* Location: /application/controllers/heredero.php */
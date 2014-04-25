<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
* @package  Prestaciones 
* @category Controller CodeIgniter 
* @uses     Acciones asociadas al controlador en cuestión
* @author   Jesus A. Rodriguez R. en <jesus.rodriguez937@mppre.gob.ve>
* @since    13/08/2013 a las 12:11:15 PM
*
*/

class Test extends CI_Controller {
    function __construct()	{
        parent::__construct();		
		$this->load->model('trabajador_model');
    }
    
	function index () {
		$movimientos1 = $this->trabajador_model->get_movimientos_sigefirrhh(117389988) ;
		$movimientos2 = objectToArray($movimientos1) ;
		var_dump($movimientos1);
		echo '<hr>';
		var_dump($movimientos2);
	}
    
    
}

/* End of file test.php */
/* Location: /application/controllers/test.php */
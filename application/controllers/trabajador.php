<?php

/**
* 
* @package  Prestaciones 
* @category Controller CodeIgniter 
* @uses     Acciones asociadas al controlador en cuestión
* @author   Jesus A. Rodriguez R. en <jesus.rodriguez937@mppre.gob.ve>
* @since    10/07/2013 a las 04:55:34 PM
*
*/

class Trabajador extends CI_Controller {
    function __construct()	{
        parent::__construct(); 
		is_logged_in();
		$this->load->model('trabajador_model');
		$this->load->model('tramite_model');
		$this->load->model('heredero_model');
    }
	
	function consultar() {
		$cedula = $this->input->post('cedula') ;		
		$trabajador = $this->trabajador_model->get_datos_sigefirrhh($cedula);
		if ($trabajador !== FALSE ) {			
			echo json_encode($trabajador) ;
		}
		else 
			echo 0;
		
}
    
	function frm_ficha() {
		$data['accion'] = 'Ficha del Trabajador';			
		$data['script'] = '';
		register_log('Acceso',"Acceso al formulario para generar ficha del trabajador");	
		
		$data ['main_content'] 		= 'trabajador/frm_ficha';  
		$this->load->view('sistema/template',$data);  	
	}
    
	function generar_ficha() {		
		$data['nombres'] = '' ;
		$data['apellidos'] = '' ;
		$data['apellidos'] = '';
		$data['cedula'] = '' ;
		$data['fecha_ingreso'] = '' ;
		$data['fecha_egreso'] = '' ;									
		$this->load->library('pdf');
		$this->pdf->AddPage('P');
		$this->pdf->setFontsize(11.5);
		$this->pdf->setFooterText('Generado por: '.$this->session->userdata('usuario').' el '.get_now_full());
		$this->load->library('parser');			
		$cedula = (int) $this->uri->segment(3) ; # Cedula
		$id_trabajador = (int) $this->uri->segment(4) ; # SIGEFIRRHH
		$id_empleado = (int) $this->uri->segment(5) ; # RRHH
		register_log('Generación',"Se genero la ficha al trabajador con C.I.: $cedula",1);	
		if ($id_empleado == 0) {		
			$trabajador = $this->trabajador_model->get_trabajador_sigefirrhh($id_trabajador) ;
			#var_dump($trabajador) ; exit ;
			$data['nombres'] = $trabajador->nombres ;
			$data['apellidos'] = $trabajador->apellidos ;
			$data['cedula'] = $trabajador->cedula  ;
			$data['fecha_ingreso'] = $trabajador->fecha_ingreso ;
			$data['fecha_egreso'] = $trabajador->fecha_egreso ;	
			$data['origen'] = $trabajador->origen ;	
			$html = $this->parser->parse('trabajador/reportes/ficha_personal', $data,TRUE); 				
			$this->pdf->writeHTML($html, true, false, false, false, ''); 
			// Esto es Para probar el Git en Hub
			$this->pdf->RoundedRect(165, 35, 30, 30, 6.50, '0000');
			$this->pdf->Text(162,68,'FOTO RECIENTE') ;
			$this->pdf->Output('ficha_personal.pdf', 'I'); 
		}
		elseif ($id_empleado > 0){
			$trabajador = $this->trabajador_model->get_trabajador_rrhh($cedula, $id_trabajador, $id_empleado) ;
			#var_dump($trabajador) ; exit ;
			$data['nombres'] = $trabajador->nombres ;
			$data['apellidos'] = $trabajador->apellidos ;
			$data['cedula'] = $trabajador->cedula  ;
			$data['fecha_ingreso'] = $trabajador->fecha_ingreso ;
			$data['fecha_egreso'] = $trabajador->fecha_egreso ;
			$data['origen'] = $trabajador->origen ;
			$html = $this->parser->parse('trabajador/reportes/ficha_personal', $data,TRUE); 				
			$this->pdf->writeHTML($html, true, false, false, false, ''); 
			#$this->pdf->RoundedRect(150, 35, 30, 30, 3.50, '1111', 'DF');
			$this->pdf->RoundedRect(165, 35, 30, 30, 6.50, '0000');
			$this->pdf->Text(162,68,'FOTO RECIENTE') ;
			$this->pdf->Output('ficha_personal.pdf', 'I'); 
		}
		else  show_404('Trabajador no encontrado');
	}
	
    function buscar(){
		$cedula = (int) $this->input->post('cedula') ;		
		$datos_sigefirrhh = $this->trabajador_model->get_datos_sigefirrhh($cedula);
		$datos_rrhh = $this->trabajador_model->get_datos_rrhh($cedula);
		if ($datos_sigefirrhh !== FALSE ) {			
			echo json_encode($datos_sigefirrhh) ;
		}
		elseif ($datos_rrhh !== FALSE) {
			echo json_encode($datos_rrhh);
		}
		else 
			echo 0;
	}
	
	function frm_buscar() {
		$data['accion'] = 'Buscar Trabajador';			
		$data['script'] = '';		
		$data ['main_content'] 		= 'trabajador/frm_buscar';  
		register_log('Acceso',"Acceso al formulario para buscar a un trabajador");	
		$this->load->view('sistema/template',$data);  
	}
		
	function buscar_tramites() {
		sleep(1);
		$data = array ();		
		$this->load->library('parser');
		$cedula = (int) $this->input->post('cedula') ;
		register_log('Busqueda',"Busqueda de trámites al trabajador con C.I.: $cedula",1);	
		$trab_sigefirrhh = $this->trabajador_model->get_reg_sigefirrhh($cedula) ;
		$trab_rrhh = $this->trabajador_model->get_reg_rrhh($cedula) ;
		$data['tram_reg'] = $this->tramite_model->get_lista($cedula) ;
		if ($trab_sigefirrhh !== FALSE AND $trab_rrhh !== FALSE) { ### Tiene Registros en SIGEFIRRHH y en RRHH
			$mov_sigefirrhh = $this->trabajador_model->get_movimientos_sigefirrhh($cedula) ;
			$mov_rrhh = $this->trabajador_model->get_movimientos_rrhh($cedula) ;
			$data['mov_sigefirrhh'] = $mov_sigefirrhh;
			$data['mov_rrhh'] = $mov_rrhh;
			$data['cedula'] = $trab_sigefirrhh->cedula;
			$data['nombres'] = $trab_sigefirrhh->nombres;
			$data['apellidos'] = $trab_sigefirrhh->apellidos;
			$data['sexo'] = $trab_sigefirrhh->sexo;
			$data['fecha_nacimiento'] = $trab_sigefirrhh->fecha_nacimiento;
			$data['origen'] = $trab_sigefirrhh->origen;			
			$this->load->view('trabajador/maestro_detalle',$data) ;
		}
		else if ($trab_rrhh != FALSE AND $trab_sigefirrhh == FALSE ) { ### Tiene Solo Registros en RRHH
			$mov_rrhh = $this->trabajador_model->get_movimientos_rrhh($cedula) ;
			$data['mov_rrhh'] = $mov_rrhh;
			$data['cedula'] = $trab_rrhh->cedula;
			$data['nombres'] = $trab_rrhh->nombres;
			$data['apellidos'] = $trab_rrhh->apellidos;
			$data['sexo'] = $trab_rrhh->sexo;
			$data['origen'] = $trab_rrhh->origen;
			$this->load->view('trabajador/maestro_detalle',$data) ;
		}
		else
			echo mensaje('Personal con la cédula no existe en SIGEFIRRHH ni el SIRRHH');
			
			
	}	
		
	function ficha() {
		#$data = array ();
		$this->load->library('parser');
		$data['accion'] = 'Listo' ;
	
		$modo			= $this->uri->segment(3);
		$cedula			= $this->uri->segment(4);
		$id_trabajador	= $this->uri->segment(5);
		$id_empleado	= $this->uri->segment(6);		
		#die($id_trabajador);
		register_log('Generación',"Se generó la ficha del trabajador para el trámite con la C.I.: $cedula");	
		$data ['main_content'] 	= 'trabajador/frm_ficha';  
		$data ['accion'] 		= 'Iniciar Trámite al Trabajdor';
		$data ['icon']			= 'application_form_add.png';
		$trabajador = $this->trabajador_model->get_trabajador_sigefirrhh($id_trabajador);
		if ($trabajador !== FALSE) {
			$data['cedula'] = $trabajador->cedula ;
			$data['nombres'] = $trabajador->nombres ;
			$data['apellidos'] = $trabajador->apellidos ;
			$data['tipo_personal'] = $trabajador->tipo_personal ;
			$maint_content = $this->parser->parse('trabajador/frm_ficha',$data,TRUE) ;
			$data['main_content'] = $maint_content ;
			$this->load->view('sistema/template_parser',$data);  
		}
		
		#$this->load->view('sistema/header') ;
		#$this->load->view('menus/'.$this->session->userdata('acceso')); 
		#$this->load->view('trabajador/frm_ficha') ;
		#$this->load->view('sistema/footer') ;
		

	}
	
	function expediente () {
			export_to_xls('SELECT * FROM v_tramite_maestro');
			$herederos		= $this->heredero_model->get_list(15);
			$data['herederos'] = $herederos ;	
			$tabla_herederos = $this->load->view('heredero/tabla', $data, TRUE);
			$tabla_herederos = str_replace(chr(10), " ", $tabla_herederos);
			$tabla_herederos = str_replace(chr(13), " ", $tabla_herederos);
			//echo $tabla_herederos ;
			//$data ['tabla_herederos'] = $tabla_herederos ;
			//exit;
			$data ['main_content'] 		= 'trabajador/expedientes';  			
			$this->load->view('sistema/template', $data);  
	}
		
}

/* End of file personal.php */
/* Location: /application/controllers/personal.php */
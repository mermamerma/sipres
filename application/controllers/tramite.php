<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
* @package  Sipres 
* @category Controller CodeIgniter 
* @uses     Acciones asociadas al controlador en cuestión
* @author   Jesus A. Rodriguez R. en <jesus.rodriguez937@mppre.gob.ve>
* @since    17/03/2014 a las 11:00:41 AM
*
*/

class Tramite extends CI_Controller {
    function __construct()	{
        parent::__construct();
		is_logged_in();
		$this->load->model('trabajador_model');
		$this->load->model('tramite_model');
		$this->load->model('heredero_model');
    }
    
    function informe(){
									
		$this->load->library('pdf');
		$this->pdf->AddPage('P');
		$this->load->library('parser');			
		$id_tramite = (int) $this->uri->segment(3) ; # 
		$cedula = (int) $this->uri->segment(4) ; # 
		$id_trabajador = (int) $this->uri->segment(5) ; # 
		$id_empleado = (int) $this->uri->segment(6) ; # 
		
		switch ($id_empleado) {
			case 0 : # Se busca el trabajador en el SIGEFIRRHH
				$datos = $this->trabajador_model->get_trabajador_sigefirrhh($id_trabajador);					
				break ;
			default :
				$datos = $this->trabajador_model->get_trabajador_rrhh($cedula, $id_trabajador, $id_empleado);					
				break ;
		}
		$tramite	= $this->tramite_model->get_tramite($id_tramite);
		$data['herederos'] 	= $this->heredero_model->get_list_($id_tramite);
		$data['historico']	= $this->tramite_model->get_historico_($id_tramite);
		register_log('Generación',"Se generó el informe del trámite ID $id_tramite al trabajador con CI $cedula");	
		// Trabajador
		$data['cedula'] = $datos->cedula  ;
		$data['nombres'] = $datos->nombres ;
		$data['apellidos'] = $datos->apellidos ;		
		$data['tipo_personal'] = $datos->tipo_personal  ;
		$data['cargo'] = $datos->cargo  ;
		$data['estatus'] = $datos->estatus  ;
		$data['correo'] = $datos->correo  ;
		$data['fecha_ingreso_sis'] = $datos->fecha_ingreso ;		
		$data['fecha_egreso_sis'] = $datos->fecha_egreso ;
		$data['fecha_ingreso'] = date_to_human($tramite->fecha_ingreso) ;		
		$data['fecha_egreso'] = date_to_human($tramite->fecha_egreso) ;
		$data['telf_residencial'] = $tramite->telf_residencial  ;
		$data['telf_celular'] = $tramite->telf_celular  ;
		$data['correo_alt'] = $tramite->correo_alt  ;
		$data['origen'] = $datos->origen  ;
		// Tramite
		$data['estatus_tramite'] = $tramite->estatus_tramite  ;
		$data['motivo_egreso'] = $tramite->motivo_egreso  ;
		$data['usuario_asignado'] = $tramite->usuario_asignado  ;
		$data['fecha_inicio'] = $tramite->fecha_inicio  ;
		$data['fecha_asignacion'] = date_to_human($tramite->fecha_asignacion)  ;
		$data['num_djp'] = $tramite->num_djp  ; 
		$data['fecha_djp'] = date_to_human($tramite->fecha_djp)  ;
		$data['monto_viejo_regimen'] = to_moneda($tramite->monto_viejo_regimen)  ; 
		$data['monto_ley_mayo'] = to_moneda($tramite->monto_ley_mayo)  ; 
		$data['monto_prest_fide'] = to_moneda($tramite->monto_prest_fide)  ; 
		$data['monto_total_prest'] = to_moneda($tramite->monto_total_prest)  ; 
		$data['observaciones'] = $tramite->observaciones  ;
		// Movimientos en el MRE
		$data['fecha_firma_coord'] = date_to_human($tramite->fecha_firma_coord)  ;
		$data['fecha_firma_dir'] = date_to_human($tramite->fecha_firma_dir)  ;
		$data['fecha_firma_dir_gral'] = date_to_human($tramite->fecha_firma_dir_gral)  ;
		$data['fecha_env_admin'] = date_to_human($tramite->fecha_env_admin)  ;
		$data['num_memo_admin'] = $tramite->num_memo_admin  ;
		$data['fecha_env_acreencia'] = date_to_human($tramite->fecha_env_acreencia)  ;
		// Movimientos en el MINFIN
		$data['nun_memo_env_fnza'] = $tramite->nun_memo_env_fnza  ;
		$data['fecha_env_fnza_pri_vez'] = date_to_human($tramite->fecha_env_fnza_pri_vez)  ;
		$data['fecha_devol_fnza'] = date_to_human($tramite->fecha_devol_fnza)  ;
		$data['num_memo_sgd_vez_fnza'] = $tramite->num_memo_sgd_vez_fnza  ;
		$data['fecha_env_fnza_sgd_vez'] = date_to_human($tramite->fecha_env_fnza_sgd_vez)  ;
		// Movimientos Cierre
		$data['num_memo_env_psto'] = $tramite->num_memo_env_psto  ;
		$data['fecha_env_psto'] = date_to_human($tramite->fecha_env_psto)  ;
		$data['disp_bs'] = to_moneda($tramite->disp_bs)  ;
		$data['num_memo_sin_disp'] = $tramite->num_memo_sin_disp  ;
		$data['fecha_devol_sin_disp'] = date_to_human($tramite->fecha_devol_sin_disp)  ;
		$data['fecha_env_exp'] = date_to_human($tramite->fecha_env_exp)  ;
		// Pago
		$data['tipo_pago'] = date_to_human($tramite->tipo_pago)  ;
		// Cheque
		$data['fecha_remision_chq'] = date_to_human($tramite->fecha_remision_chq)  ;
		$data['num_listado'] = $tramite->num_listado  ;
		$data['fecha_listado'] = date_to_human($tramite->fecha_listado)  ;
		$data['banco_cheque'] = $tramite->banco_cheque  ;
		$data['num_cheque'] = $tramite->num_cheque  ;
		$data['monto_cheque'] = to_moneda($tramite->monto_cheque)  ;
		$data['fecha_memo_cierre'] = date_to_human($tramite->fecha_memo_cierre)  ;
		// Transferencia
		$data['banco_transfe'] = $tramite->banco_transfe  ;
		$data['num_cta_transfe'] = $tramite->num_cta_transfe  ;
		$data['monto_transfe'] = to_moneda($tramite->monto_transfe)  ;
		$data['fecha_transfe'] = date_to_human($tramite->fecha_transfe)  ;		
		$data['num_confirm_transfe'] = $tramite->num_confirm_transfe  ;
		// Cierre
		$data['num_memo_cierre'] = $tramite->num_memo_cierre  ;
		$data['fecha_entrg_benefi'] = date_to_human($tramite->fecha_entrg_benefi)  ;
		$data['vvnd_bvf'] = to_moneda($tramite->vvnd_bvf)  ;
		$data['fecha_pago_vaca'] = date_to_human($tramite->fecha_pago_vaca)  ;
		$data['nombre_tipo_pago_vaca'] = $tramite->nombre_tipo_pago_vaca  ;
		$tipo_pago = $tramite->tipo_pago ;
		if ($tipo_pago == 'CHEQUE')
			$vista = 'tramite/informe_cheque' ;
		elseif ($tipo_pago == 'TRANSFERENCIA')
			$vista = 'tramite/informe_transfe' ;
		else
			$vista = 'tramite/informe_sin_pago';
						
		$html = $this->parser->parse($vista, $data,TRUE);
		$this->pdf->setFooterText('Generado por: '.$this->session->userdata('usuario').' el '.get_now_full());
		$this->pdf->writeHTML($html, true, false, false, false, ''); 
		$this->pdf->AddPage();
		//die($this->pdf->getFontSize());
		$this->pdf->setFontsize(8);
		$html_her = $this->parser->parse('tramite/heredero/tabla_herederos', $data,TRUE); 
		$this->pdf->writeHTML($html_her, true, false, false, false, ''); 
		$this->pdf->setFontsize(10);
		$this->pdf->AddPage();
		$html_his = $this->parser->parse('tramite/tabla_historico', $data,TRUE); 
		$this->pdf->writeHTML($html_his, true, false, false, false, ''); 
		$this->pdf->Output('informe.pdf', 'I'); 			

	}
		
	function formulario() {
		$this->load->library('parser');
		# id_tramite, cedula, id_trabajador (SIGEFIRRHH), id_empleado (RRHH),
		$id_tramite = (int) $this->uri->segment(3) ;
		$cedula = $this->uri->segment(4) ;
		$id_trabajador = (int) $this->uri->segment(5) ;
		$id_empleado = (int) $this->uri->segment(6) ;				
		if ($id_tramite == 0) {
			$data['accion'] = 'Iniciar Trámite';			
			$data['script'] = '';
			$data['cedula'] = $cedula ;
			$data['id_empleado'] = $id_empleado ;
			$data['id_trabajador'] = $id_trabajador ;
			$data['id_tramite'] = $id_tramite ;
			$data['icon'] = 'tramite_iniciar.png';
			switch ($id_empleado) {
				case 0 : # Se busca el trabajador en el SIGEFIRRHH
					$datos = $this->trabajador_model->get_trabajador_sigefirrhh($id_trabajador);					
					break ;
				default :
					$datos = $this->trabajador_model->get_trabajador_rrhh($cedula, $id_trabajador, $id_empleado);					
					break ;
			}
			#var_dump($datos); exit;
			$data['datos']   =  $datos ;		 	
				
			$data ['main_content'] 		= 'tramite/formulario';  
			register_log('Acceso',"Acceso al formulario para iniciar un trámite al trabajador con C.I.: $cedula");	
			$this->load->view('sistema/template',$data);  

		}
		elseif ($id_tramite > 0) {
			$data['accion'] = 'Editar Trámite';			
			$data['script'] = '';
			$data['cedula'] = $cedula ;
			$data['id_empleado'] = $id_empleado ;
			$data['id_trabajador'] = $id_trabajador ;
			$data['id_tramite'] = $id_tramite ;
			$data['icon'] = 'tramite_editar.png';
			
			$tramite	= $this->tramite_model->get_tramite($id_tramite);						
			$historico	= $this->tramite_model->get_historico($id_tramite);
			$herederos	= $this->heredero_model->get_list($id_tramite);
			$data['tramite']	=  $tramite ;
			$data['historico']	=  $historico ;
			$data['herederos']	=  $herederos ;
			$data['tabla_herederos'] = $this->load->view('tramite/heredero/tabla', $data, TRUE);
			$data['script'] = $this->load->view('tramite/set_tramite', $data, TRUE);
			
			
			switch ($id_empleado) {
				case 0 : # Se busca el trabajador en el SIGEFIRRHH
					$datos = $this->trabajador_model->get_trabajador_sigefirrhh($id_trabajador);					
					break ;
				default :
					$datos = $this->trabajador_model->get_trabajador_rrhh($cedula, $id_trabajador, $id_empleado);				
					break ;
			}			
			$data['datos']   =  $datos ;	
			$data ['main_content'] 		= 'tramite/formulario';  
			register_log('Acceso',"Acceso al formulario para editar trámite ID $id_tramite al trabajador con C.I.: $cedula");	
			$this->load->view('sistema/template',$data);  
		}		
	}
	
	function guardar () {
		$id_tramite			= (int) $this->input->post('id_tramite') ;
		$id_cedula			= $this->input->post('id_cedula') ;
		$id_trabajador		= (int) $this->input->post('id_trabajador') ;
		$id_empleado		= (int) $this->input->post('id_empleado')	;		
		if ($id_tramite == 0) {
			$id_new = $this->tramite_model->insertar() ;
			$this->tramite_model->insert_historico($id_new) ;			
			register_log('Inserción',"Se Registro el Trámite por Primera vez bajo el ID => $id_new",1);    	 	
			#$str  	= dialog('Información','¡Trámite Guardado Satisfactoriamente!',2);   		
			echo block_redirect("¡Trámite Registrado Satisfactoriamente!","tramite/formulario/$id_new/$id_cedula/$id_trabajador/$id_empleado");
		}
		elseif ($id_tramite > 0) {
			$this->tramite_model->actualizar() ;
			$this->tramite_model->insert_historico($id_tramite) ;			
			register_log('Actualización',"Se Actualizó el Trámite con el ID => $id_tramite",1);    	 	
			echo block_redirect("¡Trámite Actualizado Satisfactoriamente!","tramite/formulario/$id_tramite/$id_cedula/$id_trabajador/$id_empleado");
			
		}
		
	}
    
}

/* End of file tramite.php */
/* Location: /application/controllers/tramite.php */
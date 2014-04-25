<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * 
 * @author Jesús Rodríguez
 * @version 
 */	

class Usuario extends CI_Controller {
    function __construct()	{
        parent::__construct();	
		is_logged_in();
        $this->load->model('usuario_model');
		#$this->load->model('trabajador_model');
    }
    
	function index() {	
		register_log('Acceso',"Acceso al listado de todos los usuarios del sistema");
		$data ['main_content'] 	= 'sistema/usuario/listar_usuarios';		
		$data ['tabla'] 		= $this->listar_usuarios();	
		$this->load->view('sistema/template',$data);		
    }
	
    function listar_usuarios (){
    	$base_url = base_url();	
    	$tabla_html =
					"<table cellspacing='1'  class='display' id='datatable'>
    				<thead>
						<tr>
							<th>Usuario</th>
    						<th>Rol</th>
							<th>Creador</th>
    						<th>Estatus</th>
    						<th>Acciones</th>
    					</tr>
    				</thead>";    	
    	$rows = $this->usuario_model->listar_usaurios()  ;    	    	 	
    	foreach ($rows as $key=> $row) {
    				$img 		= "<img src='".base_url()."public/images/editar.png' align='absmiddle'/>";
    		    	$tabla_html .= "<tr id='row_{$row['id_usuario']}'>
									<td>{$row['usuario']}</td>
									<td>{$row['rol']}</td>
									<td>{$row['creador']}</td>
									<td>
										<img src='".$base_url."public/images/{$row['img_estatus']}' title='Estatus: {$row['img_estatus']}' align='absmiddle'/>
									</td>
									<td>
										<a href='".$base_url."usuario/frm_usuario/{$row['id_usuario']}'> <img title='Editar Usuario' src='$base_url/public/images/editar.png' align='absmiddle'/></a>
										<a href='".$base_url."bitacora/usuario/{$row['id_usuario']}'> <img title='Ver Bitacora del Usuario'src='$base_url/public/images/log.png' align='absmiddle'/></a>
									</td>    		    						
    		    					</tr>";
    	}		
		$tabla_html .= "</table>";
		return $tabla_html;
    }
    
    function frm_usuario () {
    	
    	$id_usuario =  $this->uri->segment(3);    		    	
		$data['rules'] = array();
		$script = '';
		$usuario = $this->usuario_model->get_usuario_por_id((int)$id_usuario);
		
		if (($usuario !== FALSE) and (is_numeric($id_usuario))) {
			#die($usuario->id_personal) ;
			$personal = $this->usuario_model->get_datos($usuario->id_personal,'id_personal');
			//var_dump($personal);exit;
			$script  = '<script>';
			$script .= "\n$('#id_usuario').val('{$usuario->id_usuario}');\n";
			$script .= "\n$('#id_personal').val('{$usuario->id_personal}');\n";				
			$script .= "\n$('#cedula').val('{$personal->cedula}');\n";
			$script .= "\n$('#nombres').val('{$personal->nombres}');\n";
			$script .= "\n$('#apellidos').val('{$personal->apellidos}');\n";
			$script .= "\n$('#sexo').val('{$personal->sexo}');\n";
			$script .= "\n$('#cargo').val('{$personal->cargo}');\n";
			$script .= "\n$('#correo').val('{$personal->correo}');\n";
			$script .= "$('#usuario').val('{$usuario->usuario}');\n";
			$script .= "$('#id_estatus').val('{$usuario->id_estatus}');\n";
			$script .= "$('#id_rol').val('{$usuario->id_rol}');\n";
			$script .= "$('#id_estatus').val('{$usuario->id_estatus}');\n";
			$script .= "$('#img_buscar').hide();\n";
			$script .= '</script>';
			$rules[] = ('cedula : { required:true,digits:true }');
			$rules[] = ('usuario : { required:true }');
			$rules[] = ('rol : { required:true }');
			$rules[] = ('estatus : { required:true }');
			$data['rules'] = $rules;
			$data['accion'] = 'Editar Usuario';			
			$data['script'] = $script;
			register_log('Acceso',"Acceso al formulario para modificar el usuario {$usuario->usuario}");
		}
		else {
			$rules[] = ('cedula : { required:true,digits:true }');
			$data['rules'] = $rules;  	
			$data['accion'] = 'Agregar Usuario';			
			$data['script'] = '';
			register_log('Acceso',"Acceso al formulario para agregar un usuario");	
		}
		$data ['main_content'] 		= 'sistema/usuario/frm_usuario';  
		$this->load->view('sistema/template',$data);  	
    }

	function guardar () {
		$this->load->library('adldap');
		$usuario			= $this->input->post('usuario') ;
		$id_usuario			= $this->input->post('id_usuario')	;
		$id_personal		= $this->input->post('id_personal') ;
		$duplicado			= $this->usuario_model->duplicado(array('usuario'=>$usuario))	;
		$existe_ldap		= $this->usuario_model->existe_en_ldap($usuario);	
		$existe_duplicado	= ($id_usuario != '')? $this->usuario_model->duplicado_edit($usuario,$id_usuario):FALSE;
		if ($existe_ldap)
		$str		=	'';	
		
		if($existe_ldap) {
			if (($id_usuario == '') AND (!$duplicado)) {	#### Agrego el nuevo Usuario			
				$id = $this->usuario_model->insertar() ;
				register_log('Inserción',"Se agregó el usuario \"$usuario\" bajo el ID => $id",1);    	 	
				$str  	= dialog('Información','¡Usuario Agregado Satisfactoriamente!',2);   						  	
			}
			elseif (($id_usuario == '') AND ($duplicado)) {			
				register_log('Error',"Se intentó agregar el usaurio \"$usuario\" que ya estaba registrado",1);    	 	
				$str  	= dialog('Error',"¡Usuario \"$usuario\" ya esta registrado en el sistema!",1);	  		
			}		
			elseif ($id_usuario != '' AND (!$existe_duplicado)) {
				$this->usuario_model->editar() ;
				register_log('Modificación',"Se editó el usuario \"$usuario\"",1);    	 	
				$str  	= dialog('Información','¡Usuario Modificado Satisfactoriamente!',2);	  	
			}
			elseif ($id_usuario != '' AND ($existe_duplicado)) {			
				register_log('Error',"Al modificar el usuario \"$usuario\", este ya existe previamente en el sistema",1);
				$str  	= dialog('Error','¡Ya hay un usuario en el sistema con el mismo nombre de usuario!',1);	  	
			}		
			
		}
		else {
			register_log('Error',"Si intento agregar el usuario \"$usuario\", el cual no esta registrado en el LDAP",1);
			$str  	= dialog('Error',"El usuario \"$usuario\", no esta registrado en el LDAP, contacte al personal de informática para crearle el correo institucional",1);
		}
		echo $str;
	}
	
}
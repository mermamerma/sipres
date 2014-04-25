<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
* @Desc Registra un log de acividad 
*
* @author   Autor(es): Jesus Rodriguez
* @access   public
* @param    $accion	Controlador o modulo al cual de esta accediendo
* @param   	$desc	Describe que lo es lo que esta haciendo   
* @param   	$query	Si se desea almacenar la sentencia que se ejecuto 
* @return   void
*/

function register_log($accion = '', $detalle ='', $query = 0)	{		
	$CI 		=  &get_instance();
	$modulo		=  ucfirst(to_minuscula($CI->uri->segment(1)));
	$id_usuario =  $CI->session->userdata('id_usuario');
	$url		=  $_SERVER['REQUEST_URI'];  
	$ip			=  $_SERVER['REMOTE_ADDR'];
	$sql		=  ($query) ? $CI->db->last_query() : null ;
	$fecha		=  now_db_datetime();
	$log 		=  array(
					'id_usuario'=>$id_usuario,
					'ip'=>$ip,'url'=>$url,
					'modulo'=>$modulo,
					'accion'=>$accion,
					'detalle'=>$detalle,
					'sentencia'=>$sql,
					'fecha_creacion'=>$fecha
					);
	$CI->db->insert('bitacora', $log);		 
}

/**
* 
* @Desc Verifica si el usuario esta logueado
*
* @author  Author(s): Jesus Rodriguez
* @return   bool 
*/
function is_logged_in()  {
	$CI =& get_instance();		
   	$esta_logueado = $CI->session->userdata('esta_logueado'); 
   	
   	if( ! isset($esta_logueado) || $esta_logueado !== TRUE) {
   		redirect(base_url().'login/sesion_requerida','refresh');
		exit();
   		#echo 'Tu no tienes permiso para acceder a esta página; <a href="'.base_url().'login">Iniciar Sesión</a>';    		
   		#die();
   	}		
} 

/**
* 
* @Desc 	Para imprimir un dialog JQuery 
*
* @author   Autor(es): Jesus Rodriguez
* @access   public
* @param    String		$titulo		Titulo de la ventana
* @param	String		$msj		descripción del Mensaje
* @param   	String		$class		En tipo de imagen que se va a mostrar 1: es un Alert 2:Check		
* 
*/
function dialog($titulo, $mensaje, $class){
	$img = array('1' => 'ui-icon ui-icon-alert', '2'=>'ui-icon ui-icon-circle-check'); 
	
	$str = "<script>
			$(function() {
			$( '#dialog' ).dialog({autoOpen: true, modal:true, 
			buttons: {
			Aceptar: function() {
				$( this ).dialog( \"close\" );	
				$('#resultado-ajax').html('');
				} }
			});
			});
			</script>		
			<div class='demo'>
				<div id='dialog' title='$titulo'>
					<br /><br />					
					<div<p><span class='{$img[$class]}' style='float:left; margin:0 7px 20px 0;'></span>$mensaje</p>
				</div>
			</div>
			</script>";
	return $str;		
}

function mensaje($msj) {
	return "<script>mensaje('$msj');</script>";
}

function msj_redirect($msj,$url = '') {
	//$url = 'http://www.google.co.ve' ;
	return "<script>mensaje_redirect('$msj','$url');</script>";
}

function block_redirect($msj, $url = '') {
	$url = base_url().$url; 	
	return "<script>block_redirect('$msj','$url');</script>";
}
/**
* 
* @Desc 		Para imprimir el java script que va eliminar un registro vida datatable 
*
* @author		Autor(es): Jesus Rodriguez
* @access		public
* @param		Int		$id 		Registro que va a ser eliminado
* @param		String	$action		Action de la forma
* @return   	String	$str
*/

function js_eliminar($action) {
	$action = base_url().$action;
	$str=<<<EOF
<script>
function eliminar(id) {
	$("#dialog:ui-dialog").dialog("destroy");
	$("#dialog").dialog({
		resizable: false,
		title: 'Atención',
		modal: true,
		buttons: {
			"Borrar el registro": function() {
				$( this ).dialog( "close" );
				$.ajax({
					url:'$action'+id,
					type:'get',					
					success:function(data){ $('#resultado-ajax').html(data) }
				});
			},
			"Cancelar": function() {
				$( this ).dialog( "close" );				
			}
		}
	});
	$('#dialog').html("<p><span class='ui-icon ui-icon-alert' style='float:left; margin:0 7px 20px 0;'></span> Este registro será elimiando permanentemente y no podrá ser recuperado. ¿Esta Ud. Seguro?	</p>");
}
</script>
EOF;
echo  $str ;
}

/**
* 
* @Desc 	Para imprimir el action y las reglas de un formulario con Jquery 
*
* @author   Autor(es): Jesus Rodriguez
* @access   public
* @param    String		$fomr		Nombre del formulario
* @param	String		$base_url	URL de la app
* @param   	String		$action		Action de la forma
* @param   	Array		$rule		Arreglo con las reglas implementando el Pluguin		
* @param   	String		$img		Nombre del archivo con la animación, el ID del TAG img debera de ser igual an nombre del archivo sin la extensión
* 
*/
function ajaxifica($form, $action, $rules = array(), $img = ''){
	$variable = 		
	$action   = base_url().$action;
	$src_img  = base_url().'public/images/error.png';
	$now	  = get_hour(6);		
    if ($img != '') {   	 
    	$id_img   = substr($img, 0, strpos($img, '.'));    	
    	$show_gif = "$('#$id_img').show();";
    	$hide_gif = "$('#$id_img').hide();";
    }
    else {
    	$show_gif =	 '';
    	$hide_gif = '';
    }      
    	
	$rules_js = '';
	$num_rules = count($rules);

	if ($num_rules > 1) {
		for ($i=0; $i < count($rules) -1 ; $i++) {
			$rules_js .= $rules[$i].', ';
		}
		$rules_js = $rules_js.$rules[count($rules)-1];
		$rules_js;
	}	
	elseif ($num_rules == 1) 
		$rules_js .= $rules[0]		;
	elseif ($num_rules == 0)
		$rules_js .= ''		;
	$hora = get_hour(6);
	$str=<<<EOF
<script>
			
function enviar (){
	if($('#form1').valid()){
		$show_gif
		$.ajax({
				url:'$action',
				type:'post',
				data:$('#$form').serialize(),
				success:function(data){ 
					$('#resultado-ajax').html(data);
					$hide_gif
					
				}
		});
	}
	else {
	$("#tabs").tabs("select", "tabs-2");
	msj_invalido() ;
	}
	
}
			
$(document).ready(function(){	
	$( '#dialog' ).dialog({autoOpen: false, modal:true});
	$(".boton").button(); 
	$(function() { $( '#tabs' ).tabs();});
	
});

$(document).ready(function(){			
$('#$form').validate({
	rules:{
		$rules_js			
		}}
	);
;
		})
$(function() {
	$.easydate.set_now('$hora');
	$(".easydate").easydate();
});
</script>
EOF;
echo  $str ;
}

function ajaxifica_tramite($form, $action, $rules = array(), $img = ''){
	$variable = 		
	$action   = base_url().$action;
	$src_img  = base_url().'public/images/error.png';
	$now	  = get_hour(6);		
    if ($img != '') {   	 
    	$id_img   = substr($img, 0, strpos($img, '.'));    	
    	$show_gif = "$('#$id_img').show();";
    	$hide_gif = "$('#$id_img').hide();";
    }
    else {
    	$show_gif =	 '';
    	$hide_gif = '';
    }      
    	
	$rules_js = '';
	$num_rules = count($rules);

	if ($num_rules > 1) {
		for ($i=0; $i < count($rules) -1 ; $i++) {
			$rules_js .= $rules[$i].', ';
		}
		$rules_js = $rules_js.$rules[count($rules)-1];
		$rules_js;
	}	
	elseif ($num_rules == 1) 
		$rules_js .= $rules[0]		;
	elseif ($num_rules == 0)
		$rules_js .= ''		;
	$hora = get_hour(6);
	$str=<<<EOF
<script>
			
function enviar (){
	if($('#form1').valid()){
		$show_gif
		$.ajax({
				url:'$action',
				type:'post',
				data:$('#$form').serialize(),
				success:function(data){ 
					$('#resultado-ajax').html(data);
					$hide_gif
					
				}
		});
	}
	else {				
		$("#tabs").tabs("select", "tabs-2");
		$("#msj_error_estatus").show();
		msj_invalido() ;
	}
	
}
			
$(document).ready(function(){	
	$( '#dialog' ).dialog({autoOpen: false, modal:true});
	$(".boton").button(); 
	$(function() { $( '#tabs' ).tabs();});
	
});

$(document).ready(function(){			
$('#$form').validate({
	rules:{
		$rules_js			
		}}
	);
;
		})
$(function() {
	$.easydate.set_now('$hora');
	$(".easydate").easydate();
});
</script>
EOF;
echo  $str ;
}

/**
* 
* @Desc     Para Exportar una consulta a base de datos mediante un XLS
* @link     https://github.com/EllisLab/CodeIgniter/wiki/Excel-Plugin 
* @author   Autor(es): Jesus Rodriguez
* @access   public
* @param    Array       $query          Resultado de la consulta a BD
* @param    String      $file           Nombre del archivo
* 
*/
function export_to_xls($query, $file = 'export'){
     $headers = ''; // just creating the var for field headers to append to below
     $data = ''; // just creating the var for field data to append to below
     
     $fields = $query->field_data();
     #var_dump($fields);
     if ($query->num_rows() == 0) {
          echo '<p>La tabla al parecer no contiene datos.</p>';
     } 
     else {
          foreach ($fields as $field) {
             $headers .= $field->name . "\t";
          }
     
          foreach ($query->result() as $row) {
               $line = '';
               foreach($row as $value) {                                            
                    if ((!isset($value)) OR ($value == "")) {
                         $value = "\t";
                    } else {
                         $value = str_replace('"', '""', $value);
                         $value = '"' . $value . '"' . "\t";
                    }
                    $line .= $value;
               }
               $data .= trim($line)."\n";
          }
          
          $data = str_replace("\r","",$data);
                         
          header("Content-type: application/x-msdownload");
          header("Content-Disposition: attachment; filename=$file.xls");
          echo "$headers\n$data";  
     }
    

}

function to_moneda_bd($string)
{
	$string = str_replace('.', '', $string) ;
    $Negative = 0;

    if(preg_match("/^\-/",$string))
    {
        $Negative = 1;
        $string = preg_replace("|\-|","",$string);
    }

    $string = preg_replace("|\.|","",$string);
    $Full = @split("[\,]",$string);

    $Count = count($Full);

    if($Count > 1)
    {
        $First = $Full[0];
        $Second = $Full[1];
        $NumCents = strlen($Second);
        if($NumCents == 2)
        {

        }
        else if($NumCents < 2)
        {
            $Second = $Second . "0";
        }
    }
    else if(@$NumCents > 2)
    {
        $Temp = substr($Second,0,3);
        $Second = substr($Temp,0,2);
    }else
    {
        $First = $Full[0];
        $Second = "00";
    }

    $length = strlen($First);

    if( $length <= 3 )
    {
        $string = $First . "." . $Second;

    // if negative flag is set, add negative to number
        if($Negative == 1)
        {
            $string = "-" . $string;
        }

        return $string;
    }
    else
    {
        $loop_count = intval( ( $length / 3 ) );
        $section_length = -3;
        for( $i = 0; $i < $loop_count; $i++ )
        {
            $sections[$i] = substr( $First, $section_length, 3 );
            $section_length = $section_length - 3;
        }

        $stub = ( $length % 3 );
        if( $stub != 0 )
        {
            $sections[$i] = substr( $First, 0, $stub );
        }

        $Done = implode( "", array_reverse( $sections ) );
        $Done = $Done . "." . $Second;

        if($Negative == 1)
        {
            $Done = "-" . $Done;
        }

        return $Done;

    }
}

function to_moneda($input){
	return number_format($input,2,',' ,'.') ;
}

function to_moneda2($string)
{

    $Negative = 0;

    if(preg_match("/^\-/",$string))
    {
        $Negative = 1;
        $string = preg_replace("|\-|","",$string);
    }

    $string = preg_replace("|\,|","",$string);	

    $Full = @split("[\.]",$string);
	
    $Count = count($Full);

    if($Count > 1)
    {
        $First = $Full[0];
        $Second = $Full[1];
        $NumCents = strlen($Second);

        if($NumCents == 2)
        {

        }
        else if($NumCents < 2)
        {
            $Second = $Second . "0";
        }
        else if($NumCents > 2)
        {
            $Temp = substr($Second,0,3);
            $Second = substr($Temp,0,2);
        }
    }
    else
    {
        $First = $Full[0];
        $Second = "00";
    }

    $length = strlen($First);

    if( $length <= 3 )
    {
        $string = $First . "," . $Second;

        if($Negative == 1)
        {
            $string = "-" . $string;
        }

        return $string;
    }
    else
    {
        $loop_count = intval( ( $length / 3 ) );
        $section_length = -3;

        for( $i = 0; $i < $loop_count; $i++ )
        {
            $sections[$i] = substr( $First, $section_length, 3 );
            $section_length = $section_length - 3;
        }

        $stub = ( $length % 3 );
        if( $stub != 0 )
        {
            $sections[$i] = substr( $First, 0, $stub );
        }

        $Done = implode( "", array_reverse( $sections ) );
        $Done = $Done . "," . $Second;

        // if negative flag is set, add negative to number
        if($Negative == 1)
        {
            $Done = "-" . $Done;
        }

        return $Done;

    }
}

function to_mayuscula($input) {
	return mb_strtoupper($input,'UTF-8') ;
}

function to_minuscula($input) {
	return mb_strtolower($input,'UTF-8') ;
}


/**
* 
* @Desc     Para quitar los saltos de línea y las Tabualciones de una entrada y quedar todo en una sola línea
* @link     https://github.com/EllisLab/CodeIgniter/wiki/Excel-Plugin 
* @author   Autor(es): Jesus Rodriguez
* @access   public
* @param    String	$input	String a limpiar
* @return	String  $input	String de una sola línea
* 
*/
function code_line($input) {	
	$input = str_replace(chr(10), " ", $input);
	$input = str_replace(chr(13), " ", $input);
	return $input;
}
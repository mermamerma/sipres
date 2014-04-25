<div id="dialog">
</div>
<div id="dialog-confirm" title="Atención">
</div>
<div id="form_container">
<form id="form1" class="appnitro" method="post" action="<?=base_url().'reporte/imprimir'?>" target="_blank">
<?=form_hidden('modo'); ?>
  <div class="form_description">
    <h2><?= $accion ?><img id="img_accion" class="icon_accion" src="<?=base_url().'public/images/iconos/'.$icon?>" /></h2>
    <p>Formulario</p>
    </div>
    <div id="tabs">
		<ul>			
			<li><a href="#tabs-1"><img class="ui-icon ui-icon-search"/>Parametros de Busqueda</a></li>					
		</ul>
		       
		<div id="tabs-1">
		<table width="826" border="0" id="tabla_datos_trabajador" style="display:block">                          
          <tr>
            <td>
				<li>
				<label class="description_2" for="element_2">Cédula</label>
				<?= form_input('cedula','','class="element text medium-form"')?>		
				</li>
			</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>
				<li>
				<label class="description_2" for="element_2">Nombres</label>
				<?= form_input('nombres','','class="element text medium-form" onkeyup="convert_mayusculas(this)"')?>		
				</li>
			</td>
            <td><label class="description_2" for="element_2">Apellidos</label>
              <?= form_input('apellidos','','class="element text medium-form" onkeyup="convert_mayusculas(this)"')?></td>
          </tr>
          <tr>
            <td>
				<li>
				<label class="description_2" for="element_2">Estatus del Trámite</label>
				<?= form_dropdown_custom('id_estatus_tramite',SQL_TRAM);?>						
				</li>			</td>
            <td><label class="description_2" for="element_2">Motivo del Egreso</label>
              <?= form_dropdown_db('id_motivo_egreso', 'motivo_egreso');?></td>
          </tr>
           <tr>
            <td>
				<li>
                  <label class="description_2" for="element_2">Usuario que lo Registró</label>
                  <?= form_dropdown_custom('id_usuario',SQL_ANALISTAS_ACTIVO);?>
				</li>			</td>
            <td>
				<label class="description_2" for="element_2">Analista Asignado</label>
				<?= form_dropdown_custom('id_usuario_asignado',SQL_ANALISTAS_ACTIVO);?>			</td>
          </tr>     
          <tr>
            <td width="410">
				<li>
                  <label class="description_2" for="element_2">Fecha de Creación - Cominezo</label>
                  <?= form_date_picker('fecha_inicio_begin','','class="element text medium-form"');?>
				</li>			</td>
            <td width="406"><label class="description_2" for="element_2">Fecha de Creación - Final</label>
              <?= form_date_picker('fecha_inicio_end','','class="element text medium-form"');?></td>
          </tr>          
          <tr>
            <td>
				<li>
                  <label class="description_2" for="element_2">Fecha de Asignación - Cominezo</label>
                  <?= form_date_picker('fecha_asignacion_begin','','class="element text medium-form"');?>
				</li>			</td>
            <td><label class="description_2" for="element_2">Fecha de Asignación - Final</label>
              <?= form_date_picker('fecha_asignacion_end','','class="element text medium-form"');?></td>
          </tr>              
                    <tr>
            <td>
				<li>
				<label class="description_2" for="element_2">Tipo de Pago</label>
				<?= form_dropdown_db('id_tipo_pago','tipo_pago','onchange=javascript:cambio_tipo_pago();');?>						
				</li>			</td>
            <td>
				<span id="banco_cheque" style="display:none">								
				<label class="description_2">Banco Emisor del Cheque</label>
				<?= form_dropdown_db('id_banco_cheque','banco');?>										
				</span>
				<span id="banco_transfe" style="display:none">								
				<label class="description_2">Banco Receptor de la Transferencia</label>
				<?= form_dropdown_db('id_banco_transfe','banco');?>										
				</span>			</td>
          </tr> 
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr align="center" id="tr_titulo_reporte" style="display:none">
                      <td colspan="2">
					  	<li>
						<label class="description_2"> *****   Título del Reporte   *****</label>
						<?= form_input('titulo','','class="element text medium-form" onkeyup="convert_mayusculas(this)"')?>					
						</li>
						<br />					  </td>
                    </tr>
                    <tr align="center">
                      <td colspan="2"><img id="progress_bar" style="display:none" src="<?=base_url()?>public/images/progress_bar.gif" /></td>
                    </tr>
          <tr>
            <td colspan="2">			
			<div id="resultado-ajax"></div>			</td>
          </tr>           
        </table>		
		</div>
    </div>
</form>  
  	     	  
  	<div id="boton_buscar" class="boton" onclick="javacript:enviar_busqueda();">Buscar</div>  
	     
	<div id="boton_restablecer" class="boton" onclick="javacript:restablecer();">Restablecer</div>  
	     
	<div id="boton_cancelar" class="boton" onclick="javacript:$(location).attr('href','<?=base_url()?>');">Cancelar</div>
	<span id="botones_hay" style="visibility:hidden">
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
  	<div id="boton_pdf" class="boton" onclick="javacript:generar_pdf();">Generar PDF</div>
	     	
  	<div id="boton_xls" class="boton" onclick="javacript:generar_xls();">Generar XLS</div>
	</span>
  	<br /><br />
</div>

<script>

$("#boton_buscar").button({icons: {primary: "ui-icon-gear"},  	text: true	});
$("#boton_restablecer").button({icons: {primary: "ui-icon-arrowreturnthick-1-w"},  	text: true	});
$("#boton_cancelar").button({icons: {primary: "ui-icon-cancel"},	text: true	});
$("#boton_pdf").button({icons: {primary: "ui-icon-document"},		text: true	});
$("#boton_xls").button({icons: {primary: "ui-icon-calculator"},		text: true	});

function restablecer() {
	$('#form1').reset();
	$('#resultado-ajax').html('');
	$('#tr_titulo_reporte').hide();
	$('#botones_hay').css("visibility","hidden");
}

function convert_mayusculas(field) {
            field.value = field.value.toUpperCase()
}

function generar_pdf() {
	$('#modo').val('PDF');
	$('#form1').submit();
}

function generar_xls() {
	$('#modo').val('XLS');
	$('#form1').submit();
}

function enviar_busqueda (){
	$('#boton_buscar').hide();
	$('#boton_restablecer').hide();
	$('#tr_titulo_reporte').hide();
	$('#resultado-ajax').html('');
	$('#modo').val('');
	$('#botones_hay').css("visibility","hidden");
	if($('#form1').valid()){		
		$("#progress_bar").show('slide');
		$.ajax({
				url:'<?=base_url()?>reporte/buscar',
				type:'post',
				data:$('#form1').serialize(),
				success:function(data){ 
					$('#boton_buscar').show();
					$('#boton_restablecer').show();
					$("#progress_bar").hide();
					$('#resultado-ajax').html(data);					
					
				}
		});
	}
	else {
	$('#boton_buscar').show();
	$('#boton_restablecer').show();
	$("#tabs").tabs("select", "tabs-2");
	msj_invalido() ;
	}
	
}

$(document).ready(function(){
	$(".boton").button(); 	
});

// Reglas del Formulario Reporte
$(function() {
	$( "#tabs" ).tabs();
	$('#form1').validate({
		rules:{	
			cedula : {  digits:true },
			fecha_inicio_begin : { dateDE: true  }, fecha_inicio_end : { dateDE: true  }, fecha_asignacion_begin : { dateDE: true  }, fecha_asignacion_end : { dateDE: true  }
		}}
	);	
});

function cambio_tipo_pago() {
	id_tipo_pago = $('#id_tipo_pago').val();	
	if (id_tipo_pago == 1) { // Cheque
		$('#id_banco_transfe').val('');
		$('#banco_cheque').css("display","block");
		$('#banco_transfe').css("display","none");
	}
	else if (id_tipo_pago == 2){ // Transferencia
		$('#id_banco_cheque').val('');
		$('#banco_transfe').css("display","block");
		$('#banco_cheque').css("display","none");	
	}
	else if (id_tipo_pago == ''){ // Ningún tipo de Pago
		$('#id_banco_cheque').val('');
		$('#id_banco_transfe').val('');
		$('#banco_transfe').css("display","none");
		$('#banco_cheque').css("display","none");	
	}
}


</script>
<?= $script ?>
<?=ajaxifica('form1','reporte/buscar',$rules = array())?>




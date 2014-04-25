<div id="dialog">
</div>
<div id="form_container">
<form id="form1" class="appnitro" method="post">
  <div class="form_description">
      <h2><?=$accion;?> <img id="img_accion" class="icon_accion" src="<?=base_url().'public/images/iconos/form_search.png'?>" /></h2>
      <p>Formulario de Busqueda</p>
	  <?=form_hidden('id_personal'); ?>
	<?=form_hidden('id_empleado'); ?>
    </div>
    <div id="tabs">
	<ul>
	<li><a href="#tabs-1">Datos de Trabajador</a></li>
	</ul>
	<div id="tabs-1">
    <table width="825" border="0">      
      <tr>
        <td>
			<li>
			<label class="description" for="element_2">Cédula del Trabajador <span class="required">(*)</span></label>
			<?= form_input('cedula','','class="element text small"')?>
			<img id="img_buscar" src="<?=base_url().'public/images/lupa.png'?>"  onclick="javascript:consultar()" style="cursor:pointer;" />
			<?=img( array('src' => 'public/images/activityanimation.gif','alt'=>'Procesando','longdesc'=>'Buscando', 'id'=>'activityanimation', 'style'=>'display:none'));?>
			</li>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>
			<div id="resultado-ajax">			</div>		</td>
      </tr>
    </table>
   </div>           
  </form>
  <div id="boton_generar" class="boton" onclick="javacript:enviar();" style="display:none">Generar Ficha</div>		       
  <br /><br />  
  </div>
<script>

$('#form1').bind("keypress", function(e) {
  if (e.keyCode == 13) {               
    e.preventDefault();
	consultar();
    return false;
  }
});

function consultar() {
	if($('#form1').valid()){
		$('#activityanimation').show();
		//$('#resultado-ajax').hide();		
		$.ajax({
			url:'<?=base_url()?>trabajador/buscar_tramites',
			type:'post',
			data:$('#form1').serialize(),
			success:function(data){
				$('#activityanimation').hide();
				$('#resultado-ajax').html(data);
				//$('#resultado-ajax').show();					
			}
		});
	}
}
$(document).ready(function(){				
	$('#form1').validate({ rules:{ cedula : { required:true,digits:true }	}}	);
	$(".boton").button(); 
	$(function() { $( '#tabs' ).tabs();});	
	$('#cedula').focus(); 
});

function test() {
	mensaje('Personal con la cédula no existe en SIGEFIRRHH ni el SIRRHH') ;
	//alert('Me ejecuto');
}
</script>


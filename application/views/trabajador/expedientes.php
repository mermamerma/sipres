<div id="resultado-ajax">
</div>
<div id="dialog">
</div>
<div id="form_container">
<form id="form1" class="appnitro" method="post" action="<?=base_url().'trabajador/tramite/guardar/'?>" >
  <div class="form_description">
    <h2>aaaaaaaaaa</h2>
    <p>Formulario</p>
    <p><a href="javascript:confirmar();">testy</a></p>
  </div>
<div id="tabs">
<ul>
	<li><span class="ui-icon ui-icon-flag"></span><a href="#tabs-1">Trabajador</a></li>
	<li><a href="#tabs-2">Trámite</a></li>
	<li><a href="#tabs-3">Movimientos</a></li>	
	<li><a href="#tabs-4">Movimientos</a></li>	
</ul>
	<div id="tabs-1">
		<table id="tbl_resultado">
		<thead>
		<tr class="ui-widget-header ">
		<th>Cédula</th>
		<th>Nombres sdf sdf sd</th>
		<th>Apellidos</th>
		<th>Ingreso</th>
		<th>Egreso sdf sdf sdf</th>
		<th>Estatus</th>
		<th>Motivo</th>
		<th>Observaciones</th>
		<th>-----</th>
		</tr>
		</thead>
		<tbody>
		<tr>
		<td>111</td>
		<td>2222</td>
		<td>333</td>
		<td>444</td>
		<td>5555</td>
		<td>666</td>
		<td>777</td>
		<td>8888</td>
		<td>&nbsp;</td>
		</tr>
		</tbody>
		</table>
		<script>
		$(function() {
			var oTable1 = $('#tbl_resultado').dataTable({
				"aaSorting": [[ 0, "desc" ]],
				"bAutoWidth":false,
				"bJQueryUI": true,
				"sPaginationType": "full_numbers",
				"bScrollCollapse": true	
			});
		}); 
		</script>
	</div>
</div>
  </form>
  
  
	<script>
$(function() {
	var name = $( "#name" ),
	email = $( "#email" ),
	password = $( "#password" ),
	allFields = $( [] ).add( name ).add( email ).add( password ), tips = $( ".validateTips" );
	$( "#dialog-form" ).dialog({
	autoOpen: false,
	height: 430,
	width: 450,
	modal: true,
	buttons: {
		"Registrar Heredero": function() {
		var bValid = true;
		// From jquery.validate.js (by joern), contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
		if ( bValid ) {
			$( "#users tbody" ).append( "<tr>" +
			"<td>" + name.val() + "</td>" +
			"<td>" + email.val() + "</td>" +
			"<td>" + password.val() + "</td>" +
			"</tr>" );
			$( this ).dialog( "close" );
		}
		},
		Cancel: function() {
			$( this ).dialog( "close" );
		}
		},
		close: function() {
			allFields.val( "" ).removeClass( "ui-state-error" );
		}
		});
		$( "#create-user" )
	.button()
	.click(function() {
	$( "#dialog-form" ).dialog( "open" );
	});
	});
</script>
    		       
  <div id="aceptar" class="boton ui-button-text" onclick="">Aceptar</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <div id="cancelar" class="boton" onclick="javacript:history.go(-1);">Cancelar</div>
  <br /><br />
  </div>
<script>

$("#tab1").button({icons: {primary: "ui-icon-gear"},  text: true	});

$(function() {
	$(".boton").button(); 
	$( "#tabs" ).tabs();
	
});

function enviar () {
	if($('#form1').valid()){
		alert('envio la forma') ;
	}
}

function testy() {
	r = confirmar('Esta seguro de eliminar??') ;	
}

$(document).ready(function() { 
    $('#aceptar').click(function() { 
        block_redirect('Registro Actualizado','#');
    });    
}); 

$(document).ready(function() { 
    $('#demo8').click(function() { 
        $.blockUI(); 
 
        setTimeout(function() { 
            $.unblockUI({ 
                onUnblock: function(){ alert('onUnblock'); } 
            }); 
        }, 2000); 
    }); 
}); 
        


</script>

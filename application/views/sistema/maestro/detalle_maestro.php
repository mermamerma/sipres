<div id="resultado-ajax">
</div>
<div id="form_container">
	<form id="form1" class="appnitro" method="post" action="">
		<div class="form_description">
			<h2>Detalle Maestro - <?=$desc?> <img id="img_accion" class="icon_accion" src="<?=base_url().'public/images/iconos/table_relationship.png'?>" /></h2> 
			<p>Lista de Registro</p>
		</div>	
		<div id="tabla_pintada">
		</div>	
		<div id="datatable_container">
		<?= $tabla?>
		</div>
	<br />
	<div id="boton_agregar" class="boton" onclick="javacript:frm_maestro('','',<?=$id_tabla?>)">Agregar</div>	         		
	<div id="boton_recargar" class="boton" onclick="javacript:window.location.href = '<?=base_url()?>maestro/detalle/<?=$id_tabla?>';">Recargar Tabla</div>		
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<div id="boton_volver" class="boton" onclick="javacript:window.location.href = '<?=base_url()?>maestro';">Volver a Maestros</div>		   		
	</form>
</div>
<script>

$("#boton_agregar").button({icons: {primary: "ui-icon-circle-plus"},  	text: true	});
$("#boton_recargar").button({icons: {primary: "ui-icon-refresh"},  	text: true	});
$("#boton_volver").button({icons: {primary: "ui-icon-arrowreturnthick-1-w"},  	text: true	});

/* Global var for counter */

function cambiar_(nombre, c){
	var intIndexOfMatch = nombre.indexOf(c);
	while (intIndexOfMatch != -1){
		nombre = nombre.replace(c,' ');
		intIndexOfMatch = nombre.indexOf(c);
	}
	return nombre;
}



function frm_maestro(id, nombre, id_tabla) {
	nombre = cambiar_(nombre,'_');
	$("#id_row").val(id);
	$("#nombre").val(nombre);
	$("#id_tabla").val(id_tabla);
	$("#dialog-form").dialog( "open" );	
	$("#dialog-form").css("height","130px");
}	

$(function() {
	var oTable = $('#datatable').dataTable({
		"bAutoWidth":false,
		"bJQueryUI": true,
		//"bProcessing": true,
		"sPaginationType": "full_numbers",
		"iDisplayLength": 20,
		"bScrollCollapse": true
	});
	$(".boton").button(); 
	
	$('#new').click( function (e) {
    	e.preventDefault();       	
		//$('#datatable').dataTable().fnAddData( [ '1111111111', '22222222222222222'] ); 
	} );
	
	function detalle_maestro (maestro) {
		url = "<?=base_url()?>maestro/detalle/"+maestro;  
		$(location).attr('href',url);  
	}
	


	// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
	$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
	var name 	= $( "#nombre" ),
	allFields 	= $( [] ).add( name ),
	tips 		= $( ".validateTips" );
	
	function updateTips( t ) {
			tips
				.text( t )
				.addClass( "ui-state-highlight" );
			setTimeout(function() {
				tips.removeClass( "ui-state-highlight", 1500 );
			}, 500 );
	}

	function checkLength( o, n, min, max ) {
		if ( o.val().length > max || o.val().length < min ) {
			o.addClass( "ui-state-error" );
			updateTips( "Longitud de " + n + " debe estar entre " +min + " y " + max + "." );
			return false;
		} 
		else {return true;}
	}

	function checkRegexp( o, regexp, n ) {
	if ( !( regexp.test( o.val() ) ) ) {
		o.addClass( "ui-state-error" );
		updateTips( n );
		return false;
	} 
	else {return true;}
	}
		
	$( "#dialog-form" ).dialog({
		autoOpen: false,
		height: 300,
		width: 350,
		modal: true,
		buttons: {
			"Aceptar": function() {
				var bValid = true;
				allFields.removeClass( "ui-state-error" );
				bValid = bValid && checkLength( name, "Nombre", 1, 50 );
				//bValid = bValid && checkRegexp( name, /^[a-zA-Z ñ Ñ á Á éÉ íÍ óÓ úÚ _]([0-9a-z_ ])+$/i, "Debe comenzar con una letra, puede estar constituido de la a-z, 0-9, guión bajo , y espacios en blanco." );
					if ( bValid ) {
						var nombre = $("#nombre").val();
						var img = "<img src='<?=base_url()?>public/images/editar.png' align='absmiddle'/><a href='#' onclick=javascript:frm_maestro("
						$.ajax({
							url:'<?=base_url().'maestro/procesar'?>',
							type:'post',
							dataType:'script',
							data:$('#form2').serialize(),
							success:function(data){							 								
								$('#resultado-ajax').html(data);								
							}
						});
						$( this ).dialog( "close" );
					}
			},
			"Cancelar": function() 
				{$( this ).dialog( "close" );}
		},
		close: function() 
			{allFields.val( "" ).removeClass( "ui-state-error" );}
	});
});
</script>
<div class="demo">
<div id="dialog-form" title="Crear nuevo registro" style="height:230px;">
<form id="form2" method="post" action="#">
	<p class="validateTips"></p>
	<p></p>
	<h5>Nombre</h5>
	<input type="text" name="nombre" id="nombre" class="text ui-widget-content ui-corner-all" onkeypress="return event.keyCode!=13" />
	<input type="hidden" name="id_row" id="id_row"  value=""/>	
	<input type="hidden" name="id_tabla" id="id_tabla"  value=""/>	
</form>
</div>
</div><!-- End demo -->
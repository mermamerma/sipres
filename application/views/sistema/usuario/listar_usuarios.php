<div id="resultado-ajax">
</div>
<div id="form_container">
	<form id="form1" class="appnitro" method="post" action="">
		<div class="form_description">
			<h2>Usuarios <img id="img_accion" class="icon_accion" src="<?=base_url().'public/images/iconos/usuarios.png'?>" /></h2>
			<p>Lista de los usuarios registrados en el sistema</p>
		</div>	
		<div id="tabla_pintada">
		</div>	
		<div id="datatable_container">
		<?= $tabla?>
		</div>
	<br />
	<div id="boton_agregar" class="boton" onclick="javacript:window.location.href = '<?=base_url()?>usuario/frm_usuario/' ">Agregar</div>	
	</form>
</div>
<script>
$("#boton_agregar").button({icons: {primary: "ui-icon-circle-plus"},  	text: true	});


$(function() {
	var oTable = $('#datatable').dataTable({
		"bAutoWidth":false,
		"bJQueryUI": true,
		//"bProcessing": true,
		"sPaginationType": "full_numbers",
		"iDisplayLength": 15,
		"bScrollCollapse": true
	});
}); 
$(".boton").button(); 
</script>
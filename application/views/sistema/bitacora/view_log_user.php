<div id="resultado-ajax">
</div>
<div id="dialog">
</div>
<div id="form_container">
<form id="form1" class="appnitro" method="post" action="" style="width:">
	<div class="form_description">
 		<h2>Bitácora del Usuario <?=@$usuario->usuario?></h2> 
      <p>Lista de las actividades diarias en el sistema</p>	  
	</div>
	<?php echo $this->table->generate($results); ?>
	<br />	
	<div class="" id="" style="font-weight:bold">Mostrando <?=$inicio?> de un total de <?=$total_rows?> registros</div>
	<br /> 
	<?php echo $this->pagination->create_links(); ?>
	<br /><br /><br />
	<div id="boton_agregar" class="boton" onclick="javacript:window.location.href = '<?=base_url()?>usuario' ">Volver</div>		  	
</form>
</div>
<script>
$(function(){
		$('#datatable').dataTable({
			"bAutoWidth":true,
			"bJQueryUI": true, 
			"bPaginate": false,
			"bInfo": false
		});
});
$(".boton").button(); 
</script>


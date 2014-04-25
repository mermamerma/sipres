<table id="tbl_resultado">
<thead>
<tr class="">
  <th>Cédula</th>
<th>Nombres</th>
<th>Apellidos</th>
<th>Ingreso</th>
<th>Egreso</th>
<th>Motivo</th>
<th>Estatus</th>
<th>Analista</th>
<th>Origen</th>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>
<?php foreach($tramites as $row): ?>
<tr>
<td><?=$row->cedula?></td>
<td><?=$row->nombres?></td>
<td><?=$row->apellidos?></td>
<td><?=date_to_human($row->fecha_ingreso)?></td>
<td><?=date_to_human($row->fecha_egreso)?></td>
<td><?=$row->motivo_egreso?></td>
<td><?=$row->estatus_tramite?></td>
<td><?=$row->analista_asignado?></td>
<td><?=$row->origen?></td>
<td>
<a class="ui-icon ui-icon-search" title="Ver Trámite"  href="<?=base_url()?>tramite/formulario/<?=$row->id_tramite?>/<?=$row->cedula?>/<?=$row->id_trabajador?>/<?=$row->id_empleado?>"></a></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<script>
$(function() {
	var oTable1 = $('#tbl_resultado').dataTable({
		"aaSorting": [[ 0, "asc" ]],
		"bAutoWidth":false,
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"bScrollCollapse": true	
	});
}); 

<?php if (count($tramites) > 0): ?>
	$('#botones_hay').css("visibility","visible");
	$('#tr_titulo_reporte').show();
<?php endif; ?>

</script>
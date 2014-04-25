<table id="users" class="" border="1" bordercolor="#3B5998" cellspacing="0">
<thead>
<tr class="ui-widget-header ">
<th>Cédula</th>
<th>Nombres y Apellidos</th>
<th>Parentesco</th>
<th>Banco</th>
<th>N° Cheque </th>
<th>Monto</th>
<th>Emisión</th>
<th>Entrega</th>
<th>Usuario </th>
<th>Realizado</th>
<?php if ($this->session->userdata('acceso') == 'administrador') :  ?>
<th>Acción</th>
<?php endif; ?>
</tr>
</thead>
<tbody>
<?php if (is_array(@$herederos)):?><?php foreach($herederos as $row): ?>
<tr id="tr_heredero_<?=$row->id_heredero?>" style="font-size:13px">
<td><?=$row->cedula?></td>
<td><?=$row->nombres?>
  <?=$row->apellidos?></td>
<td><?=$row->parentesco?></td>
<td><?=$row->banco?></td>
<td><?=$row->num_cheque?></td>
<td><?=to_moneda($row->monto)?></td>
<td><?=$row->fecha_emision?></td>
<td><?=$row->fecha_entrega?></td>
<td><?=$row->usuario?></td>
<td><?=$row->fecha_creacion?></td>
<?php if ($this->session->userdata('acceso') == 'administrador') :  ?>	
<td>
<table border="0">
<tr>
<td><a class="ui-icon ui-icon-pencil" href="javascript:editar_h(<?=$row->id_heredero?>);"></a></td>
<td><a class="ui-icon ui-icon-trash"  href="javascript:confirmar_elim_h(<?=$row->id_heredero?>);"></a></td>
</tr>
</table>
</td>
<?php endif; ?>
</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>

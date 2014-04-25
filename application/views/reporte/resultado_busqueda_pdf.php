<?php if ($titulo !=''): ?>
<h3 align="center"><?=$titulo?></h3>
<?php endif; ?>
<table border="1" bordercolor="" cellspacing="0">
<thead>
<tr align="center" style="font-weight:bold" bgcolor="#E5E5E5">
<th><?= 'Cédula' ?></th>
<th>Nombres</th>
<th>Apellidos</th>
<th>Ingreso</th>
<th>Egreso</th>
<th>Motivo</th>
<th>Estatus</th>
<th>Origen</th>
<th>Observaciones</th>
</tr>
</thead>
<tbody>
<?php $estiloFila = ''; ?>
<?php foreach($tramites as $row): ?>
<tr align="center" <?= $estiloFila?> >
<td><?= $row->cedula ?></td>
<td><?= $row->nombres ?></td>
<td><?= $row->apellidos ?></td>
<td><?= to_human_date($row->fecha_ingreso)?></td>
<td><?= to_human_date($row->fecha_egreso) ?></td>
<td><?= $row->motivo_egreso?></td>
<td><?= $row->estatus_tramite ?></td>
<td><?= $row->origen ?></td>
<td><?= $row->observaciones ?></td>
</tr>
<?php $estiloFila = ($estiloFila=='') ? 'bgcolor="#EEEEFF"' : ''; ?>
<?php endforeach; ?>
</tbody>
</table>

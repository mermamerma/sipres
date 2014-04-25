<?php if ($titulo !=''): ?>
<h3 align="center"><?=utf8_decode($titulo)?></h3>
<?php endif; ?>
<table border="1" bordercolor="" cellspacing="0">
<thead>
<tr align="center" style="font-weight:bold" bgcolor="#E5E5E5">
<th><?= utf8_decode('Cédula') ?></th>
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
<td><?= utf8_decode($row->nombres) ?></td>
<td><?= utf8_decode($row->apellidos) ?></td>
<td><?= to_human_date($row->fecha_ingreso)?></td>
<td><?= to_human_date($row->fecha_egreso) ?></td>
<td><?= utf8_decode($row->motivo_egreso) ?></td>
<td><?= utf8_decode($row->estatus_tramite) ?></td>
<td><?= $row->origen ?></td>
<td><?= utf8_decode($row->observaciones) ?></td>
</tr>
<?php $estiloFila = ($estiloFila=='') ? 'bgcolor="#EEEEFF"' : ''; ?>
<?php endforeach; ?>
</tbody>
</table>

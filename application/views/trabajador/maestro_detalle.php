<?PHP
$ci = &get_instance();
$ci->load->model("tramite_model");

$con_foto = 'http://rrhh.mppre.gob.ve/fotos/'.$cedula.'.jpg';
$sin_foto = base_url().'public/images/sin_foto.png';
$fp = curl_init($con_foto);
$ret = curl_setopt($fp, CURLOPT_RETURNTRANSFER, 1);
$ret = curl_setopt($fp, CURLOPT_TIMEOUT, 30);
$ret = curl_exec($fp);
$info = curl_getinfo($fp, CURLINFO_HTTP_CODE);
curl_close($fp);
$url = ($info == 404)? $sin_foto : $con_foto ;
?>
<table width="827" border="0" id="tabla_datos_trabajador" style="display:block">
          
          <tr>
            <td width="389" height="55">
				<li>
				<label class="description" for="element_2">Nombres</label>
				<?= form_input('nombres',$nombres,'class="element text_gris medium-form" readonly="" ')?>
			</li>			</td>
            <td width="305"><label class="description" for="element_2">Apellidos</label>
              <?= form_input('apellidos',$apellidos,'class="element text_gris medium-form" readonly=""')?></td>
            <td width="119" rowspan="2" align="center">
				<img class="fotico" width="71" height="100" src="<?=$url?>">
				</td>
          </tr>
          <tr>
            <td>
				<li>
				<label class="description" for="element_2">Sexo</label>
				<?= form_input('sexo',$sexo,'class="element text_gris medium-form" readonly="" ')?>
				</li>			</td>
            <td><label class="description" for="element_2">Ubicación en Base de Datos</label>
              <?= form_input('fecha_nacimiento',$origen,'class="element text_gris medium-form" readonly="" ')?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3">
			<div>
			<h3>Movimientos en el Ministerio <img id="img_accion" class="icon_accion_2" src="<?=base_url().'public/images/iconos/arrow_in_out.png'?>" /></h3>
			<table width="821" cellspacing="1" id="datatable_movimientos">
			<thead>
			<tr>
				<th>Ingreso</th>
				<th>Egreso</th>
				<th>Adscripción</th>
				<th>Dependencia</th>
				<th>Cargo</th>
				<th>Tipo de Personal </th>
				<th>Estatus</th>
				<th>Base de Datos</th>
				<th>ID</th>
				<th>Acciones</th>
			  </tr>
			</thead>
			<tbody>
			<?php if (is_array(@$mov_sigefirrhh)):?>
				<?php foreach($mov_sigefirrhh as $row): ?>
				<?php $comenzado_1 = $ci->tramite_model->comenzado($row->id_trabajador,$row->id_empleado) ;?>
			  	<tr>
				<td><?=$row->fecha_ingreso?></td>
				<td><?=$row->fecha_egreso?></td>
				<td><?=$row->adscripcion?></td>
				<td><?=$row->dependencia?></td>
				<td><?=$row->cargo?></td>
				<td><?=$row->tipo_personal?></td>
				<td><?=$row->estatus?></td>
				<td><?=$row->origen?></td>
				<td align="center">
				<?php if ($row->id_trabajador > 0) 
					echo  $row->id_trabajador ;
				else
					echo  $row->id_empleado ;
				?>
				</td>
				<td align="center">
					<?php if (($row->estatus != 'ACTIVO' AND $row->estatus != 'SUSPENDIDO') AND (!$comenzado_1)):  ?>
						<a href="<?= base_url()?>tramite/formulario/0/<?=$row->cedula?>/<?=$row->id_trabajador?>/<?=$row->id_empleado?>">
						<img class="fotico" alt="Iniciar Trámite" title="Iniciar Trámite" height="15" src="<?= base_url()?>public/images/iconos/iniciar.png"></a>
					<?php endif; ?>
					<?php if ($comenzado_1):  ?>
						<img class="" alt="Trámite Registrado" title="Trámite Registrado" src="<?= base_url()?>public/images/iconos/tramite_check.png"></a>
					<?php endif; ?>
					<a href="<?= base_url()?>trabajador/generar_ficha/<?=$row->cedula?>/<?=$row->id_trabajador?>/<?=$row->id_empleado?>" target="_blank">
					<img class="fotico" alt="Generar Ficha" title="Generar Ficha" height="15" src="<?= base_url()?>public/images/iconos/crear_ficha.png" /></a>
				</td>
			  </tr>
			<?php endforeach; ?>
			<?php endif; ?>
			<?php if (is_array($mov_rrhh)):?>				
				<?php foreach($mov_rrhh as $row): ?>
				<?php $comenzado_2 = $ci->tramite_model->comenzado($row->id_trabajador,$row->id_empleado) ;?>
			  	<tr>
				<td><?=$row->fecha_ingreso?></td>
				<td><?=$row->fecha_egreso?></td>
				<td><?=$row->adscripcion?></td>
				<td><?=$row->dependencia?></td>
				<td><?=$row->cargo?></td>
				<td><?=$row->tipo_personal?></td>
				<td><?=$row->estatus?></td>
				<td><?=$row->origen?></td>
				<td align="center">
				<?php
				 if ($row->id_trabajador > 0) 
					echo  $row->id_trabajador ;
				else
					echo  $row->id_empleado ;			
				?>
				</td>
				<td align="center">
					<?php if (!$comenzado_2):  ?>
						<a href="<?= base_url()?>tramite/formulario/0/<?=$row->cedula?>/<?=$row->id_trabajador?>/<?=$row->id_empleado?>">
						<img class="fotico" alt="Iniciar Trámite" title="Iniciar Trámite" height="15" src="<?= base_url()?>public/images/iconos/iniciar.png"></a>
					<?php endif; ?>
					<?php if ($comenzado_2):  ?>
						<img class="" alt="Trámite Registrado" title="Trámite Registrado" src="<?= base_url()?>public/images/iconos/tramite_check.png">
					<?php endif; ?>
					<a href="<?= base_url()?>trabajador/generar_ficha/<?=$row->cedula?>/<?=$row->id_trabajador?>/<?=$row->id_empleado?>" target="_blank">
					<img class="fotico" alt="Generar Ficha" title="Generar Ficha" height="15" src="<?= base_url()?>public/images/iconos/crear_ficha.png" />
					</a>
			  </tr>
			<?php endforeach; ?>
			<?php endif; ?>
			</tbody>
			</table>
			</div>			</td>
          </tr>
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3">
			<div>
			<h3>Trámites Registrados <img id="img_accion" class="icon_accion_2" src="<?=base_url().'public/images/iconos/tramite_go.png'?>" /></h3>
			<table width="821" cellspacing="1" id="datatable_tramites">
			<thead>
			<tr>
				<th>Iniciado</th>
				<th>Estatus</th>
				<th>Registrado por </th>
				<th>Analista Asignado</th>
				<th>Base de Datos</th>
				<th>ID</th>
				<th>Acciones</th>
			  </tr>
			</thead>
			<tbody>
			<?php if (is_array(@$tram_reg)):?>
				<?php foreach($tram_reg as $row): ?>
			  	<tr>
				<td><?=$row->fecha_creacion?></td>
				<td><?=$row->estatus?></td>
				<td><?=$row->usuario?></td>
				<td><?=$row->usuario_asignado?></td>
				<td><?=$row->origen?></td>
				<td align="center">
				<?php if ($row->id_trabajador > 0) 
					echo  $row->id_trabajador ;
				else
					echo  $row->id_empleado ;
				?>				</td>
				<td align="center">
					<a href="<?= base_url()?>tramite/formulario/<?=$row->id_tramite?>/<?=$row->cedula?>/<?=$row->id_trabajador?>/<?=$row->id_empleado?>">
					<img class="" alt="Ver Trámite" title="Ver Trámite" height="15" src="<?= base_url()?>public/images/iconos/tramite_detalle.png">					</a>
					<a href="<?= base_url()?>tramite/informe/<?=$row->id_tramite?>/<?=$row->cedula?>/<?=$row->id_trabajador?>/<?=$row->id_empleado?>" target="_blank">
					<img class="" alt="Generar Informe" title="Generar Informe" height="15" src="<?= base_url()?>public/images/iconos/printer.png">					</a>				</td>
			  </tr>
			<?php endforeach; ?>
			<?php endif; ?>			
			</tbody>
			</table>
			</div>
			</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
         </tr>
</table>
<script>
$(function() {
	var oTable = $('#datatable_movimientos').dataTable({
		"bAutoWidth":false,
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"iDisplayLength": 15,
		"aaSorting": [[ 7, "desc" ]],
		"bScrollCollapse": true
	
	});
}); 

$(function() {
	var oTable = $('#datatable_tramites').dataTable({
		"bAutoWidth":false,
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"iDisplayLength": 15,
		"aaSorting": [[ 7, "desc" ]],
		"bScrollCollapse": true
	
	});
});

</script>

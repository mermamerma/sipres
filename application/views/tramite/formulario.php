<style>
.ui-tabs .ui-tabs-nav li { list-style: none; float: left; position: relative; top: 1px; margin: 0 .2em 1px 0; border-bottom: 0 !important; padding: 0; white-space: nowrap; }
.ui-tabs .ui-tabs-nav li a { float: left; padding: .5em 1em; text-decoration: none; }
.ui-tabs .ui-tabs-nav li a img { float: left; margin-right: 1px}
.ui-tabs .ui-tabs-nav li.ui-tabs-selected { margin-bottom: 0; padding-bottom: 1px; }
.ui-tabs .ui-tabs-nav li.ui-tabs-selected a, .ui-tabs .ui-tabs-nav li.ui-state-disabled a, .ui-tabs .ui-tabs-nav li.ui-state-processing a { cursor: text; }
</style>
<div id="resultado-ajax">
</div>
<div id="dialog">
</div>
<div id="dialog-confirm" title="Atención">
</div>
<div id="form_container">
<?php
$cedula =  $datos->cedula ;
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
<form id="form1" class="appnitro" method="post" action="" >
  <div class="form_description">
    <h2><?= $accion ?><img id="img_accion" class="icon_accion" src="<?=base_url().'public/images/iconos/'.$icon?>" /></h2>
    <p>Formulario</p>
	<?=form_hidden('id_tramite',$id_tramite); ?>
	<?=form_hidden('id_cedula',$cedula); ?>
	<?=form_hidden('id_trabajador',$id_trabajador); ?>
	<?=form_hidden('id_empleado',$id_empleado); ?>
    </div>
    <div id="tabs">
		<ul>
			<li><a href="#tabs-1"><img class="ui-icon ui-icon-person"/>Trabajador</a></li>
			<li><a href="#tabs-2"><img class="ui-icon ui-icon-script"/>Trámite</a></li>
			<li><a href="#tabs-3"><img class="ui-icon ui-icon-transfer-e-w"/>Movimientos</a></li>	
			<li><a href="#tabs-4"><img class="ui-icon ui-icon-tag"/>Pago</a></li>	
			<li><a href="#tabs-5"><img class="ui-icon ui-icon-locked"/>Cierre</a></li>
			<?php if ($id_tramite > 0):  ?>
				<li><a href="#tabs-6"><img class="ui-icon ui-icon-heart"/>Herederos</a></li>
				<li><a href="#tabs-7"><img class="ui-icon ui-icon-comment"/>Histórico</a></li>
			<?php endif; ?>			
		</ul>
		<div id="tabs-1">
			<table width="826" border="0" id="tabla_datos_trabajador" style="display:block">
          <tr>
            <td>
				<li>
				<label class="description" for="element_2">Cédula del Trabajador</label>
				<?= form_input('cedula',$datos->cedula,'class="element text_gris medium-form" readonly=""')?>
				</li>			</td>
            <td align="center">
				<img class="fotico" height="100" src="<?=$url?>">
			</td>
          </tr>
          <tr>
            <td width="410">
				<li>
				<label class="description" for="element_2">Nombres</label>
				<?= form_input('nombres',$datos->nombres,'class="element text_gris medium-form" readonly="" ')?>
				</li>			</td>
            <td width="406">
				<label class="description" for="element_2">Apellidos</label>
				<?= form_input('apellidos',$datos->apellidos,'class="element text_gris medium-form" readonly=""')?>			</td>
          </tr>
		  <tr>
            <td width="410">
				<li>
				<label class="description" for="element_2">Tipo Personal</label>
				<?= form_input('tipo_personal',$datos->tipo_personal,'class="element text_gris medium-form" readonly=""')?>
				</li>			</td>
            <td width="406">
				<label class="description" for="element_2">Cargo</label>
				<?= form_input('cargo',$datos->cargo,'class="element text_gris medium-form" readonly=""')?>			</td>
          </tr>
          <tr>
            <td>
				<li>
				<label class="description" for="element_2">Estatus</label>
				<?= form_input('estatus',$datos->estatus,'class="element text_gris medium-form" readonly=""')?>
				</li>			</td>
            <td>
				<label class="description" for="element_2">Correo</label>
				<?= form_input('correo',$datos->correo,'class="element text_gris medium-form" readonly=""')?>			</td>
          </tr>
          
          <tr>
            <td>
				<li>
				<label class="description" for="element_2">Fecha de Ingreso en el Sistema</label>
				<?= form_input('fecha_ingreso_sistema',($datos->fecha_ingreso),'class="element text_gris medium-form" readonly=""')?>	
				<a><img onclick="javascript:copiar_fecha_ingreso()" src="<?= base_url()?>public/images/good_bit.png" alt="Copiar Fecha de Ingreo"  title="Copiar Fecha de Ingreo"></a>
				</li>
			</td>
            <td>
				<label class="description" for="element_2"> Fecha de Egreso en el Sistema</label>
                <?= form_input('fecha_egreso_sistema',($datos->fecha_egreso),'class="element text_gris medium-form"')?>
				<a><img onclick="javascript:copiar_fecha_egreso()" src="<?= base_url()?>public/images/good_bit.png" alt="Copiar Fecha de Egreo"  title="Copiar Fecha de Egreo"></a>
            	</td>
          </tr>
          <tr>
            <td>
				<li>
				<label class="description" for="element_2">Fecha Real de Ingreso </label>
				<?= form_date_picker('fecha_ingreso','','class="element text medium-form"');?>
				</li>
			</td>
            <td><label class="description" for="element_2">Fecha Real de Egreso </label>
              <?= form_date_picker('fecha_egreso','','class="element text medium-form"');?>
			  </td>
          </tr>
          <tr>
            <td>
				<li>
				<label class="description" for="element_2">Teléfono Residencial</label>
				<?= form_input('telf_residencial','','class="element text medium-form"')?>
				</li>			</td>
            <td>
				<label class="description" for="element_2">Teléfono Celular
                <?= form_input('telf_celular','','class="element text medium-form"')?>
            	</label>			</td>
          </tr>
          <tr>
            <td>
				<li>
				<label class="description" for="element_2">Correo Alternativo</label>
				<?= form_input('correo_alt','','class="element text medium-form"')?>
				</li>
			</td>
            <td>
			<label class="description" for="element_2">Origen
                <?= form_input('origen',$datos->origen,'class="element text_gris medium-form" readonly=""')?>
           	</label>			</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
		</div>           
		<div id="tabs-2">
			<table width="826" border="0" id="tabla_datos_trabajador" style="display:block">          
          <tr id="msj_error_estatus" style="display:none">
            <td colspan="2">
				<div style="padding: 0 .7em;" class="ui-state-error ui-corner-all">
				<p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span>
				<strong>Atención:</strong> Debe seleccionar un nuevo estatus para poder realizar el control y seguimiento del trámite</p>
			</div>	
			</td>
            </tr>
          <tr>
            <td>
				<li>
				<label class="description" for="element_2">Estatus del Trámite <span class="required">(*)</span></label>
				<?php 
				if ($id_tramite > 0)  
					echo form_dropdown_custom('id_estatus_tramite',SQL_MOD_TRAM);
				else
					echo form_dropdown_custom('id_estatus_tramite',SQL_INI_TRAM);
				?>						
				</li>			</td>
            <td>
				<?php if ($id_tramite > 0):  ?>
				<label class="description" for="element_2">Estatus Actual del Trámite: </label>
				<b><div id="div_estatus_tramite" style="font:bold; color:#000000; background-color:#FFFF00"></div></b>
				<?php endif; ?>			</td>
          </tr>
           <tr>
            <td>
				<li>
				<label class="description" for="element_2">Motivo del Egreso <span class="required">(*)</span></label>
				<?= form_dropdown_db('id_motivo_egreso', 'motivo_egreso');?>
				</li>
			</td>
            <td>
				<label class="description" for="element_2">Analista Asignado <span class="required">(*)</span></label>
				<?= form_dropdown_custom('id_usuario_asignado',SQL_ANALISTAS_ACTIVO);?>			</td>
          </tr>     
          <tr>
            <td width="410">
				<li>
				<label class="description" for="element_2">Fecha de Inicio</label>
				<?php $fecha_inicio = ($id_tramite == 0)? date ('d-m-Y'): ''; ?>
				<?= form_input('fecha_inicio',$fecha_inicio,'class="element text_gris medium-form"')?>
				</li>			</td>
            <td width="406">
				<label class="description" for="element_2">Fecha de Asignación <span class="required">(*)</span></label>				
				<?= form_date_picker('fecha_asignacion','','class="element text medium-form"');?>			</td>
          </tr>          
          <tr>
            <td>
				<li>
				<label class="description" for="element_2">Número de la Declaración Jurada de Patrimonio</label>
				<?= form_input('num_djp','','class="element text medium-form"')?>
				</li>			</td>
            <td>
				<label class="description" for="element_2">Fecha de la Declaración Jurada de Patrimonio</label>				
				<?= form_date_picker('fecha_djp','','class="element text medium-form"');?>			</td>
          </tr>              
          <tr>
            <td>
				<li>
				<label class="description" for="element_2">Monto de Cálculo Viejo Régimen</label>
				<?= form_input('monto_viejo_regimen','','class="element text medium-form" onkeypress="enterDecimal1(event)" autocomplete="OFF"')?>
				</li>			</td>
            <td>
				<label class="description" for="element_2">Monto de Calculo Ley Mayo 2012</label>
				<?= form_input('monto_ley_mayo','','class="element text medium-form" onkeypress="enterDecimal1(event)" autocomplete="OFF"')?>			</td>
		</tr>          
          <tr>
            <td>
				<li>
				<label class="description" for="element_2">Monto de Prestaciones Antiguedad Fideicomiso</label>
				<?= form_input('monto_prest_fide','','class="element text medium-form" onkeypress="enterDecimal1(event)" autocomplete="OFF"')?>
				</li>			</td>
            <td>
				<label class="description" for="element_2">Monto Total de Prestaciones</label>
				<?= form_input('monto_total_prest','','class="element text medium-form" onkeypress="enterDecimal1(event)" autocomplete="OFF"')?>			</td>
          </tr>
          <tr>
            <td colspan="2">
				<li>
				<label class="description" for="element_2">Observaciones</label>
                <?=form_textarea('observaciones','','class="element textarea medium" style="width:780px"')?>
                </li>			</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
		</div>
		<div id="tabs-3">
			<fieldset id="fieldset_mre">
			<legend>Ministerio de Relaciones Exteriores</legend>
			<table width="793" border="0">          
    		<tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="394">
				<li>
				<label class="description" for="element_2">Fecha Enviado a la Firma del Coordinador</label>
				<?= form_date_picker('fecha_firma_coord','','class="element text medium-form"');?>
				</li>
			</td>
            <td width="389">
				<label class="description" for="element_2">Fecha Enviado a la Firma del Director </label>
				<?= form_date_picker('fecha_firma_dir','','class="element text medium-form"');?>
			</td>
          </tr>          
            <td width="394">
				<li>
				<label class="description" for="element_2">Fecha Enviado a la Firma del Director General</label>
				<?= form_date_picker('fecha_firma_dir_gral','','class="element text medium-form"');?>
				</li>
			</td>
            <td width="389"><label class="description" for="element_2">Fecha Enviado a Administración</label>
              <?= form_date_picker('fecha_env_admin','','class="element text medium-form"');?>
			 </td>			 
          <tr>
            <td>
				<li>
				<label class="description" for="element_2">N° de Memorándum a Administración</label>
				<?= form_input('num_memo_admin','','class="element text medium-form"')?>
				</li>
			</td>
            <td>
				<label class="description" for="element_2">Fecha Enviado a Acreencia</label>
				 <?= form_date_picker('fecha_env_acreencia','','class="element text medium-form"');?>
			</td>
          </tr>          
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
		    </table>
			</fieldset>
			<fieldset id="fieldset_mfin">
				<legend>Ministerio de Finanzas</legend>
				<table width="793" border="0">          
				<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  	</tr>
			  	<tr>
				<td width="394">
					<li>
					<label class="description" for="element_2">N° de Memorándum al Ministerio de Finanzas</label>
					<?= form_input('nun_memo_env_fnza','','class="element text medium-form"')?>
					</li>	
				</td>
				<td width="389">
					<label class="description" for="element_2">Fecha Enviado al Ministerio de Finanzas </label>
					<?= form_date_picker('fecha_env_fnza_pri_vez','','class="element text medium-form"');?>
				</td>
			  	</tr>          
				<td width="394">
					<li>
					<label class="description" for="element_2">Fecha de Devolución Ministerio de Finanzas</label>
					<?= form_date_picker('fecha_devol_fnza','','class="element text medium-form"');?>
				  </li>
				</td>
				<td width="389">
					<label class="description" for="element_2">N° de Memorándum al Ministerio de Finanzas 2&ordm; Vez</label>
					<?= form_input('num_memo_sgd_vez_fnza','','class="element text medium-form"')?>
				</td>         
			  	<tr>
				<td>
					<li>
					<label class="description" for="element_2">Fecha Enviado al Ministerio de Finanzas  2&ordm; Vez</label>
					<?= form_date_picker('fecha_env_fnza_sgd_vez','','class="element text medium-form"');?>
					</li>
				</td>
				<td>&nbsp;</td>
			  	</tr>          
			 	 <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			 	</tr>
				</table>
		  	</fieldset>
			</fieldset>
			<fieldset id="fieldset_cierre">
			<legend>Cierre</legend>
			<table width="793" border="0">          
          	<tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="394">
				<li>					
					<label class="description" for="element_2">Número de Memorándum Enviado a Presupuesto</label>
    	         	<?= form_input('num_memo_env_psto','','class="element text medium-form"')?>			
				</li>	
			</td>
            <td width="389">
				<label class="description" for="element_2">Fecha de Envíado a Presupuesto</label>
				<?= form_date_picker('fecha_env_psto','','class="element text medium-form"');?>	
			</td>
          </tr>          
            <td width="394">
			  <li>			  
				<label class="description" for="element_2">Disponibilidad por Bs.</label>
             	<?= form_input('disp_bs','','class="element text medium-form" onkeypress="enterDecimal1(event)" autocomplete="OFF"')?>			
			  </li>
			</td>
            <td width="389">								
				<label class="description" for="element_2">N° de Memorándum sin Disponibilidad</label>
				<?= form_input('num_memo_sin_disp','','class="element text medium-form"')?>				
			</td>         
          <tr>
            <td>
			<li>				
				<label class="description" for="element_2">Fecha Devolución sin Disponibilidad</label>
				<?= form_date_picker('fecha_devol_sin_disp','','class="element text medium-form"');?>			
			</li>
			</td>
            <td>								
				<label class="description" for="element_2">Fecha de Enviado al Expediente</label>
				<?= form_date_picker('fecha_env_exp','','class="element text medium-form"');?>
			</td>
          </tr>          
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
		   	 </table>
		  	</fieldset>
		</div>
	  	<div id="tabs-4">
			<table width="792" border="0">
 			<tr>
		    <td>
				<li>
				<label class="description" for="element_2">Tipo de Pago</label>
              	<?= form_dropdown_db('id_tipo_pago', 'tipo_pago','onchange=javascript:cambio_tipo_pago();');?>
				</li>
			</td>
		    </tr>
				<tr>
		    <td>&nbsp;</td>
		    </tr>
			</table>
			<fieldset id="fieldset_cheque" style="display:none">
			<legend>Datos del Cheque</legend>
				  <table width="793" border="0">          
					
				  <tr>
					<td width="394">
						<li>				
						<label class="description" for="element_2">Fecha Remisión del Cheque</label>
						<?= form_date_picker('fecha_remision_chq','','class="element text medium-form"');?>			
						</li>			</td>
					<td width="389">
						<label class="description" for="element_2">N° de Listado</label>
							<?= form_input('num_listado','','class="element text medium-form"')?>			</td>
				  </tr>          
					<td width="394">
						<li>
						<label class="description" for="element_2">Fecha de Listado </label>
						<?= form_date_picker('fecha_listado','','class="element text medium-form"');?>
					  </li>			</td>
					<td width="389"><label class="description" for="element_2">Banco Emisor</label>
					  <?= form_dropdown_db('id_banco_cheque', 'banco');?></td>         
					<tr>
					  <td>
						<li>
						  <label class="description" for="element_2">N° de Cheque</label>
						  <?= form_input('num_cheque','','class="element text medium-form"')?>
					  </li>			  </td>
					  <td>
					  	<label class="description" for="element_2">Monto en Bolívares del Cheque</label>
						<?= form_input('monto_cheque','','class="element text medium-form"  onkeypress="enterDecimal1(event)" autocomplete="OFF"')?>
					</td>
					</tr>
					<tr>
					<td>
						<li>
						  <label class="description" for="element_2">Fecha de Entrega al Beneficiario</label>
						  <?= form_date_picker('fecha_entrg_benefi','','class="element text medium-form"');?>
						</li>
					</td>
					<td>&nbsp;</td>
				  </tr>          
				  <tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				  </tr>
				</table>
		</fieldset>
		<fieldset id="fieldset_transferencia" style="display:none">
			<legend>Datos de la Transferencia</legend>
				<table width="793" border="0">          
					
				  <tr>
					<td width="394">
						<li>				
						<label class="description" for="element_2">Banco Receptor de la Transferencia</label>
					  	<?= form_dropdown_db('id_banco_transfe', 'banco');?>
						</li>						</td>
					<td width="389">
						<label class="description" for="element_2">N° de Cuenta para la Transferencia</label>
						<?= form_input('num_cta_transfe','','class="element text medium-form"')?>					</td>
				  </tr>          
					<td width="394">
						<li>						
					  	<label class="description" for="element_2">Monto en Bolívares de la Transferencia</label>
						<?= form_input('monto_transfe','','class="element text medium-form"  onkeypress="enterDecimal1(event)" autocomplete="OFF"')?>					
					    </li>					</td>
					<td width="389">						
						  <label class="description" for="element_2">Fecha de la Transferencia</label>
						  <?= form_date_picker('fecha_transfe','','class="element text medium-form"');?>					  </td>         
					<tr>
					  <td>
						<li>
						  <label class="description" for="element_2">N° de Confirmación de Transferencia </label>
						  <?= form_input('num_confirm_transfe','','class="element text medium-form"')?>
					  </li>					  </td>
					  <td>&nbsp;</td>
					</tr>
					          
				  <tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				  </tr>
				</table>
		  </fieldset>
		</div>
		<div id="tabs-5">
		<table width="793" border="0">                    	
          <tr>
            <td width="394">
				<li>								
				<label class="description" for="element_2">N° de Memorándum Auto Cierre</label>
             	<?= form_input('num_memo_cierre','','class="element text medium-form"')?>					
				</li>
			</td>
            <td width="389">
				<label class="description" for="element_2">Fecha del Memorándum Auto Cierre</label>
				<?= form_date_picker('fecha_memo_cierre','','class="element text medium-form"');?>
			</td>
          </tr>          
            <td width="394">
			  <li>
				<label class="description" for="element_2">VVND Y BVF</label>
				<?= form_input('vvnd_bvf','','class="element text medium-form" onkeypress="enterDecimal1(event)" autocomplete="OFF"')?>	
			  </li>
			  </td>
            <td width="389">
				<label class="description" for="element_2">Fecha de Pago de las Vacaciones</label>
				<?= form_date_picker('fecha_pago_vaca','','class="element text medium-form"');?>
			</td>         
          <tr>
            <td>
				<li>								
					<label class="description" for="element_2">Tipo de Pago de las Vacaciones</label>
     	         	<?= form_dropdown_db('id_tipo_pago_vaca', 'tipo_pago_vaca');?>					
				</li>
			</td>
            <td>&nbsp;</td>
          </tr>          
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
		</table>
		</div>
		<?php if ($id_tramite > 0):  ?>			
		<div id="tabs-6">
		<table width="793" border="0">
          <tr>
            <td><h3> Personas Registradas</h3></td>
          </tr>
          <tr>
            <td>
			<div id="wraper_herederos">
				<?= $tabla_herederos ?>
			</div>
			 <p><div id="create-user" class="boton">Agregar Heredero</div></p>
			</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>
				<li>
				<label class="description" for="element_2">Observaciones de los Herederos</label>
                <?=form_textarea('observ_herederos','','class="element textarea medium" style="width:780px"')?>
                </li>			</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
		</table>
		</div>
		<div id="tabs-7">
		<table width="793" border="0">
          <tr>
            <td><h3> Movimientos</h3></td>
          </tr>
          <tr>
            <td>
			<table width="821" cellspacing="1" id="datatable_historico">
			<thead>
			<tr>
				<th>ID</th>
				<th>Estatus</th>
				<th>Usuario</th>
				<th>Fecha</th>
				</tr>
			</thead>
			<tbody>
			<?php if (is_array(@$historico)):?>
				<?php foreach($historico as $row): ?>
			  	<tr>
				<td><?=$row->id?></td>
				<td><?=$row->estatus?></td>
				<td><?=$row->usuario?></td>
				<td><?=$row->fecha?></td>
				</tr>
			<?php endforeach; ?>
			<?php endif; ?>			
			</tbody>
			</table>
			</td>
          </tr>
		</table>
		</div>
		<?php endif; ?>	
	</div>
  </form>
  
  	<div id="dialog-form" title="Formulario de Heredero">
	<p></p>
	<form name="form_h" id="form_h">
	<input type="hidden" id="id_heredero" name="id_heredero" />
	<input type="hidden" id="id_tramite_h" name="id_tramite_h" />
	<fieldset>
		<label class="description">Cédula</label>
		<input type="text" name="cedula_h" id="cedula_h" class="element textarea medium">
		<label class="description" >Nombres</label>
		<input type="text" name="nombres_h" id="nombres_h" class="element textarea medium">
		<label class="description">Aapellidos</label>
		<input type="text" name="apellidos_h" id="apellidos_h" class="element textarea medium">
		<label class="description" >Parentesco</label>
		<?= form_dropdown_db('id_parentesco', 'parentesco');?>
		<label class="description" for="banco_h">Banco</label>
		<?= form_dropdown_db('id_banco_h', 'banco');?>
		<label class="description">Cheque N°</label>
		<input type="text" name="num_cheque_h" id="num_cheque_h" class="element textarea medium">
		<label class="description" for="monto_cheque_h">Monto</label>
		<input type="text" name="monto_cheque_h" id="monto_cheque_h" class="element textarea medium" onkeypress="enterDecimal1(event)" autocomplete="OFF">
		<label class="description">Fecha de Emisión del Cheque</label>
		<?= form_date_picker('fecha_emision_h','','class="element text medium-form"');?>
		<label class="description">Fecha de Entrega del Cheque</label>
		<?= form_date_picker('fecha_entrega_h','','class="element text medium-form"');?>
	</fieldset>
	</form>
	</div>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	  
  	<div id="boton_aceptar" class="boton" onclick="javacript:enviar();">Aceptar</div>  
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<div id="boton_cancelar" class="boton" onclick="javacript:$(location).attr('href','<?=base_url()?>');">Cancelar</div>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
  <?php if ($id_tramite > 0):  ?>	
  	<div id="boton_imprimir" class="boton" onclick="javacript:window.open('<?=base_url()?>tramite/informe/<?=$id_tramite?>/<?=$cedula?>/<?=$id_trabajador?>/<?=$id_empleado?>', '_blank')">Imprimir</div>
  <?php endif; ?>	
  <br /><br />
  </div>

<script>

function reset_pagos(){
	// Cheque
	$('#fecha_remision_chq').val('');
	$('#num_listado').val('');
	$('#fecha_listado').val('');
	$('#id_banco_cheque').val('');
	$('#num_cheque').val('');
	$('#monto_cheque').val('');
	$('#fecha_entrg_benefi').val('');
	// Transferencia
	$('#id_banco_transfe').val('');
	$('#num_cta_transfe').val('');
	$('#monto_transfe').val('');
	$('#fecha_transfe').val('');
	$('#num_confirm_transfe').val('');
	
}

function cambio_tipo_pago() {
	id_tipo_pago = $('#id_tipo_pago').val();
	tipo_pago = $('#id_tipo_pago option:selected').text();
	r = confirm('Al cambiar el tipo de pago, se borarran los datos del anterior método de pago, \n ¿Esta seguro de proceder? ') ;
	if (r) {
		if (id_tipo_pago == 1) { // Cheque
			$('#fieldset_cheque').css("display","block");
			$('#fieldset_transferencia').css("display","none");
			reset_pagos();		
		}
		else if (id_tipo_pago == 2){ // Transferencia
			$('#fieldset_cheque').css("display","none");
			$('#fieldset_transferencia').css("display","block");
			reset_pagos();
		}
	}
	else {
		if(id_tipo_pago == 1)
			$('#id_tipo_pago').val(2);
		elseif(id_tipo_pago == 2)
			$('#id_tipo_pago').val(1);
	}
}

function copiar_fecha_ingreso() {
	$('#fecha_ingreso').val($('#fecha_ingreso_sistema').val());
}

function copiar_fecha_egreso() {
	$('#fecha_egreso').val($('#fecha_egreso_sistema').val());
}

function deshabilitar() {
	$(document).ready(function(){
		$('#form1').find('input, textarea, button, select').attr('readonly','true');
		$('#form1').find('input, textarea, button, select').addClass('text_gris');
		$('#observaciones').css( "background-color","#DDDDDD");
		$('#observ_herederos').css( "background-color","#DDDDDD");
		$('#boton_aceptar').css("display","none");
		$('#create-user').css("display","none");
	});
}

$("#boton_aceptar").button({icons: {primary: "ui-icon-disk"},  text: true	});
$("#boton_cancelar").button({icons: {primary: "ui-icon-cancel"},text: true	});
$("#boton_imprimir").button({icons: {primary: "ui-icon-print"},text: true	});
$("#create-user").button({icons: {primary: "ui-icon-circle-plus"},text: true	});

// Parametros del Dialog para El Formulario de Heredero
$(function() {

	$( "#dialog-form" ).dialog({
	autoOpen: false,
	height: 600,
	width: 500,
	modal: true,
	buttons: {
		"Aceptar": function() {			
			valido = $('#form_h').valid() ;
			validar_heredero();
			
		},
		"Cancelar": function() {
			$( this ).dialog( "close" );
			reset_form_h();
		}
		},
		close: function() {
			reset_form_h();
		//allFields.val( "" ).removeClass( "ui-state-error" );
		}
	});
	$( "#create-user" ).button().click(function() {
		$('#id_tramite_h').val($('#id_tramite').val());
		$( "#dialog-form" ).dialog( "open" );
	});
});

function reset_form_h(){
	//$('#id_heredero').val('');
	var form = $( "#form_h" );
	var validator = form.validate();
	validator.resetForm();
	$('#form_h').reset();
}

function eliminar_heredero(id) {
	$.ajax({
		url:'<?=base_url()?>heredero/eliminar/'+id,
		type:'POST',
		success:function(data){
			$('#resultado-ajax').html(data);
			//$('#resultado-ajax').show();					
		}
	});
}

function editar_h(id_heredero){
	$('#id_heredero').val(id_heredero);
	$('#id_tramite_h').val($('#id_tramite').val());
	$( "#dialog-form" ).dialog( "open" );
	$.ajax({
		url:'<?=base_url()?>heredero/editar/'+id_heredero,
		type:'GET',		
		success:function(data){										
			$('#resultado-ajax').html(data);			
		}
	});
}

function validar_heredero() {
	if($('#form_h').valid()){			
		//$('#resultado-ajax').hide();				
		$.ajax({
			url:'<?=base_url()?>heredero/guardar',
			type:'post',
			data:$('#form_h').serialize(),
			success:function(data){
				reset_form_h();
				jQuery('#dialog-form').dialog('close');
				$('#wraper_herederos').html('');
				$('#resultado-ajax').html(data);
				//$('#resultado-ajax').show();					
			}
		});
	}
	else { 
		$("#tabs").tabs("select", "tabs-2");
		
	}
}

function confirmar_elim_h(id) {
	 $(function() {
	$( "#dialog-confirm" ).dialog({
	resizable: false,
	height:150,
	modal: true,
	buttons: {
	"Aceptar": function() {
	$( this ).dialog( "close" );
		eliminar_heredero(id);
	},
	"Cancelar": function() {
	$( this ).dialog( "close" );
	}
	}
	});
		
		$('#dialog-confirm').html("<p><span class='ui-icon ui-icon-alert' style='float:left; margin:0 7px 20px 0;'></span>¿Esta seguro de Proceder con la acción?</p>");		
	});
}

// DataTable Histórico
$(function() {
	var oTable1 = $('#datatable_historico').dataTable({
		"aaSorting": [[ 0, "desc" ]],
		"bAutoWidth":false,
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"iDisplayLength": 15,
		"bScrollCollapse": true	
	});
}); 

// Mascaras y ejecución una vez Cargada la página
//$(document).ready(function(){
window.onload = function() { 
	tipo_personal = $('#tipo_personal').val();
	id_tipo_pago = $('#id_tipo_pago').val();			
	$(".boton").button(); 	
	// jQuery("#fecha_asignacion").mask("99-99-9999");	
	jQuery("#telf_celular").mask("9999-9999999") ;
	jQuery("#telf_residencial").mask("9999-9999999") ;
	jQuery("#num_cta_transfe").mask("9999-9999-99-9999999999") ;
	
	if (tipo_personal=='CONTRATADO') {	$('#fieldset_mfin').css({'display':'none'}); }
	
	if (id_tipo_pago == 1) { // PAGO CHEQUE
		$('#fieldset_cheque').css("display","block");
	}
	if (id_tipo_pago == 2) { // PAGO TRANSFERENCIA
		$('#fieldset_transferencia').css("display","block");
	}
	
}	
//});

// Reglas del Formulario Trámite
$(function() {
	$( "#tabs" ).tabs();
	$('#form1').validate({
		rules:{
			// REGLAS TRABAJADOR 
			correo_alt : {  email: true }, fecha_ingreso : { dateDE: true  }, fecha_egreso : { dateDE: true  },
			// REGLAS TRAMITE 
			id_estatus_tramite : { required:true }, fecha_asignacion : { required:true, dateDE: true  },			
			fecha_djp : { dateDE: true  },
			id_motivo_egreso : { required:true }, id_usuario_asignado : { required:true },
			// Movimiento MRE
			fecha_firma_coord : { dateDE: true  }, fecha_firma_dir : { dateDE: true  },
			fecha_firma_dir_gral : { dateDE: true  }, fecha_env_admin : { dateDE: true  }, fecha_env_acreencia : { dateDE: true  },
			// Movimiento MFIN
			fecha_env_fnza_pri_vez : { dateDE: true  }, fecha_devol_fnza : { dateDE: true  },
			fecha_env_fnza_sgd_vez : { dateDE: true  },
			// Movimiento Cierre
			fecha_env_psto : { dateDE: true  }, fecha_devol_sin_disp : { dateDE: true  },
			fecha_env_exp : { dateDE: true  },
			// Pago - Cheque
			fecha_remision_chq : { dateDE: true  }, fecha_listado : { dateDE: true  }, fecha_entrg_benefi : { dateDE: true  },
			num_listado : { digits:true }, num_cheque : { digits:true },
			// Pago - Transferencia
			fecha_transfe : { dateDE: true  }, num_confirm_transfe : { digits:true }, 
			// Cierre
			fecha_memo_cierre : { dateDE:true }, fecha_pago_vaca : { dateDE: true  }, 
			
		}}
	);	
});

// Reglas del Formulario Heredero
$(function() {
	$('#form_h').validate({
		rules:{
			// REGLAS TRABAJADOR 
			cedula_h : {  required: true, digits:true }, 	nombres_h : { required:true, alfabetico:true }, apellidos_h : { required:true, alfabetico:true }, num_cheque_h : { digits:true }
		}}
	);	
});

</script>
<?= $script ?>
<?=ajaxifica_tramite('form1','tramite/guardar',$rules = array())?>
<?php if ($this->session->userdata('acceso') == 'analista') :  ?>		
	<script>
	deshabilitar();
	</script>
 <?php endif; ?>



<script>
$(document).ready(function(){
	// Datos
	$('#telf_residencial').val('<?= $tramite->telf_residencial?>');
	$('#telf_celular').val('<?= $tramite->telf_celular?>');
	$('#correo_alt').val('<?= $tramite->correo_alt?>');
	$('#fecha_ingreso').val('<?= to_human_date($tramite->fecha_ingreso)?>');
	$('#fecha_egreso').val('<?= to_human_date($tramite->fecha_egreso)?>');
	// Trámite
	$('#div_estatus_tramite').html('<?= $tramite->estatus_tramite?>');
	$('#id_motivo_egreso').val('<?= $tramite->id_motivo_egreso?>');
	$('#id_usuario_asignado').val('<?= $tramite->id_usuario_asignado?>');
	$('#fecha_inicio').val('<?= $tramite->fecha_inicio?>');
	$('#fecha_asignacion').val('<?= date_to_human($tramite->fecha_asignacion) ?>');
	$('#num_djp').val('<?= $tramite->num_djp?>');
	$('#fecha_djp').val('<?= date_to_human($tramite->fecha_djp) ?>');
	$('#monto_viejo_regimen').val('<?= to_moneda($tramite->monto_viejo_regimen) ?>');
	$('#monto_ley_mayo').val('<?= to_moneda($tramite->monto_ley_mayo) ?>');
	$('#monto_prest_fide').val('<?= to_moneda($tramite->monto_prest_fide) ?>');
	$('#monto_total_prest').val('<?= to_moneda($tramite->monto_total_prest) ?>');
	$('#observaciones').val('<?= str_replace("\r\n"," ",$tramite->observaciones) ?>');
	// Movimientos MRE
	$('#fecha_firma_coord').val('<?= date_to_human($tramite->fecha_firma_coord) ?>');
	$('#fecha_firma_dir').val('<?= date_to_human($tramite->fecha_firma_dir) ?>');
	$('#fecha_firma_dir_gral').val('<?= date_to_human($tramite->fecha_firma_dir_gral) ?>');
	$('#fecha_env_admin').val('<?= date_to_human($tramite->fecha_env_admin) ?>');
	$('#num_memo_admin').val('<?= $tramite->num_memo_admin ?>');
    $('#fecha_env_acreencia').val('<?= date_to_human($tramite->fecha_env_acreencia) ?>');
	// Movimientos MFIN
	$('#nun_memo_env_fnza').val('<?= $tramite->nun_memo_env_fnza ?>');
	$('#fecha_env_fnza_pri_vez').val('<?= date_to_human($tramite->fecha_env_fnza_pri_vez) ?>');
	$('#fecha_devol_fnza').val('<?= date_to_human($tramite->fecha_devol_fnza) ?>');
	$('#num_memo_sgd_vez_fnza').val('<?= $tramite->num_memo_sgd_vez_fnza ?>');
	$('#fecha_env_fnza_sgd_vez').val('<?= date_to_human($tramite->fecha_env_fnza_sgd_vez) ?>');	
	// Movimientos Cierre
	$('#num_memo_env_psto').val('<?= $tramite->num_memo_env_psto ?>');
	$('#fecha_env_psto').val('<?= date_to_human($tramite->fecha_env_psto) ?>');
	$('#disp_bs').val('<?= to_moneda($tramite->disp_bs) ?>');
	$('#num_memo_sin_disp').val('<?= $tramite->num_memo_sin_disp ?>');
	$('#fecha_devol_sin_disp').val('<?= date_to_human($tramite->fecha_devol_sin_disp) ?>');
	$('#fecha_env_exp').val('<?= date_to_human($tramite->fecha_env_exp) ?>');
	// Tipo Pago
	$('#id_tipo_pago').val('<?= $tramite->id_tipo_pago ?>');
	// Cheque 
	$('#fecha_remision_chq').val('<?= date_to_human($tramite->fecha_remision_chq) ?>');
	$('#num_listado').val('<?= $tramite->num_listado ?>');
	$('#fecha_listado').val('<?= date_to_human($tramite->fecha_listado) ?>');
	$('#id_banco_cheque').val('<?= $tramite->id_banco_cheque ?>');
	$('#num_cheque').val('<?= $tramite->num_cheque ?>');
	$('#monto_cheque').val('<?= to_moneda($tramite->monto_cheque) ?>');
	$('#fecha_entrg_benefi').val('<?= date_to_human($tramite->fecha_entrg_benefi) ?>');
	// Transferencia
	$('#id_banco_transfe').val('<?= $tramite->id_banco_transfe ?>');
	$('#num_cta_transfe').val('<?= $tramite->num_cta_transfe ?>');
	$('#monto_transfe').val('<?= to_moneda($tramite->monto_transfe) ?>');
	$('#fecha_transfe').val('<?= date_to_human($tramite->fecha_transfe) ?>');
	$('#num_confirm_transfe').val('<?= $tramite->num_confirm_transfe ?>');
	// Cierre
	$('#num_memo_cierre').val('<?= $tramite->num_memo_cierre ?>');
	$('#fecha_memo_cierre').val('<?= date_to_human($tramite->fecha_memo_cierre) ?>');
	$('#vvnd_bvf').val('<?= to_moneda($tramite->vvnd_bvf) ?>');	
	$('#fecha_pago_vaca').val('<?= date_to_human($tramite->fecha_pago_vaca) ?>');
	$('#id_tipo_pago_vaca').val('<?= $tramite->id_tipo_pago_vaca ?>');
	// Herederos
	$('#observ_herederos').val("<?=  str_replace("\r\n","<br>",$tramite->observ_herederos) ?>");
	
});

</script>

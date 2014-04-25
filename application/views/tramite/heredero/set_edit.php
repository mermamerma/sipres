<script>
$('#cedula_h').val('<?= $heredero->cedula ?>');
$('#nombres_h').val('<?= $heredero->nombres ?>');
$('#apellidos_h').val('<?= $heredero->apellidos ?>');
$('#id_parentesco').val('<?= $heredero->id_parentesco ?>');
$('#id_banco_h').val('<?= $heredero->id_banco ?>');
$('#num_cheque_h').val('<?= $heredero->num_cheque ?>');
$('#monto_cheque_h').val('<?=to_moneda($heredero->monto) ?>');
$('#fecha_emision_h').val('<?= $heredero->fecha_emision ?>');
$('#fecha_entrega_h').val('<?= $heredero->fecha_entrega ?>');
</script>

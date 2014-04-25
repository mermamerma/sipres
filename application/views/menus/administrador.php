
<style>
<!--
	
	.fg-button { float:left; padding: .4em 1em; text-decoration:none !important; cursor:pointer; position: relative; text-align: center; zoom: 1; }
	.fg-button .ui-icon { position: absolute; top: 50%; margin-top: -8px; left: 50%; margin-left: -8px; }
		
	button.fg-button { width:auto; overflow:visible; } /* removes extra button width in IE */
	
	.fg-button-icon-left { padding-left: 2.1em; }
	.fg-button-icon-right { padding-right: 2.1em; }
	.fg-button-icon-left .ui-icon { right: auto; left: .2em; margin-left: 0; }
	.fg-button-icon-right .ui-icon { left: auto; right: .2em; margin-left: 0; }
	.fg-button-icon-solo { display:block; width:8px; text-indent: -9999px; }	 /* solo icon buttons must have block properties for the text-indent to work */	
	.hidden{display:none;}
-->
</style>


<script type="text/javascript">

$(function(){		
	
	$('.fg-button').hover(
		function(){ $(this).removeClass('ui-state-default').addClass('ui-state-focus'); },
		function(){ $(this).removeClass('ui-state-focus').addClass('ui-state-default'); }
	);

	$('#mnuSistema').fgmenu({content:$('#mnuSistema').next().html(), flyOut:true});
	$('#mnuTrabajador').fgmenu({content:$('#mnuTrabajador').next().html(), flyOut:true});		
	$('#mnuReporte').fgmenu({content:$('#mnuReporte').next().html(), flyOut:true});	
});


</script>

<div id="fgmenu" class="ui-widget-header ui-corner-bottom" style="margin-bottom:1px;float:left;display:block; width:900px;">
	<a tabindex="1" href="#sistema" class="fg-button fg-button-icon-right ui-widget ui-state-default ui-corner-bottom" id="mnuSistema">
	<span class="ui-icon ui-icon-triangle-1-s"></span>Sistema</a>
	<div id="sistema" class="hidden">
		<ul>
			<li><a href="<?=base_url()?>">Inicio</a></li>
			<li><a href="<?=base_url()."usuario"?>">Usuarios</a></li>		
			<li><a href="#">Maestros</a>
				<ul>
					<li><a href="<?=base_url()."maestro"?>">Principales</a></li>				
				</ul>
			</li>
			<li><a href="<?=base_url()."bitacora/listar"?>">Bitácorara</a></li>
		</ul>
	</div>

	<a tabindex="2" href="#trabajador" class="fg-button fg-button-icon-right ui-widget ui-state-default ui-corner-bottom" id="mnuTrabajador">
	<span class="ui-icon ui-icon-triangle-1-s"></span>Trabajador</a>
	<div id="trabajador" class="hidden">
		<ul>
			<li>
				<a href="<?=base_url()."trabajador/frm_buscar"?>">Buscar</a>
			</li>
		</ul>
	</div>
	
	<a tabindex="" href="#reporte" class="fg-button fg-button-icon-right ui-widget ui-state-default ui-corner-bottom" id="mnuReporte">
	<span class="ui-icon ui-icon-triangle-1-s"></span>Reporte</a>
	<div id="reporte" class="hidden">
		<ul>
			<li>
				<a href="<?=base_url()."reporte/formulario"?>">Formulario</a>
			</li>
		</ul>
	</div>

	<a style="" href="<?=base_url()."login/logoff"?>">
	<div class="fg-button ui-widget ui-state-default ui-corner-br" style="float:right;height:15px;display:block;">Salir</div></a>


</div>

<div style="float:right;margin-right: 10px; margin-top: 5px;">
<a><?= $this->session->userdata('usuario')?></a>
</div>
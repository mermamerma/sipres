<div id="resultado-ajax">
</div>
<div id="dialog">
</div>
<div id="form_container">
<form id="form1" class="appnitro" method="post" action="">
  <div class="form_description">
      <h2><?=$accion;?> <img id="img_accion" class="icon_accion" src="<?=base_url().'public/images/iconos/usuario.png'?>" /> </h2> 
      <p>Formulario</p>
	<?=form_hidden('id_usuario'); ?>	  
	<?=form_hidden('id_personal'); ?>	  
    </div>
	<div id="tabs">
	<ul>
	<li><a href="#tabs-1">Datos del Usuario</a></li>
	</ul>
	<div id="tabs-1">
    <table width="825" border="0">      
      <tr>
        <td>
			<li>
			<label class="description" for="element_2">Cédula del Usuario <span class="required">(*)</span></label>
			<?= form_input('cedula','','class="element text small"')?>
			<img id="img_buscar" src="<?=base_url().'public/images/lupa.png'?>" / onclick="javascript:consultar()" style="cursor:pointer;">
			</li>
		</td>
      </tr>

      <tr>
        <td><table width="826" border="0">
          <tr>
            <td width="409">
				<li>
				<label class="description" for="element_2">Nombres</label>
				<?= form_input('nombres','','class="element text medium-form" readonly="" ')?>
				</li>			</td>
            <td width="407">
				<label class="description" for="element_2">Apellidos</label>
				<?= form_input('apellidos','','class="element text medium-form" readonly=""')?>			</td>
          </tr>
		  <tr>
            <td width="409">
				<li>
				<label class="description" for="element_2">Sexo</label>
				<?= form_input('sexo','','class="element text medium-form" readonly=""')?>
				</li>			</td>
            <td width="407">
				<label class="description" for="element_2">Cargo</label>
				<?= form_input('cargo','','class="element text medium-form" readonly=""')?>			</td>
          </tr>
          <tr>
            <td>
				<li>
				<label class="description" for="element_2">Correo</label>
				<?= form_input('correo','','class="element text medium-form" readonly=""')?>
				</li>			</td>
            <td>
				<label class="description" for="element_2">Usuario <span class="required">(*)</span></label>
				<?= form_input('usuario','','class="element text medium-form"')?>			</td>
          </tr>
          <tr>
            <td>
				<li>
				<label class="description" for="element_2">Rol <span class="required">(*)</span></label>
				<?= form_dropdown_db('id_rol', 'rol');?>
				</li>
			</td>
            <td>
				<label class="description" for="element_2">Estatus <span class="required">(*)</span></label>
				<?= form_dropdown_db('id_estatus', 'estatus');?>			</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          
        </table></td>
      </tr>
    </table>
    </div>		       
  </form>
  <div id="aceptar" class="boton" onclick="javacript:enviar();">Aceptar</div>
  <div id="cancelar" class="boton" onclick="javacript:history.go(-1);">Cancelar</div>	
  <br /><br />
</div>
<script>
$("#aceptar").button({icons: {primary: "ui-icon-disk"},  	text: true	});
$("#cancelar").button({icons: {primary: "ui-icon-cancel"},  	text: true	});


function consultar() {

	$("#id_rol").rules("remove", "required");	
	$("#id_estatus").rules("remove", "required");
	$("#usuario").rules("remove", "required");

	if($('#form1').valid()){
		$('#resultado-ajax').hide();
		$('#cargando').show();
		
		$.ajax({
			url:'<?=base_url()?>trabajador/consultar',
			type:'post',
			dataType: 'json',
			data:$('#form1').serialize(),
			success:function(data){
				var personal = data;
				if(personal == 0) {
					mensaje('Personal con la cédula: '+$('#cedula').val()+' no existe en el SIGEFIRRHH') ;
					$("#form1").reset();						
				}				
				else {															
					$('#id_personal').val(personal.id_personal) ;
					$('#nombres').val(personal.nombres) ;
					$('#apellidos').val(personal.apellidos) ;
					$('#sexo').val(personal.sexo) ;
					$('#cargo').val(personal.cargo) ;
					$('#id_rol').val(personal.id_rol) ;
					$('#id_estatus').val(personal.id_estatus) ;
					if (personal.correo != null) {
						usuario = personal.correo ;
						usuario  = (usuario.substring(0,usuario.indexOf('@')));
						$('#correo').val(personal.correo) ;
						$('#usuario').val(usuario) ;
					}
					else {						
						nombres = $('#nombres').val()  ;
						apellidos = $('#apellidos').val() ;
						nom_array = nombres.split(' ');
						ape_array = apellidos.split(' ');
						cedula = $('#cedula').val()  ;
						part_cedula = cedula.substring(cedula.length - 3, cedula.length) ;
						usuario = nom_array[0]+'.'+ape_array[0]+part_cedula;
						usuario = usuario.toLowerCase();
						$('#usuario').val(usuario) ;
						
					}										
					$("#usuario").rules("add", {required:true});
					$("#id_rol").rules("add", {required:true});	
					$("#id_estatus").rules("add", {required:true});	
				}
			}
		});
	}
}



</script>

<?=ajaxifica('form1','usuario/guardar',$rules)?>

<?=$script;?>


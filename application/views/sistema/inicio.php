<?php
$total = "22"; // Numero total de imagenes
$extension = ".jpg";// Definimos la extension, puede ser .jpg, gif, bmp, etc.
$start = "1";
$random = mt_rand($start, $total);
$image_name = $random . $extension;
$path = base_url()."public/images/banners/".$image_name;
?> 
<form id="" class="appnitro" enctype="multipart/form-data" method="" action="#">
					<div class="form_description">
			<h2>Bienvenido al Sistema</h2>
			<div id="msj_login" class="" style=""></div>
		</div>						
<div>
  <label class="description" for="element_2"></label>
	<br />
	<br />
    <img src="<?=$path?>"  class="imagen_inicio"/>

	</div>
	
	<ul>
	<br />

</ul>
  </form>	
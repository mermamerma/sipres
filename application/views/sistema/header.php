<?php
/*
#echo $this->uri->uri_string() ;
#die();
#session_start();
#var_dump($this->session->userdata('esta_logueado')); die();
$esta_logueado = $this->session->userdata('esta_logueado') ;

if ( ! defined('BASEPATH')) exit('Sin Acceso Directo al Script');
session_start();
if ($esta_logueado==FALSE && $this->uri->uri_string()!='login')
{
	#die('no hay sesión') ;
	$this->session->sess_destroy(); 
	session_destroy();
	redirect('login','refresh');	
	exit();
}


if (($this->uri->uri_string()=='login') && ($esta_logueado == TRUE))	{	
	redirect('site','refresh');
	exit();
}
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?= $this->config->item('system_acronym'); ?> - <?= $this->config->item('system_name'); ?></title>
<link rel="shortcut icon" href="<?=base_url()?>public/images/cochinito.png" />
<?= script_tag('public/js/my_functions.js') ?>
<?=link_tag ( 'public/css/styles.css' );?>
<?=$this->jquery->output ();?>
</head>
<body id="main_body" class="ex_highlight_row">
<div id="div_main">
<?=img ( $top_png = array ('src' => 'public/images/top.png', 'width' => '736', 'height' => '11', 'id' => 'top' ) );?>
<?=img ( $topbolivariano = array ('src' => 'public/images/top_bolivariano.jpg', 'width' => '900', 'height' => '55' ) );?>
<?=img ( $topbolivariano = array ('src' => 'public/images/banner_sipres.jpg', 'width' => '900', 'height' => '50') );?>
<br />
<div id="form_container" style="top: 0px; right: 0px; padding-top: 1px; padding-right: 0px; padding-bottom: 1px;  border-bottom-color:#333333"> 
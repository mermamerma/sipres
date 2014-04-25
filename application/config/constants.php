<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

define('BANNER_PATH','public/images/banners');

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| Estas son constantes SQL que no varian
|
*/


define('SQL_ANALISTAS_ACTIVO','SELECT id_usuario as clave, usuario as valor FROM usuario where id_usuario NOT IN (0,1) AND id_estatus = 1 order by usuario ASC');
define('SQL_ANALISTAS_ALL','SELECT id_usuario as clave, usuario as valor FROM usuario where id_usuario NOT IN (0) AND id_estatus = 1 order by usuario ASC');
define('SQL_INI_TRAM','SELECT id_estatus_tramite as clave, nombre_estatus_tramite as valor FROM estatus_tramite where id_estatus_tramite = 5 ');
define('SQL_MOD_TRAM','SELECT id_estatus_tramite as clave, nombre_estatus_tramite as valor FROM estatus_tramite where id_estatus_tramite NOT IN (5) ORDER BY nombre_estatus_tramite ASC ');
define('SQL_TRAM','SELECT id_estatus_tramite as clave, nombre_estatus_tramite as valor FROM estatus_tramite');


/* End of file constants.php */
/* Location: ./application/config/constants.php */
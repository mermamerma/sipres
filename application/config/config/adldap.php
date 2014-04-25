<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['account_suffix'] = '';
$config['base_dn'] = 'ou=people,dc=mppre,dc=gob,dc=ve';
$config['domain_controllers'] = array ("repldap.mppre.gob.ve");
$config['ad_username'] = 'cn=admin,dc=gob,dc=ve';
$config['ad_username'] = 'cn=admin,dc=gob,dc=ve';
$config['ad_password'] = '12wsxzaq';
$config['real_primarygroup'] = true;
$config['use_ssl'] = false;
$config['use_tls'] = false;
$config['recursive_groups'] = true;
/*
$config['account_suffix'] = '';
$config['base_dn'] = 'ou=people,dc=mppre,dc=gob,dc=ve';
$config['domain_controllers'] = array ("10.11.11.20");
$config['ad_username'] = 'uid=zimbra,cn=admins,cn=zimbra';
$config['ad_password'] = '12wsxzaq';
$config['real_primarygroup'] = true;
$config['use_ssl'] = false;
$config['use_tls'] = false;
$config['recursive_groups'] = true;
*/
/* End of file adldap.php */
/* Location: ./system/application/config/adldap.php */
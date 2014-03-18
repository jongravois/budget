<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$active_group = "default";
$active_record = TRUE;

$db['pmfinancials']['hostname'] = "edrdb1";
$db['pmfinancials']['username'] = "pamuser";
$db['pmfinancials']['password'] = "K08p.h/";
$db['pmfinancials']['database'] = "pmfinancials";
$db['pmfinancials']['dbdriver'] = "sqlsrv";
$db['pmfinancials']['dbprefix'] = "";
$db['pmfinancials']['pconnect'] = FALSE;
$db['pmfinancials']['db_debug'] = TRUE;
$db['pmfinancials']['cache_on'] = FALSE;
$db['pmfinancials']['cachedir'] = "";
$db['pmfinancials']['char_set'] = "utf8";
$db['pmfinancials']['dbcollat'] = "utf8_general_ci";
$db['pmfinancials']['autoint']    = TRUE;
$db['pmfinancials']['stricton']   = FALSE;

////////////////////////////////////////////

$db['default']['hostname'] = "edrdb2";
$db['default']['username'] = "pamuser";
$db['default']['password'] = "K08p.h/";
$db['default']['database'] = "EdR_Budgeting";
$db['default']['dbdriver'] = "sqlsrv";
$db['default']['dbprefix'] = "";
$db['default']['pconnect'] = FALSE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = "";
$db['default']['char_set'] = "utf8";
$db['default']['dbcollat'] = "utf8_general_ci";
$db['default']['autoint']    = TRUE;
$db['default']['stricton']   = FALSE;


/* End of file database.php */
/* Location: ./application/config/database.php */
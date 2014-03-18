<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$autoload['packages'] = array();
$autoload['libraries'] = array('database', 'table');
$autoload['helper'] = array('url', 'file', 'form');
$autoload['config'] = array('site_config');
$autoload['language'] = array();
$autoload['model'] = array('globals_m', 'user_m', 'fiscal_m', 'finloc_m', 'pam_m', 'sam_m', 'sam_notes_m', 'email_m', 'budget_m', 'budget_feed_m', 'admin_m');


/* End of file autoload.php */
/* Location: ./application/config/autoload.php */
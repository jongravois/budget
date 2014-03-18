<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Atm_projection extends Frontend_Controller {

public function __construct() {
	parent::__construct();
	error_reporting(0); // for production
	parse_str($_SERVER['QUERY_STRING'], $_GET);
} // end constructor
/***************************************************/
/***************************************************/
public function index() {
	echo "This page needs to be coded.";
}
/***************************************************/
/***************************************************/
} // end class

/* End of file atm_projection.php */
/* Location: ./application/controllers/atm_projection.php */
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pam_user extends Frontend_Controller {

public function __construct() {
	parent::__construct();
	error_reporting(0); // for production
	parse_str($_SERVER['QUERY_STRING'], $_GET);
} // end constructor
/***************************************************/
/***************************************************/
public function index() {
	// assign 'user' from PM APP to variable $u
	$u = $this->input->post('sUsername');
	//print_r($u); die();

	$user = $this->user_m->login($u);
	
	if($user['accessLevel'] == "user" || $user['accessLevel'] == "superuser"){
		redirect('pam_budget/budget', 'refresh');
	} else {
		redirect('pam_budget/dashboard', 'refresh');
	} // end if
}
/***************************************************/
/***************************************************/
} // end class

/* End of file pam_user.php */
/* Location: ./application/controllers/pam_user.php */
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sam_user extends Frontend_Controller {

public function __construct() {
	parent::__construct();
	error_reporting(0); // for production
	parse_str($_SERVER['QUERY_STRING'], $_GET);
	$this->load->model('budget_m');
} // end constructor
/***************************************************/
/***************************************************/
public function index() {
	// assign 'user' from PM APP to variable $u
	$u = $this->input->post('sUsername');

	$user = $this->user_m->login($u);

	redirect('sam_budget/index/', 'refresh');
}
/***************************************************/
/***************************************************/
} // end class

/* End of file sam_user.php */
/* Location: ./application/controllers/sam_user.php */
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frontend_Controller extends MY_Controller {

function __construct(){
	parent::__construct();
	session_start();
	$this->load->library('session');
	$this->load->model('user_m');

	// if ($this->user_m->loggedin() == FALSE) {
	// 	redirect('welcome/index');
	// }
} // end constructor
/***********************************************/
/***********************************************/
} // end class

/* End of file Frontend_Controller.php */
/* Location: ./application/libraries/Frontend_Controller.php */

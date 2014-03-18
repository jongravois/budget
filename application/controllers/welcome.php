<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

public function __construct() {
	parent::__construct();
} // end constructor
/***************************************************/
/***************************************************/
public function index() {
	$this->load->view('welcome_message');
}
/***************************************************/
/**************************************************/
public function sam(){
	$this->load->view('welcome_message_sam');
} // end sam function
/**************************************************/
public function invalid_user(){
	$this->load->view('invalid_message');
} // end invalid_user function
/**************************************************/
/***************************************************/
} // end class

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
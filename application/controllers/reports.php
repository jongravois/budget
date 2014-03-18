<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends Frontend_Controller {

public function __construct() {
	parent::__construct();
	error_reporting(0); // for production
	parse_str($_SERVER['QUERY_STRING'], $_GET);
	$this->user = $this->session->all_userdata();
} // end constructor
/***************************************************/
/***************************************************/
public function index() {
	print_r($this->user['id']);
}
/***************************************************/
public function employee_summary($id){
	$this->load->view('pam/empsum', array(
        'user' => $this->user,
        'budget' => $id
    ));
} // end employee_summary function
/**************************************************/
public function ajax_reporter(){
	$lynk = $this->input->post('url');
	$hash = strtoupper(md5($this->user->login_user.time()));
	$pager =  $lynk.'&sessionid='.$hash;

	$updateit = $this->user_m->save_report_session($this->user['id'],$hash);

	//echo $updateit;
	echo $pager;
} // end ajax_reported function
/**************************************************/
/***************************************************/
} // end class

/* End of file reports.php */
/* Location: ./application/controllers/reports.php */
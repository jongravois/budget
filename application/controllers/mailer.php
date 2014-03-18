<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mailer extends Frontend_Controller {

public function __construct() {
	parent::__construct();
	error_reporting(0); // for production
	parse_str($_SERVER['QUERY_STRING'], $_GET);
} // end constructor
/***************************************************/
/***************************************************/
public function index() {
	/**
	* THIS WORKS WITH GMAIL SEND
	**/

	//error_reporting(E_ALL);
	$msg = "<html><head><meta charset='utf-8'><title>Budget Open</title></head><body><h3>The Payroll Portion of Demo Property's budget has been opened!</h3><p>All existing employees and their existing benefits have been provided by Human Resources and have been loaded into the budget.</p><p><strong>PLEASE NOTE:</strong> Existing part-time and hourly employees have been budgeted with NO hours and all bonus programs are also set to 0.</p><p>In order to access this new budget to make changes, please log into PM and access PAM from the left-hand navigation.</p></body></html>";

	$this->load->library('email');
	$this->email->set_newline("\r\n");

	$this->email->from('From: PAM@edrtrust.com\r\nReply-To: PAM@edrtrust.com');
	$this->email->to('jgravois@edrtrust.com');
	$this->email->subject('The Payroll Portion has been opened!');
	$this->email->message($msg);
	if($this->email->send()){
		echo 'Your email was sent, fool.';
	} else {
		show_error($this->email->print_debugger());
	} // end if

	/*
	$to = 'jgravois@edrtrust.com';
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From: PAM@edrtrust.com\r\nReply-To: PAM@edrtrust.com";
	$headers .= "\r\nCc:";
	$subject = 'The Payroll Portion has been opened!';
	$msg = "<html><head><meta charset='utf-8'><title>Budget Open</title></head><body><h3>The Payroll Portion of Demo Property's budget has been opened!</h3><p>All existing employees and their existing benefits have been provided by Human Resources and have been loaded into the budget.</p><p><strong>PLEASE NOTE:</strong> Existing part-time and hourly employees have been budgeted with NO hours and all bonus programs are also set to 0.</p><p>In order to access this new budget to make changes, please log into PM and access PAM from the left-hand navigation.</p></body></html>";
	@mail( $to, $subject, $msg, $headers);

	echo $msg;
	*/
}	
/***************************************************/
public function email_open($id){
	$thisBud = $this->budget_m->get($id);
	$user_email = $this->session->userdata('user_email');
	$regional_email = $this->session->userdata('regional');

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From: PAM@edrtrust.com\r\nReply-To: PAM@edrtrust.com";
	$headers .= "\r\nCc:";
	$subject = "The Payroll Portion of " . $thisBud->name . "'s has been opened!";
	$msg = "<html><head><meta charset='utf-8'><title>Budget Open</title></head><body><h3>The Payroll Portion of " . $thisBud->name . "'s budget has been opened!</h3><br><br><p>All existing employees and their existing benefits have been provided by Human Resources and have been loaded into the budget.</p><p><strong>PLEASE NOTE:</strong> Existing part-time and hourly employees have been budgeted with NO hours and all bonus programs, except the Community Manager's bonus, are also set to 0.</p><p>In order to access this new budget to make changes, please log into PM and access PAM from the left-hand navigation.</p><br><p><strong>REMEMBER:</strong> There are Grace Hill Training courses for PM, P.A.M. and S.A.M.</p></body></html>";

	$to = array($regional_email, $thisBud->budget_email);

	@mail( $to, $subject, $msg, $headers);

	redirect('pam_budget/budget/'.$thisBud->id, 'redirect');
} // end email_open function
/**************************************************/
/**************************************************/
/***************************************************/
} // end class

/* End of file pam_user.php */
/* Location: ./application/controllers/pam_user.php */
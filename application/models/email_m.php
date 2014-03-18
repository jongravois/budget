<?php

class Email_m extends MY_Model{

	protected $_table_name = '';
	protected $_primary_key = 'id';
	protected $_primary_filter = 'intval';
	protected $_order_by = '';
	protected $_rules = array();
	protected $_timestamps = FALSE;

function __construct(){
	parent::__construct();
} // end constructor
/***************************************************/
/***************************************************/
public function email_approved($id,$user,$software){
	$this->load->library('email');
	$this->email->set_newline("\r\n");

	$user = $this->user_m->get($user);
	$budget = $this->budget_m->get_bud_info($id);
	
	$to = $budget[0]['budget_email'] . ', ' . $budget[0]['approver_email'];
	$subject = $software . " Budget Approved";

	switch($software){
		case 'PAM':
			$msg = $this->load->view('pam/inc/email_pam_approve',compact('budget','user','subject','software'),true);
			break;
		case 'ATM':
			$msg = $this->load->view('sam/inc/email_atm_approve',compact('budget','user','subject','software'),true);
			break;
		case 'SAM':
			$msg = $this->load->view('sam/inc/email_sam_approve',compact('budget','user','subject','software'),true);
			break;
	} // end switch

	//mail setup, recipients, subject, etc
    $headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From: PAM@edrtrust.com\r\nReply-To: PAM@edrtrust.com";
	$headers .= "\r\nCc:";
	@mail( $to, $subject, $msg, $headers);

	return $msg;
} // end email_approved function
/**************************************************/
public function email_open($id,$user,$software){
	$this->load->library('email');
	$this->email->set_newline("\r\n");

	$user = $this->user_m->get($user);
	$budget = $this->budget_m->get_bud_info($id);
	
	$to = $budget[0]['budget_email'] . ', ' . $budget[0]['approver_email'];
	$subject = $software . " Budget Opened";

	switch($software){
		case 'PAM':
			$msg = $this->load->view('pam/inc/email_pam_open',compact('budget','user','subject','software'),true);
			break;
		case 'ATM':
			break;
		case 'SAM':
			$msg = $this->load->view('sam/inc/email_sam_open',compact('budget','user','subject','software'),true);
			break;
	} // end switch

	//mail setup, recipients, subject, etc
    $headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From: PAM@edrtrust.com\r\nReply-To: PAM@edrtrust.com";
	$headers .= "\r\nCc:";
	@mail( $to, $subject, $msg, $headers);

	return $msg;
} // end sam_email_open function
/**************************************************/
public function email_rejected($id,$user,$software,$reason = null){
	$this->load->library('email');
	$this->email->set_newline("\r\n");

	$user = $this->user_m->get($user);
	$budget = $this->budget_m->get_bud_info($id);
	
	$to = $budget[0]['budget_email'] . ', ' . $budget[0]['approver_email'];
	$subject = $software . " Budget Rejected";

	switch($software){
		case 'PAM':
			$msg = $this->load->view('pam/inc/email_pam_reject',compact('budget','user','subject','software','reason'),true);
			break;
		case 'ATM':
			$msg = $this->load->view('sam/inc/email_atm_reject',compact('budget','user','subject','software','reason'),true);
			break;
		case 'SAM':
			$msg = $this->load->view('sam/inc/email_sam_reject',compact('budget','user','subject','software','reason'),true);
			break;
	} // end switch

	//mail setup, recipients, subject, etc
    $headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From: PAM@edrtrust.com\r\nReply-To: PAM@edrtrust.com";
	$headers .= "\r\nCc:";
	@mail( $to, $subject, $msg, $headers);

	return $msg;
} // end email_rejected function
/**************************************************/
public function email_reopened($id,$user,$software){
	$this->load->library('email');
	$this->email->set_newline("\r\n");

	$user = $this->user_m->get($user);
	$budget = $this->budget_m->get_bud_info($id);
	
	$to = $budget[0]['budget_email'] . ', ' . $budget[0]['approver_email'];
	$subject = $software . " Budget Re-Opened";

	switch($software){
		case 'PAM':
			$msg = $this->load->view('pam/inc/email_pam_reopen',compact('budget','user','subject','software'),true);
			break;
		case 'ATM':
			break;
		case 'SAM':
			$msg = $this->load->view('sam/inc/email_sam_reopen',compact('budget','user','subject','software'),true);
			break;
	} // end switch

	//mail setup, recipients, subject, etc
    $headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From: PAM@edrtrust.com\r\nReply-To: PAM@edrtrust.com";
	$headers .= "\r\nCc:";
	@mail( $to, $subject, $msg, $headers);

	return $msg;
} // end email_reopened function
/**************************************************/
public function email_submitted($id,$user,$software){
	$this->load->library('email');
	$this->email->set_newline("\r\n");

	$user = $this->user_m->get($user);
	$budget = $this->budget_m->get_bud_info($id);
	
	$to = $budget[0]['budget_email'] . ', ' . $budget[0]['approver_email'];
	$subject = $software . " Budget Submitted";

	switch($software){
		case 'PAM':
			$msg = $this->load->view('pam/inc/email_pam_submit',compact('budget','user','subject','software'),true);
			break;
		case 'ATM':
			$msg = $this->load->view('sam/inc/email_atm_submit',compact('budget','user','subject','software'),true);
			break;
		case 'SAM':
			$msg = $this->load->view('sam/inc/email_sam_submit',compact('budget','user','subject','software'),true);
			break;
	} // end switch

	//mail setup, recipients, subject, etc
    $headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From: PAM@edrtrust.com\r\nReply-To: PAM@edrtrust.com";
	$headers .= "\r\nCc:";
	@mail( $to, $subject, $msg, $headers);

	return $msg;
} // end email_submitted function
/**************************************************/
public function email_test(){
	$to = 'jgravois@edrtrust.com';
	$subject = "Test Email";
	$msg = "<html><head><title>TEST EMAIL</title><meta http-equiv='Content-Type' content='text/html; charset=utf-8' /></head><body><h1>Test Title</h1><p>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.</p><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.</p><p>Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. Nam nulla quam, gravida non, commodo a, sodales sit amet, nisi.</p></body></html>";

	//mail setup, recipients, subject, etc
    $headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From: PAM@edrtrust.com\r\nReply-To: PAM@edrtrust.com";
	$headers .= "\r\nCc:";
	mail( $to, $subject, $msg, $headers);
} // end email_test function
/**************************************************/
/***************************************************/
/***************************************************/
} // end class
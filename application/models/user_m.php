<?php

class User_m extends MY_Model{

	protected $_table_name = 'users';
	protected $_primary_key = 'id';
	protected $_primary_filter = 'intval';
	protected $_order_by = 'username';
	protected $_rules = array();
	protected $_timestamps = FALSE;

function __construct(){
	parent::__construct();
} // end constructor
/***************************************************/
/***************************************************/
public function login($u){
	$user = $this->get_by("username='{$u}'",TRUE);
	//echo $this->db->last_query(); die();
	//var_dump($user);die();
	
	if( $user ){
		$sql = "SELECT ParentEmail FROM [EdR_Budgeting].[dbo].[UserHierarchy] WHERE Child LIKE '%" . $user->username . "%'";
		$query = $this->db->query($sql);
		$regional = $query->row('ParentEmail');

		if( !$regional ){ $regional = "kreed@edrtrust.com"; }
		
		//log in user
	 	$data = array(
	 		'id' => $user->id,
	 		'username' => $user->username,
			'user_email' => $user->user_email,
			'login_user' => $user->login_user,
			'accessLevel' => $user->accessLevel,
			'default_budget' => $user->defaultBudget,
			'access_group' => $user->access_group,
			'regional' => $regional,
			'loggedin' => TRUE
		);
		$this->session->set_userdata($data);
		
		return $data;
	} else{
		redirect('welcome/invalid_user','refresh');
	} // end if	
} // end login function
/**************************************************/
public function logout(){
	$this->session->sess_destroy();
} // end logout function
/**************************************************/
public function loggedin(){
	return (bool) $this->session->userdata('loggedin');
} // end leggedin function
/**************************************************/
public function hash($string){
	return hash('sha512', $string . config_item('encryption_key'));
} // end hash function
/**************************************************/
public function save_report_session($id,$hash){
	$sql = "UPDATE users SET sessionid = '{$hash}' WHERE id = {$id}";
	$doit = $this->db->query($sql);
	return $this->db->last_query();
} // end save_report_session function
/**************************************************/
/***************************************************/
/***************************************************/
} // end class
<?php

class Budget_feed_m extends MY_Model{

	protected $_table_name = 'budget_feed';
	protected $_primary_key = 'EMP_ID';
	protected $_primary_filter = 'intval';
	protected $_order_by = 'EMP_ID';
	protected $_rules = array();
	protected $_timestamps = FALSE;

function __construct(){
	parent::__construct();
} // end constructor
/***************************************************/
/***************************************************/
public function get_bonus_by_budget($bid){
	$CY = $this->globals_m->current_year();
	$query = $this->db->where('COMPANY_ID', substr($bid,0,3))->where('EE_YEAR', $CY )->where('NAME','Staffing Bonus')->get('budget_feed');
	return $query->result_array();
} // end get_bonus_by_budget function
/**************************************************/
public function get_bonus_by_empid($id){
	$CY = $this->globals_m->current_year();

	$q = $this->db->select('BUDGET_ID')->where('EMP_ID', $id)->limit(1)->get('budget_feed');
	$bid = $q->row('BUDGET_ID');
	//return $bid;

	$query = $this->db->where('COMPANY_ID', substr($bid,0,3))->where('EE_YEAR', $CY )->where('NAME','Staffing Bonus')->get('budget_feed');
	//return $this->db->last_query();
	return $query->result_array();
} // end get_bonus_by_empid function
/*-----------------------------------------------------*/
public function get_bonus_id_by_budget($id){
	$curr_year = $this->globals_m->current_year();
	$q = $this->db->select('EMP_ID')->where('EE_YEAR',$curr_year)->where('EE_STATUS','S')->where('BUDGET_ID',$id)->get('budget_feed');
	return $q->row('EMP_ID'); 
} // end get_bonus_id_by_budget function
/**************************************************/
public function get_staffing_bonus_feed($id){
	$budget = $this->get($id);
	return $budget;
} // end get_staffing_bonus_feed function
/**************************************************/
public function get_streetteam_by_budget($id){
	$curr_year = $this->globals_m->current_year();
	$q = $this->db->where('COMPANY_ID', substr($id,0,3))->where('EE_YEAR', $curr_year )->where('NAME','Temp Help G&A')->get('budget_feed');
	return $q->result_array();
} // end get_turn_by_budget function
/**************************************************/
public function get_turn_feed($id){
	$budget = $this->get($id);
	return $budget;
} // end get_turn_feed function
/**************************************************/
public function get_turn_by_budget($id){
	$curr_year = $this->globals_m->current_year();
	$q = $this->db->where('COMPANY_ID', substr($id,0,3))->where('EE_YEAR', $curr_year )->where('NAME','TEMPORARY LABOR -- TURN')->get('budget_feed');
	return $q->result_array();
} // end get_turn_by_budget function
/**************************************************/
/***************************************************/
/***************************************************/
} // end class
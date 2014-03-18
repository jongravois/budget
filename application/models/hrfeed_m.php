<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hrfeed_m extends MY_Model{

	protected $_table_name     = 'hr_feed';
	protected $_primary_key    = 'id';
	protected $_primary_filter = 'intval';
	protected $_order_by       = 'EMPLID';
	protected $_rules          = array();
	protected $_timestamps     = FALSE;

function __construct(){
	parent::__construct();
} // end constructor
/***************************************************/
public function get_field_emps($id){
	$co = substr($id,0,3);
	$sql = "SELECT * FROM hr_feed WHERE LEFT(HOME_DEPT,3) = {$co} AND YEAR_ID = {$this->globals_m->current_year()}";
	$q = $this->db->query($sql);
	return $q->result_array();
} // end get_field_emps function
/**************************************************/
public function get_department_emps($id){
	$sql = "SELECT * FROM hr_feed WHERE HOME_DEPT = {$id} AND YEAR_ID = {$this->globals_m->current_year()}";
	$q = $this->db->query($sql);
	return $q->result_array();
} // end get_department_emps function
/**************************************************/
/***************************************************/
/***************************************************/
} // end class
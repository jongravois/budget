<?php

class Fiscal_m extends MY_Model{

	protected $_table_name = 'fiscal_reference';
	protected $_primary_key = 'id';
	protected $_primary_filter = 'intval';
	protected $_order_by = 'id';
	protected $_rules = array();
	protected $_timestamps = FALSE;

function __construct(){
	parent::__construct();
} // end constructor
/***************************************************/
/***************************************************/
public function get_fiscal_info($id){
	$q = $this->db->where('fiscal_start',$id)->get('fiscal_reference');
	return $q->result_array();
} // end get_fiscal_info function
/**************************************************/
/***************************************************/
/***************************************************/
} // end class
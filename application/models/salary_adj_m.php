<?php

class Salary_adj_m extends MY_Model{

	protected $_table_name = 'salary_adjustment';
	protected $_primary_key = 'id';
	protected $_primary_filter = 'intval';
	protected $_order_by = '';
	protected $_rules = array();
	protected $_timestamps = FALSE;

function __construct(){
	parent::__construct();
} // end constructor
/***************************************************/
public function save_adjustments($arr){
	$EMP_ID = $arr['EMP_ID'];

	$q = $this->db->where('EMP_ID', $EMP_ID)->get('salary_adjustment');

	if ($q->num_rows() > 0) {
		$this->db->where('EMP_ID', $EMP_ID)->update('salary_adjustment', $arr);
	} else { 
		$this->db->insert('salary_adjustment', $arr);
	} // end if

	return $this->db->last_query();
} // end save_adjustments function
/**************************************************/
/***************************************************/
/***************************************************/
/***************************************************/
} // end class
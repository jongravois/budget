<?php

class Sam_notes_m extends MY_Model{

	protected $_table_name = 'sam_notes';
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
public function get_asset_year_note($budget_id, $asset_id, $year_id){
	/*$co_id = (int)substr($budget_id,0,3);
	$de_id = substr($budget_id,-2);
	if( $de_id == '00'){ $de_id = 99; } else { $de_id = (int)$de_id; } // end if
	$theCol = '['.$year_id.']';
	
	$q = $this->db->select($theCol)->where('COMPANY_ID', $co_id)->where('DEPARTMENT_ID',$de_id)->where('ASSET_ID',$asset_id)->get('sam_notes');
	//return $this->db->last_query();
	return $q->row($theCol);*/
} // end get_asset_year_note function
/**************************************************/
public function get_asset_note($budget_id, $asset_id){
	$co_id = (int)substr($budget_id,0,3);
	$de_id = substr($budget_id,-2);
	if( $de_id == '00'){ $de_id = 99; } else { $de_id = (int)$de_id; } // end if
	
	$q = $this->db->where('COMPANY_ID', $co_id)->where('DEPARTMENT_ID',$de_id)->where('ASSET_ID',$asset_id)->get('sam_notes');
	//return $this->db->last_query();
	return $q->result_array();
} // end get_asset_year_note function
/**************************************************/
/***************************************************/
/***************************************************/
} // end class
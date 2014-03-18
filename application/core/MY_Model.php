<?php
class MY_Model extends CI_Model {
	
	protected $_table_name = '';
	protected $_primary_key = 'id';
	protected $_primary_filter = 'intval';
	protected $_order_by = '';
	protected $_rules = array();
	protected $_timestamps = FALSE;
	
function __construct() {
	parent::__construct();
} // end constructor
/***************************************************/
/***************************************************/
public function get($id = NULL, $single = FALSE){
	if ($id != NULL) {
		$filter = $this->_primary_filter;
		$id = $filter($id);
		$this->db->where($this->_primary_key, $id);
		$method = 'row';
	} elseif($single == TRUE) {
		$method = 'row';
	} else {
		$method = 'result';
	} // end if
	
	if (!count($this->db->ar_orderby)) {
		$this->db->order_by($this->_order_by);
	} // end if
	return $this->db->get($this->_table_name)->$method();
} // end function
/***************************************************/	
public function get_by($where, $single = FALSE){
	$this->db->where($where);
	return $this->get(NULL, $single);
} // end get_by function
/***************************************************/	
public function save($data, $id = NULL){
	// Set timestamps
	if ($this->_timestamps == TRUE) {
		$now = date('Y-m-d H:i:s');
		$id || $data['created'] = $now;
		$data['modified'] = $now;
	} // end if
	
	// Insert
	if ($id === NULL) {
		!isset($data[$this->_primary_key]) || $data[$this->_primary_key] = NULL;
		$this->db->set($data);
		$this->db->insert($this->_table_name);
		$id = $this->db->insert_id();
	} else {
		// Update
		$filter = $this->_primary_filter;
		$id = $filter($id);
		$this->db->set($data);
		$this->db->where($this->_primary_key, $id);
		$this->db->update($this->_table_name);
	} // end if
	
	return $id;
} // end save function
/***************************************************/
public function delete($id){
	$filter = $this->_primary_filter;
	$id = $filter($id);
	
	if (!$id) {
		return FALSE;
	} // end if
	$this->db->where($this->_primary_key, $id);
	$this->db->limit(1);
	$this->db->delete($this->_table_name);
} // end delete function
/***************************************************/
public function set_db( $db_name ){
	if (in_array($db_name, array_keys($this->_db))) {
		$this->db = $this->$db_name;
	} else {
		show_error('Invalid database connection: ' . $db_name);
	} // end if
} // end set_db function
/***************************************************/
/***************************************************/
} // end class
<?php

class Admin_m extends MY_Model{

	protected $_table_name = 'budgets';
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
public function clear_out_atm($bid){
	$co_id = substr($bid,0,3);
	$de_id = substr($bid,-2);
	if( $de_id == '00'){ $de_id = 99; } else { $de_id = (int)$de_id; } // end if

	$CY = $this->globals_m->current_year();
	$sql = "DELETE FROM atm_feed WHERE YEAR_ID = {$CY} AND COMPANY_ID = {$co_id} AND DEPARTMENT_ID = {$de_id}";
	$clr = $this->db->query($sql);
	return $this->db->last_query();
} // end clear_out_atm function
/**************************************************/
public function fetch_admin_record_edit($id, $table){
	switch( $table ){
		case 'sam_asset_type':
			$q = $this->db->where('PROJECT_CODE',$id)->get($table);
			break;
		case 'comType':
			$q = $this->db->where('companyTypeID',$id)->get($table);
			break;
		case 'jobcodes':
			$q = $this->db->where('jobCode',$id)->get($table);
			break;
		default:
			$q = $this->db->where('id',$id)->get($table);
			break;
	} // end switch
	return $q->result_array();
} // end fetch_admin_record_edit function
/**************************************************/
public function get_access_group_dd(){
	$sql = "SELECT id,access_group FROM dbo.accessgroups";
	$q = $this->db->query($sql);
	
	if( $q->num_rows() > 0) {
		$data[0] = "Select ... ";
		foreach( $q->result() as $row ){
			$data[$row->id] = $row->access_group;
		} //end foreach
		return $data;
	} // end if
} // end get_access_group_dd function
/**************************************************/
public function get_access_level_dd(){
	$access = array(
		'user' => 'Single Budget User',
		'superuser' => 'Multiple Budget User',
		'analyst' => 'Analyst (Read Only Access to Properties',
		'regional' => 'Regional'
	);
	return $access;
} // end get_access_level_dd function
/**************************************************/
public function get_all_accessgroups(){
	$q = $this->db->select('id,access_group')->get('accessgroups');
	$recordset = $q->result_array();

	for($r=0;$r<count($recordset);$r++):
		$recordset[$r]['actions'] = "
			<div class='btn-group'>
			<button class='btnEditRecord btn btn-inverse' data-id='" . $recordset[$r]['id'] . "' data-table='accessgroups'>Edit</button>
			<button class='btnDeleteRecord btn btn-danger' data-id='" . $recordset[$r]['id'] . "' data-table='accessgroups'>Delete</button>
			</div>
		";
	endfor;

	return $recordset;
} // end get_all_accessgroups function
/**************************************************/
public function get_all_budgets(){
	$q = $this->db->select('id,name,budget_email,approver_email')->get('budgets');
	$recordset = $q->result_array();

	for($r=0;$r<count($recordset);$r++):
		$recordset[$r]['actions'] = "
			<div class='btn-group'>
			<button class='btnEditRecord btn btn-inverse' data-id='" . $recordset[$r]['id'] . "' data-table='budgets'>Edit</button>
			<button class='btnDeleteRecord btn btn-danger' data-id='" . $recordset[$r]['id'] . "' data-table='budgets'>Delete</button>
			</div>
		";
	endfor;

	return $recordset;
} // end get_all_budgets function
/**************************************************/
public function get_all_company_types(){
	$q = $this->db->select('companyTypeID,CompanyType')->get('comType');
	$recordset = $q->result_array();

	for($r=0;$r<count($recordset);$r++):
		$recordset[$r]['actions'] = "
			<div class='btn-group'>
			<button class='btnEditRecord btn btn-inverse' data-id='" . $recordset[$r]['companyTypeID'] . "' data-table='comType'>Edit</button>
			<button class='btnDeleteRecord btn btn-danger' data-id='" . $recordset[$r]['companyTypeID'] . "' data-table='comType'>Delete</button>
			</div>
		";
	endfor;

	return $recordset;
} // end get_all_company_types function
/**************************************************/
public function get_all_fixed_assets(){
	$q = $this->db->select('PROJECT_CODE,ASSET_TYPE,PROJECT_TYPE,DEPRECIATION_ACCOUNT_NUMBER')->get('sam_asset_type');
	$recordset = $q->result_array();

	for($r=0;$r<count($recordset);$r++):
		$recordset[$r]['actions'] = "
			<div class='btn-group'>
			<button class='btnEditRecord btn btn-inverse' data-id='" . $recordset[$r]['PROJECT_CODE'] . "' data-table='sam_asset_type'>Edit</button>
			<button class='btnDeleteRecord btn btn-danger' data-id='" . $recordset[$r]['PROJECT_CODE'] . "' data-table='sam_asset_type'>Delete</button>
			</div>
		";
	endfor;

	return $recordset;
} // end get_all_fixed_assets function
/**************************************************/
public function get_all_globals(){
	$curr_year = $this->globals_m->current_year();
	$q = $this->db->select('id,name,item,value,max')->where('year_id',$curr_year)->get('globals');
	$recordset = $q->result_array();

	for($r=0;$r<count($recordset);$r++):
		$recordset[$r]['actions'] = "
			<div class='btn-group'>
			<button class='btnEditRecord btn btn-inverse' data-id='" . $recordset[$r]['id'] . "' data-table='globals'>Edit</button>
			<button class='btnDeleteRecord btn btn-danger' data-id='" . $recordset[$r]['id'] . "' data-table='globals'>Delete</button>
			</div>
		";
	endfor;

	return $recordset;
} // end get_all_globals function
/**************************************************/
public function get_all_job_codes(){
	$q = $this->db->select('jobCode,jobTitle,Company_Dept,accountCrossReference')->get('jobcodes');
	$recordset = $q->result_array();

	for($r=0;$r<count($recordset);$r++):
		$recordset[$r]['actions'] = "
			<div class='btn-group'>
			<button class='btnEditRecord btn btn-inverse' data-id='" . $recordset[$r]['jobCode'] . "' data-table='jobcodes'>Edit</button>
			<button class='btnDeleteRecord btn btn-danger' data-id='" . $recordset[$r]['jobCode'] . "' data-table='jobcodes'>Delete</button>
			</div>
		";
	endfor;

	return $recordset;
} // end get_all_job_codes function
/**************************************************/
public function get_all_sui(){
	$q = $this->db->select('id,state,SUIrate,SUIbase')->get('sui');
	$recordset = $q->result_array();

	for($r=0;$r<count($recordset);$r++):
		$recordset[$r]['actions'] = "
			<div class='btn-group'>
			<button class='btnEditRecord btn btn-inverse' data-id='" . $recordset[$r]['id'] . "' data-table='sui'>Edit</button>
			<button class='btnDeleteRecord btn btn-danger' data-id='" . $recordset[$r]['id'] . "' data-table='sui'>Delete</button>
			</div>
		";
	endfor;

	return $recordset;
} // end get_all_sui function
/**************************************************/
public function get_all_users(){
	$q = $this->db->select('id,username,defaultBudget,accessLevel,user_email,access_group')->get('users');
	$recordset = $q->result_array();

	for($r=0;$r<count($recordset);$r++):
		$recordset[$r]['actions'] = "
			<div class='btn-group'>
			<button class='btnEditRecord btn btn-inverse' data-id='" . $recordset[$r]['id'] . "' data-table='users'>Edit</button>
			<button class='btnDeleteRecord btn btn-danger' data-id='" . $recordset[$r]['id'] . "' data-table='users'>Delete</button>
			</div>
		";
	endfor;

	return $recordset;
} // end get_all_users function
/**************************************************/
public function get_all_workers_comp(){
	$q = $this->db->select('id,code,description,ratePerHundred,wcClassCode')->get('workerscompensationrates');
	$recordset = $q->result_array();

	for($r=0;$r<count($recordset);$r++):
		$recordset[$r]['actions'] = "
			<div class='btn-group'>
			<button class='btnEditRecord btn btn-inverse' data-id='" . $recordset[$r]['id'] . "' data-table='workerscompensationrates'>Edit</button>
			<button class='btnDeleteRecord btn btn-danger' data-id='" . $recordset[$r]['id'] . "' data-table='workerscompensationrates'>Delete</button>
			</div>
		";
	endfor;

	return $recordset;
} // end get_all_workers_comp function
/**************************************************/
public function get_budget_ids(){
	$q = $this->db->select('id')->get('budgets');
	return $q->result_array();
} // end get_budget_ids function
/*-----------------------------------------------------*/
public function get_budget_year(){
	$q = $this->db->select('id,name,item,value,max')->get('budget_year');
	$recordset = $q->result_array();

	for($r=0;$r<count($recordset);$r++):
		$recordset[$r]['actions'] = "
			<div class='btn-group'>
			<button class='btnEditRecord btn btn-inverse' data-id='" . $recordset[$r]['id'] . "' data-table='budget_year'>Edit</button>
			</div>
		";
	endfor;

	return $recordset;
} // end get_budget_year function
/*-----------------------------------------------------*/
public function get_company_type_dd(){
	$sql = "SELECT companyTypeID,CompanyType FROM dbo.comType";
	$q = $this->db->query($sql);
	
	if( $q->num_rows() > 0) {
		$data[0] = "Select ... ";
		foreach( $q->result() as $row ){
			$data[$row->companyTypeID] = $row->CompanyType;
		} //end foreach
		return $data;
	} // end if
} // end get_company_type_dd function
/**************************************************/
public function get_current_status_by_budget_id($id,$software = 'pam'){
	$field = $software . '_status';

	$q = $this->db->select($field)->where('id',$id)->get('budgets');
	return $q->row($field);
} // end get_current_status_by_budget_id function
/**************************************************/
public function get_ez_admin(){
	$CY = $this->globals_m->current_year();
	$sql = "SELECT B.id, B.name, pm_status = case when F.UNIT_ID <> 80000000 then CAST(F.DEC AS int) when G.UNIT_ID = 80000000 then CAST(G.DEC AS int) end, B.pam_status, B.atm_status, B.sam_status FROM [EdR_Budgeting].[dbo].[budgets] as B LEFT JOIN edrdb1.[PMFINANCIALS].[pmfinancials].[FINLOC] as F ON (F.YEAR_ID = {$CY} AND LEFT(B.id,3) = F.UNIT_ID AND F.LINE_ID IN (80000184,80000183) AND ( F.CUST2_ID = RIGHT(B.id,2) OR F.UNIT_ID = RIGHT(B.id,2) )AND F.VER_ID = 80000000) JOIN edrdb1.[PMFINANCIALS].[pmfinancials].[FINLOC]  as G ON (G.YEAR_ID = {$CY} AND G.UNIT_ID = 80000000 AND G.LINE_ID IN (80000184,80000183) AND ( G.CUST1_ID = RIGHT(B.id,2) OR G.UNIT_ID = RIGHT(B.id,2) )AND G.VER_ID = 80000000)";
	$q = $this->db->query($sql);
	$recordset = $q->result_array();

	if( count($recordset) == 0){
		$q = $this->db->select('id, name, 999 as pm_status, pam_status, atm_status, sam_status')->order_by('id')->get('budgets');
		$recordset = $q->result_array();
	} // end if

	return $recordset;
} // end get_ez_admin function
/**************************************************/
public function get_live_pam_budgets(){
	$q = $this->db->where('pam_status != 0')->get('budgets');
	return $q->result_array();
} // end get_live_budgets function
/**************************************************/
public function get_live_sam_budgets(){
	$q = $this->db->select('id')->where('sam_status != 0')->get('budgets');
	return $q->result_array();
} // end get_live_budgets function
/**************************************************/
public function get_open_pam_budgets(){
	$q = $this->db->select('id')->where('pam_status',1)->get('budgets');
	return $q->result_array();
} // end get_open_budgets function
/**************************************************/
public function get_open_sam_budgets(){
	$q = $this->db->select('id')->where('sam_status',1)->get('budgets');
	return $q->result_array();
} // end get_open_budgets function
/**************************************************/
public function get_project_count($bid){
	$CY = $this->globals_m->current_year();
	$co_id = (int)substr($bid,0,3);
	$de_id = substr($bid,-2);
	if( $de_id == '00'){ $de_id = 99; } else { $de_id = (int)$de_id; } // end if

	$sql = "SELECT COUNT(*) AS cnt FROM sam_asset_feed WHERE YEAR_ID = {$CY} AND COMPANY_ID = {$co_id} AND DEPARTMENT_ID = {$de_id}";
	$q = $this->db->query($sql);
	return $q->row('cnt');
} // end get_project_count function
/*-----------------------------------------------------*/
public function recalc_pam($bid){
	// return $bid;
	$CY = $this->globals_m->current_year();
	$curr_date = date('Y-m-d');
	$co_id = substr($bid,0,3);
	
	if( (int)$co_id > 499 && (int)$co_id < 600 ){
		$corporate = 1;
	} else {
		$corporate = 0;
	} // end if

	$q = $this->db->select('EMP_ID')
	              ->where('EE_YEAR', $CY)
	              ->where('BUDGET_ID',$bid)
	              ->where('EE_STATUS', 'B')
	              ->get('budget_feed');
	// return $q->result_array();
	
	if ($q->num_rows() > 0) {
		if( (int)$corporate == 1 ){
			foreach($q->result_array() as $emp){
				//return $emp;
				$doit = $this->budget_m->budget_corporate($emp['EMP_ID']);
				$sql = "UPDATE budget_feed SET EE_STATUS = 'B', LAST_EDIT = '{$curr_date}' WHERE EMP_ID = {$emp['EMP_ID']} AND EE_YEAR = {$curr_year}";
				$dothedate = $this->admin_m->xSQL($sql);
			} // end foreach
		} else {
			foreach($q->result_array() as $emp){
				$doit = $this->budget_m->budget_field($emp['EMP_ID']);
				// print_r($doit); die();
				$sql = "UPDATE budget_feed SET EE_STATUS = 'B', LAST_EDIT = '{$curr_date}' WHERE EMP_ID = {$emp['EMP_ID']} AND EE_YEAR = {$CY}";
				// return $sql;
				$dothedate = $this->admin_m->xSQL($sql);
			} // end foreach

			// return $bid;

			$doitbonus = $this->budget_m->budget_staffing_bonus_by_bid($bid);
			$doitturn = $this->budget_m->budget_turn_emp_by_bid($bid);
			$doitstreet = $this->budget_m->budget_streetteam_emp_by_bid($bid);
		} //end if
	} else {
		return false;
	} // end if

	return "complete.";
} // end recalc function
/**************************************************/
public function recalc_sam($bid){
	$prose = $this->sam_m->get_project_ids_for_sam($bid);
	//return $prose;
	if( count($prose) > 0):
		foreach($prose as $proj):
			$thisProj = $this->sam_m->get_project_info($proj['id']);
			
			$id = $thisProj[0]['id'];
			$pid = $thisProj[0]['ASSET_ID'];
			$action = "update";
			$arrUpdate = array();

			for($u=1;$u<13;$u++){
				$arrUpdate['P'.$u] = $thisProj[0]['P'.$u];
			} // end for

			$doit = $this->sam_m->save_to_sam_pm_out($id, $pid, $bid, $arrUpdate, $action);

			if( $doit ){
				echo '<br>' . $id . ': ' . $thisProj[0]['SAM_ASSET'] . ': Recalculated.<br>';
			} // end if
		endforeach;
	endif;
	
	echo ' <span style="color:#B00400;font-weight:bold;">Complete!</span><br><br>';
} // end recalc_sam function
/*-----------------------------------------------------*/
public function save_group_ins($arr, $prc){
	$sqlS = "UPDATE globals SET value = {$arr['aSingle']}, max = {$arr['cSingle']} WHERE item = 'GISingle'";
	$upSingle = $this->db->query($sqlS);

	$sqlF = "UPDATE globals SET value = {$arr['aFamily']}, max = {$arr['cFamily']} WHERE item = 'GIFamily'";
	$upFamily = $this->db->query($sqlF);

	$inc = ( (float)$prc/100 ) + 1.00;

	$sqlEX = "UPDATE budget_feed SET GRP_INS_MONTHLY_EXPENSE = GRP_INS_MONTHLY_EXPENSE * $inc";
	$upExisting = $this->db->query($sqlEX);

	if( $upSingle && $upFamily ){
		return "Update Successful!";
	} else {
		return "An error has occured. Please try again!";
	} // end if
} // end save_group_ins function
/**************************************************/
/***************************************************/
public function insert_table($table,$arr){
	$this->db->insert($table,$arr);
	return $this->db->insert_id();
} // end insert_table function
/**************************************************/
public function update_table($table,$where,$arr){
	$this->db->where($where)->update($table,$arr);
	return $this->db->last_query();
} // end update_table function
/**************************************************/
public function xSQL($sql){
	$this->db->query($sql);
	return $this->db->last_query();
} // end xSQL function
/**************************************************/
/***************************************************/
/***************************************************/
} // end class
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Frontend_Controller {

public function __construct() {
	parent::__construct();
	error_reporting(0); // for production
	parse_str($_SERVER['QUERY_STRING'], $_GET);
	$this->user = $this->session->all_userdata();
} // end constructor
/***************************************************/
/***************************************************/
public function index($view=null) {
	//echo $this->agent->version(); die();
	if($this->user['accessLevel'] != 'admin' && $this->user['accessLevel'] != 'propadmin'):
		$this->load->view('admin/admin_denied');
	// elseif($this->agent->browser() == 'Internet Explorer'):
	// 	redirect('admin/unsupported_browser');
	else:
		if( !$view ){
			$data['allBudgets']  = $this->admin_m->get_all_budgets();
			$data['view_name'] = "admin/components/v_budgets";
		}else{
			switch($view){
				case 'accessgroups':
					$data['allAccessGroups'] = $this->admin_m->get_all_accessgroups();
					$data['view_name'] = "admin/components/v_accessgroups";
					break;
				case 'budgets':
					$data['allBudgets'] = $this->admin_m->get_all_budgets();
					$data['view_name'] = "admin/components/v_budgets";
					break;
				case 'budget_year':
					$data['budgetYear'] = $this->admin_m->get_budget_year();
					$data['view_name'] = "admin/components/v_budget_year";
					break;
				case 'companytypes':
					$data['allCompanyTypes'] = $this->admin_m->get_all_company_types();
					$data['view_name'] = "admin/components/v_companytypes";
					break;
				case 'ez_admin':
					$data['ezAdmin'] = $this->admin_m->get_ez_admin();
					$data['view_name'] = "admin/components/v_ezadmin";
					break;
				case 'fixedassets':
					$data['allFixedAssets'] = $this->admin_m->get_all_fixed_assets();
					$data['view_name'] = "admin/components/v_fixedassets";
					break;
				case 'globals':
					$data['allGlobals'] = $this->admin_m->get_all_globals();
					$data['view_name'] = "admin/components/v_globals";
					break;
				case 'grpins':
					$data['view_name'] = "admin/components/v_grpins";
					break;
				case 'jobcodes':
					$data['allJobCodes'] = $this->admin_m->get_all_job_codes();
					$data['view_name'] = "admin/components/v_jobcodes";
					break;
				case 'recalc_all':
					$data['view_name'] = "admin/components/v_recalc_all";
					break;
				case 'recalc_open':
					$data['view_name'] = "admin/components/v_recalc_open";
					break;
				case 'sam_recalc_all':
					$data['view_name'] = "admin/components/v_recalc_all_sam";
					break;
				case 'sam_recalc_open':
					$data['view_name'] = "admin/components/v_recalc_open_sam";
					break;
				case 'unemployment':
					$data['allStateUnemployment']   = $this->admin_m->get_all_sui();
					$data['view_name'] = "admin/components/v_sui";
					break;
				case 'users':
					$data['allUsers'] = $this->admin_m->get_all_users();
					$data['view_name'] = "admin/components/v_users";
					break;
				case 'wc':
					$data['allWorkersCompensation'] = $this->admin_m->get_all_workers_comp();
					$data['view_name'] = "admin/components/v_wc";
					break;
			} // end switch
		} // end if
		$this->load->view('admin/admin_main',$data);
	endif;
} // end index function
/***************************************************/
/***************************************************/
public function unsupported_browser(){
	echo "Internet Explorer is not currently supported in the Admin area. Please use another browser.";
} // end unsupported-browser function
/***************************************************/
/***************************************************/
public function denied(){
	$this->load->view('admin/admin_denied');
} // end denied function
/***************************************************/
/***************************************************/
public function form($action, $table, $id=null){
	switch($action){
		case 'edit':
			$record = $this->admin_m->fetch_admin_record_edit($id, $table);
			switch($table){
				case 'accessgroups':
					$data['subview'] = $this->load->view('admin/components/form_accessgroups', array('record'=>$record),TRUE);
					break;
				case 'budgets':
					$data['subview'] = $this->load->view('admin/components/form_budgets', array('record'=>$record),TRUE);
					break;
				case 'comType':
					$data['subview'] = $this->load->view('admin/components/form_comType', array('record'=>$record),TRUE);
					break;
				case 'sam_asset_type':
					$data['subview'] = $this->load->view('admin/components/form_sam_asset_type', array('record'=>$record),TRUE);
					break;
				case 'budget_year':
					$data['subview'] = $this->load->view('admin/components/form_budget_year', array('record'=>$record),TRUE);
					break;
				case 'globals':
					$data['subview'] = $this->load->view('admin/components/form_globals', array('record'=>$record),TRUE);
					break;
				case 'jobcodes':
					$data['subview'] = $this->load->view('admin/components/form_jobcodes', array('record'=>$record),TRUE);
					break;
				case 'sui':
					$data['subview'] = $this->load->view('admin/components/form_sui', array('record'=>$record),TRUE);
					break;
				case 'users':
					$data['subview'] = $this->load->view('admin/components/form_users', array('record'=>$record),TRUE);
					break;
				case 'workerscompensationrates':
					$data['subview'] = $this->load->view('admin/components/form_wc', array('record'=>$record),TRUE);
					break;
			} // end switch
			break;
		case 'create':
			switch($table){
				case 'accessgroups':
					$data['subview'] = $this->load->view('admin/components/form_accessgroups_new', array('record'=>$record),TRUE);
					break;
				case 'budgets':
					$data['subview'] = $this->load->view('admin/components/form_budgets_new', array('record'=>$record),TRUE);
					break;
				case 'comTypes':
					$data['subview'] = $this->load->view('admin/components/form_comType_new', array('record'=>$record),TRUE);
					break;
				case 'fixedassets':
					$data['subview'] = $this->load->view('admin/components/form_sam_asset_type_new', array('record'=>$record),TRUE);
					break;
				case 'jobcodes':
					$data['subview'] = $this->load->view('admin/components/form_jobcodes_new', array('record'=>$record),TRUE);
					break;
				case 'sui':
					$data['subview'] = $this->load->view('admin/components/form_sui_new', array('record'=>$record),TRUE);
					break;
				case 'users':
					$data['subview'] = $this->load->view('admin/components/form_users_new', array('record'=>$record),TRUE);
					break;
				case 'wcrates':
					$data['subview'] = $this->load->view('admin/components/form_wc_new', array('record'=>$record),TRUE);
					break;
			} // end switch
			break;
	} // end switch

	$this->load->view('admin/admin_form', $data);
} // end form function
/**************************************************/
/***************************************************/
/**************************************************/
public function recalc_pam_projects($status){
	if ( $status == 'open' ) {
		$open_prop = $this->admin_m->get_open_pam_budgets();
		//print_r($open_prop);die();
		foreach( $open_prop as $op ){
			//echo $op['id'];
			$doit = $this->admin_m->recalc_pam($op['id']);
			//var_dump($doit); die();
			if( $doit ){
				echo $op['name'];
				echo ' <span style="color:#B00400;font-weight:bold;">Complete!</span><br><br>';
			} // endif
		} // end foreach
	} elseif( $status == 'all' ){
		$all_prop = $this->admin_m->get_live_pam_budgets();
		//print_r($all_prop);die();
		foreach( $all_prop as $ap ){
			//echo $ap['id'];
			$doit = $this->admin_m->recalc_pam($ap['id']);
			//var_dump($doit); die();
			if( $doit ){
				echo $ap['name'];
				echo ' <span style="color:#B00400;font-weight:bold;">Complete!</span><br><br>';
			} // endif
		} // end foreach
	} // end if
} // end recalc_pam_projects function
/**************************************************/
public function recalc_pam_single($id){
	$doit = $this->admin_m->recalc_pam($id);
	//var_dump($doit); die();
	redirect('pam_budget/budget/'.$id,'refresh');
} // end recalc_single function
/**************************************************/
public function recalc_sam_projects($status){
	if ( $status == 'open' ) {
		$open_prop = $this->admin_m->get_open_sam_budgets();
		//print_r($open_prop);die();
		foreach( $open_prop as $op ){
			//echo $op['id'];
			$doit = $this->admin_m->recalc_sam($op['id']);
			//var_dump($doit); die();
			if( $doit ){
				echo $op['name'];
				echo ' <span style="color:#B00400;font-weight:bold;">Complete!</span><br><br>';
			} // endif
		} // end foreach
	} elseif( $status == 'all' ){
		$all_prop = $this->admin_m->get_live_sam_budgets();
		//print_r($all_prop); die();
		foreach( $all_prop as $ap ){
			//echo $ap['id'];
			$doit = $this->admin_m->recalc_sam($ap['id']);
			//var_dump($doit); die();
			if( $doit ){
				echo $ap['name'];
				echo ' <span style="color:#B00400;font-weight:bold;">Complete!</span><br><br>';
			} // endif
		} // end foreach
	} // end if
} // end recalc_pam_projects function
/**************************************************/
public function recalc_sam_single($id){
	$doit = $this->admin_m->recalc_sam($id);
	//var_dump($doit); die();
	redirect('sam_budget/atm/'.$id,'refresh');
} // end recalc_sam_single function
/**************************************************/
public function reopen_atm_single($id){
	$this->budget_m->status_set_atm_submitted($id);
	redirect('sam_budget/atm/'.$id);
} // end reopen_atm_single function
/**************************************************/
public function reopen_sam_single($id){
	$this->budget_m->status_set_sam_submitted($id);
	redirect('sam_budget/sam/'.$id);
} // end reopen_sam_single function
/**************************************************/
public function reopen_pam_single($id){
	$this->budget_m->status_set_pam_submitted($id);
	redirect('pam_budget/budget/'.$id);
} // end reopen_single function
/**************************************************/
public function save_record_handler_accessgroups(){
	$id = $this->input->post('id');
	$frmData[access_group] = $this->input->post('access_group');

	$doit = $this->admin_m->update_table('accessgroups',"id = {$id}", $frmData);

	redirect('admin/index','refresh');
} // end save_record_handler_accessgroups function
/**************************************************/
public function save_record_handler_budget_year(){
	$id = $this->input->post('id');
	$frmData['value'] = $this->input->post('value');
	
	$doit = $this->admin_m->update_table('budget_year',"id = {$id}", $frmData);

	redirect('admin/index','refresh');
} // end save_record_handler_budget_year function
/**************************************************/
public function save_record_handler_budgets(){
	//print_r($_POST);
	$id = $this->input->post('id');
	$frmData['name']              = $this->input->post('name');
	$frmData['fiscalStart']       = $this->input->post('fiscalStart');
	$frmData['budget_email']      = $this->input->post('budget_email');
	$frmData['approver_email']    = $this->input->post('approver_email');
	$frmData['cmBonus']           = $this->input->post('cmBonus');
	$frmData['has_ATM']           = $this->input->post('has_ATM');
	$frmData['staffRateByMonth']  = $this->input->post('staffRateByMonth');
	$frmData['CIP_CODE']          = $this->input->post('CIP_CODE');
	$frmData['DEPRECIATION_CODE'] = $this->input->post('DEPRECIATION_CODE');
	$frmData['CAN_ALLOCATE']      = $this->input->post('CAN_ALLOCATE');
	$frmData['companyTypeID']     = $this->input->post('companyTypeID');
	$frmData['accessGroupID']     = $this->input->post('accessGroupID');
	$frmData['emp_state'] = $this->input->post('emp_state');

	$doit = $this->admin_m->update_table('budgets',"id = {$id}", $frmData);

	redirect('admin/index','refresh');
} // end save_record_handler_budgets function
/**************************************************/
public function save_record_handler_comType(){
	$companyTypeID = $this->input->post('companyTypeID');
	$frmData['CompanyType'] = $this->input->post('CompanyType');

	$doit = $this->admin_m->update_table('comType',"companyTypeID = {$companyTypeID}", $frmData);

	redirect('admin/index','refresh');
} // end save_record_handler_comType function
/**************************************************/
public function save_record_handler_globals(){
	$id = $this->input->post('id');
	$frmData['name'] = $this->input->post('name');
	$frmData['value'] = $this->input->post('value');
	$frmData['max'] = $this->input->post('max');

	$doit = $this->admin_m->update_table('globals',"id = {$id}", $frmData);

	redirect('admin/index','refresh');
} // end save_record_handler_globals function
/**************************************************/
public function save_record_handler_jobcodes(){
	// print_r($_POST);die();
	$jobCode = $this->input->post('jobCode');
	$frmData['jobTitle']                    = $this->input->post('jobTitle');
	$frmData['accountCrossReference']       = $this->input->post('accountCrossReference');
	$frmData['Company_Dept']                = $this->input->post('Company_Dept');
	$frmData['[Long-TermDisabilityPremium]']  = $this->input->post('Long-TermDisabilityPremium');
	$frmData['[Short-TermDisabilityPremium]'] = $this->input->post('Short-TermDisabilityPremium');
	$frmData['wcClassCode']                 = $this->input->post('wcClassCode');

	$doit = $this->admin_m->update_table('jobcodes',"jobCode = {$jobCode}", $frmData);

	redirect('admin/index','refresh');
} // end save_record_handler_jobcodes function
/**************************************************/
public function save_record_handler_sam_asset_type(){
	$PROJECT_CODE = $this->input->post('PROJECT_CODE');
	$frmData['ASSET_TYPE']                  = $this->input->post('ASSET_TYPE');
	$frmData['PROJECT_TYPE']                = $this->input->post('PROJECT_TYPE');
	$frmData['ASSET_CLASS']                 = $this->input->post('ASSET_CLASS');
	$frmData['ASSET_CATEGORY']              = $this->input->post('ASSET_CATEGORY');
	$frmData['USEFUL_LIFE']                 = $this->input->post('USEFUL_LIFE');
	$frmData['REAL_PERSONAL']               = $this->input->post('REAL_PERSONAL');
	$frmData['CIP_ACCOUNT_NUMBER']          = $this->input->post('CIP_ACCOUNT_NUMBER');
	$frmData['DEPRECIATION_DEPARTMENT']     = $this->input->post('DEPRECIATION_DEPARTMENT');
	$frmData['DEPRECIATION_ACCOUNT_NUMBER'] = $this->input->post('DEPRECIATION_ACCOUNT_NUMBER');

	$doit = $this->admin_m->update_table('sam_asset_type',"PROJECT_CODE = {$PROJECT_CODE}", $frmData);

	redirect('admin/index','refresh');
} // end save_record_handler_sam_asset_type function
/**************************************************/
public function save_record_handler_sui(){
	$id = $this->input->post('id');
	$frmData['state']   = $this->input->post('state');
	$frmData['SUIrate'] = $this->input->post('SUIrate');
	$frmData['SUIbase'] = $this->input->post('SUIbase');

	$doit = $this->admin_m->update_table('sui',"id = {$id}", $frmData);

	redirect('admin/index','refresh');
} // end save_record_handler_sui function
/**************************************************/
public function save_record_handler_users(){
	$id = $this->input->post('id');
	$frmData['username']      = $this->input->post('username');
	$frmData['user_email']    = $this->input->post('user_email');
	$frmData['defaultBudget'] = $this->input->post('defaultBudget');
	$frmData['accessLevel']   = $this->input->post('accessLevel');
	$frmData['access_group']  = $this->input->post('access_group');
	$frmData['login_user'] = 'edrtrust\\' . $frmData['username'];
	$frmData['password'] = 'password'; 

	$doit = $this->admin_m->update_table('users',"id = {$id}", $frmData);

	redirect('admin/index','refresh');
} // end save_record_handler_users function
/**************************************************/
public function save_record_handler_wcomp(){
	$id = $this->input->post('id');
	$frmData['code']           = $this->input->post('code');
	$frmData['description']    = $this->input->post('description');
	$frmData['ratePerHundred'] = $this->input->post('ratePerHundred');
	$frmData['wcClassCode']    = $this->input->post('wcClassCode');

	$doit = $this->admin_m->update_table('workerscompensationrates',"id = {$id}", $frmData);

	redirect('admin/index','refresh');
} // end save_record_handler_wcomp function
/**************************************************/
public function save_new_record_handler_budgets(){
	//print_r($_POST);die();
	$frmData['id']                = $this->input->post('id');
	$frmData['name']              = $this->input->post('name');
	$frmData['fiscalStart']       = $this->input->post('fiscalStart');
	$frmData['budget_email']      = $this->input->post('budget_email');
	$frmData['approver_email']    = $this->input->post('approver_email');
	$frmData['has_ATM'] = $this->input->post('has_ATM');
	$frmData['pam_status'] = 0;
	$frmData['atm_status'] = 0;
	$frmData['sam_status'] = 0;
	$frmData['cmBonus']           = $this->input->post('cmBonus');
	$frmData['staffRateByMonth']  = $this->input->post('staffRateByMonth');
	$frmData['CIP_CODE']          = $this->input->post('CIP_CODE');
	$frmData['DEPRECIATION_CODE'] = $this->input->post('DEPRECIATION_CODE');
	$frmData['companyTypeID']     = $this->input->post('companyTypeID');
	$frmData['accessGroupID']     = $this->input->post('accessGroupID');
	$frmData['emp_state'] = $this->input->post('emp_state');

	$doit = $this->admin_m->insert_table('budgets', $frmData);

	redirect('admin/index','refresh');
} // end save_new_record_handler_budgets function
/**************************************************/
public function save_new_record_handler_accessgroups(){
	$frmData['access_group'] = $this->input->post('access_group');
	
	$doit = $this->admin_m->insert_table('accessgroups', $frmData);

	redirect('admin/index','refresh');
} // end save_new_record_handler_accessgroups function
/**************************************************/
public function save_new_record_handler_comType(){
	$frmData[CompanyType] = $this->input->post('CompanyType'); 
	
	$doit = $this->admin_m->insert_table('comType', $frmData);

	redirect('admin/index','refresh');
} // end save_new_record_handler_comType function
/**************************************************/
public function save_new_record_handler_jobcodes(){
	$frmData['jobCode']                    = $this->input->post('jobCode');
	$frmData['jobTitle']                    = $this->input->post('jobTitle');
	$frmData['accountCrossReference']       = $this->input->post('accountCrossReference');
	$frmData['Company_Dept']                = $this->input->post('Company_Dept');
	$frmData['[Long-TermDisabilityPremium]']  = $this->input->post('Long-TermDisabilityPremium');
	$frmData['[Short-TermDisabilityPremium]'] = $this->input->post('Short-TermDisabilityPremium');
	$frmData['wcClassCode']                 = $this->input->post('wcClassCode');

	$doit = $this->admin_m->insert_table('jobcodes', $frmData);

	redirect('admin/index','refresh');
} // end save_new_record_handler_jobcodes function
/**************************************************/
public function save_new_record_handler_sam_asset_type(){
	$frmData['PROJECT_CODE']                = $this->input->post('PROJECT_CODE'); 
	$frmData['ASSET_TYPE']                  = $this->input->post('ASSET_TYPE'); 
	$frmData['PROJECT_TYPE']                = $this->input->post('PROJECT_TYPE'); 
	$frmData['ASSET_CLASS']                 = $this->input->post('ASSET_CLASS'); 
	$frmData['ASSET_CATEGORY']              = $this->input->post('ASSET_CATEGORY'); 
	$frmData['USEFUL_LIFE']                 = $this->input->post('USEFUL_LIFE'); 
	$frmData['CIP_ACCOUNT_NUMBER']          = $this->input->post('CIP_ACCOUNT_NUMBER'); 
	$frmData['DEPRECIATION_DEPARTMENT']     = $this->input->post('DEPRECIATION_DEPARTMENT'); 
	$frmData['DEPRECIATION_ACCOUNT_NUMBER'] = $this->input->post('DEPRECIATION_ACCOUNT_NUMBER');

	$doit = $this->admin_m->insert_table('sam_asset_type', $frmData);

	redirect('admin/index','refresh');
} // end save_record_handler_sam_asset_type_new function
/**************************************************/
public function save_new_record_handler_sui(){
	$frmData['state']   = $this->input->post('state'); 
	$frmData['SUIrate'] = $this->input->post('SUIrate'); 
	$frmData['SUIbase'] = $this->input->post('SUIbase');
	
	$doit = $this->admin_m->insert_table('sui', $frmData);

	redirect('admin/index','refresh');
} // end save_new_record_handler_sui function
/**************************************************/
public function save_new_record_handler_users(){
	$frmData['username']      = $this->input->post('username');
	$frmData['user_email']    = $this->input->post('user_email');
	$frmData['defaultBudget'] = $this->input->post('defaultBudget');
	$frmData['accessLevel']   = $this->input->post('accessLevel');
	$frmData['access_group']  = $this->input->post('access_group');
	$frmData['login_user'] = 'edrtrust\\' . $frmData['username'];
	$frmData['password'] = 'password';

	$doit = $this->admin_m->insert_table('users', $frmData);

	redirect('admin/index','refresh');
} // end save_new_record_handler_users function
/**************************************************/
public function save_new_record_handler_wcomp(){
	$frmData['code']           = $this->input->post('code');
	$frmData['description']    = $this->input->post('description');
	$frmData['ratePerHundred'] = $this->input->post('ratePerHundred');
	$frmData['wcClassCode']    = $this->input->post('wcClassCode');

	$doit = $this->admin_m->insert_table('workerscompensationrates', $frmData);

	redirect('admin/index','refresh');
} // end save_new_record_handler_wcomp function
/**************************************************/
/**************************************************/
public function ajax_delete_record(){
	$id = $this->input->post('id');
	$table = $this->input->post('table');
	$curr_year = $this->globals_m->current_year();

	switch( $table ){
		case 'comType':
			$sql = "DELETE FROM comType WHERE companyTypeID = {$id}";
			$doit = $this->admin_m->xSQL($sql);
			break;
		case 'globals':
			$sql = "DELETE FROM globals WHERE year_id = {$curr_year} AND id = {$id}";
			$doit = $this->admin_m->xSQL($sql);
			break;
		case 'jobcodes':
			$sql = "DELETE FROM jobcodes WHERE jobCode = {$id}";
			$doit = $this->admin_m->xSQL($sql);
			break;
		case 'sam_asset_type':
			$sql = "DELETE FROM sam_asset_type WHERE PROJECT_CODE = {$id}";
			$doit = $this->admin_m->xSQL($sql);
			break;
		default:
			$sql = "DELETE FROM {$table} WHERE id = {$id}";
			$doit = $this->admin_m->xSQL($sql);
			break;
	} // end switch

	return true;
} // end ajax_delete_grpins function
/**************************************************/
public function ajax_ez_admin(){
	//print_r($_POST);
	$budget_id = $this->input->post('id');
	$value = $this->input->post('value');
	$software = $this->input->post('type');

	$current = $this->admin_m->get_current_status_by_budget_id($budget_id,$software);

	if( $current == $value ){ return false; }

	switch( $software ){
		case 'pam':
			if( $current == 0 && $value == 1 ){
				$budget = $this->budget_m->get_budget_info($id);

				$this->load->model('hrfeed_m');
				$emps = $this->hrfeed_m->get_department_emps($id);

				if(in_array((int)$budget[0]['companyTypeID'], array(1,2) ) ){
					if( count($emps) > 0){
						foreach($emps as $emp){
							$newbie = $this->budget_m->return_copied_budget($emp, $id);
							$budded = $this->budget_m->budget_corporate($newbie);
						} // end foreach
					} // end if
				} else {
					if( count($emps) > 0){
						foreach($emps as $emp){
							$newbie = $this->budget_m->return_copied_budget($emp, $id); // INSERTS into BUDGET_FEED
							$budded = $this->budget_m->budget_field($newbie); // INSERTS IN PAM_PM_OUT
						} // end foreach
						$propBonus = $this->budget_m->create_staffing_bonus($id);
						$noTurn = $this->budget_m->create_turn_emp($id);
						$noTeam = $this->budget_m->create_streetteam_emp($id);
					} // end if
				} // end if
				$email = $this->email_m->email_open($id,$this->session->userdata('id'),'PAM');
				$this->budget_m->status_set_open($id);
			} // end if
			break;
		case 'atm':
			if( $current == 0 && $value == 1 ){
				$clearit = $this->admin_m->clear_out_atm($budget_id);
				$openit = $this->sam_m->open_atm($budget_id);
				$this->sam_m->status_set_atm_open($budget_id);
				$email = $this->email_m->email_open($budget_id,$this->session->userdata('id'),'ATM');
			} // end if
			break;
		case 'sam':
			if( $current == 0 && $value == 1 ){
				$openit = $this->sam_m->open_sam($budget_id);
				$this->sam_m->status_set_sam_open($budget_id);
				$email = $this->email_m->email_open($budget_id,$this->session->userdata('id'),'SAM');
			} // end if
			break;
	} // end switch

	$sql = "UPDATE budgets SET {$software}_status = {$value} WHERE id = {$budget_id}";
	$doit = $this->admin_m->xSQL($sql);
	return;
} // end ajax_ez_admin function
/**************************************************/
public function ajax_fetch_edit_modal(){
	$id = $this->input->post('id');
	$table = $this->input->post('table');

	$record = $this->admin_m->fetch_admin_record_edit($id, $table);
	switch($table){
		case 'accessgroups':
			$window_title = 'Access Groups';
			$window_form = $this->load->view('admin/components/form_accessgroups', array('record'=>$record),TRUE);
			break;
		case 'budgets':
			$window_title = 'Budget Entities';
			$window_form = $this->load->view('admin/components/form_budgets', array('record'=>$record),TRUE);
			break;
		case 'comType':
			$window_title = 'Company Types';
			$window_form = $this->load->view('admin/components/form_comType', array('record'=>$record),TRUE);
			break;
		case 'globals':
			$window_title = 'Application Globals';
			$window_form = $this->load->view('admin/components/form_globals', array('record'=>$record),TRUE);
			break;
		case 'jobcodes';
			$window_title = 'Job Codes';
			$window_form = $this->load->view('admin/components/form_jobcodes', array('record'=>$record),TRUE);
			break;
		case 'sam_asset_type':
			$window_title = 'Fixed Assets';
			$window_form = $this->load->view('admin/components/form_sam_asset_type', array('record'=>$record),TRUE);
			break;
		case 'sui':
			$window_title = 'State Unemployment';
			$window_form = $this->load->view('admin/components/form_sui', array('record'=>$record),TRUE);
			break;
		case 'users':
			$window_title = 'Authorized Users';
			$window_form = $this->load->view('admin/components/form_users', array('record'=>$record,'user'=>$this->user),TRUE);
			break;
		case 'workerscompensationrates':
			$window_title = 'Workers Compensation Rates';
			$window_form = $this->load->view('admin/components/form_wc', array('record'=>$record),TRUE);
			break;
	} // end switch

	$retHTML = '<div class="modal-header">';
	$retHTML .= '<h3 id="myModalLabel">';
	$retHTML .= $window_title;
	$retHTML .= '</h3></div><div class="modal-body"><p>';
	$retHTML .= $window_form;
	$retHTML .= '</p></div>';
	$retHTML .= '<div class="modal-footer">';
	$retHTML .= '<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>';
	//$retHTML .= '<button class="btn btn-edr btnSaveModalChanges">Save changes</button>':
	$retHHML .= '</div>';
	echo $retHTML;
} // end ajax_fetch_edit_modal function
/**************************************************/
public function ajax_fetch_new_modal(){
	$section = $this->input->post('section');
	switch($section){
		case 'accessgroups':
			$window_title = 'Access Groups';
			$window_form = $this->load->view('admin/components/form_accessgroups_new', array(),TRUE);
			break;
		case 'budgets':
			$window_title = 'Budget Entities';
			$window_form = $this->load->view('admin/components/form_budgets_new', array(),TRUE);
			break;
		case 'company_types':
			$window_title = 'Company Types';
			$window_form = $this->load->view('admin/components/form_comType_new', array(),TRUE);
			break;
		case 'fixed_assets':
			$window_title = 'Fixed Assets';
			$window_form = $this->load->view('admin/components/form_sam_asset_type_new', array(),TRUE);
			break;
		case 'job_codes';
			$window_title = 'Job Codes';
			$window_form = $this->load->view('admin/components/form_jobcodes_new', array(),TRUE);
			break;
		case 'state_unemployment':
			$window_title = 'State Unemployment';
			$window_form = $this->load->view('admin/components/form_sui_new', array(),TRUE);
			break;
		case 'users':
			$window_title = 'Authorized Users';
			$window_form = $this->load->view('admin/components/form_users_new', array('user'=>$this->user),TRUE);
			break;
		case 'workers_compensation':
			$window_title = 'Workers Compensation Rates';
			$window_form = $this->load->view('admin/components/form_wc_new', array(),TRUE);
			break;
	} // end switch

	$retHTML = '<div class="modal-header">';
	$retHTML .= '<h3 id="myModalLabel">';
	$retHTML .= $window_title;
	$retHTML .= '</h3></div><div class="modal-body"><p>';
	$retHTML .= $window_form;
	$retHTML .= '</p></div>';
	$retHTML .= '<div class="modal-footer">';
	$retHTML .= '<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>';
	//$retHTML .= '<button class="btn btn-edr btnSaveModalChanges">Save changes</button>';
	$retHTML .= '</div>';
	echo $retHTML;
} // end ajax_fetch_new_modal function
/**************************************************/
public function ajax_fetch_reject_form(){
	$data['id'] = $this->input->post('id');

	if ( $data['id'] != '' ) {
		$msg = $this->load->view('pam/inc/form_reject_pam', $data, TRUE);
		echo $msg;
	} else {
		echo 'AJAX is not performing!';
	} // end if
} // end ajax_fetch_reject_form function
/**************************************************/
public function ajax_fetch_reject_atm_form(){
	$data['id'] = $this->input->post('id');

	if ( $data['id'] != '' ) {
		$msg = $this->load->view('sam/inc/form_reject_atm', $data, TRUE);
		echo $msg;
	} else {
		echo 'AJAX is not performing!';
	} // end if
} // end ajax_fetch_reject_form function
/**************************************************/
public function ajax_fetch_reject_sam_form(){
	$data['id'] = $this->input->post('id');

	if ( $data['id'] != '' ) {
		$msg = $this->load->view('sam/inc/form_reject_sam', $data, TRUE);
		echo $msg;
	} else {
		echo 'AJAX is not performing!';
	} // end if
} // end ajax_fetch_reject_form function
/**************************************************/
public function ajax_recalc_pam_projects(){
	$status = $this->input->post('status');
	$curr_year = $this->globals_m->current_year();
	$curr_date = date('Y-m-d');

	if ( $status == 'open' ) {
		$open_prop = $this->admin_m->get_open_pam_budgets();
		//print_r($open_prop);die();
		foreach( $open_prop as $op ){
			$buddy = $this->budget_m->get_bud_info($op['id']);
			echo "<b>" . $buddy[0]['name'] . "</b>";
			$doit = $this->admin_m->recalc_pam($op['id']);
			// print_r($doit); die();
			if( $doit ){
				echo ' -- <span style="color:#B00400;font-weight:bold;">Complete!</span><br><br>';
			} else{
				echo " -- <span style='color:#B00400;font-weight:bold;''>No Employees To Budget.</span><br><br>";
			} // endif
		} // end foreach
	} elseif( $status == 'all' ){
		$all_prop = $this->admin_m->get_live_pam_budgets();
		foreach( $all_prop as $ap ){
			$buddy = $this->budget_m->get_bud_info($ap['id']);
			echo "<b>" . $buddy[0]['name'] . "</b>";
			$doit = $this->admin_m->recalc_pam($ap['id']);
			if( $doit ){
				echo ' -- <span style="color:#B00400;font-weight:bold;">Complete!</span><br><br>';
			} else{
				echo " -- <span style='color:#B00400;font-weight:bold;''>No Employees To Budget.</span><br><br>";
			} // endif
		} // end foreach
	} else {
		echo 'AJAX is not performing!';
	} // end if
} // end ajax_get_all_open_projects function
/**************************************************/
public function ajax_recalc_sam_projects(){
	$status = $this->input->post('status');
	//echo $status; die();

	$CY = $this->globals_m->current_year();
	$curr_date = date('Y-m-d');

	if( $status ){
		if ( $status == 'open' ):
			$open_prop = $this->admin_m->get_open_sam_budgets();
			//print_r($open_prop);
			foreach( $open_prop as $op ){
				$buddy = $this->budget_m->get_bud_info($op['id']);
				//print_r($buddy);
				echo "<b>" . $buddy[0]['name'] . "</b>";
				$hasProj = $this->admin_m->get_project_count($op['id']);
				if((int)$hasProj == 0):
					echo "<span style='color:#B00400;font-weight:bold;''>&nbsp;&nbsp;--&nbsp;&nbsp;No Projects Found!</span>";
				else:
					$doit = $this->admin_m->recalc_sam($op['id']);
				endif;
				echo "<br><br>";
			} // end foreach
		elseif( $status == 'all' ):
			$all_prop = $this->admin_m->get_live_sam_budgets();
			//print_r($all_prop);
			foreach( $all_prop as $ap ){
				$buddy = $this->budget_m->get_bud_info($ap['id']);
				//print_r($buddy);
				echo "<b>" . $buddy[0]['name'] . "</b>";
				$hasProj = $this->admin_m->get_project_count($ap['id']);
				if((int)$hasProj == 0):
					echo "<span style='color:#B00400;font-weight:bold;''>&nbsp;&nbsp;--&nbsp;&nbsp;No Projects Found!</span>";
				else:
					$doit = $this->admin_m->recalc_sam($ap['id']);
				endif;
				echo "<br><br>";
			} // end foreach
		endif;
	} else {
		echo 'AJAX is not performing!';
	} // end if
} // end ajax_get_all_open_projects function
/**************************************************/
public function ajax_save_grpins(){
	$percent = $this->input->post('percent');
	$frmData['cSingle'] = $this->input->post('cSingle');
	$frmData['aSingle'] = $this->input->post('aSingle');
	$frmData['cFamily'] = $this->input->post('cFamily');
	$frmData['aFamily'] = $this->input->post('aFamily');

	if ( count($frmData) == 4 ) {
		$msg = $this->admin_m->save_group_ins($frmData,$percent);
		$recalcule = $this->recalc_pam_projects('open');
		echo $msg;
	} else {
		echo 'AJAX is not performing!';
	} // end if
} // end ajax_save_grpins function
/**************************************************/
/**************************************************/
/***************************************************/
} // end class

/* End of file pam_user.php */
/* Location: ./application/controllers/pam_user.php */
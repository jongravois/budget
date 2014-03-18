<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sam_budget extends Frontend_Controller {

public function __construct() {
	parent::__construct();
	error_reporting(0); // for production
	parse_str($_SERVER['QUERY_STRING'], $_GET);
	$this->user = $this->session->all_userdata();
} // end constructor
/***************************************************/
/***************************************************/
public function index($val = null) {
	if(!isset($val)){
		$primaryBudget = $this->budget_m->get($this->user['default_budget']);
	} else {
		$primaryBudget = $this->budget_m->get($val);
	} // end if
	// echo "<pre>"; print_r($primaryBudget); echo "</pre>"; die();
	
	if($this->user['accessLevel'] == "user"):
		if($primaryBudget->has_ATM == 1){
			$this->load->view('sam/atm', array(
		        'user' => $this->user,
		        'budgets' => NULL,
		        'primary' => $primaryBudget
		    ));
		} else {
			$this->load->view('sam/sam', array(
		        'user' => $this->user,
		        'budgets' => NULL,
		        'primary' => $primaryBudget
		    ));
		} // end if
	elseif($this->user['accessLevel'] == "superuser"):
		$accessGroup = $this->user['access_group'];
		$budgets_avail = $this->budget_m->get_possible_budgets($accessGroup);
		//echo "<pre>"; print_r($primaryBudget); echo "</pre>"; die();
		// echo "<pre>"; print_r($budgets_avail); echo "</pre>"; die();
		
		if((int)$primaryBudget->hasATM == 1){
			$this->load->view('sam/atm', array(
		        'user' => $this->user,
		        'budgets' => $budgets_avail,
		        'primary' => $primaryBudget
		    ));
		} else {
			$this->load->view('sam/sam', array(
		        'user' => $this->user,
		        'budgets' => $budgets_avail,
		        'primary' => $primaryBudget
		    ));
		} // end if
	else:
		redirect('sam_budget/dashboard', 'refresh');
	endif;
} // end index
/***************************************************/
/***************************************************/
public function budget($val = null, $ast = null){
	if( !isset($val) ):
		$primaryBudget = $this->budget_m->get($this->user['default_budget']);
	else:
		$primaryBudget = $this->budget_m->get($val);
	endif;

	if( isset($ast) ):
		$assets = array('asset_code' => $ast );
	else:
		$assets = array();
	endif;

	if( $primaryBudget->has_ATM == 1):
		$arrTotals['asset_total'] = $this->sam_m->get_asset_total($val,$ast);
		$arrTotals['budgeted'] = $this->sam_m->get_cy_budget_for_asset($val, $ast);
		$arrTotals['remaining'] = (float)$arrTotals['budgeted'] - (float)$arrTotals['asset_total'];
	else:
		$arrTotals['budgeted'] = -999;
	endif;

	//print_r($assets); die();
		
	$this->load->view('sam/budget', array(
        'user' => $this->user,
        'primary' => $primaryBudget,
        'assets' => $assets,
        'asset_totals' => $arrTotals
    ));
} // end budget function
/**************************************************/
public function sam($val=null){
	if( !isset($val) ):
		$primaryBudget = $this->budget_m->get($this->user['default_budget']);
	else:
		$primaryBudget = $this->budget_m->get($val);
	endif;

	if( (int)$primaryBudget->has_ATM == 1):
		redirect('sam_budget/atm/'.$val, 'refresh');
	else:
		$this->load->view('sam/sam', array(
	        'user' => $this->user,
	        'primary' => $primaryBudget,
	        'assets' => $assets
	    ));
	endif;
} // end sam function
/**************************************************/
/***************************************************/
public function atm($val = null){
	if( !isset($val) ):
		$val = "300000";
		$primaryBudget = $this->budget_m->get($this->user['default_budget']);
	else:
		$primaryBudget = $this->budget_m->get($val);
	endif;

	if( (int)$primaryBudget->has_ATM == 0):
		redirect('sam_budget/sam/'.$val, 'refresh');
	else: 
		$this->load->view('sam/atm', array(
	        'user' => $this->user,
	        'primary' => $primaryBudget
	    ));
	endif;
} // end budget function
/**************************************************/
/**************************************************/
public function dashboard(){
	$user = $this->session->all_userdata();
	$budgets = $this->budget_m->return_user_budgets($user);
	
	$tabs = array();
	if(!isset($budgets[0])){ $budgets[0] = array(null); } else { $tabs['norm'] = 1; }
	if(!isset($budgets[1])){ $budgets[1] = array(null); } else { $tabs['other'] = 1; }
 	if(!isset($budgets[2])){ $budgets[2] = array(null); } else { $tabs['departments'] = 1; }

	$this->load->view('sam/dashboard', array(
		'user'              => $user,
		'tabs'              => $tabs,
		'fiscal_norm'       => $budgets[0],
		'fiscal_other'      => $budgets[1],
		'fiscal_department' => $budgets[2]
    ));
} // end dashboard function
/**************************************************/
/**************************************************/
public function open_budget($id){
	$bud = $this->budget_m->get_one_budget($id);

	if( (int) $bud[0]['companyTypeID'] > 2){
		redirect('sam_budget/open_company_budget/'.$id,'refresh');
	} else {
		redirect('sam_budget/open_department_budget/'.$id,'refresh');
	} // end if
} // end open_budget function
/**************************************************/
public function open_company_budget($id){
	$budget = $this->budget_m->get_bud_info($id);

	if( $budget[0]['has_ATM'] == 1 ):
		$openit = $this->sam_m->open_atm($id);
		$this->sam_m->status_set_atm_open($id);
	endif;

	$openhim = $this->sam_m->open_sam($id);
	//print_r($openhim); die();

	$this->sam_m->status_set_sam_open($id);

	$email = $this->email_m->email_open($id,$this->session->userdata('id'),'SAM');

	redirect('sam_budget/atm/'.$id, 'refresh');
} // end open_company_budget function
/**************************************************/
public function open_department_budget($id){
	$openit = $this->sam_m->open_atm($id);
	$this->sam_m->status_set_sam_open($id);
	$email = $this->email_m->email_open($id,$this->session->userdata('id'),'SAM');
	redirect('sam_budget/budget/'.$id, 'refresh');
} // end open_department_budget function
/**************************************************/
/**************************************************/
public function atm_add_asset($id){
	$data['primary'] = $this->budget_m->get($id);
	$data['user'] = $this->user;
	$data['assetDD'] = $this->sam_m->get_new_asset_dd($id);
	$this->load->view('sam/sam_new_asset', $data);
} // end atm_add_asset function
/**************************************************/
public function atm_edit_project_handler(){
	//print_r($_POST); die();
	$id = $this->input->post('project_id');
	$bid = $this->input->post('budget_id');
	$project = $this->sam_m->get_project_info($id);
	$pid = substr($project[0]['SAM_PROJECT'],-2);
	//print_r($project); die();
	
	$frmData['YEAR_ID'] = $this->globals_m->current_year();
	$frmData['SAM_DESCRIPTION'] = $this->input->post('sam_description');
	$frmData['P1'] = $this->input->post('SAM_P_1');
	$frmData['P2'] = $this->input->post('SAM_P_2');
	$frmData['P3'] = $this->input->post('SAM_P_3');
	$frmData['P4'] = $this->input->post('SAM_P_4');
	$frmData['P5'] = $this->input->post('SAM_P_5');
	$frmData['P6'] = $this->input->post('SAM_P_6');
	$frmData['P7'] = $this->input->post('SAM_P_7');
	$frmData['P8'] = $this->input->post('SAM_P_8');
	$frmData['P9'] = $this->input->post('SAM_P_9');
	$frmData['P10'] = $this->input->post('SAM_P_10');
	$frmData['P11'] = $this->input->post('SAM_P_11');
	$frmData['P12'] = $this->input->post('SAM_P_12');
	$frmData['ASSET_NOTES'] = $this->input->post('sam_notes');

	$doit = $this->sam_m->save_edited_project($id, $frmData);

	// UPDATE SAM_OUT
	$pmoutit = $this->sam_m->save_to_sam_pm_out($id, $pid, $bid, $frmData, 'update');

	echo "<pre>"; print_r($pmoutit); echo "</pre>"; die();
	
	redirect('sam_budget/budget/'.$bid . '/' . $asset_code,'refresh');
} // end atm_edit_project_handler function
/**************************************************/
public function atm_new_asset_handler(){
	//print_r($_POST); die();
	$budget_id = $this->input->post('budget_id');
	$ASSET_ID = $this->input->post('ASSET_ID');
	$cy_dollars = $this->input->post('cy_dollars');

	$doit = $this->sam_m->new_asset_to_list($budget_id,$ASSET_ID,$cy_dollars);
	//var_dump($doit);
	redirect('sam_budget/atm/'.$budget_id, 'refresh');
} // end atm_new_asset_handler function
/**************************************************/
public function atm_new_project_handler(){
	//print_r($_POST);die();

	$asset = $this->sam_m->get_asset_by_id($this->input->post('asset'));
	$budget_id = $this->input->post('budget_id');
	$de_id = substr($budget_id,-2);
	if( $de_id == '00'){ $de_id = 99; } else { $de_id = (int)$de_id; } // end if

	$frmData['YEAR_ID'] = $this->globals_m->current_year();
    $frmData['ASSET_ID'] = $asset[0]['PROJECT_CODE'];
    $frmData['COMPANY_ID'] = substr($budget_id,0,3);
    $frmData['DEPARTMENT_ID'] = $de_id;
    $frmData['SAM_ASSET'] = $asset[0]['ASSET_TYPE'];
    $frmData['SAM_DESCRIPTION'] = $this->input->post('sam_description');
    $frmData['SAM_PROJECT'] = '20' . $frmData['YEAR_ID'] . '-' . $frmData['ASSET_ID'];
    $frmData['SAM_TYPE'] = $asset[0]['PROJECT_TYPE'];
    $frmData['P1'] = ( $this->input->post('SAM_P_1') ? $this->input->post('SAM_P_1') : 0);
    $frmData['P2'] = ( $this->input->post('SAM_P_2') ? $this->input->post('SAM_P_2') : 0);
    $frmData['P3'] = ( $this->input->post('SAM_P_3') ? $this->input->post('SAM_P_3') : 0);
    $frmData['P4'] = ( $this->input->post('SAM_P_4') ? $this->input->post('SAM_P_4') : 0);
    $frmData['P5'] = ( $this->input->post('SAM_P_5') ? $this->input->post('SAM_P_5') : 0);
    $frmData['P6'] = ( $this->input->post('SAM_P_6') ? $this->input->post('SAM_P_6') : 0);
    $frmData['P7'] = ( $this->input->post('SAM_P_7') ? $this->input->post('SAM_P_7') : 0);
    $frmData['P8'] = ( $this->input->post('SAM_P_8') ? $this->input->post('SAM_P_8') : 0);
    $frmData['P9'] = ( $this->input->post('SAM_P_9') ? $this->input->post('SAM_P_9') : 0);
    $frmData['P10'] = ( $this->input->post('SAM_P_10') ? $this->input->post('SAM_P_10') : 0);
    $frmData['P11'] = ( $this->input->post('SAM_P_11') ? $this->input->post('SAM_P_11') : 0);
    $frmData['P12'] = ( $this->input->post('SAM_P_12') ? $this->input->post('SAM_P_12') : 0);
    $frmData['ASSET_NOTES'] = $this->input->post('sam_notes');

    $doit = $this->sam_m->save_new_project($frmData);

    // INSERT SAM_OUT
    $pmoutit = $this->sam_m->save_to_sam_pm_out($doit, $frmData['ASSET_ID'], $budget_id, $frmData, 'insert');

    redirect('sam_budget/budget/' . $budget_id . '/' . $frmData['ASSET_ID'], 'refresh');
} // end atm_new_handler function
/**************************************************/
public function sam_edit_project_handler(){
	//print_r($_POST); die();
	$id = $this->input->post('project_id');
	$bid = $this->input->post('budget_id');
	$project = $this->sam_m->get_project_info($id);
	// print_r($project); die();
	$pid = substr($project[0]['SAM_PROJECT'],-2);
	
	$frmData['YEAR_ID'] = $this->globals_m->current_year();
	$frmData['SAM_DESCRIPTION'] = $this->input->post('sam_description');
	$frmData['P1'] = $this->input->post('SAM_P_1');
	$frmData['P2'] = $this->input->post('SAM_P_2');
	$frmData['P3'] = $this->input->post('SAM_P_3');
	$frmData['P4'] = $this->input->post('SAM_P_4');
	$frmData['P5'] = $this->input->post('SAM_P_5');
	$frmData['P6'] = $this->input->post('SAM_P_6');
	$frmData['P7'] = $this->input->post('SAM_P_7');
	$frmData['P8'] = $this->input->post('SAM_P_8');
	$frmData['P9'] = $this->input->post('SAM_P_9');
	$frmData['P10'] = $this->input->post('SAM_P_10');
	$frmData['P11'] = $this->input->post('SAM_P_11');
	$frmData['P12'] = $this->input->post('SAM_P_12');
	$frmData['ASSET_NOTES'] = $this->input->post('sam_notes');
	//print_r($frmData); die();
	//print_r($id); die();

	$doit = $this->sam_m->save_edited_project($id, $frmData);

	// UPDATE SAM_OUT
	$pmoutit = $this->sam_m->save_to_sam_pm_out($id, $pid, $bid, $frmData, 'update');

	//echo "<pre>"; print_r($pmoutit); echo "</pre>"; die();
	
	redirect('sam_budget/sam/'.$bid,'refresh');
} // end sam_edit_project_handler function
/**************************************************/
public function sam_new_project_handler(){
	//print_r($_POST);die();

	$asset = $this->sam_m->get_asset_by_id($this->input->post('ASSET_ID'));
	//print_r($asset);die();
	
	$budget_id = $this->input->post('budget_id');
	$de_id = substr($budget_id,-2);
	if( $de_id == '00'){ $de_id = 99; } else { $de_id = (int)$de_id; } // end if

	$frmData['YEAR_ID'] = $this->globals_m->current_year();
    $frmData['ASSET_ID'] = $asset[0]['PROJECT_CODE'];
    $frmData['COMPANY_ID'] = substr($budget_id,0,3);
    $frmData['DEPARTMENT_ID'] = $de_id;
    $frmData['SAM_ASSET'] = $asset[0]['ASSET_TYPE'];
    $frmData['SAM_DESCRIPTION'] = $this->input->post('sam_description');
    $frmData['SAM_PROJECT'] = '20' . $frmData['YEAR_ID'] . '-' . $frmData['ASSET_ID'];
    $frmData['SAM_TYPE'] = $asset[0]['PROJECT_TYPE'];
    $frmData['P1'] = ( $this->input->post('SAM_P_1') ? $this->input->post('SAM_P_1') : 0);
    $frmData['P2'] = ( $this->input->post('SAM_P_2') ? $this->input->post('SAM_P_2') : 0);
    $frmData['P3'] = ( $this->input->post('SAM_P_3') ? $this->input->post('SAM_P_3') : 0);
    $frmData['P4'] = ( $this->input->post('SAM_P_4') ? $this->input->post('SAM_P_4') : 0);
    $frmData['P5'] = ( $this->input->post('SAM_P_5') ? $this->input->post('SAM_P_5') : 0);
    $frmData['P6'] = ( $this->input->post('SAM_P_6') ? $this->input->post('SAM_P_6') : 0);
    $frmData['P7'] = ( $this->input->post('SAM_P_7') ? $this->input->post('SAM_P_7') : 0);
    $frmData['P8'] = ( $this->input->post('SAM_P_8') ? $this->input->post('SAM_P_8') : 0);
    $frmData['P9'] = ( $this->input->post('SAM_P_9') ? $this->input->post('SAM_P_9') : 0);
    $frmData['P10'] = ( $this->input->post('SAM_P_10') ? $this->input->post('SAM_P_10') : 0);
    $frmData['P11'] = ( $this->input->post('SAM_P_11') ? $this->input->post('SAM_P_11') : 0);
    $frmData['P12'] = ( $this->input->post('SAM_P_12') ? $this->input->post('SAM_P_12') : 0);
    $frmData['ASSET_NOTES'] = $this->input->post('sam_notes');
    //print_r($frmData); die();

    $doit = $this->sam_m->save_new_project($frmData);
    //print_r($doit);die();

    // INSERT SAM_OUT
    $pmoutit = $this->sam_m->save_to_sam_pm_out($doit, $asset[0]['PROJECT_CODE'], $budget_id, $frmData, 'insert');
    
    redirect('sam_budget/sam/' . $budget_id, 'refresh');
} // end sam_new_handler function
/**************************************************/
public function select_diff_budget(){
	// print_r($_POST);die();
	$newBudget = $this->input->post('newBudget');
	redirect('sam_budget/index/'.$newBudget);
} // end select_diff_budget function
/**************************************************/
public function timeline_edit_handler(){
	//print_r($_POST); die();
	$CY = $this->globals_m->current_year();
	$current_year = (int) '20' . $CY;
	list($budget_id, $asset_code) = explode('|', $this->input->post('bud_id_asset'));
	$co_id = (int)substr($budget_id,0,3);
	$de_id = substr($budget_id,-2);
	if( $de_id == '00'){ $de_id = 99; } else { $de_id = (int)$de_id; } // end if
	
	//$yr[0] = (int)$current_year;
	//$note[0]   = $this->input->post('notes_Y6');
	//$data[0] = $this->input->post('proj_total_Y6');
	$yr[1] = (int)$current_year+1;
	$note[1] = $this->input->post('notes_Y7');
	$data[1] = $this->input->post('proj_total_Y7');
	$yr[2] = (int)$current_year+2;
	$note[2] = $this->input->post('notes_Y8');
	$data[2] = $this->input->post('proj_total_Y8');
	$yr[3] = (int)$current_year+3;
	$note[3] = $this->input->post('notes_Y9');
	$data[3] = $this->input->post('proj_total_Y9');
	$yr[4] = (int)$current_year+4;
	$note[4] = $this->input->post('notes_Y10');
	$data[4] = $this->input->post('proj_total_Y10');

	for( $y=0; $y<5; $y++){
		$dataNotes['COMPANY_ID'] = $co_id;
		$dataNotes['DEPARTMENT_ID'] = $de_id;
		$dataNotes['ASSET_ID'] = $asset_code;
		$dataNotes['BUDGET_YEAR'] = $yr[$y];
		$dataNotes['[NOTE]'] = $note[$y];
		$doNotes = $this->sam_m->save_tenyear_note($dataNotes);
	} // end for
	
	for( $y=0; $y<5; $y++){
		$dataAmount['COMPANY_ID'] = $co_id;
		$dataAmount['YEAR_ID'] = $CY;
		$dataAmount['DEPARTMENT_ID'] = $de_id;
		$dataAmount['PROJECT_CODE'] = $asset_code;
		$dataAmount['BUDGET_YEAR'] = $yr[$y];
		$dataAmount['AMOUNT'] = (float)$data[$y];
		$doAmount = $this->sam_m->save_tenyear_projection($dataAmount);
	} // end for

	redirect('sam_budget/atm/'.$budget_id,'refresh');
} // end timeline_edit_handler function
/**************************************************/
/**************************************************/
public function approve_atm(){
	// TODO: CREATE FUNCTION
	echo "This has to be coded!";
} // end approve_atm function
/**************************************************/
public function approve_budget(){
	// TODO: CREATE FUNCTION
	echo "This has to be coded!";
} // end approve_budget function
/**************************************************/
public function archive_budget(){
	// TODO: CREATE FUNCTION
	echo "This has to be coded!";
} // end archive_budget function
/**************************************************/
public function manager_submit(){
	// TODO: CREATE FUNCTION
	echo "This has to be coded!";
} // end manager_submit function
/**************************************************/
public function reject_budget(){
	// TODO: CREATE FUNCTION
	echo "This has to be coded!";
} // end reject_budget function
/**************************************************/
public function reopen_budget(){
	// TODO: CREATE FUNCTION
	echo "This has to be coded!";
} // end reopen_budget function
/**************************************************/
public function z_atm_approved($id){
	$this->budget_m->status_set_atm_approved($id);

	// email code
	$email = $this->email_m->email_approved($id,$this->session->userdata('id'),'ATM');

	redirect('sam_budget/atm/'.$id);
} // end z_atm_approved function
/**************************************************/
public function z_atm_rejected(){
	$id = $this->input->post('budget');
	$reason = $this->input->post('reason');

	$this->budget_m->status_set_atm_open($id);

	// email code
	$email = $this->email_m->email_rejected($id,$this->session->userdata('id'),'ATM', $reason);

	redirect('sam_budget/atm/'.$id);
} // end z_atm_rejected function
/**************************************************/
public function z_atm_submit_for_approval($id){
	$this->budget_m->status_set_atm_submitted($id);

	// email code
	$email = $this->email_m->email_submitted($id,$this->session->userdata('id'),'ATM');

	//echo $email;die();

	redirect('sam_budget/atm/'.$id);
} // end z_atm_submit_for_approval function
/**************************************************/
public function z_sam_approved($id){
	$this->budget_m->status_set_sam_approved($id);

	// email code
	$email = $this->email_m->email_approved($id,$this->session->userdata('id'),'SAM');

	//echo $email;die();

	redirect('sam_budget/sam/'.$id);
} // end z_sam_approved function
/**************************************************/
public function z_sam_rejected($id=null){
	if( !$id ){ $id = $this->input->post('budget'); }
	$reason = $this->input->post('reason');

	$this->budget_m->status_set_sam_open($id);

	// email code
	$email = $this->email_m->email_rejected($id,$this->session->userdata('id'),'SAM', $reason);

	redirect('sam_budget/sam/'.$id);
} // end z_atm_rejected function
/**************************************************/
public function z_sam_submit_for_approval($id){
	$this->budget_m->status_set_sam_submitted($id);

	// email code
	$email = $this->email_m->email_submitted($id,$this->session->userdata('id'),'SAM');

	//echo $email;die();

	redirect('sam_budget/sam/'.$id);
} // end z_atm_submit_for_approval function
/**************************************************/
/**************************************************/
public function ajax_atm_delete_project(){
	$project_id = $this->input->post('id');
	$budget_id = $this->sam_m->get_budget_id_from_project($project_id);
	$doit = $this->sam_m->delete_sam_project($project_id);
	
	// ZERO OUT PROJECT IN SAM_OUT
	$pmoutit = $this->sam_m->save_to_sam_pm_out($project_id, $budget_id, $frmData, 'delete');
	return true;
} // end ajax_sam_delete_project function
/**************************************************/
public function ajax_atm_edit_current(){
	$CY = $this->globals_m->current_year();
	$budget_id = $this->input->post('budget_id');
	$asset_code = $this->input->post('asset_code');
	$value = $this->input->post('value');

	//check CY allocation for asset_code
	$total = $this->sam_m->ajax_get_atm_total_by_asset($budget_id, $asset_code, $CY);
	
	//if less allow
	if( (float)$total > (float)$value){
		echo $total;
	} else {
		echo "OK";
	} // end if
} // end ajax_atm_edit_current function
/*-----------------------------------------------------*/
public function ajax_atm_edit_project(){
	$CY = $this->globals_m->current_year();
	$proj_id = $this->input->post('projID');
	$data['project'] = $this->sam_m->get_project_info($proj_id);

	if( (int)$data['project'][0]['DEPARTMENT_ID'] == 99){
		$budget_id = $data['project'][0]['COMPANY_ID'] . '000';
	} else {
		$budget_id = $data['project'][0]['COMPANY_ID'] . '0' . $data['project'][0]['DEPARTMENT_ID'];
	} // end if

	$asset_code = substr($data['project'][0]['SAM_PROJECT'],-2);
	$data['cyProj'] = $this->sam_m->get_sam_cy_projection($budget_id,$asset_code);
	$data['cyBudgeted'] = $this->sam_m->get_sam_cy_asset_budgeted($budget_id,$asset_code);
	$data['projBudgeted'] = $this->sam_m->get_sam_proj_budgeted($budget_id, $asset_code,$proj_id);
	$data['remnant'] = (float)$data['cyProj'][0]['AMOUNT'] - (float)$data['cyBudgeted'][0]['budgeted'] + (float)$data['projBudgeted'];

	$retHTML = $this->load->view('sam/inc/view_atm_single_edit', $data, true);
	echo $retHTML;
} // end ajax_sam_edit_project function
/**************************************************/
public function ajax_atm_view_project(){
	$CY = $this->globals_m->current_year();
	$proj_id = $this->input->post('projID');
	$data['project'] = $this->sam_m->get_project_info($proj_id);

	if( (int)$data['project'][0]['DEPARTMENT_ID'] == 99){
		$budget_id = $data['project'][0]['COMPANY_ID'] . '000';
	} else {
		$budget_id = $data['project'][0]['COMPANY_ID'] . '0' . $data['project'][0]['DEPARTMENT_ID'];
	} // end if

	$asset_code = substr($data['project'][0]['SAM_PROJECT'],-2);
	$data['cyProj'] = $this->sam_m->get_sam_cy_projection($budget_id,$asset_code);
	$data['cyBudgeted'] = $this->sam_m->get_sam_cy_asset_budgeted($budget_id,$asset_code);
	$data['remnant'] = (float)$data['cyProj'][0]['20'.$CY] - (float)$data['cyBudgeted'][0]['budgeted'];
	
	$retHTML = $this->load->view('sam/inc/view_atm_single_view', $data, true);
	echo $retHTML;
} // end ajax_atm_view_project function
/**************************************************/
public function ajax_sam_delete_project(){
	$project_id = $this->input->post('id');
	$budget_id = $this->sam_m->get_budget_id_from_project($project_id);
	$doit = $this->sam_m->delete_sam_project($project_id);
	
	// ZERO OUT PROJECT IN SAM_OUT
	$pmoutit = $this->sam_m->save_to_sam_pm_out($project_id, $budget_id, $frmData, 'delete');
	return true;
} // end ajax_sam_delete_project function
/**************************************************/
public function ajax_sam_edit_project(){
	$proj_id = $this->input->post('projID');
	$data['project'] = $this->sam_m->get_project_info($proj_id);

	if( (int)$data['project'][0]['DEPARTMENT_ID'] == 99){
		$budget_id = $data['project'][0]['COMPANY_ID'] . '000';
	} else {
		$budget_id = $data['project'][0]['COMPANY_ID'] . '0' . $data['project'][0]['DEPARTMENT_ID'];
	} // end if

	$asset_code = substr($data['project'][0]['SAM_PROJECT'],-2);
	$data['cyProj'] = $this->sam_m->get_sam_cy_projection($budget_id,$asset_code);
	$data['cyBudgeted'] = $this->sam_m->get_sam_cy_asset_budgeted($budget_id,$asset_code);
	
	$retHTML = $this->load->view('sam/inc/view_sam_single_edit', $data, true);
	echo $retHTML;
} // end ajax_sam_edit_project function
/**************************************************/
public function ajax_sam_fetch_projType(){
	$asset_code = $this->input->post('asset');
	if ( $asset_code != '' ) {
		$msg = $this->sam_m->get_project_type_by_asset($asset_code);
		echo $msg;
	} else {
		echo 'AJAX is not performing!';
	} // end if
} // end ajax_sam_fetch_projType function
/**************************************************/
public function ajax_sam_view_project(){
	$proj_id = $this->input->post('projID');
	$data['project'] = $this->sam_m->get_project_info($proj_id);

	if( (int)$data['project'][0]['DEPARTMENT_ID'] == 99){
		$budget_id = $data['project'][0]['COMPANY_ID'] . '000';
	} else {
		$budget_id = $data['project'][0]['COMPANY_ID'] . '0' . $data['project'][0]['DEPARTMENT_ID'];
	} // end if

	$asset_code = substr($data['project'][0]['SAM_PROJECT'],-2);
	$data['cyProj'] = $this->sam_m->get_sam_cy_projection($budget_id,$asset_code);
	$data['cyBudgeted'] = $this->sam_m->get_sam_cy_asset_budgeted($budget_id,$asset_code);
	
	$retHTML = $this->load->view('sam/inc/view_sam_single_view', $data, true);
	echo $retHTML;
} // end ajax_sam_view_project function
/*-----------------------------------------------------*/
public function ajax_get_sam_edit(){
	$data['budget_id'] = $this->input->post('budget_id'); // 300000
	$data['asset_code'] = $this->input->post('asset_code'); // 01
	$data['asset_cy_projection'] = $this->sam_m->get_sam_cy_projection($data['budget_id'],$data['asset_code']);
	$data['asset_cy_budgeted'] = $this->sam_m->get_sam_cy_asset_budgeted($data['budget_id'],$data['asset_code']);

	if ( $data['budget_id'] != '' ) {
		$retHTML = $this->load->view('sam/inc/view_sam_edit', $data, TRUE);
		echo $retHTML;
	} else {
		echo 'AJAX is not performing!';
	} // end if
} // end ajax_get_sam_edit function
/**************************************************/
public function ajax_get_sam_note(){
	$budget_id   = $this->input->post('budget_id');
    $asset_code  = $this->input->post('asset_code');
    $budget_year = $this->input->post('budget_year');

    if ( $budget_id != '' ) {
    	$note = $this->sam_m->ajax_get_sam_note_by_year($budget_id,$asset_code,$budget_year);
    	echo $note;
    } else {
		echo 'AJAX is not performing!';
	} // end if
} // end ajax_get_sam_note function
/**************************************************/
public function ajax_get_timeline_details(){
	$data['budget_id'] = $this->input->post('budget_id'); 			//300000
	$data['year_id'] = substr($this->input->post('year_id'),-2);	// 13
	$data['asset_code'] = $this->input->post('asset_code');			// 01
	//$data['year_total'] = $this->input->post('year_total');
	
	if ( $data['budget_id'] != '' ) {
		$retHTML = $this->load->view('sam/inc/view_timeline_details', $data, TRUE);
		echo $retHTML;
	} else {
		echo 'AJAX is not performing!';
	} // end if
} // end ajax_get_timeline_details function
/**************************************************/
public function ajax_get_timeline_edit(){
	$data['budget_id'] = $this->input->post('budget_id'); // 300000
	$data['asset_code'] = $this->input->post('asset_code'); // 01

	if ( $data['budget_id'] != '' ) {
		$retHTML = $this->load->view('sam/inc/view_timeline_edit', $data, TRUE);
		echo $retHTML;
	} else {
		echo 'AJAX is not performing!';
	} // end if
} // end ajax_get_timeline_edit function
/**************************************************/
public function ajax_get_timeline_show(){
	$data['budget_id'] = $this->input->post('budget_id'); // 300000
	$data['asset_code'] = $this->input->post('asset_code'); // 01

	if ( $data['budget_id'] != '' ) {
		$retHTML = $this->load->view('sam/inc/view_timeline_show', $data, TRUE);
		echo $retHTML;
	} else {
		echo 'AJAX is not performing!';
	} // end if
} // end ajax_get_timeline_show function
/**************************************************/
public function ajax_manager_submit_screen(){
	$data['budget_id'] = $this->input->post('bid');
	if ( $data['budget_id'] != '' ) {
		$retHTML = $this->load->view('sam/inc/view_manager_submit', $data, TRUE);
		echo $retHTML;
	} else {
		echo 'AJAX is not performing!';
	} // end if
} // end ajax_manager_submit_screen function
/**************************************************/
public function ajax_SAM_submit(){
	$budget_id = $this->input->post('bid');
	$this->budget_m->status_set_sam_submitted($budget_id);

	// email code
	$email = $this->email_m->email_submitted($id,$this->session->userdata('id'),'SAM');

	//echo $email;die();

	redirect('sam_budget/atm/'.$id);
} // end ajax_SAM_submit function
/**************************************************/
/**************************************************/
} // end class

/* End of file sam_budget.php */
/* Location: ./application/controllers/sam_budget.php */
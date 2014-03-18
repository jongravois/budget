<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pam_budget extends Frontend_Controller {

public function __construct() {
	parent::__construct();
	error_reporting(E_ALL); 
	//error_reporting(0); // for production
	parse_str($_SERVER['QUERY_STRING'], $_GET);
	$this->user = $this->session->all_userdata();
} // end constructor
/***************************************************/
/***************************************************/
public function index() {
	print_r($this->user);
} // end index
/***************************************************/
/***************************************************/
public function budget($val = null){
	if(!isset($val)){
		$primaryBudget = $this->budget_m->get($this->user['default_budget']);
	} else {
		$primaryBudget = $this->budget_m->get($val);
	} // end if
	//print_r($primaryBudget); die();

	//$this->finloc_m->verifyPM();

	$this->load->view('pam/budget', array(
        'user' => $this->user,
        'primary' => $primaryBudget
    ));
} // end budget function
/**************************************************/
/***************************************************/
public function dashboard(){
	//$this->finloc_m->verifyPM();
	$budgets = $this->budget_m->return_user_budgets($this->user);
	$tabs = array();
	if(!isset($budgets[0])){ $budgets[0] = array(null); } else { $tabs['norm'] = 1; }
	if(!isset($budgets[1])){ $budgets[1] = array(null); } else { $tabs['other'] = 1; }
 	if(!isset($budgets[2])){ $budgets[2] = array(null); } else { $tabs['departments'] = 1; }

	$this->load->view('pam/dashboard', array(
		'user'              => $this->user,
		'tabs'              => $tabs,
		'fiscal_norm'       => $budgets[0],
		'fiscal_other'      => $budgets[1],
		'fiscal_department' => $budgets[2]
    ));
} // end dashboard function
/**************************************************/
/***************************************************/
public function add_emp($budget_id){
	$bud = $this->budget_m->get($budget_id);
	$this->load->view('pam/add_emp', array(
        'user' => $this->user,
        'budget' => $bud,
        'fiscal' => $this->fiscal_m->get_fiscal_info($bud->fiscalStart)
    ));
} // end add_emp function
/**************************************************/
public function add_emp_handler(){
	$budget = $this->budget_m->get_bud_info($this->input->post('BUDGET_ID'));
	//print_r($budget[0]); die();

	if( in_array((int)$this->input->post('title'), array(4132,4133) ) ){
		$ee_type = 'M';
	} else {
		$ee_type = $this->input->post('EE_TYPE');
	} // end if

	$annual = (float)$this->input->post('ANNUAL_RATE'); // 57000
	$hourly = (float)$this->input->post('HOURLY_RATE'); // 0
	$caHourly = (float)$this->input->post('HOURLY_RATE_CA'); // 65.00

	switch( $ee_type ){
		case 'S':
			$annual_rate = $annual;
			$hourly_rate = number_format( $annual / 2080, 2);
			break;
		case 'M':
			$annual_rate = 0;
			$hourly_rate = $caHourly;
			break;
		case 'H':
			$annual_rate = $hourly * 2080;
			$hourly_rate = $hourly;
			break;
	} // end switch

	$feed['EMPLID'] = "newEmp";
	$feed['NAME'] = $this->input->post('NAME'); // GenComm
	$feed['EE_STATUS'] = "P"; // set to P and set to B when budgeted. Use to delete incomplete records
	$feed['EE_YEAR'] = (int)$this->globals_m->current_year();
	$feed['NEW_EMP'] = "Y";
	$feed['EMP_REPLACE'] = $this->input->post('EMP_REPLACE'); // N
	$feed['HIRE_DATE'] = date('Y-m-d', strtotime($this->input->post('HIRE_DATE')));
	$feed['START_DATE'] = date('Y-m-d', strtotime($this->input->post('HIRE_DATE')));
	$feed['REHIRE_DATE'] = date('Y-m-d', strtotime($this->input->post( 'REHIRE_DATE')));
	$feed['COMPANY_ID'] = substr( $this->input->post('BUDGET_ID'),0,3 );
	$feed['DEPARTMENT_ID'] = $this->input->post('DEPARTMENT_ID'); // 41
	$feed['EMP_STATE'] = $this->input->post('empState'); // TN
	$feed['REG_TEMP'] = $this->input->post('REG_TEMP');
	$feed['FULL_PART'] = $this->input->post('FULL_PART'); // F
	$feed['EE_TYPE'] = $ee_type;
	$feed['ANNUAL_RATE'] = (float)$annual_rate;
	$feed['STIPEND_AMOUNT'] = (float)$this->input->post('STIPEND_AMOUNT'); // 0
	$feed['HOURLY_RATE'] = (float)$hourly_rate;
	$feed['ADJUSTED_HOURLY_RATE'] = (float)$hourly_rate;
	$feed['JOB_ID'] = $this->input->post('title'); // 4120
	$feed['HOME_JOBCOST_NO'] = $feed['JOB_ID'] . $this->budget_m->getACR($feed['JOB_ID']);
	$feed['WORKERS_COMP_CODE'] = $this->budget_m->get_WCP_code($feed['EMP_STATE'], $feed['JOB_ID']);
	$feed['PERCENTAGE_401K'] = $this->input->post('PERCENTAGE_401K'); // 3
	$feed['GRP_INS_TYPE'] = $this->input->post('GRP_INS_TYPE'); // Family
	$feed['GRP_INS_MONTHLY_EXPENSE'] = (float)$this->globals_m->get_ins_default($feed['GRP_INS_TYPE']);
	$feed['HOME_OFFICE_BONUS_PERCENTAGE'] = (float)$this->input->post('HOME_OFFICE_BONUS_PERCENTAGE');
	$feed['CA_RAD'] = $this->input->post('caRad'); // Y
	$feed['HAS_OVERTIME'] = $this->input->post('HAS_OVERTIME'); // Y
	$feed['IS_DINING_EMP'] = $this->input->post('IS_DINING_EMP');
	$feed['IS_MEAL_ELIGIBLE'] = $this->input->post('IS_MEAL_ELIGIBLE');
	$feed['HAS_BONUS'] = ( in_array((int)$feed['COMPANY_ID'], array(530,540)) ) ? 'Y' : 'N';
	$feed['ALLOC_TOTAL'] = (int)$this->input->post('ALLOC_TOTAL'); // 100
	$feed['ESPP'] = (float)$this->input->post('ESPP'); // 10
	$feed['FSA'] = $this->input->post('FSA'); // Y
	$feed['LAST_EDIT'] = '';
	$feed['BUDGET_ID'] = (int)$this->input->post('BUDGET_ID');
	$feed['HAS_END_DATE'] = $this->input->post('HAS_END_DATE');
	//print_r($feed);die();

	if( in_array((int)$feed['JOB_ID'],array(4132,4133)) ){ $feed['FULL_PART'] == 'P'; }

	$EMP_ID = $this->budget_feed_m->save($feed);

	if( $ee_type == 'M'){
		$eetype['EMP_ID'] = $eyetype['EMP_ID'] = $EMP_ID;
		$eetype['YEAR_ID'] = $eyetype['YEAR_ID'] = $this->globals_m->current_year();
		$eetype['CAT_ID'] = 'PSA';
		$eyetype['CAT_ID'] = 'VSM';
		for($v=1;$v<13;$v++){
			$thisOne = $this->input->post('stipend_P_'.$v);
			if( isset($thisOne) && $thisOne > 0 ){
				$eetype['P_'.$v] = $thisOne;
				$eyetype['P_'.$v] = 1;
			} else {
				$eetype['P_'.$v] = 0;
				$eyetype['P_'.$v] = 0;
			} // end if
			
		} // end for

		$this->budget_m->save_storage($eetype);
		$this->budget_m->save_storage($eyetype);
	} // end if

	if( $feed['CA_RAD'] == 'Y'){
		$ahCA['EMP_ID'] = $EMP_ID;
		$ahCA['YEAR_ID'] = $this->globals_m->current_year();
		$ahCA['CAT_ID'] = 'CAH';
		for($v=1;$v<13;$v++){
			$ahCA['P_'.$v] = $this->input->post('CA_HOURS_P_'.$v);
		} // end for

		$this->budget_m->save_storage($ahCA);
	} // end if

	if( $ee_type == 'H'){
		$FTEH['EMP_ID'] = $EMP_ID;
		$FTEH['YEAR_ID'] = $this->globals_m->current_year();
		$FTEH['CAT_ID'] = 'FTE';
		for($v=1;$v<13;$v++){
			$FTEH['P_'.$v] = $this->input->post('FTE_P_'.$v);
		} // end for

		$this->budget_m->save_storage($FTEH);
	} // end if

	if( $feed['HAS_OVERTIME'] == 'Y'){
		$OVRT['EMP_ID'] = $EMP_ID;
		$OVRT['YEAR_ID'] = $this->globals_m->current_year();
		$OVRT['CAT_ID'] = 'OTH';
		for($v=1;$v<13;$v++){
			$OVRT['P_'.$v] = $this->input->post('OVR_P_'.$v);
		} // end for

		$this->budget_m->save_storage($OVRT);
	} // end if

	if( $feed['IS_DINING_EMP'] == 'Y'){
		$IDEMP['EMP_ID'] = $EMP_ID;
		$IDEMP['YEAR_ID'] = $this->globals_m->current_year();
		$IDEMP['CAT_ID'] = 'DHA';
		for($v=1;$v<13;$v++){
			$IDEMP['P_'.$v] = $this->input->post('DH_P_'.$v);
		} // end for

		$this->budget_m->save_storage($IDEMP);
	} // end if

	if( $feed['IS_MEAL_ELIGIBLE'] == 'Y'){
		$NOMP['EMP_ID'] = $EMP_ID;
		$NOMP['YEAR_ID'] = $this->globals_m->current_year();
		$NOMP['CAT_ID'] = 'EMA';
		for($v=1;$v<13;$v++){
			$NOMP['P_'.$v] = $this->input->post('NOM_P_'.$v);
		} // end for

		$this->budget_m->save_storage($NOMP);
	} // end if

	if( $feed['HAS_BONUS'] == 'Y'){
		$DBON['EMP_ID'] = $EMP_ID;
		$DBON['YEAR_ID'] = $this->globals_m->current_year();
		$DBON['CAT_ID'] = 'DVB';
		for($v=1;$v<13;$v++){
			$DBON['P_'.$v] = $this->input->post('DEV_BONUS_P_'.$v);
		} // end for

		$this->budget_m->save_storage($DBON);
	} // end if

	if( (int)$budget[0]['companyTypeID'] < 3):
		$new_budgeted_emp = $this->budget_m->budget_corporate($EMP_ID);
	else:
		$new_budgeted_emp = $this->budget_m->budget_field($EMP_ID);
	endif;

	if($new_budgeted_emp){
		$sql = "UPDATE budget_feed SET EE_STATUS = 'B' WHERE EMP_ID = {$EMP_ID}";
		$doit = $this->budget_m->xSQL($sql);
	} // end if

	// echo "<pre>"; print_r($new_budgeted_emp); echo "</pre>";
	redirect('pam_budget/budget/'.$feed['BUDGET_ID'], 'refresh');
} // end add_emp_handler function
/**************************************************/
public function delete_emp($id){
	$budget = $this->budget_m->get_budget_from_emp($id);
	if((int)$budget[0]['COMPANY_ID'] < 500 || (int)$budget[0]['COMPANY_ID'] > 599){
		$budget_id = $budget[0]['COMPANY_ID'] . "000";
	} else {
		$budget_id = $budget[0]['COMPANY_ID'] . "0" . $budget[0]['DEPARTMENT_ID'];
	}// end if

	$sql = "UPDATE pam_pm_out SET P_1 = 0, P_2 = 0, P_3 = 0, P_4 = 0, P_5 = 0, P_6 = 0, P_7 = 0, P_8 = 0, P_9 = 0, P_10 = 0, P_11 = 0, P_12 = 0 WHERE keyCol LIKE '{$id}%' AND RIGHT(keyCol,2) = " . $this->globals_m->current_year();
	
	$query = $this->budget_m->xSQL($sql);

	$this->budget_m->update_user( array('EE_STATUS'=>'D'), $id);

	redirect('pam_budget/budget/'.$budget_id,'refresh');
} // end delete_emp function
/**************************************************/
public function edit_emp($id){
	//$budget = $this->budget_feed_m->get($id);
	$bud = $this->pam_m->get_complete_employee($id);
	$this->load->view('pam/edit_emp', array(
        'user' => $this->user,
        'budget' => $bud
    ));
} // end edit_emp function
/**************************************************/
public function edit_emp_handler(){
	//print_r($_POST); die();
	$refreshIT = $this->input->post('refreshed');
	$curr_year = $this->globals_m->current_year();
	$EMP_ID = $this->input->post('EMP_ID');
	$budget = $this->pam_m->get_complete_employee($EMP_ID);
	//print_r($budget); die();

	if( $this->input->post('EE_TYPE') == 'M'){
		$feed['ADJUSTED_HOURLY_RATE'] = $this->input->post('HOURLY_RATE_CA');
	} // end if

	$test_dining = $this->budget_m->get_dining_by_jobcode( $this->input->post('JOB_ID') );
	if( (int)substr($test_dining,-2) == 13 ){
		$feed['IS_DINING_EMP'] = 'Y';
	} else {
		$feed['IS_DINING_EMP'] = 'N';
	}// end if

	$feed['NAME'] = $this->input->post('NAME');
	$feed['START_DATE'] = $this->input->post('START_DATE');
	$feed['REHIRE_DATE'] = $this->input->post('REHIRE_DATE');
	$feed['EMP_STATE'] = $this->input->post('empState');
	$feed['FULL_PART'] = $this->input->post('FULL_PART');
	$feed['EE_TYPE'] = $this->input->post('EE_TYPE');
	$feed['PERCENTAGE_401K'] = $this->input->post('cont401k');
	$feed['GRP_INS_TYPE'] = $this->input->post('groupIns');
	$feed['GRP_INS_MONTHLY_EXPENSE'] = $this->input->post('GRP_INS_MONTHLY_EXPENSE');
	$feed['HOME_OFFICE_BONUS_PERCENTAGE'] = $this->input->post('HOME_OFFICE_BONUS_PERCENTAGE');
	$feed['CA_RAD'] = $this->input->post('CA_RAD');
	$feed['HAS_OVERTIME'] = $this->input->post('hasOvertime');
	$feed['IS_MEAL_ELIGIBLE'] = $this->input->post('isMealEligible');
	$feed['ALLOC_TOTAL'] = $this->input->post('ALLOC_TOTAL');
	$feed['ESPP'] = $this->input->post('ESPP');
	$feed['FSA'] = $this->input->post('FSA');
	$feed['LAST_EDIT'] = date('Y-m-d');
	$feed['BUDGET_ID'] = $this->input->post('BUDGET_ID');
	$feed['HAS_END_DATE'] = $this->input->post('radRehireDate');

	$doit = $this->budget_m->update_user($feed,$EMP_ID);

	// Let's do FTE next
	for($c=1;$c<13;$c++){
		$arrUpdate['P_'.$c] = (float) $this->input->post('FTE_P_'.$c);
	} // end for

	$has_fte = $this->budget_m->get_employee_totals($EMP_ID, $curr_year, 'FTE');

	if( $has_fte || array_sum($arrUpdate) != 0 ){
		$arrUpdate['YEAR_ID'] = $curr_year;
		$arrUpdate['CAT_ID'] = 'FTE';
		
		$doitFTE = $this->budget_m->update_storage($EMP_ID,'FTE',$arrUpdate);
	} // end if

	// OVERTIME
	if( $feed['HAS_OVERTIME'] == 'Y' ){
		$arrUpdate = array(
			'YEAR_ID' => $curr_year,
			'CAT_ID' => 'OTH'
		);
		for($c=1;$c<13;$c++){
			$arrUpdate['P_'.$c] = $this->input->post('OVR_P_'.$c);
		} // end for

		$doitOTH = $this->budget_m->update_storage($EMP_ID,'OTH',$arrUpdate);
	} // end if

	//DINING HOURS
	if( $feed['IS_DINING_EMP'] && $feed['IS_DINING_EMP'] == 'Y' ){
		$arrUpdate = array(
			'YEAR_ID' => $curr_year,
			'CAT_ID' => 'DHA'
		);
		for($c=1;$c<13;$c++){
			$arrUpdate['P_'.$c] = $this->input->post('DH_P_'.$c);
		} // end for

		$doitDHA = $this->budget_m->update_storage($EMP_ID,'DHA',$arrUpdate);
	} // end if

	//EMPLOYEE MEALS
	if( $this->input->post('isMealEligible') == 'Y' ){
		$arrUpdate = array(
			'YEAR_ID' => $curr_year,
			'CAT_ID' => 'EMA'
		);
		for($c=1;$c<13;$c++){
			$arrUpdate['P_'.$c] = $this->input->post('NOM_P_'.$c);
		} // end for

		$doitEMA = $this->budget_m->update_storage($EMP_ID,'EMA',$arrUpdate);
	} // end if

	//ADDITIONAL BENEFITS
	$testSum = 0;
	$has_ABS = $this->budget_m->get_employee_totals($EMP_ID, $curr_year, 'ABS');

	for($ab=1;$ab<13;$ab++){
		$testSum += (float) $this->input->post('additional_benefits_P_'.$ab);
	} // end for

	if( $has_ABS || $testSum > 0 ){
		$arrUpdate = array(
			'YEAR_ID' => $curr_year,
			'CAT_ID' => 'ABS'
		);
		for($c=1;$c<13;$c++){
			$arrUpdate['P_'.$c] = $this->input->post('additional_benefits_P_'.$c);
		} // end for

		$doitABS = $this->budget_m->update_storage($EMP_ID,'ABS',$arrUpdate);
	} // end if

	//DEVELOPMENT BONUS
	if( (int)$budget['budget']['companyTypeID'] == 2 ){
		$arrUpdate = array(
			'YEAR_ID' => $curr_year,
			'CAT_ID' => 'DVB'
		);
		for($c=1;$c<13;$c++){
			$arrUpdate['P_'.$c] = $this->input->post('DEV_BONUS_P_'.$c);
		} // end for

		$doitDVB = $this->budget_m->update_storage($EMP_ID,'DVB',$arrUpdate);
	} // end if

	//CA STIPEND AND ADDITIONAL HOURS
	if( $feed['EE_TYPE'] == 'M' ){
		$arrUpdate = array(
			'YEAR_ID' => $curr_year,
			'CAT_ID' => 'PSA'
		);
		$arrUpdate1 = array(
			'YEAR_ID' => $curr_year,
			'CAT_ID' => 'VSM'
		);
		$arrUpdate2 = array(
			'YEAR_ID' => $curr_year,
			'CAT_ID' => 'CAH'
		);
		for($c=1;$c<13;$c++){
			$arrUpdate['P_'.$c] = $this->input->post('CA_MO_STIPEND_P_'.$c);
			$arrUpdate1['P_'.$c] = ( (int)$this->input->post('CA_MO_STIPEND_P_'.$c) > 0 ? 1 : 0);
			$arrUpdate2['P_'.$c] = $this->input->post('CA_AH_P_'.$c);
		} // end for
		$doitPSA = $this->budget_m->update_storage($EMP_ID,'PSA',$arrUpdate);
		$doitVSM= $this->budget_m->update_storage($EMP_ID,'VSM',$arrUpdate1);
		$doitCAH = $this->budget_m->update_storage($EMP_ID,'CAH',$arrUpdate2);
	} // end if CA

	if( (int)$budget['budget']['companyTypeID'] < 3):
		$new_budgeted_emp = $this->budget_m->budget_corporate($EMP_ID);
	else:
		$new_budgeted_emp = $this->budget_m->budget_field($EMP_ID);
	endif;
	//echo "<pre>";print_r($new_budgeted_emp);echo "</pre>"; die();

	if($refreshIT == 'Y'){
		redirect('pam_budget/edit_emp/'.$EMP_ID, 'refresh');
	} else {
		redirect('pam_budget/budget/'.$budget['feed']['BUDGET_ID'], 'refresh');
	} // end if
} // end edit_emp_handler function
/**************************************************/
public function edit_property_bonuses($budget_id){
	$primary = $this->budget_m->get($budget_id);
	$budget = $this->budget_feed_m->get_bonus_by_budget($budget_id);
	$this->load->view('pam/edit_property_bonuses', array(
        'user' => $this->user,
        'primary' => $primary,
        'budget' => $budget,
        'fiscal' => $this->fiscal_m->get_fiscal_info($primary->fiscalStart)
    ));
} // end edit_property_bonuses function
/**************************************************/
public function edit_property_bonus_handler(){
	$BUDGET_ID = $this->input->post('BUDGET_ID');
	$budget = $this->budget_m->get_bud_info($BUDGET_ID);
	//echo $BUDGET_ID; print_r($budget); die();
	
	if((int)$budget[0]['companyTypeID'] == 4 || (int)$budget[0]['companyTypeID'] == 6){
		$dmb['P_1']  = $this->input->post('DMB1');
		$dmb['P_2']  = $this->input->post('DMB2');
		$dmb['P_3']  = $this->input->post('DMB3');
		$dmb['P_4']  = $this->input->post('DMB4');
		$dmb['P_5']  = $this->input->post('DMB5');
		$dmb['P_6']  = $this->input->post('DMB6');
		$dmb['P_7']  = $this->input->post('DMB7');
		$dmb['P_8']  = $this->input->post('DMB8');
		$dmb['P_9']  = $this->input->post('DMB9');
		$dmb['P_10'] = $this->input->post('DMB10');
		$dmb['P_11'] = $this->input->post('DMB11');
		$dmb['P_12'] = $this->input->post('DMB12');

		$doit = $this->budget_m->update_staffing_bonus($BUDGET_ID, 'DMB', $dmb);
	} // end if

	$lib['P_1']  = $this->input->post('LIB1');
	$lib['P_2']  = $this->input->post('LIB2');
	$lib['P_3']  = $this->input->post('LIB3');
	$lib['P_4']  = $this->input->post('LIB4');
	$lib['P_5']  = $this->input->post('LIB5');
	$lib['P_6']  = $this->input->post('LIB6');
	$lib['P_7']  = $this->input->post('LIB7');
	$lib['P_8']  = $this->input->post('LIB8');
	$lib['P_9']  = $this->input->post('LIB9');
	$lib['P_10'] = $this->input->post('LIB10');
	$lib['P_11'] = $this->input->post('LIB11');
	$lib['P_12'] = $this->input->post('LIB12');

	$doit = $this->budget_m->update_staffing_bonus($BUDGET_ID, 'LIB', $lib);

	$rpi['P_1']  = $this->input->post('RPI1');
	$rpi['P_2']  = $this->input->post('RPI2');
	$rpi['P_3']  = $this->input->post('RPI3');
	$rpi['P_4']  = $this->input->post('RPI4');
	$rpi['P_5']  = $this->input->post('RPI5');
	$rpi['P_6']  = $this->input->post('RPI6');
	$rpi['P_7']  = $this->input->post('RPI7');
	$rpi['P_8']  = $this->input->post('RPI8');
	$rpi['P_9']  = $this->input->post('RPI9');
	$rpi['P_10'] = $this->input->post('RPI10');
	$rpi['P_11'] = $this->input->post('RPI11');
	$rpi['P_12'] = $this->input->post('RPI12');

	$doit = $this->budget_m->update_staffing_bonus($BUDGET_ID, 'RPI', $rpi);

	$lmb['P_1']  = $this->input->post('LMB1');
	$lmb['P_2']  = $this->input->post('LMB2');
	$lmb['P_3']  = $this->input->post('LMB3');
	$lmb['P_4']  = $this->input->post('LMB4');
	$lmb['P_5']  = $this->input->post('LMB5');
	$lmb['P_6']  = $this->input->post('LMB6');
	$lmb['P_7']  = $this->input->post('LMB7');
	$lmb['P_8']  = $this->input->post('LMB8');
	$lmb['P_9']  = $this->input->post('LMB9');
	$lmb['P_10'] = $this->input->post('LMB10');
	$lmb['P_11'] = $this->input->post('LMB11');
	$lmb['P_12'] = $this->input->post('LMB12');

	$doit = $this->budget_m->update_staffing_bonus($BUDGET_ID, 'LMB', $lmb);

	$rmb['P_1']  = $this->input->post('RMB1');
	$rmb['P_2']  = $this->input->post('RMB2');
	$rmb['P_3']  = $this->input->post('RMB3');
	$rmb['P_4']  = $this->input->post('RMB4');
	$rmb['P_5']  = $this->input->post('RMB5');
	$rmb['P_6']  = $this->input->post('RMB6');
	$rmb['P_7']  = $this->input->post('RMB7');
	$rmb['P_8']  = $this->input->post('RMB8');
	$rmb['P_9']  = $this->input->post('RMB9');
	$rmb['P_10'] = $this->input->post('RMB10');
	$rmb['P_11'] = $this->input->post('RMB11');
	$rmb['P_12'] = $this->input->post('RMB12');

	$doit = $this->budget_m->update_staffing_bonus($BUDGET_ID, 'RMB', $rmb);

	$iai['P_1']  = $this->input->post('IAI1');
	$iai['P_2']  = $this->input->post('IAI2');
	$iai['P_3']  = $this->input->post('IAI3');
	$iai['P_4']  = $this->input->post('IAI4');
	$iai['P_5']  = $this->input->post('IAI5');
	$iai['P_6']  = $this->input->post('IAI6');
	$iai['P_7']  = $this->input->post('IAI7');
	$iai['P_8']  = $this->input->post('IAI8');
	$iai['P_9']  = $this->input->post('IAI9');
	$iai['P_10'] = $this->input->post('IAI10');
	$iai['P_11'] = $this->input->post('IAI11');
	$iai['P_12'] = $this->input->post('IAI12');

	$doit = $this->budget_m->update_staffing_bonus($BUDGET_ID, 'IAI', $iai);

	$empid = $this->budget_feed_m->get_bonus_id_by_budget($BUDGET_ID);
	//print_r($empid);
	$doit = $this->budget_m->budget_staffing_bonus($empid);

	redirect('pam_budget/budget/'.$BUDGET_ID, 'refresh');
} // end edit_property_bonus_handler1 function
/**************************************************/
public function edit_street_team($budget_id){
	$primary = $this->budget_m->get($budget_id);
	$curr_year = $this->globals_m->current_year();
	$budget = $this->budget_feed_m->get_streetteam_by_budget($budget_id);
	$numTeam = $this->budget_m->get_employee_totals($budget[0]['EMP_ID'],$curr_year,'NST');
	$salTeam = $this->budget_m->get_employee_totals($budget[0]['EMP_ID'],$curr_year,'AST');
	//print_r($budget); die();

	$this->load->view('pam/edit_streetteam', array(
        'user' => $this->user,
        'primary' => $primary,
        'budget' => $budget,
        'fiscal' => $this->fiscal_m->get_fiscal_info($primary->fiscalStart),
        'team_num' => $numTeam,
        'team_sal' => $salTeam
    ));
} // end edit_street_team function
/**************************************************/
public function edit_streetteam_handler(){
	//print_r($_POST);
	$EMP_ID = $this->input->post('EMP_ID');
	$BUDGET_ID = $this->input->post('BUDGET_ID');

	$arrNum['P_1']  = $this->input->post('num_P_1');
	$arrNum['P_2']  = $this->input->post('num_P_2');
	$arrNum['P_3']  = $this->input->post('num_P_3');
	$arrNum['P_4']  = $this->input->post('num_P_4');
	$arrNum['P_5']  = $this->input->post('num_P_5');
	$arrNum['P_6']  = $this->input->post('num_P_6');
	$arrNum['P_7']  = $this->input->post('num_P_7');
	$arrNum['P_8']  = $this->input->post('num_P_8');
	$arrNum['P_9']  = $this->input->post('num_P_9');
	$arrNum['P_10'] = $this->input->post('num_P_10');
	$arrNum['P_11'] = $this->input->post('num_P_11');
	$arrNum['P_12'] = $this->input->post('num_P_12');

	$this->budget_m->update_storage($EMP_ID, 'NST', $arrNum );

	$arrSal['P_1']  = $this->input->post('sal_P_1');
	$arrSal['P_2']  = $this->input->post('sal_P_2');
	$arrSal['P_3']  = $this->input->post('sal_P_3');
	$arrSal['P_4']  = $this->input->post('sal_P_4');
	$arrSal['P_5']  = $this->input->post('sal_P_5');
	$arrSal['P_6']  = $this->input->post('sal_P_6');
	$arrSal['P_7']  = $this->input->post('sal_P_7');
	$arrSal['P_8']  = $this->input->post('sal_P_8');
	$arrSal['P_9']  = $this->input->post('sal_P_9');
	$arrSal['P_10'] = $this->input->post('sal_P_10');
	$arrSal['P_11'] = $this->input->post('sal_P_11');
	$arrSal['P_12'] = $this->input->post('sal_P_12');

	$this->budget_m->update_storage($EMP_ID, 'AST', $arrSal);

	$buddy = $this->budget_m->budget_streetteam_emp($EMP_ID);
	//echo "<pre>"; print_r($buddy); echo "</pre>"; die();

	redirect('pam_budget/budget/'.$BUDGET_ID, 'refresh');
} // end edit_streetteam_handler function
/**************************************************/
public function edit_turn($budget_id){
	$primary = $this->budget_m->get($budget_id);
	$curr_year = $this->globals_m->current_year();
	$budget = $this->budget_feed_m->get_turn_by_budget($budget_id);
	$this->load->view('pam/edit_turn', array(
        'user' => $this->user,
        'primary' => $primary,
        'budget' => $budget,
        'fiscal' => $this->fiscal_m->get_fiscal_info($primary->fiscalStart),
        'turn_num' => $this->budget_m->get_employee_totals($budget[0]['EMP_ID'],$curr_year,'NTE'),
        'turn_sal' => $this->budget_m->get_employee_totals($budget[0]['EMP_ID'],$curr_year,'ATS')
    ));
} // end edit_turn function
/**************************************************/
public function edit_turn_handler(){
	$EMP_ID = $this->input->post('EMP_ID');
	$BUDGET_ID = $this->input->post('BUDGET_ID');

	$arrNum['P_1']  = $this->input->post('num_P_1');
	$arrNum['P_2']  = $this->input->post('num_P_2');
	$arrNum['P_3']  = $this->input->post('num_P_3');
	$arrNum['P_4']  = $this->input->post('num_P_4');
	$arrNum['P_5']  = $this->input->post('num_P_5');
	$arrNum['P_6']  = $this->input->post('num_P_6');
	$arrNum['P_7']  = $this->input->post('num_P_7');
	$arrNum['P_8']  = $this->input->post('num_P_8');
	$arrNum['P_9']  = $this->input->post('num_P_9');
	$arrNum['P_10'] = $this->input->post('num_P_10');
	$arrNum['P_11'] = $this->input->post('num_P_11');
	$arrNum['P_12'] = $this->input->post('num_P_12');

	$this->budget_m->update_storage($EMP_ID, 'NTE', $arrNum );

	$arrSal['P_1']  = $this->input->post('sal_P_1');
	$arrSal['P_2']  = $this->input->post('sal_P_2');
	$arrSal['P_3']  = $this->input->post('sal_P_3');
	$arrSal['P_4']  = $this->input->post('sal_P_4');
	$arrSal['P_5']  = $this->input->post('sal_P_5');
	$arrSal['P_6']  = $this->input->post('sal_P_6');
	$arrSal['P_7']  = $this->input->post('sal_P_7');
	$arrSal['P_8']  = $this->input->post('sal_P_8');
	$arrSal['P_9']  = $this->input->post('sal_P_9');
	$arrSal['P_10'] = $this->input->post('sal_P_10');
	$arrSal['P_11'] = $this->input->post('sal_P_11');
	$arrSal['P_12'] = $this->input->post('sal_P_12');

	$this->budget_m->update_storage($EMP_ID, 'ATS', $arrSal);

	$turner = $this->budget_m->budget_turn_emp($EMP_ID);
	//print_r($turner); die();

	redirect('pam_budget/budget/'.$BUDGET_ID, 'refresh');
} // end edit_turn_handler function
/**************************************************/
public function open_budget($id){
	$bud = $this->budget_m->get_one_budget($id);
	//print_r($bud); die();

	if( (int) $bud[0]['companyTypeID'] > 2){
		redirect('pam_budget/open_company_budget/'.$id,'refresh');
	} else {
		redirect('pam_budget/open_department_budget/'.$id,'refresh');
	} // end if
} // end open_budget function
/**************************************************/
public function open_company_budget($id){
	//error_reporting(0);
	$this->load->model('hrfeed_m');

	$clearbud = $this->budget_m->clear_out_budget($id);

	$emps = $this->hrfeed_m->get_field_emps($id);
	// echo "<pre>"; print_r($emps); echo "</pre>"; die();

	if( count($emps) > 0){
		foreach($emps as $emp){
			$newbie = $this->budget_m->return_copied_budget($emp, $id);
			$budded = $this->budget_m->budget_field($newbie);
		} // end foreach
	} // end if
	
	// Create Property Bonuses and Dining Bonus, if applicable
	$propBonus = $this->budget_m->create_staffing_bonus($id);
	// echo "<pre>"; print_r($propBonus); echo "</pre>";

	// Create Turn Employees
	$noTurn = $this->budget_m->create_turn_emp($id);
	// echo "<pre>"; print_r($noTurn); echo "</pre>";


	// CREATE STREET TEAM MEMBERS
	$noTeam = $this->budget_m->create_streetteam_emp($id);
	// echo "<pre>"; print_r($noTeam); echo "</pre>";

	// TODO: Send email redirect
	$email = $this->email_m->email_open($id,$this->session->userdata('id'),'PAM');

	//echo $email;die();

	// Change budget status
	$this->budget_m->status_set_open($id);
	
	redirect('pam_budget/budget/'.$id, 'refresh');
} // end open_company_budget function
/**************************************************/
public function open_department_budget($id){
	error_reporting(0);
	$this->load->model('hrfeed_m');
	
	$clearbud = $this->budget_m->clear_out_budget($id);

	$emps = $this->hrfeed_m->get_department_emps($id);

	if( count($emps) > 0){
		foreach($emps as $emp){
			$newbie = $this->budget_m->return_copied_budget($emp, $id);
			$budded = $this->budget_m->budget_corporate($newbie); //<------- NEED		
		} // end foreach
	} // end if

	$email = $this->email_m->email_open($id,$this->session->userdata('id'),'PAM');

	// Change budget status
	$this->budget_m->status_set_open($id);

	// Send email redirect
	redirect('pam_budget/budget/'.$id, 'refresh');
} // end open_department_budget function
/**************************************************/
public function email_test(){
	$email = $this->email_m->email_test();

	echo $email;die();
} // end test_email function
/**************************************************/
public function select_diff_budget(){
	$newBudget = $this->input->post('newBudget');
	redirect('pam_budget/budget/'.$newBudget);
} // end select_diff_budget function
/**************************************************/
/**************************************************/
public function ajax_add_salary_adjustment(){
	$frmData['EMP_ID'] = $this->input->post('EMP_ID');
	$frmData['period'] = substr($this->input->post('period'),2);
	$frmData['kind'] = $this->input->post('IncDec'); // Decrease
	$frmData['type'] = $this->input->post('typer');
	$frmData['amount'] = $this->input->post('fig');

	if( $frmData['period'] != '' ){
		$addAdjustment = $this->pam_m->ajax_adjust_salary($frmData);
		//print_r($addAdjustment);
		echo $addAdjustment;
	} else {
		echo 'AJAX is not performing!';
	} // end if
} // end ajax_add_salary_adjustment function
/**************************************************/
public function ajax_delete_salary_adjustment(){
	$frmData['EMP_ID'] = $this->input->post('EMP_ID'); // 1098
	$frmData['period'] = $this->input->post('period'); // 

	if( $frmData['period'] != '' ){
		$delAdjustment = $this->pam_m->ajax_delete_salary_adjustment($frmData);
		//var_dump($delAdjustment);
		echo $delAdjustment;
	} else {
		echo 'AJAX is not performing!';
	} // end if
} // end ajax_delete_salary_adjustment function
/**************************************************/
public function ajax_fetch_add_summary(){
	$str = $this->input->post('data');
	$HIRE_DATE = $this->input->post('strt');
	$REHIRE_DATE = $this->input->post('nd');
	
	$processed = explode('&',$str);

	foreach($processed as $process){
		list($cKey, $cVal) = explode('=',$process,2);
		$arr[$cKey] = $cVal;
	} // end foreach

	$arr['HIRE_DATE'] = $HIRE_DATE;
	$arr['REHIRE_DATE'] = $REHIRE_DATE;

	$retHTML = '<table class="table-striped" style="width:90%;margin:0 auto;">';
	$retHTML .= '<tr><td colspan="2" style="text-align:center;"><label>SUBMISSION SUMMARY</label></td></tr>';
  	$retHTML .= '<tr><td style="width:40%;">COMPANY:</td><td style="width:60%;">';

  	echo $retHTML;
} // end ajax_fetch_add_summary function
/**************************************************/
public function ajax_get_insurance(){
	$type = $this->input->post('type');
	if( $type != '' ){
		$cost = $this->globals_m->get_ins_default( $type );
		echo $cost;
	} else {
		echo 'AJAX is not performing!';
	} // end if
} // end ajax_get_insurance function
/**************************************************/
public function ajax_get_jobs_by_DeptDD(){
	$dept = $this->input->post('dept');
	if ( $dept != '' ) {
		$jobInfo = $this->budget_m->get_jobs_in_department($dept);
		echo $jobInfo;
	} else {
		echo 'AJAX is not performing!';
	} // end if
} // end ajax_get_jobs_by_DeptDD function
/**************************************************/
public function ajax_get_salary_adjustment(){
	$id = $this->input->post('EMP_ID');
	$adden = $this->pam_m->ajax_salary_adjustment_table($id);
	echo $adden;
} // end ajax_get_salary_adjustment function
/**************************************************/
/**************************************************/
public function z_budget_approved($id){
	$this->budget_m->status_set_approved($id);

	// email code
	$email = $this->email_m->email_approved($id,$this->session->userdata('id'),'PAM');

	redirect('pam_budget/budget/'.$id);
} // end z_budget_approved function
/**************************************************/
public function z_budget_rejected(){
	$id = $this->input->post('budget');
	$reason = $this->input->post('reason');

	$this->budget_m->status_set_open($id);

	// email code
	$email = $this->email_m->email_rejected($id,$this->session->userdata('id'),'PAM', $reason);

	redirect('pam_budget/budget/'.$id);
} // end z_budget_rejected function
/**************************************************/
public function z_submit_for_approval($id){
	$this->budget_m->status_set_pam_submitted($id);

	// email code
	$email = $this->email_m->email_submitted($id,$this->session->userdata('id'),'PAM');

	//echo $email;die();

	redirect('pam_budget/budget/'.$id);
} // end z_submit_for_approval function
/**************************************************/
/**************************************************/
/**************************************************/
} // end class

/* End of file pam_budget.php */
/* Location: ./application/controllers/pam_budget.php */
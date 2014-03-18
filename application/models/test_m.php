<?php

class Test_m extends MY_Model{

	protected $_table_name = '';
	protected $_primary_key = 'id';
	protected $_primary_filter = 'intval';
	protected $_order_by = '';
	protected $_rules = array();
	protected $_timestamps = FALSE;

function __construct(){
	parent::__construct();
} // end constructor
/***************************************************/
public function ajax_adjust_salary($arr){
	$this->load->model('salary_adj_m');

	$EMP_ID = $arr['EMP_ID']; //1158
	$period = $arr['period']; //7
	$kind = $arr['kind']; //Increase
	$type = $arr['type']; // Percent or Dollars
	$amount = $arr['amount']; //10

	$emp = $this->budget_m->get_emp_info($EMP_ID);
	$bud = $this->budget_m->get_bud_info($emp[0]['BUDGET_ID']);

	$aSal = $this->budget_m->get_salary_adjustments($EMP_ID);

	if( !$aSal || count($aSal) == 0 ){
		$aSal['EMP_ID']      = $emp[0]['EMP_ID'];
		$aSal['YEAR_ID']     = $this->globals_m->current_year();
		$aSal['HOURLY_RATE'] = $emp[0]['HOURLY_RATE'];
		$aSal['EE_TYPE']     = $emp[0]['EE_TYPE'];
		for($a=1;$a<13;$a++){
			$aSal['P_'.$a] = $emp[0]['HOURLY_RATE'];
		} // end for
	} // end if
	//return $aSal;

	if( $kind == 'Decrease'){ $amount = $amount * -1; }

	// given EMP_ID, effective period, kind( Inc or Dec), type(S,M,H) and amount
	if( $emp[0]['EE_TYPE'] == 'H' ): // Hourly
		if( $type == 'Percent'){
			$baseHourly = (float) $emp[0]['HOURLY_RATE'];
			$amount = (float) $amount * $baseHourly / 100;
			$adjusted = $baseHourly + $amount;
		} else {
			$adjusted = $emp[0]['HOURLY_RATE'] + $amount;
		} // end if
	elseif( $emp[0]['EE_TYPE'] == 'S' ): // Annual
		if( $type == 'Percent'){
			$baseAnnual = (float) $emp[0]['ANNUAL_RATE'];
			$adj = (float) $amount * $baseAnnual / 100;
			$adjusted = ((float) $baseAnnual + $adj) / 2080;
		} else {
			$adjusted = ($emp[0]['ANNUAL_RATE'] + $amount) / 2080;
		} // end if
	else:
		return "MONTHLY";
	endif;

	$arrAdjustment = array(
		'EMP_ID' => $EMP_ID,
		'YEAR_ID' => $this->globals_m->current_year(),
		'HOURLY_RATE' => $emp[0]['HOURLY_RATE'],
		'EE_TYPE' => $emp[0]['EE_TYPE'],
	);

	for($s=1;$s<$period;$s++){
		$arrAdjustment['P_'.$s] = $emp[0]['HOURLY_RATE'];
	} // end for

	for($sr=(int)$period;$sr<13;$sr++){
		$arrAdjustment['P_'.$sr] = $adjusted;
	} // end for

	$doit = $this->salary_adj_m->save($arrAdjustment);
	$retHTML = $this->pam_m->ajax_salary_adjustment_table($EMP_ID);
	return $retHTML;
} // end ajax_adjust_salary($frmData) function
/**************************************************/
public function budget_field($id){ // PASS IN EMP_ID
	/*~~~ 1. SALARY [6100] ~~~*/
	$pm['salary'] = $this->pam_m->compute_pm_salary($id);
	$this->budget_m->save_for_pm($pm['salary']);
	
	/*~~~ 2. BONUS [6195] ~~~*/
	$pm['bonus'] = $this->pam_m->compute_pm_bonus($id);
	$this->budget_m->save_for_pm($pm['bonus']);

	/*~~~ 3. FICA & MEDICARE [6210] ~~~*/
	$pm['fica'] = $this->pam_m->compute_pm_fica($id);
	$this->budget_m->save_for_pm($pm['fica']);

	/*~~~ 4. FUI & SUI  --> 6215 ~~~*/
	$pm['fuisui'] = $this->pam_m->compute_pm_fuisui($id);
	$this->budget_m->save_for_pm($pm['fuisui']);

	/*~~~ 5. Workman's Comp --> 6220 ~~~*/
	$pm['wc'] = $this->pam_m->compute_pm_wcomp($id);
	$this->budget_m->save_for_pm($pm['wc']);

	/*~~~ 6. Group Insurance --> 6225 ~~~*/
	$pm['gi'] = $this->pam_m->compute_pm_group_insurance($id);
	$this->budget_m->save_for_pm($pm['gi']);

	/*~~~ 7. DISABILITY --> 6230 ~~~*/
	$pm['disability'] = $this->pam_m->compute_pm_disability($id);
	$this->budget_m->save_for_pm($pm['disability']);

	/*~~~ 8. OTHER BENEFITS --> 6255 ~~~*/
	$pm['bennies'] = $this->pam_m->compute_pm_staffing_benefits($id);
	$this->budget_m->save_for_pm($pm['bennies']);

	/*~~~ 9. 401K Employer Contribution --> 6265 ~~~*/
	$pm['k401'] = $this->pam_m->compute_pm_401K_contribution($id);
	$this->budget_m->save_for_pm($pm['k401']);

	/*~~~ 10. Meals [6235] ~~~*/
	$pm['meals'] = $this->pam_m->compute_pm_meals($id);
	$this->budget_m->save_for_pm($pm['meals']);

	/*~~~ 11. 401K Admin booked to 6260 & dept 41 for properties "department" for all others ~~~*/
	$pm['admin'] = $this->pam_m->compute_pm_401k_admin($id);
	$this->budget_m->save_for_pm($pm['admin']);

	/*~~~ 12. Payroll Processing is totaled and booked to 6270 & "department" ~~~*/
	$pm['adp'] = $this->pam_m->compute_pm_adp_admin($id);
	// $this->budget_m->save_for_pm($pm['adp']);

	return $pm;
} // end budget_field function
/**************************************************/
public function get_field_emps($id){
	$curr_year = $this->globals_m->current_year();
	$q = $this->db->select('EMP_ID')
	              ->where('EE_YEAR', $curr_year)
	              ->where('BUDGET_ID',$id)
	              ->where('EE_STATUS', 'B')
	              ->get('budget_feed');
	return $q->result_array();
} // end get_field_emps function
/**************************************************/
/***************************************************/
/***************************************************/
/***************************************************/
} // end class


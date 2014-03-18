<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Budget_m extends MY_Model{

	protected $_table_name     = 'budgets';
	protected $_primary_key    = 'id';
	protected $_primary_filter = 'intval';
	protected $_order_by       = 'name';
	protected $_rules          = array();
	protected $_timestamps     = FALSE;

function __construct(){
	parent::__construct();
} // end constructor
/***************************************************/
/***************************************************/
public function budget_corporate($id){ // PASS IN EMP_ID
	/*~~~ 1. SALARY ~~~*/
	$pm['salary'] = $this->pam_m->compute_pm_salary($id);
	$this->save_for_pm($pm['salary']);
	
	/*~~~ 2. BONUS ~~~*/
	$pm['bonus'] = $this->pam_m->compute_pm_bonus_corp($id);

	/*~~~ 3. FICA & MEDICARE ~~~*/
	$pm['fica'] = $this->pam_m->compute_pm_fica_corp($id);
	$this->save_for_pm($pm['fica']);

	/*~~~ 4. FUI & SUI  --> 6215 ~~~*/
	$pm['fuisui'] = $this->pam_m->compute_pm_fuisui($id);
	$this->save_for_pm($pm['fuisui']);

	/*~~~ 5. Workman's Comp --> 6220 ~~~*/
	$pm['wc'] = $this->pam_m->compute_pm_wcomp($id);
	$this->save_for_pm($pm['wc']);

	/*~~~ 6. Group Insurance --> 6225 ~~~*/
	$pm['gi'] = $this->pam_m->compute_pm_group_insurance($id);
	$this->save_for_pm($pm['gi']);

	/*~~~ 7. DISABILITY --> 6230 ~~~*/
	$pm['disability'] = $this->pam_m->compute_pm_disability($id);
	$this->save_for_pm($pm['disability']);

	/*~~~ 8. OTHER BENEFITS --> 6255 ~~~*/
	$pm['bennies'] = $this->pam_m->compute_pm_staffing_benefits($id);
	$this->save_for_pm($pm['bennies']);

	/*~~~ 9. 401K Employer Contribution --> 6265 ~~~*/
	$pm['k401'] = $this->pam_m->compute_pm_401K_contribution_corp($id);
	$this->save_for_pm($pm['k401']);

	/*~~~ 10. Meals ~~~*/
	$pm['meals'] = $this->pam_m->compute_pm_meals($id);
	$this->save_for_pm($pm['meals']);

	/*~~~ 11. 401K Admin booked to 6260 & dept 41 for properties "department" for all others ~~~*/
	$pm['admin'] = $this->pam_m->compute_pm_401k_admin($id);
	$this->save_for_pm($pm['admin']);

	/*~~~ 12. Payroll Processing is totaled and booked to 6270 & "department" ~~~*/
	$pm['adp'] = $this->pam_m->compute_pm_adp_admin($id);
	$this->save_for_pm($pm['adp']);

	//echo "<pre>"; print_r($pm); echo "</pre>";die();
	return $pm;
} // end budget_corporate function
/**************************************************/
public function budget_field($id){ // PASS IN EMP_ID
	/*~~~ 1. SALARY [6100] ~~~*/
	$pm['salary'] = $this->pam_m->compute_pm_salary($id);
	$this->save_for_pm($pm['salary']);
	
	/*~~~ 2. BONUS [6195] ~~~*/
	$pm['bonus'] = $this->pam_m->compute_pm_bonus($id);
	$this->save_for_pm($pm['bonus']);

	/*~~~ 3. FICA & MEDICARE [6210] ~~~*/
	$pm['fica'] = $this->pam_m->compute_pm_fica($id);
	$this->save_for_pm($pm['fica']);

	/*~~~ 4. FUI & SUI  --> 6215 ~~~*/
	$pm['fuisui'] = $this->pam_m->compute_pm_fuisui($id);
	$this->save_for_pm($pm['fuisui']);

	/*~~~ 5. Workman's Comp --> 6220 ~~~*/
	$pm['wc'] = $this->pam_m->compute_pm_wcomp($id);
	$this->save_for_pm($pm['wc']);

	/*~~~ 6. Group Insurance --> 6225 ~~~*/
	$pm['gi'] = $this->pam_m->compute_pm_group_insurance($id);
	$this->save_for_pm($pm['gi']);

	/*~~~ 7. DISABILITY --> 6230 ~~~*/
	$pm['disability'] = $this->pam_m->compute_pm_disability($id);
	$this->save_for_pm($pm['disability']);

	/*~~~ 8. OTHER BENEFITS --> 6255 ~~~*/
	$pm['bennies'] = $this->pam_m->compute_pm_staffing_benefits($id);
	$this->save_for_pm($pm['bennies']);

	/*~~~ 9. 401K Employer Contribution --> 6265 ~~~*/
	$pm['k401'] = $this->pam_m->compute_pm_401K_contribution($id);
	$this->save_for_pm($pm['k401']);

	/*~~~ 10. Meals [6235] ~~~*/
	$pm['meals'] = $this->pam_m->compute_pm_meals($id);
	$this->save_for_pm($pm['meals']);

	/*~~~ 11. 401K Admin booked to 6260 & dept 41 for properties "department" for all others ~~~*/
	$pm['admin'] = $this->pam_m->compute_pm_401k_admin($id);
	$this->save_for_pm($pm['admin']);

	/*~~~ 12. Payroll Processing is totaled and booked to 6270 & "department" ~~~*/
	$pm['adp'] = $this->pam_m->compute_pm_adp_admin($id);
	$this->save_for_pm($pm['adp']);

	return $pm;
} // end budget_field function
/**************************************************/
public function budget_staffing_bonus($id){
	//return $id;
	$CY = $this->globals_m->current_year();

	$bsbonus = $this->budget_feed_m->get_bonus_by_empid($id);
	// return $bsbonus;

	if( in_array((int)$bsbonus[0]['DEPARTMENT_ID'], array(13,41,52,55)) ){
		$budget_id = $bsbonus[0]['COMPANY_ID'] . '000';
	} else {
		$budget_id = $bsbonus[0]['COMPANY_ID'] . '0' . $bsbonus[0]['DEPARTMENT_ID'];
	} // end if
	
	$rmb = $this->get_staffing_bonus($budget_id,'RMB');
	$iai = $this->get_staffing_bonus($budget_id,'IAI');
	$cmb = $this->get_staffing_bonus($budget_id,'CMB');
	$lib = $this->get_staffing_bonus($budget_id,'LIB');
	$rpi = $this->get_staffing_bonus($budget_id,'RPI');
	$lmb = $this->get_staffing_bonus($budget_id,'LMB');

	$dmb = $this->get_staffing_bonus($budget_id,'DMB');

	$bs['EMP_ID'] = $id;
	$bs['EMPLID'] = "staffingBonus";
	$bs['Year_id'] = $CY;
	$bs['Ver_id'] = $this->globals_m->version_id();
	$bs['Unit_id'] = substr($budget_id,0,3);
	$bs['Line_id'] = 9999;
	$bs['Cust1_id'] = 41;
	$bs['Cust2_id'] = 0;
	for( $o=1;$o<13;$o++){
		$bs['P_'. $o] = 0;
	} // end for

	//$pms['EMP_ID'] . $pms['Line_id'] . $pms['Cust1_id'] . $pms['Year_id'];
	$bs['keyCol'] = $id . $bs['Line_id'] . $bs['Unit_id'] . $bs['Cust1_id'] . $CY;

	$sqlKillOT = "DELETE FROM overtime_out WHERE EMP_ID = '".(int) $bs['EMP_ID']."'";
    $this->db->query($sqlKillOT);
    $this->db->insert('overtime_out', $bs);

    // CLEAR OUT EXISTING
    $this->db->where('Year_id',$CY)->where('EMP_ID',$id)->delete('pam_pm_out');

    // I. INSERT LINES OF NO PAY
    // ADP Admin
    $bs['Line_id'] = 6270;
    $bs['keyCol'] = $id . $bs['Line_id'] . $bs['Cust1_id'] . $CY;
    $this->db->insert('pam_pm_out',$bs);

    // 401K Admin
    $bs['Line_id'] = 6260;
    $bs['keyCol'] = $id . $bs['Line_id'] . $bs['Cust1_id'] . $CY;
    $this->db->insert('pam_pm_out',$bs);

    // Meals
    $bs['Line_id'] = 6235;
    $bs['keyCol'] = $id . $bs['Line_id'] . $bs['Cust1_id'] . $CY;
    $this->db->insert('pam_pm_out',$bs);

    // 401K Contribution
    $bs['Line_id'] = 6265;
    $bs['keyCol'] = $id . $bs['Line_id'] . $bs['Cust1_id'] . $CY;
    $this->db->insert('pam_pm_out',$bs);

    // Disability
    $bs['Line_id'] = 6230;
    $bs['keyCol'] = $id . $bs['Line_id'] . $bs['Cust1_id'] . $CY;
    $this->db->insert('pam_pm_out',$bs);

    // Group Insurance
    $bs['Line_id'] = 6225;
    $bs['keyCol'] = $id . $bs['Line_id'] . $bs['Cust1_id'] . $CY;
    $this->db->insert('pam_pm_out',$bs);

    // Other Benefits
    $bs['Line_id'] = 6255;
    $bs['keyCol'] = $id . $bs['Line_id'] . $bs['Cust1_id'] . $CY;
    $this->db->insert('pam_pm_out',$bs);

    // II. BONUS IN SALARY GL (with Dining Manager Bonus, if applicable)
    $bs['Line_id'] = 6195;
    $bs['keyCol'] = $id . $bs['Line_id'] . $bs['Cust1_id'] . $CY;
    for( $o=1;$o<13;$o++){
		$bs['P_'. $o] = (float) $rmb[0]['P_'. $o] + (float) $iai[0]['P_'. $o] + (float) $cmb[0]['P_'. $o];
	} // end for
	$this->db->insert('pam_pm_out',$bs);

	// III. BONUS IN BONUS GL
	$bs['Line_id'] = 6197;
    $bs['keyCol'] = $id . $bs['Line_id'] . $bs['Cust1_id'] . $CY;
    for( $o=1;$o<13;$o++){
		$bs['P_'. $o] = (float) $lib[0]['P_'. $o] + (float) $rpi[0]['P_'. $o] + (float) $lmb[0]['P_'. $o];
	} // end for
	$this->db->insert('pam_pm_out',$bs);

	// IV. FICA & MEDICARE
	$bennieQ = "SELECT BUDGET_ID, YEAR_ID, sum(P_1) as P_1, sum(P_2) as P_2, sum(P_3) as P_3, sum(P_4) as P_4, sum(P_5) as P_5, sum(P_6) as P_6, sum(P_7) as P_7, sum(P_8) as P_8, sum(P_9) as P_9, sum(P_10) as P_10, sum(P_11) as P_11, sum(P_12) as P_12 FROM budget_storage WHERE BUDGET_ID = {$budget_id} GROUP BY BUDGET_ID, YEAR_ID";
	$bennieQry = $this->db->query($bennieQ);
	$totBennie = $bennieQry->result_array();

	$bs['Line_id'] = 6210;
    $bs['keyCol'] = $id . $bs['Line_id'] . $bs['Cust1_id'] . $CY;

	$ficaMax = $this->globals_m->get_fica_max();
	$ficaRate = $this->globals_m->get_fica_rate();
	$medicareRate = $this->globals_m->get_medicare_rate();

	$fica_val = $this->globals_m->get_maxed_tax($totBennie[0],$ficaMax,$ficaRate);

	for($p=1;$p<13;$p++){
		$thisOne = ($fica_val[$p] + ( $totBennie[0]['P_'.$p] * $medicareRate ));
		$bs["P_".$p] = number_format($thisOne,2,".","");
	} // end for
	$this->db->insert('pam_pm_out',$bs);

	// V. FUI & SUI  --> 6215
    $bs['Line_id'] = 6215;
    $bs['keyCol'] = $id . $bs['Line_id'] . $bs['Cust1_id'] . $CY;

    $fuiMax = $this->globals_m->get_fui_max();
	$fuiRate = $this->globals_m->get_fui_rate();
	$suiMax = $this->globals_m->get_sui_max($bsbonus[0]['EMP_STATE']);
	$suiRate = $this->globals_m->get_sui_rate($bsbonus[0]['EMP_STATE']);

	$fui_val = $this->globals_m->get_maxed_tax($totBennie[0],$fuiMax,$fuiRate);
	$sui_val = $this->globals_m->get_maxed_tax($totBennie[0],$suiMax,$suiRate);

	for($p=1;$p<13;$p++){
		$thisOne = ((float) $fui_val[$p] / 100 + (float) $sui_val[$p] / 100);
		$bs["P_".$p] = number_format($thisOne,2,".","");
	} // end for
	$this->db->insert('pam_pm_out',$bs);

    //Workman's Comp --> 6220
    $bs['Line_id'] = 6220;
    $bs['keyCol'] = $id . $bs['Line_id'] . $bs['Cust1_id'] . $CY;

    $wcRate = $this->budget_m->get_wcomp_rate($bsbonus[0]['EMP_STATE'], $bsbonus[0]['JOB_ID']);
    if(!$wcRate){$wcRate = 0;}
	$staffRate = $this->budget_m->get_staff_rate( $budget_id );
	if($bsbonus[0]['EMP_STATE'] == 'TN'){ $wcRate = 0; }

	for($w=1;$w<13;$w++){
		$thisOne = (($totBennie[0]["P_".$w] + $staffRate) * $wcRate/100);
		$bs["P_".$w] = number_format($thisOne,2,".","");
	} // end for
	$this->db->insert('pam_pm_out',$bs);

	/* DINING MANAGER BONUS ONLY */
	if( in_array( (int) $bsbonus[0]['COMPANY_ID'], array(268,349)) ){
		$bs['Line_id'] = 6195;
		$bs['Cust1_id'] = 13;
		$bs['keyCol'] = $id . $bs['Line_id'] . $bs['Cust1_id'] . $CY;
		for( $o=1;$o<13;$o++){
			$bs['P_'. $o] = (float) $dmb[0]['P_'. $o];
		} // end for
		$this->db->insert('pam_pm_out',$bs);
	}

    return "completed budget staffing bonus function.";
} // end budget_staffing_bonus function
/**************************************************/
public function budget_staffing_bonus_by_bid($bid){
	$CY = $this->globals_m->current_year();

	$bsbonus = $this->budget_feed_m->get_bonus_by_budget($bid);

	$rmb = $this->get_staffing_bonus($bid,'RMB');
	$iai = $this->get_staffing_bonus($bid,'IAI');
	$cmb = $this->get_staffing_bonus($bid,'CMB');
	$lib = $this->get_staffing_bonus($bid,'LIB');
	$rpi = $this->get_staffing_bonus($bid,'RPI');
	$lmb = $this->get_staffing_bonus($bid,'LMB');

	$dmb = $this->get_staffing_bonus($bid,'DMB');

	$bs['EMP_ID'] = $bsbonus[0]['EMP_ID'];
	$bs['EMPLID'] = "staffingBonus";
	$bs['Year_id'] = $CY;
	$bs['Ver_id'] = $this->globals_m->version_id();
	$bs['Unit_id'] = substr($bid,0,3);
	$bs['Line_id'] = 9999;
	$bs['Cust1_id'] = 41;
	$bs['Cust2_id'] = 0;
	for( $o=1;$o<13;$o++){
		$bs['P_'. $o] = 0;
	} // end for

	$bs['keyCol'] = $bs['EMP_ID'] . $bs['Line_id'] . $bs['Unit_id'] . $bs['Cust1_id'] . $CY;

	$sqlKillOT = "DELETE FROM overtime_out WHERE EMP_ID = '" . (int) $bs['EMP_ID'] . "'";
    $this->db->query($sqlKillOT);
    $this->db->insert('overtime_out', $bs);

    // CLEAR OUT EXISTING
    $this->db->where('Year_id',$CY)->where('EMP_ID',$bs['EMP_ID'])->delete('pam_pm_out');

    // I. INSERT LINES OF NO PAY
    // ADP Admin
    $bs['Line_id'] = 6270;
    $bs['keyCol'] = $bs['EMP_ID'] . $bs['Line_id'] . $bs['Unit_id'] . $bs['Cust1_id'] . $CY;
    $this->db->insert('pam_pm_out',$bs);

    // 401K Admin
    $bs['Line_id'] = 6260;
    $bs['keyCol'] = $bs['EMP_ID'] . $bs['Line_id'] . $bs['Unit_id'] . $bs['Cust1_id'] . $CY;
    $this->db->insert('pam_pm_out',$bs);

    // Meals
    $bs['Line_id'] = 6235;
    $bs['keyCol'] = $bs['EMP_ID'] . $bs['Line_id'] . $bs['Unit_id'] . $bs['Cust1_id'] . $CY;
    $this->db->insert('pam_pm_out',$bs);

    // 401K Contribution
    $bs['Line_id'] = 6265;
    $bs['keyCol'] = $bs['EMP_ID'] . $bs['Line_id'] . $bs['Unit_id'] . $bs['Cust1_id'] . $CY;
    $this->db->insert('pam_pm_out',$bs);

    // Disability
    $bs['Line_id'] = 6230;
    $bs['keyCol'] = $bs['EMP_ID'] . $bs['Line_id'] . $bs['Unit_id'] . $bs['Cust1_id'] . $CY;
    $this->db->insert('pam_pm_out',$bs);

    // Group Insurance
    $bs['Line_id'] = 6225;
    $bs['keyCol'] = $bs['EMP_ID'] . $bs['Line_id'] . $bs['Unit_id'] . $bs['Cust1_id'] . $CY;
    $this->db->insert('pam_pm_out',$bs);

    // Other Benefits
    $bs['Line_id'] = 6255;
    $bs['keyCol'] = $bs['EMP_ID'] . $bs['Line_id'] . $bs['Unit_id'] . $bs['Cust1_id'] . $CY;
    $this->db->insert('pam_pm_out',$bs);

    // II. BONUS IN SALARY GL (with Dining Manager Bonus, if applicable)
    $bs['Line_id'] = 6195;
    $bs['keyCol'] = $bs['EMP_ID'] . $bs['Line_id'] . $bs['Unit_id'] . $bs['Cust1_id'] . $CY;
    for( $o=1;$o<13;$o++){
		$bs['P_'. $o] = (float) $rmb[0]['P_'. $o] + (float) $iai[0]['P_'. $o] + (float) $cmb[0]['P_'. $o];
	} // end for
	$this->db->insert('pam_pm_out',$bs);

	if( (int)$bs['Unit_id'] == 268 || (int)$bs['Unit_id'] == 349 ){
		$bs['Cust1_id'] = 13;
		$bs['keyCol'] = $bs['EMP_ID'] . $bs['Line_id'] . $bs['Unit_id'] . $bs['Cust1_id'] . $CY;
		for( $o=1;$o<13;$o++){
			$bs['P_'. $o] = (float) $dmb[0]['P_'. $o];
		} // end for
    	$this->db->insert('pam_pm_out',$bs);
	} // end if

	// III. BONUS IN BONUS GL
	$bs['Line_id'] = 6197;
    $bs['keyCol'] = $bs['EMP_ID'] . $bs['Line_id'] . $bs['Unit_id'] . $bs['Cust1_id'] . $CY;
    for( $o=1;$o<13;$o++){
		$bs['P_'. $o] = (float) $lib[0]['P_'. $o] + (float) $rpi[0]['P_'. $o] + (float) $lmb[0]['P_'. $o];
	} // end for
	$this->db->insert('pam_pm_out',$bs);

	// IV. FICA & MEDICARE
	$bennieQ = "SELECT BUDGET_ID, YEAR_ID, sum(P_1) as P_1, sum(P_2) as P_2, sum(P_3) as P_3, sum(P_4) as P_4, sum(P_5) as P_5, sum(P_6) as P_6, sum(P_7) as P_7, sum(P_8) as P_8, sum(P_9) as P_9, sum(P_10) as P_10, sum(P_11) as P_11, sum(P_12) as P_12 FROM budget_storage WHERE BUDGET_ID = {$bid} GROUP BY BUDGET_ID, YEAR_ID";
	$bennieQry = $this->db->query($bennieQ);
	$totBennie = $bennieQry->result_array();

	$bs['Line_id'] = 6210;
    $bs['keyCol'] = $bs['EMP_ID'] . $bs['Line_id'] . $bs['Unit_id'] . $bs['Cust1_id'] . $CY;

	$ficaMax = $this->globals_m->get_fica_max();
	$ficaRate = $this->globals_m->get_fica_rate();
	$medicareRate = $this->globals_m->get_medicare_rate();

	$fica_val = $this->globals_m->get_maxed_tax($totBennie[0],$ficaMax,$ficaRate);

	for($p=1;$p<13;$p++){
		$thisOne = ($fica_val[$p] + ( $totBennie[0]['P_'.$p] * $medicareRate ));
		$bs["P_".$p] = number_format($thisOne,2,".","");
	} // end for
	$this->db->insert('pam_pm_out',$bs);

	// V. FUI & SUI  --> 6215
    $bs['Line_id'] = 6215;
    $bs['keyCol'] = $bs['EMP_ID'] . $bs['Line_id'] . $bs['Unit_id'] . $bs['Cust1_id'] . $CY;

    $fuiMax = $this->globals_m->get_fui_max();
	$fuiRate = $this->globals_m->get_fui_rate();
	$suiMax = $this->globals_m->get_sui_max($bsbonus[0]['EMP_STATE']);
	$suiRate = $this->globals_m->get_sui_rate($bsbonus[0]['EMP_STATE']);

	$fui_val = $this->globals_m->get_maxed_tax($totBennie[0],$fuiMax,$fuiRate);
	$sui_val = $this->globals_m->get_maxed_tax($totBennie[0],$suiMax,$suiRate);

	for($p=1;$p<13;$p++){
		$thisOne = ((float) $fui_val[$p] / 100 + (float) $sui_val[$p] / 100);
		$bs["P_".$p] = number_format($thisOne,2,".","");
	} // end for
	$this->db->insert('pam_pm_out',$bs);

    //Workman's Comp --> 6220
    $bs['Line_id'] = 6220;
    $bs['keyCol'] = $bs['EMP_ID'] . $bs['Line_id'] . $bs['Unit_id'] . $bs['Cust1_id'] . $CY;

    $wcRate = $this->budget_m->get_wcomp_rate($bsbonus[0]['EMP_STATE'], $bsbonus[0]['JOB_ID']);
    if(!$wcRate){$wcRate = 0;}
    if($bsbonus[0]['EMP_STATE'] == 'TN'){ $wcRate = 0; }
    //return $wcRate;
    
	$staffRate = $this->budget_m->get_staff_rate( $bid );

	for($w=1;$w<13;$w++){
		$thisOne = (($totBennie[0]["P_".$w] + $staffRate) * $wcRate/100);
		$bs["P_".$w] = number_format($thisOne,2,".","");
	} // end for
	//return $bs;
	$this->db->insert('pam_pm_out',$bs);

    return "completed budget staffing bonus function.";
} // end budget_staffing_bonus function
/**************************************************/
public function budget_streetteam_emp($id){
	//return $id;
	$fullEmp = array();
	$curr_year = $this->globals_m->current_year();

	$turner = $this->budget_feed_m->get($id);
	//return $turner;

	$numTeam = $this->get_employee_totals($id,$curr_year,'NST');
	$amountTeam = $this->get_employee_totals($id,$curr_year,'AST');

	if( count($numTeam) < 1 ){
		$numTeam = array(array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0));
	} // end if

	if( count($amountTeam) < 1 ){
		$amountTeam = array(array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0));
	} // end if

	//return $amountTeam;

	$te['EMP_ID'] = $id;
	$te['EMPLID'] = "streetTeam";
	$te['Year_id'] = $curr_year;
	$te['Ver_id'] = $this->globals_m->version_id();
	$te['Unit_id'] = $turner->COMPANY_ID;
	$te['Cust1_id'] = 41;
	$te['Cust2_id'] = 0;
	for( $o=1;$o<13;$o++){
		$te['P_'. $o] = 0;
	} // end for

	// CLEAR OUT EXISTING
    $this->db->where('Year_id',$curr_year)->where('EMP_ID',$te['EMP_ID'])->delete('pam_pm_out');

    // I. INSERT LINES OF NO PAY
    // Meals
    $te['Line_id'] = 6235;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $curr_year;
    $this->db->insert('pam_pm_out',$te);
    array_push($fullEmp, $te);

    // 401K Contribution
    $te['Line_id'] = 6265;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $curr_year;
    $this->db->insert('pam_pm_out',$te);
    array_push($fullEmp, $te);

    // Disability
    $te['Line_id'] = 6230;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $curr_year;
    $this->db->insert('pam_pm_out',$te);
    array_push($fullEmp, $te);

    // Group Insurance
    $te['Line_id'] = 6225;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $curr_year;
    $this->db->insert('pam_pm_out',$te);
    array_push($fullEmp, $te);

    // Other Benefits
    $te['Line_id'] = 6255;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $curr_year;
    $this->db->insert('pam_pm_out',$te);
    array_push($fullEmp, $te);

    // Bonus
    $te['Line_id'] = 6195;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $curr_year;
    $this->db->insert('pam_pm_out',$te);
    array_push($fullEmp, $te);

    // II. SALARY
    $te['Line_id'] = 6205;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $curr_year;
    for( $o=1;$o<13;$o++){
		$te['P_'. $o] = (float) $amountTeam[0]['P_'. $o];
	} // end for
	$this->db->insert('pam_pm_out',$te);
	array_push($fullEmp, $te);

	// III. ADP Admin -- 6270
	$te['Line_id'] = 6270;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $curr_year;
    for( $o=1;$o<13;$o++){
		$te['P_'. $o] = (float) $numTeam[0]['P_'. $o] * (float) $this->globals_m->get_admin_adp();
	} // end for
	$this->db->insert('pam_pm_out',$te);
	array_push($fullEmp, $te);

	// IV. 401K Admin -- 6260
	$te['Line_id'] = 6260;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $curr_year;
    for( $o=1;$o<13;$o++){
		$te['P_'. $o] = (float) $numTeam[0]['P_'. $o] * (float) $this->globals_m->get_admin_401k();
	} // end for
	$this->db->insert('pam_pm_out',$te);
	array_push($fullEmp, $te);

	// IV. FICA & MEDICARE
	for( $o=1;$o<13;$o++){
		$totBennie['P_'.$o] = (float) $amountTeam[0]['P_'. $o];
	} // end for

	$te['Line_id'] = 6210;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $curr_year;

	$ficaMax = $this->globals_m->get_fica_max();
	$ficaRate = $this->globals_m->get_fica_rate();
	$medicareRate = $this->globals_m->get_medicare_rate();

	$fica_val = $this->globals_m->get_maxed_tax($totBennie,$ficaMax,$ficaRate);

	for($p=1;$p<13;$p++){
		$thisOne = ($fica_val[$p] + ( $totBennie['P_'.$p] * $medicareRate ));
		$te["P_".$p] = number_format($thisOne,2,".","");
	} // end for
	$this->db->insert('pam_pm_out',$te);
	array_push($fullEmp, $te);

	// V. FUI & SUI  --> 6215
    $te['Line_id'] = 6215;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $curr_year;

    $fuiMax = $this->globals_m->get_fui_max();
	$fuiRate = $this->globals_m->get_fui_rate();
	$suiMax = $this->globals_m->get_sui_max($turner->EMP_STATE);
	$suiRate = $this->globals_m->get_sui_rate($turner->EMP_STATE);

	$fui_val = $this->globals_m->get_maxed_tax($totBennie,$fuiMax,$fuiRate);
	$sui_val = $this->globals_m->get_maxed_tax($totBennie,$suiMax,$suiRate);

	for($p=1;$p<13;$p++){
		$thisOne = ((float) $fui_val[$p] / 100 + (float) $sui_val[$p] / 100);
		$te["P_".$p] = number_format($thisOne,2,".","");
	} // end for
	$this->db->insert('pam_pm_out',$te);
	array_push($fullEmp, $te);

	// VI. Workman's Comp  --> 6220
    $te['Line_id'] = 6220;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $curr_year;

    $wcRate = $this->budget_m->get_wcomp_rate($turner->EMP_STATE, $turner->JOB_ID);
    if(!$wcRate){$wcRate = 0;}
	$staffRate = $this->budget_m->get_staff_rate( $id );

    for($p=1;$p<13;$p++){
		$thisOne = ((float) $amountTeam[0]['P_'. $p] * $wcRate / 100);
		$te["P_".$p] = number_format($thisOne,2,".","");
	} // end for
    $this->db->insert('pam_pm_out',$te);
    array_push($fullEmp, $te);

    return $fullEmp;
} // end budget_turn_emps function
/**************************************************/
public function budget_streetteam_emp_by_bid($bid){
	//error_reporting(E_ALL);
	// return $bid;
	$CY = $this->globals_m->current_year();

	$turner = $this->budget_feed_m->get_streetteam_by_budget($bid);
	// return $turner;

	$id = $turner[0]['EMP_ID'];

	$numTeam = $this->get_employee_totals($id,$CY,'NST');
	$amountTeam = $this->get_employee_totals($id,$CY,'AST');

	if( count($numTeam) < 1 ){
		$numTeam = array(array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0));
	} // end if

	if( count($amountTeam) < 1 ){
		$amountTeam = array(array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0));
	} // end if

	// return $amountTeam;

	$te['EMP_ID'] = $id;
	$te['EMPLID'] = "streetTeam";
	$te['Year_id'] = $CY;
	$te['Ver_id'] = $this->globals_m->version_id();
	$te['Unit_id'] = $turner[0]['COMPANY_ID'];
	$te['Cust1_id'] = 41;
	$te['Cust2_id'] = 0;
	for( $o=1;$o<13;$o++){
		$te['P_'. $o] = 0;
	} // end for

	// CLEAR OUT EXISTING
    $this->db->where('Year_id',$CY)->where('EMP_ID',$id)->delete('pam_pm_out');

    // I. INSERT LINES OF NO PAY
    // Meals
    $te['Line_id'] = 6235;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $CY;
    $this->db->insert('pam_pm_out',$te);

    // 401K Contribution
    $te['Line_id'] = 6265;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $CY;
    $this->db->insert('pam_pm_out',$te);

    // Disability
    $te['Line_id'] = 6230;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $CY;
    $this->db->insert('pam_pm_out',$te);

    // Group Insurance
    $te['Line_id'] = 6225;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $CY;
    $this->db->insert('pam_pm_out',$te);

    // Other Benefits
    $te['Line_id'] = 6255;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $CY;
    $this->db->insert('pam_pm_out',$te);

    // Bonus
    $te['Line_id'] = 6195;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $CY;
    $this->db->insert('pam_pm_out',$te);

    // II. SALARY
    $te['Line_id'] = 6205;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $CY;
    for( $o=1;$o<13;$o++){
		$te['P_'. $o] = (float) $amountTeam[0]['P_'. $o];
	} // end for
	$this->db->insert('pam_pm_out',$te);

	// III. ADP Admin -- 6270
	$te['Line_id'] = 6270;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $CY;
    for( $o=1;$o<13;$o++){
		$te['P_'. $o] = (float) $numTeam[0]['P_'. $o] * (float) $this->globals_m->get_admin_adp();
	} // end for
	$this->db->insert('pam_pm_out',$te);

	// IV. 401K Admin -- 6260
	$te['Line_id'] = 6260;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $CY;
    for( $o=1;$o<13;$o++){
		$te['P_'. $o] = (float) $numTeam[0]['P_'. $o] * (float) $this->globals_m->get_admin_401k();
	} // end for
	$this->db->insert('pam_pm_out',$te);

	// IV. FICA & MEDICARE
	for( $o=1;$o<13;$o++){
		$totBennie['P_'.$o] = (float) $amountTeam[0]['P_'. $o];
	} // end for

	$te['Line_id'] = 6210;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $CY;

	$ficaMax = $this->globals_m->get_fica_max();
	$ficaRate = $this->globals_m->get_fica_rate();
	$medicareRate = $this->globals_m->get_medicare_rate();

	$fica_val = $this->globals_m->get_maxed_tax($totBennie,$ficaMax,$ficaRate);

	for($p=1;$p<13;$p++){
		$thisOne = ($fica_val[$p] + ( $totBennie['P_'.$p] * $medicareRate ));
		$te["P_".$p] = number_format($thisOne,2,".","");
	} // end for
	$this->db->insert('pam_pm_out',$te);

	// V. FUI & SUI  --> 6215
    $te['Line_id'] = 6215;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $CY;

    $fuiMax = $this->globals_m->get_fui_max();
	$fuiRate = $this->globals_m->get_fui_rate();
	$suiMax = $this->globals_m->get_sui_max($turner[0]['EMP_STATE']);
	$suiRate = $this->globals_m->get_sui_rate($turner[0]['EMP_STATE']);

	$fui_val = $this->globals_m->get_maxed_tax($totBennie,$fuiMax,$fuiRate);
	$sui_val = $this->globals_m->get_maxed_tax($totBennie,$suiMax,$suiRate);

	for($p=1;$p<13;$p++){
		$thisOne = ((float) $fui_val[$p] / 100 + (float) $sui_val[$p] / 100);
		$te["P_".$p] = number_format($thisOne,2,".","");
	} // end for
	$this->db->insert('pam_pm_out',$te);

	// VI. Workman's Comp  --> 6220
    $te['Line_id'] = 6220;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $CY;

    $wcRate = $this->budget_m->get_wcomp_rate($turner[0]['EMP_STATE'], $turner[0]['JOB_ID']);
    if(!$wcRate){$wcRate = 0;}
	$staffRate = $this->budget_m->get_staff_rate( $id );

    for($p=1;$p<13;$p++){
		$thisOne = ((float) $amountTeam[0]['P_'. $p] * $wcRate / 100);
		$te["P_".$p] = number_format($thisOne,2,".","");
	} // end for
    $this->db->insert('pam_pm_out',$te);

    return "completed budget turn emps function.";
} // end budget_turn_emps function
/**************************************************/
public function budget_turn_emp($id){
	//return $id;
	$curr_year = $this->globals_m->current_year();
	$bud = $this->get_budget_from_emp($id);
	//return $bud;

	if((int)$bud[0]['COMPANY_ID'] > 499 && (int)$bud[0]['COMPANY_ID'] < 600){
		$bid = $bud[0]['COMPANY_ID'] . '0' . $bud[0]['DEPARTMENT_ID'];
	} else {
		$bid = $bud[0]['COMPANY_ID'] . '000';
	} // end if

	//return $bid;
	$turner = $this->budget_feed_m->get($id);
	// return $turner;

	$numTurn = $this->get_employee_totals($id,$curr_year,'NTE');
	$amountTurn = $this->get_employee_totals($id,$curr_year,'ATS');

	if( count($numTurn) < 1 ){
		$numTurn = array(array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0));
	} // end if

	if( count($amountTurn) < 1 ){
		$amountTurn = array(array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0));
	} // end if

	$te['EMP_ID'] = $id;
	$te['EMPLID'] = "turnEmployees";
	$te['Year_id'] = $curr_year;
	$te['Ver_id'] = $this->globals_m->version_id();
	$te['Unit_id'] = $turner->COMPANY_ID;
	$te['Cust1_id'] = 55;
	$te['Cust2_id'] = 0;
	for( $o=1;$o<13;$o++){
		$te['P_'. $o] = 0;
	} // end for

	// CLEAR OUT EXISTING
    $this->db->where('Year_id',$curr_year)->where('EMP_ID',$te['EMP_ID'])->delete('pam_pm_out');

    // I. INSERT LINES OF NO PAY
    // Meals
    $te['Line_id'] = 6235;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $curr_year;
    $this->db->insert('pam_pm_out',$te);

    // 401K Contribution
    $te['Line_id'] = 6265;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $curr_year;
    $this->db->insert('pam_pm_out',$te);

    // Disability
    $te['Line_id'] = 6230;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $curr_year;
    $this->db->insert('pam_pm_out',$te);

    // Group Insurance
    $te['Line_id'] = 6225;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $curr_year;
    $this->db->insert('pam_pm_out',$te);

    // Other Benefits
    $te['Line_id'] = 6255;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $curr_year;
    $this->db->insert('pam_pm_out',$te);

    // Bonus
    $te['Line_id'] = 6195;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $curr_year;
    $this->db->insert('pam_pm_out',$te);

    // II. SALARY
    $te['Line_id'] = 6205;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $curr_year;
    for( $o=1;$o<13;$o++){
		$te['P_'. $o] = (float) $amountTurn[0]['P_'. $o];
	} // end for
	$this->db->insert('pam_pm_out',$te);

	// III. ADP Admin -- 6270
	$te['Line_id'] = 6270;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $curr_year;
    for( $o=1;$o<13;$o++){
		$te['P_'. $o] = (float) $numTurn[0]['P_'. $o] * (float) $this->globals_m->get_admin_adp();
	} // end for
	$this->db->insert('pam_pm_out',$te);

	// IV. 401K Admin -- 6260
	$te['Line_id'] = 6260;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $curr_year;
    for( $o=1;$o<13;$o++){
		$te['P_'. $o] = (float) $numTurn[0]['P_'. $o] * (float) $this->globals_m->get_admin_401k();
	} // end for
	$this->db->insert('pam_pm_out',$te);

	// IV. FICA & MEDICARE
	for( $o=1;$o<13;$o++){
		$totBennie['P_'.$o] = (float) $amountTurn[0]['P_'. $o];
	} // end for

	$te['Line_id'] = 6210;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $curr_year;

	$ficaMax = $this->globals_m->get_fica_max();
	$ficaRate = $this->globals_m->get_fica_rate();
	$medicareRate = $this->globals_m->get_medicare_rate();

	$fica_val = $this->globals_m->get_maxed_tax($totBennie,$ficaMax,$ficaRate);

	for($p=1;$p<13;$p++){
		$thisOne = ($fica_val[$p] + ( $totBennie['P_'.$p] * $medicareRate ));
		$te["P_".$p] = number_format($thisOne,2,".","");
	} // end for
	$this->db->insert('pam_pm_out',$te);

	// V. FUI & SUI  --> 6215
    $te['Line_id'] = 6215;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $curr_year;

    $fuiMax = $this->globals_m->get_fui_max();
	$fuiRate = $this->globals_m->get_fui_rate();
	$suiMax = $this->globals_m->get_sui_max($turner->EMP_STATE);
	$suiRate = $this->globals_m->get_sui_rate($turner->EMP_STATE);

	$fui_val = $this->globals_m->get_maxed_tax($totBennie,$fuiMax,$fuiRate);
	$sui_val = $this->globals_m->get_maxed_tax($totBennie,$suiMax,$suiRate);

	for($p=1;$p<13;$p++){
		$thisOne = ((float) $fui_val[$p] / 100 + (float) $sui_val[$p] / 100);
		$te["P_".$p] = number_format($thisOne,2,".","");
	} // end for
	$this->db->insert('pam_pm_out',$te);

	// VI. Workman's Comp  --> 6220
    $te['Line_id'] = 6220;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $curr_year;

    $wcRate = $this->budget_m->get_wcomp_rate($turner->EMP_STATE, $turner->JOB_ID);
    if(!$wcRate){$wcRate = 0;}
	$staffRate = $this->budget_m->get_staff_rate( $id );

    for($p=1;$p<13;$p++){
		$thisOne = ((float) $amountTurn[0]['P_'. $p] * $wcRate / 100);
		$te["P_".$p] = number_format($thisOne,2,".","");
	} // end for
    $this->db->insert('pam_pm_out',$te);

    return "completed budget_turn_emps function.";
} // end budget_turn_emps function
/**************************************************/
public function budget_turn_emp_by_bid($bid){
	// return $bid;
	$CY = $this->globals_m->current_year();
	$bud = $this->get_bud_info($bid);
	$bid = $bud[0]['id'];

	// return $bid;
	$turner = $this->budget_feed_m->get_turn_by_budget($bid);
	// return $turner;
	$id = $turner[0]['EMP_ID'];

	$numTurn = $this->get_employee_totals($id,$CY,'NTE');
	$amountTurn = $this->get_employee_totals($id,$CY,'ATS');

	if( count($numTurn) < 1 ){
		$numTurn = array(array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0));
	} // end if

	if( count($amountTurn) < 1 ){
		$amountTurn = array(array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0));
	} // end if

	$te['EMP_ID'] = $turner[0]['EMP_ID'];
	$te['EMPLID'] = "turnEmployees";
	$te['Year_id'] = $CY;
	$te['Ver_id'] = $this->globals_m->version_id();
	$te['Unit_id'] = $turner[0]['COMPANY_ID'];
	$te['Cust1_id'] = 55;
	$te['Cust2_id'] = 0;
	for( $o=1;$o<13;$o++){
		$te['P_'. $o] = 0;
	} // end for

	// CLEAR OUT EXISTING
    $this->db->where('Year_id',$CY)->where('EMP_ID',$te['EMP_ID'])->delete('pam_pm_out');

    // I. INSERT LINES OF NO PAY
    // Meals
    $te['Line_id'] = 6235;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $CY;
    $this->db->insert('pam_pm_out',$te);

    // 401K Contribution
    $te['Line_id'] = 6265;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $CY;
    $this->db->insert('pam_pm_out',$te);

    // Disability
    $te['Line_id'] = 6230;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $CY;
    $this->db->insert('pam_pm_out',$te);

    // Group Insurance
    $te['Line_id'] = 6225;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $CY;
    $this->db->insert('pam_pm_out',$te);

    // Other Benefits
    $te['Line_id'] = 6255;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $CY;
    $this->db->insert('pam_pm_out',$te);

    // Bonus
    $te['Line_id'] = 6195;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $CY;
    $this->db->insert('pam_pm_out',$te);

    // II. SALARY
    $te['Line_id'] = 6205;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $CY;
    for( $o=1;$o<13;$o++){
		$te['P_'. $o] = (float) $amountTurn[0]['P_'. $o];
	} // end for
	$this->db->insert('pam_pm_out',$te);

	// III. ADP Admin -- 6270
	$te['Line_id'] = 6270;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $CY;
    for( $o=1;$o<13;$o++){
		$te['P_'. $o] = (float) $numTurn[0]['P_'. $o] * (float) $this->globals_m->get_admin_adp();
	} // end for
	$this->db->insert('pam_pm_out',$te);

	// IV. 401K Admin -- 6260
	$te['Line_id'] = 6260;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $CY;
    for( $o=1;$o<13;$o++){
		$te['P_'. $o] = (float) $numTurn[0]['P_'. $o] * (float) $this->globals_m->get_admin_401k();
	} // end for
	$this->db->insert('pam_pm_out',$te);

	// IV. FICA & MEDICARE
	for( $o=1;$o<13;$o++){
		$totBennie['P_'.$o] = (float) $amountTurn[0]['P_'. $o];
	} // end for

	$te['Line_id'] = 6210;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $CY;

	$ficaMax = $this->globals_m->get_fica_max();
	$ficaRate = $this->globals_m->get_fica_rate();
	$medicareRate = $this->globals_m->get_medicare_rate();

	$fica_val = $this->globals_m->get_maxed_tax($totBennie,$ficaMax,$ficaRate);

	for($p=1;$p<13;$p++){
		$thisOne = ($fica_val[$p] + ( $totBennie['P_'.$p] * $medicareRate ));
		$te["P_".$p] = number_format($thisOne,2,".","");
	} // end for
	$this->db->insert('pam_pm_out',$te);

	// V. FUI & SUI  --> 6215
    $te['Line_id'] = 6215;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $CY;

    $fuiMax = $this->globals_m->get_fui_max();
	$fuiRate = $this->globals_m->get_fui_rate();
	$suiMax = $this->globals_m->get_sui_max($turner[0]['EMP_STATE']);
	$suiRate = $this->globals_m->get_sui_rate($turner[0]['EMP_STATE']);

	$fui_val = $this->globals_m->get_maxed_tax($totBennie,$fuiMax,$fuiRate);
	$sui_val = $this->globals_m->get_maxed_tax($totBennie,$suiMax,$suiRate);

	for($p=1;$p<13;$p++){
		$thisOne = ((float) $fui_val[$p] / 100 + (float) $sui_val[$p] / 100);
		$te["P_".$p] = number_format($thisOne,2,".","");
	} // end for
	$this->db->insert('pam_pm_out',$te);

	// VI. Workman's Comp  --> 6220
    $te['Line_id'] = 6220;
    $te['keyCol'] = $id . $te['Line_id'] . $te['Cust1_id'] . $CY;

    $wcRate = $this->budget_m->get_wcomp_rate($turner[0]['EMP_STATE'], $turner[0]['JOB_ID']);
    if(!$wcRate){$wcRate = 0;}
	$staffRate = $this->budget_m->get_staff_rate( $id );

    for($p=1;$p<13;$p++){
		$thisOne = ((float) $amountTurn[0]['P_'. $p] * $wcRate / 100);
		$te["P_".$p] = number_format($thisOne,2,".","");
	} // end for
    $this->db->insert('pam_pm_out',$te);

    return "completed budget_turn_emps function.";
} // end budget_turn_emps function
/**************************************************/
public function clear_out_budget($id){
	$CY = $this->globals_m->current_year();
	$bs = $this->db->where('BUDGET_ID', $id)->where('YEAR_ID',$CY)->delete('budget_storage');

	$q = $this->db->where('BUDGET_ID',$id)->get('budget_feed');
	if($q->num_rows() > 0) {
		foreach($q->result_array() as $xist){
			$xEmp = $xist['EMP_ID'];
			$arrUpdate = array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0);

		$es = $this->db->where('EMP_ID', $xEmp)->delete('employee_storage');
		$oo = $this->db->where('EMP_ID', $xEmp)->delete('overtime_out');
		$ppo = $this->db->where('EMP_ID', $xEmp)->update('pam_pm_out', $arrUpdate);
		$sa = $this->db->where('EMP_ID', $xEmp)->delete('salary_adjustment');
		$bf = $this->db->where('EMP_ID', $xEmp)->delete('budget_feed');
		} // end foreach
	} // end if
	return "completed!";
} // end clear_out_budget function
/**************************************************/
public function clear_out_department_budget($id){
	$CY = $this->globals_m->current_year();
	$co_id = substr($id,0,3);
	$de_id = substr($id,-2);

	$cSQL = "UPDATE pam_pm_out SET P_1 = 0, P_2 = 0, P_3 = 0, P_4 = 0, P_5 = 0, P_6 = 0, P_7 = 0, P_8 = 0, P_9 = 0, P_10 = 0, P_11 = 0, P_12 = 0 WHERE Unit_id = {$co_id} AND Cust1_id = {$de_id} AND Year_id = {$CY}";
	$this->db->query($cSQL);

	$dSQL = "DELETE FROM budget_feed WHERE EE_YEAR = {$CY} AND BUDGET_ID = {id}";
	$this->db->query($dSQL);
} // end clear_out_department_budget function
/**************************************************/
public function create_staffing_bonus($id){
	$curr_year = $this->globals_m->current_year();
	$kitty = array('DMB','IAI','LIB','LMB','RPI','RMB');
	$budget = $this->get_one_budget($id);
	$fiscal = $this->fiscal_m->get_fiscal_info($budget[0]['fiscalStart']);
	$job = $this->get_job_info('4229');
	
	if($budget[0]['fiscalStart'] == 0){
		$dtRehire = '20' . $curr_year . $fiscal[0]['fiscal_day_last'];
	} else {
		$dtRehire = '20' . (int) $curr_year + 1 . $fiscal[0]['fiscal_day_last'];
	} // end if
	
	$this->db->where('BUDGET_ID',$id)->where('YEAR_ID',$curr_year)->delete('budget_storage');
	
	for($sb=0;$sb<count($kitty);$sb++){
		$insArray = array(
			'BUDGET_ID' => $id,
			'YEAR_ID' => $curr_year,
			'CAT_ID' => $kitty[$sb],
			'P_1' => 0,
			'P_2' => 0,
			'P_3' => 0,
			'P_4' => 0,
			'P_5' => 0,
			'P_6' => 0,
			'P_7' => 0,
			'P_8' => 0,
			'P_9' => 0,
			'P_10' => 0,
			'P_11' => 0,
			'P_12' => 0
		);

		$this->db->insert('budget_storage', $insArray);
	} // end for

	$cmPercent = $this->globals_m->get_cm_bonus_qualifier();
    $cmFactor = $this->get_cm_bonus_factor( $id );
    $cmBonus = $cmPercent/100 * $cmFactor /12;
    $cmbTotal = $cmPercent/100 * $cmFactor;

	$insArray = array(
		'BUDGET_ID' => $id,
		'YEAR_ID' => $this->globals_m->current_year(),
		'CAT_ID' => 'CMB',
		'P_1' => $cmBonus,
		'P_2' => $cmBonus,
		'P_3' => $cmBonus,
		'P_4' => $cmBonus,
		'P_5' => $cmBonus,
		'P_6' => $cmBonus,
		'P_7' => $cmBonus,
		'P_8' => $cmBonus,
		'P_9' => $cmBonus,
		'P_10' => $cmBonus,
		'P_11' => $cmBonus,
		'P_12' => $cmBonus
	);
	$this->db->insert('budget_storage', $insArray);

	$bfArray = array(
			'EMPLID' => 'staffingBonus',
			'NAME' => 'Staffing Bonus',
			'BUDGET_ID' => $id,
			'EE_STATUS' => 'S',
			'EE_YEAR' => $curr_year,
			'NEW_EMP' => 'N',
			'EMP_REPLACE' => 'N',
			'HIRE_DATE' => '20' . $curr_year . $fiscal[0]['fiscal_day_one'],
			'START_DATE' => $dtRehire,
			'REHIRE_DATE' => $dtRehire,
			'COMPANY_ID' => substr($id,0,3),
			'DEPARTMENT_ID' => 41,
			'EMP_STATE' => $budget[0]['emp_state'],
			'REG_TEMP' => 'R',
			'FULL_PART' => 'F',
			'EE_TYPE' => 'S',
			'ANNUAL_RATE' => $cmbTotal,
			'STIPEND_AMOUNT' => 0,
			'HOURLY_RATE' => $cmbTotal/2080,
			'ADJUSTED_HOURLY_RATE' => $cmbTotal/2080,
			'JOB_ID' => '4229',
			'HOME_JOBCOST_NO' => '42296197',
			'WORKERS_COMP_CODE' => $budget[0]['emp_state'].'4229',
			'PERCENTAGE_401K' => 0,
			'GRP_INS_MONTHLY_EXPENSE' => 0,
			'GRP_INS_TYPE' => 'None',
			'HOME_OFFICE_BONUS_PERCENTAGE' => 0,
			'CA_RAD' => 'N',
			'HAS_OVERTIME' => 'N',
			'IS_DINING_EMP' => 'N',
			'IS_MEAL_ELIGIBLE' => 'N',
			'HAS_BONUS' => 'Y',
			'ALLOC_TOTAL' => 100,
			'ESPP' => 0,
			'FSA' => 'N',
			'LAST_EDIT' => '',
			'HAS_END_DATE' => 'N'
	);

	$this->db->where('NAME', 'Staffing Bonus')->where('COMPANY_ID',substr($id,0,3))->where('EE_YEAR',$curr_year)->delete('budget_feed');
	$this->db->insert('budget_feed', $bfArray);
	$generated_empid = $this->db->insert_id();

	$budg = $this->budget_staffing_bonus($generated_empid);
	return $budg;
} // end create_staffing_bonus function
/**************************************************/
public function create_streetteam_emp($id){
	//return $id;
	$curr_year = $this->globals_m->current_year();

	$budget = $this->get_one_budget($id);
	$fiscal = $this->fiscal_m->get_fiscal_info($budget[0]['fiscalStart']);
	$job = $this->get_job_info('4155');
	//return $job;

	if($budget[0]['fiscalStart'] == 0){
		$dtRehire = '20' . $curr_year . $fiscal[0]['fiscal_day_last'];
	} else {
		$dtRehire = '20' . (int) $curr_year + 1 . $fiscal[0]['fiscal_day_last'];
	} // end if

	$teArray = array(
			'EMPLID' => 'streetTeam',
			'NAME' => 'Temp Help G&A',
			'BUDGET_ID' => $id,
			'EE_STATUS' => 'W',
			'EE_YEAR' => $curr_year,
			'NEW_EMP' => 'N',
			'EMP_REPLACE' => 'N',
			'HIRE_DATE' => '20' . $curr_year . $fiscal[0]['fiscal_day_one'],
			'START_DATE' => $dtRehire,
			'REHIRE_DATE' => $dtRehire,
			'COMPANY_ID' => substr($id,0,3),
			'DEPARTMENT_ID' => 41,
			'EMP_STATE' => $budget[0]['emp_state'],
			'REG_TEMP' => 'T',
			'FULL_PART' => 'P',
			'EE_TYPE' => 'H',
			'ANNUAL_RATE' => 0,
			'STIPEND_AMOUNT' => 0,
			'HOURLY_RATE' => 0,
			'ADJUSTED_HOURLY_RATE' => 0,
			'JOB_ID' => '4155',
			'HOME_JOBCOST_NO' => '41556205',
			'WORKERS_COMP_CODE' => $budget[0]['emp_state'].'4155',
			'PERCENTAGE_401K' => 0,
			'GRP_INS_MONTHLY_EXPENSE' => 0,
			'GRP_INS_TYPE' => 'None',
			'HOME_OFFICE_BONUS_PERCENTAGE' => 0,
			'CA_RAD' => 'N',
			'HAS_OVERTIME' => 'N',
			'IS_DINING_EMP' => 'N',
			'IS_MEAL_ELIGIBLE' => 'N',
			'HAS_BONUS' => 'N',
			'ALLOC_TOTAL' => 100,
			'ESPP' => 0,
			'FSA' => 'N',
			'LAST_EDIT' => '',
			'HAS_END_DATE' => 'N'
	);
	//return $teArray;

	$this->db->where('NAME', 'Temp Help G&A')->where('COMPANY_ID',substr($id,0,3))->where('EE_YEAR',$curr_year)->delete('budget_feed');
	$this->db->insert('budget_feed', $teArray);
	$generated_empid = $this->db->insert_id();

	$budg = $this->budget_streetteam_emp($generated_empid);
	return $budg;
} // end create_turn_employee function
/**************************************************/
public function create_turn_emp($id){
	//return $id;
	$curr_year = $this->globals_m->current_year();

	$budget = $this->get_one_budget($id);
	$fiscal = $this->fiscal_m->get_fiscal_info($budget[0]['fiscalStart']);
	$job = $this->get_job_info('5514');

	if($budget[0]['fiscalStart'] == 0){
		$dtRehire = '20' . $curr_year . $fiscal[0]['fiscal_day_last'];
	} else {
		$dtRehire = '20' . (int) $curr_year + 1 . $fiscal[0]['fiscal_day_last'];
	} // end if

	$teArray = array(
			'EMPLID' => 'turnEmployees',
			'NAME' => 'TEMPORARY LABOR -- TURN',
			'BUDGET_ID' => $id,
			'EE_STATUS' => 'X',
			'EE_YEAR' => $curr_year,
			'NEW_EMP' => 'N',
			'EMP_REPLACE' => 'N',
			'HIRE_DATE' => '20' . $curr_year . $fiscal[0]['fiscal_day_one'],
			'START_DATE' => $dtRehire,
			'REHIRE_DATE' => $dtRehire,
			'COMPANY_ID' => substr($id,0,3),
			'DEPARTMENT_ID' => 55,
			'EMP_STATE' => $budget[0]['emp_state'],
			'REG_TEMP' => 'T',
			'FULL_PART' => 'P',
			'EE_TYPE' => 'H',
			'ANNUAL_RATE' => 0,
			'STIPEND_AMOUNT' => 0,
			'HOURLY_RATE' => 0,
			'ADJUSTED_HOURLY_RATE' => 0,
			'JOB_ID' => '5514',
			'HOME_JOBCOST_NO' => '55146205',
			'WORKERS_COMP_CODE' => $budget[0]['emp_state'].'5514',
			'PERCENTAGE_401K' => 0,
			'GRP_INS_MONTHLY_EXPENSE' => 0,
			'GRP_INS_TYPE' => 'None',
			'HOME_OFFICE_BONUS_PERCENTAGE' => 0,
			'CA_RAD' => 'N',
			'HAS_OVERTIME' => 'N',
			'IS_DINING_EMP' => 'N',
			'IS_MEAL_ELIGIBLE' => 'N',
			'HAS_BONUS' => 'N',
			'ALLOC_TOTAL' => 100,
			'ESPP' => 0,
			'FSA' => 'N',
			'LAST_EDIT' => '',
			'HAS_END_DATE' => 'N'
	);

	$this->db->where('NAME', 'TEMPORARY LABOR -- TURN')->where('COMPANY_ID',substr($id,0,3))->where('EE_YEAR',$curr_year)->delete('budget_feed');
	$this->db->insert('budget_feed', $teArray);
	$generated_empid = $this->db->insert_id();
	//return $generated_empid;

	$budg = $this->budget_turn_emp($generated_empid);
	return $budg;
} // end create_turn_employee function
/**************************************************/
public function determine_company_type_from_emp($id){
	return $id;
} // end determine_company_type_from_emp function
/**************************************************/
public function determineValidPeriods($emp) {
	//return $emp;
	$this->load->helper('date');

	$budget = $this->get_bud_info($emp[0]['BUDGET_ID']);

	$curr_year = $this->globals_m->current_year();
	$currentYear = (int) '20' . $curr_year;
	$fiscal_start = $budget[0]['fiscal_start'];
	
	$impStartDate = date('m/d/Y', strtotime($emp[0]['START_DATE']));
	$empStartDate = strtotime($emp[0]['START_DATE']);
	list($hd1,$hd2,$hd3) = explode('/', $impStartDate );

	$impRehireDate = date('m/d/Y', strtotime($emp[0]['REHIRE_DATE']));
	$empEndDate = strtotime($emp[0]['REHIRE_DATE']);
	list($rhd1,$rhd2,$rhd3) = explode('/', $impRehireDate );

	$COMPANY_ID = $emp[0]['COMPANY_ID'];
	//$subsequentYear = $currentYear + 1;

	$TVP[0] = $VP[0] = 0;
	
    for($x=1;$x<25;$x++){
        $dtBudget[$x] = mktime(0, 0, 0, $x, 1, (int) $currentYear);
        if( $dtBudget[$x] >= $empStartDate && $dtBudget[$x] <= $empEndDate ){
	   		$TVP[$x] = 1;
        } else {
	   		$TVP[$x] =0;
        } // end if
    } // end for
     
     $hdNumDays = days_in_month( (int) $hd1 );
     $rhdNumDays = days_in_month( (int) $rhd1 );
     
     $TVP[ (int) $hd1 ] = ( (($hdNumDays - (int) $hd2) + 1 ) / $hdNumDays);
     
    if( (int) $rhd3 == (int) $currentYear ){
	 	$TVP[ (int) $rhd1] = (int) $rhd2/$rhdNumDays;    
    } elseif ( (int) $rhd3 == (int) $currentYear + 1) {
		$TVP[ (int) $rhd1 + 12 ] = (int) $rhd2/$rhdNumDays;
    } // end if

    $fym = (int) $fiscal_start + 1;

    for($l=1;$l<13;$l++){
    	$VP["P_".$l] = $TVP[$fym];
    	$fym++;
    } // end for

	return $VP;
} // end function
/**************************************************/
public function determineValidStipend($emp,$yr){
	$budget_id = $emp[0]['COMPANY_ID'] . '000';
	$budget = $this->get_bud_info($budget_id);

	$full_part = $budget[0]['FULL_PART'];
	if( $full_part != 'M'){
		return array(array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0));
	} else {
		$query = $this->db->where('EMP_ID', $emp)
	                  ->where('YEAR_ID',$yr)
	                  ->where('CAT_ID','VSM')
	                  ->get('employee_storage');
	return $query->result_array();
	} // end if
} // end determineValidStipend function
/**************************************************/
public function fetch_fiscal_departments(){
	$query = $this->db->select('id')->where_in('companyTypeID',array(1,2))->order_by('id')->get('budgets');
	return $query->result_array();
} // end fetch_fiscal_departments function
/**************************************************/
public function fetch_fiscal_norm(){
	$query = $this->db->select('id')->where('fiscalStart',0)->where_in('companyTypeID',array(3,4,5,6))->order_by('id')->get('budgets');
	return $query->result_array();
} // end fetch_fiscal_norm function
/**************************************************/
public function fetch_fiscal_other(){
	$query = $this->db->select('id')->where('fiscalStart !=',0)->where_in('companyTypeID',array(3,4,5,6))->order_by('id')->get('budgets');
	return $query->result_array();
} // end fetch_fiscal_norm function
/**************************************************/
public function fetch_job($jc){
	$q = $this->db->select('jobTitle')->where('jobCode',$jc)->get('jobcodes');
	return $q->row('jobTitle');
} // end fetch_job function
/**************************************************/
public function getACR($job){
	$q = $this->db->select('accountCrossReference')->where('jobCode', $job)->get('jobcodes');
	return $q->row('accountCrossReference');
} // end getACR function
/**************************************************/
public function get_ACR_by_id($id){
	$sql = "SELECT RIGHT([HOME_JOBCOST_NO],4) AS ACR FROM [budget_feed] WHERE [EMP_ID] = {$id}";
	$q = $this->db->query($sql);
	return $q->row('ACR');
} // end get_ACR_by_id function
/**************************************************/
public function get_bf_emp($id){
	return $this->budget_feed_m->get($id);
} // end get_bf_emp function
/**************************************************/
public function get_bonus_from_pmout($id,$yr){
	$q = $this->db->where('EMP_ID',$id)->where('Year_id',$yr)->where('Line_id',6195)
	              ->get('pam_pm_out');
	return $q->result_array();
} // end get_fica_bonus function
/**************************************************/
public function get_budget_from_emp($id){
	$q = $this->db->select('COMPANY_ID, DEPARTMENT_ID')->where('EMP_ID',$id)->get('budget_feed');
	return $q->result_array();
} // end get function
/**************************************************/
public function get_budget_groups($userID){
	$query = $this->db->select('accessGroupID')->where('userID',$userID)->get('bridge_UserToGroup');
	return $query->result_array();
} // end get_budget_groups function
/**************************************************/
public function get_bud_info($budget_id){
	$sql = "SELECT B.*, FR.fiscal_start, FR.fiscal_day_one, FR.fiscal_day_last, FR.P_1, FR.P_1_a, FR.P_2, FR.P_2_a, FR.P_3, FR.P_3_a, FR.P_4, FR.P_4_a, FR.P_5, FR.P_5_a, FR.P_6, FR.P_6_a, FR.P_7, FR.P_7_a, FR.P_8, FR.P_8_a, FR.P_9, FR.P_9_a, FR.P_10, FR.P_10_a, FR.P_11, FR.P_11_a, FR.P_12, FR.P_12_a FROM budgets B JOIN fiscal_reference FR ON B.fiscalStart = FR.id WHERE B.id = {$budget_id}";
	$q = $this->db->query($sql);
	$results = $q->result_array();
	// echo $this->db->last_query(); die();
	return $results;
} // end get_bud_info function
/**************************************************/
public function get_cm_bonus_factor($id){
	$q = $this->db->select('cmBonus')->where('id',$id)->get('budgets');
	return $q->row('cmBonus');
} // end get_cm_bonus_factor function
/**************************************************/
public function get_department_dd($co_type){
	switch((int)$co_type){
		case 2:
			$q = $this->db->select('deptCode,Department')->where('companyTypeID','2')->where_in('deptCode',array(31,32))->order_by('deptCode')->get('departments');
			break;
		case 4:
			$q = $this->db->select('deptCode,Department')->where_in('companyTypeID',array(3,4))->order_by('deptCode')->get('departments');
			break;
		case 5:
			$q = $this->db->select('deptCode,Department')->where_in('companyTypeID',array(3,5))->order_by('deptCode')->get('departments');
			break;
		case 6:
			$q = $this->db->select('deptCode,Department')->where_in('companyTypeID',array(3,4,5))->order_by('deptCode')->get('departments');
			break;
		default:
			$q = $this->db->select('deptCode,Department')->where('companyTypeID',$co_type)->order_by('deptCode')->get('departments');
			break;
	} // end switch
	
	$data['0'] = "Please Select";
	foreach ($q->result() as $row) {
		$data[ $row->deptCode ] = $row->deptCode . ' -- ' . $row->Department;
	} // end foreach
	return $data;
} // end get_department_dd function
/**************************************************/
public function get_dev_bonus_from_pmout($id,$yr){
	$q = $this->db->where('EMP_ID',$id)->where('Year_id',$yr)->where('Line_id',6200)
	              ->get('pam_pm_out');
	return $q->result_array();
} // end get_fica_bonus function
/**************************************************/
public function get_dining_by_jobcode($jc){
	$q = $this->db->select('Company_Dept')->where('jobCode',$jc)->get('jobcodes');
	return $q->row('Company_Dept');
} // end test_if_dining_by_jobcode function
/*-----------------------------------------------------*/
public function get_emp_bud_info($id){
	$query = $this->db->where('EMP_ID',$id)->get('budget_feed');
	$pm['emp'] = $query->result_array();
	return $pm;

	$budget_id = $pm['emp'][0]['COMPANY_ID'].'000';

	$q = $this->db->join('fiscal_reference FR','B.fiscalStart = FR.id')->where('B.id',$budget_id)->get('budgets B');
	$pm['budget'] = $q->result_array();
	return $pm;
} // end get_emp_bud_info function
/**************************************************/
public function get_emp_info($id){
	$query = $this->db->where('EMP_ID',$id)->get('budget_feed');
	return $query->result_array();
} // end get_emp_info function
/**************************************************/
public function get_emps_for_budget($id){
	$co_id = substr($id,0,3);
	$de_id = substr($id,-2);

	if( (int)$co_id < 499 || (int)$co_id > 599 ){
		// property
		$q = $this->db->where('EE_YEAR',$this->globals_m->current_year())
	              ->where('COMPANY_ID', substr($id,0,3))
	              ->where('EE_STATUS', 'B')
	              ->get('budget_feed');
	} else {
		//corporate
		$q = $this->db->where('EE_YEAR',$this->globals_m->current_year())
	              ->where('COMPANY_ID', substr($id,0,3))
	              ->where('DEPARTMENT_ID', $de_id)
	              ->where('EE_STATUS', 'B')
	              ->get('budget_feed');
	} // end if
	return $q->result_array();
} // end get_emps_for_budget function
/**************************************************/
public function get_employee_totals($id, $yr, $symbol){
	$q = $this->db->where('EMP_ID', $id)
	                  ->where('YEAR_ID',$yr)
	                  ->where('CAT_ID',$symbol)
	                  ->get('employee_storage');
	return $q->result_array();
} // end get_employee_totals function
/**************************************************/
public function get_employee_period_totals($id, $yr, $symbol){
	$q = $this->db->select('P_1,P_2,P_3,P_4,P_5,P_6,P_7,P_8,P_9,P_10,P_11,P_12')
	            ->where('EMP_ID', $id)
	            ->where('YEAR_ID',$yr)
	            ->where('CAT_ID',$symbol)
	            ->get('employee_storage');
	return $q->result_array();
} // end get_employee_period_totals function
/**************************************************/
public function get_hr_emp($id){
	$q = $this->db->where('EMPLID', $id)->get('hr_feed');

	if ($q->num_rows() > 0) {
	    foreach($q->result_array() as $imp){
	        $data[] = $imp;
	    } // end foreach
	    return $data;
	} // end if
	return false;
} // end get_existing_emp function
/**************************************************/
public function get_fiscal_by_id($id){
	$q = $this->db->select('fiscalStart')->where('id', $id)->get('budgets');
	return $q->row('fiscalStart');
} // end get_fiscal_by_id function
/**************************************************/
public function get_job_info($id){
	$query = $this->db->where('jobCode', $id)->get('jobcodes');
	return $query->result_array();
} // end get_job_info function
/**************************************************/
public function get_jobs_in_department($dept){
	$sql = "SELECT jobCode,jobTitle FROM jobcodes WHERE Company_Dept LIKE '%{$dept}' ORDER BY jobCode ASC";
	$q = $this->db->query($sql);

	if($q->num_rows() > 0) {
		$jobInfo_dd = '<select name="title" id="title" class="span6">';
	  	$jobInfo_dd .= '<option value="">Please select a job title...</option>';
	    foreach($q->result_array() as $jobInfo) {
		 	$jobInfo_dd .= '<option value="'.$jobInfo['jobCode'].'">'.$jobInfo['jobCode'].' - '.$jobInfo['jobTitle'].'</option>';
	    } //end foreach
	  	$jobInfo_dd .= '</select>';
       return $jobInfo_dd;
    } //end if
} // end get_jobs_in_department function
/**************************************************/
public function get_monthly_rate($id, $yr){
	$pm = $this->get_emp_bud_info($id);
	$adjustments = $this->get_salary_adjustments($id);

	if( !$adjustments ){
		$ajs = $pm['emp'][0]['ADJUSTED_HOURLY_RATE'];
		$adjustments = array((array('P_1'=>$ajs,'P_2'=>$ajs,'P_3'=>$ajs,'P_4'=>$ajs,'P_5'=>$ajs,'P_6'=>$ajs,'P_7'=>$ajs,'P_8'=>$ajs,'P_9'=>$ajs,'P_10'=>$ajs,'P_11'=>$ajs,'P_12'=>$ajs)));
	} // end if
	
	return $adjustments;
} // end get_monthly_rate function
/**************************************************/
public function get_monthly_stipend($id, $yr){
	$pm = $this->get_emp_bud_info($id);

	$stipend = $this->budget_m->get_employee_period_totals($id,$pm['emp'][0]['EE_YEAR'],'PSA');

	if( !$stipend ){
		$ajs = $pm['emp'][0]['STIPEND_AMOUNT'];
		$stipend = array((array('P_1'=>$ajs,'P_2'=>$ajs,'P_3'=>$ajs,'P_4'=>$ajs,'P_5'=>$ajs,'P_6'=>$ajs,'P_7'=>$ajs,'P_8'=>$ajs,'P_9'=>$ajs,'P_10'=>$ajs,'P_11'=>$ajs,'P_12'=>$ajs)));
	} // end if
	
	return $stipend;
} // end get_monthly_stipend function
/**************************************************/
public function get_one_budget($id){
	$q = $this->db->where('id', $id)->get('budgets');
	return $q->result_array();
} // end get_one_budget function
/**************************************************/
public function get_possible_budgets($groups){
	$query = "SELECT id FROM dbo.budgets WHERE accessGroupID IN ({$groups}) ORDER BY id";
	$q = $this->db->query($query);
	return $q->result_array();
} // end get_possible_budgets function
/**************************************************/
public function get_possible_budgets_dd($groups){
	$sql = "SELECT id,name FROM dbo.budgets WHERE accessGroupID IN ({$groups}) ORDER BY id";
	$q = $this->db->query($sql);
	
	if( $q->num_rows() > 0) {
		$data[0] = "To change budget, select ... ";
		foreach( $q->result() as $row ){
			$data[$row->id] = $row->name;
		} //end foreach
		return $data;
	} // end if
} // end get_possible_budgets_dd function
/**************************************************/
public function get_salary_adjustments($id){
	$q = $this->db->where('EMP_ID', $id)->where('EE_TYPE !=','M')->limit(1)->get('salary_adjustment');

	if ($q->num_rows() > 0) {
	    foreach($q->result_array() as $adj){
	        $data[] = $adj;
	    } // end foreach
	    return $data;
	} // end if
	return false;
} // end get_salary_adjustments function
/**************************************************/
public function get_salary_period_adjustments($id){
	$q = $this->db->select('P_1,P_2,P_3,P_4,P_5,P_6,P_7,P_8,P_9,P_10,P_11,P_12')->where('EMP_ID', $id)->get('salary_adjustment');

	if ($q->num_rows() > 0) {
	    foreach($q->result_array() as $adj){
	        $data[] = $adj;
	    } // end foreach
	    return $data;
	} // end if
	return false;
} // end get_salary_period_adjustments function
/**************************************************/
public function get_salary_from_pmout($id,$yr){
	$Line_id = $this->get_ACR_by_id($id);
	$q = $this->db->where('EMP_ID',$id)->where('Year_id',(int)$yr)->where('Line_id',$Line_id)
	              ->get('pam_pm_out');
	return $q->result_array();
} // end get_salary_from_pmout function
/**************************************************/
public function get_salary_periods_from_pmout($id,$yr){
	$Line_id = $this->get_ACR_by_id($id);
	$q = $this->db->select('P_1,P_2,P_3,P_4,P_5,P_6,P_7,P_8,P_9,P_10,P_11,P_12')
	              ->where('EMP_ID',$id)->where('Year_id',(int)$yr)->where('Line_id',$Line_id)
	              ->get('pam_pm_out');
	return $q->result_array();
} // end get_salary_periods_from_pmout function
/**************************************************/
public function get_staffing_bonus($bud_id, $symbol){
	$curr_year = $this->globals_m->current_year();
	$q = $this->db->where('BUDGET_ID', $bud_id)
	              ->where('YEAR_ID',$curr_year)
	              ->where('CAT_ID',$symbol)
	              ->get('budget_storage');
	return $q->result_array();
} // end get_staffing_bonus function
/**************************************************/
public function get_staff_rate($budget_id){
	$q = $this->db->select('staffRateByMonth')->where('id', $budget_id)->get('budgets');
	return $q->row('staffRateByMonth');
} // end get_staff_rate function
/**************************************************/
public function get_stipend_adjustments($id){
	$q = $this->db->where('EMP_ID', $id)->where('EE_TYPE =','M')->get('salary_adjustment');

	if ($q->num_rows() > 0) {
	    foreach($q->result_array() as $adj){
	        $data[] = $adj;
	    } // end foreach
	    return $data;
	} // end if
	return false;
} // end get_stipend_adjustments function
/**************************************************/
public function get_wcomp_rate($state, $jobCode){
	$sql = "SELECT ratePerHundred FROM jobcodes jc JOIN workerscompensationrates w on jc.wcClassCode = w.wcClassCode WHERE jc.jobCode = {$jobCode} AND LEFT(w.code, 2) = '{$state}'";
	$q = $this->db->query($sql);
	return $q->row('ratePerHundred');
} // end get_wcomp_rate function
/**************************************************/
public function get_WC_code($state, $jobCode){
	$sql = "SELECT wcClassCode FROM workerscompensationrates WHERE code LIKE '{$state}%' AND wcClassCode = ( SELECT wcClassCode FROM jobcodes WHERE jobCode = {$jobCode} )";
	$q = $this->db->query($sql);
	return $q->row('code');
} // end get_WC_code function
/**************************************************/
public function get_WCP_code($state, $jobCode){
	$sql = "SELECT code FROM workerscompensationrates WHERE code LIKE '{$state}%' AND wcClassCode = ( SELECT wcClassCode FROM jobcodes WHERE jobCode = {$jobCode} )";
	$q = $this->db->query($sql);
	return $q->row('code');
} // end get_WC_code function
/**************************************************/
public function get_workers_comp($value){
	$q = $this->db->select('ratePerHundred')->where('wcClassCode',$value)->get('workerscompensationrates');
   	return $q->row('ratePerHundred');
} // end get_workers_comp function
/**************************************************/
public function return_copied_budget($emp, $id){
	// return $id;
	$curr_year = $this->globals_m->current_year();
	
	$newbie = array();
	
	$budget = $this->get(substr($emp['HOME_DEPT'],0,3).'000'); // OBJECT
	$fiscal = $this->fiscal_m->get($budget->fiscalStart, TRUE); // OBJECT

	if($budget->fiscalStart == 0){
		$dtStart = '20' . $curr_year . $fiscal->fiscal_day_one;
		$dtRehire = '20' . $curr_year . $fiscal->fiscal_day_last;
	} else {
		$dtStart = '20' . $curr_year . $fiscal->fiscal_day_one;
		$dtRehire = '20' . (int) $curr_year + 1 . $fiscal->fiscal_day_last;
	} // end if

	$annie = (float) $emp['ANNUAL_RATE'];
	$monie = (float) $emp['STIPEND_AMOUNT'];
	$hrlie = (float) $emp['HOURLY_RATE'];

	//NO ANNUAL FROM HR
	if( !$annie || $annie == 0 ){
		//HR PROVIDES ONLY STIPEND
		if( !$hrlie || $hrlie == 0 ){
			$annie = (float)$monie * 12;
		} else {
			$annie = (float)$hrlie * 173.3333 * 12;
		} // end if
	} // end if

	//NO HOURLY FROM HR
	if( !$hrlie || $hrlie == 0 ){
		//HR PROVIDES ONLY STIPEND
		if( !$annie || $annie == 0 ){
			$hrlie = (float) $monie/173.3333;
		} else {
			$hrlie = (float)$annie/173.3333 * 12;
		} // end if
	} // end if

	$newbie['EMPLID']               = $emp['EMPLID'];
	$newbie['NAME']                 = $emp['NAME'];
	$newbie['BUDGET_ID']            = $id;
	$newbie['EE_STATUS']            = "B";
	$newbie['EE_YEAR']              = $this->globals_m->current_year();
	$newbie['NEW_EMP']              = "N";
	$newbie['EMP_REPLACE']          = "N";
	$newbie['HIRE_DATE']            = date('Y-m-d', strtotime($emp['HIRE_DATE']));
	$newbie['START_DATE']           = $dtStart;
	$newbie['REHIRE_DATE']          = $dtRehire;
	$newbie['COMPANY_ID']           = substr($emp['HOME_DEPT'],0,3);
	$newbie['DEPARTMENT_ID']        = substr($emp['HOME_DEPT'],-2);
	$newbie['EMP_STATE']            = substr($emp['JOB_CODE'],-2);
	$newbie['REG_TEMP']             = $emp['REG_TEMP'];
	$newbie['FULL_PART']            = $emp['FULL_PARTTIME'];
	$newbie['EE_TYPE']              = $emp['EE_TYPE'];
	$newbie['ANNUAL_RATE']          = $annie;
	$newbie['STIPEND_AMOUNT']       = $monie;
	$newbie['HOURLY_RATE']          = $hrlie;
	$newbie['ADJUSTED_HOURLY_RATE'] = $hrlie;
	$newbie['JOB_ID']               = substr($emp['JOB_CODE'],0,4);

	if ( (int) $newbie['JOB_ID'] == 4132 ||  (int) $newbie['JOB_ID'] == 4133) { // is an CA
	    $newbie['FULL_PART'] = "P";
	   	$newbie['EE_TYPE'] = "M";
    } // end if

	$newbie['HOME_JOBCOST_NO']              = substr($emp['JOB_CODE'],0,4) . $this->getACR(substr($emp['JOB_CODE'],0,4));
	$newbie['WORKERS_COMP_CODE']            = $emp['WORKERS_COMP_CODE'];
	$newbie['PERCENTAGE_401K']              = $emp['PERCENTAGE_401K'];
	$newbie['GRP_INS_MONTHLY_EXPENSE']      = $emp['GROUP_INS_MONTHLY_EXPENSE'];
	$newbie['GRP_INS_TYPE']                 = $emp['GROUP_INS_TYPE'];
	$newbie['HOME_OFFICE_BONUS_PERCENTAGE'] = $emp['HOME_OFFICE_BONUS_PERCENTAGE'];
	$newbie['ESPP']                         = ( !$emp['ESPP'] ? 0 : $emp['ESPP']);
	$newbie['FSA']                          = ( !$emp['FSA'] ? 'N' : $emp['FSA']) ;
	$newbie['CA_RAD']                       = "N";
	$newbie['HAS_OVERTIME']                 = "N";
	$newbie['IS_DINING_EMP']                = "N";
	$newbie['IS_MEAL_ELIGIBLE']             = "N";
	$newbie['HAS_BONUS']                    = "N";
	$newbie['ALLOC_TOTAL']                  = 100;
	$newbie['LAST_EDIT']                    = "";
	$newbie['HAS_END_DATE']                 = "N";

	$xist = $this->budget_feed_m->get_by( array('EMPLID' => $newbie['EMPLID'], 'EE_YEAR' => $newbie['EE_YEAR'] ));

	if( $xist):
		return $xist[0]->EMP_ID;
	else:
		$new_id = $this->budget_feed_m->save($newbie);
		return $new_id;
	endif;
} // end return_copied_budget function
/**************************************************/
public function return_user_budgets($user){
	$out = array();
	$fiscal_norm = $this->budget_m->fetch_fiscal_norm();
	$fiscal_other = $this->budget_m->fetch_fiscal_other();
	$fiscal_departments  = $this->budget_m->fetch_fiscal_departments();

	switch($user['access_group']){
		case 1:
			$accessable = array( $user['default_budget']);
			break;
		case 777:
		case 888:
		case 999:
			$groups = $this->budget_m->get_budget_groups($user['access_group']);
			foreach( $groups as $group){ array_push($out, $group['accessGroupID']); }
			$grps = implode(',', $out);
			$accessable = $this->budget_m->get_possible_budgets($grps);
			break;
		default:
			$accessable = $this->budget_m->get_possible_budgets($user['access_group']);
	} // end switch

	$cntBudgets = count($accessable);
	if( $cntBudgets > 1 ){
		for( $b=0;$b<$cntBudgets;$b++ ){
			if( in_array($accessable[$b], $fiscal_norm)){
				$avail_budgets[0][$b] = $accessable[$b];
			} elseif( in_array($accessable[$b], $fiscal_other)) {
				$avail_budgets[1][$b] = $accessable[$b];
			} else {
				$avail_budgets[2][$b] = $accessable[$b];
			} // end if
		} // end foreach
	} else{
		$avail_budgets[0] = $accessable;
	}

	return $avail_budgets;
} // end return_user_budgets function
/**************************************************/
public function save_for_pm($arr){
	$this->load->model('pam_out_m');
	$this->db->delete('pam_pm_out', array('keyCol' => $arr['keyCol']));
	$id = $this->pam_out_m->save($arr);
	return $id;
} // end save_for_pm function
/**************************************************/
public function save_storage($arr){
	$id = $this->db->insert('employee_storage',$arr);
	return $id;
} // end save_storage function
/**************************************************/
public function status_set_approved($id){
	$updArray = array('pam_status' => '3');
    $this->db->where('id',$id)->update('budgets',$updArray);
} // end status_set_approved function
/**************************************************/
public function status_set_archived($id){
	$updArray = array('pam_status' => '4');
    $this->db->where('id',$id)->update('budgets',$updArray);
} // end status_set_archived function
/**************************************************/
public function status_set_initial($id){
	$updArray = array('pam_status' => '0');
    $this->db->where('id',$id)->update('budgets',$updArray);
} // end status_set_initial function
/**************************************************/
public function status_set_atm_open($id){
	$updArray = array('atm_status' => '1');
    $this->db->where('id',$id)->update('budgets',$updArray);
} // end status_set_atm_open function
/**************************************************/
public function status_set_open($id){
	$updArray = array('pam_status' => '1');
    $this->db->where('id',$id)->update('budgets',$updArray);
} // end status_set_open function
/**************************************************/
public function status_set_atm_approved($id){
	$updArray = array('atm_status' => '3');
    $this->db->where('id',$id)->update('budgets',$updArray);
} // end status_set_atm_approved function
/**************************************************/
public function status_set_atm_submitted($id){
	$updArray = array('atm_status' => '2');
    $this->db->where('id',$id)->update('budgets',$updArray);
} // end status_set_atm_submitted function
/**************************************************/
public function status_set_pam_submitted($id){
	$updArray = array('pam_status' => '2');
    $this->db->where('id',$id)->update('budgets',$updArray);
} // end status_set_submitted function
/**************************************************/
public function status_set_sam_approved($id){
	$updArray = array('sam_status' => '3');
    $this->db->where('id',$id)->update('budgets',$updArray);
} // end status_set_sam_approved function
/**************************************************/
public function status_set_sam_open($id){
	$updArray = array('sam_status' => '1');
    $this->db->where('id',$id)->update('budgets',$updArray);
} // end status_set_sam_open function
/**************************************************/
public function status_set_sam_submitted($id){
	$updArray = array('sam_status' => '2');
    $this->db->where('id',$id)->update('budgets',$updArray);
} // end status_set_sam_submitted function
/**************************************************/
public function update_staffing_bonus($id, $symbol, $arr){
	$current_year = $this->globals_m->current_year();
	$q = $this->db->where('YEAR_ID',$current_year)->where('BUDGET_ID', $id)->where('CAT_ID',$symbol)->get('budget_storage');

	if( count($q->result_array()) == 0 ){
		$insArray = array(
			'BUDGET_ID' => $id,
			'YEAR_ID' => $current_year,
			'CAT_ID' => $symbol,
			'P_1' => $arr['P_1'],
      		'P_2' => $arr['P_2'],
      		'P_3' => $arr['P_3'],
      		'P_4' => $arr['P_4'],
      		'P_5' => $arr['P_5'],
      		'P_6' => $arr['P_6'],
      		'P_7' => $arr['P_7'],
      		'P_8' => $arr['P_8'],
      		'P_9' => $arr['P_9'],
      		'P_10' => $arr['P_10'],
      		'P_11' => $arr['P_11'],
      		'P_12' => $arr['P_12']
		);
		$this->db->insert('budget_storage',$insArray);
	} else {
		$this->db->where('YEAR_ID',$current_year)->where('BUDGET_ID', $id)->where('CAT_ID',$symbol)->update('budget_storage',$arr);
	} // end if
} // end update_staffing_bonus function
/**************************************************/
public function update_storage($empID, $symbol, $arr){
	$current_year = $this->globals_m->current_year();

	$q = $this->db->where('YEAR_ID',$current_year)->where('EMP_ID', $empID)->where('CAT_ID',$symbol)->get('employee_storage');

	if( !$q->result_array() ){
		$arr['EMP_ID'] = $empID;
		$arr['YEAR_ID'] = $current_year;
		$arr['CAT_ID'] = $symbol;

		$this->db->insert('employee_storage',$arr);
	} else {
		$this->db->where('YEAR_ID',$current_year)->where('EMP_ID', $empID)->where('CAT_ID',$symbol)->update('employee_storage',$arr);
	} // end if
} // end update_storage function
/**************************************************/
public function update_user($arr,$id){
	$this->db->where('EMP_ID',$id)->update('budget_feed', $arr);
	return $this->db->last_query();
} // end update_user function
/**************************************************/
public function xSQL($sql){
	$this->db->query($sql);
	return $this->db->last_query();
} // end xSQL function
/**************************************************/
/***************************************************/
/***************************************************/
} // end class
<?php

class Pam_m extends CI_Model{

function __construct(){
	parent::__construct();
} // end constructor
/***************************************************/
/***************************************************/
public function ajax_adjust_salary($arr){
	//error_reporting('E_ALL');
	$EMP_ID = $arr['EMP_ID']; //1485
	$period = $arr['period']; //7
	$kind = $arr['kind']; //Decrease
	$type = $arr['type']; // Percent
	$amount = $arr['amount']; //10

	$emp = $this->budget_m->get_emp_info($EMP_ID);
	$bud = $this->budget_m->get_bud_info($emp[0]['BUDGET_ID']);

	$aSal = $this->budget_m->get_salary_adjustments($EMP_ID);
	if( !$aSal ){
		$aSal['EMP_ID'] = $EMP_ID;
		$aSal['YEAR_ID'] = $this->globals_m->current_year();
		$aSal['HOURLY_RATE'] = $emp[0]['HOURLY_RATE'];
		$aSal['EE_TYPE'] = $emp[0]['EE_TYPE'];

		for($s=1;$s<13;$s++){
			$aSal['P_'.$s] = $emp[0]['ADJUSTED_HOURLY_RATE'];
		} // end for

		$doit = $this->insert_array('salary_adjustment', $aSal);

		$aSal = array($aSal);
	} // end if

	// determine percentage of amount submitted
	if( $emp[0]['EE_TYPE'] == 'S' ):
		if( $type == 'Dollars'){
			$baseAnnual = $emp[0]['ANNUAL_RATE']; // 2500
			$purrscent = (float)$amount / (float)$baseAnnual * 100; // 10
		} else {
			$purrscent = $amount; // 10
		} // end if
	elseif( $emp[0]['EE_TYPE'] == 'H' ):
		if( $type == 'Dollars'){
			$baseHourly = $emp[0]['ADJUSTED_HOURLY_RATE']; // 15
			$purrscent = (float)$amount / (float)$baseHourly * 100; // 10
		} else {
			$purrscent = $amount;
		}// end if
	else:
		if( $type == 'Dollars'){
			$baseMonthly = $emp[0]['STIPEND_AMOUNT']; // 250
			$purrscent = (float)$amount / (float)$baseMonthly * 100; // 10
		} else {
			$purrscent = $amount;
		} // end if
	endif;

	if( $kind == 'Decrease'){ 
		$purrscent = (100 - $purrscent)/100; 
	} else { 
		$purrscent = (float)1.00 + $purrscent/100; 
	} // end if

	for($a=$period;$a<13;$a++){
		$updArray['P_'.$a] = $aSal[0]['P_'.$a] * $purrscent;
	} // end for

	$doit = $this->update_by_array('salary_adjustment',array('EMP_ID' => $EMP_ID),$updArray);

	$retHTML = $this->ajax_salary_adjustment_table($EMP_ID);
	return $retHTML;
} // end ajax_adjust_salary($frmData) function
/**************************************************/
public function ajax_delete_salary_adjustment($arr){
	$EMP_ID = $arr['EMP_ID'];
	$period = (int)$arr['period'];

	$emp = $this->budget_m->get_emp_info($EMP_ID);
	$bud = $this->budget_m->get_bud_info($emp[0]['BUDGET_ID']);

	$aSal = $this->budget_m->get_salary_adjustments($EMP_ID);

	$arrAdjustment = array(
		'EMP_ID' => $EMP_ID,
		'YEAR_ID' => $this->globals_m->current_year(),
		'HOURLY_RATE' => $emp[0]['HOURLY_RATE'],
		'EE_TYPE' => $emp[0]['EE_TYPE'],
	);

	if( $emp[0]['EE_TYPE'] != 'M' ):
		if( $period > 1){
			$previ = $period-1;
			$cv = $aSal[0]['P_'.$period];
			$pv = $aSal[0]['P_'.$previ];
		} else {
			$cv = $aSal[0]['P_'.$period];
			$pv = $emp[0]['HOURLY_RATE'];
		} // end if
		
		$arrAdjustment['P_'.$period] = $pv;

		for($c=$period+1;$c<13;$c++){
			if( (float)$aSal[0]['P_'.$c] == $cv ){
				$arrAdjustment['P_'.$c] = $pv;
			} // end if
		} // end for

		$doit = $this->update_by_array('salary_adjustment',array('EMP_ID'=>$EMP_ID),$arrAdjustment);
		$retHTML = $this->ajax_salary_adjustment_table($EMP_ID);
		return $retHTML;
	else: // Monthly
		// do CA stuff
		return "Monthly Guy, eh?";
	endif;
} // end ajax_delete_salary_adjustment function
/**************************************************/
public function ajax_salary_adjustment_table($user_id){
	$sala = $this->budget_m->get_salary_adjustments($user_id);
	$emp = $this->get_complete_employee($user_id);
	$fiscal = $this->fiscal_m->get_fiscal_info($emp['budget']['fiscalStart']);
	$osal = $emp['feed']['HOURLY_RATE'];

	$retHTML = '<table id="tblSalAdj" class="table table-bordered" style="width:100%;">
            <tr>
              <th style="width:8%;">PERIOD</th>
              <th style="width:24%;">ADJUSTMENT AMOUNT</th>
              <th style="width:24%;">ADJUSTMENT PERCENTAGE</th>
              <th style="width:24%;">HOURLY WAGE</th>
              <th style="width:18%;">&nbsp;</th>
            </tr>';

	if($sala):
		for($s=1;$s<13;$s++){
	        if( (float)$sala[0]['P_'.$s] != $osal ){
	          $adden[$s] = array(
	            'period' => $s,
	            'hourly' => (float)$sala[0]['P_'.$s] - $osal,
	            'percent' => (((float)$sala[0]['P_'.$s] - $osal ) / $osal ) * 100,
	            'wage' => (float)$sala[0]['P_'.$s] 
	          );
	        } // end if
	        $osal = (float)$sala[0]['P_'.$s];
	     } // end for

	     if(!isset($adden)):
	     	$retHTML .= "<tr><td colspan='5' style='text-align:center;font-weight:bold;'>No Salary Adjustments Found!</td></tr>";
	     else :
		    foreach( $adden as $ad ){
			    $retHTML .= "<tr>";
			    $retHTML .= "<td>".$fiscal[0]['P_'.$ad['period']]."</td>";
			    $retHTML .= "<td>$".number_format($ad['hourly'],2)."/hour</td>";
			    $retHTML .= "<td>".number_format($ad['percent'],2)."%</td>";
			    $retHTML .= "<td>$".number_format($ad['wage'],2)."</td>";
			    $retHTML .= "<td style='text-align:center;'><a class='btn btn-edr btnDeleteAdj' data-period='".$ad['period']."'>DELETE</a></td>";
			    $retHTML .= "</tr>";
			} // end foreach

			$totChange = (float)$sala[0]['P_12']-(float)$emp['feed']['HOURLY_RATE'];
			$totPercent = ($totChange/(float)$emp['feed']['HOURLY_RATE'])*100;

			$retHTML .= "<tr>";
			$retHTML .= "<td>**YEAR**</td>";
			$retHTML .= "<td>$".number_format($totChange,2)."/hour</td>";
			$retHTML .= "<td>".number_format($totPercent,2)."%</td>";
			$retHTML .= "<td>$".number_format($sala[0]['P_12'],2)."</td>";
			$retHTML .= "<td style='text-align:center;'>&nbsp;</td>";
			$retHTML .= "</tr>";
		endif;
	else:
		$retHTML .= "<tr><td colspan='5' style='text-align:center;font-weight:bold;'>No Salary Adjustments Found!</td></tr>";
	endif;
	$retHTML .= "</table>";
	return $retHTML;
} // end ajax_salary_adjustment_table function
/**************************************************/
public function compute_pm_adp_admin($id){
	//return $id;
	$emp = $this->budget_m->get_emp_info($id);
	$bud = $this->budget_m->get_bud_info($emp[0]['BUDGET_ID']);
	//return $bud;

	$companyAllocation = $emp[0]['ALLOC_TOTAL'];
	$validPeriods = $this->budget_m->determineValidPeriods( $emp );

	$pmsal = $this->budget_m->get_salary_from_pmout($id, $this->globals_m->current_year());
	
	$pma['EMP_ID'] = $pmsal[0]['EMP_ID'];
	$pma['EMPLID'] = $pmsal[0]['EMPLID'];
	$pma['Year_id'] = $pmsal[0]['Year_id'];
	$pma['Ver_id'] = $this->globals_m->version_id();
	$pma['Unit_id'] = $pmsal[0]['Unit_id'];
	$pma['Line_id'] = 6270;
	$pma['Cust1_id'] = $pmsal[0]['Cust1_id'];
	$pma['Cust2_id'] = $pmsal[0]['Cust2_id'];

	$adminADP = $this->globals_m->get_admin_adp();

	for($p=1;$p<13;$p++){
		$thisOne =  $adminADP * $companyAllocation/100 * $validPeriods["P_{$p}"];
		$pma["P_".$p] = number_format($thisOne,2,".","");
	} // end for

	$pma['keyCol'] = $pma['EMP_ID'] . $pma['Line_id'] . $pma['Cust1_id'] . $pma['Year_id'];

	return $pma;
} // end compute_pm_adp_admin function
/**************************************************/
public function compute_pm_bonus($id){ 
	//return $id; // EMP_ID
	$curr_year = $this->globals_m->current_year();
	$emp = $this->budget_m->get_emp_info($id);
	$bud = $this->budget_m->get_bud_info($emp[0]['BUDGET_ID']);
	$pmsal = $this->budget_m->get_salary_from_pmout($id, $this->globals_m->current_year());
	//return $bud;

	if( (int)$bud[0]['companyTypeID'] > 2 ):
		return $this->compute_pm_bonus_corp($id);
	endif;

	$companyAllocation = $emp[0]['ALLOC_TOTAL'];
	$validPeriods = $this->budget_m->determineValidPeriods($emp);
   	$workingMonths = 0;
	//return $validPeriods;

   	for($h=1;$h<13;$h++){
		$workingMonths += (int) $validPeriods['P_'.$h];
	} // end for
	
  	$pmb['EMP_ID'] = $pmo['EMP_ID'] = $id;
	$pmb['EMPLID'] = $pmo['EMPLID'] = $emp[0]['EMPLID'];
	$pmb['Year_id'] = $pmo['Year_id'] = $this->globals_m->current_year();
	$pmb['Ver_id'] = $pmo['Ver_id'] = $this->globals_m->version_id();
	$pmb['Unit_id'] = $pmo['Unit_id'] = $emp[0]['COMPANY_ID'];
	$pmb['Line_id'] = 6195;
	$pmb['Cust1_id'] = $emp[0]['DEPARTMENT_ID'];
	$pmb['Cust2_id'] = 0;
	$pmb['keyCol'] = $pmb['EMP_ID'] . $pmb['Line_id'] . $pmb['Cust1_id'] . $pmb['Year_id'];

	for($s=1;$s<13;$s++):
		$thisOne = 0 * $companyAllocation/100 * $validPeriods['P_'.$s];
		$pmb['P_'.$s] = number_format($thisOne,2,".","");
	endfor;

	return $pmb;
} // end compute_pm_bonus function
/**************************************************/
public function compute_pm_bonus_corp($id){ 
	//return $id; // EMP_ID
	$curr_year = $this->globals_m->current_year();
	$emp = $this->budget_m->get_emp_info($id);
	$bud = $this->budget_m->get_bud_info($emp[0]['BUDGET_ID']);
	$pmsal = $this->budget_m->get_salary_from_pmout($id, $this->globals_m->current_year());
	//return $bud;

	$companyAllocation = $emp[0]['ALLOC_TOTAL'];
	$validPeriods = $this->budget_m->determineValidPeriods($emp);
	$txCorpBonus = 0;
	$cmBonus = 0;
	$totalDevBonus = 0;
   	$workingMonths = 0;
   	$ho_bo = 0;
	//return $validPeriods;

   	for($h=1;$h<13;$h++){
		$workingMonths += (int) $validPeriods['P_'.$h];
	} // end for
	//return $validPeriods;
	
	$hbq = (float) $this->globals_m->get_hobo_qualifier()/100;
	//return $hbq;
  	$hbp = (float) $emp[0]['HOME_OFFICE_BONUS_PERCENTAGE']/100;
  	//return $hbp;

  	$pmdb['EMP_ID'] = $pmb['EMP_ID'] = $pmo['EMP_ID'] = $id;
	$pmdb['EMPLID'] = $pmb['EMPLID'] = $pmo['EMPLID'] = $emp[0]['EMPLID'];
	$pmdb['Year_id'] = $pmb['Year_id'] = $pmo['Year_id'] = $this->globals_m->current_year();
	$pmdb['Ver_id'] = $pmb['Ver_id'] = $pmo['Ver_id'] = $this->globals_m->version_id();
	$pmdb['Unit_id'] = $pmb['Unit_id'] = $pmo['Unit_id'] = $emp[0]['COMPANY_ID'];
	$pmdb['Line_id'] = 6200;
	$pmb['Line_id'] = 6195;
	$pmdb['Cust1_id'] = $pmb['Cust1_id'] = $emp[0]['DEPARTMENT_ID'];
	$pmdb['Cust2_id'] = $pmb['Cust2_id'] = 0;
	$pmb['keyCol'] = $pmb['EMP_ID'] . $pmb['Line_id'] . $pmb['Cust1_id'] . $pmb['Year_id'];
	$pmdb['keyCol'] = $pmb['EMP_ID'] . $pmdb['Line_id'] . $pmb['Cust1_id'] . $pmb['Year_id'];

	if( $bud[0]['companyTypeID'] == 1 ):
		// CORPORATE
      	for($h=1;$h<13;$h++){
			$pmb['P_'.$h] = $hbq * $hbp * $pmsal[0]['P_'.$h] * $validPeriods['P_'.$h];
			$ho_bo = $ho_bo + $pmb['P_'.$h];
  		} // end for
  		$this->budget_m->save_for_pm($pmb);
  		return $pmb;
  	elseif( $bud[0]['companyTypeID'] == 2):
  		// DEVELOPMENT
  		$devBonus = $this->budget_m->get_employee_totals($emp[0]['EMP_ID'], $curr_year, 'DVB');
  		if(!$devBonus){
  			$devBonus = array( array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0) );
  		} // end if
  		//return $devBonus;
	   		
   		for($h=1;$h<13;$h++){
				$totalDevBonus += (float) $devBonus[0]['P_'.$h];
				$ho_bo = $ho_bo + ($hbq * $hbp) * $pmsal[0]['P_'.$h];
  		} // end for
  		//return 'HOBO: ' . $ho_bo . ' |||DEV: ' . $totalDevBonus;

  		if($totalDevBonus < $ho_bo ){
  			// to pay the greater, add the difference to the second period
  			for($h=1;$h<13;$h++){
  				if((float)$workingMonths > 0){
  					$pmdb['p_'.$h] = $devBonus[0]['P_'.$h];
  					$pmb['P_'.$h] = (((($hbq * $hbp) * $pmsal[0]['P_'.$h]) - (($totalDevBonus / $workingMonths)) * (int)$validPeriods['P_'.$h]));
				} else {
					$pmdb['P_'.$h] = 0;
					$pmb['P_'.$h] = 0;
				}
	  		} // end for
  		} else {
  			// forget the difference because it is included in the development bonus
  			for($h=1;$h<13;$h++){
  				if((float)$workingMonths > 0){
  					$pmdb['p_'.$h] = $devBonus[0]['P_'.$h];
  					$pmb['P_'.$h] = 0;
  				} else {
					$pmdb['P_'.$h] = 0;
					$pmb['P_'.$h] = 0;
				}
	  		} // end for
  		} // end if
  		$this->budget_m->save_for_pm($pmdb);
  		$this->budget_m->save_for_pm($pmb);
  		return $pmb;
  	else:
		// property
		for($s=1;$s<13;$s++):
			$thisOne = 0 * $companyAllocation/100 * $validPeriods['P_'.$s];
			$pmb['P_'.$s] = number_format($thisOne,2,".","");
		endfor;
		$this->budget_m->save_for_pm($pmb);
  		return $pmb;
	endif;
} // end compute_pm_bonus function
/**************************************************/
public function compute_pm_disability($id){
	/* LTDI & STDI #1 for companyTypeID < 3 if FULL_PARTTIME = "F" or "B" (part-time w/ Benefits) AND jobCodes of 4120, 4131, 1305, & 1307; STDI #2 (all remaining FULL_PARTTIME = "F" or "B" (part-time w/ Benefits)) */
	$emp = $this->budget_m->get_emp_info($id);
	$bud = $this->budget_m->get_bud_info($emp[0]['BUDGET_ID']);
	//return $emp;

	$companyAllocation = $emp[0]['ALLOC_TOTAL'];
	$validPeriods = $this->budget_m->determineValidPeriods( $emp );
	//return $validPeriods;

	if( (int) $emp[0]['COMPANY_ID'] == 349 ): // dining only company
    	$diningSpCode = 13;
    elseif((int)$bud[0]['companyTypeID'] < 3): // corporate
    	$diningSpCode = substr($emp[0]['BUDGET_ID'],-2);
    else:
    	$diningSpCode = 41; // property
    endif;

	$pmsal = $this->budget_m->get_salary_from_pmout($id, $this->globals_m->current_year());
	//return $pmsal;

	$pmd['EMP_ID'] = $pmsal[0]['EMP_ID'];
	$pmd['EMPLID'] = $pmsal[0]['EMPLID'];
	$pmd['Year_id'] = $pmsal[0]['Year_id'];
	$pmd['Ver_id'] = $this->globals_m->version_id();
	$pmd['Unit_id'] = $pmsal[0]['Unit_id'];
	$pmd['Line_id'] = 6230;
	$pmd['Cust1_id'] = $diningSpCode;
	$pmd['Cust2_id'] = $pmsal[0]['Cust2_id'];
	$pmd['keyCol'] = $pmd['EMP_ID'] . $pmd['Line_id'] . $pmd['Cust1_id'] . $pmd['Year_id'];

	$ltdiMax = $this->globals_m->get_ltdi_max();
	$ltdiRate = $this->globals_m->get_ltdi_rate();
	$stdi_1Max = (float)$this->globals_m->get_stdi1_max() * .7;
	$stdi_1Rate = $this->globals_m->get_stdi1_rate();
	$stdi_2Max = (float)$this->globals_m->get_stdi2_max() * .7;
	$stdi_2Rate = $this->globals_m->get_stdi2_rate();
	//return $stdi_2Max;

	for($s=1;$s<13;$s++){
		$taxableSalary[0]['P_'.$s] = $pmsal[0]['P_'.$s];
		$pmSalary_70[0]['P_'.$s] = $pmsal[0]['P_'.$s] * .7;
	} // end for
	//return $pmSalary_70;

	$ltdi_val  = $this->globals_m->get_period_maxed_tax($taxableSalary[0],$ltdiMax,$ltdiRate);
	$stdi1_val = $this->globals_m->get_period_maxed_tax($pmSalary_70[0],$stdi_1Max,$stdi_1Rate);
	$stdi2_val  = $this->globals_m->get_period_maxed_tax($pmSalary_70[0],$stdi_2Max,$stdi_2Rate);
	//return $ltdi_val;

	if( $emp[0]['FULL_PART'] == 'F' || $emp[0]['FULL_PART'] == 'B'):
		if ( (int)$bud[0]['companyTypeID'] == 1 || (int)$bud[0]['companyTypeID'] == 2 || in_array( (int)$emp[0]['JOB_ID'], array(4120, 4131, 4134, 1305, 1307) ) ):
			for($p=1;$p<13;$p++){
				$thisOne = ((float) $ltdi_val[$p] + (float) $stdi1_val[$p]);
				$pmd["P_".$p] = number_format($thisOne,2,".","");
			} // end for
		else:
			for($p=1;$p<13;$p++){
				$thisOne = (float) $stdi2_val[$p];
				$pmd["P_".$p] = number_format($thisOne,2,".","");
			} // end for
		endif;
	else: // no ltdi and stdi2
		for($d=1;$d<13;$d++){
			$pmd["P_".$d] = number_format(0,2,".","");
		} // end for
	endif;

	return $pmd;
} // end compute_pm_disability function
/**************************************************/
public function compute_pm_fica($id){
	//return $id;
	$emp = $this->budget_m->get_emp_info($id);
	$bud = $this->budget_m->get_bud_info($emp[0]['BUDGET_ID']);
	//return $emp;

	$companyAllocation = $emp[0]['ALLOC_TOTAL'];
	$validPeriods = $this->budget_m->determineValidPeriods( $emp );

	$pmsal = $this->budget_m->get_salary_from_pmout($id, $this->globals_m->current_year());
	$pmbone = $this->budget_m->get_bonus_from_pmout($id, $this->globals_m->current_year());

	$fiscalStart = (int) $bud[0]['fiscalStart']; //6
	//return $fiscalStart;

	$ficaMax = $this->globals_m->get_fica_max();
	$ficaRate = $this->globals_m->get_fica_rate();
	$medicareRate = $this->globals_m->get_medicare_rate();

	if( $fiscalStart == 0 ){
		// owned
		for($s=1;$s<13;$s++){
			$ficaSalary['P_'.$s] = $pmsal[0]['P_'.$s] + $pmbone[0]['P_'.$s];
		} // end for

		$fica_val = $this->globals_m->get_maxed_tax($ficaSalary,$ficaMax,$ficaRate);

		for($p=1;$p<13;$p++){
			$thisOne = ($fica_val[$p] + ( $pmsal[0]['P_'.$p] * $medicareRate )) * $validPeriods["P_{$p}"];
			$pmf["P_".$p] = number_format($thisOne,2,".","");
		} // end for
	} else {
		//managed
		// HANDLING PREVIOUS FY
		for($s=1;$s<$fiscalStart+1;$s++){
			$PFY['P_'.$s] = ($emp[0]['ANNUAL_RATE']/12 * $companyAllocation/100) + $pmbone[0]['P_'.$s];
		} // end for
		for($s=$fiscalStart+1;$s<13;$s++){
			$PFY['P_'.$s] = $pmsal[0]['P_'.$s] + $pmbone[0]['P_'.$s];
		} // end for

		$py_fica_val = $this->globals_m->get_maxed_tax($PFY,$ficaMax,$ficaRate);
		$arrP = array_slice($py_fica_val, $fiscalStart);

		// CURRENT FY
		for($s=1;$s<$fiscalStart+1;$s++){
			$cnt = $s + (12 - $fiscalStart);
			$CFY['P_'.$s] = $pmsal[0]['P_'.$cnt] + $pmbone[0]['P_'.$cnt];
		} // end for
		for($s=$fiscalStart+1;$s<13;$s++){
			$CFY['P_'.$s] = 0;
		} // end for
		
		$cy_fica_val = $this->globals_m->get_maxed_tax($CFY,$ficaMax,$ficaRate);
		$arrC = array_shift($cy_fica_val);
		$hybrid = array_merge( (array)$arrP, (array)$cy_fica_val );

		for($s=1;$s<13;$s++){
			$fica_val['P_' . $s] = $hybrid[$s];
		} // end for

		for($p=1;$p<13;$p++){
			$thisOne = ($fica_val['P_' . $p] + ( $pmsal[0]['P_'.$p] * $medicareRate )) * $validPeriods["P_{$p}"];
			$pmf["P_".$p] = number_format($thisOne,2,".","");
		} // end for
	} // end if

	$pmf['EMP_ID'] = $pmsal[0]['EMP_ID'];
	$pmf['EMPLID'] = $pmsal[0]['EMPLID'];
	$pmf['Year_id'] = $pmsal[0]['Year_id'];
	$pmf['Ver_id'] = $this->globals_m->version_id();
	$pmf['Unit_id'] = $pmsal[0]['Unit_id'];
	$pmf['Line_id'] = 6210;
	$pmf['Cust1_id'] = $pmsal[0]['Cust1_id'];
	$pmf['Cust2_id'] = $pmsal[0]['Cust2_id'];
	$pmf['keyCol'] = $pmf['EMP_ID'] . $pmf['Line_id'] . $pmf['Cust1_id'] . $pmf['Year_id'];

	return $pmf;
} // end compute_pm_fica function
/**************************************************/
public function compute_pm_fica_corp($id){
	//return $id;
	$emp = $this->budget_m->get_emp_info($id);
	$bud = $this->budget_m->get_bud_info($emp[0]['BUDGET_ID']);
	$hobo = 0;
	//return $emp;

	$companyAllocation = $emp[0]['ALLOC_TOTAL'];
	$validPeriods = $this->budget_m->determineValidPeriods( $emp );

	$pmsal = $this->budget_m->get_salary_from_pmout($id, $this->globals_m->current_year());
	$pmhobo =  $this->budget_m->get_bonus_from_pmout($id, $this->globals_m->current_year());
	$pmbone = $this->budget_m->get_dev_bonus_from_pmout($id, $this->globals_m->current_year());
	if(!$pmbone){ $pmbone = array( array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0) ); } // end if
	//return $pmbone;

	$fiscalStart = (int) $bud[0]['fiscalStart'];
	//return $fiscalStart;

	for($s=1;$s<13;$s++){
		$ficaSalary['P_'.$s] = $pmsal[0]['P_'.$s] + $pmbone[0]['P_'.$s];
		$hobo += $pmhobo[0]['P_'.$s];
	} // end for
	$ficaSalary['P_2'] = $ficaSalary['P_2'] + $hobo;

	$pmf['EMP_ID'] = $pmsal[0]['EMP_ID'];
	$pmf['EMPLID'] = $pmsal[0]['EMPLID'];
	$pmf['Year_id'] = $pmsal[0]['Year_id'];
	$pmf['Unit_id'] = $pmsal[0]['Unit_id'];
	$pmf['Ver_id'] = $this->globals_m->version_id();
	$pmf['Line_id'] = 6210;
	$pmf['Cust1_id'] = $pmsal[0]['Cust1_id'];
	$pmf['Cust2_id'] = $pmsal[0]['Cust2_id'];

	$ficaMax = $this->globals_m->get_fica_max();
	$ficaRate = $this->globals_m->get_fica_rate();
	$medicareRate = $this->globals_m->get_medicare_rate();

	$fica_val = $this->globals_m->get_maxed_tax($ficaSalary,$ficaMax,$ficaRate);
	//return $fica_val;

	for($p=1;$p<13;$p++){
		$thisOne = ($fica_val[$p] + ( ($pmsal[0]['P_'.$p] + $pmbone[0]['P_'.$p]) * $medicareRate )) * $companyAllocation/100;
		$pmf["P_".$p] = number_format($thisOne,2,".","");
	} // end for
	$pmf['P_2'] = $pmf['P_2'] + ($hobo * $medicareRate );
	$pmf['P_2'] = number_format($pmf['P_2'],2,".","");

	$pmf['keyCol'] = $pmf['EMP_ID'] . $pmf['Line_id'] . $pmf['Cust1_id'] . $pmf['Year_id'];

	return $pmf;
} // end compute_pm_fica function
/**************************************************/
public function compute_pm_fuisui($id){
	//return $id;
	$emp = $this->budget_m->get_emp_info($id);
	$bud = $this->budget_m->get_bud_info($emp[0]['BUDGET_ID']);
	//return $bud;

	$companyAllocation = $emp[0]['ALLOC_TOTAL'];
	$validPeriods = $this->budget_m->determineValidPeriods( $emp );

	$pmsal = $this->budget_m->get_salary_from_pmout($id, $this->globals_m->current_year());
	$pmbone = $this->budget_m->get_bonus_from_pmout($id, $this->globals_m->current_year());

	$fuiMax = $this->globals_m->get_fui_max();
	$fuiRate = $this->globals_m->get_fui_rate();
	$suiMax = $this->globals_m->get_sui_max($emp[0]['EMP_STATE']);
	$suiRate = $this->globals_m->get_sui_rate($emp[0]['EMP_STATE']);

	$fiscalStart = (int) $bud[0]['fiscalStart'];

	if( $fiscalStart == 0){
		for($s=1;$s<13;$s++){
			$taxableSalary['P_'.$s] = $pmsal[0]['P_'.$s] + $pmbone[0]['P_'.$s];
		} // end for

		$fui_val = $this->globals_m->get_maxed_tax($taxableSalary,(float)$fuiMax * (float)$companyAllocation / 100,$fuiRate);
		$sui_val = $this->globals_m->get_maxed_tax($taxableSalary,(float)$suiMax * (float)$companyAllocation / 100,$suiRate);
		//return $sui_val;

		for($p=1;$p<13;$p++){
			$thisOne = ((float) $fui_val[$p] / 100 + (float) $sui_val[$p] / 100);
			$pms["P_".$p] = number_format($thisOne,2,".","");
		} // end for
	} else {
		// managed
		//HANDLING PREVIOUS FY
		for($s=1;$s<$fiscalStart+1;$s++){
			$py_taxableSalary['P_'.$s] = $emp[0]['ANNUAL_RATE']/12 + $pmbone[0]['P_'.$s];
		} // end for

		for($s=$fiscalStart+1;$s<13;$s++){
			$py_taxableSalary['P_'.$s] = $pmsal[0]['P_'.$s] + $pmbone[0]['P_'.$s];
		} // end for

		$py_fui_val = $this->globals_m->get_maxed_tax($py_taxableSalary,(float)$fuiMax * (float)$companyAllocation / 100,$fuiRate);
		$arrPFV = array_slice($py_fui_val, $fiscalStart);
		$py_sui_val = $this->globals_m->get_maxed_tax($py_taxableSalary,(float)$suiMax * (float)$companyAllocation / 100,$suiRate);
		$arrPSV = array_slice($py_sui_val, $fiscalStart);
		
		// CURRENT FY
		for($s=1;$s<$fiscalStart+1;$s++){
			$cnt = $s + (12 - $fiscalStart);
			$cy_taxableSalary['P_'.$s] = $pmsal[0]['P_'.$cnt] + $pmbone[0]['P_'.$cnt];
		} // end for

		for($s=$fiscalStart+1;$s<13;$s++){
			$cy_taxableSalary['P_'.$s] = 0;
		} // end for

		$cy_fui_val = $this->globals_m->get_maxed_tax($cy_taxableSalary,(float)$fuiMax * (float)$companyAllocation / 100,$fuiRate);
		$arrCFF = array_shift($cy_fui_val);
		$cy_sui_val = $this->globals_m->get_maxed_tax($cy_taxableSalary,(float)$suiMax * (float)$companyAllocation / 100,$suiRate);
		$arrCFS = array_shift($cy_sui_val);

		$hybrid_fui = array_merge($arrPFV, $cy_fui_val);
		$hybrid_sui = array_merge($arrPSV, $cy_sui_val);

		for($s=1;$s<13;$s++){
			$fui_val[$s] = $hybrid_fui[$s];
			$sui_val[$s] = $hybrid_sui[$s];
		} // end for

		for($p=1;$p<13;$p++){
			$thisOne = ((float) $fui_val[$p] / 100 + (float) $sui_val[$p] / 100);
			$pms["P_".$p] = number_format($thisOne,2,".","");
		} // end for

	} // end if

	$pms['EMP_ID'] = $pmsal[0]['EMP_ID'];
	$pms['EMPLID'] = $pmsal[0]['EMPLID'];
	$pms['Year_id'] = $pmsal[0]['Year_id'];
	$pms['Ver_id'] = $this->globals_m->version_id();
	$pms['Unit_id'] = $pmsal[0]['Unit_id'];
	$pms['Line_id'] = 6215;
	$pms['Cust1_id'] = $pmsal[0]['Cust1_id'];
	$pms['Cust2_id'] = $pmsal[0]['Cust2_id'];
	$pms['keyCol'] = $pms['EMP_ID'] . $pms['Line_id'] . $pms['Cust1_id'] . $pms['Year_id'];

	return $pms;
} // end compute_pm_fuisui function
/**************************************************/
public function compute_pm_group_insurance($id){
	//return $id;
	$emp = $this->budget_m->get_emp_info($id);
	$bud = $this->budget_m->get_bud_info($emp[0]['BUDGET_ID']);
	//return $bud;

	$companyAllocation = $emp[0]['ALLOC_TOTAL'];
	$validPeriods = $this->budget_m->determineValidPeriods( $emp );

	$pmsal = $this->budget_m->get_salary_from_pmout($id, $this->globals_m->current_year());

	$pmg['EMP_ID'] = $pmsal[0]['EMP_ID'];
	$pmg['EMPLID'] = $pmsal[0]['EMPLID'];
	$pmg['Year_id'] = $pmsal[0]['Year_id'];
	$pmg['Ver_id'] = $this->globals_m->version_id();
	$pmg['Unit_id'] = $pmsal[0]['Unit_id'];
	$pmg['Line_id'] = 6225;
	$pmg['Cust1_id'] = $pmsal[0]['Cust1_id'];
	$pmg['Cust2_id'] = $pmsal[0]['Cust2_id'];

	for($g=1;$g<13;$g++){
		 $thisOne = $emp[0]['GRP_INS_MONTHLY_EXPENSE'] * $companyAllocation/100 * $validPeriods['P_'.$g];
		 $pmg["P_".$g] = number_format($thisOne,2,".","");
	} // end for

	$pmg['keyCol'] = $pmg['EMP_ID'] . $pmg['Line_id'] . $pmg['Cust1_id'] . $pmg['Year_id'];

	return $pmg;
} // end compute_pm_group_insurance function
/**************************************************/
public function compute_pm_401k_admin($id){
	//return $id;
	$emp = $this->budget_m->get_emp_info($id);
	$bud = $this->budget_m->get_bud_info($emp[0]['BUDGET_ID']);
	//print_r($bud); die();

	$companyAllocation = $emp[0]['ALLOC_TOTAL'];
	$validPeriods = $this->budget_m->determineValidPeriods( $emp );

	$pmsal = $this->budget_m->get_salary_from_pmout($id, $this->globals_m->current_year());
	
	$pma['EMP_ID'] = $pmsal[0]['EMP_ID'];
	$pma['EMPLID'] = $pmsal[0]['EMPLID'];
	$pma['Year_id'] = $pmsal[0]['Year_id'];
	$pma['Ver_id'] = $this->globals_m->version_id();
	$pma['Unit_id'] = $pmsal[0]['Unit_id'];
	$pma['Line_id'] = 6260;
	if( (int)$bud[0]['companyTypeID'] < 3):
		$pma['Cust1_id'] = $pmsal[0]['Cust1_id'];
	else:
		if($bud[0]['id'] == "349000" || $bud[0]['id'] == 349000):
			$pma['Cust1_id'] = 13;
		else:
			$pma['Cust1_id'] = 41;
		endif;
	endif;
	$pma['Cust2_id'] = $pmsal[0]['Cust2_id'];

	$admin401K = $this->globals_m->get_admin_401k();

	for($p=1;$p<13;$p++){
		$thisOne =  $admin401K * $companyAllocation/100 * $validPeriods["P_{$p}"];
		$pma["P_".$p] = number_format($thisOne,2,".","");
	} // end for

	$pma['keyCol'] = $pma['EMP_ID'] . $pma['Line_id'] . $pma['Cust1_id'] . $pma['Year_id'];

	return $pma;
} // end compute_pm_401k_admin function
/**************************************************/
public function compute_pm_401K_contribution($id){
	//return $id;
	$emp = $this->budget_m->get_emp_info($id);
	$bud = $this->budget_m->get_bud_info($emp[0]['BUDGET_ID']);
	//return $bud;

	$companyAllocation = $emp[0]['ALLOC_TOTAL'];
	$validPeriods = $this->budget_m->determineValidPeriods( $emp );

	$pmsal = $this->budget_m->get_salary_from_pmout($id, $this->globals_m->current_year());
	$pmbone = $this->budget_m->get_bonus_from_pmout($id, $this->globals_m->current_year());
	if( !$pmbone ){
		$pmbone = array( array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0) );
	} // end if

	for($s=1;$s<13;$s++){
		$taxableSalary['P_'.$s] = $pmsal[0]['P_'.$s] + $pmbone[0]['P_'.$s];
	} // end for
	//return $taxableSalary;

	$pmk['EMP_ID'] = $pmsal[0]['EMP_ID'];
	$pmk['EMPLID'] = $pmsal[0]['EMPLID'];
	$pmk['Year_id'] = $pmsal[0]['Year_id'];
	$pmk['Ver_id'] = $this->globals_m->version_id();
	$pmk['Unit_id'] = $pmsal[0]['Unit_id'];
	$pmk['Line_id'] = 6265;
	$pmk['Cust1_id'] = $pmsal[0]['Cust1_id'];
	$pmk['Cust2_id'] = $pmsal[0]['Cust2_id'];

	if ( $emp[0]['PERCENTAGE_401K'] > 3) {
        $useFor401K = .03;
    } else {
        $useFor401K = $emp[0]['PERCENTAGE_401K'] * .01;
    } // end if

	for($k=1;$k<13;$k++){
		 $thisOne = $taxableSalary['P_'.$k] * $useFor401K * .5;
		 $pmk['P_'.$k] = number_format($thisOne,2,".","");
	} // end for

	$pmk['keyCol'] = $pmk['EMP_ID'] . $pmk['Line_id'] . $pmk['Cust1_id'] . $pmk['Year_id'];

	return $pmk;
} // end compute_pm_401K_contribution function
/**************************************************/
public function compute_pm_401K_contribution_corp($id){
	//return $id;
	$emp = $this->budget_m->get_emp_info($id);
	$bud = $this->budget_m->get_bud_info($emp[0]['BUDGET_ID']);
	$hobo = 0;
	//return $bud;

	$companyAllocation = $emp[0]['ALLOC_TOTAL'];
	$validPeriods = $this->budget_m->determineValidPeriods( $emp );

	$pmsal = $this->budget_m->get_salary_from_pmout($id, $this->globals_m->current_year());
	$pmhobo = $this->budget_m->get_bonus_from_pmout($id, $this->globals_m->current_year());
	$pmbone = $this->budget_m->get_dev_bonus_from_pmout($id, $this->globals_m->current_year());
	if( !$pmbone ){
		$pmbone = array( array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0) );
	} // end if

	for($s=1;$s<13;$s++){
		$taxableSalary['P_' . $s] = $pmsal[0]['P_' . $s] + $pmbone[0]['P_' . $s];
		$hobo += $pmhobo[0]['P_' . $s];
	} // end for
	$taxableSalary['P_2'] = $taxableSalary['P_2'] + $hobo;

	$pmk['EMP_ID'] = $pmsal[0]['EMP_ID'];
	$pmk['EMPLID'] = $pmsal[0]['EMPLID'];
	$pmk['Year_id'] = $pmsal[0]['Year_id'];
	$pmk['Ver_id'] = $this->globals_m->version_id();
	$pmk['Unit_id'] = $pmsal[0]['Unit_id'];
	$pmk['Line_id'] = 6265;
	$pmk['Cust1_id'] = $pmsal[0]['Cust1_id'];
	$pmk['Cust2_id'] = $pmsal[0]['Cust2_id'];

	if ( $emp[0]['PERCENTAGE_401K'] > 3) {
        $useFor401K = .03;
    } else {
        $useFor401K = $emp[0]['PERCENTAGE_401K'] * .01;
    } // end if

	for($k=1;$k<13;$k++){
		 $thisOne = $taxableSalary["P_".$k] * $useFor401K * .5 * $companyAllocation/100;
		 $pmk["P_".$k] = number_format($thisOne,2,".","");
	} // end for

	$pmk['keyCol'] = $pmk['EMP_ID'] . $pmk['Line_id'] . $pmk['Cust1_id'] . $pmk['Year_id'];

	return $pmk;
} // end compute_pm_401K_contribution function
/**************************************************/
public function compute_pm_meals($id){
	//return $id;
	$emp = $this->budget_m->get_emp_info($id);
	$bud = $this->budget_m->get_bud_info($emp[0]['BUDGET_ID']);
	//return $bud;

	$companyAllocation = $emp[0]['ALLOC_TOTAL'];
	$validPeriods = $this->budget_m->determineValidPeriods( $emp );

	$pmsal = $this->budget_m->get_salary_from_pmout($id, $this->globals_m->current_year());
	
	$pmm['EMP_ID'] = $pmsal[0]['EMP_ID'];
	$pmm['EMPLID'] = $pmsal[0]['EMPLID'];
	$pmm['Year_id'] = $pmsal[0]['Year_id'];
	$pmm['Ver_id'] = $this->globals_m->version_id();
	$pmm['Unit_id'] = $pmsal[0]['Unit_id'];
	$pmm['Line_id'] = 6235;
	$pmm['Cust1_id'] = $pmsal[0]['Cust1_id'];
	$pmm['Cust2_id'] = $pmsal[0]['Cust2_id'];

	if( $emp[0]['IS_MEAL_ELIGIBLE'] == 'Y' ):
		$meal_price = $this->globals_m->get_meal_price();
	else:
		$meal_price = 0;
	endif;

	$eligible_meals = $this->budget_m->get_employee_totals($id,$pmm['Year_id'],'EMA');

	if(!$eligible_meals){
		$eligible_meals = array(array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0));
	} // end if

	for($p=1;$p<13;$p++){
		$thisOne =  $meal_price * $eligible_meals[0]["P_".$p] * $companyAllocation/100 * $validPeriods["P_{$p}"];
		$pmm["P_".$p] = number_format($thisOne,2,".","");
	} // end for

	$pmm['keyCol'] = $pmm['EMP_ID'] . $pmm['Line_id'] . $pmm['Cust1_id'] . $pmm['Year_id'];

	return $pmm;
} // end compute_pm_meals function
/**************************************************/
public function compute_pm_salary($id){
	//error_reporting(0);
	$emp = $this->budget_m->get_emp_info($id);
	$bud = $this->budget_m->get_bud_info($emp[0]['BUDGET_ID']);
	//return $emp;

	$pms['EMP_ID'] = $pmo['EMP_ID'] = $id;
	$pms['EMPLID'] = $pmo['EMPLID'] = $emp[0]['EMPLID'];
	$pms['Year_id'] = $pmo['Year_id'] = $this->globals_m->current_year();
	$pms['Ver_id'] = $pmo['Ver_id'] = $this->globals_m->version_id();
	$pms['Unit_id'] = $pmo['Unit_id'] = $emp[0]['COMPANY_ID'];
	$pms['Line_id'] = $pmo['Line_id'] = substr($emp[0]['HOME_JOBCOST_NO'],-4,4);
	$pms['Cust1_id'] = $pmo['Cust1_id'] = $emp[0]['DEPARTMENT_ID'];
	$pms['Cust2_id'] = $pmo['Cust2_id'] = 0;

	$companyAllocation = $emp[0]['ALLOC_TOTAL'];
	$validPeriods = $this->budget_m->determineValidPeriods( $emp );
	//return $validPeriods;
	
	$fte = array(array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0));
	$overtime_hours = array(array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0));
	$dining_hours = array(array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0));
	$validStipendAmount = array(array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0));
	$validPeriodStipend = array(array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0));
	$caAddHours = array(array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0));

	// create FTE factor for employees
	if($emp[0]['EE_TYPE'] == 'H'){ // hourly employee -- get FTE
		$FTEQ = $this->budget_m->get_employee_totals($id,$pms['Year_id'],'FTE');
		if( $FTEQ ){ $fte = $FTEQ; }
	} elseif($emp[0]['EE_TYPE'] == 'S') { // salaried employee -- get default FTE
		$fte = array(array('P_1'=>40,'P_2'=>40,'P_3'=>40,'P_4'=>40,'P_5'=>40,'P_6'=>40,'P_7'=>40,'P_8'=>40,'P_9'=>40,'P_10'=>40,'P_11'=>40,'P_12'=>40));
	} // end if

	// get overtime hours
	if( $emp[0]['HAS_OVERTIME'] == 'Y'){
		$OTH = $this->budget_m->get_employee_totals($id,$pms['Year_id'],'OTH');
		if( $OTH ){ $overtime_hours = $OTH; }
	} // end if
	
	// create a coefficient to compute or negate dining hours
	if( $pms['Cust1_id'] == 13){
		$DHA = $this->budget_m->get_employee_totals($id,$pms['Year_id'],'DHA');
		if( $DHA ){ $dining_hours = $DHA; }
		$dontPay = 0;
	} else {
		$dontPay = 1;
	} // end if

	// create valid stipends for monthly employees
	if($emp[0]['EE_TYPE'] == 'M'){
		$VSM = $this->budget_m->get_employee_totals($id,$pms['Year_id'],'VSM');
		if( $VSM ){ $validPeriodStipend = $VSM; }

		$PSA = $this->budget_m->get_employee_totals($id,$pms['Year_id'],'PSA');
		if( $PSA ){ $validStipendAmount = $PSA; }

		$CAH = $this->budget_m->get_employee_totals($id,$pms['Year_id'],'CAH');
		if( $CAH ){ $caAddHours = $CAH; }
	} // end if

	$sal_month = $this->budget_m->get_monthly_rate($id,$pms['Year_id']);

	for($s=1;$s<13;$s++):
		$overtime = $sal_month[0]['P_'.$s] * 1.5 * $overtime_hours[0]['P_'.$s] * ceil($validPeriods['P_'.$s]);
		
		$pmo['P_'.$s] = number_format($overtime * $companyAllocation/100,2,".","");

		$salary = 
			( $validStipendAmount[0]['P_'.$s] * $validPeriodStipend[0]['P_'.$s] ) +
			( $sal_month[0]['P_'.$s] * $dining_hours[0]['P_'.$s] * ceil($validPeriods['P_'.$s]) ) +
			( $sal_month[0]['P_'.$s] * $caAddHours[0]['P_'.$s] * ceil($validPeriods['P_'.$s]) )   +
			( $sal_month[0]['P_'.$s] * 173.3333 * $fte[0]['P_'.$s]/40 * $validPeriods['P_'.$s] * $dontPay );

		$pms['P_'.$s] = number_format(($salary + $overtime) * $companyAllocation/100,2,".","");
	endfor;

	$pms['keyCol'] = $pms['EMP_ID'] . $pms['Line_id'] . $pms['Cust1_id'] . $pms['Year_id'];
	$pmo['keyCol'] = $pmo['EMP_ID'] . $pmo['Line_id'] . $pmo['Unit_id'] . $pmo['Cust1_id'] . $pmo['Year_id'];

	$this->load->model('overtime_out_m');
	$this->db->delete('overtime_out', array('keyCol' => $pmo['keyCol']));
	$id = $this->overtime_out_m->save($pmo);

	return $pms;
} // end compute_salary function
/**************************************************/
public function compute_pm_staffing_benefits($id){
	//return $id;
	$emp = $this->budget_m->get_emp_info($id);
	$bud = $this->budget_m->get_bud_info($emp[0]['BUDGET_ID']);
	//return $bud;

	$companyAllocation = $emp[0]['ALLOC_TOTAL'];
	$validPeriods = $this->budget_m->determineValidPeriods( $emp );

	$pmsal = $this->budget_m->get_salary_from_pmout($id, $this->globals_m->current_year());
	$pmbone = $this->budget_m->get_bonus_from_pmout($id, $this->globals_m->current_year());

	$salAndBonusTotal = 0;

	for($s=1;$s<13;$s++){
		$taxableSalary['P_'.$s] = $pmsal[0]['P_'.$s] + $pmbone[0]['P_'.$s];
		$salAndBonusTotal += $taxableSalary['P_'.$s];
	} // end for

	$pmb['EMP_ID'] = $pmsal[0]['EMP_ID'];
	$pmb['EMPLID'] = $pmsal[0]['EMPLID'];
	$pmb['Year_id'] = $pmsal[0]['Year_id'];
	$pmb['Ver_id'] = $this->globals_m->version_id();
	$pmb['Unit_id'] = $pmsal[0]['Unit_id'];
	$pmb['Line_id'] = 6255;

	if( $emp[0]['COMPANY_ID'] == 349 ){
		$pmb['Cust1_id'] = 13;
	} elseif(in_array((int)$bud[0]['companyTypeID'], array(1,2))){
		$pmb['Cust1_id'] = $pmsal[0]['Cust1_id'];
	} else {
		$pmb['Cust1_id'] = 41;
	} // end if

	$pmb['Cust2_id'] = $pmsal[0]['Cust2_id'];

	/*~~~ ESPP ER Discount Expense ~~~ */
	$espp = $emp[0]['ESPP'];
	$market_price = $this->globals_m->get_stock_market_price();
	$discount_share = $this->globals_m->get_stock_market_discount();
	$esppERDiscEx = ceil($salAndBonusTotal * $espp / 100 * ($companyAllocation/100) / $market_price * $discount_share) / 4;
	//$pmb['esppERDiscEx'] = $esppERDiscEx;

	/*~~~ ESPP Administration Fee ~~~ */
	if( (int)$emp[0]['COMPANY_ID'] < 300 ){
		$esppAdmin = 0;
	} else {
		$esppAdmin = $this->globals_m->getESPPAdmin(); // #2
	} // end if
	//$pmb['esppAdmin'] = $esppAdmin;

	/*~~~ ADD Insurance Expense ~~~ */
	if( in_array( (int)$emp[0]['JOB_ID'], array(4120,4121)) || in_array((int)$bud[0]['companyTypeID'], array(1,2)) ){
		$addExpense = $this->globals_m->getADDExpense(); // #3
	} else {
		$addExpense = 0;
	} // end if
	//$pmb['addExpense'] = $addExpense;

	if(in_array((int)$bud[0]['companyTypeID'], array(1,2))){
		$propADD = 0;
		$corpADD = $addExpense;
	} else {
		$propADD = (float)$addExpense * 12;
		$corpADD = 0;
	} // end if
	//$pmb['propADD'] = $propADD;
	//$pmb['corpADD'] = $corpADD;

	/*~~~ Flex Spend Program Calculation ~~~ */
	if( $emp[0]['FSA'] == "Y"){
		$flex = $this->globals_m->get_flex_spend();
	} else {
		$flex = 0;
	} // end if
	// $pmb['emp'] = $emp;
	// $pmb['bud'] = $bud;
	// $pmb['flex'] = $flex;

	/*~~~ Other Benefits ~~~ */
	$otb = $this->budget_m->get_employee_totals($id,$emp[0]['EE_YEAR'],'ABS');
	if(!$otb){
		$otb = array(array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0));
	} // end if

	for($p=1;$p<13;$p++){
		$thisOne = ($otb[0]["P_".$p] + $corpADD + $flex + $esppAdmin) * $validPeriods["P_{$p}"]; 
		$pmb["P_".$p] = number_format($thisOne,2,".","");
	} // end for

	$febr = 2 + (int)$bud[0]['fiscalStart'];
	if( $febr > 12){ $febr = $febr-12; } // end if
	$pmb["P_".$febr] += $propADD; // add Prop ADD to February

	$q1 = 3 + (int)$bud[0]['fiscalStart'];
	if( $q1 > 12){ $q1 = $q1-12; } // end if
	$pmb["P_".$q1] += $esppERDiscEx;

	$q2 = 6 + (int)$bud[0]['fiscalStart'];
	if( $q2 > 12){ $q2 = $q2-12; } // end if
	$pmb["P_".$q2] += $esppERDiscEx;

	$q3 = 9 + (int)$bud[0]['fiscalStart'];
	if( $q3 > 12 ){ $q3 = $q3-12; } // end if
	$pmb["P_".$q3] += $esppERDiscEx;

	$q4 = 12 + (int)$bud[0]['fiscalStart'];
	if( $q4 > 12){ $q4 = $q4-12; } // end if
	$pmb["P_".$q4] += $esppERDiscEx;

	$pmb['keyCol'] = $pmb['EMP_ID'] . $pmb['Line_id'] . $pmb['Cust1_id'] . $pmb['Year_id'];

	return $pmb;
} // end compute_pm_staffing_benefits function
/**************************************************/
public function compute_pm_wcomp($id){ 
	//return $id;
	$emp = $this->budget_m->get_emp_info($id);
	$bud = $this->budget_m->get_bud_info($emp[0]['BUDGET_ID']);
	//return $emp;

	$companyAllocation = $emp[0]['ALLOC_TOTAL'];
	$validPeriods = $this->budget_m->determineValidPeriods( $emp );

	$pmsal = $this->budget_m->get_salary_from_pmout($id, $this->globals_m->current_year());
	$pmbone = $this->budget_m->get_bonus_from_pmout($id, $this->globals_m->current_year());

	for($s=1;$s<13;$s++){
		$taxableSalary["P_{$s}"] = $pmsal[0]["P_{$s}"] + $pmbone[0]["P_{$s}"];
	} // end for
	//return $taxableSalary;

	$pmw['EMP_ID'] = $pmsal[0]['EMP_ID'];
	$pmw['EMPLID'] = $pmsal[0]['EMPLID'];
	$pmw['Year_id'] = $pmsal[0]['Year_id'];
	$pmw['Ver_id'] = $this->globals_m->version_id();
	$pmw['Unit_id'] = $pmsal[0]['Unit_id'];
	$pmw['Line_id'] = 6220;
	$pmw['Cust1_id'] = $pmsal[0]['Cust1_id'];
	$pmw['Cust2_id'] = $pmsal[0]['Cust2_id'];

	$wcRate = $this->budget_m->get_wcomp_rate($emp[0]['EMP_STATE'], $emp[0]['JOB_ID']);
	$staffRate = $this->budget_m->get_staff_rate( $emp[0]['COMPANY_ID'] . '000' );
	if(!$wcRate){$wcRate = 0;}

	if( (int)$emp[0]['JOB_ID'] != 4299 ):
		if( (int)$emp[0]['JOB_ID'] == 4133 || (int)$emp[0]['JOB_ID'] == 4132 || (int)$emp[0]['JOB_ID'] == 4633 ) :
		 	//not tennessee and not bonus and is CA
		 	for($w=1;$w<13;$w++){
		 		$thisOne = (($pmsal[0]["P_".$w] + $staffRate) * $wcRate/100);
		 		$pmw["P_".$w] = number_format($thisOne,2,".","");
		 	} // end for
		else:
			//not tennessee and not bonus and not CA
			for($w=1;$w<13;$w++){
				$thisOne = $pmsal[0]["P_".$w] * $wcRate/100;
		 		$pmw["P_".$w] = number_format($thisOne,2,".","");
		 	} // end for
		endif;
	else:
		// this is NOT TN and could be staffing bonus
		if ( (int)$emp[0]['JOB_ID'] == 4133 || (int)$emp[0]['JOB_ID'] == 4132 || (int)$emp[0]['JOB_ID'] == 4633 ):
			for($w=1;$w<13;$w++){
		 		$thisOne = (($taxableSalary["P_".$w] + $staffRate) * $wcRate/100);
		 		$pmw["P_".$w] = number_format($thisOne,2,".","");
		 	} // end for
		else:
			for($w=1;$w<13;$w++){
		 		$thisOne = $taxableSalary["P_".$w] * $wcRate/100;
		 		$pmw["P_".$w] = number_format($thisOne,2,".","");
		 	} // end for
		endif;
	endif;

	$pmw['keyCol'] = $pmw['EMP_ID'] . $pmw['Line_id'] . $pmw['Cust1_id'] . $pmw['Year_id'];

	return $pmw;
} // end compute_pm_wcomp function
/**************************************************/
/***************************************************/
public function get_complete_employee($id){
	$curr_year = $this->globals_m->current_year();
	$empty_array = array(array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0));

	$q = $this->db->select('bf.*,d.Department,j.jobTitle')
	        ->join('departments d', 'bf.DEPARTMENT_ID = d.deptCode')
	        ->join('jobcodes j', 'bf.JOB_ID = j.jobCode')  
	        ->where('EE_YEAR', $curr_year)
	        ->where('EMP_ID',$id)
	        ->get('budget_feed bf');
	$feed = $q->result_array();

	$q = $this->db->where('id',$feed[0]['BUDGET_ID'])->get('budgets');
	$budget = $q->result_array();

	$ABS = $this->budget_m->get_employee_period_totals($id,$curr_year,'ABS');
	if( count($ABS) == 0 ) $ABS = $empty_array;
	$CAH = $this->budget_m->get_employee_period_totals($id,$curr_year,'CAH');
	if( count($CAH) == 0 ) $CAH = $empty_array;
	$DHA = $this->budget_m->get_employee_period_totals($id,$curr_year,'DHA');
	if( count($DHA) == 0 ) $DHA = $empty_array;
	$DVB = $this->budget_m->get_employee_period_totals($id,$curr_year,'DVB');
	if( count($DVB) == 0 ) $DVB = $empty_array;
	$EMA = $this->budget_m->get_employee_period_totals($id,$curr_year,'EMA');
	if( count($EMA) == 0 ) $EMA = $empty_array;
	$FTE = $this->budget_m->get_employee_period_totals($id,$curr_year,'FTE');
	if( count($FTE) == 0 ) $FTE = $empty_array;
	$NTE = $this->budget_m->get_employee_period_totals($id,$curr_year,'NTE');
	if( count($NTE) == 0 ) $NTE = $empty_array;
	$OTH = $this->budget_m->get_employee_period_totals($id,$curr_year,'OTH');
	if( count($OTH) == 0 ) $OTH = $empty_array;
	$VSM = $this->budget_m->get_employee_period_totals($id,$curr_year,'VSM');
	if( count($VSM) == 0 ) $VSM = $empty_array;
	$PSA = $this->budget_m->get_employee_period_totals($id,$curr_year,'PSA');
	if( count($PSA) == 0 ) $PSA = $empty_array;

	if( $feed[0]['EE_TYPE'] == 'S'){
		$FTE = array(array('P_1'=>40,'P_2'=>40,'P_3'=>40,'P_4'=>40,'P_5'=>40,'P_6'=>40,'P_7'=>40,'P_8'=>40,'P_9'=>40,'P_10'=>40,'P_11'=>40,'P_12'=>40));
	} // end if

	$SAL = $this->budget_m->get_salary_period_adjustments($id);
	if( !$SAL || count($SAL) == 0 ){
		$SAL = array(array('P_1'=>$feed[0]['ADJUSTED_HOURLY_RATE'],'P_2'=>$feed[0]['ADJUSTED_HOURLY_RATE'],'P_3'=>$feed[0]['ADJUSTED_HOURLY_RATE'],'P_4'=>$feed[0]['ADJUSTED_HOURLY_RATE'],'P_5'=>$feed[0]['ADJUSTED_HOURLY_RATE'],'P_6'=>$feed[0]['ADJUSTED_HOURLY_RATE'],'P_7'=>$feed[0]['ADJUSTED_HOURLY_RATE'],'P_8'=>$feed[0]['ADJUSTED_HOURLY_RATE'],'P_9'=>$feed[0]['ADJUSTED_HOURLY_RATE'],'P_10'=>$feed[0]['ADJUSTED_HOURLY_RATE'],'P_11'=>$feed[0]['ADJUSTED_HOURLY_RATE'],'P_12'=>$feed[0]['ADJUSTED_HOURLY_RATE']));
	} // end if

	$stipend = $this->budget_m->get_monthly_stipend($id, $curr_year);
	if( !$stipend || count($stipend) == 0 ){
		$SAL = array(
			array(
				'P_1'=>$PSA[0]['P_1'] * $VSM[0]['P_1'],
				'P_2'=>$PSA[0]['P_2'] * $VSM[0]['P_2'],
				'P_3'=>$PSA[0]['P_3'] * $VSM[0]['P_3'],
				'P_4'=>$PSA[0]['P_4'] * $VSM[0]['P_4'],
				'P_5'=>$PSA[0]['P_5'] * $VSM[0]['P_5'],
				'P_6'=>$PSA[0]['P_6'] * $VSM[0]['P_6'],
				'P_7'=>$PSA[0]['P_7'] * $VSM[0]['P_7'],
				'P_8'=>$PSA[0]['P_8'] * $VSM[0]['P_8'],
				'P_9'=>$PSA[0]['P_9'] * $VSM[0]['P_9'],
				'P_10'=>$PSA[0]['P_10'] * $VSM[0]['P_10'],
				'P_11'=>$PSA[0]['P_11'] * $VSM[0]['P_11'],
				'P_12'=>$PSA[0]['P_12'] * $VSM[0]['P_12'])
			);
	} // end if

	return array( 'budget'=>$budget[0], 'feed'=>$feed[0], 'hourly_rate' => $SAL[0], 'monthly_stipend' => $stipend[0], 'additional_benefits' => $ABS[0], 'additional_hours' => $CAH[0], 'dining_hours' => $DHA[0], 'development_bonus' => $DVB[0], 'employee_meals' => $EMA[0], 'fte' => $FTE[0], 'overtime_hours' => $OTH[0], 'valid_stipend_periods' => $VSM[0] );
} // end get_complete_employee function
/**************************************************/
public function insert_array($table,$array){
	$this->db->insert($table, $array);
	return $this->db->insert_id();
} // end insert_array function
/**************************************************/
public function update_by_array($table,$where,$array){
	$this->db->where($where)->update($table, $array);
	return $this->db->insert_id();
} // end update_by_array function
/**************************************************/
/***************************************************/
/***************************************************/
} // end class
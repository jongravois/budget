<?php

class Sam_m extends CI_Model{

function __construct(){
	parent::__construct();
} // end constructor
/***************************************************/
/***************************************************/
public function ajax_get_atm_total_by_asset($budget_id, $asset_code, $year_id){
	$co_id = (int)substr($budget_id,0,3);
	$de_id = substr($budget_id,-2);
	if( $de_id == '00'){ $de_id = 99; } else { $de_id = (int)$de_id; } // end if
	
	$sql = "SELECT SUM([P1]) + SUM([P2]) + SUM([P3]) + SUM([P4]) + SUM([P5]) + SUM([P6]) + SUM([P7]) + SUM([P8]) + SUM([P9]) + SUM([P10]) + SUM([P11]) + SUM([P12]) AS year_total FROM [EdR_Budgeting].[dbo].[sam_asset_feed] WHERE [COMPANY_ID] = {$co_id} AND [DEPARTMENT_ID] = {$de_id} AND RIGHT([SAM_PROJECT],2) = {$asset_code} AND YEAR_ID = {$year_id}";

	$q = $this->db->query($sql);
	//return $this->db->last_query();
	if($q->num_rows() > 0) {
        return $q->row('year_total');
    } else {
    	return 0;
    } //end if
} // end ajax_get_atm_total_by_asset function
/**************************************************/
public function ajax_get_monthly_total_by_year($budget_id, $asset_code, $year_id){
	$co_id = (int)substr($budget_id,0,3);
	$de_id = substr($budget_id,-2);
	if( $de_id == '00'){ $de_id = 99; } else { $de_id = (int)$de_id; } // end if
	
	$sql = "SELECT SUM([P1]) AS P_1, SUM([P2]) AS P_2, SUM([P3]) AS P_3, SUM([P4]) AS P_4, SUM([P5]) AS P_5, SUM([P6]) AS P_6, SUM([P7]) AS P_7, SUM([P8]) AS P_8, SUM([P9]) AS P_9, SUM([P10]) AS P_10, SUM([P11]) AS P_11, SUM([P12]) AS P_12 FROM [EdR_Budgeting].[dbo].[sam_asset_feed] WHERE [COMPANY_ID] = {$co_id} AND [DEPARTMENT_ID] = {$de_id} AND RIGHT([SAM_PROJECT],2) = {$asset_code} AND YEAR_ID = {$year_id}";

	$q = $this->db->query($sql);
	if($q->num_rows() > 0) {
		$retHTML = $q->result_array();
        return $retHTML;
    } //end if
} // end ajax_get_monthly_total_by_year function
/**************************************************/
public function ajax_get_projects_for_sam($budget_id, $asset_code){
	$curr_year = $this->globals_m->current_year();
	$co_id = (int)substr($budget_id,0,3);
	$de_id = substr($budget_id,-2);
	if( $de_id == '00'){ $de_id = 99; } else { $de_id = (int)$de_id; } // end if

	$sql = "SELECT * FROM sam_asset_feed WHERE COMPANY_ID = {$co_id} AND DEPARTMENT_ID = {$de_id} AND YEAR_ID = {$curr_year} AND RIGHT(SAM_PROJECT,2) = {$asset_code} ORDER BY SAM_PROJECT";
	$q = $this->db->query($sql);
    return $q->result_array();
} // end ajax_get_projects_for_sam function
/**************************************************/
public function ajax_get_sam_note_by_year($budget_id,$asset_code,$budget_year){
	$CY = $this->globals_m->current_year();
	$co_id = (int)substr($budget_id,0,3);
	$de_id = substr($budget_id,-2);
	if( $de_id == '00'){ $de_id = 99; } else { $de_id = (int)$de_id; } // end if

	$q = $this->db->select('NOTE')
				  ->where('COMPANY_ID', $co_id)
				  ->where('DEPARTMENT_ID', $de_id)
				  ->where('ASSET_ID',$asset_code)
				  ->where('BUDGET_YEAR',$budget_year)
	              ->get('sam_notes');
	//return $this->db->last_query();
	return $q->row('NOTE');
} // end ajax_get_sam_note_by_year function
/**************************************************/			
public function ajax_get_timeline_amount($budget_id, $asset_code, $budget_year){
	$CY = $this->globals_m->current_year();
	$co_id = (int)substr($budget_id,0,3);
	$de_id = substr($budget_id,-2);
	if( $de_id == '00'){ $de_id = 99; } else { $de_id = (int)$de_id; } // end if

	if( strlen($budget_year) == 2){ $budget_year = '20' . $budget_year; }

	$q = $this->db->select('AMOUNT')
	              ->where('YEAR_ID',$CY)
	              ->where('COMPANY_ID', $co_id)
	              ->where('DEPARTMENT_ID',$de_id)
	              ->where('PROJECT_CODE',$asset_code)
	              ->where('BUDGET_YEAR',$budget_year)
	              ->get('atm_feed');
	return $q->row('AMOUNT');
} // end ajax_get_timeline_amount function
/**************************************************/
public function ajax_get_timeline_note($budget_id, $asset_code, $budget_year){
	$CY = $this->globals_m->current_year();
	$co_id = (int)substr($budget_id,0,3);
	$de_id = substr($budget_id,-2);
	if( $de_id == '00'){ $de_id = 99; } else { $de_id = (int)$de_id; } // end if

	$q = $this->db->select('NOTE')
	              ->where('COMPANY_ID', $co_id)
	              ->where('DEPARTMENT_ID',$de_id)
	              ->where('ASSET_ID',$asset_code)
	              ->where('BUDGET_YEAR',$budget_year)
	              ->get('sam_notes');
	return $q->row('NOTE');
} // end ajax_get_timeline_note function
/**************************************************/
public function ajax_get_timeline_for_edit($id, $assID){
	$co_id = (int)substr($id,0,3);
	$de_id = substr($id,-2);
	if( $de_id == '00'){ $de_id = 99; } else { $de_id = (int)$de_id; } // end if
	$curr_year = $this->globals_m->current_year();

	$q = $this->db->where('COMPANY_ID',$co_id)
	              ->where('DEPARTMENT_ID',$de_id)
	              ->where('PROJECT_CODE',$assID)
	              ->where('YEAR_ID',$curr_year)
	              ->get('atm_feed');

	if($q->num_rows() > 0) {
		$data = $q->result_array();
       return $data;
    } //end if
} // end ajax_get_timeline_for_edit function
/**************************************************/
public function get_aggregate_co_total($co_id, $cat){
	$CY = $this->globals_m->current_year();
	$sql = "SELECT SAM_TYPE, SUM([P1]) + SUM([P2]) + SUM([P3]) + SUM([P4]) + SUM([P5]) + SUM([P6]) +  SUM([P7]) + SUM([P8]) + SUM([P9]) + SUM([P10]) + SUM([P11]) + SUM([P12]) AS TOTAL FROM sam_asset_feed WHERE COMPANY_ID = {$co_id} AND SAM_TYPE = '{$cat}' AND YEAR_ID = {$CY} GROUP BY SAM_TYPE";
    $q = $this->db->query( $sql );
        
    if ($q->num_rows() > 0) {
	    foreach($q->result_array() as $row){
		  $data[] = $row;
	    } // end foreach
	    return $data;
    } // end if
        //return $this->db->last_query();
        return false;
} // end get_aggregate_co_total function
/**************************************************/
public function get_all_projects_for_sam($budget_id){
	$curr_year = $this->globals_m->current_year();
	$co_id = (int)substr($budget_id,0,3);
	$de_id = substr($budget_id,-2);
	if( $de_id == '00'){ $de_id = 99; } else { $de_id = (int)$de_id; } // end if

	$sql = "SELECT * FROM sam_asset_feed WHERE COMPANY_ID = {$co_id} AND DEPARTMENT_ID = {$de_id} AND YEAR_ID = {$curr_year} ORDER BY SAM_PROJECT";
	$q = $this->db->query($sql);
	//return $this->db->last_query();
    return $q->result_array();
} // end get_all_projects_for_sam function
/**************************************************/
public function get_asset_projects_for_sam($budget_id, $asset_code){
	$curr_year = $this->globals_m->current_year();
	$co_id = (int)substr($budget_id,0,3);
	$de_id = substr($budget_id,-2);
	if( $de_id == '00'){ $de_id = 99; } else { $de_id = (int)$de_id; } // end if

	$sql = "SELECT * FROM sam_asset_feed WHERE COMPANY_ID = {$co_id} AND DEPARTMENT_ID = {$de_id} AND YEAR_ID = {$curr_year} AND RIGHT(SAM_PROJECT,2) = {$asset_code} ORDER BY SAM_PROJECT";
	$q = $this->db->query($sql);
    return $q->result_array();
} // end get_asset_projects_for_sam function
/**************************************************/
public function get_asset_by_project_id($id){
	$sql = "SELECT sat.* FROM sam_asset_type AS sat JOIN sam_asset_feed as saf ON sat.PROJECT_CODE = RIGHT(saf.SAM_PROJECT,2) WHERE sat.PROJECT_CODE = {$id}";
	$q = $this->db->query($sql);
	return $q->result_array();
} // end get_asset_by_project_id function
/**************************************************/
public function get_asset_by_id($id){
	$q = $this->db->where('PROJECT_CODE', $id)->get('sam_asset_type');
	return $q->result_array();
} // end get_asset_by_id function
/**************************************************/
public function get_asset_name($id){
	$q = $this->db->select('ASSET_TYPE')->where('PROJECT_CODE',$id)->get('sam_asset_type');
	return $q->row('ASSET_TYPE');
} // end get_asset_name function
/**************************************************/
public function get_asset_total($id, $projID){
	//error_reporting(E_ALL);
	$co_id = (int)substr($id,0,3);
	$de_id = substr($id,-2);
	if( $de_id == '00'){ $de_id = 99; } else { $de_id = (int)$de_id; } // end if
	$curr_year = $this->globals_m->current_year();

	$sql = "SELECT SUM(P1) + SUM(P2) + SUM(P3) + SUM(P4) + SUM(P5) + SUM(P6)+ SUM(P7) + SUM(P8) + SUM(P9) + SUM(P10) + SUM(P11) + SUM(P12) AS total FROM sam_asset_feed WHERE COMPANY_ID = {$co_id} AND DEPARTMENT_ID = {$de_id} AND RIGHT(SAM_PROJECT,2) = '{$projID}' AND YEAR_ID = {$curr_year}";
	$q = $this->db->query($sql);
	
	if($q->num_rows > 0){
		return $q->row('total');
	} // end if
	return 0;
} // end get_asset_total function
/**************************************************/
public function get_asset_type($id){
	$q = $this->db->select('PROJECT_TYPE')->where('PROJECT_CODE',$id)->get('sam_asset_type');
	return $q->row('PROJECT_TYPE');
} // end get_asset_type function
/**************************************************/
public function get_bed_types($co_id){
	$DB2 = $this->load->database('pmfinancials', TRUE);
	$CY = $this->globals_m->current_year();
	$PY = (int)$CY-1;

    $sql = "SELECT CAST(DEC AS INT) AS 'Design Beds' FROM pmfinancials.FINLOC_BASE where line_id = 9112 and ver_id = 80000000 and year_id = {$PY} and cust1_id = 100 and cust2_id = 1 and unit_id = {$co_id}";
    $q = $DB2->query($sql);
    return $q->row('Design Beds');
} // end get_bed_types function
/**************************************************/
public function get_budget_id_from_project($id){
	$q = $this->db->select('COMPANY_ID,DEPARTMENT_ID')->where('id',$id)->get('sam_asset_feed');
	if($q->row('DEPARTMENT_ID') == '99'){
		return $q->row('COMPANY_ID') . '000';
	} else {
		return $q->row('COMPANY_ID') . '0' . $q->row('DEPARTMENT_ID');
	} // end if
} // end get_budget_id_from_project function
/**************************************************/
public function get_cip_switch($id){
	$q = $this->db->select('CIP_CODE')->where('id',$id)->get('budgets');
	return $q->row('CIP_CODE');
} // end get_cip_switch function
/**************************************************/
public function get_company_atm($id){
	$co_id = (int)substr($id,0,3);
	$de_id = substr($id,-2);
	if( $de_id == '00'){ $de_id = 99; } else { $de_id = (int)$de_id; } // end if
	$CY = $this->globals_m->current_year();
	$curr_year = (int) '20' . $CY;

	$yrs['P'] = ($curr_year - 1);
	$yrs['C'] = ($curr_year);

	$sql = "WITH sat (PROJECT_CODE, ASSET_TYPE, PROJECT_TYPE) AS (SELECT sat.PROJECT_CODE, sat.ASSET_TYPE, sat.PROJECT_TYPE from sam_asset_type sat join atm_feed atm on (atm.PROJECT_CODE = sat.PROJECT_CODE and atm.company_id = {$co_id} AND atm.DEPARTMENT_ID = {$de_id} AND atm.YEAR_ID = {$CY} AND ((atm.BUDGET_YEAR = {$yrs['P']} and atm.amount > 0) or (atm.budget_year >= {$yrs['C']} and atm.amount > 0)) ) group by sat.PROJECT_CODE, sat.ASSET_TYPE, sat.PROJECT_TYPE) SELECT atm.id, sat.PROJECT_CODE, sat.ASSET_TYPE, sat.PROJECT_TYPE, ISNULL(atm.amount, 0) AMOUNT FROM sat JOIN atm_feed atm ON (sat.PROJECT_CODE = atm.PROJECT_CODE AND BUDGET_YEAR = {$yrs['C']} AND atm.YEAR_ID = {$CY}) WHERE COMPANY_ID = {$co_id} AND DEPARTMENT_ID = {$de_id} AND YEAR_ID = {$CY} GROUP BY sat.PROJECT_CODE, sat.ASSET_TYPE, sat.PROJECT_TYPE, atm.id, AMOUNT ORDER BY sat.PROJECT_CODE";

	$q = $this->db->query($sql);
	//echo $this->db->last_query();
	return $q->result_array();
} // end get_company_atm function
/**************************************************/
public function get_company_atm_CY_totals($id){
	$co_id = (int)substr($id,0,3);
	$de_id = substr($id,-2);
	if( $de_id == '00'){ $de_id = 99; } else { $de_id = (int)$de_id; } // end if
	$CY = $this->globals_m->current_year();
	$curr_year = (int) '20' . $CY;

	$yrs['P'] = ($curr_year - 1);
	$yrs['C'] = ($curr_year);

	$sql = "WITH sat (PROJECT_CODE, ASSET_TYPE, PROJECT_TYPE) AS (SELECT sat.PROJECT_CODE, sat.ASSET_TYPE, sat.PROJECT_TYPE from sam_asset_type sat join atm_feed atm on (atm.PROJECT_CODE = sat.PROJECT_CODE  and atm.company_id = {$co_id} AND atm.DEPARTMENT_ID = {$de_id} AND atm.YEAR_ID = {$CY} AND ((atm.BUDGET_YEAR = {$yrs['P']} and atm.amount > 0) or (atm.budget_year = {$yrs['C']} and atm.amount > 0)) ) group by sat.PROJECT_CODE, sat.ASSET_TYPE, sat.PROJECT_TYPE) SELECT SUM(atm.AMOUNT) as TOTAL FROM sat JOIN atm_feed atm ON (sat.PROJECT_CODE = atm.PROJECT_CODE AND BUDGET_YEAR = {$yrs['C']} AND atm.YEAR_ID = {$CY}) WHERE COMPANY_ID = {$co_id} AND DEPARTMENT_ID = {$de_id} AND YEAR_ID = {$CY} GROUP BY sat.PROJECT_CODE, sat.ASSET_TYPE, sat.PROJECT_TYPE, atm.id, AMOUNT";

	$q = $this->db->query($sql);
	//echo $this->db->last_query();
	return $q->result_array();
} // end get_company_atm_CY_totals function
/**************************************************/
public function get_company_curryear_budgeted($id){
	$co_id = (int)substr($id,0,3);
	$de_id = substr($id,-2);
	if( $de_id == '00'){ $de_id = 99; } else { $de_id = (int)$de_id; } // end if
	$curr_year = $this->globals_m->current_year();

	$sql = "SELECT SUM(P1) + SUM(P2) + SUM(P3) + SUM(P4) + SUM(P5) + SUM(P6)+ SUM(P7) + SUM(P8) + SUM(P9) + SUM(P10) + SUM(P11) + SUM(P12) AS total FROM sam_asset_feed WHERE COMPANY_ID = {$co_id} AND DEPARTMENT_ID = '{$de_id}' AND YEAR_ID = {$curr_year}";
	$q = $this->db->query($sql);
	
	if($q->num_rows > 0){
		return $q->row('total');
	} // end if
	return false;
} // end get_company_curryear_budgeted function
/**************************************************/
public function get_company_curryear_projection($id){
	$co_id = (int)substr($id,0,3);
	$de_id = substr($id,-2);
	if( $de_id == '00'){ $de_id = 99; } else { $de_id = (int)$de_id; } // end if
	
	$CY = $this->globals_m->current_year();
	$curr_year = '20' . $CY;

	$sql = "SELECT SUM(AMOUNT) AS AMOUNT FROM atm_feed WHERE COMPANY_ID = {$co_id} AND DEPARTMENT_ID = {$de_id} AND YEAR_ID = {$CY} AND BUDGET_YEAR = {$curr_year} GROUP BY COMPANY_ID";
	$q = $this->db->query($sql);
	//return $this->db->last_query();
	return $q->row('AMOUNT');
} // end get_company_curryear_projection function
/**************************************************/
public function get_company_curryear_total($id){
	$co_id = (int)substr($id,0,3);
	$de_id = substr($id,-2);
	if( $de_id == '00'){ $de_id = 99; } else { $de_id = (int)$de_id; } // end if
	$CY = $this->globals_m->current_year();
	$curr_year = '20' . $CY;

	$sql = "SELECT sum({$curr_year}) as total FROM atm_feed WHERE COMPANY_ID = {$co_id} AND DEPARTMENT_ID = {$de_id} AND YEAR_ID = {$CY} AND STATUS = 'W'";
	$q = $this->db->query($sql);
	//return $this->db->last_query();
	return $q->row('total');
} // end get_company_curryear_total function
/**************************************************/
public function get_cy_budget_for_asset($val, $ast){
	$co_id = (int)substr($val,0,3);
	$de_id = substr($val,-2);
	if( $de_id == '00'){ $de_id = 99; } else { $de_id = (int)$de_id; } // end if

	$CY = $this->globals_m->current_year();
	$curr_year = '20' . $CY;

	$sql = "SELECT SUM(AMOUNT) AS total FROM atm_feed WHERE COMPANY_ID = {$co_id} AND DEPARTMENT_ID = {$de_id} AND YEAR_ID = {$CY} AND PROJECT_CODE = '{$ast}' AND BUDGET_YEAR = {$curr_year}";
	$q = $this->db->query($sql);
	//return $this->db->last_query();
	return $q->row('total');
} // end get_cy_budget_for_asset function
/**************************************************/
public function get_depreciation_switch($id){
	$q = $this->db->select('DEPRECIATION_CODE')->where('id',$id)->get('budgets');
	return $q->row('DEPRECIATION_CODE');
} // end get_depreciation_switch function
/**************************************************/
public function get_new_asset_dd($id){
	$co_id = (int)substr($id,0,3);
	$de_id = substr($id,-2);
	if( $de_id == '00'){ $de_id = 99; } else { $de_id = (int)$de_id; } // end if
	$CY = $this->globals_m->current_year();
	$curr_year = (int) '20' . $CY;

	$yrs['P'] = ($curr_year - 1);
	$yrs['C'] = ($curr_year);

	$sql = "WITH sat (PROJECT_CODE, ASSET_TYPE, PROJECT_TYPE) AS (SELECT sat.PROJECT_CODE, sat.ASSET_TYPE, sat.PROJECT_TYPE from sam_asset_type sat join atm_feed atm on (atm.PROJECT_CODE = sat.PROJECT_CODE and atm.company_id = {$co_id} AND atm.DEPARTMENT_ID = {$de_id} AND atm.YEAR_ID = {$CY} AND ((atm.BUDGET_YEAR = {$yrs['P']} and atm.amount > 0) or (atm.budget_year = {$yrs['C']} and atm.amount > 0)) ) group by sat.PROJECT_CODE, sat.ASSET_TYPE, sat.PROJECT_TYPE) SELECT PROJECT_CODE, PROJECT_CODE+'---'+ASSET_TYPE AS VALUE FROM sam_asset_type WHERE PROJECT_CODE NOT IN (SELECT sat.PROJECT_CODE FROM sat JOIN atm_feed atm ON (sat.PROJECT_CODE = atm.PROJECT_CODE AND BUDGET_YEAR = {$yrs['C']} AND atm.YEAR_ID = {$CY}) WHERE COMPANY_ID = {$co_id} AND DEPARTMENT_ID = {$de_id} AND YEAR_ID = {$CY} GROUP BY sat.PROJECT_CODE, sat.ASSET_TYPE, sat.PROJECT_TYPE, atm.id, AMOUNT)";

	$q = $this->db->query($sql);
	$data['0'] = "Please Select ... ";
	foreach ($q->result_array() as $row) {
		$data[ $row['PROJECT_CODE'] ] = $row['VALUE'];
	} // end foreach
	return $data;
} // end get_new_asset_dd function
/**************************************************/
public function old_get_new_asset_dd($budget_id){
	$co_id = substr($budget_id, 0, 3);
	$de_id = substr($budget_id,-2);
	if( $de_id == '00'){ $de_id = 99; } else { $de_id = (int)$de_id; } // end if
	$CY = $this->globals_m->current_year();
	$curr_year = (int) '20' . $CY;

	$yrs[1] = '[' . ($curr_year - 5) . ']';
	$yrs[2] = '[' . ($curr_year - 4) . ']';
	$yrs[3] = '[' . ($curr_year - 3) . ']';
	$yrs[4] = '[' . ($curr_year - 2) . ']';
	$yrs[5] = '[' . ($curr_year - 1) . ']';
	$yrs[6] = '[' . ($curr_year) . ']';
	$yrs[7] = '[' . ($curr_year + 1) . ']';
	$yrs[8] = '[' . ($curr_year + 2) . ']';
	$yrs[9] = '[' . ($curr_year + 3) . ']';
	$yrs[10] = '[' . ($curr_year + 4) . ']';

	$sql = "SELECT PROJECT_CODE, PROJECT_CODE+' -- '+ASSET_TYPE AS VALUE FROM [EdR_Budgeting].[dbo].[sam_asset_type] WHERE PROJECT_CODE NOT IN ( SELECT DISTINCT(PROJECT_CODE) FROM atm_feed WHERE COMPANY_ID = {$co_id} AND DEPARTMENT_ID = {$de_id} AND YEAR_ID = {$CY} AND ( ( {$yrs[6]} is not null AND {$yrs[6]} != 0) OR ( {$yrs[5]} is not null AND {$yrs[5]} != 0 ) ) )";
	$q = $this->db->query($sql);

	$data['0'] = "Please Select ... ";
	if ( $q->num_rows() > 0 ) {
		foreach ($q->result() as $row) {
			$data[ $row->PROJECT_CODE ] = $row->VALUE;
		} // end foreach
		return $data;
	} // end if
} // end get_new_asset_dd function
/**************************************************/
public function get_project_ids_for_sam($budget_id){
	$curr_year = $this->globals_m->current_year();
	$co_id = (int)substr($budget_id,0,3);
	$de_id = substr($budget_id,-2);
	if( $de_id == '00'){ $de_id = 99; } else { $de_id = (int)$de_id; } // end if

	$sql = "SELECT id FROM sam_asset_feed WHERE COMPANY_ID = {$co_id} AND DEPARTMENT_ID = {$de_id} AND YEAR_ID = {$curr_year} ORDER BY SAM_PROJECT";
	$q = $this->db->query($sql);
	//return $this->db->last_query();
    return $q->result_array();
} // end get_project_ids_for_sam function
/**************************************************/
public function get_project_info($id){
	$q = $this->db->where('id',$id)->get('sam_asset_feed');
	return $q->result_array();
} // end get_project_full_info function
/**************************************************/
public function get_project_type_by_asset($id){
	$q = $this->db->select('PROJECT_TYPE')->where('PROJECT_CODE', $id)->get('sam_asset_type');
	return $q->row('PROJECT_TYPE');
} // end get_project_type_by_asset function
/**************************************************/
public function get_sam_cy_projection($budget_id, $asset_code, $budget_year = null){
	$co_id = substr($budget_id, 0, 3);
	$de_id = substr($budget_id,-2);
	if( $de_id == '00'){ $de_id = 99; } else { $de_id = (int)$de_id; } // end if

	$CY = $this->globals_m->current_year();
	if( !$budget_year ){ $budget_year = "20" . $CY; }
	

	$q = $this->db->select('AMOUNT')->where('COMPANY_ID',$co_id)
	                            ->where('DEPARTMENT_ID',$de_id)
	                            ->where('PROJECT_CODE', $asset_code)
	                            ->where('YEAR_ID', $CY)
	                            ->where('BUDGET_YEAR', $budget_year)
	                            ->get('atm_feed');
	//return $this->db->last_query();
	return $q->result_array();
} // end get_sam_cy_projection function
/**************************************************/
public function get_sam_cy_asset_budgeted($budget_id, $asset_code){
	$curr_year = $this->globals_m->current_year();
	$co_id = substr($budget_id, 0, 3);
	$de_id = substr($budget_id,-2);
	if( $de_id == '00'){ $de_id = 99; } else { $de_id = (int)$de_id; } // end if

	$sql = "SELECT SUM([P1])+SUM([P2])+SUM([P3])+SUM([P4])+SUM([P5])+SUM([P6])+SUM([P7])+SUM([P8])+SUM([P9])+SUM([P10])+SUM([P11])+SUM([P12]) AS budgeted FROM [EdR_Budgeting].[dbo].[sam_asset_feed] WHERE [COMPANY_ID] = {$co_id} AND [DEPARTMENT_ID] = {$de_id} AND [YEAR_ID] = {$curr_year} AND RIGHT([SAM_PROJECT],2) = {$asset_code}";
	$q = $this->db->query($sql);
	//return $this->db->last_query();
	return $q->result_array();
} // end get_sam_cy_asset_budgeted function
/**************************************************/
public function get_sam_proj_budgeted($budget_id, $asset_code, $proj_id){
	$curr_year = $this->globals_m->current_year();
	$co_id = substr($budget_id, 0, 3);
	$de_id = substr($budget_id,-2);
	if( $de_id == '00'){ $de_id = 99; } else { $de_id = (int)$de_id; } // end if

	$sql = "SELECT [P1]+[P2]+[P3]+[P4]+[P5]+[P6]+[P7]+[P8]+[P9]+[P10]+[P11]+[P12] AS budgeted FROM [EdR_Budgeting].[dbo].[sam_asset_feed] WHERE [COMPANY_ID] = {$co_id} AND [DEPARTMENT_ID] = {$de_id} AND [YEAR_ID] = {$curr_year} AND RIGHT([SAM_PROJECT],2) = {$asset_code} AND id = {$proj_id}";
	$q = $this->db->query($sql);
	//return $this->db->last_query();
	return $q->row('budgeted');
} // end get_sam_proj_budgeted function
/**************************************************/
public function delete_sam_project($id){
	$this->db->where('id',$id)->delete('sam_asset_feed');
	return $this->db->last_query();
} // end delete_sam_project function
/**************************************************/
public function new_asset_to_list($bid,$aid,$amount){
	$curr_year = $this->globals_m->current_year();
	$CY = '20' . $curr_year;
	$co_id = (int)substr($bid,0,3);
	$de_id = substr($bid,-2);
	if( $de_id == '00'){ $de_id = 99; } else { $de_id = (int)$de_id; } // end if

	$q = $this->db->select('id')
	              ->where('COMPANY_ID',$co_id)
	              ->where('DEPARTMENT_ID',$de_id)
	              ->where('Year_id', $curr_year)
	              ->where('PROJECT_CODE',$aid)
	              ->where('BUDGET_YEAR',$CY)
	              ->get('atm_feed');
	
	if($q->num_rows > 0){
		// UPDATE
		$arrUpdate['AMOUNT'] = $amount;
		$this->db->where('id', $q->row('id'))->update('atm_feed', $arrUpdate);
		return $this->db->last_query();
	} else { 
	// INSERT
		$arrInsert = array(
			'YEAR_ID' => $curr_year,
			'COMPANY_ID' => $co_id,
			'DEPARTMENT_ID' => $de_id,
			'PROJECT_CODE' => $aid,
			'BUDGET_YEAR' => $CY,
			'ORIGINAL' => $amount,
			'AMOUNT' => $amount
		);
		$this->db->insert('atm_feed', $arrInsert);
		return $this->db->last_query();
	} // end if
} // end new_asset_to_list function
/**************************************************/
public function old_open_atm($id){
	$co_id = (int)substr($id,0,3);
	$de_id = substr($id,-2);
	if( $de_id == '00'){ $de_id = 99; } else { $de_id = (int)$de_id; } // end if

	$CY = $this->globals_m->current_year();
	$PY = (int)$CY - 1;
	$curr_year = (int) '20' . $CY;

	$yrs[1] = '[' . ($curr_year - 5) . ']';
	$yrs[2] = '[' . ($curr_year - 4) . ']';
	$yrs[3] = '[' . ($curr_year - 3) . ']';
	$yrs[4] = '[' . ($curr_year - 2) . ']';
	$yrs[5] = '[' . ($curr_year - 1) . ']';
	$yrs[6] = '[' . ($curr_year) . ']';
	$yrs[7] = '[' . ($curr_year + 1) . ']';
	$yrs[8] = '[' . ($curr_year + 2) . ']';
	$yrs[9] = '[' . ($curr_year + 3) . ']';
	$yrs[10] = '[' . ($curr_year + 4) . ']';

	// ensure db clean
	$q = $this->db
	          ->where('STATUS','W')
	          ->where('YEAR_ID', $CY)
	          ->where('COMPANY_ID', $co_id)
	          ->where('DEPARTMENT_ID',$de_id)
	          ->get('atm_feed');
	
	if($q->num_rows > 0){
		$d = $this->db
	          ->where('STATUS','W')
	          ->where('YEAR_ID', $CY)
	          ->where('COMPANY_ID', $co_id)
	          ->where('DEPARTMENT_ID',$de_id)
	          ->delete('atm_feed');
	} // end if

	// copy from last year to current and change to 'W' status
	$sql = "INSERT INTO atm_feed SELECT {$CY} AS [YEAR_ID], 'W' AS [STATUS], [COMPANY_ID], [DEPARTMENT_ID], [PROJECT_CODE], {$yrs[1]}, {$yrs[2]}, {$yrs[3]}, {$yrs[4]}, {$yrs[5]}, {$yrs[6]}, {$yrs[7]}, {$yrs[8]}, {$yrs[9]}, {$yrs[10]} FROM atm_feed WHERE STATUS='O' AND YEAR_ID = {$PY} AND COMPANY_ID = {$co_id} AND DEPARTMENT_ID = {$de_id}";
	$this->db->query($sql);
} // end open_atm function
/**************************************************/
public function open_atm($id){
	$co_id = (int)substr($id,0,3);
	$de_id = substr($id,-2);
	if( $de_id == '00'){ $de_id = 99; } else { $de_id = (int)$de_id; } // end if

	$CY = $this->globals_m->current_year();
	$PY = (int)$CY - 1;
	$curr_year = (int) '20' . $CY;

	$yrs[1] = $curr_year - 5; 	// 2009 
	$yrs[2] = $curr_year - 4;  	// 2010
	$yrs[3] = $curr_year - 3;	// 2011
	$yrs[4] = $curr_year - 2;  	// 2012
	$yrs[5] = $curr_year - 1;	// 2013
	$yrs[6] = $curr_year;		// 2014
	$yrs[7] = $curr_year + 1;  	// 2015
	$yrs[8] = $curr_year + 2; 	// 2016
	$yrs[9] = $curr_year + 3;	// 2017
	$yrs[10] = $curr_year + 4;	// 2018

	// clean database (in case)
	$sql = "DELETE FROM atm_feed WHERE COMPANY_ID = {$co_id} AND DEPARTMENT_ID = {$de_id} AND YEAR_ID = {$CY}";
	$doit = $this->db->query($sql);

	$pcSQL = "SELECT DISTINCT PROJECT_CODE FROM atm_feed WHERE COMPANY_ID = {$co_id} AND DEPARTMENT_ID = {$de_id} AND YEAR_ID = {$PY}";
	$q = $this->db->query($pcSQL);
	$all_codes = $q->result();
	
	// loop through last year and insert this year with PY->AMOUNT = CY->ORIGINAL & CY->AMOUNT
	foreach( $all_codes as $code ):
		for($y=1; $y<11; $y++){
			$sql3 = "SELECT AMOUNT FROM atm_feed WHERE COMPANY_ID = {$co_id} AND DEPARTMENT_ID = {$de_id} AND YEAR_ID = {$PY} AND PROJECT_CODE = {$code->PROJECT_CODE} AND BUDGET_YEAR = {$yrs[$y]}";
			$doit3 = $this->db->query($sql3);
			$val = $doit3->row('AMOUNT');
			if( !$val ){ $val = 0.00; }

			$sql5 = "INSERT INTO atm_feed (YEAR_ID,COMPANY_ID,DEPARTMENT_ID,PROJECT_CODE,BUDGET_YEAR,ORIGINAL,AMOUNT) VALUES ( {$CY}, {$co_id}, {$de_id}, {$code->PROJECT_CODE}, {$yrs[$y]}, $val, $val )";
			$doit10 = $this->db->query($sql5);
		} // end for

		// insert new 4th year out
		$sql10 = "INSERT INTO atm_feed VALUES ( {$CY}, {$co_id}, {$de_id}, {$code->PROJECT_CODE}, {$yrs[10]}, 0.00, 0.00 )";
		$doit10 = $this->db->query($sql10);
	endforeach;

	return true;
} // end open_atm function
/**************************************************/
public function open_sam($id){
	//return $id;
	$co_id = (int)substr($id,0,3);
	$de_id = substr($id,-2);
	if( $de_id == '00'){ $de_id = 99; } else { $de_id = (int)$de_id; } // end if

	$CY = $this->globals_m->current_year();

	$pSQL = "SELECT id FROM sam_asset_feed WHERE COMPANY_ID = {$co_id} AND DEPARTMENT_ID = {$de_id} AND YEAR_ID = {$CY}";
	$q = $this->db->query($pSQL);
	$all_projs = $q->result();
	//print_r($all_projs); die();

	$arrUpdate = array( 'P_1'=>0, 'P_2'=>0, 'P_3'=>0, 'P_4'=>0, 'P_5'=>0, 'P_6'=>0, 'P_7'=>0, 'P_8'=>0, 'P_9'=>0, 'P_10'=>0, 'P_11'=>0, 'P_12'=>0);

	foreach( $all_projs as $proj){
		$doit = $this->db->where('ASSET_ID',$proj->id)->where('YEAR_ID',$CY)->update('sam_pm_out', $arrUpdate);
	} // end foreach

	$dSQL = "DELETE FROM sam_asset_feed WHERE COMPANY_ID = {$co_id} AND DEPARTMENT_ID = {$de_id} AND YEAR_ID = {$CY}";
	$q = $this->db->query($dSQL);
	
	return;
} // end open_sam function
/**************************************************/
/**************************************************/
public function save_edited_project($id,$arr){
	$this->db->where('id',$id)->update('sam_asset_feed',$arr);
	return $this->db->last_query();
} // end save_edited_project function
/**************************************************/
public function save_new_project($arr){
	$this->db->insert('sam_asset_feed', $arr);
	return $this->db->insert_id();
} // end save_new_project function
/**************************************************/
public function save_tenyear_note($arr){
	$q = $this->db->select('id')
		          ->where('COMPANY_ID', $arr['COMPANY_ID'])
		          ->where('DEPARTMENT_ID', $arr['DEPARTMENT_ID'])
		          ->where('ASSET_ID', $arr['ASSET_ID'])
		          ->where('BUDGET_YEAR',$arr['BUDGET_YEAR'])
		          ->get('sam_notes');

	if($q->num_rows > 0){
	// UPDATE
		$this->db->where('id', $q->row('id'))->update('sam_notes', $arr);
		return $this->db->last_query();
	} else { 
	// INSERT
		$this->db->insert('sam_notes', $arr);
		return $this->db->last_query();
	} // end if
} // end save_tenyear_notes function
/**************************************************/
public function save_tenyear_projection($arr){
	$CY = $this->globals_m->current_year();
	$q = $this->db->select('id')
	              ->where('COMPANY_ID', $arr['COMPANY_ID'])
	              ->where('DEPARTMENT_ID', $arr['DEPARTMENT_ID'])
	              ->where('PROJECT_CODE', $arr['PROJECT_CODE'])
	              ->where('BUDGET_YEAR',$arr['BUDGET_YEAR'])
	              ->where('YEAR_ID',$CY)
	              ->get('atm_feed');

	if($q->num_rows > 0){
	// UPDATE
		$this->db->where('id', $q->row('id'))->update('atm_feed', $arr);
		return $this->db->last_query();
	} else { 
	// INSERT
		$this->db->insert('atm_feed', $arr);
		return $this->db->last_query();
	} // end if
} // end save_tenyear_projections function
/**************************************************/
/**************************************************/
public function save_to_sam_pm_out($id, $pid, $bid, $arr, $action){
	// print_r($id); die(); // 85 (sam_asset_feed::id)
	// print_r($pid); die(); // 10 (sam_asset_feed::Asset_id)
	// print_r($bid); die(); //300000 
	// print_r($arr); die(); 
	// print_r($action); die(); //update
	$CY = $this->globals_m->current_year();
	// print_r($CY); die(); // 14

	$co_id = substr($bid, 0, 3); //300
	$de_id = substr($bid,-2); // 00
	if( $de_id == '00'){ $de_id = 99; } else { $de_id = (int)$de_id; } // end if

	$fiscal = $this->fiscal_m->get_fiscal_info($this->budget_m->get_fiscal_by_id($bid));

	$this_asset = $this->get_asset_by_project_id($pid);
	$CIP_switch = $this->get_cip_switch($bid);
	$DIP_switch = $this->get_depreciation_switch($bid);
	// print_r($this_asset); die();

	$kill_existing = "DELETE FROM sam_pm_out WHERE Unit_id = {$co_id} AND Corp_id = {$de_id} AND ASSET_ID = '{$pid}' AND Year_id = {$CY}";
	// echo $kill_existing; die();
	$q = $this->db->query($kill_existing);

	if($action == 'delete'){
		$pm['forPMSTAT'] = array(
			'ASSET_ID' => (int) $pid,
			'Year_id'  => (int) $CY,
			'Ver_id'   => 80000000,
			'Unit_id'  => $co_id,
			'Line_id'  => 9202,
			'Cust1_id' => 999,
			'Cust2_id' => $pid,
			'Corp_id'  => $de_id,
			'P_1'      => 0,
			'P_2'      => 0,
			'P_3'      => 0,
			'P_4'      => 0,
			'P_5'      => 0,
			'P_6'      => 0,
			'P_7'      => 0,
			'P_8'      => 0,
			'P_9'      => 0,
			'P_10'     => 0,
			'P_11'     => 0,
			'P_12'     => 0
		);

		$pm['forPMCIP'] = array(
	    	'ASSET_ID' => (int) $pid,
		    'Year_id' => (int) $CY,
		    'Ver_id' => 80000000,
		    'Unit_id' => $co_id,
		    'Line_id' => 2025,
		    'Cust1_id' => 0,
		    'Cust2_id' => $pid,
		    'Corp_id' => $de_id,
		    'P_1'      => 0,
			'P_2'      => 0,
			'P_3'      => 0,
			'P_4'      => 0,
			'P_5'      => 0,
			'P_6'      => 0,
			'P_7'      => 0,
			'P_8'      => 0,
			'P_9'      => 0,
			'P_10'     => 0,
			'P_11'     => 0,
			'P_12'     => 0
		);

		$pm['forPMDEPR'] = array(
	    	'ASSET_ID' => (int) $pid,
		    'Year_id' => (int) $CY,
		    'Ver_id' => 80000000,
		    'Unit_id' => $co_id,
		    'Line_id' => $this_asset[0]['DEPRECIATION_ACCOUNT_NUMBER'],
		    'Cust1_id' => 80,
		    'Cust2_id' => $pid,
		    'Corp_id' => $de_id,
		    'P_1'      => 0,
			'P_2'      => 0,
			'P_3'      => 0,
			'P_4'      => 0,
			'P_5'      => 0,
			'P_6'      => 0,
			'P_7'      => 0,
			'P_8'      => 0,
			'P_9'      => 0,
			'P_10'     => 0,
			'P_11'     => 0,
			'P_12'     => 0
		);
	} else{
		$sqlGP = "SELECT SUM(P1) AS P1, SUM(P2) AS P2, SUM(P3) AS P3, SUM(P4) AS P4, SUM(P5) AS P5, SUM(P6) AS P6, SUM(P7) AS P7, SUM(P8) AS P8, SUM(P9) AS P9, SUM(P10) AS P10, SUM(P11) AS P11, SUM(P12) AS P12 FROM sam_asset_feed WHERE YEAR_ID = {$CY} AND COMPANY_ID = {$co_id} AND DEPARTMENT_ID = {$de_id} AND RIGHT(SAM_PROJECT,2) = '{$pid}'";
		// echo $sqlGP; die();
		$q = $this->db->query($sqlGP);
		$projTot = $q->result_array();

		// return $projTot;

		$pm['forPMSTAT'] = array(
			'ASSET_ID' => $pid,
			'Year_id'  => (int) $CY,
			'Ver_id'   => 80000000,
			'Unit_id'  => $co_id,
			'Line_id'  => 9202,
			'Cust1_id' => 999,
			'Cust2_id' => $pid,
			'Corp_id'  => $de_id,
			'P_1'      => $projTot[0]['P1'],
			'P_2'      => $projTot[0]['P2'],
			'P_3'      => $projTot[0]['P3'],
			'P_4'      => $projTot[0]['P4'],
			'P_5'      => $projTot[0]['P5'],
			'P_6'      => $projTot[0]['P6'],
			'P_7'      => $projTot[0]['P7'],
			'P_8'      => $projTot[0]['P8'],
			'P_9'      => $projTot[0]['P9'],
			'P_10'     => $projTot[0]['P10'],
			'P_11'     => $projTot[0]['P11'],
			'P_12'     => $projTot[0]['P12']
		);

		$pm['forPMCIP'] = array(
	    	'ASSET_ID' => $pid,
		    'Year_id' => (int) $CY,
		    'Ver_id' => 80000000,
		    'Unit_id' => $co_id,
		    'Line_id' => 2025,
		    'Cust1_id' => 0,
		    'Cust2_id' => $pid,
		    'Corp_id' => $de_id
		);

		if((int)$CIP_switch == 1):
			for($p=1;$p<13;$p++):
				$zz = $p - 1;
				$zzTop = 'P_' . $zz;
				if($p == 1){
					$pm['forPMCIP']['P_1'] = $projTot[0]['P1'];
				} else {
					$pm['forPMCIP']['P_'.$p] = $pm['forPMCIP'][$zzTop] + $projTot[0]['P'.$p];
				} // end if
			endfor;
		else:
			for($p=1;$p<13;$p++):
				$pm['forPMCIP']['P_'.$p] = 0;
			endfor;
		endif;

		$pm['forPMDEPR'] = array(
	    	'ASSET_ID' => $pid,
		    'Year_id' => (int) $CY,
		    'Ver_id' => 80000000,
		    'Unit_id' => $co_id,
		    'Line_id' => $this_asset[0]['DEPRECIATION_ACCOUNT_NUMBER'],
		    'Cust1_id' => 80,
		    'Cust2_id' => $pid,
		    'Corp_id' => $de_id
		);

		if((int)$DIP_switch == 1):
			for($p=1;$p<13;$p++):
				$pm['forPMDEPR']['P_'.$p] = (float) $arr['P'.$p] / ( (float) $this_asset[0]['USEFUL_LIFE'] * 12 );
			endfor;
		else:
			for($p=1;$p<13;$p++):
				$pm['forPMDEPR']['P_'.$p] = 0;
			endfor;
		endif;
	}// end if
	
	$doStat = $this->db->insert('sam_pm_out',$pm['forPMSTAT']);
	//return $this->db->last_query();
    $doCIP = $this->db->insert('sam_pm_out',$pm['forPMCIP']);
    //return $this->db->last_query();
    $doDEPR = $this->db->insert('sam_pm_out',$pm['forPMDEPR']);
    return $this->db->last_query();	
} // end update_sam_out function
/***************************************************/
/***************************************************/
public function insert_array($table,$array){
	$this->db->insert($table, $array);
	return $this->db->insert_id();
} // end insert_array function
/**************************************************/
public function status_set_atm_open($id){
	$updArray = array('atm_status' => '1');
    $this->db->where('id',$id)->update('budgets',$updArray);
} // end status_set_open function
/**************************************************/
public function status_set_sam_open($id){
	$updArray = array('sam_status' => '1');
    $this->db->where('id',$id)->update('budgets',$updArray);
} // end status_set_sam_open function
/**************************************************/
public function update_by_array($table,$where,$array){
	$this->db->where($where)->update($table, $array);
	return $this->db->insert_id();
} // end update_by_array function
/**************************************************/
public function retSQL($sql){
	$q = $this->db->query($sql);
	return $q->result_array();
} // end xSQL function
/**************************************************/
/***************************************************/
/***************************************************/
} // end class
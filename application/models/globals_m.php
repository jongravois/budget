<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Globals_m extends MY_Model{

	protected $_table_name     = 'globals';
	protected $_primary_key    = 'id';
	protected $_primary_filter = 'intval';
	protected $_order_by       = 'item';
	protected $_rules          = array();
	protected $_timestamps     = FALSE;

function __construct(){
	parent::__construct();
} // end constructor
/***************************************************/
/***************************************************/
public function current_year(){
	$q = $this->db->select('value')->where('item','currentYear')->get('budget_year');
	return $q->row('value');
} // end current_year function
/**************************************************/
public function fetch_state_dd(){
	$q = $this->db->select('stateAbbr, stateName')->from('States')->order_by('stateName')->get();
     
    if($q->num_rows > 0){
	  	foreach($q->result() as $row){
	       $data[$row->stateAbbr] = $row->stateName;
	  	}//end foreach
     	return $data;
    }//endif
} // end fetch_state_dd function
/**************************************************/
public function getADDExpense(){
	$q = $this->db->select('value')->where('item','ADDInsurance')->get('globals');
	return $q->row('value');
} // end getADDExpense function
/**************************************************/
public function get_admin_401k(){
	$q = $this->db->select('value')->where('item','401K_Admin')->get('globals');
	return $q->row('value');
} // end get_admin_401k function
/**************************************************/
public function get_admin_adp(){
	$q = $this->db->select('value')->where('item','ADP')->get('globals');
	return $q->row('value');
} // end get_admin_adp function
/**************************************************/
public function get_annual_quarters($fs){
	switch( (int) $fs ){
		case 0:
		case 3:
		case 6:
		case 9:
			return array(3,6,9,12);
			break;
		case 1:
		case 4:
		case 7:
		case 10:
			return array(2,5,8,11);
			break;
		case 2:
		case 5:
		case 8:
		case 11:
			return array(1,4,7,10);
			break;
	} // end switch
} // end get_annual_quarters function
/**************************************************/
public function get_cm_bonus_qualifier(){
	$q = $this->db->select('value')->where('item','cmBonusPercent')->get('globals');
	return $q->row('value');
} // end getcmBonusQualifier function
/**************************************************/
public function get_department_name($id){
	$q = $this->db->select('Department')->where('deptCode',$id)->get('departments');
	return $q->row('Department');
} // end get_department_name function
/**************************************************/
public function getESPPAdmin(){
	$q = $this->db->select('value')->where('item','ESPPadmin')->get('globals');
	return $q->row('value');
} // end getESPPAdmin function
/**************************************************/
public function get_fica_max(){
	$q = $this->db->select('max')->where('item','FICA')->get('globals');
	return $q->row('max');
} // end get_fica_max function
/**************************************************/
public function get_fica_rate(){
	$q = $this->db->select('value')->where('item','FICA')->get('globals');
	return $q->row('value');
} // end get_fica_rate function
/**************************************************/
public function get_flex_spend(){
	$q = $this->db->select('value')->where('item','FSAfee')->get('globals');
	return $q->row('value');
} // end get_flex_spend function
/**************************************************/
public function get_fui_max(){
	$q = $this->db->select('max')->where('item','FUI')->get('globals');
	return $q->row('max');
} // end get_fuisui_max function
/**************************************************/
public function get_fui_rate(){
	$q = $this->db->select('value')->where('item','FUI')->get('globals');
	return $q->row('value');
} // end get_fuisui_rate function
/**************************************************/
public function get_gi_family(){
	$q = $this->db->select('value')->where('item','GIFamily')->get('globals');
	return $q->row('value');
} // end get_gi_family function
/**************************************************/
public function get_gi_single(){
	$q = $this->db->select('value')->where('item','GISingle')->get('globals');
	return $q->row('value');
} // end get_si_single function
/**************************************************/
public function get_hobo_qualifier(){
	$q = $this->db->select('value')->where('item','hoBonusQualifier')->get('globals');
	return $q->row('value');
} // end get_hobo_qualifier function
/**************************************************/
public function get_ins_default($type){
	$q = $this->db->select('value')->where('item','GI'.$type)->get('globals');
	return $q->row('value');
} // end get function
/**************************************************/
public function get_ltdi_max(){
	$q = $this->db->select('max')->where('item', 'LTDI')->get('globals');
    return $q->row('max');
} // end get_ltdi_max function
/**************************************************/
public function get_ltdi_rate(){
	$q = $this->db->select('value')->where('item', 'LTDI')->get('globals');
    return $q->row('value');
} // end get_ltdi_rate function
/**************************************************/
public function get_maxed_tax($sal,$max,$rate){
	// print_r($sal);die();
	$TAX = array(0,0,0,0,0,0,0,0,0,0,0,0,0);

    // Create a total variable and load in first month salary 
    $salTot = 0;

    for ($c=1; $c<13;$c++) {
      	if ( (float)$salTot + (float)$sal["P_".$c] < (float)$max ) {
	   		$TAX[$c] = (float)$sal["P_".$c] * (float)$rate;
	   		$salTot = $salTot + (float)$sal["P_".$c];
      	} else {
	   		$TAX[$c] = ((float)$max - (float)$salTot) * (float)$rate;
	   		break;
      	} // end if
    } // end for
	
     return $TAX;
} // end get_maxed_tax function
/**************************************************/
public function get_meal_price(){
	$q = $this->db->select('value')->where('item', 'mealValue')->get('globals');
    return $q->row('value');
} // end get_meal_price function
/**************************************************/
public function get_medicare_rate(){
	$q = $this->db->select('value')->where('item','Medicare')->get('globals');
	return $q->row('value');
} // end get_medicare_rate function
/**************************************************/
public function get_period_maxed_tax($sal,$max,$rate){
    // Create a total variable and load in first month salary 
     for ($c=1; $c<13;$c++) {
      	if ($sal["P_".$c] <= $max) {
	   		$TAX[$c] = $sal["P_".$c] * $rate;
      	} else {
	   		$TAX[$c] = $max * $rate;
      	} // end if
     } // end for
	
     return $TAX;
} // end get_period_maxed_tax function
/**************************************************/
public function get_sui_max($state){
	$q = $this->db->select('SUIbase')->where('state', $state)->get('sui');
	return $q->row('SUIbase');
} // end get_sui_max function
/**************************************************/
public function get_sui_rate($state){
	$q = $this->db->select('SUIrate')->where('state', $state)->get('sui');
	return $q->row('SUIrate');
} // end get_sui_rate function
/**************************************************/
public function get_stdi1_max(){
	$q = $this->db->select('max')->where('item', 'STDI1')->get('globals');
    return $q->row('max');
} // end get_stdi1_max function
/**************************************************/
public function get_stdi1_rate(){
	$q = $this->db->select('value')->where('item', 'STDI1')->get('globals');
    return $q->row('value');
} // end get_stdi1_rate function
/**************************************************/
public function get_stdi2_max(){
	$q = $this->db->select('max')->where('item', 'STDI2')->get('globals');
    return $q->row('max');
} // end get_stdi2_max function
/**************************************************/
public function get_stdi2_rate(){
	$q = $this->db->select('value')->where('item', 'STDI2')->get('globals');
    return $q->row('value');
} // end get_stdi2_rate function
/**************************************************/
public function get_stock_market_discount(){
	$q = $this->db->select('value')->where('item','ESPPdmp')->get('globals');
	return $q->row('value');
} // end get_stock_market_discount function
/**************************************************/
public function get_stock_market_price(){
	$q = $this->db->select('value')->where('item','ESPPdiscount')->get('globals');
	return $q->row('value');
} // end get_stock_market_price function
/**************************************************/
public function version_id(){
	$q = $this->db->select('value')->where('item','ver_id')->get('globals');
	return $q->row('value');
} // end version_id function
/**************************************************/
/***************************************************/
} // end class
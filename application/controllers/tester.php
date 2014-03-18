<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tester extends Frontend_Controller {

public function __construct() {
	parent::__construct();
	error_reporting(E_ALL); // for production
	parse_str($_SERVER['QUERY_STRING'], $_GET);
	$this->load->model('test_m');
} // end constructor
/***************************************************/
/***************************************************/
public function index() {
	$buddy = $this->budget_m->get_emp_bud_info(140);
	echo "<pre>"; print_r($buddy); echo "</pre>";
}
/***************************************************/
public function fizz(){
	$fica = $this->pam_m->compute_pm_fica('1158');

	echo "<pre>"; var_dump($fica); echo "</pre>";
} // end fizz function
/**************************************************/
public function jason(){
	$str = "BUDGET_ID=300000&DEPARTMENT_ID=41&title=4120&NAME=iu&FULL_PART=F®_TEMP=R&EMP_REPLACE=N&HIRE_DATE=01%2F01%2F2014&HAS_END_DATE=N&REHIRE_DATE=12%2F31%2F2014&EE_TYPE=S&ANNUAL_RATE=96418998&HOURLY_RATE=0&HAS_OVERTIME=N&stipend_P_1=0&stipend_P_2=0&stipend_P_3=0&stipend_P_4=0&stipend_P_5=0&stipend_P_6=0&stipend_P_7=0&stipend_P_8=0&stipend_P_9=0&stipend_P_10=0&stipend_P_11=0&stipend_P_12=0&caRad=N&HOURLY_RATE_CA=0&CA_HOURS_P_1=0&CA_HOURS_P_2=0&CA_HOURS_P_3=0&CA_HOURS_P_4=0&CA_HOURS_P_5=0&CA_HOURS_P_6=0&CA_HOURS_P_7=0&CA_HOURS_P_8=0&CA_HOURS_P_9=0&CA_HOURS_P_10=0&CA_HOURS_P_11=0&CA_HOURS_P_12=0&FTE_P_1=0&FTE_P_2=0&FTE_P_3=0&FTE_P_4=0&FTE_P_5=0&FTE_P_6=0&FTE_P_7=0&FTE_P_8=0&FTE_P_9=0&FTE_P_10=0&FTE_P_11=0&FTE_P_12=0&OVR_P_1=0&OVR_P_2=0&OVR_P_3=0&OVR_P_4=0&OVR_P_5=0&OVR_P_6=0&OVR_P_7=0&OVR_P_8=0&OVR_P_9=0&OVR_P_10=0&OVR_P_11=0&OVR_P_12=0&IS_DINING_EMP=N&IS_MEAL_ELIGIBLE=N&DH_P_1=0&DH_P_2=0&DH_P_3=0&DH_P_4=0&DH_P_5=0&DH_P_6=0&DH_P_7=0&DH_P_8=0&DH_P_9=0&DH_P_10=0&DH_P_11=0&DH_P_12=0&NOM_P_1=0&NOM_P_2=0&NOM_P_3=0&NOM_P_4=0&NOM_P_5=0&NOM_P_6=0&NOM_P_7=0&NOM_P_8=0&NOM_P_9=0&NOM_P_10=0&NOM_P_11=0&NOM_P_12=0&HOME_OFFICE_BONUS_PERCENTAGE=0&DEV_BONUS_P_1=0&DEV_BONUS_P_2=0&DEV_BONUS_P_3=0&DEV_BONUS_P_4=0&DEV_BONUS_P_5=0&DEV_BONUS_P_6=0&DEV_BONUS_P_7=0&DEV_BONUS_P_8=0&DEV_BONUS_P_9=0&DEV_BONUS_P_10=0&DEV_BONUS_P_11=0&DEV_BONUS_P_12=0&empState=TN&GRP_INS_TYPE=None&GRP_INS_MONTHLY_EXPENSE=0&PERCENTAGE_401K=0&FSA=N&ESPP=0&IS_ALLOCATED=N&ALLOC_TOTAL=100";

	$processed = explode('&',$str);

	foreach($processed as $process){
		list($cKey, $cVal) = explode('=',$process,2);
		$arr[stripslashes($cKey)] = stripslashes($cVal);
	} // end foreach

	echo "<pre>";print_r($arr);echo "</pre>";
} // end jason function
/**************************************************/
public function mailer(){
	$to = 'jgravois@edrtrust.com';
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From: PAM@edrtrust.com\r\nReply-To: PAM@edrtrust.com";
	$headers .= "\r\nCc:";
	$subject = 'The Payroll Portion has been opened!';
	$msg = "<html><head><meta charset='utf-8'><title>Budget Open</title></head><body><h3>The Payroll Portion of Demo Property's budget has been opened!</h3><p>All existing employees and their existing benefits have been provided by Human Resources and have been loaded into the budget.</p><p><strong>PLEASE NOTE:</strong> Existing part-time and hourly employees have been budgeted with NO hours and all bonus programs are also set to 0.</p><p>In order to access this new budget to make changes, please log into PM and access PAM from the left-hand navigation.</p></body></html>";
	@mail( $to, $subject, $msg, $headers);
} // end mailer function
/**************************************************/
public function dater(){
	$newTime = strtotime('2014-01-01');
	$arr[0] = date('Y-m-d', $newTime );
	
	for($t=1;$t<13;$t++){
		$newTime = strtotime('+1 month', $newTime);
		$arr[$t] = date('Y-m-d', $newTime);
	}

	print_r($arr);
} // end dater function
/**************************************************/
public function buddy(){
	//$id = '300000';
	$id = '349000';
	$this->load->model('hrfeed_m');
	
	$emps = $this->test_m->get_field_emps($id);

	if( count($emps) > 0){
		foreach($emps as $emp){
			$newbie = $this->budget_m->return_copied_budget($emp, $id); // INSERTS into BUDGET_FEED
			$budded = $this->budget_m->budget_field($newbie); // INSERTS IN PAM_PM_OUT
		} // end foreach
	} // end if

	// // Create Property Bonuses and Dining Bonus, if applicable
	//$propBonus = $this->budget_m->create_staffing_bonus($id);

	// // Create Turn Employees
	//$noTurn = $this->budget_m->create_turn_emp($id); 

	echo "<pre>";var_dump($budded); echo "</pre>";
} // end valid_periods function
/**************************************************/
public function emp(){
	$adden = $this->pam_m->ajax_salary_adjustment_table('1006');
	echo "<table>";
	echo $adden;
	echo "</table>";
} // end emp function
/**************************************************/
public function fuey(){
	$id = '1469';
	$pm = $this->pam_m->compute_pm_fuisui($id);

	echo "<pre>";var_dump($pm); echo "</pre>";
} // end fuey function
/**************************************************/
public function kitty(){
	$testee = $this->budget_m->create_turn_emp('300000');
	echo "<pre>"; print_r($testee); echo "</pre>";
} // end kitty function
/**************************************************/
public function sal(){
	$id = '1239';
	$pm = $this->pam_m->compute_pm_salary($id);

	echo "<pre>";var_dump($pm); echo "</pre>";
} // end sal function
/**************************************************/
public function salad(){
	$tArr = array(
		'EMP_ID' => 1203, //1158,
		'period' => 7,
		'kind' => 'Increase',
		'type' => 'Percent',
		'amount' => 10
	);
	$jwg = $this->test_m->ajax_adjust_salary($tArr);

	echo "<pre>";var_dump($jwg);echo "</pre>";
} // end salad function
/**************************************************/
public function salview(){
	$bud = $this->pam_m->get_complete_employee('1006');
	$this->load->view('pam/inc/edit_salary_info', array(
        'user' => $this->session->all_userdata(),
        'budget' => $bud
    ));
} // end salview function
/**************************************************/
public function summer(){
	$bud = $this->pam_m->get_complete_employee('1006');
	$this->load->view('pam/inc/edit_employee_summary', array(
        'user' => $this->session->all_userdata(),
        'budget' => $bud
    ));
} // end summer function
/**************************************************/
public function valerie(){
	$emp = $this->budget_m->get_emp_info('869');
	$validPeriods = $this->budget_m->determineValidPeriods( $emp );
	echo "<pre>";var_dump($validPeriods); echo "</pre>";
} // end valerie function
/**************************************************/
public function rosebud(){
	$id = '1006';
	$bud = $this->pam_m->get_complete_employee($id);
	echo "<pre>";var_dump($bud); echo "</pre>";
} // end rosebud function
/**************************************************/
public function samsum(){
	$co_id = 308;
	$jojo = $this->sam_m->get_aggregate_co_total($co_id,'IT');
	var_dump($jojo);
} // end samsum function
/**************************************************/
public function samsung(){
	$annual_amount = $this->sam_m->ajax_get_timeline_amount('300000', '04', '13');
	$mo_annual_amount = $this->sam_m->ajax_get_atm_total_by_asset('300000', '04', '13');
	//echo $this->db->last_query();
	echo('YEAR: ' . $annual_amount . ' || BY MONTH: ' . $mo_annual_amount . '<br><br><br>');
	if( !$annual_amount){ $annual_amount = 0; }
	if( (float)$annual_amount < (float)$mo_annual_amount ){ $annual_amount = $mo_annual_amount; }
	echo $annual_amount;
} // end samsung function
/**************************************************/
public function delhi($id){
	$this->budget_m->clear_out_department_budget($id);
	echo "Completed";
} // end delhi function
/**************************************************/
public function fix_kaye($id = null){
	if(!$id){ $id = '312000'; }
	$propBonus = $this->budget_m->create_staffing_bonus($id);
	$noTurn = $this->budget_m->create_turn_emp($id);
	$noTeam = $this->budget_m->create_streetteam_emp($id);
} // end fix_kaye function
/*-----------------------------------------------------*/
/***************************************************/
} // end class

/* End of file pam_user.php */
/* Location: ./application/controllers/pam_user.php */
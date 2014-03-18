<?php
class Finloc_m extends CI_Model {

function __construct() {
        parent::__construct();
} // end constructor
/*-----------------------------------------------------*/
/*-----------------------------------------------------*/
public function getPMStatus($yr, $co_id, $de_id = 0){
	$this->DB2 = $this->load->database('pmfinancials', true);
	//return array('yr'=>$yr, 'co_id'=>$co_id, 'de_id'=>$de_id);
	if($de_id != '00'):
		//department
		$sql = "SELECT CAST(DEC AS int) AS DEC FROM edrdb1.PMFINANCIALS.pmfinancials.FINLOC WHERE  YEAR_ID = {$yr} AND (CUST1_ID = {$de_id} or Unit_ID = {$de_id}) AND LINE_ID IN ( 80000184,80000183) AND VER_ID = 80000000";
	else :
		//property
		$sql = "SELECT CAST(DEC AS int) AS DEC FROM edrdb1.PMFINANCIALS.pmfinancials.FINLOC WHERE LINE_ID IN ( 80000184,80000183) AND CUST2_ID = 0 AND VER_ID = 80000000 AND YEAR_ID = {$yr} AND [UNIT_ID] = {$co_id} ORDER BY [UNIT_ID]";
	endif;

	$query = $this->DB2->query( $sql );
	return $query->row('DEC');
} // end getPamStatus function
/*-----------------------------------------------------*/
public function close_by_PM($id){
	$sql = "UPDATE budgets SET pam_status = 3, atm_status = 3, sam_status = 3 WHERE id = {$id}";
	$q = $this->db->query($sql);
	return $this->db->last_query();
} // end close_by_pm function
/*-----------------------------------------------------*/
public function verifyPM(){} // end verifyPM function
/*-----------------------------------------------------*/
/*-----------------------------------------------------*/
/*-----------------------------------------------------*/
} // end class


/* End of file Finloc_m.php */
/* Location: ./application/models/Finloc_m.php */
?>
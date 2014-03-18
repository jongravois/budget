<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

public $data = array();

function __construct(){
	parent::__construct();
	$this->data['errors'] = array();
	$this->data['ftp_host'] = config_item('ftp_host');

	/***** <DYNAMIC USER AGENT SNIFFER> *****/
    $this->load->library('user_agent');

	if ($this->agent->is_mobile('ipad')){
        $this->data['agent'] =  "tablet";
    } else if ($this->agent->is_mobile('iphone')){
        $this->data['agent'] =  "smartphone";
    } else if ($this->agent->is_mobile('ipod')){
        $this->data['agent'] =  "smartphone";
    } else if ($this->agent->is_mobile()){
        $this->data['agent'] =  "tablet";
    } else {
        $this->data['agent'] =  "desktop";
    } // end if
    /***** </DYNAMIC USER AGENT SNIFFER> *****/
} // end constructor
/***********************************************/
/***********************************************/
} // end class

/* End of file MY_Controller.php */
/* Location: ./application/controllers/MY_Controller.php */
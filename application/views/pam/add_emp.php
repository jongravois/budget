<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>P.A.M. -- Add Employee</title>

  <script src="<?= base_url('assets/js/jquery-1.9.0.min.js'); ?>" type="text/javascript"></script>
  <script src="<?= base_url('assets/js/bootstrap.js'); ?>" type="text/javascript"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js" type="text/javascript"></script>

	<link href="<?= base_url('assets/css/bootstrap.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/bootstrap-responsive.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/font-awesome.css'); ?>" rel="stylesheet">
  <link href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet">
	<link href="<?= base_url('assets/css/site.css'); ?>" rel="stylesheet">

  <style>
    label{padding:4px 0;font-weight:bold;font-size:14px;color:#1b6633;}
    .push-right{ padding: 10px 0 10px 50px; }
  </style>
</head>

<body>
  <?php
    //print_r($budget);print_r($fiscal);
  ?>
  <div class="container" style="margin-top:10px;border-top:5px solid #1b6633;">
    <h3 align="center" style="margin-bottom:0;">ADD EMPLOYEE</h3>
    <div class="span12">
      <br><br>
      <div class="row">
        <!--/*~~~~~~~~~~~ BEGIN ADD EMPLOYEE FORM ~~~~~~~~~~~~~*/-->
        <?php // OPEN FORM TAG
          $formAttr = array('name' => 'addform', 'id' => 'addform');
          $hidden = array('BUDGET_ID' => $budget->id);
          echo form_open('pam_budget/add_emp_handler',$formAttr, $hidden);
        ?>
        <!--/*~~~~~~~~~~~ EMPLOYEE INFORMATION ~~~~~~~~~~~~~*/-->
        <div id="employee_information">
          <table class="table-striped" style="width:90%;margin:0 auto;">
            <tr>
              <td style="width:25%; text-align:left;"><label>COMPANY:</label></td>
              <td style="width:75%; text-align:left;">
                <span id='summaryEmp' class='summery'><?= substr($budget->id,0,3) . ' -- ' . $budget->name; ?></span>
              </td>
            </tr>
            <tr>
              <td><label>DEPARTMENT:</label></td>
              <td>
                <?php
                  if((int)$budget->id == 349000){
                    $depDD = array('0' => 'Please Select ...', '13'=>'13 -- Dining', '41' => '41 -- General Administrative', '52' => '52 -- Maintenance and Repairs');
                  } else {
                    $depDD = $this->budget_m->get_department_dd($budget->companyTypeID);
                  } // end if
                ?>
                <?= form_dropdown('DEPARTMENT_ID', $depDD, '', 'id="depDD" class="span4"' ); ?>
              </td>
            </tr>
            <tr>
              <td><label>JOB TITLE:</label></td>
              <td><div id="ajaxDD">Select a department first.</div></td>
            </tr>
            <tr>
              <td><label for="NAME">POSITION NAME:</label></td>
              <td>
                <input class="input-xxlarge" type="text" id="NAME" name="NAME" placeholder="Position Name">
              </td>
            </tr>
            <tr>
              <td><label>EMPLOYMENT STATUS:</label></td>
              <td>
                <label class="radio inline">
                  <input type="radio" name="FULL_PART" value="F" checked /> Full-Time
                </label>
                <label class="radio inline">
                  <input type="radio" name="FULL_PART" value="P" /> Part-Time
                </label>
                <!--<label class="radio inline">
                  <input type="radio" name="FULL_PART" value="B" /> Part-Time with Benefits
                </label>-->
              </td>
            </tr>
            <tr>
              <td><label>EMPLOYMENT TYPE:</label></td>
              <td>
                <label class="radio inline">
                  <input type="radio" name="REG_TEMP" value="R" checked /> Regular
                </label>
                <label class="radio inline">
                  <input type="radio" name="REG_TEMP" value="T" /> Temporary
                </label>
              </td>
            </tr>
            <tr>
              <td colspan="2" class="push-right">
                <label class="radio inline">Is this a new position in your budget?</label>
                <label class="radio inline">
                  <input type="radio" name="EMP_REPLACE" value="Y" /> Yes
                </label>
                <label class="radio inline">
                  <input type="radio" name="EMP_REPLACE" value="N" checked /> No
                </label>
              </td>
            </tr>
            <tr>
              <td><label>HIRE DATE:</label></td>
              <td>
                <?php // HIRE DATE INPUT
                  $curr_year = $this->globals_m->current_year();
                  $firstDay = (string) '20'.$curr_year.$fiscal[0]['fiscal_day_one'];
                  $HIRE_DATE = date('m/d/Y', strtotime($firstDay));
                ?>
                <div class="input-append">
                  <input id="hireDate" name="HIRE_DATE" size="16" type="text" value="<?= $HIRE_DATE; ?>">
                  <span class="add-on"><i class="icon-th"></i></span>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2" class="push-right">
                <label class="radio inline">Will this employee have an End Date within this budget?</label>
                <label class="radio inline">
                  <input type="radio" name="HAS_END_DATE" class="HSD" value="Y" /> Yes
                </label>
                <label class="radio inline">
                  <input type="radio" name="HAS_END_DATE" class="HSD" value="N" checked="checked" /> No
                </label>
              </td>
            </tr>
            <tr id="endDateRow" style="display:none">
              <td><label>END DATE:</label></td>
              <td>
                <?php // END DATE INPUT
                  $end_year = ( (int)$budget->fiscalStart==0 ? $curr_year : (int)$curr_year+1 );
                  $lastDay = (string) '20'.$end_year.$fiscal[0]['fiscal_day_last'];
                  $REHIRE_DATE = date('m/d/Y', strtotime($lastDay));
                ?>
                <div class="input-append date" id="dp2" data-date="<?= $REHIRE_DATE; ?>" data-date-format="mm-dd-yyyy">
                  <input id="rehireDate" name="REHIRE_DATE" class="datepicker" size="16" type="text" value="<?= $REHIRE_DATE; ?>">
                  <span class="add-on"><i class="icon-th"></i></span>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <div class="form-actions">
                  <button type="button" class="btn btn-large btnCancel">Cancel</button>
                  <button type="button" data-location="employee_information" class="btn btnNext btn-large btn-edr">Next</button>
                  <img class="wait-gif" src="<?= base_url('/assets/images/spin_light_lg.gif'); ?>" class="waiting" style="display:none;" />
                </div>
              </td>
            </tr>
          </table>
        </div> <!-- END employee_information DIV -->
        <!--/*~~~~~~~~~~~ SALARY INFORMATION ~~~~~~~~~~~~~~~*/-->
        <div id="salary_information" style="display:none;">
          <table class="table-striped" style="width:90%;margin:0 auto;">
            <tr>
              <td colspan="2" style="text-align:center;">
                NAME: <label class="em-name" style="display:inline;"></label> ( <label class="em-job" style="display:inline;"></label> )<br>
                <label>SALARY INFORMATION</label>
              </td>
            </tr>
            <tr id="caInfo" style="display:none;">
              <td colspan="2" style="text-align:center; padding:0 20%;">
                <span style="font:bold 11px verdana; color:#DC241F;">
                  Community/Resident Assistants and Senior Community/Resident Assistants must be entered as monthly employees. Use "Additional Hours" to designate workload, if desired.
                </span>
              </td>
            </tr>
              <tr>
              <td style="width:35%;"><label>SALARY TYPE:</label></td>
              <td style="width:65%;">
               <?php
                    $EE_TYPE = array('0' => 'Select...','S' => 'Salary','H' => 'Hourly', 'M' => 'Monthly');
                    $js_eeType = 'id = "EE_TYPE"';
                    echo form_dropdown('EE_TYPE',$EE_TYPE,'Select...',$js_eeType);
               ?>
              </td>
            </tr>
            <tr id="ANNUAL_BASE" style="display:none;">
              <td><label>ANNUAL BASE SALARY:</label></td>
              <td>
                <div class="input-prepend input-append">
                  <span class="add-on">$</span>
                  <?php
                    $ANNUAL_RATE = array(
                      'id' => 'ANNUAL_RATE',
                      'name' => 'ANNUAL_RATE',
                      'value' => 0
                    );
                    echo form_input($ANNUAL_RATE);
                   ?>
                   <span class="add-on" style="color:#C83F39;"><b>PER YEAR</b></span>
                 </div>
                </td>
           </tr>
           <tr class="HOURLY_BASE" style="display:none;">
              <td><label>HOURLY RATE:</label></td>
              <td>
                <div class="input-prepend input-append">
                  <span class="add-on">$</span>
                  <?php
                    $HOURLY_RATE = array(
                      'id' => 'HOURLY_RATE',
                      'name' => 'HOURLY_RATE',
                      'value' => 0
                    );
                    echo form_input($HOURLY_RATE);
                   ?>
                   <span class="add-on" style="color:#C83F39;"><b>PER HOUR</b></span>
                 </div>
                </td>
            </tr>
            <tr class="HOURLY_BASE" style="display:none;">
              <td colspan="2" class="push-right">
                <label class="radio inline">Will this employee have overtime hours?</label>
                <label class="radio inline">
                  <input type="radio" name="HAS_OVERTIME" class="HOT" value="Y" /> Yes
                </label>
                <label class="radio inline">
                  <input type="radio" name="HAS_OVERTIME" class="HOT" value="N" checked="checked" /> No
                </label>
              </td>
            </tr>
            <tr class="MONTHLY_RATE" style="display:none;">
              <td colspan="2" style="text-align:center;">
                <span style="font:bold 11px verdana; color:#DC241F; width:80%;">
                  Indicate which months this employee will receive the stipend by entering the stipend amount into the proper container.
                </span>
              </td>
            </tr>
            <tr class="MONTHLY_RATE" style="display:none;">
              <td colspan="2">
                <table class="table table-bordered" style="width:90%;margin:0 auto;">
                    <tr style="background-color:#1b6633;color:#FFFFFF;">
                      <td style="background-color: #1b6633;">EZ Entry</td>
                      <td colspan="5" style="background-color: #1b6633; color:#FFFFFF;">
                        <div class="input-prepend" style="display:inline;">
                          <span class="add-on" style="color:#000;">$</span>
                          <input type="text" class="input-small ezEntry" data-type="PSA" value="0" />
                        </div>
                        &nbsp;
                        <img src="<?= base_url('assets/images/ez-button.png'); ?>" style="height:30px;width:30px"; class="btnEZ" data-type="PSA" />
                      </td>
                    </tr>
                    <tr>
                      <?php for($c=1;$c<7;$c++): ?>
                        <td>
                          <label><?= $fiscal[0]['P_'.$c]; ?></label>
                          <div class="input-prepend">
                            <span class="add-on">$</span>
                            <input class="span1 aPSA" type="text" id="stipend_P_<?= $c; ?>" name="stipend_P_<?= $c; ?>" value="0" />
                          </div>
                        </td>
                      <?php endfor; ?>
                    </tr>
                    <tr>
                      <?php for($c=7;$c<13;$c++): ?>
                        <td>
                          <label><?= $fiscal[0]['P_'.$c]; ?></label>
                          <div class="input-prepend">
                            <span class="add-on">$</span>
                            <input class="span1 aPSA" type="text" id="stipend_P_<?= $c; ?>" name="stipend_P_<?= $c; ?>" value="0" />
                          </div>
                        </td>
                      <?php endfor; ?>
                    </tr>
                  </table>
              </td>
            </tr>
            <tr class="MONTHLY_RATE" style="display:none;">
              <td colspan="2" class="push-right">
                <label class="radio inline">Will this employee be working additional monthly hours?</label>
                <label class="radio inline">
                  <input type="radio" name="caRad" class="CAR" value="Y" /> Yes
                </label>
                <label class="radio inline">
                  <input type="radio" name="caRad" class="CAR" value="N" checked="checked" /> No
                </label>
              </td>
            </tr>
            <tr class="validPeriodsAndStipends" style="display:none;">
              <td><label>HOURLY RATE FOR ADDITIONAL HOURS:</label></td>
              <td>
                <div class="input-prepend">
                  <span class="add-on">$</span>
                  <?php
                    $HOURLY_RATE_CA = array(
                         'id' => 'HOURLY_RATE_CA',
                         'name' => 'HOURLY_RATE_CA',
                         'class' => 'HOURLY_RATE_CA',
                         'value' => 0
                    );
                    echo form_input($HOURLY_RATE_CA);
                  ?>
                </div>
              </td>
            </tr>
            <tr class="validPeriodsAndStipends" style="display:none;">
              <td colspan="2" style="text-align:center;">
                <span style="font:bold 11px verdana; color:#DC241F; width:80%;">
                  Enter additional hours you expect this employee to work beyond housing and stipends per month. [ MAX ALLOWED: 174 (Full Time) ]
                </span>
              </td>
            </tr>
            <tr class="validPeriodsAndStipends" style="background-color: #1b6633; color:#FFFFFF;display:none;">
                    <td>EZ Entry</td>
                    <td>
                      <input type="text" class="input-medium ezEntry" data-type="CAH" value="0" />
                      &nbsp;
                      <img src="<?= base_url('assets/images/ez-button.png'); ?>" style="height:30px;width="30px; class="btnEZ" data-type="CAH" />
                    </td>
                  </tr>
            <tr class="validPeriodsAndStipends" style="display:none;">
              <td colspan="2">
                <table class="table table-bordered" style="width:40%;margin:0 auto;">
                  <tr>
                    <?php for($vp=1;$vp<7;$vp++): ?>
                      <td>
                        <?= $fiscal[0]['P_'.$vp]; ?>
                        <input class="input-small aCAH" type="text" id="CA_HOURS_P_<?= $vp; ?>" name="CA_HOURS_P_<?= $vp; ?>" value="0">
                      </td>
                    <?php endfor; ?>
                  </tr>
                  <tr>
                    <?php for($vp=7;$vp<13;$vp++): ?>
                      <td>
                        <?= $fiscal[0]['P_'.$vp]; ?>
                        <input class="input-small aCAH" type="text" id="CA_HOURS_P_<?= $vp; ?>" name="CA_HOURS_P_<?= $vp; ?>" value="0">
                      </td>
                    <?php endfor; ?>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <div class="form-actions">
                  <button type="button" data-location="salary_information" class="btn btnBack btn-large btn-inverse">Back</button>
                  <button type="button" class="btn btn-large btnCancel">Cancel</button>
                  <button type="button" data-location="salary_information" class="btn btnNext btn-large btn-edr">Next</button>
                  <img class="wait-gif" src="<?= base_url('/assets/images/spin_light_lg.gif'); ?>" class="waiting" style="display:none;" />
                </div>
              </td>
            </tr>
          </table>
        </div> <!-- END salary_information DIV -->
        <!--/*~~~~~~~~~~~ WORK HOURS INFORMATION ~~~~~~~~~~~*/-->
        <div id="work_hours_information" style="display:none;">
          <table class="table-striped" style="width:90%;margin:0 auto;">
            <tr>
              <td colspan="2" style="text-align:center;">
                NAME: <label class="em-name" style="display:inline;"></label> ( <label class="em-job" style="display:inline;"></label> )<br>
                <label>EMPLOYEE HOURS</label>
              </td>
            </tr>
            <tr>
              <td style="50%;">
                <table id="tblFTE" class="table table-striped" style="width:70%;margin:0 auto;display:none;">
                  <tr>
                    <td colspan="2"><b>FTE<br>( HOURS PER WEEK )</b><br><span style="font:bold 11px verdana; color:#DC241F; width:80%;">MAX ALLOWED: 40</span></td>
                  </tr>
                  <tr style="background-color: #1b6633; color:#FFFFFF;">
                    <td>EZ Entry</td>
                    <td>
                      <input type="text" class="input-small ezEntry" data-type="FTE" value="0" />
                      &nbsp;
                      <img src="<?= base_url('assets/images/ez-button.png'); ?>" style="height:30px;width="30px; class="btnEZ" data-type="FTE" />
                    </td>
                  </tr>
                  <?php for($c=1;$c<13;$c++): ?>
                    <tr>
                      <td style="50%;">
                        <?= $fiscal[0]['P_'.$c]; ?>
                      </td>
                      <td style="50%;">
                        <input class="input-medium aFTE" type="text" id="FTE_P_<?= $c; ?>" name="FTE_P_<?= $c; ?>" value="0">
                      </td>
                    </tr>
                  <?php endfor; ?>
                </table>
              </td>
              <td style="50%;">
                <table id="tblOVR" class="table table-striped" style="width:70%;margin:0 auto;display:none;">
                  <tr>
                    <td colspan="2"><b>OVERTIME<br>( HOURS PER MONTH )</b></td>
                  </tr>
                  <tr style="background-color: #1b6633; color:#FFFFFF;">
                    <td>EZ Entry</td>
                    <td>
                      <input type="text" class="input-medium ezEntry" data-type="OVR" value="0" />
                      &nbsp;
                      <img src="<?= base_url('assets/images/ez-button.png'); ?>" style="height:30px;width="30px; class="btnEZ" data-type="OVR" />
                    </td>
                  </tr>
                  <?php for($c=1;$c<13;$c++): ?>
                    <tr>
                      <td style="50%;">
                        <?= $fiscal[0]['P_'.$c]; ?>
                      </td>
                      <td style="50%;">
                        <input class="input-medium aOVR" type="text" id="OVR_P_<?= $c; ?>" name="OVR_P_<?= $c; ?>" value="0">
                      </td>
                    </tr>
                  <?php endfor; ?>
                </table>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <div class="form-actions">
                  <button type="button" data-location="work_hours_information" class="btn btnBack btn-large btn-inverse">Back</button>
                  <button type="button" class="btn btn-large btnCancel">Cancel</button>
                  <button type="button" data-location="work_hours_information" class="btn btnNext btn-large btn-edr">Next</button>
                  <img class="wait-gif" src="<?= base_url('/assets/images/spin_light_lg.gif'); ?>" class="waiting" style="display:none;" />
                </div>
              </td>
            </tr>
          </table>
        </div> <!-- END work_hours_information DIV -->
        <!--/*~~~~~~~~~~~ DINING INFORMATION ~~~~~~~~~~~~~~~*/-->
        <div id="dining_information" style="display:none;">
          <table class="table-striped" style="width:90%;margin:0 auto;">
            <tr>
              <td colspan="2" style="text-align:center;">
                NAME: <label class="em-name" style="display:inline;"></label> ( <label class="em-job" style="display:inline;"></label> )<br>
                <label>DINING</label>
              </td>
            </tr>
            <tr>
              <td align="center">
                <label>DINING EMPLOYEE</label>
                <?php
                  $selDining = "id='IS_DINING_EMP' class='span1'";
                  $choices = array('N' => 'No', 'Y' => 'Yes');
                  echo form_dropdown('IS_DINING_EMP',$choices,'N',$selDining);
                ?>
              </td>
              <td align="center">
                <label>MEAL ELIGIBLE</label>
                <?php
                  $selMealE = "id='IS_MEAL_ELIGIBLE' class='span1'";
                  $choices = array('N' => 'No', 'Y' => 'Yes');
                  echo form_dropdown('IS_MEAL_ELIGIBLE',$choices,'N',$selMealE);
                ?>
              </td>
            </tr>
            <tr>
              <td style="50%;">
                <table id="tblDHM" class="table table-striped" style="width:70%;margin:0 auto;display:none;">
                  <tr>
                    <td colspan="2"><b>DINING HOURS / MONTH</b><br><span style="font:bold 11px verdana; color:#DC241F; width:80%;">MAX ALLOWED: 174 (Full Time)</span></td>
                  </tr>
                  <tr style="background-color: #1b6633; color:#FFFFFF;">
                    <td>EZ Entry</td>
                    <td>
                      <input type="text" class="input-small ezEntry" data-type="DHA" value="0" />
                      &nbsp;
                      <img src="<?= base_url('assets/images/ez-button.png'); ?>" style="height:30px;width="30px; class="btnEZ" data-type="DHA" />
                    </td>
                  </tr>
                  <?php for($c=1;$c<13;$c++): ?>
                    <tr>
                      <td style="50%;">
                        <?= $fiscal[0]['P_'.$c]; ?>
                      </td>
                      <td style="50%;">
                        <input class="input-medium aDHA" type="text" id="DH_P_<?= $c; ?>" name="DH_P_<?= $c; ?>" value="0">
                      </td>
                    </tr>
                  <?php endfor; ?>
                </table>
              </td>
              <td style="50%;">
                <table id="tblNOM" class="table table-striped" style="width:70%;margin:0 auto;display:none;">
                  <tr>
                    <td colspan="2"><b>NUMBER OF MEALS / MONTH</b></td>
                  </tr>
                  <tr style="background-color: #1b6633; color:#FFFFFF;">
                    <td>EZ Entry</td>
                    <td>
                      <input type="text" class="input-small ezEntry" data-type="EMA" value="0" />
                      &nbsp;
                      <img src="<?= base_url('assets/images/ez-button.png'); ?>" style="height:30px;width="30px; class="btnEZ" data-type="EMA" />
                    </td>
                  </tr>
                  <?php for($c=1;$c<13;$c++): ?>
                    <tr>
                      <td style="50%;">
                        <?= $fiscal[0]['P_'.$c]; ?>
                      </td>
                      <td style="50%;">
                        <input class="input-medium aEMA" type="text" id="NOM_P_<?= $c; ?>" name="NOM_P_<?= $c; ?>" value="0">
                      </td>
                    </tr>
                  <?php endfor; ?>
                </table>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <div class="form-actions">
                  <button type="button" data-location="dining_information" class="btn btnBack btn-large btn-inverse">Back</button>
                  <button type="button" class="btn btn-large btnCancel">Cancel</button>
                  <button type="button" data-location="dining_information" class="btn btnNext btn-large btn-edr">Next</button>
                  <img class="wait-gif" src="<?= base_url('/assets/images/spin_light_lg.gif'); ?>" class="waiting" style="display:none;" />
                </div>
              </td>
            </tr>
          </table>
        </div> <!-- END dining_information DIV -->
        <!--/*~~~~~~~~~~~ BONUS INFORMATION ~~~~~~~~~~~~~~~*/-->
        <div id="bonus_information" style="display:none;">
          <table class="table-striped" style="width:90%;margin:0 auto;">
            <tr id="HOBO">
              <td><label>CORPORATE BONUS PERCENTAGE:</label></td>
              <td>
                <div class="input-append">
                  <?php
                    $HOME_OFFICE_BONUS_PERCENTAGE = array(
                         'id' => 'HOME_OFFICE_BONUS_PERCENTAGE',
                         'name' => 'HOME_OFFICE_BONUS_PERCENTAGE',
                         'class' => 'HOME_OFFICE_BONUS_PERCENTAGE',
                         'value' => 0
                    );
                    echo form_input($HOME_OFFICE_BONUS_PERCENTAGE);
                  ?>
                  <span class="add-on">%</span>
                </div>
              </td>
            </tr>
            <tr id="development_bonus">
              <td colspan="2">
                <label>DEVELOPMENT BONUS</label>
                <table class="table table-bordered" style="width:60%;margin:0 auto;">
                  <tr style="background-color: #1b6633 !important; color:#FFFFFF;">
                    <td style="background-color: #1b6633;">EZ Entry</td>
                    <td style="background-color: #1b6633;">
                      <input type="text" class="input-medium ezEntry" data-type="DVB" value="0" />
                      &nbsp;
                      <img src="<?= base_url('assets/images/ez-button.png'); ?>" style="height:30px;width="30px; class="btnEZ" data-type="DVB" />
                    </td>
                  </tr>
                  <?php for($b=1;$b<13;$b++): ?>
                    <tr>
                      <td style="width:50%;"><?= $fiscal[0]['P_'.$b]; ?></td>
                      <td style="width:50%;">
                        <input class="input-medium aDVB" type="text" name="DEV_BONUS_P_<?= $b; ?>" value="0">
                      </td>
                    </tr>
                  <?php endfor; ?>
                </table>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <div class="form-actions">
                  <button type="button" data-location="bonus_information" class="btn btnBack btn-large btn-inverse">Back</button>
                  <button type="button" class="btn btn-large btnCancel">Cancel</button>
                  <button type="button" data-location="bonus_information" class="btn btnNext btn-large btn-edr">Next</button>
                  <img class="wait-gif" src="<?= base_url('/assets/images/spin_light_lg.gif'); ?>" class="waiting" style="display:none;" />
                </div>
              </td>
            </tr>
          </table> 
        </div> <!-- END bonus_information DIV -->
        <!--/*~~~~~~~~~~~ BENEFITS INFORMATION ~~~~~~~~~~~~~*/-->
        <div id="benefits_information" style="display:none;">
          <table class="table-striped" style="width:90%;margin:0 auto;">
            <tr>
              <td colspan="2" style="text-align:center;">
                NAME: <label class="em-name" style="display:inline;"></label> ( <label class="em-job" style="display:inline;"></label> )<br>
                <label>BENEFITS</label>
              </td>
            </tr>
            <tr>
              <td style="50%;"><label>EMPLOYMENT STATE:</label></td>
              <td style="50%;">
                <?php
                  $selState = "id='empState'";
                  $states = $this->globals_m->fetch_state_dd();
                  echo form_dropdown('empState',$states,$budget->emp_state,$selState);
                ?>
              </td>
            </tr>
            <tr>
              <td style="50%;"><label>GROUP INSURANCE:</label></td>
              <td style="50%;">
                <?php
                  $selIns = "id='group_ins'";
                  $choices = array('None' => 'None', 'Single' => 'Single', 'Family' => 'Family');
                  echo form_dropdown('GRP_INS_TYPE',$choices,'None',$selIns);
                ?>
                <input type="hidden" id="GRP_INS_MONTHLY_EXPENSE" name="GRP_INS_MONTHLY_EXPENSE" value="0" />
              </td>
            </tr>
            <tr>
              <td style="50%;"><label>401K EMPLOYEE MATCH:</label></td>
              <td style="50%;">
                <?php
                  $selMatch401 = "id='empMatch401'";
                  $choices = array('0' => '0%', '1' => '1%', '2' => '2%', '3' => '3% or More');
                  echo form_dropdown('PERCENTAGE_401K',$choices,'0',$selMatch401);
                ?>
              </td>
            </tr>
            <tr>
              <td style="50%;"><label>FLEX SPEND PARTICIPATION:</label></td>
              <td style="50%;">
                <?php
                  $selFsa = "id='ben_fsa'";
                  $choices = array('N' => 'Not Participating', 'Y' => 'Participating');
                  echo form_dropdown('FSA',$choices,'None',$selFsa);
                ?>
              </td>
            </tr>
            <tr>
              <td style="50%;"><label>EMPLOYEE STOCK PURCHASE PROGRAM:<br>( Limit: Up to 15% )</label></td>
              <td style="50%;">
                <div class="input-append">
                  <?php
                    $ESPP = array(
                      'id' => 'ESPP',
                      'name' => 'ESPP',
                      'value' => 0,
                      'class' => 'input-small'
                    );
                    echo form_input($ESPP);
                   ?>
                   <span class="add-on">%</span>
                 </div>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <div class="form-actions">
                  <button type="button" data-location="benefits_information" class="btn btnBack btn-large btn-inverse">Back</button>
                  <button type="button" class="btn btn-large btnCancel">Cancel</button>
                  <button type="button" data-location="benefits_information" class="btn btnNext btn-large btn-edr">Next</button>
                  <img class="wait-gif" src="<?= base_url('/assets/images/spin_light_lg.gif'); ?>" class="waiting" style="display:none;" />
                </div>
              </td>
            </tr>
          </table>
        </div> <!-- END benefits_information DIV -->
        <!--/*~~~~~~~~~~~ ALLOCATION INFORMATION ~~~~~~~~~~~*/-->
        <div id="allocation_information" style="display:none;">
          <table class="table-striped" style="width:90%;margin:0 auto;">
            <tr>
              <td colspan="2" style="text-align:center;">
                NAME: <label class="em-name" style="display:inline;"></label> ( <label class="em-job" style="display:inline;"></label> )<br>
                <label>ALLOCATION</label>
              </td>
            </tr>
            <tr>
              <td colspan="2" class="push-right">
                <label class="radio inline">Is this employee allocated to multiple companies or departments?</label>
                <label class="radio inline">
                  <input type="radio" name="IS_ALLOCATED" class="EIA" value="Y" /> Yes
                </label>
                <label class="radio inline">
                  <input type="radio" name="IS_ALLOCATED" class="EIA" value="N" checked="checked" /> No
                </label>
              </td>
            </tr>
            <tr id="allocation_row" style="display:none;">
              <td colspan="2" class="push-right">
                <label class="radio inline">What percentage of this employee should be designated for this budget?</label>
                <div class="input-append" style="display:inline;">
                  <?php
                    $ALLOC_TOTAL = array(
                      'id' => 'ALLOC_TOTAL',
                      'name' => 'ALLOC_TOTAL',
                      'class' => 'input-small',
                      'value' => 100
                    );
                    echo form_input($ALLOC_TOTAL);
                   ?>
                   <span class="add-on">%</span>
                 </div>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <div class="form-actions">
                  <button type="button" data-location="allocation_information" class="btn btnBack btn-large btn-inverse">Back</button>
                  <button type="button" class="btn btn-large btnCancel">Cancel</button>
                  <button type="button" data-location="allocation_information" class="btn btnNext btn-large btn-edr">Next</button>
                  <img class="wait-gif" src="<?= base_url('/assets/images/spin_light_lg.gif'); ?>" class="waiting" style="display:none;" />
                </div>
              </td>
            </tr>
          </table>
        </div> <!-- END allocation_information DIV -->
        <!--/*~~~~~~~~~~~ SUBMIT SUMMARY ~~~~~~~~~~~~~~~~~~~*/-->
        <div id="submit_summary" style="display:none;">
          <table class="table-striped" style="width:90%;margin:0 auto;">
            <tr>
              <td colspan="2" style="text-align:center;">
                <label>SUBMISSION SUMMARY</label>
              </td>
            </tr>
            <tr>
              <td style="width:35%; text-align:left;">COMPANY:</td>
              <td style="width:65%; text-align:left;">
                <span id='summaryEmp_Company' class='summery'>
                  <?= substr($budget->id,0,3) . ' -- ' . $budget->name; ?>
                </span>
              </td>
            </tr>
            <tr>
              <td>DEPARTMENT:</td>
              <td>
                <span id='summaryEmp_Department' class='summery'></span>
              </td>
            </tr>
            <tr>
              <td>JOB TITLE:</td>
              <td>
                <span id='summaryEmp_JobTitle' class='summery'></span>
              </td>
            </tr>
            <tr>
              <td>EMPLOYEE:</td>
              <td>
                <span id='summaryEmp_Employee' class='summery'></span>
              </td>
            </tr>
            <tr>
              <td>BUDGET START DATE:</td>
              <td>
                <span id='summaryEmp_StartDate' class='summery'></span>
              </td>
            </tr>
            <tr>
              <td>BUDGET END DATE:</td>
              <td>
                <span id='summaryEmp_EndDate' class='summery'></span>
              </td>
            </tr>
            <tr>
              <td>ANNUAL SALARY:</td>
              <td>
                <span id='summaryEmp_Annual' class='summery'></span>
              </td>
            </tr>
            <tr>
              <td>HOURLY RATE:</td>
              <td>
                <span id='summaryEmp_Hourly' class='summery'></span>
              </td>
            </tr>
            <tr>
              <td>CORPORATE OFFICE BONUS:</td>
              <td>
                <span id='summaryEmp_COB' class='summery'></span>
              </td>
            </tr>
            <tr>
              <td>GROUP INSURANCE PLAN / EXPENSE:</td>
              <td>
                <span id='summaryEmp_GroupInsurance' class='summery'></span>
              </td>
            </tr>
            <tr>
              <td>401K EMPLOYER MATCH:</td>
              <td>
                <span id='summaryEmp_Employer_Match_401K' class='summery'></span>
              </td>
            </tr>
            <tr>
              <td>FLEX SPEND ACCOUNT:</td>
              <td>
                <span id='summaryEmp_FSA' class='summery'></span>
              </td>
            </tr>
            <tr>
              <td>EMPLOYEE STOCK PURCHASE PLAN:</td>
              <td>
                <span id='summaryEmp_Employer_ESPP' class='summery'></span>
              </td>
            </tr>
            <tr>
              <td>COMPANY ALLOCATION:</td>
              <td>
                <span id='summaryEmp_Allocation' class='summery'></span>
              </td>
            </tr>
          </table>
          <br>
          <table width='100%' id='summaryAddPeriodTotals' class="table table-striped table-bordered">
            <tr>
              <th style="width:18%;">&nbsp;</th>
              <?php for($f=1;$f<13;$f++): ?>
                <th style="text-align:center;">
                  <?= $fiscal[0]['P_'.$f.'_a']; ?>
                </th>
              <?php endfor; ?>
              <th>Total</th>
            </tr>
            <tr>
              <td>FTE</td>
              <?php for($f=1;$f<13;$f++): ?>
                <td style="text-align:center;">
                  <span id="sFTE_P_<?= $f; ?>"></span>
                </td>
              <?php endfor; ?>
              <td style="text-align:center;">-</td>
            </tr>
            <tr>
              <td>OVERTIME</td>
              <?php for($f=1;$f<13;$f++): ?>
                <td style="text-align:center;">
                  <span id="sOVR_P_<?= $f; ?>"></span>
                </td>
              <?php endfor; ?>
              <td style="text-align:center;">
                <span id="tot_sOVR"></span>
              </td>
            </tr>
            <tr>
              <td>CA PLUS HOURS</td>
              <?php for($f=1;$f<13;$f++): ?>
                <td style="text-align:center;">
                  <span id="sCAH_P_<?= $f; ?>"></span>
                </td>
              <?php endfor; ?>
                <td style="text-align:center;">
                  <span id="tot_sCAH"></span>
                </td>
            </tr>
            <tr>
              <td>DINING HOURS</td>
              <?php for($f=1;$f<13;$f++): ?>
                <td style="text-align:center;">
                  <span id="sDHA_P_<?= $f; ?>"></span>
                </td>
              <?php endfor; ?>
              <td style="text-align:center;">
                <span id="tot_sDHA"></span>
              </td>
            </tr>
            <tr>
              <td>ELIGIBLE MEALS</td>
              <?php for($f=1;$f<13;$f++): ?>
                <td style="text-align:center;">
                  <span id="sEMA_P_<?= $f; ?>"></span>
                </td>
              <?php endfor; ?>
              <td style="text-align:center;">
                <span id="tot_sEMA"></span>
              </td>
            </tr>
            <?php if((int)$budget->companyTypeID == 2): ?>
              <tr>
                <td>DEVELOPMENT BONUS</td>
                <?php for($f=1;$f<13;$f++): ?>
                  <td style="text-align:center;">
                    <span id="sDVB_P_<?= $f; ?>"></span>
                  </td>
                <?php endfor; ?>
                <td style="text-align:center;">
                  <span id="tot_sDVB"></span>
                </td>
              </tr>
            <?php endif; ?>
            <tr>
              <td>MONTHLY STIPEND</td>
              <?php for($f=1;$f<13;$f++): ?>
                  <td style="text-align:center;">
                    <span id="sVSM_P_<?= $f; ?>"></span>
                  </td>
                <?php endfor; ?>
                <td style="text-align:center;">-</td>
              </tr>
            <tr>
              <td colspan="14">
                <div class="form-actions">
                  <button type="button" data-location="submit_summary" class="btn btnBack btn-large btn-inverse">Back</button>
                  <button type="button" class="btn btn-large btnCancel">Cancel</button>
                  <button type="submit" data-location="submit_summary" class="btn btnSubmit btn-large btn-edr">Submit</button>
                  <img class="wait-gif" src="<?= base_url('/assets/images/spin_light_lg.gif'); ?>" class="waiting" style="display:none;" />
                </div>
              </td>
            </tr>
          </table>
        </div> <!-- END submit_summary DIV -->
        <?= form_close(); ?>
      </div> <!-- end .row -->
    </div> <!-- end .span12 -->
  </div> <!-- END . container -->

<script type="text/javascript">
  $(function() {
    var JOB_TITLE;
    var NAME;
    var hireDateDefault = "<?= $HIRE_DATE; ?>";
    var rehireDateDefault = "<?= $REHIRE_DATE; ?>";
    var company_type = "<?= $budget->companyTypeID; ?>";
    var can_allocate = "<?= $budget->CAN_ALLOCATE; ?>";

    if( company_type != 2 || company_type != '2'){ $('#development_bonus').hide(); }

    //Datepickers
    $('#hireDate').datepicker({ 
      minDate: new Date(hireDateDefault), 
      maxDate: new Date(rehireDateDefault)
    });
    $('#rehireDate').datepicker({ 
      minDate: new Date(hireDateDefault), 
      maxDate: new Date(rehireDateDefault)
    });
    /*====================================*/
    $(document).on('blur', '#ESPP', function(e){
      var valew = $(this).val();
      if( valew > 15){
        $(this).val(15);
      } // end if
    });

    $(document).on('click', '.btnNext', function(e){
      $('.wait-gif').show();
      JOB_TITLE = $('#title option:selected').text();
      $('.em-job').text(JOB_TITLE);
      NAME = $('#NAME').val();
      $('.em-name').text(NAME);
      
      var location = $(this).data('location');
      switch(location){
        case 'employee_information':
          // VALIDATE
          if( $('#depDD').val() == 0){ 
            alert('Department Required'); 
            $('.wait-gif').hide(); 
            return false; 
          } // end if
          if( $('#title').val() == ''){ 
            alert('Job Required'); 
            $('.wait-gif').hide(); 
            return false; 
          } // end if
          if( $('#NAME').val() == ''){ 
            alert('Name Required'); 
            $('.wait-gif').hide(); 
            return false;
          } // end if

          // MOVE
          $('#employee_information').fadeOut( function(){
            $('.wait-gif').hide();
            $('#salary_information').fadeIn();
          });
          break;
        case 'salary_information':
          // VALIDATE
          if( $('#EE_TYPE').val() == 0){ 
            alert('Employment Type Required'); 
            $('.wait-gif').hide(); 
            return false; 
          } // end if

          //MOVE
          if( $('input[name=HAS_OVERTIME]:checked').val() == 'Y' ){
            $('#salary_information').fadeOut( function(){
              $('.wait-gif').hide();
              if($('#EE_TYPE').val() != 'H'){
                $('#tblFTE').hide();
              } // end if
              $('#work_hours_information').fadeIn();
            });
          } else if( (company_type == 4 || company_type == 6) && $('#depDD').val() == '13' ){
            $('#salary_information').fadeOut( function(){
              $('.wait-gif').hide();
              $('#dining_information').fadeIn();
            });
          } else if( $('#EE_TYPE').val() == 'H' || $('input[name=HAS_OVERTIME]:checked').val() == 'Y' ){
            $('#salary_information').fadeOut( function(){
              $('.wait-gif').hide();
              $('#work_hours_information').fadeIn();
            });
          } else if( company_type == 1 || company_type == 2 ){
            $('#salary_information').fadeOut( function(){
              $('.wait-gif').hide();
              $('#bonus_information').fadeIn();
            });
          } else {
            $('#salary_information').fadeOut( function(){
              $('.wait-gif').hide();
              $('#benefits_information').fadeIn();
            });
          } // end if
          break;
        case 'work_hours_information':
          if( company_type == 4 || company_type == 6 ){
            $('#work_hours_information').fadeOut( function(){
              $('.wait-gif').hide();
              $('#dining_information').fadeIn();
            });
          } else if( company_type == 1 || company_type == 2 ){
            $('#work_hours_information').fadeOut( function(){
              $('.wait-gif').hide();
              $('#bonus_information').fadeIn();
            });
          } else {
            $('#work_hours_information').fadeOut( function(){
              $('.wait-gif').hide();
              $('#benefits_information').fadeIn();
            });
          } // end if
          break;
        case 'dining_information':
          // VALIDATE

          // MOVE
          $('#dining_information').fadeOut( function(){
            $('.wait-gif').hide();
            $('#benefits_information').fadeIn();
          });
          break;
        case 'bonus_information':
          // VALIDATE

          // MOVE
          $('#bonus_information').fadeOut( function(){
            $('.wait-gif').hide();
            $('#benefits_information').fadeIn();
          });
          break;
        case 'benefits_information':
          // VALIDATE

          // MOVE
          if( can_allocate == "1" ){
            $('#benefits_information').fadeOut( function(){
              $('.wait-gif').hide();
              $('#allocation_information').fadeIn();
            });
          } else {
            $('#benefits_information').fadeOut( function(){
              $('.wait-gif').hide();
              get_summary_report();
              $('#submit_summary').fadeIn();
            });
          } // end if
          break;
        case 'allocation_information':
          $('#allocation_information').fadeOut( function(){
              $('.wait-gif').hide();
              get_summary_report();
              $('#submit_summary').fadeIn();
          });
          break;
      } // end switch
    });
    /*====================================*/
    $(document).on('click', '.btnBack', function(e){
      $('.wait-gif').show();
      JOB_TITLE = $('#title option:selected').text();
      $('.em-job').val(JOB_TITLE);
      NAME = $('#NAME').val();
      $('.em-name').val(NAME);
      
      var location = $(this).data('location');
      switch(location){
        case 'salary_information':
          $('#salary_information').fadeOut( function(){
            $('.wait-gif').hide();
            $('#employee_information').fadeIn();
          });
          break;
        case 'work_hours_information':
          $('#work_hours_information').fadeOut( function(){
            $('.wait-gif').hide();
            $('#salary_information').fadeIn();
          });
          break;
        case 'dining_information':
          if( $('#EE_TYPE').val() == 'H' || $('input[name=HAS_OVERTIME]:checked').val() == 'Y' ){
            $('#dining_information').fadeOut( function(){
              $('.wait-gif').hide();
              $('#work_hours_information').fadeIn();
            });
          } else if( company_type == 4 || company_type == 6 ){
            $('#dining_information').fadeOut( function(){
              $('.wait-gif').hide();
              $('#salary_information').fadeIn();
            });
          } // end if
          break;
        case 'bonus_information':
          if( $('#EE_TYPE').val() == 'H' || $('input[name=HAS_OVERTIME]:checked').val() == 'Y' ){
            $('#bonus_information').fadeOut( function(){
              $('.wait-gif').hide();
              $('#work_hours_information').fadeIn();
            });
          } else {
            $('#bonus_information').fadeOut( function(){
              $('.wait-gif').hide();
              $('#salary_information').fadeIn();
            });
          } // end if
          break;
        case 'benefits_information':
          if( company_type == 1 || company_type == 2 ){
            $('#benefits_information').fadeOut( function(){
              $('.wait-gif').hide();
              $('#bonus_information').fadeIn();
            });
          } else if( company_type == 4 || company_type == 6 ){
            $('#benefits_information').fadeOut( function(){
              $('.wait-gif').hide();
              $('#dining_information').fadeIn();
            });
          } else if( $('#EE_TYPE').val() == 'H' || $('input[name=HAS_OVERTIME]:checked').val() == 'Y' ){
            $('#benefits_information').fadeOut( function(){
              $('.wait-gif').hide();
              $('#work_hours_information').fadeIn();
            });
          } else {
            $('#benefits_information').fadeOut( function(){
              $('.wait-gif').hide();
              $('#salary_information').fadeIn();
            });
          } // end if
          break;
        case 'allocation_information':
          $('#allocation_information').fadeOut( function(){
              $('.wait-gif').hide();
              $('#benefits_information').fadeIn();
            });
          break;
        case 'submit_summary':
          if( can_allocate == "1" ){
            $('#submit_summary').fadeOut( function(){
              $('.wait-gif').hide();
              $('#allocation_information').fadeIn();
            });
          } else {
            $('#submit_summary').fadeOut( function(){
              $('.wait-gif').hide();
              $('#benefits_information').fadeIn();
            });
          } // end if
          break;
      } // end switch
    });
    /*====================================*/
    $(document).on('click', '.btnCancel', function(e){
      var answer = confirm('You have entered new data that has not yet been saved or submitted to the server. If you click "Continue" below, this data will be lost. Click "Cancel" to stay on the current page.');
      if (answer) {
        window.location = "<?= site_url('pam_budget/budget/'.$budget->id); ?>";  
      } // end if
      return false;
    });
    /*====================================*/
    $(document).on('focus', '.ezEntry', function(e){
      $(this).select();
    });
    /*====================================*/
    $(document).on('blur', '.ezEntry', function(e){
      var tipe = $(this).data('type');
      var vale = $(this).val();

      switch(tipe){
        case 'FTE':
          if( vale > 40){ vale = 40; }
          $('.aFTE').each(function( index ){
            $(this).val(vale);
          });
          break;
        case 'OVR':
          $('.aOVR').each(function( index ){
            $(this).val(vale);
          });
          break;
        case 'DVB':
          $('.aDVB').each(function( index ){
            $(this).val(vale);
          });
          break;
        case 'DHA':
          if( vale > 174){ vale = 174; }
          $('.aDHA').each(function( index ){
            $(this).val(vale);
          });
          break;
        case 'EMA':
          $('.aEMA').each(function( index ){
            $(this).val(vale);
          });
          break;
        case 'PSA':
          $('.aPSA').each(function( index ){
            $(this).val(vale);
          });
          break;
        case 'CAH':
          $('.aCAH').each(function( index ){
            $(this).val(vale);
          });
          break;
      } // end switch
    });
    /*====================================*/
    $(document).on('change', '#depDD', function(e){
      var val = $(this).val();
      if( val == '55'){
        alert('Turn Employees are budgeted en masse. Please click the button "Edit Turn Employees" to continue.');
        var link = "<?= site_url('pam_budget/budget/'.$budget->id); ?>";
        window.location = link;
      } else {
        $.ajax({
          url: "<?= site_url('pam_budget/ajax_get_jobs_by_DeptDD'); ?>",
          type: 'POST',
          data: { dept: val },
          success: function(msg){
              $('#ajaxDD').html(msg);
          } // end success
        }); // end ajax
      } // end if
    });
    /*====================================*/
    $(document).on('change', '#group_ins', function(e){
      var insType = $(this).val();

      $.ajax({
        url:  "<?= site_url('pam_budget/ajax_get_insurance'); ?>",
        type: "POST",
        data: { type: insType },
        success: function(msg){
          $('#GRP_INS_MONTHLY_EXPENSE').val(msg);
        } // end success
      });
    });
    /*====================================*/
    $(document).on('change', '#title', function(e){
      var JOB_ID = $(this).val();
      JOB_TITLE = $('#title option:selected').text();
      
      if( JOB_ID == "4298" ){
        alert('Staffing and Dining Bonus is budgeted in a unique manner. Please click the button "Edit Dining Bonuses to continue.');
        var link = "<?= site_url('pam_budget/budget/'.$budget->id); ?>";
        window.location = link;
      } // end if
      if( JOB_ID == "4229" ){
        alert('Staffing Bonus is budgeted in a unique manner. Please click the button "Edit Property Bonuses to continue.');
        var link = "<?= site_url('pam_budget/budget/'.$budget->id); ?>";
        window.location = link;
      } // end if
      if( JOB_ID == '4132' || JOB_ID == '4133' ){ 
        $('#caInfo').show(); 
        $('input[name="FULL_PART"]:eq(1)').attr('checked', 'checked');
        $('#EE_TYPE').val('M').prop("disabled", true);
        eetype_config();
      } //end if
    });
    /*====================================*/
    $(document).on('click', '.HSD', function(e){
      var hse = $('input[name="HAS_END_DATE"]:checked').val();
      if( hse == "Y"){
        $('#endDateRow').fadeIn('slow');
      } // end if
      if( hse == "N"){
        $('#endDateRow').fadeOut('slow');
      } // end if
    });
    /*====================================*/
    $(document).on('change', '#EE_TYPE', function(e){
      var vale = $('#EE_TYPE').val();
      eetype_config();
    });
    /*====================================*/ 
    $(document).on('click', '.CAR', function(e){
      var hot = $('input[name="caRad"]:checked').val();
      if( hot == "Y"){
        $('.validPeriodsAndStipends').fadeIn('slow');
      } // end if
      if( hot == "N"){
        $('.validPeriodsAndStipends').fadeOut('slow');
      } // end if
    });
    /*====================================*/
    $(document).on('blur', '.aCAH', function(e){
      var valew = $(this).val();
      if( parseFloat(valew) > 174 ){
        alert('Maximum allowed value is 174.');
        $(this).val('174');
        return false;
      } // end if
    });
    /*====================================*/
    $(document).on('blur', '.aFTE', function(e){
      var valew = $(this).val();
      if( parseFloat(valew) > 40 ){
        alert('Maximum allowed value is 40.');
        $(this).val('40');
        return false;
      } // end if
    });
    /*====================================*/
    $(document).on('blur', '.aDHA', function(e){
      var valew = $(this).val();
      if( parseFloat(valew) > 174 ){
        alert('Maximum allowed value is 174.');
        $(this).val('174');
        return false;
      } // end if
    });
    /*====================================*/
    $(document).on('click', '.HOT', function(e){
      var hot = $('input[name="HAS_OVERTIME"]:checked').val();
      if( hot == "Y"){
        $('#tblOVR').show();
      } // end if
      if( hot == "N"){
        $('#tblOVR').hide();
      } // end if
    });
    /*====================================*/
    $(document).on('click', '.EIA', function(e){
      var eia = $('input[name="IS_ALLOCATED"]:checked').val();
      if( eia == "Y"){
        $('#allocation_row').fadeIn('slow');
      } // end if
      if( eia == "N"){
        $('#allocation_row').fadeOut('slow');
      } // end if
    });
    /*====================================*/
      $(document).on('change', '#IS_DINING_EMP', function(e){
        var ide = $('#IS_DINING_EMP option:selected').val();
        if( ide == "Y"){
          $('#tblDHM').fadeIn('slow');
        } // end if
        if( ide == "N"){
          $('#tblDHM').fadeOut('slow');
        } // end if
      });
    /*====================================*/
      $(document).on('click', '#IS_MEAL_ELIGIBLE', function(e){
        var nomy = $('#IS_MEAL_ELIGIBLE option:selected').val();
        if( nomy == "Y"){
          $('#tblNOM').fadeIn('slow');
        } // end if
        if( nomy == "N"){
          $('#tblNOM').fadeOut('slow');
        } // end if
      });
    /*====================================*/
  }); // end document ready function
  /*====================================*/
  function eetype_config(){
    var vale = $('#EE_TYPE').val();
      switch(vale){
        case 'S':
          $('#ANNUAL_BASE').show();
          $('.HOURLY_BASE').hide();
          $('.MONTHLY_RATE').hide();
          $('.validPeriodsAndStipends').hide();
          $('#tblFTE').hide();
          break;
        case 'M':
          $('#ANNUAL_BASE').hide();
          $('.HOURLY_BASE').hide();
          $('.MONTHLY_RATE').show();
          var hot = $('input[name="caRad"]:checked').val();
          if( hot == "Y"){
            $('.validPeriodsAndStipends').show();
          } // end if
          if( hot == "N"){
            $('.validPeriodsAndStipends').hide();
          } // end if
          $('#tblFTE').hide();
          break;
        case 'H':
          $('#ANNUAL_BASE').hide();
          $('.HOURLY_BASE').show();
          $('.MONTHLY_RATE').hide();
          $('.validPeriodsAndStipends').hide();
          $('#tblFTE').show();
          break;
        default:
          $('#ANNUAL_BASE').hide();
          $('.HOURLY_BASE').hide();
          $('.MONTHLY_RATE').hide();
          $('.validPeriodsAndStipends').hide();
          $('#tblFTE').hide();
          break;
      } // end switch
  } // end function
  /*====================================*/
  function get_summary_report(){
    $('#summaryEmp_Department').empty().html( $('#depDD option:selected').text() );
    $('#summaryEmp_JobTitle').empty().html( $('#title option:selected').text() );
    $('#summaryEmp_Employee').empty().html( $('#NAME').val() );
    $('#summaryEmp_StartDate').empty().html( $('#hireDate').val() );
    $('#summaryEmp_EndDate').empty().html( $('#rehireDate').val() );
    
    if( $('#EE_TYPE option:selected').val() == 'S'){
      var annie = $('#ANNUAL_RATE').val();
      $('#summaryEmp_Annual').empty().html( '$' + (parseFloat(annie)).toFixed(2) );
      $('#summaryEmp_Hourly').empty().html( '$' + (parseFloat(annie)/2080).toFixed(2) );
    } else if( $('#EE_TYPE option:selected').val() == 'H' ){
      var owly = $('#HOURLY_RATE').val();
      $('#summaryEmp_Annual').empty().html( '$' + (parseFloat(owly) * 2080).toFixed(2) );
      $('#summaryEmp_Hourly').empty().html( '$' + (parseFloat(owly)).toFixed(2) );
    } else{
      $('#summaryEmp_Annual').empty().html( '0.00' );
      $('#summaryEmp_Hourly').empty().html( '0.00' );
    }//end if
    
    $('#summaryEmp_COB').empty().html( $('#HOME_OFFICE_BONUS_PERCENTAGE').val()+'%');
    $('#summaryEmp_GroupInsurance').empty().html( $('#group_ins option:selected').text() + ' / $'+ $('#GRP_INS_MONTHLY_EXPENSE').val() );
    $('#summaryEmp_Employer_ESPP').empty().html( $('#ESPP').val()+'%');
    $('#summaryEmp_FSA').empty().html( $('#ben_fsa option:selected').text() );
    $('#summaryEmp_Employer_Match_401K').empty().html( $('#empMatch401 option:selected').text() );
    $('#summaryEmp_Allocation').empty().html( $('#ALLOC_TOTAL').val()+'%');

    for(f=1;f<13;f++){
      if( $('#EE_TYPE option:selected').val() == 'S' ){
        $('#sFTE_P_'+f).empty().html( '40' );
      } else {
        $('#sFTE_P_'+f).empty().html( $('#FTE_P_'+f).val() );
      } // end if 
    } // end if

    var totOVR = 0;
    for(f=1;f<13;f++){ 
      totOVR += parseFloat($('#OVR_P_'+f).val());
      $('#sOVR_P_'+f).empty().html( $('#OVR_P_'+f).val() ); 
    } // end if
    $('#tot_sOVR').empty().html( totOVR );

    var totCAH = 0;
    for(f=1;f<13;f++){ 
      totCAH += parseFloat($('#CA_HOURS_P'+f).val());
      $('#sCAH_P_'+f).empty().html( $('#CA_HOURS_P_'+f).val() ); 
    } // end if
    $('#tot_sCAH').empty().html( totCAH );

    var totDHA = 0;
    for(f=1;f<13;f++){ 
      totDHA += parseFloat($('#DH_P_'+f).val());
      $('#sDHA_P_'+f).empty().html( $('#DH_P_'+f).val() ); 
    } // end if
    $('#tot_sDHA').empty().html( totDHA );

    var totEMA = 0;
    for(f=1;f<13;f++){ 
      totEMA += parseFloat($('#NOM_P_'+f).val());
      $('#sEMA_P_'+f).empty().html( $('#NOM_P_'+f).val() ); 
    } // end if
    $('#tot_sEMA').empty().html( totEMA );

    for(f=1;f<13;f++){ 
      $('#sVSM_P_'+f).empty().html( $('#stipend_P_'+f).val() ); 
    } // end if
  } // end function
</script>
</body>
</html>
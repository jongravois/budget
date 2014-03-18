<?php
  if( (int)$budget['budget']['pam_status'] > 1 || $user['accessLevel'] == 'analyst'):
    $dissed = 'disabled="disabled"';
  else:
    $dissed = '';
  endif;
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>P.A.M. -- Edit Employee</title>

  <script src="<?= base_url('assets/js/jquery-1.9.0.min.js'); ?>" type="text/javascript"></script>
  <script src="<?= base_url('assets/js/bootstrap.js'); ?>" type="text/javascript"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js" type="text/javascript"></script>

  <link href="<?= base_url('assets/css/bootstrap.css'); ?>" rel="stylesheet">
  <link href="<?= base_url('assets/css/bootstrap-responsive.css'); ?>" rel="stylesheet">
  <!--<link href="<?= base_url('assets/css/font-awesome.css'); ?>" rel="stylesheet">-->
  <link href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet">
  <link href="<?= base_url('assets/css/site.css'); ?>" rel="stylesheet">

  <style>
    .benTotal{font-weight:bold;}
  </style>
</head>

<body>
  <?php
    $fiscal = $this->fiscal_m->get_fiscal_info($budget['budget']['fiscalStart']);
    $curr_year = $this->globals_m->current_year();
    //print_r($budget);
  ?>
  <div class="container" style="margin-top:10px;border-top:5px solid #1b6633;">
    <h3 align="center" style="margin-bottom:0;">EMPLOYEE EDIT</h3>
    <h4 align="center"><?= $budget['budget']['name']; ?></h4>
    <h5 align="center"><?= $budget['feed']['NAME']; ?>&nbsp;( <?= $budget['feed']['JOB_ID'] . ' -- ' . $budget['feed']['jobTitle']; ?> )</h5>
    <div class="span12">
      <div class="row">
        <div class="span3">
          <p style="text-align:center;font-style:italic;font-weight:bold;font-size:11px;">
            <?= "Welcome, ".$user['login_user']; ?>
          </p>
    <!--/*~~~~~~~~~~~~~ BEGIN LEFT NAV ~~~~~~~~~~~~~~~*/-->
          <ul id="edit-sidenav" class="nav nav-tabs nav-stacked edit-sidenav" style="margin-top:-12px;">
            <li><a id="btn_employee_information" class="btn btn-large btn-block btnNav">
              Employee Information
            </a></li>
            <li><a id="btn_salary_information" class="btn btn-large btn-block btnNav">
              Salary Information
            </a></li>
            <li><a id="btn_work_hours_information" class="btn btn-large btn-block btnNav">
                Work Hours Information
              </a></li>
            <li><a id="btn_dining_information" class="btn btn-large btn-block btnNav">
                Dining Information
              </a></li>
            <li><a id="btn_benefits_information" class="btn btn-large btn-block btnNav">
              Benefits Information
            </a></li>
            <li><a id="btn_bonus_information" class="btn btn-large btn-block btnNav">
                Bonus Information
              </a></li>
            <li><a id="btn_allocation_information" class="btn btn-large btn-block btnNav">
                Allocation Information
              </a></li>
            <li><a id="btn_editSummary" class="btn btn-large btn-block btnNav">
              Employee Summary
            </a></li>
            <?php if( (int)$budget['budget']['pam_status'] < 2): ?>
              <?php if( $user['accessLevel'] != 'analyst'): ?>
                <li>&nbsp;</li>
                <li><a id="submitToPM" class="btn btn-large btn-block btn-edr">
                  SAVE ALL CHANGES
                </a></li>
              <?php endif; ?>
            <?php endif; ?>
            <?php if( $user['accessLevel'] == 'analyst'): ?>
              <li>&nbsp;</li>
                <li>
                  <a id="btnCloseView" class="btn btn-block btn-danger" href="#">
                    CLOSE VIEW
                  </a>
                </li>
            <?php else: ?>
              <?php if( (int)$budget['budget']['pam_status'] < 2): ?>
                <li>&nbsp;</li>
                  <li>
                    <a id="btnCancelEdit" class="btn btn-block btn-danger" href="#">
                      CANCEL EDIT
                    </a>
                  </li>
              <?php else: ?>
                <li>&nbsp;</li>
                <li>
                  <a id="btnCloseView" class="btn btn-block btn-danger" href="#">
                    CLOSE VIEW
                  </a>
                </li>
              <?php endif; ?>
            <?php endif; ?>
        </ul>
    <!--/*~~~~~~~~~~~~~ END LEFT NAV ~~~~~~~~~~~~~~~*/-->
        </div>
        <div class="span9">
          <?php //print_r($budget);  //style="display:none;" ?>
    <!--/*~~~~~~~~~~~ BEGIN EDIT EMPLOYEE FORM ~~~~~~~~~~~~~*/-->
          <?= form_open('pam_budget/edit_emp_handler', array('id' => 'frmEditEmp')); ?>
          <?= form_hidden('BUDGET_ID',$budget['budget']['id']); ?>
          <?= form_hidden('EMP_ID', $budget['feed']['EMP_ID']); ?>
          <?= form_hidden('JOB_ID', $budget['feed']['JOB_ID']); ?>
          <input type="hidden" id="refreshed" name="refreshed" value="N" />
    <!--/*~~~~~~~~~~~~~ EMPLOYEE SUMMARY ~~~~~~~~~~~~~~~*/-->
            <div id="editSummary">
              <?php if( (int)$budget['budget']['pam_status'] < 2 && $user['accessLevel'] != 'analyst'): ?>
                <p>
                  <a id="btnRefresh" class="btn btn-small btn-inverse">
                    <i class="icon-white icon-repeat"></i> REFRESH
                  </a>
                </p>
              <?php endif; ?>
              <?php $this->load->view('pam/inc/edit_employee_summary', array('data'=>$budget)); ?>
            </div> <!-- END editSummary -->
    <!--/*~~~~~~~~~~~~~ EMPLOYEE INFORMATION ~~~~~~~~~~~~~~~*/-->
            <div id="employee_information" style="display:none;">
              <h3 style="text-align:center;background-color:#1b6633;color:#FFFFFF;">EMPLOYEE INFORMATION</h3>
              <hr>
              <table class="table-striped" style="width:90%;margin:0 auto;">
                <tr>
                  <td style="width:35%;"><label>Company:</label></td>
                  <td style="width:65%;"><label><?= $budget['budget']['name']; ?></label></td>
                </tr>
                <tr>
                  <td><label>Department:</label></td>
                  <td><label><?= $budget['feed']['Department']; ?></label></td>
                </tr>
                <tr>
                  <td><label>Job Title:</label></td>
                  <td><label><?= $budget['feed']['JOB_ID'] . ' -- ' . $budget['feed']['jobTitle']; ?></label></td>
                </tr>
                <tr>
                  <td><label for="NAME">Last Name, First Name:</label></td>
                  <td><input <?= $dissed; ?> type="text" class="NAME"  id="NAME" name="NAME" value="<?= $budget['feed']['NAME']; ?>" /></td>
                </tr>
                <tr>
                  <td><label>Employment Status</td>
                  <td>
                    <?php if( (int)$budget['budget']['pam_status'] > 1 || $user['accessLevel'] == 'analyst'): ?>
                      <?php
                        switch($budget['feed']['FULL_PART']){
                          case 'F':
                            echo "<label>Full-Time</label>";
                            break;
                          case 'P':
                            echo "<label>Part-Time</label>";
                            break;
                          case 'B':
                            echo "<label>Part-Time with Benefits</label>";
                            break;
                        } // end switch
                      ?>
                    <?php else: ?>
                      <?php 
                        switch( $budget['feed']['FULL_PART'] ){
                          case "F":
                            $fStatus = "checked";
                            $pStatus = "";
                            $bStatus = "";
                            break;
                          case "P":
                            $fStatus = "";
                            $pStatus = "checked";
                            $bStatus = "";
                            break;
                          case "B":
                            $fStatus = "d";
                            $pStatus = "";
                            $bStatus = "checked";
                            break;
                        } // end switch 
                      ?>
                      <label class="radio inline">
                        <input type="radio" name="FULL_PART" value="F" <?= $fStatus; ?> /> Full-Time
                      </label>
                      <label class="radio inline">
                        <input type="radio" name="FULL_PART" value="P" <?= $pStatus; ?> /> Part-Time
                      </label>
                      <!--<label class="radio inline">
                        <input type="radio" name="FULL_PART" value="B" <?= $bStatus; ?> /> Part-Time with Benefits
                      </label>-->
                    <?php endif; ?>
                  </td>
                </tr>
                <tr>
                  <td><label for="START_DATE">Budget Start Date:</label></td>
                  <td>
                    <div class="input-append date" id="dp3" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                      <?php
                        $START_DATE = $budget['feed']['START_DATE'];
                        $js_startDate = $dissed . ' class="datepicker" id="START_DATE"';
                        echo form_input('START_DATE',$START_DATE,$js_startDate);
                      ?>
                      <span class="add-on"><i class="icon-calendar"></i></span>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><label>Original Hire Date:</label></td>
                  <td><label><?= $budget['feed']['HIRE_DATE']; ?></label></td>
                </tr>
                <?php if( (int)$budget['budget']['pam_status'] < 2 && $user['accessLevel'] != 'analyst'): ?>
                  <tr>
                    <td><label>Will this employee have an End Date?</label></td>
                    <td>
                      <?php 
                        if( $budget['feed']['HAS_END_DATE'] == "Y" ){
                          $yEndDate = "checked";
                          $nEndDate = "";
                        } else {
                          $yEndDate = "";
                          $nEndDate = "checked";
                        } // end if 
                      ?>
                      <label class="radio inline">
                        <input type="radio" name="radRehireDate" <?= $yEndDate; ?> value="Y" onclick="showRehireDate();" /> Yes
                      </label>
                      <label class="radio inline">
                        <input type="radio" name="radRehireDate" <?= $nEndDate; ?> value="N" onclick="showRehireDate();" /> No
                      </label>
                    </td>
                  </tr>
                <?php endif; ?>
                <tr id="endDateRow" class="well">
                  <td style="text-align:right;">End Date:</td>
                  <td>
                    <div id="opt_EndDate" class="input-append date" id="dp4" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                      <?php
                        $REHIRE_DATE = $budget['feed']['REHIRE_DATE'];
                        $js_endDate = $dissed . ' class="datepicker" id="REHIRE_DATE"';
                        echo form_input('REHIRE_DATE',$REHIRE_DATE,$js_endDate);
                      ?>
                      <span class="add-on"><i class="icon-calendar"></i></span>
                    </div>
                  </td>
                </tr>
                <?php if( (int)$budget['budget']['pam_status'] < 2 &&  $user['accessLevel'] != 'analyst'): ?>
                  <tr><td colspan="2"><br>&nbsp;<br></td></tr>
                  <tr><td colspan="2">
                    <span style="font:bold 11px verdana; color:#DC241F; width:80%;">
                      NOTE: If you need to budget overtime hours or meals for this employee, you must answer yes to the applicable question below. To budget overtime hours, select the <u>Work Hours Information</u> panel located in the menu to the left. To budget meals, select the <u>Dining Information</u> panel located in the menu to the left. If these choices are not currently visible, they will only appear in the menu to the left once you answer YES to each question below.
                    </span>
                  </td></tr>
                  <tr><td colspan="2"><br>&nbsp;<br></td></tr>
                  <?php
                     if( $budget['feed']['HAS_OVERTIME'] == 'Y' ){
                        $yOvertime = "checked";
                        $nOvertime = "";
                      } else {
                        $yOvertime = "";
                        $nOvertime = "checked";
                      } // end if

                      if( $budget['feed']['IS_MEAL_ELIGIBLE'] == "Y" ){
                        $yMeals = "checked";
                        $nMeals = "";
                      } else {
                        $yMeals = "";
                        $nMeals = "checked";
                      } // end if
                  ?>
                  <tr>
                    <td><label>Is this employee eligible for overtime?</label></td>
                    <td>
                      <label class="radio inline">
                        <input type="radio" name="hasOvertime" class="hasOvertime" <?= $yOvertime; ?> value="Y"> Yes
                      </label>
                      <label class="radio inline">
                        <input type="radio" name="hasOvertime" class="hasOvertime" <?= $nOvertime; ?> value="N"> No
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td><label>Is this employee eligible for free meals?</label></td>
                    <td>
                      <label class="radio inline">
                        <input type="radio" name="isMealEligible" class="isMealEligible" <?= $yMeals; ?> value="Y"> Yes
                      </label>
                      <label class="radio inline">
                        <input type="radio" name="isMealEligible" class="isMealEligible" <?= $nMeals; ?> value="N"> No
                      </label>
                    </td>
                  </tr>
                <?php endif; ?>
              </table>
            </div> <!-- END employee_information -->
    <!--/*~~~~~~~~~~~~~ SALARY INFORMATION ~~~~~~~~~~~~~~~*/-->
            <div id="salary_information" style="display:none;">
              <h3 style="text-align:center;background-color:#1b6633;color:#FFFFFF;">
                SALARY INFORMATION
              </h3>
              <hr>
              <table class="table-striped" style="width:90%;margin:0 auto;">
                <tr>
                  <td colspan="2">
                    <span style="font:bold 11px verdana; color:#DC241F; width:80%;">
                      NOTE: P.A.M. operates on ALL employees based on an hourly salary calculation. Rounding may occur.  
                    </span>
                  </td>
                </tr>
                <tr><td colspan="2">&nbsp;</td></tr>
                <tr id="row_ee_type">
                  <td style="width:40%;"><label>Salary Type:</label></td>
                  <td style="width:60%;">
                    <?php 
                      if( $budget['feed']['EE_TYPE'] == "S" ){
                        $thisSal = "Annual";
                        $sEEType = "checked";
                        $mEEType = "";
                        $hEEType = "";
                      } elseif($budget['feed']['EE_TYPE'] == "M"){
                        $thisSal = "Monthly";
                        $sEEType = "";
                        $mEEType = "checked";
                        $hEEType = "";
                      } else {
                        $thisSal = "Hourly";
                        $sEEType = "";
                        $mEEType = "";
                        $hEEType = "checked";
                      } // end if 
                    ?>
                    <?php if( (int)$budget['budget']['pam_status'] < 2 &&  $user['accessLevel'] != 'analyst'): ?>
                      <label class="radio inline">
                        <input type="radio" name="EE_TYPE" class='EET' <?= $sEEType; ?> value="S" /> Salaried
                      </label>
                      <label class="radio inline">
                        <input type="radio" name="EE_TYPE" class='EET' <?= $mEEType; ?> value="M" /> Stipended
                      </label>
                      <label class="radio inline">
                        <input type="radio" name="EE_TYPE" class='EET' <?= $hEEType; ?> value="H" /> Hourly
                      </label>
                    <?php else: ?>
                      <input type="text" name="EE_TYPE" class='EET' <?= $dissed; ?> value="<?= $thisSal; ?>" />
                    <?php endif; ?>
                  </td>
                </tr>
                <?php
                  $CAH = array(array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0)); 
                  $qCAH = $this->budget_m->get_employee_totals($budget['feed']['EMP_ID'], $curr_year, 'CAH'); 
                  if( $qCAH ){ $CAH = $qCAH; }
                ?>
                <?php
                    if($budget['feed']['CA_RAD'] == 'Y'){
                      $yCARAD = "checked";
                      $nCARAD = "";
                      $total_additional_income = 0;
                      for($ai = 1; $ai<13; $ai++){
                        $total_additional_income = $total_additional_income + $CAH[0]['P_'.$ai];
                      } // end for
                      $total_additional_income = $total_additional_income * $budget['feed']['ADJUSTED_HOURLY_RATE'];
                    } else {
                      $yCARAD = "";
                      $nCARAD = "checked";
                      $total_additional_income = 0;
                    } // end if}
                  ?>
                <?php
                  $curr_year = $this->globals_m->current_year();
                  $stipendAmounts = array(array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0));
                  $fetched_stipend_amount = $this->budget_m->get_employee_totals($budget['feed']['EMP_ID'], $curr_year, 'PSA');
                  if($fetched_stipend_amount){
                    $stipendAmounts = $fetched_stipend_amount; 
                  } // end if

                  $total_stipend_amount = 0;

                  for($sa=1;$sa<13;$sa++){
                    $total_stipend_amount = $total_stipend_amount + $stipendAmounts[0]['P_'.$sa];
                  } // end for
                ?>
                <?php
                  //Salary Type
                  if( $budget['feed']['JOB_ID'] != 4132 && $budget['feed']['JOB_ID'] != 4133){
                    $figAnnie = $budget['feed']['HOURLY_RATE'] * 2080;
                    $annieRate = number_format($figAnnie,2);
                    $hrlyRate = number_format($budget['feed']['ADJUSTED_HOURLY_RATE'],2);
                  } else {
                    $annieRate = $total_stipend_amount + $total_additional_income;
                    $annieRate = $annieRate . ' (includes Stipend and Additional Hours Worked)';
                  } // end if
                  $hrlyRate = number_format($budget['feed']['ADJUSTED_HOURLY_RATE'],2);
                ?>
                <tr>
                  <td>Annual Base Salary:</td>
                  <td>
                    <label name='ANNUAL_BASE'>
                      $<?= $annieRate; ?>
                    </label>
                  </td>
                </tr>
                <tr>
                  <td>Base Hourly Rate:</td>
                  <td>
                    <label name='HOURLY_RATE'>
                      $<?php echo $hrlyRate; ?>
                    </label>
                  </td>
                </tr>
                <tr><td colspan="2">&nbsp;</td></tr>
                <tr><td colspan="2">
                </td></tr>
                <?php if( !in_array((int)$budget['feed']['JOB_ID'], array(4132,4133) ) ): ?>
                <tr>
                  <td colspan="2" style="text-align:center;">
                    <b>SALARY ADJUSTMENTS</b>
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <div id="committedAdjustments"></div>
                  </td>
                </tr>
                <?php if( (int)$budget['budget']['pam_status'] < 2 && $user['accessLevel'] != 'analyst'): ?>
                  <tr><td colspan="2">&nbsp;</td></tr>
                  <tr>
                    <td><a id="btnSalAdjuster" class="btn" href=""><i class="icon-plus-sign"></i> Add Salary Adjustment</a></td>
                    <td>&nbsp;</td>
                  </tr>
                <?php endif; ?>
                <tr id="frmAdjSalary" style="display:none;">
                  <td colspan="2"><br>
                    <select class="span2 inline" id="salAdjPeriod" name="salAdjPeriod">
                      <option value="">Please Select ...</option>
                      <?php for($s=1;$s<13;$s++){ echo "<option value='P_$s'>{$fiscal[0]['P_'.$s]}</option>"; } // end for ?>
                    </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label class="radio inline">
                      <input type="radio" name="salAdjIncDec" class="SAID" value="Increase" /> Increase
                    </label>
                    <label class="radio inline">
                      <input type="radio" name="salAdjIncDec" class="SAID" value="Decrease" /> Decrease
                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label class="radio inline">
                      <input type="radio" name="salAdjType" class="SAT" value="Percent" /> Percent
                    </label>
                    <label class="radio inline">
                      <input type="radio" name="salAdjType" class="SAT" value="Dollars" /> Dollars
                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <div id="salAdjInput" style="display:inline;">
                      <div id="salAdjInputP" class="input-append" style="display:none;">
                        <input class="span1" name="salAdjPercent" type="text">
                        <span class="add-on">%</span>
                      </div>
                      <div id="salAdjInputDH" class="input-prepend input-append" style="display:none;">
                        <span class="add-on">$</span>
                        <input class="span1" name="salAdjDollars" type="text">
                        <span class="add-on" style="color:#C83F39;"><b>PER HOUR</b></span>
                      </div>
                      <div id="salAdjInputDS" class="input-prepend input-append" style="display:none;">
                        <span class="add-on">$</span>
                        <input class="span1" name="salAdjAnnual" type="text">
                        <span class="add-on" style="color:#C83F39;"><b>PER YEAR</b></span>
                      </div>
                      <div id="salAdjInputDM" class="input-prepend input-append" style="display:none;">
                        <span class="add-on">$</span>
                        <input class="span1" name="salAdjMonth" type="text">
                        <span class="add-on" style="color:#C83F39;"><b>PER MONTH</b></span>
                      </div>
                    </div>&nbsp;&nbsp;
                    <a id="btnSubmitAdjustment" class="btn btn-edr">ADD</a>
                  </td>
                </tr>
                <tr><td colspan="2">&nbsp;</td></tr>
                <?php else: // CAs ?>
                  <tr><td colspan="2">&nbsp;</td></tr>
                  <tr><td colspan="2"><b>MONTHLY STIPEND</b></td></tr>
                  <?php if( (int)$budget['budget']['pam_status'] < 2 &&  $user['accessLevel'] != 'analyst'): ?>
                    <tr style="background-color: #1b6633; color:#FFFFFF;">
                      <td>EZ Entry</td>
                      <td>
                        <input type="text" class="input-medium ezEntry" data-type="PSA" value="0" />
                        &nbsp;
                        <img src="<?= base_url('assets/images/ez-button.png'); ?>" style="height:30px;width="30px; class="btnEZ" data-type="PSA" />
                      </td>
                    </tr>
                  <?php endif; ?>
                  <tr><td colspan="2">
                    
                    <table class="table table-bordered" style="width:90%;margin:0 auto;">
                      <tr>
                        <?php for($f=1;$f<7;$f++): ?>
                          <th><?= $fiscal[0]['P_'.$f.'_a']; ?></th>
                        <?php endfor; ?>
                      </tr>
                      <tr>
                        <?php for($f=1;$f<7;$f++): ?>
                          <td>
                            <div class="input-prepend">
                              <span class="add-on">$</span>
                              <?= form_input('CA_MO_STIPEND_P_'.$f, $stipendAmounts[0]['P_'.$f], 'class="span1 ePSA" ' . $dissed); ?>
                            </div>
                          </td>
                        <?php endfor; ?>
                      </tr>
                      <tr>
                        <?php for($f=7;$f<13;$f++): ?>
                          <th><?= $fiscal[0]['P_'.$f.'_a']; ?></th>
                        <?php endfor; ?>
                      </tr>
                      <tr>
                        <?php for($f=7;$f<13;$f++): ?>
                          <td>
                            <div class="input-prepend">
                              <span class="add-on">$</span>
                              <?= form_input('CA_MO_STIPEND_P_'.$f, $stipendAmounts[0]['P_'.$f], 'class="span1 ePSA" ' . $dissed); ?>
                            </div>
                          </td>
                        <?php endfor; ?>
                      </tr>
                    </table>
                  </td></tr>
                  <tr><td colspan="2">&nbsp;</td></tr>
                  <?php if( (int)$budget['budget']['pam_status'] < 2): ?>
                    <tr>
                      <td style="width:40%;"><label>Will this employee be working additional monthly hours?</label></td>
                      <td style="width:60%;">
                        <label class="radio inline">
                          <input type="radio" name="CA_RAD" class="eCAAD" <?= $yCARAD; ?> value="Y"> Yes
                        </label>
                        <label class="radio inline">
                          <input type="radio" name="CA_RAD" class="eCAAD" <?= $nCARAD; ?> value="N"> No
                        </label>
                      </td>
                    </tr>
                  <?php endif; ?>
                <?php endif; ?>
                <tr><td colspan="2">&nbsp;</td></tr>
                <tr class="rowCA__RAD" style="display:none;">
                  <td colspan="2"><b>CA/RA ADDITIONAL HOURS</b></td>
                </tr>
                <tr class="rowCA__RAD" style="display:none;"><td colspan="2">&nbsp;</td></tr>
                <tr class="rowCA__RAD" style="display:none;">
                  <td><label>Hourly Rate for Additional Hours:</label></td>
                  <td>
                    <div class="input-prepend">
                      <span class="add-on">$</span>
                      <?php
                        if( (int)$budget['budget']['pam_status'] < 2):
                          $HOURLY_RATE_CA = array(
                             'id' => 'HOURLY_RATE_CA',
                             'name' => 'HOURLY_RATE_CA',
                             'class' => 'HOURLY_RATE_CA',
                             'value' => number_format($budget['feed']['ADJUSTED_HOURLY_RATE'],2)
                          );
                        else:
                          $HOURLY_RATE_CA = array(
                            'id' => 'HOURLY_RATE_CA',
                            'name' => 'HOURLY_RATE_CA',
                            'class' => 'HOURLY_RATE_CA',
                            'value' => $hrlyRate,
                            'disabled' => 'disabled'
                          );
                        endif;
                        echo form_input($HOURLY_RATE_CA);
                      ?>
                    </div>
                  </td>
                </tr>
                <?php if( (int)$budget['budget']['pam_status'] < 2): ?>
                  <tr class="rowCA__RAD" style="background-color:#1b6633 !important; color:#FFFFFF;display:none;">
                    <td>EZ Entry</td>
                    <td>
                      <input type="text" class="input-small ezEntry" data-type="CAH" value="0" />
                      &nbsp;
                      <img src="<?= base_url('assets/images/ez-button.png'); ?>" style="height:30px;width="30px; class="btnEZ" data-type="CAH" />
                    </td>
                  </tr>
                <?php endif; ?>
                <tr class="rowCA__RAD" style="display:none;">
                  <td colspan="2">
                    <table class="table table-bordered" style="width:90%;margin:0 auto;">
                      <tr>
                        <?php for($f=1;$f<7;$f++): ?>
                          <th><?= $fiscal[0]['P_'.$f.'_a']; ?></th>
                        <?php endfor; ?>
                      </tr>
                      <tr>
                        <?php for($f=1;$f<7;$f++): ?>
                          <td>
                            <?= form_input('CA_AH_P_'.$f, $CAH[0]['P_'.$f],'class="span1 eCAH" ' . $dissed); ?>
                          </td>
                        <?php endfor; ?>
                      </tr>
                      <tr>
                        <?php for($f=7;$f<13;$f++): ?>
                          <th><?= $fiscal[0]['P_'.$f.'_a']; ?></th>
                        <?php endfor; ?>
                      </tr>
                      <tr>
                        <?php for($f=7;$f<13;$f++): ?>
                          <td>
                            <?= form_input('CA_AH_P_'.$f, $CAH[0]['P_'.$f],'class="span1 eCAH" ' . $dissed); ?>
                          </td>
                        <?php endfor; ?>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr><td colspan="2">&nbsp;</td></tr>
              </table>
            </div> <!-- END salary_information -->
    <!--/*~~~~~~~~~~~~~ WORK HOURS INFORMATION ~~~~~~~~~~~~~~~*/-->
            <div id="work_hours_information" style="display:none;">
              <h3 style="text-align:center;background-color:#1b6633;color:#FFFFFF;">
                WORK HOURS INFORMATION
              </h3>
              <hr>
              <table id="tblWHI" class="table-striped" style="width:90%;margin:0 auto;">
                <tr>
                  <td style="width:50%">
                    <table id="tblFTE" class="table table-striped" style="width:70%;margin:0 auto;">
                      <tr>
                        <td colspan="2">
                          <b>FTE<br>( HOURS PER WEEK )</b><br>
                          <span style="font:bold 11px verdana; color:#DC241F; width:80%;">
                            MAX ALLOWED: 40
                          </span>
                        </td>
                      </tr>
                      <?php if( (int)$budget['budget']['pam_status'] < 2 &&  $user['accessLevel'] != 'analyst'): ?>
                        <tr style="background-color:#1b6633;color:#FFFFFF;">
                          <td>EZ Entry</td>
                          <td>
                            <input type="text" class="input-small ezEntry" data-type="FTE" value="0" />
                            &nbsp;
                            <img src="<?= base_url('assets/images/ez-button.png'); ?>" style="height:30px;width="30px; class="btnEZ" data-type="FTE" />
                          </td>
                        </tr>
                      <?php endif; ?>

                      <?php for($c=1;$c<13;$c++): ?>
                        <tr>
                          <td style="50%;">
                            <?= $fiscal[0]['P_'.$c]; ?>
                          </td>
                          <td style="50%;">
                            <input class="input-medium eFTE" type="text" id="FTE_P_<?= $c; ?>" name="FTE_P_<?= $c; ?>" value="<?= $budget['fte']['P_'.$c]; ?>" <?= $dissed; ?>>
                          </td>
                        </tr>
                      <?php endfor; ?>
                    </table>
                  </td>
                  <td style="50%">
                    <table id="tblOVR" class="table table-striped" style="width:70%;margin:0 auto;">
                      <tr>
                        <td colspan="2"><b>OVERTIME<br>( HOURS PER MONTH )</b><br><span style="font:bold 11px verdana; color:#DC241F; width:80%;">&nbsp;</span></td>
                      </tr>
                      <?php if( (int)$budget['budget']['pam_status'] < 2 &&  $user['accessLevel'] != 'analyst'): ?>
                        <tr style="background-color: #1b6633; color:#FFFFFF;">
                          <td>EZ Entry</td>
                          <td><input type="text" class="input-small ezEntry" data-type="OVR" value="0" />
                          &nbsp;
                            <img src="<?= base_url('assets/images/ez-button.png'); ?>" style="height:30px;width="30px; class="btnEZ" data-type="OVR" /></td></td>
                        </tr>
                      <?php endif; ?>
                      <?php for($c=1;$c<13;$c++): ?>
                        <tr>
                          <td style="50%;">
                            <?= $fiscal[0]['P_'.$c]; ?>
                          </td>
                          <td style="50%;">
                            <input class="input-medium eOVR" type="text" id="OVR_P_<?= $c; ?>" name="OVR_P_<?= $c; ?>" value="<?= $budget['overtime_hours']['P_'.$c]; ?>" <?= $dissed; ?>>
                          </td>
                        </tr>
                      <?php endfor; ?>
                    </table>
                  </td>
                </tr>
              </table>
            </div> <!-- END work_hours_information -->
    <!--/*~~~~~~~~~~~~~ DINING INFORMATION ~~~~~~~~~~~~~~~*/-->
            <div id="dining_information" style="display:none;">
              <h3 style="text-align:center;background-color:#1b6633;color:#FFFFFF;">DINING INFORMATION</h3>
              <hr>
              <table id="tblDINING" class="table-striped" style="width:90%;margin:0 auto;">
                <tr>
                  <td style="width:50%;">
                    <table id="tblDHR" class="table table-striped" style="width:70%;margin:0 auto;">
                      <tr>
                        <td colspan="2">
                          <b>DINING HOURS / MONTH</b><br>
                          <span style="font:bold 11px verdana; color:#DC241F; width:80%;">
                            MAX ALLOWED: 174 (Full Time)
                          </span>
                        </td>
                      </tr>

                      <?php if( (int)$budget['budget']['pam_status'] < 2 &&  $user['accessLevel'] != 'analyst'): ?>
                        <tr style="background-color:#1b6633;color:#FFFFFF;">
                          <td>EZ Entry</td>
                          <td>
                            <input type="text" class="input-small ezEntry" data-type="DHA" value="0" />
                            &nbsp;
                            <img src="<?= base_url('assets/images/ez-button.png'); ?>" style="height:30px;width="30px; class="btnEZ" data-type="DHA" />
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php for($c=1;$c<13;$c++): ?>
                        <tr>
                          <td style="50%;">
                            <?= $fiscal[0]['P_'.$c]; ?>
                          </td>
                          <td style="50%;">
                            <input class="input-medium eDHA" type="text" id="DH_P_<?= $c; ?>" name="DH_P_<?= $c; ?>" value="<?= $budget['dining_hours']['P_'.$c]; ?>" <?= $dissed; ?>>
                          </td>
                        </tr>
                      <?php endfor; ?>
                    </table>
                  </td>
                  <td style="width:50%;">
                    <table id="tblNOM" class="table table-striped" style="width:70%;margin:0 auto;">
                      <tr>
                        <td colspan="2">
                          <b>FREE MEALS<br>( MEALS PER MONTH )</b><br>
                          <span style="font:bold 11px verdana; color:#DC241F; width:80%;">
                            MAX ALLOWED: 100
                          </span>
                        </td>
                      </tr>

                      <?php if( (int)$budget['budget']['pam_status'] < 2 &&  $user['accessLevel'] != 'analyst'): ?>
                        <tr style="background-color:#1b6633;color:#FFFFFF;">
                          <td>EZ Entry</td>
                          <td>
                            <input type="text" class="input-small ezEntry" data-type="NOM" value="0" />
                            &nbsp;
                            <img src="<?= base_url('assets/images/ez-button.png'); ?>" style="height:30px;width="30px; class="btnEZ" data-type="NOM" />
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php for($c=1;$c<13;$c++): ?>
                        <tr>
                          <td style="50%;">
                            <?= $fiscal[0]['P_'.$c]; ?>
                          </td>
                          <td style="50%;">
                            <input class="input-medium eNOM" type="text" id="NOM_P_<?= $c; ?>" name="NOM_P_<?= $c; ?>" value="<?= $budget['employee_meals']['P_'.$c]; ?>" <?= $dissed; ?>>
                          </td>
                        </tr>
                      <?php endfor; ?>
                    </table>
                  </td>
                </tr>
              </table>
            </div> <!-- END dining_information -->
    <!--/*~~~~~~~~~~~~~ BENEFITS INFORMATION ~~~~~~~~~~~~~~~*/-->
            <div id="benefits_information" style="display:none;">
              <h3 style="text-align:center;background-color:#1b6633;color:#FFFFFF;">
                BENEFITS INFORMATION
              </h3>
              <hr>
              <table class="table-striped" style="width:90%;margin:0 auto;">
                <tr>
                  <td>Employee State:</td>
                  <td>
                    <?php
                      $selState = "id='empState' " . $dissed;
                      $states = $this->globals_m->fetch_state_dd();
                      echo form_dropdown('empState',$states,$budget['feed']['EMP_STATE'],$selState);
                    ?>
                  </td>
                </tr>
                <tr>
                  <td>Group Insurance:</td>
                  <td>
                    <?php
                      $groupInsurance = array('None' => 'None','Single' => 'Single','Family' => 'Family');
                      $groupInsJS = "id='groupInsurancePlan' " . $dissed;
                      echo form_dropdown('groupIns',$groupInsurance,$budget['feed']['GRP_INS_TYPE'],$groupInsJS);
                    ?>
                    <?php
                      $giSingle = "$" . $this->globals_m->get_gi_single();
                      $giFamily = "$" . $this->globals_m->get_gi_family();
                    ?>
                    <?php if($budget['feed']['GRP_INS_TYPE'] != 'None'): ?>
                      <br>
                      <div id="row_grp_ins_exp">
                        Group Insurance Expense:
                        <div class="input-prepend">
                          <span class="add-on">$</span>
                            <input type="text" id="txtGrpInsExp" name="GRP_INS_MONTHLY_EXPENSE" value="<?= $budget['feed']['GRP_INS_MONTHLY_EXPENSE']; ?>" <?= $dissed; ?> />
                            </span><br>
                            <span style="font-size:11px;font-weight:bold;color:#404040;">Current Defaults: Single: <?= $giSingle ?>; Family: <?= $giFamily; ?>;</span>
                        </div>
                      </div>
                    <?php else: ?>
                      <br>
                      <div id="row_grp_ins_exp" style="display:none;">
                        Group Insurance Expense:
                        <div class="input-prepend">
                          <span class="add-on">$</span>
                            <input type="text" id="txtGrpInsExp" name="GRP_INS_MONTHLY_EXPENSE" value="<?= $budget['feed']['GRP_INS_MONTHLY_EXPENSE']; ?>" <?= $dissed; ?> />
                            </span><br>
                            <span style="font-size:11px;font-weight:bold;color:#404040;">Current Defaults: Single: <?= $giSingle ?>; Family: $<?= $giFamily; ?>;</span>
                        </div>
                      </div>
                    <?php endif; ?>
                  </td>
                </tr>
                
                <tr>
                    <td>401K Employee Match Percentage:</td>
                    <td>
                         <select name="cont401k" id = 'k401' <?= $dissed; ?>>
                      <?php if ( $budget['feed']['PERCENTAGE_401K'] == 0) { ?>
                           <option value="0" selected="selected">0%</option>
                      <?php } else { ?>
                           <option value="0">0%</option>
                      <?php
                      }
                      if ( $budget['feed']['PERCENTAGE_401K'] == 1) {?>
                           <option value="1" selected="selected">1%</option>
                      <?php } else { ?>
                           <option value="1">1%</option>
                      <?php
                      }
                      if ( $budget['feed']['PERCENTAGE_401K'] == 2) { ?>
                           <option value="2" selected="selected">2%</option>
                      <?php } else { ?>
                           <option value="2">2%</option>
                      <?php
                      }
                      if ( $budget['feed']['PERCENTAGE_401K'] >= 3) { ?>
                           <option value="3" selected="selected">3% or ></option>
                      <?php } else {?>
                           <option value="3">3% or ></option>
                      <?php } ?>
                         </select>
                    </td>
               </tr>
               <tr>
                 <td>Flex Spend Program</td>
                 <td>
                   <?php
                      $flex = array('N' => 'Not Participating','Y' => 'Participating');
                      $fsaJS = "id='FSA' " . $dissed;
                      echo form_dropdown('FSA',$flex,$budget['feed']['FSA'],$fsaJS);
                    ?>
                 </td>
               </tr>
               <tr>
                <td>Stock Purchase Percentage<br>( Limit: Up to 15% )</td>
                <td>
                  <div class="input-append">
                    <?= form_input('ESPP',$budget['feed']['ESPP'], $dissed); ?>
                    <span class="add-on">%</span>
                  </div>
                </td>
               </tr>
               <tr><td colspan="2">&nbsp;</td></tr>
               <tr><td colspan="2">&nbsp;</td></tr>
               <tr>
                  <td colspan="2" style="text-align:center;">
                    <b>STAFFING -- OTHER BENEFITS</b>
                  </td>
                </tr>
                <tr><td colspan="2">
                  <?php
                    $quarters = $this->globals_m->get_annual_quarters($budget['budget']['fiscalStart']);

                    if( in_array($budget['budget']['companyTypeID'], array(1,2)) || in_array($budget['feed']['JOB_ID'], array(4120,4121)) ){
                      $ADDInsEx = $this->globals_m->getADDExpense();
                    } else {
                      $ADDInsEx = 0;
                    } // end if
                    if($budget['feed']['FSA'] == 'Y'){
                      $FSPE = $this->globals_m->get_flex_spend();
                    } else {
                      $FSPE = 0;
                    } // end if
                    if( (int) $budget['feed']['COMPANY_ID'] > 299 && (int)$budget['feed']['DEPARTMENT_ID'] != 55 ){
                      $ESPP = $this->globals_m->getESPPAdmin();
                    } else {
                      $ESPP = 0;
                    } // end if

                    if($budget['feed']['ESPP'] != '' && (int)$budget['feed']['ESPP'] > 0){
                      $pmsal = $this->budget_m->get_salary_from_pmout($budget['feed']['EMP_ID'], $this->globals_m->current_year());
                      $pmbone = $this->budget_m->get_bonus_from_pmout($budget['feed']['EMP_ID'], $this->globals_m->current_year());

                      $total_income = 0;
                      for($c=1;$c<13;$c++){
                        $total_income += $pmsal[0]['P_'.$c] + $pmbone[0]['P_'.$c];
                      } // end for

                      $discount_price = $this->globals_m->get_stock_market_price();
                      $discount_share = $this->globals_m->get_stock_market_discount();
                      
                      $totESPPD = ceil($total_income * $budget['feed']['ESPP']/100 / $discount_price) * $discount_share;
                        $ESPPD = $totESPPD / 4;
                    } else { 
                      $ESPPD = 0.00;
                      $totESPPD = 0.00;
                    } // end if
                    
                  ?>
                  <table class="table table-striped" style="width:90%;margin:0 auto;">
                    <tr>
                      <th>&nbsp;</th>
                      <th style="vertical-align:bottom;">A.D. &amp; D. Insurance</th>
                      <th style="vertical-align:bottom;">Flex Spd<br>Program Expense</th>
                      <th style="vertical-align:bottom;">Emp Stock<br>Purchase Plan Admin</th>
                      <th style="vertical-align:bottom;">Emp Stock<br>Purchase Plan Discount</th>
                      <th style="vertical-align:bottom;">Additional Benefit</th>
                      <th style="vertical-align:bottom;">TOTAL</th>
                    </tr>
                    <tr style="background-color: #1b6633; color:#FFFFFF;">
                      <td colspan="2">EZ Entry</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td colspan="2">
                        <input type="text" class="input-small ezEntry" data-type="ABS" value="0" />
                        &nbsp;
                        <img src="<?= base_url('assets/images/ez-button.png'); ?>" style="height:30px;width="30px; class="btnEZ" data-type="ABS" />
                      </td>
                    </tr>
                    <?php for($y=1;$y<13;$y++): ?>
                      <tr class='oBennie'>
                        <td><?= $fiscal[0]['P_'.$y.'_a']; ?></td>
                        <td>
                          <div class="input-prepend">
                            <span class="add-on">$</span>
                            <input type="text" class="input-mini ADDINSEX" name="ADDINSEX" disabled="disabled" value="<?= number_format($ADDInsEx,2); ?>" />
                          </div>
                        </td>
                        <td>
                          <div class="input-prepend">
                            <span class="add-on">$</span>
                            <input type="text" class="input-mini FSPE" name="FSPE" disabled="disabled" value="<?= number_format($FSPE,2); ?>" />
                          </div>
                        </td>
                        <td>
                          <div class="input-prepend">
                            <span class="add-on">$</span>
                            <input type="text" class="input-mini ESPP" name="ESPP" disabled="disabled" value="<?= number_format($ESPP,2); ?>" />
                          </div>
                        </td>
                        <?php if( in_array($y, $quarters) ): ?>
                          <td>
                            <div class="input-prepend">
                              <span class="add-on">$</span>
                              <input type="text" class="input-mini ESPPD" name="ESPPD" disabled="disabled" value="<?= number_format($ESPPD,2); ?>" />
                            </div>
                          </td>
                        <?php else: ?>
                          <td>
                            <div class="input-prepend">
                              <span class="add-on">$</span>
                              <input type="text" class="input-mini ESPPD" name="ESPPD" disabled="disabled" value="-" />
                            </div>
                          </td>
                        <?php endif; ?>
                        <td>
                          <div class="input-append">
                            <span class="add-on">$</span>
                            <input <?= $dissed; ?> type="text" class="input-mini ADDBEN eABS" name="additional_benefits_P_<?= $y; ?>" value="<?= $budget['additional_benefits']['P_'.$y]; ?>" />
                          </div>
                        </td>
                        <td>
                          <div class="input-prepend">
                            <span class="add-on">$</span>
                            <input type="text" class="input-mini brTot" name="benRowTotal" disabled="disabled" />
                          </div>
                        </td>
                      </tr>
                    <?php endfor; ?>
                    <tr>
                      <td><b>TOTAL</b></td>
                      <td>
                        <div class="input-prepend">
                          <span class="add-on">$</span>
                          <input type="text" class="input-mini benTotal" id="totADND" name="totADND" disabled="disabled" value="<?= number_format((float)$ADDInsEx*12,2); ?>" />
                        </div>
                      </td>
                      <td>
                        <div class="input-prepend">
                          <span class="add-on">$</span>
                          <input type="text" class="input-mini benTotal" id="totFSPE" name="totFSPE" disabled="disabled" value="<?= number_format((float)$FSPE*12,2); ?>" />
                        </div>
                      </td>
                      <td>
                        <div class="input-prepend">
                          <span class="add-on">$</span>
                          <input type="text" class="input-mini benTotal" id="totESPP" name="totESPA" disabled="disabled" value="<?= number_format((float)$ESPP*12,2); ?>" />
                        </div>
                      </td>
                      <td>
                        <div class="input-prepend">
                          <span class="add-on">$</span>
                          <input type="text" class="input-mini benTotal" id="totESPD" name="totESPD" disabled="disabled" value="<?= number_format((float)$totESPPD,2); ?>" />
                        </div>
                      </td>
                      <td>
                        <div class="input-prepend">
                          <span class="add-on">$</span>
                          <input type="text" class="input-mini benTotal" id="totADDBEN" name="totADDBEN" disabled="disabled" />
                        </div>
                      </td>
                      <td>
                        <div class="input-prepend">
                          <span class="add-on">$</span>
                          <input type="text" class="input-mini benTotal" id="totGrand" name="totGrand" disabled="disabled" />
                        </div>
                      </td>
                    </tr>
                  </table>
                </td></tr>
              </table>
            </div> <!-- END benefits_information -->
    <!--/*~~~~~~~~~~~~~ BONUS INFORMATION ~~~~~~~~~~~~~~~*/-->
            <div id="bonus_information" style="display:none;">
              <?php // test for property. Write notice about Staffing / Dining Bonus?>

              <?php // else: ?>
                <h3 style="text-align:center;background-color:#1b6633;color:#FFFFFF;">
                  BONUS INFORMATION
                </h3>
                <hr>
                <table class="table-striped" style="width:90%;margin:0 auto;">
                  <tr>
                    <td style="width:35%;">Corporate Bonus Percentage</td>
                    <td style="width:65%;">
                      <div class="input-append">
                        <input type="text" <?= $dissed; ?> name="HOME_OFFICE_BONUS_PERCENTAGE" value="<?= $budget['feed']['HOME_OFFICE_BONUS_PERCENTAGE']; ?>" />
                        <span class="add-on">%</span>
                      </div>
                    </td>
                  </tr>
                  <tr><td colspan="2">&nbsp;</td></tr>
                  <?php if((int)$budget['budget']['companyTypeID'] == 2): ?>
                    <tr>
                      <td colspan="2" style="text-align:center;">
                        <b>DEVELOPMENT BONUS</b>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" style="text-align:center;">
                        <span style="font:normal 14px verdana; color:#DC241F; width:80%;">
                          Enter the dollar amount for the Development Bonus in the appropriate field(s) below  
                        </span>
                      </td>
                    </tr>
                    <?php if( (int)$budget['budget']['pam_status'] < 2 &&  $user['accessLevel'] != 'analyst'): ?>
                      <tr style="background-color: #1b6633; color:#FFFFFF;">
                        <td style="background-color: #1b6633">EZ Entry</td>
                        <td style="background-color: #1b6633">
                          <div class="input-prepend">
                            <span class="add-on"style="color:#000;" >$</span>
                            <input type="text" class="input-small ezEntry" data-type="DVB" value="0" />
                            &nbsp;
                            <img src="<?= base_url('assets/images/ez-button.png'); ?>" style="height:30px;width="30px; class="btnEZ" data-type="DVB" />
                          </div>
                        </td>
                      </tr>
                    <?php endif; ?>
                    <?php for($y=1;$y<13;$y++): ?>
                      <tr>
                        <td><?= $fiscal[0]['P_'.$y] ?></td>
                        <td>
                          <div class="input-prepend">
                            <span class="add-on">$</span>
                            <input type="number" <?= $dissed; ?> name="DEV_BONUS_P_<?= $y; ?>" value="<?= $budget['development_bonus']['P_'.$y]; ?>" class="eDVB" />
                          </div>
                        </td>
                      </tr>
                    <?php endfor; ?>
                  <?php endif; ?>
                </table>
              <?php //endif; ?>
            </div> <!-- END bonus_information -->
    <!--/*~~~~~~~~~~~~~ ALLOCATION INFORMATION ~~~~~~~~~~~~~~~*/-->
            <div id="allocation_information" style="display:none;">
              <h3 style="text-align:center;background-color:#1b6633;color:#FFFFFF;">ALLOCATION INFORMATION</h3>
              <hr>
              <table class="table-striped" style="width:90%;margin:0 auto;">
                <tr>
                  <td colspan="2">
                    <label>What percentage of this employee should be designated for this budget?</label>
                    <div class="input-append">
                      <input type="number" <?= $dissed; ?> name="ALLOC_TOTAL" value="<?= $budget['feed']['ALLOC_TOTAL']; ?>" />
                      <span class="add-on">%</span>
                    </div>
                  </td>
                </tr>
              </table>
            </div> <!-- END allocation_information-->
          <?= form_close(); ?>
    <!--/*~~~~~~~~~~~~~ END EDIT EMPLOYEE FORM ~~~~~~~~~~~~~~~*/-->
        </div>
      </div> <!-- end .row -->
    </div> <!-- end .span12 -->
  </div> <!-- END . container -->

<script type="text/javascript">
   
  /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
  jQuery(document).ready( function($) {

    var EMP_ID = "<?= $budget['feed']['EMP_ID']; ?>";
    var EE_TYPE = "<?= $budget['feed']['EE_TYPE']; ?>";
    var PART_FULL = "<?= $budget['feed']['FULL_PART']; ?>";
    var HAS_OVERTIME = "<?= $budget['feed']['HAS_OVERTIME']; ?>";
    var JOB_CODE = "<?= $budget['feed']['JOB_ID']; ?>";
    var MEAL_ELIGIBLE = "<?= $budget['feed']['IS_MEAL_ELIGIBLE']; ?>";
    var CA_AD = "<?= $budget['feed']['CA_RAD']; ?>";
    var COMPANY_TYPE = "<?= (int)$budget['budget']['companyTypeID']; ?>";
    var can_allocate = "<?= $budget['budget']['CAN_ALLOCATE']; ?>"; // 0 or 1
    var a = ["#employee_information","#salary_information","#work_hours_information","#dining_information","#benefits_information","#bonus_information","#allocation_information", "#editSummary"];
    var arrayOfScreens = a.join(", ");
    var fig = 0;
    //alert(COMPANY_TYPE);
    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
    dining();
    test_ca();

    //TOC
    if( HAS_OVERTIME == 'N' && EE_TYPE != 'H'){ $('#btn_work_hours_information').hide(); }
    if( COMPANY_TYPE != 4 && COMPANY_TYPE != 6 && MEAL_ELIGIBLE != 'Y'){ 
      $('#btn_dining_information').hide(); 
    } // end if
    if(COMPANY_TYPE == 4 || COMPANY_TYPE == 6){
      $('#btn_work_hours_information').hide();
      $('#btn_dining_information').show();
    } // end if
    if( COMPANY_TYPE != 1 && COMPANY_TYPE != 2 ){ $('#btn_bonus_information').hide(); }
    if(can_allocate != 1 ){ $('#btn_allocation_information').hide(); }

     $(document).on('blur', 'input[name=ESPP]', function(e){
      var valew = $(this).val();
      if( valew > 15){
        $(this).val(15);
      } // end if
    });

    $(document).on('blur', '.ezEntry', function(e){
      var tipe = $(this).data('type');
      var vale = $(this).val();

      switch(tipe){
        case 'FTE':
          if( vale > 40){ vale = 40; }
          $('.eFTE').each(function( index ){
            $(this).val(vale);
          });
          break;
        case 'OVR':
          $('.eOVR').each(function( index ){
            $(this).val(vale);
          });
          break;
        case 'PSA':
          $('.ePSA').each(function( index ){
            $(this).val(vale);
          });
          break;
        case 'CAH':
          $('.eCAH').each(function( index ){
            $(this).val(vale);
          });
          break;
        case 'DHA':
          if( vale > 174){ vale = 174; }
          $('.eDHA').each(function( index ){
            $(this).val(vale);
          });
          break;
        case 'NOM':
          $('.eNOM').each(function( index ){
            $(this).val(vale);
          });
          break;
        case 'EMA':
          $('.eEMA').each(function( index ){
            $(this).val(vale);
          });
          break;
        case 'ABS':
          $('.eABS').each(function( index ){
            $(this).val(vale);
            $('input[name="additional_benefits_P_12"]').blur();
          });
          break;
        case 'DVB':
          $('.eDVB').each(function( index ){
            $(this).val(vale);
          });
          break;
      } // end switch
    });

    $('.btnNav').click(function(){
      var id = $(this).attr('id');
      var nme = '#' + id.replace('btn_', '');

      $(arrayOfScreens).hide();
      
      if( nme == '#work_hours_information'){
        if(EE_TYPE == 'S'){ 
          $('#tblFTE').hide();
        } else {
          $('#tblFTE').show();
        } //end if

        if( $('input[name=hasOvertime]:checked').val() == 'N' ){
          $('#tblOVR').hide();
        } else {
          $('#tblOVR').show();
        } //end if
      } // end if
      
      if( nme == '#salary_information'){
        jQuery.ajax({
          url: "<?= site_url('pam_budget/ajax_get_salary_adjustment'); ?>",
          type: 'POST',
          dataType: 'html',
          data: {EMP_ID: EMP_ID},
          success: function(msg) { 
            $('#committedAdjustments').empty().html(msg);
            if( EE_TYPE == 'M' && CA_AD == 'Y'){
              $('.rowCA__RAD').show();
            } // end if 
          } // end success
        }); // end $.ajax
      } // end if
      $(nme).show();
    });

    $('#btnSalAdjuster').click(function(e){
      e.preventDefault();
      $('#salAdjInputP').find('input').val('');
      $('#salAdjInputD').find('input').val('');
      $('.SAT:checked').val('Percent');
      $('.SAID:checked').val('Increase');
      $('#salAdjPeriod').val('');
      $('#frmAdjSalary').show();
      return false;
    });

    $(document).on('click', '#btnRefresh', function(e){
      $('#refreshed').val('Y');
      $('#frmEditEmp').submit();
    });

    $(document).on('change', '.SAT', function(e){
      var typed = $(this).val();
      if( typed == "Percent"){
        $('#salAdjInputP').css('display','inline');
        $('#salAdjInputDH').css('display','none');
        $('#salAdjInputDS').css('display','none');
        $('#salAdjInputDM').css('display','none');
      } // end if
      if( typed == "Dollars" && EE_TYPE == "H" ){
        $('#salAdjInputP').css('display','none');
        $('#salAdjInputDH').css('display','inline');
        $('#salAdjInputDS').css('display','none');
        $('#salAdjInputDM').css('display','none');
      } // end if
      if( typed == "Dollars" && EE_TYPE == "M"){
        $('#salAdjInputP').css('display','none');
        $('#salAdjInputDH').css('display','none');
        $('#salAdjInputDS').css('display','none');
        $('#salAdjInputDM').css('display','inline');
      } // end if
      if( typed == "Dollars" && EE_TYPE == "S"){
        $('#salAdjInputP').css('display','none');
        $('#salAdjInputDH').css('display','none');
        $('#salAdjInputDS').css('display','inline');
        $('#salAdjInputDM').css('display','none');
      } // end if
    });

    $(document).on('blur', '.eFTE', function(e){
      var valew = $(this).val();
      if( parseFloat(valew) > 40 ){
        alert('Maximum allowed value is 40.');
        $(this).val('40');
        return false;
      } // end if
    });

    $(document).on('change', '.hasOvertime', function(e){
      var HOS = $('input[name=hasOvertime]:checked').val();
      if( HOS == 'Y' ){
        $('#btn_work_hours_information').fadeIn();
      } else {
        if(EE_TYPE != 'H'){
          $('#btn_work_hours_information').fadeOut();
        }
      } // end if
    });

    $(document).on('change', '.isMealEligible', function(e){
      var ISM = $('input[name=isMealEligible]:checked').val();
      if( ISM == 'Y' ){
        $('#btn_dining_information').fadeIn();
      } else {
        $('#btn_dining_information').fadeOut();
      } // end if
    });

    $(document).on('click', '#btnSubmitAdjustment', function(e){
      var period = $('#salAdjPeriod option:selected').val();
      var IncDec = $('.SAID:checked').val();
      var typer = $('.SAT:checked').val();
      
      if(typer == 'Percent'){
        fig = $('input[name=salAdjPercent]').val();
      } else {
        if( EE_TYPE == 'S'){
          fig = $('input[name=salAdjAnnual]').val();
        } else if ( EE_TYPE == 'M'){
          fig = $('input[name=salAdjMonth]').val();
        } else {
          fig = $('input[name=salAdjDollars]').val();
        } // end if
      } // end if

      if( period == 0){
        alert('You must select an effective period.');
        return false;
      } // end if

      if( !IncDec){
        alert('You must select an increase or decrease in salary.');
        return false;
      } // end if

      if( !typer){
        alert('You must select either a percentage or monetary increase or decrease in salary.');
        return false;
      } // end if

      e.preventDefault();
      $('#frmAdjSalary').hide();
      $.ajax({
        url: "<?= site_url('pam_budget/ajax_add_salary_adjustment'); ?>",
        type: 'POST',
        data: { EMP_ID : EMP_ID, period : period, IncDec : IncDec, typer : typer, fig : fig},
        success: function(msg) {$('#committedAdjustments').empty().html(msg); }
      }); // end ajax
    });

    $(document).on('click', '.btnDeleteAdj', function(e){
      var period = $(this).data('period');

      e.preventDefault();
      $('#frmAdjSalary').hide();
      $.ajax({
        url: "<?= site_url('pam_budget/ajax_delete_salary_adjustment'); ?>",
        type: 'POST',
        data: { EMP_ID : EMP_ID, period : period},
        success: function(msg) {$('#committedAdjustments').empty().html(msg); }
      }); // end ajax
    });

    $(document).on('change', '.eCAAD', function(e){
      var cah = $('input[name="CA_RAD"]:checked').val();
      if( cah == "Y"){
        $('.rowCA__RAD').fadeIn('slow');
      } // end if
      if( cah == "N"){
        $('.rowCA__RAD').fadeOut('slow');
      } // end if
    });

    $(document).on('change', '#groupInsurancePlan', function(e){
      var gip = $(this).val();

      if(gip == 'None'){
        $('#txtGrpInsExp').val(0);
        $('#row_grp_ins_exp').slideUp(350);
      } else {
        $('#row_grp_ins_exp').slideDown(350);
      } // end if
    });

    $('#btnCancelEdit').on('click', function(e){
      var answer = confirm('You have entered new data that has not yet been saved or submitted to the server. If you click "OK" below, this data will be lost. Click "Cancel" to stay on the current page.');
      if (answer) {
        window.location = "<?= site_url('pam_budget/budget/'.$budget['feed']['BUDGET_ID']); ?>";  
      } // end if
      return false;
    }); // end btnCancel

    $('#btnCloseView').on('click', function(e){
        window.location = "<?= site_url('pam_budget/budget/'.$budget['feed']['BUDGET_ID']); ?>";  
    }); // end btnCancel

    $('#submitToPM').on('click', function(e){
      $('#frmEditEmp').submit();
    }); // end submitToPM

    $('.datepicker').datepicker({ minDate: 0 });

    if( $('input[name=radRehireDate]:checked').val() == 'N'){
      $('#endDateRow').hide();
    } // end if

    $('.ADDBEN').blur(function(e){
      total_benny();
    }).blur();

    function test_ca(){
      if( parseInt(JOB_CODE) != 4132 && parseInt(JOB_CODE) != 4133 ){ 
        return false; 
      } else {
        $('#row_ee_type').hide();
        $('input[name=EE_TYPE]').val('M');
        $('#tblFTE').hide();
      } // end if
    } // end function
  }); // end document ready
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
  function formatCurrency(num) {
    num = isNaN(num) || num === '' || num === null ? 0.00 : num;
    return parseFloat(num).toFixed(2);
  } // end function

  function showRehireDate() { //show Rehire Date
    var value = $('input[name=radRehireDate]:checked').val();
      if(value == 'Y') {
        $('#endDateRow').show(500);
      } else {
        $('#endDateRow').hide();
      }//endif
  }//end ShowRehireDate function

  function dining() {// Dining Employee hours & Number of Meals dropdowns
    var diningDD = $('#diningEmp :selected').val();
    var mealsDD = $('#meals :selected').val();

    if(diningDD == 'N') {
      $('#dhNOM tr').find('th:eq(0)').hide();
      $('#dhNOM tr').find('td:eq(0)').hide();
      $('#dhNOM tr').find('th:eq(1)').hide();
      $('#dhNOM tr').find('td:eq(1)').hide();
    }//endif
    
    if(mealsDD == 'N') {
      $('#dhNOM tr').find('th:eq(0)').hide();
      $('#dhNOM tr').find('td:eq(0)').hide();
      $('#dhNOM tr').find('th:eq(2)').hide();
      $('#dhNOM tr').find('td:eq(2)').hide();
    }//endif
    
    if(diningDD == 'Y') {
      $('#dhNOM tr').find('th:eq(0)').show();
      $('#dhNOM tr').find('td:eq(0)').show();
      $('#dhNOM tr').find('th:eq(1)').show();
      $('#dhNOM tr').find('td:eq(1)').show();
    }//endif
    
    if(mealsDD == 'Y') {
      $('#dhNOM tr').find('th:eq(0)').show();
      $('#dhNOM tr').find('td:eq(0)').show();
      $('#dhNOM tr').find('th:eq(2)').show();
      $('#dhNOM tr').find('td:eq(2)').show();
    }//endif  
  }//end Dining function

  function total_benny(){
    var toto;
    var totAddBen = 0;
    var grtoto = 0;

    $('.oBennie').each( function(){
      var adnd = parseFloat( $(this).find("input.ADDINSEX").val() );
      var FSPE = parseFloat( $(this).find("input.FSPE").val() );
      var ESPP = parseFloat( $(this).find("input.ESPP").val() );
      var ESPPD = parseFloat( $(this).find("input.ESPPD").val() );
      var ADDBEN = parseFloat( $(this).find("input.ADDBEN").val() );

      if( isNaN(ESPPD) ){
        toto = adnd + FSPE + ESPP + ADDBEN;
      } else {
        toto = adnd + FSPE + ESPP + ADDBEN + ESPPD;
      } // end if
      
      grtoto += toto;

      $(this).find('.brTot').val( formatCurrency(toto) );
    }); 

    $('.ADDBEN').each(function(){
      totAddBen += parseFloat(this.value);
    });

    $('#totADDBEN').val( formatCurrency(totAddBen));
    $('#totGrand').val( formatCurrency(grtoto));
  } // end total_benny function
</script>
</body>
</html>
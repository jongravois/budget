<!DOCTYPE html>
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
            <li>&nbsp;</li>
            <li><a id="submitToPM" class="btn btn-large btn-block btn-edr">
              SAVE ALL CHANGES
            </a></li>
            <li>&nbsp;</li>
            <li>
              <a id="btnCancelEdit" class="btn btn-block btn-danger" href="#">
                CANCEL EDIT
              </a>
            </li>
        </ul>
    <!--/*~~~~~~~~~~~~~ END LEFT NAV ~~~~~~~~~~~~~~~*/-->
        </div>
        <div class="span9">
          <?php //print_r($budget);  //style="display:none;" ?>
    <!--/*~~~~~~~~~~~ BEGIN EDIT EMPLOYEE FORM ~~~~~~~~~~~~~*/-->
          <?= form_open('pam_budget/edit_emp_handler', array('id' => 'frmEditEmp')); ?>
          <?= form_hidden('BUDGET_ID',$budget['budget']['id']); ?>
          <?= form_hidden('EMP_ID', $budget['feed']['EMP_ID']); ?>
    <!--/*~~~~~~~~~~~~~ EMPLOYEE SUMMARY ~~~~~~~~~~~~~~~*/-->
            <div id="editSummary">
              <h3 style="text-align:center;background-color:#1b6633;color:#FFFFFF;">EMPLOYEE SUMMARY</h3>
              <hr>
              <table class="table-striped" style="width:90%;margin:0 auto;">
                <tr>
                  <td style="width:35%; text-align:left;">COMPANY:</td>
                  <td style="width:65%; text-align:left;">
                    <span id='summaryEmp' class='summery'><?= $budget['budget']['name']; ?></span>
                  </td>
                </tr>
                <tr>
                  <td>DEPARTMENT:</td>
                  <td>
                    <span id='summaryEmp' class='summery'>
                      <?= $budget['feed']['DEPARTMENT_ID'] . ' -- ' . $budget['feed']['Department']; ?>
                    </span>
                  </td>
                </tr>
                <tr>
                  <td>JOB TITLE:</td>
                  <td>
                    <span id='summaryEmp' class='summery'>
                      <?= $budget['feed']['JOB_ID'] . ' -- ' . $budget['feed']['jobTitle']; ?>
                    </span>
                  </td>
                </tr>
                <tr>
                  <td>EMPLOYEE:</td>
                  <td>
                    <span id='summaryEmp' class='summery'><?= $budget['feed']['NAME']; ?></span>
                  </td>
                </tr>
                <tr>
                  <td>HIRE DATE:</td>
                  <td>
                    <span id='summaryEmp' class='summery'><?= $budget['feed']['HIRE_DATE']; ?></span>
                  </td>
                </tr>
                <tr>
                  <td>BUDGET START DATE:</td>
                  <td>
                    <span id='summaryEmp' class='summery'><?= $budget['feed']['START_DATE']; ?></span>
                  </td>
                </tr>
                <tr>
                  <td>BUDGET END DATE:</td>
                  <td>
                    <span id='summaryEmp' class='summery'><?= $budget['feed']['REHIRE_DATE']; ?></span>
                  </td>
                </tr>
                <tr>
                  <td>ORIGINAL BASE SALARY (Annual):</td>
                  <td>
                    <span id='summaryEmp' class='summery'>$<?= number_format($budget['feed']['ANNUAL_RATE'],2,'.',','); ?></span>
                  </td>
                </tr>
                <tr>
                  <td>ORIGINAL MONTHLY STIPEND AMOUNT:</td>
                  <td>
                    <span id='summaryEmp' class='summery'>$<?= number_format($budget['feed']['STIPEND_AMOUNT'],2,'.',','); ?></span>
                  </td>
                </tr>
                <tr>
                  <td>ORIGINAL BASE SALARY (Hourly):</td>
                  <td>
                    <span id='summaryEmp' class='summery'>$<?= number_format($budget['feed']['HOURLY_RATE'],2,'.',','); ?></span>
                  </td>
                </tr>
                <tr>
                  <td>ADJUSTED BASE SALARY (Annual):</td>
                  <td>
                    <?php  
                      $tSal = $this->budget_m->get_salary_periods_from_pmout($budget['feed']['EMP_ID'],$curr_year );
                    ?>
                    <span id='summaryEmp' class='summery'>
                      $<?= number_format(array_sum($tSal[0]),2,'.',','); ?>
                    </span>
                  </td>
                </tr>
                <tr>
                  <td>ADJUSTED MONTHLY STIPEND AMOUNT:</td>
                  <td>
                    <?php  
                      $aSal = $this->budget_m->get_stipend_adjustments($budget['feed']['EMP_ID']);
                      if( !$aSal ){ 
                        $newMonthly = $budget['feed']['STIPEND_AMOUNT']; 
                      } else {
                        $newMonthly = $aSal[0]['P_12'];
                      } // end if
                    ?>
                    <span id='summaryEmp' class='summery'>
                      $<?= number_format($newMonthly,2,'.',','); ?>
                    </span>
                  </td>
                </tr>
                <tr>
                  <td>ADJUSTED BASE SALARY (Hourly):</td>
                  <td>
                    <?php  
                      $aSal = $this->budget_m->get_salary_adjustments($budget['feed']['EMP_ID']);
                      if( !$aSal ){ 
                        $newHourly = $budget['feed']['HOURLY_RATE']; 
                      } else {
                        $newHourly = $aSal[0]['P_12'];
                      } // end if
                    ?>
                    <span id='summaryEmp' class='summery'>
                      $<?= number_format($newHourly,2,'.',','); ?>
                    </span>
                  </td>
                </tr>
                <tr>
                  <td>CORPORATE OFFICE BONUS:</td>
                  <td>
                    <span id='summaryEmp' class='summery'><?= $budget['feed']['HOME_OFFICE_BONUS_PERCENTAGE']; ?>%</span>
                  </td>
                </tr>
                <tr>
                  <td>GROUP INSURANCE PLAN:</td>
                  <td>
                    <span id='summaryEmp' class='summery'><?= $budget['feed']['GRP_INS_TYPE']; ?></span>
                  </td>
                </tr>
                <tr>
                  <td>401K EMPLOYER MATCH:</td>
                  <td>
                    <span id='summaryEmp' class='summery'><?= $budget['feed']['PERCENTAGE_401K']; ?>%</span>
                  </td>
                </tr>
                <tr>
                  <td>COMPANY ALLOCATION:</td>
                  <td>
                    <span id='summaryEmp' class='summery'><?= $budget['feed']['ALLOC_TOTAL']; ?>%</span>
                  </td>
                </tr>
              </table>
              <table width='100%' id='summaryAddPeriodTotals' class="table table-striped table-bordered">
                <tr>
                  <th style="width:18%;">&nbsp;</th>
                  <?php for($f=1;$f<13;$f++): ?>
                    <th><?= $fiscal[0]['P_'.$f.'_a']; ?></th>
                  <?php endfor; ?>
                  <th>Total</th>
                </tr>
                <tr>
                  <td>HOURLY RATE</td>
                  <?php for($f=1;$f<13;$f++): ?>
                    <td>
                      <?php if( $budget['fte']['P_'.$f] < 1 && $budget['overtime_hours']['P_'.$f] < 1 && $budget['additional_hours']['P_'.$f] < 1 && $budget['dining_hours']['P_'.$f] < 1): ?>
                        ---
                      <?php else: ?>
                        <?= $budget['hourly_rate']['P_'.$f]; ?>
                      <?php endif; ?>
                    </td>
                  <?php endfor; ?>
                  <td style="text-align:center;">---</td>
                </tr>
                <tr>
                  <td>FTE</td>
                  <?php for($f=1;$f<13;$f++): ?>
                    <td><?= $budget['fte']['P_'.$f]; ?></td>
                  <?php endfor; ?>
                  <td style="text-align:center;">---</td>
                </tr>
                <tr>
                  <td>OVERTIME</td>
                  <?php for($f=1;$f<13;$f++): ?>
                    <td><?= $budget['overtime_hours']['P_'.$f]; ?></td>
                  <?php endfor; ?>
                  <td><?= array_sum($budget['overtime_hours']); ?></td>
                </tr>
                <tr>
                  <td>CA PLUS HOURS</td>
                  <?php for($f=1;$f<13;$f++): ?>
                    <td><?= $budget['additional_hours']['P_'.$f]; ?></td>
                  <?php endfor; ?>
                  <td><?= array_sum($budget['additional_hours']); ?></td>
                </tr>
                <tr>
                  <td>DINING HOURS</td>
                  <?php for($f=1;$f<13;$f++): ?>
                    <td><?= $budget['dining_hours']['P_'.$f]; ?></td>
                  <?php endfor; ?>
                  <td><?= array_sum($budget['dining_hours']); ?></td>
                </tr>
                <tr>
                  <td>ELIGIBLE MEALS</td>
                  <?php for($f=1;$f<13;$f++): ?>
                    <td><?= $budget['employee_meals']['P_'.$f]; ?></td>
                  <?php endfor; ?>
                  <td><?= array_sum($budget['employee_meals']); ?></td>
                </tr>
                <?php if( (int) $budget['budget']['companyTypeID'] == 2 ): ?>
                  <tr>
                    <td>DEVELOPMENT BONUS</td>
                    <?php for($f=1;$f<13;$f++): ?>
                      <td><?= $budget['development_bonus']['P_'.$f]; ?></td>
                    <?php endfor; ?>
                    <td><?= array_sum($budget['development_bonus']); ?></td>
                  </tr>
                <?php endif; ?>
                <tr>
                  <td>MONTHLY STIPEND</td>
                  <?php for($f=1;$f<13;$f++): ?>
                      <?php if((int)$budget['valid_stipend_periods']['P_'.$f] > 0) : ?>
                        <td><?= $budget['monthly_stipend']['P_'.$f]; ?></td>
                      <?php else: ?>
                        <td style="text-align:center;">---</td>
                      <?php endif; ?>
                    </td>
                  <?php endfor; ?>
                  <?php if( (float)array_sum($budget['monthly_stipend']) > 0 ): ?>
                    <td><?= array_sum($budget['monthly_stipend']); ?></td>
                  <?php else: ?>
                    <td style="text-align:center;">---</td>
                  <?php endif; ?>
                </tr>
              </table>
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
                  <td><input type="text" class="NAME"  id="NAME" value="<?= $budget['feed']['NAME']; ?>" /></td>
                </tr>
                <tr>
                  <td><label>EMPLOYMENT STATUS</td>
                  <td>
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
                          $bStatus = "checke";
                          break;
                      } // end switch 
                    ?>
                    <label class="radio inline">
                      <input type="radio" name="FULL_PART" value="F" <?= $fStatus; ?> /> Full-Time
                    </label>
                    <label class="radio inline">
                      <input type="radio" name="FULL_PART" value="P" <?= $pStatus; ?> /> Part-Time
                    </label>
                    <label class="radio inline">
                      <input type="radio" name="FULL_PART" value="B" <?= $bStatus; ?> /> Part-Time with Benefits
                    </label>
                  </td>
                </tr>
                <tr>
                  <td><label for="START_DATE">Budget Start Date:</label></td>
                  <td>
                    <div class="input-append date" id="dp3" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                      <?php
                        $START_DATE = $budget['feed']['START_DATE'];
                        $js_startDate = 'class="datepicker" id="START_DATE"';
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
                <tr id="endDateRow" class="well">
                  <td style="text-align:right;">End Date:</td>
                  <td>
                    <div id="opt_EndDate" class="input-append date" id="dp4" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                      <?php
                        $REHIRE_DATE = $budget['feed']['REHIRE_DATE'];
                        $js_endDate = 'class="datepicker" id="REHIRE_DATE"';
                        echo form_input('REHIRE_DATE',$REHIRE_DATE,$js_endDate);
                      ?>
                      <span class="add-on"><i class="icon-calendar"></i></span>
                    </div>
                  </td>
                </tr>
                <tr><td colspan="2"><br>&nbsp;<br></td></tr>
                <tr><td colspan="2">
                  <span style="font:bold 11px verdana; color:#DC241F; width:80%;">
                    NOTE: If you need to budget overtime hours or meals for this employee, you must answer yes to the applicable question below. To budget overtime hours, select the <u>Work Hours Information</u> panel located in the menu to the left. To budget meals, select the <u>Dining Information</u> panel located in the menu to the left. If these choices are not currently visible, they will only appear in the menu to the left once you answer YES to each question below.
                  </span>
                </td></tr>
                <tr><td colspan="2"><br>&nbsp;<br></td></tr>
                <?php
                   if( $budget['feed']['HAS_OVERTIME'] == "Y" ){
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
                      <input type="radio" name="hasOvertime" <?= $yOvertime; ?> value="Y"> Yes
                    </label>
                    <label class="radio inline">
                      <input type="radio" name="hasOvertime" <?= $nOvertime; ?> value="N"> No
                    </label>
                  </td>
                </tr>
                <tr>
                  <td><label>Is this employee eligible for free meals?</label></td>
                  <td>
                    <label class="radio inline">
                      <input type="radio" name="isMealEligible" <?= $yMeals; ?> value="Y"> Yes
                    </label>
                    <label class="radio inline">
                      <input type="radio" name="isMealEligible" <?= $nMeals; ?> value="N"> No
                    </label>
                  </td>
                </tr>
              </table>
            </div> <!-- END employee_information -->
    <!--/*~~~~~~~~~~~~~ SALARY INFORMATION ~~~~~~~~~~~~~~~*/-->
            <div id="salary_information" style="display:none;">
              <h3 style="text-align:center;background-color:#1b6633;color:#FFFFFF;">
                SALARY INFORMATION
              </h3>
              <hr>
              <table class="table-striped" style="width:90%;margin:0 auto;">
                <tr><td colspan="2">
                  <span style="font:bold 11px verdana; color:#DC241F; width:80%;">
                    NOTE: P.A.M. operates on ALL employees based on an hourly salary calculation. Rounding may occur.  
                  </span>
                </td></tr>
                <tr><td colspan="2">&nbsp;</td></tr>
                <tr>
                  <td style="width:40%;"><label>Salary Type:</label></td>
                  <td style="width:60%;">
                    <?php 
                      if( $budget['feed']['EE_TYPE'] == "S" ){
                        $sEEType = "checked";
                        $mEEType = "";
                        $hEEType = "";
                      } elseif($budget['feed']['EE_TYPE'] == "M"){
                        $sEEType = "";
                        $mEEType = "checked";
                        $hEEType = "";
                      } else {
                        $sEEType = "";
                        $mEEType = "";
                        $hEEType = "checked";
                      } // end if 
                    ?>
                    <label class="radio inline">
                      <input type="radio" name="EE_TYPE" class='EET' <?= $sEEType; ?> value="S" /> Salaried
                    </label>
                    <label class="radio inline">
                      <input type="radio" name="EE_TYPE" class='EET' <?= $mEEType; ?> value="M" /> Stipended
                    </label>
                    <label class="radio inline">
                      <input type="radio" name="EE_TYPE" class='EET' <?= $hEEType; ?> value="H" /> Hourly
                    </label>
                  </td>
                </tr>
                <?php
                  //Salary Type
                  $figAnnie = $budget['feed']['HOURLY_RATE'] * 2080;
                  $annieRate = number_format($figAnnie,2);
                 
                  $hrlyRate = number_format($budget['feed']['HOURLY_RATE'],2);
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
                <tr><td colspan="2">&nbsp;</td></tr>
                <tr>
                  <td><a id="btnSalAdjuster" class="btn" href=""><i class="icon-plus-sign"></i> Add Salary Adjustment</a></td>
                  <td>&nbsp;</td>
                </tr>
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
                  <tr><td colspan="2">
                    <?php
                      $curr_year = $this->globals_m->current_year();
                      $stipend_periods = $this->budget_m->get_employee_totals($budget['feed']['EMP_ID'], $curr_year, 'VSM');
                      $stipend_amounts = $this->budget_m->get_employee_totals($budget['feed']['EMP_ID'], $curr_year, 'PSA');
                    ?>
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
                              <?= form_input('CA_MO_STIPEND_P_'.$f, $stipend_amounts[0]['P_'.$f], 'class="span1"'); ?>
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
                              <?= form_input('CA_MO_STIPEND_P_'.$f, $stipend_amounts[0]['P_'.$f], 'class="span1"'); ?>
                            </div>
                          </td>
                        <?php endfor; ?>
                      </tr>
                    </table>
                  </td></tr>
                  <tr><td colspan="2">&nbsp;</td></tr>
                  <?php
                    if($budget['feed']['CA_RAD'] == 'Y'){
                      $yCARAD = "checked";
                      $nCARAD = "";
                    } else {
                      $yCARAD = "";
                      $nCARAD = "checked";
                    } // end if}
                  ?>
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
                <tr><td colspan="2">&nbsp;</td></tr>
                <tr class="rowCA__RAD" style="display:none;"><td colspan="2"><b>CA/RA ADDITIONAL HOURS</b></td></tr>
                <tr class="rowCA__RAD" style="display:none;"><td colspan="2">&nbsp;</td></tr>
                <tr class="rowCA__RAD" style="display:none;">
                  <td><label>Hourly Rate for Additional Hours:</label></td>
                    <td>
                      <div class="input-prepend">
                        <span class="add-on">$</span>
                        <?php
                          $HOURLY_RATE_CA = array(
                               'id' => 'HOURLY_RATE_CA',
                               'name' => 'HOURLY_RATE_CA',
                               'class' => 'HOURLY_RATE_CA',
                               'value' => $hrlyRate
                          );
                          echo form_input($HOURLY_RATE_CA);
                        ?>
                      </div>
                    </td>
                </tr>
                <tr class="rowCA__RAD" style="display:none;">
                  <td colspan="2">
                    <table class="table table-bordered" style="width:90%;margin:0 auto;">
                      <tr>
                        <?php for($f=1;$f<7;$f++): ?>
                          <th><?= $fiscal[0]['P_'.$f.'_a']; ?></th>
                        <?php endfor; ?>
                      </tr>
                      <tr>
                        <?php
                          $CAH = array(array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0)); 
                          $qCAH = $this->budget_m->get_employee_totals($budget['feed']['EMP_ID'], $curr_year, 'CAH'); 
                          if( $qCAH ){ $CAH = $qCAH; }
                          ?>
                        <?php for($f=1;$f<7;$f++): ?>
                          <td>
                            <?= form_input('CA_AH_P_'.$f, $CAH[0]['P_'.$f],'class="span1"'); ?>
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
                            <?= form_input('CA_AH_P_'.$f, $CAH[0]['P_'.$f],'class="span1"'); ?>
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
              <table class="table-striped" style="width:90%;margin:0 auto;">
                <tr>
                  <th style="width:10%;">&nbsp;</th>
                  <th style="width:45%;">FTE<br />( HOURS PER WEEK )</th>
                  <th style="width:45%;">OVERTIME HOURS PER MONTH</th>
                </tr>
                <?php for($y=1;$y<13;$y++): ?>
                  <tr>
                    <td><?= $fiscal[0]['P_'.$y] ?></td>
                    <td>
                      <input type="number" name="FTE_P_<?= $y; ?>" value="<?= $budget['fte']['P_'.$y]; ?>" />
                    </td>
                    <td>
                      <input type="number" name="OVR_P_<?= $y; ?>" value="<?= $budget['overtime_hours']['P_'.$y]; ?>" />
                    </td>
                  </tr>
                <?php endfor; ?>
              </table>
            </div> <!-- END work_hours_information -->
    <!--/*~~~~~~~~~~~~~ DINING INFORMATION ~~~~~~~~~~~~~~~*/-->
            <div id="dining_information" style="display:none;">
              <h3 style="text-align:center;background-color:#1b6633;color:#FFFFFF;">DINING INFORMATION</h3>
              <hr>
              <table class="table-striped" style="width:90%;margin:0 auto;">
                <tr>
                  <td style="width:50%;text-align:center;">
                    DINING EMPLOYEE
                  </td>
                  <td style="width:50%;text-align:center;">
                    MEAL ELIGIBLE
                  </td>
                </tr>
                <tr>
                  <td style="width:50%;text-align:center;">
                    <?php
                      $diningEmp = array('N' => 'No','Y' => 'Yes');
                      $js_diningEmp = 'id="diningEmp" onChange="dining();"';
                      echo form_dropdown('diningEmp',$diningEmp,$budget['feed']['IS_DINING_EMP'],$js_diningEmp);
                    ?>
                  </td>
                  <td style="width:50%;text-align:center;">
                    <?php
                      $mealEligible = array('N' => 'No','Y' => 'Yes');
                      $js_meals = 'id="meals" onChange="dining();"';
                      echo form_dropdown('mealEligible',$mealEligible,$budget['feed']['IS_MEAL_ELIGIBLE'],$js_meals);
                    ?>
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <table id="dhNOM" class="table table-bordered">
                      <tr>
                        <td>&nbsp;</td>
                        <td>DINING HOURS/MONTH</td>
                        <td>NUMBER OF MEALS/MONTH</td>
                      </tr>
                      <?php for($y=1;$y<13;$y++): ?>
                        <tr>
                          <td><?= $fiscal[0]['P_'.$y] ?></td>
                          <td>
                            <input type="number" name="DH_P_<?= $y; ?>" value="<?= $budget['dining_hours']['P_'.$y]; ?>" id="DHP_<?= $y; ?>" class="DINING_HOURS" onChange="validDINING_HOURS()" />
                          </td>
                          <td>
                            <input type="number" name="NOM_P_<?= $y; ?>" value="<?= $budget['dining_hours']['P_'.$y]; ?>" id="NOM_<?= $y; ?>" class="NO_MEALS" />
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
                      $selState = "id='empState'";
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
                      $groupInsJS = "id='groupInsurancePlan'";
                      echo form_dropdown('groupIns',$groupInsurance,$budget['feed']['GRP_INS_TYPE'],$groupInsJS);
                    ?>
                  </td>
                </tr>
                <tr>
                    <td>401K Employee Match Percentage:</td>
                    <td>
                         <select name="cont401k" id = 'k401'>
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
                      $fsaJS = "id='FSA'";
                      echo form_dropdown('FSA',$flex,$budget['feed']['FSA'],$fsaJS);
                    ?>
                 </td>
               </tr>
               <tr>
                <td>Stock Purchase Percentage</td>
                <td>
                  <div class="input-append">
                    <?= form_input('ESPP',$budget['feed']['ESPP']); ?>
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
                      $ESPPD = 0;
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
                    <?php for($y=1;$y<13;$y++): ?>
                      <tr class='oBennie'>
                        <td><?= $fiscal[0]['P_'.$y.'_a']; ?></td>
                        <td>
                          <div class="input-prepend">
                            <span class="add-on">$</span>
                            <input type="text" class="input-mini ADDINSEX" name="ADDINSEX" disabled="disabled" value="<?= $ADDInsEx; ?>" />
                          </div>
                        </td>
                        <td>
                          <div class="input-prepend">
                            <span class="add-on">$</span>
                            <input type="text" class="input-mini FSPE" name="FSPE" disabled="disabled" value="<?= $FSPE; ?>" />
                          </div>
                        </td>
                        <td>
                          <div class="input-prepend">
                            <span class="add-on">$</span>
                            <input type="text" class="input-mini ESPP" name="ESPP" disabled="disabled" value="<?= $ESPP; ?>" />
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
                              <input type="text" class="input-mini ESPPD" name="ESPPD" disabled="disabled" value="0" />
                            </div>
                          </td>
                        <?php endif; ?>
                        <td>
                          <div class="input-append">
                            <span class="add-on">$</span>
                            <input type="text" class="input-mini ADDBEN" name="additional_benefits_P_<?= $y; ?>" value="<?= $budget['additional_benefits']['P_'.$y]; ?>" />
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
                        <input type="text" name="HOME_OFFICE_BONUS_PERCENTAGE" value="<?= $budget['feed']['HOME_OFFICE_BONUS_PERCENTAGE']; ?>" />
                        <span class="add-on">%</span>
                      </div>
                    </td>
                  </tr>
                  <tr><td colspan="2">&nbsp;</td></tr>
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
                  <?php for($y=1;$y<13;$y++): ?>
                    <tr>
                      <td><?= $fiscal[0]['P_'.$y] ?></td>
                      <td>
                        <div class="input-prepend">
                          <span class="add-on">$</span>
                          <input type="number" name="DEV_BONUS_P_<?= $y; ?>" value="<?= $budget['development_bonus']['P_'.$y]; ?>" />
                        </div>
                      </td>
                    </tr>
                  <?php endfor; ?>
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
                      <input type="number" name="ALLOC_TOTAL" value="<?= $budget['feed']['ALLOC_TOTAL']; ?>" />
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
   ( function($) {
      $(document).ready( function() {
        var EMP_ID = "<?= $budget['feed']['EMP_ID']; ?>";
        var EE_TYPE = "<?= $budget['feed']['EE_TYPE']; ?>";
        var CA_AD = "<?= $budget['feed']['CA_RAD']; ?>";
        var a = ["#employee_information","#salary_information","#work_hours_information","#dining_information","#benefits_information","#bonus_information","#allocation_information", "#editSummary"];
        var arrayOfScreens = a.join(", ");
        var fig = 0;
        //alert(EE_TYPE);

        $('.btnNav').click(function(){
          var id = $(this).attr('id');
          var nme = '#' + id.replace('btn_', '');
          $(arrayOfScreens).hide();
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

        $('#btnCancelEdit').on('click', function(e){
          var answer = confirm('You have entered new data that has not yet been saved or submitted to the server. If you click "OK" below, this data will be lost. Click "Cancel" to stay on the current page.');
          if (answer) {
            window.location = "<?= site_url('pam_budget/budget/'.$budget['feed']['BUDGET_ID']); ?>";  
          } // end if
          return false;
        }); // end btnCancel

        $('#submitToPM').on('click', function(e){
          $('#frmEditEmp').submit();
          //var farm = $('#frmEditEmp').serialize();
          //alert(farm);
        }); // end submitToPM

        $('.datepicker').datepicker({ minDate: 0 });
        dining();

        if( $('input[name=radRehireDate]:checked').val() == 'N'){
          $('#endDateRow').hide();
        } // end if

        $('.ADDBEN').blur(function(e){
          total_benny();
        }).blur();

      })(); // end document ready
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
        $('#dhNOM tr').find('td:eq(0)').hide();
        $('#dhNOM tr').find('td:eq(1)').hide();
      }//endif
      
      if(mealsDD == 'N') {
        $('#dhNOM tr').find('td:eq(0)').hide();
        $('#dhNOM tr').find('td:eq(2)').hide();
      }//endif
      
      if(diningDD == 'Y') {
        $('#dhNOM tr').find('td:eq(0)').show();
        $('#dhNOM tr').find('td:eq(1)').show();
      }//endif
      
      if(mealsDD == 'Y') {
        $('#dhNOM tr').find('td:eq(0)').show();
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
        
        toto = adnd + FSPE + ESPP + ESPPD + ADDBEN;
        grtoto += toto;

        $(this).find('.brTot').val( formatCurrency(toto) );
      }); 

      $('.ADDBEN').each(function(){
        totAddBen += parseFloat(this.value);
      });

      $('#totADDBEN').val( formatCurrency(totAddBen));
      $('#totGrand').val( formatCurrency(grtoto));
    } // end total_benny function
  } ) ( jQuery );
</script>
</body>
</html>
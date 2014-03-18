<?php $curr_year = $this->globals_m->current_year(); ?>
<?php $fiscal = $this->fiscal_m->get_fiscal_info($budget['budget']['fiscalStart']); ?>
<h3 style="text-align:center;background-color:#1b6633;color:#FFFFFF;">EMPLOYEE SUMMARY</h3>
<hr>

<table class="table-striped" style="width:90%;margin:0 auto;">
    <tr>
    <td style="width:45%; text-align:left;">COMPANY:</td>
    <td style="width:55%; text-align:left;">
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
    <td>ANNUAL SALARY (INITIAL / BUDGETED):</td>
    <td>
      <?php 
        $tSal = $this->budget_m->get_salary_periods_from_pmout($budget['feed']['EMP_ID'],$curr_year );
        $aSal = $this->budget_m->get_salary_adjustments($budget['feed']['EMP_ID']);
        if( !$aSal ){ 
          $newHourly = $budget['feed']['ADJUSTED_HOURLY_RATE']; 
        } else {
          $newHourly = $aSal[0]['P_12'];
        } // end if
      ?> 
      <span id='summaryEmp' class='summery'>
        <?php if($budget['feed']['EE_TYPE'] == 'S' ){
          echo '$' . number_format($budget['feed']['ANNUAL_RATE'],2,'.',',');
        } elseif($budget['feed']['EE_TYPE'] == 'M'){
          echo '$' . number_format($budget['feed']['STIPEND_AMOUNT']*12,2,'.',',');
        } else {
          echo '$' . number_format($budget['feed']['HOURLY_RATE']*2080,2,'.',',');
        } // end if ?>
      </span> / 
      <span id='summaryEmp' class='summery'>
        <?php
          if( !$tSal ):
            echo "Refresh to see value.";
          else:
            echo '$'.number_format($newHourly*2080,2,'.',',');
          endif;
        ?>
      </span>
    </td>
  </tr>
  <tr>
    <td>HOURLY SALARY (INITIAL / BUDGETED):</td>
    <td>
      <span id='summaryEmp' class='summery'>
        $<?= number_format($budget['feed']['HOURLY_RATE'],2,'.',','); ?>
      </span> / 
      <span id='summaryEmp' class='summery'>
        $<?= number_format($newHourly,2,'.',','); ?>
      </span>
    </td>
  </tr>
  <tr>
    <td>CORPORATE OFFICE BONUS:</td>
    <td>
      <span id='summaryEmp' class='summery'>
        <?= $budget['feed']['HOME_OFFICE_BONUS_PERCENTAGE']; ?>%
      </span>
    </td>
  </tr>
  <tr>
    <td>GROUP INSURANCE PLAN / EXPENSE:</td>
    <td>
      <span id='summaryEmp' class='summery'>
        <?= $budget['feed']['GRP_INS_TYPE']; ?>
      </span> / 
      <span id='summaryEmp' class='summery'>
        $<?= number_format($budget['feed']['GRP_INS_MONTHLY_EXPENSE'],2,'.',','); ?>
      </span>
    </td>
  </tr>
  <tr>
    <td>401K EMPLOYER MATCH:</td>
    <td>
      <span id='summaryEmp' class='summery'>
        <?= $budget['feed']['PERCENTAGE_401K']; ?>%
      </span>
    </td>
  </tr>
  <tr>
    <td>COMPANY ALLOCATION:</td>
    <td>
      <span id='summaryEmp' class='summery'>
        <?= $budget['feed']['ALLOC_TOTAL']; ?>%
      </span>
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
    <td>HOURLY RATE</td>
    <?php for($f=1;$f<13;$f++): ?>
      <td style="text-align:center;">
        <?php if( $budget['fte']['P_'.$f] < 1 && $budget['overtime_hours']['P_'.$f] < 1 && $budget['additional_hours']['P_'.$f] < 1 && $budget['dining_hours']['P_'.$f] < 1): ?>
          -
        <?php else: ?>
          <?= ($budget['hourly_rate']['P_'.$f] == 0) ? '-' : number_format($budget['hourly_rate']['P_'.$f],2); ?>
        <?php endif; ?>
      </td>
    <?php endfor; ?>
    <td style="text-align:center;">-</td>
  </tr>
  <tr>
    <td>FTE</td>
    <?php for($f=1;$f<13;$f++): ?>
      <td style="text-align:center;">
        <?= ($budget['fte']['P_'.$f] == 0) ? '-' : $budget['fte']['P_'.$f]; ?>
      </td>
    <?php endfor; ?>
    <td style="text-align:center;">-</td>
  </tr>
  <tr>
    <td>OVERTIME</td>
    <?php for($f=1;$f<13;$f++): ?>
      <td style="text-align:center;">
        <?= ($budget['overtime_hours']['P_'.$f] == 0) ? '-' : $budget['overtime_hours']['P_'.$f]; ?>
      </td>
    <?php endfor; ?>
    <td style="text-align:center;">
      <?= (array_sum($budget['overtime_hours']) == 0) ? '-' : array_sum($budget['overtime_hours']); ?>
    </td>
  </tr>
  <tr>
    <td>CA PLUS HOURS</td>
    <?php for($f=1;$f<13;$f++): ?>
      <td style="text-align:center;">
        <?= ($budget['additional_hours']['P_'.$f] == 0) ? '-' : $budget['additional_hours']['P_'.$f]; ?>
      </td>
    <?php endfor; ?>
    <td style="text-align:center;">
      <?= (array_sum($budget['additional_hours']) == 0) ? '-' : array_sum($budget['additional_hours']); ?>
    </td>
  </tr>
  <tr>
    <td>DINING HOURS</td>
    <?php for($f=1;$f<13;$f++): ?>
      <td style="text-align:center;">
        <?= ($budget['dining_hours']['P_'.$f] == 0) ? '-' : $budget['dining_hours']['P_'.$f]; ?>
      </td>
    <?php endfor; ?>
    <td style="text-align:center;">
      <?= (array_sum($budget['dining_hours']) == 0) ? '-' : array_sum($budget['dining_hours']); ?>
    </td>
  </tr>
  <tr>
    <td>ELIGIBLE MEALS</td>
    <?php for($f=1;$f<13;$f++): ?>
      <td style="text-align:center;">
        <?= ($budget['employee_meals']['P_'.$f] == 0) ? '-' : $budget['employee_meals']['P_'.$f]; ?>
      </td>
    <?php endfor; ?>
    <td style="text-align:center;">
      <?= (array_sum($budget['employee_meals']) == 0) ? '-' : array_sum($budget['employee_meals']); ?>
    </td>
  </tr>
  <?php if( (int) $budget['budget']['companyTypeID'] == 2 ): ?>
    <tr>
      <td>DEVELOPMENT BONUS</td>
      <?php for($f=1;$f<13;$f++): ?>
        <td style="text-align:center;">
          <?= ($budget['development_bonus']['P_'.$f] == 0) ? '-' : number_format($budget['development_bonus']['P_'.$f],2); ?>
        </td>
      <?php endfor; ?>
      <td style="text-align:center;">
        <?= (array_sum($budget['development_bonus']) == 0) ? '-' : number_format(array_sum($budget['development_bonus']),2); ?>
      </td>
    </tr>
  <?php endif; ?>
  <tr>
    <td>MONTHLY STIPEND</td>
    <?php for($f=1;$f<13;$f++): ?>
        <?php if((int)$budget['valid_stipend_periods']['P_'.$f] > 0) : ?>
          <td style="text-align:center;">
            <?= ($budget['monthly_stipend']['P_'.$f] == 0) ? '-' : number_format($budget['monthly_stipend']['P_'.$f],2); ?>
          </td>
        <?php else: ?>
          <td style="text-align:center;">-</td>
        <?php endif; ?>
      </td>
    <?php endfor; ?>
    <?php if( (float)array_sum($budget['monthly_stipend']) > 0 ): ?>
      <td style="text-align:center;"><?= number_format(array_sum($budget['monthly_stipend']),2); ?></td>
    <?php else: ?>
      <td style="text-align:center;">-</td>
    <?php endif; ?>
  </tr>
</table>
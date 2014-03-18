<?php $fiscal = $this->fiscal_m->get_fiscal_info($budget['budget']['fiscalStart']); ?>
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
    <td><label>Salary Type:</label></td>
    <td>
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
    <td>Hourly Rate:</td>
    <td>
      <label name='HOURLY_RATE'>
        $<?php echo $hrlyRate; ?>
      </label>
    </td>
  </tr>
  <tr>
    <td>Monthly Base Stipend:</td>
    <td>
      <label name='MONTHLY_BASE'>
        $<?= $budget['feed']['STIPEND_AMOUNT']; ?>
      </label>
    </td>
  </tr>
  <tr><td colspan="2">&nbsp;</td></tr>
  <tr>
    <td colspan="2" style="text-align:center;">
      <b>SALARY ADJUSTMENTS</b>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <div id="committedAdjustments">
        <table class="table table-bordered" style="width:100%;">
          <tr>
            <th style="width:8%;">PERIOD</th>
            <th style="width:24%;">ADJUSTMENT AMOUNT</th>
            <th style="width:24%;">ADJUSTMENT PERCENTAGE</th>
            <th style="width:24%;">HOURLY WAGE</th>
            <th style="width:18%;">&nbsp;</th>
          </tr>
          <?php 
            $sala = $this->budget_m->get_salary_adjustments($budget['feed']['EMP_ID']);

            if($sala): 
              $osal = $budget['feed']['HOURLY_RATE'];
              //var_dump($osal);
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
              //echo "<br><br>";
              //print_r($adden);
              foreach( $adden as $ad ){
                echo "<tr>";
                echo "<td>".$fiscal[0]['P_'.$ad['period']]."</td>";
                echo "<td>$".number_format($ad['hourly'],2)."/hour</td>";
                echo "<td>".number_format($ad['percent'],2)."%</td>";
                echo "<td>$".number_format($ad['wage'],2)."</td>";
                echo "<td style='text-align:center;'><a class='btn btn-edr btnDeleteAdj' data-period='".$ad['period']."'>DELETE</a></td>";
                echo "</tr>";
              } // end foreach
          ?>
            <?php endif; ?>
        </table>
      </div>
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
        <div id="salAdjInputD" class="input-prepend" style="display:none;">
          <span class="add-on">$</span>
          <input class="span1" name="salAdjDollars" type="text">
        </div>
      </div>&nbsp;&nbsp;
      <a id="btnSubmitAdjustment" class="btn btn-edr">ADD</a>
    </td>
  </tr>
  <tr><td colspan="2">&nbsp;</td></tr>
  
</table>
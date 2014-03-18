<?php
  if( in_array((int)$primary->companyTypeID, array(4,6)) ){
    $dining = TRUE;
  } else {
    $dining = FALSE;
  } // end if
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>P.A.M. -- Edit Bonuses</title>

	<link href="<?= base_url('assets/css/bootstrap.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/bootstrap-responsive.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/font-awesome.css'); ?>" rel="stylesheet">
  <link href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet">
	<link href="<?= base_url('assets/css/site.css'); ?>" rel="stylesheet">

  <style>
    #control_panel{ position:fixed; bottom:0;}
    th{text-align:left;}
    .oneInput, .twoInput{
      width:50px;
      text-align:center;
    }
    .oneColTotal, .twoColTotal, .screenOneTotal, .screenTwoTotal{ font-weight: bold; text-align:center; }
    #totScreenOne, #totScreenTwo{ width:100px; font-weight: bold; text-align:center; }
  </style>

	<!--[if IE 7]>
		<link rel="stylesheet" href="<?= base_url('assets/css/font-awesome-ie7.min.css'); ?>">
	<![endif]-->
	<!--[if lt IE 9]>  
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>  
    <![endif]-->
</head>

<body>
  <?php
    $LIB = $this->budget_m->get_staffing_bonus($primary->id, 'LIB' );
    if( count($LIB) == 0 ){
      $LIB = array(array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0));
    }// end if
    $RPI = $this->budget_m->get_staffing_bonus($primary->id, 'RPI' );
    if( count($RPI) == 0 ){
      $RPI = array(array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0));
    }// end if
    $LMB = $this->budget_m->get_staffing_bonus($primary->id, 'LMB' );
    if( count($LMB) == 0 ){
      $LMB = array(array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0));
    }// end if
    $DMB = $this->budget_m->get_staffing_bonus($primary->id, 'DMB' );
    if( count($DMB) == 0 ){
      $DMB = array(array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0));
    }// end if
    $RMB = $this->budget_m->get_staffing_bonus($primary->id, 'RMB' );
    if( count($RMB) == 0 ){
      $RMB = array(array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0));
    }// end if
    $IAI = $this->budget_m->get_staffing_bonus($primary->id, 'IAI' );
    if( count($IAI) == 0 ){
      $IAI = array(array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0));
    }// end if
    $CMB = $this->budget_m->get_staffing_bonus($primary->id, 'CMB' );
    if( count($CMB) == 0 ){
      $CMB = array(array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0));
    }// end if
  ?>
  <div class="container" style="margin-top:10px;border-top:5px solid #1b6633;">
    <h2 align="center">STAFFING BONUS EDIT</h2><br><br>
    <?php //print_r($primary); ?><br><br>
    <div class="span12">
      <div id="bonusScreenOne" class="row">
        <?= form_open('pam_budget/edit_property_bonus_handler'); ?>
        <?= form_hidden('BUDGET_ID', $primary->id); ?>
        <table style="width:60%;margin:0 auto;">
          <tr>
            <th style='width:20%;'>&nbsp;</th>
            <th style='width:20%;'>Leasing<br>Incentive<br>Bonus</th>
            <th style='width:20%;'>Renewal<br>Pool<br>Incentive</th>
            <th style='width:20%;'>Leasing/<br>Marketing<br>Manager</th>
            <?php if( $dining ): ?>
              <th style='width:20%;'>Dining<br>Manager<br>Bonus</th>
            <?php endif; ?>
            <th style='width:20%;'><span style="color:#DC241F;"><b>TOTAL</b></span></th>
          </tr>
          <?php for($b=1;$b<13;$b++): ?>
            <?php
              $lib_input = array('name'=>'LIB'.$b,'value'=>$LIB[0]['P_'.$b],'class'=>'oneInput row'.$b);
              $rpi_input = array('name'=>'RPI'.$b,'value'=>$RPI[0]['P_'.$b],'class'=>'oneInput row'.$b);
              $lmb_input = array('name'=>'LMB'.$b,'value'=>$LMB[0]['P_'.$b],'class'=>'oneInput row'.$b);
              $dmb_input = array('name'=>'DMB'.$b,'value'=>$DMB[0]['P_'.$b],'class'=>'oneInput row'.$b);
            ?>
            <tr>
              <td><?= form_label($fiscal[0]['P_'.$b]); ?></td>
              <td><?= form_input($lib_input); ?></td>
              <td><?= form_input($rpi_input); ?></td>
              <td><?= form_input($lmb_input); ?></td>
              <?php if( $dining ): ?>
                <td><?= form_input($dmb_input); ?></td>
              <?php endif; ?>
              <td><input type="text" disabled="disabled" class="screenOneTotal" size="30" style="width:50px;text-alignment:center;"></td>
            </tr>
          <?php endfor; ?>
          <tr>
            <td><span style="color:#DC241F;"><b>TOTAL</b></span></td>
            <td><input type="text" disabled="disabled" id="totLIB" name="totLIB" size="30" class="oneColTotal" style="width:50px;text-alignment:center;"></td>
            <td><input type="text" disabled="disabled" id="totRPI" name="totRPI" size="30" class="oneColTotal" style="width:50px;text-alignment:center;"></td>
            <td><input type="text" disabled="disabled" id="totLMB" name="totLMB" size="30" class="oneColTotal" style="width:50px;text-alignment:center;"></td>
            <?php if( $dining ): ?>
              <td><input type="text" disabled="disabled" id="totDMB" name="totDMB" size="30" class="oneColTotal" style="width:50px;text-alignment:center;"></td>
            <?php endif; ?>
              <td><input type="text" disabled="disabled" id="totScreenOne" name="totScreenOne" size="30" style="width:50px;text-alignment:center;color:#DC241F;"></td>
          </tr>
          <tr><td colspan=5>&nbsp;<br><br></td></tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="4">
              <button type="reset" class="btn btn-large" name="btnCancel" id="btnCancel">
                <i class="icon-remove"></i> Cancel
              </button>
              &nbsp;&nbsp;
              <button type="submit" class="btn btn-large btn-edr" name="sOneNext" id="sOneNext">
                <i class="icon-chevron-right"></i> Next
              </button>
            </td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </div>
      <div id="bonusScreenTwo" class="row" style="display:none;">
        <table style="width:70%;margin:0 auto;">
          <tr>
            <th style='width:20%;'>&nbsp;</th>
            <th style='width:20%;'>Resident<br>Services<br>Manager</th>
            <th style='width:20%;'>Internal<br>Audit<br>Incentive</th>
            <th style='width:20%;'>Community<br>Manager<br>Bonus</th>
            <th style='width:20%;'><span style="color:#DC241F;"><b>TOTAL</b></span></th>
          </tr>
          <?php for($b=1;$b<13;$b++): ?>
          <?php
            $rmb_input = array('name'=>'RMB'.$b,'value'=>$RMB[0]['P_'.$b],'class'=>'twoInput row'.$b);
            $iai_input = array('name'=>'IAI'.$b,'value'=>$IAI[0]['P_'.$b],'class'=>'twoInput row'.$b);
            $cmb_input = array('name'=>'CMB'.$b,'value'=>$CMB[0]['P_'.$b],'class'=>'twoInput row'.$b, 'disabled' => 'disabled');
          ?>
            <tr>
              <td><?= form_label($fiscal[0]['P_'.$b]); ?></td>
              <td><?= form_input($rmb_input); ?></td>
              <td><?= form_input($iai_input); ?></td>
              <td><?= form_input($cmb_input); ?></td>
              <td><input type="text" disabled="disabled" class="screenTwoTotal" size="30" style="width:50px;text-alignment:center;"></td>
            </tr>
          <?php endfor; ?>
          <tr>
            <td><span style="color:#DC241F;"><b>TOTAL</b></span></td>
            <td><input type="text" disabled="disabled" id="totRMB" name="totRMB" class="twoColTotal" size="30" style="width:50px;text-alignment:center;"></td>
            <td><input type="text" disabled="disabled" id="totIAI" name="totIAI" class="twoColTotal" size="30" style="width:50px;text-alignment:center;"></td>
            <td><input type="text" disabled="disabled" id="totCMB" name="totCMB" class="twoColTotal" size="30" style="width:50px;text-alignment:center;"></td>
            <td><input type="text" disabled="disabled" id="totScreenTwo" name="totScreenTwo" class="screenTwoTotal" size="30" style="width:50px;text-alignment:center;color:#DC241F;"></td>
          </tr>
          <tr><td colspan=5>&nbsp;<br><br></td></tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="4">
              <button type="reset" class="btn btn-large" name="sTwoBack" id="sTwoBack">
                <i class="icon-chevron-left"></i> Back
              </button>
              &nbsp;&nbsp;
              <button type="submit" class="btn btn-large btn-edr" name="btnSubmit" id="btnSubmit">
                <i class="icon-ok icon-white"></i> Submit
              </button>
            </td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <?= form_close(); ?>
      </div>
    </div>
  </div> <!-- END . container -->

<script src="<?= base_url('assets/js/jquery-1.9.0.min.js'); ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/bootstrap.js'); ?>" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js" type="text/javascript"></script>
<script type="text/javascript">

  (function() {
    $('.btnDelete').on('click', function(e){
      if( !confirm("Are you sure you want to delete this?")) { 
        return false;
      } // end if
    }); // end btnDelete

    $('#sOneNext').on('click',function(e){
      e.preventDefault();
      $('#bonusScreenOne').fadeOut('slow', function(){
        $('#bonusScreenTwo').fadeIn('slow');
      });
    }); // end #sOneBack click

    $('#sTwoBack').on('click',function(e){
      e.preventDefault();
      $('#bonusScreenTwo').fadeOut('slow', function(){
        $('#bonusScreenOne').fadeIn('slow');
      });
    }); // end #sTwoBack click

    $('#btnCancel').on('click',function(e){
      var lynx = "<?= site_url('pam_budget/budget/'.$budget[0]['BUDGET_ID']); ?>";
      window.location = lynx;
    }); // end btnCancel

    $(".oneInput").blur(function(){
      // Tally Row
      var thisRow = $(this).closest('tr');
      var rowTotal = 0;
      thisRow.find('input.oneInput').each(function() {
          var n = parseFloat(this.value);
          if(!isNaN(n))
              rowTotal += n;
        });
       $(this).parent().parent().find( 'input.screenOneTotal').empty().val( rowTotal );
       
       // Tally Column
       var colName = $(this).attr('name');
       var col = colName.substr(0,3);
       var spanName = "input#tot"+col;
       var tot = parseInt($("input[name='"+col+"1']").val())+parseInt($("input[name='"+col+"2']").val())+parseInt($("input[name='"+col+"3']").val())+parseInt($("input[name='"+col+"4']").val())+parseInt($("input[name='"+col+"5']").val())+parseInt($("input[name='"+col+"6']").val())+parseInt($("input[name='"+col+"7']").val())+parseInt($("input[name='"+col+"8']").val())+parseInt($("input[name='"+col+"9']").val())+parseInt($("input[name='"+col+"10']").val())+parseInt($("input[name='"+col+"11']").val())+parseInt($("input[name='"+col+"12']").val());
       $(spanName).empty().val(tot);
       
       //GRAND TOTAL
       var gTotalOne = parseInt($("#totLIB").val())+parseInt($("#totRPI").val())+parseInt($("#totLMB").val());
       $("#totScreenOne").empty().val( gTotalOne );
    }).blur(); // end inputOne blur

    $(".twoInput").blur(function(){
      // Tally Row
      var thisRow = $(this).closest('tr');
      var rowTotal = 0;
      thisRow.find('input.twoInput').each(function() {
          var n = parseFloat(this.value);
          if(!isNaN(n))
              rowTotal += n;
        });
       $(this).parent().parent().find( 'input.screenTwoTotal').empty().val( rowTotal );
       
       // Tally Column
       var colName = $(this).attr('name');
       var col = colName.substr(0,3);
       var spanName = "input#tot"+col;
       var tot = parseInt($("input[name='"+col+"1']").val())+parseInt($("input[name='"+col+"2']").val())+parseInt($("input[name='"+col+"3']").val())+parseInt($("input[name='"+col+"4']").val())+parseInt($("input[name='"+col+"5']").val())+parseInt($("input[name='"+col+"6']").val())+parseInt($("input[name='"+col+"7']").val())+parseInt($("input[name='"+col+"8']").val())+parseInt($("input[name='"+col+"9']").val())+parseInt($("input[name='"+col+"10']").val())+parseInt($("input[name='"+col+"11']").val())+parseInt($("input[name='"+col+"12']").val());
       $(spanName).empty().val(tot);
       
       //GRAND TOTAL
       var gTotalTwo = parseInt($("#totRMB").val())+parseInt($("#totIAI").val())+parseInt($("#totCMB").val());
       $("#totScreenTwo").empty().val(gTotalTwo);
    }).blur(); // end inputTwo blur
  })();

  

</script>

</body>
</html>
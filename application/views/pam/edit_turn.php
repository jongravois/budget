<?php
  if( count($turn_num) == 0 ){
    $turn_num = array(array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0));
  }// end if
  if( count($turn_sal) == 0 ){
    $turn_sal = array(array('P_1'=>0,'P_2'=>0,'P_3'=>0,'P_4'=>0,'P_5'=>0,'P_6'=>0,'P_7'=>0,'P_8'=>0,'P_9'=>0,'P_10'=>0,'P_11'=>0,'P_12'=>0));
  }// end if
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>P.A.M. -- Edit Turn Employees</title>

	<link href="<?= base_url('assets/css/bootstrap.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/bootstrap-responsive.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/font-awesome.css'); ?>" rel="stylesheet">
  <link href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet">
	<link href="<?= base_url('assets/css/site.css'); ?>" rel="stylesheet">

  <style>#control_panel{ position:fixed; bottom:0;}th{text-align:left;}</style>

	<!--[if IE 7]>
		<link rel="stylesheet" href="<?= base_url('assets/css/font-awesome-ie7.min.css'); ?>">
	<![endif]-->
	<!--[if lt IE 9]>  
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>  
    <![endif]-->
</head>
<body>
  <div class="container" style="margin-top:10px;border-top:5px solid #1b6633;">
    <div class="row">
      <div class="span12">
        <div class="row" style="text-align:center;">
          <h1>TURN EMPLOYEES</h1>
        </div> <!-- END .row -->
        <div class="row">
          <?php //print_r($budget); ?>
          <br><br>
          <?= form_open('pam_budget/edit_turn_handler'); ?>
          <table style="width:50%;margin:0 auto;">
            <tr>
              <th>MONTH</th>
              <th># Employees</th>
              <th>Total Amount For All Employees</th>
            </tr>
            <?php for($f=1;$f<13;$f++): ?>
            <?php 
              $num_input = array('name'=>'num_P_'.$f,'id'=>'num_P_'.$f,'value'=>$turn_num[0]['P_'.$f],'size'=>'30','style'=>'width:50px;text-align:center;');
              $sal_input = array('name'=>'sal_P_'.$f,'id'=>'sal_P_'.$f,'value'=>$turn_sal[0]['P_'.$f],'size'=>'70','style'=>'width:120px;text-align:right;');
              $btnCancel = array('name'=>'btnCancel','id'=>'btnCancel','value'=>'Cancel','class'=>'btn');
              $btnSubmit = array('name'=>'btnSubmit','id'=>'btnSubmit','value'=>'Save Turn','class'=>'btn btn-edr');
             ?>
              <tr>
                <td><?= form_label($fiscal[0]['P_'.$f]); ?></td>
                <td>
                  <?= form_input($num_input); ?></td>
                <td>
                  <div class="input-prepend input-append">
                    <span class="add-on">$</span>
                    <?= form_input($sal_input); ?>
                    <span class="add-on">.00</span>
                  </div>
                </td>
              </tr>
            <?php endfor; ?>
              <tr>
                <td colspan="3">
                  <br><br>
                  <button type="reset" class="btn" name="btnCancel" id="btnCancel">
                    <i class="icon-remove"></i> Cancel
                  </button>
                  &nbsp;&nbsp;&nbsp;
                  <button type="submit" class="btn btn-edr" name="btnSubmit" id="btnSubmit">
                    <i class="icon-ok icon-white"></i> Save Turn
                  </button>  
                </td>
              </tr>
          </table>
          <?= form_hidden('EMP_ID', $budget[0]['EMP_ID']); ?>
          <?= form_hidden('BUDGET_ID', $budget[0]['BUDGET_ID']); ?>
          <?= form_close(); ?>
        </div> <!-- END .row -->

      </div> <!-- END .span12 -->
    </div> <!-- END .row -->
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
    });

    $('#btnCancel').on('click',function(e){
      var lynx = "<?= site_url('pam_budget/budget/'.$budget[0]['BUDGET_ID']); ?>";
      window.location = lynx;
    });
  })();

</script>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>EdR Budgeting -- S.A.M.</title>

	<link href="<?= base_url('assets/css/bootstrap.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/bootstrap-responsive.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/font-awesome.css'); ?>" rel="stylesheet">
  <link href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet">
	<link href="<?= base_url('assets/css/site.css'); ?>" rel="stylesheet">

  <style>
    #control_panel{ position:fixed; bottom:0;}
    .btnBreakdownHide, .btnShowDynDetails{cursor:pointer;}
    tr.dym_row{ background-color: #ffffff !important; color: #404040; font-weight: bold; }
    th.dyn-row{ background-color: #ccc; color: #404040; font-weight: bold; text-align: center;}
    td.dyn-row-current{ background-color: #1b6633; font-weight: bold; }
    td.dyn-row-future{ background-color: #ff6; color: #404040; font-weight: bold; }
    td.dyn-row-disabled{ background-color: #d1e0d6; color: #000000; font-weight: bold; }
    input.dr-current, input.dr-future{ font-size:11px !important; font-weight:bold !important;}
    textarea.dyn-notes{ height:200px; width:70px; min-height:200px; max-width:70px; font-size:11px; font-weight:bold; }
    span.dyn-notes{ font-size:11px; font-weight:normal; }
    th.sub_sam{ text-align:center; background-color:#d1e0d6; color:#000; }
    table.sam-sub-main tr:nth-child(even){ background-color: #FFF; }

    select{ font-weight:bold; font-size:18px;}
  </style>

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
          Logged in as <?= $user['login_user']; ?> for 20<?= $this->globals_m->current_year(); ?> Budget</p>
          <h3 style="margin-bottom:0;">SIMPLIFIED ASSETS MANAGEMENT</h3>
          <h2 style="margin-top:0;color:#1b6633;">S.A.M. IV</h2>
          <!--<p><?php //print_r($primary); ?></p>-->
          <!--<br><br>-->
          <?php
            if( $user['accessLevel'] == "superuser" ){
              $budgets_avail = $this->budget_m->get_possible_budgets_dd($user['access_group']);
              echo form_open('sam_budget/select_diff_budget');
              echo form_dropdown('newBudget', $budgets_avail, 'id="newBudget"');
              echo form_close();
            } //endif; 
          ?>
          <h2><?= substr($primary->id,0,3) . " - " . $primary->name; ?></h2>
        </div> <!-- END .row -->
        <div id="dash_body" class="row">
          <div style="width:70%; margin:0 auto; padding:10px;font-size:16px;">
            <h3>Add New Asset</h3>
            <form id="frmAddAss" method="POST" action="<?= site_url('sam_budget/atm_new_asset_handler'); ?>">
              <input type="hidden" name="budget_id" value="<?= $primary->id; ?>" />
              <table class="table table-bordered">
                <tr>
                  <td colspan="2"><?= form_dropdown('ASSET_ID', $assetDD, '0', 'class="span6"'); ?></td>
                </tr>
                <tr>
                  <td style="width:60%;">Amount in dollars to be budgeted for Current Year</td>
                  <td style="width:40%;">
                    <div class="input-prepend">
                      <span class="add-on">$</span>
                      <input name="cy_dollars" class="span4" id="appendedPrependedInput" type="text">
                    </div>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" style="text-align:center;">
                    <a href="#" id="btnCancel" class="btn btn-large btn-inverse">Cancel</a>
                    &nbsp;&nbsp;&nbsp;
                    <a href="#" id="btnSubmit" class="btn btn-large btn-edr">Submit</a>
                  </td>
                </tr>
              </table>
            </form>
          </div>
        </div> <!-- END .row -->
      </div> <!-- END .span12 -->
    </div> <!-- END .row -->
  </div> <!-- END . container -->
  

<script src="<?= base_url('assets/js/jquery-1.9.0.min.js'); ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/bootstrap.js'); ?>" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js" type="text/javascript"></script>
<script type="text/javascript">

  (function() {
    $(document).on('click','#btnSubmit',function(e){
      e.preventDefault();
      $('#frmAddAss').submit();
    });

    $(document).on('click','#btnCancel',function(e){
      e.preventDefault();
      var lynx = "<?= site_url('sam_budget/atm/' . $primary->id); ?>";
      $(location).attr('href',lynx);
    });

    $(document).on('blur','input[name="cy_dollars"]', function(e){
      $(this).val($(this).val().replace(/,/g,''));
    });
  })();
</script>

</body>
</html>
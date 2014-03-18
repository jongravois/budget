<?php
  // Get Remaing for Asset
  //print_r($asset_totals); die();
?><!DOCTYPE html>
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
    .cp_sam_user { height:40px; padding: 12px 0; }
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
        <!-- Inner Header -->
        <div class="row" style="text-align:center;">
          Logged in as <?= $user['login_user']; ?> for 20<?= $this->globals_m->current_year(); ?> Budget</p>
          <h3 style="margin-bottom:0;">SIMPLIFIED ASSETS MANAGER</h3>
          <h2 style="margin-top:0;color:#1b6633;">S.A.M. IV</h2>
          <!--<p><?php //print_r($primary); ?></p>-->
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
          <?php //print_r($user); ?>
          <?php //print_r($primary); die(); ?>
          <?php
            switch( $primary->sam_status ){
              case 0:
                $this->load->view('sam/inc/sam_prompt_open', array('budget'=>$primary));
                break;
              case 1:
                if( $user['accessLevel'] == "analyst"){
                  $this->load->view('sam/inc/budget_readonly', array('budget'=>$primary,'assets'=>$assets));
                } else {
                  $this->load->view('sam/inc/budget_read_write', array('budget'=>$primary,'assets'=>$assets));
                } // end if
                break;
              default:
                $this->load->view('sam/inc/budget_readonly', array('budget'=>$primary,'assets'=>$assets));
                break;
            } // end switch
          ?>
        </div> <!-- END .row -->

        <div id="control_panel" style="display:none;">
          <?php if( $primary->sam_status != 0 ): ?>
            <?php if( $user['accessLevel'] != "analyst"): ?>
              <div class="span12 cp_sam_user">
                  <?php $this->load->view('sam/inc/budget_user_controls'); ?>
              </div> <!-- END .span12 -->
            <?php endif; ?>

            <?php if( $user['accessLevel'] == "analyst"): ?>
              <div class="span12 cp_sam_user">
                  <?php $this->load->view('sam/inc/budget_analyst_controls'); ?>
              </div> <!-- END .row -->
            <?php endif; ?>

            <?php if( $user['accessLevel'] != "user" && $user['accessLevel'] != "superuser" && $user['accessLevel'] != "analyst"): ?>
              <div class="span12 cp_approver" style="display:none;">
                <?php $this->load->view('sam/inc/budget_approver_controls'); ?>
              </div> <!-- END .row -->
            <?php endif; ?>

            <?php if($user['accessLevel'] == "admin" || $user['accessLevel'] == "propadmin"): ?>
              <div class="span12 cp_admin" style="display:none;">
                <?php $this->load->view('sam/inc/budget_admin_controls'); ?>
              </div> <!-- END .row -->
            <?php endif; ?>

          <?php endif; ?>
        </div> <!-- END #control_panel -->
      </div> <!-- END .span12 -->
    </div> <!-- END .row -->
  </div> <!-- END . container -->

  <div id="myModal5" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h3>REASON FOR REJECTION</h3>
    </div>
    <div class="modal-body">
      <p><span id="mbody5"></span></p>
    </div>
  </div>
  

<script src="<?= base_url('assets/js/jquery-1.9.0.min.js'); ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/bootstrap.js'); ?>" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js" type="text/javascript"></script>
<script type="text/javascript">

  (function() {
    var upperLimit = "<?= $asset_totals['budgeted']; ?>";
    var remnant = "<?= $asset_totals['remaining']; ?>";
    var flaggot = 0;
    
    var totFld = 0;
    var thisfld = 0;

    $(document).on('click', '.btnViewProject', function(e){
      var $this = $(this);
      var id = $this.data('id');
      //alert(id);

      $.ajax({
        url:  "<?= site_url('sam_budget/ajax_atm_view_project'); ?>",
        type: "POST",
        data: { projID: id },
        success: function(msg){
          //alert(msg);
          $this.closest('tr').after(msg);
          $('.btnCloseViewProj').click(function(e){
            e.preventDefault();
            $(this).parents('tr').remove();
          });
        } // end success
      });
    });

    $(document).on('focus', '.aSAM', function(e){
      totFld = TotalInputs('aSAM');
      thisfld = $(this).val();
    });

    $(document).on('blur', '.aSAM', function(e){
      if(upperLimit == -999){ return; } // end if
      
      var valu = $(this).val();
      var totle = TotalInputs('aSAM');

      if( totle <= remnant ){
        if( flaggot == 0){
          remaining = parseFloat(remnant)-parseFloat(valu);
        } else {
          remaining = remaining-valu;
        } // end if
        $(this).parents('.frmNewAssets').find('.project_total').val(totle);
        $(this).parents('.frmNewAssets').find('.asset_remayne').val(remaining);
        flaggot++;
      } else {
        alert('That amount will put you OVER-BUDGET!');
        $(this).parents('.frmNewAssets').find('.project_total').val(remnant);
        $(this).val(0);
      } // end if
    });

    $(document).on('focus', '.eSAM', function(e){
      totFld = TotalInputs('eSAM');
      thisfld = $(this).val();
    });

    $(document).on('blur', '.eSAM', function(e){
      if(upperLimit == -999){ return; } // end if
      $this = $(this);

      var valu = $this.val();
      var totle = TotalInputs('eSAM');
      var pRem = $(this).parents('.frmEditAsset').find('.original_remnant').val();
    
      if( totle <= pRem ){
        $(this).parents('.frmEditAsset').find('.project_total').val(totle);
        $(this).parents('.frmEditAsset').find('.asset_remayne').val(parseFloat(pRem)-parseFloat(totle));
      } else {
        alert('That amount will put you OVER-BUDGET!');
        $this.val(thisfld);
        totle = TotalInputs('eSAM');
        $(this).parents('.frmEditAsset').find('.project_total').val(totle);
        $(this).parents('.frmEditAsset').find('.asset_remayne').val(parseFloat(pRem)-parseFloat(totle));
      } // end if
    });

    $('.btnDelete').on('click', function(e){
      if( !confirm("Are you sure you want to delete this?")) { 
        return false;
      } // end if
    });

    $(document).on('click','#btnSnR2PM', function(e){
      e.preventDefault();
      var lynk = "http://pm.edrtrust.com/Deciweb/MPC/Custom/Integration/Run_OpenLinkConfirm.asp";
      window.location = lynk;
    });

    $(document).on('click', '.btnBreakdownHide', function(e){
      $('.project_breakdown_by_month').slideUp(350);
    });

    $(document).on('click', '.btnEditProject', function(e){
      var $this = $(this);
      var id = $(this).data('id');
      $this.parents('table.sam-sub-main').find('tr.rowNewForm').slideUp(350);

      $.ajax({
        url:  "<?= site_url('sam_budget/ajax_atm_edit_project'); ?>",
        type: "POST",
        data: { projID: id },
        success: function(msg){
          $this.closest('tr').after(msg);
        } // end success
      });
    });

    $(document).on('click', '.btnDeleteProject', function(e){
      var bosco = $(this);
      var id = bosco.data('id');
      
      if( !confirm("Are you sure you want to delete this? You will not be able to recover this data at a later time.")) { 
        return false;
      } // end if
      
      $.ajax({
        url:  "<?= site_url('sam_budget/ajax_atm_delete_project'); ?>",
        type: "POST",
        data: { id: id },
        success: function(msg){
          //bosco.parents('.dym_row').slideUp(350);
          location.reload();
        } // end success
      });
    });

    $(document).on('click', '.btnHideThis', function(e){
      $(this).parents('.dym_row').slideUp(350);
    });

    $(document).on('focus keypress', '.sam_notes', function(e){
      UpdateCount($(this));
    });

    $(document).on('click', '.btnReports', function(e){
      e.preventDefault();

      var lynk = $(this).data('link');
      $.ajax({
        url:  "<?= site_url('reports/ajax_reporter'); ?>",
        type: "POST",
        data: { url: lynk },
        success: function(msg){
          window.open(msg);
        } // end success
      });
    });

  })();

  function UpdateCount(notes){
    var msgSpan = notes.parents('td').find('.counter_msg');
    var ml = parseInt( notes.attr('maxlength') );
    var length = notes.val().length;
    var msg = ml - length + ' characters of ' + ml + ' characters left';

    msgSpan.html(msg);
  } // end UpdateCount function

  function TotalInputs(name){
    var numb = 0;
    $('.'+name).each(function(e){
      numb = numb + parseFloat($(this).val());
    });
    return numb;
  } // end TotalInputs function

</script>

</body>
</html>
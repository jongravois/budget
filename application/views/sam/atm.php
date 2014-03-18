<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
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
    table.tblSubmitReport td{ text-align: center; }
    #myModal2 .modal-body{ max-height:600px;}
    .dymRowShowing { border:2px solid #b00400; }
    .overdraft{
      background-color:#B00400;
      color:#FFFFFF;
    }
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
          <?php //print_r($user); ?>
          <?php //print_r($primary); die(); ?>
          <?php
            switch( $primary->atm_status ){
              case 0:
                $this->load->view('sam/inc/atm_prompt_open', array('budget'=>$primary));
                break;
              case 1:
                if( $user['accessLevel'] == "analyst"){
                  $this->load->view('sam/inc/atm_readonly', array( 'primary'=>$primary ));
                } else {
                  $this->load->view('sam/inc/atm_read_write', array());
                } // end if
                break;
              case 2:
                if( $user['accessLevel'] == "analyst"){
                  $this->load->view('sam/inc/atm_readonly', array());
                } else {
                  $this->load->view('sam/inc/atm_read_write', array());
                } // end if
                break;
              case 3:
                if( $user['accessLevel'] == "analyst"){
                  $this->load->view('sam/inc/atm_readonly', array());
                } // end if
                if( (int) $primary->sam_status < 3){
                  $this->load->view('sam/inc/atm_read_write', array());
                } else {
                  //print_r($primary); die();
                  $this->load->view('sam/inc/atm_complete', array());
                } // end if
                break;
              default:
               if( $user['accessLevel'] == "analyst"){
                  $this->load->view('sam/inc/atm_readonly', array());
                } // end if
                if( (int) $primary->sam_status < 3){
                  $this->load->view('sam/inc/atm_read_write', array());
                } else {
                   $this->load->view('sam/inc/atm_complete', array());
                } // end if
                break;
            } // end switch
          ?>
        </div> <!-- END .row -->

        <div id="control_panel">
          <?php if( $primary->atm_status != 0 ): ?>
            <?php if( $user['accessLevel'] != "analyst"): ?>
              <div class="span12 cp_sam_user">
                  <?php $this->load->view('sam/inc/atm_user_controls'); ?>
              </div> <!-- END .span12 -->
            <?php endif; ?>

            <?php if( $user['accessLevel'] == "analyst"): ?>
              <div class="span12 cp_sam_user">
                  <?php $this->load->view('sam/inc/atm_analyst_controls'); ?>
              </div> <!-- END .row -->
            <?php endif; ?>

            <?php if( $user['accessLevel'] != "user" && $user['accessLevel'] != "superuser" && $user['accessLevel'] != "analyst"): ?>
              <div class="span12 cp_approver">
                <?php
                  $data['primary'] = $primary;
                  $this->load->view('sam/inc/atm_approver_controls',$data);
                ?>
              </div> <!-- END .row -->
            <?php endif; ?>

            <?php if($user['accessLevel'] == "admin" || $user['accessLevel'] == "propadmin"): ?>
              <div class="span12 cp_admin">
                <?php $this->load->view('sam/inc/atm_admin_controls'); ?>
              </div> <!-- END .row -->
            <?php endif; ?>

          <?php endif; ?>
        </div> <!-- END #control_panel -->
      </div> <!-- END .span12 -->
    </div> <!-- END .row -->
  </div> <!-- END . container -->

  <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h3>REASON FOR REJECTION</h3>
    </div>
    <div class="modal-body">
      <p><span id="mbody"></span></p>
    </div>
  </div> <!-- END myModal -->

  <div id="myModal2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h3>S.A.M. SUBMISSION SUMMARY</h3>
    </div>
    <div class="modal-body">
      <p><span id="mbody2"></span></p>
    </div>
  </div> <!-- END myModal2 -->

  <div id="myModal3" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h3>SUMMARY NOTE</h3>
    </div>
    <div class="modal-body">
      <p><span id="mbody3"></span></p>
    </div>
  </div> <!-- END myModal3 -->

  <div id="myModal4" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h3>ASSET TYPE BALANCE SHEET</h3>
    </div>
    <div class="modal-body">
      <p><span id="mbody4"></span></p>
    </div>
  </div> <!-- END myModal4 -->
  
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
<script src="<?= base_url('assets/js/bootstrap-modal.js'); ?>" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js" type="text/javascript"></script>
<script type="text/javascript">

  (function() {
    var ttlFields = 0;
    var budget_eyedee = "<?= $primary->id; ?>";

    if( $('.overdraft').length > 0) {
      $('#btnSAMSubmit').attr("disabled", "disabled");
    } 

    $(document).on('click', '.btnShowTimelineRO', function(e){
      var bosco = $(this);
      var eied = bosco.data('id');
      //alert(eied);
      var arrID = eied.split('|');
      var budget_id = arrID[0];
      var asset_code = arrID[1];

      $('.dym_row').hide();

      $.ajax({
        url:  "<?= site_url('sam_budget/ajax_get_timeline_show'); ?>",
        type: "POST",
        data: { budget_id: budget_id, asset_code: asset_code },
        success: function(msg){
          bosco
             .closest('tr')
             .next('.dym_row')
             .empty()
             .html(msg)
             .slideDown(350);
        } // end success
      });
    });

    $(document).on('click', '.btnShowBudgetRO', function(e){
      var bosco = $(this);
      var eied = bosco.data('id');
      //alert(eied);
      var arrID = eied.split('|');
      var budget_id = arrID[0];
      var asset_code = arrID[1];

      var lynk = "<?= site_url('sam_budget/budget'); ?>/"+budget_id+"/"+asset_code;
      window.location.href = lynk;
    });

    $(document).on('click', '.btnRejectATM', function(e){
      e.preventDefault();
      var $this = $(this);
      var eyedee = $this.data('id');
            
      $.ajax({
        url:  "<?= site_url('admin/ajax_fetch_reject_atm_form'); ?>",
        type: "POST",
        data: { id: eyedee },
        success: function(msg){
          $('#mbody').html(msg);
          $('#myModal').modal('show');
        } // end success
      });
    });

    $(document).on('click', '.btnRejectSAM', function(e){
      e.preventDefault();
      var $this = $(this);
      var eyedee = $this.data('id');
            
      $.ajax({
        url:  "<?= site_url('admin/ajax_fetch_reject_sam_form'); ?>",
        type: "POST",
        data: { id: eyedee },
        success: function(msg){
          $('#mbody').html(msg);
          $('#myModal').modal('show');
        } // end success
      });
    });

    //$('#control_panel').hide();
    $(document).on('click','#btnSnR2PM', function(e){
      e.preventDefault();
      var lynk = "http://pm.edrtrust.com/Deciweb/MPC/Custom/Integration/Run_OpenLinkConfirm.asp";
      window.location = lynk;
    });

    $(document).on('blur', '#atm_current', function(e){
      var $this = $(this);
      var val = $this.val();
      var budgetid = $this.data('budgetid');
      var assetcode = $this.data('assetcode');
      
      $.ajax({
        url:  "<?= site_url('sam_budget/ajax_atm_edit_current'); ?>",
        type: "POST",
        data: { budget_id: budgetid, asset_code: assetcode, value: val },
        success: function(min){
          if(min != "OK"){
            alert( "In S.A.M., you have already budgeted $"+min+" for this asset. You cannot reduce your A.T.M. amount to $"+val+" without editing that asset in S.A.M. first.\n\nClick the 'Edit Budget' button to change those projects.");
            $('.btnHideDynRow').click();
          } // end if
        } // end success
      });
    });

    $(document).on('click', '.btnEditTimeline', function(e){
      var bosco = $(this);
      var eied = $(this).data('id');
      var arrID = eied.split('|');
      var budget_id = arrID[0];
      var asset_code = arrID[1];

      $('.dym_row').hide();

      $.ajax({
        url:  "<?= site_url('sam_budget/ajax_get_timeline_edit'); ?>",
        type: "POST",
        data: { budget_id: budget_id, asset_code: asset_code },
        success: function(msg){
          bosco
            .closest('tr')
            .next('.dym_row')
            .empty()
            .html(msg)
            .slideDown(350);
        } // end success
      });
    });

    $(document).on('click', '.btnShowTimeline', function(e){
      var bosco = $(this);
      var eied = $(this).parent('td').data('id');
      var arrID = eied.split('|');
      var budget_id = arrID[0];
      var asset_code = arrID[1];

      $('.dym_row').hide();

      $.ajax({
        url:  "<?= site_url('sam_budget/ajax_get_timeline_show'); ?>",
        type: "POST",
        data: { budget_id: budget_id, asset_code: asset_code },
        success: function(msg){
          bosco
             .closest('tr')
             .next('.dym_row')
             .empty()
             .html(msg)
             .slideDown(350);
        } // end success
      });    
    });

    $(document).on('click', '.btnHideDynRow', function(e){
      $('.dym_row').slideUp(350);
    });

    $(document).on('click','.btnShowDynDetails', function(e){
      var bosco = $(this);
      var yeer = bosco.data('yr');
      var asset = bosco.data('asset');
      var year_total = bosco.siblings('input.proj_total').val();
      var buddy = "<?= $primary->id; ?>";

      $.ajax({
         url:  "<?= site_url('sam_budget/ajax_get_timeline_details'); ?>",
         type: "POST",
         data: { budget_id:buddy, asset_code:asset, year_id:yeer, year_total:year_total },
         success: function(msg){
           $('.hidden_monthly_breakdown').hide();

           bosco
             .closest('tr')
             .next('.hidden_monthly_breakdown')
             .find('.project_breakdown_by_month')
             .empty().html(msg);

           bosco
             .closest('tr')
             .next('.hidden_monthly_breakdown')
             .slideDown(350);
         } // end success
       });
    });

    $(document).on('click', '.btnBreakdownHide', function(e){
      $('.project_breakdown_by_month').slideUp(350);
    });

    $(document).on('click', '.btnSubmitTimelineEdit', function(e){
      var bass = $(this).data('rowid');
      $('input[name="bud_id_asset"]').val(bass);
      $(this).parents('form').submit();
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
        url:  "<?= site_url('sam_budget/ajax_sam_delete_project'); ?>",
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

    $(document).on('blur', '.aSAM', function(e){
      var upperLimit = $('input[name="topLimit"]').val();
      var valu = $(this).val();
      var totle = $(this).parents('.frmNewAssets').find('.project_total').val();
                  
      totle = parseFloat(totle) + parseFloat(valu);
      if( totle <= upperLimit ){
        $(this).parents('.frmNewAssets').find('.project_total').val(totle);
        upperLimit = upperLimit-valu;
      } else {
        alert('That amount will put you OVER-BUDGET!');
        $(this).parents('.frmNewAssets').find('.project_total').val(upperLimit);
        $(this).val(0);
      } // end if
    });

    $(document).on('blur', '.eSAM', function(e){
      var CY_Proj = $('input[name="CY_Projected"]').val();
      var CY_Bud = $('input[name="CY_Budgeted"]').val();
      var PR_Tots = $('input[name="PR_Total"]').val();
      var topLimit = (parseFloat(CY_Proj) - parseFloat(CY_Bud)) + parseFloat(PR_Tots);
      var valu = $(this).val();
      var totle = $(this).parents('.frmEditAsset').find('.project_total').val();
      
      ttlFields = TotalInputs('eSAM');
      
      if( ttlFields <= topLimit ){
         $(this).parents('.frmEditAsset').find('.project_total').val(ttlFields);
      } else {
        alert('That amount will put you OVER-BUDGET!');
        $(this).parents('.frmEditAssets').find('.project_total').val(topLimit);
        $(this).val(0);
      } // end if
    });

    $(document).on('focus keypress', '.sam_notes', function(e){
      UpdateCount($(this));
    });

    $(document).on('click', '.btnSAMSubmit', function(e){
      e.preventDefault();
      $.ajax({
        url:  "<?= site_url('sam_budget/ajax_manager_submit_screen'); ?>",
        type: "POST",
        data: { bid: budget_eyedee },
        success: function(msg){
          $('#mbody2').html(msg);
          $('#myModal2').modal('show');
          $('.btnSubSumCancel').click(function(e){
            $('#myModal2').modal('hide');          
          });
          $('.btnSubSumSubmit').click(function(e){
            $.ajax({
              url:  "<?= site_url('sam_budget/ajax_SAM_submit'); ?>",
              type: "POST",
              data: { bid: budget_eyedee },
              success: function(msg){
                var lynx = "<?= site_url('sam_budget/atm/'.$primary->id); ?>";
                $(location).attr('href',lynx);
              } // end success
            });
          });
        } // end success
      });
    });

    $(document).on('click','.btnMoreNote', function(e){
      var $this = $(this);
      var budget_id = $this.data('budget');
      var asset_code = $this.data('asset');
      var budget_year = $this.data('byear');

      e.preventDefault();

      $.ajax({
        url:  "<?= site_url('sam_budget/ajax_get_sam_note'); ?>",
        type: "POST",
        data: { budget_id: budget_id, asset_code: asset_code , budget_year: budget_year },
        success: function(msg){
          $('#mbody3').html(msg);
          $('#myModal3').modal('show');
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
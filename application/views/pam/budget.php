<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>EdR Budgeting -- P.A.M.</title>

	<link href="<?= base_url('assets/css/bootstrap.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/bootstrap-responsive.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/font-awesome.css'); ?>" rel="stylesheet">
  <link href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet">
	<link href="<?= base_url('assets/css/site.css'); ?>" rel="stylesheet">

  <style>#control_panel{ position:fixed; bottom:0;}</style>

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
        <div class="row" style="text-align:center;border-bottom:5px solid #1b6633;">
          <p style="font-style:italic;">
            Logged in as <?= $user['login_user']; ?> for 20<?= $this->globals_m->current_year(); ?> Budget</p>
          <h3 style="margin-bottom:0;">PAYROLL ADMINISTRATION MODULE</h3>
          <h2 style="margin-top:0;color:#1b6633;">P.A.M. IV</h2>
          <!--<p><?php //print_r($primary); ?></p>-->
          <?php
            if( $user['accessLevel'] == "superuser" ){
              $budgets_avail = $this->budget_m->get_possible_budgets_dd($user['access_group']);
              //print_r($budgets_avail);
              echo form_open('pam_budget/select_diff_budget',array('id' => 'frmChangeBudget'));
              echo form_dropdown('newBudget', $budgets_avail, 0, 'id="newBudget"');
              echo form_close();
            } //endif; 
          ?>
          <h2><?= substr($primary->id,0,3) . " - " . $primary->name; ?></h2>
        </div> <!-- END .row -->
        
        <div id="dash_body" class="row">
          <?php //print_r($user); ?>
          <?php //print_r($primary); die(); ?>
          <?php
            switch( $primary->pam_status ){
              case 0:
                $this->load->view('pam/inc/prompt_open', array('budget'=>$primary));
                break;
              default:
                $this->load->view('pam/inc/budget_read_write', array('budget'=>$primary));
                break;
            } // end switch
          ?>
        </div> <!-- END .row -->

        <div id="control_panel">
          <?php if( $primary->pam_status != 0 ): ?>
            <?php if( $user['accessLevel'] != "analyst"): ?>
              <div class="span12 cp_user">
                  <?php $this->load->view('pam/inc/user_controls'); ?>
              </div> <!-- END .span12 -->
            <?php endif; ?>

            <?php if( $user['accessLevel'] == "analyst"): ?>
              <div class="span12 cp_user">
                  <?php $this->load->view('pam/inc/analyst_controls'); ?>
              </div> <!-- END .row -->
            <?php endif; ?>

            <?php if( $user['accessLevel'] != "user" && $user['accessLevel'] != "superuser" && $user['accessLevel'] != "analyst"): ?>
              <div class="span12 cp_approver">
                <?php $this->load->view('pam/inc/approver_controls'); ?>
              </div> <!-- END .row -->
            <?php endif; ?>

            <?php if($user['accessLevel'] == "admin" || $user['accessLevel'] == "propadmin"): ?>
              <div class="span12 cp_admin">
                <?php $this->load->view('pam/inc/admin_controls'); ?>
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
  </div>

<script src="<?= base_url('assets/js/jquery-1.9.0.min.js'); ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/bootstrap.js'); ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/bootstrap-dropdown.js'); ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/bootstrap-modal.js'); ?>" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js" type="text/javascript"></script>
<script type="text/javascript">

  (function() {
    //$('#control_panel').hide();

    $('.btnDelete').on('click', function(e){
      if( !confirm("Are you sure you want to delete this?")) { 
        return false;
      } // end if
    });

    $(document).on('change', '#newBudget', function(e){
      $('#frmChangeBudget').submit();
    });

   $(document).on('click','#btnSnR2PM', function(e){
      e.preventDefault();
      var lynk = "http://pm.edrtrust.com/Deciweb/MPC/Custom/Integration/Run_OpenLinkConfirm.asp";
      window.location = lynk;
    });

    $(document).on('click', '.btnRejectBudget', function(e){
      e.preventDefault();
      var $this = $(this);
      var eyedee = $this.data('id');
            
      $.ajax({
        url:  "<?= site_url('admin/ajax_fetch_reject_form'); ?>",
        type: "POST",
        data: { id: eyedee },
        success: function(msg){
          $('#mbody').html(msg);
          $('#myModal').modal('show');
        } // end success
      });
    });

    $(document).on('click', '.btnReports', function(e){
      e.preventDefault();

      var lynk = $(this).data('link');
      $.ajax({
        url:  "<?= site_url('reports/ajax_reporter'); ?>",
        type: "POST",
        data: { url: lynk },
        success: function(msg){
          //alert(msg);
          window.open(msg);
        } // end success
      });
    });
  })();

</script>

</body>
</html>
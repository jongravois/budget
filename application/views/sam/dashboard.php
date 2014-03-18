<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>EdR Budgeting -- SAM</title>

	<link href="<?= base_url('assets/css/bootstrap.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/bootstrap-responsive.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/font-awesome.css'); ?>" rel="stylesheet">
  <link href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet">
	<link href="<?= base_url('assets/css/site.css'); ?>" rel="stylesheet">

  <style type="text/css">
    .pmDashBlack{ background-color: #000; color:#FFF; }
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
          <p style="font-style:italic;">Logged in as <?= $user['login_user']; ?></p>
          <h1 style="margin-bottom:0;">SIMPLIFIED ASSETS MANAGER</h1>
          <h3 style="margin-top:0;">SAM IV</h3>
          <?php if( $user['accessLevel'] == "admin" || $user['accessLevel'] == "propertyadmin") : ?>
            <br>
            <p><?= anchor('admin/index', 'ADMINISTRATION', 'class="EZ-admin"'); ?></p>
          <?php endif; ?>
          <br>
          <p><strong>LEGEND</strong>: 
            <span style="padding:4px;background-color: #009; color:#FFF;">Not Started</span> | 
            <span style="padding:4px;background-color: #900; color:#FFF;">In Progress</span> | 
            <span style="padding:4px;background-color: #F87114; color:#FFF;">Submitted</span> | 
            <span style="padding:4px;background-color: #090; color:#FFF;">Approved</span> | 
            <span style="padding:4px;background-color: #CCC; color:#000;">Archived</span> | 
            <span style="padding:4px;background-color: #000; color:#FFF;">PM Closed</span>
          </p>
          <br><br>
        </div> <!-- END .row -->
      </div> <!-- END .span12 -->
    </div> <!-- END .row -->

    <div class="row">
      <div class="span12">
        <?php $this->load->view('sam/inc/dash_tabs'); ?>
      </div> <!-- END .span12 -->
    </div> <!-- END .row -->
  </div> <!-- END . container -->

<script src="<?= base_url('assets/js/jquery-1.9.0.min.js'); ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/bootstrap.js'); ?>" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js" type="text/javascript"></script>
<script type="text/javascript">

(function() {
  $( "#tabs" ).tabs();

  $('.pmDash').on('click', function(){
    var eyedee = $(this).data('id');
    var url = "<?= site_url('sam_budget/atm'); ?>/" + eyedee;
    $(location).attr('href',url);
  });
})();

</script>

</body>
</html>
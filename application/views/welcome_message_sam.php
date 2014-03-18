<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>S.A.M. -- LOGGER</title>

	<link href="<?= base_url('assets/css/bootstrap.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/bootstrap-responsive.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/prettify.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/bootstrap-wysihtml5.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/font-awesome.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/site.css'); ?>" rel="stylesheet">

	<!--[if IE 7]>
		<link rel="stylesheet" href="<?= base_url('assets/css/font-awesome-ie7.min.css'); ?>">
	<![endif]-->
	<!--[if lt IE 9]>  
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>  
    <![endif]-->
</head>
<body>
	<div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">PAM IV/SAM IV</a>
        </div>
      </div>
    </div>
	<div id="page-content" class="container-fluid">

  <br><br><br><br>
  <div class="row">
    <div class="span12">
      <h3>Welcome to SAM IV</h3>
      <p class="head_link btn" style="text-align:center;">
        <a href="<?= site_url('welcome/index'); ?>">SWITCH TO PAM IV</a>
      </p>
    </div>
  </div>
  <hr>
  
  <div class="container">
    <div class="row">
      <div class="span12">
        <div class="row">
          <ul class="unstyled">
            <li class="span4">
              <form class="pmDemo" action="<?= site_url('sam_user/index'); ?>" method="post">
                <input type="hidden" name="sUsername" value="admin" />
                <input type="submit" name="submit" value="ADMIN" />
              </form>
            </li>
            <li class="button-dashboard span4">
              <form class="pmDemo" action="<?= site_url('sam_user/index'); ?>" method="post">
                <input type="hidden" name="sUsername" value="kreed" />
                <input type="submit" name="submit" value="KALEB REED" />
              </form>
            </li>
            <li class="button-dashboard span4">
              <form class="pmDemo" action="<?= site_url('sam_user/index'); ?>" method="post">
               <input type="hidden" name="sUsername" value="hr_admin" />
               <input type="submit" name="submit" value="HR OFFICE" />
              </form>
            </li>
            <li class="button-dashboard span4">
              <form class="pmDemo" action="<?= site_url('sam_user/index'); ?>" method="post">
               <input type="hidden" name="sUsername" value="regional" />
               <input type="submit" name="submit" value="REGIONAL" />
              </form>
            </li>
            <li class="button-dashboard span4">
              <form class="pmDemo" action="<?= site_url('sam_user/index'); ?>" method="post">
               <input type="hidden" name="sUsername" value="cao" />
               <input type="submit" name="submit" value="CAO (DREW)" />
              </form>
            </li>
            <li class="button-dashboard span4">
              <form class="pmDemo" action="<?= site_url('sam_user/index'); ?>" method="post">
               <input type="hidden" name="sUsername" value="analyst" />
               <input type="submit" name="submit" value="ANALYST" />
              </form>
            </li>
            <li class="button-dashboard span4">
              <form class="pmDemo" action="<?= site_url('sam_user/index'); ?>" method="post">
               <input type="hidden" name="sUsername" value="pmtraining1" />
               <input type="submit" name="submit" value="OWNED" />
              </form>
            </li>
             <li class="button-dashboard span4">
              <form class="pmDemo" action="<?= site_url('sam_user/index'); ?>" method="post">
               <input type="hidden" name="sUsername" value="manprop" />
               <input type="submit" name="submit" value="MANAGED" />
              </form>
            </li>
            <li class="button-dashboard span4">
              <form class="pmDemo" action="<?= site_url('sam_user/index'); ?>" method="post">
               <input type="hidden" name="sUsername" value="corpIT" />
               <input type="submit" name="submit" value="IT DEPARTMENT" />
              </form>
            </li>
           <li class="button-dashboard span4">
              <form class="pmDemo" action="<?= site_url('sam_user/index'); ?>" method="post">
               <input type="hidden" name="sUsername" value="louisville" />
               <input type="submit" name="submit" value="MULTIPLE PROPERTY ACCESS" />
              </form>
            </li>
            <li class="button-dashboard span4">
              <form class="pmDemo" action="<?= site_url('sam_user/index'); ?>" method="post">
               <input type="hidden" name="sUsername" value="const" />
               <input type="submit" name="submit" value="CONSTRUCTION DEPARTMENT" />
              </form>
            </li>
            <li class="button-dashboard span4">
              <form class="pmDemo" action="<?= site_url('sam_user/index'); ?>" method="post">
               <input type="hidden" name="sUsername" value="devel" />
               <input type="submit" name="submit" value="DEVELOPMENT DEPARTMENT" />
              </form>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div><!--/.fluid-container-->

<script src="<?= base_url('assets/js/wysihtml5.js'); ?>" type="text/javascript"></script>
<!--<script src="<?= base_url('assets/js/jquery-1.7.2.min.js'); ?>" type="text/javascript"></script>-->
<script src="<?= base_url('assets/js/jquery-1.9.0.min.js'); ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/prettify.js'); ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/bootstrap.js'); ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/bootstrap-wysihtml5.js'); ?>" type="text/javascript"></script>
<script type="text/javascript">
(function() {
    $('.textarea').wysihtml5();
    $(prettyPrint);
})();
</script>

</body>
</html>
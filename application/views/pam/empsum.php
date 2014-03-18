<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>P.A.M. -- Employee Summary Report</title>

  <script src="<?= base_url('assets/js/jquery-1.9.0.min.js'); ?>" type="text/javascript"></script>
  <script src="<?= base_url('assets/js/bootstrap.js'); ?>" type="text/javascript"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js" type="text/javascript"></script>

	<link href="<?= base_url('assets/css/bootstrap.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/bootstrap-responsive.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/font-awesome.css'); ?>" rel="stylesheet">
  <link href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet">
	<link href="<?= base_url('assets/css/site.css'); ?>" rel="stylesheet">

  <style></style>
</head>
<body>

	<a target="_blank" href="http://reports.edrtrust.com/ReportServer?/PAM_SAM/Employee Summary&year=14&Unit=349">Report Server</a>

	<a href="http://reports.edrtrust.com/ReportServer?/PAM_SAM/Employee Summary&year=14&Unit=349" onclick="window.open('report.htm', 'newwindow', 'width=600, height=550'); return false;"> New Window</a>

	<p style="text-align:center;"><a class="btn btn-large btn-edr" href="<?= site_url('pam_budget/budget/'.$budget); ?>">RETURN TO BUDGET</a></p>

<script>
(function() {
	//$('#offToRS').submit();
})(); // end self-invoking anonymous function
</script>

</body>
</html>
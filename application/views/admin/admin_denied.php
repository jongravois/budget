<?php $this->load->view('admin/components/page_head'); ?>
<body>
<style type="text/css">
	th{ text-align: center;font:bold 16px sans-serif; color:#F87114; }
	td{ text-align: center;font:bold 16px sans-serif;vertical-align: middle;}
</style>
		
    <div class="container" style="margin-top:30px;">
    	<?php //var_dump($allExpos); ?>
		<div class="row">
			<!-- Main column -->
			<div class="span12" style="text-align:center;">
				<img src="<?= base_url('assets/images/access_denied.gif'); ?>" alt="Access Denied">
			</div>
		</div> <!-- END .row DIV -->
	</div>
	
<script src="<?= base_url('assets/js/jquery.1.8.3.min.js'); ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/bootstrap.js'); ?>" type="text/javascript"></script>
	
<script>
	(function(){})();
</script>

<?php $this->load->view('admin/components/page_tail'); ?>
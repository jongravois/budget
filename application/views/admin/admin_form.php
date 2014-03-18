<?php $this->load->view('admin/components/page_head'); ?>
<body>
<style type="text/css">
	th{ text-align: center;font:bold 16px sans-serif; background-color:#1b6633; color:#FFF; }
	td{ font:bold 16px sans-serif;vertical-align: middle;}
	.btnClearBudgetsFilter{ cursor:pointer;}
</style>
		
    <div class="navbar navbar-inverse navbar-fixed-top">
    	<div class="navbar-inner">
        	<div class="container">
	        	<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
	            	<span class="icon-bar"></span>
	            	<span class="icon-bar"></span>
	            	<span class="icon-bar"></span>
	          	</button>
          		<a class="brand" href="<?= site_url('admin/index'); ?>">ADMINISTRATION</a>
          		<div class="nav-collapse collapse">
		          	<ul class="nav">
		              <li class="active">&nbsp;</li>
		              <li class="">
		                <a href="<?= site_url('pam_budget/dashboard'); ?>">P.A.M. Dashboard</a>
		              </li>
		              <li class="">
		                <a href="<?= site_url('sam_budget/dashboard'); ?>">S.A.M. Dashboard</a>
		              </li>
		          	</ul>
         	 	</div>
        	</div>
      	</div>
    </div> <!-- END .row DIV -->
		
	<div class="container">
	    <div class="row">
	      <div class="span3 bs-docs-sidebar">
	        <?php $this->load->view('admin/components/v_left_nav'); ?>
	      </div> <!-- END bs-docs-sidebar -->
	      <div class="span9" style="margin-top:70px;">
	      	<?= $subview; ?>
	      </div>
	  	</div>
	</div>

	<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
	
<script src="<?= base_url('assets/js/jquery.1.8.3.min.js'); ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/bootstrap.js'); ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/bootstrap-modal.js'); ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/jquery.tablePagination.js'); ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/jquery.uitablefilter.js'); ?>" type="text/javascript"></script>
	
<script>
	$.extend($.expr[":"], {
		"containsNC": function(elem, i, match, array) {
			return (elem.textContent || elem.innerText || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
		}
	});

	(function(){
		
	})();
</script>

<?php $this->load->view('admin/components/page_tail'); ?>
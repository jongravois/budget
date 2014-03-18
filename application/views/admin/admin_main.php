<?php $this->load->view('admin/components/page_head'); ?>

<body>
<style type="text/css">
	th{ text-align: center;font:bold 16px sans-serif; background-color:#1b6633; color:#FFF; }
	td{ font:bold 16px sans-serif;vertical-align: middle;}
	.btnClearBudgetsFilter{ display: none; }
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
	      <div class="span9">
	      	<span style="height:60px;"><br>&nbsp;<br></span>
			
			<section id="inner_view">
	        	<?= $this->load->view($view_name); ?>
	        </section>

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
	(function(){
		$('table').tablePagination({
			rowsPerPage: 12,
			firstArrow : (new Image()).src="<?= base_url('assets/images/first.gif'); ?>",
            prevArrow : (new Image()).src="<?= base_url('assets/images/prev.gif'); ?>",
            lastArrow : (new Image()).src="<?= base_url('assets/images/last.gif'); ?>",
            nextArrow : (new Image()).src="<?= base_url('assets/images/next.gif'); ?>"
		});

		$(document).on('click', '.btnViewRecord', function(e){
			var id = $(this).data('id');
			var table = $(this).data('table');
			alert(table+'||'+id);
		});

		$(document).on('click', '.btnAddRecord', function(e){
			var section = $(this).data('section');
			var lynxBase = "<?= site_url('admin/form/create'); ?>";
			var lynx = lynxBase+'/'+section;
			window.location = lynx;
		});

		$(document).on('click', '.btnEditRecord', function(e){
			var id = $(this).data('id');
			var table = $(this).data('table');
			var lynxBase = "<?= site_url('admin/form/edit'); ?>";
			var lynx = lynxBase+'/'+table+'/'+id;
			window.location = lynx;
		});

		$(document).on('click', '.btnDeleteRecord', function(e){
			var id = $(this).data('id');
			var table = $(this).data('table');
			if( !confirm("This data cannot be recovered. Are you sure?")) { 
        		return false;
      		} // end if
			
			$.ajax({
				url:  "<?= site_url('admin/ajax_delete_record'); ?>",
				type: "POST",
				data: { id: id, table: table },
				success: function(msg){
					location.reload();
				} // end success
			});
		});

		$(document).on('keyup', '.rowFilter', function(e){
			var term = $(this).val().toLowerCase();
			
			if( term != ""){
			 	$('table tbody>tr').hide();
				$( 'table td').filter(function(){
					return $(this).text().toLowerCase().indexOf(term) >-1
				}).parent('tr').show();
			} else {
				$('table tbody>tr').show();
			} // end if
		});

		$(document).on('click', '.btnClearBudgetsFilter', function(e){
			$('.rowFilter').val('');
			$('table tbody').find('tr').show();
			$('table').tablePagination({
				rowsPerPage: 12,
				firstArrow : (new Image()).src="<?= base_url('assets/images/first.gif'); ?>",
	            prevArrow : (new Image()).src="<?= base_url('assets/images/prev.gif'); ?>",
	            lastArrow : (new Image()).src="<?= base_url('assets/images/last.gif'); ?>",
	            nextArrow : (new Image()).src="<?= base_url('assets/images/next.gif'); ?>"
			});
		});

		$(document).on('blur', '#inputPercentGIIncrease', function(e){
			var valu = $(this).val();

			if( $.isNumeric( valu ) ){
				var current_single = $('#single_current').html();
				var current_family = $('#family_current').html();
				var adjusted_single = (parseFloat(current_single) * parseFloat(valu)/100) + parseFloat(current_single);
				var adjusted_family = (parseFloat(current_family) * parseFloat(valu)/100) + parseFloat(current_family);
				$('#single_adjusted').html(adjusted_single.toFixed(2));
				$('#family_adjusted').html(adjusted_family.toFixed(2));
			} else { 
				return false; 
			} // end if
		});

		$(document).on('click', '.btnSaveGIAdjust', function(e){
			if( $('#inputPercentGIIncrease').val() < .01) {
				alert('You must enter a percentage to continue.');
				return false;
			}// end if
			var cSingle = $('#single_current').html();
			var aSingle = $('#single_adjusted').html();
			var cFamily = $('#family_current').html();
			var aFamily = $('#family_adjusted').html();
			var percent = $('#inputPercentGIIncrease').val();

			if( !confirm("Clicking OK will not only change the default values but will also recaculate all open budgets with this increase. Are you sure?")) { 
        		return false;
      		} // end if

			$.ajax({
				url:  "<?= site_url('admin/ajax_save_grpins'); ?>",
				type: "POST",
				data: { cSingle: cSingle, aSingle: aSingle, cFamily: cFamily, aFamily: aFamily, percent: percent },
				success: function(msg){
					$('#giAdjustMsg').html(msg);
				} // end success
			});
		});

		$(document).on('click', '.btnCancelGIAdjust', function(e){
			$('#single_adjusted').html('');
			$('#family_adjusted').html('');
			$('#inputPercentGIIncrease').val('').focus();
		});

		$(document).on('click', '.btnRecalcOpen', function(e){
			$(this).hide();
			
			$.ajax({
				url:  "<?= site_url('admin/ajax_recalc_pam_projects'); ?>",
				type: "POST",
				data: { status: 'open' },
				success: function(msg){
					$('#recalcOpenReport').html(msg);
				} // end success
			});
		});

		$(document).on('click', '.btnRecalcOpenSam', function(e){
			$(this).hide();
			$.ajax({
				url:  "<?= site_url('admin/ajax_recalc_sam_projects'); ?>",
				type: "POST",
				data: { status: 'open' },
				success: function(msg){
					$('#recalcOpenReport').html(msg);
					//window.location.href="<?= site_url('admin/index'); ?>";
				} // end success
			});
		});

		$(document).on('click', '.btnRecalcAll', function(e){
			$(this).hide();
			
			$.ajax({
				url:  "<?= site_url('admin/ajax_recalc_pam_projects'); ?>",
				type: "POST",
				data: { status: 'all' },
				success: function(msg){
					$('#recalcAllReport').html(msg);
				} // end success
			});
		});

		$(document).on('click', '.btnRecalcAllSam', function(e){
			$(this).hide();

			$.ajax({
				url:  "<?= site_url('admin/ajax_recalc_sam_projects'); ?>",
				type: "POST",
				data: { status: 'all' },
				success: function(msg){
					$('#recalcAllReport').html(msg);
				} // end success
			});
		});

		$(document).on('click', '.btnSaveModalChanges', function(e){
			$('#myModal').modal('hide');
			$('#myModal').find('form').submit();
		});

		$(document).on('blur', '.inputEZA', function(e){
			var id = $(this).data('id');
			var type = $(this).data('type');
			var value = $(this).val();
			//alert(value);

			if( value == 0){
				if( !confirm("Setting a budget to zero (0) will require the budget to be opened by the user reseting it to its opening stage and resulting in loss of all data entered. Are you sure you mean 0? Setting the budget to 1 will allow the budget to once again be edited and will preserve customized data.")) { 
        			return false;
      			} // end if
			} // end if

			if( value > 4 ){
				alert("Valid values are 0,1,2,3 and 4");
				$(this).val('').focus();
				return false;
			} // end if

			$.ajax({
				url:  "<?= site_url('admin/ajax_ez_admin'); ?>",
				type: "POST",
				data: { id: id, type: type, value: value },
				success: function(msg){
					//alert(msg);
				} // end success
			});
		});

		var proImg = "<img src='<?= base_url('assets/images/processing.gif'); ?>' />";
		$('.loadingDiv')
    		.html(proImg).hide()  // hide it initially
    		.ajaxStart(function() {
        		$(this).show();
    		})
    		.ajaxStop(function() {
        		$(this).hide();
    	});
	})(); // end document.ready
</script>

<?php $this->load->view('admin/components/page_tail'); ?>
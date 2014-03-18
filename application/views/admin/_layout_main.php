<?php $this->load->view('admin/components/page_head'); ?>
<body>
<style type="text/css">
	th{ text-align: center;font:bold 16px sans-serif; color:#F87114; }
	td{ text-align: center;font:bold 16px sans-serif;vertical-align: middle;}
</style>
    <div class="container">
    	<?php //var_dump($allExpos); ?>
		<div class="row">
			<!-- Main column -->
			<div class="span12" style="text-align:center;">
				<section>
					<h2>TALENT EXPO ADMINISTRATION</h2>
				</section>
			</div>
		</div> <!-- END .row DIV -->
		
		<div class="row">
			<div class="span12">
				<table class="table table-bordered">
					<tr>
						<td colspan="4">
							<a id="btnNewExpo" class="btn" href="<?= site_url('xmen/create_new_expo'); ?>">
								<i class="icon-plus"></i> ADD NEW EXPO
							</a>
						</td>
					</tr>
					<tr>
						<th style="width:25%;">EXPO</th>
						<th style="width:25%;">HOST</th>
						<th style="width:25%;">CITY</th>
						<th style="width:25%;">&nbsp;</th>
					</tr>
					<?php foreach($allExpos as $xp): ?>
						<tr>
							<td><?= $xp->expo_name; ?></td>
							<td><?= $xp->host; ?></td>
							<td><?= $xp->expo_city . ', ' . $xp->expo_state; ?></td>
							<td style="text-align:center;">
								<div class="btn-toolbar" style="display:inline;">
									<div class="btn-group">
								    	<a class="btn btnEdit" href="<?= site_url('xmen/edit_expo/' . $xp->id); ?>"><i class="icon-pencil"></i>EDIT</a>
								    	<a class="btn btnDelete" href="<?= site_url('xmen/delete_expo/' . $xp->id); ?>"><i class="icon-remove"></i>DELETE</a>
								  </div><!-- END .btn-group DIV -->
								</div><!-- END btn-toolbar DIV -->
							</td>
						</tr>
					<?php endforeach; ?>
				</table>
			</div>
		</div>
	</div>
	
	<script>
		(function($){
			
		})(jQuery);
		
		function add_new_expo(){
			alert('New One');
		} // end function
		
		function edit_expo( id ){
			alert(id);
		} // end function
		
		function delete_expo( id ){
			alert(id);
		} // end function
	</script>

<?php $this->load->view('admin/components/page_tail'); ?>
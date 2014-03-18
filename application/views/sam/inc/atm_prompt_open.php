<?php if( $user['accessLevel'] == "analyst"): ?>
	<div style="width:80%; margin:0 auto; padding:10px;font-size:16px;">
		<br><p>The <b>Fixed Assets Management</b> portion of the budgeting process for this property has not yet been opened.</p><br><br>
		<a class="btn btn-large" onclick="history.go(-1);">Return to Previous Screen</a></p>
		<br><br>
	</div>
<?php else: ?>
	<?php if( ($user['accessLevel'] == 'admin') || ($user['accessLevel'] == 'approver') || ($user['accessLevel'] == 'regional') ) : ?>
		
		<div style="width:80%; margin:0 auto; padding:10px;font-size:16px;">		
			<br><p>You are about to enter the <b>Fixed Assets Timeline Management</b> portion of the budgeting process.</p>
			<p>If you click "<b>Continue</b>", any available prior year fixed assets projection will be loaded into S.A.M. IV. Then you may modify/delete existing projects or add new projects to fit your budgetary or projection plan. A notification email will be sent to the Community Manager and Regional Director indicating that this budget is now open.</p>
			<p>If you click "<b>Cancel</b>", you will return to the dashboard and no action will have occurred on this fixed assets budget.</p><br>
			<p><a href="<?= site_url('sam_budget/open_budget/'.$budget->id); ?>" class="btn btn-large btn-inverse">Continue to Fixed Assets Budgeting</a>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a class="btn btn-large" onclick="history.go(-1);">Cancel and Return to Previous Screen</a></p>
		</div>

	<?php else: ?>
		
		<div style="width:80%; margin:0 auto; padding:10px;font-size:16px;">		
			<br><p>You are about to enter the <b>Fixed Assets Management</b> portion of your budgeting process.</p>
			<p>When you click "<b>Continue</b>", any available prior year fixed assets projection will be loaded into S.A.M. IV. Then you may modify/delete existing projects or add new projects to fit your budgetary or projection plan. A notification email will be sent to the Community Manager and Regional Director indicating that this budget is now open.</p>
			<p><a href="<?= site_url('sam_budget/open_budget/'.$budget->id); ?>" class="btn btn-large btn-inverse">Continue to Fixed Assets Budgeting</a>
		</div>

	<?php endif; ?>
<?php endif; ?>
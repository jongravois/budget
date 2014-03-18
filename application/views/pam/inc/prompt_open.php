<?php if( $user['accessLevel'] == "analyst"): ?>
	<div style="width:80%; margin:0 auto; padding:10px;font-size:16px;">
		<br><p>The <b>Payroll portion</b> of the budgeting process for this property has not yet been opened.</p><br><br>
		<a class="btn btn-large" onclick="history.go(-1);">Return to Previous Screen</a></p>
		<br><br>
	</div>
<?php else: ?>
	<?php if( ($user['accessLevel'] == 'admin') || ($user['accessLevel'] == 'approver') || ($user['accessLevel'] == 'regional') ) : ?>
		
		<div style="width:80%; margin:0 auto; padding:10px;font-size:16px;">		
			<br><p>You are about to enter the <b>Payroll portion</b> of the budgeting process.</p>
			<p>If you click "<b>Continue</b>", all existing employees and their existing benefits will be loaded into the payroll budget. Then you may modify/delete existing employees or add new positions to fit your payroll budgetary plan. A notification email will be sent to the Community Manager and Regional Director indicating that this budget is now open.</p>
			<p>If you click "<b>Cancel</b>", you will return to the dashboard and no action will have occurred on this payroll budget.</p><br>
			<p><a href="<?= site_url('pam_budget/open_budget/'.$budget->id); ?>" class="btn btn-large btn-inverse">Continue to Payroll Budgeting</a>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a class="btn btn-large" onclick="history.go(-1);">Cancel and Return to Previous Screen</a></p>
		</div>

	<?php else: ?>
		
		<div style="width:80%; margin:0 auto; padding:10px;font-size:16px;">		
			<br><p>You are about to enter the <b>Payroll portion</b> of your budgeting process.</p>
			<p>When you click "<b>Continue</b>", all existing employees and their existing benefits will be loaded into the payroll budget. Then, you may modify/delete existing employees or add new positions to fit your payroll budgetary plan.<br><br>A notification email will be sent to you and to your <b>Regional Director</b> indicating that this budget is now open.</p>
			<p><a href="<?= site_url('pam_budget/open_budget/'.$budget->id); ?>" class="btn btn-large btn-inverse">Continue to Payroll Budgeting</a>
		</div>

	<?php endif; ?>
<?php endif; ?>
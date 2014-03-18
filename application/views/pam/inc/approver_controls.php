<?php if( (int)$primary->pam_status != 2): ?>
<table cellpadding="6" style="width:100%;">
	<tr style="background-color:#404040; height:40px;">
		<td align="center" style="width:50%;">
			<a href="<?= site_url('pam_budget/dashboard'); ?>" class="btn"><i class="icon-th"></i> DASHBOARD</a>
		</td>
		<td align="center" style="width:50%;">
			<a href="<?= site_url('pam_budget/edit_street_team/'.$primary->id); ?>" class="btn"><i class="icon-road"></i> EDIT STREET TEAM</a>
		</td>
	</tr>
</table>
<?php else: ?>
	<table cellpadding="6" style="width:100%;">
		<tr style="background-color:#404040; height:40px;">
			<td align="center" style="width:25%;">
				<a href="<?= site_url('pam_budget/z_budget_approved/'.$primary->id); ?>" class="btn btn-edr"><i class="icon-thumbs-up"></i> APPROVE BUDGET</a>
			</td>
			<td align="center" style="width:25%;">
				<a href="<?= site_url('pam_budget/dashboard'); ?>" class="btn btn"><i class="icon-th"></i> DASHBOARD</a>
			</td>
			<td align="center" style="width:25%;">
				<a href="<?= site_url('pam_budget/edit_street_team/'.$primary->id); ?>" class="btn btn"><i class="icon-road"></i> EDIT STREET TEAM</a>
			</td>
			<td align="center" style="width:25%;">
				<a href="<?= site_url('pam_budget/z_budget_rejected/'.$primary->id); ?>" class="btn btn-danger btnRejectBudget" data-id="<?= $primary->id; ?>"><i class="icon-thumbs-down"></i> REJECT BUDGET</a>
			</td>
		</tr>
	</table>
<?php endif; ?>
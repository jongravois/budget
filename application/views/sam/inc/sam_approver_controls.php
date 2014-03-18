<?php if( (int)$primary->sam_status != 2): ?>
<table cellpadding="6" style="width:100%;">
	<tr style="background-color:#404040; height:40px;">
		<td align="center">
			<a href="<?= site_url('sam_budget/dashboard'); ?>" class="btn"><i class="icon-th"></i> DASHBOARD</a>
		</td>
	</tr>
</table>
<?php else: ?>
	<table cellpadding="6" style="width:100%;">
		<tr style="background-color:#404040; height:40px;">
			<td align="center" style="width:33%;">
				<a href="<?= site_url('sam_budget/z_sam_approved/'.$primary->id); ?>" class="btn btn-edr"><i class="icon-thumbs-up"></i> APPROVE BUDGET</a>
			</td>
			<td align="center" style="width:34%;">
				<a href="<?= site_url('sam_budget/dashboard'); ?>" class="btn btn"><i class="icon-th"></i> DASHBOARD</a>
			</td>
			<td align="center" style="width:33%;">
				<a href="<?= site_url('sam_budget/z_sam_rejected/'.$primary->id); ?>" class="btn btn-danger"><i class="icon-thumbs-down"></i> REJECT BUDGET</a>
			</td>
		</tr>
	</table>
<?php endif; ?>
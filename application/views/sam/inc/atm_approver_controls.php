<?php if( (int)$primary->atm_status == 0 || (int)$primary->atm_status == 1 ): ?>
	<table cellpadding="6" style="width:100%;">
		<tr style="background-color:#404040; height:40px;">
			<td align="center">
				<a href="<?= site_url('sam_budget/dashboard'); ?>" class="btn">
					<i class="icon-th"></i> DASHBOARD
				</a>
			</td>
		</tr>
	</table>
<?php else: ?>
	<table cellpadding="6" style="width:100%;">
		<tr style="background-color:#404040; height:40px;">
			<td align="center" style="width:33%;">
				<?php if($primary->atm_status == 2): ?>
					<a href="<?= site_url('sam_budget/z_atm_approved/'.$primary->id); ?>" data-id="<?= $primary->id; ?>" class="btn btn-edr"><i class="icon-thumbs-up"></i> APPROVE A.T.M.</a>
				<?php else: ?>
					<?php if($primary->sam_status == 2): ?>
						<a href="<?= site_url('sam_budget/z_sam_approved/'.$primary->id); ?>" data-id="<?= $primary->id; ?>" class="btn btn-edr"><i class="icon-thumbs-up"></i> APPROVE S.A.M.</a>
					<?php else: ?>
						&nbsp;
					<?php endif; ?>
				<?php endif; ?>
			</td>
			<td align="center" style="width:34%;">
				<a href="<?= site_url('sam_budget/dashboard'); ?>" class="btn">
					<i class="icon-th"></i> DASHBOARD
				</a>
			</td>
			<td align="center" style="width:33%;">
				<?php if($primary->atm_status == 2): ?>
					<a href="<?= site_url('sam_budget/z_atm_rejected/'.$primary->id); ?>" data-id="<?= $primary->id; ?>" class="btn btn-danger btnRejectATM"><i class="icon-thumbs-down"></i> REJECT A.T.M.</a>
				<?php else: ?>
					<?php if($primary->sam_status == 2): ?>
						<a href="<?= site_url('sam_budget/z_sam_rejected/'.$primary->id); ?>" data-id="<?= $primary->id; ?>" class="btn btn-danger btnRejectSAM"><i class="icon-thumbs-down"></i> REJECT S.A.M.</a>
					<?php else: ?>
						&nbsp;
					<?php endif; ?>
				<?php endif; ?>
			</td>
		</tr>
	</table>
<?php endif; ?>	
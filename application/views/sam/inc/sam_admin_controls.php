<table cellpadding="6" style="width:100%;">
	<tr style="background-color:#1b6633; height:40px;">
		<td align="center" style="width:50%;">
			<a href="<?= site_url('admin/index'); ?>" class="btn"><i class="icon-cog"></i> ADMINISTRATOR / SETTINGS</a>
		</td>
		<td align="center" style="width:50%;">
			<?php if( (int)$primary->sam_status == 3): ?>
				<a href="<?= site_url('admin/reopen_sam_single/'.$primary->id); ?>" class="btn"><i class="icon-flag"></i> RE-OPEN THIS BUDGET</a>
			<?php else: ?>
				<a href="<?= site_url('admin/recalc_sam_single/'.$primary->id); ?>" class="btn"><i class="icon-retweet"></i> RECALCULATE THIS BUDGET</a>
			<?php endif; ?>
		</td>
	</tr>
</table>
<div class="span12">
	<table cellpadding="6" style="width:94%;">
		<tr style="background-color:#AAAAAA; height:40px;">
			<td align="center" style="width:25%;">
		<?php if( $primary->sam_status == 1 ): ?>
				<a href="<?= site_url('sam_budget/atm/'.$primary->id); ?>" class="btn btn-block btn-inverse"><i class="icon-list-alt"></i> RETURN TO A.T.M.</a>
		<?php else: ?>
			&nbsp;
		<?php endif; ?>
			</td>

			<td align="center" style="width:25%;"></td>	

			<td align="center" style="width:25%;"></td>

			<td align="center" style="width:25%;"></td>
		</tr>
		<tr style="background-color:#AAAAAA;height:40px;">
			<td align="center" style="width:25%;"></td>

			<td align="center" style="width:25%;"></td>
			
			<td align="center" style="width:25%;">
				<?php //if( $primary->pam_status == 1 ): ?>
					<!--<a href="<?= site_url('sam_budget/z_submit_for_approval/'.$primary->id); ?>" class="btn btn-block btn-danger"><i class="icon-certificate"></i> SUBMIT FOR APPROVAL</a>-->
				<?php //else: ?>
					&nbsp;
				<?php //endif; ?>
			</td>
		</tr>
	</table>
</div>
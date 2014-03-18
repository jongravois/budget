<?= form_open('admin/save_new_record_handler_users'); ?>
<table class="table table-bordered">
	<tr>
		<td style="35%;"><?= form_label('UserName','username'); ?></td>
		<td style="65%;"><?= form_input('username'); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Email','user_email'); ?></td>
		<td><?= form_input('user_email'); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Default Budget<br><span class="help_text">Company ID+0+Department ID<br>For Properties, enter 00 as Department Id</span>','defaultBudget'); ?></td>
		<td><?= form_input('defaultBudget'); ?></td>
	</tr>
	<tr>
		<?php 
			$ddAccessLevel = $this->admin_m->get_access_level_dd(); 
			$ddAccessLevel['propadmin'] = 'Administrator (No Access to Corporate)';
			if( $user['accessLevel'] == 'admin'):
				$ddAccessLevel['approver'] = 'Corporate Approver';
				//$ddAccessLevel['admin'] = 'Full System Administrator';
			endif;
		?>
		<td><?= form_label('Access Level','accessLevel'); ?></td>
		<td><?= form_dropdown('accessLevel',$ddAccessLevel); ?></td>
	</tr>
	<tr>
		<?php 
			$ddAccessGrp = $this->admin_m->get_access_group_dd();
			$ddAccessGrp['777'] = 'All Property Access';
			if( $user['accessLevel'] == 'admin'):
				$ddAccessGrp['888'] = 'All Corporate Department Access';
				$ddAccessGrp['999'] = 'All Budget Access';
			endif;
		?>
		<td><?= form_label('Access Group','access_group'); ?></td>
		<td><?= form_dropdown('access_group', $ddAccessGrp); ?></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:center;">
			<?= form_submit('submit', 'Submit'); ?>
		</td>
	</tr>
</table>
<?= form_close(); ?>
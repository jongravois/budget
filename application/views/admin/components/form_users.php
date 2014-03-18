<?= form_open('admin/save_record_handler_users'); ?>
<?= form_hidden('id', $record[0]['id']); ?>

<table class="table table-bordered">
	<tr>
		<td style="35%;"><?= form_label('UserName','username'); ?></td>
		<td style="65%;"><?= form_input('username',$record[0]['username']); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Email','user_email'); ?></td>
		<td><?= form_input('user_email',$record[0]['user_email']); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Default Budget<br>(Company ID+0+Department ID)<br>For Properties, enter 00 as Department Id','defaultBudget'); ?></td>
		<td><?= form_input('defaultBudget',$record[0]['defaultBudget']); ?></td>
	</tr>
	<tr>
		<?php 
			$ddAccessLevel = $this->admin_m->get_access_level_dd(); 
			if( $user['accessLevel'] == 'admin'):
				$ddAccessLevel['approver'] = 'Corporate Approver';
				$ddAccessLevel['propadmin'] = 'Administrator (No Access to Corporate)';
				//$ddAccessLevel['admin'] = 'Full System Administrator';
			endif;
		?>
		<td><?= form_label('Access Level','accessLevel'); ?></td>
		<td><?= form_dropdown('accessLevel',$ddAccessLevel,$record[0]['accessLevel']); ?></td>
	</tr>
	<tr>
		<?php 
			$ddAccessGrp = $this->admin_m->get_access_group_dd();
			if( $user['accessLevel'] == 'admin'):
				$ddAccessGrp['777'] = 'All Property Access';
				$ddAccessGrp['888'] = 'All Corporate Department Access';
				$ddAccessGrp['999'] = 'All Budget Access';
			endif;
		?>
		<td><?= form_label('Access Group','access_group'); ?></td>
		<td><?= form_dropdown('access_group', $ddAccessGrp,$record[0]['access_group']); ?></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:center;">
			<?= form_submit('submit', 'Submit'); ?>
		</td>
	</tr>
</table>
<?= form_close(); ?>
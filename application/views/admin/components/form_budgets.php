<?= form_open('admin/save_record_handler_budgets'); ?>
<?= form_hidden('id', $record[0]['id']); ?>
<table class="table table-bordered">
	<tr>
		<td style="35%;"><?= form_label('Name','name'); ?></td>
		<td style="65%;"><?= form_input('name',$record[0]['name']); ?></td>
	</tr>
	<tr>
		<td><?= form_label('State of Employment','emp_state'); ?></td>
		<td><?= form_input('emp_state',$record[0]['emp_state']); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Fiscal Start','fiscalStart'); ?></td>
		<td><?= form_input('fiscalStart',$record[0]['fiscalStart']); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Budget Email','budget_email'); ?></td>
		<td><?= form_input('budget_email',$record[0]['budget_email']); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Approver Email','approver_email'); ?></td>
		<td><?= form_input('approver_email',$record[0]['approver_email']); ?></td>
	</tr>
	<tr>
		<td><?= form_label('CM Bonus','cmBonus'); ?></td>
		<td><?= form_input('cmBonus',$record[0]['cmBonus']); ?></td>
	</tr>
	<tr>
		<?php
			if( (int)$record[0]['has_ATM'] == 1 ):
				$atmY = "checked = 'checked'";
				$atmN = "";
			else:
				$atmY = "";
				$atmN = "checked = 'checked'";
			endif;
		?>
		<td><?= form_label('Has A.T.M?','has_ATM'); ?></td>
		<td>
			<input type="radio" name="has_ATM" value="1" <?= $atmY; ?> />&nbsp;YES&nbsp;&nbsp;&nbsp;
			<input type="radio" name="has_ATM" value="0" <?= $atmN; ?> />&nbsp;NO
		</td>
	</tr>
	<tr>
		<td><?= form_label('Staff Rate by Month','staffRateByMonth'); ?></td>
		<td><?= form_input('staffRateByMonth',$record[0]['staffRateByMonth']); ?></td>
	</tr>
	<tr>
		<td><?= form_label('CIP CODE','CIP_CODE'); ?></td>
		<td><?= form_input('CIP_CODE',$record[0]['CIP_CODE']); ?></td>
	</tr>
	<tr>
		<td><?= form_label('DEPRECIATION CODE','DEPRECIATION_CODE'); ?></td>
		<td><?= form_input('DEPRECIATION_CODE',$record[0]['DEPRECIATION_CODE']); ?></td>
	</tr>
	<tr>
		<?php
			if( (int)$record[0]['CAN_ALLOCATE'] == 1 ):
				$allocY = "checked = 'checked'";
				$allocN = "";
			else:
				$allocY = "";
				$allocN = "checked = 'checked'";
			endif;
		?>
		<td><?= form_label('Can Allocate?','CAN_ALLOCATE'); ?></td>
		<td>
			<input type="radio" name="CAN_ALLOCATE" value="1" <?= $allocY; ?> />&nbsp;YES&nbsp;&nbsp;&nbsp;
			<input type="radio" name="CAN_ALLOCATE" value="0" <?= $allocN; ?> />&nbsp;NO
		</td>
	</tr>
	<tr>
		<?php $ddCoType = $this->admin_m->get_company_type_dd(); ?>
		<td><?= form_label('Company Type','companyTypeID'); ?></td>
		<td><?= form_dropdown('companyTypeID', $ddCoType,$record[0]['companyTypeID']); ?></td>
	</tr>
	<tr>
		<?php $ddAccessGrp = $this->admin_m->get_access_group_dd(); ?>
		<td><?= form_label('Access Group (dropdown)','accessGroupID'); ?></td>
		<td><?= form_dropdown('accessGroupID', $ddAccessGrp,$record[0]['accessGroupID']); ?></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:center;">
			<?= form_submit('submit', 'Submit'); ?>
		</td>
	</tr>
</table>
<?= form_close(); ?>
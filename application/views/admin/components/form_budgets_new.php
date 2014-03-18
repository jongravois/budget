<?= form_open('admin/save_new_record_handler_budgets'); ?>
<table class="table table-bordered">
	<tr>
		<td style="35%;"><?= form_label('Budget ID<br><span class="help_text">Entered as Company ID, followed by a 0 and then by Department ID for corporate or 00 for properties.</span>','id'); ?></td>
		<td style="65%;"><?= form_input('id'); ?></td>
	</tr>
	<tr>
		<td style="35%;"><?= form_label('Name','name'); ?></td>
		<td style="65%;"><?= form_input('name'); ?></td>
	</tr>
	<tr>
		<td><?= form_label('State of Employment<br><span class="help_text">Just two (2) Capital Letters','emp_state'); ?></td>
		<td><?= form_input('emp_state',$record[0]['emp_state']); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Fiscal Start<br><span class="help_text">0:January, 5:June, 6:July, 7:August</span>','fiscalStart'); ?></td>
		<td><?= form_input('fiscalStart'); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Budget Email<br><span class="help_text">Community Manager Email Address</span>','budget_email'); ?></td>
		<td><?= form_input('budget_email'); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Approver Email<br><span class="help_text">Regional Director Address</span>','approver_email'); ?></td>
		<td><?= form_input('approver_email'); ?></td>
	</tr>
	<tr>
		<td><?= form_label('CM Bonus<br><span class="help_text">Amount of annual bonus for Community Manager (100%)</span>','cmBonus'); ?></td>
		<td><?= form_input('cmBonus'); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Has A.T.M?<br><span class="help_text">Choose "Yes" if the budget projects Fixed Assets spending for 10 year segments</span>','has_ATM'); ?></td>
		<td>
			<input type="radio" name="has_ATM" value="1" />&nbsp;YES&nbsp;&nbsp;&nbsp;
			<input type="radio" name="has_ATM" value="0" />&nbsp;NO
		</td>
	</tr>
	<tr style="display:none;">
		<td><?= form_label('Staff Rate by Month<br><span class="help_text">Monthly equivalent of Unit Rental for staff</span>','staffRateByMonth'); ?></td>
		<td><?= form_input('staffRateByMonth','1'); ?></td>
	</tr>
	<tr style="display:none;">
		<td><?= form_label('CIP CODE<br><span class="help_text">Enter 0 or 1</span>','CIP_CODE'); ?></td>
		<td><?= form_input('CIP_CODE','1'); ?></td>
	</tr>
	<tr style="display:none;">
		<td><?= form_label('DEPRECIATION CODE<br><span class="help_text">Enter 0 or 1</span>','DEPRECIATION_CODE'); ?></td>
		<td><?= form_input('DEPRECIATION_CODE','1'); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Can Allocate?<br><span class="help_text">Choose "Yes" if staffing expenses can be shared amoung multiple budgets.</span>','CAN_ALLOCATE'); ?></td>
		<td>
			<input type="radio" name="CAN_ALLOCATE" value="1" />&nbsp;YES&nbsp;&nbsp;&nbsp;
			<input type="radio" name="CAN_ALLOCATE" value="0" />&nbsp;NO
		</td>
	</tr>
	<tr>
		<?php $ddCoType = $this->admin_m->get_company_type_dd(); ?>
		<td><?= form_label('Company Type<br><span class="help_text">RL stands for Residence Life</span>','companyTypeID'); ?></td>
		<td><?= form_dropdown('companyTypeID', $ddCoType); ?></td>
	</tr>
	<tr>
		<?php $ddAccessGrp = $this->admin_m->get_access_group_dd(); ?>
		<td><?= form_label('Access Group (dropdown)','accessGroupID'); ?></td>
		<td><?= form_dropdown('accessGroupID', $ddAccessGrp); ?></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:center;">
			<?= form_submit('submit', 'Submit'); ?>
		</td>
	</tr>
</table>
<?= form_close(); ?>
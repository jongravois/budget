<?= form_open('admin/save_new_record_handler_jobcodes'); ?>
<table class="table table-bordered">
	<tr>
		<td style="35%;"><?= form_label('Job Code','jobCode'); ?></td>
		<td style="65%;"><?= form_input('jobCode'); ?></td>
	</tr>
	<tr>
		<td style="35%;"><?= form_label('Title','jobTitle'); ?></td>
		<td style="65%;"><?= form_input('jobTitle'); ?></td>
	</tr>
	<tr>
		<td><?= form_label('ACR','accountCrossReference'); ?></td>
		<td><?= form_input('accountCrossReference'); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Company/Department','Company_Dept'); ?></td>
		<td><?= form_input('Company_Dept'); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Long-Term Disability Premium','Long-TermDisabilityPremium'); ?></td>
		<td><?= form_input('Long-TermDisabilityPremium','99.99'); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Short-Term Disability Premium','Short-TermDisabilityPremium'); ?></td>
		<td><?= form_input('Short-TermDisabilityPremium','99.99'); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Workers Compensation Class','wcClassCode'); ?></td>
		<td><?= form_input('wcClassCode'); ?></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:center;">
			<?= form_submit('submit', 'Submit'); ?>
		</td>
	</tr>
</table>
<?= form_close(); ?>
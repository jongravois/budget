<?= form_open('admin/save_record_handler_jobcodes'); ?>
<?= form_hidden('jobCode', $record[0]['jobCode']); ?>
<table class="table table-bordered">
	<tr>
		<td style="35%;"><?= form_label('Title','jobTitle'); ?></td>
		<td style="65%;"><?= form_input('jobTitle', $record[0]['jobTitle']); ?></td>
	</tr>
	<tr>
		<td><?= form_label('ACR','accountCrossReference'); ?></td>
		<td><?= form_input('accountCrossReference', $record[0]['accountCrossReference']); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Company/Department','Company_Dept'); ?></td>
		<td><?= form_input('Company_Dept', $record[0]['Company_Dept']); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Long-Term Disability Premium','Long-TermDisabilityPremium'); ?></td>
		<td><?= form_input('Long-TermDisabilityPremium', $record[0]['Long-TermDisabilityPremium']); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Short-Term Disability Premium','Short-TermDisabilityPremium'); ?></td>
		<td><?= form_input('Short-TermDisabilityPremium', $record[0]['Short-TermDisabilityPremium']); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Workers Compensation Class','wcClassCode'); ?></td>
		<td><?= form_input('wcClassCode', $record[0]['wcClassCode']); ?></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:center;">
			<?= form_submit('submit', 'Submit'); ?>
		</td>
	</tr>
</table>
<?= form_close(); ?>
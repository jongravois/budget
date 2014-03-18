<?= form_open('admin/save_record_handler_wcomp'); ?>
<?= form_hidden('id', $record[0]['id']); ?>
<table class="table table-bordered">
	<tr>
		<td style="35%;"><?= form_label('Code','code'); ?></td>
		<td style="65%;"><?= form_input('code',$record[0]['code']); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Description','description'); ?></td>
		<td><?= form_input('description',$record[0]['description']); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Rate (per Hundred)','ratePerHundred'); ?></td>
		<td><?= form_input('ratePerHundred',$record[0]['ratePerHundred']); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Class Code','wcClassCode'); ?></td>
		<td><?= form_input('wcClassCode',$record[0]['wcClassCode']); ?></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:center;">
			<?= form_submit('submit', 'Submit'); ?>
		</td>
	</tr>
</table>
<?= form_close(); ?>
<?= form_open('admin/save_record_handler_budget_year'); ?>
<?= form_hidden('id', $record[0]['id']); ?>
<table class="table table-bordered">
	<tr>
		<td style="35%;"><?= form_label('Name','name'); ?></td>
		<td style="65%;"><?= form_input('name', $record[0]['name']); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Default Value','value'); ?></td>
		<td><?= form_input('value', $record[0]['value']); ?></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:center;">
			<?= form_submit('submit', 'Submit'); ?>
		</td>
	</tr>
</table>
<?= form_close(); ?>
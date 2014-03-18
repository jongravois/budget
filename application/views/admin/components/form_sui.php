<?= form_open('admin/save_record_handler_sui'); ?>
<?= form_hidden('id', $record[0]['id']); ?>
<table class="table table-bordered">
	<tr>
		<td style="35%;"><?= form_label('State','state'); ?></td>
		<td style="65%;"><?= form_input('state',$record[0]['state']); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Rate','SUIrate'); ?></td>
		<td><?= form_input('SUIrate',$record[0]['SUIrate']); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Base','SUIbase'); ?></td>
		<td><?= form_input('SUIbase',$record[0]['SUIbase']); ?></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:center;">
			<?= form_submit('submit', 'Submit'); ?>
		</td>
	</tr>
</table>
<?= form_close(); ?>
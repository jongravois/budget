<?= form_open('admin/save_new_record_handler_sui'); ?>
<table class="table table-bordered">
	<tr>
		<td style="35%;"><?= form_label('State','state'); ?></td>
		<td style="65%;"><?= form_input('state'); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Rate','SUIrate'); ?></td>
		<td><?= form_input('SUIrate'); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Base','SUIbase'); ?></td>
		<td><?= form_input('SUIbase'); ?></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:center;">
			<?= form_submit('submit', 'Submit'); ?>
		</td>
	</tr>
</table>
<?= form_close(); ?>
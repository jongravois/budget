<?= form_open('admin/save_record_handler_accessgroups'); ?>
<?= form_hidden('id', $record[0]['id']); ?>
<table class="table table-bordered">
	<tr>
		<td style="35%;"><?= form_label('Name','access_group'); ?></td>
		<td style="65%;"><?= form_input('access_group', $record[0]['access_group']); ?></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:center;">
			<?= form_submit('submit', 'Submit'); ?>
		</td>
	</tr>
</table>
<?= form_close(); ?>
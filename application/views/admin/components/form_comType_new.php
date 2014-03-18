<?= form_open('admin/save_new_record_handler_comType'); ?>
<table class="table table-bordered">
	<tr>
		<td style="35%;"><?= form_label('Name','CompanyType'); ?></td>
		<td style="65%;"><?= form_input('CompanyType'); ?></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:center;">
			<?= form_submit('submit', 'Submit'); ?>
		</td>
	</tr>
</table>
<?= form_close(); ?>
<?= form_open('admin/save_new_record_handler_wcomp'); ?>
<table class="table table-bordered">
	<tr>
		<td style="35%;"><?= form_label('Code','code'); ?></td>
		<td style="65%;"><?= form_input('code'); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Description','description'); ?></td>
		<td><?= form_input('description'); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Rate (per Hundred)','ratePerHundred'); ?></td>
		<td><?= form_input('ratePerHundred'); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Class Code<br><span class="help_text">Correlates with WC Code assigned to each Job Code</span>','wcClassCode'); ?></td>
		<td><?= form_input('wcClassCode'); ?></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:center;">
			<?= form_submit('submit', 'Submit'); ?>
		</td>
	</tr>
</table>
<?= form_close(); ?>
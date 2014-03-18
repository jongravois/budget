<?= form_open('admin/save_new_record_handler_sam_asset_type'); ?>
<table class="table table-bordered">
	<tr>
		<td style="35%;"><?= form_label('Project Code','PROJECT_CODE'); ?></td>
		<td style="65%;"><?= form_input('PROJECT_CODE'); ?></td>
	</tr>
	<tr>
		<td style="35%;"><?= form_label('Asset Type','ASSET_TYPE'); ?></td>
		<td style="65%;"><?= form_input('ASSET_TYPE'); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Project Type','PROJECT_TYPE'); ?></td>
		<td><?= form_input('PROJECT_TYPE'); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Asset Class','ASSET_CLASS'); ?></td>
		<td><?= form_input('ASSET_CLASS'); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Asset Category','ASSET_CATEGORY'); ?></td>
		<td><?= form_input('ASSET_CATEGORY'); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Useful Life','USEFUL_LIFE'); ?></td>
		<td><?= form_input('USEFUL_LIFE'); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Real or Personal','REAL_PERSONAL'); ?></td>
		<td>
			<input type="radio" name="REAL_PERSONAL" value="Real" />&nbsp;REAL&nbsp;&nbsp;&nbsp;
			<input type="radio" name="REAL_PERSONAL" value="Personal" />&nbsp;PERSONAL
		</td>
	</tr>
	<tr>
		<td><?= form_label('CIP Account','CIP_ACCOUNT_NUMBER'); ?></td>
		<td><?= form_input('CIP_ACCOUNT_NUMBER'); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Depreciation Department','DEPRECIATION_DEPARTMENT'); ?></td>
		<td><?= form_input('DEPRECIATION_DEPARTMENT'); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Depreciation Account','DEPRECIATION_ACCOUNT_NUMBER'); ?></td>
		<td><?= form_input('DEPRECIATION_ACCOUNT_NUMBER'); ?></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:center;">
			<?= form_submit('submit', 'Submit'); ?>
		</td>
	</tr>
</table>
<?= form_close(); ?>
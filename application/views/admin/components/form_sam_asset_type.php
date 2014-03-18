<?= form_open('admin/save_record_handler_sam_asset_type'); ?>
<?= form_hidden('PROJECT_CODE', $record[0]['PROJECT_CODE']); ?>
<table class="table table-bordered">
	<tr>
		<td style="35%;"><?= form_label('Asset Type','ASSET_TYPE'); ?></td>
		<td style="65%;"><?= form_input('ASSET_TYPE', $record[0]['ASSET_TYPE']); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Project Type','PROJECT_TYPE'); ?></td>
		<td><?= form_input('PROJECT_TYPE', $record[0]['PROJECT_TYPE']); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Asset Class','ASSET_CLASS'); ?></td>
		<td><?= form_input('ASSET_CLASS', $record[0]['ASSET_CLASS']); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Asset Category','ASSET_CATEGORY'); ?></td>
		<td><?= form_input('ASSET_CATEGORY', $record[0]['ASSET_CATEGORY']); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Useful Life','USEFUL_LIFE'); ?></td>
		<td><?= form_input('USEFUL_LIFE', $record[0]['USEFUL_LIFE']); ?></td>
	</tr>
	<tr>
		<?php
			if( (int)$record[0]['REAL_PERSONAL'] == "Real" ):
				$rpR = "checked='checked'";
				$rpP = "";
			else:
				$rpR = "";
				$rpP = "checked='checked'";
			endif;
		?>
		<td><?= form_label('Real or Personal','REAL_PERSONAL'); ?></td>
		<td>
			<input type="radio" name="REAL_PERSONAL" value="Real" <?= $rpR; ?> />&nbsp;REAL&nbsp;&nbsp;&nbsp;
			<input type="radio" name="REAL_PERSONAL" value="Personal" <?= $rpP; ?> />&nbsp;PERSONAL
		</td>
	</tr>
	<tr>
		<td><?= form_label('CIP Account','CIP_ACCOUNT_NUMBER'); ?></td>
		<td><?= form_input('CIP_ACCOUNT_NUMBER', $record[0]['CIP_ACCOUNT_NUMBER']); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Depreciation Department','DEPRECIATION_DEPARTMENT'); ?></td>
		<td><?= form_input('DEPRECIATION_DEPARTMENT', $record[0]['DEPRECIATION_DEPARTMENT']); ?></td>
	</tr>
	<tr>
		<td><?= form_label('Depreciation Account','DEPRECIATION_ACCOUNT_NUMBER'); ?></td>
		<td><?= form_input('DEPRECIATION_ACCOUNT_NUMBER', $record[0]['DEPRECIATION_ACCOUNT_NUMBER']); ?></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:center;">
			<?= form_submit('submit', 'Submit'); ?>
		</td>
	</tr>
</table>
<?= form_close(); ?>
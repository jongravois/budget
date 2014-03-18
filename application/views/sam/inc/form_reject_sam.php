<?= form_open('sam_budget/z_sam_rejected'); ?>
	<?= form_hidden('budget', $id); ?>
<table class="table table-bordered">
	<tr>
		<td style="text-align:center;">
			<textarea name='reason' style="height:120px;width:90%;margin:0 auto;"></textarea>
		</td>
	</tr>
	<tr>
		<td style="text-align:center;">
			<input type="submit" value="SUBMIT" class="btn btn-edr" />
		</td>
	</tr>
</table>
<?= form_close(); ?>
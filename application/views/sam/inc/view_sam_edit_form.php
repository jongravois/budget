<?= form_open('sam_budget/sam_edit_project_handler'); ?>
	<table class='table table-bordered' style='width:100%; margin:0 auto;'>
		<tr>
			<td style="width:6%;">Code</td>
			<td style="width:18%;">Asset</td>
			<td style="width:10%;">Type</td>
			<td style="width:46%;">Description</td>
			<td style="width:20%;">Project Total</td>
		</tr>
		<tr>
			<td><?= $asset_code; ?></td>
			<td><?= $this->sam_m->get_asset_name($asset_code); ?></td>
			<td><?= $this->sam_m->get_asset_type($asset_code); ?></td>
			<td>
				<input type="text" class="span4" id="sam_description" name="sam_description" />
			</td>
			<td>
				<input type="text" class="span2" disabled="disabled" />
			</td>
		</tr>
		<tr>
			<td colspan="5">
				<table class='table table-bordered' style='width:80%; margin:0 auto;'>
					<tr>
						<td style="width:15%;"><?= $fiscal[0]['P_1']; ?></td>
						<td style="width:35%;">
							<div class="input-prepend">
							  <span class="add-on">$</span>
							  <input class="span2" id="SAM_P_1" name="SAM_P_1" type="text">
							</div>
						</td>
						<td style="width:15%;"><?= $fiscal[0]['P_7']; ?></td>
						<td style="width:35%;">
							<div class="input-prepend">
							  <span class="add-on">$</span>
							  <input class="span2" id="SAM_P_7" name="SAM_P_7" type="text">
							</div>
						</td>
					</tr>
					<tr>
						<td><?= $fiscal[0]['P_2']; ?></td>
						<td>
							<div class="input-prepend">
							  <span class="add-on">$</span>
							  <input class="span2" id="SAM_P_2" name="SAM_P_2" type="text">
							</div>
						</td>
						<td><?= $fiscal[0]['P_8']; ?></td>
						<td>
							<div class="input-prepend">
							  <span class="add-on">$</span>
							  <input class="span2" id="SAM_P_8" name="SAM_P_8" type="text">
							</div>
						</td>
					</tr>
					<tr>
						<td><?= $fiscal[0]['P_3']; ?></td>
						<td>
							<div class="input-prepend">
							  <span class="add-on">$</span>
							  <input class="span2" id="SAM_P_3" name="SAM_P_3" type="text">
							</div>
						</td>
						<td><?= $fiscal[0]['P_9']; ?></td>
						<td>
							<div class="input-prepend">
							  <span class="add-on">$</span>
							  <input class="span2" id="SAM_P_9" name="SAM_P_9" type="text">
							</div>
						</td>
					</tr>
					<tr>
						<td><?= $fiscal[0]['P_4']; ?></td>
						<td>
							<div class="input-prepend">
							  <span class="add-on">$</span>
							  <input class="span2" id="SAM_P_4" name="SAM_P_4" type="text">
							</div>
						</td>
						<td><?= $fiscal[0]['P_10']; ?></td>
						<td>
							<div class="input-prepend">
							  <span class="add-on">$</span>
							  <input class="span2" id="SAM_P_10" name="SAM_P_10" type="text">
							</div>
						</td>
					</tr>
					<tr>
						<td><?= $fiscal[0]['P_5']; ?></td>
						<td>
							<div class="input-prepend">
							  <span class="add-on">$</span>
							  <input class="span2" id="SAM_P_5" name="SAM_P_5" type="text">
							</div>
						</td>
						<td><?= $fiscal[0]['P_11']; ?></td>
						<td>
							<div class="input-prepend">
							  <span class="add-on">$</span>
							  <input class="span2" id="SAM_P_11" name="SAM_P_11" type="text">
							</div>
						</td>
					</tr>
					<tr>
						<td><?= $fiscal[0]['P_6']; ?></td>
						<td>
							<div class="input-prepend">
							  <span class="add-on">$</span>
							  <input class="span2" id="SAM_P_6" name="SAM_P_6" type="text">
							</div>
						</td>
						<td><?= $fiscal[0]['P_12']; ?></td>
						<td>
							<div class="input-prepend">
							  <span class="add-on">$</span>
							  <input class="span2" id="SAM_P_12" name="SAM_P_12" type="text">
							</div>
						</td>
					</tr>
					<tr><td colspan="4">&nbsp;</td></tr>
					<tr><td colspan="4" style="text-align:center;">NOTES<br>
							<textarea id="sam_notes" name="sam_notes" style="height:100px;width:90%;margin:0 auto;"></textarea>
							<br><span style="font:normal 11px sans-serif;color:#B00400;">750 of 750 characters remaining</span>
							<br><br>
							<input class="btn btn-edr btnAddNewProj" type="submit" name="submit" value="submit" />
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<?= form_hidden('budget_id', $budget_id); ?>
	<?= form_hidden('asset', $asset_code); ?>
<?= form_close(); ?>
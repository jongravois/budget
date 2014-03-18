<?php
	$CYF = '[20'.$this->globals_m->current_year() . ']';
	$CYA = '20'.$this->globals_m->current_year();
	$tots = (float)$project[0]['P1']+(float)$project[0]['P2']+(float)$project[0]['P3']+(float)$project[0]['P4']+(float)$project[0]['P5']+(float)$project[0]['P6']+(float)$project[0]['P7']+(float)$project[0]['P8']+(float)$project[0]['P9']+(float)$project[0]['P10']+(float)$project[0]['P11']+(float)$project[0]['P12'];
	if((int)$project[0]['DEPARTMENT_ID'] == 99){
		$budget_id = $project[0]['COMPANY_ID'] . '000';
	} else {
		$budget_id = $project[0]['COMPANY_ID'] . '0' . $project[0]['DEPARTMENT_ID'];
	} // end if
	$cyProjected = $cyProj[0][$CYA];
	
	$fiscal = $this->fiscal_m->get_fiscal_info( $this->budget_m->get_fiscal_by_id($budget_id));
?>
<tr><td colspan="4" style="background-color: #B00400;">
	<?php //print_r($cyProjected); ?>
	<form class="frmEditAsset" method="POST" action="<?= site_url('sam_budget/atm_edit_project_handler'); ?>">
		<table class='table table-bordered' style='width:100%; margin:0 auto;background-color: #FFFFFF;'>
			<input type="hidden" name="original_remnant" class="original_remnant" value="<?= $remnant; ?>" />
			<tr style="background-color: #FFFFFF;">
				<td style="width:6%;">Code</td>
				<td style="width:18%;">Asset</td>
				<td style="width:10%;">Type</td>
				<td style="width:36%;">Description</td>
				<td style="width:13%;">Project Total</td>
				<td style="width:17%;">Remaining for Asset</td>
			</tr>
			<tr>
				<td><?= substr($project[0]['SAM_PROJECT'],-2); ?></td>
				<td><?= $project[0]['SAM_ASSET']; ?></td>
				<td><?= $project[0]['SAM_TYPE']; ?></td>
				<td>
					<input type="text" class="span4" id="sam_description" name="sam_description" value="<?= $project[0]['SAM_DESCRIPTION']; ?>" />
				</td>
				<td>
					<input type="text" class="span2 project_total" disabled="disabled" name="project_total" value="<?= $tots; ?>" />
				</td>
				<td>
					<input type="text" class="span1 asset_remayne" disabled="disabled" name="asset_remayne" value="<?= $remnant - $tots; ?>" />
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
								  <input tabindex="1" class="span2 eSAM" id="SAM_P_1" name="SAM_P_1" type="text" value="<?= $project[0]['P1']; ?>">
								</div>
							</td>
							<td style="width:15%;"><?= $fiscal[0]['P_7']; ?></td>
							<td style="width:35%;">
								<div class="input-prepend">
								  <span class="add-on">$</span>
								  <input tabindex="7" class="span2 eSAM" id="SAM_P_7" name="SAM_P_7" type="text" value="<?= $project[0]['P7']; ?>">
								</div>
							</td>
						</tr>
						<tr>
							<td><?= $fiscal[0]['P_2']; ?></td>
							<td>
								<div class="input-prepend">
								  <span class="add-on">$</span>
								  <input tabindex="2" class="span2 eSAM" id="SAM_P_2" name="SAM_P_2" type="text" value="<?= $project[0]['P2']; ?>">
								</div>
							</td>
							<td><?= $fiscal[0]['P_8']; ?></td>
							<td>
								<div class="input-prepend">
								  <span class="add-on">$</span>
								  <input tabindex="8" class="span2 eSAM" id="SAM_P_8" name="SAM_P_8" type="text" value="<?= $project[0]['P8']; ?>">
								</div>
							</td>
						</tr>
						<tr>
							<td><?= $fiscal[0]['P_3']; ?></td>
							<td>
								<div class="input-prepend">
								  <span class="add-on">$</span>
								  <input tabindex="3" class="span2 eSAM" id="SAM_P_3" name="SAM_P_3" type="text" value="<?= $project[0]['P3']; ?>">
								</div>
							</td>
							<td><?= $fiscal[0]['P_9']; ?></td>
							<td>
								<div class="input-prepend">
								  <span class="add-on">$</span>
								  <input tabindex="9" class="span2 eSAM" id="SAM_P_9" name="SAM_P_9" type="text" value="<?= $project[0]['P9']; ?>">
								</div>
							</td>
						</tr>
						<tr>
							<td><?= $fiscal[0]['P_4']; ?></td>
							<td>
								<div class="input-prepend">
								  <span class="add-on">$</span>
								  <input tabindex="4" class="span2 eSAM" id="SAM_P_4" name="SAM_P_4" type="text" value="<?= $project[0]['P4']; ?>">
								</div>
							</td>
							<td><?= $fiscal[0]['P_10']; ?></td>
							<td>
								<div class="input-prepend">
								  <span class="add-on">$</span>
								  <input tabindex="10" class="span2 eSAM" id="SAM_P_10" name="SAM_P_10" type="text" value="<?= $project[0]['P10']; ?>">
								</div>
							</td>
						</tr>
						<tr>
							<td><?= $fiscal[0]['P_5']; ?></td>
							<td>
								<div class="input-prepend">
								  <span class="add-on">$</span>
								  <input tabindex="5" class="span2 eSAM" id="SAM_P_5" name="SAM_P_5" type="text" value="<?= $project[0]['P5']; ?>">
								</div>
							</td>
							<td><?= $fiscal[0]['P_11']; ?></td>
							<td>
								<div class="input-prepend">
								  <span class="add-on">$</span>
								  <input tabindex="11" class="span2 eSAM" id="SAM_P_11" name="SAM_P_11" type="text" value="<?= $project[0]['P11']; ?>">
								</div>
							</td>
						</tr>
						<tr>
							<td><?= $fiscal[0]['P_6']; ?></td>
							<td>
								<div class="input-prepend">
								  <span class="add-on">$</span>
								  <input tabindex="6" class="span2 eSAM" id="SAM_P_6" name="SAM_P_6" type="text" value="<?= $project[0]['P6']; ?>">
								</div>
							</td>
							<td><?= $fiscal[0]['P_12']; ?></td>
							<td>
								<div class="input-prepend">
								  <span class="add-on">$</span>
								  <input tabindex="12" class="span2 eSAM" id="SAM_P_12" name="SAM_P_12" type="text" value="<?= $project[0]['P12']; ?>">
								</div>
							</td>
						</tr>
						<tr><td colspan="4">&nbsp;</td></tr>
						<tr><td colspan="4" style="text-align:center;">NOTES<br>
								<textarea class="sam_notes maxed" maxlength="750" name="sam_notes" style="height:100px;width:90%;margin:0 auto;"><?= $project[0]['ASSET_NOTES']; ?></textarea>
								<br><span style="font:normal 11px sans-serif;color:#B00400;"><span class='counter_msg'></span></span>
								<br><br>
								<input class="btn btn-edr btnAddNewProj" type="submit" name="submit" value="submit" />
							</td>
						</tr>
					</table>
					<?= form_hidden('project_id', $project[0]['id']); ?>
					<?= form_hidden('budget_id', $budget_id); ?>
					<?= form_hidden('CY_Projected',$cyProjected); ?>
					<?= form_hidden('CY_Budgeted',$cyBudgeted[0]['budgeted']); ?>
					<?= form_hidden('PR_Total',$tots); ?>
					<?= form_hidden('asset', substr($project[0]['SAM_PROJECT'],-2)); ?>
				</td>
			</tr>
		</table>
	</form>
</td></tr>
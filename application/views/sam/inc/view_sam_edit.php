<?php
	$curr_year = (int)'20'.$this->globals_m->current_year();
	$fiscal = $this->fiscal_m->get_fiscal_info($this->budget_m->get_fiscal_by_id($budget_id));
	$projects = $this->sam_m->ajax_get_projects_for_sam($budget_id, $asset_code);
	$target = (float)$asset_cy_projection[0][$curr_year] - (float)$asset_cy_budgeted[0]['budgeted'];
?>
	<td colspan='8' style='background-color:#FFFFFF;'>
		<?php //print_r($asset_cy_budgeted); ?>
		<table class='table table-bordered sam-sub-main' style='width:80%; margin:0 auto;'>
			<tr>
				<th class="sub_sam" style="width:10%;">PROJECT</th>
				<th class="sub_sam" style="width:50%;">DESCRIPTION</th>
				<th class="sub_sam" style="width:15%;">TOTAL</th>
				<th class="sub_sam" style="width:25%;text-align:right;">
					<a class="btn btn-mini btnHideThis">X</a>
				</th>
			</tr>

			<?php if( empty($projects) ): ?>
				<tr>
					<td colspan='4' style="text-align:center;">NO PROJECTS FOUND!</td>
				</tr>
			<?php else: ?>
				<?php foreach($projects as $pj): ?>
				<?php 
					$totalTD = 0;
					for($t=1;$t<13;$t++){
						$totalTD += $pj['P'.$t];
					} // end for 
				?>
					<tr>
						<td><?= $pj['SAM_PROJECT']; ?></td>
						<td><?= $pj['SAM_DESCRIPTION']; ?></td>
						<td style="text-align:right;"><?= number_format($totalTD,2); ?></td>
						<td style="text-align:center;">
							<a class="btn btnEditProject" data-id="<?= $pj['id']; ?>"><i class="icon-pencil"></i> EDIT</a>
							&nbsp;&nbsp;
							<a class="btn btn-danger btnDeleteProject" data-id="<?= $pj['id']; ?>"><i class="icon-trash"></i> DELETE</a>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
			<tr class="rowNewForm">
				<td colspan="4" style="background-color: #B00400;">
					<form class="frmNewAssets" method="POST" action="<?= site_url('sam_budget/sam_new_project_handler'); ?>">
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
								<input type="text" class="span2 project_total" disabled="disabled" name="project_total" value="0" />
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
											  <input tabindex="1" class="span2 aSAM" id="SAM_P_1" name="SAM_P_1" type="text" value="0">
											</div>
										</td>
										<td style="width:15%;"><?= $fiscal[0]['P_7']; ?></td>
										<td style="width:35%;">
											<div class="input-prepend">
											  <span class="add-on">$</span>
											  <input tabindex="7" class="span2 aSAM" id="SAM_P_7" name="SAM_P_7" type="text" value="0">
											</div>
										</td>
									</tr>
									<tr>
										<td><?= $fiscal[0]['P_2']; ?></td>
										<td>
											<div class="input-prepend">
											  <span class="add-on">$</span>
											  <input tabindex="2" class="span2 aSAM" id="SAM_P_2" name="SAM_P_2" type="text" value="0">
											</div>
										</td>
										<td><?= $fiscal[0]['P_8']; ?></td>
										<td>
											<div class="input-prepend">
											  <span class="add-on">$</span>
											  <input tabindex="8" class="span2 aSAM" id="SAM_P_8" name="SAM_P_8" type="text" value="0">
											</div>
										</td>
									</tr>
									<tr>
										<td><?= $fiscal[0]['P_3']; ?></td>
										<td>
											<div class="input-prepend">
											  <span class="add-on">$</span>
											  <input tabindex="3" class="span2 aSAM" id="SAM_P_3" name="SAM_P_3" type="text" value="0">
											</div>
										</td>
										<td><?= $fiscal[0]['P_9']; ?></td>
										<td>
											<div class="input-prepend">
											  <span class="add-on">$</span>
											  <input tabindex="9" class="span2 aSAM" id="SAM_P_9" name="SAM_P_9" type="text" value="0">
											</div>
										</td>
									</tr>
									<tr>
										<td><?= $fiscal[0]['P_4']; ?></td>
										<td>
											<div class="input-prepend">
											  <span class="add-on">$</span>
											  <input tabindex="4" class="span2 aSAM" id="SAM_P_4" name="SAM_P_4" type="text" value="0">
											</div>
										</td>
										<td><?= $fiscal[0]['P_10']; ?></td>
										<td>
											<div class="input-prepend">
											  <span class="add-on">$</span>
											  <input tabindex="10" class="span2 aSAM" id="SAM_P_10" name="SAM_P_10" type="text" value="0">
											</div>
										</td>
									</tr>
									<tr>
										<td><?= $fiscal[0]['P_5']; ?></td>
										<td>
											<div class="input-prepend">
											  <span class="add-on">$</span>
											  <input tabindex="5" class="span2 aSAM" id="SAM_P_5" name="SAM_P_5" type="text" value="0">
											</div>
										</td>
										<td><?= $fiscal[0]['P_11']; ?></td>
										<td>
											<div class="input-prepend">
											  <span class="add-on">$</span>
											  <input tabindex="11" class="span2 aSAM" id="SAM_P_11" name="SAM_P_11" type="text" value="0">
											</div>
										</td>
									</tr>
									<tr>
										<td><?= $fiscal[0]['P_6']; ?></td>
										<td>
											<div class="input-prepend">
											  <span class="add-on">$</span>
											  <input tabindex="6" class="span2 aSAM" id="SAM_P_6" name="SAM_P_6" type="text" value="0">
											</div>
										</td>
										<td><?= $fiscal[0]['P_12']; ?></td>
										<td>
											<div class="input-prepend">
											  <span class="add-on">$</span>
											  <input tabindex="12" class="span2 aSAM" id="SAM_P_12" name="SAM_P_12" type="text" value="0">
											</div>
										</td>
									</tr>
									<tr><td colspan="4">&nbsp;</td></tr>
									<tr><td colspan="4" style="text-align:center;">NOTES<br>
											<textarea class="sam_notes maxed" maxlength="750" name="sam_notes" style="height:100px;width:90%;margin:0 auto;"></textarea>
											<br><span style="font:normal 11px sans-serif;color:#B00400;"><span class='counter_msg'></span></span>
											<br><br>
											<input class="btn btn-edr btnAddNewProj" type="submit" name="submit" value="submit" />
										</td>
									</tr>
								</table>
								<?= form_hidden('topLimit',$target); ?>
								<?= form_hidden('budget_id', $budget_id); ?>
								<?= form_hidden('asset', $asset_code); ?>
							</td>
						</tr>
					</table>
				</form>
				</td>
			</tr>
		</table>
	</td>
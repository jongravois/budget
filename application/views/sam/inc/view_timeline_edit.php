<?php
	$curr_year = (int)'20'.$this->globals_m->current_year();
	$yrs = array($curr_year-5,$curr_year-4,$curr_year-3,$curr_year-2,$curr_year-1, $curr_year, $curr_year+1, $curr_year+2,$curr_year+3,$curr_year+4);

	$co_id = substr($budget_id,0,3);
	$de_id = ( (int)substr($budget_id,-2) == 0 ? '99' : substr($budget_id,-2));
?>

<td colspan='8' style='background-color:#FFFFFF;'>
	<?= form_open('sam_budget/timeline_edit_handler'); ?>
	<?= form_hidden('bud_id_asset', ''); ?>
	<table class='table table-bordered' style='width:98%; margin:0 auto;'>
		<tr class="main_asset_row">
			<th class='dyn-row'><?= $yrs[0]; ?></th>
			<th class='dyn-row'><?= $yrs[1]; ?></th>
			<th class='dyn-row'><?= $yrs[2]; ?></th>
			<th class='dyn-row'><?= $yrs[3]; ?></th>
			<th class='dyn-row'><?= $yrs[4]; ?></th>
			<th class='dyn-row'><?= $yrs[5]; ?></th>
			<th class='dyn-row'><?= $yrs[6]; ?></th>
			<th class='dyn-row'><?= $yrs[7]; ?></th>
			<th class='dyn-row'><?= $yrs[8]; ?></th>
			<th class='dyn-row'><?= $yrs[9]; ?></th>
			<th class='dyn-row'><a class="btnHideDynRow btn btn-mini">CLOSE</a></th>
		</tr>
		<tr style="background-color:#FFFFFF;">
			<?php 
				for($t=1;$t<6;$t++ ):
					$x = (int)$t - 1;
					$year_id = substr($yrs[$x],-2);
					$annual_amount = $this->sam_m->ajax_get_timeline_amount($budget_id, $asset_code, $year_id);
					$mo_annual_amount = $this->sam_m->ajax_get_atm_total_by_asset($budget_id, $asset_code, $year_id);
					if( !$annual_amount){ $annual_amount = 0; }
					
					if( (float)$annual_amount < (float)$mo_annual_amount ){ 
						$annual_amount = $mo_annual_amount;
						echo "<td style='text-align:center;background-color:#B00400;' class='dyn-row-disabled'>"; 
					} else {
						echo "<td style='text-align:center;' class='dyn-row-disabled'>";
					} // end if
			?>
					<input type='text' class="span1 proj_total" disabled="disabled" value="$<?= number_format($annual_amount,2); ?>" name="proj_total_Y<?= $t; ?>" style="display:inline; width:56px; font-size:11px; font-weight:bold;" />
					<span class="btnShowDynDetails" data-yr="<?= $yrs[$x]; ?>" data-asset="<?= $asset_code; ?>" style="display:inline; font-size:8px;">&dArr;</span>
				</td>
			<?php endfor; ?>
			<?php $annual_amount = $this->sam_m->ajax_get_timeline_amount($budget_id, $asset_code, $yrs[5]);
			?>
				<!-- ADDED 02/25/2014 
					Also changed loop below (notes) to exclude current year
					Also in /controllers/sam_budget, modified timeline_edit_handler function to exclude current year submissions
				-->
				<td style='text-align:center;' class='dyn-row-disabled'>
					<input type='text' class="span1 proj_total" disabled="disabled" value="$<?= number_format($annual_amount,2); ?>" name="proj_total_Y6" style="display:inline; width:56px; font-size:11px; font-weight:bold;" />
				</td>
				<!-- ADDED 02/25/2014 -->
				<td style='display:none;text-align:center;' class='dyn-row-current'>
					<input type='text' id="atm_current" class='span1 dr-current' value="<?= $annual_amount; ?>" name='proj_total_Y6' data-budgetid="<?= $budget_id; ?>" data-assetcode="<?= $asset_code; ?>" />
				</td>
			<?php 
				for($t=7;$t<11;$t++ ):
					$x = (int)$t - 1;
					$year_id = substr($yrs[$x],-2);
					$annual_amount = $this->sam_m->ajax_get_timeline_amount($budget_id, $asset_code, $yrs[$x]);
					if( !$annual_amount){ $annual_amount = 0; }
			?>
				<td style='text-align:center;' class='dyn-row-future'>
					<input type='text' class='span1 dr-future' value="<?= $annual_amount; ?>" name="proj_total_Y<?= $t; ?>" />
				</td>
			<?php endfor; ?>
				<td>
					<a href='#' class='btn btn-mini btn-inverse btnSubmitTimelineEdit' data-rowid="<?= $budget_id.'|'.$asset_code; ?>">SAVE</a>
				</td>
			</tr>
			<tr class="hidden_monthly_breakdown" style="background-color:#FFFFFF;display:none;">
				<td colspan="11">
					<div class="project_breakdown_by_month"></div>
				</td>
			</tr>
			<tr style="background-color:#FFFFFF;">
				<?php 
					for($t=1;$t<7;$t++ ):
						$x = (int)$t - 1;
						$year_id = substr($yrs[$x],-2);
						$knotes = $this->sam_m->ajax_get_timeline_note($budget_id, $asset_code, $yrs[$x]);
						if(!$knotes){ $knotes = '';}
				?>
					<td style="text-align:center;width:9%;">
						<span><?= $yrs[$x]; ?> Notes</span>
						<br>
						<span class="dyn-notes"><?= substr($knotes,0,150); ?></span>
						<?php if( strlen($knotes) > 150 ): ?>
							<span style="font-weight: bold; font-size: 10px;">
							 	... <a href="#" class = "btn btn-mini btnMoreNote" data-budget="<?= $budget_id; ?>" data-asset="<?= $asset_code; ?>" data-bYear = "<?= $yrs[$x]; ?>">MORE</a>
							</span>
						<?php endif; ?>
					</td>
				<?php endfor; ?>
				<?php 
					for($t=7;$t<11;$t++ ):
						$x = (int)$t - 1;
						$year_id = substr($yrs[$x],-2);
						$knotes = $this->sam_m->ajax_get_timeline_note($budget_id, $asset_code, $yrs[$x]);
						if(!$knotes){ $knotes = '';}
				?>
					<td style="text-align:center;width:9%;">
						<span><?= $yrs[$x]; ?> Notes</span>
						<br>
						<textarea class="popTA" name="notes_Y<?= $t; ?>" style="width:90%;min-height:200px;"><?= $knotes; ?></textarea>
					</td>
				<?php endfor; ?>
				<td>&nbsp;</td>
			</tr>
	</table>
	<?= form_close(); ?>
</td>
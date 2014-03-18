<?php
	$curr_year = (int)'20'.$this->globals_m->current_year();
	$yrs = array($curr_year-5,$curr_year-4,$curr_year-3,$curr_year-2,$curr_year-1, $curr_year, $curr_year+1, $curr_year+2,$curr_year+3,$curr_year+4);

	$co_id = substr($budget_id,0,3);
	$de_id = ( (int)substr($budget_id,-2) == 0 ? '99' : substr($budget_id,-2));
?>

<td colspan='8' style='background-color:#FFFFFF;'>
	<?= form_open('sam_budget/timeline_view_handler'); ?>
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
				for($t=1;$t<11;$t++ ):
					$x = (int)$t - 1;
					$year_id = substr($yrs[$x],-2);
					$annual_amount = $this->sam_m->ajax_get_timeline_amount($budget_id, $asset_code, $yrs[$x]);
					if(!$annual_amount){ $annual_amount = 0; }
			?>
				<td style='text-align:center;' class='dyn-row-disabled'>
					<input type='text' class="span1" disabled="disabled" value="$<?= number_format($annual_amount,2); ?>" name="proj_total_Y<?= $t; ?>" style="display:inline; width:56px; font-size:11px; font-weight:bold;" />
					<span class="btnShowDynDetails" data-yr="<?= $yrs[$x]; ?>" data-asset="<?= $asset_code; ?>" style="display:inline; font-size:8px;">&dArr;</span>
				</td>
			<?php endfor; ?>
				<td class='dyn-row-disabled'>&nbsp;</td>
			</tr>
			<tr class="hidden_monthly_breakdown" style="background-color:#FFFFFF;display:none;">
				<td colspan="11">
					<div class="project_breakdown_by_month"></div>
				</td>
			</tr>
			
			<tr style="background-color:#FFFFFF;">
				<?php 
					for($t=1;$t<11;$t++ ):
						$x = (int)$t - 1;
						$year_id = substr($yrs[$x],-2);
						$knotes = $this->sam_m->ajax_get_timeline_note($budget_id, $asset_code, $yrs[$x]);
						if(!$knotes){ $knotes = '';}
				?>
				<td style="text-align:center;">
					<span><?= $yrs[$x]; ?> Notes</span>
					<br>
					<span class="dyn-notes">
						<?= substr($knotes,0,150); ?>
						<?php if( strlen($knotes) > 150 ): ?>
							 <span style="font-weight: bold; font-size: 10px;">
							 	... <a href="#" class = "btn btn-mini btnMoreNote" data-budget="<?= $budget_id; ?>" data-asset="<?= $asset_code; ?>" data-bYear = "<?= $yrs[$x]; ?>">MORE</a>
							 </span>
						<?php endif; ?>
					</span>
				</td>
				<?php endfor; ?>
				<td>&nbsp;</td>	
			</tr>

		<tr style="background-color:#1b6633;">
			<td style='width:9%;background-color:#1b6633;'>&nbsp;</td>
			<td style='width:9%;background-color:#1b6633;'>&nbsp;</td>
			<td style='width:9%;background-color:#1b6633;'>&nbsp;</td>
			<td style='width:9%;background-color:#1b6633;'>&nbsp;</td>
			<td style='width:9%;background-color:#1b6633;'>&nbsp;</td>
			<td style='width:9%;background-color:#1b6633;'>&nbsp;</td>
			<td style='width:9%;background-color:#1b6633;'>&nbsp;</td>
			<td style='width:9%;background-color:#1b6633;'>&nbsp;</td>
			<td style='width:9%;background-color:#1b6633;'>&nbsp;</td>
			<td style='width:9%;background-color:#1b6633;'>&nbsp;</td>
			<td style='width:9%;background-color:#1b6633;'>&nbsp;</td>
		</tr>
	</table>
	<?= form_close(); ?>
</td>
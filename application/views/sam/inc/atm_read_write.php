<style>
	th{ 
		background-color: #404040;
		color:#FFFFFF;
		font-size: 12px;
		text-align: left;
	}
	tr:nth-child(even){ background-color:#eee;}
	tr.emp_grid{
		height:36px;
	}
	tr.emp_grid>td{
		font-size: 16px;
	}
</style>

<?php
	//print_r($primary);die();
	$current_year = $this->globals_m->current_year();
	$flagfb = 0;

	$atm = $this->sam_m->get_company_atm($primary->id);
	$cy_total = $this->sam_m->get_company_atm_CY_totals($primary->id);
	$cyTotal = 0;
	foreach($cy_total as $cyt){ $cyTotal += $cyt['TOTAL']; } // end foreach
	$budded = $this->sam_m->get_company_curryear_budgeted($primary->id);
	
	$cyrem = (float)$cyTotal - (float)$budded;
	if( count($atm) < 1 ):
?>
	<table style="width:100%; margin:0 auto; overflow-x:auto;">
		<tr>
			<th style="width:2%;">&nbsp;</th>
			<th style="width:3%;">CODE</th>
			<th style="width:20%;">ASSETS</th>
			<th style="width:12%;">PROJECT TYPE</th>
			<th style="width:10%;">CY PROJECTION</th>
			<th style="width:10%;">CY BUDGETED</th>
			<th style="width:10%;">CY REMAINING</th>
			<th style="width:30%;">&nbsp;</th>
		</tr>
		<tr><td colspan="8" align="center"><strong>NO ASSETS FOUND!</strong></td></tr>
		<tr><td colspan="8">&nbsp;</td></tr>
	</table>
<?php else: ?>
	<table class="table table-bordered" style="width:100%; margin:0 auto;">
		<?php $cyPercent = (float) $budded / (float) $cyTotal * 100; ?>
		<tr>
			<td colspan="4" style="text-align:center;"><b>COMPANY CURRENT YEAR TOTAL</b></td>
			<td style="padding-right:10px;text-align:right;font-weight:bold;">$<?= number_format($cyTotal,2); ?></td>
			<td style="padding-right:10px;text-align:right;font-weight:bold;">$<?= number_format($budded,2); ?></td>
			<td style="padding-right:10px;text-align:right;font-weight:bold;">
					$<?= number_format($cyrem,2); ?>
			</td>
			<td style="padding-right:10px;text-align:leftt;font-weight:bold;">Budget Completion: <?= number_format($cyPercent,0); ?>%</td>
		</tr>
		<tr>
			<th style="width:2%;">&nbsp;</th>
			<th style="width:3%;">CODE</th>
			<th style="width:19%;">ASSETS</th>
			<th style="width:10%;">PROJECT TYPE</th>
			<th style="width:11%;">CY PROJECTION</th>
			<th style="width:11%;">CY BUDGETED</th>
			<th style="width:11%;">CY REMAINING</th>
			<th style="width:30%;">&nbsp;</th>
		</tr>
		
		<?php foreach($atm as $row): ?>
			<?php $budgeted = $this->sam_m->get_asset_total($primary->id, $row['PROJECT_CODE']); ?>
			<?php $remaining = ($row['AMOUNT']-$budgeted); ?>
			<?php $asset_projection = $this->sam_m->get_cy_budget_for_asset($primary->id, $row['PROJECT_CODE']); ?>
			<?php $mo_pri = $this->sam_m->ajax_get_monthly_total_by_year($primary->id, $row['PROJECT_CODE'], $current_year); ?>

			<?php if( (float)$budgeted > (float) $asset_projection ): ?>
				<tr class="major_values_row overdraft">
			<?php else: ?>
				<tr class="major_values_row">
			<?php endif; ?>
			
				<td>&nbsp;</td>
				<td><?= $row['PROJECT_CODE']; ?></td>
				<td><?= $row['ASSET_TYPE']; ?></td>
				<td style="text-align:center;"><?= $row['PROJECT_TYPE']; ?></td>
				<td style="padding-right:10px;text-align:right;">$<?= number_format($row['AMOUNT'],2) . '<br>' . $mo_pri['year_total']; ?></td>
				<td style="padding-right:10px;text-align:right;">$<?= number_format($budgeted,2); ?></td>
				<td class="cyrem" style="padding-right:10px;text-align:right;">
						<?= number_format($remaining,2); ?>
				</td>
				<td data-id="<?= $primary->id . '|' . $row['PROJECT_CODE']; ?>">
				<?php if( $primary->atm_status == 1): ?>
					<a class="btn btn-inverse btnEditTimeline" data-id="<?= $primary->id . '|' . $row['PROJECT_CODE']; ?>"><i class="icon-th"></i>  Edit A.T.M.</a>
				<?php else: ?>
					<a class="btn btn-inverse btnShowTimeline" data-id="<?= $primary->id . '|' . $row['PROJECT_CODE']; ?>"><i class="icon-check"></i>  Show A.T.M.</a>
				<?php endif; ?>
				&nbsp;
				<?php if($row['AMOUNT'] != 0 || $row['AMOUNT' ] != '' ): ?>
					<a href="<?= site_url('sam_budget/budget/'.$primary->id.'/'.$row['PROJECT_CODE']); ?>" class="btn btn-edr btnEditBudget"><i class="icon-edit"></i> Edit Budget</a>
				<?php endif; ?>
				</td>
			</tr>
			<tr class="dym_row" style="display:none;"></tr>
		<?php endforeach; ?>
		<tr><td colspan="8">&nbsp;</td></tr>
	</table>
<?php endif; ?>
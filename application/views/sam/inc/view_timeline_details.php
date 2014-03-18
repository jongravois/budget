<?php
// Array ( [budget_id] => 300000 [year_id] => 12 [asset_code] => 01 )
$curr_year = (int)'20'.$this->globals_m->current_year();
$yrs = array($curr_year-5,$curr_year-4,$curr_year-3,$curr_year-2,$curr_year-1, $curr_year, $curr_year+1, $curr_year+2,$curr_year+3,$curr_year+4);

$budget = $this->budget_m->get_one_budget($budget_id);
$fiscal = $this->fiscal_m->get_fiscal_info($budget[0]['fiscalStart']);

$amountMonths = $this->sam_m->ajax_get_monthly_total_by_year($budget_id, $asset_code, $year_id);
//var_dump($amountMonths);die();
$totle = (float)$amountMonths[0]['P_1'] + (float)$amountMonths[0]['P_2'] + (float)$amountMonths[0]['P_3'] + (float)$amountMonths[0]['P_4'] + (float)$amountMonths[0]['P_5'] + (float)$amountMonths[0]['P_6'] + (float)$amountMonths[0]['P_7'] + (float)$amountMonths[0]['P_8'] + (float)$amountMonths[0]['P_9'] + (float)$amountMonths[0]['P_10'] + (float)$amountMonths[0]['P_11'] + (float)$amountMonths[0]['P_12'];

if( (float)$totle == 0 || (float)$totle == '' ):
?>
	<td colspan="11" style="background-color:#FFFFFF;">
		<b>There is no monthly breakdown on file for this asset for this period.</b>
	</td>
<?php //elseif( (float)$totle != (float)$year_total): ?>
	<!-- <td colspan="11" style="background-color:#FFFFFF;">
		<b>Houston, we have a problem!</b>
	</td> -->
<?php else: ?>
	<style>
		td.lblMonth{ text-align: center; background-color:#BBB;}
	</style>

	<td colspan="11" style="background-color:#FFFFFF;">
		<table class='table table-bordered' style='width:60%; margin:0 auto;'>
			<tr style="background-color:#B00400;">
				<td colspan="8" style="color:#FFF; text-align:center; font-weight:bold;">
					Monthly Breakdown for 20<?= $year_id; ?>
					&nbsp;&nbsp;&nbsp;<i class="icon-remove-sign icon-white btnBreakdownHide"></i>
				</td>
			</tr>
			<tr style="background-color:#FFFFFF;">
				<td style="width:12.5%" class="lblMonth"><?= $fiscal[0]['P_1_a']; ?></td>
				<td style="width:12.5%">$<?= number_format($amountMonths[0]['P_1'],2); ?></td>
				<td style="width:12.5%" class="lblMonth"><?= $fiscal[0]['P_4_a']; ?></td>
				<td style="width:12.5%">$<?= number_format($amountMonths[0]['P_4'],2); ?></td>
				<td style="width:12.5%" class="lblMonth"><?= $fiscal[0]['P_7_a']; ?></td>
				<td style="width:12.5%">$<?= number_format($amountMonths[0]['P_7'],2); ?></td>
				<td style="width:12.5%" class="lblMonth"><?= $fiscal[0]['P_10_a']; ?></td>
				<td style="width:12.5%">$<?= number_format($amountMonths[0]['P_10'],2); ?></td>
			</tr>
			<tr style="background-color:#FFFFFF;">
				<td style="width:12.5%" class="lblMonth"><?= $fiscal[0]['P_2_a']; ?></td>
				<td style="width:12.5%">$<?= number_format($amountMonths[0]['P_2'],2); ?></td>
				<td style="width:12.5%" class="lblMonth"><?= $fiscal[0]['P_5_a']; ?></td>
				<td style="width:12.5%">$<?= number_format($amountMonths[0]['P_5'],2); ?></td>
				<td style="width:12.5%" class="lblMonth"><?= $fiscal[0]['P_8_a']; ?></td>
				<td style="width:12.5%">$<?= number_format($amountMonths[0]['P_8'],2); ?></td>
				<td style="width:12.5%" class="lblMonth"><?= $fiscal[0]['P_11_a']; ?></td>
				<td style="width:12.5%">$<?= number_format($amountMonths[0]['P_11'],2); ?></td>
			</tr>
			<tr style="background-color:#FFFFFF;">
				<td style="width:12.5%" class="lblMonth"><?= $fiscal[0]['P_3_a']; ?></td>
				<td style="width:12.5%">$<?= number_format($amountMonths[0]['P_3'],2); ?></td>
				<td style="width:12.5%" class="lblMonth"><?= $fiscal[0]['P_6_a']; ?></td>
				<td style="width:12.5%">$<?= number_format($amountMonths[0]['P_6'],2); ?></td>
				<td style="width:12.5%" class="lblMonth"><?= $fiscal[0]['P_9_a']; ?></td>
				<td style="width:12.5%">$<?= number_format($amountMonths[0]['P_9'],2); ?></td>
				<td style="width:12.5%" class="lblMonth"><?= $fiscal[0]['P_12_a']; ?></td>
				<td style="width:12.5%">$<?= number_format($amountMonths[0]['P_12'],2); ?></td>
			</tr>
			<tr style="background-color:#FFFFFF;">
				<td colspan="6">&nbsp;</td>
				<td class="lblMonth">TOTAL</td>
				<td>$<?= number_format($totle,2); ?></td>
			</tr>
		</table>
	</td>
<?php endif; ?>
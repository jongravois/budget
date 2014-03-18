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
	if($this->uri->segment(4)):
		$asset_code = $this->uri->segment(4);
		$projects = $this->sam_m->get_asset_projects_for_sam($primary->id, $asset_code);
	else:
		$projects = $this->sam_m->get_all_projects_for_sam($primary->id);
	endif;
	
	//print_r($projects); die();

	$curr_year = (int)'20'.$this->globals_m->current_year();
	$fiscal = $this->fiscal_m->get_fiscal_info($this->budget_m->get_fiscal_by_id($primary->id));
?>
	<td colspan='8' style='background-color:#FFFFFF;'>
		<?php //print_r($asset_cy_budgeted); ?>
		<table class='table table-bordered sam-sub-main' style='width:80%; margin:0 auto;'>
			<tr>
				<th class="sub_sam" style="width:10%;">PROJECT</th>
				<th class="sub_sam" style="width:50%;">DESCRIPTION</th>
				<th class="sub_sam" style="width:15%;">TOTAL</th>
				<th class="sub_sam" style="width:25%;text-align:right;">&nbsp;</th>
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
							<a class="btn btnViewProject" data-id="<?= $pj['id']; ?>"><i class="icon-pencil"></i> VIEW</a>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</table>
	</td>
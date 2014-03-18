<div class="span12">
	<table cellpadding="6" style="width:94%;">
		<tr style="background-color:#AAAAAA; height:40px;">
			<td align="center" style="width:30%;">
				<?php if( $primary->sam_status == 1 ): ?>
					<a id="btnSnR2PM" href="<?= site_url('sam_budget/dashboard'); ?>" class="btn btn-block"><i class="icon-home"></i> RETURN TO PM</a>
				<?php else: ?>
					&nbsp;
				<?php endif; ?>
			</td>

			<td align="center" style="width:40%;">
				<div class="btn-group dropup">
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				    	<i class="icon-folder-open"></i>&nbsp;REPORTS
				    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				    <span class="caret"></span>
				  	</a>
				  	<ul class="dropdown-menu">
				  		<li>
							<a target="_blank" style="text-align:left;" class="btn btn-block btnReports" href="<?= site_url('admin/denied'); ?>" data-link="http://reports.edrtrust.com/ReportServer?/PamSamIV/SAM11000_PM_Summary_Report&unit=<?= $primary->id; ?>">
								<i class="icon-list-alt"></i>&nbsp;&nbsp;&nbsp;PM Summary&nbsp;&nbsp;&nbsp;
							</a> <!-- SAM11000 -->
						</li>
						<li style="text-align:left;">
							<a target="_blank" style="text-align:left;" class="btn btn-block btnReports" href="<?= site_url('admin/denied'); ?>" data-link="http://reports.edrtrust.com/ReportServer?/PamSamIV/SAM11100_PM_Fixed_Asset_Report&unit=<?= $primary->id; ?>">
								<i class="icon-list-alt"></i>&nbsp;&nbsp;&nbsp;PM Fixed Asset Report&nbsp;&nbsp;&nbsp;
							</a> <!-- SAM11100 -->
						</li>
						<li style="text-align:left;">
							<a target="_blank" style="text-align:left;" class="btn btn-block btnReports" href="<?= site_url('admin/denied'); ?>" data-link="http://reports.edrtrust.com/ReportServer?/PamSamIV/SAM10400_10Year_CapEx_Projection_Notes&unit=<?= $primary->id; ?>">
								<i class="icon-list-alt"></i>&nbsp;&nbsp;&nbsp;Capital Spend Notes&nbsp;&nbsp;&nbsp;
							</a>
						</li>
					</ul>
				</div>
			</td>	

			<td align="center" style="width:30%;">
				<?php if( $primary->sam_status == 1 ): ?>
					<a href="<?= site_url('sam_budget/z_sam_submit_for_approval/'.$primary->id); ?>" class="btn btn-block btn-danger"><i class="icon-certificate"></i> SUBMIT FOR APPROVAL</a>
				<?php else: ?>
					&nbsp;
				<?php endif; ?>
			</td>
		</tr>
	</table>
</div>
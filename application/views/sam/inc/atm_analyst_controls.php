<div class="span12">
	<table cellpadding="2" style="width:94%;">
		<tr style="background-color:#AAAAAA;">
			<td style="width:25%;">
				<a href="<?= site_url('sam_budget/dashboard'); ?>" class="btn">
					<i class="icon-th"></i> DASHBOARD
				</a>
			</td>
			<td style="width:25%;">&nbsp;</td>
			<td style="width:25%;">
				<div class="btn-group dropup">
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				    	<i class="icon-folder-open"></i>&nbsp;REPORTS
				    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				    <span class="caret"></span>
				  	</a>
				  	<ul class="dropdown-menu">
						<li style="text-align:left;">
							<a target="_blank" style="text-align:left;" class="btn btn-block btnReports" href="<?= site_url('admin/denied'); ?>" data-link="http://reports.edrtrust.com/ReportServer?/PamSamIV/SAM11000_PM_Summary_Report&unit=<?= $primary->id; ?>"> <!-- SAM11000 -->
								<i class="icon-list-alt"></i>&nbsp;&nbsp;&nbsp;PM Summary&nbsp;&nbsp;&nbsp;
							</a>
						</li>
						<li style="text-align:left;">
							<a target="_blank" style="text-align:left;" class="btn btn-block btnReports" href="<?= site_url('admin/denied'); ?>" data-link="http://reports.edrtrust.com/ReportServer?/PamSamIV/SAM11100_PM_Fixed_Asset_Report&unit=<?= $primary->id; ?>"> <!-- SAM11100 -->
								<i class="icon-list-alt"></i>&nbsp;&nbsp;&nbsp;PM Fixed Asset Report&nbsp;&nbsp;&nbsp;
							</a>
						</li>
						<?php if( in_array($user['access_group'], array('777','888', '999') )): ?>
						<li style="text-align:left;">
							<a target="_blank" style="text-align:left;" class="btn btn-block" href="http://reports.edrtrust.com/ReportServer?/PamSamIV/SAM10100_10Year_CapEx_by_Company">
								<i class="icon-list-alt"></i>&nbsp;&nbsp;&nbsp;Company Capital Spend Projection&nbsp;&nbsp;&nbsp;
							</a>
						</li>
						<?php endif; ?>
						<li style="text-align:left;">
							<a target="_blank" style="text-align:left;" class="btn btn-block btnReports" href="<?= site_url('admin/denied'); ?>" data-link="http://reports.edrtrust.com/ReportServer?/PamSamIV/SAM10200_10Year_CapEx_by_Project_Code&unit=<?= $primary->id; ?>">
								<i class="icon-list-alt"></i>&nbsp;&nbsp;&nbsp;Project Capital Spend Projection&nbsp;&nbsp;&nbsp;
							</a>
						</li>
						<?php if( in_array($user['access_group'], array('777','888', '999') )): ?>
						<li style="text-align:left;">
							<a target="_blank" style="text-align:left;" class="btn btn-block" href="http://reports.edrtrust.com/ReportServer?/PamSamIV/SAM10300_CapEx_By_Asset_Types"> <!-- SAM10300 -->
								<i class="icon-list-alt"></i>&nbsp;&nbsp;&nbsp;Annual Capital Spend&nbsp;&nbsp;&nbsp;
							</a>
						</li>
						<?php endif; ?>
						<li style="text-align:left;">
							<a target="_blank" style="text-align:left;" class="btn btn-block btnReports" href="<?= site_url('admin/denied'); ?>" data-link="http://reports.edrtrust.com/ReportServer?/PamSamIV/SAM10400_10Year_CapEx_Projection_Notes&unit=<?= $primary->id; ?>">
								<i class="icon-list-alt"></i>&nbsp;&nbsp;&nbsp;Capital Spend Notes&nbsp;&nbsp;&nbsp;
							</a>
						</li>
						<?php if( in_array($user['access_group'], array('777','888', '999') )): ?>
						<li style="text-align:left;">
							<a target="_blank" style="text-align:left;" class="btn btn-block" href="http://reports.edrtrust.com/ReportServer?/PamSamIV/SAM10500_Capital_Spend_Projection">
								<i class="icon-list-alt"></i>&nbsp;&nbsp;&nbsp;Prior Year Projection Variance&nbsp;&nbsp;&nbsp;
							</a>
						</li>
						<?php endif; ?>
						<li style="text-align:left;">
							<a target="_blank" style="text-align:left;" class="btn btn-block btnReports" href="<?= site_url('admin/denied'); ?>" data-link="http://reports.edrtrust.com/ReportServer?/PamSamIV/SAM10600_Capital_Spend_Projection_by_Project_Code&unit=<?= $primary->id; ?>">
								<i class="icon-list-alt"></i>&nbsp;&nbsp;&nbsp;Prior Year Project Variance&nbsp;&nbsp;&nbsp;
							</a>
						</li>
						<?php if( in_array($user['access_group'], array('777','888', '999') )): ?>
						<li style="text-align:left;">
							<a target="_blank" style="text-align:left;" class="btn btn-block" href="http://reports.edrtrust.com/ReportServer?/PamSamIV/SAM10700_CapEx_Proj_vs_Budget_by_Company">
								<i class="icon-list-alt"></i>&nbsp;&nbsp;&nbsp;Capital Spend vs Budget&nbsp;&nbsp;&nbsp;
							</a>
						</li>
						<?php endif; ?>
						<li style="text-align:left;">
							<a target="_blank" style="text-align:left;" class="btn btn-block btnReports" href="<?= site_url('admin/denied'); ?>" data-link="http://reports.edrtrust.com/ReportServer?/PamSamIV/SAM10800_CapEx_Proj_vs_Budget_by_Project_Code&unit=<?= $primary->id; ?>">
								<i class="icon-list-alt"></i>&nbsp;&nbsp;&nbsp;Capital Spend vs Budget by Project&nbsp;&nbsp;&nbsp;
							</a>
						</li>
					</ul>
				</div>
			</td>
			<td style="width:25%;">&nbsp;</td>	
		</tr>
	</table>
</div>
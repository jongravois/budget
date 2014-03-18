<div class="span12">
	<table cellpadding="6" style="width:94%;">
		<tr style="background-color:#AAAAAA; height:40px;">
			<td rowspan="2" align="center" style="width:25%;">
		<?php if( $primary->pam_status == 1 ): ?>
				<a href="<?= site_url('pam_budget/add_emp/'.$primary->id); ?>" class="btn btn-block btn-inverse"><i class="icon-plus"></i> ADD EMPLOYEE</a>
		<?php else: ?>
			&nbsp;
		<?php endif; ?>
			</td>
			
			<td align="center" style="width:25%;">
		<?php if( $primary->pam_status == 1 && in_array((int)$primary->companyTypeID, array(3,5) ) ): ?>
			<a href="<?= site_url('pam_budget/edit_property_bonuses/'.$primary->id); ?>" class="btn btn-block"><i class="icon-star"></i> EDIT PROPERTY BONUSES</a>
		<?php elseif( $primary->pam_status == 1 && in_array((int)$primary->companyTypeID, array(4,6) ) ): ?>
			<a href="<?= site_url('pam_budget/edit_property_bonuses/'.$primary->id); ?>" class="btn btn-block"><i class="icon-fire"></i> EDIT DINING BONUSES</a>
		<?php else: ?>
				&nbsp;
		<?php endif; ?>
			</td>	
				
			<td rowspan="2" align="center" style="width:25%;">
				<div class="btn-group dropup">
				  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				    <i class="icon-folder-open"></i>&nbsp;REPORTS
				    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				    <span class="caret"></span>
				  </a>
				  <ul class="dropdown-menu">
					<li style="text=align:left;">
				    	<a target="_blank" href="<?= site_url('admin/denied'); ?>" data-link="http://reports.edrtrust.com/ReportServer?/PAMSAMIV/PAM10100_Employee_Summary&year=<?= $this->globals_m->current_year(); ?>&unit=<?= $primary->id; ?>" class="btn btn-block btnReports">
						<i class="icon-list-alt"></i>&nbsp;&nbsp;&nbsp;Summary Report&nbsp;&nbsp;&nbsp;</a>
					</li>
					<li style="text=align:left;">
				    	<a target="_blank"  href="<?= site_url('admin/denied'); ?>" data-link="http://reports.edrtrust.com/ReportServer?/PAMSAMIV/PAM10400_Employee_Detail_by_Property&year=<?= $this->globals_m->current_year(); ?>&unit=<?= $primary->id; ?>" class="btn btn-block btnReports">
						<i class="icon-road"></i>&nbsp;&nbsp;&nbsp;PM Out Report&nbsp;&nbsp;&nbsp;</a>
					</li>
					<li style="text=align:left;">
						<a target="_blank"  href="<?= site_url('admin/denied'); ?>" data-link="http://reports.edrtrust.com/ReportServer?/PAMSAMIV/PAM10300_Tie_Out_Reports&year=<?= $this->globals_m->current_year(); ?>&unit=<?= $primary->id; ?>" class="btn btn-block btnReports">
						<i class="icon-wrench"></i>&nbsp;&nbsp;&nbsp;Tie-Out Reports&nbsp;&nbsp;&nbsp;</a>
					</li>
					<li style="text=align:left;">
						<a target="_blank"  href="<?= site_url('admin/denied'); ?>" data-link="http://reports.edrtrust.com/ReportServer?/PamSamIV/PAM10500_Salary_Adjustments&year=<?= $this->globals_m->current_year(); ?>&unit=<?= $primary->id; ?>" class="btn btn-block btnReports">
							<i class="icon-signal"></i>&nbsp;&nbsp;&nbsp;Salary Adjustment Report</a>
					</li>
				  </ul>
				</div>
			</td>
			<td align="center" style="width:25%;">
				<?php if( $primary->pam_status == 1 ): ?>
					<a id="btnSnR2PM" href="<?= site_url('pam_budget/dashboard'); ?>" class="btn btn-block"><i class="icon-home"></i> SAVE &amp; RETURN TO PM</a>
				<?php else: ?>
					&nbsp;
				<?php endif; ?>
			</td>
		</tr>
		<tr style="background-color:#AAAAAA;height:40px;">
			<td align="center" style="width:25%;">
				<?php if( $primary->pam_status == 1  && in_array((int)$primary->companyTypeID, array(3,4,5,6) )): ?>
						<a href="<?= site_url('pam_budget/edit_turn/'.$primary->id); ?>" class="btn btn-block"><i class="icon-edit"></i> EDIT TURN EMPLOYEES</a>
				<?php else: ?>
					&nbsp;
				<?php endif; ?>
			</td>

			<!-- <td align="center" style="width:25%;"> -->
				<!-- <a target="_blank" href="http://reports.edrtrust.com/Reports/Pages/Report.aspx?ItemPath=/PamSamIV/PAM10300_Tie_Out_Reports" class="btn btn-block"><i class="icon-search"></i> ANALYSIS REPORTS</a> -->
			<!-- </td> -->
			
			<td align="center" style="width:25%;">
				<?php if( $primary->pam_status == 1 ): ?>
					<a href="<?= site_url('pam_budget/z_submit_for_approval/'.$primary->id); ?>" class="btn btn-block btn-danger"><i class="icon-certificate"></i> SUBMIT FOR APPROVAL</a>
				<?php else: ?>
					&nbsp;
				<?php endif; ?>
			</td>
		</tr>
	</table>
</div>
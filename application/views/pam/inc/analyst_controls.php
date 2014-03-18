<style>#control_panel .btn{ min-width: 250px; }</style>
<table cellpadding="6" style="width:100%;">
	<tr style="background-color:#AAAAAA; height:40px;">
		<td align="center">
			<a href="<?= site_url('pam_budget/dashboard'); ?>" class="btn"><i class="icon-th"></i> DASHBOARD</a>
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
			    <li style="text=align:left;">
			    	<a target="_blank" href="http://reports.edrtrust.com/ReportServer?/PAMSAMIV/PAM10100_Employee_Summary&year=<?= $this->globals_m->current_year(); ?>&unit=<?= $primary->id; ?>" class="btn btn-block">
					<i class="icon-list-alt"></i>&nbsp;&nbsp;&nbsp;Summary Report&nbsp;&nbsp;&nbsp;</a>
				</li>
				<li style="text=align:left;">
			    	<a target="_blank" href="http://reports.edrtrust.com/ReportServer?/PAMSAMIV/PAM10400_Employee_Detail_by_Property&year=<?= $this->globals_m->current_year(); ?>&unit=<?= $primary->id; ?>" class="btn btn-block">
					<i class="icon-road"></i>&nbsp;&nbsp;&nbsp;PM Out Report&nbsp;&nbsp;&nbsp;</a>
				</li>
				<li style="text=align:left;">
					<a target="_blank" href="http://reports.edrtrust.com/ReportServer?/PAMSAMIV/PAM10300_Tie_Out_Reports&year=<?= $this->globals_m->current_year(); ?>&unit=<?= $primary->id; ?>" class="btn btn-block">
					<i class="icon-wrench"></i>&nbsp;&nbsp;&nbsp;Tie-Out Reports&nbsp;&nbsp;&nbsp;</a>
				</li>
				<li style="text=align:left;">
					<a target="_blank" href="http://reports.edrtrust.com/ReportServer?/PamSamIV/PAM10500_Salary_Adjustments&year=<?= $this->globals_m->current_year(); ?>&unit=<?= $primary->id; ?>" class="btn btn-block">
						<i class="icon-signal"></i>&nbsp;&nbsp;&nbsp;Salary Adjustment Report</a>
				</li>
			  </ul>
			</div></td>
		<td style="width:25%;">&nbsp;</td>
	</tr>
</table>
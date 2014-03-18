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
	//print_r($primary);
	$emps = $this->budget_m->get_emps_for_budget($primary->id);
	//echo "<br><br>"; print_r($emps);
	//echo "<br><br>";
	if( count($emps) < 1 ):
?>
	<table style="width:100%; margin:0 auto;">
		<tr>
			<th style="width:5%;">&nbsp;</th>
			<th style="width:10%;">Date Modified</th>
			<th style="width:10%;">Employee ID</th>
			<th style="width:25%;">Employee</th>
			<th style="width:25%;">Job Title</th>
			<th style="width:5%;">FT/PT</th>
			<th style="width:20%;">&nbsp;</th>
		</tr>
		<tr><td colspan="7" align="center"><strong>NO EMPLOYEES FOUND!</strong></td></tr>
		<tr><td colspan="7">&nbsp;</td></tr>
	</table>
<?php else: ?>

	<table style="width:100%; margin:0 auto;">
		<tr>
			<th style="width:5%;">&nbsp;</th>
			<th style="width:10%;">Date Modified</th>
			<th style="width:10%;">Employee ID</th>
			<th style="width:25%;">Employee</th>
			<th style="width:25%;">Job Title</th>
			<th style="width:5%;">FT/PT</th>
			<th style="width:20%;">&nbsp;</th>
		</tr>
	<?php foreach( $emps as $emp ): ?>
		<tr class="emp_grid">
			<td><strong><?= $emp['EE_STATUS']; ?></strong></td>
			<td><?= $emp['LAST_EDIT']; ?></td>
			<td><?= $emp['EMPLID']; ?></td>
			<td><?= $emp['NAME']; ?></td>
			<td><?= $this->budget_m->fetch_job($emp['JOB_ID']); ?></td>
			<td><strong><?= $emp['FULL_PART']; ?></strong></td>
			<td>&nbsp;</td>
		</tr>
	<?php endforeach; ?>
		<tr><td colspan="7">&nbsp;</td></tr>
	</table>
<?php endif; ?>
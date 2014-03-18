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
	$atm = $this->sam_m->get_company_atm($primary->id);
	echo "<br><br>"; print_r($atm);
	//echo "<br><br>";
	
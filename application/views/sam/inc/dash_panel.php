<ul class="unstyled">
	<?php
		foreach( $budgets as $budget):
			$thisBudget = $this->budget_m->get($budget['id']);
			$coNum = substr($thisBudget->id,0,3);
			$deNum = substr($thisBudget->id,-2);
	        $thisBudPM = $this->finloc_m->getPMStatus($this->globals_m->current_year(), $coNum, $deNum);

	        if( (int)$thisBudPM > 0 ):
	        	//$fixit = $this->finloc_m->close_by_PM($thisBudget->id);
	        endif;
	        
	        switch($thisBudPM){
	          case -1:
	            $thisBudgetPM = "Rejected";
	            break;
	          case 1:
	            $thisBudgetPM = "Submitted";
	            break;
	          case 2:
	            $thisBudgetPM = "Approved";
	            break;
	          default:
	            $thisBudgetPM = "Open";
	            break;
	        } // end switch

	        switch($thisBudget->sam_status){
	          case 0:
	            $thisBudgetSAM = "Not Started";
	            break;
	          case 1:
	            $thisBudgetSAM = "In Progress";
	            break;
	          case 2:
	            $thisBudgetSAM = "Submitted";
	            break;
	          case 3:
	          	$thisBudgetSAM = "Approved";
	            break;
	          case 4:
	          	$thisBudgetSAM = "Archived";
	            break;
	          default:
	            $thisBudgetSAM = "Open";
	            break;
	        } // end switch

	        switch($thisBudget->atm_status){
	          case 0:
	            $thisBudgetATM = "Not Started";
	            break;
	          case 1:
	            $thisBudgetATM = "In Progress";
	            break;
	          case 2:
	            $thisBudgetATM = "Submitted";
	            break;
	          case 3:
	          	$thisBudgetATM = "Approved";
	            break;
	          case 4:
	          	$thisBudgetATM = "Archived";
	            break;
	          default:
	            $thisBudgetATM = "Open";
	            break;
	        } // end switch


	        //if( (int)$thisBudPM > 0 ):
        		//$fixit = $this->finloc_m->close_by_PM($thisBudget->id);
        		//$tbColor = "pmDashBlack";
        	//else:
		        switch( $thisBudget->sam_status){
		          case 0:
		            $tbColor = "pmDashBlue";
		            break;
		          case 1:
		            $tbColor = "pmDashRed";
		            break;
		          case 2:
		            $tbColor = "pmDashYellow";
		            break;
		          case 3:
		            $tbColor = "pmDashGreen";
		            break;
		          case 4:
		            $tbColor = "pmDashGray";
		            break;
		        } // end switch
		    //endif;
	    ?>
	      <li class="pmDash <?= $tbColor; ?> span3" data-id="<?= $thisBudget->id; ?>">
	      	<?php if((int)substr($thisBudget->id,0,3) > 499 && (int)substr($thisBudget->id,0,3) < 600): ?>
	      		<p><?= $coNum; ?> - <?= $deNum; ?></p>
			<?php else: ?>
	        	<p><?= $coNum; ?></p>
	        <?php endif; ?>
	        <?php
	        	if(strlen($thisBudget->name) > 22){
	        		$budname = substr($thisBudget->name,0,22) . "...";
	        	} else {
	        		$budname = $thisBudget->name;
	        	} // end if
	        ?>
	        <p class="bud-name"><?= $thisBudget->name; ?></p>
	        <p class="pm-status">ATM Status: <?= $thisBudgetATM; ?>
	        	<br>SAM Status: <?= $thisBudgetSAM; ?>
	        	<br>PM Status: <?= $thisBudgetPM; ?></p>
	      </li>
	<?php
		endforeach;
	?>
</ul>
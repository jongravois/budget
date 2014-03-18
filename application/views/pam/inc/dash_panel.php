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
	        
	        switch((int)$thisBudPM){
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

	        switch((int)$thisBudget->pam_status){
	          case 0:
	            $thisBudgetPAM = "Not Started";
	            break;
	          case 1:
	            $thisBudgetPAM = "In Progress";
	            break;
	          case 2:
	            $thisBudgetPAM = "Submitted";
	            break;
	          case 3:
	          	$thisBudgetPAM = "Approved";
	            break;
	          case 4:
	          	$thisBudgetPAM = "Archived";
	            break;
	          default:
	            $thisBudgetPAM = "Open";
	            break;
	        } // end switch
	        
	        //if( (int)$thisBudPM > 0 ):
        		//$fixit = $this->finloc_m->close_by_PM($thisBudget->id);
        		//$tbColor = "pmDashBlack";
        	//else:
        		switch((int)$thisBudget->pam_status){
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
	        <p class="bud-name"><?= $budname; ?></p>
	        <p class="pm-status">PAM Status: <?= $thisBudgetPAM; ?>
	        	<br>PM Status: <?= $thisBudgetPM; ?> (<?= $thisBudPM; ?>)</p>
	      </li>
	<?php
		endforeach;
	?>
</ul>
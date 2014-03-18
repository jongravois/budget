<div class="page-header">
    <h1>BUDGET YEAR</h1>
  </div>
  <p class="lead">This <b>value</b> determines the data set for S.A.M., A.T.M., and P.A.M. and should only be changed if prior history is needed (and should be reset when no longer needed) or to prepare for a new budgeting season.<br><br><span style="font-weight:bold;color:#b00400;">NOTE: Do not set this value to less than "14."</span></p>

  <div class="row-fluid">
    <div class="span12">
      <p>
		<?php
			$this->table->clear();
			$tmpl = array ( 'table_open' => '<table id="tblBudgetYear" class="table table-striped table-bordered">' );
			$this->table->set_template($tmpl);
			$this->table->set_heading(array('ID', 'NAME', 'CODE', 'VALUE', 'MAX', 'ACTIONS'));
			$this->table->set_empty("-");
			echo $this->table->generate($budgetYear);
		?>
      </p>
    </div>
  </div>
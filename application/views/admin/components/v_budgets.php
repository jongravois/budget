<div class="page-header">
    <h1>BUDGET ENTITIES</h1>
    <button class="btn btn-edr btnAddRecord" data-section="budgets">Add Record</button>
  </div>

  <div class="row-fluid">
    <div class="span12">
      <p>
      	<form class="filter-form">Filter: <input name="filter" class="rowFilter" value="" maxlength="30" size="30" type="text">&nbsp;<i class="btnClearBudgetsFilter icon-remove-circle"></i></form>
		<?php
			$tmpl = array ( 'table_open' => '<table id="tblBudgets" class="table table-striped table-bordered">' );
			$this->table->set_template($tmpl);
			$this->table->set_heading(array('ID', 'NAME', 'EMAIL', 'APPROVER', 'ACTIONS'));
			$this->table->set_empty("-");
			echo $this->table->generate($allBudgets);
		?>
      </p>
    </div>
  </div>
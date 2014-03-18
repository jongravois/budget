<div class="page-header">
    <h1>GLOBAL VALUES</h1>
  </div>
  <p class="lead"><u>Short-Term Disability</u>: Determine global table rate for STDI by calculating the monthly premium without reducing the weekly earnings to 70%. Take this result and divide it by monthly base salary. <u>This should be the rate entered on the global table.</u> PAM will calculate this monthly expense by taking monthly base salary * global table value * 70%.<br><br><u>Open Budget Group</u>: Use 0 for owned budgets and 1 for managed budgets</p>

  <div class="row-fluid">
    <div class="span12">
      <p>
      	<form class="filter-form">Filter: <input name="filter" class="rowFilter" value="" maxlength="30" size="30" type="text">&nbsp;<i class="btnClearBudgetsFilter icon-remove-circle"></i></form>
		<?php
			$this->table->clear();
			$tmpl = array ( 'table_open' => '<table id="tblGlobals" class="table table-striped table-bordered">' );
			$this->table->set_template($tmpl);
			$this->table->set_heading(array('ID', 'NAME', 'CODE', 'VALUE', 'MAX', 'ACTIONS'));
			$this->table->set_empty("-");
			echo $this->table->generate($allGlobals);
		?>
      </p>
    </div>
  </div>
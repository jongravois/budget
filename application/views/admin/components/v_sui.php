<div class="page-header">
    <h1>STATE UNEMPLOYMENT</h1>
    <button class="btn btn-edr btnAddRecord" data-section="sui">Add Record</button>
  </div>

  <div class="row-fluid">
    <div class="span12">
      <p>
      	<form class="filter-form">Filter: <input name="filter" class="rowFilter" value="" maxlength="30" size="30" type="text">&nbsp;<i class="btnClearBudgetsFilter icon-remove-circle"></i></form>
		<?php
			$this->table->clear();
			$tmpl = array ( 'table_open' => '<table id="tblStateUnemployment" class="table table-striped table-bordered">' );
			$this->table->set_template($tmpl);
			$this->table->set_heading(array('ID', 'STATE', 'RATE', 'BASE', 'ACTIONS'));
			$this->table->set_empty("-");
			echo $this->table->generate($allStateUnemployment);
		?>
      </p>
    </div>
  </div>
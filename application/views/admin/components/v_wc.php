<div class="page-header">
  	<button class="btn btn-edr btnAddRecord" data-section="wcrates">Add Record</button>
    <h1>WORKERS COMPENSATION</h1>
  </div>

  <div class="row-fluid">
    <div class="span12">
      <p>
      	<form class="filter-form">Filter: <input name="filter" class="rowFilter" value="" maxlength="30" size="30" type="text">&nbsp;<i class="btnClearBudgetsFilter icon-remove-circle"></i></form>
		<?php
			$this->table->clear();
			$tmpl = array ( 'table_open' => '<table id="tblWorkersCompensation" class="table table-striped table-bordered">' );
			$this->table->set_template($tmpl);
			$this->table->set_heading(array('ID', 'CODE', 'DESCRIPTION', 'RATE', 'CLASS', 'ACTIONS'));
			$this->table->set_empty("-");
			echo $this->table->generate($allWorkersCompensation);
		?>
      </p>
    </div>
  </div>
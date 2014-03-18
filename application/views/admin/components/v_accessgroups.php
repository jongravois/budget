<div class="page-header">
    <h1>ACCESS GROUPS</h1>
    <button class="btn btn-edr btnAddRecord" data-section="accessgroups">Add Group</button>
  </div>

  <div class="row-fluid">
    <div class="span12">
      <p>
      	<form class="filter-form">Filter: <input name="filter" class="rowFilter" value="" maxlength="30" size="30" type="text">&nbsp;<i class="btnClearBudgetsFilter icon-remove-circle"></i></form>
		<?php
			$this->table->clear();
			$tmpl = array ( 'table_open' => '<table id="tblAccessGroups" class="table table-striped table-bordered">' );
			$this->table->set_template($tmpl);
			$this->table->set_heading(array('ID', 'GROUP', 'ACTIONS'));
			$this->table->set_empty("-");
			echo $this->table->generate($allAccessGroups);
		?>
      </p>
    </div>
  </div>
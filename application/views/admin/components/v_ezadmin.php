<div class="page-header">
    <h1>EZ Admin</h1>
  </div>
  <p class="lead"></p>

  <div class="row-fluid">
    <div class="span12">
      <p>
      	<form class="filter-form">Filter: <input name="filter" class="rowFilter" value="" maxlength="30" size="30" type="text">&nbsp;<i class="btnClearBudgetsFilter icon-remove-circle"></i></form>
      	<table id="tblEZAdmin" class="table table-striped table-bordered">
      		<thead>
      			<tr>
      				<th>ID</th>
      				<th>ENTITY</th>
      				<th>P.M.</th>
      				<th>P.A.M.</th>
      				<th>A.T.M.</th>
      				<th>S.A.M.</th>
      			</tr>
      		</thead>
      		<tbody>
      			<?php foreach( $ezAdmin as $row): ?>
					<tr>
						<td style="width:10%;"><?= $row['id']; ?></td>
						<td style="width:30%;"><?= $row['name']; ?></td>
						<td style="width:15%;text-align:center;"><?= (int)$row['pm_status']; ?></td>
						<td style="width:15%;text-align:center;">
							<input type="text" class="span4 inputEZA" name="pam_status" data-id="<?= $row['id']; ?>" data-type="pam" value="<?= $row['pam_status']; ?>" />
						</td>
						<td style="width:15%;text-align:center;">
							<input type="text" class="span4 inputEZA" name="atm_status" data-id="<?= $row['id']; ?>" data-type="atm" value="<?= $row['atm_status']; ?>" />
						</td>
						<td style="width:15%;text-align:center;">
							<input type="text" class="span4 inputEZA" name="Sam_status" data-id="<?= $row['id']; ?>" data-type="sam" value="<?= $row['sam_status']; ?>" />
						</td>
					</tr>
      			<?php endforeach; ?>
      		</tbody>
      	</table>
      </p>
    </div>
  </div>
<div class="page-header">
    <h1>GROUP INSURANCE</h1>
  </div>

  <div class="row-fluid">
    <div class="span12">
      <p>
      	<label class="help_text">Enter Group Insurance increase for year as a percentage of the current defaults.</label>
		<div class="input-append" style="display:inline;">
			<input class="span2" id="inputPercentGIIncrease" type="text">
			<span class="add-on">%</span>
		</div>
      </p>
      <p>
		<table id="tblGroupInsurance" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th style="width:40%;">CATEGORY</th>
					<th style="width:30%;">CURRENT DEFAULT</th>
					<th style="width:30%;">NEW DEFAULT</th>
				</tr>
			</thead>
			<tbody>
				<tr><td colspan="3">&nbsp;</td></tr>
				<tr>
					<td>SINGLE</td>
					<td id="single_current">
						<?= $this->globals_m->get_gi_single(); ?>
					</td>
					<td id="single_adjusted">&nbsp;</td>
				</tr>
				<tr>
					<td>FAMILY</td>
					<td id="family_current">
						<?= $this->globals_m->get_gi_family(); ?>
					</td>
					<td id="family_adjusted">&nbsp;</td>
				</tr>
				<tr><td colspan="3" style="text-align:center;color:#b00400;"><span id="giAdjustMsg">&nbsp;</span></td></tr>
				<tr>
					<td colspan="3">
						<a href="#" class="btn btn-edr btnSaveGIAdjust">SAVE</a>
						&nbsp;&nbsp;&nbsp;
						<a href="#" class="btn btnCancelGIAdjust">CANCEL</a>
					</td>
				</tr>
			</tbody>
		</table>
      </p>
    </div>
  </div>
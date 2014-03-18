<table class="table-striped" style="width:90%;margin:0 auto;">
  <tr>
    <td colspan="2" style="text-align:center;">
      <label>SUBMISSION SUMMARY</label>
    </td>
  </tr>
  <tr>
    <td style="width:40%;">
      COMPANY:
    </td>
    <td style="width:60%;">
      <?= substr($budget->id,0,3) . ' -- ' . $budget->name; ?>
    </td>
  </tr>
  <tr>
    <td style="width:40%;">
      DEPARTMENT:
    </td>
    <td style="width:60%;">
      
    </td>
  </tr>
  <tr>
    <td style="width:40%;">
      JOB TITLE:
    </td>
    <td style="width:60%;">
      
    </td>
  </tr>
  <tr>
    <td style="width:40%;">
      NAME:
    </td>
    <td style="width:60%;">
      
    </td>
  </tr>
  <tr>
    <td style="width:40%;">
      EMPLOYMENT STATUS:
    </td>
    <td style="width:60%;">
      
    </td>
  </tr>
  <tr>
    <td style="width:40%;">
      BUDGET START DATE:
    </td>
    <td style="width:60%;">
      
    </td>
  </tr>
  <tr>
    <td style="width:40%;">
      BUDGET END DATE:
    </td>
    <td style="width:60%;">
      
    </td>
  </tr>


  <tr>
    <td colspan="2">
      <div class="form-actions">
        <button type="button" data-location="submit_summary" class="btn btnBack btn-large btn-inverse">Back</button>
        <button type="button" class="btn btn-large btnCancel">Cancel</button>
        <button type="submit" data-location="submit_summary" class="btn btnSubmit btn-large btn-edr">Submit</button>
        <img class="wait-gif" src="<?= base_url('/assets/images/spin_light_lg.gif'); ?>" class="waiting" style="display:none;" />
      </div>
    </td>
  </tr>
</table>
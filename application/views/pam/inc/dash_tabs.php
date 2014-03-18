<div class="container">
    <div class="row">
      <div class="span12">
        <div class="row">
          <div id="tabs">
            <ul>
              <?php if($user['accessLevel'] != "approver"): ?>
                <li><a href="#tabs-1">FISCAL START - JANUARY</a></li>
                <li><a href="#tabs-2">FISCAL START - OTHER</a></li>
              <?php endif; ?>
              <?php if($user['accessLevel'] == "admin" || $user['accessLevel'] == "approver"): ?>
                <li><a href="#tabs-3">CORPORATE DEPARTMENTS</a></li>
              <?php endif; ?>
            </ul>
            <br>
            <?php
              $norm['budgets'] = $this->budget_m->fetch_fiscal_norm();
              $other['budgets'] = $this->budget_m->fetch_fiscal_other();
              $depts['budgets'] = $this->budget_m->fetch_fiscal_departments();

              switch( $user['accessLevel']){
                case 'admin':
            ?>
              <div id="tabs-1"><?php $this->load->view('pam/inc/dash_panel', $norm); ?></div>
              <div id="tabs-2"><?php $this->load->view('pam/inc/dash_panel', $other); ?></div>
              <div id="tabs-3"><?php $this->load->view('pam/inc/dash_panel', $depts); ?></div>
            <?php
                  break;
                case 'propadmin':
                case 'regional':
                case 'analyst':
            ?>
              <div id="tabs-1"><?php $this->load->view('pam/inc/dash_panel', $norm); ?></div>
              <div id="tabs-2"><?php $this->load->view('pam/inc/dash_panel', $other); ?></div>
            <?php
                  break;
                case 'approver':
            ?>
              <div id="tabs-1"><?php $this->load->view('pam/inc/dash_panel', $depts); ?></div>
            <?php
                  break;
              } // end switch
            ?>
          </div>
        </div> <!-- END .row -->
      </div> <!-- END .span12 -->
    </div> <!-- END .row -->
  </div> <!-- END . container -->
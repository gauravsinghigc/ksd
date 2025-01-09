<div class="row">
  <div class="col-md-5">
    <div class="shadow-lg m-t-5 p-2 rounded-2">
      <div class="row">
        <div class="col-md-12">
          <h4 class="app-bg p-2"><i class="fa fa-building"></i> Plot & Project Details</h4>
        </div>
        <div class="col-md-12">
          <h4 class='app-text bg-secondary'>Project Details</h4>
          <table class='table table-striped'>
            <tr>
              <td>
                <span class="text-grey">Project Name</span><br>
                <span class="h4">
                  <?php echo FETCH($ProjectSql, "project_title"); ?>
                </span>
              </td>
              <td>
                <span class="text-grey">Project Type</span><br>
                <span class="h4">
                  <?php echo FETCH($ProjectSql, "project_type"); ?>
                </span>
              </td>
            </tr>
            <tr>
              <td>
                <span class="text-grey">Project Area</span><br>
                <span class="h4">
                  <?php echo FETCH($ProjectSql, "project_area"); ?> <?php echo FETCH($ProjectSql, "project_measure_unit"); ?>
                </span>
              </td>
              <td>
                <span class="text-grey">Total Units</span><br>
                <span class="h4">
                  <?php echo TOTAL("SELECT * FROM project_units where project_id='" . FETCH($ProjectSql, "Projects_id") . "'"); ?> Units
                </span>
              </td>
            </tr>
          </table>
        </div>
        <div class="col-md-12">
          <h4 class='app-text bg-secondary'>Plot Details</h4>
          <table class='table table-striped'>
            <tr>
              <td>
                <span class="text-grey">Unit No</span><br>
                <span class="h4">
                  <?php echo FETCH($PlotSql, "projects_unit_name"); ?>
                </span>
              </td>
              <td>
                <span class="text-grey">Unit Type</span><br>
                <span class="h4">
                  <?php echo FETCH($PlotSql, "projects_unit_type"); ?>
                </span>
              </td>
            </tr>
            <tr>
              <td>
                <span class="text-grey">Unit Area</span><br>
                <span class="h4">
                  <?php echo FETCH($PlotSql, "project_unit_area"); ?> <?php echo FETCH($PlotSql, "project_unit_measurement_unit"); ?>
                </span>
              </td>
              <td>
                <span class="text-grey">Unit Rate</span><br>
                <span class="h4">
                  <?php echo Price(FETCH($PlotSql, "unit_per_price"), "text-success", "Rs."); ?>/<?php echo FETCH($PlotSql, "project_unit_measurement_unit"); ?>
                </span>
              </td>
            </tr>
            <tr>
              <td>
                <span class='text-grey'>Unit Net Price</span><br>
                <span class="h4">
                  <?php echo Price(FETCH($PlotSql, "project_unit_price"), "text-success", "Rs."); ?>
                </span>
              </td>
            </tr>
            <tr>
              <td>
                <span class='text-grey'>Total Re-selling</span><br>
                <span class="h4">
                  <?php echo TOTAL("SELECT * FROM booking_resales where booking_plot_id='$PlotId' and booking_resale_type='RE_SALE'"); ?> Re-Sales
                </span>
              </td>
              <td>
                <span class='text-grey'>Total Transfers</span><br>
                <span class="h4">
                  <?php echo TOTAL("SELECT * FROM booking_resales where booking_plot_id='$PlotId' and booking_resale_type='TRANSFER'"); ?> Transfers
                </span>
              </td>
            </tr>

          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-7">
    <div class="shadow-lg m-t-5 p-2 rounded-2">
      <div class="row">
        <div class="col-md-12">
          <h4 class="app-bg p-2"><i class="fa fa-user"></i> Current property owner & Sale Agent</h4>
        </div>
        <div class="col-md-12">
          <?php echo UserDetails(FETCH($CustomerSql, "id")); ?>
        </div>
        <div class="col-md-12">
          <?php echo UserDetails(FETCH($PartnerSql, "id")); ?>
        </div>
      </div>
    </div>
  </div>
</div>
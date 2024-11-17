<?php
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';
if (isset($_GET['id'])) {
  $ViewCustomerId = $_GET['id'];
  $_SESSION['USER_VIEW_ID_AGENT_DASHBOARD'] = $_GET['id'];
} else {
  $ViewCustomerId = $_SESSION['USER_VIEW_ID_AGENT_DASHBOARD'];
}
require "../../../include/admin/page-header-req/user-profile-req.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Dashboard | <?php echo company_name; ?></title>
  <?php include '../../../include/header_files.php'; ?>
  <script>
    window.onload = function() {
      document.getElementById("projects").classList.add("app-bg");
    }
  </script>
</head>

<body>
  <div id="container" class="navbar-fixed mainnav-fixed mainnav-lg">
    <?php include '../../header.php'; ?>
    <!--END NAVBAR-->
    <div class="boxed">
      <!--CONTENT CONTAINER-->
      <!--===================================================-->
      <div id="content-container">
        <!--===================================================-->
        <div id="page-content">
          <div class="panel">
            <div class="panel-body">
              <div class="row">
                <?php include 'user-info.php'; ?>
                <div class="col-md-12">
                  <h3 class='app-sub-heading'>All Projects</h3>
                  <?php
                  $nettotalprojectsoldamount = 0;
                  $SQL_customerprojects = TOTAL("SELECT * FROM bookings where bookings.partner_id='$CustomerId' GROUP BY project_list_id");
                  if ($SQL_customerprojects == 0) {
                  } else {
                    $SQL_AllBookings = SELECT("SELECT * FROM bookings where bookings.partner_id='$CustomerId' GROUP BY project_list_id");
                    while ($FetchCustomerBookings = mysqli_fetch_array($SQL_AllBookings)) {
                      $BookingsId[] = $FetchCustomerBookings['bookingid'];
                    }
                    $nettotalprojectsoldamount = 0;
                    foreach ($BookingsId as $BookingId) {
                      $SQL_AllBookings = SELECT("SELECT * FROM bookings where bookings.partner_id='$CustomerId' and bookingid='$BookingId'");
                      $fetchBookings = mysqli_fetch_array($SQL_AllBookings);
                      $project_list_id = $fetchBookings['project_list_id'];
                      $project_unit_id = $fetchBookings['project_unit_id'];
                      $unit_name = $fetchBookings['unit_name'];
                      $unit_area = $fetchBookings['unit_area'];
                      $unit_rate = $fetchBookings['unit_rate'];
                      $unit_cost = $fetchBookings['unit_cost'];
                      $possession = $fetchBookings['possession'];
                      $net_payable_amount = $fetchBookings['net_payable_amount'];
                      $nettotalprojectsoldamount += $unit_cost;
                      $matches = preg_replace('/[^0-9.]+/', '', $unit_area);
                      $unit_area_in_numbers = (int)$matches;
                      $possession_notes = SECURE($fetchBookings['possession_notes'], "d");
                      $possession_update_date = $fetchBookings['possession_update_date'];

                      $SQL_BookingProjects = SELECT("SELECT * FROM projects where Projects_id='$project_list_id'");
                      $FetchBookingprojects = mysqli_fetch_array($SQL_BookingProjects);
                      $project_title = $FetchBookingprojects['project_title'];
                      $project_type = $FetchBookingprojects['project_type'];
                      $project_area = $FetchBookingprojects['project_area'];
                      $project_measure_unit = $FetchBookingprojects['project_measure_unit'];
                      $project_created_at = $FetchBookingprojects['created_at'];
                      $project_status = $FetchBookingprojects['project_status'];

                      $SQL_BookingsUnits = SELECT("SELECT * FROM project_units where project_units_id='$project_unit_id'");
                      $FetchBookingUnits = mysqli_fetch_array($SQL_BookingsUnits);
                      $project_unit_measurement_unit = $project_measure_unit;
                      $projects_unit_type = $FetchBookingUnits['projects_unit_type'];
                      $unit_created_at = $FetchBookingUnits['created_at'];
                  ?>
                      <div class="data-list">
                        <span class="w-pr-20">
                          <span class='text-grey italic'>Project Name</span><br>
                          <span class="bold text-black"><?php echo $project_title; ?></span>
                        </span>
                        <span class="w-pr-20">
                          <span class='text-grey italic'>Project Type</span><br>
                          <span class="bold text-black"><?php echo $project_type; ?></span>
                        </span>
                        <span class="w-pr-20">
                          <span class='text-grey italic'>Project Area</span><br>
                          <span class="bold text-black"><?php echo $project_area; ?> <?php echo $project_measure_unit; ?></span>
                        </span>
                        <span class="w-pr-20">
                          <span class='text-grey italic'>Project Cost</span><br>
                          <span class="bold text-black">
                            <?php echo Price(AMOUNT("SELECT * FROM project_units where project_id='$project_list_id'", "project_unit_price"), "text-success", "Rs."); ?>
                          </span>
                        </span>
                        <span class="w-pr-10">
                          <span class='text-grey italic'>Total Units</span><br>
                          <span class="bold text-black">
                            <?php echo TOTAL("SELECT * FROM project_units where project_id='$project_list_id'") . " " . $projects_unit_type; ?>s
                          </span>
                        </span>
                        <span class="w-pr-10">
                          <span class='text-grey italic'>Sold Units</span><br>
                          <span class="bold text-black">
                            <?php echo TOTAL("SELECT * FROM project_units where project_id='$project_list_id' and project_unit_status='SOLD'") . " " . $projects_unit_type; ?>s
                          </span>
                        </span>
                        <span class="w-pr-10">
                          <span class='text-grey italic'>Available Units</span><br>
                          <span class="bold text-black">
                            <?php echo TOTAL("SELECT * FROM project_units where project_id='$project_list_id' and project_unit_status='ACTIVE'") . " " . $projects_unit_type; ?>s
                          </span>
                        </span>
                      </div>
                  <?php }
                  } ?>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>

    <?php include '../../sidebar.php'; ?>
    <?php include '../../footer.php'; ?>
  </div>

  <?php include '../../../include/footer_files.php'; ?>
</body>

</html>
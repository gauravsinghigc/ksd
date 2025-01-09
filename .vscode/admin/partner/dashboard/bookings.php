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
      document.getElementById("bookings").classList.add("app-bg");
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
                  <h3 class="app-sub-heading">All Bookings</h3>
                  <?php
                  $SQL_customerprojects = TOTAL("SELECT * FROM bookings where bookings.partner_id='$CustomerId'");
                  if ($SQL_customerprojects == 0) {
                  } else {
                    $SQL_AllBookings = SELECT("SELECT * FROM bookings where bookings.partner_id='$CustomerId'");
                    $SerialNo = 0;
                    while ($fetchBookings = mysqli_fetch_array($SQL_AllBookings)) {
                      $SerialNo++;
                      $bookingids = $fetchBookings['bookingid'];
                      $project_list_id = $fetchBookings['project_list_id'];
                      $project_unit_id = $fetchBookings['project_unit_id'];
                      $unit_name = $fetchBookings['unit_name'];
                      $unit_area = $fetchBookings['unit_area'];
                      $unit_rate = $fetchBookings['unit_rate'];
                      $unit_cost = $fetchBookings['unit_cost'];
                      $possession = $fetchBookings['possession'];
                      $net_payable_amount = $fetchBookings['net_payable_amount'];
                      $net_payable_amount = (int)$net_payable_amount;
                      $chargename = $fetchBookings['chargename'];
                      $charges = $fetchBookings['charges'];
                      $discountname = $fetchBookings['discountname'];
                      $discount = $fetchBookings['discount'];
                      $bookings_created_at = date("d M, Y", strtotime($fetchBookings['created_at']));
                      $booking_status = $fetchBookings['status'];
                      $booking_date = date("d M, Y", strtotime($fetchBookings['booking_date']));
                      $clearing_date = $fetchBookings['clearing_date'];
                      $bookingid2 = "B$bookingids/"  . date("m/Y", strtotime($fetchBookings['booking_date']));
                      $matches = preg_replace('/[^0-9.]+/', '', $unit_area);
                      $unit_area_in_numbers = (int)$matches;
                      $possession_notes = SECURE($fetchBookings['possession_notes'], "d");
                      $possession_update_date = $fetchBookings['possession_update_date'];

                      $SQL_BookingsUnits = SELECT("SELECT * FROM project_units where project_units_id='$project_unit_id'");
                      $FetchBookingUnits = mysqli_fetch_array($SQL_BookingsUnits);
                      $project_unit_measurement_unit = $FetchBookingUnits['project_unit_measurement_unit'];
                      $projects_unit_type = $FetchBookingUnits['projects_unit_type'];
                      $unit_created_at = $FetchBookingUnits['created_at'];
                  ?>
                      <div class="flex-s-b data-list">
                        <span class="text-black w-pr-3">
                          <span class='text-grey'>Sno</span><br>
                          <?php echo $SerialNo; ?>
                        </span>

                        <span class="text-black w-pr-10">
                          <span class='text-grey'>BookingId</span><br>
                          <a href="<?php echo DOMAIN; ?>/admin/booking/details/?id=<?php echo $bookingids; ?>">
                            <span class="text-info"><?php echo $bookingid2; ?></span>
                          </a>
                        </span>

                        <span class="text-black w-pr-10">
                          <span class='text-grey'>UnitName</span><br>
                          <?php echo UpperCase($unit_name); ?> (<?php echo $projects_unit_type; ?>)</span>

                        <span class="text-black w-pr-11">
                          <span class='text-grey'>UnitArea</span><br>
                          <?php echo $unit_area; ?></span>

                        <span class="text-black w-pr-12">
                          <span class='text-grey'>UnitRate</span><br>
                          Rs.<?php echo number_format($unit_rate); ?>/<?php echo $project_unit_measurement_unit; ?></span>

                        <span class="text-black w-pr-13">
                          <span class='text-grey'>UnitCost</span><br>
                          Rs.<?php echo number_format($unit_cost); ?></span>

                        <span class="text-black w-pr-12">
                          <span class='text-grey'>NetCost</span><br>
                          <?php echo Price($net_payable_amount, "text-success", "Rs."); ?></span>

                        <span class="text-black w-pr-8">
                          <span class='text-grey'>BookingDate</span><br>
                          <?php echo $booking_date; ?></span>

                        <span class="text-black w-pr-8">
                          <span class='text-grey'>CreatedAt</span><br>
                          <?php echo $bookings_created_at; ?></span>

                        <span class="text-black w-pr-13 text-right">
                          <span class='text-grey'>Actions</span><br>
                          <a href="<?php echo DOMAIN; ?>/admin/booking/booking_exports_orginal.php?id=<?php echo $bookingids; ?>" target="_blank" class="text-primary m-r-5"><i class="fa fa-print text-primary"></i> Receipt</a>
                          <a href="<?php echo DOMAIN; ?>/admin/booking/details/?id=<?php echo $bookingids; ?>" class="text-danger"><i class="fa fa-home text-danger"></i> Dashboard</a>
                        </span>
                      </div>
                  <?php }
                  }
                  ?>
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
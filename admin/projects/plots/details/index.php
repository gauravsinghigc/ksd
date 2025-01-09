<?php
require '../../../../require/modules.php';
require "../../../../require/admin/sessionvariables.php";
require '../../../../include/admin/common.php';

if (isset($_GET['plotid'])) {
  $PlotId = SECURE($_GET['plotid'], "d");
  $_SESSION['PLOT_ID'] = $PlotId;
} else {
  $PlotId = $_SESSION['PLOT_ID'];
}

$PlotSql = "SELECT * FROM project_units where project_units_id='$PlotId'";
$ProjectSql = "SELECT * FROM projects where Projects_id='" . FETCH($PlotSql, "project_id") . "'";
$BookingSql = "SELECT * FROM bookings where project_unit_id='$PlotId'";
$CustomerSql = "SELECT * FROM users where id='" . FETCH($BookingSql . " ORDER BY bookingid DESC limit 1", "customer_id") . "'";
$PartnerSql = "SELECT * FROM users where id='" . FETCH($BookingSql . " ORDER BY bookingid DESC limit 1", "partner_id") . "'";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Plot Dashboard / Re-sales | <?php echo company_name; ?></title>
  <?php include '../../../../include/header_files.php'; ?>
</head>

<body>
  <div id="container" class="navbar-fixed mainnav-fixed mainnav-lg">
    <?php include '../../../header.php'; ?>

    <!-- main content area -->
    <div class="boxed">
      <!--CONTENT CONTAINER-->
      <!--===================================================-->
      <div id="content-container">
        <!--Page content-->
        <div id="page-content">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-12">
              <div class="panel square">
                <div class="panel-body">
                  <div class='row'>
                    <div class='col-md-9'>
                      <h2 class='mt-0 m-t-0'><i class='fa fa-map-marker app-text'></i> Plot Re-Sale Dashboard</h2>
                      <a href="../index.php" class='btn btn-sm btn-default'><i class='fa fa-angle-left'></i> Back to Plots</a>
                    </div>
                    <div class="col-md-3">
                      <div class="p-3">
                        <a href="<?php echo DOMAIN; ?>/admin/booking/new_booking.php?type=RE_SALE&plot_id=<?php echo $PlotId; ?>&project_id=<?php echo FETCH($PlotSql, "project_id"); ?>" class="btn btn-md btn-success"><i class='fa fa-refresh'></i> Re-Sale</a>
                        <a href="<?php echo DOMAIN; ?>/admin/booking/new_booking.php?type=TRANSFER&plot_id=<?php echo $PlotId; ?>&project_id=<?php echo FETCH($PlotSql, "project_id"); ?>" class="btn btn-md btn-danger"><i class="fa fa-exchange"></i> Transfer Plot</a>
                      </div>
                    </div>
                  </div>

                  <?php
                  include "sections/customer-project-details.php";
                  include "sections/project-resale-counter.php";
                  include "sections/navbar.php";
                  ?>

                  <div class="row">
                    <div class="col-md-12">
                      <h3 class="app-sub-heading">All Bookings</h3>
                    </div>
                    <div class="col-md-12">
                      <?php
                      $SQL_AllBookings = SELECT("SELECT * FROM bookings where bookings.project_unit_id='$PlotId' ORDER BY bookingid DESC");
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

                          <span class="text-black w-pr-7">
                            <span class='text-grey'>SALE TYPE</span><br>
                            <?php
                            $BookingType = FETCH("SELECT * FROM booking_resales where booking_main_id='$bookingids'", "booking_resale_type");
                            echo BookingTypes($BookingType);
                            ?>
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

                          <span class="text-black w-pr-12">
                            <span class='text-grey'>UnitCost</span><br>
                            Rs.<?php echo number_format($unit_cost); ?></span>

                          <span class="text-black w-pr-12">
                            <span class='text-grey'>NetCost</span><br>
                            <?php echo Price($NetPayable = $net_payable_amount, "text-primary", "Rs."); ?>
                          </span>
                          <span class="text-black w-pr-12">
                            <span class='text-grey'>Paid</span><br>
                            <?php
                            $CheckSqlForReSale = CHECK("SELECT * FROM booking_resales where booking_main_id='$bookingids' and booking_resale_type='TRANSFER'");
                            if ($CheckSqlForReSale != null) {
                              $PreviousBookingId = FETCH($BookingSql . " and bookingid!='$bookingids' ORDER BY bookingid DESC limit 1", "bookingid");
                              $PreviousPayment = GetNetPaidAmount($PreviousBookingId);
                            } else {
                              $PreviousPayment = 0;
                            }
                            echo Price($NetPaid = GetNetPaidAmount($bookingids) + $PreviousPayment, "text-success", "Rs."); ?>
                          </span>
                          <span class="text-black w-pr-12">
                            <span class='text-grey'>Balance</span><br>
                            <?php echo Price($Balance = $NetPayable - $NetPaid, "text-danger", "Rs."); ?>
                          </span>

                          <span class="text-black w-pr-10">
                            <span class='text-grey'>BookingDate</span><br>
                            <?php echo $booking_date; ?></span>


                          <span class="text-black w-pr-13 text-right">
                            <span class='text-grey'>Actions</span><br>
                            <a href="<?php echo DOMAIN; ?>/admin/booking/booking_exports_orginal.php?id=<?php echo $bookingids; ?>" target="_blank" class="text-primary m-r-5"><i class="fa fa-print text-primary"></i></a>
                            <a href="<?php echo DOMAIN; ?>/admin/booking/details/?id=<?php echo $bookingids; ?>" class="text-info"><i class="fa fa-eye text-info"></i> Details</a>
                          </span>
                        </div>
                      <?php }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>





    <!-- end -->
    <?php include '../../../sidebar.php'; ?>
    <?php include '../../../footer.php'; ?>

  </div>

  <?php include '../../../../include/footer_files.php'; ?>
</body>

</html>
<?php
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';

if (isset($_GET['id'])) {
  $bookingid = $_GET['id'];
  $_SESSION['bookingid'] = $_GET['id'];
} else {
  $bookingid = $_SESSION['id'];
}

$BookingSql = "SELECT * FROM bookings where bookingid='$bookingid'";
$customer_id = FETCH($BookingSql, "customer_id");
$partner_id = FETCH($BookingSql, "partner_id");
$CoAllotySql = "SELECT * FROM booking_alloties where BookingAllotyMainBookingId='$bookingid'";
$CustomerSql = "SELECT * FROM users where id='$customer_id'";
$PartnerSql = "SELECT * FROM users where id='$partner_id'";
$CustomerAddress = "SELECT * FROM user_address where user_id='$customer_id'";
$PartnerAddress = "SELECT * FROM user_address where user_id='$partner_id'";

//other variables
$area = FETCH($BookingSql, "unit_area");
$areaint = GetNumbers($area);
$MainBookingID = "B" . $bookingid . "/" . date('m/Y', strtotime(FETCH($BookingSql, 'created_at')));
?>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Edit Booking : <?php echo company_name; ?></title>
  <?php include '../../../include/header_files.php'; ?>
</head>

<body>
  <div id="container" class="navbar-fixed mainnav-fixed mainnav-lg">
    <?php include '../../header.php'; ?>

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
                  <div class="row">
                    <div class="col-md-12">
                      <h3 class="m-t-0"><i class="fa fa-edit text-danger"></i> Edit Bookings : <span class="text-grey"> <?php echo $MainBookingID; ?></span></h3>
                      <a href="index.php" class="btn btn-md btn-default"><i class="fa fa-angle-left"></i> Back to Booking Dashboard</a>
                    </div>
                  </div>

                  <form action="../../../controller/bookingcontroller.php" method="POST">
                    <?php FormPrimaryInputs(true, [
                      "bookingid" => $bookingid
                    ]); ?>
                    <div class="row">
                      <div class="col-md-12">
                        <h4>Edit Customer or Agents</h4>
                      </div>
                      <div class="col-md-4 form-group">
                        <label>Update Customer</label>
                        <select class="form-control" name="customer_id" required="">
                          <?php
                          $FetchCustomers = FetchConvertIntoArray("SELECT * FROM users where user_role_id='4'", true);
                          if ($FetchCustomers != null) {
                            foreach ($FetchCustomers as $Customers) {
                              if ($Customers->id == $customer_id) {
                                $selected = "selected";
                              } else {
                                $selected = "";
                              }
                          ?>
                              <option value="<?php echo $Customers->id; ?>" <?php echo $selected; ?>>(C<?php echo $Customers->id; ?>) : <?php echo $Customers->name; ?> : <?php echo $Customers->phone; ?></option>
                          <?php
                            }
                          } ?>
                        </select>
                      </div>

                      <div class="col-md-4 form-group">
                        <label>Update Agent</label>
                        <select class="form-control" name="partner_id" required="">
                          <?php
                          $FetchCustomers = FetchConvertIntoArray("SELECT * FROM users where user_role_id='3'", true);
                          if ($FetchCustomers != null) {
                            foreach ($FetchCustomers as $Partners) {
                              if ($Partners->id == $partner_id) {
                                $selected = "selected";
                              } else {
                                $selected = "";
                              }
                          ?>
                              <option value="<?php echo $Partners->id; ?>" <?php echo $selected; ?>>(C<?php echo $Partners->id; ?>) : <?php echo $Partners->name; ?> : <?php echo $Partners->phone; ?></option>
                          <?php
                            }
                          } ?>
                        </select>
                      </div>

                      <div class="col-md-12">
                        <h4>Edit Plot Details</h4>
                      </div>

                      <div class="col-md-5 form-group">
                        <label>Update Plot Details</label>
                        <select name="unit_name" class="form-control">
                          <?php $FetchPlots = FetchConvertIntoArray("SELECT * FROM project_units", true);
                          if ($FetchPlots != null) {
                            foreach ($FetchPlots as $Plots) {
                              if ($Plots->project_units_id == FETCH($BookingSql, "project_unit_id")) {
                                $selected = "selected";
                              } else {
                                $selected = "";
                              }
                          ?>
                              <option value="<?php echo $Plots->project_units_id; ?>" <?php echo $selected; ?>>(<?php echo $Plots->project_units_id; ?>) <?php echo $Plots->projects_unit_name; ?> : <?php echo $Plots->project_unit_area . " " . $Plots->project_unit_measurement_unit; ?> : Rs.<?php echo $Plots->unit_per_price; ?>/<?php echo $Plots->project_unit_measurement_unit; ?> : Rs.<?php echo $Plots->project_unit_price; ?></option>
                          <?php
                            }
                          } else {
                            echo "<option>No Active Plots Found!</option>";
                          } ?>
                        </select>
                      </div>

                      <div class="col-md-4 form-group">
                        <label>Update CRN No</label>
                        <input type="text" name="crn_no" class="form-control" value="<?php echo FETCH($BookingSql, "crn_no"); ?>">
                      </div>

                      <div class="col-md-4 form-group">
                        <label>Update Ref No</label>
                        <input type="text" name="ref_no" class="form-control" value="<?php echo FETCH($BookingSql, "ref_no"); ?>">
                      </div>

                      <div class=" col-md-12">
                        <a href="index.php" class="btn btn-md btn-default"><i class="fa fa-angle-double-left"></i> Back to details</a>
                        <button type="submit" name="UpdateBookingDetails" class="btn btn-md btn-primary"> <i class="fa fa-check-circle-o"></i> Update Details</button>
                      </div>
                    </div>
                  </form>

                  <form action="../../../controller/bookingcontroller.php" method="POST">
                    <?php FormPrimaryInputs(true); ?>
                    <div class="row">
                      <div class="col-md-12">
                        <h3><i class="fa fa-edit"></i> update Possession or More Details</h3>
                      </div>
                      <div class="from-group col-md-12">
                        <label>Booking date</label>
                        <input type="date" name="booking_date" value="<?php echo FETCH($BookingSql, "booking_date"); ?>" class="form-control">
                      </div>
                      <div class="from-group col-md-12">
                        <label>Booking Created at</label>
                        <input type="date" name="created_at" value="<?php echo DATE_FORMATE2("Y-m-d", FETCH($BookingSql, "created_at")); ?>" class="form-control">
                      </div>
                      <div class="from-group col-md-12">
                        <label>Booking Clear Date</label>
                        <input type="date" name="clearing_date" value="<?php echo DATE_FORMATE2("Y-m-d", FETCH($BookingSql, "clearing_date")); ?>" class="form-control">
                      </div>
                      <div class="from-group col-md-12">
                        <label>Possession</label>
                        <select name="possession" class="form-control">
                          <?php InputOptions(["Yes" => "Yes", "No" => "No"], FETCH($BookingSql, "possession")); ?>
                        </select>
                      </div>
                      <div class="form-group col-md-12">
                        <label>Possession Notes</label>
                        <textarea style="height:100% !important;" class="form-control" name="possession_notes" rows="3"><?php echo FETCH($BookingSql, "possession_notes"); ?></textarea>
                      </div>
                      <div class="col-md-12">
                        <a href="index.php" class="btn btn-md btn-default"><i class="fa fa-angle-double-left"></i> Back to details</a>
                        <button type="submit" name="update_possession_status" value="<?php echo $bookingid; ?>" class="btn btn-success">Update Details</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include '../../payments/payment-popup.php'; ?>


    <!-- end -->
    <?php include '../../sidebar.php'; ?>
    <?php include '../../footer.php'; ?>
  </div>

  <?php include '../../../include/footer_files.php'; ?>

</html>
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

if (isset($_GET['pid'])) {
  $pid = $_GET['pid'];
  $_SESSION['pid'] = $_GET['pid'];
} else {
  $pid = $_SESSION['pid'];
}

$BookingSql = "SELECT * FROM bookings where bookingid='$bookingid'";
$customer_id = FETCH($BookingSql, "customer_id");
$partner_id = FETCH($BookingSql, "partner_id");
$CoAllotySql = "SELECT * FROM booking_alloties where BookingAllotyMainBookingId='$bookingid'";
$CustomerSql = "SELECT * FROM users where id='$customer_id'";
$PartnerSql = "SELECT * FROM users where id='$partner_id'";
$CustomerAddress = "SELECT * FROM user_address where user_id='$customer_id'";
$PartnerAddress = "SELECT * FROM user_address where user_id='$partner_id'";
$DevChargeSql = "SELECT * FROM developmentchargepayments where devchargepaymentid='$pid'";
$DevId = FETCH($DevChargeSql, "developmentchargeid");
$DevSql = "SELECT * FROM developmentcharges where devchargesid='$DevId'";
$AllDevSql = "SELECT * FROM developmentcharges where bookingid='$bookingid'";


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
  <title>Update Development Charge & Other Charges : <?php echo company_name; ?></title>
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
                      <h3 class="m-t-0">
                        <i class="fa fa-edit text-danger"></i> Update Development & Other Charges : <span class="text-grey">
                          <?php echo $MainBookingID; ?></span>
                      </h3>
                      <a href="index.php" class="btn btn-md btn-default"><i class="fa fa-angle-left"></i> Back to Booking Dashboard</a>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <h4 class="section-heading">Booking Details</h4>
                      <p class="data-list flex-s-b">
                        <span>Ref No : </span>
                        <b><?php echo FETCH($BookingSql, 'crn_no'); ?>//<?php echo FETCH($BookingSql, "ref_no"); ?></b>
                      </p>
                      <p class="data-list flex-s-b">
                        <span>BookingID : </span>
                        <b><?php echo $MainBookingID; ?></b>
                      </p>
                      <p class="data-list flex-s-b">
                        <span>Project Name :</span>
                        <b><?php echo FETCH($BookingSql, "project_name"); ?></b>
                      </p>
                      <p class="data-list flex-s-b">
                        <span>Project Area :</span>
                        <b><?php echo FETCH($BookingSql, "project_area"); ?></b>
                      </p>
                      <p class="data-list flex-s-b">
                        <span>Plot No :</span>
                        <b><?php echo strtoupper(FETCH($BookingSql, "unit_name")); ?></b>
                      </p>
                      <p class="data-list flex-s-b">
                        <span>Plot Area :</span>
                        <b><?php
                            $matches = preg_replace('/[^0-9.]+/', '', FETCH($BookingSql, "unit_area"));
                            $unit_area_in_numbers = (int)$matches;
                            echo FETCH($BookingSql, "unit_area"); ?></b>
                      </p>
                      <p class="data-list flex-s-b">
                        <span>Plot Rate :</span>
                        <b>Rs.<?php echo FETCH($BookingSql, "unit_rate"); ?>/sq yards</b>
                      </p>
                      <p class="data-list flex-s-b">
                        <span>Plot Cost :</span>
                        <b><?php echo Price(FETCH($BookingSql, "unit_cost"), "text-primary", "Rs."); ?></b>
                      </p>
                      <?php if (FETCH($BookingSql, "charges") != 0) { ?>
                        <tr>
                          <th>Charges <span class="text-grey fs-11 m-l-5"><?php echo FETCH($BookingSql, "chargename"); ?> (
                              <?php echo FETCH($BookingSql, "charges"); ?>% )</span></th>
                          <td>+ Rs.<?php echo $unit_cost / 100 * (int)FETCH($BookingSql, "charges"); ?></td>
                        </tr>
                      <?php } ?>
                      <?php if (FETCH($BookingSql, "discount") != 0) { ?>
                        <tr>
                          <th>Discount <span class="text-grey fs-11 m-l-5"><?php echo FETCH($BookingSql, "discountname"); ?> (
                              Rs.<?php echo FETCH($BookingSql, "discount");  ?> )</span></th>
                          <td>- Rs.<?php echo $unit_area_in_numbers * FETCH($BookingSql, "discount"); ?></td>
                        </tr>
                      <?php } ?>
                      <p class="data-list flex-s-b">
                        <span>Net Plot Cost :</span>
                        <b><?php echo Price(FETCH($BookingSql, "net_payable_amount"), "text-primary", "Rs."); ?></b>
                      </p>
                    </div>
                    <div class="col-md-4">
                      <h4 class="section-heading">Allotee Details</h4>
                      <p>
                        <b>Allotee Details</b><br>
                        <?php echo FETCH($CustomerSql, "name"); ?>,<br>
                        <?php echo FETCH($CustomerSql, "father_name"); ?><br>
                        <?php
                        echo FETCH($CustomerAddress, "user_street_address") . " ";
                        echo FETCH($CustomerAddress, "user_area_locality") . "<br>";
                        echo FETCH($CustomerAddress, "user_city") . " ";
                        echo FETCH($CustomerAddress, "user_state") . "<br>";
                        echo FETCH($CustomerAddress, "user_pincode") . " ";
                        echo FETCH($CustomerAddress, "user_country");
                        echo "<br>";
                        echo FETCH($CustomerSql, "phone") . "<BR>";
                        echo FETCH($CustomerSql, "email") . "<BR>";
                        ?>
                      </p>
                    </div>
                    <div class="col-md-4">
                      <h4 class="section-heading">Co-Allotee Details</h4>
                      <?php $Check = CHECK($CoAllotySql);
                      if ($Check != null) {
                        $BookingAllotyId = FETCH($CoAllotySql, "BookingAllotyId"); ?>
                        <p>
                          <b>Co-Allotee Details</b><br>
                          <?php echo FETCH($CoAllotySql, "BookingAllotyFullName"); ?><br>
                          <?php echo FETCH($CoAllotySql, "BookingAllotyRelation"); ?><br>
                          <?php echo FETCH($CoAllotySql, "BookingAllotyFatherName"); ?><br>
                          <?php
                          echo FETCH($CoAllotySql, "BookingAllotyStreetAddress");
                          echo FETCH($CoAllotySql, "BookingAllotyArea") . "<br>";
                          echo FETCH($CoAllotySql, "BookingAllotyCity");
                          echo FETCH($CoAllotySql, "BookingAllotyState") . "<br>";
                          echo FETCH($CoAllotySql, "BookingAllotyCountry") . "";
                          echo FETCH($CoAllotySql, "BookingAllotyPincode");
                          echo "<br>";
                          echo FETCH($CoAllotySql, "BookingAllotyPhoneNumber") . "<BR>";
                          echo FETCH($CoAllotySql, "BookingAllotyEmail") . "<BR>";
                          ?>
                        </p>
                      <?php } else {
                        $BookingAllotyId = 0;
                        NoData("No Co-Allotee Details found!");
                      } ?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <h3 class="section-heading">Update Development & Other Charge Details</h3>
                    </div>
                    <div class="col-md-7">
                      <h4 class='app-sub-heading'>Enter Details</h4>
                      <form action="../../../controller/developmentchargecontroller.php" method="POST">
                        <?php FormPrimaryInputs(true, [
                          "devchargepaymentid" => $pid
                        ]); ?>
                        <div class="row">
                          <div class="col-md-6 form-group">
                            <label> Payment Mode</label>
                            <select name='devchargepaymentmode' class="form-control" required>
                              <?php echo InputOptions([
                                "CASH" => "Cash Payment", "BANKING" => "Online Banking", "CHEQUE" => "Cheque/DD", "" => "Select Pay Mode"
                              ], FETCH($DevChargeSql, "devchargepaymentmode")); ?>
                            </select>
                          </div>
                          <div class="col-md-6 form-group">
                            <label>Paid Amount (in Rs.) </label>
                            <input type="text" name="devchargepaymentamount" class="form-control" value="<?php echo FETCH($DevChargeSql, "devchargepaymentamount"); ?>">
                          </div>
                          <div class="col-md-6 form-group">
                            <label> Source/Bank/Method Name</label>
                            <input type="text" name="devpaymentbankname" value="<?php echo FETCH($DevChargeSql, "devpaymentbankname"); ?>" class=" form-control">
                          </div>
                          <div class="col-md-6 form-group">
                            <label> Issue/Payment Initiate Date</label>
                            <input type="date" name="devpaymentupdatedat" value="<?php echo FETCH($DevChargeSql, "devpaymentupdatedat"); ?>" class="form-control">
                          </div>
                          <div class="col-md-6 form-group">
                            <label> Paying/Clear/Payment Date</label>
                            <input type="date" name="devpaymentreleaseddate" value="<?php echo FETCH($DevChargeSql, "devpaymentreleaseddate"); ?>" class="form-control">
                          </div>
                          <div class="col-md-6 form-group">
                            <label>Payment Status</label>
                            <select name='devpaymentstatus' class="form-control" required>
                              <?php echo InputOptions(["RECEIVED" => "Received", "CLEAR" => "Clear", "PAID" => "Paid", "ISSUE" => "Issue", "PENDING" => "Pending", "" => "Select Pay Status"], FETCH($DevChargeSql, "devpaymentstatus")); ?>
                            </select>
                          </div>
                          <div class="col-md-12 form-group">
                            <label>Received By/Issue To/Paid to</label>
                            <input type="text" name="devpaymentreceivedby" value='<?php echo FETCH($DevChargeSql, "devpaymentreceivedby"); ?>' class="form-control">
                          </div>
                          <div class="col-md-12 form-group">
                            <label> Transaction Details</label>
                            <textarea name="devchargepaymentnotes" class="form-control" required><?php echo FETCH($DevChargeSql, "devchargepaymentnotes"); ?></textarea>
                          </div>
                          <div class="col-md-12 form-group">
                            <label> Other Details</label>
                            <textarea name="devpaymentdetails" class="form-control" required><?php echo SECURE(FETCH($DevChargeSql, "devpaymentdetails"), "d"); ?></textarea>
                          </div>

                          <div class="col-md-12">
                            <a href="index.php" class="btn btn-md btn-default"><i class="fa fa-angle-left"></i> Back to Booking
                              Dashboard</a>
                            <button class="btn btn-md btn-primary" type="submit" name="UpdateDevelopmentChargeDetails">Update Details</button>
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
      </div>
    </div>

    <!-- end -->
    <?php include '../../sidebar.php'; ?>
    <?php include '../../footer.php'; ?>
  </div>

  <?php include '../../../include/footer_files.php'; ?>

</html>
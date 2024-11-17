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

if (isset($_GET['did'])) {
  $did = $_GET['did'];
  $_SESSION['did'] = $_GET['did'];
} else {
  $did = $_SESSION['did'];
}

$BookingSql = "SELECT * FROM bookings where bookingid='$bookingid'";
$customer_id = FETCH($BookingSql, "customer_id");
$partner_id = FETCH($BookingSql, "partner_id");
$CoAllotySql = "SELECT * FROM booking_alloties where BookingAllotyMainBookingId='$bookingid'";
$CustomerSql = "SELECT * FROM users where id='$customer_id'";
$PartnerSql = "SELECT * FROM users where id='$partner_id'";
$CustomerAddress = "SELECT * FROM user_address where user_id='$customer_id'";
$PartnerAddress = "SELECT * FROM user_address where user_id='$partner_id'";
$DevSql = "SELECT * FROM developmentcharges where devchargesid='$did'";


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
                        <i class="fa fa-edit text-danger"></i> Update Development Charges : <span class="text-grey">
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
                      <h3 class="section-heading">Update Development Charge Details</h3>
                    </div>
                    <div class="col-md-12">
                      <h4 class='app-sub-heading'>Enter Details</h4>
                      <form action="../../../controller/developmentchargecontroller.php" method="POST">
                        <?php FormPrimaryInputs(true, [
                          "devchargesid" => $did
                        ]); ?>
                        <div class="row">
                          <div class="col-lg-8 col-md-8 col-sm-6 col-12">
                            <div class="row">
                              <div class="form-group col-md-6 col-lg-6 col-sm-6 col-12">
                                <label class="">Development Charge Name</label>
                                <input type="text" value='<?php echo FETCH($DevSql, "developmentchargetitle"); ?>' name="developmentchargetitle" oninput="chargeoverview()" required="" id="chargename" class="form-control" placeholder="">
                              </div>
                              <div class="form-group col-md-6 col-lg-6 col-sm6 col-12">
                                <label>Development Charge Category</label>
                                <select type="text" name="developmentchargetype" onchange="chargeoverviewcategory()" required="" id="chargecategory" class="form-control">
                                  <?php
                                  $Sqldevcharge = SELECT("SELECT developmentchargetype FROM developmentcharges GROUP BY developmentchargetype");
                                  while ($Ftchcharge = mysqli_fetch_array($Sqldevcharge)) {
                                    if ($Ftchcharge['developmentchargetype'] ==  FETCH($DevSql, "developmentchargetype")) {
                                      $selected = "selected";
                                    } else {
                                      $selected = "";
                                    } ?>
                                    <option value="<?php echo $Ftchcharge['developmentchargetype']; ?>" <?php echo $selected; ?>><?php echo $Ftchcharge['developmentchargetype']; ?></option>
                                  <?php } ?>
                                  <option value="Others">Others</option>
                                </select>
                              </div>
                              <div style="display:none;" id="otherchargeview">
                                <div class="form-group col-md-6 col-lg-6 col-sm-6 col-12">
                                  <label>Other Charge Category</label>
                                  <input type="text" name="otherchargecategory" id="otherchargecategory" oninput="chargeoverviewcategory2()" class="form-control">
                                </div>
                              </div>
                              <div class="form-group col-md-6 col-lg-6 col-sm-6 col-12">
                                <label>Apply Development in</label>
                                <select class="form-control" name="developmentcharge" id="chargetypes" onchange="EnablePerOptions()" required="">
                                  <?php echo InputOptions([
                                    "FIX AMOUNT" => "Fix Amount",
                                    "PERCENTAGE" => "Percentage"
                                  ], FETCH($DevSql, "developmentcharge")); ?>
                                </select>
                              </div>
                              <?php if (FETCH($DevSql, "developmentcharge") == "PERCENTAGE") { ?>
                                <div style="display:none;" id="percentageview">
                                  <div class="form-group col-md-6 col-lg-6 col-sm-6 col-12">
                                    <label>Development Charge in (%)</label>
                                    <input type="text" name="developmentchargepercentage" value='<?php echo FETCH($DevSql, "developmentchargepercentage"); ?>' id="PercentageValue" oninput="CalculateDevcharges()" class="form-control">
                                  </div>
                                </div>
                              <?php } else { ?>
                                <div style="display:none;" id="percentageview">
                                  <div class="form-group col-md-6 col-lg-6 col-sm-6 col-12">
                                    <label>Development Charge in (%)</label>
                                    <input type="text" name="developmentchargepercentage" value='<?php echo FETCH($DevSql, "developmentchargepercentage"); ?>' id="PercentageValue" oninput="CalculateDevcharges()" class="form-control">
                                  </div>
                                </div>
                              <?php   } ?>
                              <div class="form-group col-md-6 col-lg-6 col-sm-6 col-12">
                                <label>Development Charge Amount</label>
                                <input type="text" name="developementchargeamount" value='<?php echo FETCH($DevSql, "developementchargeamount"); ?>' oninput="chargeoverview()" id="FinalDevChargeAmount" class="form-control" required="">
                                <span class="text-danger" id="alertmsg"></span>
                              </div>
                              <div class="form-group col-md-6 col-lg-6 col-sm-6 col-12">
                                <label>Status of Charges</label>
                                <select class="form-control" name="developmentchargestatus" required="">
                                  <?php echo InputOptions([
                                    "OPEN" => "Open",
                                    "CLOSED" => "Closed"
                                  ], FETCH($DevSql, "developmentchargestatus")); ?>
                                </select>
                              </div>
                              <div class="form-group col-md-12 col-lg-12 col-sm-12 col-12">
                                <label>Charge Description</label>
                                <textarea class="form-control" name="developmentchargedescription" rows="5" oninput="chargeoverview()"><?php echo SECURE(FETCH($DevSql, "developmentchargedescription"), "d"); ?></textarea>
                              </div>

                              <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                                <a href='index.php' class="btn btn-lg btn-default"><i class="fa fa-angle-left"></i> Back to Booking Dashboard</a>
                                <button class="btn btn-success btn-lg" type="submit" name="UpdateDevelopmentCharges">Update Development Charges</button>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                            <h4 class="app-bg br5 p-3 pl-1 mb-1 mt-0">Development Charge Overview</h4>
                            <table class="table table-striped">
                              <tr>
                                <th>Name</th>
                                <td align="right"><span id="chargename_view"></span></td>
                              </tr>
                              <tr>
                                <th>Category</th>
                                <td align="right"><span id="chargecategory_view"></span></td>
                              </tr>
                              <tr>
                                <th>Charges In</th>
                                <td align="right"><span id="chargetypes_view"></span></td>
                              </tr>
                              <tr>
                                <th>Charge Amount</th>
                                <td align="right"><span id="FinalDevChargeAmount_view" class="text-success fs-14"></span></td>
                              </tr>
                            </table>
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
  <script>
    function EnablePerOptions() {
      var percentageview = document.getElementById("percentageview");
      var chargetypes = document.getElementById("chargetypes");
      if (chargetypes.value === "PERCENTAGE") {
        percentageview.style.display = "block";
      } else {
        percentageview.style.display = "none";
      }
    }
  </script>
  <script>
    function CalculateDevcharges() {
      var PercentageValue = document.getElementById("PercentageValue");
      var FinalDevChargeAmount = document.getElementById("FinalDevChargeAmount");
      var NetPayableAmount = <?php echo $net_payable_amount; ?>;

      TotalDevelopmentChargeAmount = +NetPayableAmount / 100 * +PercentageValue.value;
      TotalDevelopmentChargeAmount = Math.round(TotalDevelopmentChargeAmount);

      if (TotalDevelopmentChargeAmount >= NetPayableAmount) {
        document.getElementById("alertmsg").innerHTML = "Development Charge cannot be greater then Net Payable Amount!";
      } else {
        var chargetypes = document.getElementById("chargetypes");
        var PercentageValue = document.getElementById("PercentageValue");
        if (chargetypes.value === "PERCENTAGE") {
          document.getElementById("chargetypes_view").innerHTML = chargetypes.value + " : (" + PercentageValue.value + "%) ";
        } else {
          document.getElementById("chargetypes_view").innerHTML = chargetypes.value;
        }
        FinalDevChargeAmount.value = TotalDevelopmentChargeAmount;
        document.getElementById("FinalDevChargeAmount_view").innerHTML = "Rs." + FinalDevChargeAmount.value;
        document.getElementById("alertmsg").innerHTML = "";
      }
    }
  </script>

  <script>
    function chargeoverviewcategory() {
      var chargecategory = document.getElementById("chargecategory");
      var otherchargecategory = document.getElementById("otherchargecategory");

      if (chargecategory.value === "Others") {
        document.getElementById("otherchargeview").style.display = "block";
      } else {
        document.getElementById("otherchargeview").style.display = "none";
      }

      document.getElementById("chargecategory_view").innerHTML = chargecategory.value;

    }
  </script>

  <script>
    function chargeoverviewcategory2() {
      var chargecategory = document.getElementById("chargecategory");
      var otherchargecategory = document.getElementById("otherchargecategory");

      document.getElementById("chargecategory_view").innerHTML = otherchargecategory.value;

    }
  </script>

  <script>
    function chargeoverview() {
      var chargename = document.getElementById("chargename");
      var chargecategory = document.getElementById("chargecategory");
      var chargetypes = document.getElementById("chargetypes");
      var PercentageValue = document.getElementById("PercentageValue");
      var FinalDevChargeAmount = document.getElementById("FinalDevChargeAmount");
      var otherchargecategory = document.getElementById("otherchargecategory");

      if (chargecategory.value === "Others") {
        document.getElementById("otherchargeview").style.display = "block";
        document.getElementById("chargecategory_view").innerHTML = otherchargecategory.value;
      } else {
        document.getElementById("chargecategory_view").innerHTML = chargecategory.value;
        document.getElementById("otherchargeview").style.display = "none";
      }

      document.getElementById("chargename_view").innerHTML = chargename.value;

      if (chargetypes.value === "PERCENTAGE") {
        document.getElementById("chargetypes_view").innerHTML = chargetypes.value + " : (" + PercentageValue.value + "%) ";
      } else {
        document.getElementById("chargetypes_view").innerHTML = chargetypes.value;
      }
      document.getElementById("FinalDevChargeAmount_view").innerHTML = "Rs." + FinalDevChargeAmount.value;
    }
  </script>
  <?php include '../../../include/footer_files.php'; ?>

</html>
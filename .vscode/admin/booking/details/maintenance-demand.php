<?php
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';
require "HeaderRequest/MaintenanceDemandHeaderRequest.php";
?>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Maintenance Demand Letter : <?php echo company_name; ?></title>
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
                      <h3 class="m-t-0"><i class="fa fa-exchange text-danger"></i> Maintenance Demand Letter : <span class="text-grey"> <?php echo $MainBookingID; ?></span></h3>
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

                            $string = FETCH($BookingSql, "unit_area");
                            preg_match('/-?\d+(\.\d+)?/', $string, $matches);
                            $unit_area_in_numbers = $matches[0];
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
                      <h4 class="section-heading">Payment History</h4>
                    </div>
                    <div class="col-md-4">
                      <h4 class="section-heading">Previous Maintenance Demand Letters</h4>
                      <?php
                      $Demands = FetchConvertIntoArray("SELECT * FROM booking_pay_req where PayReqType='MAINTENANCE' and PayReqBookingId='$bookingid'", true);
                      if ($Demands != null) {
                        foreach ($Demands as $d) { ?>
                          <p class="data-list m-b-0" style="display:flex !important;flex-direction: column;padding:0.4rem !important;">
                            <span class="w-100">
                              <span class="fs-13">
                                <?php echo $d->PayReqTitle; ?>
                              </span><br>
                              <?php Price($dmdamount = $d->PayRequestingAmount, "text-success fs-13", "Rs."); ?>
                              <span class="pull-right"><?php echo DATE_FORMATE2("d M, Y", $d->PayReqDate); ?></span><br>
                              <span class="text-danger">due on <?php echo DATE_FORMATE2("d M, Y", $d->PayRequestDueDate); ?></span>
                            </span><br>
                            <span class="w-100">
                              <a target="_blank" href="../docs/dmd-m.php?id=<?php echo $bookingid; ?>&dmdid=<?php echo $d->PaymentRequestId; ?>" class="btn btn-sm btn-primary" style="margin-left:0px !important;">
                                <i class="fa fa-file"></i> View Demand Letter
                              </a>
                              <?php CONFIRM_DELETE_POPUP(
                                "remove_dmd",
                                [
                                  "remove_demand_letters" => true,
                                  "control_id" => $d->PaymentRequestId,
                                ],
                                "bookingcontroller",
                                "Remove",
                                "btn btn-danger btn-sm pull-right"
                              ); ?>
                            </span>
                          </p>
                      <?php
                          $DmdId = $d->PaymentRequestId;
                        }
                      } else {
                        $DmdId = 0;
                        NoData("No Previous Demands Found!");
                      } ?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-4">
                      <h4 class="section-heading">Allotee & Co-Allotee Details</h4>
                      <div class="p-2 shadow-sm">
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
                        <hr>
                        <?php $Check = CHECK($CoAllotySql);
                        if ($Check != null) { ?>
                          <p>
                            <b>Co-Allotee Details</b><br>
                            <?php echo FETCH($CoAllotySql, "BookingAllotyRelation"); ?><br>
                            <?php echo FETCH($CoAllotySql, "BookingAllotyFullName"); ?><br>
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
                        <?php } ?>
                      </div>
                    </div>

                    <div class="col-md-8">
                      <h4 class="section-heading">Send Demand Request for Maintenance</h4>
                      <form action="../../../controller/bookingcontroller.php" method="POST">
                        <?php FormPrimaryInputs(true, [
                          "PayReqBookingId" => $bookingid,
                          "PhoneNumber" => FETCH($CustomerSql, "phone"),
                          "EmailId" => FETCH($CustomerSql, "email"),
                          "Name" => FETCH($CustomerSql, "name"),
                          "MainBookingID" => $MainBookingID,
                          "PayReqType" => "MAINTENANCE"
                        ]) ?>
                        <div class="row">
                          <div class="col-md-12 form-group">
                            <label>Demand Title</label>
                            <input type="text" name="PayReqTitle" value="1 Year Maintenance Charge (2025-2026)" placeholder="Request for Maintenance or Other Payments" class="form-control" required>
                          </div>
                          <div class="col-md-4 form-group">
                            <label>Pay Period</label>
                            <select name="PayReqPayPeriod" class="form-control" required>
                              <?php echo InputOptions(
                                [
                                  "" => "Select Pay Period",
                                  "ONE-TIME" => "OneTime",
                                  "MONTHLY" => "Monthly",
                                  "QUATERLY" => "Quaterly",
                                  "HALF-YEARLY" => "Half-Yearly",
                                  "YEARLY" => "Yearly"
                                ],
                                ""
                              );  ?>
                            </select>
                          </div>
                          <div class="col-md-4 form-group">
                            <label>Req Send Date</label>
                            <input type="date" name="PayReqDate" class="form-control" value="<?php echo DATE("Y-m-d"); ?>">
                          </div>
                          <div class="col-md-4 form-group">
                            <label>Due Date</label>
                            <input type="date" name="PayRequestDueDate" value="<?php echo date("Y-m-d", strtotime("+7 days")); ?>" class="form-control">
                          </div>
                          <div class="col-md-3 form-group">
                            <label>Net Unit Area</label>
                            <input type="text" name="null" readonly="" class="form-control" value="<?php echo FETCH($BookingSql, "unit_area"); ?>">
                          </div>
                          <div class="from-group col-md-3">
                            <label>Rate per unit</label>
                            <input type="text" name="demand_percentage" id="DemandRatePerUnit" class="form-control" oninput="CalculateAmount()">
                          </div>
                          <div class="from-group col-md-3">
                            <label>Paying For Months</label>
                            <input type="number" name="PayReqPayingMonths" value="1" id='PayingMonths' oninput="CalculateAmount()" class="form-control" min="1" required="">
                          </div>
                          <div class="from-group col-md-3">
                            <label>Request Amount : &nbsp;<Span id="err" class="text-danger float-right"> </Span></label>
                            <input type="text" name="PayRequestingAmount" id="current_paying_amount" value="" class="form-control" placeholder="" required="">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <label>
                              <input type="checkbox" name="sms" value="true" checked> Send Link via SMS on
                              <?php echo FETCH($CustomerSql, "phone"); ?>
                            </label><br>
                            <label>
                              <input type="checkbox" name="email" checked value="true"> Send Link via EMAIL on
                              <?php echo FETCH($CustomerSql, "email"); ?>
                            </label>
                          </div>
                          <div class="col-md-6 form-group pt-3">
                            <br>
                            <label>Demand Descriptions</label>
                            <textarea class="form-control" name="PayRequestDescriptions" rows="3"></textarea>
                          </div>
                          <div class="col-md-6 form-group pt-3">
                            <br>
                            <label>Payable At (BANK ACCOUNT DETAILS):</label>
                            <textarea class="form-control" name="PayReqSendDescsriptions" rows="3"></textarea>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-12">
                            <button type="submit" name="GenerateMaintenanceDemandLetter" class="btn btn-lg btn-success">Generate Demand
                              Letter</button>
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
    <?php include '../../payments/payment-popup.php'; ?>

    <script>
      function CalculateAmount() {
        var UnitArea = <?php echo $unit_area_in_numbers; ?>;
        var PayingMonths = parseInt(document.getElementById("PayingMonths").value);
        var DemandRatePerUnit = parseFloat(document.getElementById("DemandRatePerUnit").value);
        var CurrentPayingAmount = (UnitArea * DemandRatePerUnit) * PayingMonths;

        document.getElementById("current_paying_amount").value = Math.round(CurrentPayingAmount);
      }
    </script>
    <!-- end -->
    <?php include '../../sidebar.php'; ?>
    <?php include '../../footer.php'; ?>
  </div>

  <?php include '../../../include/footer_files.php'; ?>

</html>
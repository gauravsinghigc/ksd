<?php
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';

$PageTitle = "Other Payments";

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php echo $PageTitle; ?> | <?php echo company_name; ?></title>
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
        <div id="page-content">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-12">
              <div class="panel square">
                <div class="panel-body">
                  <div class="row">
                    <div class="col-md-12">
                      <h3 class="m-t-3"><i class="fa fa-mobile app-text"></i> All Other Payments</h3>
                    </div>
                    <div class="col-md-12">
                      <?php include '../common.php'; ?>
                    </div>

                    <div class="col-md-12 m-t-10">
                      <div class="table-responsive">
                        <table class="table-striped table table-responsive">
                          <thead>
                            <tr>
                              <th>Sno</th>
                              <th>BookingId</th>
                              <th>Customer</th>
                              <th>Project</th>
                              <th>PlotNo/Area</th>
                              <th>ChargeName</th>
                              <th>Charges</th>
                              <th>PaidAmount</th>
                              <th>LastPaidAt</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $OtherChargeSQL = "SELECT * FROM developmentcharges ORDER BY bookingid DESC";
                            $TotalItems = TOTAL($OtherChargeSQL);
                            $start = START_FROM;
                            $end = DEFAULT_RECORD_LISTING;

                            // Fetch Development Charge Data from database and display it in table format.
                            $GetOtherPayments = FetchConvertIntoArray($OtherChargeSQL . " limit $start, $end", true);
                            if ($GetOtherPayments != null) {

                              //serial number
                              $SerialNo = SERIAL_NO;

                              foreach ($GetOtherPayments as $OtherPayment) {
                                $SerialNo++;
                                //Booking Details
                                $bookingid = $OtherPayment->bookingid;
                                $BookingSQL = "SELECT * FROM bookings WHERE bookingid='$bookingid'";
                                $BookingID = "B" . $bookingid . "/" . DATE_FORMATE2("m/y", FETCH($BookingSQL, "created_at"));

                                $CustomerSQL = "SELECT * FROM users where id='" . FETCH($BookingSQL, "customer_id") . "'";
                                $CustomerName = FETCH($CustomerSQL, "name");
                                $CustomerEmailId = FETCH($CustomerSQL, "email");
                                $CustomerPhoneId = FETCH($CustomerSQL, "phone");
                            ?>
                                <tr>
                                  <td><?php echo $SerialNo; ?></td>
                                  <td>
                                    <a class="link text-primary" target="_blank" href="<?php echo DOMAIN; ?>/admin/booking/details/?id=<?php echo $bookingid; ?>">
                                      <?php echo $BookingID; ?>
                                    </a>
                                  </td>
                                  <td>
                                    <a target="_blank" href="<?php echo ADMIN_URL; ?>/customers/details/?id=<?php echo FETCH($BookingSQL, "customer_id"); ?>" class="link text-primary">
                                      (ID<?php echo FETCH($BookingSQL, "customer_id"); ?>)
                                      <?php echo $CustomerName; ?>
                                    </a>
                                  </td>
                                  <td>
                                    <?php echo FETCH($BookingSQL, "project_name"); ?>
                                  </td>
                                  <td>
                                    <?php echo FETCH($BookingSQL, "unit_name"); ?>
                                    (<?php echo FETCH($BookingSQL, "unit_area"); ?>)
                                  </td>
                                  <td>
                                    <?php echo LimitText($OtherPayment->developmentchargetitle, 0, 30); ?>
                                  </td>
                                  <td>
                                    <?php echo Price($OtherPayment->developementchargeamount, "text-primary", "Rs."); ?>
                                  </td>
                                  <td>
                                    <?php echo Price(AMOUNT("SELECT devchargepaymentamount FROM developmentchargepayments where developmentchargeid='" . $OtherPayment->devchargesid . "'", "devchargepaymentamount"), "text-success", "Rs."); ?>
                                  </td>
                                  <td>
                                    <?php echo DATE_FORMATE2("d M, Y", FETCH("SELECT devpaymentreleaseddate FROM developmentchargepayments where developmentchargeid='" . $OtherPayment->devchargesid . "' ORDER BY devchargepaymentid DESC limit 1", "devpaymentreleaseddate")); ?>
                                  </td>
                                  <td>
                                    <a href="<?php echo ADMIN_URL; ?>/booking/d-receipt.php?id=<?php echo $bookingid; ?>&pid=<?php echo FETCH("SELECT devchargepaymentid FROM developmentchargepayments where developmentchargeid='" . $OtherPayment->devchargesid . "' ORDER BY devchargepaymentid DESC limit 1", "devchargepaymentid"); ?>" class="btn btn-sm btn-default" target="_blank"><i class="fa fa-file-pdf-o text-danger"></i> Receipt</a>
                                    <a href="<?php echo ADMIN_URL; ?>/booking/details/edit-dev-charge.php?id=<?php echo $bookingid; ?>&pid=<?php echo FETCH("SELECT devchargepaymentid FROM developmentchargepayments where developmentchargeid='" . $OtherPayment->devchargesid . "' ORDER BY devchargepaymentid DESC limit 1", "devchargepaymentid"); ?>" class="btn btn-sm btn-default"><i class="fa fa-edit text-primary"></i> Edit</a>
                                  </td>
                                </tr>
                            <?php  }
                            } else {
                              NoDataTableView("No Payment Record Found", 6);
                            } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <?php echo PaginationFooter($TotalItems, "index.php"); ?>
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

  <script>
    function PaymentMode(data) {
      if (data == "cash") {
        document.getElementById("cash").style.display = "block";
        document.getElementById("check").style.display = "none";
        document.getElementById("banking").style.display = "none";
      } else if (data == "check") {
        document.getElementById("cash").style.display = "none";
        document.getElementById("check").style.display = "block";
        document.getElementById("banking").style.display = "none";
      } else if (data == "banking") {
        document.getElementById("cash").style.display = "none";
        document.getElementById("check").style.display = "none";
        document.getElementById("banking").style.display = "block";
      } else {
        document.getElementById("cash").style.display = "block";
        document.getElementById("check").style.display = "none";
        document.getElementById("banking").style.display = "none";
      }
    }
  </script>

  <script>
    function getpaidamount() {
      document.getElementById("cashamount").value = document.getElementById("paidamount").value;
      document.getElementById("netpaidamount").innerHTML = document.getElementById("paidamount").value;
      document.getElementById("net_payable").value = document.getElementById("paidamount").value;
    }
  </script>

  <script>
    function chargesCalcu() {
      var chargevalue = document.getElementById("chargevalue").value;
      var chargeshow = document.getElementById("chargeshow");
      var net_payable = document.getElementById("net_payable").value;
      var unit_cost = document.getElementById("paidamount").value;
      var chargename = document.getElementById("chargename").value;
      var discountvalue = document.getElementById("discountvalue").value;
      var discountshow = document.getElementById("discountshow");
      var discountname = document.getElementById("discountname").value;

      if (chargevalue > 0 || discountvalue > 0) {
        chargeshow.style.display = "block";

        if (discountvalue > 0) {
          discountshow.style.display = "block";
          discountamount = Math.round(unit_cost / 100 * discountvalue);
          discountableamount = +unit_cost - +discountamount;
          discountshow.innerHTML = discountname + " (" + discountvalue + "%) : <b> - Rs." + discountamount + "</b>";
          discountname.value = discountname;
          chargeableamount = Math.round(unit_cost / 100 * chargevalue);
          new_net_payable = (+unit_cost + +chargeableamount) - +discountamount;

          document.getElementById("net_payable").value = new_net_payable;
          chargeshow.innerHTML = chargename + " (" + chargevalue + "%): <b> + Rs." + chargeableamount + "</b>";

          document.getElementById("netpaidamount").innerHTML = new_net_payable;
          document.getElementById("paidamount").innerHTML = unit_cost;
          chargename.value = chargename;

        } else {
          discountshow.style.display = "none";
          discountableamount = 0;
          chargename.value = "";
          discountname.value = "";
          chargeableamount = Math.round(unit_cost / 100 * chargevalue);
          new_net_payable = +unit_cost + +chargeableamount;

          document.getElementById("net_payable").value = new_net_payable;
          chargeshow.innerHTML = chargename + " (" + chargevalue + "%): <b> + Rs." + chargeableamount + "</b>";

          document.getElementById("netpaidamount").innerHTML = new_net_payable;
          document.getElementById("paidamount").innerHTML = unit_cost;
          chargename.value = chargename;

        }

      } else {
        chargeshow.style.display = "none";
        discountshow.style.display = "none";

        document.getElementById("net_payable").value = unit_cost;
        document.getElementById("netpaidamount").innerHTML = unit_cost;
        document.getElementById("paidamount").innerHTML = unit_cost;
        chargename.value = "";
        discountname.value = "";
      }

      if (discountvalue > 0) {
        discountshow.style.display = "block";
      } else if (discountvalue == 0) {
        discountshow.style.display = "none";
      } else {
        discountshow.style.display = "none";
      }

      if (chargevalue > 0) {
        chargeshow.style.display = "block";
      } else if (chargevalue == 0) {
        chargeshow.style.display = "none";
      } else {
        chargeshow.style.display = "none";
      }
    }
  </script>

</body>

</html>
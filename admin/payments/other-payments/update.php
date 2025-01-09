<?php
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';

$PageTitle = "Update Online Payments";

if (isset($_GET['id'])) {
  $CheckId = $_GET['id'];
  $_SESSION['Online_payment_ID'] = $_GET['id'];
} else {
  $CheckId = $_SESSION['Online_payment_ID'];
}

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
        <div class="pageheader hidden-xs">
          <h3> <?php echo $PageTitle; ?> </h3>
        </div>
        <!--Page content-->
        <div id="page-content">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-12">
              <div class="panel p-1 square">
                <div class="panel-body">
                  <div class="row">

                    <?php

                    $Sql2 = SELECT("SELECT *, online_payments.created_at AS 'cashreceivedat' FROM payments, online_payments where payments.payment_id=online_payments.payment_id and online_payments.online_payments_id='$CheckId' ORDER BY online_payments_id  ASC");
                    $fetch2 = mysqli_fetch_array($Sql2); ?>

                    <form action="../../../controller/paymentcontroller.php" method="POST" class="row">
                      <?php FormPrimaryInputs(true); ?>
                      <div class="form-group col-md-4 col-lg-4 col-sm-6 col-12">
                        <label>Booking ID</label>
                        <input type="text" readonly class="form-control" value="B<?php echo $fetch2['bookingid']; ?><?php echo date("/m/Y", strtotime($fetch2['created_at'])); ?>">
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="form-group">
                          <label>Online Payment Method</label>
                          <input type="" name="payment_mode" class="form-control" value="<?php echo $fetch2['payment_mode']; ?>">
                        </div>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="form-group">
                          <label>Bank/Wallet/Upi/Provider name</label>
                          <input type="text" name='OnlineBankName' value="<?php echo $fetch2['OnlineBankName']; ?>" class="form-control">
                        </div>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="form-group">
                          <label>Transaction ID</label>
                          <input type="text" name="transactionId" value="<?php echo $fetch2['transactionId']; ?>" class="form-control">
                        </div>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="form-group">
                          <label>Paid Amount</label>
                          <input type="text" name="onlinepaidamount" value="<?php echo $fetch2['onlinepaidamount']; ?>" class="form-control">
                        </div>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="form-group">
                          <label>Transaction Status</label>
                          <select name="transaction_status" class="form-control">
                            <?php if ($fetch2['transaction_status'] == "Success") { ?>
                              <option value="<?php echo $fetch2['transaction_status']; ?>" selected=""><?php echo $fetch2['transaction_status']; ?></option>
                              <option value="Pending">Pending</option>
                              <option value="Failed">Failed</option>
                              <option value="Rejected">Rejected By Provider</option>
                            <?php } else if ($fetch2['transaction_status'] == "Pending") { ?>
                              <option value="Success">Success</option>
                              <option value="<?php echo $fetch2['transaction_status']; ?>" selected=""><?php echo $fetch2['transaction_status']; ?></option>
                              <option value="Failed">Failed</option>
                              <option value="Rejected">Rejected By Provider</option>
                            <?php } else if ($fetch2['transaction_status'] == "Failed") { ?>
                              <option value="Success">Success</option>
                              <option value="Pending">Pending</option>
                              <option value="<?php echo $fetch2['transaction_status']; ?>" selected=""><?php echo $fetch2['transaction_status']; ?></option>
                              <option value="Rejected">Rejected By Provider</option>
                            <?php } else if ($fetch2['transaction_status'] == "Rejected") { ?>
                              <option value="Success">Success</option>
                              <option value="Pending">Pending</option>
                              <option value="<?php echo $fetch2['transaction_status']; ?>" selected=""><?php echo $fetch2['transaction_status']; ?></option>
                              <option value="Failed">Failed</option>

                            <?php } else { ?>
                              <option value="Success" selected="">Success</option>
                              <option value="Pending">Pending</option>
                              <option value="Failed">Failed</option>
                              <option value="Rejected">Rejected By Provider</option>
                            <?php } ?>

                          </select>
                        </div>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="form-group">
                          <label>Transaction Details/Notes</label>
                          <textarea class="form-control" name="payment_details" value="<?php echo $fetch2['payment_details']; ?>" row="1"><?php echo $fetch2['payment_details']; ?></textarea>
                        </div>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="form-group">
                          <label>Transaction Date</label>
                          <input type="date" name="created_at" value="<?php echo $fetch2['created_at']; ?>" class="form-control">
                        </div>
                      </div>

                      <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                        <a href="index.php" class="btn btn-md btn-default"><i class="fa fa-angle-left"></i> Back to All Payments</a>
                        <button class="btn btn-md btn-primary" type="submit" name="updateonlinepaymentstatus" value="<?php echo $CheckId; ?>">Update</button>
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
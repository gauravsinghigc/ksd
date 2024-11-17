<?php
require '../../require/modules.php';
require "../../require/admin/sessionvariables.php";
require '../../include/admin/common.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Payments | <?php echo company_name; ?></title>
  <?php include '../../include/header_files.php'; ?>
</head>

<body>
  <div id="container" class="navbar-fixed mainnav-fixed mainnav-lg">
    <?php include '../header.php'; ?>

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
                      <h3 class="m-t-3"><i class="fa fa-inr app-text"></i> All Payments</h3>
                    </div>
                    <div class="col-md-12">
                      <div class="flex-s-b">
                        <?php include 'common.php'; ?>
                        <div class="btn-group btn-group-sm w-100">
                          <form action="" method="GET" class="flex-s-b form-search-filter w-100">
                            <span class="w-100 p-1 text-right"><b>Search Payments</b></span>
                            <select name="search_type" class="form-control" onchange="checkfiltertype()" id="filtertype">
                              <option value="bookings.bookingid">Booking ID</option>
                              <option value="bookings.customer_id">Customer ID</option>
                              <option value="bookings.partner_id">Agent ID</option>
                              <option value="bookings.unit_name">Plot No</option>
                              <option value="payments.payment_mode">Payment Mode</option>
                              <option value="payments.payment_amount">Payment Amount</option>
                              <option value="payments.remark">Payment Remark</option>
                              <option value="payments.payment_mode">Payment Mode</option>
                              <option value="payments.created_at">Created Date</option>
                              <option value="payments.payment_date">Paid Date</option>
                            </select>
                            <input type="text" name="search_value" class="form-control" id="filtervalue" placeholder="Enter Search Value">
                            <button type="submit" class="btn btn-sm btn-default m-l-5" name="search">Search</button>
                          </form>
                        </div>

                      </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12 col-sm-12 p-l-0 p-r-0 p-t-10">
                      <?php if (isset($_GET['search'])) { ?>
                        <center>
                          <p class="text-center app-bg shadow-lg br10 p-1 w-50 flex-s-b m-b-20">
                            <span><span>Search Results :</span> <?php echo $_GET['search_value']; ?></span>
                            <a href="index.php" class="text-danger"><span class="text-white"><i class="fa fa-times"></i> Clear</span></a>
                          </p>
                        </center>
                      <?php }
                      $TotalItems = TOTAL("SELECT *, payments.payment_id AS 'payment_delete_id', payments.created_at AS 'payment_created_at' FROM payments, bookings where payments.bookingid=bookings.bookingid order by payments.payment_id DESC");
                      include "../../include/extra/data-counter.php"; ?>
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>SNo</th>
                            <th>TxnRefId</th>
                            <th>BookingID</th>
                            <th>Customer</th>
                            <th>Plot No.</th>
                            <th>Agent</th>
                            <th>Payment Mode</th>
                            <th>NetPaid</th>
                            <th>Paid Date</th>
                            <th>CreatedAt</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          if (isset($_GET['search'])) {
                            $search_type = $_GET['search_type'];
                            $search_value = $_GET['search_value'];
                            // Handle date search types correctly
                            if ($search_type == "payments.payment_date" || $search_type == "payments.created_at") {
                              $search_value = date('Y-m-d', strtotime($search_value));
                            }
                            // Filtered query
                            $getpayments = SELECT("SELECT *, payments.payment_id AS 'payment_delete_id', payments.created_at AS 'payment_created_at' 
                           FROM payments, bookings 
                           WHERE $search_type LIKE '%$search_value%' 
                           AND payments.bookingid = bookings.bookingid 
                           ORDER BY payments.payment_id DESC");
                          } else {
                            // Default query
                            $getpayments = SELECT("SELECT *, payments.payment_id AS 'payment_delete_id', payments.created_at AS 'payment_created_at' 
                           FROM payments, bookings , developmentcharges
                           WHERE payments.bookingid = bookings.bookingid 
                           AND developmentcharges.bookingid=bookings.bookingid
                           ORDER BY payments.payment_id DESC 
                           LIMIT $start, $listcounts");
                          }

                          include "../../include/extra/serial-no.php";
                          while ($FetchAllPayments = mysqli_fetch_array($getpayments)) {
                            $SerialNo++;
                            $payment_id = $FetchAllPayments['payment_id'];
                            $payment_delete_id = $FetchAllPayments['payment_delete_id'];
                            $bookingid = $FetchAllPayments['bookingid'];
                            $booking_date = date("m/Y", strtotime($FetchAllPayments['booking_date']));
                            $payment_date = date("d M, Y", strtotime($FetchAllPayments['payment_date']));
                            $payment_mode = $FetchAllPayments['payment_mode'];
                            $payment_amount = $FetchAllPayments['payment_amount'];
                            $payment_created_at = $FetchAllPayments['payment_created_at'];
                            $slip_no = $FetchAllPayments['slip_no'];
                            $payment_id = $FetchAllPayments['payment_id'];
                            $created_at = $FetchAllPayments['created_at'];
                            $customer_id = $FetchAllPayments['customer_id'];
                            $net_paid_amount = $FetchAllPayments['net_paid'];
                            $partner_id = $FetchAllPayments['partner_id'];
                            $payment_type = $FetchAllPayments['payment_type'];

                            $payment_created_date = date("M, Y", strtotime($FetchAllPayments['payment_date']));
                            $payment_created_date_full = date("d M, Y", strtotime($FetchAllPayments['payment_date']));
                            $payment_created_date_full2 = date("dmY", strtotime($FetchAllPayments['payment_date']));
                            $paymentcreatedat = $FetchAllPayments['created_at'];
                            $CheckDevelopmentCharges = CHECK("SELECT * FROM developmentcharges WHERE bookingid='$bookingid '");
                            if ($CheckDevelopmentCharges == true) {
                              $d = "YES";
                            } else {
                              $d = '';
                            }
                            echo $FetchAllPayments['developementchargeamount'];
                            //payment modes
                            if ($payment_mode == "check") {
                              $SELECT_check_payments = SELECT("SELECT * from check_payments where payment_id='$payment_id'");
                              $check_payments = mysqli_fetch_array($SELECT_check_payments);
                              $txnid = $check_payments['check_payments'];
                              $checknumber = $check_payments['checknumber'];
                              $checkissuedto = $check_payments['checkissuedto'];
                              $bankName = $check_payments['bankName'];
                              $ifsc = $check_payments['ifsc'];
                              $payment_status = $check_payments['checkstatus'];
                              $check_issued_at = date("d M, Y", strtotime($check_payments['created_at']));
                              $payment_note = "<br>by check no: $checknumber issued on $check_issued_at for $checkissuedto through $bankName | $ifsc e.i $payment_status";
                            } else if (
                              $payment_mode == "banking"
                            ) {
                              $SELECT_online_payments = SELECT("SELECT * FROM online_payments where payment_id='$payment_id'");
                              $online_payments = mysqli_fetch_array($SELECT_online_payments);
                              $txnid = $online_payments['online_payments_id'];
                              $OnlineBankName = $online_payments['OnlineBankName'];
                              $transactionId = $online_payments['transactionId'];
                              $payment_details = $online_payments['payment_details'];
                              $payment_mode = $online_payments['payment_mode'];
                              $payment_status = $online_payments['transaction_status'];
                              $payment_note = "<br>by Online Banking : Bank Name:$OnlineBankName, TxnId: $transactionId, Details: $payment_details, Status: $payment_status";
                            } else if (
                              $payment_mode == "cash"
                            ) {
                              $SELECT_cash_payments = SELECT("SELECT * FROM cash_payments where payment_id='$payment_id'");
                              $cash_payments = mysqli_fetch_array($SELECT_cash_payments);
                              $txnid = $cash_payments['cash_payments'];
                              $cashreceivername = $cash_payments['cashreceivername'];
                              $cashamount = $cash_payments['cashamount'];
                              $payment_status = "done!";
                              $payment_note = "<br>Cash " . $payment_amount . " is received by $cashreceivername on " . date("d M, Y h:m A", strtotime($paymentcreatedat));
                            }

                            $paymentreferenceid = "B$bookingid/P$payment_id/T$txnid/D$payment_created_date_full2";

                            if ($payment_mode == "check") {
                              $payment_mode = "Cheque";
                            } else {
                              $$payment_mode = $payment_mode;
                            }

                            //select customer details
                            $SelectCustomers = SELECT("SELECT * FROM users where id='$customer_id'");
                            $CustomerDetails = mysqli_fetch_array($SelectCustomers);
                            $CustomerName = $CustomerDetails['name'];
                            //  plot details
                            $plotName = $FetchAllPayments['unit_name'];
                            //agent details
                            $SelectAgents = SELECT("SELECT * FROM users where id='$partner_id'");
                            $AgentDetails = mysqli_fetch_array($SelectAgents);
                            $AgentName = $AgentDetails['name'];

                          ?>
                            <tr>
                              <td><?php echo $SerialNo; ?></td>
                              <td class="text-primary"><?php echo $paymentreferenceid; ?>
                              </td>
                              <td><a class="text-primary text-decoration-underline" href="<?php echo DOMAIN; ?>/admin/booking/details/?id=<?php echo $bookingid; ?>">B<?php echo $bookingid; ?>/<?php echo date("m/Y", strtotime($created_at)); ?></a></td>
                              <td><a href="<?php echo DOMAIN; ?>/admin/customer/dashboard/?id=<?php echo $customer_id; ?>" class="text-primary"><i class="fa fa-user text-info"></i> <?php echo $CustomerName . '' . $d; ?></a></td>
                              <td><a href=""><?php echo $plotName . '(' . $FetchAllPayments['project_area'] . ')'; ?></a></td>
                              <td><a href="<?php echo DOMAIN; ?>/admin/partner/dashboard/?id=<?php echo $partner_id; ?>" class="text-primary"><i class="fa fa-user text-info"></i> <?php echo $AgentName; ?></a></td>
                              <td><?php echo $payment_mode; ?></td>
                              <td class="text-success">Rs.<?php echo $net_paid_amount; ?></td>
                              <td><?php echo DATE_FORMATE2("d M ,Y", $payment_date); ?></td>
                              <td><?php echo DATE_FORMATE2("d M ,Y", $payment_created_at); ?></td>
                              <td>
                                <a href="<?php echo DOMAIN; ?>/admin/booking/emi_receipt.php?id=<?php echo $bookingid; ?>&payment_id=<?php echo $payment_id; ?>" target="blank" class="btn btn-sm btn-primary"><i class="fa fa-print"></i></a>
                              </td>
                            </tr>
                          <?php } ?>
                          <?php

                          //total amount paid
                          if (isset($_GET['search'])) {
                            $search_type = $_GET['search_type'];
                            $search_value = $_GET['search_value'];
                            $TotalAmountPaid = SELECT("SELECT sum(net_paid) FROM payments, bookings  where $search_type like '%$search_value%' and payments.bookingid=bookings.bookingid");
                          } else {
                            $TotalAmountPaid = SELECT("SELECT sum(net_paid) FROM payments, bookings where payments.bookingid=bookings.bookingid");
                          }
                          while ($fetchtotalpayment = mysqli_fetch_array($TotalAmountPaid)) {
                            $TotalPayment = $fetchtotalpayment['sum(net_paid)'];
                          }
                          if ($TotalPayment == null) {
                            $TotalPayment = 0;
                          } else {
                            $TotalPayment = $TotalPayment;
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                    <?php include "../../include/extra/pagination.php"; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>


    <?php include 'payment-popup.php'; ?>


    <!-- end -->
    <?php include '../sidebar.php'; ?>
    <?php include '../footer.php'; ?>
  </div>

  <?php include '../../include/footer_files.php'; ?>
  <script>
    function checkfiltertype() {
      var filtertype = document.getElementById("filtertype");
      if (filtertype.value == "payments.created_at") {
        document.getElementById("filtervalue").type = "date";
      } else if (filtertype.value == "payments.payment_date") {
        document.getElementById("filtervalue").type = "date";
      } else {
        document.getElementById("filtervalue").type = "text";
      }
    }
  </script>
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
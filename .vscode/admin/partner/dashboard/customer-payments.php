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
      document.getElementById("customer_payments").classList.add("app-bg");
    }
  </script>
</head>

<body>
  <div id="container" class="navbar-fixed mainnav-fixed mainnav-lg">
    <?php include '../../header.php'; ?>
    <div class="boxed">
      <div id="content-container">
        <div id="page-content">
          <div class="panel">
            <div class="panel-body">
              <div class="row">
                <?php include 'user-info.php'; ?>
                <div class="col-md-12">
                  <h3 class="app-sub-heading">All Customer Payments</h3>
                  <?php
                  $TotalPayment = 0;
                  $getpayments = SELECT("SELECT * FROM payments, bookings where payments.bookingid=bookings.bookingid and bookings.partner_id='$ViewCustomerId' order by payments.payment_id ASC");
                  $SerialNo = 0;
                  while ($FetchAllPayments = mysqli_fetch_array($getpayments)) {
                    $SerialNo++;
                    $payment_id = $FetchAllPayments['payment_id'];
                    $bookingid = $FetchAllPayments['bookingid'];
                    $booking_date = date("m/Y", strtotime($FetchAllPayments['booking_date']));
                    $payment_mode = $FetchAllPayments['payment_mode'];
                    $payment_amount = $FetchAllPayments['payment_amount'];
                    $payment_date = date("d M, Y", strtotime($FetchAllPayments['payment_date']));
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

                    //booking sql 
                    $BookingSql = "SELECT * FROM bookings where bookingid='$bookingid'";

                    //select customer details
                    $SelectCustomers = SELECT("SELECT * FROM users where id='$customer_id'");
                    $CustomerDetails = mysqli_fetch_array($SelectCustomers);
                    $CustomerName = $CustomerDetails['name'];

                    //agent details
                    $SelectAgents = SELECT("SELECT * FROM users where id='$partner_id'");
                    $AgentDetails = mysqli_fetch_array($SelectAgents);
                    $AgentName = $AgentDetails['name'];

                    //txn details
                    //payment modes
                    if (
                      $payment_mode == "check"
                    ) {
                      $SELECT_check_payments = SELECT("SELECT * from check_payments where payment_id='$payment_id'");
                      $check_payments = mysqli_fetch_array($SELECT_check_payments);
                      $txnid = $check_payments['check_payments'];
                      $checknumber = $check_payments['checknumber'];
                      $checkissuedto = $check_payments['checkissuedto'];
                      $bankName = $check_payments['bankName'];
                      $ifsc = $check_payments['ifsc'];
                      $payment_status = $check_payments['checkstatus'];
                      $check_issued_at = date("d M, Y", strtotime($check_payments['created_at']));
                      $payment_note = "by check no: $checknumber issued on $check_issued_at for $checkissuedto through $bankName | $ifsc e.i $payment_status";
                    } else if ($payment_mode == "banking") {
                      $SELECT_online_payments = SELECT("SELECT * FROM online_payments where payment_id='$payment_id'");
                      $online_payments = mysqli_fetch_array($SELECT_online_payments);
                      $txnid = $online_payments['online_payments_id'];
                      $OnlineBankName = $online_payments['OnlineBankName'];
                      $transactionId = $online_payments['transactionId'];
                      $payment_details = $online_payments['payment_details'];
                      $payment_mode = $online_payments['payment_mode'];
                      $payment_status = $online_payments['transaction_status'];
                      $payment_note = "by Online Banking : Bank Name: $OnlineBankName, TxnId: $transactionId, Details: $payment_details, Status: $payment_status";
                    } else if ($payment_mode == "cash") {
                      $SELECT_cash_payments = SELECT("SELECT * FROM cash_payments where payment_id='$payment_id'");
                      $cash_payments = mysqli_fetch_array($SELECT_cash_payments);
                      $txnid = $cash_payments['cash_payments'];
                      $cashreceivername = $cash_payments['cashreceivername'];
                      $cashamount = $cash_payments['cashamount'];
                      $payment_status = "done!";
                      $payment_note = "Cash " . $payment_amount . " is received by $cashreceivername on " . date("d M, Y h:m A", strtotime($created_at));
                    }
                    $paymentreferenceid = "B$bookingid/P$payment_id/T$txnid/D$payment_created_date_full2";
                    if ($payment_mode == "check") {
                      $payment_mode = "<span class='text-warning'><i class='fa fa-money text-primary'></i> " . UpperCase("CHEQUE") . "</span>";
                    } elseif ($payment_mode == "NetBanking") {
                      $payment_mode = "<span class='text-primary'><i class='fa fa-globe text-info'></i> " . UpperCase("NETBANKING") . "</span>";
                    } else {
                      $payment_mode = "<span class='text-success'><i class='fa fa-exchange text-danger'></i> " . UpperCase("CASH") . "</span>";;
                    }

                    $TotalPayment += $net_paid_amount;
                  ?>
                    <div class="data-list flex-s-b">
                      <span class='w-pr-3'>
                        <span class='text-grey'>SNo</span><br>
                        <span><?php echo $SerialNo; ?></span>
                      </span>
                      <span class='w-pr-20'>
                        <span class='text-grey'>PaymentRefId</span><br>
                        <span>
                          <a href="<?php echo DOMAIN; ?>/admin/booking/receipt.php?id=<?php echo $bookingid; ?>&payment_id=<?php echo $payment_id; ?>" target="blank" class="text-info">
                            <i class='fa fa-print text-danger'></i> <?php echo $paymentreferenceid; ?>
                          </a>
                        </span>
                      </span>
                      <span class='w-pr-12'>
                        <span class='text-grey'>BookingId</span><br>
                        <span>
                          <a class="text-primary" href="<?php echo DOMAIN; ?>/admin/booking/details/?id=<?php echo $bookingid; ?>">B<?php echo $bookingid; ?>/<?php echo date("m/Y", strtotime($created_at)); ?></a>
                        </span>
                      </span>
                      <span class='w-pr-15'>
                        <span class='text-grey'>CustomerName</span><br>
                        <span>
                          <a href="<?php echo DOMAIN; ?>/admin/customer/dashboard/?id=<?php echo $customer_id; ?>" class="text-primary"><i class="fa fa-user text-primary"></i> <?php echo $CustomerName; ?></a>
                        </span>
                      </span>
                      <span class='w-pr-10'>
                        <span class='text-grey'>ProjectName</span><br>
                        <span>
                          <?php echo FETCH($BookingSql, "project_name"); ?>
                        </span>
                      </span>
                      <span class='w-pr-5'>
                        <span class='text-grey'>UnitName</span><br>
                        <span>
                          <?php echo UpperCase(FETCH($BookingSql, "unit_name")); ?>
                        </span>
                      </span>
                      <span class='w-pr-11'>
                        <span class='text-grey'>UnitArea</span><br>
                        <span>
                          <?php echo UpperCase(FETCH($BookingSql, "unit_area")); ?>
                        </span>
                      </span>
                      <span class='w-pr-11'>
                        <span class='text-grey'>PaymentMode</span><br>
                        <span><?php echo $payment_mode; ?></span>
                      </span>
                      <span class='w-pr-8'>
                        <span class='text-grey'>PaymentDate</span><br>
                        <span><?php echo $payment_date; ?></span>
                      </span>
                      <span class='w-pr-12 text-right'>
                        <span class='text-grey'>PaidAmount</span><br>
                        <span><?php echo Price($net_paid_amount, "text-success", "Rs."); ?></span>
                      </span>
                    </div>
                  <?php } ?>
                  <hr>
                  <p class='text-right'>
                    <span class='text-grey h4'>Net Payable By All Customers : </span>
                    <span class='bold h4'>
                      <?php echo Price($NetPayable = AMOUNT("SELECT * FROM bookings where partner_id='$ViewCustomerId'", "net_payable_amount"), "text-success", "Rs."); ?>
                    </span><br>
                    <span class='text-grey fs-12'><?php echo PriceInWords($NetPayable); ?></span>
                  </p>
                  <hr>
                  <p class='text-right'>
                    <span class='text-grey h4'>Paid Amount By All Customers : </span>
                    <span class='bold h4'>
                      <?php echo Price($TotalPayment, "text-primary", "Rs."); ?>
                    </span><br>
                    <span class='text-grey fs-12'><?php echo PriceInWords($TotalPayment); ?></span>
                  </p>
                  <hr>
                  <p class='text-right'>
                    <span class='text-grey h4'>Balance : </span>
                    <span class='bold h4'>
                      <?php echo Price($Balance = $NetPayable - $TotalPayment, "text-danger", "Rs."); ?>
                    </span><br>
                    <span class='text-grey fs-12'><?php echo PriceInWords($Balance); ?></span>
                  </p>
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
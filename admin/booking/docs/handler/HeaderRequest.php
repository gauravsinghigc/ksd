<?php
if (isset($_GET['id'])) {
 $bookingid = $_GET['id'];
 $_SESSION['bookingid'] = $_GET['id'];
} else {
 $bookingid = $_SESSION['id'];
}

if (isset($_GET['dmdid'])) {
 $dmdid = $_GET['dmdid'];
 $_SESSION['dmdid'] = $_GET['dmdid'];
} else {
 $dmdid = $_SESSION['dmdid'];
}

$BookingSql = "SELECT * FROM bookings where bookingid='$bookingid'";
$customer_id = FETCH($BookingSql, "customer_id");
$partner_id = FETCH($BookingSql, "partner_id");
$CoAllotySql = "SELECT * FROM booking_alloties where BookingAllotyMainBookingId='$bookingid' and BookingAllotyFullName!=''";
$CustomerSql = "SELECT * FROM users where id='$customer_id'";
$PartnerSql = "SELECT * FROM users where id='$partner_id'";
$CustomerAddress = "SELECT * FROM user_address where user_id='$customer_id'";
$PartnerAddress = "SELECT * FROM user_address where user_id='$partner_id'";
$DMDSql = "SELECT * FROM booking_pay_req where PaymentRequestId='$dmdid'";

//other variables
$area = FETCH($BookingSql, "unit_area");
$areaint = GetNumbers($area);

$getpayments = SELECT("SELECT *, payments.created_at AS 'payment_created_at' FROM payments, bookings where payments.bookingid=bookings.bookingid and bookings.bookingid='$bookingid' order by payments.payment_id DESC");
$net_paid_amount2 = 0;
$SerialNo = 0;
while ($FetchAllPayments = mysqli_fetch_array($getpayments)) {
 $SerialNo++;
 $payment_id = $FetchAllPayments['payment_id'];
 $bookingid = $FetchAllPayments['bookingid'];
 $booking_date = $FetchAllPayments['booking_date'];
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
 $clearing_date2 = $FetchAllPayments['clearing_date'];
 $emi_months = $FetchAllPayments['emi_months'];
 $net_paid_amount2 += (int)$net_paid_amount;

 if ($payment_mode == "check") {
  $payment_mode = "Cheque";
 } else {
  $payment_mode = $payment_mode;
 }

 //select customer details
 $SelectCustomers = SELECT("SELECT * FROM users where id='$customer_id'");
 $CustomerDetails = mysqli_fetch_array($SelectCustomers);
 $CustomerName = $CustomerDetails['name'];

 //agent details
 $SelectAgents = SELECT("SELECT * FROM users where id='$partner_id'");
 $AgentDetails = mysqli_fetch_array($SelectAgents);
 $AgentName = $AgentDetails['name'];


 $GetPAYMENTS = SELECT("SELECT * FROM payments where payment_id='$payment_id' and bookingid='$bookingid' ORDER BY payment_id  DESC");
 $payments = mysqli_fetch_array($GetPAYMENTS);
 $payment_amount = $payments['payment_amount'];
 $payment_mode = $payments['payment_mode'];
 $slip_no = $payments['slip_no'];
 $remark = $payments['remark'];
 $payment_created_date = date("M, Y", strtotime($payments['payment_date']));
 $payment_created_date_full = date("d M, Y", strtotime($payments['payment_date']));
 $payment_created_date_full2 = date("dmY", strtotime($payments['payment_date']));
 $paymentcreatedat = $payments['created_at'];
 $payment_id = $payments['payment_id'];

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
}

$inputString = FETCH($BookingSql, "unit_name"); // Your input string

// Use preg_replace to remove alphabets and get only numbers
$numbersOnly = preg_replace("/[^0-9]/", "", $inputString);

//total amount paid for thisbookings
$TotalAmountPaid = 0;
$SqlPayments = SELECT("SELECT * FROM payments where bookingid='$bookingid'");
while ($FetchPayments = mysqli_fetch_array($SqlPayments)) {
 $payment_mode = $FetchPayments['payment_mode'];
 $payment_id = $FetchPayments['payment_id'];

 if ($payment_mode == "cash") {
  $TotalAmountPaid += $FetchPayments['net_paid'];
  $paymentstatus = "Received";
 } elseif ($payment_mode == "banking") {
  $checkbankpayment = SELECT("SELECT * FROM online_payments where payment_id='$payment_id'");
  $checkbankpaymentstatus = mysqli_fetch_assoc($checkbankpayment);
  $paymentstatus = $checkbankpaymentstatus['transaction_status'];
  if ($paymentstatus == "Success") {
   $TotalAmountPaid += $FetchPayments['net_paid'];
  } else {
   $TotalAmountPaid += 0;
  }
 } elseif ($payment_mode == "check") {
  $SqlChequepayments = SELECT("SELECT * FROM check_payments where payment_id='$payment_id'");
  $FetchChequepayments = mysqli_fetch_assoc($SqlChequepayments);
  $paymentstatus = $FetchChequepayments['checkstatus'];
  if ($paymentstatus == "Clear") {
   $TotalAmountPaid += $FetchPayments['net_paid'];
  } else {
   $TotalAmountPaid += 0;
  }
 }
}
$PaymentforProjects = $TotalAmountPaid;
$project_unit_id = FETCH($BookingSql, 'project_unit_id');

$CheckSqlForReSale = CHECK("SELECT * FROM booking_resales where booking_main_id='$bookingid' and booking_resale_type='TRANSFER'");
if ($CheckSqlForReSale != null) {
 $PreviousBookingId = FETCH("SELECT * FROM bookings where bookingid!='$bookingid' AND project_unit_id='$project_unit_id' ORDER BY bookingid DESC limit 1", "bookingid");
 $PreviousPayment = GetNetPaidAmount($PreviousBookingId);
} else {
 $PreviousPayment = 0;
}

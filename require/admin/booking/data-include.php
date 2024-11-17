<?php

$bookingid = $_GET['id'];
//bookings details
$GetBookings = SELECT("SELECT * FROM bookings where bookingid='$bookingid'");
$Bookings = mysqli_fetch_array($GetBookings);
$project_name = $Bookings['project_name'];
$project_area = $Bookings['project_area'];
$unit_name = $Bookings['unit_name'];
$unit_area = $Bookings['unit_area'];
$str = $unit_area;
$unit_area_2 = preg_replace('/[^0-9.]+/', '', $str);
$unit_rate = $Bookings['unit_rate'];
$unit_cost = $Bookings['unit_cost'];
$net_payable_amount = $Bookings['net_payable_amount'];
$booking_date = $Bookings['booking_date'];
$clearing_date = $Bookings['clearing_date'];
$clearing_date2 = $Bookings['clearing_date'];
$possession = $Bookings['possession'];
$chargename = $Bookings['chargename'];
$charges = $Bookings['charges'];
$discountname = $Bookings['discountname'];
$discount = $Bookings['discount'];
$created_at = $Bookings['created_at'];
$customer_id = $Bookings['customer_id'];
$partner_id = $Bookings['partner_id'];
$matches = preg_replace('/[^0-9.]+/', '', $unit_area);
$unit_area_in_numbers = (int)$matches;
$possession_notes = SECURE($Bookings['possession_notes'], "d");
$possession_update_date = $Bookings['possession_update_date'];
$ref_no = $Bookings['ref_no'];
$crn_no = $Bookings['crn_no'];

//partner details
$GetPartner = SELECT("SELECT * FROM users where id='$partner_id'");
$Partners = MYSQLI_FETCH_ARRAY($GetPartner);
$partner_name = $Partners['name'];
$partner_email = $Partners['email'];
$partner_phone = $Partners['phone'];

//customer DETAILS
$GetUsers = SELECT("SELECT * FROM users where id='$customer_id'");
$users = mysqli_fetch_array($GetUsers);
$customer_name = $users['name'];
$customer_phone = $users['phone'];
$customer_email = $users['email'];

//customer Address
$Getuseraddress = SELECT("SELECT * FROM user_address where user_id='$customer_id'");
$useraddress = mysqli_fetch_array($Getuseraddress);
$user_street_address = $useraddress['user_street_address'];
$user_area_locality = $useraddress['user_area_locality'];
$user_city = $useraddress['user_city'];
$user_state = $useraddress['user_state'];
$user_pincode = $useraddress['user_pincode'];
$user_country = $useraddress['user_country'];

if (isset($_GET['payment_id'])) {
 $payment_id = $_GET['payment_id'];
 $GetPAYMENTS = SELECT("SELECT * FROM payments where payment_id='$payment_id' and bookingid='$bookingid' ORDER BY payment_id  DESC");
} else {
 $GetPAYMENTS = SELECT("SELECT * FROM payments where bookingid='$bookingid' ORDER BY payment_id  DESC");
}
$payments = mysqli_fetch_array($GetPAYMENTS);
$payment_amount = $payments['payment_amount'];
$payment_mode = $payments['payment_mode'];
$slip_no = $payments['slip_no'];
$remark = $payments['remark'];
$payment_date = $payments['payment_date'];
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
 $payment_note = "Cash " . $payment_amount . " is received by $cashreceivername on " . date("d M, Y h:m A", strtotime($paymentcreatedat));
}


//total amount paid for thisbookings
$TotalAmountPaid = 0;
$SqlPayments = SELECT("SELECT * FROM payments where bookingid='$bookingid'");
while ($FetchPayments = mysqli_fetch_array($SqlPayments)) {
 $payment_mode = $FetchPayments['payment_mode'];
 $payment_id = $FetchPayments['payment_id'];

 if ($payment_mode == "cash") {
  $TotalAmountPaid += $FetchPayments['net_paid'];
 } elseif ($payment_mode == "banking") {
  $checkbankpayment = SELECT("SELECT * FROM online_payments where payment_id='$payment_id'");
  $checkbankpaymentstatus = mysqli_fetch_assoc($checkbankpayment);
  $transaction_status = $checkbankpaymentstatus['transaction_status'];
  if ($transaction_status == "Success") {
   $TotalAmountPaid += $FetchPayments['net_paid'];
  } else {
   $TotalAmountPaid += 0;
  }
 } elseif ($payment_mode == "check") {
  $SqlChequepayments = SELECT("SELECT * FROM check_payments where payment_id='$payment_id'");
  $FetchChequepayments = mysqli_fetch_assoc($SqlChequepayments);
  $checkstatus = $FetchChequepayments['checkstatus'];
  if ($checkstatus == "Clear") {
   $TotalAmountPaid += $FetchPayments['net_paid'];
  } else {
   $TotalAmountPaid += 0;
  }
 }
}

$PaymentforProjects = $TotalAmountPaid;

//check payment status
$SqlPayments = SELECT("SELECT * FROM payments where bookingid='$bookingid'");
$FetchPayments = mysqli_fetch_assoc($SqlPayments);


//payment payment_status
if ($payment_status == "Issued") {
 $amount_paid = $payment_amount;
 $balance = $net_payable_amount;
} elseif ($payment_status == "Cleared") {
 $amount_paid = $PaymentforProjects;
 $balance = $payment_amount - $net_payable_amount;
} elseif ($payment_status == "done!") {
 $amount_paid = $PaymentforProjects;
 $balance = $payment_amount - $net_payable_amount;
} else {
 $amount_paid = $payment_amount;
}


//reference nnumber
$refrenecenum = rand(0000000, 100000000);
$paymentreferenceid = "B$bookingid/P$payment_id/T$txnid/D$payment_created_date_full2";

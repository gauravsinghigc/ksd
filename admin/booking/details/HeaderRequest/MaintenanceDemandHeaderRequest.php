<?php

if (isset($_GET['id'])) {
 $bookingid = $_GET['id'];
 $_SESSION['bookingid'] = $_GET['id'];
} else {
 $bookingid = $_SESSION['id'];
}

$BookingSql = "SELECT * FROM bookings where bookingid='$bookingid'";
$customer_id = FETCH($BookingSql, "customer_id");
$partner_id = FETCH($BookingSql, "partner_id");
$CoAllotySql = "SELECT * FROM booking_alloties where BookingAllotyMainBookingId='$bookingid' and BookingAllotyFullName!=''";
$CustomerSql = "SELECT * FROM users where id='$customer_id'";
$PartnerSql = "SELECT * FROM users where id='$partner_id'";
$CustomerAddress = "SELECT * FROM user_address where user_id='$customer_id'";
$PartnerAddress = "SELECT * FROM user_address where user_id='$partner_id'";
$project_unit_id = FETCH($BookingSql, "project_unit_id");

//other variables
$area = FETCH($BookingSql, "unit_area");
$areaint = GetNumbers($area);
$MainBookingID = "B" . $bookingid . "/" . date('m/Y', strtotime(FETCH($BookingSql, 'created_at')));

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

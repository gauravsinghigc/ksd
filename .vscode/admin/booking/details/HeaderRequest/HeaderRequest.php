<?php

if (isset($_GET['id'])) {
 $BookingViewId = $_GET['id'];
 $_SESSION['BOOKING_VIEW_ID'] = $_GET['id'];
} else {
 $BookingViewId = $_SESSION['BOOKING_VIEW_ID'];
}

$GetBookings = SELECT("SELECT * FROM bookings where bookingid='$BookingViewId' ORDER BY bookingid DESC");
$Bookings = mysqli_fetch_array($GetBookings);
$bookingid = $Bookings['bookingid'];
$project_name = $Bookings['project_name'];
$project_area = $Bookings['project_area'];
$unit_name = strtoupper($Bookings['unit_name']);
$unit_area = $Bookings['unit_area'];
$unit_rate = $Bookings['unit_rate'];
$unit_cost = $Bookings['unit_cost'];
$net_payable_amount = $Bookings['net_payable_amount'];
$booking_date = $Bookings['booking_date'];
$clearing_date = $Bookings['clearing_date'];
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
$possession_notes = $Bookings['possession_notes'];
$possession_update_date = $Bookings['possession_update_date'];
$project_unit_id = $Bookings['project_unit_id'];
$emi_months = $Bookings['emi_months'];
$emi_last_date = date("d M, Y", strtotime($Bookings['booking_date'], strtotime("+$emi_months months")));
$crn_no = $Bookings['crn_no'];
$ref_no = $Bookings['ref_no'];

$agent_relation = FETCH("SELECT * FROM users where id='$customer_id'", "agent_relation");
if ($agent_relation == 0) {
 $Update = UPDATE("UPDATE users SET agent_relation='$partner_id' where id='$customer_id'");
}

//customer DETAILS
$getusers = SELECT("SELECT * FROM users, user_address, user_roles where users.company_relation='" . company_id . "' and users.id='$customer_id' and users.id=user_address.user_id and users.user_role_id=user_roles.role_id");
$count = 0;
$customers = mysqli_fetch_array($getusers);
$count++;
$customer_name = $customers['name'];
$customer_phone = $customers['phone'];
$customer_email = $customers['email'];
$user_street_address = $customers['user_street_address'];
$user_area_locality = $customers['user_area_locality'];
$user_city = $customers['user_city'];
$user_state = $customers['user_state'];
$user_pincode = $customers['user_pincode'];
$user_country = $customers['user_country'];
$executedcustomer_id = $customers['user_id'];
$customer_user_profile_img = $customers['user_profile_img'];
$user_status = $customers['user_status'];
$created_at_c = $customers['created_at'];
$user_role_id = $customers['user_role_id'];
$user_role_name = $customers['role_name'];
$agent_relation = $customers['agent_relation'];
if ($user_status == "ACTIVE") {
 $user_status_view = "<span class='text-success'><i class='fa fa-check-circle'></i> Active</span>";
} else {
 $user_status_view = "<span class='text-danger'><i class='fa fa-warning'></i> Inactive</span>";
}
if ($customer_user_profile_img == "user.png") {
 $customer_user_profile_img = DOMAIN . "/storage/sys-img/$customer_user_profile_img";
} else {
 $customer_user_profile_img = DOMAIN . "/storage/users/$executedcustomer_id/img/$customer_user_profile_img";
}

//agent details
$getusers_a = SELECT("SELECT * FROM users, user_roles where users.company_relation='" . company_id . "' and users.id='$partner_id' and users.user_role_id=user_roles.role_id");
$count = 0;
$agents = mysqli_fetch_array($getusers_a);
$count++;
$customer_id_a = $agents['id'];
$customer_name_a = $agents['name'];
$customer_phone_a = $agents['phone'];
$customer_email_a = $agents['email'];
$AddSQL = "SELECT * FROM user_address where user_id='$customer_id_a'";
$user_street_address_a = FETCH($AddSQL, 'user_street_address');
$user_area_locality_a = FETCH($AddSQL, 'user_area_locality');
$user_city_a = FETCH($AddSQL, 'user_city');
$user_state_a = FETCH($AddSQL, 'user_state');
$user_pincode_a = FETCH($AddSQL, 'user_pincode');
$user_country_a = FETCH($AddSQL, 'user_country');
$executedcustomer_id_a = $agents['id'];
$customer_user_profile_img_a = $agents['user_profile_img'];
$user_status_a = $agents['user_status'];
$created_at_a = $agents['created_at'];
$user_role_id_a = $agents['user_role_id'];
$user_role_name_a = $agents['role_name'];
if ($user_status_a == "ACTIVE") {
 $user_status_viea_a = "<span class='text-success'><i class='fa fa-check-circle'></i> Active</span>";
} else {
 $user_status_view_a = "<span class='text-danger'><i class='fa fa-warning'></i> Inactive</span>";
}
if ($customer_user_profile_img_a == "user.png") {
 $customer_user_profile_img_a = DOMAIN . "/storage/sys-img/$customer_user_profile_img_a";
} else {
 $customer_user_profile_img_a = DOMAIN . "/storage/users/$customer_id_a/img/$customer_user_profile_img_a";
}

//last payment
$GetPAYMENTS = CHECK("SELECT * FROM payments where bookingid='$bookingid' ORDER BY payment_id DESC");
if ($GetPAYMENTS == true) {
 $GetPAYMENTS = SELECT("SELECT * FROM payments where bookingid='$bookingid' ORDER BY payment_id DESC");
 $payments = mysqli_fetch_array($GetPAYMENTS);
 $payment_amount = $payments['payment_amount'];
 $payment_mode = $payments['payment_mode'];
 $slip_no = $payments['slip_no'];
 $remark = $payments['remark'];
 $payment_date = $payments['payment_date'];
 $paymentcreatedat = $payments['created_at'];
} else {
 $payment_amount = "";
 $payment_mode = "";
 $slip_no = "";
 $remark = "";
 $payment_date = "";
 $paymentcreatedat = "";
}

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

//total amount paid for developmemnt charges previous
$AllDevPaidCharges1 = "SELECT * FROM developmentcharges, developmentchargepayments where developmentcharges.bookingid='$bookingid' and developmentcharges.devchargesid=developmentchargepayments.developmentchargeid and devpaymentstatus like '%RECEIVED%'";
$AllDevPaidCharges2 = "SELECT * FROM developmentcharges, developmentchargepayments where developmentcharges.bookingid='$bookingid' and developmentcharges.devchargesid=developmentchargepayments.developmentchargeid and devpaymentstatus like '%PAID%'";
$AllDevPaidCharges3 = "SELECT * FROM developmentcharges, developmentchargepayments where developmentcharges.bookingid='$bookingid' and developmentcharges.devchargesid=developmentchargepayments.developmentchargeid and devpaymentstatus like '%CLEAR%'";
$AllDevPaidCharges4 = "SELECT * FROM developmentcharges, developmentchargepayments where developmentcharges.bookingid='$bookingid' and developmentcharges.devchargesid=developmentchargepayments.developmentchargeid and devpaymentstatus like '%SUCCESS%'";
$NetDevPaidAmount = AMOUNT($AllDevPaidCharges4, "devchargepaymentamount") + AMOUNT($AllDevPaidCharges1, "devchargepaymentamount") + AMOUNT($AllDevPaidCharges2, "devchargepaymentamount") + AMOUNT($AllDevPaidCharges3, "devchargepaymentamount");
$NetchargesPaid = $NetDevPaidAmount;
if ($NetchargesPaid == null) {
 $NetchargesPaid = 0;
} else {
 $NetchargesPaid = $NetchargesPaid;
}

//emiavriabel
$emi_id = FETCH("SELECT * FROM booking_emis where booking_id='$bookingid'", "emi_id");

//Booking id
$MainBookingID = "B$bookingid/" . date("m/Y", strtotime($created_at));

$BankLoanSql = "SELECT * FROM booking_loans where booking_main_id='$bookingid'";

<?php

if (isset($_GET['b_id'])) {
 $_SESSION['bid'] = $_GET['b_id'];
 $bookingID = $_GET['b_id'];
} else {
 $bookingID = $_SESSION['bid'];
}
if (CHECK("SELECT * FROM bookings where bookingid='$bookingID'") == null) {
 LOCATION("warning", "No booking found!", DOMAIN . "/admin/booking");
} else {
 $SearchBookings = SELECT("SELECT * FROM bookings where bookingid='$bookingID'");
}

$FetchDetails = mysqli_fetch_array($SearchBookings);
$customer_id = $FetchDetails['customer_id'];
$CustomerId = $customer_id;
$Select_Users = "SELECT * FROM users where id='$customer_id'";
$Query = mysqli_query($DBConnection, $Select_Users);
$Customers = mysqli_fetch_assoc($Query);
$C_user_role_id = $Customers['user_role_id'];
$C_name = $Customers['name'];
$C_email = $Customers['email'];
$C_phone = $Customers['phone'];
$C_user_profile_img = $Customers['user_profile_img'];
$C_created_at = $Customers['created_at'];
$C_updated_at = $Customers['updated_at'];
$C_password = $Customers['password'];
$C_company_relation_id = $Customers['company_relation'];
if ($C_user_profile_img == null or $C_user_profile_img == "user.png") {
 $C_user_profile_img = DOMAIN . "/storage/sys-img/user.png";
} else {
 $C_user_profile_img = DOMAIN . "/storage/users/$CustomerId/img/$C_user_profile_img";
}

//customer address
//customer address
$C_FetchAddress = SELECT("SELECT * FROM user_address where user_id='$CustomerId'");
$C_IfExits = mysqli_num_rows($C_FetchAddress);
if ($C_IfExits == 0) {
 $C_user_street_address = "";
 $C_user_area_locality = "";
 $C_user_state = "";
 $C_user_city = "";
 $C_user_pincode = "";
 $C_created_at = "";
 $C_updated_at = "";
 $C_user_country = "";
} else {
 $C_fetchAdd = mysqli_fetch_array($C_FetchAddress);
 $C_user_street_address = htmlentities($C_fetchAdd['user_street_address']);
 $C_user_area_locality = $C_fetchAdd['user_area_locality'];
 $C_user_city = $C_fetchAdd['user_city'];
 $C_user_state = $C_fetchAdd['user_state'];
 $C_user_pincode = $C_fetchAdd['user_pincode'];
 $C_user_country = $C_fetchAdd['user_country'];
 $C_created_at = $C_fetchAdd['created_at'];
 $C_updated_at = $C_fetchAdd['updated_at'];
}
//customer type
$C_Select_UsersTypes = SELECT("SELECT * from user_roles where role_id='$C_user_role_id'");
$C_UserTypes = mysqli_fetch_assoc($C_Select_UsersTypes);
$C_role_name = $C_UserTypes['role_name'];

//verification textarea
$verification = rand(000000, 999999);

$GetBookings = SELECT("SELECT * FROM bookings where bookingid='$bookingID' ORDER BY bookingid DESC");
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
$matches = preg_replace('/[^0-9.]+/', '', $unit_area);
$unit_area_in_numbers = (int)$matches;
$possession_notes = SECURE($Bookings['possession_notes'], "d");
$possession_update_date = $Bookings['possession_update_date'];
$emi_months = $Bookings['emi_months'];
$emi_payable_amount = round((int)$net_payable_amount / (int)$emi_months);

$MainBookingID = "B$bookingid/" . date("m/Y", strtotime($created_at));

if (isset($_GET['demand_id'])) {
 $_SESSION['demand_id'] = $_GET['demand_id'];
 $DemandId = $_GET['demand_id'];
} else {
 if (isset($_SESSION['demand_id'])) {
  $_SESSION['demand_id'] = $_SESSION['demand_id'];
  $DemandId = $_SESSION['demand_id'];
 } else {
  $DemandId = FETCH("SELECT PaymentRequestId FROM booking_pay_req where PayReqBookingId='$bookingID' ORDER BY PaymentRequestId DESC limit", "PaymentRequestId");
  $_SESSION["demand_id"] = $DemandId;
 }
}

<?php
require '../../require/modules.php';
require "../../require/admin/sessionvariables.php";
require '../../include/admin/common.php';

// Set the file name and path
$filename = 'booking_reports.csv';
$path = __DIR__ . '/' . $filename;

// Open the file for writing
$file = fopen($path, 'w');

// Write the header row
$header_row = [
  'Sno',
  'Project Name/Plot NO',
  'Plot Area',
  '(ID)Customer Name',
  'Phone Number',
  'Email-Id',
  '(ID)Agent Name',
  'Net Payable',
  'Net Received',
  'Pending',
  'Received in (%)',
  'Net Dev-Charges',
  'Paid Dev-Charges',
  'Balance Dev-Charges',
  'TotalPayable',
  'TotalPaid',
  'TotalBalance',
  'Booking Date',
  'Status'
];
fputcsv($file, $header_row);

if (isset($_GET['bookingid'])) {
  $bookingid = $_GET['bookingid'];
  $project_name = $_GET['project_name'];
  $unit_name = $_GET['unit_name'];
  $unit_area = $_GET['unit_area'];
  $unit_rate = $_GET['unit_rate'];
  $customer_id = $_GET['customer_id'];
  $partner_id = $_GET['partner_id'];
  $booking_date = $_GET['booking_date'];
  $created_at = $_GET['created_at'];
  $possession = $_GET['possession'];
  $crn_no = $_GET['crn_no'];
  $status = $_GET['status'];
  if ($created_at == " " or $booking_date == " ") {
    $daterange = "and DATE(booking_date)<='$created_at' and DATE(booking_date)>='$booking_date'";
  } else {
    $daterange = "";
  }
  $GetBookings = SELECT("SELECT * FROM bookings where crn_no like '%$crn_no%' $daterange and possession like '%$possession%' and partner_id like '%$partner_id%' and customer_id like '%$customer_id%' and unit_rate like '%$unit_rate%' and unit_area like '%$unit_area%' and unit_name like '%$unit_name%' and bookingid like '%$bookingid%' and project_name like '%$project_name%' and status like '%$status%' order by CAST(SUBSTRING(unit_name, 2) AS UNSIGNED) ASC");
} else {
  $GetBookings = SELECT("SELECT * FROM bookings where status!='DELETED' ORDER BY CAST(SUBSTRING(unit_name, 2) AS UNSIGNED) ASC");
}
$nettotalpayments = 0;
$totalpaymentpaid = 0;
$TOTAL_PAYABLE = 0;
$TOTAL_PAID = 0;
$TOTAL_BALANCE = 0;
$Count = 0;
$data_rows = [];
$row = [];
while ($Bookings = mysqli_fetch_array($GetBookings)) {
  $Count++;
  $bookingid = $Bookings['bookingid'];
  $project_name = $Bookings['project_name'];
  $project_area = $Bookings['project_area'];
  $unit_name = $Bookings['unit_name'];
  $unit_area = $Bookings['unit_area'];
  $unit_rate = $Bookings['unit_rate'];
  $unit_cost = $Bookings['unit_cost'];
  $net_payable_amount = $Bookings['net_payable_amount'];
  $booking_date = $Bookings['booking_date'];
  $possession = $Bookings['possession'];
  $chargename = $Bookings['chargename'];
  $charges = $Bookings['charges'];
  $discountname = $Bookings['discountname'];
  $discount = $Bookings['discount'];
  $created_at = $Bookings['created_at'];
  $customer_id = $Bookings['customer_id'];
  $partner_id = $Bookings['partner_id'];
  $project_unit_id = $Bookings['project_unit_id'];
  $emi_months = $Bookings['emi_months'];
  $clearing_date = $Bookings['clearing_date'];
  $TOTAL_PAYABLE += $net_payable_amount;
  $status = $Bookings['status'];

  //check booking is cancelled or not

  //update project units
  $Update = UPDATE("UPDATE project_units SET project_unit_status='SOLD' where project_units_id='$project_unit_id'");


  //customer DETAILS
  $GetUsers = SELECT("SELECT * FROM users where id='$customer_id'");
  $users = mysqli_fetch_array($GetUsers);
  $customer_name = $users['name'];
  $customer_phone = $users['phone'];
  $customer_email = $users['email'];

  //agent details
  $GetAgents = SELECT("SELECT * FROM users where id='$partner_id'");
  $agents = mysqli_fetch_array($GetAgents);
  $partner_name = $agents['name'];
  $partner_phone = $agents['phone'];
  $partner_email = $agents['email'];

  //customer Address
  $Getuseraddress = SELECT("SELECT * FROM user_address where user_id='$customer_id'");
  $useraddress = mysqli_fetch_array($Getuseraddress);
  $user_street_address = $useraddress['user_street_address'];
  $user_area_locality = $useraddress['user_area_locality'];
  $user_city = $useraddress['user_city'];
  $user_state = $useraddress['user_state'];
  $user_pincode = $useraddress['user_pincode'];
  $user_country = $useraddress['user_country'];


  //total amount paid for thisbookings
  $PaymentforProjects = 0;
  $TotalAmountPaid = SELECT("SELECT * FROM payments where bookingid='$bookingid'");
  while ($fetchtotalpayment = mysqli_fetch_array($TotalAmountPaid)) {
    $PaymentforProjects += $fetchtotalpayment['net_paid'];
  }
  if ($PaymentforProjects == null) {
    $PaymentforProjects = 0;
  } else {
    $PaymentforProjects = $PaymentforProjects;
  }

  //total payment paid
  $totalpaymentpaid += $PaymentforProjects;
  $TOTAL_PAID += (int)$PaymentforProjects;
  $Balance = $net_payable_amount - $PaymentforProjects;

  //dev charges
  $NetDevCharges = AMOUNT("SELECT * FROM developmentcharges where bookingid='$bookingid'", "developementchargeamount");
  if($NetDevCharges == null || $NetDevCharges == 0){
      $NetDevCharges = 0;
  }

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

$DevBalance = $NetDevCharges - $NetchargesPaid;
$NetPayableALL = $net_payable_amount + $NetDevCharges;
$TotalPaidAll = $PaymentforProjects + $NetchargesPaid;
$TotalBalanceAll = $Balance + $DevBalance;
  //make csv file rows of data
  $row = [
    "$Count",
    "$project_name / $unit_name",
    "$unit_area",
    "($customer_id) $customer_name",
    "$customer_phone",
    "$customer_email",
    "($partner_id) $partner_name",
    "Rs.$net_payable_amount",
    "Rs.$PaymentforProjects",
    "Rs.$Balance",
    "" . 100 - round(($net_payable_amount - $PaymentforProjects) / $net_payable_amount * 100, 2) . " %",
    "Rs." . $NetDevCharges  . "",
    "Rs." . $NetchargesPaid . "",
    "Rs." . $DevBalance . "",
    "Rs.$NetPayableALL",
    "Rs.$TotalPaidAll",
    "Rs.$TotalBalanceAll",
    "" . date("d M, Y", strtotime($booking_date)) . "",
    "$status"
  ];

  array_push($data_rows, $row);
}

$NET_BALANCE = $TOTAL_PAYABLE - $TOTAL_PAID;
if ($TOTAL_PAYABLE == 0) {
  $TOTAL_PAYABLE = 1;
}
$row = [
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "Rs." . $TOTAL_PAYABLE . "",
  "Rs." . $TOTAL_PAID . "",
  "Rs." . $NET_BALANCE . "",
  "" . round(($TOTAL_PAYABLE - $TOTAL_PAID) / $TOTAL_PAYABLE * 100, 2) . " %",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  ""

];

array_push($data_rows, $row);

foreach ($data_rows as $data_row) {
  fputcsv($file, $data_row);
}

// Close the file
fclose($file);

header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Pragma: no-cache');
readfile($path);

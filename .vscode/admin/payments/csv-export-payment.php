<?php
require '../../require/modules.php';
require "../../require/admin/sessionvariables.php";
require '../../include/admin/common.php';

// Set the file name and path
$filename = 'Allpayment_reports.csv';
$path = __DIR__ . '/' . $filename;

// Open the file for writing
$file = fopen($path, 'w');

// Write the header row
$header_row = [
 'Sno',
 'TxnRefId',
 'BookingID',
 'Customer',
 'Plot No',
 'Agent',
 'Payment Mode',
 'NetPaid',
 'Paid Date',
 'CreatedAt',

];
fputcsv($file, $header_row);
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
                           FROM payments, bookings 
                           WHERE payments.bookingid = bookings.bookingid 
                           ORDER BY payments.payment_id DESC 
                         ");
}

$Count = 0;
$data_rows = [];
$row = [];
while ($FetchAllPayments = mysqli_fetch_array($getpayments)) {
 $Count++;
 $paymentreferenceid;
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


 $row = [
  "$Count",
  "B $bookingid /" . date("m/Y", strtotime($created_at)),
  "$CustomerName",
  "$plotName (" . $FetchAllPayments['project_area'] . ")",
  "$AgentName",
  "$payment_mode",
  "$net_paid_amount",
  "" . DATE_FORMATE2("d M ,Y", $payment_date),
  "" . DATE_FORMATE2("d M ,Y", $payment_created_at),
 ];
}

$row = [
 "",
 "",
 "",
 "",
 "",
 "",
 "",
 "",
 "",
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

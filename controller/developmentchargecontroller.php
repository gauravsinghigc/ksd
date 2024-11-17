<?php

//add controller helper files
require 'helper.php';

//add aditional requirements
require '../require/admin/sessionvariables.php';

//start request processing

if (isset($_POST['CreateDevelopmentCharges'])) {
 $developmentchargetitle = $_POST['developmentchargetitle'];
 $developmentchargetype = $_POST['developmentchargetype'];
 if ($developmentchargetype == "Others") {
  $developmentchargetype = $_POST['otherchargecategory'];
 } else {
  $developmentchargetype = $_POST['developmentchargetype'];
 }
 $developmentcharge = $_POST['developmentcharge'];
 $developmentchargepercentage = $_POST['developmentchargepercentage'];
 $developementchargeamount = $_POST['developementchargeamount'];
 $developmentchargedescription = SECURE(POST("developmentchargedescription"), "e");
 $bookingid = $_SESSION['BOOKING_VIEW_ID2'];
 $developmentchargecreatedat = RequestDataTypeDate;
 $developmentchargestatus = "OPEN";

 $Save = SAVE("developmentcharges", ["developmentchargepercentage", "bookingid", "developmentchargetitle", "developmentchargetype", "developmentcharge", "developementchargeamount", "developmentchargedescription", "developmentchargecreatedat", "developmentchargestatus"]);
 RESPONSE($Save, "Development Charges <b>$developmentchargetitle</b> with Booking <b>B$bookingid</b> is added Successfully!", "Unable to Add development charge in Bookings");

 //receive payments
} elseif (isset($_POST['ReceivedDevelopmentChargePayments'])) {

 //common variables
 $devchargepaymentamount = $_POST['devchargepaymentamount'];
 $devchargepaymentnotes = $_POST["devchargepaymentnotes"];
 $developmentchargeid = $_SESSION['DEVELOPMENT_CHARGE_ID'];
 $devchargepaymentmode = $_POST['devchargepaymentmode'];
 $devpaymentcreatedat = RequestDataTypeDate;

 //cash payments
 if ($devchargepaymentmode == "CASH") {
  $devpaymentreceivedby = $_POST['cashreceivername'];
  $devpaymentreleaseddate = date("Y-m-d", strtotime($_POST['cashreceivedate']));
  $devpaymentstatus = "RECEIVED";
  $devpaymentdetails = SECURE("Cash Received by $devpaymentreceivedby on " . DATE_FORMATE2("d M, Y", $devpaymentreleaseddate), "e");

  //online payments
 } elseif ($devchargepaymentmode == "BANKING") {
  $onlinepaymenttype = $_POST['onlinepaymenttype'];
  $devpaymentbankname = $_POST['OnlineBankName'];
  $transactionId = $_POST['transactionId'];
  $devpaymentstatus = $_POST['transaction_status'];
  $devpaymentdetails = $_POST["payment_details"];
  $devpaymentreleaseddate = date("Y-m-d", strtotime($_POST['transactiondate']));
  $devpaymentdetails = "TxnID: $transactionId<br> Mode: $onlinepaymenttype<br> Notes: " . $devpaymentdetails;
  $devpaymentdetails = SECURE($devpaymentdetails, "e");

  //cheque payments
 } else if ($devchargepaymentmode == "CHEQUE") {
  $checkissuedto = $_POST['checkissuedto'];
  $checknumber = $_POST['checknumber'];
  $devpaymentbankname = $_POST['BankName'];
  $ifsc = $_POST['ifsc'];
  $devpaymentreleaseddate = $_POST['checkcleardate'];
  $devpaymentstatus = $_POST['checkstatus'];
  $devpaymentreceivedby = $_POST['chequereceivedby'];
  $checkcleardate = $_POST['checkcleardate'];
  $checkissuedate = $_POST['checkissuedate'];
  $devpaymentupdatedat = $checkissuedate;
  $devpaymentdetails = "Bank: " . $devpaymentbankname . ",<br> IFSC: $ifsc <br> Cheque No: $checknumber,<br> IssuedTo: $checkissuedto,<br> Issue At: " . DATE_FORMATE2("d M, Y", $checkissuedate) . ", <br> Clear At: ". DATE_FORMATE2("d M, Y", $checkcleardate).",<br> Cheque Received By : $devpaymentreceivedby";
  $devpaymentdetails = SECURE($devpaymentdetails, "e");
 }

 $Save = SAVE("developmentchargepayments", ["developmentchargeid", "devpaymentupdatedat", "devchargepaymentmode", "devchargepaymentamount", "devchargepaymentnotes", "devpaymentreceivedby", "devpaymentbankname", "devpaymentreleaseddate", "devpaymentstatus", "devpaymentdetails", "devpaymentcreatedat"]);
 RESPONSE($Save, "Payment Received for Development Charge RefID: DC$developmentchargeid!", "Unable to recieve Payment for Development Charges!");

 //update development charge details
} elseif (isset($_POST['UpdateDevelopmentChargeDetails'])) {
 $devchargepaymentid  = SECURE($_POST['devchargepaymentid'], "d");

 $Update = UPDATE_DATA("developmentchargepayments", [
  "devchargepaymentmode" => $_POST['devchargepaymentmode'],
  "devchargepaymentamount" => $_POST['devchargepaymentamount'],
  "devchargepaymentnotes" => $_POST['devchargepaymentnotes'],
  "devpaymentreceivedby" => $_POST['devpaymentreceivedby'],
  "devpaymentbankname" => $_POST['devpaymentbankname'],
  "devpaymentreleaseddate" => $_POST['devpaymentreleaseddate'],
  "devpaymentstatus" => $_POST['devpaymentstatus'],
  "devpaymentupdatedat" => $_POST['devpaymentupdatedat'],
  "devpaymentdetails" => SECURE($_POST['devpaymentdetails'], "e")
 ], "devchargepaymentid='$devchargepaymentid'");

 RESPONSE($Update, "Development charge details are updated successfully!", "Unable to update development charge details at the moment!");

 //update development charge details
} elseif (isset($_POST['UpdateDevelopmentCharges'])) {
 $devchargesid = SECURE($_POST['devchargesid'], "d");

 $developmentchargetitle = $_POST['developmentchargetitle'];
 $developmentchargetype = $_POST['developmentchargetype'];
 if ($developmentchargetype == "Others") {
  $developmentchargetype = $_POST['otherchargecategory'];
 } else {
  $developmentchargetype = $_POST['developmentchargetype'];
 }

 $developmentcharge = $_POST['developmentcharge'];
 $developmentchargepercentage = $_POST['developmentchargepercentage'];
 $developementchargeamount = $_POST['developementchargeamount'];
 $developmentchargedescription = SECURE(POST("developmentchargedescription"), "e");
 $developmentchargecreatedat = RequestDataTypeDate;
 $developmentchargestatus = $_POST['developmentchargestatus'];

 $Save = UPDATE_TABLE(
  "developmentcharges",
  [
   "developmentchargepercentage", "developmentchargetitle", "developmentchargetype", "developmentcharge", "developementchargeamount", "developmentchargedescription", "developmentchargecreatedat", "developmentchargestatus"
  ],
  "devchargesid='$devchargesid'"
 );
 RESPONSE($Save, "Development Charges <b>$developmentchargetitle</b> with Booking <b>B$bookingid</b> is updated Successfully!", "Unable to Add development charge in Bookings");
}

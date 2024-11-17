<?php
//add controller helper files
require 'helper.php';

//add aditional requirements
require '../require/admin/sessionvariables.php';

//start your actions from here
if (isset($_POST['create_payment'])) {
  $company_id = $_POST['create_payment'];
  $bookingid = $_POST['bookingid'];

  //payment
  $payment_mode = $_POST['payment_mode'];

  //check
  $checkissuedto = $_POST['checkissuedto'];
  $checknumber = $_POST['checknumber'];
  $BankName = $_POST['BankName'];
  $ifsc = $_POST['ifsc'];
  $checkstatus = $_POST['checkstatus'];

  //OnlineBankName
  $onlinepaymenttype = $_POST['onlinepaymenttype'];
  $OnlineBankName = $_POST['OnlineBankName'];
  $transactionId = $_POST['transactionId'];
  $payment_details = $_POST['payment_details'];
  $transaction_status = $_POST['transaction_status'];

  //cash payment
  $cashreceivername = $_POST['cashreceivername'];
  $cashamount = $_POST['net_paid'];

  //payment date
  if ($payment_mode == "cash") {
    $payment_date = $_POST['cashreceivedate'];
  } else if ($payment_mode == "check") {
    $payment_date = $_POST['checkissuedate'];
  } else {
    $payment_date = $_POST['transactiondate'];
  }

  //remark
  $slip_no = $_POST['slip_no'];
  $remark = $_POST['remark'];
  $charges = $_POST['chargename'];
  $chargeamount = $_POST['charges'];
  $discounts = $_POST['discountname'];
  $discountamount = $_POST['discount'];
  $net_paid = $_POST['net_paid'];

  $payment_amount = $_POST['payment_amount'];
  $checkamount = $net_paid;
  $onlinepaidamount = $net_paid;

  $paid_date = RequestDataTypeDate;
  $created_at = RequestDataTypeDate;
  $NetPayableEmiAmount = $_POST['NetPayableEmiAmount'];
  $TotalEMI = FETCH("SELECT * FROM booking_emis where booking_id='$bookingid'", "emi_months");
  $EmiAmount = FETCH("SELECT * from booking_emis where booking_id='$bookingid'", 'emi_per_month');
  $emi_months = $TotalEMI;
  $emi_per_month = $EmiAmount;

  //save payments
  $payment_type = "MONTH EMI";
  $create_payments = SAVE("payments", ["emi_ids", "bookingid", "payment_mode", "payment_amount", "slip_no", "remark", "payment_date", "charges", "chargeamount", "discounts", "discountamount", "net_paid", "payment_type", "created_at"]);
  if ($create_payments == true) {

    $selectpayments = SELECT("SELECT * FROM payments where bookingid='$bookingid' and payment_amount='$payment_amount' ORDER BY payment_id DESC");
    $payments = mysqli_fetch_array($selectpayments);
    $payment_id = $payments['payment_id'];

    //create payment modes
    if ($payment_mode == "check") {
      if ($checkstatus == "Clear") {
        $clearedat = $_POST['clearedat'];
      } else {
        $clearedat = null;
      }
      $issuedat = $_POST['checkissuedate'];
      $created_at = $_POST['checkissuedate'];
      $savechecks = SAVE("check_payments", ["payment_id", "checkissuedto", "checknumber", "BankName", "ifsc", "checkamount", "checkstatus", "created_at", "issuedat", "clearedat"]);
      if ($savechecks == true) {
        $payment = "save";
      } else {
        $payment = "failed";
      }
    } else if ($payment_mode == "cash") {
      $created_at = $_POST['cashreceivedate'];
      $savecash = SAVE("cash_payments", ["payment_id", "cashreceivername", "cashamount", "created_at"]);
      if ($savecash == true) {
        $payment = "save";
      } else {
        $payment = "failed";
      }
    } else if ($payment_mode == "banking") {
      $payment_mode = $_POST['onlinepaymenttype'];
      $created_at = $_POST['transactiondate'];
      $saveonlinepayment = SAVE("online_payments", ["payment_id", "OnlineBankName", "transactionId", "onlinepaidamount", "created_at", "payment_details", "payment_mode", "transaction_status"]);
      if ($saveonlinepayment == true) {
        $payment = "save";
      } else {
        $payment = "failed";
      }
    }
  }

  if ($payment == "save") {
    $bookingid = $bookingid;
    $payment_id = $payment_id;

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

    $GetPAYMENTS = SELECT("SELECT * FROM payments where bookingid='$bookingid' and payment_id='$payment_id' ORDER BY payment_id  DESC");
    $payments = mysqli_fetch_array($GetPAYMENTS);
    $payment_amount = $payments['payment_amount'];
    $payment_mode = $payments['payment_mode'];
    $slip_no = $payments['slip_no'];
    $remark = $payments['remark'];
    $payment_date = $payments['payment_date'];
    $payment_created_date = date("Y-m-d", strtotime($payments['payment_date']));
    $payment_created_date_full = date("Y-m-d", strtotime($payments['payment_date']));
    $payment_created_date_full2 = date("dmy", strtotime($payments['payment_date']));
    $paymentcreatedat = $payments['created_at'];
    $payment_id = $payments['payment_id'];

    //txnID fetching
    if ($payment_mode == "check") {
      $SELECT_check_payments = SELECT("SELECT * from check_payments where payment_id='$payment_id'");
      $check_payments = mysqli_fetch_array($SELECT_check_payments);
      $txnid = $check_payments['check_payments'];
      $checknumber = $check_payments['checknumber'];
      $checkissuedto = $check_payments['checkissuedto'];
      $bankName = $check_payments['bankName'];
      $ifsc = $check_payments['ifsc'];
      $payment_status = $check_payments['checkstatus'];
      $check_issued_at = date("Y-m-d", strtotime($check_payments['created_at']));
      $payment_note = "<br>by check no: $checknumber issued on $check_issued_at for $checkissuedto through $bankName | $ifsc e.i $payment_status";
    } else if ($payment_mode == "banking") {
      $SELECT_online_payments = SELECT("SELECT * FROM online_payments where payment_id='$payment_id'");
      $online_payments = mysqli_fetch_array($SELECT_online_payments);
      $txnid = $online_payments['online_payments_id'];
      $OnlineBankName = $online_payments['OnlineBankName'];
      $transactionId = $online_payments['transactionId'];
      $payment_details = $online_payments['payment_details'];
      $payment_mode = $online_payments['payment_mode'];
      $payment_status = $online_payments['transaction_status'];
      $payment_note = "<br>by Online Banking : Bank Name:$OnlineBankName, TxnId: $transactionId, Details: $payment_details, Status: $payment_status";
    } else if ($payment_mode == "cash") {
      $SELECT_cash_payments = SELECT("SELECT * FROM cash_payments where payment_id='$payment_id'");
      $cash_payments = mysqli_fetch_array($SELECT_cash_payments);
      $txnid = $cash_payments['cash_payments'];
      $cashreceivername = $cash_payments['cashreceivername'];
      $cashamount = $cash_payments['cashamount'];
      $payment_status = "done!";
      $payment_note = "<br>Cash " . $payment_amount . " is received by $cashreceivername on " . date("d M, Y h:m A", strtotime($paymentcreatedat));
    }

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

    //payment reference id
    $paymentreferenceid = "B$bookingid/P$payment_id/T$txnid/D$payment_created_date_full2";

    //sent mail for recpective mail-ids
    $getpayments = SELECT("SELECT * FROM payments where bookingid='$bookingid' and payment_id='$payment_id' order by payments.payment_id ASC");
    $TotalPayment = 0;
    $NetpaidTotal = 0;
    $SerialNo = 0;
    while ($FetchAllPayments = mysqli_fetch_array($getpayments)) {
      $SerialNo++;
      $payment_id = $FetchAllPayments['payment_id'];
      $bookingid = $FetchAllPayments['bookingid'];
      $payment_mode = $FetchAllPayments['payment_mode'];
      $payment_amount = $FetchAllPayments['payment_amount'];
      $payment_date = date("Y-m-d", strtotime($paymentcreatedat));
      $slip_no = $FetchAllPayments['slip_no'];
      $payment_id = $FetchAllPayments['payment_id'];
      $created_at = $FetchAllPayments['created_at'];
      $net_paid_amount = $FetchAllPayments['net_paid'];
      $payment_type = $FetchAllPayments['payment_type'];
      $charges2 = $FetchAllPayments['charges'];
      $chargeamount2 = $FetchAllPayments['chargeamount'];
      $discounts2 = $FetchAllPayments['discounts'];
      $discountamount2 = $FetchAllPayments['discountamount'];
      $TotalPayment += $payment_amount;
      $NetpaidTotal += $net_paid_amount;
      $remark = $FetchAllPayments['remark'];
      //payment status
      $SqlPayments = SELECT("SELECT * FROM payments where bookingid='$bookingid'");
      $FetchPayments = mysqli_fetch_array($SqlPayments);
      if ($payment_mode == "cash") {
        $paymentstatus = "Received";
        $cashreceivername = FETCH("SELECT * FROM cash_payments where payment_id='$payment_id'", "cashreceivername");
        $net_paid_amount = $net_paid_amount;
        $payment_Details = "Cash Payment received by $cashreceivername";
        $created_at = $FetchPayments['created_at'];
        $paid_date = $payment_created_date_full;
      } elseif ($payment_mode == "banking") {
        $checkbankpayment = SELECT("SELECT * FROM online_payments where payment_id='$payment_id'");
        $checkbankpaymentstatus = mysqli_fetch_assoc($checkbankpayment);
        $paymentstatus = $checkbankpaymentstatus['transaction_status'];
        $OnlineBankName = $checkbankpaymentstatus['OnlineBankName'];
        $transactionId = $checkbankpaymentstatus['transactionId'];
        $payment_details = $checkbankpaymentstatus['payment_details'];
        $payment_mode = $checkbankpaymentstatus['payment_mode'];
        $paid_date =  date("Y-m-d", strtotime($checkbankpaymentstatus['created_at']));
        $transaction_status = $checkbankpaymentstatus['transaction_status'];
        $payment_Details = "Bank Name : $OnlineBankName<br>
       Txn ID : $transactionId<br>
       Details : $payment_details<br>
       Pay By : $payment_mode<br>
       Txn Status : $transaction_status<br>";

        if ($paymentstatus == "Success") {
          $net_paid_amount = $net_paid_amount;
        } else {
          $net_paid_amount = 0;
        }
      } elseif ($payment_mode == "check") {
        $SqlChequepayments = SELECT("SELECT * FROM check_payments where payment_id='$payment_id'");
        $FetchChequepayments = mysqli_fetch_assoc($SqlChequepayments);
        $paymentstatus = $FetchChequepayments['checkstatus'];
        $checkissuedto = $FetchChequepayments['checkissuedto'];
        $checknumber = $FetchChequepayments['checknumber'];
        $bankName = $FetchChequepayments['bankName'];
        $ifsc = $FetchChequepayments['ifsc'];
        $checkstatus = $FetchChequepayments['checkstatus'];
        if ($checkstatus == "Clear") {
          if ($FetchChequepayments['clearedat'] == null) {
            $paid_date = $paymentcreatedat;
          } else {
            $paid_date = date("Y-m-d", strtotime($FetchChequepayments['clearedat']));
          }
        } else {
          if ($paid_date == null) {
            $paid_date = date("Y-m-d", strtotime($payment_created_date_full));
            $clearedat = $paid_date;
          } else {
            $paid_date = "Check is $checkstatus";
          }
        }


        $clearedat = $FetchChequepayments['clearedat'];
        $bounceat = $FetchChequepayments['bounceat'];
        $inbankat = $FetchChequepayments['inbankat'];
        $issuedat = $FetchChequepayments['issuedat'];

        if ($bounceat == null) {
          $bounceat = "";
        } else {
          $bounceat = date("Y-m-d", strtotime($FetchChequepayments['bounceat']));
        }

        if ($inbankat == null) {
          $inbankat = "";
        } else {
          $inbankat = date("Y-m-d", strtotime($FetchChequepayments['inbankat']));
        }
        if ($issuedat == null) {
          $issuedat = "";
        } else {
          $issuedat = date("Y-m-d", strtotime($FetchChequepayments['issuedat']));
        }

        if ($clearedat == null) {
          $clearedat = "";
        } else {
          $clearedat = date("Y-m-d", strtotime($FetchChequepayments['clearedat']));
        }
        $payment_Details = "Cheque Issued To : $checkissuedto<br>
       Cheque No :  $checknumber<br>
       Bank & IFSC : $bankName | $ifsc<br>
       Current Status : $checkstatus<br>
       Issue Date : $issuedat<br>
       Cleared At : $clearedat<br>
       Bounce At : $bounceat<br>
       InBank At : $inbankat";
        if ($paymentstatus == "Clear") {
          $net_paid_amount = $net_paid_amount;
        } else {
          $net_paid_amount = 0;
        }
        $payment_mode = "Cheque";
      }
    }

    LOCATION("success", "Monthly Payment Received for B$bookingid Booking!", "$access_url");
  } else {
    LOCATION("danger", "Unable to recieve EMI Payment for B$bookingid!", "$access_url");
  }

  //commission payouts
} elseif (isset($_POST['commission_payouts'])) {
  $partner_id = $_SESSION['USER_VIEW_ID'];
  $commission_payout_amount = $_POST['commission_payout_amount'];
  $commission_payout_type = $_POST['commission_payout_type'];
  $commission_payout_date = RequestDataTypeDate;
  $commission_payout_payment_mode = $_POST['commission_payout_payment_mode'];
  $commission_status = "Executed!";
  $commission_payout_notes = htmlentities($_POST['commission_payout_notes']);

  $Save = SAVE("commission_payouts", ["partner_id", "commission_payout_amount", "commission_payout_type", "commission_payout_date", "commission_payout_payment_mode", "commission_status", "commission_payout_notes"]);
  RESPONSE($act = $Save, "Amount of Rs.$commission_payout_amount is paid for thier $commission_payout_type!", "Unable to Make payouts of Rs.$commission_payout_amount for $commission_payout_type");

  //update check status
} else if (isset($_POST['updatecheckstatus'])) {
  $check_payments = $_POST['updatecheckstatus'];
  $checkstatus = $_POST['checkstatusnew'];
  $checkissuedto = $_POST['checkissuedto'];
  $checknumber = $_POST['checknumber'];
  $bankName = $_POST['bankName'];
  $ifsc = $_POST['ifsc'];
  $checkamount = $_POST['checkamount'];
  $datetime = RequestDataTypeDate;
  $clearedat = $_POST['clearedat'];
  $issuedat = $_POST['issuedat'];
  $inbankat = $_POST['inbankat'];
  $bounceat = $_POST['bounceat'];
  $created_at = $_POST['created_at'];

  $payment_id = FETCH("SELECT * FROM check_payments where check_payments='$check_payments'", "payment_id");

  $payments = [
    "payment_amount" => $checkamount,
    "payment_date" => $clearedat,
    "net_paid" => $checkamount
  ];
  $Update = UPDATE_DATA("payments", $payments, "payment_id=$payment_id");
  $Update = UPDATE("UPDATE check_payments SET created_at='$created_at', bounceat='$bounceat', inbankat='$inbankat', checkstatus='$checkstatus', checkissuedto='$checkissuedto', checknumber='$checknumber', bankName='$bankName', ifsc='$ifsc', checkamount='$checkamount', issuedat='$issuedat', clearedat='$clearedat' where check_payments='$check_payments'");

  RESPONSE($Update, "Check Status Updated Successfully which is $checkstatus", "Unable to Update Check Status");

  //update online payment
} else if (isset($_POST['updateonlinepaymentstatus'])) {
  $online_payments_id = $_POST['updateonlinepaymentstatus'];
  $update_at = date("d M, Y");
  $transaction_status = $_POST['transaction_status'];
  $payment_mode = $_POST['payment_mode'];
  $OnlineBankName = $_POST['OnlineBankName'];
  $transactionId = $_POST['transactionId'];
  $payment_details = $_POST['payment_details'];
  $created_at = $_POST['created_at'];
  $onlinepaidamount = $_POST['onlinepaidamount'];

  $payment_id = FETCH("SELECT * FROM online_payments where online_payments_id='$online_payments_id'", "payment_id");
  $payments = [
    "payment_amount" => $onlinepaidamount,
    "payment_date" => $created_at,
    "net_paid" => $onlinepaidamount
  ];
  $Update = UPDATE_DATA("payments", $payments, "payment_id=$payment_id");
  $update  = UPDATE("UPDATE online_payments SET onlinepaidamount='$onlinepaidamount', created_at='$created_at', payment_details='$payment_details', transactionId='$transactionId', OnlineBankName='$OnlineBankName', payment_mode='$payment_mode', transaction_status='$transaction_status', update_at='$update_at' where online_payments_id='$online_payments_id'");
  RESPONSE($update, "Online Payment Status is Updated Successfully!", "Unable to Update Online Payment Status");

  //delete payment records
} elseif (isset($_GET['delete_payment_records'])) {

  $access_url = SECURE($_GET['access_url'], "d");
  $delete_payment_records = SECURE($_GET['delete_payment_records'], "d");

  if ($delete_payment_records == true) {
    $control_id = SECURE($_GET['control_id'], "d");
    $payment_mode = SECURE($_GET['payment_mode'], "d");
    $delete = DELETE_FROM("payments", "payment_id='$control_id'");

    if ($payment_mode == "cash") {
      $delete = DELETE_FROM("cash_payments", "payment_id='$control_id'");
    } elseif ($payment_mode == "check") {
      $deletecash = DELETE_FROM("check_payments", "payment_id='$control_id'");
    } elseif ($payment_mode == "banking") {
      $deletecash = DELETE_FROM("online_payments", "payment_id='$control_id'");
    }
  } else {
    $delete = false;
  }
  RESPONSE($delete, "Payment Record deleted successfully!", "Unable to delete payment record at the moment!");

  //update commissio
} elseif (isset($_POST['AddCommissionDetails'])) {
  $commission_id = SECURE($_POST['commission_id'], "d");
  $partner_id = SECURE($_POST['partner_id'], "d");

  //commission payout details
  $payouts = array(
    "partner_id" => $partner_id,
    "commission_id" => $commission_id,
    "commission_payout_amount" => $_POST['commission_payout_amount'],
    "commission_payout_type" => $_POST['commission_payout_type'],
    "commission_payout_date" => $_POST['commission_payout_date'],
    "commission_payout_payment_mode" => $_POST['commission_payout_payment_mode'],
    "commission_status" => $_POST['commission_status'],
    "commission_payout_notes" => SECURE($_POST['commission_payout_notes'], "e")
  );
  $save = INSERT("commission_payouts", $payouts);
  RESPONSE($save, "Commission Payourt details saved!", "Unable to save commission payout details!");
}

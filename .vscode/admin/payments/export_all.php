<?php
require '../../require/modules.php';
require "../../require/admin/sessionvariables.php";
require '../../include/admin/common.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Export All Payments</title>
 <style>
  table.striped {
   border-spacing: 0;
   width: 100%;
   border: 1px solid #ddd;
  }

  tr.striped:nth-child(even) {
   background-color: #f2f2f2;
  }

  tr,
  td {
   text-align: left !important;
   padding: 3px !important;
  }

  th {
   text-align: left !important;
  }
 </style>
</head>

<body onload="doConvert()" style="font-size:13px !important;color: black !important;margin:auto;font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">

 <section style="border-style:groove; border-width:thin;margin: auto; width: 1300px;border: 1px solid rgb(147 78 255);padding: 5px;">
  <small class="float:left;"><i></i></small>
  <div style="text-align:center;">
   <h3 style="line-height:1;margin-bottom:4px;margin-top:0px;font-size:24px !important;">
    ALL PAYEMENT<br>
    <small style="color:grey; font-size:16px !important;">PAYMENT REPORTS</small>
   </h3>
  </div>
  <?php include "../../include/export/rc-header.php"; ?>
  <hr>
  <table class="table striped table-striped" style="width:100%;">
   <thead>
    <tr style="background-color: #6a6a6a;color: white;">
     <th style="width:2%;">Sno</th>
     <th style="width:11%;">Payment RefId</th>
     <th style="width:7%;">BookingID</th>
     <th style="width:30% !important;">(ID)Customer Name</th>
     <th style="width:12% !important;">(ID)Agent Name</th>
     <th style="width:5% !important;">Mode</th>
     <th style="width:6% !important;">NetPaid</th>
     <th style="width:9% !important;">Paid Date</th>
     <th style="width:9% !important;">Created At</th>
     <th style="width:8% !important;">Type</th>
    </tr>
   </thead>
   <tbody>
    <?php
    if (isset($_GET['search_type'])) {
     $search_value = $_GET['search_value'];
     $search_type = $_GET['search_type'];
     if ($search_type == "payments.payment_date") {
                              $search_value = $search_value;
                            } elseif ($search_type == "payments.created_at") {
                              $search_value = $search_value;
                            } else {
                              $search_value = $search_value;
                            }
     $getpayments = SELECT("SELECT *, payments.created_at AS 'payment_created_at' FROM payments, bookings where $search_type like '%$search_value%' and payments.bookingid=bookings.bookingid order by payments.payment_id ASC");
    } else {
     $getpayments = SELECT("SELECT *, payments.created_at AS 'payment_created_at' FROM payments, bookings where payments.bookingid=bookings.bookingid order by payments.payment_id ASC");
    }
    $CountNo = 0;
    $NetPaid = 0;
    while ($FetchAllPayments = mysqli_fetch_array($getpayments)) {
     $payment_id = $FetchAllPayments['payment_id'];
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
     $NetPaid += ($net_paid_amount);

     $payment_created_date = date("M, Y", strtotime($FetchAllPayments['payment_date']));
     $payment_created_date_full = date("d M, Y", strtotime($FetchAllPayments['payment_date']));
     $payment_created_date_full2 = date("dmY", strtotime($FetchAllPayments['payment_date']));
     $paymentcreatedat = $FetchAllPayments['created_at'];

     if ($payment_mode == "check") {
      $payment_mode = "Cheque";
     } else {
      $payment_mode = $payment_mode;
     }
     $txnid = 0;
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

     $paymentreferenceid = "B$bookingid/P$payment_id/T$txnid/D$payment_created_date_full2";

     //select customer details
     $SelectCustomers = SELECT("SELECT * FROM users where id='$customer_id'");
     $CustomerDetails = mysqli_fetch_array($SelectCustomers);
     $CustomerName = $CustomerDetails['name'];

     //agent details
     $SelectAgents = SELECT("SELECT * FROM users where id='$partner_id'");
     $AgentDetails = mysqli_fetch_array($SelectAgents);
     $AgentName = $AgentDetails['name'];
     $CountNo++;
    ?>
     <tr class="striped">
      <td><?php echo $CountNo; ?></td>
      <td><b><?php echo $paymentreferenceid; ?></b></td>
      <td>B<?php echo $bookingid; ?>/<?php echo date("m/Y", strtotime($created_at)); ?></td>
      <td>(<?php echo $customer_id; ?>) <?php echo $CustomerName; ?></td>
      <td>(<?php echo $partner_id; ?>) <?php echo $AgentName; ?></td>
      <td><?php echo $payment_mode; ?></td>
      <td>Rs.<?php echo $net_paid_amount; ?></td>
      <td><?php echo $payment_date; ?></td>
      <td><?php echo $payment_created_at; ?></td>
      <td><?php echo $payment_type; ?></td>
     </tr>
    <?php } ?>
    <?php

    //total amount paid
    if (isset($_GET['search'])) {
     $search_type = $_GET['search_type'];
     $search_value = $_GET['search_value'];
    if ($search_type == "payments.payment_date") {
                              $search_value = $search_value;
                            } elseif ($search_type == "payments.created_at") {
                              $search_value = $search_value;
                            } else {
                              $search_value = $search_value;
                            }
     $TotalAmountPaid = SELECT("SELECT sum(net_paid) FROM payments, bookings  where $search_type like '%$search_value%' and payments.bookingid=bookings.bookingid");
    } else {
     $TotalAmountPaid = SELECT("SELECT sum(net_paid) FROM payments, bookings where payments.bookingid=bookings.bookingid");
    }
    while ($fetchtotalpayment = mysqli_fetch_array($TotalAmountPaid)) {
     $TotalPayment = $fetchtotalpayment['sum(net_paid)'];
    }
    if ($TotalPayment == null) {
     $TotalPayment = 0;
    } else {
     $TotalPayment = $TotalPayment;
    }
    ?>
    <tr>
     <td colspan="6" align="right" style="text-align:right !important;">
      <b style="text-align:right !important;">
       <b class="fs-16" style="font-size:20px !important;">Total Payment &nbsp;</b>
      </b>
     </td>
     <td style="color:green;font-size:20px !important;"><span class="fs-16"><b>Rs.<?php echo $TotalPayment; ?></b></span></td>
     <td colspan="4"></td>
    </tr>
   </tbody>
  </table>
  <p style="color:grey; font-size:12px;text-align:center;"><b>Exported On:</b> <?php echo date("D d M, Y"); ?> by (UID : <?php echo LOGIN_UserId; ?>) <?php echo LOGIN_UserFullName; ?>, <?php echo LOGIN_UserEmailId; ?>, <?php echo LOGIN_UserPhoneNumber; ?> | <b>UserType :</b> <?php echo LOGIN_UserRoleName; ?></p>

 </section>
</body>

</html>
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
  <title>Print B<?php echo $_GET['id']; ?> Receipts</title>
</head>

<body onload="doConvert()" style="padding: 1rem;color: black;font-size:13px;margin:auto;font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">
  <?php
  include "data-include.php";
  ?>



  <section style="border-style:groove; border-width:thin;margin: auto; width: 1000px;border: 1px solid rgb(147 78 255);padding: 5px;">


    <div style="text-align:center;">
      <h3 style="line-height:1;margin-bottom:4px;margin-top:-19px;font-size:30px !important;">
        <br>
        BOOKING CANCELLED<br>
        <small style='color:grey;font-weight:600 !important;font-size:17px !important;'>Booking Cancel & Refund Receipt</small>
        <hr>
      </h3>
    </div>
    <div style="position: absolute;
    width: inherit;
    color: red !important;
    transform: rotate(-30deg);
    text-align: center;
    margin-top: 15rem;">
      <hr>
      <h1>BOOKING B<?php echo $_GET['id']; ?>/<?php echo date("m/Y", strtotime($created_at)); ?> CANCELLED!</h1>
      <hr>
    </div>
    <?php include "../../include/export/rc-header.php"; ?>
    <div style="display: flex;justify-content: space-between;margin-top:7px;">
      <div style="width:40%;">
        <?php include "../../include/export/booking-and-customer-details.php"; ?>
      </div>
      <div>
        <?php include "../../include/export/booking-project-unit-details.php"; ?>
      </div>
      <div>
        <table style="text-align:left;line-height: 15px;">
          <tr>
            <th>Booking Date :</th>
            <td><?php echo date("d M, Y", strtotime($booking_date)); ?></td>
          </tr>
          <tr>
            <th>Invoice No:</th>
            <td>B<?php echo $_GET['id']; ?>/<?php echo date("m/Y", strtotime($created_at)); ?></td>
          </tr>
          <tr>
            <th>Receipt At:</th>
            <td><?php echo date("d M, Y h:i A"); ?></td>
          </tr>
        </table>
      </div>
    </div>

    <style>
      table.striped {
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
      }

      tr.striped:nth-child(even) {
        background-color: #f2f2f2;
      }
    </style>
    <hr>
    <h3 style="text-align:center; margin-top:2px; margin-bottom:2px;background-color:lightgray;padding:4px;">All Payments</h3>
    <table class="striped" style="width:100%;padding:1px;">
      <thead style="background-color:#d7d7d7; color:black;">
        <tr>
          <th align="right">SNo</th>
          <th align="right">PaymentRefId</th>
          <th align="right">Payment Mode</th>
          <th align="right">Amount</th>
          <th align="right">Charges</th>
          <th align="right">Discount</th>
          <th align="right">NetPaid</th>
          <th align="right">Payment Date</th>
          <th align="right">Status</th>
          <th align="right">Type</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (isset($_GET['search'])) {
          $search_type = $_GET['search_type'];
          $search_value = $_GET['search_value'];
          $getpayments = SELECT("SELECT * FROM payments where $search_type like '%$search_value%' and bookingid='$bookingid' order by payments.payment_id DESC");
        } else {
          $getpayments = SELECT("SELECT * FROM payments where bookingid='$bookingid' order by payments.payment_id DESC");
        }
        $TotalPayment = 0;
        $NetpaidTotal = 0;
        $SerialNo = 0;
        while ($FetchAllPayments = mysqli_fetch_array($getpayments)) {
          $SerialNo++;
          $payment_id = $FetchAllPayments['payment_id'];
          $bookingid = $FetchAllPayments['bookingid'];
          $payment_mode = $FetchAllPayments['payment_mode'];
          $payment_amount = $FetchAllPayments['payment_amount'];
          $payment_date = date("d M, Y", strtotime($FetchAllPayments['payment_date']));
          $slip_no = $FetchAllPayments['slip_no'];
          $payment_id = $FetchAllPayments['payment_id'];
          $created_at = $FetchAllPayments['created_at'];
          $net_paid_amount = $FetchAllPayments['net_paid'];
          $net_paid_amount2 = $FetchAllPayments['net_paid'];
          $payment_type = $FetchAllPayments['payment_type'];
          $charges2 = $FetchAllPayments['charges'];
          $chargeamount2 = $FetchAllPayments['chargeamount'];
          $discounts2 = $FetchAllPayments['discounts'];
          $discountamount2 = $FetchAllPayments['discountamount'];
          $TotalPayment += $payment_amount;
          $NetpaidTotal += $net_paid_amount;

          //payment status
          $SqlPayments = SELECT("SELECT * FROM payments where payment_id='$payment_id' and bookingid='$bookingid'");
          $FetchPayments = mysqli_fetch_array($SqlPayments);
          if ($payment_mode == "cash") {
            $paymentstatus = "Received";
            $net_paid_amount = $net_paid_amount;
          } elseif ($payment_mode == "banking") {
            $checkbankpayment = SELECT("SELECT * FROM online_payments where payment_id='$payment_id' and payment_id='$payment_id'");
            $checkbankpaymentstatus = mysqli_fetch_assoc($checkbankpayment);
            $paymentstatus = $checkbankpaymentstatus['transaction_status'];
            if ($paymentstatus == "Success") {
              $net_paid_amount = $net_paid_amount;
            } else {
              $net_paid_amount = 0;
            }
          } elseif ($payment_mode == "check") {
            $SqlChequepayments = SELECT("SELECT * FROM check_payments where payment_id='$payment_id'");
            $FetchChequepayments = mysqli_fetch_assoc($SqlChequepayments);
            $paymentstatus = $FetchChequepayments['checkstatus'];
            if ($paymentstatus == "Clear") {
              $net_paid_amount = $net_paid_amount;
            } else {
              $net_paid_amount = 0;
            }
          }

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

        ?>
          <tr class="striped">
            <td align="right"><?php echo $SerialNo; ?></td>
            <td align="right"><?php echo $paymentreferenceid; ?></td>
            <td align="right"><?php echo $payment_mode; ?></td>
            <td align="right">Rs.<?php echo $payment_amount; ?></td>
            <td align="right">
              <?php if ($chargeamount2 != null or $chargeamount2 != "") { ?>
                <?php echo "+ Rs ." . $chargeamount2; ?>
              <?php } else {
                echo "-";
              } ?>
            </td>
            <td align="right">
              <?php if ($discounts2 != null or $discountamount2 != "") { ?>
                <?php echo "- Rs." . $discountamount2; ?>
              <?php } else {
                echo "-";
              } ?>
            </td>
            <td align="right" class="text-success">Rs.<?php echo $net_paid_amount; ?></td>
            <td align="right"><?php echo $payment_date; ?></td>
            <td align="right"><?php echo $paymentstatus; ?></td>
            <td align="right"><?php echo $payment_type; ?></td>
          </tr>
        <?php } ?>
        <?php
        ?>
        <tr>
          <td class="text-primary" align="right" COLSPAN="4"><span class="fs-16"><b>Rs.<?php echo $TotalPayment; ?></b></span></td>
          <td colspan="3"></td>
          <td class="text-primary" align="right"><span class="fs-16"><b>Rs.<?php echo $TotalAmountPaid; ?></b></span></td>
        </tr>
      </tbody>
    </table>
    <table style="text-align:right;line-height: 14px;font-size:14px !important;width:100% !important;margin-top:1rem !important;font-weight:600 !important;">
      <tr>
        <th>Total Unit Cost :</th>
        <td>Rs.<?php echo $unit_cost; ?></td>
      </tr>
      <?php if ($chargename == null) {
      } else { ?>
        <tr>
          <th><?php echo $chargename; ?> (<?php echo $charges; ?>%) :</th>
          <td>+ Rs.<?php echo $unit_cost / 100 * $charges; ?></td>
        </tr>
      <?php } ?>
      <?php if ($discountname == null) {
      } else { ?>
        <tr>
          <th><?php echo $discountname; ?> (Rs.<?php echo $discount;  ?>/sq area) :</th>
          <td>- Rs.<?php echo $unit_area_in_numbers * $discount; ?></td>
        </tr>
      <?php } ?>
      <tr>
        <th>Net Payable :</th>
        <td>Rs.<?php echo $net_payable_amount; ?></td>
      </tr>
      <tr>
        <th>Total Paid :</th>
        <td style="color:green;">Rs.<?php echo $TotalAmountPaid; ?></td>
      </tr>
      <tr>
        <th>Balance :</th>
        <td style="color:red;">Rs.<?php echo (int)$net_payable_amount - (int)$TotalAmountPaid; ?></td>
      </tr>
    </table>
    <div style="width:100%;display:flex;">
      <div style="width:50%;">
        <h4 style="text-align:center;background-color:lightgrey;padding:7px;text-transform:uppercase;">Booking Cancel Details</h4>
        <?php
        $CancelSql = "SELECT * FROM booking_cancelled where BookingCancelledBookingId='$bookingid'"; ?>

        <table style="width:100%;">
          <tr class="striped">
            <th align="right">Cancel ID:</th>
            <td><?php echo FETCH($CancelSql, "BookingCancelledId"); ?><?php echo DATE_FORMATE2("/d/m/Y", FETCH($CancelSql, "BookingCancelledCreatedAt")); ?>
          </tr>
          <tr class="striped">
            <th align="right">Cancel Date:</th>
            <td><?php echo DATE_FORMATE2("d M, Y", FETCH($CancelSql, "BookingCancelledDate")); ?>
          </tr>
          <tr class="striped">
            <th align="right">Cancel Created At:</th>
            <td><?php echo DATE_FORMATE2("d M, Y", FETCH($CancelSql, "BookingCancelledCreatedAt")); ?>
          </tr>
          <tr class="striped">
            <th align="right">Cancel By:</th>
            <td><?php echo FETCH("SELECT * FROM users where id='" . FETCH($CancelSql, "BookingCancelledBy") . "'", "name"); ?> - <small>ID : <?php echo FETCH($CancelSql, "BookingCancelledBy"); ?></small>
          </tr>
          <tr class="striped">
            <th align="right">Cancel Detail/Reason:</th>
            <td><?php echo SECURE(FETCH($CancelSql, "BookingCancelledReason"), "d"); ?>
          </tr>
        </table>
      </div>
      <div style="width:50%;">
        <h4 style="text-align:center;background-color:lightgrey;padding:7px;text-transform:uppercase;">Booking Refund Details</h4>
        <?php
        $RefundSql = "SELECT * FROM booking_refund where BookingRefundMainBookingId='$bookingid'"; ?>

        <table style="width:100%;">
          <tr class="striped">
            <th align="right">Refund ID:</th>
            <td><?php echo FETCH($RefundSql, "BookingRefundId"); ?><?php echo DATE_FORMATE2("/d/m/Y", FETCH($RefundSql, "BookingRefundCreatedAt")); ?>
          </tr>
          <tr class="striped">
            <th align="right">Refund Date:</th>
            <td><?php echo DATE_FORMATE2("d M, Y", FETCH($RefundSql, "BookingRefundId")); ?>
          </tr>
          <tr class="striped">
            <th align="right">Refund Created At:</th>
            <td><?php echo DATE_FORMATE2("d M, Y", FETCH($RefundSql, "BookingRefundCreatedAt")); ?>
          </tr>
          <tr class="striped">
            <th align="right">Refund Updated At:</th>
            <td><?php echo DATE_FORMATE2("d M, Y", FETCH($RefundSql, "BookingRefundUpdatedAt")); ?>
          </tr>
          <tr class="striped">
            <th align="right">Refund By:</th>
            <td><?php echo FETCH("SELECT * FROM users where id='" . FETCH($RefundSql, "BookingRefundCreatedBy") . "'", "name"); ?> - <small>ID : <?php echo FETCH($RefundSql, "BookingRefundCreatedBy"); ?></small>
          </tr>
          <tr class="striped">
            <th align="right">Refund To:</th>
            <td><?php echo FETCH($RefundSql, "BookingRefundTo"); ?>
          </tr>
          <tr class="striped">
            <th align="right">Refund Amount:</th>
            <td>Rs.<?php echo FETCH($RefundSql, "BookingRefundAmount"); ?>
          </tr>
          <tr class="striped">
            <th align="right">Refund Mode:</th>
            <td><?php echo FETCH($RefundSql, "BookingRefundMode"); ?>
          </tr>
          <tr class="striped">
            <th align="right">Refund Status:</th>
            <td><?php echo FETCH($RefundSql, "BookingRefundStatus"); ?>
          </tr>
          <tr class="striped">
            <th align="right">Refund Detail:</th>
            <td><?php echo SECURE(FETCH($RefundSql, "BookingRefundDetails"), "d"); ?>
          </tr>
        </table>
      </div>
    </div>
    <div style="height:70px;">
      <div style="text-align:right;">
        <p style="font-size:11px;margin-top:0px; margin-bottom:0px;width:200px;padding-top:50px;border-style:groove;border-width:thin;float: right;text-align: center;">Authorised Name & Signature</p>
      </div>
      <div style="text-align:left;">
        <p style="font-size:11px;padding-top: 25px; margin-bottom:0px;">
          <span>Remarks : <?php echo $remark; ?></span><br>
          <i>Ref No: <?php echo $refrenecenum; ?>/B<?php echo $bookingid; ?>/<?php echo date("m/Y"); ?></i><br>
          <span>UID<?php echo LOGIN_UserId; ?>/<?php echo LOGIN_UserFullName; ?></span>
        </p>
      </div>
    </div>
    <br>
  </section>

</body>


</html>
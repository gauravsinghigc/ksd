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
  <title>Booking Receipts B<?php echo $_GET['id']; ?></title>
</head>

<body onload="doConvert()" style="padding: 1rem;color: black !important;font-size:14px;margin:auto;font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">
  <?php
  include "data-include.php";
  ?>



  <section style="border-style:groove;display:block; border-width:thin;margin: auto; width: 1000px;height:1470px;border: 1px solid rgb(147 78 255);padding: 5px;">
    <div style="text-align:center;">
      <br>
      <h3 style="line-height:1;margin-bottom:4px;margin-top:-19px;">
        ------- BOOKING RECEIPT ---------
        <br>
      </h3>
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
    <p style="margin-top:10px; margin-bottom:0px;">
      <span><b>AGENT Details :</b>
        AGENT ID : <?php echo $partner_id; ?></span><br>
      <b>Name : </b><?php echo $partner_name; ?> |
      <b>Email : </b><?php echo $partner_email; ?> |
      <b>Phone : </b><?php echo $partner_phone; ?>
    </p>
    <div style="display: flex;justify-content: space-between;">
      <div style="width:70%;">
        <p style="margin-top:10px; margin-bottom:0px;">
          <span><b>Payment Note :</b><br> Total <span><?php echo PriceinWords($payment_amount); ?></span> rupees is paid for booking <b>B<?php echo $bookingid; ?>/<?php echo date("m/Y", strtotime($created_at)); ?></b> which is paid on <?php echo date("d M, Y h:m A", strtotime($paymentcreatedat)); ?> <?php echo $payment_note; ?></span>
        </p>
      </div>
      <table style="text-align:right;line-height: 12px;width:48% !important;">
        <tr>
          <th>Total Unit Cost :</th>
          <td>Rs.<?php echo Price($unit_cost, "", ""); ?></td>
        </tr>
        <?php if ($chargename == null) {
        } else { ?>
          <tr>
            <th><?php echo $chargename; ?> (<?php echo $charges; ?>%) :</th>
            <td>+ Rs.<?php echo round($unit_cost / 100 * $charges); ?></td>
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
          <th>Net Payable (100%) :</th>
          <td><?php echo Price($net_payable_amount, "", "Rs."); ?></td>
        </tr>
        <tr>
          <th>Amount Paid (<?php echo $PaidPercentage = round($payment_amount / $net_payable_amount * 100, 2); ?>%) :</th>
          <td>Rs.<?php echo Price($payment_amount, "", ""); ?></td>
        </tr>
        <tr>
          <th>Balance (<?php echo 100 - $PaidPercentage; ?>%) :</th>
          <td>Rs.<?php echo Price((int)$net_payable_amount - (int)$payment_amount, "", ""); ?></td>
        </tr>
      </table>
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
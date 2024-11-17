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




  <section style="border-style:groove;display:block; border-width:thin;margin: auto; width: 1000px;height:1470px;border: 1px solid rgb(147 78 255);padding: 5px;">
    <div style="text-align:center;">
      <br>
      <h3 style="line-height:1;margin-bottom:4px;margin-top:-19px;font-size:15px !important;">
        --------- BOOKING BALANCE RECEIPT -------------
        <br>
      </h3>
    </div>
    <?php include "../../include/export/rc-header.php"; ?>

    <div style="display: flex;justify-content: space-between;margin-top:7px;">
      <div style="width:40%;">
        <table style="text-align:left;line-height: 17px;">
          <tr>
            <th style="width:35%;">REF No : </th>
            <td><?php echo $ref_no . "//CRN:" . $crn_no; ?></td>
          </tr>
          <tr>
            <th>Customer Name :</th>
            <td><?php echo $customer_name; ?></td>
          </tr>
          <tr>
            <th>Address :</th>
            <td><?php echo "$user_street_address $user_area_locality $user_city $user_state $user_pincode $user_country"; ?></td>
          </tr>
          <tr>
            <th>Phone Number :</th>
            <td><?php echo $customer_phone; ?></td>
          </tr>
          <tr>
            <th>Email ID :</th>
            <td><?php echo $customer_email; ?></td>
          </tr>
        </table>
      </div>
      <div>
        <table style="text-align:left;line-height: 17px;">
          <tr>
            <th>Project Name :</th>
            <td><?php echo $project_name; ?></td>
          </tr>
          <tr>
            <th>Unit No: :</th>
            <td><?php echo $unit_name; ?></td>
          </tr>
          <tr>
            <th>Unit Area :</th>
            <td><?php echo $unit_area; ?></td>
          </tr>
          <tr>
            <th>Rate:</th>
            <td>Rs.<?php echo $unit_rate; ?>/unit area</td>
          </tr>
          <tr>
            <th>Unit Cost:</th>
            <td>Rs.<?php echo $unit_cost; ?></td>
          </tr>
          <tr>
            <th>Possession:</th>
            <td><?php echo $possession; ?></td>
          </tr>
        </table>
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
          <span><b>Payment Note :</b><br> Total <span><?php echo PriceInWords($payment_amount); ?></span> rupees is paid for booking <b>B<?php echo $bookingid; ?>/<?php echo date("m/Y", strtotime($created_at)); ?></b> which is paid on <?php echo date("d M, Y h:m A", strtotime($paymentcreatedat)); ?> <?php echo $payment_note; ?></span><br><br>
        </p>
      </div>
      <table style="text-align:right;line-height: 12px;width:48% !important;">
        <tr>
          <th>Total Unit Cost :</th>
          <td>Rs.<?php echo $unit_cost; ?></td>
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
          <th>Net Payable :</th>
          <td>Rs.<?php echo $net_payable_amount; ?></td>
        </tr>
        <tr>
          <th>Total Paid :</th>
          <td>Rs.<?php echo $TotalAmountPaid; ?></td>
        </tr>
        <tr>
          <th>Balance :</th>
          <td>Rs.<?php echo (int)$net_payable_amount - (int)$TotalAmountPaid; ?></td>
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
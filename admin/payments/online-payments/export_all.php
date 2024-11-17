<?php
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Export All Online Payments</title>
</head>

<body onload="doConvert()" style="color: #505050;margin:auto;font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">

  <section style="border-style:groove; border-width:thin;margin: auto; width: 950px;border: 1px solid rgb(147 78 255);padding: 5px;">
    <small class="float:left;"><i></i></small>
    <div style="text-align:center;">
      <h3 style="line-height:1;margin-bottom:4px;margin-top:0px;">
        ALL Online PAYEMENT<br>
        <small style="color:grey; font-size:11px;">PAYMENT REPORTS</small>
      </h3>
    </div>
    <?php include "../../../include/export/rc-header.php"; ?>
    <hr>
    <table class="table table-striped" style="font-size:10px;width:100%;">
      <thead>
        <tr align="left">
          <th>RefId</th>
          <th>BookingID</th>
          <th>(ID)CustomerName</th>
          <th>Bank/Provider</th>
          <th>TxnId</th>
          <th>Details</th>
          <th>Mode</th>
          <th>TxnDate</th>
          <th>UpdateAt</th>
          <th>TxnStatus</th>
          <th>Amount</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (isset($_GET['search'])) {
          $search_type = $_GET['search_type'];
          $search_value = $_GET['search_value'];
          $CheckCashPayments = CHECK("SELECT * FROM bookings, payments, online_payments where $search_type like '%$search_value%' and payments.payment_id=online_payments.payment_id and bookings.bookingid=payments.bookingid ORDER BY online_payments_id  ASC");
        } else {
          $CheckCashPayments = CHECK("SELECT * FROM bookings, payments, online_payments where payments.payment_id=online_payments.payment_id and bookings.bookingid=payments.bookingid ORDER BY online_payments_id  ASC");
        }
        if ($CheckCashPayments != 0) {
          if (isset($_GET['search'])) {
            $search_type = $_GET['search_type'];
            $search_value = $_GET['search_value'];
            $Sql2 = SELECT("SELECT *, online_payments.created_at AS 'cashreceivedat' FROM bookings, payments, online_payments where $search_type like '%$search_value%' and payments.payment_id=online_payments.payment_id and bookings.bookingid=payments.bookingid ORDER BY online_payments_id  ASC");
          } else {
            $Sql2 = SELECT("SELECT *, online_payments.created_at AS 'cashreceivedat' FROM bookings, payments, online_payments where payments.payment_id=online_payments.payment_id and bookings.bookingid=payments.bookingid ORDER BY online_payments_id  ASC");
          }
          while ($fetch2 = mysqli_fetch_array($Sql2)) {
            $customer_id = $fetch2['customer_id'];

            //customer name;
            $SQL = SELECT("SELECT * FROM users where id='$customer_id'");
            $Fetch = mysqli_fetch_array($SQL);
            $customer_name = $Fetch['name']; ?>
            <tr>
              <td><?php echo $fetch2['online_payments_id']; ?></td>
              <td>B<?php echo $fetch2['bookingid']; ?><?php echo date("/m/Y", strtotime($fetch2['created_at'])); ?></td>
              <td>(<?php echo $customer_id; ?>)<?php echo $customer_name; ?></td>
              <td><?php echo $fetch2['OnlineBankName']; ?></td>
              <td><?php echo $fetch2['transactionId']; ?></td>
              <td><?php echo $fetch2['payment_details']; ?></td>
              <td><?php echo $fetch2['payment_mode']; ?></td>
              <td><?php echo date("d M, Y", strtotime($fetch2['cashreceivedat'])); ?></td>
              <td><?php echo $fetch2['update_at']; ?></td>
              <td><?php echo $fetch2['transaction_status']; ?></td>
              <td class="text-success">Rs.<?php echo $fetch2['onlinepaidamount']; ?></td>
            </tr>
        <?php }
        }
        ?>
        <?php

        //total amount paid
        if (isset($_GET['search'])) {
          $search_type = $_GET['search_type'];
          $search_value = $_GET['search_value'];
          $TotalAmountPaid = SELECT("SELECT sum(net_paid) FROM payments, bookings, online_payments where payments.payment_id=online_payments.payment_id and $search_type like '%$search_value%' and payments.bookingid=bookings.bookingid");
        } else {
          $TotalAmountPaid = SELECT("SELECT sum(net_paid) FROM payments, bookings, online_payments where payments.payment_id=online_payments.payment_id and payments.bookingid=bookings.bookingid");
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
          <td colspan="10" align="right">
            <b>
              <b class="fs-16">Total Payment &nbsp;</b>
            </b>
          </td>
          <td class="text-primary" colspan="1"><span class="fs-16">Rs.<?php echo $TotalPayment; ?></span></td>
          <td colspan="1"></td>
        </tr>
      </tbody>
    </table>
    <p style="color:grey; font-size:10px;text-align:center;"><b>Exported On:</b> <?php echo date("D d M, Y"); ?> by (UID : <?php echo LOGIN_UserId; ?>) <?php echo LOGIN_UserFullName; ?>, <?php echo LOGIN_UserEmailId; ?>, <?php echo LOGIN_UserPhoneNumber; ?> | <b>UserType :</b> <?php echo LOGIN_UserRoleName; ?></p>

  </section>
</body>

</html>
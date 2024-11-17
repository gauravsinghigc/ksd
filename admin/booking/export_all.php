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
  <title>Export All BOOKINGS</title>
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
      padding: 1px !important;
      font-size: 11px !important;
      font-weight: 600 !important;
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
        ALL BOOKINGS<br>
        <small style="color:grey; font-size:19px !important;">BOOKINGS REPORTS</small>
      </h3>
    </div>

    <hr>
    <table class="striped" style="width: 100%;">
      <thead>
        <tr align="left">
          <th>SNo</th>
          <th>Booking ID</th>
          <th>Project Name/Plot NO</th>
          <th>PlotArea</th>
          <th>(ID)CustomerName</th>
          <th>(ID)AgentName</th>
          <th>Net Payable</th>
          <th>Received</th>
          <th>Pending</th>
          <th>BookingDate</th>
          <th>Clearingdate</th>
          <th>CreatedAt</th>
        </tr>
      </thead>
      <tbody>
        <?php
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
          $GetBookings = SELECT("SELECT * FROM bookings where crn_no like '%$crn_no%' $daterange and possession like '%$possession%' and partner_id like '%$partner_id%' and customer_id like '%$customer_id%' and unit_rate like '%$unit_rate%' and unit_area like '%$unit_area%' and unit_name like '%$unit_name%' and bookingid like '%$bookingid%' and project_name like '%$project_name%' and status like '%$status%' order by bookingid DESC");
        } else {
          $GetBookings = SELECT("SELECT * FROM bookings where status!='DELETED' ORDER BY bookingid DESC");
        }
        $nettotalpayments = 0;
        $totalpaymentpaid = 0;
        $TOTAL_PAYABLE = 0;
        $TOTAL_PAID = 0;
        $TOTAL_BALANCE = 0;
        $Count = 0;
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
          $nettotalpayments += $net_payable_amount;
          $emi_months = $Bookings['emi_months'];
          $clearing_date = $Bookings['clearing_date'];
          $TOTAL_PAYABLE += (int)$net_payable_amount;

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
          $TotalAmountPaid = SELECT("SELECT sum(net_paid) FROM payments where bookingid='$bookingid'");
          while ($fetchtotalpayment = mysqli_fetch_array($TotalAmountPaid)) {
            $PaymentforProjects = $fetchtotalpayment['sum(net_paid)'];
          }
          if ($PaymentforProjects == null) {
            $PaymentforProjects = 0;
          } else {
            $PaymentforProjects = $PaymentforProjects;
          }

          //total payment paid
          $totalpaymentpaid += $PaymentforProjects;
          $TOTAL_PAID += (int)$PaymentforProjects;
        ?>

          <tr class="striped">
            <td><?php echo $Count; ?></td>
            <td>
              B<?php echo $bookingid; ?>/<?php echo date("m/Y", strtotime($created_at)); ?>
            </td>
            <td><?php echo $project_name; ?> (<?php echo $unit_name; ?>)</td>
            <td><?php echo $unit_area; ?></td>
            <td>(<?php echo $customer_id; ?>) <?php echo $customer_name; ?></td>
            <td>(<?php echo $partner_id; ?>) <?php echo $partner_name; ?></td>
            <td><span class="text-success">Rs.<?php echo $net_payable_amount; ?></span></td>
            <td><span class="text-dark">Rs.<?php echo $PaymentforProjects; ?></span></td>
            <td><span class="text-danger">Rs.<?php echo $net_payable_amount - $PaymentforProjects; ?></span></td>
            <td><?php echo 100 - round(($net_payable_amount - $PaymentforProjects) / $net_payable_amount * 100, 2) . " %"; ?></td>
            <td><?php echo $booking_date; ?></td>
            <td><?php echo $clearing_date; ?></td>
            <td><?php echo $created_at; ?></td>
          </tr>

        <?php } ?>
        <?php


        ?>
        <tr>
          <td colspan="6" align="right" style="text-align:right !important;">
            <span class="fs-12" style="font-size:16px !important;"><b>Total Payments</b> &nbsp;</span>
          </td>
          <td><span class="fs-12 text-success" style="color:green;font-size:16px !important;"><b>Rs.<?php echo number_format($TOTAL_PAYABLE); ?></b></span></td>
          <td class="text-dark" colspan="1"><span class="fs-12" style="font-size:16px !important;"><b>Rs.<?php echo number_format($TOTAL_PAID); ?></b></span></td>
          <td><span class="fs-12 text-danger" style="color:red;font-size:16px !important;"><b>Rs.<?php echo number_format($TOTAL_PAYABLE - $TOTAL_PAID); ?></b></span></td>
          <td colspan="4"></td>
        </tr>
      </tbody>
    </table>
    <p style="color:grey; font-size:12px;text-align:center;"><b>Exported On:</b> <?php echo date("D d M, Y"); ?> by (UID : <?php echo $UserId; ?>) <?php echo $name; ?>, <?php echo $email; ?>, <?php echo $phone; ?> | <b>UserType :</b> <?php echo $role_name; ?></p>

  </section>
</body>

</html>
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
  <title>EMICHART</title>
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
</head>

<body onload="window" style="padding: 1rem;font-size:13px !important;font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">
  <?php
  $EMICHARTID = $_GET['id'];
  $SQL_booking_emis = SELECT("SELECT *, booking_emis.created_at AS emi_created_at, bookings.created_at AS BookingCreatedAt FROM bookings, booking_emis where bookings.bookingid=booking_emis.booking_id and booking_emis.emi_id='$EMICHARTID'");
  $FetchCustomerDetails = mysqli_fetch_array($SQL_booking_emis);
  $customer_id = $FetchCustomerDetails['customer_id'];
  $project_name = $FetchCustomerDetails['project_name'];
  $project_area = $FetchCustomerDetails['project_area'];
  $unit_name = $FetchCustomerDetails['unit_name'];
  $unit_area = $FetchCustomerDetails['unit_area'];
  $str = $unit_area;
  $unit_area_2 = preg_replace('/[^0-9.]+/', '', $str);
  $unit_rate = $FetchCustomerDetails['unit_rate'];
  $unit_cost = $FetchCustomerDetails['unit_cost'];
  $net_payable_amount = $FetchCustomerDetails['net_payable_amount'];
  $booking_date = $FetchCustomerDetails['booking_date'];
  $clearing_date = $FetchCustomerDetails['clearing_date'];
  $possession = $FetchCustomerDetails['possession'];
  $chargename = $FetchCustomerDetails['chargename'];
  $charges = $FetchCustomerDetails['charges'];
  $discountname = $FetchCustomerDetails['discountname'];
  $discount = $FetchCustomerDetails['discount'];
  $created_at = $FetchCustomerDetails['BookingCreatedAt'];
  $customer_id = $FetchCustomerDetails['customer_id'];
  $partner_id = $FetchCustomerDetails['partner_id'];

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
  ?>

  <section style="border-style:groove; border-width:thin;margin: auto; width: 1000px;border: 1px solid rgb(147 78 255);padding: 5px;">

    <div style="text-align:center;">
      <h3 style="line-height:1;margin-bottom:4px;">
        <span style="font-size: 2rem;">EMI CHART</span><br>
        <small style="color:grey;">EMI CHART</small>
      </h3>
    </div>
    <?php include "../../include/export/rc-header.php"; ?>
    <div style="display: flex;justify-content: space-between;margin-top:7px;">
      <div style="width:40%;">
        <table style="text-align:left;line-height: 12px;">
          <tr>
            <th style="width:35%;">Customer ID : </th>
            <td>CUST00<?php echo $customer_id; ?></td>
          </tr>
          <tr>
            <th>Register Name :</th>
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
        <table style="text-align:left;line-height: 12px;">
          <tr>
            <th>Project Name :</th>
            <td><?php echo $project_name; ?></td>
          </tr>
          <tr>
            <th>Unit Name :</th>
            <td><?php echo $unit_name; ?></td>
          </tr>
          <tr>
            <th>Unit Area :</th>
            <td><?php echo $unit_area; ?></td>
          </tr>
          <tr>
            <th>Rate:</th>
            <td><?php echo $unit_rate; ?></td>
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
        <table style="text-align:left;line-height: 17px;">
          <tr>
            <th>Date:</th>
            <td><?php echo date("d M, Y h:m A", strtotime($created_at)); ?></td>
          </tr>
          <tr>
            <th>Invoice No:</th>
            <td>B<?php echo $_GET['id']; ?>/<?php echo date("m/Y", strtotime($created_at)); ?></td>
          </tr>
          <tr>
            <th>Sale Date:</th>
            <td><?php echo $booking_date; ?></td>
          </tr>
          <tr>
            <th>EMI Months :</th>
            <td><?php echo $FetchCustomerDetails['emi_months']; ?> Months</td>
          </tr>
          <tr>
            <th>Clearing Date:</th>
            <td><?php echo $clearing_date; ?></td>
          </tr>
          <tr>
            <th>Receipt At:</th>
            <td><?php echo date("d M, Y H:m A"); ?></td>
          </tr>

        </table>
      </div>
    </div>
    <h3 align="center">EMI SCHEDULE</h3>
    <table class="table striped fs-14">
      <thead>
        <tr align="left">
          <th style="width:6%;">EMIid</th>
          <th>BookingID</th>
          <th>EMIStartDate</th>
          <th>EMIEndDate</th>
          <th>PreferDay</th>
          <th>EMIPerMonth</th>
          <th>TotalEMI</th>
          <th>EMIStatus</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $CheckEMI = CHECK("SELECT * FROM bookings, booking_emis where booking_emis.booking_id=bookings.bookingid and booking_emis.emi_id='$EMICHARTID'");
        if ($CheckEMI != 0) {
          $SQL_booking_emis = SELECT("SELECT *, booking_emis.created_at AS emi_created_at FROM bookings, booking_emis where bookings.bookingid=booking_emis.booking_id and booking_emis.emi_id='$EMICHARTID'");
          while ($FetchEMI = mysqli_fetch_array($SQL_booking_emis)) {
            $emi_id = $FetchEMI['emi_id'];
            $emi_created_at = date("/m/Y", strtotime($FetchEMI['emi_created_at']));
            $emi_created = $FetchEMI['emi_created_at'];
            $bookingcreatedat = date("/m/Y", strtotime($FetchEMI['created_at']));
            $bookingID = $FetchEMI['booking_id'];
            $emi_start_date = $FetchEMI['emi_start_date'];
            $emi_last_date = $FetchEMI['emi_last_date'];
            $emi_per_month = $FetchEMI['emi_per_month'];
            $emi_day_of_month = $FetchEMI['emi_day_of_month'];
            $emi_status = $FetchEMI['emi_status'];
            $emi_months = $FetchEMI['emi_months']; ?>
            <tr align="left">
              <td>EMI<?php echo $emi_id; ?><?php echo date("/m/y", strtotime($emi_start_date)); ?></td>
              <td><a href="<?php echo $DOMAIN; ?>/admin/bookings/booking_exports.php?id=<?php echo $bookingID; ?>">B<?php echo $_GET['id']; ?>/<?php echo date("m/Y", strtotime($created_at)); ?></a></td>
              <td><?php echo date("d M, Y", strtotime($emi_start_date)); ?></td>
              <td><?php echo $emi_last_date; ?></td>
              <td><?php echo $emi_day_of_month; ?> of Month</td>
              <td>Rs.<?php echo $emi_per_month; ?>/month</td>
              <td><?php echo $emi_months; ?></td>
              <td><?php echo $emi_status; ?></td>
            </tr>
        <?php }
        } ?>
      </tbody>
    </table>
    <br>
    <table class="table striped" style="width:100%;">
      <thead>
        <tr align="right">
          <th>EMI_NO</th>
          <th>PaymentDate</th>
          <th>EMI_AMOUNT</th>
          <th>PaidAmount</th>
          <th>Balance</th>
          <th>PreferDate</th>
          <th>STATUS</th>
          <th>PaidAt</th>
        </tr>
      </thead>
      <?php
      $CheckEMIPAYMENTS = CHECK("SELECT * FROM emi_lists where emi_id='$emi_id' order by emi_list_status DESC");
      if ($CheckEMIPAYMENTS != 0) {
        $SQLEMIPAYMENTS = SELECT("SELECT * FROM emi_lists where emi_id='$emi_id' ORDER BY emi_list_status DESC");
        $NetEMIPAID = 0;
        $NetPayableEmi = 0;
        $NetBalance = 0;
        while ($EMIPAYMENTS = mysqli_fetch_array($SQLEMIPAYMENTS)) {
          $emi_list_id = $EMIPAYMENTS['emi_list_id'];
          $emi_dates = $EMIPAYMENTS['emi_dates'];
          $emi_amount = $EMIPAYMENTS['emi_amount'];
          $emi_list_status = $EMIPAYMENTS['emi_list_status'];
          $prefer_day = $EMIPAYMENTS['prefer_day'];
          $emi_number = $EMIPAYMENTS['emi_number'];
          $paid_date = $EMIPAYMENTS['paid_date'];
          $emi_paid = $EMIPAYMENTS['emi_paid'];
          $emi_balance = $EMIPAYMENTS['emi_balance'];
          $NetEMIPAID += $emi_paid;
          $NetPayableEmi += $emi_amount;
          $NetBalance += $emi_balance;  ?>
          <tr class="striped">
            <td style=" text-align:right;"><?php echo $emi_number; ?></td>
            <td style="text-align:right;"><?php echo $emi_dates; ?></td>
            <td style="text-align:right;">Rs.<?php echo $emi_amount; ?></td>
            <td style="text-align:right;">Rs.<?php echo $emi_paid; ?></td>
            <td style="text-align:right;">Rs.<?php echo $emi_balance; ?></td>
            <td style="text-align:right;"><?php echo $prefer_day; ?> <?php echo date("M, Y", strtotime($emi_dates)); ?></td>
            <td style="text-align:right;"><?php echo $emi_list_status; ?></td>
            <td style="text-align:right;">
              <?php echo $paid_date; ?>
            </td>
          </tr>
      <?php }
      } ?>
      <tr>
        <td></td>
        <td></td>
        <td style="text-align:right;">Rs.<?php echo $NetPayableEmi; ?></td>
        <td style="text-align:right;">Rs.<?php echo $NetEMIPAID; ?></td>
        <td style="text-align:right;">Rs.<?php echo $NetBalance; ?></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    </table>

  </section>
</body>

</html>
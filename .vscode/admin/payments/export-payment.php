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

<body onload="doConvert()" style="font-size:13px !important;color: black;margin:auto;font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">
  <?php
  $bookingid = $_GET['id'];
  $pay_id = $_GET['pay_id'];
  //bookings details
  $GetBookings = SELECT("SELECT * FROM bookings where bookingid='$bookingid'");
  $Bookings = mysqli_fetch_array($GetBookings);
  $project_name = $Bookings['project_name'];
  $project_area = $Bookings['project_area'];
  $unit_name = $Bookings['unit_name'];
  $unit_area = $Bookings['unit_area'];
  $unit_rate = $Bookings['unit_rate'];
  $unit_cost = $Bookings['unit_cost'];
  $net_payable_amount = $Bookings['net_payable_amount'];
  $booking_date = $Bookings['booking_date'];
  $clearing_date = date("d M, Y", strtotime($Bookings['clearing_date']));
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

  //last payment
  $GetPAYMENTS = SELECT("SELECT * FROM payments where bookingid='$bookingid' and payment_id='$pay_id' ORDER BY payment_id  DESC");
  $payments = mysqli_fetch_array($GetPAYMENTS);
  $payment_amount = $payments['payment_amount'];
  $payment_mode = $payments['payment_mode'];
  $slip_no = $payments['slip_no'];
  $remark = $payments['remark'];
  $payment_date = $payments['payment_date'];
  $paymentcreatedat = $payments['created_at'];
  $new_charges = $payments['charges'];
  $new_chargeamount = $payments['chargeamount'];
  $new_discounts = $payments['discounts'];
  $new_discountamount = $payments['discountamount'];
  $new_net_paid = $payments['net_paid'];

  //total amount paid for thisbookings
  $TotalAmountPaid = SELECT("SELECT sum(payment_amount) FROM payments where bookingid='$bookingid'");
  while ($fetchtotalpayment = mysqli_fetch_array($TotalAmountPaid)) {
    $PaymentforProjects = $fetchtotalpayment['sum(payment_amount)'];
  }

  //reference nnumber
  $refrenecenum = rand(00000, 100000000);

  ?>



  <section style="border-style:groove; border-width:thin;margin: auto; width: 950px;border: 1px solid rgb(147 78 255);padding: 5px;">
    <small class="float:left;"><i>CUSTOMER COPY</i></small>
    <div style="text-align:center;">
      <h3 style="line-height:1;margin-bottom:4px;margin-top:5px;">
        INVOICE DETAILS<br>
        <small style="color:grey; font-size:12px;">BOOKING | TOKEN | EMI RECEIPT</small>
      </h3>
    </div>
    <?php include "../../include/export/rc-header.php"; ?>
    <div style="display: flex;justify-content: space-between;margin-top:7px;">
      <div style="width:40%;">
        <table style="text-align:left;font-size:12px;">
          <tr>
            <th style="width:35%;">Customer ID : </th>
            <td>CUST00<?php echo $customer_id; ?></td>
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
          <tr>
            <th>Latest Slip No :</th>
            <td><?php echo $slip_no; ?></td>
          </tr>
          <tr>
            <th>Remark :</th>
            <td><?php echo $remark; ?></td>
          </tr>

        </table>
      </div>
      <div>
        <table style="text-align:left;font-size:12px;">
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
          <tr>
            <th>Possession Notes:</th>
            <td><?php echo $possession_notes; ?></td>
          </tr>

        </table>
      </div>
      <div>
        <table style="text-align:left;font-size:12px;">
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
            <td><?php echo date("d M, Y", strtotime($booking_date)); ?></td>
          </tr>
          <tr>
            <th>EMI Months :</th>
            <td><?php echo $Bookings['emi_months']; ?> Months</td>
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
    <div style="display: flex;justify-content: space-between;">
      <div style="width:70%;">
        <p style="font-size:11px; margin-top:10px; margin-bottom:0px;">
          <span><b>Payment Note :</b><br> Total <span id="office"></span> rupees is paid for booking <b>B<?php echo $bookingid; ?>/<?php echo date("m/Y", strtotime($created_at)); ?></b> which is paid on <?php echo date("d M, Y h:m a", strtotime($paymentcreatedat)); ?></span><br><br>
          <b>Note: </b></br>
          • Booking / Token / Emi Amount is not refund in any case.<br>
          • Continue not deposit two EMI / After 15 Days token will not be refunded.<br>
        </p>
      </div>
      <table style="text-align:right; font-size:12px;">
        <tr>
          <th>Amount :</th>
          <td>Rs.<?php echo $payment_amount; ?></td>
        </tr>
        <?php if ($chargename == null) {
        } else { ?>
          <tr>
            <th><?php echo $chargename; ?> (<?php echo $charges; ?>%) :</th>
            <td>+ Rs.<?php echo round($net_payable_amount / 100 * $charges); ?></td>
          </tr>
        <?php } ?>
        <?php if ($discountname == null) {
        } else { ?>
          <tr>
            <th><?php echo $discountname; ?> (<?php echo $discount; ?>%) :</th>
            <td>- Rs.<?php echo round($net_payable_amount / 100 * $discount); ?></td>
          </tr>
        <?php } ?>
        <tr>
          <th>Net Payable Amount :</th>
          <td>Rs.<?php echo $new_net_paid; ?></td>
        </tr>
        <tr>
          <th>Amount Paid :</th>
          <td>Rs.<?php echo $new_net_paid; ?></td>
        </tr>
        <tr>
          <th>Total Payment Paid :</th>
          <td>Rs.<?php echo $PaymentforProjects; ?></td>
        </tr>
        <tr>
          <th>Balance :</th>
          <td>Rs.<?php echo $net_payable_amount - $PaymentforProjects; ?></td>
        </tr>
      </table>
    </div>
    <div style="text-align:center;">
      <p style="font-size:11px;margin-top:0px; margin-bottom:0px;">This is a computer generate Invoice <br>
        <i>Ref No: <?php echo $refrenecenum; ?>/B<?php echo $bookingid; ?>/<?php echo date("m/Y"); ?></i>
      </p>
    </div>
    <br>
  </section>
  <hr style="border-style: dashed;border-width: thin;border: 1px dashed dimgrey; width:750px;">
  <section style="border-style:groove; border-width:thin;margin: auto; width: 950px;border: 1px solid rgb(147 78 255);padding: 5px;">
    <small class="float:left;"><i>OFFICE COPY</i></small>
    <div style="text-align:center;">
      <h3 style="line-height:1;margin-bottom:4px;margin-top:5px;">
        INVOICE DETAILS<br>
        <small style="color:grey; font-size:12px;">BOOKING | TOKEN | EMI RECEIPT</small>
      </h3>
    </div>
    <div style="text-align: center;display: flex;align-content: space-around; justify-content: center;">
      <img src="<?php echo company_logo; ?>" style="width:2.5rem; height:2.5rem;"><br>
      <span style="font-size:28px;"><?php echo company_name; ?></span>
    </div>
    <div style="text-align: center;display: flex;align-content: space-around; justify-content: center;">
      <p style="margin-bottom: 3px;margin-top: -5px;font-size: 12px;"><?php echo company_address; ?></p>
    </div>
    <div style="text-align: center;display: flex;align-content: space-around; justify-content: center;">
      <p style="margin-bottom: 3px;margin-top: -5px;font-size: 12px;">
        <b>Phone :</b> <?php echo company_phone; ?> |
        <b>Email ID :</b> <?php echo company_email; ?> |
        <b>Website :</b> <?php echo DOMAIN; ?>
      </p>
    </div>
    <div style="display: flex;justify-content: space-between;margin-top:7px;">
      <div style="width:40%;">
        <table style="text-align:left;font-size:12px;">
          <tr>
            <th style="width:35%;">Customer ID : </th>
            <td>CUST<?php echo $customer_id; ?></td>
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
          <tr>
            <th>Latest Slip No :</th>
            <td><?php echo $slip_no; ?></td>
          </tr>
          <tr>
            <th>Remark :</th>
            <td><?php echo $remark; ?></td>
          </tr>

        </table>
      </div>
      <div>
        <table style="text-align:left;font-size:12px;">
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
          <tr>
            <th>Possession Notes:</th>
            <td><?php echo $possession_notes; ?></td>
          </tr>

        </table>
      </div>
      <div>
        <table style="text-align:left;font-size:12px;">
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
            <td><?php echo date("d M, Y", strtotime($booking_date)); ?></td>
          </tr>
          <tr>
            <th>EMI Months :</th>
            <td><?php echo $Bookings['emi_months']; ?> Months</td>
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
    <div style="display: flex;justify-content: space-between;">
      <div style="width:70%;">
        <p style="font-size:11px; margin-top:10px; margin-bottom:0px;">
          <span><b>Payment Note : </b><br> Total <span id="customer"></span> rupees is paid for booking <b>B<?php echo $bookingid; ?>/<?php echo date("m/Y", strtotime($created_at)); ?></b> which is paid on <?php echo date("d M, Y h:m a", strtotime($paymentcreatedat)); ?></span><br><br>
          <b>Note: </b></br>
          • Booking / Token / Emi Amount is not refund in any case.<br>
          • Continue not deposit two EMI / After 15 Days token will not be refunded.<br>
        </p>
      </div>
      <table style="text-align:right; font-size:12px;">
        <tr>
          <th>Amount :</th>
          <td>Rs.<?php echo $payment_amount; ?></td>
        </tr>
        <?php if ($chargename == null) {
        } else { ?>
          <tr>
            <th><?php echo $chargename; ?> (<?php echo $charges; ?>%) :</th>
            <td>+ Rs.<?php echo round($net_payable_amount / 100 * $charges); ?></td>
          </tr>
        <?php } ?>
        <?php if ($discountname == null) {
        } else { ?>
          <tr>
            <th><?php echo $discountname; ?> (<?php echo $discount; ?>%) :</th>
            <td>- Rs.<?php echo round($net_payable_amount / 100 * $discount); ?></td>
          </tr>
        <?php } ?>
        <tr>
          <th>Net Payable Amount :</th>
          <td>Rs.<?php echo $new_net_paid; ?></td>
        </tr>
        <tr>
          <th>Amount Paid :</th>
          <td>Rs.<?php echo $new_net_paid; ?></td>
        </tr>
        <tr>
          <th>Total Payment Paid :</th>
          <td>Rs.<?php echo $PaymentforProjects; ?></td>
        </tr>
        <tr>
          <th>Balance :</th>
          <td>Rs.<?php echo $net_payable_amount - $PaymentforProjects; ?></td>
        </tr>
      </table>
    </div>
    <div style="text-align:center;">
      <p style="font-size:11px;margin-top:0px; margin-bottom:0px;">This is a computer generate Invoice <br>
        <i>Ref No: <?php echo $refrenecenum; ?>/B<?php echo $bookingid; ?>/<?php echo date("m/Y"); ?></i>
      </p>
    </div>
    <br>
  </section>
</body>
<script>
  function doConvert() {
    var numberInput = <?php echo $payment_amount; ?>;


    var oneToTwenty = ['', 'one ', 'two ', 'three ', 'four ', 'five ', 'six ', 'seven ', 'eight ', 'nine ', 'ten ',
      'eleven ', 'twelve ', 'thirteen ', 'fourteen ', 'fifteen ', 'sixteen ', 'seventeen ', 'eighteen ', 'nineteen '
    ];
    var tenth = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];

    if (numberInput.toString().length > 7) return myDiv.innerHTML = 'overlimit';
    console.log(numberInput);
    //let num = ('0000000000'+ numberInput).slice(-10).match(/^(\d{1})(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
    var num = ('0000000' + numberInput).slice(-7).match(/^(\d{1})(\d{1})(\d{2})(\d{1})(\d{2})$/);
    console.log(num);
    if (!num) return;

    var outputText = num[1] != 0 ? (oneToTwenty[Number(num[1])] || `${tenth[num[1][0]]} ${oneToTwenty[num[1][1]]}`) + ' million ' : '';

    outputText += num[2] != 0 ? (oneToTwenty[Number(num[2])] || `${tenth[num[2][0]]} ${oneToTwenty[num[2][1]]}`) + 'hundred ' : '';
    outputText += num[3] != 0 ? (oneToTwenty[Number(num[3])] || `${tenth[num[3][0]]} ${oneToTwenty[num[3][1]]}`) + ' thousand ' : '';
    outputText += num[4] != 0 ? (oneToTwenty[Number(num[4])] || `${tenth[num[4][0]]} ${oneToTwenty[num[4][1]]}`) + 'hundred ' : '';
    outputText += num[5] != 0 ? (oneToTwenty[Number(num[5])] || `${tenth[num[5][0]]} ${oneToTwenty[num[5][1]]} `) : '';

    document.getElementById("office").innerHTML = outputText;
    document.getElementById("customer").innerHTML = outputText;

  }
</script>


</html>
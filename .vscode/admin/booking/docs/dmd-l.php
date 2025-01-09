<?php
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';

if (isset($_GET['id'])) {
  $bookingid = $_GET['id'];
  $_SESSION['bookingid'] = $_GET['id'];
} else {
  $bookingid = $_SESSION['id'];
}

if (isset($_GET['dmdid'])) {
  $dmdid = $_GET['dmdid'];
  $_SESSION['dmdid'] = $_GET['dmdid'];
} else {
  $dmdid = $_SESSION['dmdid'];
}

$BookingSql = "SELECT * FROM bookings where bookingid='$bookingid'";
$customer_id = FETCH($BookingSql, "customer_id");
$partner_id = FETCH($BookingSql, "partner_id");
$CoAllotySql = "SELECT * FROM booking_alloties where BookingAllotyMainBookingId='$bookingid' and BookingAllotyFullName!=''";
$CustomerSql = "SELECT * FROM users where id='$customer_id'";
$PartnerSql = "SELECT * FROM users where id='$partner_id'";
$CustomerAddress = "SELECT * FROM user_address where user_id='$customer_id'";
$PartnerAddress = "SELECT * FROM user_address where user_id='$partner_id'";
$DMDSql = "SELECT * FROM booking_pay_req where PaymentRequestId='$dmdid'";

//other variables
$area = FETCH($BookingSql, "unit_area");
$areaint = GetNumbers($area);

$getpayments = SELECT("SELECT *, payments.created_at AS 'payment_created_at' FROM payments, bookings where payments.bookingid=bookings.bookingid and bookings.bookingid='$bookingid' order by payments.payment_id DESC");
$net_paid_amount2 = 0;
$SerialNo = 0;
while ($FetchAllPayments = mysqli_fetch_array($getpayments)) {
  $SerialNo++;
  $payment_id = $FetchAllPayments['payment_id'];
  $bookingid = $FetchAllPayments['bookingid'];
  $booking_date = $FetchAllPayments['booking_date'];
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
  $clearing_date2 = $FetchAllPayments['clearing_date'];
  $emi_months = $FetchAllPayments['emi_months'];
  $net_paid_amount2 += (int)$net_paid_amount;

  if ($payment_mode == "check") {
    $payment_mode = "Cheque";
  } else {
    $payment_mode = $payment_mode;
  }

  //select customer details
  $SelectCustomers = SELECT("SELECT * FROM users where id='$customer_id'");
  $CustomerDetails = mysqli_fetch_array($SelectCustomers);
  $CustomerName = $CustomerDetails['name'];

  //agent details
  $SelectAgents = SELECT("SELECT * FROM users where id='$partner_id'");
  $AgentDetails = mysqli_fetch_array($SelectAgents);
  $AgentName = $AgentDetails['name'];


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
}

$inputString = FETCH($BookingSql, "unit_name"); // Your input string

// Use preg_replace to remove alphabets and get only numbers
$numbersOnly = preg_replace("/[^0-9]/", "", $inputString);

//total amount paid for thisbookings
$TotalAmountPaid = 0;
$SqlPayments = SELECT("SELECT * FROM payments where bookingid='$bookingid'");
while ($FetchPayments = mysqli_fetch_array($SqlPayments)) {
  $payment_mode = $FetchPayments['payment_mode'];
  $payment_id = $FetchPayments['payment_id'];

  if ($payment_mode == "cash") {
    $TotalAmountPaid += $FetchPayments['net_paid'];
    $paymentstatus = "Received";
  } elseif ($payment_mode == "banking") {
    $checkbankpayment = SELECT("SELECT * FROM online_payments where payment_id='$payment_id'");
    $checkbankpaymentstatus = mysqli_fetch_assoc($checkbankpayment);
    $paymentstatus = $checkbankpaymentstatus['transaction_status'];
    if ($paymentstatus == "Success") {
      $TotalAmountPaid += $FetchPayments['net_paid'];
    } else {
      $TotalAmountPaid += 0;
    }
  } elseif ($payment_mode == "check") {
    $SqlChequepayments = SELECT("SELECT * FROM check_payments where payment_id='$payment_id'");
    $FetchChequepayments = mysqli_fetch_assoc($SqlChequepayments);
    $paymentstatus = $FetchChequepayments['checkstatus'];
    if ($paymentstatus == "Clear") {
      $TotalAmountPaid += $FetchPayments['net_paid'];
    } else {
      $TotalAmountPaid += 0;
    }
  }
}
$PaymentforProjects = $TotalAmountPaid;
$project_unit_id = FETCH($BookingSql, 'project_unit_id');

$CheckSqlForReSale = CHECK("SELECT * FROM booking_resales where booking_main_id='$bookingid' and booking_resale_type='TRANSFER'");
if ($CheckSqlForReSale != null) {
  $PreviousBookingId = FETCH("SELECT * FROM bookings where bookingid!='$bookingid' AND project_unit_id='$project_unit_id' ORDER BY bookingid DESC limit 1", "bookingid");
  $PreviousPayment = GetNetPaidAmount($PreviousBookingId);
} else {
  $PreviousPayment = 0;
}

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset='utf-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <title>Demand Letter</title>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <style>
    section {
      width: 800px !important;
      height: 1000px !important;
    }
  </style>
</head>

<body onload="doConvert()" style=" font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI' , Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans' , 'Helvetica Neue' , sans-serif !important;margin-left:1.5rem;">
  <section style="padding:0.5rem;margin:2% auto;display:block;">
    <img src="<?php echo STORAGE_URL; ?>/doc-img/header.jpg" style="width:100%;">
    <img src="<?php echo STORAGE_URL; ?>/doc-img/water.jpg" style="position: absolute;top: 25%;left: 26%;width: 50%;z-index: -1;">
    <div>
      <h2 style="text-align:center;margin-top: -1.5rem;margin-bottom:-0.2rem !important;">Demand Letter <br>
        <hr style="width:30%;margin-top:-0.1rem;">
        </h4>
        <p style="display:flex;justify-content:space-between;font-size:14px;">
          <span>
            <span><b>Reference No:</b> KSD-YV/Plot No: <?php echo $numbersOnly; ?></span><br>
            <span><b>Plot No:</b> <?php echo $numbersOnly; ?>/<?php echo FETCH($BookingSql, "project_name"); ?></span>
          </span>
          <span style="text-align:right;">
            <span><b>Demand Date :</b> <?php echo DATE_FORMATE2("d M, Y", FETCH($DMDSql, "PayReqDate")); ?></span><BR>
            <span><b>Due Date :</b> <?php echo DATE_FORMATE2("d M, Y", FETCH($DMDSql, "PayRequestDueDate")); ?></span>
          </span>
        </p>
    </div>
    <div style="font-size:14px !important;">
      <div style="display:flex;justify-content:space-between;">
        <p>
          <b>Allotee Details</b><br>
          <b><?php echo FETCH($CustomerSql, "name"); ?></b>,<br>
          <?php echo FETCH($CustomerSql, "father_name"); ?><br>
          <?php
          echo FETCH($CustomerAddress, "user_street_address") . " ";
          echo FETCH($CustomerAddress, "user_area_locality") . " <br>";
          echo FETCH($CustomerAddress, "user_city") . " ";
          echo FETCH($CustomerAddress, "user_state") . " <br>";
          echo FETCH($CustomerAddress, "user_pincode") . " ";
          echo "<br>";
          echo FETCH($CustomerSql, "phone") . "<BR>";
          echo FETCH($CustomerSql, "email") . "<BR>";
          ?>
        </p>
        <?php $Check = CHECK($CoAllotySql);
        if ($Check != null) { ?>
          <p style="float:right;">
            <b>Co-Allotee Details</b><br>
            <b> <?php echo FETCH($CoAllotySql, "BookingAllotyFullName"); ?></b>,<br>
            <?php echo FETCH($CoAllotySql, "BookingAllotyRelation"); ?><br>
            <?php
            echo FETCH($CoAllotySql, "BookingAllotyStreetAddress") . " ";
            echo FETCH($CoAllotySql, "BookingAllotyArea") . " <br>";
            echo FETCH($CoAllotySql, "BookingAllotyCity") . " ";
            echo FETCH($CoAllotySql, "BookingAllotyState") . " <br>";
            echo FETCH($CoAllotySql, "BookingAllotyPincode") . " <br>";
            echo FETCH($CoAllotySql, "BookingAllotyPhoneNumber") . " <BR>";
            echo FETCH($CoAllotySql, "BookingAllotyEmail") . " ";
            ?>
          </p>
        <?php }
        $inputString = FETCH($BookingSql, "unit_name"); // Your input string

        // Use preg_replace to remove alphabets and get only numbers
        $numbersOnly = preg_replace("/[^0-9]/", "", $inputString); ?>
      </div>
      <p style="margin-top:0px !important;">
        <br>
        <b>Subject :</b> Payment request against your Allotment of <b>Plot No. <?php echo $numbersOnly; ?></b>, having Area: <b><?php echo FETCH($BookingSql, "unit_area"); ?></b>
        <br><br><br>
        <b>Dear Mr/s <?php echo FETCH($CustomerSql, "name"); ?></b><br>
        <br>
        This is with reference to your above booking/allotment, where in, “Current Demand
        Letter as in the table is due as per payment plan opted & accepted by you. The
        schedule of payment is given in the below mentioned table.
      </p>
      <div style="padding-left:2rem;padding-right:2rem !important;">
        <table style="width:100%;" border="1">
          <thead>
            <tr>
              <th>Sno</th>
              <th>Installment Category</th>
              <th>Installment Particulars</th>
              <th>Installment Amount due</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Payment Received</td>
              <td>Till Date of this
                Demand Letter</td>
              <td><?php echo Price($net = $net_paid_amount2 + $PreviousPayment, "", "Rs."); ?></td>
            </tr>
            <tr>
              <td>2</td>
              <td>Current
                Installment<br>
                (*Current
                Demand)</td>
              <td>Total Due <?php echo round($Percentage = FETCH($DMDSql, "PayRequestingAmount") / (FETCH($BookingSql, "net_payable_amount")) * 100, 2); ?>% of Total BSP - Rs.<?php echo Price(FETCH($BookingSql, "net_payable_amount"), "", ""); ?></td>
              <td><?php echo Price($current = round(FETCH($BookingSql, "net_payable_amount") / 100 * $Percentage, 2), "", "Rs."); ?></td>
            </tr>
            <tr>
              <td>3</td>
              <td>Due as on
                Date of this
                Letter</td>
              <td>Current Due
                =(Current Demand Payment Received) +
                Previous Due</td>
              <td><?php echo Price($currentdue = $current - $net, "", "Rs."); ?></td>
            </tr>
            <tr>
              <td colspan="2" align="right">In Words</td>
              <td colspan="2">
                <b><?php echo PriceinWords($currentdue); ?></b>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <p STYLE="margin-bottom:0px !important;">
        <?php if (FETCH($DMDSql, "PayReqSendDescsriptions") != NULL) {
        ?>
        <?PHP
        } ?>
        As you are aware, that timely payment of instalment is essence for your allotment. Therefore, keeping
        in view of your interest in our Project “YASH VIHAR”, you are requested to pay the current
        outstanding/due installment/ and <?php echo FETCH($DMDSql, "PayRequestDescriptions"); ?>, within 7 days of this Demand Letter through
        cheque or demand draft favouring “KSD BUILDTECH PRIVATE LIMITED” payable at New Delhi,
        failing which the Company will be forced to cancel your allotment. All delayed payments made after
        due date shall be charged with an interest as per RERA Act.
      </p>
    </div><br><br><br>
    <img src="<?php echo STORAGE_URL; ?>/doc-img/footer.jpg" style="width:100%;">
  </section>

  <section style="height:100%;padding:0.5rem;margin:2% auto;display:block;">
    <img src="<?php echo STORAGE_URL; ?>/doc-img/header.jpg" style="width:100%;">
    <img src="<?php echo STORAGE_URL; ?>/doc-img/water.jpg" style="position: absolute;top: 70rem;left: 26%;width: 50%;z-index: -1;">
    <div style="font-size:14px !important;">
      <br><br>
      <p>
        For any query, you can reach our customer care [support@yashvihar.com] at our
        office.<br><br><br><br>
        <b>WARM REGARDS</b><br><br><br><br><br>
        <b>KSD Buildtech Private Limited</b><br><br><br><br>
        <b>NOTE:</b><br>
        1. M/s For KSD Buildtech Private Limited’s PAN is <b><?php echo FETCH("SELECT * FROM company_attributes where company_attribute_name='PAN_NO' and company_id='" . company_id . "'", "company_attribute_value"); ?></b>.<br>
        2. You are requested to pay applicable Tax, if any, along with the demand
        amount.<br>
        3. Kindly mention your Name, CRN No., Plot No. and Telephone/Mobile number
        on the reverse side of the cheque/draft.<br>
        4. For applicable terms and condition please refer to the Application Form
        and/or BBA.<br>
        5. One sq. meter is equals to 10.7639 sq. ft.<br>
        6. The charges against dishonour of cheque(s) shall be applicable @ Rs. 1000/-
        for each case.<br>
        7. Ignore this letter if the demanded amount has already been paid<br>
        <?php if (FETCH($DMDSql, "PayReqSendDescsriptions") != null) { ?>
          8. Kindly clear the due payment as per demand in favor of <b><?php echo FETCH($DMDSql, "PayReqSendDescsriptions"); ?></b>.
        <?php } else { ?>
          8. Kindly clear the due payment as per demand in favor of <b>M/s KSD Buildtech Pvt Ltd. A/c No. 0511000000001087, IFSC Code - NTBL0GUR051</b> which is our <b>HRERA Master Account</b>
        <?php } ?>
        <br>
        <b>9. If any payment is not timely made by the due date, in addition to the sum due there shall be a 9% late payment penalty and administrative penalty
        </b>
        <br>

      </p>
      <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    </div>
    <img src="<?php echo STORAGE_URL; ?>/doc-img/footer.jpg" style="width:100%;">
  </section>

  <script>
    function doConvert() {
      var numberInput = <?php echo FETCH($BookingSql, "unit_area"); ?>;


      var oneToTwenty = ['', 'one ', 'two ', 'three ', 'four ', 'five ', 'six ', 'seven ', 'eight ', 'nine ', 'ten ',
        'Eleven ', 'Twelve ', 'Thirteen ', 'Fourteen ', 'Fifteen ', 'Sixteen ', 'Seventeen ', 'Sighteen ', 'Nineteen '
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

      document.getElementById("inwords").innerHTML = "Rupees " + outputText;
    }
  </script>
</body>

</html>
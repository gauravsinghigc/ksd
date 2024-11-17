<?php
require "../../../require/modules.php";
include "../../../require/admin/sessionvariables.php";
include '../../../include/admin/common.php';

if (isset($_GET['id'])) {
 $bookingid = $_GET['id'];
 $_SESSION['bookingid'] = $_GET['id'];
} else {
 $bookingid = $_SESSION['id'];
}

$BookingSql = "SELECT * FROM bookings where bookingid='$bookingid'";
$customer_id = FETCH($BookingSql, "customer_id");
$partner_id = FETCH($BookingSql, "partner_id");
$CoAllotySql = "SELECT * FROM booking_alloties where BookingAllotyMainBookingId='$bookingid' and BookingAllotyFullName!=''";
$CustomerSql = "SELECT * FROM users where id='$customer_id'";
$PartnerSql = "SELECT * FROM users where id='$partner_id'";
$CustomerAddress = "SELECT * FROM user_address where user_id='$customer_id'";
$PartnerAddress = "SELECT * FROM user_address where user_id='$partner_id'";

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
 $C_user_profile_img = $CustomerDetails['user_profile_img'];
 if ($C_user_profile_img == null or $C_user_profile_img == "user.png") {
  $C_user_profile_img = DOMAIN . "/storage/sys-img/user.png";
 } else {
  $C_user_profile_img = DOMAIN . "/storage/users/$customer_id/img/$C_user_profile_img";
 }

 //agent details
 $SelectAgents = SELECT("SELECT * FROM users where id='$partner_id'");
 $AgentDetails = mysqli_fetch_array($SelectAgents);
 $AgentName = $AgentDetails['name'];
 $A_user_profile_img = $AgentDetails['user_profile_img'];
 if ($A_user_profile_img == null or $C_user_profile_img == "user.png") {
  $A_user_profile_img = DOMAIN . "/storage/sys-img/user.png";
 } else {
  $A_user_profile_img = DOMAIN . "/storage/users/$partner_id/img/$A_user_profile_img";
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
  $payment_note = "<br>by cheque no: $checknumber issued on $check_issued_at for $checkissuedto through $bankName | $ifsc e.i $payment_status";
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
include "../data-include.php";
$MainBookingID = "B$bookingid/" . date("m/Y", strtotime($created_at));
?>
<html>

<head>
 <title>PBA_Letter_<?php echo date("d_m_Y"); ?></title>
 <link rel="preconnect" href="https://fonts.googleapis.com">
 <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
 <link href="https://fonts.googleapis.com/css2?family=Michroma&family=Play&display=swap" rel="stylesheet">

</head>

<body style="padding:0.5rem;font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif !important;">
 <section style="border-style:groove;border-width:thick;border-color:black;width:800px;margin:1% auto; height:1160px;display:block;background-image: repeating-linear-gradient(45deg, #f9f9f9, transparent 2px);">
  <h1 style="font-family: 'Michroma', sans-serif;text-align:right;padding:0.5rem;background-color:white;font-size:2rem;width: max-content;float: right;margin-top: -1.5rem;margin-right: -1rem;">
   PLOT BUYER<br> AGREEMENT
  </h1>
  <center style="margin-top: 20rem;">
   <img src="<?php echo company_logo; ?>" style="width:55%;">
  </center>
  <img src="<?php echo STORAGE_URL_D; ?>/tool-img/water-mark-2.png" style="position:absolute;width:inherit;top:37rem;">

  <center style="margin-top: 31rem;">
   <hr style="height:0.19rem;background-color:black !important;width:45%;margin-bottom:5px;color:black;">
   <h3 style="margin-top:0px;margin-bottom:0.5rem;font-size:1.5rem;">HRERA ID: RERA-GRG-PROJ-347-2019 | LISCENCE NO. 94 OF 2017</h3>
  </center>
 </section>

 <section style="width:800px;margin:1% auto; height:1160px;display:block;">
  <h1 style="text-align:center;margin-top:2rem;">PLOT BUYER’S AGREEMENT</h1>
  <h3 style="text-align:center;">BY AND AMONG</h3>
  <h2 style="text-align:center;"><?php echo company_name; ?></h2>

  <p>
   <b>Registered Office:</b><br>
   <?php echo company_address; ?>
  </p>

  <h4 style="text-align:center;">AND</h4>
  <br>
  <div style="display:flex;justify-content:space-between;">
   <div>
    <h4 style="margin-bottom:0.2rem;">Allotee Detail</h4>
    <img src="<?php echo $C_user_profile_img; ?>" style="width:8rem;">
    <br>
    <span>Customer ID : 00<?php echo $customer_id; ?></span>
    <p style="margin-top:0.2rem;">
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
   </div>
   <div>
    <?php $Check = CHECK($CoAllotySql);
    if ($Check != null) { ?>
     <p style="float:right;">
      <b>Co-Allotee Details</b><br>
      <span>Allotee ID : 00<?php echo $AlloteeId =  FETCH($CoAllotySql, "BookingAllotyId"); ?></span><br>
      <b><?php echo $AlloteeName = FETCH($CoAllotySql, "BookingAllotyFullName"); ?></b>,<br>
      <?php echo FETCH($CoAllotySql, "BookingAllotyRelation"); ?><br>
      <?php echo FETCH($CoAllotySql, "BookingAllotyFatherName"); ?><br>
      <?php
      echo FETCH($CoAllotySql, "BookingAllotyStreetAddress") . " ";
      echo FETCH($CoAllotySql, "BookingAllotyArea") . " <br>";
      echo FETCH($CoAllotySql, "BookingAllotyCity") . " ";
      echo FETCH($CoAllotySql, "BookingAllotyState") . " <br>";
      echo FETCH($CoAllotySql, "BookingAllotyPhoneNumber") . " <BR>";
      echo FETCH($CoAllotySql, "BookingAllotyEmail") . " ";

      $AlloteeName = FETCH($CoAllotySql, "BookingAllotyFullName");
      $AlloteeId =  FETCH($CoAllotySql, "BookingAllotyId");
      ?>
     </p>
    <?php } else {
     $AlloteeId = "";
     $AlloteeName = "";
    } ?>
   </div>
  </div>
  <h5 style="text-align:center;margin-top:4rem;">FOR</h5>
  <p style="text-align:center;">
   <span>Project Name: <b><?php echo strtoupper($project_name); ?> </b></span><br>
   <span>Plot No: <b><?php echo strtoupper($unit_name); ?> </b></span><br>
   <span>Area : <b><?php echo strtoupper($unit_area); ?> </b></span><br>
   <span>Booking ID : <b><?php echo strtoupper($MainBookingID); ?> </b></span><br>
  </p>

  <div style="display:flex;justify-content:space-between;width:100%;margin-top:7rem;">
   <p>
    <b>Signature</b>
   </p>
   <p style="margin-top:1rem;padding-top:4rem;">
    <span style="color:grey;font-style:italic;text-decoration:none !important;font-size:0.8rem;">Company</span><br>
    <?php echo company_name; ?>
   </p>
   <p style="margin-top:1rem;padding-top:4rem;">
    <span style="color:grey;font-style:italic;text-decoration:none !important;font-size:0.8rem;">Allotee</span><br>
    <?php echo $customer_name; ?>
   </p>
   <p style="margin-top:1rem;padding-top:4rem;">
    <span style="color:grey;font-style:italic;text-decoration:none !important;font-size:0.8rem;">Co-Allotee</span><br>
    <?php echo $AlloteeName; ?>
   </p>
  </div>
  <p style="font-size:0.7rem;">
   <b>Note :</b> HRERA No. RERA-GRG-PROJ-347-2019, DATED: 16.10.2020, Plotted Colony under DDJAY Scheme over 7.7. Acres, License
   No. 94 of 2017 dated 06.11.2017.
  </p>
 </section>

 <section style="width:800px;margin:1% auto; height:1160px;display:block;">
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <div style="display:flex;justify-content:space-between;width:100%;">
   <p>
    <b>Signature</b>
   </p>
   <p style="margin-top:1rem;padding-top:4rem;">
    <span style="color:grey;font-style:italic;text-decoration:none !important;font-size:0.8rem;">Company</span><br>
    <?php echo company_name; ?>
   </p>
   <p style="margin-top:1rem;padding-top:4rem;">
    <span style="color:grey;font-style:italic;text-decoration:none !important;font-size:0.8rem;">Allotee</span><br>
    <?php echo $customer_name; ?>
   </p>
   <p style="margin-top:1rem;padding-top:4rem;">
    <span style="color:grey;font-style:italic;text-decoration:none !important;font-size:0.8rem;">Co-Allotee</span><br>
    <?php echo $AlloteeName; ?>
   </p>
  </div>
  <p style="font-size:0.7rem;">
   <b>Note :</b> HRERA No. RERA-GRG-PROJ-347-2019, DATED: 16.10.2020, Plotted Colony under DDJAY Scheme over 7.7. Acres, License
   No. 94 of 2017 dated 06.11.2017.
  </p>
 </section>
 <section style="width:800px;margin:1% auto; height:1160px;display:block;">
  <br><br><br><br><br>
  <p style="text-align:justify;">
   <b><i>Please read carefully…</i></b><br>
   Important Instructions to the Allottee.<br>
   The Allottee(s) states and confirms that the Company has made the Allottee(s)
   aware of the office of the Company at <?php echo company_address2; ?>. The Allottee(s) confirms that the Allottee(s) has read and
   perused the Agreement, containing the detailed terms and conditions and in
   addition, the Allottee(s) further confirms to have fully understood the terms and
   conditions of the Agreement (including the Company's limitations) and the
   Allottee(s) is agreeable to perform his obligations as per the conditions stipulated in
   the Agreement. Thereafter the Allottee(s) has applied for allotment of a plot in the
   said Project and has requested the Company to allot a plot. The Allottee(s) agrees
   and confirms to sign the Agreement in entirety and to abide by the terms and
   conditions of the Agreement and the terms and conditions, as mentioned herein.
   Any one desiring to purchase a plot will be required to execute two (2) copies of the
   Agreement (hereinafter defined) for each plot to be purchased. The Agreement sets
   forth in detail the terms and conditions of sale with respect to the said Plot
   (hereinafter defined) and should be read carefully by each Allottee. The Allottee is
   expected to read each and every clause of this Agreement carefully; understand the
   legal implication thereof, his obligations and liabilities and obligations and
   limitations of the Company (hereinafter defined), as set forth in the Agreement. The
   Allottee shall thereafter, execute and deliver both (2) copies of the Agreement to the
   Company within thirty (30) days from the date of dispatch of Agreement through
   registered post by the Company. On failure of the Allottee to return the duly signed
   Agreement within the stipulated time, the Allotment (hereinafter defined) of the
   Allottee may be cancelled by the Company and on such cancellation the Earnest
   Money (hereinafter defined), all taxes, if any, paid to Govt. Authority, and Non
   Refundable Amounts (hereinafter defined) paid by the Allottee shall stand forfeited
   and the Allottee shall be left with no right, title or interest whatsoever in the said
   Plot booked by the Allottee. This Agreement shall not be binding on the Company
   until executed by the Company through its Authorized Signatory. The Company
   will have the option in its sole discretion to either accept or reject the signed
   Agreement within thirty (30) days after receiving the Agreement from the Allottee. If
   the Company decides to accept the Agreement then a signed copy of the Agreement.
  </p>
  <br><br>
  <center>
   <hr style="width:20%;">
  </center>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <div style="display:flex;justify-content:space-between;width:100%;">
   <p>
    <b>Signature</b>
   </p>
   <p style="margin-top:1rem;padding-top:4rem;">
    <span style="color:grey;font-style:italic;text-decoration:none !important;font-size:0.8rem;">Company</span><br>
    <?php echo company_name; ?>
   </p>
   <p style="margin-top:1rem;padding-top:4rem;">
    <span style="color:grey;font-style:italic;text-decoration:none !important;font-size:0.8rem;">Allotee</span><br>
    <?php echo $customer_name; ?>
   </p>
   <p style="margin-top:1rem;padding-top:4rem;">
    <span style="color:grey;font-style:italic;text-decoration:none !important;font-size:0.8rem;">Co-Allotee</span><br>
    <?php echo $AlloteeName; ?>
   </p>
  </div>
  <p style="font-size:0.7rem;">
   <b>Note :</b> HRERA No. RERA-GRG-PROJ-347-2019, DATED: 16.10.2020, Plotted Colony under DDJAY Scheme over 7.7. Acres, License
   No. 94 of 2017 dated 06.11.2017.
  </p>
 </section>
 <section style="width:800px;margin:1% auto; height:1160px;display:block;">
  <br><br><br><br><br><br><br>
  <p style="text-align:justify;">
   will be returned to the Allottee for his/ her reference and record and the other copy
   shall be retained by the Company. The Company reserves the right to request
   thorough identification, financial and other information as it may so desire
   concerning the Allottee. The Company may reject and refuse to execute the
   Agreement if it is found that the Allottee has made any corrections / cancellations
   / alterations / modifications therein. The Company reserves the right to reject any
   agreement executed by the Allottee without any cause or explanation or without
   assigning any reasons thereof and to refuse to execute the Agreement in which case
   the decision of the Company shall be final and binding on the Intending Allottee.
   The Allottee confirms having read and understood the above instructions and each
   and every clause of the Agreement and the Allottee now executes the Agreement
   being fully conscious of his/ her rights and obligations and limitations of the
   Company there under and undertakes to faithfully abide by all the terms and
   conditions of the Agreement.<br><br>
   Instructions for execution of the Agreement:<br>
   1) Kindly sign along with joint allottee, if any, on all places in the Agreement
   including all annexure & schedules.<br>
   2) Kindly paste at the space provided, color photographs of the allottee and joint
   allottee, if any<br>
   3) Kindly sign across the photographs.<br>
   4) Both signed copies of the Agreement in its original form along with all
   annexure/schedule should be returned to the Company by registered post
   (AD)/hand delivery only within the time stipulated.<br>
   5) Witness’s signatures to be done only on the pages mentioned.<br>

  </p>
  <br><br>
  <br><br>
  <br><br>
  <br><br>
  <center>
   <hr style="width:20%;">
  </center>
  <br><br><br>
  <br><br><br>
  <br><br><br><br><br>
  <br><br><br><br><br>
  <br><br><br><br><br>
  <div style="display:flex;justify-content:space-between;width:100%;">
   <p>
    <b>Signature</b>
   </p>
   <p style="margin-top:1rem;padding-top:4rem;">
    <span style="color:grey;font-style:italic;text-decoration:none !important;font-size:0.8rem;">Company</span><br>
    <?php echo company_name; ?>
   </p>
   <p style="margin-top:1rem;padding-top:4rem;">
    <span style="color:grey;font-style:italic;text-decoration:none !important;font-size:0.8rem;">Allotee</span><br>
    <?php echo $customer_name; ?>
   </p>
   <p style="margin-top:1rem;padding-top:4rem;">
    <span style="color:grey;font-style:italic;text-decoration:none !important;font-size:0.8rem;">Co-Allotee</span><br>
    <?php echo $AlloteeName; ?>
   </p>
  </div>
  <p style="font-size:0.7rem;">
   <b>Note :</b> HRERA No. RERA-GRG-PROJ-347-2019, DATED: 16.10.2020, Plotted Colony under DDJAY Scheme over 7.7. Acres, License
   No. 94 of 2017 dated 06.11.2017.
  </p>
 </section>

 <section style="width:800px;margin:1% auto; height:1160px;display:block;">
  <br><br><br>
  <br><br><br>
  <br><br><br>
  <h4 style="text-align:center;">PLOT BUYER’S AGREEMENT</h4>
  <p>This AGREEMENT made at Gurugram of on</p>
  <h5 style="text-align:center;">BY AND AMONG</h5>
  <p>

   M/s <b><?php echo company_name; ?></b>, a company incorporated under the
   Companies Act, 2013 of India with company identity number
   U70100HR2011PTC043811 and having its registered office at <?php echo company_address2; ?> (hereinafter referred to as the <b>“Promoter”</b>
   which expression shall unless repugnant to the context or meaning thereof be
   deemed to mean and include its successors, administrators and permitted assigns),
   through its Director, Mr. Sachin Dalal duly authorized to execute this Agreement
   under the Board Resolution dated 01.04.2022 of the <b>FIRST PART</b>.
  </p>
  <h5 style="text-align:center;">AND</h5>

  <h4 style="margin-bottom:0.2rem;">(1). Allotee Details</h4>
  <span>Customer ID : 00<?php echo $customer_id; ?></span>
  <p style="margin-top:0.2rem;">
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
   <h4 style="margin-bottom:0px;">(2). Co-Allotee Details</h4>
   <span>Allotee ID : 00<?php echo $AlloteeId =  FETCH($CoAllotySql, "BookingAllotyId"); ?></span>
   <p style="margin-top:0px;">
    <b><?php echo $AlloteeName = FETCH($CoAllotySql, "BookingAllotyFullName"); ?></b>,<br>
    <?php echo FETCH($CoAllotySql, "BookingAllotyRelation"); ?><br>
    <?php echo FETCH($CoAllotySql, "BookingAllotyFatherName"); ?><br>
    <?php
    echo FETCH($CoAllotySql, "BookingAllotyStreetAddress") . " ";
    echo FETCH($CoAllotySql, "BookingAllotyArea") . " <br>";
    echo FETCH($CoAllotySql, "BookingAllotyCity") . " ";
    echo FETCH($CoAllotySql, "BookingAllotyState") . " <br>";
    echo FETCH($CoAllotySql, "BookingAllotyPhoneNumber") . " <BR>";
    echo FETCH($CoAllotySql, "BookingAllotyEmail") . " ";

    $AlloteeName = FETCH($CoAllotySql, "BookingAllotyFullName");
    $AlloteeId =  FETCH($CoAllotySql, "BookingAllotyId");
    $diff = "<br><br><br><br><br><br><br><br>";
    ?>
   </p>
  <?php } else {
   $AlloteeId = "";
   $AlloteeName = "";
   $diff = "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
  } ?>
  <p>(Here in after singly/jointly, as the case may be, referred to as the <b>“Allottee”</b> which
   expression shall, unless repugnant to the context or meaning thereof, include
   his/her heirs, executors, legal representatives and successors) of the <b>OTHER
    PART.</b>
  </p>
  <h4>DEFINITIONS:</h4>
  <?php echo $diff; ?>
  <br>
  <div style="display:flex;justify-content:space-between;width:100%;">
   <p>
    <b>Signature</b>
   </p>
   <p style="margin-top:1rem;padding-top:4rem;">
    <span style="color:grey;font-style:italic;text-decoration:none !important;font-size:0.8rem;">Company</span><br>
    <?php echo company_name; ?>
   </p>
   <p style="margin-top:1rem;padding-top:4rem;">
    <span style="color:grey;font-style:italic;text-decoration:none !important;font-size:0.8rem;">Allotee</span><br>
    <?php echo $customer_name; ?>
   </p>
   <p style="margin-top:1rem;padding-top:4rem;">
    <span style="color:grey;font-style:italic;text-decoration:none !important;font-size:0.8rem;">Co-Allotee</span><br>
    <?php echo $AlloteeName; ?>
   </p>
  </div>
  <p style="font-size:0.7rem;">
   <b>Note :</b> HRERA No. RERA-GRG-PROJ-347-2019, DATED: 16.10.2020, Plotted Colony under DDJAY Scheme over 7.7. Acres, License
   No. 94 of 2017 dated 06.11.2017.
  </p>
 </section>
 <section style="width:800px;margin:1% auto; height:1160px;display:block;">
  <br><br><br><br><br><br><br><br><br><br><br><br><br>
  <p style="text-align:justify;">
   For the purpose of this Agreement, unless the context otherwise requires,<br>-
   “Act” means the Real Estate (Regulation and Development) Act, 2016 (16 of 2016);<br>
   “Government” means the Government of the State of Haryana;<br>
   “Rules” means the Real Estate (Regulation and Development) Rules, 2017 for the
   State of Haryana;<br>
   “Section” means a section of the Act.<br><br>
   <b>WHEREAS</b>
   <b>A.</b> The Promoter is the absolute and lawful owner of land measuring 7.7 Acres
   vide two Sale Deed dated 04.10.2011 and 04.01.2012 registered with SubRegistrar, Pataudi, Gurugram, comprised of 61 Kanal 12 Marla sin Khewat
   No.395/397, Mustil/ Khasra No.63/6min(1-6), 15min(5-12), 16(8-0), 17(2-
   14), 24(6-0), 25(8-0), Mustil/ Khasra No.64/4 (2-18), 5(7-4), Mustil/ Khasra
   No.65/1 (8-0), 2/1(4-6), 9/2(3-19), 10(3-13) Pataudi, Gurugram) (“Said
   Land”).The Promoter is fully competent to enter into this Agreement and all
   the legal formalities with respect to the right, title and interest of the
   Promoter regarding the said Land on which Project is to be constructed have
   been complied with.<br><br><br>
   <b>B.</b> The Town and Country Planning Department, Haryana Government has
   granted the approval/ sanction to develop the Project vides approval dated
   06.11.2017 bearing license no. 94 of 2017.<br><br><br>
   <b>C.</b> The Promoter has obtained approval on the layout plan/ demarcation/
   zoning/ site plan or any requisite approval for the Project as the case may
   be, from Town and Country Planning Department, Haryana Government.<br>
   The Promoter agrees and undertakes that it shall not make any changes to
   these approved plans except in strict compliance with section 14 of the Act/
   any other laws of the State as applicable.<br><br><br>
   <b>D.</b> The Promoter has registered the Project under the provisions of the Act with
   the Haryana Real Estate Regulatory Authority, at Gurugram vide HRERA No.
   RERA-GRG-PROJ-347-2019 and Registration No. 36 of 2020.

  </p>
 </section>
</body>

</html>
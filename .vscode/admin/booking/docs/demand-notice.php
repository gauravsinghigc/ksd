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
  $net_paid_amount2 += (int) $net_paid_amount;
  $unit_area = $FetchAllPayments['unit_area'];

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

//check re-sale or transfer status of current bookings
$CheckSql = "SELECT * FROM booking_resales where booking_main_id='$bookingid'";
$CheckStatus = CHECK($CheckSql);
$DocTitle = "Final Demand Notice Cum Offer Of Possession";
$TextName = "";


$inputString = FETCH($BookingSql, "unit_name"); // Your input string

// Use preg_replace to remove alphabets and get only numbers
$numbersOnly = preg_replace("/[^0-9]/", "", $inputString);
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset='utf-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <title>Final Demand Notice Cum Offer Of Possession @ KSD-YV/Plot No: <?php echo $numbersOnly; ?></title>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <style>
    section {
      width: 800px !important;
      height: 1000px !important;
    }

    html,
    body,
    p,
    ul,
    ol {
      line-height: normal !important;
    }
  </style>
</head>

<body onload="doConvert()" style=" font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI' , Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans' , 'Helvetica Neue' , sans-serif !important;margin-left:1.5rem;">
  <section style="padding:0.5rem;margin:2% auto;display:inline-block;">
    <img src="<?php echo STORAGE_URL; ?>/doc-img/header.jpg" style="width:100%;">
    <img src="<?php echo STORAGE_URL; ?>/doc-img/water.jpg" style="position: absolute;top: 25%;left: 26%;width: 50%;z-index: -1;">
    <div>
      <h2 style="text-align:center;margin-top: -1.5rem;margin-bottom:-0.2rem !important;"><?php echo $DocTitle; ?> <br>
        <hr style="width:70%;margin-top:-0.1rem;">
        </h4>
        <p style="display:flex;justify-content:space-between;font-size:14px;">
          <span>
            <span><b>Reference No:</b> KSD-YV/Plot No: <?php echo $numbersOnly; ?></span><br>
            <span><b>Plot No:</b> <?php echo $numbersOnly; ?>/<?php echo FETCH($BookingSql, "project_name"); ?></span>
          </span>
          <span style="text-align:right;">
            <span><b>Issue Date :</b> <?php echo Date("d M, Y"); ?></span><br>
            <span><b>Booking Date :</b>
              <?php echo DATE_FORMATE2("d M, Y", FETCH($BookingSql, "booking_date")); ?></span>
          </span>
        </p>
    </div>
    <div style="font-size:14px !important;">
      <div style="display:flex;justify-content:space-between;">
        <p>
          <b>To</b><br>
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
          <p style=" float:right;">
            <b>Co-Allotee Details</b>
            <br>
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
        <?php } ?>
      </div>


      <p><b>Subject:</b> Final Demand notice cum offer of possession for your <b>Plot No :
          <?php echo $numbersOnly; ?></b>
        in the Project-
        <b>"<?php echo FETCH($BookingSql, "project_name"); ?>"</b> situated at Sector-5. Pataudi, Gurugram, Haryana –
        122503.
      </p>
      <h4>Respected Sir/Ma’am,</h4>
      <p style="text-align: justify;">
        We <b>“M/s KSD Buildtech Private Limited”</b>, having registered office at <b>SCO 35, First
          Floor, Sector-15-II, Market, Gurugram, Haryana-122001</b> do hereby serve upon you the
        following Demand Notice in unequivocal terms:
        We <b>M/s KSD Buildtech Private Limited</b> are delighted to inform you that the
        completion certificate bearing <b>Memo No. LC-3319- JE (SB)-2023/ 406 on 03-01-2024</b> for
        the project <b>"<?php echo FETCH($BookingSql, "project_name"); ?>"</b> has been granted in respect of license
        <b>bearing no. 94 of 2017
          dated 06-11-2017</b> from the Director Town and Country Planning, Chandigarh, the
        progress on the plot that has been assigned to you in the project has reached a point
        where it is ready for possession. We will shortly begin the process of turning over
        possession of our project, <b>"<?php echo FETCH($BookingSql, "project_name"); ?>"</b>.
      </p>
      <p>To make this experience seamless for you, given below are the various requisites that
        needs to be followed at this stage of handing over of possession of your unit: </p>
      <ol>
        <li>After completion of construction, the Final Area of the said <b>Plot bearing no :
            <?php echo $numbersOnly; ?></b>
          is <b><?php echo $unit_area; ?></b>. </li>
        <li>
          <p style="text-align:justify;">
            As per the Payment Plan, instalment of
            <b><?php echo Price($BookingBalance = FETCH($BookingSql, "net_payable_amount") - $net_paid_amount2, "", "Rs."); ?></b>/-
            <b>(<?php echo PriceInWords($BookingBalance); ?>)</b> out of the Basic Selling Price
            <b>(hereinafter referred to as “BSP”)</b>, towards the final payments due against <b>Plot No :
              <?php echo $numbersOnly; ?></b> is payable at your end in order to enable us to start the process of
            handing over the possession of your unit. Kindly note that the due date for the
            payment of the due amount is
            <b><?php echo $DueDate = DATE_FORMATE2("d M, Y", IfRequested("GET", "due_date", date("Y-m-d", strtotime("+15 days")), false)); ?></b>.
          </p>
        </li>
        <li>
          <p style="text-align:justify;">
            Further, the payments against <b>“Annexure-A”</b> of the Application Form and
            <b>Schedule “C”</b> of the Plot Buyer Agreement <b>(hereinafter referred to as “PBA)</b>, executed by you
            and KSD
            Buildtech Pvt Ltd, are now pending. Total dues at
            this stage of the possession of your unit are as follows:
          </p>
        </li>
      </ol>
      <br>
      <img src="<?php echo STORAGE_URL; ?>/doc-img/footer.jpg" style="width:100%;">
  </section>

  <section style="height:100%;padding:0.5rem;margin:2% auto;display:inline-block;">
    <br>
    <img src="<?php echo STORAGE_URL; ?>/doc-img/header.jpg" style="width:100%;">
    <img src="<?php echo STORAGE_URL; ?>/doc-img/water.jpg" style="position: absolute;top: 70rem;left: 26%;width: 50%;z-index: -1;">
    <div style="font-size:14px !important;">
      <br>
      <table style="width:100%;" border="1">
        <tr>
          <th>S.No</th>
          <th>Description</th>
          <th>Amount (Rs.)</th>
        </tr>
        <tr>
          <th>1</th>
          <td>Due amount of the Total Price of the Unit </td>
          <th><?php echo Price($BookingBalance, "", "Rs."); ?>/-</th>
        </tr>
        <tr>
          <th>2</th>
          <td>Electrical route (without cable and Meter) </td>
          <th><?php echo Price($ELC_CHARGE = 20000, "", "Rs."); ?>/-</th>
        </tr>
        <tr>
          <th>3</th>
          <td>Water Connection (Without Meter) </td>
          <th><?php echo Price($WTR_CHARGE = 15000, "", "Rs."); ?>/-</th>
        </tr>
        <tr>
          <th>4</th>
          <td>Flush Water Supply Connection</td>
          <th><?php echo Price($WTR_SUPPLY_CHARGE = 15000, "", "Rs."); ?>/-</th>
        </tr>
        <tr>
          <th>5</th>
          <td>Sewerage Connection </td>
          <th><?php echo Price($SWG_CHARGE = 25000, "", "Rs."); ?>/-</th>
        </tr>
        <tr>
          <th>6</th>
          <td>Electrification Charges (HT Connection) </td>
          <th><?php echo Price($HT_CON_CHARGE = 25000, "", "Rs."); ?>/-</th>
        </tr>
        <?php $PointNo = 6; ?>
        <tr>
          <th><?php echo $PointNo = $PointNo + 1; ?></th>
          <td>Additional Cost: Interest Free Maintenance
            <?php if ($_GET['IFMS'] != "0") { ?>
              Security (IFMS) (Rs. <?php echo $IFMSPrice = IfRequested("GET", "IFMS", 0, False); ?>/- per sq. yrd.)<br>
              <b>(<?php echo Price($IFMSPrice, "", "Rs."); ?> x <?php echo GetNumbers($unit_area); ?> sq. yards =
                <?php echo Price($IFMSPrice * GetNumbers($unit_area), "", "Rs."); ?>/-)</b>
            <?php } ?>
          </td>
          <th>
            <?php if ($_GET['IFMS'] != "0") { ?>
              <?php echo Price($IFMSCharges = $IFMSPrice * GetNumbers($unit_area), "", "Rs."); ?>/-
            <?php } else {
              $IFMSCharges = 0; ?>
              Nill
            <?php } ?>
          </th>
        </tr>
        <?php
        ?>
        <tr>
          <th><?php echo $PointNo = $PointNo + 1; ?></th>
          <td>Other Charges (EDC/IDC) </td>
          <th>Nill</th>
        </tr>
        <tr>
          <th><?php echo $PointNo = $PointNo + 1; ?></th>
          <td>Registration Office expenses </td>
          <th>Nill</th>
        </tr>
        <tr>
          <th><?php echo $PointNo = $PointNo + 1; ?></th>
          <td>Stamp Duty </td>
          <th>As per government norms.</th>
        </tr>
        <?php
        $UPKEEPPrice = IfRequested("GET", "UPKEEP", 0, false);
        ?>
        <tr>
          <th><?php echo $PointNo = $PointNo + 1; ?></th>
          <td>
            <?php if ($_GET['UPKEEP'] != 0) { ?>
              1 Year advance upkeep charges <b>@ <?php echo Price($UPKEEPPrice, "", "Rs."); ?></b> per
              sq. yards.<br>
              <b><?php echo "Rs.$UPKEEPPrice x " . Getnumbers($unit_area) . " sq. yards = Rs." . ($UPKEEPPrice * GetNumbers($unit_area)) * 12; ?>/-</b>
            <?php } else { ?>
              1 Year advance upkeep charges: Free
            <?php } ?>
          </td>
          <th>
            <?php if ($_GET['UPKEEP'] != 0) { ?>
              <?php echo Price($UPKEEPCHarge = ($UPKEEPPrice * GetNumbers($unit_area)) * 12, "", "Rs."); ?>/-
            <?php } else {
              $UPKEEPCHarge = 0; ?>
              Nill
            <?php } ?>
          </th>
        </tr>
        <?php
        $NET_PAYABLE_AS_PER_FINAL_DEMAND_NOTICE = $HT_CON_CHARGE + $WTR_SUPPLY_CHARGE + $SWG_CHARGE + $ELC_CHARGE + $WTR_CHARGE + $IFMSCharges + $UPKEEPCHarge + $BookingBalance;
        ?>
        <tr>
          <th></th>
          <th>Total </th>
          <th><?php echo Price($NET_PAYABLE_AS_PER_FINAL_DEMAND_NOTICE, "", "Rs."); ?>/-</th>
        </tr>
      </table>
      <p>
        <b>NOTE: </b><br><br>
        <?php
        if ($IFMSCharges != 0) { ?>
          <b>* Additional Cost:</b> Interest Free Maintenance Security (IFMS)= <b>Rs.<?php echo $IFMSPrice; ?></b>/- x
          <b><?php echo GetNumbers($unit_area); ?> Sq. Yard</b> (Area of the allotted unit) =
          <b><?php echo Price($IFMSCharges, "", "Rs."); ?></b>/- <b>(<?php echo PriceInWords($IFMSCharges); ?>)</b>
          <br><br>
        <?php } else { ?>
          <b>* Additional Cost:</b> Interest Free Maintenance Security (IFMS)= <b>Not Applicable</b>
          <br><br>
        <?php }
        if ($UPKEEPCHarge != 0) { ?>
          <b>* 1 Year advance upkeep charges : </b> <b><?php echo Price($UPKEEPPrice, "", "Rs."); ?></b> x
          <b><?php echo Getnumbers($unit_area); ?> sq. yards</b> (Area of the
          allotted unit) = <b><?php echo Price($UPKEEPCHarge, "", "Rs."); ?></b>/-
          <b>(<?php echo PriceInWords($UPKEEPCHarge); ?>)</b>.
          <br>
        <?php } else { ?>
          <b>* 1 Year advance upkeep charges : </b> <b>Not Applicable</b>.
          <br>
        <?php } ?>
        <br>
        <b>* </b>
        Kindly clear the due payment as per demand in favor of
        <?php if (isset($_GET['BANK_ACCOUNT_DETAILS'])) {
          if ($_GET['BANK_ACCOUNT_DETAILS'] != "" || $_GET['BANK_ACCOUNT_DETAILS']  == ' ') {
            echo "<b>" . $_GET['BANK_ACCOUNT_DETAILS'] . "</b>";
          } else {
            echo "<b>M/s KSD Buildtech Pvt Ltd. A/c No. 0511000000001087, IFSC Code - NTBL0GUR051</b> which is our HRERA Master Account.";
          }
        } else { ?>
          <b>M/s KSD Buildtech Pvt Ltd. A/c No. 0511000000001087, IFSC Code - NTBL0GUR051</b> which is our HRERA Master Account.
        <?php } ?>
      </p>

      <p style='text-align:justify;'>
        Additionally, <b>KSD Buildtech Pvt Ltd</b> have been using the nomenclature of the
        Plot created at the time of the launch of sales or revisions made during the
        period of development to describe your property. It has been determined to
        prescribe an addressing method that will make it easier to identify a specific
        unit's address within the entire Project, even though the same performed its
        purpose during the marketing and construction phases. The new address for
        your property shall be as follows: <b>Plot No : <?php echo $numbersOnly; ?></b> in the
        Project-<b>"<?php echo FETCH($BookingSql, "project_name"); ?>"</b>
        situated at <b>Sector-5. Pataudi, Gurugram, Haryana – 122503</b>, and the plot
        allotted on the name of <b><?php echo FETCH($CustomerSql, "name"); ?>,
          <?php echo FETCH($CustomerSql, "father_name"); ?>,
          <?php
          echo FETCH($CustomerAddress, "user_street_address") . ", ";
          echo FETCH($CustomerAddress, "user_area_locality") . ". ";
          echo FETCH($CustomerAddress, "user_city") . ", ";
          echo FETCH($CustomerAddress, "user_state") . ", ";
          echo FETCH($CustomerAddress, "user_pincode") . ", ";
          echo FETCH($CustomerSql, "phone") . " ";
          echo FETCH($CustomerSql, "email") . " ";
          ?>
        </b>
      </p>
      <ol start="4">
        <li>
          <p><b>Special Power of Attorney:</b> KSD Buildtech Pvt Ltd wishes to clarify at this
            juncture that you may appoint an attorney or representative by granting them
            a legal power of attorney that has been properly executed and registered at the
            sub-registrar's office in the event if you are unable to personally visit the unit
            and/or for the execution and registration of the conveyance deed of your unit. </p>
        </li>
      </ol>
    </div>
    <br>
    <img src="<?php echo STORAGE_URL; ?>/doc-img/footer.jpg" style="width:100%;">
  </section>

  <section style="height:100%;padding:0.5rem;margin:2% auto;display:inline-block;">
    <br>
    <img src="<?php echo STORAGE_URL; ?>/doc-img/header.jpg" style="width:100%;">
    <img src="<?php echo STORAGE_URL; ?>/doc-img/water.jpg" style="position: absolute;top: 70rem;left: 26%;width: 50%;z-index: -1;">
    <div style="font-size:14px !important;">
      <ol start="5" style='margin-bottom:0px;margin-top:0px;'>
        <li>
          <p><b>Issuance of Offer of Possession:</b> KSD Buildtech Pvt Ltd further clarifies that
            you will receive an "OFFER OF POSSESSION" indicating the date on which the
            relevant Plot will be handed over upon fulfilment of the abovementioned
            prerequisites. </p>
        </li>
        <li>
          <p style='text-align:justify;'><b>Holding Charges:</b> Please be aware that upkeep charges of <b>Rs.
              <?php echo $UPKEEPPrice; ?></b> per square
            yards shall be paid on monthly basis in advance on or before 7th of each
            consecutive month in case you fail to make the due payments on or before the
            due date. </p>
        </li>
        <li>
          <p style='text-align:justify;'><b>Documentation required for possession:</b></p>
          <ol type='a'>
            <li>
              <p style='text-align:justify;'><b>Undertaking:</b> You are required to submit an Indemnity-cum-
                Undertaking along with the payment, as attached herewith, for
                intimation of Offer of Possession and hand-over of the unit.</p>
              <ul>
                <li>
                  <p style='text-align:justify;'><b>Resident Indians:</b> The undertaking should be typed on a Rs.
                    100/- stamp paper and the same has to be duly signed by all the
                    applicants and then attested by the notary public with requisite
                    value of notary stamp. </p>
                </li>
                <li>
                  <p style='text-align:justify;'>
                    <b>Non-Resident Indians:</b> The undertaking should be typed on
                    Bond Paper and should be attested by a Competent official of
                    the Indian Mission abroad/Consulate General abroad. The
                    same has to be duly stamped by the Collector of Stamps Delhi
                    within Three months from the date of Receipt in India.
                  </p>
                </li>
              </ul>
            </li>
            <li>
              <p style="text-align:justify;">
                Three passport size photographs of each allottee along with self-attested
                copy of PAN card/ Aadhar card for resident Indians and self-attested
                copy of passport of Non-Resident Indians, are required at the time of
                physical possession.
              </p>
            </li>
            <li>
              <p style="text-align:justify;">
                Stamp Duty and Registration charges
              </p>
            </li>
            <li>
              <p style="text-align:justify;">
                No objection certificate from Bank/ Financial Institution, for handing
                over the possession to you, the allottee, in case there is lien marked in
                this plot.
              </p>
            </li>
            <li>
              <p style="text-align:justify;">
                Maintenance Agreement
              </p>
            </li>
          </ol>
        </li>
        <li>
          <p style="text-align:justify;">
            <b>Physical Possession of the Plot:</b> You may schedule an appointment with KSD
            Buildtech Pvt Ltd to take Possession of the Plot once the dues have been cleared
            and the necessary documents have been signed and submitted. On the date of
            actual/formal handover, you may along with all the applicants, if any, visit the
            Project to take over the physical possession of the Plot.
          </p>
        </li>
        <li>
          <p style="text-align:justify;">
            <b>Conveyance Deed: </b>KSD Buildtech Pvt Ltd further affirms that upon successful
            completion of all the formalities, a conveyance deed for the Plot shall be
            executed in your favour within three months but not later than six months from
            the date of possession to convey the title of the Plot for which possession is
            being granted. The same would be registered with the Sub registrar, Tehsil
            Pataudi, Gurugram. Please note that your presence would be required for the
            execution and registration of the conveyance deed.
          </p>
        </li>
        <li>
          <p style="text-align:justify">
            <b> Enhanced government dues:</b> It is being clarified on behalf of KSD Buildtech
            Pvt Ltd that while the statement of accounts reflects the total dues of
            <B><?php echo Price($NET_PAYABLE_AS_PER_FINAL_DEMAND_NOTICE, "", "Rs."); ?></B> - as on
            <b><?php echo $DueDate; ?></b>, EDC/IDC charges which are levied by the
            government may at times, be enhanced, without sufficient notice by the
            government. If a request for such increased payment is made before or after
            registration of the property, it must be paid immediately upon request.
          </p>
        </li>
      </ol>
    </div> <br>
    <img src="<?php echo STORAGE_URL; ?>/doc-img/footer.jpg" style="width:100%;">
    <br>
  </section>

  <section style="height:100%;padding:0.5rem;margin:2% auto;display:inline-block;">
    <img src="<?php echo STORAGE_URL; ?>/doc-img/header.jpg" style="width:100%;">
    <img src="<?php echo STORAGE_URL; ?>/doc-img/water.jpg" style="position: absolute;top: 70rem;left: 26%;width: 50%;z-index: -1;">
    <div style="font-size:14px !important;">
      <ol start="11">
        <li>
          <p style="text-align:justify;">
            <b> TDS:</b> Under the newly inserted Section 194IA of the Income Tax Act, 1961, with
            effect from June 1, 2013, the transfer of an immovable property (sales price of
            more than Rs. 5 million) will be required to pay 1% tax at source on sale must
            be deducted. He shall remit the proceeds or part thereof payable to the
            transferor, at the time of payment or credit, whichever is earlier, to the treasury
            within 7 days from the end of the month in which the deduction is made. The
            Challan-cum-Statement in Form 26QB must be attached to the balance payment
            due directly to the company. Otherwise, late payment interest will be imposed
            as per the Application Form/Allotment letter/Plot Buyer Agreement. For your
            convenience, we provide below the information to submit on Form No. 26QB
            (Challan Cum Statesman) at the time of payment:
          </p>
        </li>
      </ol>
      <table style='width:100%;' border="1">
        <tr>
          <th>S.No</th>
          <th>Description of the filed in Form 26QB</th>
          <th>Information to be filed in the relevant box/space</th>
        </tr>
        <tr>
          <th>1.</th>
          <td>Permanent Account Number (PAN) of the Transferor/Payee/Seller </td>
          <th>
            <?php echo FETCH("SELECT * FROM user_documents where document_name like '%PAN CARD%' and user_id='$customer_id'", "user_documents_no"); ?>
          </th>
        </tr>
        <tr>
          <th>2.</th>
          <td>Full Name of the Transferor/Payee/Seller </td>
          <th><?php echo FETCH($CustomerSql, "name"); ?></th>
        </tr>
        <tr>
          <th>3.</th>
          <td>Complete Address of the Transferor/Payee/Seller. </td>
          <th>
            <?php
            echo FETCH($CustomerAddress, "user_street_address") . ", ";
            echo FETCH($CustomerAddress, "user_area_locality") . ". ";
            echo FETCH($CustomerAddress, "user_city") . ", ";
            echo FETCH($CustomerAddress, "user_state") . ", ";
            echo FETCH($CustomerAddress, "user_pincode") . ", ";
            ?>
          </th>
        </tr>
      </table>
      <ol start=" 12">
        <li>
          <p style='text-align:justify;'><b>Consequences in case of default of payment of dues by the allottee(s):</b>
            <b><?php echo FETCH($CustomerSql, "name"); ?></b>, if you default in making the payment aforementioned
            dues within the stipulated time frame or make any other default in furtherance
            to the pre-requisites, then <b>KSD Buildtech Pvt Ltd</b> shall have the rights
            mentioned below:
          </p>
          <ol type='a'>
            <li>
              <p style='text-align:justify;'>To charge interest on the due amount at the rate prescribed by the
                HRERA Rules and Regulations i.e., 10.75%. (SBI MCLR +2%)</p>
            </li>
            <li>
              <p style='text-align:justify;'>
                To keep on abeyance/suspension of the booking or cancel the allotment
                of the said Plot.
              </p>
            </li>
            <li>
              <p style="text-align:justify;">
                To forfeit/deduct the earnest money together with interest on
                instalments due but unpaid and interest on delayed payments and other
                deductible/non-refundable amount such as amount to be paid/or paid
                to the Broker; any tax, govt. cess or other amount paid to the Authority
                or Government.
              </p>
            </li>
            <li>
              <p style="text-align:justify">
                To re-allocate the allotment of the said Plot which includes change in
                area and location of the said Plot.
              </p>
            </li>
          </ol>
        </li>
      </ol>
      <p style='text-align:justify;'>
        If the above-mentioned rights are exercised, then the balance amount after
        aforesaid deductions shall be refundable to you without any interest, after the
        said Plot is allotted to some other intending Applicant(s) and after compliance
        of certain formalities by the Applicant(s).
      </p>
      <p style='text-align:justify;'>
        For further communication/concern regarding the same, please write back on
        the official mail id- Support@Yashvihar.com and official contact no.
        8826545471.
      </p>
      <p style="text-align:justify;">
        <b>Yours Sincerely,</b>
        <br><br><br><br>
        <small>
          KSD Buildtech Pvt. Ltd.<br>
          SCO - 35, First Floor<br>
          Sector - 15, Part 2<br>
          Gurgaon - 122001<br>
        </small>
      </p>
    </div>
    <img src="<?php echo STORAGE_URL; ?>/doc-img/footer.jpg" style="width:100%;">
  </section>

</body>

</html>
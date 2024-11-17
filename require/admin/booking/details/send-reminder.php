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
$MainBookingID = "B" . $bookingid . "/" . date('m/Y', strtotime(FETCH($BookingSql, 'created_at')));
?>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Send Reminder Letter : <?php echo company_name; ?></title>
  <?php include '../../../include/header_files.php'; ?>
</head>

<body>
  <div id="container" class="navbar-fixed mainnav-fixed mainnav-lg">
    <?php include '../../header.php'; ?>

    <!-- main content area -->
    <div class="boxed">
      <!--CONTENT CONTAINER-->
      <!--===================================================-->
      <div id="content-container">
        <!--Page content-->
        <div id="page-content">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-12">
              <div class="panel square">
                <div class="panel-body">
                  <div class="row">
                    <div class="col-md-12">
                      <h3 class="m-t-0"><i class="fa fa-exchange text-danger"></i> Send Payment Reminder (Reminder Letter) : <span class="text-grey"> <?php echo $MainBookingID; ?></span></h3>
                      <a href="index.php" class="btn btn-md btn-default"><i class="fa fa-angle-left"></i> Back to Booking Dashboard</a>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-4">
                      <h4 class="section-heading">Booking Details</h4>
                      <p class="data-list flex-s-b">
                        <span>Ref No : </span>
                        <b><?php echo FETCH($BookingSql, 'crn_no'); ?>//<?php echo FETCH($BookingSql, "ref_no"); ?></b>
                      </p>
                      <p class="data-list flex-s-b">
                        <span>BookingID : </span>
                        <b><?php echo $MainBookingID; ?></b>
                      </p>
                      <p class="data-list flex-s-b">
                        <span>Project Name :</span>
                        <b><?php echo FETCH($BookingSql, "project_name"); ?></b>
                      </p>
                      <p class="data-list flex-s-b">
                        <span>Project Area :</span>
                        <b><?php echo FETCH($BookingSql, "project_area"); ?></b>
                      </p>
                      <p class="data-list flex-s-b">
                        <span>Plot No :</span>
                        <b><?php echo strtoupper(FETCH($BookingSql, "unit_name")); ?></b>
                      </p>
                      <p class="data-list flex-s-b">
                        <span>Plot Area :</span>
                        <b><?php
                            $matches = preg_replace('/[^0-9.]+/', '', FETCH($BookingSql, "unit_area"));
                            $unit_area_in_numbers = (int)$matches;
                            echo FETCH($BookingSql, "unit_area"); ?></b>
                      </p>
                      <p class="data-list flex-s-b">
                        <span>Plot Rate :</span>
                        <b>Rs.<?php echo FETCH($BookingSql, "unit_rate"); ?>/sq yards</b>
                      </p>
                      <p class="data-list flex-s-b">
                        <span>Plot Cost :</span>
                        <b><?php echo Price(FETCH($BookingSql, "unit_cost"), "text-primary", "Rs."); ?></b>
                      </p>
                      <?php if (FETCH($BookingSql, "charges") != 0) { ?>
                        <tr>
                          <th>Charges <span class="text-grey fs-11 m-l-5"><?php echo FETCH($BookingSql, "chargename"); ?> (
                              <?php echo FETCH($BookingSql, "charges"); ?>% )</span></th>
                          <td>+ Rs.<?php echo $unit_cost / 100 * (int)FETCH($BookingSql, "charges"); ?></td>
                        </tr>
                      <?php } ?>
                      <?php if (FETCH($BookingSql, "discount") != 0) { ?>
                        <tr>
                          <th>Discount <span class="text-grey fs-11 m-l-5"><?php echo FETCH($BookingSql, "discountname"); ?> (
                              Rs.<?php echo FETCH($BookingSql, "discount");  ?> )</span></th>
                          <td>- Rs.<?php echo $unit_area_in_numbers * FETCH($BookingSql, "discount"); ?></td>
                        </tr>
                      <?php } ?>
                      <p class="data-list flex-s-b">
                        <span>Net Plot Cost :</span>
                        <b><?php echo Price(FETCH($BookingSql, "net_payable_amount"), "text-primary", "Rs."); ?></b>
                      </p>
                    </div>
                    <div class="col-md-4">
                      <h4 class="section-heading">Payment History</h4>
                      <?php
                      if (isset($_GET['search'])) {
                        $search_type = $_GET['search_type'];
                        $search_value = $_GET['search_value'];

                        if ($search_type == "payments.payment_date") {
                          $search_value = date("Y-m-d", strtotime($search_value));
                        } elseif ($search_type == "payments.created_at") {
                          $search_value = date("d M, Y", strtotime($search_value));
                        } else {
                          $search_value = $search_value;
                        }
                        $getpayments = SELECT("SELECT *, payments.created_at AS 'payment_created_at' FROM payments, bookings where $search_type like '%$search_value%' and payments.bookingid=bookings.bookingid and bookings.bookingid='$bookingid' order by payments.payment_id DESC");
                      } else {
                        $getpayments = SELECT("SELECT *, payments.created_at AS 'payment_created_at' FROM payments, bookings where payments.bookingid=bookings.bookingid and bookings.bookingid='$bookingid' order by payments.payment_id DESC");
                      }
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
                          $$payment_mode = $payment_mode;
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
                      ?>
                        <p class="data-list">
                          <span class="text-left"><?php echo $payment_mode; ?></span>
                          <span class="text-success text-left">Rs.<?php echo $net_paid_amount; ?></span>
                          <span class="text-left"><?php echo $payment_date; ?></span>
                          <span class="text-right">
                            <a href="<?php echo DOMAIN; ?>/admin/booking/emi_receipt.php?id=<?php echo $bookingid; ?>&payment_id=<?php echo $payment_id; ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-print"></i> View Receipt</a>
                          </span>
                        </p>
                      <?php } ?>
                      <p class="data-list text-right">
                        <span>Net Payable (<?php echo $full = 100; ?>%):</span>
                        <b><?php echo Price($Payable = (int)FETCH($BookingSql, "net_payable_amount"), "text-primary", "Rs."); ?></b>
                      </p>
                      <p class="data-list text-right">
                        <span>Net Paid (<?php $Pending = $full - round((int)$net_paid_amount2 / (int)$Payable * 100);
                                        echo $full - $Pending; ?>%):</span>
                        <b><?php echo Price((int)$net_paid_amount2, "text-success", "Rs."); ?></b>
                      </p>
                      <p class="data-list text-right">
                        <span>Balance (<?php echo $full - round((int)$net_paid_amount2 / (int)$Payable * 100); ?>%):</span>
                        <b><?php echo Price((int)$Payable - (int)$net_paid_amount2, "text-danger", "Rs."); ?></b>
                      </p>

                    </div>
                    <div class="col-md-4">
                      <h4 class="section-heading">Previous Reminder Letters</h4>
                      <?php
                      $Demands = FetchConvertIntoArray("SELECT * FROM booking_pay_req where PayReqType='REMINDER' and PayReqBookingId='$bookingid'", true);
                      if ($Demands != null) {
                        foreach ($Demands as $d) { ?>
                          <p class="data-list" style="display:flex !important;flex-direction: column;padding:0.4rem !important;">
                            <span class="w-100">
                              <?php Price($dmdamount = $d->PayRequestingAmount, "text-success", "Rs."); ?>
                              (<?php $REQ = round((int)$dmdamount / FETCH($BookingSql, "net_payable_amount") * 100);
                                echo 100 - (100 - $REQ); ?>%) @
                              <?php echo DATE_FORMATE2("d M, Y", $d->PayReqDate); ?><br>
                              <span class="text-grey">due on <?php echo DATE_FORMATE2("d M, Y", $d->PayRequestDueDate); ?></span>
                            </span>
                            <span class="w-100">
                              <a target="_blank" href="../docs/remd-l.php?id=<?php echo $bookingid; ?>&dmdid=<?php echo $d->PaymentRequestId; ?>" class="btn btn-sm btn-primary" style="margin-left:0px !important;">View Reminder Letter</a>
                              <?php CONFIRM_DELETE_POPUP(
                                "remove_dmd",
                                [
                                  "remove_demand_letters" => true,
                                  "control_id" => $d->PaymentRequestId,
                                ],
                                "bookingcontroller",
                                "Remove",
                                "btn btn-danger btn-sm"
                              ); ?>
                            </span>
                            <br>
                          </p>
                      <?php }
                      } else {
                        NoData("No Reminder Letter Found!");
                      } ?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-4">
                      <h4 class="section-heading">Allotee & Co-Allotee Details</h4>
                      <p>
                        <b>Allotee Details</b><br>
                        <?php echo FETCH($CustomerSql, "name"); ?>,<br>
                        <?php echo FETCH($CustomerSql, "father_name"); ?><br>
                        <?php
                        echo FETCH($CustomerAddress, "user_street_address") . " ";
                        echo FETCH($CustomerAddress, "user_area_locality") . "<br>";
                        echo FETCH($CustomerAddress, "user_city") . " ";
                        echo FETCH($CustomerAddress, "user_state") . "<br>";
                        echo FETCH($CustomerAddress, "user_pincode") . " ";
                        echo FETCH($CustomerAddress, "user_country");
                        echo "<br>";
                        echo FETCH($CustomerSql, "phone") . "<BR>";
                        echo FETCH($CustomerSql, "email") . "<BR>";
                        ?>
                      </p>
                      <hr>
                      <?php $Check = CHECK($CoAllotySql);
                      if ($Check != null) { ?>
                        <p>
                          <b>Co-Allotee Details</b><br>
                          <?php echo FETCH($CoAllotySql, "BookingAllotyRelation"); ?><br>
                          <?php echo FETCH($CoAllotySql, "BookingAllotyFullName"); ?><br>
                          <?php echo FETCH($CoAllotySql, "BookingAllotyFatherName"); ?><br>
                          <?php
                          echo FETCH($CoAllotySql, "BookingAllotyStreetAddress");
                          echo FETCH($CoAllotySql, "BookingAllotyArea") . "<br>";
                          echo FETCH($CoAllotySql, "BookingAllotyCity");
                          echo FETCH($CoAllotySql, "BookingAllotyState") . "<br>";
                          echo FETCH($CoAllotySql, "BookingAllotyCountry") . "";
                          echo FETCH($CoAllotySql, "BookingAllotyPincode");
                          echo "<br>";
                          echo FETCH($CoAllotySql, "BookingAllotyPhoneNumber") . "<BR>";
                          echo FETCH($CoAllotySql, "BookingAllotyEmail") . "<BR>";
                          ?>
                        </p>
                      <?php } ?>
                    </div>

                    <div class="col-md-8">
                      <h4 class="section-heading">Send Payment Request or Reminder Letter</h4>
                      <form action="../../../controller/bookingcontroller.php" method="POST">
                        <?php FormPrimaryInputs(true, [
                          "PayReqBookingId" => $bookingid,
                          "PhoneNumber" => FETCH($CustomerSql, "phone"),
                          "EmailId" => FETCH($CustomerSql, "email"),
                          "Name" => FETCH($CustomerSql, "name"),
                          "PayReqType" => "REMINDER"
                        ]); ?>
                        <div class="row">
                          <div class="col-md-4 form-group">
                            <label>BookingID</label>
                            <input type="text" name="MainBookingID" class="form-control" value="<?php echo $MainBookingID; ?>" readonly="">
                          </div>
                          <div class="col-md-4 form-group">
                            <label>Req Send Date</label>
                            <input type="date" name="PayReqDate" class="form-control" value="<?php echo DATE("Y-m-d"); ?>">
                          </div>
                          <div class="col-md-4 form-group">
                            <label>Booking Amount</label>
                            <input type="text" name="null" readonly="" class="form-control" value="<?php echo FETCH($BookingSql, "net_payable_amount"); ?>">
                          </div>
                        </div>
                        <div class="row">
                          <div class="from-group col-md-4">
                            <label>Request Amount (in %)</label>
                            <input type="text" name="demand_percentage" id="applicablereceivebookingamount" list="listpercentage" class="form-control" oninput="ReceiveBookingAmount()">
                            <datalist id="listpercentage">
                              <option value="1">Enter Manual</option>
                              <?php
                              $ProjectStages = FetchConvertIntoArray("SELECT * FROM project_stages where ProjectStageMainProjectId='" . FETCH($BookingSql, 'project_list_id') . "' ORDER BY ProjectStageId DESC", true);
                              if ($ProjectStages != null) {
                                foreach ($ProjectStages as $Stages) {
                              ?>
                                  <option value="<?php echo $Stages->ProjectStagePaymentPercentage; ?>">
                                    <?php echo $Stages->ProjectStageName; ?> @ <?php echo $Stages->ProjectStagePaymentPercentage; ?>%
                                  </option>
                                <?php
                                }
                              } else {
                                ?>
                                <option value="new">Please Add Project Stages as per DLP</option>
                              <?php
                              } ?>
                            </datalist>
                          </div>
                          <div class="from-group col-md-4">
                            <label>Amount : &nbsp;<Span id="err" class="text-danger float-right"> </Span></label>
                            <input type="text" name="PayRequestingAmount" id="current_paying_amount" onmouseout="CalculateEmis()" oninput="CalculatePrice()" value="" class="form-control" placeholder="" required="">
                          </div>
                          <div class="col-md-4 form-group">
                            <label>Due Date</label>
                            <input type="date" name="PayRequestDueDate" value="<?php echo date("Y-m-d", strtotime("+1 month")); ?>" class="form-control">
                          </div>
                          <div class="col-md-12">
                            <label>
                              <input type="checkbox" name="sms" value="true"> Send Link via SMS on
                              <?php echo FETCH($CustomerSql, "phone"); ?>
                            </label><br>
                            <label>
                              <input type="checkbox" name="email" value="true"> Send Link via EMAIL on
                              <?php echo FETCH($CustomerSql, "email"); ?>
                            </label>
                          </div>
                          <div class="col-md-6 form-group pt-3">
                            <br>
                            <label>Demand Descriptions</label>
                            <textarea class="form-control" name="PayRequestDescriptions" rows="3"></textarea>
                          </div>
                          <div class="col-md-6 form-group pt-3">
                            <br>
                            <label>Notes:</label>
                            <textarea class="form-control" name="PayReqSendDescsriptions" rows="3"></textarea>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-12">
                            <button type="submit" name="GenerateDemandLetter" class="btn btn-lg btn-success">Generate Reminder
                              Letter</button>
                            <a href="../docs/demand-letter-for-payment-request.php?id=<?php echo $bookingid; ?>" class="btn btn-lg btn-default">View Latest Reminder Letter</a>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include '../../payments/payment-popup.php'; ?>

    <script>
      function ReceiveBookingAmount() {
        var applicablereceivebookingamount = document.getElementById("applicablereceivebookingamount");
        var current_paying_amount = document.getElementById("current_paying_amount");
        var RealProjectAmount = <?php echo FETCH($BookingSql, 'net_payable_amount'); ?>;

        if (applicablereceivebookingamount.value == 0 || applicablereceivebookingamount.value == "0") {
          current_paying_amount.value = 1;

        } else {
          var new_booking_amount = Math.round(+RealProjectAmount / 100 * +applicablereceivebookingamount.value);
          current_paying_amount.value = +new_booking_amount;
          document.getElementById("paid_amount").innerHTML = "Rs." + current_paying_amount.value;
          document.getElementById("amounttobepaid").innerHTML = +RealProjectAmount - +new_booking_amount;
          document.getElementById("amount_left").value = +RealProjectAmount - +new_booking_amount;
        }
      }
    </script>
    <!-- end -->
    <?php include '../../sidebar.php'; ?>
    <?php include '../../footer.php'; ?>
  </div>

  <?php include '../../../include/footer_files.php'; ?>

</html>
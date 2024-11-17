<?php
require '../../../../require/modules.php';
require "../../../../require/admin/sessionvariables.php";
require '../../../../include/admin/common.php';



if (isset($_SESSION['TEMP_BOOKING_SESSION'])) {
  if ($_SESSION['TEMP_BOOKING_SESSION'] == NULL) {
    LOCATION("warning", "Please Start Fresh Bookings", ADMIN_URL . "/booking/new_booking.php");
  }
}
if (isset($_GET['continueforpayment'])) {
  $project_unit_id = $_GET['project_unit_id'];
  $_SESSION['project_name'] = $_GET['project_name'];
  $_SESSION['project_area'] = $_GET['project_area'];
  $_SESSION['unit_name'] = $_GET['unit_name'];
  $_SESSION['unit_area'] = $_GET['unit_area'];
  $_SESSION['unit_rate'] = $_GET['unit_rate'];
  $_SESSION['unit_cost'] = $_GET['unit_cost'];
  $_SESSION['net_payable_amount'] = $_GET['net_payable_amount'];
  $_SESSION['chargename'] = $_GET['chargename'];
  $chargeamount2 = $_GET['charges'];
  $_SESSION['charges'] = $chargeamount2;
  $_SESSION['discount'] = $_GET['discount'];
  $_SESSION['project_list_id'] = $_SESSION['p_search'];
  $_SESSION['project_unit_id'] = $_GET['project_unit_id'];
  if ($_GET['discountamount'] == null || $_GET['discountamount'] == "") {
    $_SESSION['discountname'] = "";
    $_SESSION['discountamount'] = "";
  } else {
    $_SESSION['discountamount'] = $_GET['discountamount'];
    $_SESSION['discountname'] = $_GET['discountname'];
  }
} else {
  $_SESSION['project_name'] = $_SESSION['project_name'];
  $_SESSION['project_area'] = $_SESSION['project_area'];
  $_SESSION['unit_name'] = $_SESSION['unit_name'];
  $_SESSION['unit_area'] = $_SESSION['unit_area'];
  $_SESSION['unit_rate'] = $_SESSION['unit_rate'];
  $_SESSION['unit_cost'] = $_SESSION['unit_cost'];
  $_SESSION['net_payable_amount'] = $_SESSION['net_payable_amount'];
  $_SESSION['chargename'] = $_SESSION['chargename'];
  $_SESSION['charges'] = $_SESSION['charges'];
  $_SESSION['discountname'] = $_SESSION['discountname'];
  $_SESSION['discount'] = $_SESSION['discount'];
  $_SESSION['project_list_id'] = $_SESSION['project_list_id'];
  $_SESSION['project_unit_id'] = $_SESSION['project_unit_id'];
  $_SESSION['discountamount'] = $_SESSION['discountamount'];
}

$project_list_id = $_SESSION['project_list_id'];

//check project current stage
$StageSql = "SELECT * FROM project_stages where ProjectStageMainProjectId='" . $_SESSION['p_search'] . "' ORDER BY ProjectStageId DESC";
$ProjectStagePaymentPercentage = FETCH($StageSql, "ProjectStagePaymentPercentage");
if ($ProjectStagePaymentPercentage == null || $ProjectStagePaymentPercentage == "") {
  $BookingAmount = "";
  $StageName = "";
  $StagePer = "";
} else {
  $GetAmount = round((int)$_SESSION['net_payable_amount'] / 100 * (int)$ProjectStagePaymentPercentage);
  $BookingAmount = $GetAmount;
  $StageName = FETCH($StageSql, "ProjectStageName") . " Stage.";
  $StagePer = $ProjectStagePaymentPercentage . "% of Rs." . $_SESSION['net_payable_amount'] . " due to ";
}

//get partner id
if (isset($_SESSION['customer_id'])) {
  $customer_id = $_SESSION['customer_id'];
  $partner_id = FETCH("SELECT * FROM users where id='$customer_id'", "agent_relation");
} else {
  $partner_id = null;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Payment | <?php echo company_name; ?></title>
  <?php include '../../../../include/header_files.php'; ?>
  <style>
    table tr th,
    table tr td,
    table tr td span {
      padding: 2px 4px !important;
      font-size: 1rem !important;
    }
  </style>
</head>

<body>
  <div id="container" class="navbar-fixed mainnav-fixed mainnav-lg">
    <?php include '../../../header.php'; ?>

    <!--END NAVBAR-->
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
                    <div class="col-md-12 text-center m-t-2">
                      <div class="steps">
                        <a href="../../new_booking.php">
                          <span class="step active"><i class="fa fa-check-circle"></i></span>
                          <span class="step-text">Customer Selected</span>
                        </a>
                        <a href="../../project/">
                          <span class="step active"><i class="fa fa-check-circle"></i></span>
                          <span class="step-text">Plot Selected</span>
                        </a>
                        <a>
                          <span class="step run">3</span>
                          <span class="step-text">Payment Details</span>
                        </a>
                        <a>
                          <span class="step">4</span>
                          <span class="step-text">Agent Details</span>
                        </a>
                        <a>
                          <span class="step run">5</span>
                          <span class="step-text">Upload Documents</span>
                        </a>
                      </div>
                    </div>
                  </div>
                  <form action="partner" method="GET">
                    <div class="row">
                      <input type="text" name="user_country" value="INDIA" hidden="">
                      <input type="text" name="partner_id" value="<?php echo $partner_id; ?>" hidden="">
                      <input type="text" name="emi_per_month" hidden="" value="<?php echo $_SESSION['net_payable_amount']; ?>" id="calculatedemi">
                      <input type="text" name="emi_last_date" hidden="" value="" id="lastdateofemisss">
                      <div class="col-md-12">
                        <div class="section-heading flex-s-b">
                          <h4 class="m-b-0 m-t-2">Payment Methods</h4>
                          <i class="fa fa-angle-right fs-20"></i>
                        </div>
                      </div>
                      <div class="col-md-12 m-b-15 m-t-10 text-center">
                        <div class="btn-group-lg btn-group payments">
                          <label class="btn btn-success">
                            <input type="radio" name="payment_mode" id="pay_mode" hidden="" value="cash" onclick="PaymentMode('cash')" checked=""> <i class="fa fa-money"></i> Cash Receipts
                          </label>
                          <label class="btn btn-warning">
                            <input type="radio" name="payment_mode" hidden="" id="pay_mode" value="banking" onclick="PaymentMode('banking')"><i class="fa fa-mobile"></i> Online Receipts
                          </label>
                          <label class="btn btn-danger">
                            <input type="radio" name="payment_mode" hidden="" id="pay_mode" value="check" onclick="PaymentMode('check')"><i class="fa fa-text-height"></i> Cheque/DD Receipts
                          </label>
                        </div>
                      </div>

                      <div class="col-md-12 col-12" style="display:none;padding: 0rem 1rem;" id="check">
                        <div class="col-md-12">
                          <h4><b>Cheque/DD Payment</b></h4>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                          <div class="form-group">
                            <label>Name of Person For whom check is Issued</label>
                            <input type="text" name="checkissuedto" value="" class="form-control">
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                          <div class="form-group">
                            <label>Cheque/DD Number</label>
                            <input type="text" name="checknumber" value="" class="form-control">
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                          <div class="form-group">
                            <label>Bank Name</label>
                            <input type="text" name="BankName" value="" class="form-control">
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                          <div class="form-group">
                            <label>Bank IFSC Code</label>
                            <input type="text" name="ifsc" value="" class="form-control">
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                          <div class="form-group">
                            <label>Cheque Date</label>
                            <input type="date" value='<?php echo date("Y-m-d"); ?>' name="checkissuedate" class="form-control">
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                          <div class="form-group">
                            <label>Cheque Status</label>
                            <select class="form-control" name="checkstatus" id="checkissustatus" onchange="checkcheckstatus()">
                              <option value="Issued">Select Cheque Status</option>
                              <option value="Issued">Received</option>
                              <option value="Clear">Clear</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12" style="display:none;" id="checkcleardate">
                          <div class="form-group">
                            <label>Cheque Clear Date</label>
                            <input type="date" name="clearedat" value="" class="form-control">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-12 col-12" style="display:none;padding: 0rem 1rem;" id="banking">
                        <div class="row">
                          <div class="col-md-12">
                            <h4><b>Online Banking</b></h4>
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                              <label>Online Payment Type</label>
                              <select name="onlinepaymenttype" class="form-control">
                                <option value="NetBanking/Online" selected>Net Banking/Online</option>
                                <option value="CC/DC">Credit/Debit Card</option>
                                <option value="Wallets">Online Wallets</option>
                                <option value="UPI">UPI</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                              <label>Bank/Wallet/Upi/Provider name</label>
                              <input type="text" name="OnlineBankName" value="" class="form-control">
                            </div>
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                              <label>Transaction ID</label>
                              <input type="text" name="transactionId" value="" class="form-control">
                            </div>
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                              <label>Transaction Status</label>
                              <select name="transaction_status" class="form-control">
                                <option value="Pending">Select Txn Status</option>
                                <option value="Success">Success</option>
                                <option value="Pending">Pending</option>
                                <option value="Failed">Failed</option>
                                <option value="Rejected">Rejected By Provider</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                              <label>Transaction Details/Notes</label>
                              <textarea class="form-control" name="payment_details" row="1"></textarea>
                            </div>
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                              <label>Transaction Date</label>
                              <input type="date" value='<?php echo date("Y-m-d"); ?>' name="transactiondate" value="" class="form-control">
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-12 col-12" id="cash" style="padding: 0rem 1rem;">
                        <div class="row">
                          <div class="col-md-12">
                            <h4 class="bold"><b>Cash Payment</b></h4>
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                              <label>Cash Received By</label>
                              <input type="text" name="cashreceivername" value="<?php echo LOGIN_UserFullName; ?> @ <?php echo LOGIN_UserId; ?>" class="form-control">
                            </div>
                          </div>

                          <input type="hidden" name="cashamount" id="cashamount" readonly="" value="<?php echo $_SESSION['net_payable_amount']; ?>" class="form-control">

                          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                              <label>Cash Received date</label>
                              <input type="date" value='<?php echo date("Y-m-d"); ?>' name="cashreceivedate" class="form-control">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row m-t-20 m-b-10">
                      <div class="col-md-12">
                        <h4 class="section-heading">Booking Amount</h4>
                      </div>
                      <div>
                        <div class="from-group col-md-6">
                          <label>Select Applicable Booking Amount</label>
                          <select class="form-control" id="applicablereceivebookingamount" onchange="ReceiveBookingAmount()" required>
                            <option value="0">Select Project Stage</option>
                            <option value="manual">Receive Manual Percentage</option>
                            <?php
                            $ProjectStages = FetchConvertIntoArray("SELECT * FROM project_stages where ProjectStageMainProjectId='$project_list_id' ORDER BY ProjectStageId DESC", true);
                            if ($ProjectStages != null) {
                              foreach ($ProjectStages as $Stages) {
                            ?>
                                <option value="<?php echo $Stages->ProjectStagePaymentPercentage; ?>"><?php echo $Stages->ProjectStageName; ?> @ <?php echo $Stages->ProjectStagePaymentPercentage; ?>%</option>
                              <?php
                              }
                            } else {
                              ?>
                              <option value="new">Please Add Project Stages as per DLP</option>
                            <?php
                            } ?>
                          </select>
                        </div>
                        <div class="from-group col-md-6">
                          <label>Booking Amount : &nbsp;<Span id="err" class="text-danger float-right"> </Span></label>
                          <input type="text" name="booking_amount" id="current_paying_amount" onmouseout="CalculateEmis()" oninput="CalculatePrice()" value="<?php echo $BookingAmount; ?>" class="form-control" placeholder="" required="">
                        </div>
                        <div class="from-group col-md-6">
                          <label>Rest Amount (Rs.)</label>
                          <input type="number" name="rest_amount" id="amount_left" value="<?php echo $_SESSION['net_payable_amount']; ?>" readonly="" class="form-control" placeholder="">
                        </div>
                        <div class="from-group col-md-6">
                          <div style="display:none;" id="manual_receive">
                            <label>Receiving Percentage</label>
                            <input type="number" id="per_centage_receving" value="" readonly="" class="form-control" placeholder="">
                          </div>
                        </div>
                        <div class="from-group col-md-6">
                          <label>Booking Date</label>
                          <input type="date" value='<?php echo date("Y-m-d"); ?>' name="booking_date" class="form-control" placeholder="" required="">
                        </div>
                        <div class="from-group col-md-6 hidden">
                          <label>EMI Start Date</label>
                          <input type="date" name="emi_start_date" min="2000-01-01" value="<?php echo date("Y-m-d", strtotime("+1 Months")); ?>" onchange="EmiStartDate()" id="emi_starts_from" class="form-control" placeholder="" required="">
                        </div>
                        <div class="from-group col-md-6 hidden">
                          <label>Prefer Payment Date</label>
                          <select name="emi_day_of_month" onchange="EmiStartDate()" id="prefer_emi_date" class="form-control demo-chosen-select" placeholder="" required="">
                            <?php
                            $s = 1;
                            while ($s < 31) {
                              if ($s == 10) {
                                $selected = "selected";
                              } else {
                                $selected = "";
                              } ?>
                              <option value="<?php echo $s; ?>" <?php echo $selected; ?>><?php echo $s; ?> day of Every Month</option>
                            <?php
                              $s++;
                            } ?>
                          </select>
                        </div>
                        <div class="from-group col-md-6 hidden">
                          <label>Select Approx Clearing Months</label>
                          <select name="emi_months" class="form-control demo-chosen-select" id="emimonths" onmouseout="EmiStartDate()" onchange="CalculateEmis()" placeholder="" required="">
                            <?php
                            $StartMonth = MIN_EMI_MONTH;
                            $EndMonth = MAX_EMI_MONTHS;
                            $Start = 1;
                            $TotalMonth = $EndMonth / $StartMonth;
                            while ($Start <= $TotalMonth) {
                              $EMIMONTHLIST = $Start * $StartMonth;
                              if ($EMIMONTHLIST == 24) {
                                $selected = "selected";
                              } else {
                                $selected = "";
                              } ?>
                              <option value="<?php echo $EMIMONTHLIST; ?>" <?php echo $selected; ?>><?php echo $EMIMONTHLIST; ?></option>
                            <?PHP $Start++;
                            }
                            ?>
                          </select>
                        </div>
                        <div class="from-group col-md-6" hidden="">
                          <label>Clearing Date</label>
                          <input type="text" value='' name="" class="form-control" readonly="" placeholder="" required="">
                        </div>
                        <div class="from-group col-md-6">
                          <label>Possession Status</label>
                          <div class=""><input type="radio" name="possession" value="yes" id=""> Yes (Possession Provided)</div>
                          <div class=""><input type="radio" name="possession" value="no" checked="" id=""> No (Not Provided)</div>
                        </div>
                        <div class=" from-group col-md-6">
                          <label>Possession Notes</label>
                          <textarea class="form-control" name="possession_notes" style="height:auto !important;" rows="2"></textarea>
                        </div>
                      </div>
                    </div>

                    <div class="row m-t-2">
                      <div class="col-md-6 text-right">
                        <div class="from-group col-md-12 text-right flex-inline pl-0 pr-0">
                          <h4 class="text-left section-heading">Payment Review</h4>
                          <table class="table table-striped">
                            <tbody>
                              <tr>
                                <th>Plot Area</th>
                                <td><span><?php echo  (int)$_SESSION['unit_area']; ?>/<?php echo MeasurementUnit; ?></span></td>
                              </tr>
                              <tr>
                                <th>Plot Rate</th>
                                <td><span>Rs.<?php echo  (int)$_SESSION['unit_rate']; ?>/<?php echo MeasurementUnit; ?></span></td>
                              </tr>
                              <tr>
                                <th>Plot Cost</th>
                                <td><span>Rs.<?php echo $_SESSION['unit_cost']; ?></span></td>
                              </tr>

                              <?php if ($_SESSION['charges'] != "") { ?>
                                <tr>
                                  <th>Charges (<?php echo $_SESSION['chargename']; ?>)</th>
                                  <td><span><?php echo $_SESSION['charges']; ?> %</span></td>
                                </tr>
                                <tr>
                                  <th>Charges</th>
                                  <td>+ <span>Rs.<?php echo round((int)$_SESSION['unit_cost'] / 100 * (int)$_SESSION['charges']); ?></span></td>
                                </tr>
                              <?php } ?>
                              <?php if ($_SESSION['discount'] != "") { ?>
                                <tr>
                                  <th><?php echo str_replace("_", " ", $_SESSION['discountname']); ?></th>
                                  <td><span>Rs.<?php echo  $_SESSION['discount']; ?></span>/<?php echo MeasurementUnit; ?></td>
                                </tr>
                                <tr>
                                  <th>Discount Amount</th>
                                  <td><span>- Rs.<?php echo  (int)$_SESSION['discount'] * (int)$_SESSION['unit_area']; ?></span></td>
                                </tr>
                              <?php } ?>
                              <tr>
                                <th>Amount Payable</th>
                                <td><span>Rs.<?php echo  (int)$_SESSION['net_payable_amount']; ?></span></td>
                              </tr>
                              <tr>
                                <th>Booking Amount</th>
                                <td><span id="paid_amount">Rs.0</span></td>
                              </tr>
                              <tr>
                                <th>Rest Amount</th>
                                <td class="text-success fs-16">Rs.<span id="amounttobepaid"><?php echo $_SESSION['net_payable_amount']; ?></span></span></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div class="col-md-6 text-right hidden">
                        <h4 class="text-left section-heading">MONTHLY EMI</h4>
                        <table class="table table-striped">
                          <tbody>
                            <tr>
                              <th>Total EMI</th>
                              <td><span id="emi">1</span> Month</td>
                            </tr>
                            <tr>
                              <th>EMI Start From</th>
                              <td><span id="emi_start">yyyy/mm/dd</span></td>
                            </tr>
                            <tr>
                              <th>Prefer Payment Date</th>
                              <td><span id="prefer_Date">1 day of Every Month</span></td>
                            </tr>
                            <tr>
                              <th>EMI Per Month</th>
                              <td class="text-primary fs-17"><span>Rs.<span id="amounttobepaid2"><?php echo $_SESSION['net_payable_amount']; ?></span></span></td>
                            </tr>
                            <tr>
                              <th>Last EMI Date</th>
                              <td><span id="emi_end">yyyy/mm/dd</span></td>
                            </tr>
                            <tr>
                              <td colspan="2">
                                <span><small>All Amounts are in round figure and rounded to nearest value.</small></span><br>
                                <label><span class="text-info" id="ifcheckisalloted" style="display:none;"></span></label>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>


                    <div class="row m-t-20">
                      <div class="col-md-12">
                        <h4 class="section-heading">Slip No & Remark</h4>
                      </div>
                      <div class="p-1">
                        <div class="from-group col-md-6">
                          <label>CRN NO </label>
                          <input type="text" name="slip_no" class="form-control" placeholder="">
                        </div>
                        <div class="from-group col-md-6">
                          <label>Ref No </label>
                          <input type="text" name="remark" class="form-control" placeholder="">
                        </div>
                      </div>
                    </div>

                    <br>
                    <div class="from-group col-md-12 text-center m-t-20">
                      <a href="../../project" class="btn btn-lg btn-default square"><i class="fa fa-angle-left"></i> Back to Plots</a>
                      <button class="btn btn-lg btn-primary square" type="submit" name="bookingcontinuetoagent">Continue <i class="fa fa-angle-right"></i></button>
                    </div>
                </div>
                </form>
              </div>
            </div>
          </div>

        </div>

        <!-- end -->
      </div>
      <!--===================================================-->
      <!--END CONTENT CONTAINER-->



      <!-- end -->
      <?php include '../../../sidebar.php'; ?>
      <?php include '../../../footer.php'; ?>
    </div>

    <?php include '../../../../include/footer_files.php'; ?>
    <script>
      function ReceiveBookingAmount() {
        var applicablereceivebookingamount = document.getElementById("applicablereceivebookingamount");
        var current_paying_amount = document.getElementById("current_paying_amount");
        var RealProjectAmount = <?php echo $_SESSION['net_payable_amount']; ?>;

        if (applicablereceivebookingamount.value == "manual") {
          document.getElementById("manual_receive").style.display = "block";
          current_paying_amount.value = 0;
        } else {
          document.getElementById("manual_receive").style.display = "none";
        }

        var receivingpercentage = +current_paying_amount / +RealProjectAmount * 100;
        document.getElementById("per_centage_receving").value = receivingpercentage;

        if (applicablereceivebookingamount.value == 0 || applicablereceivebookingamount.value == "manual") {
          current_paying_amount.value = 1;
        } else {
          var new_booking_amount = Math.round(+RealProjectAmount / 100 * +applicablereceivebookingamount.value);
          current_paying_amount.value = +new_booking_amount;
          document.getElementById("paid_amount").innerHTML = "Rs." + current_paying_amount.value;
          document.getElementById("amounttobepaid").innerHTML = +RealProjectAmount - +new_booking_amount;
          document.getElementById("amount_left").value = +RealProjectAmount - +new_booking_amount;
        }
      }

      function EmiStartDate() {
        var month2 = document.getElementById("emimonths").value;
        var emi_starts_from = document.getElementById("emi_starts_from").value;
        var prefer_emi_date = document.getElementById("prefer_emi_date").value;

        var startdate = new Date(emi_starts_from);
        var newemistartdate = new Date(startdate).toDateString();

        var newest = new Date(emi_starts_from);
        var emi_end_date = newest.setMonth(newest.getMonth() + +month2);
        var realemiend = new Date(emi_end_date).toDateString();

        document.getElementById("emi_end").innerHTML = realemiend;
        document.getElementById("emi_start").innerHTML = newemistartdate;
        document.getElementById("prefer_Date").innerHTML = prefer_emi_date + " day of Every Month";
        document.getElementById("lastdateofemisss").value = realemiend;
        document.getElementById("emi").innerHTML = month2;
      }
    </script>

    <script>
      function CalculateEmis() {
        var month2 = document.getElementById("emimonths").value;
        var emi_starts_froms = document.getElementById("emi_starts_from").value;
        var net_amount = document.getElementById("amount_left").value;

        newemipermonth = net_amount / month2;
        var newemipermonth = parseFloat(newemipermonth).toFixed(0);

        if (emi_starts_froms === "") {
          emi_starts_froms = new Date();
        }

        var newests = new Date(emi_starts_froms);

        var emi_end_dates = newests.setMonth(newests.getMonth() + +month2);
        var realemiends = new Date(emi_end_dates).toDateString();

        document.getElementById("emi_end").innerHTML = realemiends;
        document.getElementById("amounttobepaid2").innerHTML = newemipermonth + " / per month";
        document.getElementById("calculatedemi").value = newemipermonth;
        document.getElementById("lastdateofemisss").value = realemiends;
        document.getElementById("emi").innerHTML = month2;
      }
    </script>

    <script>
      document.getElementById("calculatedemi").value = document.getElementById("amount_left").value;
      document.getElementById("amounttobepaid2").innerHTML = document.getElementById("amount_left").value;
    </script>
    <script>
      function checkcheckstatus() {
        var checkstatus = document.getElementById("checkissustatus").value;
        var current_paying_amount = document.getElementById("current_paying_amount").value;
        var net_payable_amount = <?php echo $_SESSION['net_payable_amount']; ?>;
        if (checkstatus === "Issued") {
          document.getElementById("checkcleardate").style.display = "none";
          document.getElementById("ifcheckisalloted").innerHTML = "Check is Issued! Payment will be added after check is cleared!";
          document.getElementById("err").innerHTML = "";
          document.getElementById("amount_left").value = net_payable_amount;
          document.getElementById("paid_amount").innerHTML = "<b>- Rs." + current_paying_amount + "</b>";
          document.getElementById("amounttobepaid").innerHTML = net_payable_amount;
          document.getElementById("calculatedemi").value = net_payable_amount;
          document.getElementById("amounttobepaid2").innerHTML = net_payable_amount;
          document.getElementById("cashamount").value = +net_payable_amount - +current_paying_amount;
        } else {
          document.getElementById("checkcleardate").style.display = "block";
          document.getElementById("ifcheckisalloted").innerHTML = "Check is Cleared! So payment will be added and adjusted!";
          document.getElementById("err").innerHTML = "";
          document.getElementById("amount_left").value = +net_payable_amount - +current_paying_amount;
          document.getElementById("paid_amount").innerHTML = "<b>- Rs." + current_paying_amount + "</b>";
          document.getElementById("amounttobepaid").innerHTML = +net_payable_amount - +current_paying_amount;
          document.getElementById("amounttobepaid2").innerHTML = +net_payable_amount - +current_paying_amount;
          document.getElementById("calculatedemi").value = +net_payable_amount - +current_paying_amount;
          document.getElementById("cashamount").value = +net_payable_amount - +current_paying_amount;
        }
      }
    </script>
    <script>
      function CalculatePrice() {

        var current_paying_amount = document.getElementById("current_paying_amount").value;
        var net_payable_amount = <?php echo $_SESSION['net_payable_amount']; ?>;
        var checkstatus = document.getElementById("checkissustatus").value;

        var receivingpercentage = +current_paying_amount / +net_payable_amount * 100;

        if (current_paying_amount > net_payable_amount) {
          document.getElementById("err").innerHTML = "Booking Amount cannot be greater than Rs." + net_payable_amount;
        }

        if (current_paying_amount == 0) {
          document.getElementById("err").innerHTML = "Booking Amount cannot be zero!";
          document.getElementById("paid_amount").innerHTML = "";
          document.getElementById("amounttobepaid").innerHTML = +net_payable_amount;
          document.getElementById("amounttobepaid2").innerHTML = +net_payable_amount;
          document.getElementById("calculatedemi").value = net_payable_amount;
          document.getElementById("cashamount").value = current_paying_amount;
          document.getElementById("amount_left").value = +net_payable_amount - +current_paying_amount;
          document.getElementById("per_centage_receving").value = receivingpercentage;
        } else {
          if (checkstatus === "Issued") {

            document.getElementById("ifcheckisalloted").innerHTML = "Check is Issued! Payment will be observed after check clearing!";
            document.getElementById("err").innerHTML = "";
            document.getElementById("amount_left").value = net_payable_amount;
            document.getElementById("paid_amount").innerHTML = "<b>- Rs." + current_paying_amount + "</b>";
            document.getElementById("amounttobepaid").innerHTML = +net_payable_amount;
            document.getElementById("amounttobepaid2").innerHTML = +net_payable_amount;
            document.getElementById("calculatedemi").value = net_payable_amount;
            document.getElementById("cashamount").value = +net_payable_amount - +current_paying_amount;
            document.getElementById("per_centage_receving").value = receivingpercentage;
          } else {
            document.getElementById("ifcheckisalloted").innerHTML = "Check is Cleared!";
            document.getElementById("err").innerHTML = "";
            document.getElementById("amount_left").value = +net_payable_amount - +current_paying_amount;
            document.getElementById("paid_amount").innerHTML = "<b>- Rs." + current_paying_amount + "</b>";
            document.getElementById("amounttobepaid").innerHTML = +net_payable_amount - +current_paying_amount;
            document.getElementById("amounttobepaid2").innerHTML = +net_payable_amount - +current_paying_amount;
            document.getElementById("calculatedemi").value = +net_payable_amount - +current_paying_amount;
            document.getElementById("cashamount").value = +net_payable_amount - +current_paying_amount;
            document.getElementById("per_centage_receving").value = receivingpercentage;
          }
        }
      }
    </script>
    <script>
      function PaymentMode(data) {
        if (data == "cash") {
          document.getElementById("cash").style.display = "block";
          document.getElementById("check").style.display = "none";
          document.getElementById("banking").style.display = "none";
          document.getElementById("ifcheckisalloted").style.display = "none";
        } else if (data == "check") {
          document.getElementById("cash").style.display = "none";
          document.getElementById("check").style.display = "block";
          document.getElementById("banking").style.display = "none";
          document.getElementById("ifcheckisalloted").style.display = "block";
        } else if (data == "banking") {
          document.getElementById("cash").style.display = "none";
          document.getElementById("check").style.display = "none";
          document.getElementById("banking").style.display = "block";
          document.getElementById("ifcheckisalloted").style.display = "none";
        } else {
          document.getElementById("cash").style.display = "block";
          document.getElementById("check").style.display = "none";
          document.getElementById("banking").style.display = "none";
          document.getElementById("ifcheckisalloted").style.display = "none";
        }
      }
    </script>

    <script>
      var payment_mode = document.getElementsByName("payment_mode").value;
      if (payment_mode === "check") {
        document.getElementById("ifcheckisalloted").innerHTML = "Check is payment mode is selected";
      }
    </script>
</body>

</html>
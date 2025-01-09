<?php
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';


if (isset($_GET['bid'])) {
  $_SESSION['bid'] = $_GET['bid'];
  $bookingID = $_GET['bid'];
  $emi_id = $_GET['emi_id'];
  $_SESSION['emi_id'] = $_GET['emi_id'];
} else {
  $bookingID = $_SESSION['bid'];
  $emi_id = $_SESSION['emi_id'];
}
if (CHECK("SELECT * FROM bookings where bookingid='$bookingID'") == null) {
  LOCATION("warning", "No booking found!", DOMAIN . "/admin/booking");
} else {
  $SearchBookings = SELECT("SELECT * FROM bookings where bookingid='$bookingID'");
}


$FetchDetails = mysqli_fetch_array($SearchBookings);
$customer_id = $FetchDetails['customer_id'];
$CustomerId = $customer_id;
$Select_Users = "SELECT * FROM users where id='$customer_id'";
$Query = mysqli_query($DBConnection, $Select_Users);
$Customers = mysqli_fetch_assoc($Query);
$C_user_role_id = $Customers['user_role_id'];
$C_name = $Customers['name'];
$C_email = $Customers['email'];
$C_phone = $Customers['phone'];
$C_user_profile_img = $Customers['user_profile_img'];
$C_created_at = $Customers['created_at'];
$C_updated_at = $Customers['updated_at'];
$C_password = $Customers['password'];
$C_company_relation_id = $Customers['company_relation'];
if ($C_user_profile_img == null or $C_user_profile_img == "user.png") {
  $C_user_profile_img = DOMAIN . "/storage/sys-img/user.png";
} else {
  $C_user_profile_img = DOMAIN . "/storage/users/$CustomerId/img/$C_user_profile_img";
}

//customer address
//customer address
$C_FetchAddress = SELECT("SELECT * FROM user_address where user_id='$CustomerId'");
$C_IfExits = mysqli_num_rows($C_FetchAddress);
if ($C_IfExits == 0) {
  $C_user_street_address = "";
  $C_user_area_locality = "";
  $C_user_state = "";
  $C_user_city = "";
  $C_user_pincode = "";
  $C_created_at = "";
  $C_updated_at = "";
  $C_user_country = "";
} else {
  $C_fetchAdd = mysqli_fetch_array($C_FetchAddress);
  $C_user_street_address = htmlentities($C_fetchAdd['user_street_address']);
  $C_user_area_locality = $C_fetchAdd['user_area_locality'];
  $C_user_city = $C_fetchAdd['user_city'];
  $C_user_state = $C_fetchAdd['user_state'];
  $C_user_pincode = $C_fetchAdd['user_pincode'];
  $C_user_country = $C_fetchAdd['user_country'];
  $C_created_at = $C_fetchAdd['created_at'];
  $C_updated_at = $C_fetchAdd['updated_at'];
}
//customer type
$C_Select_UsersTypes = SELECT("SELECT * from user_roles where role_id='$C_user_role_id'");
$C_UserTypes = mysqli_fetch_assoc($C_Select_UsersTypes);
$C_role_name = $C_UserTypes['role_name'];

//verification textarea
$verification = rand(000000, 999999);

$GetBookings = SELECT("SELECT * FROM bookings where bookingid='$bookingID' ORDER BY bookingid DESC");
$Bookings = mysqli_fetch_array($GetBookings);
$bookingid = $Bookings['bookingid'];
$project_name = $Bookings['project_name'];
$project_area = $Bookings['project_area'];
$unit_name = strtoupper($Bookings['unit_name']);
$unit_area = $Bookings['unit_area'];
$unit_rate = $Bookings['unit_rate'];
$unit_cost = $Bookings['unit_cost'];
$net_payable_amount = $Bookings['net_payable_amount'];
$booking_date = $Bookings['booking_date'];
$clearing_date = $Bookings['clearing_date'];
$possession = $Bookings['possession'];
$chargename = $Bookings['chargename'];
$charges = $Bookings['charges'];
$discountname = $Bookings['discountname'];
$discount = $Bookings['discount'];
$created_at = $Bookings['created_at'];
$customer_id = $Bookings['customer_id'];
$matches = preg_replace('/[^0-9.]+/', '', $unit_area);
$unit_area_in_numbers = (int)$matches;
$possession_notes = SECURE($Bookings['possession_notes'], "d");
$possession_update_date = $Bookings['possession_update_date'];
$emi_months = $Bookings['emi_months'];
$emi_payable_amount = round((int)$net_payable_amount / (int)$emi_months);

$MainBookingID = "B$bookingid/" . date("m/Y", strtotime($created_at));

//total amount paid for thisbookings
$TotalAmountPaid = 0;
$SqlPayments = SELECT("SELECT * FROM payments where bookingid='$bookingID'");
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

//total amount paid for developmemnt charges previous
$TotalAmountPaid2 = SELECT("SELECT sum(devchargepaymentamount) FROM developmentchargepayments, developmentcharges where developmentcharges.bookingid='$bookingID' and developmentchargepayments.developmentchargeid=developmentcharges.devchargesid and developmentchargepayments.devpaymentstatus='RECEIVED' or developmentchargepayments.devpaymentstatus='PAID' or developmentchargepayments.devpaymentstatus='CLEAR'");
while ($fetchtotalpayment2 = mysqli_fetch_array($TotalAmountPaid2)) {
  $NetchargesPaid = $fetchtotalpayment2['sum(devchargepaymentamount)'];
}
if ($NetchargesPaid == null) {
  $NetchargesPaid = 0;
} else {
  $NetchargesPaid = $NetchargesPaid;
}

$totalpayment = FETCH("SELECT * FROM booking_pay_req where PayReqBookingId='$bookingid' and PayReqType='DEMAND' ORDER BY PaymentRequestId DESC", "PayRequestingAmount");
if ($totalpayment == null || $totalpayment == 0) {
  $totalpayment = $emi_payable_amount;
} else {
  $totalpayment = $totalpayment;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Receive Payments | <?php echo company_name; ?></title>
  <?php include '../../../include/header_files.php'; ?>
  <style>
    table tr th,
    td {
      padding: 2px 4px !important;
    }
  </style>
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
                      <h3 class="m-t-3"><i class="fa fa-calendar app-text"></i> Receive Payments</h3>
                    </div>
                    <div class="col-md-7 col-lg-7 col-12">
                      <div class="cust-details">
                        <div class="userWidget-1 m-b-2">
                          <div class="avatar app-bg">
                            <img src="<?php echo $C_user_profile_img; ?>" alt="avatar">
                            <div class="name osLight fs-20 p-b-2"> <?php echo $C_name ?> </div>
                            <a href="<?PHP echo DOMAIN; ?>/admin/customer/details/?id=<?php echo $customer_id; ?>" class="btn m-t-2 btn-sm btn-primary square float-right m-t-5">View Profile</a>
                          </div>
                          <div class="title text-uppercase"> <?php echo $C_role_name ?> </div>
                          <div class="address p-b-10 p-t-5">
                            <p class="text-grey fs-14 p-l-0 m-l-0">
                              <span><i class="fa fa-phone fs-14 text-info p-0"></i> : <?php echo $C_phone; ?></span> &nbsp; &nbsp;|
                              <span><i class="fa fa-envelope fs-14 text-danger p-0"></i> : <?php echo $C_email; ?></span><br>
                              <span><i class="fa fa-map-marker fs-14 text-success p-0"></i> : <?php echo "$C_user_street_address, $C_user_area_locality, $C_user_city $C_user_state - $C_user_country $C_user_pincode"; ?></span><br>
                            </p>
                          </div>
                          <div class="clearfix"> </div>
                        </div>
                      </div>
                      <h4 class="section-heading">Payment History</h4>
                      <table class="table table-striped p-1" style="font-size:11px !important;">
                        <tr>
                          <th>View</th>
                          <th>PayMode</th>
                          <th>CreatedAt</th>
                          <th>PaidDate</th>
                          <th>Amount</th>
                          <th>Status</th>
                          <th class="text-right">NetPaid</th>
                        </tr>
                        <?php
                        $TotalPaymentReceived = 0;
                        $SqlPayments = SELECT("SELECT * FROM payments where bookingid='$bookingID'");
                        while ($FetchPayments = mysqli_fetch_array($SqlPayments)) {
                          $TotalPaymentReceived = 0;
                          $payment_mode = $FetchPayments['payment_mode'];
                          $payment_id = $FetchPayments['payment_id'];
                          $payment_date_for_payment = $FetchPayments['payment_date'];

                          if ($payment_mode == "cash") {
                            $TotalPaymentReceived += $FetchPayments['net_paid'];
                            $paymentstatus = "Received";
                          } elseif (
                            $payment_mode == "banking"
                          ) {
                            $checkbankpayment = SELECT("SELECT * FROM online_payments where payment_id='$payment_id'");
                            $checkbankpaymentstatus = mysqli_fetch_assoc($checkbankpayment);
                            $paymentstatus = $checkbankpaymentstatus['transaction_status'];
                            if ($paymentstatus == "Success") {
                              $TotalPaymentReceived += $FetchPayments['net_paid'];
                            } else {
                              $TotalPaymentReceived += 0;
                            }
                          } elseif (
                            $payment_mode == "check"
                          ) {
                            $SqlChequepayments = SELECT("SELECT * FROM check_payments where payment_id='$payment_id'");
                            $FetchChequepayments = mysqli_fetch_assoc($SqlChequepayments);
                            $paymentstatus = $FetchChequepayments['checkstatus'];
                            if ($paymentstatus == "Clear") {
                              $TotalPaymentReceived += $FetchPayments['net_paid'];
                            } else {
                              $TotalPaymentReceived += 0;
                            }
                          }
                        ?>
                          <tr>
                            <td class="text-left" style="font-size:12px !important;">
                              <a href="<?php echo DOMAIN; ?>/admin/booking/receipt.php?id=<?php echo $bookingid; ?>&payment_id=<?php echo $payment_id; ?>" target="blank" class="text-info">
                                <i class='fa fa-print text-danger'></i> Receipts
                              </a>
                            </td>
                            <td class="text-left" style="text-align:left !important;font-size:12px !important;"><?php echo strtoupper($FetchPayments['payment_mode']); ?></td>
                            <td class="text-left" style="font-size:12px !important;"><?php echo DATE_FORMATE2("d M, Y h:i A", $FetchPayments['created_at']); ?></td>
                            <td class="text-left" style="font-size:12px !important;"><?php echo date("d M, Y", strtotime($payment_date_for_payment)); ?></td>
                            <td class="text-left" style="font-size:12px !important;"><span class="text-dark">Rs.<?php echo $FetchPayments['payment_amount']; ?></span></td>
                            <td class="text-left" style="font-size:12px !important;"><?php echo $paymentstatus; ?></td>
                            <td style="font-size:12px !important;" align="right"><span class="text-success">Rs.<?php echo $TotalPaymentReceived; ?></span></td>
                          </tr>
                        <?php } ?>
                        <tr>
                          <td colspan="7" align="right"><span class="text-primary"></span></td>
                        </tr>
                        <tr>
                          <td colspan="7" align="right"><span class="text-grey">Total Paid &nbsp;</span><span class="text-primary fs-16">Rs.<?php echo $PaymentforProjects; ?></span></td>
                        </tr>
                        <?php
                        $CheckSqlForReSale = CHECK("SELECT * FROM booking_resales where booking_main_id='$bookingid' and booking_resale_type='TRANSFER'");
                        if ($CheckSqlForReSale != null) {
                          $PreviousBookingId = FETCH("SELECT * FROM bookings where bookingid!='$bookingid' ORDER BY bookingid DESC limit 1", "bookingid");
                          $PreviousPayment = GetNetPaidAmount($PreviousBookingId);
                        } else {
                          $PreviousPayment = 0;
                        }
                        if ($PreviousPayment != 0) {
                        ?>
                          <tr>
                            <td colspan="7" align="right"><span class="text-grey">Previously Paid &nbsp;</span>
                              <span class="text-dark fs-16">Rs.<?php echo  $PreviousPayment; ?></span>
                            </td>
                          </tr>
                        <?php
                        }
                        ?>
                        <tr>
                          <td colspan="7" align="right"><span class="text-grey">Net Payable &nbsp;</span><span class="text-dark fs-16">Rs.<?php echo $net_payable_amount - $PreviousPayment; ?></span></td>
                        </tr>
                        <tr>
                          <td align="right"></td>
                          <td colspan="6" align="right"><span class="text-grey">Balance &nbsp;</span><span class="text-danger fs-15">Rs.<?php echo $net_payable_amount - $PaymentforProjects - $PreviousPayment; ?></span></td>
                        </tr>

                      </table>
                      <h4 class="section-heading">Booking Details</h4>
                      <table class="table table-striped">
                        <tr>
                          <th>Booking ID</th>
                          <td><span class="text-info text-decoration-underline"><?php echo $MainBookingID; ?></span></td>
                        </tr>
                        <tr>
                          <th>Project Name</th>
                          <td><?php echo $project_name; ?></td>
                        </tr>
                        <tr>
                          <th>Project Area</th>
                          <td><?php echo $project_area; ?></td>
                        </tr>
                        <tr>
                          <th>Unit No:</th>
                          <td><?php echo $unit_name; ?></td>
                        </tr>
                        <tr>
                          <th>Unit Area</th>
                          <td><?php echo $unit_area; ?></td>
                        </tr>
                        <tr>
                          <th>Unit Rate</th>
                          <td>Rs.<?php echo $unit_rate; ?> / sq area</td>
                        </tr>
                        <tr>
                          <th>Unit Cost</th>
                          <td><span>Rs.<?php echo $unit_cost; ?></span></td>
                        </tr>
                        <?php if ($charges != 0) { ?>
                          <tr>
                            <th>Charges <span class="text-grey fs-11 m-l-5"><?php echo $chargename; ?> ( <?php echo $charges; ?>% )</span></th>
                            <td>+ Rs.<?php echo $unit_cost / 100 * $charges; ?></td>
                          </tr>
                        <?php } ?>
                        <?php if ($discount != 0) { ?>
                          <tr>
                            <th>Discount <span class="text-grey fs-11 m-l-5"><?php echo $discountname; ?> ( Rs.<?php echo $discount;  ?> )</span></th>
                            <td>- Rs.<?php echo $unit_area_in_numbers * $discount; ?></td>
                          </tr>
                        <?php } ?>
                        <tr>
                          <th>Net Payable Amount</th>
                          <td><span class="text-success fs-14">Rs.<?php echo $net_payable_amount; ?></span></td>
                        </tr>
                        <tr>
                          <th>Booking Date</th>
                          <td><?php echo DATE_FORMATE2("d M, Y", $booking_date); ?></td>
                        </tr>
                        <tr>
                          <th>Booking Created at</th>
                          <td><?php echo DATE_FORMATE2("d M, Y", $created_at); ?></td>
                        </tr>
                        <tr>
                          <th>Clearing Date</th>
                          <td><?php echo DATE_FORMATE2("d M, Y", $clearing_date); ?></td>
                        </tr>
                      </table>

                    </div>
                    <div class="col-md-5 col-lg-5 col-12">
                      <form action="../../../controller/paymentcontroller.php" method="POST" class="fs-13">
                        <?php FormPrimaryInputs(true, [
                          "project_measure_unit" => MeasurementUnit
                        ]) ?>
                        <div class="payment-section">
                          <div class="row">
                            <h4 class="section-heading m-t-0">Select Payment Mode</h4>
                            <div class="col-md-12">
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
                            <div class="col-md-12 col-12" style="display:none;" id="check">
                              <div class="row">
                                <div class="col-md-12">
                                  <h4>Cheque/DD Payment</h4>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                  <div class="form-group">
                                    <label>Issue to</label>
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
                                    <input type="date" value="<?php echo date('Y-m-d'); ?>" name="checkissuedate" class="form-control">
                                  </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                  <div class="form-group">
                                    <label>Cheque Status</label>
                                    <select class="form-control" name="checkstatus" id="checkissustatus" onchange="checkcheckstatuscheck()">
                                      <option value="Issued" selected>Select Cheque Status</option>
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

                            </div>

                            <div class="col-md-12 col-12" style="display:none;" id="banking">
                              <div class="row">
                                <div class="col-md-12">
                                  <h4>Online Banking</h4>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                  <div class="form-group">
                                    <label>Online Payment Type</label>
                                    <select name="onlinepaymenttype" class="form-control">
                                      <option value="NetBanking" selected>Net Banking</option>
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
                                      <option value="Success">Success</option>
                                      <option value="Pending" selected>Pending</option>
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
                                    <input type="date" name="transactiondate" value="<?php echo date('Y-m-d'); ?>" class="form-control">
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="col-md-12 col-12" id="cash">
                              <div class="row">
                                <div class="col-md-12">
                                  <h4>Cash Payment</h4>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                  <div class="form-group">
                                    <label>Cash Received By</label>
                                    <input type="text" name="cashreceivername" value="<?php echo LOGIN_UserFullName; ?> @ <?php echo LOGIN_UserId; ?>" class="form-control">
                                  </div>
                                </div>
                                <input type="text" hidden="" name="cashamount" id="cashamount">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                  <div class="form-group">
                                    <label>Cash Received date</label>
                                    <input type="date" name="cashreceivedate" value="<?php echo date('Y-m-d'); ?>" class="form-control">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <h4 class="section-heading">Enter Payable Amount</h4>
                          <div class="form-group col-12 col-md-6">
                            <label>BookingID</label>
                            <select name="bookingid" class="form-control" readonly="">
                              <?php
                              $FetchPROJECT_TYPE = SELECT("SELECT * from bookings where bookingid='$bookingID'");
                              while ($FetchPROJECTST = mysqli_fetch_array($FetchPROJECT_TYPE)) {
                                $bookingid = $FetchPROJECTST['bookingid'];
                                $booking_date = date("m/Y", strtotime($FetchPROJECTST['booking_date'])); ?>
                                <option value="<?php echo $bookingid; ?>" selected="">B<?php echo $bookingid; ?>/<?php echo $booking_date; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="form-group col-12 col-md-6 p-r-0 p-l-0">
                            <label>Payment Amount</label>
                            <input type="text" name="NetPayableEmiAmount" id="netpayableemiamount" value="<?php echo $totalpayment; ?>" hidden="">
                            <input type="text" name="payment_amount" oninput="getpaidamount()" value="<?php echo $totalpayment; ?>" id="paidamount" class="form-control" placeholder="" required="">
                          </div>
                          <div class="col-md-12 text-right p-l-0 p-r-0">
                            <table class="table table-striped p-l-0 p-r-0">
                              <tr>
                                <td>
                                  <span class="fs-17" class="text-primary">Amount Paying : Rs.<span id="p_amount"><?php echo $totalpayment; ?></span></span>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <span class="fs-17" id="chargeshow" style="display:none;"></span>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <span class="fs-17" id="discountshow" style="display:none;"></span>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <span class="fs-18"><b>Net Paybale :</b><span class="text-success"> Rs.<span id="netpaidamount" class="text-success"></span></span></span>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <span class="fs-17" id="checkcstatus" style="display:none;"></span>
                                </td>
                              </tr>
                            </table>
                          </div>
                          <div class="col-md-12 text-center" id="emi_payment_alert" style="display:none;">
                            <span id="" class="bg-danger p-2 br20"><i class="fa fa-warning"></i> Payment Amount cannot be greater then Total EMI Amount</span>
                          </div>
                          <div class="col-md-12 m-b-20">
                            <a class="btn btn-md btn-primary" onclick="Databar('chargesaddareas', 'btncharges', 'RemoveCharges', 'Add Charges', 'Remove Charges')" id="btncharges"><span id="RemoveCharges"><i class="fa fa-plus"></i> Add Late Fees & Discount</span></a>
                            <a class="btn btn-md btn-primary" onclick="Databar('notesarea', 'notesection', 'hidenotes', 'Add Remarks', 'Remove Notes')" id="notesection"><span id="hidenotes"><i class="fa fa-plus"></i> Add Remarks</span></a>
                          </div>
                          <div class="row m-t-20" style="display:none;" id="chargesaddareas">
                            <div class="col-md-12">
                              <h4 class="section-heading">Discount & Charges</h4>
                            </div>
                            <div class="from-group col-md-12">
                              <div class="row">
                                <div class="col-md-8 col-12">
                                  <label>Charge name</label>
                                  <input type="text" name="chargename" oninput="chargesCalcu()" id="chargename" value="" class="form-control" placeholder="">
                                </div>
                                <div class="col-md-4 col-12">
                                  <label>Charges in Amount</label>
                                  <input type="text" name="charges" oninput="chargesCalcu()" id="chargevalue" class="form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="from-group col-md-12">
                              <div class="row">
                                <div class="col-md-8 col-12">
                                  <label>Discount name</label>
                                  <input type="text" name="discountname" oninput="chargesCalcu()" id="discountname" value="" class="form-control" placeholder="">
                                </div>
                                <div class="col-md-4 col-12">
                                  <label>Discount in Amount</label>
                                  <input type="text" name="discount" oninput="chargesCalcu()" id="discountvalue" class="form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row" id="notesarea" style="display:none;">
                            <div class="col-md-12">
                              <h4 class="section-heading">Tally No & Remark</h4>
                            </div>
                            <div class="p-1">
                              <div class="from-group col-md-6">
                                <label>Tally No </label>
                                <input type="text" name="slip_no" class="form-control" placeholder="TALLY/###">
                              </div>
                              <div class="from-group col-md-6">
                                <label>Remarks/Note </label>
                                <input type="text" name="remark" class="form-control" placeholder="">
                              </div>
                            </div>
                          </div>
                          <input type="text" name="net_paid" id="net_payable" value="<?php echo $totalpayment; ?>" hidden="">
                          <div class="row">
                            <div class="col-md-12 m-t-30">
                              <a data-toggle="modal" id="continuebutton" onmouseover="GetDetails()" data-target="#confirm_payment" class="btn btn-success btn-block p-3">Receive Payments</a>
                            </div>
                          </div>
                          <!--END CONTENT CONTAINER-->
                          <!-- Modal  3-->
                          <div class="modal fade square" id="confirm_payment" role="dialog">
                            <div class="modal-dialog modal-md">
                              <div class="modal-content">
                                <div class="modal-header app-bg text-white">
                                  <button type="button" class="close text-white m-r-8 m-t-1" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title text-white">Confirm Payment</h4>
                                </div>
                                <div class="modal-body overflow-auto">
                                  <div clas="row">
                                    <div class="col-md-12">
                                      <div class="cust-details">
                                        <div class="userWidget-1">
                                          <div class="avatar app-bg">
                                            <img src="<?php echo $C_user_profile_img; ?>" alt="avatar">
                                            <div class="name osLight fs-20 p-b-2"> <?php echo $C_name ?> </div>
                                          </div>
                                          <div class="title text-uppercase"> <?php echo $C_role_name ?> </div>
                                          <div class="address p-b-10 p-t-5">
                                            <p class="text-grey fs-14 p-l-0 m-l-0">
                                              <span><i class="fa fa-phone fs-14 text-info p-0"></i> : <?php echo $C_phone; ?></span> &nbsp; &nbsp;|
                                              <span><i class="fa fa-envelope fs-14 text-danger p-0"></i> : <?php echo $C_email; ?></span><br>
                                              <span><i class="fa fa-map-marker fs-14 text-success p-0"></i> : <?php echo "$C_user_street_address, $C_user_area_locality, $C_user_city $C_user_state - $C_user_country $C_user_pincode"; ?></span><br>
                                            </p>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <h4 class="section-heading">Booking Details</h4>
                                      <table class="table table-striped">
                                        <?php

                                        $GetBookings = SELECT("SELECT * FROM bookings where bookingid='$bookingid' ORDER BY bookingid DESC");
                                        if ($GetBookings == false) {
                                          echo "<h3 class='text-danger'>No Bookings Found!</h3>";
                                        }
                                        while ($Bookings = mysqli_fetch_array($GetBookings)) {
                                          $bookingid = $Bookings['bookingid'];
                                          $project_name = $Bookings['project_name'];
                                          $project_area = $Bookings['project_area'];
                                          $unit_name = strtoupper($Bookings['unit_name']);
                                          $unit_area = $Bookings['unit_area'];
                                          $unit_rate = $Bookings['unit_rate'];
                                          $unit_cost = $Bookings['unit_cost'];
                                          $net_payable_amount = $Bookings['net_payable_amount'];
                                          $booking_date = $Bookings['booking_date'];
                                          $clearing_date = $Bookings['clearing_date'];
                                          $possession = $Bookings['possession'];
                                          $chargename = $Bookings['chargename'];
                                          $charges = $Bookings['charges'];
                                          $discountname = $Bookings['discountname'];
                                          $discount = $Bookings['discount'];
                                          $created_at = $Bookings['created_at'];
                                          $customer_id = $Bookings['customer_id'];
                                          $matches = preg_replace('/[^0-9.]+/', '', $unit_area);
                                          $unit_area_in_numbers = (int)$matches;
                                          $possession_notes = SECURE($Bookings['possession_notes'], "d");
                                          $possession_update_date = $Bookings['possession_update_date'];
                                          $emi_months = $Bookings['emi_months'];
                                          $MainBookingID = "B$bookingid/" . date("m/Y", strtotime($created_at));
                                          $emi_id = FETCH("SELECT * FROM booking_emis where booking_id='$bookingid'", "emi_id");
                                        ?>
                                          <tr>
                                            <th>Booking ID</th>
                                            <td><span class="text-info text-decoration-underline"><?php echo $MainBookingID; ?></span></td>
                                          </tr>
                                          <tr>
                                            <th>Plot Name</th>
                                            <td><?php echo $unit_name; ?> @ <?php echo $project_name; ?></td>
                                          </tr>
                                          <tr>
                                            <th>Plot Area</th>
                                            <td><?php echo $unit_area; ?></td>
                                          </tr>
                                          <tr>
                                            <th>Purchase Amount</th>
                                            <td><span class="text-success fs-14">Rs.<?php echo $net_payable_amount; ?></span></td>
                                          </tr>
                                        <?php } ?>
                                      </table>
                                    </div>
                                    <div class="col-md-6">
                                      <h4 class="section-heading">Payment Details</h4>
                                      <table class="table table-striped">
                                        <tr>
                                          <th>Payment Mode</th>
                                          <td>
                                            <span id="pmode">Cash Payment</span>
                                          </td>
                                        </tr>
                                        <tr>
                                          <th>Paying Amount</th>
                                          <td>
                                            <span class="text-success">Rs.<span id="r_amount"></span></span>
                                          </td>
                                        </tr>
                                      </table>
                                    </div>
                                    <div class="col-md-12">
                                      <h2 class="text-center"><span class="verification"><?php echo $verification; ?></span></h2>
                                      <div class="form-group">
                                        <label class="text-center m-t-10">Type Above Text below <span id="vstatus"></span></label>
                                        <input type="text" name="" id="v_date" oninput="verifications()" class="form-control text-center" placeholder="">
                                      </div>

                                    </div>
                                  </div>
                                </div>

                                <div class="modal-footer">
                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                  <button type="button" name="create_payment" style="display:none;" onclick="actionBtn('emibtn', 'Receiving Payment')" id="emibtn" class="btn btn-success">Confirm & Receive Payment</button>
                                </div>
                              </div>
                            </div>
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
    <script>
      function checkcheckstatuscheck() {
        var current_paying_amount = document.getElementById("netpayableemiamount").value;
        var net_payable_amount = <?php echo $net_payable_amount; ?>;
        if (document.getElementById("checkissustatus").value == "Clear") {
          document.getElementById("checkcleardate").style.display = "block";
          document.getElementById("ifcheckisalloted").innerHTML = "Check is Cleared! So payment will be added and adjusted!";
          document.getElementById("err").innerHTML = "";
          document.getElementById("amount_left").value = +net_payable_amount - +current_paying_amount;
          document.getElementById("paid_amount").innerHTML = "<b>- Rs." + current_paying_amount + "</b>";
          document.getElementById("amounttobepaid").innerHTML = +net_payable_amount - +current_paying_amount;
          document.getElementById("amounttobepaid2").innerHTML = +net_payable_amount - +current_paying_amount;
          document.getElementById("calculatedemi").value = +net_payable_amount - +current_paying_amount;
          document.getElementById("cashamount").value = +net_payable_amount - +current_paying_amount;
          document.getElementById("p_amount").innerHTML = net_payable_amount;
        } else {
          document.getElementById("checkcleardate").style.display = "none";
          document.getElementById("ifcheckisalloted").innerHTML = "Check is Issued! Payment will be added after check is cleared!";
          document.getElementById("err").innerHTML = "";
          document.getElementById("amount_left").value = net_payable_amount;
          document.getElementById("paid_amount").innerHTML = "<b>- Rs." + current_paying_amount + "</b>";
          document.getElementById("amounttobepaid").innerHTML = net_payable_amount;
          document.getElementById("calculatedemi").value = net_payable_amount;
          document.getElementById("amounttobepaid2").innerHTML = net_payable_amount;
          document.getElementById("cashamount").value = +net_payable_amount - +current_paying_amount;
          document.getElementById("p_amount").innerHTML = net_payable_amount;
        }
      }
    </script>

    <!-- end -->
    <?php include '../../sidebar.php'; ?>
    <?php include '../../footer.php'; ?>
  </div>
  <script>
    function verifications() {
      var v_date = document.getElementById("v_date");
      if (v_date.value == <?php echo $verification; ?>) {
        document.getElementById("vstatus").innerHTML = "Payment Receiving Confimed!";
        document.getElementById("vstatus").classList.add("text-success");
        document.getElementById("vstatus").classList.remove("text-danger");
        document.getElementById("emibtn").style.display = "";
        document.getElementById("emibtn").type = "submit";
      } else {
        document.getElementById("vstatus").innerHTML = "";
        document.getElementById("vstatus").classList.add("text-danger");
        document.getElementById("vstatus").classList.remove("text-success");
        document.getElementById("emibtn").style.display = "none";
        document.getElementById("emibtn").type = "";
      }
    }
  </script>
  <script>
    function GetDetails() {
      document.getElementById("r_amount").innerHTML = document.getElementById("paidamount").value;
    }
  </script>
  <script>
    document.getElementById("netpaidamount").innerHTML = document.getElementById("paidamount").value;
    document.getElementById("cashamount").value = document.getElementById("paidamount").value;
  </script>
  <script>
    function PaymentMode(data) {
      if (data == "cash") {
        document.getElementById("cash").style.display = "block";
        document.getElementById("check").style.display = "none";
        document.getElementById("banking").style.display = "none";
        document.getElementById("pmode").innerHTML = "Cash Payment";
      } else if (data == "check") {
        document.getElementById("cash").style.display = "none";
        document.getElementById("check").style.display = "block";
        document.getElementById("banking").style.display = "none";
        document.getElementById("pmode").innerHTML = "Cheque Payment";
      } else if (data == "banking") {
        document.getElementById("cash").style.display = "none";
        document.getElementById("check").style.display = "none";
        document.getElementById("banking").style.display = "block";
        document.getElementById("pmode").innerHTML = "Online Payment";
      } else {
        document.getElementById("cash").style.display = "block";
        document.getElementById("check").style.display = "none";
        document.getElementById("banking").style.display = "none";
        document.getElementById("pmode").innerHTML = "Cash Payment";
      }
    }
  </script>
  <script>
    function getpaidamount() {
      document.getElementById("cashamount").value = document.getElementById("paidamount").value;
      document.getElementById("netpaidamount").innerHTML = document.getElementById("paidamount").value;
      document.getElementById("net_payable").value = document.getElementById("paidamount").value;
      document.getElementById("p_amount").innerHTML = document.getElementById("paidamount").value;
      var payingamount = document.getElementById("paidamount");
      var netrequireamount = <?php echo $totalpayment; ?>;
      if (payingamount.value <= netrequireamount) {
        document.getElementById("emi_payment_alert").style.display = "none";
        document.getElementById("continuebutton").style.display = "block";
      } else {
        document.getElementById("emi_payment_alert").style.display = "none";
        document.getElementById("continuebutton").style.display = "block";
      }
    }
  </script>
  <script>
    function chargesCalcu() {
      var chargevalue = document.getElementById("chargevalue").value;
      var chargeshow = document.getElementById("chargeshow");
      var net_payable = document.getElementById("net_payable").value;
      var unit_cost = document.getElementById("paidamount").value;
      var chargename = document.getElementById("chargename").value;
      var discountvalue = document.getElementById("discountvalue").value;
      var discountshow = document.getElementById("discountshow");
      var discountname = document.getElementById("discountname").value;

      if (chargevalue > 0 || discountvalue > 0) {
        chargeshow.style.display = "block";

        if (discountvalue > 0) {


          document.getElementById("checkcstatus").innerHTML = "Amount is Added in the System!";
          discountshow.style.display = "block";
          discountamount = discountvalue;
          discountableamount = +unit_cost - +discountvalue;
          discountshow.innerHTML = discountname + " : <b> - Rs." + discountamount + "</b>";
          discountname.value = discountname;
          chargeableamount = chargevalue;
          new_net_payable = (+unit_cost + +chargeableamount) - +discountamount;

          document.getElementById("net_payable").value = new_net_payable;
          chargeshow.innerHTML = chargename + " : <b> + Rs." + chargeableamount + "</b>";

          document.getElementById("netpaidamount").innerHTML = new_net_payable;
          document.getElementById("paidamount").innerHTML = unit_cost;
          chargename.value = chargename;
          document.getElementById("p_amount").innerHTML = new_net_payable;

        } else {
          discountshow.style.display = "none";
          discountableamount = 0;
          chargename.value = "";
          discountname.value = "";
          chargeableamount = chargevalue;
          new_net_payable = +unit_cost + +chargeableamount;

          document.getElementById("net_payable").value = new_net_payable;
          chargeshow.innerHTML = chargename + " : <b> + Rs." + chargeableamount + "</b>";

          document.getElementById("netpaidamount").innerHTML = new_net_payable;
          document.getElementById("paidamount").innerHTML = unit_cost;
          chargename.value = chargename;
          document.getElementById("p_amount").innerHTML = new_net_payable;

        }

      } else {
        chargeshow.style.display = "none";
        discountshow.style.display = "none";

        document.getElementById("net_payable").value = unit_cost;
        document.getElementById("netpaidamount").innerHTML = unit_cost;
        document.getElementById("paidamount").innerHTML = unit_cost;
        chargename.value = "";
        discountname.value = "";
      }

      if (discountvalue > 0) {
        discountshow.style.display = "block";
      } else if (discountvalue == 0) {
        discountshow.style.display = "none";
      } else {
        discountshow.style.display = "none";
      }

      if (chargevalue > 0) {
        chargeshow.style.display = "block";
      } else if (chargevalue == 0) {
        chargeshow.style.display = "none";
      } else {
        chargeshow.style.display = "none";
      }
    }
  </script>
  <script type="text/javascript">
    function selects() {
      var ele = document.getElementsByName('emi_list_id');
      for (var i = 0; i < ele.length; i++) {
        if (ele[i].type == 'checkbox')
          ele[i].checked = true;
      }
    }
  </script>

  <?php include '../../../include/footer_files.php'; ?>
</body>

</html>
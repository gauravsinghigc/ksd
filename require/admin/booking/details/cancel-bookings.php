<?php
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';

ini_set("display_errors", 1);
if (isset($_GET['id'])) {
  $BookingViewId = $_GET['id'];
  $_SESSION['BOOKING_VIEW_ID'] = $_GET['id'];
} else {
  $BookingViewId = $_SESSION['BOOKING_VIEW_ID'];
}

$GetBookings = SELECT("SELECT * FROM bookings where bookingid='$BookingViewId' ORDER BY bookingid DESC");
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
$emi_last_date = date("d M, Y", strtotime($Bookings['booking_date'], strtotime("+$emi_months months")));

//customer DETAILS
$getusers = SELECT("SELECT * FROM users, user_address, user_roles where users.company_relation='" . company_id . "' and users.id='$customer_id' and users.user_role_id='4' and users.id=user_address.user_id and users.user_role_id=user_roles.role_id");
$count = 0;
$customers = mysqli_fetch_array($getusers);
$count++;
$customer_name = $customers['name'];
$customer_phone = $customers['phone'];
$customer_email = $customers['email'];
$user_street_address = $customers['user_street_address'];
$user_area_locality = $customers['user_area_locality'];
$user_city = $customers['user_city'];
$user_state = $customers['user_state'];
$user_pincode = $customers['user_pincode'];
$user_country = $customers['user_country'];
$executedcustomer_id = $customers['user_id'];
$customer_user_profile_img = $customers['user_profile_img'];
$user_status = $customers['user_status'];
$created_at_c = $customers['created_at'];
$user_role_id = $customers['user_role_id'];
$user_role_name = $customers['role_name'];
$agent_relation = $customers['agent_relation'];
if ($user_status == "ACTIVE") {
  $user_status_view = "<span class='text-success'><i class='fa fa-check-circle'></i> Active</span>";
} else {
  $user_status_view = "<span class='text-danger'><i class='fa fa-warning'></i> Inactive</span>";
}
if ($customer_user_profile_img == "user.png") {
  $customer_user_profile_img = DOMAIN . "/storage/sys-img/$customer_user_profile_img";
} else {
  $customer_user_profile_img = DOMAIN . "/storage/users/$executedcustomer_id/img/$customer_user_profile_img";
}

//agent details
$getusers_a = SELECT("SELECT * FROM users, user_address, user_roles where users.company_relation='" . company_id . "' and users.id='$agent_relation' and users.id=user_address.user_id and users.user_role_id=user_roles.role_id");
$count = 0;
$agents = mysqli_fetch_array($getusers_a);
$count++;
$customer_id_a = $agents['id'];
$customer_name_a = $agents['name'];
$customer_phone_a = $agents['phone'];
$customer_email_a = $agents['email'];
$user_street_address_a = $agents['user_street_address'];
$user_area_locality_a = $agents['user_area_locality'];
$user_city_a = $agents['user_city'];
$user_state_a = $agents['user_state'];
$user_pincode_a = $agents['user_pincode'];
$user_country_a = $agents['user_country'];
$executedcustomer_id_a = $agents['user_id'];
$customer_user_profile_img_a = $agents['user_profile_img'];
$user_status_a = $agents['user_status'];
$created_at_a = $agents['created_at'];
$user_role_id_a = $agents['user_role_id'];
$user_role_name_a = $agents['role_name'];
if ($user_status_a == "ACTIVE") {
  $user_status_viea_a = "<span class='text-success'><i class='fa fa-check-circle'></i> Active</span>";
} else {
  $user_status_view_a = "<span class='text-danger'><i class='fa fa-warning'></i> Inactive</span>";
}
if ($customer_user_profile_img_a == "user.png") {
  $customer_user_profile_img_a = DOMAIN . "/storage/sys-img/$customer_user_profile_img_a";
} else {
  $customer_user_profile_img_a = DOMAIN . "/storage/users/$customer_id_a/img/$customer_user_profile_img_a";
}

//last payment
$GetPAYMENTS = CHECK("SELECT * FROM payments where bookingid='$bookingid' ORDER BY payment_id  DESC");
if ($GetPAYMENTS == true) {
  $GetPAYMENTS = SELECT("SELECT * FROM payments where bookingid='$bookingid' ORDER BY payment_id  DESC");
  $payments = mysqli_fetch_array($GetPAYMENTS);
  $payment_amount = $payments['payment_amount'];
  $payment_mode = $payments['payment_mode'];
  $slip_no = $payments['slip_no'];
  $remark = $payments['remark'];
  $payment_date = $payments['payment_date'];
  $paymentcreatedat = $payments['created_at'];
} else {
  $payment_amount = "";
  $payment_mode = "";
  $slip_no = "";
  $remark = "";
  $payment_date = "";
  $paymentcreatedat = "";
}

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

//total amount paid for developmemnt charges previous
$TotalAmountPaid2 = SELECT("SELECT sum(devchargepaymentamount) FROM developmentchargepayments, developmentcharges where developmentcharges.bookingid='$BookingViewId' and developmentchargepayments.developmentchargeid=developmentcharges.devchargesid and developmentchargepayments.devpaymentstatus='RECEIVED' or developmentchargepayments.devpaymentstatus='PAID' or developmentchargepayments.devpaymentstatus='CLEAR'");
while ($fetchtotalpayment2 = mysqli_fetch_array($TotalAmountPaid2)) {
  $NetchargesPaid = $fetchtotalpayment2['sum(devchargepaymentamount)'];
}
if ($NetchargesPaid == null) {
  $NetchargesPaid = 0;
} else {
  $NetchargesPaid = $NetchargesPaid;
}

//emiavriabel
$emi_id = FETCH("SELECT * FROM booking_emis where booking_id='$bookingid'", "emi_id");

//Booking id
$MainBookingID = "B$bookingid/" . date("m/Y", strtotime($created_at));
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?PHP echo $MainBookingID; ?> | <?php echo company_name; ?></title>
  <?php include '../../../include/header_files.php'; ?>
  <style>
    td {
      text-align: right !important;
      font-size: 1rem !important;
    }

    table tr.striped td {
      font-size: 1rem !important;
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
                      <h3 class="m-t-3"><i class="fa fa-times app-text"></i> Cancel Bookings : <?php echo $MainBookingID; ?></h3>
                      <a href="index.php" class="btn btn-md btn-default"><i class="fa fa-angle-left"></i> Back to Booking Dashboard</a>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-7">
                      <h4 class="section-heading">Cancel Booking Details</h4>
                      <?php
                      $CheckBookingCancel = CHECK("SELECT * FROM booking_cancelled where BookingCancelledBookingId='$bookingid'");
                      if ($CheckBookingCancel == false) { ?>
                        <form action="<?php echo CONTROLLER; ?>/bookingcontroller.php" method="POST">
                          <?php FormPrimaryInputs(true, [
                            "BookingCancelledBookingId" => $bookingid
                          ]); ?>
                          <div class="row">
                            <div class="col-md-12">
                              <h4 class="app-sub-heading">Cancel Details</h4>
                            </div>
                            <div class="col-md-5 form-group">
                              <label>Cancel date</label>
                              <input type="date" name="BookingCancelledDate" class="form-control" value="<?php echo date("Y-m-d"); ?>" required>
                            </div>
                            <div class="col-md-12 form-group">
                              <label>Cancel Reason/Details</label>
                              <textarea class="form-control" name="BookingCancelledReason" rows="3"></textarea>
                            </div>
                            <div class="col-md-12">
                              <h4 class="app-sub-heading">Refund Details</h4>
                            </div>
                            <div class="col-md-8 form-group">
                              <label>Refund Reason</label>
                              <input type="text" name="BookingRefundReason" class="form-control" required="">
                            </div>
                            <div class="col-md-5 form-group">
                              <label>Refund Date</label>
                              <input type="date" value="<?php echo date("Y-m-d"); ?>" class="form-control" name="BookingRefundDate" value="">
                            </div>
                            <div class="col-md-7 form-group">
                              <label>Refunded to / Person name</label>
                              <input type="text" name="BookingRefundTo" class="form-control" required="">
                            </div>
                            <div class="col-md-4 form-group">
                              <label>Refund Mode</label>
                              <select class="form-control" name="BookingRefundMode" required="">
                                <?php InputOptions(["Cash", "Online/NetBanking", "UPI App", "Cheque/DD"]); ?>
                              </select>
                            </div>
                            <div class="col-md-4 form-group">
                              <label for="">Refund Status</label>
                              <select class="form-control" name="BookingRefundStatus" required="">
                                <?php InputOptions(["Paid" => "Paid", "Pending" => "Pending"], "Pending"); ?>
                              </select>
                            </div>
                            <div class="col-md-4 form-group">
                              <label>Refund Amount</label>
                              <input type="text" value="<?php echo $TotalAmountPaid; ?>" name="BookingRefundAmount" class="form-control" required="">
                            </div>
                            <div class="col-md-12 form-group">
                              <label>Refund Transfer/Cheque/Online/NetBanking Details</label>
                              <textarea class="form-control" name="BookingRefundDetails" rows="4" required=""></textarea>
                            </div>

                            <div class="col-md-12">
                              <button class="btn btn-md btn-danger" name="CreateBookingCancellRequests" value="<?php echo SECURE($bookingid, "e"); ?>">Cancel Booking</button>
                              <a href="index.php" class="btn btn-md btn-default">Back to Booking Dashboard</a>
                            </div>
                          </div>
                        </form>
                      <?php } else { ?>
                        <div class="row">
                          <div class="col-md-12">
                            <h4 class="text-danger"><i class="fa fa-check-circle"></i> This Booking ID <b><?php echo $MainBookingID; ?></b> is Cancelled!</h4>
                            <p>This booking id is Cancelled!</p>
                            <hr>
                            <a href="index.php" class="btn btn-md btn-default">View Booking Dashboard!</a>
                            <a target="_blank" href="../refund-receipt.php?id=<?php echo $bookingid; ?>" class="btn btn-md btn-primary"><i class="fa fa-print"></i> Print Refund Receipt</a>
                            <h4 style="text-align:center;background-color:lightgrey;padding:7px;text-transform:uppercase;">Booking Cancel Details</h4>
                            <?php
                            $CancelSql = "SELECT * FROM booking_cancelled where BookingCancelledBookingId='$bookingid'"; ?>

                            <table style="width:100%;" class="table table-striped">
                              <tr class="striped">
                                <th align="right">Cancel ID:</th>
                                <td><?php echo FETCH($CancelSql, "BookingCancelledId"); ?><?php echo DATE_FORMATE2("/d/m/Y", FETCH($CancelSql, "BookingCancelledCreatedAt")); ?>
                              </tr>
                              <tr class="striped">
                                <th align="right">Cancel Date:</th>
                                <td><?php echo DATE_FORMATE2("d M, Y", FETCH($CancelSql, "BookingCancelledDate")); ?>
                              </tr>
                              <tr class="striped">
                                <th align="right">Cancel Created At:</th>
                                <td><?php echo DATE_FORMATE2("d M, Y", FETCH($CancelSql, "BookingCancelledCreatedAt")); ?>
                              </tr>
                              <tr class="striped">
                                <th align="right">Cancel By:</th>
                                <td><?php echo FETCH("SELECT * FROM users where id='" . FETCH($CancelSql, "BookingCancelledBy") . "'", "name"); ?> - <small>ID : <?php echo FETCH($CancelSql, "BookingCancelledBy"); ?></small>
                              </tr>
                              <tr class="striped">
                                <th align="right">Cancel Detail/Reason:</th>
                                <td><?php echo SECURE(FETCH($CancelSql, "BookingCancelledReason"), "d"); ?>
                              </tr>
                            </table>
                            <h4 style="text-align:center;background-color:lightgrey;padding:7px;text-transform:uppercase;">Booking Refund Details</h4>
                            <?php
                            $RefundSql = "SELECT * FROM booking_refund where BookingRefundMainBookingId='$bookingid'"; ?>

                            <table style="width:100%;" class="table table-striped">
                              <tr class="striped">
                                <th align="right">Refund ID:</th>
                                <td><?php echo FETCH($RefundSql, "BookingRefundId"); ?><?php echo DATE_FORMATE2("/d/m/Y", FETCH($RefundSql, "BookingRefundCreatedAt")); ?>
                              </tr>
                              <tr class="striped">
                                <th align="right">Refund Date:</th>
                                <td><?php echo DATE_FORMATE2("d M, Y", FETCH($RefundSql, "BookingRefundId")); ?>
                              </tr>
                              <tr class="striped">
                                <th align="right">Refund Created At:</th>
                                <td><?php echo DATE_FORMATE2("d M, Y", FETCH($RefundSql, "BookingRefundCreatedAt")); ?>
                              </tr>
                              <tr class="striped">
                                <th align="right">Refund Updated At:</th>
                                <td><?php echo DATE_FORMATE2("d M, Y", FETCH($RefundSql, "BookingRefundUpdatedAt")); ?>
                              </tr>
                              <tr class="striped">
                                <th align="right">Refund By:</th>
                                <td><?php echo FETCH("SELECT * FROM users where id='" . FETCH($RefundSql, "BookingRefundCreatedBy") . "'", "name"); ?> - <small>ID : <?php echo FETCH($RefundSql, "BookingRefundCreatedBy"); ?></small>
                              </tr>
                              <tr class="striped">
                                <th align="right">Refund To:</th>
                                <td><?php echo FETCH($RefundSql, "BookingRefundTo"); ?>
                              </tr>
                              <tr class="striped">
                                <th align="right">Refund Amount:</th>
                                <td>Rs.<?php echo FETCH($RefundSql, "BookingRefundAmount"); ?>
                              </tr>
                              <tr class="striped">
                                <th align="right">Refund Mode:</th>
                                <td><?php echo FETCH($RefundSql, "BookingRefundMode"); ?>
                              </tr>
                              <tr class="striped">
                                <th align="right">Refund Status:</th>
                                <td><?php echo FETCH($RefundSql, "BookingRefundStatus"); ?>
                              </tr>
                              <tr class="striped">
                                <th align="right">Refund Detail:</th>
                                <td><?php echo SECURE(FETCH($RefundSql, "BookingRefundDetails"), "d"); ?>
                              </tr>
                            </table>
                          </div>
                        </div>
                      <?php } ?>
                    </div>

                    <div class=" col-md-5">
                      <h4 class="section-heading">Booking Details</h4>

                      <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xs-12 p-b-5">
                          <h4 class="bold">Customer Details</h4>
                          <a href="<?php echo DOMAIN; ?>/admin/customer/dashboard/?id=<?php echo $customer_id; ?>">
                            <div class="p-1r shadow-lg p-t-20 br10 hover-shadow app-bdr-top">
                              <div class="header">
                                <div class="row">
                                  <div class="col-lg-2 col-md-2 col-sm-2 col-2 col-xs-2">
                                    <div class="avatar m-t-15">
                                      <img src="<?php echo $customer_user_profile_img; ?>" class="img-fluid" alt="<?php echo $customer_name; ?>" title="<?php echo $customer_name; ?>">
                                    </div>
                                  </div>
                                  <div class="col-lg-10 col-md-10 col-sm-10 col-10 col-xs-10">
                                    <h5 class="m-t-4 m-b-3 fs-13 text-right text-grey italic">CUST ID : <?php echo $customer_id; ?></h5>
                                    <h5 class="m-t-4 m-b-3 fs-15"><b><?php echo $customer_name; ?></b></h5>
                                    <p class="lh-1-5 m-b-1 m-t-5">
                                      <i class="fa fa-envelope-o text-danger"></i> <?php echo $customer_email; ?><br>
                                      <i class="fa fa-phone text-info"></i> <?php echo $customer_phone; ?>
                                    </p>
                                  </div>
                                  <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xs-12">
                                    <p class="lh-1-4 m-t-5">
                                      <i class="fa fa-map-marker text-success"></i> <?php echo "$user_street_address,  $user_area_locality, $user_city, $user_state $user_country - $user_pincode"; ?>
                                    </p>
                                  </div>
                                  <div class="clearfix"></div>
                                </div>
                              </div>
                            </div>
                            <div class="clearfix"></div>
                          </a>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xs-12 p-b-10 p-1">
                          <h4 class="bold">Agent Details</h4>
                          <a href="<?php echo DOMAIN; ?>/admin/partner/dashboard/?id=<?php echo $agent_relation; ?>">
                            <div class="p-1r shadow-lg p-t-20 br10 hover-shadow app-bdr-top">
                              <div class="header">
                                <div class="row">
                                  <div class="col-lg-2 col-md-2 col-sm-2 col-2 col-xs-2">
                                    <div class="avatar m-t-15">
                                      <img src="<?php echo $customer_user_profile_img_a; ?>" class="img-fluid" alt="<?php echo $customer_name_a; ?>" title="<?php echo $customer_name_a; ?>">
                                    </div>
                                  </div>
                                  <div class="col-lg-10 col-md-10 col-sm-10 col-10 col-xs-10">
                                    <h5 class="m-t-4 m-b-3 fs-13 text-right text-grey italic">AGENT ID : <?php echo $agent_relation; ?></h5>
                                    <h5 class="m-t-4 m-b-3 fs-15"><b><?php echo $customer_name_a; ?></b></h5>
                                    <p class="lh-1-5 m-b-1 m-t-5">
                                      <i class="fa fa-envelope-o text-danger"></i> <?php echo $customer_email_a; ?><br>
                                      <i class="fa fa-phone text-info"></i> <?php echo $customer_phone_a; ?>
                                    </p>
                                  </div>
                                  <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xs-12">
                                    <p class="lh-1-4 m-t-5">
                                      <i class="fa fa-map-marker text-success"></i> <?php echo "$user_street_address_a,  $user_area_locality_a, $user_city_a, $user_state_a $user_country_a - $user_pincode_a"; ?>
                                    </p>
                                  </div>
                                  <div class="clearfix"></div>

                                </div>
                              </div>
                            </div>
                            <div class="clearfix"></div>
                          </a>
                        </div>


                        <div class="col-lg-12 col-md-12 col-12">
                          <h4 class="bold">Booking Details</h4>
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
                          </table>

                          <h4 class="bold">
                            <span class="m-t-5">More Details</span>
                          </h4>
                          <table class="table table-striped">
                            <tr>
                              <th>Pay Period (EMI MONTHS)</th>
                              <td><?php echo $emi_months; ?> Months</td>
                            </tr>
                            <tr>
                              <th>Booking Date</th>
                              <td><?php echo $booking_date; ?></td>
                            </tr>
                            <tr>
                              <th>Booking Created at</th>
                              <td><?php echo $created_at; ?></td>
                            </tr>
                            <tr>
                              <th>Clearing Date</th>
                              <td><?php echo $clearing_date; ?></td>
                            </tr>
                            <tr>
                              <th>Possession</th>
                              <td><?php echo $possession; ?></td>
                            </tr>
                            <tr>
                              <th>Possession last Update</th>
                              <td><?php echo $possession_update_date; ?></td>
                            </tr>
                            <tr>
                              <th>Possession Notes</th>
                              <td><?php echo $possession_notes; ?></td>
                            </tr>
                            <?php
                            $SQL_booking_emis = SELECT("SELECT *, booking_emis.created_at AS emi_created_at FROM bookings, booking_emis where bookings.bookingid=booking_emis.booking_id and booking_emis.emi_id='$emi_id'");
                            if ($SQL_booking_emis != null) {
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
                                $emi_months = $FetchEMI['emi_months'];
                                $totalpayment = $emi_per_month; ?>
                                <tr>
                                  <th>Pay Period (EMI MONTHS)</th>
                                  <td><?php echo $emi_months; ?> Months</td>
                                </tr>
                                <tr>
                                  <th>EMI Start Date</th>
                                  <td><?php echo date("d M, Y", strtotime($emi_start_date)); ?></td>
                                </tr>
                                <tr>
                                  <th>EMI END Date</th>
                                  <td><?php echo date("d M, Y", strtotime($emi_last_date)); ?></td>
                                </tr>
                                <tr>
                                  <th>EMI Payable Per Month</th>
                                  <td>Rs.<?php echo $emi_per_month; ?></td>
                                </tr>

                            <?php }
                            }
                            ?>
                          </table>
                          <style>
                            .table-payments table tr,
                            td {
                              font-size: 9px !important;
                            }
                          </style>

                          <h4 class="bold">Payment History</h4>
                          <table class="table table-striped p-1" style="font-size:11px !important;">
                            <tr>
                              <th>PayMode</th>
                              <th>CreatedAt</th>
                              <th>PaidDate</th>
                              <th>Amount</th>
                              <th>Status</th>
                              <th class="text-right">NetPaid</th>
                            </tr>
                            <?php
                            $TotalPaymentReceived = 0;
                            $SqlPayments = SELECT("SELECT * FROM payments where bookingid='$bookingid'");
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
                                <td class="text-left" style="text-align:left !important;font-size:12px !important;"><?php echo strtoupper($FetchPayments['payment_mode']); ?></td>
                                <td class="text-left" style="font-size:12px !important;"><?php echo $FetchPayments['created_at']; ?></td>
                                <td class="text-left" style="font-size:12px !important;"><?php echo date("d M, Y", strtotime($payment_date_for_payment)); ?></td>
                                <td class="text-left" style="font-size:12px !important;"><span class="text-dark">Rs.<?php echo $FetchPayments['payment_amount']; ?></span></td>
                                <td class="text-left" style="font-size:12px !important;"><?php echo $paymentstatus; ?></td>
                                <td style="font-size:12px !important;"><span class="text-success">Rs.<?php echo $TotalPaymentReceived; ?></span></td>
                              </tr>
                            <?php } ?>
                            <tr>
                              <td colspan="7"><span class="text-primary"></span></td>
                            </tr>
                            <tr>
                              <td colspan="7"><span class="text-grey">Total Paid &nbsp;</span><span class="text-primary fs-16">Rs.<?php echo $PaymentforProjects; ?></span></td>
                            </tr>
                            <tr>
                              <td colspan="7"><span class="text-grey">Net Payable &nbsp;</span><span class="text-dark fs-16">Rs.<?php echo $net_payable_amount; ?></span></td>
                            </tr>
                            <tr>
                              <td align="right"></td>
                              <td colspan="6"><span class="text-grey">Balance &nbsp;</span><span class="text-danger fs-15">Rs.<?php echo $net_payable_amount - $PaymentforProjects; ?></span></td>
                            </tr>
                          </table>

                        </div>
                      </div>
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


    <!-- end -->
    <?php include '../../sidebar.php'; ?>
    <?php include '../../footer.php'; ?>
  </div>

  <?php include '../../../include/footer_files.php'; ?>
</body>

</html>
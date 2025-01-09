<?php
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';


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

//customer DETAILS
$getusers = SELECT("SELECT * FROM users, user_address, user_roles where users.company_relation='$company_id' and users.id='$customer_id' and users.user_role_id='4' and users.id=user_address.user_id and users.user_role_id=user_roles.role_id");
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
  $customer_user_profile_img = "$DOMAIN/storage/sys-img/$customer_user_profile_img";
} else {
  $customer_user_profile_img = "$DOMAIN/storage/users/$executedcustomer_id/img/$customer_user_profile_img";
}

//agent details
$getusers_a = SELECT("SELECT * FROM users, user_address, user_roles where users.company_relation='$company_id' and users.id='$agent_relation' and users.id=user_address.user_id and users.user_role_id=user_roles.role_id");
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
  $customer_user_profile_img_a = "$DOMAIN/storage/sys-img/$customer_user_profile_img_a";
} else {
  $customer_user_profile_img_a = "$DOMAIN/storage/users/$customer_id_a/img/$customer_user_profile_img_a";
}

//last payment
$GetPAYMENTS = SELECT("SELECT * FROM payments where bookingid='$bookingid' ORDER BY payment_id  DESC");
$payments = mysqli_fetch_array($GetPAYMENTS);
$payment_amount = $payments['payment_amount'];
$payment_mode = $payments['payment_mode'];
$slip_no = $payments['slip_no'];
$remark = $payments['remark'];
$payment_date = $payments['payment_date'];
$paymentcreatedat = $payments['created_at'];

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

//Booking id
$MainBookingID = "B$bookingid/" . date("m/Y", strtotime($created_at));
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?PHP echo $MainBookingID; ?> | <?php echo $company_name; ?></title>
  <?php include '../../../include/header_files.php'; ?>
  <style>
    td {
      text-align: right !important;
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
        <div class="pageheader hidden-xs">
          <h3>Booking Dashboard : <?php echo $MainBookingID; ?></h3>
        </div>
        <!--Page content-->
        <div id="page-content">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-12">
              <div class="panel square">
                <div class="panel-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="btn-group-sm btn-group">
                        <a href="<?php echo $DOMAIN; ?>/admin/booking/booking_exports_orginal.php?id=<?php echo $bookingid; ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-print"></i> Booking Receipt</a>
                        <a href="<?php echo $DOMAIN; ?>/admin/booking/booking_exports.php?id=<?php echo $bookingid; ?>" target="_blank" class="btn btn-sm btn-info"><i class="fa fa-print"></i> Booking Balance</a>
                        <a href="<?php echo $DOMAIN; ?>/admin/booking/booking_payments.php?id=<?php echo $bookingid; ?>" target="_blank" class="btn btn-sm btn-success"><i class="fa fa-print"></i> Booking Payments</a>
                        <a href="<?php echo $DOMAIN; ?>/admin/booking/booking_development_charges.php?id=<?php echo $bookingid; ?>" target="_blank" class="btn btn-sm btn-dark"><i class="fa fa-print"></i> Development Charges</a>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 col-xs-12 p-b-15">
                          <h4 class="app-bg br5 p-3 pl-1">Customer Details</h4>
                          <a href="<?php echo $DOMAIN; ?>/admin/customer/dashboard/?id=<?php echo $customer_id; ?>">
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

                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 col-xs-12 p-b-15 p-1">
                          <h4 class="app-bg br5 p-3 pl-1 mt-0">Agent Details</h4>
                          <a href="<?php echo $DOMAIN; ?>/admin/partner/dashboard/?id=<?php echo $agent_relation; ?>">
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
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-12">
                      <div class="col-lg-12 col-md-12 col-12 col-sm-12 shadow-sm">
                        <h4 class="app-bg br5 p-3 pl-1">Booking Details</h4>
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
                      </div>

                      <div class="col-lg-12 col-md-12 col-12 col-sm-12 shadow-sm">
                        <h4 class="app-bg br5 p-2 flex-s-b">
                          <span class="m-t-5">More Details</span>
                          <a href="#" data-toggle="modal" data-target="#possession_update" class="text-white fs-10 btn-sm btn btn-primary round"><i class="fa fa-edit"></i> Update</a>
                        </h4>
                        <table class="table table-striped">
                          <tr>
                            <th>Pay Period (EMI MONTHS)</th>
                            <td><?php echo $emi_months; ?> Months</td>
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
                        </table>
                      </div>
                      <style>
                        .table-payments table tr,
                        td {
                          font-size: 9px !important;
                        }
                      </style>
                      <div class="col-lg-12 col-md-12 col-12 col-sm-12 shadow-sm table-payments">
                        <div class="app-bg br5 p-2 flex-s-b pl-1">
                          <span class="m-t-5">Booking Payment History</span>
                          <a href="#" data-toggle="modal" data-target="#add_data" class="text-white fs-10 btn-sm btn btn-primary round"><i class="fa fa-plus"></i> Add Payment</a>
                        </div>
                        <table class="table table-striped" style="font-size:9px !important;">
                          <?php
                          $TotalPaymentReceived = 0;
                          $SqlPayments = SELECT("SELECT * FROM payments where bookingid='$bookingid'");
                          while ($FetchPayments = mysqli_fetch_array($SqlPayments)) {
                            $TotalPaymentReceived = 0;
                            $payment_mode = $FetchPayments['payment_mode'];
                            $payment_id = $FetchPayments['payment_id'];

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
                              <td style="text-align:left !important;font-size:11px !important;"><?php echo strtoupper($FetchPayments['payment_mode']); ?></td>
                              <td style="font-size:11px !important;"><?php echo $FetchPayments['created_at']; ?></td>
                              <td style="font-size:11px !important;"><span class="text-dark">Rs.<?php echo $FetchPayments['payment_amount']; ?></span></td>
                              <td style="font-size:11px !important;">
                                <?php
                                if ($FetchPayments['charges'] == null) {
                                } else { ?>
                                  + Rs.<?php echo round((int)$FetchPayments['payment_amount'] / 100 * (int)$FetchPayments['chargeamount']); ?><br>
                                  <span class="text-grey"><?php echo $FetchPayments['charges']; ?></span> : <?php echo $FetchPayments['chargeamount']; ?>%
                                <?php  } ?>
                              </td>
                              <td style="font-size:11px !important;">
                                <?php
                                if ($FetchPayments['discounts'] == null) {
                                } else { ?>

                                  - Rs.<?php echo round((int)$FetchPayments['payment_amount'] / 100 * (int)$FetchPayments['discountamount']); ?><br>
                                  <span class="text-grey"><?php echo $FetchPayments['discounts']; ?></span> : <?php echo $FetchPayments['discountamount']; ?>%
                                <?php  } ?>
                              </td>
                              <td style="font-size:11px !important;"><?php echo $paymentstatus; ?></td>
                              <td style="font-size:11px !important;"><span class="text-success">Rs.<?php echo $TotalPaymentReceived; ?></span></td>
                            </tr>
                          <?php } ?>
                          <tr>
                            <td colspan="6" align="right"></td>
                            <td><span class="text-primary"></td>
                          </tr>
                          <tr>
                            <td colspan="6" align="right"><span class="text-grey">Total Paid &nbsp;</span></td>
                            <td><span class="text-primary fs-16">Rs.<?php echo $PaymentforProjects; ?></span></td>
                          </tr>
                          <tr>
                            <td colspan="6" align="right"><span class="text-grey">Net Payable &nbsp;</span></td>
                            <td><span class="text-dark fs-16">Rs.<?php echo $net_payable_amount; ?></span></td>
                          </tr>
                          <tr>
                            <td colspan="6" align="right"><span class="text-grey">Balance &nbsp;</span></td>
                            <td><span class="text-danger fs-15">Rs.<?php echo $net_payable_amount - $PaymentforProjects; ?></span></td>
                          </tr>
                        </table>

                      </div>

                    </div>


                    <div class="col-lg-6 col-md-6 col-12 col-sm-6 shadow-sm">
                      <div class="col-lg-12 col-md-12 col-12 col-sm-12 shadow-sm table-payments">
                        <div class="app-bg br5 p-2 flex-s-b pl-1">
                          <span class="m-t-5">Development Charges</span>
                          <a href="<?php echo $DOMAIN; ?>/admin/booking/development-charges/?b_id=<?php echo $BookingViewId; ?>" class="text-white fs-10 btn-sm btn btn-primary round"><i class="fa fa-plus"></i> Add Charges</a>
                        </div>

                        <table class="table table-striped text-right" align="right">
                          <tr class="text-right">
                            <th class="text-right">RefID</th>
                            <th align="right" class="text-right">BookingiD</th>
                            <th align="right" class="text-right">Name</th>
                            <th align="right" class="text-right">Type</th>
                            <th align="right" class="text-right">Status</th>
                            <th align="right" class="text-right">Amount</th>
                          </tr>
                          <?php
                          $SqlDevcharges = SELECT("SELECT * FROM developmentcharges, bookings where developmentcharges.bookingid='$bookingid' and developmentcharges.bookingid=bookings.bookingid ORDER by developmentcharges.devchargesid ASC");
                          $netdevelopmentcharges = 0;
                          while ($FetchDevCharges = mysqli_fetch_array($SqlDevcharges)) {
                            $devchargesid = $FetchDevCharges['devchargesid'];
                            $bookingid2 = $FetchDevCharges['bookingid'];
                            $created_at2 = $FetchDevCharges['created_at'];
                            $developmentchargetitle = $FetchDevCharges['developmentchargetitle'];
                            $developmentchargetype = $FetchDevCharges['developmentchargetype'];
                            $developmentcharge = $FetchDevCharges['developmentcharge'];
                            $developementchargeamount = $FetchDevCharges['developementchargeamount'];
                            $developmentchargecreatedat = $FetchDevCharges['developmentchargecreatedat'];
                            $developmentchargestatus = $FetchDevCharges['developmentchargestatus'];
                            $MainBookingID2 = "B$bookingid2/" . date("m/Y", strtotime($created_at2));
                            $netdevelopmentcharges += (int)$developementchargeamount; ?>
                            <tr>
                              <td>DC<?php echo $devchargesid; ?></td>
                              <td><span class="text-info"><?php echo $MainBookingID2; ?></span></td>
                              <td><?php echo $developmentchargetitle; ?></td>
                              <td><?php echo $developmentchargetype; ?></td>
                              <td><?php echo $developmentchargestatus; ?></td>
                              <td><span class="text-success fs-14">Rs.<?php echo $developementchargeamount; ?></span></td>
                            </tr>
                          <?php } ?>
                          <tr>
                            <td colspan="5"><span class="text-grey">Total Development Charges</span></td>
                            <td>
                              <span class="text-primary fs-16"> Rs.<?php echo $netdevelopmentcharges; ?></span>
                            </td>
                          </tr>
                        </table>
                      </div>

                      <div class="col-lg-12 col-md-12 col-12 col-sm-12 shadow-sm table-payments">
                        <div class="app-bg br5 p-2 flex-s-b pl-1">
                          <span class="m-t-5">Development Charge Payment</span>
                          <a href="<?php echo $DOMAIN; ?>/admin/payments/dev-payments/?b_id=<?php echo $BookingViewId; ?>" class="text-white fs-10 btn-sm btn btn-primary round"><i class="fa fa-plus"></i> Add Payments</a>
                        </div>

                        <table class="table table-striped text-right" align="right">
                          <tr class="text-right">
                            <th align="right" class="text-right">RefID</th>
                            <th align="right" class="text-right">Mode</th>
                            <th align="right" class="text-right">PaidAt</th>
                            <th align="right" class="text-right">Status</th>
                            <th align="right" class="text-right">Amount</th>
                          </tr>
                          <?php
                          $TotalAmountPaid2 = SELECT("SELECT * FROM developmentchargepayments, developmentcharges where developmentcharges.bookingid='$BookingViewId' and developmentchargepayments.developmentchargeid=developmentcharges.devchargesid");
                          $netdevelopmentchargespaid = 0;
                          while ($fetchtotalpayment2 = mysqli_fetch_array($TotalAmountPaid2)) {
                            $developmentchargeid = $fetchtotalpayment2['developmentchargeid'];
                            $devchargepaymentmode = $fetchtotalpayment2['devchargepaymentmode'];
                            $devchargepaymentamount = $fetchtotalpayment2['devchargepaymentamount'];
                            $devchargepaymentnotes = html_entity_decode(SECURE($fetchtotalpayment2['devchargepaymentnotes'], "d"));
                            $devpaymentreceivedby = $fetchtotalpayment2['devpaymentreceivedby'];
                            $devpaymentbankname = $fetchtotalpayment2['devpaymentbankname'];
                            $devpaymentreleaseddate = $fetchtotalpayment2['devpaymentreleaseddate'];
                            $devpaymentstatus = $fetchtotalpayment2['devpaymentstatus'];
                            $devpaymentdetails = html_entity_decode(SECURE($fetchtotalpayment2['devpaymentdetails'], "d"));
                            $devpaymentcreatedat = $fetchtotalpayment2['devpaymentcreatedat'];
                            $devpaymentupdatedat = $fetchtotalpayment2['devpaymentupdatedat'];
                            $netdevelopmentchargespaid += $devchargepaymentamount;
                          ?>
                            <tr>
                              <td><span class="text-info">DC<?php echo $developmentchargeid; ?></span></td>
                              <td><?php echo $devchargepaymentmode; ?></td>
                              <td><?php echo $devpaymentreleaseddate; ?></td>
                              <td><?php echo $devpaymentstatus; ?></td>
                              <td><span class="text-success fs-14">Rs.<?php echo $devchargepaymentamount; ?></span></td>
                            </tr>
                          <?php } ?>
                          <tr>
                            <td colspan="4"><span class="text-grey">Total Paid</span></td>
                            <td>
                              <span class="text-primary fs-16"> Rs.<?php echo $netdevelopmentchargespaid; ?></span>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="4"><span class="text-grey">Net Payable</span></td>
                            <td>
                              <span class="text-black fs-15"> Rs.<?php echo $netdevelopmentcharges; ?></span>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="4"><span class="text-grey">Balance</span></td>
                            <td>
                              <span class="text-danger fs-14"> Rs.<?php echo  $netdevelopmentcharges - $netdevelopmentchargespaid; ?></span>
                            </td>
                          </tr>
                        </table>
                      </div>

                      <div class="col-lg-12 col-md-12 col-12 col-sm-12 shadow-sm table-payments">
                        <h4 class="app-bg br5 p-3 pl-1">Commission</h4>
                        <table class="table table-striped" style="font-size:9px !important;">
                          <?php
                          $commission_amount_total = 0;
                          $SQL_commissions = SELECT("SELECT * FROM  commission where commission.booking_id='$bookingid'  ORDER BY commission.commission_id DESC");
                          while ($FetchCommission = mysqli_fetch_array($SQL_commissions)) {
                            $commission_amount_total += $FetchCommission['commission_amount']; ?>
                            <tr>
                              <td>Rs.<?php echo $FetchCommission['commission_rate_area']; ?> / sq area</td>
                              <td class="text-success">Rs.<?php echo $FetchCommission['commission_amount']; ?></td>
                              <td><?php echo $FetchCommission['created_at']; ?></td>
                              <td style="width:30%;"><?php echo $FetchCommission['commission_remark']; ?></td>
                            </tr>
                          <?php } ?>
                          <tr>
                            <th colspan="5"></th>
                          </tr>
                          <tr>
                            <td colspan="3" align="right"><span class="text-grey">Total &nbsp;</span></td>
                            <td colspan="3"><span class="text-primary fs-16">Rs.<?php echo $commission_amount_total; ?></span></td>
                          </tr>
                          <tr>
                            <td colspan="3" align="right"><span class="text-grey">Commission Paid &nbsp;</span></td>
                            <td colspan="3"><span class="text-success fs-16">Rs.
                                <?php
                                $CheckPaouts = SELECT("SELECT * FROM commission_payouts where partner_id='$customer_email_a' and commission_status='PAID'");
                                $TotalCommissionPaid = 0;
                                while ($FetchPayouts = mysqli_fetch_array($CheckPaouts)) {
                                  $TotalCommissionPaid += (int)$FetchPayouts['commission_payout_amount'];
                                }
                                echo $TotalCommissionPaid;
                                ?></span></td>
                          </tr>
                          <tr>
                            <td colspan="3" align="right"><span class="text-grey">Balance &nbsp;</span></td>
                            <td colspan="3"><span class="text-danger fs-14">Rs.
                                <?php
                                $CommissionReceivable = $commission_amount_total;
                                $CommissionBalance = (int)$CommissionReceivable - $TotalCommissionPaid;
                                echo $CommissionBalance;
                                ?></span></td>
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


    <!-- end -->
    <?php include '../../sidebar.php'; ?>
    <?php include '../../footer.php'; ?>
  </div>

  <?php include '../../../include/footer_files.php'; ?>
  <script>
    function PaymentMode(data) {
      if (data == "cash") {
        document.getElementById("cash").style.display = "block";
        document.getElementById("check").style.display = "none";
        document.getElementById("banking").style.display = "none";
      } else if (data == "check") {
        document.getElementById("cash").style.display = "none";
        document.getElementById("check").style.display = "block";
        document.getElementById("banking").style.display = "none";
      } else if (data == "banking") {
        document.getElementById("cash").style.display = "none";
        document.getElementById("check").style.display = "none";
        document.getElementById("banking").style.display = "block";
      } else {
        document.getElementById("cash").style.display = "block";
        document.getElementById("check").style.display = "none";
        document.getElementById("banking").style.display = "none";
      }
    }
  </script>
  <script>
    function getpaidamount() {
      document.getElementById("cashamount").value = document.getElementById("paidamount").value;
      document.getElementById("netpaidamount").innerHTML = document.getElementById("paidamount").value;
      document.getElementById("net_payable").value = document.getElementById("paidamount").value;
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
          discountshow.style.display = "block";
          discountamount = Math.round(unit_cost / 100 * discountvalue);
          discountableamount = +unit_cost - +discountamount;
          discountshow.innerHTML = discountname + " (" + discountvalue + "%) : <b> - Rs." + discountamount + "</b>";
          discountname.value = discountname;
          chargeableamount = Math.round(unit_cost / 100 * chargevalue);
          new_net_payable = (+unit_cost + +chargeableamount) - +discountamount;

          document.getElementById("net_payable").value = new_net_payable;
          chargeshow.innerHTML = chargename + " (" + chargevalue + "%): <b> + Rs." + chargeableamount + "</b>";

          document.getElementById("netpaidamount").innerHTML = new_net_payable;
          document.getElementById("paidamount").innerHTML = unit_cost;
          chargename.value = chargename;

        } else {
          discountshow.style.display = "none";
          discountableamount = 0;
          chargename.value = "";
          discountname.value = "";
          chargeableamount = Math.round(unit_cost / 100 * chargevalue);
          new_net_payable = +unit_cost + +chargeableamount;

          document.getElementById("net_payable").value = new_net_payable;
          chargeshow.innerHTML = chargename + " (" + chargevalue + "%): <b> + Rs." + chargeableamount + "</b>";

          document.getElementById("netpaidamount").innerHTML = new_net_payable;
          document.getElementById("paidamount").innerHTML = unit_cost;
          chargename.value = chargename;

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
</body>

</html>
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
$partner_id = $Bookings['partner_id'];
$matches = preg_replace('/[^0-9.]+/', '', $unit_area);
$unit_area_in_numbers = (int)$matches;
$possession_notes = $Bookings['possession_notes'];
$possession_update_date = $Bookings['possession_update_date'];
$project_unit_id = $Bookings['project_unit_id'];
$emi_months = $Bookings['emi_months'];
$emi_last_date = date("d M, Y", strtotime($Bookings['booking_date'], strtotime("+$emi_months months")));
$crn_no = $Bookings['crn_no'];
$ref_no = $Bookings['ref_no'];
$parking_status = $Bookings['parking_status'];

//unit details
$UnitSQL = "SELECT * FROM project_units where project_units_id='$project_unit_id'";
$project_block_id = FETCH($UnitSQL, "project_block_id");
$project_floor_id = FETCH($UnitSQL, "project_floor_id");

$project_block_name = FETCH("SELECT project_block_name FROM project_blocks where project_block_id='$project_block_id'", "project_block_name");
$projects_floor_name = FETCH("SELECT projects_floor_name from projects_floors WHERE projects_floors_id='$project_floor_id'", "projects_floor_name");
$projects_floors_tag = FETCH("SELECT projects_floors_tag from projects_floors WHERE projects_floors_id='$project_floor_id'", "projects_floors_tag");
$project_unit_bhk_type = FETCH("SELECT project_unit_bhk_type FROM project_units where project_units_id='$project_unit_id'", "project_unit_bhk_type");
$project_unit_highlights = FETCH("SELECT project_unit_highlights FROM project_units where project_units_id='$project_unit_id'", "project_unit_highlights");
$unit_broker_rate = FETCH("SELECT unit_broker_rate FROM project_units where project_units_id='$project_unit_id'", "unit_broker_rate");


$agent_relation = FETCH("SELECT * FROM users where id='$customer_id'", "agent_relation");
if ($agent_relation == 0) {
  $Update = UPDATE("UPDATE users SET agent_relation='$partner_id' where id='$customer_id'");
}

//customer DETAILS
$getusers = SELECT("SELECT * FROM users, user_address, user_roles where users.company_relation='" . company_id . "' and users.id='$customer_id' and users.id=user_address.user_id and users.user_role_id=user_roles.role_id");
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
$getusers_a = SELECT("SELECT * FROM users, user_roles where users.company_relation='" . company_id . "' and users.id='$partner_id' and users.user_role_id=user_roles.role_id");
$count = 0;
$agents = mysqli_fetch_array($getusers_a);
$count++;
$customer_id_a = $agents['id'];
$customer_name_a = $agents['name'];
$customer_phone_a = $agents['phone'];
$customer_email_a = $agents['email'];
$AddSQL = "SELECT * FROM user_address where user_id='$customer_id_a'";
$user_street_address_a = FETCH($AddSQL, 'user_street_address');
$user_area_locality_a = FETCH($AddSQL, 'user_area_locality');
$user_city_a = FETCH($AddSQL, 'user_city');
$user_state_a = FETCH($AddSQL, 'user_state');
$user_pincode_a = FETCH($AddSQL, 'user_pincode');
$user_country_a = FETCH($AddSQL, 'user_country');
$executedcustomer_id_a = $agents['id'];
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
$AllDevPaidCharges1 = "SELECT * FROM developmentcharges, developmentchargepayments where developmentcharges.bookingid='$bookingid' and developmentcharges.devchargesid=developmentchargepayments.developmentchargeid and devpaymentstatus like '%RECEIVED%'";
$AllDevPaidCharges2 = "SELECT * FROM developmentcharges, developmentchargepayments where developmentcharges.bookingid='$bookingid' and developmentcharges.devchargesid=developmentchargepayments.developmentchargeid and devpaymentstatus like '%PAID%'";
$AllDevPaidCharges3 = "SELECT * FROM developmentcharges, developmentchargepayments where developmentcharges.bookingid='$bookingid' and developmentcharges.devchargesid=developmentchargepayments.developmentchargeid and devpaymentstatus like '%CLEAR%'";
$AllDevPaidCharges4 = "SELECT * FROM developmentcharges, developmentchargepayments where developmentcharges.bookingid='$bookingid' and developmentcharges.devchargesid=developmentchargepayments.developmentchargeid and devpaymentstatus like '%SUCCESS%'";
$NetDevPaidAmount = AMOUNT($AllDevPaidCharges4, "devchargepaymentamount") + AMOUNT($AllDevPaidCharges1, "devchargepaymentamount") + AMOUNT($AllDevPaidCharges2, "devchargepaymentamount") + AMOUNT($AllDevPaidCharges3, "devchargepaymentamount");
$NetchargesPaid = $NetDevPaidAmount;
if ($NetchargesPaid == null) {
  $NetchargesPaid = 0;
} else {
  $NetchargesPaid = $NetchargesPaid;
}

//emiavriabel
$emi_id = FETCH("SELECT * FROM booking_emis where booking_id='$bookingid'", "emi_id");

//Booking id
$MainBookingID = "B$bookingid/" . date("m/Y", strtotime($created_at));

$BankLoanSql = "SELECT * FROM booking_loans where booking_main_id='$bookingid'";
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
    }

    a.hidden {
      display: none !important;
      visibility: hidden !important;
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
                  <?php include "../../../include/booking/booking-cancel-details.php"; ?>
                  <div class="row">
                    <div class="col-md-12 mb-2">
                      <a href="../index.php" class="btn btn-sm btn-default"><i class="fa fa-angle-left"></i> Back to Bookings</a>
                      <a href="../../customer/index.php" class="btn btn-sm btn-default"><i class="fa fa-angle-left"></i> Back to Customers</a>
                      <a href="../../partner/index.php" class="btn btn-sm btn-default"><i class="fa fa-angle-left"></i> Back to Agents</a>
                      <a href='#' class='btn btn-md btn-default'>
                        <?php
                        $BookingType = FETCH("SELECT * FROM booking_resales where booking_main_id='$BookingViewId'", "booking_resale_type");
                        echo BookingTypes($BookingType);
                        ?>
                      </a>
                    </div>
                    <div class="col-md-12 flex-s-b">
                      <h3 class="m-t-5"><i class="fa fa-star app-text"></i> Booking Dashboard : <?php echo $MainBookingID; ?></h3>
                      <a href="#" onclick="Databar('ViewActions')" class="btn btn-md btn-primary"><i class='fa fa-gears'></i> View Actions</a>
                    </div>
                  </div>
                  <div style="display:none;" id="ViewActions">
                    <div class="row">
                      <div class="col-md-12">
                        <h4 class="text-left"><i class="fa fa-print"></i> Printable Receipts & Documents</h4>
                        <div class="btn-group-md btn-group">
                          <a href="<?php echo DOMAIN; ?>/admin/booking/booking_exports_orginal.php?id=<?php echo $bookingid; ?>" target="_blank" class="btn btn-sm btn-default"><i class="fa fa-print text-primary"></i> Booking Receipt</a>
                          <a href="<?php echo DOMAIN; ?>/admin/booking/booking_exports.php?id=<?php echo $bookingid; ?>" target="_blank" class="btn btn-sm btn-default"><i class="fa fa-print text-primary"></i> Booking Balance</a>
                          <a href="<?php echo DOMAIN; ?>/admin/booking/booking_payments.php?id=<?php echo $bookingid; ?>" target="_blank" class="btn btn-sm btn-default"><i class="fa fa-print text-primary"></i> Booking Statement</a>
                          <a href="<?php echo DOMAIN; ?>/admin/booking/booking_development_charges.php?id=<?php echo $bookingid; ?>" target="_blank" class="btn btn-sm btn-default"><i class="fa fa-print text-primary"></i> Other Payments</a>
                          <a href="../docs/welcome-letter.php?id=<?php echo $bookingid; ?>" target="_blank" class="btn btn-sm btn-default"><i class="fa fa-print"></i> Welcome Letter</a>
                          <a href="../docs/allotment.php?id=<?php echo $bookingid; ?>" target="_blank" class="btn btn-sm btn-default"><i class="fa fa-print"></i> Allotment Letter</a>
                          <!--<a data-toggle="modal" data-target="#final_demand_notice" class="btn btn-sm btn-default"><i class="fa fa-print"></i> Final Demand Notice</a>-->
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="modal fade square" id="final_demand_notice" role="dialog">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header app-bg text-white">
                                <button type="button" class="close text-white m-r-8 m-t-1" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title text-white">Generate Final Demand Notice</h4>
                              </div>
                              <div class="modal-body overflow-auto">
                                <form class="row" target="_blank" action="../docs/demand-notice.php">
                                  <input type="hidden" name='id' value='<?php echo $bookingid; ?>'>
                                  <div class="form-group col-md-4">
                                    <label>Due Date</label>
                                    <input type='date' name='due_date' class='form-control' value='<?php echo date("Y-m-d", strtotime("+15 days")); ?>'>
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label>IFMS Charges (0 for disable)</label>
                                    <input type='number' name='IFMS' class='form-control' value='0'>
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label>UPKEEP Charges (0 for disable)</label>
                                    <input type='number' name='UPKEEP' class='form-control' value='0'>
                                  </div>

                                  <div class="col-md-12 form-group">
                                    <label>Update Bank Account Details (Optional, if empty then default account details will be shown)</label>
                                    <textarea name='BANK_ACCOUNT_DETAILS' class="form-control" rows="3"></textarea>
                                  </div>

                                  <div class='col-md-12 text-right'>
                                    <button type='submit' name='GENERATE_FINAL_DEMAND_NOTICE' class='btn btn-md btn-success'>Generate Final Demand Notice</button>
                                  </div>
                                </form>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <h4 class="text-left"><i class="fa fa-edit"></i> Update Booking Record</h4>
                        <a href="cancel-bookings.php?id=<?php echo $bookingid; ?>" class="btn btn-sm btn-warning <?php echo $hiddenbtn; ?>"><i class='fa fa-times'></i> Cancel Booking</a>
                        <a href="edit.php?id=<?php echo $bookingid; ?>" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Edit Details</a>
                        <a href="edit-alloty.php?id=<?php echo $bookingid; ?>" class="btn btn-sm btn-warning">Edit Alloty Details</a>
                        <a href="add-commission.php?bookingid=<?php echo $bookingid; ?>" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Update Commission</a>
                      </div>
                      <div class="col-md-6">
                        <h4><i class="fa fa-file text-primary"></i> Generate letter</h4>
                        <div class="btn-group btn-group-md">
                          <a href="send-demand.php?id=<?php echo $bookingid; ?>" class="btn btn-sm btn-info"><i class="fa fa-print"></i> Demand Letter</a>
                          <a href="send-reminder.php?id=<?php echo $bookingid; ?>" class="btn btn-sm btn-info"><i class="fa fa-print"></i> Reminder Letter</a>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <h4><i class="fa fa-exchange"></i> Update Payment Records</h4>
                        <a href="<?php echo DOMAIN; ?>/admin/payments/emi-payments/emi-pay.php?bid=<?php echo $bookingid; ?>&emi_id=<?php echo $emi_id; ?>" class="text-white fs-10 btn-sm btn btn-primary round <?php echo $hiddenbtn; ?>"><i class="fa fa-plus"></i> Receive Payment</a>
                        <a href="<?php echo DOMAIN; ?>/admin/booking/development-charges/?b_id=<?php echo $BookingViewId; ?>" class="text-white fs-10 btn-sm btn btn-primary round <?php echo $hiddenbtn; ?>"><i class="fa fa-plus"></i> Add Dev & Other Charges</a>
                        <a href="<?php echo DOMAIN; ?>/admin/payments/dev-payments/?b_id=<?php echo $BookingViewId; ?>" class="text-white fs-10 btn-sm btn btn-primary round <?php echo $hiddenbtn; ?>"><i class="fa fa-plus"></i> Receive Dev Payments</a>
                      </div>
                      <div class="col-md-6">
                        <h4><br></h4>
                        <a onclick="Databar('ViewActions')" class="btn btn-md btn-danger"><i class='fa fa-eye-slash'></i> Hide Actions</a>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 col-xs-12 p-b-5 m-t-15">
                          <h4 class="section-heading app-bg">Allotee Details</h4>
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

                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 col-xs-12 p-b-10">
                          <h4 class="section-heading app-bg">Agent/Partner/Sale Exectuive Details</h4>
                          <a href="<?php echo DOMAIN; ?>/admin/partner/dashboard/?id=<?php echo $partner_id; ?>">
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
                    <div class="col-md-12">
                      <h4 class="section-heading app-bg">All Payments</h4>
                    </div>
                    <div class="col-md-12">
                      <div class="pl-1 pr-1">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th>SNo</th>
                              <th>PaymentRefId</th>
                              <th>Payment Mode</th>
                              <th>NetPaid</th>
                              <th>Paid Date</th>
                              <th>CreatedAt</th>
                              <th>Type</th>
                              <th class="text-right">Action</th>
                            </tr>
                          </thead>
                          <tbody>
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
                                $payment_mode = "Cheque";
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
                              <tr>
                                <td class="text-left"><?php echo $SerialNo; ?></td>
                                <td class="text-primary text-left"><i class="fa fa-hashtag"></i> <?php echo $paymentreferenceid; ?></td>
                                <td class="text-left"><?php echo $payment_mode; ?></td>
                                <td class="text-success text-left">Rs.<?php echo $net_paid_amount; ?></td>
                                <td class="text-left"><?php echo $payment_date; ?></td>
                                <td class="text-left"><?php echo $payment_created_at; ?></td>
                                <td class="text-left"><?php echo $payment_type; ?></td>
                                <td class="text-right">
                                  <a href="<?php echo DOMAIN; ?>/admin/booking/receipt.php?id=<?php echo $bookingid; ?>&payment_id=<?php echo $payment_id; ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-print"></i> View Receipt</a>
                                </td>
                              </tr>
                            <?php } ?>
                            <?php

                            //total amount paid
                            if (isset($_GET['search'])) {
                              $search_type = $_GET['search_type'];
                              $search_value = $_GET['search_value'];
                              $TotalAmountPaid = SELECT("SELECT sum(net_paid) FROM payments, bookings  where $search_type like '%$search_value%' and payments.bookingid=bookings.bookingid");
                            } else {
                              $TotalAmountPaid = SELECT("SELECT sum(net_paid) FROM payments, bookings where payments.bookingid=bookings.bookingid");
                            }
                            while ($fetchtotalpayment = mysqli_fetch_array($TotalAmountPaid)) {
                              $TotalPayment = $fetchtotalpayment['sum(net_paid)'];
                            }
                            if ($TotalPayment == null) {
                              $TotalPayment = 0;
                            } else {
                              $TotalPayment = $TotalPayment;
                            }
                            ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <h4 class="section-heading app-bg">Booking Details</h4>
                      <table class="table table-striped">
                        <tr>
                          <th>Parking Status</th>
                          <td><?php echo $parking_status; ?></td>
                        </tr>
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
                        <?php
                        //unit details
                        $UnitSQL = "SELECT * FROM project_units where project_units_id='$project_unit_id'";
                        $project_block_id = FETCH($UnitSQL, "project_block_id");
                        $project_floor_id = FETCH($UnitSQL, "project_floor_id");

                        $project_block_name = FETCH("SELECT project_block_name FROM project_blocks where project_block_id='$project_block_id'", "project_block_name");
                        $projects_floor_name = FETCH("SELECT projects_floor_name from projects_floors WHERE projects_floors_id='$project_floor_id'", "projects_floor_name");
                        $projects_floors_tag = FETCH("SELECT projects_floors_tag from projects_floors WHERE projects_floors_id='$project_floor_id'", "projects_floors_tag");
                        $project_unit_bhk_type = FETCH("SELECT project_unit_bhk_type FROM project_units where project_units_id='$project_unit_id'", "project_unit_bhk_type");
                        $project_unit_highlights = FETCH("SELECT project_unit_highlights FROM project_units where project_units_id='$project_unit_id'", "project_unit_highlights");
                        $unit_broker_rate = FETCH("SELECT unit_broker_rate FROM project_units where project_units_id='$project_unit_id'", "unit_broker_rate");

                        ?>
                        <tr>
                          <th>Block Number</th>
                          <td><?php echo $project_block_name; ?></td>
                        </tr>
                        <tr>
                          <th>Floor Number</th>
                          <td><?php echo $projects_floor_name; ?></td>
                        </tr>
                        <tr>
                          <th>BHK Details</th>
                          <td><?php echo $project_unit_bhk_type; ?></td>
                        </tr>
                        <tr>
                          <th>Unit No</th>
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


                    <div class="col-md-6">
                      <h4 class="section-heading app-bg">Booking More Details</h4>
                      <table class="table table-striped">
                        <tr>
                          <th>Booking Date</th>
                          <td><?php echo DATE_FORMATE2("d M, Y", $booking_date); ?></td>
                        </tr>
                        <tr>
                          <th>Booking Created at</th>
                          <td><?php echo DATE_FORMATE2("d M, Y", $created_at); ?></td>
                        </tr>
                        <tr>
                          <th>Possession Status</th>
                          <td><?php echo $possession; ?></td>
                        </tr>
                        <tr>
                          <th>Possession last Update</th>
                          <td><?php echo DATE_FORMATE2("d M, Y", $possession_update_date); ?></td>
                        </tr>
                        <tr>
                          <th>Possession Notes</th>
                          <td><?php echo $possession_notes; ?></td>
                        </tr>
                        <tr>
                          <th>CRN No</th>
                          <td><?php echo $crn_no; ?></td>
                        </tr>
                        <tr>
                          <th>Ref No</th>
                          <td><?php echo $ref_no; ?></td>
                        </tr>

                      </table>
                    </div>
                    <style>
                      .table-payments table tr,
                      td {
                        font-size: 9px !important;
                      }
                    </style>
                  </div>
                  <div class="col-md-6">
                    <h4 class="section-heading app-bg">Bank Loan details</h4>
                    <form action="../../../controller/bookingcontroller.php" method="POST" class="row">
                      <?php FormPrimaryInputs(true, [
                        "booking_main_id" => $bookingid,
                      ]); ?>
                      <div class="form-group col-md-6">
                        <label>Select Bank</label>
                        <select onchange="form.submit()" name="booking_bank_name" class="form-control">
                          <?php echo InputOptions(
                            BANK_LIST,
                            FETCH($BankLoanSql, "booking_bank_name")
                          ); ?>
                        </select>
                      </div>
                      <div class="form-group col-md-6">
                        <label>Bank IFSC Code</label>
                        <input onchange="form.submit()" type="text" value='<?php echo FETCH($BankLoanSql, "booking_bank_ifsc_code"); ?>' name="booking_bank_ifsc_code" class="form-control" placeholder="IFSC CODE:">
                      </div>
                      <div class="form-group col-md-6">
                        <label>Santion Amount</label>
                        <input onchange="form.submit()" type="text" value='<?php echo FETCH($BankLoanSql, "booking_santion_amount"); ?>' name="booking_santion_amount" class="form-control" placeholder="In Rs.">
                      </div>
                      <div class="form-group col-md-6">
                        <label>Receive Amount</label>
                        <input onchange="form.submit()" type="text" value='<?php echo FETCH($BankLoanSql, "booking_receive_amount"); ?>' name="booking_receive_amount" class="form-control" placeholder="In Rs.">
                      </div>
                      <div class="form-group col-md-12">
                        <label>Other Notes/Remarks</label>
                        <textarea onchange="form.submit()" name="booking_loan_notes" rows="5" class="form-control"><?php echo SECURE(FETCH($BankLoanSql, "booking_loan_notes"), "d"); ?></textarea>
                      </div>
                    </form>
                  </div>
                  <div class="col-md-6">
                    <h4 class="section-heading app-bg">Payment History</h4>
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
                          $payment_mode = "CHEQUE";
                          if ($paymentstatus == "Clear") {
                            $TotalPaymentReceived += $FetchPayments['net_paid'];
                          } else {
                            $TotalPaymentReceived += 0;
                          }
                        }
                      ?>
                        <tr>
                          <td class="text-left" style="text-align:left !important;font-size:12px !important;"><?php echo strtoupper($payment_mode); ?></td>
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
                        <td colspan="7"><span class="text-grey">Total Paid (<?php echo round($PaymentforProjects / $net_payable_amount * 100, 2); ?>%) &nbsp;</span><span class="text-primary fs-16">Rs.<?php echo $PaymentforProjects; ?></span></td>
                      </tr>
                      <?php
                      $CheckSqlForReSale = CHECK("SELECT * FROM booking_resales where booking_main_id='$bookingid' and booking_resale_type='TRANSFER'");
                      if ($CheckSqlForReSale != null) {
                        $PreviousBookingId = FETCH("SELECT * FROM bookings where bookingid!='$bookingid' and project_unit_id='$project_unit_id' ORDER BY bookingid DESC limit 1", "bookingid");
                        $PreviousPayment = GetNetPaidAmount($PreviousBookingId);
                      } else {
                        $PreviousPayment = 0;
                      }
                      if ($PreviousPayment != 0) {
                      ?>
                        <tr>
                          <td colspan="7"><span class="text-grey">Previously Paid &nbsp;</span>
                            <span class="text-dark fs-16">Rs.<?php echo $PreviousPayment; ?></span>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="7"><span class="text-grey">Net Paid (<?php echo round($PreviousPayment + $PaymentforProjects / $net_payable_amount * 100, 2); ?>%) &nbsp;</span>
                            <span class="text-dark fs-16">Rs.<?php echo $PreviousPayment + $PaymentforProjects; ?></span>
                          </td>
                        </tr>
                      <?php
                      }
                      ?>
                      <tr>
                        <td colspan="7"><span class="text-grey">Net Payable (100%) &nbsp;</span><span class="text-dark fs-16">Rs.<?php echo $net_payable_amount; ?></span></td>
                      </tr>
                      <tr>
                        <td align="right"></td>
                        <td colspan="6"><span class="text-grey">Balance (<?php echo 100 - round($PaymentforProjects / $net_payable_amount * 100, 2); ?>%) &nbsp;</span><span class="text-danger fs-15">Rs.<?php echo round($net_payable_amount - ($PreviousPayment + $PaymentforProjects), 2); ?>
                          </span></td>
                      </tr>
                      <tr>
                        <td align="right"></td>
                        <td colspan="6"><span class="text-grey">Loan Amount &nbsp;</span><span class="text-warning fs-15">Rs.<?php echo FETCH("SELECT * FROM booking_loans where booking_main_id='$bookingid'", "booking_receive_amount"); ?></span></td>
                      </tr>
                    </table>
                  </div>
                  <div class="col-md-6">
                    <h4 class="section-heading app-bg">Other Charges</h4>
                    <table class="table table-striped text-right" align="right">
                      <tr class="text-right">
                        <th class="text-left">Action</th>
                        <th class="text-right">RefID</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Type</th>
                        <th class="text-center">Status</th>
                        <th class="text-right">Amount</th>
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
                        $netdevelopmentcharges += $developementchargeamount; ?>
                        <tr>
                          <td><a href="update-dev-charges.php?id=<?php echo $bookingid; ?>&did=<?php echo $devchargesid; ?>" class='btn btn-sm btn-default'><i class='fa fa-edit text-primary'></i> Update</a></td>
                          <td>DC<?php echo $devchargesid; ?></td>
                          <td><?php echo $developmentchargetitle; ?></td>
                          <td class='text-center'><span class='fs-11'><?php echo $developmentchargetype; ?></span></td>
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

                  <div class="col-md-6 table-payments">
                    <h4 class="section-heading app-bg">Other Charge Payments</h4>
                    <table class="table table-striped text-right" align="right">
                      <tr class="text-right">
                        <th>Receipt</th>
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
                        $devchargepaymentid = $fetchtotalpayment2['devchargepaymentid'];
                      ?>
                        <tr>
                          <td align="left" class="text-left">
                            <a href="../d-receipt.php?id=<?php echo $bookingid; ?>&pid=<?php echo $devchargepaymentid; ?>" class="btn btn-sm btn-default" target="_blank"><i class="fa fa-file-pdf-o text-danger"></i> Receipt</a>
                            <a href="edit-dev-charge.php?id=<?php echo $bookingid; ?>&pid=<?php echo $devchargepaymentid; ?>" class="btn btn-sm btn-default"><i class="fa fa-edit text-primary"></i> Edit</a>
                          </td>
                          <td><span class="text-info">DC<?php echo $developmentchargeid; ?></span></td>
                          <td><?php echo $devchargepaymentmode; ?></td>
                          <td><?php echo DATE_FORMATE2("d M, Y", $devpaymentreleaseddate); ?></td>
                          <td>
                            <?php echo $devpaymentstatus; ?>
                          </td>
                          <td><span class="text-success fs-14">Rs.<?php echo $devchargepaymentamount; ?></span></td>
                        </tr>
                      <?php } ?>
                      <tr>
                        <td colspan="5"><span class="text-grey">Total Paid</span></td>
                        <td>
                          <span class="text-primary fs-16"> Rs.<?php echo $netdevelopmentchargespaid; ?></span>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="5"><span class="text-grey">Net Payable</span></td>
                        <td>
                          <span class="text-black fs-15"> Rs.<?php echo $netdevelopmentcharges; ?></span>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="5"><span class="text-grey">Balance</span></td>
                        <td>
                          <span class="text-danger fs-14">
                            Rs.
                            <?php
                            $tolerance = 1e-10;  // or any other small value based on your requirements
                            if (abs($netdevelopmentcharges - $netdevelopmentchargespaid) < $tolerance) {
                              $result = 0;
                            } else {
                              $result = $netdevelopmentcharges - $netdevelopmentchargespaid;
                            }
                            echo $result;
                            ?>
                          </span>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="p-1">
                      <h4 class="section-heading app-bg">Commission Details</h4>
                      <?php
                      $DCom = FetchConvertIntoArray("SELECT * FROM commission where booking_id='$bookingid'", true);
                      $netCommission = 0;
                      $netPaid = 0;
                      $netBalance = 0;
                      if ($DCom == null) {
                        echo "<p class='data-list'>No Commission is disributed, please distribute commission</p>";
                      } else {
                        $netCommission = 0;
                        $netPaid = 0;
                        $netBalance = 0;
                        foreach ($DCom as $Data) {
                          $partner_id = $Data->partner_id;
                          $CSql = "SELECT * FROM users where id='$partner_id'";
                          $commission_id = $Data->commission_id;
                          $Paid = AMOUNT("SELECT * FROM commission_payouts where partner_id='$partner_id' and commission_id='$commission_id'", "commission_payout_amount", true);
                          $Balance = (int)$Data->commission_amount - (int)$Paid;

                          $netCommission += (int)$Data->commission_amount;
                          $netPaid += (int)$Paid;
                          $netBalance += (int)$Balance;
                          $commission_amount = $Data->commission_amount;
                      ?>
                          <p class="data-list">
                            <span>
                              <a href="<?php echo ADMIN_URL; ?>/partner/dashboard/?id=<?php echo $partner_id; ?>" class="text-primary">
                                <i class="fa fa-user"></i> <?php echo FETCH($CSql, "name"); ?>
                              </a> |
                              <b>Phone : </b> <?php echo FETCH($CSql, "phone"); ?> |
                              <b>CommissionType :</b> <?php echo $Data->commission_type; ?> |
                              <b>CommissionAmount :</b> <?php echo Price($commission_amount, "text-primary", "Rs."); ?> |
                              <b>Paid:</b> <?php echo Price($commission_amount, "text-success", "Rs."); ?> |
                              <b>Balance :</b> <?php echo Price($Balance, "text-danger", "Rs."); ?>
                            </span>
                            <?php
                            CONFIRM_DELETE_POPUP(
                              "remove_com",
                              [
                                "delete_commission_record" => true,
                                "control_id" => $Data->commission_id,
                              ],
                              "bookingcontroller",
                              "<i class='fa fa-trash'></i> Remove ",
                              "text-danger"
                            ) ?>
                          </p>
                      <?php }
                      } ?>
                      <p class="data-list bg-default border-danger">
                        <span><b>Total Commission:</b> <?php echo Price($netCommission, "text-primary", "Rs."); ?></span>
                        <span><b>Commission Paid:</b> <?php echo Price($netCommission, "text-success", "Rs."); ?></span>
                        <span><b>Commission Balance:</b> <?php echo Price($netBalance, "text-danger", "Rs."); ?></span>
                      </p>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <hr>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- possesion update -->
    <!-- Modal  3-->
    <div class="modal fade square" id="possession_update" role="dialog">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header app-bg text-white">
            <button type="button" class="close text-white m-r-8 m-t-1" data-dismiss="modal">&times;</button>
            <h4 class="modal-title text-white">Update Possession Details</h4>
          </div>
          <div class="modal-body overflow-auto">
            <form action="../../../controller/bookingcontroller.php" method="POST">
              <?php FormPrimaryInputs(true); ?>
              <div class="row">
                <div class="from-group col-md-12">
                  <label>Booking date</label>
                  <input type="date" name="booking_date" value="<?php echo $booking_date; ?>" class="form-control">
                </div>
                <div class="from-group col-md-12">
                  <label>Booking Created at</label>
                  <input type="date" name="created_at" value="<?php echo DATE_FORMATE2("Y-m-d", $created_at); ?>" class="form-control">
                </div>
                <div class="from-group col-md-12">
                  <label>Booking Clear Date</label>
                  <input type="date" name="clearing_date" value="<?php echo DATE_FORMATE2("Y-m-d", $clearing_date); ?>" class="form-control">
                </div>
                <div class="from-group col-md-12">
                  <label>Possession</label>
                  <select name="possession" class="form-control">
                    <?php InputOptions(["Yes" => "Yes", "No" => "No"], $possession); ?>
                  </select>
                </div>
                <div class="form-group col-md-12">
                  <label>Possession Notes</label>
                  <textarea style="height:100% !important;" class="form-control" name="possession_notes" rows="3"><?php echo $possession_notes; ?></textarea>
                </div>
              </div>
          </div>
          <div class=" modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" name="update_possession_status" value="<?php echo $BookingViewId; ?>" class="btn btn-success">Update Details</button>
            </form>
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
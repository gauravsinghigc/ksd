<?php
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Dashboard | <?php echo company_name; ?></title>
  <?php include '../../../include/header_files.php'; ?>
</head>

<body>
  <div id="container" class="navbar-fixed mainnav-fixed mainnav-lg">
    <?php include '../../header.php';
    if (isset($_GET['id'])) {
      $ViewCustomerId = $_GET['id'];
      $_SESSION['USER_VIEW_ID'] = $_GET['id'];
    } else {
      $ViewCustomerId = $_SESSION['USER_VIEW_ID'];
    }
    $CustomerId = $ViewCustomerId;
    $Select_Users = "SELECT * FROM users where id='$CustomerId'";
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
    $C_role_name = $C_UserTypes['role_name']; ?>
    <!--END NAVBAR-->
    <div class="boxed">
      <!--CONTENT CONTAINER-->
      <!--===================================================-->
      <div id="content-container">
        <!--Page content-->
        <!--===================================================-->
        <div id="page-content">
          <div class="panel">
            <div class="panel-body">
              <div class="row">
                <div class="col-md-12">
                  <h3 class="m-t-3"><i class="fa fa-user app-text"></i> Customer Details</h3>
                </div>
                <div class="col-md-12">
                  <div class="userWidget-1 m-b-0">
                    <div class="avatar app-bg">
                      <img src="<?php echo $C_user_profile_img; ?>" alt="avatar">
                      <div class="name osLight fs-20 p-b-2"> <?php echo $C_name ?> </div>
                      <a href="<?PHP echo DOMAIN; ?>/admin/customer/details/" class="btn btn-sm btn-primary square float-right m-t-5">Edit Profile</a>
                    </div>
                    <div class="title text-uppercase"> <?php echo $C_role_name ?> : <?php echo $ViewCustomerId; ?> </div>
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
                <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xs-12 c-dashboard-padding">
                  <div class="row bg-white m-0">
                    <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                      <div class="panel-bdr p-2r">
                        <h4>
                          <span class="count">
                            <?php echo TOTAL("SELECT * FROM bookings where customer_id='$CustomerId'"); ?>
                          </span>
                        </h4>
                        <span class="fs-14">Bookings</span>
                      </div>
                    </div>
                    <div class=" col-lg-2 col-md-3 col-sm-4 col-6">
                      <div class="panel-bdr p-2r">
                        <h4><i class="fa fa-inr text-success"></i>
                          <span class="count">
                            <?php
                            $TotalAmountPaid = SELECT("SELECT sum(net_payable_amount) FROM bookings where  bookings.company_id='" . company_id . "' and bookings.customer_id='$CustomerId'");
                            while ($fetchtotalpayment = mysqli_fetch_array($TotalAmountPaid)) {
                              $PaymentforProjects = $fetchtotalpayment['sum(net_payable_amount)'];
                            }
                            echo $TotalreceivableAmount = $PaymentforProjects; ?>
                          </span>
                        </h4>
                        <span class="fs-14">Total <span class="text-grey">(<?php echo $Full = 100; ?> %)</span></span>
                      </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-3 col-6">
                      <div class="panel-bdr p-2r">
                        <h4><i class="fa fa-inr text-success"></i>
                          <span class="count">
                            <?php
                            $PaymentWithoutCheck = SELECT("SELECT sum(net_paid) FROM payments, bookings where bookings.bookingid=payments.bookingid and bookings.company_id='" . company_id . "' and bookings.customer_id='$CustomerId' and payments.payment_mode!='check'");
                            while ($fetchtotalpayment = mysqli_fetch_array($PaymentWithoutCheck)) {
                              $TotalPaidAmountWithoutCheck = $fetchtotalpayment['sum(net_paid)'];
                            }

                            $PaymentWithCheck = SELECT("SELECT sum(net_paid) FROM payments, bookings, check_payments where bookings.bookingid=payments.bookingid and bookings.company_id='" . company_id . "' and bookings.customer_id='$CustomerId' and payments.payment_mode='check' and payments.payment_id=check_payments.payment_id and check_payments.checkstatus='Clear'");
                            while ($fetchtotalpayment = mysqli_fetch_array($PaymentWithCheck)) {
                              $TotalPaidAmountWithCheck = $fetchtotalpayment['sum(net_paid)'];
                            }

                            if ($TotalPaidAmountWithCheck == null or $TotalPaidAmountWithCheck == 0) {
                              $TotalPaidAmountWithCheck = 0;
                            } else {
                              $TotalPaidAmountWithCheck = (int)$TotalPaidAmountWithCheck;
                            }

                            if ($TotalPaidAmountWithoutCheck == null or $TotalPaidAmountWithoutCheck == 0) {
                              $TotalPaidAmountWithoutCheck = 0;
                            } else {
                              $TotalPaidAmountWithoutCheck = (int)$TotalPaidAmountWithoutCheck;
                            }

                            $netPaidAmount =  $TotalPaidAmountWithCheck + $TotalPaidAmountWithoutCheck;
                            ?>
                            <?php
                            $PaymentWithoutCheck2 = SELECT("SELECT sum(payment_amount) FROM payments, bookings where bookings.bookingid=payments.bookingid and bookings.company_id='" . company_id . "' and bookings.customer_id='$CustomerId' and payments.payment_mode!='check'");
                            while ($fetchtotalpayment2 = mysqli_fetch_array($PaymentWithoutCheck2)) {
                              $TotalPaidAmountWithoutCheck2 = $fetchtotalpayment2['sum(payment_amount)'];
                            }

                            $PaymentWithCheck2 = SELECT("SELECT sum(payment_amount) FROM payments, bookings, check_payments where bookings.bookingid=payments.bookingid and bookings.company_id='" . company_id . "' and bookings.customer_id='$CustomerId' and payments.payment_mode='check' and payments.payment_id=check_payments.payment_id and check_payments.checkstatus='Clear'");
                            while ($fetchtotalpayment2 = mysqli_fetch_array($PaymentWithCheck2)) {
                              $TotalPaidAmountWithCheck2 = $fetchtotalpayment2['sum(payment_amount)'];
                            }

                            if ($TotalPaidAmountWithCheck2 == null or $TotalPaidAmountWithCheck2 == 0) {
                              $TotalPaidAmountWithCheck2 = 0;
                            } else {
                              $TotalPaidAmountWithCheck2 = (int)$TotalPaidAmountWithCheck2;
                            }

                            if ($TotalPaidAmountWithoutCheck2 == null or $TotalPaidAmountWithoutCheck2 == 0) {
                              $TotalPaidAmountWithoutCheck2 = 0;
                            } else {
                              $TotalPaidAmountWithoutCheck2 = (int)$TotalPaidAmountWithoutCheck2;
                            }

                            $netPaidAmount2 =  $TotalPaidAmountWithCheck2 + $TotalPaidAmountWithoutCheck2;

                            $NetFeesandcharges = $netPaidAmount - $netPaidAmount2;
                            ?>
                            <?php
                            $TotalPendingamount = $TotalreceivableAmount - $netPaidAmount;
                            echo $TotalPendingamount;
                            if ($TotalreceivableAmount == 0) {
                              $PendingPercentage = 0;
                            } else {
                              $PendingPercentage = round((int)$netPaidAmount2 / (int)$TotalreceivableAmount * 100);
                            } ?>
                          </span>
                        </h4>
                        <span class="fs-14">Pending <span class="text-grey">(<?php echo $Pending = round(100 - $PendingPercentage); ?> %)</span></span>
                      </div>
                    </div>

                    <div class=" col-lg-2 col-md-3 col-sm-4 col-6">
                      <div class="panel-bdr p-2r">
                        <h4><i class="fa fa-inr text-success"></i>
                          <span class="count">
                            <?php echo $netPaidAmount2; ?>
                          </span>
                        </h4>
                        <span class="fs-14">Paid <span class="text-grey">(<?php echo round((int)$Full - (int)$Pending); ?>% )</span></span>
                      </div>
                    </div>

                    <div class="col-lg-2 col-md-3 col-sm-3 col-6">
                      <div class="panel-bdr p-2r">
                        <span class="cal-icon"><i class="fa fa-plus fs-18 text-black"></i></span>
                        <h4><i class="fa fa-inr text-success"></i>
                          <span class="count">
                            <?php echo $netPaidAmount - $netPaidAmount2; ?>
                          </span>
                        </h4>
                        <span class="fs-14">Fees & Charges</span>
                      </div>
                    </div>

                    <div class="col-lg-2 col-md-3 col-sm-3 col-6">
                      <div class="panel-bdr p-2r">
                        <span class="cal-icon"><i class="fa fa-equals fs-18 text-black">=</i></span>
                        <h4><i class="fa fa-inr text-success"></i>
                          <span class="count">
                            <?php echo $netPaidAmount; ?>
                          </span>
                        </h4>
                        <span class="fs-14">Net Paid</span>
                      </div>
                    </div>

                  </div>
                  <div class="panel">
                    <div class="panel-body pad-no">
                      <!--Default Tabs (Left Aligned)-->
                      <!--===================================================-->
                      <div class="tab-base">
                        <!--Nav Tabs-->
                        <ul class="nav nav-tabs">
                          <li class="active"> <a data-toggle="tab" href="#projects"> Projects</a> </li>
                          <li> <a data-toggle="tab" href="#address"> Booking</a> </li>
                          <li> <a data-toggle="tab" href="#payments"> Payments</a> </li>
                          <li> <a data-toggle="tab" href="#documents"> Documents</a> </li>
                        </ul>
                        <!--Tabs Content-->
                        <div class="tab-content">


                          <div id="projects" class="tab-pane fade active in">
                            <h3 class="p-1r">All Projects</h3>
                            <table class="table table-striped fs-13">
                              <thead>
                                <tr>
                                  <th style="width:5%;">#</th>
                                  <th>Project Details</th>
                                  <th>Project Unit</th>
                                  <th>Unit Rate</th>
                                  <th>Unit Cost</th>
                                  <th>Possession</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $nettotalprojectsoldamount = 0;
                                $SQL_customerprojects = TOTAL("SELECT * FROM bookings where bookings.customer_id='$CustomerId' ");
                                if ($SQL_customerprojects == 0) {
                                } else {
                                  $SQL_AllBookings = SELECT("SELECT * FROM bookings where bookings.customer_id='$CustomerId'");
                                  while ($FetchCustomerBookings = mysqli_fetch_array($SQL_AllBookings)) {
                                    $BookingsId[] = $FetchCustomerBookings['bookingid'];
                                  }
                                  $nettotalprojectsoldamount = 0;
                                  foreach ($BookingsId as $BookingId) {
                                    $SQL_AllBookings = SELECT("SELECT * FROM bookings where bookings.customer_id='$CustomerId' and bookingid='$BookingId'");
                                    $fetchBookings = mysqli_fetch_array($SQL_AllBookings);
                                    $project_list_id = $fetchBookings['project_list_id'];
                                    $project_unit_id = $fetchBookings['project_unit_id'];
                                    $unit_name = $fetchBookings['unit_name'];
                                    $unit_area = $fetchBookings['unit_area'];
                                    $unit_rate = $fetchBookings['unit_rate'];
                                    $unit_cost = $fetchBookings['unit_cost'];
                                    $possession = $fetchBookings['possession'];
                                    $net_payable_amount = $fetchBookings['net_payable_amount'];
                                    $nettotalprojectsoldamount += $unit_cost;

                                    $SQL_BookingProjects = SELECT("SELECT * FROM projects where Projects_id='$project_list_id'");
                                    $FetchBookingprojects = mysqli_fetch_array($SQL_BookingProjects);
                                    $project_title = $FetchBookingprojects['project_title'];
                                    $project_type = $FetchBookingprojects['project_type'];
                                    $project_area = $FetchBookingprojects['project_area'];
                                    $project_measure_unit = $FetchBookingprojects['project_measure_unit'];
                                    $project_created_at = $FetchBookingprojects['created_at'];
                                    $project_status = $FetchBookingprojects['project_status'];

                                    $SQL_BookingsUnits = SELECT("SELECT * FROM project_units where project_units_id='$project_unit_id'");
                                    $FetchBookingUnits = mysqli_fetch_array($SQL_BookingsUnits);
                                    $project_unit_measurement_unit = $FetchBookingUnits['project_unit_measurement_unit'];
                                    $projects_unit_type = $FetchBookingUnits['projects_unit_type'];
                                    $unit_created_at = $FetchBookingUnits['created_at'];
                                ?>
                                    <tr>
                                      <td align="center"><img src="<?php echo DOMAIN; ?>/storage/sys-img/project.png" class="img-fluid p-1r"></td>
                                      <td class="line-13 fs-11">
                                        <p class="fs-12 line-13">
                                          <span>
                                            #PRJ<?php echo $project_list_id; ?> | <b>Date:</b> <?php echo date("d M, Y", strtotime($project_created_at)); ?>
                                          </span>
                                          <span class="fs-12"> <br><b>Project : </b><?php echo $project_title; ?></span><br>
                                          <span class="fs-12">
                                            <b>Area :</b> <?php echo $project_area; ?> <?php echo $project_measure_unit; ?> <br>
                                            <b>Type:</b> <?php echo $project_type; ?>
                                          </span>
                                        </p>
                                      </td>
                                      <td class="line-13 fs-12">
                                        <p class="fs-12 line-13">
                                          <span>
                                            <b>Date:</b> <?php echo date("d M, Y", strtotime($unit_created_at)); ?>
                                          </span>
                                          <span class="fs-12"> <br><b>Plot No :</b> <?php echo $unit_name; ?></span><br>
                                          <span class="fs-12">
                                            <b>Area :</b> <?php echo $unit_area; ?><br>
                                            <b>Type :</b> <?php echo $projects_unit_type; ?>
                                          </span>
                                        </p>
                                      </td>
                                      <td><i class="fa fa-inr text-success"></i> <?php echo $unit_rate; ?> <?php echo $project_unit_measurement_unit; ?></td>
                                      <td><i class="fa fa-inr text-success"></i> <?php echo $unit_cost; ?></td>
                                      <td><?php echo $possession; ?></td>
                                      <td>
                                        <div class="btn-group">
                                          <a href="<?php echo DOMAIN; ?>/admin/booking/details/?id=<?php echo $BookingId; ?>" class="btn btn-sm btn-primary">View Details</a>
                                        </div>
                                      </td>
                                    </tr>
                                <?php }
                                } ?>
                                <tr>
                                  <td colspan="4" align="right">
                                    <spna class="text-grey">Total Unit Cost &nbsp; </spna>
                                  </td>
                                  <td colspan="2"><span class="text-primary fs-15">Rs.<?php echo $nettotalprojectsoldamount; ?></span></td>
                                  <td></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>

                          <div id="address" class="tab-pane fade in">
                            <h3 class="p-1r">All Bookings</h3>
                            <table class="table table-striped">
                              <thead>
                                <tr>
                                  <th style="width:5.5%;">#</th>
                                  <th>Bookings</th>
                                  <th>Unit Rate</th>
                                  <th>Unit Cost</th>
                                  <th>Charges</th>
                                  <th>Discounts</th>
                                  <th>Total Cost</th>
                                  <th>Possession</th>
                                  <th>Date</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $TotalBookingsamount = 0;
                                $SQL_customerprojects = TOTAL("SELECT * FROM bookings where bookings.customer_id='$CustomerId'");
                                if ($SQL_customerprojects == 0) {
                                } else {
                                  $SQL_AllBookings = SELECT("SELECT * FROM bookings where bookings.customer_id='$CustomerId'");
                                  $TotalBookingsamount = 0;
                                  while ($fetchBookings = mysqli_fetch_array($SQL_AllBookings)) {
                                    $bookingid = $fetchBookings['bookingid'];
                                    $bookingid2 = $fetchBookings['bookingid'];
                                    $project_list_id = $fetchBookings['project_list_id'];
                                    $project_unit_id = $fetchBookings['project_unit_id'];
                                    $unit_name = $fetchBookings['unit_name'];
                                    $unit_area = $fetchBookings['unit_area'];
                                    $unit_rate = $fetchBookings['unit_rate'];
                                    $unit_cost = $fetchBookings['unit_cost'];
                                    $possession = $fetchBookings['possession'];
                                    $net_payable_amount = (int)$fetchBookings['net_payable_amount'];
                                    $TotalBookingsamount += $net_payable_amount;
                                    $chargename = $fetchBookings['chargename'];
                                    $charges = $fetchBookings['charges'];
                                    $discountname = $fetchBookings['discountname'];
                                    $discount = $fetchBookings['discount'];
                                    $bookings_created_at = date("d M, Y", strtotime($fetchBookings['created_at']));
                                    $booking_status = $fetchBookings['status'];
                                    $booking_date = date("d M, Y", strtotime($fetchBookings['booking_date']));
                                    $clearing_date = $fetchBookings['clearing_date'];
                                    $bookingid = "B$BookingId/"  . date("m/Y", strtotime($fetchBookings['booking_date']));
                                    $matches = preg_replace('/[^0-9.]+/', '', $unit_area);
                                    $unit_area_in_numbers = (int)$matches;
                                    $possession_notes = SECURE($fetchBookings['possession_notes'], "d");
                                    $possession_update_date = $fetchBookings['possession_update_date'];

                                    $SQL_BookingsUnits = SELECT("SELECT * FROM project_units where project_units_id='$project_unit_id'");
                                    $FetchBookingUnits = mysqli_fetch_array($SQL_BookingsUnits);
                                    $project_unit_measurement_unit = $FetchBookingUnits['project_unit_measurement_unit'];
                                    $projects_unit_type = $FetchBookingUnits['projects_unit_type'];
                                    $unit_created_at = $FetchBookingUnits['created_at'];

                                ?>
                                    <tr>
                                      <td><img src="<?php echo DOMAIN; ?>/storage/sys-img/booking.png" class="img-fluid p-1r"></td>
                                      <td class="line-13">
                                        <a href="<?php echo DOMAIN; ?>/admin/booking/details/?id=<?php echo $bookingid2; ?>"><span class="text-info text-decoration-underline">#<?php echo $bookingid; ?></span></a>
                                        <br>
                                        | <?php echo $unit_name; ?><br>
                                        <span class="fs-11">
                                          <b>Area :</b> <?php echo $unit_area; ?> |<br>
                                          <b>Type:</b> <?php echo $projects_unit_type; ?>
                                        </span>
                                      </td>
                                      <td><i class="fa fa-inr text-success"></i><?php echo $unit_rate; ?> <?php echo $project_unit_measurement_unit; ?></td>
                                      <td><i class="fa fa-inr text-success"></i><?php echo $unit_cost; ?></td>
                                      <td class="line-13">
                                        + <i class="fa fa-inr text-success"></i><?php echo $unit_cost / 100 * $charges; ?><br>
                                        <span class="fs-11 text-grey"><?php echo $chargename; ?><br> ( <?php echo $charges; ?>% )</span>

                                      </td>
                                      <td class="line-13">
                                        - <i class="fa fa-inr text-success"></i><?php echo $unit_area_in_numbers * $discount; ?><br>
                                        <span class="fs-11 text-grey"><?php echo $discountname; ?> <br>( Rs.<?php echo $discount;  ?>/sq area )</span>
                                      </td>
                                      <td>
                                        <i class="fa fa-inr text-success"></i><?php echo $net_payable_amount; ?>
                                      </td>
                                      <td><?php echo $possession; ?></td>
                                      <td class="line-13">
                                        <span><b>Booking:</b> <?php echo $booking_date; ?></span><br>
                                        <span><b>Clearing: </b> <?php echo $clearing_date; ?></span><br>
                                        <span><b>Created At: </b> <?php echo $bookings_created_at; ?></span>
                                      </td>
                                      <td>
                                        <div class="btn-group">
                                          <a href="<?php echo DOMAIN; ?>/admin/booking/details/?id=<?php echo $bookingid2; ?>" target="blank" class="btn btn-sm btn-primary">View Details</a>
                                        </div>
                                      </td>
                                    </tr>
                                <?php }
                                }
                                ?>
                                <tr>
                                  <td colspan="6" align="right">
                                    <spna class="text-grey">Total Bookings &nbsp; </spna>
                                  </td>
                                  <td colspan="4"><span class="text-primary fs-15">Rs.<?php echo $TotalBookingsamount; ?></span></td>
                                  <td></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>

                          <div id="payments" class="tab-pane fade in">
                            <div class="flex-s-b">
                              <h3 class="m-b-0">All Payments</h3>
                              <div class="btn btn-group-sm">
                                <a href="<?php echo DOMAIN; ?>/admin/payments/search/" class="btn btn-sm btn-primary"> view EMI</a>
                              </div>
                            </div>
                            <table class="table table-striped">
                              <thead>
                                <tr>
                                  <th style="width:5%;">#</th>
                                  <th>RefId</th>
                                  <th>Details</th>
                                  <th>Date</th>
                                  <th>Type</th>
                                  <th>Amount</th>
                                  <th>Charges</th>
                                  <th>Discount</th>
                                  <th>Net Paid</th>
                                  <th>Status</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $SQL_BookingsPayments = SELECT("SELECT *, payments.charges AS payment_charges, payments.discounts AS payment_discounts FROM payments, bookings where payments.bookingid=bookings.bookingid and bookings.customer_id='$CustomerId' order by payments.payment_id DESC");
                                $TotalPaid = 0;
                                while ($FetchAllPayments = mysqli_fetch_assoc($SQL_BookingsPayments)) {
                                  $payment_mode = $FetchAllPayments['payment_mode'];
                                  $payment_id = $FetchAllPayments['payment_id'];
                                  $payment_amount = (int)$FetchAllPayments['payment_amount'];
                                  $slip_no = $FetchAllPayments['slip_no'];
                                  $remark = $FetchAllPayments['remark'];
                                  $payment_date = date("d M, Y", strtotime($FetchAllPayments['payment_date']));
                                  $created_at = date("d M, Y", strtotime($FetchAllPayments['created_at']));
                                  $charges_p = $FetchAllPayments['payment_charges'];
                                  $chargeamount_p = $FetchAllPayments['chargeamount'];
                                  $discounts_p = $FetchAllPayments['payment_discounts'];
                                  $discountamount_p = $FetchAllPayments['discountamount'];
                                  $payment_type = $FetchAllPayments['payment_type'];
                                  $emi_ids = "" . $FetchAllPayments['emi_ids'] . "";

                                  if ($payment_mode == "check") {
                                    $CheckPaymentsSQL = SELECT("SELECT * FROM check_payments where payment_id='$payment_id'");
                                    $fetchcheckpayments = mysqli_fetch_assoc($CheckPaymentsSQL);
                                    $checkissuedto = $fetchcheckpayments['checkissuedto'];
                                    $checknumber = $fetchcheckpayments['checknumber'];
                                    $bankName = $fetchcheckpayments['bankName'];
                                    $ifsc = $fetchcheckpayments['ifsc'];
                                    $checkstatus = $fetchcheckpayments['checkstatus'];
                                    $checkamount = $fetchcheckpayments['checkamount'];
                                    $check_created_at = $fetchcheckpayments['created_at'];
                                    $payment_status_fresh = $checkstatus;
                                    $payment_tracks = "<b>Issue To:</b> $checkissuedto <br> <b>Check no:</b> $checknumber <br> <b>Bank Name:</b> $bankName <br> <b>IFSC :</b> $ifsc <br> <b>Check Created AT :</b> $check_created_at <br> <b>Check Status :</b> $checkstatus";
                                  } else if ($payment_mode == "banking") {

                                    $bankpaymentSQL = SELECT("SELECT * from online_payments where payment_id='$payment_id'");
                                    $bankpaymentfetch = mysqli_fetch_assoc($bankpaymentSQL);
                                    $OnlineBankName = $bankpaymentfetch['OnlineBankName'];
                                    $transactionId = $bankpaymentfetch['transactionId'];
                                    $payment_detaile_online = $bankpaymentfetch['payment_details'];
                                    $payment_mode_online = $bankpaymentfetch['payment_mode'];
                                    $online_created_at = $bankpaymentfetch['created_at'];
                                    $transaction_status = $bankpaymentfetch['transaction_status'];
                                    $onlinepaidamount = $bankpaymentfetch['onlinepaidamount'];
                                    $payment_status_fresh = $transaction_status;
                                    $payment_tracks = "<b>Bank Name:</b> $OnlineBankName <br> <b>TxnID:</b> $transactionId <br> <b>Details :</b> $payment_detaile_online <br> <B>Pay Mode :</b> $payment_mode_online <br><b>Created at :</b> $online_created_at <br> <b>Status:</b> $transaction_status";
                                  } else if ($payment_mode == "cash") {
                                    $cashpaymentSQL = SELECT("SELECT * FROM cash_payments where payment_id='$payment_id'");
                                    $cashpaymentFetch = mysqli_fetch_assoc($cashpaymentSQL);
                                    $cashreceivername = $cashpaymentFetch['cashreceivername'];
                                    $cashamount = $cashpaymentFetch['cashamount'];
                                    $cash_created_at = $cashpaymentFetch['created_at'];
                                    $payment_status_fresh = "Received";
                                    $payment_tracks = "<b>Cash Amount:</b> Rs.$cashamount <br> <b>Received By:</b> $cashreceivername <br> <b>Received at :</b> $cash_created_at";
                                  }

                                  $net_paid = $FetchAllPayments['net_paid'];
                                  $TotalPaid += (int)$net_paid;
                                  if ($payment_mode == "check") {
                                    $pay_img = "check.png";
                                  } else if ($payment_mode == "banking") {
                                    $pay_img = "online.png";
                                  } else {
                                    $pay_img = "cash.png";
                                  } ?>

                                  <tr id="<?php echo $payment_mode; ?>_view">
                                    <td><img src="<?php echo DOMAIN; ?>/storage/sys-img/<?php echo $pay_img; ?>" class="img-fluid w-75"></td>
                                    <td>#<?php echo $payment_id; ?></td>
                                    <td class="line-13 fs-11">
                                      <p class="fs-11 line-13">
                                        <span><b>Slip No:</b> <?php echo $slip_no; ?></span><br>
                                        <span><b>Note:</b> <?php echo $remark; ?></span><br>
                                        <span><?php echo $payment_tracks; ?></span>
                                      </p>
                                    </td>
                                    <td class="line-13 fs-11">
                                      <p class="fs-11 line-13">
                                        <span><b>Created:</b> <?php echo $created_at; ?></span><br>
                                        <span><b>Payment:</b> <?php echo $payment_date; ?></span>
                                      </p>
                                    </td>
                                    <td><?php echo $payment_type; ?></td>
                                    <td class="fs-14">
                                      <i class="fa fa-inr text-success"></i> <?php echo $payment_amount; ?>
                                    </td>
                                    <td>
                                      + <i class="fa fa-inr text-success"></i> <?php echo round((int)$payment_amount / 100 * (int)$chargeamount_p); ?><br>
                                      <?php if ($chargeamount_p == null) {
                                      } else { ?>
                                        <span class="text-grey fs-12"><?php echo $chargeamount_p; ?>% for <?php echo $charges_p; ?></span>
                                      <?php } ?>
                                    </td>
                                    <td>
                                      - <i class="fa fa-inr text-success"></i> <?php echo round((int)$payment_amount / 100 * (int)$discountamount_p); ?><br>
                                      <?php if ($discountamount_p == null) {
                                      } else { ?>
                                        <span class="text-grey fs-12"><?php echo $discountamount_p; ?>% for <?php echo $discounts_p; ?></span>
                                      <?php } ?>
                                    </td>
                                    <td class="fs-12">
                                      <i class="fa fa-inr text-success"></i> <?php echo $net_paid; ?>
                                    </td>
                                    <td>
                                      <?php echo $payment_status_fresh; ?>
                                    </td>
                                  </tr>
                                <?php } ?>
                                <tr>
                                  <td align="right" colspan="8">Total Paid &nbsp;</td>
                                  <td><span class="text-primary fs-15" colspan="3">Rs.<?php echo $TotalPaid; ?></span></td>
                                  <td></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>

                          <div id="documents" class="tab-pane fade in">
                            <br>
                            <div class="flex-space-between section-heading">
                              <h4 class="mb-0 mt-1">Update Documents</h4>
                              <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add_documents"><i class="fa fa-upload"></i> Upload Document</a>
                            </div>
                            <br>
                            <div class='row'>
                              <div class="col-md-12">
                                <?php
                                $SQL_documents = SELECT("SELECT * FROM user_documents where user_id='$CustomerId'");
                                while ($FetchDocuments = mysqli_fetch_assoc($SQL_documents)) { ?>
                                  <p class="data-list">
                                    <span>
                                      Name : <b><?php echo $FetchDocuments['document_name']; ?></b> |
                                      DocNo : <b><?php echo $FetchDocuments['user_documents_no']; ?></b> |
                                      DocStatus : <b><?php echo $FetchDocuments['document_status']; ?></b> |
                                      <a href="<?php echo DOMAIN; ?>/storage/documents/<?php echo $CustomerId; ?>/<?php echo $FetchDocuments['document_file']; ?>" class="btn btn-sm btn-primary" target="_blank"><i class="fa fa-eye"></i> View File</a>
                                    </span>
                                    <span>
                                      <a href="#" class="btn btn-sm btn-info square" data-toggle="modal" data-target="#edit_documents_<?php echo $FetchDocuments['document_id']; ?>"><i class="fa fa-edit"></i> Update</a>
                                      <?php CONFIRM_DELETE_POPUP(
                                        "delete_documents",
                                        [
                                          "delete_customer_documents" => true,
                                          "control_id" => $FetchDocuments['document_id'],
                                        ],
                                        "usercontroller",
                                        "Remove",
                                        "btn btn-sm btn-danger"
                                      ) ?>
                                    </span>
                                  </p>
                                  <!-- Modal  3-->
                                  <div class="modal fade square" id="edit_documents_<?php echo $FetchDocuments['document_id']; ?>" role="dialog">
                                    <div class="modal-dialog modal-md">
                                      <div class="modal-content">
                                        <div class="modal-header app-bg text-white">
                                          <button type="button" class="close text-white m-r-8 m-t-1" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title text-white">Edit Documents</h4>
                                        </div>
                                        <div class="modal-body overflow-auto">
                                          <form action="../../../controller/usercontroller.php" method="POST" enctype="multipart/form-data">
                                            <?php FormPrimaryInputs(true); ?>
                                            <div class="row">
                                              <div class="from-group col-md-12">
                                                <label>Document Name</label>
                                                <input type="text" name="document_name" value="<?php echo $FetchDocuments['document_name']; ?>" class="form-control" placeholder="" required="">
                                              </div>
                                              <div class="from-group col-md-12">
                                                <label>Document No</label>
                                                <input type="text" name="user_documents_no" value="<?php echo $FetchDocuments['user_documents_no']; ?>" class="form-control" placeholder="" required="">
                                              </div>
                                              <div class="from-group col-md-12">
                                                <label>Attache File</label><br>
                                                <span class="text-info"> <small>Document is not editable, you have to upload next one in case of incorrect and other issue with documents</small></span><br>
                                                <span class="form-control"><?php echo $FetchDocuments['document_file']; ?></span>
                                                <a href="<?php echo DOMAIN; ?>/storage/users/<?php echo $CustomerId; ?>/documents/<?php echo $FetchDocuments['document_file']; ?>" class="btn btn-sm btn-primary" target="_blank"><i class="fa fa-eye"></i> view File</a>
                                              </div>
                                              <div class="from-group col-md-12"><br>
                                                <label>Document Status</label>
                                                <select name="document_status" class="form-control" value="" required="">
                                                  <option value="<?php echo $FetchDocuments['document_status']; ?>" selected=""><?php echo $FetchDocuments['document_status']; ?></option>
                                                  <option value="Received">Received!</option>
                                                  <option value="Checking...">Checking...</option>
                                                  <option value="Verified">Verified</option>
                                                  <option value="Unverified">Unverified</option>
                                                  <option value="Wrong Document">Wrong Documents</option>
                                                </select>
                                              </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                          <button type="submit" name="edit_documents" value="<?php echo $FetchDocuments['document_id']; ?>" class="btn btn-success" onclick="actionBtn('edit_<?php echo $FetchDocuments['document_id']; ?>', 'Updating...')" id="edit_<?php echo $FetchDocuments['document_id']; ?>">Save Updates</button>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                <?php } ?>
                              </div>
                            </div>
                          </div>

                          <!-- Modal  3-->
                          <div class="modal fade square" id="add_documents" role="dialog">
                            <div class="modal-dialog modal-md">
                              <div class="modal-content">
                                <div class="modal-header app-bg text-white">
                                  <button type="button" class="close text-white m-r-8 m-t-1" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title text-white">Upload Documents</h4>
                                </div>
                                <div class="modal-body overflow-auto">
                                  <form action="../../../controller/usercontroller.php" method="POST" enctype="multipart/form-data">
                                    <?php FormPrimaryInputs(
                                      true,
                                      [
                                        "user_id" => $ViewCustomerId,
                                      ]
                                    ); ?>
                                    <div class="row">
                                      <div class="from-group col-md-12">
                                        <label>Document Name</label>
                                        <input type="text" class="form-control" list="documentslist" name="document_name" value="" placeholder="">
                                        <datalist id="documentslist">
                                          <option value="PAN CARD"></option>
                                          <option value="ADHAAR CARD"></option>
                                          <option value="VOTAR CARD"></option>
                                          <option value="DRIVING LISCENCE"></option>
                                          <option value="PASSPORT"></option>
                                          <option value="RATION CARD"></option>
                                          <option value="PROPERTY PAPERS"></option>
                                          <option value="REGISTRY"></option>
                                          <option value="GENERAL POWER OF ATTORNY"></option>
                                          <option value="ELECTRICITY BILL"></option>
                                          <option value="WATER BILL"></option>
                                          <option value="MAINTENANCE BILL"></option>
                                          <option value="POSSESSION CERTIFICATE"></option>
                                          <option value="ALLOTMENT LETTER"></option>
                                          <option value="NO OBJECTION CERTIFICATE (NOC)"></option>
                                          <?php $FetchDocuments = FetchConvertIntoArray("SELECT * FROM user_documents GROUP BY document_name ORDER BY document_name DESC", true);
                                          if ($FetchDocuments != null) {
                                            foreach ($FetchDocuments as $Docs) { ?>
                                              <option value="<?php echo $Docs->document_name; ?>"></option>
                                          <?php }
                                          } ?>
                                        </datalist>
                                      </div>
                                      <div class="from-group col-md-12">
                                        <label>Document No</label>
                                        <input type="text" name="user_documents_no" value="" class="form-control" placeholder="" required="">
                                      </div>
                                      <div class="from-group col-md-12">
                                        <label>Attache File</label><br>
                                        <span class="text-info"> <small>Accepted formates : any media or document file</small></span>
                                        <input type="FILE" name="document_file" value="" class="form-control" placeholder="" required="">
                                      </div>
                                      <div class="from-group col-md-12">
                                        <label>Document Status</label>
                                        <select name="document_status" class="form-control" value="" required="">
                                          <option value="Received">Received!</option>
                                          <option value="Checking...">Checking...</option>
                                          <option value="Verified">Verified</option>
                                          <option value="Unverified">Unverified</option>
                                          <option value="Wrong Document">Wrong Documents</option>
                                        </select>
                                      </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                  <button type="submit" name="upload_documents" value="" class="btn btn-success">Upload Document</button>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>


                        </div>
                      </div>
                      <!--===================================================-->
                      <!--End Default Tabs (Left Aligned)-->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--===================================================-->
            <!--End page content-->
          </div>
          <!--===================================================-->
          <!--END CONTENT CONTAINER-->
          <script>
            function showpayments(data) {
              if (data === "cash") {
                document.getElementById("cash_view").style.visibility = "visible";
                document.getElementById("banking_view").style.visibility = "hidden";
                document.getElementById("check_view").style.visibility = "hidden";
              } else if (data === "banking") {
                document.getElementById("cash_view").style.visibility = "hidden";
                document.getElementById("banking_view").style.visibility = "visible";
                document.getElementById("check_view").style.visibility = "hidden";
              } else if (data === "check") {
                document.getElementById("cash_view").style.visibility = "hidden";
                document.getElementById("banking_view").style.visibility = "hidden";
                document.getElementById("check_view").style.visibility = "visible";
              } else {
                document.getElementById("cash_view").style.visibility = "visible";
                document.getElementById("banking_view").style.visibility = "visible";
                document.getElementById("check_view").style.visibility = "visible";
              }
            }
          </script>


          <!-- end -->
          <?php include '../../sidebar.php'; ?>
          <?php include '../../footer.php'; ?>
        </div>

        <?php include '../../../include/footer_files.php'; ?>
</body>

</html>
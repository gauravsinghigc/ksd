<?php
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';

//fresh booking data

if (isset($_GET['b_id'])) {
   $BookingViewId = $_GET['b_id'];
   $_SESSION['BOOKING_VIEW_ID'] = $_GET['b_id'];
} else {
   if (isset($_SESSION['BOOKING_VIEW_ID'])) {
      $BookingViewId = $_SESSION['BOOKING_VIEW_ID'];
   } else {
      $BookingViewId = "";
   }
}

if ($BookingViewId != null) {
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
   $possession_notes = SECURE($Bookings['possession_notes'], "d");
   $possession_update_date = $Bookings['possession_update_date'];
   $emi_months = $Bookings['emi_months'];
   $MainBookingID2 = "B$bookingid/" . date("m/Y", strtotime($created_at));

   //customer DETAILS
   $getusers = SELECT("SELECT * FROM users, user_address, user_roles where users.company_relation='" . company_id . "' and users.id='$customer_id' and users.user_role_id='4' and users.id=user_address.user_id and users.user_role_id=user_roles.role_id");
   $count = 0;
   $customers = mysqli_fetch_array($getusers);
   $count++;
   $customer_name2 = $customers['name'];
   $customer_phone2 = $customers['phone'];
   $customer_email2 = $customers['email'];
   $user_street_address2 = $customers['user_street_address'];
   $user_area_locality2 = $customers['user_area_locality'];
   $user_city2 = $customers['user_city'];
   $user_state2 = $customers['user_state'];
   $user_pincode2 = $customers['user_pincode'];
   $user_country2 = $customers['user_country'];
   $executedcustomer_id2 = $customers['user_id'];
   $customer_user_profile_img2 = $customers['user_profile_img'];
   $user_status2 = $customers['user_status'];
   $created_at_c2 = $customers['created_at'];
   $user_role_id2 = $customers['user_role_id'];
   $user_role_name2 = $customers['role_name'];
   $agent_relation2 = $customers['agent_relation'];
   if ($user_status2 == "ACTIVE") {
      $user_status_view2 = "<span class='text-success'><i class='fa fa-check-circle'></i> Active</span>";
   } else {
      $user_status_view2 = "<span class='text-danger'><i class='fa fa-warning'></i> Inactive</span>";
   }
   if ($customer_user_profile_img2 == "user.png") {
      $customer_user_profile_img2 = DOMAIN . "/storage/sys-img/$customer_user_profile_img2";
   } else {
      $customer_user_profile_img2 = DOMAIN . "/storage/users/$executedcustomer_id2/img/$customer_user_profile_img2";
   }

   //agent details
   $getusers_a = CHECK("SELECT * FROM users, user_address, user_roles where users.company_relation='" . company_id . "' and users.id='$partner_id' and users.id=user_address.user_id and users.user_role_id=user_roles.role_id");
   $count = 0;
   if ($getusers_a == null) {
      $customer_id_a = "0";
      $customer_name_a = "";
      $customer_phone_a = "";
      $customer_email_a = "";
      $user_street_address_a = "";
      $user_area_locality_a = "";
      $user_city_a = "";
      $user_state_a = "";
      $user_pincode_a = "";
      $user_country_a = "";
      $executedcustomer_id_a = "";
      $customer_user_profile_img_a = "";
      $user_status_a = "";
      $created_at_a = "";
      $user_role_id_a = "";
      $user_role_name_a = "";
   } else {
      $getusers_a = SELECT("SELECT * FROM users, user_address, user_roles where users.company_relation='" . company_id . "' and users.id='$partner_id' and users.id=user_address.user_id and users.user_role_id=user_roles.role_id");
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
   }
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
   $GetPAYMENTS = SELECT("SELECT * FROM payments where bookingid='$bookingid' ORDER BY payment_id  DESC");
   $payments = mysqli_fetch_array($GetPAYMENTS);
   $payment_amount = $payments['payment_amount'];
   $payment_mode = $payments['payment_mode'];
   $slip_no = $payments['slip_no'];
   $remark = $payments['remark'];
   $payment_date = $payments['payment_date'];
   $paymentcreatedat = $payments['created_at'];

   //total amount paid for thisbookings
   $TotalAmountPaid = SELECT("SELECT sum(payment_amount) FROM payments where bookingid='$bookingid'");
   while ($fetchtotalpayment = mysqli_fetch_array($TotalAmountPaid)) {
      $PaymentforProjects = $fetchtotalpayment['sum(payment_amount)'];
   }
} else {
   $net_payable_amount = 0;
}

if (isset($_GET['DEV_ID'])) {
   $Developmentchargeid = $_GET['DEV_ID'];
   $_SESSION['DEVELOPMENT_CHARGE_ID'] = $_GET['DEV_ID'];
} else {
   if (isset($_SESSION['DEVELOPMENT_CHARGE_ID'])) {
      $Developmentchargeid = $_SESSION['DEVELOPMENT_CHARGE_ID'];
   } else {
      $Developmentchargeid = "";
   }
}
if (isset($_SESSION['DEVELOPMENT_CHARGE_ID'])) {

   //development Charges
   $SqlDevcharges = SELECT("SELECT * FROM developmentcharges, bookings where developmentcharges.devchargesid='$Developmentchargeid' and developmentcharges.bookingid='$BookingViewId' and developmentcharges.bookingid=bookings.bookingid ORDER by developmentcharges.devchargesid ASC");
   $Countcharges = mysqli_num_rows($SqlDevcharges);
   if ($Countcharges != 0) {
      $netdevelopmentcharges3 = 0;
      $FetchDevCharges = mysqli_fetch_array($SqlDevcharges);
      $devchargesid3 = $FetchDevCharges['devchargesid'];
      $bookingid3 = $FetchDevCharges['bookingid'];
      $created_at3 = $FetchDevCharges['created_at'];
      $developmentchargetitle3 = $FetchDevCharges['developmentchargetitle'];
      $developmentchargepercentage3 = $FetchDevCharges['developmentchargepercentage'];
      $developmentchargetype3 = $FetchDevCharges['developmentchargetype'];
      $developmentcharge3 = $FetchDevCharges['developmentcharge'];
      $developementchargeamount3 = $FetchDevCharges['developementchargeamount'];
      $developmentchargecreatedat3 = $FetchDevCharges['developmentchargecreatedat'];
      $developmentchargestatus3 = $FetchDevCharges['developmentchargestatus'];
      $netdevelopmentcharges3 += $developementchargeamount3;

      //total amount paid for developmemnt charges previous
      $AllDevPaidCharges1 = "SELECT * FROM developmentcharges, developmentchargepayments where developmentcharges.bookingid='$bookingid' and developmentcharges.devchargesid=developmentchargepayments.developmentchargeid and devpaymentstatus like '%RECEIVED%'";
      $AllDevPaidCharges2 = "SELECT * FROM developmentcharges, developmentchargepayments where developmentcharges.bookingid='$bookingid' and developmentcharges.devchargesid=developmentchargepayments.developmentchargeid and devpaymentstatus like '%PAID%'";
      $AllDevPaidCharges3 = "SELECT * FROM developmentcharges, developmentchargepayments where developmentcharges.bookingid='$bookingid' and developmentcharges.devchargesid=developmentchargepayments.developmentchargeid and devpaymentstatus like '%CLEAR%'";

      $NetDevPaidAmount = AMOUNT($AllDevPaidCharges1, "devchargepaymentamount") + AMOUNT($AllDevPaidCharges2, "devchargepaymentamount") + AMOUNT($AllDevPaidCharges3, "devchargepaymentamount");
      $NetchargesPaid = $NetDevPaidAmount;
      if ($NetchargesPaid == null) {
         $NetchargesPaid = 0;
      } else {
         $NetchargesPaid = $NetchargesPaid;
      }

      $developmentchargebalance = (int)$netdevelopmentcharges3 - (int)$NetchargesPaid;
   }
} else {
   $Countcharges = 0;
   $developmentchargebalance = 0;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Add Development Charge Payments | <?php echo company_name; ?></title>
   <?php include '../../../include/header_files.php'; ?>
   <style>
      .btn-group label.btn-primary,
      label.btn-success,
      label.btn-info,
      label.btn-warning {
         height: 2.2rem !important;
         color: white !important;
      }
   </style>
</head>

<body>
   <div id="container" class="navbar-fixed mainnav-fixed mainnav-lg">
      <?php include '../../header.php'; ?>

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
                              <div class="col-md-12">
                                 <h3 class="m-t-3"><i class="fa fa-inr app-text"></i> Development Charge Payments</h3>
                                 <a href="../../booking/details/" class="btn btn-md btn-primary"><i class='fa fa-angle-left'></i> Back to Booking Dashboard</a>
                              </div>
                              <div class="col-md-12">
                                 <h4 class="m-b-15 section-heading">Search Bookings & Charges </h4>
                              </div>
                           </div>
                           <div class="row">
                              <form action="<?php echo get_url(); ?>" method="GET">
                                 <div class="form-group col-md-6">
                                    <label>Select Booking IDs</label>
                                    <select name="b_id" class="form-control" onchange="form.submit()">
                                       <option value="<?php echo $BookingViewId; ?>">Select</option>
                                       <?php
                                       $SqlBookings = SELECT("SELECT * FROM bookings ORDER by bookingid ASC");
                                       while ($FetchBookings = mysqli_fetch_array(($SqlBookings))) {
                                          $bookingid = $FetchBookings['bookingid'];
                                          $created_at = $FetchBookings['created_at'];
                                          $MainBookingID = "B$bookingid/" . date("m/Y", strtotime($created_at));
                                          $customer_id = $FetchBookings['customer_id'];

                                          if (isset($_SESSION['BOOKING_VIEW_ID'])) {
                                             if ($BookingViewId === $bookingid) {
                                                $selected = "selected=''";
                                             } else {
                                                $selected = "";
                                             }
                                          } else {
                                             $selected = "";
                                          }

                                          //customer details
                                          //customer DETAILS
                                          $getusers = SELECT("SELECT * FROM users, user_address, user_roles where users.company_relation='" . company_id . "' and users.id='$customer_id' and users.user_role_id='4' and users.id=user_address.user_id and users.user_role_id=user_roles.role_id");
                                          $count = 0;
                                          $customers = mysqli_fetch_array($getusers);
                                          $count++;
                                          $customer_name = $customers['name'];
                                          $customer_phone = $customers['phone'];
                                          $customer_email = $customers['email'];
                                       ?>
                                          <option value="<?php echo $bookingid; ?>" <?php echo $selected; ?>><?php echo $MainBookingID; ?> : <?php echo $customer_name; ?> : <?php echo $customer_phone; ?></option>
                                       <?php } ?>
                                    </select>
                                 </div>
                              </form>

                              <form action="<?php echo get_url(); ?>&" method="GET">
                                 <div class="form-group col-md-6">
                                    <label>Select Available Charges</label>
                                    <select name="DEV_ID" class="form-control" onchange="form.submit()">
                                       <option value="<?php echo $Developmentchargeid; ?>">Select</option>
                                       <?php
                                       $SqlDevcharges = SELECT("SELECT * FROM developmentcharges, bookings where developmentcharges.bookingid='$BookingViewId' and developmentcharges.bookingid=bookings.bookingid ORDER by developmentcharges.devchargesid ASC");
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
                                          <option value="<?php echo $devchargesid; ?>">DC<?php echo $devchargesid; ?> : <?php echo $developmentchargetitle; ?> : <?php echo $developmentchargetype; ?> : Rs.<?php echo $developementchargeamount; ?></option>

                                       <?php } ?>

                                    </select>
                                 </div>
                              </form>
                           </div>

                           <?php if (isset($_SESSION['BOOKING_VIEW_ID'])) { ?>
                              <div class="row">
                                 <div class="col-md-4 col-lg-4 col-sm-4 col-6">
                                    <div class="">
                                       <h4 class="app-bg br5 p-3 pl-1">Customer Details</h4>
                                    </div>
                                    <div class="row">
                                       <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xs-12 p-b-15">
                                          <div class="p-1r shadow-lg p-t-20 br10 hover-shadow app-bdr-top">
                                             <div class="header">
                                                <div class="row">
                                                   <div class="col-lg-3 col-md-3 col-sm-3 col-3 col-xs-3 pr-0 text-center flex-c">
                                                      <div class="avatar m-t-15">
                                                         <img src="<?php echo $customer_user_profile_img2; ?>" class="img-fluid" alt="<?php echo $customer_name2; ?>" title="<?php echo $customer_name2; ?>">
                                                      </div>
                                                   </div>
                                                   <div class="col-lg-9 col-md-9 col-sm-9 col-9 col-xs-9 pl-0">
                                                      <h5 class="m-t-4 m-b-3 fs-13 text-right text-grey italic">CUST ID : <?php echo $customer_id; ?></h5>
                                                      <h5 class="m-t-4 m-b-3 fs-13"><b><?php echo $customer_name2; ?></b></h5>
                                                      <p class="fs-12 lh-1-5 m-b-1 m-t-5">
                                                         <i class="fa fa-envelope-o text-danger"></i> <?php echo $customer_email2; ?><br>
                                                         <i class="fa fa-phone text-info"></i> <?php echo $customer_phone2; ?>
                                                      </p>
                                                   </div>
                                                   <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xs-12">
                                                      <p class="fs-12 lh-1-4 m-t-5">
                                                         <i class="fa fa-map-marker text-success"></i> <?php echo "$user_street_address2,  $user_area_locality2, $user_city2, $user_state2 $user_country2 - $user_pincode2"; ?>
                                                      </p>
                                                   </div>
                                                   <div class="clearfix"></div>

                                                </div>
                                             </div>
                                          </div>
                                          <div class="clearfix"></div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-4 col-lg-4 col-sm-4 col-6">

                                    <h4 class="app-bg br5 p-3 pl-1">Booking Details</h4>
                                    <table class="table table-striped">
                                       <tr>
                                          <th>Booking ID</th>
                                          <td><span class="text-info text-decoration-underline"><?php echo $MainBookingID2; ?></span></td>
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
                                 <?php if ($Countcharges != 0) { ?>
                                    <div class="col-md-4 col-lg-4 col-sm-4 col-6">
                                       <div class="">
                                          <h4 class="app-bg br5 p-3 pl-1">Development Charge Details</h4>
                                       </div>

                                       <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xs-12 p-b-15 p-1">
                                          <table class="table table-striped">
                                             <tr>
                                                <th>RefId</th>
                                                <td>
                                                   DC<?php echo $devchargesid3; ?>
                                                </td>
                                             </tr>
                                             <tr>
                                                <th>Charge Name</th>
                                                <td>
                                                   <?php echo $developmentchargetitle3; ?>
                                                </td>
                                             </tr>
                                             <tr>
                                                <th>Charge Type</th>
                                                <td>
                                                   <?php echo $developmentchargetype3; ?>
                                                </td>
                                             </tr>
                                             <tr>
                                                <th>Booking Amount</th>
                                                <td>
                                                   <span class="text-primary">Rs.<?php echo $net_payable_amount; ?></span>
                                                </td>
                                             </tr>
                                             <?php if ($developmentcharge3 == "PERCENTAGE") { ?>
                                                <tr>
                                                   <th>Applied in</th>
                                                   <td>
                                                      <?php echo $developmentcharge3; ?> (<?php echo $developmentchargepercentage3; ?>%)
                                                   </td>
                                                </tr>
                                             <?php } else { ?>
                                                <tr>
                                                   <th>Applied in</th>
                                                   <td>
                                                      <?php echo $developmentcharge3; ?>
                                                   </td>
                                                </tr>
                                             <?php } ?>
                                             <tr>
                                                <th> Amount </th>
                                                <td><span class="text-success"><i class="fa fa-plus fs-10"></i> Rs.<?php echo $developementchargeamount3; ?></span></td>
                                             </tr>
                                             <tr>
                                                <th> Net Payable Charges </th>
                                                <td><span class="text-black fs-16"> Rs.<?php echo $netdevelopmentcharges; ?></span></td>
                                             </tr>
                                             <tr>
                                                <th> Previously Paid </th>
                                                <td><span class="text-success fs-14">- Rs.<?php echo $NetchargesPaid; ?></span></td>
                                             </tr>
                                             <tr>
                                                <th> Balance </th>
                                                <td><span class="text-danger fs-14"> Rs.<?php echo $developmentchargebalance = $developementchargeamount3 - $NetchargesPaid; ?></span></td>
                                             </tr>
                                          </table>
                                       </div>
                                    </div>
                                 <?php }
                                 ?>
                              </div>
                           <?php  } ?>

                           <div class="row">
                              <div class="col-md-12">
                                 <h4 class="section-heading">Payments Details </h4>
                              </div>
                           </div>

                           <form method="POST" action="../../../controller/developmentchargecontroller.php" class="">
                              <?php FormPrimaryInputs(true); ?>
                              <div class="row">
                                 <div class="col-lg-8 col-md-8 col-sm-6 col-12">
                                    <div class="row">
                                       <div class="btn-group-lg btn-group col-md-12 col-lg-12 col-sm-12 col-12">
                                          <label class="btn btn-success">
                                             <input type="radio" name="devchargepaymentmode" id="pay_mode" value="CASH" onclick="PaymentMode('cash')" checked="" hidden> Cash Payment
                                          </label>
                                          <label class="btn btn-warning">
                                             <input type="radio" name="devchargepaymentmode" id="pay_mode" value="BANKING" onclick="PaymentMode('banking')" hidden> Online Banking
                                          </label>
                                          <label class="btn btn-info">
                                             <input type="radio" name="devchargepaymentmode" id="pay_mode" value="CHEQUE" onclick="PaymentMode('check')" hidden> Cheque/DD Payment
                                          </label>
                                       </div>
                                    </div>

                                    <div style="display:none;" id="check">
                                       <div class="row">
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
                                                <label>Issue Date</label>
                                                <input type="date" value='<?php echo date("Y-m-d"); ?>' name="checkissuedate" value="" class="form-control">
                                             </div>
                                          </div>
                                          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                             <div class="form-group">
                                                <label>Cheque Status</label>
                                                <select class="form-control" name="checkstatus" id="checkissustatus" onchange="checkcheckstatus()">
                                                   <option value="Issued">Select Cheque Status</option>
                                                   <option value="Issued" selected>Issued</option>
                                                   <option value="CLEAR">Clear</option>
                                                </select>
                                             </div>
                                          </div>
                                          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                             <div class="form-group">
                                                <label>Clear Date</label>
                                                <input type="date" value='<?php echo date("Y-m-d"); ?>' name="checkcleardate" value="" class="form-control">
                                             </div>
                                          </div>
                                          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                             <div class="form-group">
                                                <label>Cheque Received By</label>
                                                <input type="text" name="chequereceivedby" value="" class="form-control">
                                             </div>
                                          </div>
                                       </div>
                                    </div>


                                    <div style="display:none;" id="banking">
                                       <div class="row">
                                          <div class="col-md-12">
                                             <h4><b>Online Banking</b></h4>
                                          </div>
                                          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                             <div class="form-group">
                                                <label>Online Payment Type</label>
                                                <select name="onlinepaymenttype" class="form-control">
                                                   <option value="NetBanking">Net Banking</option>
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
                                                   <option value="SUCCESS">Success</option>
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

                                    <div id="cash">
                                       <div class="row">
                                          <div class="col-md-12">
                                             <h4 class="bold"><b>Cash Payment</b></h4>
                                          </div>
                                          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                             <div class="form-group">
                                                <label>Cash Received By</label>
                                                <input type="text" name="cashreceivername" value="" class="form-control">
                                             </div>
                                          </div>

                                          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                             <div class="form-group">
                                                <label>Cash Received date</label>
                                                <input type="date" value='<?php echo date("Y-m-d"); ?>' name="cashreceivedate" class="form-control">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div>
                                       <div class="row">
                                          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                             <div class="form-group">
                                                <label>Paying Amount</label>
                                                <input type="text" name="devchargepaymentamount" required="" id="payingamount" oninput="CalculateBalance()" value="<?php if ($Countcharges != 0) {
                                                                                                                                                                        echo $developmentchargebalance;
                                                                                                                                                                     } else {
                                                                                                                                                                        echo 0;
                                                                                                                                                                     } ?>" class="form-control">
                                                <span class="text-danger fs-12" id="bmsg"></span>
                                             </div>
                                          </div>

                                          <div class="form-group col-md-12 col-lg-12 col-sm-12 col-12">
                                             <label>Payment Notes</label>
                                             <textarea class="form-control" name="devchargepaymentnotes" rows="5" required=""></textarea>
                                          </div>
                                          <?php
                                          if ($developmentchargebalance == 0) {
                                             $disabled = "hidden";
                                          } else {
                                             $disabled = "";
                                          } ?>
                                          <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                                             <a href="../../booking/details/" class="btn btn-md btn-default"><i class="fa fa-angle-left"></i> Back to Booking Dashboard</a>
                                             <button class="btn btn-success btn-md" type="submit" name="ReceivedDevelopmentChargePayments">Received Payments</button>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                    <h4 class="app-bg br5 p-3 pl-1">Payment Details</h4>
                                    <?php if ($Countcharges != 0) { ?>
                                       <table class="table table-striped">
                                          <tr>
                                             <th>RefId</th>
                                             <td>
                                                DC<?php echo $devchargesid3; ?>
                                             </td>
                                          </tr>
                                          <tr>
                                             <th>Charge Name</th>
                                             <td>
                                                <?php echo $developmentchargetitle3; ?>
                                             </td>
                                          </tr>
                                          <tr>
                                             <th>Charge Type</th>
                                             <td>
                                                <?php echo $developmentchargetype3; ?>
                                             </td>
                                          </tr>
                                          <tr>
                                             <th> Net Payable Amount </th>
                                             <td><span class="text-success">Rs.<?php echo $developmentchargebalance; ?></span></td>
                                          </tr>
                                          <tr>
                                             <th> Paying Amount </th>
                                             <td><span class="text-primary fs-14"> - Rs.<span id="showamount"><?php echo $developmentchargebalance; ?></span></span></td>
                                          </tr>
                                          <tr>
                                             <th> Balance </th>
                                             <td><span class="text-danger fs-14"> Rs.<span id="showbalance"><?php echo 0; ?></span></span></td>
                                          </tr>
                                       </table>

                                    <?php } ?>
                                 </div>


                              </div>
                           </form>
                        </div>
                     </div>
                  </div>

                  <!-- end -->
               </div>
               <!--===================================================-->
               <!--END CONTENT CONTAINER-->


               <script>
                  function PaymentMode(data) {
                     if (data == "cash") {
                        document.getElementById("cash").style.display = "block";
                        document.getElementById("check").style.display = "none";
                        document.getElementById("banking").style.display = "none";
                        document.getElementById("ifcheckisalloted").innerHTML = "";
                     } else if (data == "check") {
                        document.getElementById("cash").style.display = "none";
                        document.getElementById("check").style.display = "block";
                        document.getElementById("banking").style.display = "none";
                     } else if (data == "banking") {
                        document.getElementById("cash").style.display = "none";
                        document.getElementById("check").style.display = "none";
                        document.getElementById("banking").style.display = "block";
                        document.getElementById("ifcheckisalloted").innerHTML = "";
                     } else {
                        document.getElementById("cash").style.display = "block";
                        document.getElementById("check").style.display = "none";
                        document.getElementById("banking").style.display = "none";
                        document.getElementById("ifcheckisalloted").innerHTML = "";
                     }
                  }
               </script>

               <script>
                  function CalculateBalance() {
                     var payingamount = document.getElementById("payingamount");
                     var showamount = document.getElementById("showamount");
                     var showbalance = document.getElementById("showbalance");
                     var netpayable = <?php echo $developmentchargebalance; ?>;
                     var bmsg = document.getElementById("bmsg");

                     if (payingamount.value <= 0) {
                        showamount.innerHTML = <?php echo $developmentchargebalance; ?>;
                        showbalance.innerHTML = <?php echo $developmentchargebalance; ?>;
                        document.getElementById("submit_button").style.display = "none";
                     } else {
                        calculatebalance = +netpayable - +payingamount.value;
                        if (payingamount.value > netpayable) {
                           bmsg.innerHTML = "<i class='fa fa-warning'></i> Paying Amount cannot be Greater than Net Payable Amount";
                           document.getElementById("submit_button").style.display = "none";
                        } else if (payingamount.value == 0 || payingamount.value < 0) {
                           bmsg.innerHTML = "<i class='fa fa-warning'></i> Paying Amount cannot be Zero!";
                           document.getElementById("submit_button").style.display = "none";
                        } else {
                           bmsg.innerHTML = "";
                           showamount.innerHTML = payingamount.value;
                           showbalance.innerHTML = calculatebalance;
                           document.getElementById("submit_button").style.display = "block";
                        }
                     }
                  }
               </script>
               <!-- end -->
               <?php include '../../sidebar.php'; ?>
               <?php include '../../footer.php'; ?>
            </div>
         </div>
      </div>
   </div>

   <?php include '../../../include/footer_files.php'; ?>
</body>

</html>
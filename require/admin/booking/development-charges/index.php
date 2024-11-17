<?php
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';

//fresh booking data

if (isset($_GET['b_id'])) {
   $BookingViewId = $_GET['b_id'];
   $_SESSION['BOOKING_VIEW_ID2'] = $_GET['b_id'];
} else {
   if (isset($_SESSION['BOOKING_VIEW_ID2'])) {
      $BookingViewId = $_SESSION['BOOKING_VIEW_ID2'];
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
   $getusers_a = SELECT("SELECT * FROM users, user_address, user_roles where users.company_relation='" . company_id . "' and users.id='$partner_id' and users.id=user_address.user_id and users.user_role_id=user_roles.role_id");
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Add Development Charges | <?php echo company_name; ?></title>
   <?php include '../../../include/header_files.php'; ?>
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
                                 <h3 class="m-t-3"><i class="fa fa-money app-text"></i> Development Charges</h3>
                              </div>
                              <div class="col-md-12">
                                 <h4 class="m-b-15 section-heading">Search Bookings </h4>
                              </div>
                           </div>

                           <form action="" method="GET" class="row">
                              <div class="form-group col-md-12">
                                 <label>Select Bookings</label>
                                 <select name="b_id" class="form-control" onchange="form.submit()">
                                    <?php
                                    $SqlBookings = SELECT("SELECT * FROM bookings ORDER by bookingid ASC");
                                    while ($FetchBookings = mysqli_fetch_array(($SqlBookings))) {
                                       $bookingid = $FetchBookings['bookingid'];
                                       $created_at = $FetchBookings['created_at'];
                                       $MainBookingID = "B$bookingid/" . date("m/Y", strtotime($created_at));
                                       $customer_id = $FetchBookings['customer_id'];

                                       if (isset($_SESSION['BOOKING_VIEW_ID2'])) {
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

                           <?php if (isset($_SESSION['BOOKING_VIEW_ID2'])) { ?>
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
                                                      <p class="lh-1-5 m-b-1 m-t-5">
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
                                 <div class="col-md-4 col-lg-4 col-sm-4 col-6">
                                    <div class="">
                                       <h4 class="app-bg br5 p-3 pl-1">Agent Details</h4>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xs-12 p-b-15 p-1">
                                       <div class="p-1r shadow-lg p-t-20 br10 hover-shadow app-bdr-top">
                                          <div class="header">
                                             <div class="row">
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-3 col-xs-3 pr-0 text-center flex-c">
                                                   <div class="avatar m-t-15">
                                                      <img src="<?php echo $customer_user_profile_img_a; ?>" class="img-fluid" alt="<?php echo $customer_name_a; ?>" title="<?php echo $customer_name_a; ?>">
                                                   </div>
                                                </div>
                                                <div class="col-lg-9 col-md-9 col-sm-9 col-9 col-xs-9 pl-0">
                                                   <h5 class="m-t-4 m-b-3 fs-13 text-right text-grey italic">AGENT ID : <?php echo $partner_id; ?></h5>
                                                   <h5 class="m-t-4 m-b-3 fs-13"><b><?php echo $customer_name_a; ?></b></h5>
                                                   <p class="lh-1-5 m-b-1 m-t-5">
                                                      <i class="fa fa-envelope-o text-danger"></i> <?php echo $customer_email_a; ?><br>
                                                      <i class="fa fa-phone text-info"></i> <?php echo $customer_phone_a; ?>
                                                   </p>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xs-12">
                                                   <p class="fs-12 lh-1-4 m-t-5">
                                                      <i class="fa fa-map-marker text-success"></i> <?php echo "$user_street_address_a,  $user_area_locality_a, $user_city_a, $user_state_a $user_country_a - $user_pincode_a"; ?>
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
                           <?php  } ?>

                           <div class="row">
                              <div class="col-md-12">
                                 <h4 class="section-heading">Development Charge Details </h4>
                              </div>
                           </div>
                           <form method="POST" action="../../../controller/developmentchargecontroller.php">
                              <?php FormPrimaryInputs(true); ?>
                              <div class="row">
                                 <div class="col-lg-8 col-md-8 col-sm-6 col-12">
                                    <div class="row">
                                       <div class="form-group col-md-6 col-lg-6 col-sm-6 col-12">
                                          <label class="">Development Charge Name</label>
                                          <input type="text" name="developmentchargetitle" oninput="chargeoverview()" required="" id="chargename" class="form-control" placeholder="">
                                       </div>
                                       <div class="form-group col-md-6 col-lg-6 col-sm6 col-12">
                                          <label>Development Charge Category</label>
                                          <select type="text" name="developmentchargetype" onchange="chargeoverviewcategory()" required="" id="chargecategory" class="form-control">
                                             <?php
                                             $Sqldevcharge = SELECT("SELECT * FROM developmentcharges GROUP BY developmentchargetype");
                                             while ($Ftchcharge = mysqli_fetch_array($Sqldevcharge)) { ?>
                                                <option value="<?php echo $Ftchcharge['developmentchargetype']; ?>"><?php echo $Ftchcharge['developmentchargetype']; ?></option>
                                             <?php } ?>
                                             <option value="Others">Others</option>
                                          </select>
                                       </div>
                                       <div style="display:none;" id="otherchargeview">
                                          <div class="form-group col-md-6 col-lg-6 col-sm-6 col-12">
                                             <label>Other Charge Category</label>
                                             <input type="text" name="otherchargecategory" id="otherchargecategory" oninput="chargeoverviewcategory2()" class="form-control">
                                          </div>
                                       </div>
                                       <div class="form-group col-md-6 col-lg-6 col-sm-6 col-12">
                                          <label>Apply Development in</label>
                                          <select class="form-control" name="developmentcharge" id="chargetypes" onchange="EnablePerOptions()" required="">
                                             <option value="FIX AMOUNT">Fix Amount</option>
                                             <option value="PERCENTAGE">Percentage</option>
                                          </select>
                                       </div>
                                       <div style="display:none;" id="percentageview">
                                          <div class="form-group col-md-6 col-lg-6 col-sm-6 col-12">
                                             <label>Development Charge in (%)</label>
                                             <input type="text" name="developmentchargepercentage" id="PercentageValue" oninput="CalculateDevcharges()" class="form-control">
                                          </div>
                                       </div>
                                       <div class="form-group col-md-6 col-lg-6 col-sm-6 col-12">
                                          <label>Development Charge Amount</label>
                                          <input type="text" name="developementchargeamount" oninput="chargeoverview()" id="FinalDevChargeAmount" class="form-control" required="">
                                          <span class="text-danger" id="alertmsg"></span>
                                       </div>
                                       <div class="form-group col-md-12 col-lg-12 col-sm-12 col-12">
                                          <label>Charge Description</label>
                                          <textarea class="form-control" name="developmentchargedescription" rows="5" oninput="chargeoverview()"></textarea>
                                       </div>

                                       <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                                          <a href='../details/index.php' class="btn btn-lg btn-default"><i class="fa fa-angle-left"></i> Back to Booking Dashboard</a>
                                          <button class="btn btn-success btn-lg" type="submit" name="CreateDevelopmentCharges">Create Development Charges</button>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                    <h4 class="app-bg br5 p-3 pl-1 mb-1 mt-0">Development Charge Overview</h4>
                                    <table class="table table-striped">
                                       <tr>
                                          <th>Name</th>
                                          <td align="right"><span id="chargename_view"></span></td>
                                       </tr>
                                       <tr>
                                          <th>Category</th>
                                          <td align="right"><span id="chargecategory_view"></span></td>
                                       </tr>
                                       <tr>
                                          <th>Charges In</th>
                                          <td align="right"><span id="chargetypes_view"></span></td>
                                       </tr>
                                       <tr>
                                          <th>Charge Amount</th>
                                          <td align="right"><span id="FinalDevChargeAmount_view" class="text-success fs-14"></span></td>
                                       </tr>
                                    </table>
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
                  function EnablePerOptions() {
                     var percentageview = document.getElementById("percentageview");
                     var chargetypes = document.getElementById("chargetypes");
                     if (chargetypes.value === "PERCENTAGE") {
                        percentageview.style.display = "block";
                     } else {
                        percentageview.style.display = "none";
                     }
                  }
               </script>
               <script>
                  function CalculateDevcharges() {
                     var PercentageValue = document.getElementById("PercentageValue");
                     var FinalDevChargeAmount = document.getElementById("FinalDevChargeAmount");
                     var NetPayableAmount = <?php echo $net_payable_amount; ?>;

                     TotalDevelopmentChargeAmount = +NetPayableAmount / 100 * +PercentageValue.value;
                     TotalDevelopmentChargeAmount = Math.round(TotalDevelopmentChargeAmount);

                     if (TotalDevelopmentChargeAmount >= NetPayableAmount) {
                        document.getElementById("alertmsg").innerHTML = "Development Charge cannot be greater then Net Payable Amount!";
                     } else {
                        var chargetypes = document.getElementById("chargetypes");
                        var PercentageValue = document.getElementById("PercentageValue");
                        if (chargetypes.value === "PERCENTAGE") {
                           document.getElementById("chargetypes_view").innerHTML = chargetypes.value + " : (" + PercentageValue.value + "%) ";
                        } else {
                           document.getElementById("chargetypes_view").innerHTML = chargetypes.value;
                        }
                        FinalDevChargeAmount.value = TotalDevelopmentChargeAmount;
                        document.getElementById("FinalDevChargeAmount_view").innerHTML = "Rs." + FinalDevChargeAmount.value;
                        document.getElementById("alertmsg").innerHTML = "";
                     }
                  }
               </script>

               <script>
                  function chargeoverviewcategory() {
                     var chargecategory = document.getElementById("chargecategory");
                     var otherchargecategory = document.getElementById("otherchargecategory");

                     if (chargecategory.value === "Others") {
                        document.getElementById("otherchargeview").style.display = "block";
                     } else {
                        document.getElementById("otherchargeview").style.display = "none";
                     }

                     document.getElementById("chargecategory_view").innerHTML = chargecategory.value;

                  }
               </script>

               <script>
                  function chargeoverviewcategory2() {
                     var chargecategory = document.getElementById("chargecategory");
                     var otherchargecategory = document.getElementById("otherchargecategory");

                     document.getElementById("chargecategory_view").innerHTML = otherchargecategory.value;

                  }
               </script>

               <script>
                  function chargeoverview() {
                     var chargename = document.getElementById("chargename");
                     var chargecategory = document.getElementById("chargecategory");
                     var chargetypes = document.getElementById("chargetypes");
                     var PercentageValue = document.getElementById("PercentageValue");
                     var FinalDevChargeAmount = document.getElementById("FinalDevChargeAmount");
                     var otherchargecategory = document.getElementById("otherchargecategory");

                     if (chargecategory.value === "Others") {
                        document.getElementById("otherchargeview").style.display = "block";
                        document.getElementById("chargecategory_view").innerHTML = otherchargecategory.value;
                     } else {
                        document.getElementById("chargecategory_view").innerHTML = chargecategory.value;
                        document.getElementById("otherchargeview").style.display = "none";
                     }

                     document.getElementById("chargename_view").innerHTML = chargename.value;

                     if (chargetypes.value === "PERCENTAGE") {
                        document.getElementById("chargetypes_view").innerHTML = chargetypes.value + " : (" + PercentageValue.value + "%) ";
                     } else {
                        document.getElementById("chargetypes_view").innerHTML = chargetypes.value;
                     }
                     document.getElementById("FinalDevChargeAmount_view").innerHTML = "Rs." + FinalDevChargeAmount.value;
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
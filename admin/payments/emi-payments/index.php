<?php
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';

$PageTitle = "Search Customers";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php echo $PageTitle; ?> | <?php echo company_name; ?></title>
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
                      <h3 class="m-t-3"><i class="fa fa-search app-text"></i> Search Customers</h3>
                    </div>
                    <div class="col-md-12">
                      <style>
                        .dataTables_length {
                          display: none !important;
                        }
                      </style>
                      <table class="table table-striped" id="example">
                        <thead>
                          <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>SELECT</th>
                          </tr>
                        </thead>
                        <?php
                        if (isset($_GET['customer_id'])) {
                          $view_id = $_GET['customer_id'];
                          $GetUSERS = SELECT("SELECT * FROM users, user_address, user_roles where users.id='$view_id' and users.company_relation='$company_id' and users.user_role_id='4' and users.id=user_address.user_id and users.user_role_id=user_roles.role_id");
                        } else {
                          $GetUSERS = SELECT("SELECT * FROM users, user_address, user_roles where users.company_relation='$company_id' and users.user_role_id='4' and users.id=user_address.user_id and users.user_role_id=user_roles.role_id");
                        }
                        $count = 0;
                        while ($customers = mysqli_fetch_array($GetUSERS)) {
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
                          $created_at = $customers['created_at'];
                          $user_role_id = $customers['user_role_id'];
                          $user_role_name = $customers['role_name'];
                          $agent_relation = $customers['agent_relation'];

                          if (isset($_GET['customer_id'])) {
                            if ($_GET['customer_id'] == $executedcustomer_id) {
                              $selected = "bg-success";
                              $select_text = "Selected";
                              $select_class = "btn-danger";
                            } else {
                              $selected = "";
                              $select_text = "Select";
                              $select_class = "btn-success";
                            }
                          } else {
                            $selected = "";
                            $select_text = "Select";
                            $select_class = "btn-success";
                          }

                          if ($user_status == "ACTIVE") {
                            $user_status_view = "<span class='text-success'><i class='fa fa-check-circle'></i> Active</span>";
                          } else {
                            $user_status_view = "<span class='text-danger'><i class='fa fa-warning'></i> Inactive</span>";
                          }

                          if ($customer_user_profile_img == "user.png") {
                            $customer_user_profile_img = "$DOMAIN/storage/sys-img/$customer_user_profile_img";
                          } else {
                            $customer_user_profile_img = "$DOMAIN/storage/users/$executedcustomer_id/img/$customer_user_profile_img";
                          } ?>
                          <tr>
                            <td class="<?php echo $selected; ?>">CUST00<?php echo $executedcustomer_id; ?></td>
                            <td class="<?php echo $selected; ?>">
                              <img src="<?php echo $customer_user_profile_img; ?>" style="width:19px;height:19px;" alt="<?php echo $customer_name; ?>" title="<?php echo $customer_name; ?>">
                              <a href="<?php echo $DOMAIN; ?>/admin/customer/dashboard/?id=<?php echo $executedcustomer_id; ?>" class="text-primary"><?php echo $customer_name; ?></a>
                            </td>
                            <td class="<?php echo $selected; ?>">
                              <a href="tel=<?php echo $customer_phone; ?>" class="text-primary"><i class="fa fa-phone text-success"></i> <?php echo $customer_phone; ?></a>
                            </td>
                            <td class="fs-11 <?php echo $selected; ?>">
                              <span class="fs-11"><i class="fa fa-map-marker text-success"></i> <?php echo $user_street_address; ?> <?php echo $user_area_locality; ?> <?php echo $user_city; ?> <?php echo $user_state; ?> <?php echo $user_country; ?> - <?php echo $user_pincode; ?></span>
                            </td>
                            <td class="<?php echo $selected; ?>">
                              <div class="btn-group-sm btn-group">
                                <a href="?customer_id=<?php echo $executedcustomer_id; ?>&BOOKING_STEP_2=true" class="btn btn-sm <?php echo $select_class; ?>"><?php echo $select_text; ?></a>
                              </div>
                            </td>
                          </tr>
                        <?php }
                        ?>
                      </table>
                    </div>
                    <?php if (isset($_GET['customer_id'])) { ?>
                      <div class="col-md-12 text-center m-b10">
                        <a href="index.php" class="btn btn-sm btn-danger">Remove Selection <i class="fa fa-times"></i></a>
                      </div>
                    <?php } ?>
                  </div>
                  <div class="row m-t-10">
                    <?php if (isset($_GET['customer_id'])) { ?>
                      <div class="col-md-12">
                        <h3 class="section-heading">Customer Details & Bookings</h3>
                      </div>
                    <?php } ?>
                    <div class="col-md-6">
                      <?php
                      $customer_id = 0;
                      if (isset($_GET['customer_id'])) {
                        if ($_GET['customer_id'] != "" or $_GET['customer_id'] == null) {
                          $customer_id = $_GET['customer_id'];
                          $Check = CHECK("SELECT * FROM users, user_address, user_roles where users.company_relation='$company_id' and users.id='$customer_id' and users.user_role_id='4' and users.id=user_address.user_id and users.user_role_id=user_roles.role_id");
                          if ($Check != 0) {
                            $getusers = SELECT("SELECT * FROM users, user_address, user_roles where users.company_relation='$company_id' and users.id='$customer_id' and users.user_role_id='4' and users.id=user_address.user_id and users.user_role_id=user_roles.role_id");
                            $count = 0;
                            $customers = mysqli_fetch_array($getusers);
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
                      ?>
                            <div class="p-1r shadow-lg p-t-20 br10 hover-shadow app-bdr-top">
                              <div class="header">
                                <div class="row">
                                  <div class="col-lg-2 col-md-2 col-sm-2 col-2 col-xs-2 p-r-0">
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
                      <?php }
                        }
                      } ?>
                    </div>
                    <div class="col-md-6">
                      <?php

                      $GetBookings = SELECT("SELECT * FROM bookings where customer_id='$customer_id' ORDER BY bookingid DESC");
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

                        <a href="<?php echo $DOMAIN; ?>/admin/payments/emi-payments/emi-pay.php?bid=<?php echo $bookingid; ?>&emi_id=<?php echo $emi_id; ?>&emi_list_id=0" class="btn btn-lg btn-block btn-success p-2"><i class="fa fa-plus"></i> Collect EMI</a>

                      <?php }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>


    <?php include '../payment-popup.php'; ?>

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
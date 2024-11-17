<?php
require '../../require/modules.php';
require "../../require/admin/sessionvariables.php";
require '../../include/admin/common.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>All Cancelled Bookings | <?php echo company_name; ?></title>
  <?php include '../../include/header_files.php'; ?>
</head>

<body>
  <div id="container" class="navbar-fixed mainnav-fixed mainnav-lg">
    <?php include '../header.php'; ?>

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
                      <h3 class="m-t-3"><i class="fa fa-times app-text"></i> All Cancelled Bookings</h3>
                      <div class="flex-s-b">
                        <div class="btn-group btn-group-sm w-100 m-b-10">
                          <a href="<?php echo DOMAIN; ?>/admin/booking/new_booking.php" class="btn btn-primary square">New Booking</a>
                          <a class="btn btn-success square" href="<?php echo DOMAIN; ?>/admin/payments/search/">Receive Payment</a>
                          <a href="<?php echo DOMAIN; ?>/admin/booking/development-charges/" class="btn btn-primary square">ADD Dev Charges</a>
                          <a href="cancelled-bookings.php" class="btn btn-danger square">Cancelled Bookings</a>
                          <?php if (isset($_GET['search'])) { ?>
                            <a href="<?php echo DOMAIN; ?>/admin/booking/export_all.php?search_type=<?php echo $_GET['search_type']; ?>&search_value=<?php echo $_GET['search_value']; ?>&search=true" target="blank" class="btn btn-default square">Export All</a>
                          <?php } else { ?>
                            <a href="<?php echo DOMAIN; ?>/admin/booking/export_all.php" target="blank" class="btn btn-default square">Export All</a>
                          <?php } ?>
                        </div>
                        <br>
                        <div class="btn-group btn-group-sm w-100 m-b-10">
                          <form action="" method="GET" class="flex-s-b form-search-filter w-100">
                            <span class="w-100 p-1 text-right"><b>Search Bookings</b></span>
                            <select name="search_type" class="form-control" onchange="checkfiltertype()" id="filtertype">
                              <option value="bookings.bookingid">B ID</option>
                              <option value="bookings.customer_id">Customer ID</option>
                              <option value="bookings.partner_id">Agent ID</option>
                              <option value="bookings.unit_name">Unit ID</option>
                              <option value="bookings.project_name">Project Name</option>
                              <option value="bookings.booking_date">Booking Date</option>
                              <option value="bookings.clearing_date">Clearing Date</option>
                              <option value="bookings.created_at">Created Date</option>
                              <option value="bookings.possession">Possession</option>
                              <option value="bookings.possession_notes">Possession Notes</option>
                            </select>
                            <input type="text" name="search_value" class="form-control" id="filtervalue" placeholder="Enter Search Value">
                            <button type="submit" class="btn btn-sm btn-default m-l-5" name="search">Search</button>
                          </form>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12 col-sm-12 p-l-0 p-r-0 p-t-10">
                      <?php if (isset($_GET['search'])) { ?>
                        <center>
                          <p class="text-center app-bg shadow-lg br10 p-1 w-50 flex-s-b m-b-20">
                            <span><span>Search Results :</span> <?php echo $_GET['search_value']; ?></span>
                            <a href="index.php" class="text-danger"><span class="text-white"><i class="fa fa-times"></i> Clear</span></a>
                          </p>
                        </center>
                      <?php } ?>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>SNo</th>
                            <th>Booking ID</th>
                            <th>ProjectName/PlotId</th>
                            <th>PlotArea</th>
                            <th>Customer Name</th>
                            <th>Agent Name</th>
                            <th>Net Payable</th>
                            <th>Booking Date</th>
                            <th>Clearing date</th>
                            <th>CreatedAt</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          if (isset($_GET['search'])) {
                            $search_type = $_GET['search_type'];
                            $search_value = $_GET['search_value'];

                            if ($search_type === "bookings.booking_date") {
                              $search_value = date("d M, Y", strtotime($search_value));
                            } else if ($search_type === "bookings.clearing_date") {
                              $search_value = date("d M, Y", strtotime($search_value));
                            } else if ($search_type === "bookings.created_at") {
                              $search_value = date("d M, Y", strtotime($search_value));
                            } else {
                              $search_value = $search_value;
                            }
                            $GetBookings = SELECT("SELECT * FROM bookings where $search_type='$search_value' and status!='DELETED' ORDER BY bookingid DESC");
                          } else {
                            $GetBookings = SELECT("SELECT * FROM bookings where status!='DELETED' ORDER BY bookingid DESC limit 0, 20");
                          }
                          $nettotalpayments = 0;
                          $totalpaymentpaid = 0;
                          $SerialNo = 0;
                          while ($Bookings = mysqli_fetch_array($GetBookings)) {


                            $bookingid = $Bookings['bookingid'];
                            $CheckCencelledOrNot = CHECK("SELECT * FROM booking_cancelled where BookingCancelledBookingId='$bookingid'");
                            if ($CheckCencelledOrNot == true) {
                              $SerialNo++;
                              $project_name = $Bookings['project_name'];
                              $project_area = $Bookings['project_area'];
                              $unit_name = $Bookings['unit_name'];
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
                              $project_unit_id = $Bookings['project_unit_id'];
                              $emi_months = $Bookings['emi_months'];
                              $nettotalpayments += $net_payable_amount;

                              //update project units
                              $Update = UPDATE("UPDATE project_units SET project_unit_status='SOLD' where project_units_id='$project_unit_id'");


                              //customer DETAILS
                              $GetUsers = SELECT("SELECT * FROM users where id='$customer_id'");
                              $users = mysqli_fetch_array($GetUsers);
                              $customer_name = $users['name'];
                              $customer_phone = $users['phone'];
                              $customer_email = $users['email'];

                              //agent details
                              $GetAgents = SELECT("SELECT * FROM users where id='$partner_id'");
                              $agents = mysqli_fetch_array($GetAgents);
                              $partner_name = $agents['name'];
                              $partner_phone = $agents['phone'];
                              $partner_email = $agents['email'];

                              //customer Address
                              $Getuseraddress = SELECT("SELECT * FROM user_address where user_id='$customer_id'");
                              $useraddress = mysqli_fetch_array($Getuseraddress);
                              $user_street_address = $useraddress['user_street_address'];
                              $user_area_locality = $useraddress['user_area_locality'];
                              $user_city = $useraddress['user_city'];
                              $user_state = $useraddress['user_state'];
                              $user_pincode = $useraddress['user_pincode'];
                              $user_country = $useraddress['user_country'];



                              //total amount paid for thisbookings
                              $PaymentforProjects = 0;
                              $TotalAmountPaid = SELECT("SELECT * FROM payments where bookingid='$bookingid'");
                              while ($fetchtotalpayment = mysqli_fetch_array($TotalAmountPaid)) {
                                $payment_mode = $fetchtotalpayment['payment_mode'];
                                $payment_id = $fetchtotalpayment['payment_id'];

                                if ($payment_mode == "cash") {
                                  $PaymentforProjects += $fetchtotalpayment['net_paid'];
                                } elseif ($payment_mode == "banking") {
                                  $checkbankpayment = SELECT("SELECT * FROM online_payments where payment_id='$payment_id'");
                                  $checkbankpaymentstatus = mysqli_fetch_assoc($checkbankpayment);
                                  $transaction_status = $checkbankpaymentstatus['transaction_status'];
                                  if ($transaction_status == "Success") {
                                    $PaymentforProjects += $fetchtotalpayment['net_paid'];
                                  } else {
                                    $PaymentforProjects += 0;
                                  }
                                } elseif ($payment_mode == "check") {
                                  $SqlChequepayments = SELECT("SELECT * FROM check_payments where payment_id='$payment_id'");
                                  $FetchChequepayments = mysqli_fetch_assoc($SqlChequepayments);
                                  $checkstatus = $FetchChequepayments['checkstatus'];
                                  if ($checkstatus == "Clear") {
                                    $PaymentforProjects += $fetchtotalpayment['net_paid'];
                                  } else {
                                    $PaymentforProjects += 0;
                                  }
                                }
                              }

                              $totalpaymentpaid += $PaymentforProjects;

                          ?>
                              <tr loading="lazy">
                                <td><?php echo $SerialNo; ?></td>
                                <td>
                                  <a href="details/?id=<?php echo $bookingid; ?>" class="text-primary text-decoration-underline">
                                    B<?php echo $bookingid; ?>/<?php echo date("m/Y", strtotime($created_at)); ?>
                                  </a>
                                </td>
                                <td><?php echo $project_name; ?> (<?php echo $unit_name; ?>)</td>
                                <td><?php echo $unit_area; ?></td>
                                <td><a href="../customer/dashboard/?id=<?php echo $customer_id; ?>" class="text-primary"><i class="fa fa-user"></i> <?php echo $customer_name; ?></a></td>
                                <td><a href="../partner/dashboard/?id=<?php echo $partner_id; ?>" class="text-primary"><i class="fa fa-user"></i> <?php echo $partner_name; ?></a></td>
                                <td><span class="text-success">Rs.<?php echo $net_payable_amount; ?></span></td>
                                <td><?php echo DATE_FORMATE2("d M, Y", $booking_date); ?></td>
                                <td><?php echo DATE_FORMATE2("d M, Y", $clearing_date); ?></td>
                                <td><?php echo DATE_FORMATE2("d M, Y", $created_at); ?></td>
                              </tr>

                          <?php
                            }
                          } ?>
                        </tbody>
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



    <!-- end -->
    <?php include '../sidebar.php'; ?>
    <?php include '../footer.php'; ?>
  </div>

  <?php include '../../include/footer_files.php'; ?>
  <script>
    function checkfiltertype() {
      var filtertype = document.getElementById("filtertype");
      if (filtertype.value == "bookings.booking_date") {
        document.getElementById("filtervalue").type = "date";
      } else if (filtertype.value == "bookings.clearing_date") {
        document.getElementById("filtervalue").type = "date";
      } else if (filtertype.value == "bookings.created_at") {
        document.getElementById("filtervalue").type = "date";
      } else {
        document.getElementById("filtervalue").type = "text";
      }
    }
  </script>
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
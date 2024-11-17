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
  <title>All Booking | <?php echo company_name; ?></title>
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
                      <h3 class="m-t-3"><i class="fa fa-star app-text"></i> All Bookings</h3>
                      <div class="flex-s-b">
                        <div class="btn-group btn-group-sm w-100 m-b-10">
                          <a href="<?php echo DOMAIN; ?>/admin/booking/new_booking.php" class="btn btn-primary square">New Booking</a>
                          <a class="btn btn-success square" href="<?php echo DOMAIN; ?>/admin/payments/search/">Receive Payment</a>
                          <a href="<?php echo DOMAIN; ?>/admin/booking/development-charges/" class="btn btn-primary square">ADD Dev Charges</a>
                          <a href="cancelled-bookings.php" class="btn btn-danger square">Cancelled Bookings</a>
                          <?php if (isset($_GET['bookingid'])) {
                            $bookingid = $_GET['bookingid'];
                            $project_name = $_GET['project_name'];
                            $unit_name = $_GET['unit_name'];
                            $unit_area = $_GET['unit_area'];
                            $unit_rate = $_GET['unit_rate'];
                            $customer_id = $_GET['customer_id'];
                            $partner_id = $_GET['partner_id'];
                            $net_payable_amount = $_GET['net_payable_amount'];
                            $booking_date = $_GET['booking_date'];
                            $created_at = $_GET['created_at'];
                            $possession = $_GET['possession'];
                            $crn_no = $_GET['crn_no']; ?>
                            <a href="<?php echo DOMAIN; ?>/admin/booking/export_all.php?bookingid=<?php echo $bookingid; ?>&project_name=<?php echo $project_name; ?>&unit_name=<?php echo $unit_name; ?>&unit_area=<?php echo $unit_area; ?>&unit_rate=<?php echo $unit_rate; ?>&customer_id=<?php echo $customer_id; ?>&partner_id=<?php echo $partner_id; ?>&net_payable_amount=<?php echo $net_payable_amount; ?>&booking_date=<?php echo $booking_date; ?>&created_at=<?php echo $created_at; ?>&possession=<?php echo $possession; ?>&crn_no=<?php echo $crn_no; ?>" target="blank" class="btn btn-default square">Export All</a>
                          <?php } else { ?>
                            <a href="<?php echo DOMAIN; ?>/admin/booking/export_all.php" target="blank" class="btn btn-default square">Export All</a>
                          <?php } ?>
                        </div>
                        <div class="btn-group-sm btn-group w-100 pull-right">
                          <a onclick="Databar('filters')" class="btn btn-sm btn-primary pull-right"><i class="fa fa-search"></i> Search & Filters</a>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div id="filters" style="display:none;">
                        <div class="flex-s-b mb-3">
                          <h4 class="mb-0"><i class="fa fa-filter"></i> Filter Bookings</h4>
                          <?php if (isset($_GET['bookingid'])) { ?>
                            <a href="index.php" class="text-danger"><i class="fa fa-times"></i> Clear Filters</a>
                          <?php } ?>
                          <a onclick="Databar('filters')" class="text-danger"><i class="fa fa-times"></i> Hide Filters</a>
                        </div>
                        <form class="mt-5" action="" method="get">
                          <div class="row mt-2">
                            <div class="form-group col-md-2">
                              <label>Filter By Booking ID</label>
                              <input type="text" name="bookingid" value="<?php echo IfRequested("GET", "bookingid", "", false); ?>" onchange="form.submit()" class="form-control form-control-sm" list="bookingid">
                              <?php SUGGEST("bookings", "bookingid", "ASC"); ?>
                            </div>
                            <div class="form-group col-md-2">
                              <label>Filter By Project Name</label>
                              <input type="text" name="project_name" value="<?php echo IfRequested("GET", "project_name", "", false); ?>" onchange="form.submit()" class="form-control form-control-sm" list="project_name">
                              <?php SUGGEST("bookings", "project_name", "ASC"); ?>
                            </div>
                            <div class="form-group col-md-2">
                              <label>Filter By Plot No</label>
                              <input type="text" name="unit_name" value="<?php echo IfRequested("GET", "unit_name", "", false); ?>" onchange="form.submit()" class="form-control form-control-sm" list="unit_name">
                              <?php SUGGEST("bookings", "unit_name", "ASC"); ?>
                            </div>
                            <div class="form-group col-md-2">
                              <label>Filter By Plot Area</label>
                              <input type="text" name="unit_area" list="unit_area" value="<?php echo IfRequested("GET", "unit_area", "", false); ?>" onchange="form.submit()" class="form-control form-control-sm">
                              <?php SUGGEST("bookings", "unit_area", "ASC"); ?>
                            </div>
                            <div class="form-group col-md-2">
                              <label>Filter By Plot Rate</label>
                              <input type="text" name="unit_rate" list="unit_rate" value="<?php echo IfRequested("GET", "unit_rate", "", false); ?>" onchange="form.submit()" class="form-control form-control-sm">
                              <?php SUGGEST("bookings", "unit_rate", "ASC"); ?>
                            </div>
                            <div class="form-group col-md-2">
                              <label>Filter By Customer ID</label>
                              <input type="text" name="customer_id" list="customer_id" value="<?php echo IfRequested("GET", "customer_id", "", false); ?>" onchange="form.submit()" class="form-control form-control-sm">
                              <?php SUGGEST("bookings", "customer_id", "ASC"); ?>
                            </div>
                            <div class="form-group col-md-2">
                              <label>Filter By Agent ID</label>
                              <input type="text" name="partner_id" list="partner_id" value="<?php echo IfRequested("GET", "partner_id", "", false); ?>" onchange="form.submit()" class="form-control form-control-sm">
                              <?php SUGGEST("bookings", "partner_id", "ASC"); ?>
                            </div>
                            <div class="form-group col-md-2">
                              <label>Filter By Amount</label>
                              <input type="text" name="net_payable_amount" list="net_payable_amount" value="<?php echo IfRequested("GET", "net_payable_amount", "", false); ?>" onchange="form.submit()" class="form-control form-control-sm">
                              <?php SUGGEST("bookings", "net_payable_amount", "ASC"); ?>
                            </div>
                            <div class="form-group col-md-2">
                              <label>Filter By Booking Date</label>
                              <input type="date" name="booking_date" list="booking_date" value="<?php echo IfRequested("GET", "booking_date", "", false); ?>" onchange="form.submit()" class="form-control form-control-sm">
                              <?php SUGGEST("bookings", "booking_date", "ASC"); ?>
                            </div>
                            <div class="form-group col-md-2">
                              <label>Filter By Create Date</label>
                              <input type="date" name="created_at" list="created_at" value="<?php echo IfRequested("GET", "created_at", "", false); ?>" onchange="form.submit()" class="form-control form-control-sm">
                              <?php SUGGEST("bookings", "created_at", "ASC"); ?>
                            </div>
                            <div class="form-group col-md-2">
                              <label>Filter By Possession</label>
                              <input type="text" name="possession" list="possession" value="<?php echo IfRequested("GET", "possession", "", false); ?>" onchange="form.submit()" class="form-control form-control-sm">
                              <?php SUGGEST("bookings", "possession", "ASC"); ?>
                            </div>
                            <div class="form-group col-md-2">
                              <label>Filter By CRN NO</label>
                              <input type="text" name="crn_no" list="crn_no" value="<?php echo IfRequested("GET", "crn_no", "", false); ?>" onchange="form.submit()" class="form-control form-control-sm">
                              <?php SUGGEST("bookings", "crn_no", "ASC"); ?>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                    <?php
                    $TotalItems = TOTAL("SELECT * FROM bookings where status!='DELETED' ORDER BY bookingid DESC");
                    include "../../include/extra/data-counter.php";
                    ?>
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
                            <th>CreatedAt</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          if (isset($_GET['bookingid'])) {
                            $bookingid = $_GET['bookingid'];
                            $project_name = $_GET['project_name'];
                            $unit_name = $_GET['unit_name'];
                            $unit_area = $_GET['unit_area'];
                            $unit_rate = $_GET['unit_rate'];
                            $customer_id = $_GET['customer_id'];
                            $partner_id = $_GET['partner_id'];
                            $net_payable_amount = $_GET['net_payable_amount'];
                            $booking_date = $_GET['booking_date'];
                            $created_at = $_GET['created_at'];
                            $possession = $_GET['possession'];
                            $crn_no = $_GET['crn_no'];
                            $GetBookings = SELECT("SELECT * FROM bookings where crn_no like '%$crn_no%' and possession like '%$possession%' and DATE(created_at) like '%$created_at%' and DATE(booking_date) like '%$booking_date%' and net_payable_amount like '%$net_payable_amount%' and partner_id like '%$partner_id%' and customer_id like '%$customer_id%' and unit_rate like '%$unit_rate%' and unit_area like '%$unit_area%' and unit_name like '%$unit_name%' and bookingid like '%$bookingid%' and project_name like '%$project_name%' and status!='DELETED' order by bookingid DESC");
                          } else {
                            $GetBookings = SELECT("SELECT * FROM bookings where status!='DELETED' order by bookingid DESC limit $start, $listcounts");
                          }
                          $nettotalpayments = 0;
                          $totalpaymentpaid = 0;
                          $SerialNo = 0;
                          include "../../include/extra/serial-no.php";
                          while ($Bookings = mysqli_fetch_array($GetBookings)) {
                            $bookingid = $Bookings['bookingid'];
                            $CheckCencelledOrNot = CHECK("SELECT * FROM booking_cancelled where BookingCancelledBookingId='$bookingid'");
                            if ($CheckCencelledOrNot != true) {
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
                                <td><a href="../customer/dashboard/?id=<?php echo $customer_id; ?>" class="text-primary"><i class="fa fa-user"></i> (<?php echo $customer_id; ?>) <?php echo $customer_name; ?></a></td>
                                <td><a href="../partner/dashboard/?id=<?php echo $partner_id; ?>" class="text-primary"><i class="fa fa-user"></i> (<?php echo $partner_id; ?>) <?php echo $partner_name; ?></a></td>
                                <td><span class="text-success">Rs.<?php echo $net_payable_amount; ?></span></td>
                                <td><?php echo DATE_FORMATE2("d M, Y", $booking_date); ?></td>
                                <td><?php echo DATE_FORMATE2("d M, Y", $created_at); ?></td>
                              </tr>

                          <?php
                            }
                          } ?>
                        </tbody>
                      </table>
                      <?php include "../../include/extra/pagination.php"; ?>
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
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
  <title>Invoices | <?php echo company_name; ?></title>
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
                      <h3 class="m-t-3"><i class="fa fa-file-pdf-o app-text"></i> All Booking Invoices</h3>
                    </div>
                    <div class="col-md-12">
                      <div class="flex-s-b">
                        <div class="btn-group btn-group-sm w-100 m-b-10">
                          <a href="../payments/search/" class="btn btn-primary square btn-labeled fa fa-plus">Invoice</a>
                          <a href="<?php echo DOMAIN; ?>/admin/payments/export_all.php" target="blank" class="btn btn-secondary square btn-labeled fa fa-print">Export All</a>
                        </div>
                        <div class="btn-group btn-group-sm w-100 m-b-10">
                          <form action="" method="GET" class="flex-s-b form-search-filter w-100">
                            <span class="w-100 p-1 text-right"><b>Search Payments</b></span>
                            <select name="search_type" class="form-control">
                              <option value="bookings.bookingid">Booking ID</option>
                              <option value="bookings.customer_id">Customer ID</option>
                              <option value="bookings.partner_id">Agent ID</option>
                              <option value="payments.payment_mode">Payment Mode</option>
                              <option value="payments.payment_amount">Payment Amount</option>
                              <option value="payments.remark">Payment Remark</option>
                              <option value="payments.payment_mode">Payment Mode</option>
                              <option value="payments.created_at">Payment Date</option>
                            </select>
                            <input type="text" name="search_value" class="form-control" placeholder="Enter Search Value">
                            <button type="submit" class="btn btn-sm btn-default m-l-5" name="search">Search</button>
                          </form>
                        </div>

                      </div>
                    </div>
                    <?php echo CLEAR_SEARCH(); ?>
                    <div class="col-lg-12 col-md-12 col-12 col-sm-12 p-l-0 p-r-0">
                      <table class="table table-striped" id="example">
                        <thead>
                          <tr>
                            <th>RefId</th>
                            <th>BookingID</th>
                            <th>Customer</th>
                            <th>Agent</th>
                            <th>Payment Mode</th>
                            <th>NetPaid</th>
                            <th>Payment Date</th>
                            <th>Slip No</th>
                            <th>Type</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          if (isset($_GET['search'])) {
                            $search_type = $_GET['search_type'];
                            $search_value = $_GET['search_value'];
                            $getpayments = SELECT("SELECT *, payments.created_at AS 'payment_created_at' FROM payments, bookings where $search_type like '%$search_value%' and payments.bookingid=bookings.bookingid order by payments.payment_id ASC");
                          } else {
                            $getpayments = SELECT("SELECT *, payments.created_at AS 'payment_created_at' FROM payments, bookings where payments.bookingid=bookings.bookingid order by payments.payment_id ASC");
                          }
                          while ($FetchAllPayments = mysqli_fetch_array($getpayments)) {
                            $payment_id = $FetchAllPayments['payment_id'];
                            $bookingid = $FetchAllPayments['bookingid'];
                            $booking_date = date("m/Y", strtotime($FetchAllPayments['booking_date']));
                            $payment_mode = $FetchAllPayments['payment_mode'];
                            $payment_amount = $FetchAllPayments['payment_amount'];
                            $payment_date = $FetchAllPayments['payment_created_at'];
                            $slip_no = $FetchAllPayments['slip_no'];
                            $payment_id = $FetchAllPayments['payment_id'];
                            $created_at = $FetchAllPayments['created_at'];
                            $customer_id = $FetchAllPayments['customer_id'];
                            $net_paid_amount = $FetchAllPayments['net_paid'];
                            $partner_id = $FetchAllPayments['partner_id'];
                            $payment_type = $FetchAllPayments['payment_type'];

                            //select customer details
                            $SelectCustomers = SELECT("SELECT * FROM users where id='$customer_id'");
                            $CustomerDetails = mysqli_fetch_array($SelectCustomers);
                            $CustomerName = $CustomerDetails['name'];

                            //agent details
                            $SelectAgents = SELECT("SELECT * FROM users where id='$partner_id'");
                            $AgentDetails = mysqli_fetch_array($SelectAgents);
                            $AgentName = $AgentDetails['name'];

                          ?>
                            <tr>
                              <td><?php echo $payment_id; ?></td>
                              <td><a class=" text-primary text-decoration-underline" href="<?php echo DOMAIN; ?>/admin/booking/details/?id=<?php echo $bookingid; ?>">B<?php echo $bookingid; ?>/<?php echo date("m/Y", strtotime($created_at)); ?></a></td>
                              <td><a href="<?php echo DOMAIN; ?>/admin/customer/dashboard/?id=<?php echo $customer_id; ?>" class="text-primary"><i class="fa fa-user text-info"></i> <?php echo $CustomerName; ?></a></td>
                              <td><a href="<?php echo DOMAIN; ?>/admin/partner/dashboard/?id=<?php echo $partner_id; ?>" class="text-primary"><i class="fa fa-user text-info"></i> <?php echo $AgentName; ?></a></td>
                              <td><?php echo $payment_mode; ?></td>
                              <td class="text-success">Rs.<?php echo $net_paid_amount; ?></td>
                              <td><?php echo $payment_date; ?></td>
                              <td><?php echo $slip_no; ?></td>
                              <td><?php echo $payment_type; ?></td>
                              <td>
                                <a href="<?php echo DOMAIN; ?>/admin/booking/receipt.php?id=<?php echo $bookingid; ?>&payment_id=<?php echo $payment_id; ?>" target="blank" class="btn btn-sm btn-primary"><i class="fa fa-print"></i></a>
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
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php include '../payments/payment-popup.php'; ?>

    <!-- end -->
    <?php include '../sidebar.php'; ?>
    <?php include '../footer.php'; ?>
  </div>

  <?php include '../../include/footer_files.php'; ?>
</body>

</html>
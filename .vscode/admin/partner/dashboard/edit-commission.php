<?php
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';

if (isset($_GET['bookingid'])) {
  $bookingid = $_GET['bookingid'];
  $_SESSION['booking_id'] = $bookingid;
} else {
  $bookingid = $_SESSION['booking_id'];
}

$booking_id = $bookingid;

if (isset($_GET['commission_id'])) {
  $commission_id = $_GET['commission_id'];
  $_SESSION['commission_id'] = $commission_id;
} else {
  $commission_id = $_SESSION['commission_id'];
}

$BSql = "SELECT * FROM bookings where bookingid='$bookingid'";
$MainBookingID = "B$bookingid/" . date("m/Y", strtotime(FETCH($BSql, "created_at")));
$customer_id = FETCH($BSql, "customer_id");
$partner_id = FETCH($BSql, "partner_id");
$CoAllotySql = "SELECT * FROM booking_alloties where BookingAllotyMainBookingId='$bookingid' and BookingAllotyFullName!=''";
$CustomerSql = "SELECT * FROM users where id='$customer_id'";
$CustomerAddress = "SELECT * FROM user_address where user_id='$customer_id'";
$PartnerAddress = "SELECT * FROM user_address where user_id='$partner_id'";
$CommissionSql = "SELECT * FROM commission where booking_id='$booking_id' and commission_id='$commission_id'";

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

if (isset($_GET['search_type'])) {
  $search_type = IfRequested("GET", "search_type", false);
  $search_value = IfRequested("GET", "search_value", false);
  $Sql = "SELECT * FROM users where user_role_id='3' or user_role_id='5'";
  $SearchSql = FetchConvertIntoArray($Sql, true);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Agent Details | <?php echo company_name; ?></title>
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
                    <div class="col-md-12 flex-start">
                      <a href="index.php" class="btn btn-md btn-default"><i class="fa fa-angle-left"></i> Back to Agent Dashboad</a>
                      <h3 class="m-t-4 m-b-0 m-l-10"><i class="fa fa-angle-right"></i> Update Commision Details</h3>
                    </div>
                    <div class="col-md-4">
                      <h4 class="app-bg br5 p-3 pl-1">Booking Details</h4>
                      <table class="table table-striped">
                        <tr>
                          <th>Booking ID</th>
                          <td><span class="text-info text-decoration-underline"><?php echo $MainBookingID; ?></span></td>
                        </tr>
                        <tr>
                          <th>Project Name</th>
                          <td><?php echo FETCH($BSql, "project_name"); ?></td>
                        </tr>
                        <tr>
                          <th>Project Area</th>
                          <td><?php echo FETCH($BSql, "project_area"); ?></td>
                        </tr>
                        <tr>
                          <th>Unit No:</th>
                          <td><?php echo FETCH($BSql, "unit_name"); ?></td>
                        </tr>
                        <tr>
                          <th>Unit Area</th>
                          <td><?php echo FETCH($BSql, "unit_area"); ?></td>
                        </tr>
                        <tr>
                          <th>Unit Rate</th>
                          <td>Rs.<?php echo FETCH($BSql, "unit_rate"); ?> / sq area</td>
                        </tr>
                        <tr>
                          <th>Unit Cost</th>
                          <td><span>Rs.<?php echo FETCH($BSql, "unit_cost"); ?></span></td>
                        </tr>
                        <?php if (FETCH($BSql, "charges") != 0) { ?>
                          <tr>
                            <th>Charges <span class="text-grey fs-11 m-l-5"><?php echo FETCH($BSql, "chargename"); ?> ( <?php echo FETCH($BSql, "charges"); ?>% )</span></th>
                            <td>+ Rs.<?php echo (int)FETCH($BSql, "unit_cost") / 100 * (int)FETCH($BSql, "charges"); ?></td>
                          </tr>
                        <?php } ?>
                        <?php if (FETCH($BSql, "discount") != 0) { ?>
                          <tr>
                            <th>Discount <span class="text-grey fs-11 m-l-5"><?php echo FETCH($BSql, "discountname"); ?> ( Rs.<?php echo FETCH($BSql, "discount");  ?> )</span></th>
                            <td>- Rs.<?php echo (int)FETCH($BSql, "unit_area_in_numbers") * (int)FETCH($BSql, "discount"); ?></td>
                          </tr>
                        <?php } ?>
                        <tr>
                          <th>Net Sale Amount</th>
                          <td><span class="text-success fs-14">Rs.<?php echo FETCH($BSql, "net_payable_amount"); ?></span></td>
                        </tr>
                        <tr>
                          <th>Eligible Commission Amount</th>
                          <td>
                            <?php
                            $commission_id = $commission_id;
                            $CommissionSql = "SELECT * FROM commission where commission_id='$commission_id'";
                            $commission_amount = FETCH($CommissionSql, "commission_amount");
                            echo Price($commission_amount, "text-primary h4", "Rs.");
                            ?>
                          </td>
                        </tr>
                      </table>
                    </div>
                    <div class="col-md-4">
                      <h4 class="section-heading">Allotee Details</h4>
                      <p>
                        <b>Allotee Details</b><br>
                        <?php echo FETCH($CustomerSql, "name"); ?>,<br>
                        <?php echo FETCH($CustomerSql, "father_name"); ?><br>
                        <?php
                        echo FETCH($CustomerAddress, "user_street_address") . " ";
                        echo FETCH($CustomerAddress, "user_area_locality") . "<br>";
                        echo FETCH($CustomerAddress, "user_city") . " ";
                        echo FETCH($CustomerAddress, "user_state") . "<br>";
                        echo FETCH($CustomerAddress, "user_pincode") . " ";
                        echo FETCH($CustomerAddress, "user_country");
                        echo "<br>";
                        echo FETCH($CustomerSql, "phone") . "<BR>";
                        echo FETCH($CustomerSql, "email") . "<BR>";
                        ?>
                      </p>
                    </div>
                    <div class="col-md-4">
                      <h4 class="section-heading">Co-Allotee Details</h4>
                      <?php $Check = CHECK($CoAllotySql);
                      if ($Check != null) { ?>
                        <p>
                          <b>Co-Allotee Details</b><br>
                          <?php echo FETCH($CoAllotySql, "BookingAllotyRelation"); ?><br>
                          <?php echo FETCH($CoAllotySql, "BookingAllotyFullName"); ?><br>
                          <?php echo FETCH($CoAllotySql, "BookingAllotyFatherName"); ?><br>
                          <?php
                          echo FETCH($CoAllotySql, "BookingAllotyStreetAddress");
                          echo FETCH($CoAllotySql, "BookingAllotyArea") . "<br>";
                          echo FETCH($CoAllotySql, "BookingAllotyCity");
                          echo FETCH($CoAllotySql, "BookingAllotyState") . "<br>";
                          echo FETCH($CoAllotySql, "BookingAllotyCountry") . "";
                          echo FETCH($CoAllotySql, "BookingAllotyPincode");
                          echo "<br>";
                          echo FETCH($CoAllotySql, "BookingAllotyPhoneNumber") . "<BR>";
                          echo FETCH($CoAllotySql, "BookingAllotyEmail") . "<BR>";
                          ?>
                        </p>
                      <?php } else {
                        NoData("No Co-Allotee Details Found!");
                      } ?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <h3 class="section-heading">Agent Commission Details</h3>
                      <div class="row">
                        <div class="col-md-5">
                          <?php include "../../../include/admin/sections/agent-search-fix.php"; ?>
                          <hr><br>
                          <br<br><br><br><br><br><br>
                            <?php if (isset($_GET['partner_id'])) {
                              if (isset($_GET['commission_id'])) {
                                $commission_id = $_GET['commission_id'];
                                $CommissionSql = "SELECT * FROM commission where commission_id='$commission_id'";
                                $commission_type = FETCH($CommissionSql, "commission_type");
                                $commission_percentage = FETCH($CommissionSql, "commission_percentage");
                                $commission_rate_area = FETCH($CommissionSql, "commission_rate_area");
                                $commission_amount = FETCH($CommissionSql, "commission_amount");
                                $commission_remark = FETCH($CommissionSql, "commission_remark");
                                $total_area = FETCH($CommissionSql, "total_area");
                              } else {
                                $commission_type = "amount";
                                $commission_id = 0;
                                $commission_percentage = "";
                                $commission_rate_area = "";
                                $commission_amount = "";
                                $commission_remark = "";
                                $total_area = "";
                              }

                              $PayoutSql = "SELECT * FROM commission_payouts where commission_id='$commission_id'";
                            ?>
                              <form action="../../../controller/bookingcontroller.php" method="POST">
                                <?php FormPrimaryInputs(true, [
                                  "partner_id" => $_GET['partner_id'],
                                  "booking_id" => $bookingid,
                                  "commission_id" => $commission_id,
                                ]);

                                ?>
                                <div class="row">
                                  <h4 class='section-heading app-bg'>Update Eligible Commission Amount & Type</h4>
                                  <div class="col-md-6 form-group">
                                    <label>Commission Type</label>
                                    <select class="form-control" required="" id="commission_type_value" name="commission_type" onchange="CommissionType()">
                                      <?php InputOptions(
                                        [
                                          "amount" => "Fix Amount",
                                          "percentage" => "Percentage of Plot Amount",
                                          "area" => "As Per Area (Per Unit Square)"
                                        ],
                                        "$commission_type"
                                      ) ?>
                                    </select>
                                  </div>
                                </div>

                                <div id="amount">
                                  <div class="row">
                                    <div class="from-group col-md-6">
                                      <label>Amount <span class="text-danger" id="msgerr"></span></label>
                                      <input type="text" name="commission_amount_direct" value="<?php echo $commission_amount; ?>" id="commison_amount_" oninput="CheckcommissionAmount()" class="form-control" placeholder="">
                                    </div>
                                    <div class="from-group col-md-6">
                                      <label>Sale Amount</label>
                                      <input type="text" name="" value="<?php echo FETCH($BSql, "net_payable_amount"); ?>" readonly="" class="form-control" placeholder="">
                                    </div>
                                  </div>
                                </div>


                                <div id="percentage" style="display:none;">
                                  <div class="row">
                                    <div class="from-group col-md-6">
                                      <label>Percentage <span class="text-danger" id="msgerr"></span></label>
                                      <input type="text" name="commission_percentage" value="<?php echo round($commission_amount / FETCH($BSql, "net_payable_amount") * 100, 2); ?>" id="comm_per" oninput="CalculateCommissionPercentage()" class="form-control" placeholder="">
                                    </div>
                                    <div class="from-group col-md-6">
                                      <label>Sale Amount</label>
                                      <input type="text" name="sale_amount" value="<?php echo FETCH($BSql, "net_payable_amount");; ?>" readonly="" class="form-control" placeholder="">
                                    </div>
                                  </div>
                                </div>


                                <div id="area" style="display:none;">
                                  <div class="row">
                                    <div class="from-group col-md-6">
                                      <label>Total Unit Area <span class="text-danger" id="msgerr"></span></label>
                                      <input type="text" name="total_unit_area" value="<?php echo FETCH($BSql, "unit_area"); ?>" id="total_unit_area_com" readonly="" class="form-control" placeholder="">
                                    </div>
                                    <div class="from-group col-md-6">
                                      <label>Sale Rate <span class="text-danger" id="msgerr"></span></label>
                                      <input type="text" name="saler-rate" id="salerate" value="<?php echo FETCH($BSql, "unit_rate"); ?>" readonly="" class="form-control" placeholder="">
                                    </div>
                                    <div class="from-group col-md-6">
                                      <label>Total Unit Cost <span class="text-danger" id="msgerr"></span></label>
                                      <input type="text" value="<?php echo FETCH($BSql, "unit_cost"); ?>" readonly="" class="form-control" placeholder="">
                                    </div>
                                    <div class="from-group col-md-6">
                                      <label>Commission/Rate Per Unit Area</label>
                                      <input type="text" name="commission_rate_area" value="<?php echo $commission_rate_area; ?>" id="commission_rate_area_comm" oninput="CalculateCommissionArea()" class="form-control" placeholder="">
                                    </div>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-12">
                                    <hr>
                                    <span class="text-danger" id="areacommsg"></span>
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label>Paying Commision Amount</label>
                                    <input type="text" name="commission_amount" value="<?php echo $commission_amount; ?>" class="form-control" readonly="" id="payingcommission">
                                  </div>
                                  <div class=" form-group col-md-8 pt-3">
                                    <label>Commision Note/Remarks</label>
                                    <input type="text" name="commission_remark" value="<?php echo $commission_remark; ?>" class="form-control" placeholder="">
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-12">
                                    <hr>
                                    <?php BackBtnFor("Back to Agent Dashboard"); ?>
                                    <button type="submit" name="UpdateCommission" value="<?php echo $commission_id; ?>" class="btn btn-md btn-success">Update Commission <i class="fa fa-angle-double-right"></i></button>
                                  </div>
                                </div>
                              </form>
                            <?php }
                            ?>
                        </div>
                        <div class="col-md-7">
                          <h4 class="app-sub-heading">Previous Transactions</h4>
                          <?php
                          //fetch commission payouts
                          $NetCommissionAmount = 0;
                          $fetchAllCommissionPayouts = FetchConvertIntoArray("SELECT * FROM commission_payouts where commission_id='$commission_id'", true);
                          if ($fetchAllCommissionPayouts != null) {
                            foreach ($fetchAllCommissionPayouts as $Commission) {
                              $NetCommissionAmount += (int)$Commission->commission_payout_amount;
                          ?>
                              <p class="data-list">
                                <span class="w-pr-20">
                                  <span class="text-grey">TransactionDate</span><br>
                                  <span class='name h5'>
                                    <?php echo DATE_FORMATE2("d M, Y", $Commission->commission_payout_date); ?>
                                  </span>
                                </span>
                                <span class="w-pr-20">
                                  <span class="text-grey">TransactionType</span><br>
                                  <span class='name h5'>
                                    <?php echo $Commission->commission_payout_type; ?>
                                  </span>
                                </span>
                                <span class="w-pr-20">
                                  <span class="text-grey">TransactionMode</span><br>
                                  <span class='name h5'>
                                    <?php echo $Commission->commission_payout_payment_mode; ?>
                                  </span>
                                </span>
                                <span class="w-pr-20 text-right">
                                  <span class="text-grey">TransactionAmount</span><br>
                                  <span class='name h5 text-right'>
                                    <?php echo Price($Commission->commission_payout_amount, "text-success", "Rs."); ?>
                                  </span>
                                </span>
                                <span class="w-pr-10 text-right">
                                  <span class="text-grey">Action</span><br>
                                  <span class='name h5'>
                                    <a href="../../booking/docs/acr.php?comid=<?php echo $commission_id; ?>&txnid=<?php echo $Commission->commission_payout_id; ?>" class="text-primary" target="_blank"><i class="fa fa-print text-danger"></i> Receipt</a>
                                  </span>
                                </span>
                              </p>
                          <?php
                            }
                          } else {
                            NoData("No Previous Transactions Found!");
                          }
                          ?>
                          <p class="data-list p-2">
                            <span class="w-pr-20"></span>
                            <span class="w-pr-20"></span>
                            <span class="w-pr-10"></span>
                            <span class="w-pr-30 text-right">
                              <span class='name h5 text-right'>
                                <b>Net Commission :</b> <?php echo Price($commission_amount, "text-primary text-right", "Rs."); ?>
                              </span>
                            </span>
                            <span class="w-pr-10 text-right"></span>
                          </p>
                          <p class="data-list p-2">
                            <span class="w-pr-20"></span>
                            <span class="w-pr-20"></span>
                            <span class="w-pr-10"></span>
                            <span class="w-pr-30 text-right">
                              <span class='name h5 text-right'>
                                <b>Paid :</b> <?php echo Price($NetCommissionAmount, "text-success text-right", "Rs."); ?>
                              </span>
                            </span>
                            <span class="w-pr-10 text-right"></span>
                          </p>
                          <p class="data-list p-2">
                            <span class="w-pr-20"></span>
                            <span class="w-pr-20"></span>
                            <span class="w-pr-10"></span>
                            <span class="w-pr-30 text-right">
                              <span class='name h5 text-right'>
                                <b>Balance :</b> <?php echo Price($commission_amount - $NetCommissionAmount, "text-danger text-right", "Rs."); ?>
                              </span>
                            </span>
                            <span class="w-pr-10 text-right"></span>
                          </p>
                          <hr>
                          <div class="w-100 text-right">
                            <a onclick='Databar("add-commission-payment")' class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Add Payment Record</a>
                          </div>

                          <div class="shadow-sm" style="display:none;" id="add-commission-payment">
                            <form action="../../../controller/paymentcontroller.php" method="POST">
                              <?php FormPrimaryInputs(true, [
                                "partner_id" => $partner_id,
                                "commission_id" => $commission_id
                              ]) ?>
                              <div class="row">
                                <h4 class='app-sub-heading'>Commission Payout Details</h4>
                                <div class="form-group col-md-5 pt-3">
                                  <label>Payout Status</label>
                                  <select name="commission_status" class="form-control" required="">
                                    <option value="null">Select Status</option>
                                    <option value="Paid">Paid</option>
                                    <option value="UnPaid" selected=''>UnPaid</option>
                                  </select>
                                </div>
                                <div class="form-group col-md-5 pt-3">
                                  <label>Payout Type</label>
                                  <select name="commission_payout_type" class="form-control" required="">
                                    <option value="Select Pay Type">Select Pay Type</option>
                                    <option value="ELIGIBLE COMISSION">ELIGIBLE COMISSION</option>
                                    <option value="ADVANCE PAYMENT">ADVANCE PAYMENT</option>
                                  </select>
                                </div>
                                <div class="form-group col-md-5 pt-3">
                                  <label>Payout Mode</label>
                                  <select name="commission_payout_payment_mode" class="form-control" required="">
                                    <option value="Select Pay Mode">Select Pay Mode</option>
                                    <option value="CASH">CASH</option>
                                    <option value="UPI">UPI</option>
                                    <option value="CHEQUE">CHEQUE</option>
                                    <option value="ONLINE_TRANSFER">ONLINE_TRANSFER</option>
                                    <option value="DEMAND_DRAFT">DEMAND_DRAFT</option>
                                    <option value="WALLET">WALLET</option>
                                  </select>
                                </div>
                                <div class="form-group col-md-5 pt-3">
                                  <label>Amount Paid</label>
                                  <input type="text" class="form-control" name="commission_payout_amount" value="">
                                </div>
                                <div class="form-group col-md-5 pt-3">
                                  <label>Payout date</label>
                                  <input type="date" class="form-control" name="commission_payout_date" value="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="form-group col-md-12 pt-3">
                                  <label>Payout Description</label>
                                  <textarea name="commission_payout_notes" required="" rows="3"></textarea>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-12">
                                  <hr>
                                  <a onclick='Databar("add-commission-payment")' class="btn btn-md btn-default">CANCEL </a>
                                  <button type="submit" name="AddCommissionDetails" value="<?php echo $commission_id; ?>" class="btn btn-md btn-success">Add Commission <i class="fa fa-angle-double-right"></i></button>
                                </div>
                              </div>
                            </form>
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
      </div>
      <!--===================================================-->
      <!--END CONTENT CONTAINER-->
      <!-- Modal  3-->
      <div class="modal fade square" id="add_data" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header app-bg text-white">
              <button type="button" class="close text-white m-r-8 m-t-1" data-dismiss="modal">&times;</button>
              <h4 class="modal-title text-white">Add New Agent</h4>
            </div>
            <div class="modal-body overflow-auto">
              <form action="../../../controller/usercontroller.php" method="POST">
                <?php FormPrimaryInputs(true, [
                  "user_country" => "India",
                  "agent_relation" => 0,
                ]) ?>
                <div class="row">
                  <div class="from-group col-md-6">
                    <label>Full Name</label>
                    <input type="text" name="name" value="" class="form-control" placeholder="" required="">
                  </div>
                  <div class="from-group col-md-6">
                    <label>Email</label>
                    <input type="email" name="email" value="" class="form-control" placeholder="" required="">
                  </div>
                  <div class="from-group col-md-6">
                    <label>Phone Number</label>
                    <input type="text" name="phone" value="" class="form-control" placeholder="" required="">
                  </div>
                  <div class="from-group col-md-6">
                    <label>Address</label>
                    <input type="text" name="user_street_address" value="" class="form-control" placeholder="" required="">
                  </div>
                  <div class="from-group col-md-6">
                    <label>Area Locality</label>
                    <input type="text" name="user_area_locality" value="" class="form-control" placeholder="" required="">
                  </div>
                  <div class="from-group col-md-6">
                    <label>City</label>
                    <input type="text" name="user_city" value="" class="form-control" placeholder="" required="">
                  </div>
                  <div class="from-group col-md-6">
                    <label>State</label>
                    <input type="text" name="user_state" value="" class="form-control" placeholder="" required="">
                  </div>
                  <div class="from-group col-md-6">
                    <label>Pincode</label>
                    <input type="text" name="user_pincode" value="" class="form-control" placeholder="" required="">
                  </div>
                  <div class="from-group col-md-6">
                    <label>User Status</label>
                    <select name="user_status" class="form-control" required="">
                      <option value="ACTIVE" selected="">ACTIVE</option>
                      <option value="INACTIVE">INACTIVE</option>
                    </select>
                  </div>
                  <div class="from-group col-md-6">
                    <label>User Role</label>
                    <select name="user_role_id" class="form-control text-uppercase" required="">
                      <?php
                      $getuserroles = SELECT("SELECT * FROM user_roles where role_id='3'");
                      while ($user_roles = mysqli_fetch_array($getuserroles)) {
                        $role_id = $user_roles['role_id'];
                        $role_name = $user_roles['role_name']; ?>
                        <option value="<?php echo $role_id; ?>" class="text-uppercase"><?php echo $role_name; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="create_new_user" value="<?php echo company_id; ?>" class="btn btn-success">Create</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <script>
        function CalculateCommissionArea() {
          var str = document.getElementById("total_unit_area_com").value;
          var area = Number(str.replace(/[^0-9\.]+/g, ""));;
          var commission_rate = document.getElementById("commission_rate_area_comm").value;
          var max_comm_rate = <?php echo FETCH($BSql, "net_payable_amount"); ?>;
          commission_get = +area * +commission_rate;
          if (commission_rate >= max_comm_rate) {
            document.getElementById("areacommsg").innerHTML = "Commission Rate cannot be greater then or Equal to Sale Rate";
          } else {
            document.getElementById("areacommsg").innerHTML = "";
            document.getElementById("payingcommission").value = commission_get;
          }
        }
      </script>
      <script>
        function CheckcommissionAmount() {
          if (document.getElementById("commison_amount_").value > <?php echo FETCH($BSql, "net_payable_amount"); ?>) {
            document.getElementById("msgerr").innerHTML = "Commission Amount cannot be equal and greater than too sale amount!";
            document.getElementById("payingcommission").value = document.getElementById("commison_amount_").value;
          } else {
            document.getElementById("msgerr").innerHTML = "";
            document.getElementById("payingcommission").value = document.getElementById("commison_amount_").value;
          }
        }
      </script>

      <script>
        function CalculateCommissionPercentage() {
          if (document.getElementById("comm_per").value > 0) {
            commission_amount = Math.round(<?php echo FETCH($BSql, "net_payable_amount"); ?> / 100 * document.getElementById("comm_per").value);
            if (commission_amount > <?php echo FETCH($BSql, "net_payable_amount"); ?>) {
              document.getElementById("com_amount").value = <?php echo FETCH($BSql, "net_payable_amount"); ?>;
              if (document.getElementById("com_amount").value < <?php echo FETCH($BSql, "net_payable_amount"); ?>) {
                document.getElementById("msgerr").innerHTML = "Commission Amount cannot be equal and greater than too sale amount!";
                document.getElementById("payingcommission").value = commission_amount;
              } else {
                document.getElementById("msgerr").innerHTML = "";
              }
            } else {
              document.getElementById("payingcommission").value = commission_amount;
            }
          } else {
            document.getElementById("payingcommission").value = "0";
          }
        }
      </script>

      <script>
        function CommissionType() {
          var data = document.getElementById("commission_type_value");
          if (data.value == "amount") {
            document.getElementById("amount").style.display = "block";
            document.getElementById("percentage").style.display = "none";
            document.getElementById("area").style.display = "none";
          } else if (data.value == "percentage") {
            document.getElementById("amount").style.display = "none";
            document.getElementById("area").style.display = "none";
            document.getElementById("percentage").style.display = "block";
          } else if (data.value == "area") {
            document.getElementById("amount").style.display = "none";
            document.getElementById("area").style.display = "block";
            document.getElementById("percentage").style.display = "none";
          } else {
            document.getElementById("amount").style.display = "block";
            document.getElementById("area").style.display = "none";
            document.getElementById("percentage").style.display = "none";
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
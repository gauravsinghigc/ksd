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

$BSql = "SELECT * FROM bookings where bookingid='$bookingid'";
$MainBookingID = "B$bookingid/" . date("m/Y", strtotime(FETCH($BSql, "created_at")));
$customer_id = FETCH($BSql, "customer_id");

$getusers = SELECT("SELECT * FROM users, user_address, user_roles where users.company_relation='" . company_id . "' and users.id='$customer_id' and users.user_role_id='4' and users.id=user_address.user_id and users.user_role_id=user_roles.role_id");
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
                    <div class="col-md-12">
                      <h3 class="m-t-0"><i class="fa fa-exchange"></i> Add Commision to Booking</h3>
                      <a href="index.php" class="btn btn-md btn-default"><i class="fa fa-angle-left"></i> Back to Booking Dashboard</a>

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
                          <th>Net Payable Amount</th>
                          <td><span class="text-success fs-14">Rs.<?php echo FETCH($BSql, "net_payable_amount"); ?></span></td>
                        </tr>
                      </table>
                    </div>

                    <div class="col-md-4 col-lg-4 col-4">
                      <h4 class="section-heading">Customer Details</h4>
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
                    <div class="row">
                      <div class="col-md-12 m-t-1">
                        <h4 class="section-heading flex-s-b">
                          <span class="m-t-6">Select Agent</span>
                          <a class="btn btn-primary square btn-labeled fa fa-plus" data-toggle="modal" data-target="#add_data">Add New Agent</a>
                        </h4>
                        <style>
                          .dataTables_length {
                            display: none !important;
                          }
                        </style>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-5">
                        <h4 class="app-sub-heading">Search Agents</h4>
                        <form>
                          <div class="row">
                            <div class="col-md-5">
                              <div class="form-group">
                                <label>Search Type</label>
                                <select name="search_type" onchange="form.submit()" class="form-control">
                                  <?php InputOptions(
                                    [
                                      "id" => "AGENTS ID (00XX)",
                                      "name" => "Name (Keshave)",
                                      "email" => "Email-ID (abc@domain.tld)",
                                      "phone" => "Phone Number (9876543210)"
                                    ],
                                    IfRequested("GET", "search_type", "name", false)
                                  ); ?>

                                </select>
                              </div>
                            </div>
                            <div class="col-md-7">
                              <div class="form-group">
                                <label>Enter Search Value</label>
                                <input type="text" name="search_value" onchange="form.submit()" class="form-control" placeholder="" list="datalist">
                                <datalist id="datalist">
                                  <?php
                                  if (isset($_GET['search_type'])) {
                                    $search_type = IfRequested("GET", "search_type", "", false);
                                    $search_value = IfRequested("GET", "search_value", "", false);
                                    $Sql = "SELECT * FROM users where user_role_id='3' or user_role_id='5'";
                                    $SearchSql = FetchConvertIntoArray($Sql, true);
                                    if ($SearchSql != null) {
                                      foreach ($SearchSql as $Search) {
                                  ?>
                                        <option value="<?php echo $Search->$search_type; ?>"></option>
                                      <?php
                                      }
                                    }
                                  } else {
                                    $Sql = "SELECT * FROM users where user_role_id='3' or user_role_id='5'";
                                    $SearchSql = FetchConvertIntoArray($Sql, true);
                                    if ($SearchSql != null) {
                                      foreach ($SearchSql as $Search) {
                                      ?>
                                        <option value="<?php echo $Search->name; ?>"></option>
                                  <?php
                                      }
                                    }
                                  } ?>
                                </datalist>
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>


                    <div class="row">
                      <div class="col-md-12">
                        <h4 class="section-heading">Agent Search Results & Commission Details</h4>
                        <div class="row">
                          <div class="col-md-5">
                            <?php include "../../../include/admin/sections/agent-search.php"; ?>
                          </div>
                          <div class="col-md-7">
                            <?php if (isset($_GET['partner_id'])) {
                            ?>
                              <form action="../../../controller/bookingcontroller.php" method="POST">
                                <?php FormPrimaryInputs(true, [
                                  "partner_id" => $_GET['partner_id'],
                                  "booking_id" => $bookingid,
                                ]); ?>
                                <div class="row">
                                  <div class="col-md-6 form-group">
                                    <label>Commission Type</label>
                                    <select class="form-control" required="" id="commission_type_value" name="commission_type" onchange="CommissionType()">
                                      <?php InputOptions(
                                        [
                                          "amount" => "Fix Amount",
                                          "percentage" => "Percentage of Plot Amount",
                                          "area" => "As Per Area (Per Unit Square)"
                                        ],
                                        "amount"
                                      ) ?>
                                    </select>
                                  </div>
                                </div>

                                <div id="amount">
                                  <div class="row">
                                    <div class="from-group col-md-6">
                                      <label>Amount <span class="text-danger" id="msgerr"></span></label>
                                      <input type="number" name="commission_amount_direct" value="" id="commison_amount_" oninput="CheckcommissionAmount()" class="form-control" placeholder="">
                                    </div>
                                    <div class="from-group col-md-6">
                                      <label>Sale Amount</label>
                                      <input type="number" name="" value="<?php echo FETCH($BSql, "net_payable_amount"); ?>" readonly="" class="form-control" placeholder="">
                                    </div>
                                  </div>
                                </div>


                                <div id="percentage" style="display:none;">
                                  <div class="row">
                                    <div class="from-group col-md-6">
                                      <label>Percentage <span class="text-danger" id="msgerr"></span></label>
                                      <input type="number" name="commission_percentage" value="" id="comm_per" oninput="CalculateCommissionPercentage()" class="form-control" placeholder="">
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
                                      <input type="text" name="commission_rate_area" id="commission_rate_area_comm" oninput="CalculateCommissionArea()" class="form-control" placeholder="">
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
                                    <input type="text" name="commission_amount" class="form-control" readonly="" id="payingcommission">
                                  </div>
                                  <div class=" form-group col-md-8 pt-3">
                                    <label>Commision Note/Remarks</label>
                                    <input type="text" name="commission_remark" class="form-control" placeholder="">
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-12">
                                    <a href="index.php" class="btn btn-md btn-default"><i class='fa fa-angle-left'></i> Back to Booking Dashboard</a>
                                    <button type="submit" name="CreateCommission" class="btn btn-md btn-success">Save & Add More <i class="fa fa-angle-double-right"></i></button>
                                  </div>
                                </div>
                              </form>
                            <?php }
                            ?>
                          </div>
                        </div>
                      </div>

                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <h4 class="section-heading">Commission Distributed!</h4>
                      </div>
                      <div class="col-md-12">
                        <?php
                        $DCom = FetchConvertIntoArray("SELECT * FROM commission where booking_id='$booking_id'", true);
                        if ($DCom == null) {
                          echo "<p class='data-list'>No Commission is disributed, please distribute commission</p>";
                        } else {
                          foreach ($DCom as $Data) {
                            $partner_id = $Data->partner_id;
                            $CSql = "SELECT * FROM users where id='$partner_id'";
                        ?>
                            <p class="data-list">
                              <span>
                                <i class="fa fa-user"></i> <?php echo FETCH($CSql, "name"); ?> |
                                <b>Phone : </b> <?php echo FETCH($CSql, "phone"); ?> |
                                <b>CommissionType :</b> <?php echo $Data->commission_type; ?> |
                                <b>CommissionAmount :</b> Rs.<?php echo $Data->commission_amount; ?> |
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
            var max_comm_rate = <?php echo FETCH($BSql, "unit_rate"); ?>;
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
            if (document.getElementById("commison_amount_").value < <?php echo FETCH($BSql, "unit_rate"); ?>) {
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
                if (document.getElementById("com_amount").value > <?php echo FETCH($BSql, "net_payable_amount"); ?>) {
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
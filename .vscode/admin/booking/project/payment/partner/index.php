<?php
require '../../../../../require/modules.php';
require "../../../../../require/admin/sessionvariables.php";
require '../../../../../include/admin/common.php';

if (isset($_SESSION['TEMP_BOOKING_SESSION'])) {
  if ($_SESSION['TEMP_BOOKING_SESSION'] == NULL) {
    LOCATION("warning", "Please Start Fresh Bookings", ADMIN_URL . "/booking/new_booking.php");
  }
}

if (isset($_GET['bookingcontinuetoagent'])) {
  $_SESSION['booking_amount'] = $_GET['booking_amount'];
  $_SESSION['rest_amount'] = $_GET['rest_amount'];
  $_SESSION['booking_date'] = $_GET['booking_date'];

  if (isset($_GET['possession'])) {
    $_SESSION['possession'] = $_GET['possession'];
  } else {
    $_SESSION['possession'] = "Not Available";
  }

  $_SESSION['payment_mode'] = $_GET['payment_mode'];
  $_SESSION['checkissuedto'] = $_GET['checkissuedto'];
  $_SESSION['checknumber'] = $_GET['checknumber'];
  $_SESSION['BankName'] = $_GET['BankName'];
  $_SESSION['ifsc'] = $_GET['ifsc'];
  $_SESSION['checkissuedate'] = $_GET['checkissuedate'];
  $_SESSION['OnlineBankName'] = $_GET['OnlineBankName'];
  $_SESSION['transactionId'] = $_GET['transactionId'];
  $_SESSION['transactiondate'] = $_GET['transactiondate'];
  $_SESSION['cashreceivername'] = $_GET['cashreceivername'];
  $_SESSION['cashamount'] = $_GET['cashamount'];
  $_SESSION['cashreceivedate'] = $_GET['cashreceivedate'];
  $_SESSION['slip_no'] = $_GET['slip_no'];
  $_SESSION['remark'] = $_GET['remark'];
  $_SESSION['checkstatus'] = $_GET['checkstatus'];
  $TotalUnitArea = $_SESSION['unit_area'];
  $_SESSION['emi_start_date'] = $_GET['emi_start_date'];
  $_SESSION['emi_per_month'] = $_GET['emi_per_month'];
  $_SESSION['emi_last_date'] = $_GET['emi_last_date'];
  $_SESSION['emi_day_of_month'] = $_GET['emi_day_of_month'];
  $_SESSION['onlinepaymenttype'] = $_GET['onlinepaymenttype'];
  $_SESSION['emi_months'] = $_GET['emi_months'];
  $_SESSION['possession_notes'] = htmlentities($_GET['possession_notes']);
  $_SESSION['clearedat'] = $_GET['clearedat'];
  $_SESSION['payment_details'] = $_GET['payment_details'];
  $_SESSION['transaction_status'] = $_GET['transaction_status'];
  $_SESSION['tally_no'] = $_GET['tally_no'];

  $_SESSION['booking_bank_ifsc_code'] = $_GET['booking_bank_ifsc_code'];
  $_SESSION['booking_santion_amount'] = $_GET['booking_santion_amount'];
  $_SESSION['booking_receive_amount'] = $_GET['booking_receive_amount'];
  $_SESSION['booking_loan_notes'] = SECURE($_GET['booking_loan_notes'], "d");
}
?>
<?php
if (isset($_GET['partner_id'])) {
  $partner_search_id = $_GET['partner_id'];
  $SqlPartner = "SELECT * from users where id='$partner_search_id' and company_relation='" . company_id . "' and user_role_id='3'";
  $Check = CHECK($SqlPartner);

  if ($Check != null) {
    $viewpartners = SELECT($SqlPartner);
    $fetchpartner = mysqli_fetch_array($viewpartners);
    $partner_name_view = $fetchpartner['name'];
    $partner_email_view = $fetchpartner['email'];
    $partner_phone_view = $fetchpartner['phone'];
    $executedpartnerid = $fetchpartner['id'];
    $executedcustomer_id = $executedpartnerid;
    $partner_profile_img = $fetchpartner['user_profile_img'];
    if ($partner_profile_img == "user.png") {
      $partner_profile_img = DOMAIN . "/storage/sys-img/user.png";
    } else {
      $partner_profile_img = DOMAIN . "/storage/users/$executedcustomer_id/img/$partner_profile_img";
    }

    //agent address details
    $CheckAddress = CHECK("SELECT * FROM user_address WHERE user_id='$executedpartnerid'");
    if ($CheckAddress != null) {
      $SelectAgentAddress = SELECT("SELECT * FROM user_address where user_id='$executedpartnerid'");
      $FetchAgentAddress = mysqli_fetch_assoc($SelectAgentAddress);
      $user_street_address = $FetchAgentAddress['user_street_address'];
      $user_area_locality = $FetchAgentAddress['user_area_locality'];
      $user_city = $FetchAgentAddress['user_city'];
      $user_state = $FetchAgentAddress['user_state'];
      $user_pincode = $FetchAgentAddress['user_pincode'];
      $user_country = $FetchAgentAddress['user_country'];
    } else {
      $user_street_address = "N/A";
      $user_area_locality = "N/A";
      $user_city = "N/A";
      $user_state = "N/A";
      $user_pincode = "N/A";
      $user_country = "N/A";
    }

    //if no agent is search
  } else {

    $partner_name_view = "";
    $partner_email_view = "";
    $partner_phone_view = "";
    $executedpartnerid = "0";
    $user_street_address = "";
    $user_area_locality = "";
    $user_city = "";
    $user_state = "";
    $user_pincode = "";
    $user_country = "";
    $executedcustomer_id = "0";
    $partner_profile_img = "user.png";
    if ($partner_profile_img == "user.png") {
      $partner_profile_img = DOMAIN . "/storage/sys-img/user.png";
    } else {
      $partner_profile_img = DOMAIN . "/storage/users/$executedcustomer_id/img/$partner_profile_img";
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Agent Details | <?php echo company_name; ?></title>
  <?php include '../../../../../include/header_files.php'; ?>
</head>

<body>
  <div id="container" class="navbar-fixed mainnav-fixed mainnav-lg">
    <?php include '../../../../header.php'; ?>

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

                  <div class="col-md-12 text-center m-t-2">
                    <div class="steps">
                      <a href="../../../new_booking.php">
                        <span class="step active"><i class="fa fa-check-circle"></i></span>
                        <span class="step-text">Customer Selected</span>
                      </a>
                      <a href="../../../project/">
                        <span class="step active"><i class="fa fa-check-circle"></i></span>
                        <span class="step-text">Plot Selected</span>
                      </a>
                      <a href="../../payment/">
                        <span class="step active"><i class="fa fa-check-circle"></i></span>
                        <span class="step-text">Payment Details</span>
                      </a>
                      <a>
                        <span class="step run">4</span>
                        <span class="step-text">Agent Details</span>
                      </a>
                      <a>
                        <span class="step run">5</span>
                        <span class="step-text">Upload Documents</span>
                      </a>

                    </div>
                  </div>
                  <?php if (isset($_SESSION['TYPE'])) {
                  ?>
                    <div class="row">
                      <div class="col-md-12">
                        <h4 class="bg-danger p-1"><i class='fa fa-check'></i> <?php echo $_SESSION['TYPE']; ?> the <?php echo FETCH("SELECT * FROM project_units where project_units_id='" . $_SESSION['plot_id'] . "'", "projects_unit_name"); ?> of project <?php echo FETCH("SELECT * FROM projects where Projects_Id='" . $_SESSION['project_id'] . "'", "project_title"); ?></h4>
                      </div>
                    </div>
                  <?php
                    $Z_Mode = "&mode=true";
                  } else {
                    $Z_Mode = "";
                  } ?>
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
                                  $Sql = "SELECT * FROM users where user_role_id='3'";
                                  $SearchSql = FetchConvertIntoArray($Sql, true);
                                  if ($SearchSql != null) {
                                    foreach ($SearchSql as $Search) {
                                ?>
                                      <option value="<?php echo $Search->$search_type; ?>"></option>
                                    <?php
                                    }
                                  }
                                } else {
                                  $Sql = "SELECT * FROM users where user_role_id='3'";
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
                          <?php include "../../../../../include/admin/sections/agent-search.php"; ?>
                        </div>
                        <div class="col-md-7">
                          <?php if (isset($_GET['partner_id'])) {
                          ?>
                            <form action="../../../../../controller/bookingcontroller.php" method="POST">
                              <?php FormPrimaryInputs(true, [
                                "partner_id" => $_GET['partner_id']
                              ]); ?>
                              <div class="row">
                                <h4 class='app-sub-heading'>Commission Details</h4>
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
                                    <input type="number" name="" value="<?php echo $_SESSION['net_payable_amount']; ?>" readonly="" class="form-control" placeholder="">
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
                                    <input type="text" name="sale_amount" value="<?php echo $_SESSION['net_payable_amount']; ?>" readonly="" class="form-control" placeholder="">
                                  </div>
                                </div>
                              </div>


                              <div id="area" style="display:none;">
                                <div class="row">
                                  <div class="from-group col-md-6">
                                    <label>Total Unit Area <span class="text-danger" id="msgerr"></span></label>
                                    <input type="text" name="total_unit_area" value="<?php echo $_SESSION['unit_area']; ?>" id="total_unit_area_com" readonly="" class="form-control" placeholder="">
                                  </div>
                                  <div class="from-group col-md-6">
                                    <label>Sale Rate <span class="text-danger" id="msgerr"></span></label>
                                    <input type="text" name="saler-rate" id="salerate" value="<?php echo $_SESSION['unit_rate']; ?>" readonly="" class="form-control" placeholder="">
                                  </div>
                                  <div class="from-group col-md-6">
                                    <label>Total Unit Cost <span class="text-danger" id="msgerr"></span></label>
                                    <input type="text" value="<?php echo $_SESSION['unit_cost']; ?>" readonly="" class="form-control" placeholder="">
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
                                  <input type="number" min="1" name="commission_amount" class="form-control" readonly="" id="payingcommission">
                                </div>
                                <div class=" form-group col-md-8 pt-3">
                                  <label>Commision Note/Remarks</label>
                                  <input type="text" name="commission_remark" class="form-control" placeholder="">
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-12">
                                  <button type="submit" name="CreateAgentCommissionTemp" class="btn btn-md btn-success">Save & Add More <i class="fa fa-angle-double-right"></i></button>
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
                      $TempCommissionSessionId = $_SESSION['TEMP_BOOKING_SESSION'];
                      $DCom = FetchConvertIntoArray("SELECT * FROM commission_temps where TempCommissionSessionId='$TempCommissionSessionId'", true);
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
                                "delete_temp_commission_record" => true,
                                "control_id" => $Data->TempCommissionId,
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
                    <div class="col-md-12 flex-s-b">
                      <a href="../index.php" class="btn btn-lg btn-default"><i class="fa fa-angle-double-left"></i> Back to Payments</a>
                      <?php $CheckComission = CHECK("SELECT * FROM commission_temps where TempCommissionSessionId='" . $_SESSION['TEMP_BOOKING_SESSION'] . "'");
                      if ($CheckComission != null) { ?>
                        <form action="../../../../../controller/bookingcontroller.php" method="POST">
                          <?php FormPrimaryInputs(true); ?>
                          <button type="submit" name="completebookings" class="btn btn-lg btn-success">Complete Booking <i class="fa fa-angle-double-right"></i></button>
                        </form>
                      <?php } ?>
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
              <form action="../../../../../controller/usercontroller.php" method="POST">
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
          var max_comm_rate = <?php echo $_SESSION['net_payable_amount']; ?>;
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
          if (document.getElementById("commison_amount_").value > <?php echo $_SESSION['net_payable_amount']; ?>) {
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
            commission_amount = Math.round(<?php echo $_SESSION['net_payable_amount']; ?> / 100 * document.getElementById("comm_per").value);
            if (commission_amount >= <?php echo $_SESSION['net_payable_amount']; ?>) {
              document.getElementById("com_amount").value = <?php echo $_SESSION['net_payable_amount']; ?>;
              if (document.getElementById("com_amount").value >= <?php echo $_SESSION['net_payable_amount']; ?>) {
                document.getElementById("msgerr").innerHTML = "Commission Amount cannot be equal and greater than too sale amount!";
                alert("Commision cannot be greater than and equal to sale amount");
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
      <?php include '../../../../sidebar.php'; ?>
      <?php include '../../../../footer.php'; ?>
    </div>

    <?php include '../../../../../include/footer_files.php'; ?>
</body>

</html>
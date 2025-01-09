<?php
require '../../require/modules.php';
require "../../require/admin/sessionvariables.php";
require '../../include/admin/common.php';

$CreationTempBookingSession = DATE("Y-m-d") . rand(0, 999999999999);

$_SESSION['TEMP_BOOKING_SESSION'] = $CreationTempBookingSession;

if (isset($_GET['type'])) {
  $_SESSION['TYPE'] = $_GET['type'];
  $_SESSION['plot_id'] = $_GET['plot_id'];
  $_SESSION['project_id'] = $_GET['project_id'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Booking | <?php echo company_name; ?></title>
  <?php include '../../include/header_files.php'; ?>
</head>

<body>
  <div id="container" class="navbar-fixed mainnav-fixed mainnav-lg">
    <?php include '../header.php'; ?>

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
                    <div class="col-md-12 text-center m-t-2">
                      <div class="steps">
                        <a>
                          <span class="step run">1</span>
                          <span class="step-text">Select Customer</span>
                        </a>
                        <a>
                          <span class="step">2</span>
                          <span class="step-text">Select Plots</span>
                        </a>
                        <a>
                          <span class="step">3</span>
                          <span class="step-text">Add Payment</span>
                        </a>
                        <a>
                          <span class="step">4</span>
                          <span class="step-text">Select Agent</span>
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
                        <h3 class="section-heading flex-s-b">
                          <span class="m-t-6">Select Customer</span>
                          <a class="btn btn-primary square btn-labeled fa fa-plus" data-toggle="modal" data-target="#add_data">Add New Customer</a>
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
                        <h4 class="app-sub-heading">Search Customer</h4>
                        <form>
                          <div class="row">
                            <div class="col-md-5">
                              <div class="form-group">
                                <label>Search Type</label>
                                <select name="search_type" onchange="form.submit()" class="form-control">
                                  <?php InputOptions(
                                    [
                                      "id" => "CUSTOMER ID (00XX)",
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
                                    $Sql = "SELECT * FROM users where user_role_id='4'";
                                    $SearchSql = FetchConvertIntoArray($Sql, true);
                                    if ($SearchSql != null) {
                                      foreach ($SearchSql as $Search) {
                                  ?>
                                        <option value="<?php echo $Search->$search_type; ?>"></option>
                                      <?php
                                      }
                                    }
                                  } else {
                                    $Sql = "SELECT * FROM users where user_role_id='4'";
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

                      <div class="col-md-7">
                        <h4 class="app-sub-heading">Search Results</h4>
                        <div class="row">
                          <?php
                          if (isset($_GET['search_value'])) {
                            if ($_GET['search_value'] != null || $_GET['search_value'] != "") {
                              $Sql = "SELECT * FROM users where $search_type like '%$search_value%'";
                              $SearchSql = FetchConvertIntoArray($Sql, true);
                              $Check = CHECK($Sql);
                              if ($Check == null) {
                          ?>
                                <div class="col-md-12">
                                  <h3>No Customer Found</h3>
                                  <p>No customer fround from <b><?php echo $search_type; ?></b> having value <b><?php echo $search_value; ?></b>. Please try to add this customer by clicking below button.</p>
                                  <a class="btn btn-primary square btn-labeled fa fa-plus" data-toggle="modal" data-target="#add_data">Add New Customer</a>
                                </div>
                                <?php
                              } else {

                                foreach ($SearchSql as $Customer) {
                                  $executedcustomer_id = $Customer->id;
                                  $customer_user_profile_img = $Customer->user_profile_img;
                                  if ($customer_user_profile_img == "user.png") {
                                    $customer_user_profile_img = DOMAIN . "/storage/sys-img/$customer_user_profile_img";
                                  } else {
                                    $customer_user_profile_img = DOMAIN . "/storage/users/$executedcustomer_id/img/$customer_user_profile_img";
                                  }
                                  $AddSql = "SELECT * FROM users, user_address, user_roles where users.id='$executedcustomer_id' and users.company_relation='" . company_id . "' and users.id=user_address.user_id and users.user_role_id=user_roles.role_id";
                                  $AddressSql = FetchConvertIntoArray($AddSql, true);
                                ?>
                                  <div class="col-md-12 m-b-10">
                                    <div class="row shadow-lg rounded-3 p-1">
                                      <div class="col-md-2">
                                        <img src="<?php echo $customer_user_profile_img; ?>" class="img-fluid m-t-35">
                                      </div>
                                      <div class="col-md-10">
                                        <h4 class="bold black"><?php echo $Customer->name; ?> <?php echo $Customer->father_name; ?> <small class="text-grey"> | CUST00<?php echo $Customer->id; ?></small></h4>
                                        <p>
                                          <span><?php echo $Customer->phone; ?></span><br>
                                          <span><?php echo $Customer->email; ?></span><br>
                                          <?php foreach ($AddressSql as $Address) {
                                            $user_address_id = $Address->user_address_id; ?>
                                            <span><i class="fa fa-map-marker text-success"></i> <?php echo $Address->user_street_address; ?> <?php echo $Address->user_area_locality; ?> <?php echo $Address->user_city; ?> <?php echo $Address->user_state; ?> <?php echo $Address->user_country; ?> - <?php echo $Address->user_pincode; ?></span>
                                          <?php } ?>
                                        </p>
                                        <hr>
                                        <a href="#" class="btn btn-md btn-default" data-toggle="modal" data-target="#edit_customer_<?php echo $executedcustomer_id; ?>"><i class='fa fa-edit'></i> Edit Details</a>
                                        <a href="project/?customer_id=<?php echo $executedcustomer_id; ?><?php echo $Z_Mode; ?>" class="btn btn-md btn-success">Select & Continue <i class="fa fa-angle-right"></i></a>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="modal fade square" id="edit_customer_<?php echo $executedcustomer_id; ?>" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                      <div class="modal-content">
                                        <div class="modal-header app-bg text-white">
                                          <button type="button" class="close text-white m-r-8 m-t-1" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title text-white">Edit Customer Details</h4>
                                        </div>
                                        <div class="modal-body overflow-auto">
                                          <form action="../../controller/usercontroller.php" method="POST">
                                            <?php FormPrimaryInputs(true, [
                                              "user_country" => "India",
                                              "customer_id" => $executedcustomer_id,
                                              "agent_relation" => 0,
                                              "booking_process" => true
                                            ]); ?>
                                            <div class="row">
                                              <div class="from-group col-md-6">
                                                <label>Full Name</label>
                                                <input type="text" name="name" value="<?php echo $Customer->name; ?>" class="form-control" placeholder="" required="">
                                              </div>
                                              <div class="from-group col-md-6">
                                                <label>S/O, W/O, D/O Name</label>
                                                <input type="text" name="father_name" value="<?php echo $Customer->father_name; ?>" class="form-control" placeholder="" required="">
                                              </div>
                                              <div class="from-group col-md-6">
                                                <label>Email</label>
                                                <input type="email" name="email" value="<?php echo $Customer->email; ?>" class="form-control" placeholder="">
                                              </div>
                                              <div class="from-group col-md-6">
                                                <label>Phone Number</label>
                                                <input type="text" name="phone" value="<?php echo $Customer->phone; ?>" class="form-control" placeholder="" required="">
                                              </div>
                                              <div class="from-group col-md-6">
                                                <label>Address</label>
                                                <input type="text" name="user_street_address" value="<?php echo FETCH($AddSql, "user_street_address"); ?>" class="form-control" placeholder="" required="">
                                              </div>
                                              <div class="from-group col-md-6">
                                                <label>Area Locality</label>
                                                <input type="text" name="user_area_locality" value="<?php echo FETCH($AddSql, "user_area_locality"); ?>" class="form-control" placeholder="" required="">
                                              </div>
                                              <div class="from-group col-md-6">
                                                <label>City</label>
                                                <input type="text" name="user_city" value="<?php echo FETCH($AddSql, "user_city"); ?>" class="form-control" placeholder="" required="">
                                              </div>
                                              <div class="from-group col-md-6">
                                                <label>State</label>
                                                <input type="text" name="user_state" value="<?php echo FETCH($AddSql, "user_state"); ?>" class="form-control" placeholder="" required="">
                                              </div>
                                              <div class="from-group col-md-6">
                                                <label>Pincode</label>
                                                <input type="text" name="user_pincode" value="<?php echo FETCH($AddSql, "user_pincode"); ?>" class="form-control" placeholder="" required="">
                                              </div>
                                              <div class="from-group col-md-6">
                                                <label>User Status</label>
                                                <select name="user_status" class="form-control" required="">
                                                  <?php InputOptions(
                                                    [
                                                      "ACTIVE" => "Active",
                                                      "INACTIVE" => "Inactive",
                                                    ],
                                                    $Customer->user_status
                                                  ); ?>
                                                </select>
                                              </div>
                                              <div class="from-group col-md-6">
                                                <label>User Role</label>
                                                <select name="user_role_id" class="form-control text-uppercase" required="">
                                                  <?php
                                                  $getuserroles = SELECT("SELECT * FROM user_roles where role_id='4'");
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
                                          <button type="submit" name="update_customers" value="<?php echo $executedcustomer_id; ?>" class="btn btn-success">Update Details</button>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                            <?php
                                }
                              }
                            }
                          } else {  ?>
                            <div class="col-md-12">
                              <h3>Search customers</h3>
                              <p>You can search or add customers from here without creating agents first, if your need then you can create agents here too.</p>
                              <a class="btn btn-primary square btn-labeled fa fa-plus" data-toggle="modal" data-target="#add_data">Add New Customer</a>
                            </div>
                          <?php } ?>
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
              <h4 class="modal-title text-white">Add Customer</h4>
            </div>
            <div class="modal-body overflow-auto">
              <form action="../../controller/usercontroller.php" method="POST">
                <?php FormPrimaryInputs(true, [
                  "user_country" => "India",
                  "customer_id" => 0,
                  "agent_relation" => 0,
                  "booking_process" => true
                ]); ?>
                <div class="row">
                  <div class="from-group col-md-6">
                    <label>Full Name</label>
                    <input type="text" name="name" value="" class="form-control" placeholder="" required="">
                  </div>
                  <div class="from-group col-md-6">
                    <label>S/O, W/O, D/O Name</label>
                    <input type="text" name="father_name" value="" class="form-control" placeholder="" required="">
                  </div>
                  <div class="from-group col-md-6">
                    <label>Email</label>
                    <input type="email" name="email" value="" class="form-control" placeholder="">
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
                      $getuserroles = SELECT("SELECT * FROM user_roles where role_id='4'");
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
        UploadProfileImg.onchange = evt => {
          const [file] = UploadProfileImg.files
          if (file) {
            ImgPreview.src = URL.createObjectURL(file);
          }
        }
      </script>

      <!-- end -->
      <?php include '../sidebar.php'; ?>
      <?php include '../footer.php'; ?>
    </div>

    <?php include '../../include/footer_files.php'; ?>
</body>

</html>
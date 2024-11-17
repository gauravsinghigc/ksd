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
  <title>Customers | <?php echo company_name; ?></title>
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
                      <h3 class="m-t-3"><i class="fa fa-users app-text"></i> Customers</h3>
                    </div>
                    <div class="col-md-12">
                      <div class="flex-s-b">
                        <div class="btn-group btn-group-sm w-100">
                          <a class="btn btn-primary square btn-labeled fa fa-plus" data-toggle="modal" data-target="#add_data">Customer</a>
                          <?php if (isset($_GET['search'])) { ?>
                            <a href="<?php echo DOMAIN; ?>/admin/customer/export_all.php?search_type=<?php echo $_GET['search_type']; ?>&search_value=<?php echo $_GET['search_value']; ?>&search=true" target="blank" class="btn btn-secondary square btn-labeled fa fa-print">Export All</a>
                          <?php } else { ?>
                            <a href="<?php echo DOMAIN; ?>/admin/customer/export_all.php" target="blank" class="btn btn-secondary square btn-labeled fa fa-print">Export All</a>
                          <?php } ?>
                        </div>


                        <div class="btn-group btn-group-sm w-100">
                          <form action="" method="GET" class="flex-s-b form-search-filter w-100">
                            <span class="w-100 p-1 text-right"><b>Search Customer</b></span>
                            <select name="search_type" class="form-control">
                              <option value="id">Customer ID</option>
                              <option value="name">Customer Name</option>
                              <option value="phone">Phone Number</option>
                              <option value="email">Email ID</option>
                            </select>
                            <input type="text" name="search_value" class="form-control" placeholder="Enter Search Value">
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
                            <a href="index.php" class="text-danger"><span class="text-white"><i class="fa fa-times"></i>
                                Clear</span></a>
                          </p>
                        </center>
                      <?php }
                      $TotalItems = TOTAL("SELECT * FROM users where company_relation='" . company_id . "' and user_status!='DELETED' and user_role_id='4'");
                      include "../../include/extra/data-counter.php"; ?>
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>SNo</th>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Bookings</th>
                            <th>Action</th>
                          </tr>
                        </thead>

                        <?php
                        if (isset($_GET['search'])) {
                          $search_value = $_GET['search_value'];
                          $search_type = $_GET['search_type'];
                          $GetUSERS = SELECT("SELECT * FROM users where $search_type like '%$search_value%' and company_relation='" . company_id . "' and user_status!='DELETED' and user_role_id='4'");
                          $CheckUsers = CHECK("SELECT * FROM users where $search_type like '%$search_value%' and company_relation='" . company_id . "' and user_status!='DELETED' and user_role_id='4'");
                        } else {
                          $GetUSERS = SELECT("SELECT * FROM users where company_relation='" . company_id . "' and user_status!='DELETED' and user_role_id='4' limit $start, $listcounts");
                        }

                        $CounTUsers = mysqli_num_rows($GetUSERS);

                        if ($CounTUsers == 0) { ?>

                          <tr>
                            <td colspan="8" align="center">No Customer Found!</td>
                          </tr>

                          <?php } else {
                          while ($AllUsers = mysqli_fetch_array($GetUSERS)) {
                            $customersid[] = $AllUsers['id'];
                          }
                          include "../../include//extra/serial-no.php";
                          $count = $SerialNo;
                          foreach ($customersid as $id) {
                            $getusers = SELECT("SELECT * FROM users, user_address, user_roles where users.company_relation='" . company_id . "' and users.id='$id' and users.user_role_id='4' and users.id=user_address.user_id and users.user_role_id=user_roles.role_id");
                            while ($customers = mysqli_fetch_array($getusers)) {
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
                              $father_name = $customers['father_name'];
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
                              $Bookings = TOTAL("SELECT * FROM bookings where customer_id='$executedcustomer_id'"); ?>
                              <tr>
                                <td><?php echo $count; ?></td>
                                <td>CUST00<?php echo $executedcustomer_id; ?></td>
                                <td>
                                  <img src="<?php echo $customer_user_profile_img; ?>" style="width:19px;height:19px;" alt="<?php echo $customer_name; ?>" title="<?php echo $customer_name; ?>">
                                  <a href="dashboard/?id=<?php echo $id; ?>" class="text-primary"><?php echo $customer_name; ?></a>
                                </td>
                                <td>
                                  <a href="mailto:<?php echo $customer_email; ?>" class="text-primary"><i class="fa fa-envelope text-danger"></i> <?php echo $customer_email; ?></a>
                                </td>
                                <td>
                                  <a href="tel:<?php echo $customer_phone; ?>" class="text-primary"><i class="fa fa-phone text-success"></i>
                                    <?php echo $customer_phone; ?></a>
                                </td>
                                <td>
                                  <?php echo $user_status_view; ?>
                                </td>
                                <td class="text-primary"><?php echo $Bookings; ?> Bookings</td>
                                <td>
                                  <div class="btn-group-sm btn-group">
                                    <a href="dashboard/?id=<?php echo $id; ?>" class="btn btn-sm btn-success"><i class="fa fa-home"></i></a>
                                    <a href="details/?id=<?php echo $id; ?>" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <?php
                                    if (LOGIN_UserId == APP_ID) {
                                      if ($Bookings == 0) {
                                        CONFIRM_DELETE_POPUP(
                                          "customers",
                                          [
                                            "delete_agent_records" => true,
                                            "control_id" => $executedcustomer_id,
                                          ],
                                          "usercontroller",
                                          "<i class='fa fa-trash'></i>",
                                          "btn btn-sm btn-danger"
                                        );
                                      }
                                    } ?>
                                  </div>
                                </td>
                              </tr>
                        <?php }
                          }
                        } ?>
                      </table>
                    </div>
                    <?php include "../../include/extra/pagination.php"; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


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
              <input type="hidden" name="agent_relation" value="0">
              <?php FormPrimaryInputs(true); ?>
              <div class="row">
                <div class="from-group col-md-6">
                  <label>Full Name</label>
                  <input type="text" name="name" value="" class="form-control" placeholder="">
                </div>
                <div class="from-group col-md-6">
                  <label>S/O, W/O, D/O</label>
                  <input type="text" name="father_name" value="" class="form-control" placeholder="">
                </div>
                <div class="from-group col-md-6">
                  <label>Email</label>
                  <input type="email" name="email" value="" class="form-control" placeholder="">
                </div>
                <div class="from-group col-md-6">
                  <label>Phone Number</label>
                  <input type="text" name="phone" value="" class="form-control" placeholder="">
                </div>
                <div class="from-group col-md-6">
                  <label>Address</label>
                  <input type="text" name="user_street_address" value="" class="form-control" placeholder="">
                </div>
                <div class="from-group col-md-6">
                  <label>Area Locality</label>
                  <input type="text" name="user_area_locality" value="" class="form-control" placeholder="">
                </div>
                <div class="from-group col-md-6">
                  <label>City</label>
                  <input type="text" name="user_city" value="" class="form-control" placeholder="">
                </div>
                <div class="from-group col-md-6">
                  <label>State</label>
                  <input type="text" list="statess" name="user_state" value="" class="form-control" placeholder="">
                </div>
                <div class="from-group col-md-6">
                  <label>Pincode</label>
                  <input type="text" name="user_pincode" value="" class="form-control" placeholder="">
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
            <button type="submit" name="create_new_user" value="<?php echo $company_id; ?>" class="btn btn-success">Create</button>
            </form>
          </div>
        </div>
      </div>
    </div>


    <!-- end -->
    <?php include '../sidebar.php'; ?>
    <?php include '../footer.php'; ?>
  </div>

  <?php include '../../include/footer_files.php'; ?>
</body>

</html>
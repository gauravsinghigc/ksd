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
  <title>Employees | <?php echo company_name; ?></title>
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
                      <h3 class="m-t-3"><i class="fa fa-briefcase app-text"></i> All Employees</h3>
                    </div>
                    <div class="col-md-12">
                      <div class="flex-s-b">
                        <div class="btn-group btn-group-sm w-100 m-r-20 m-l-5 m-b-10">
                          <a class="btn btn-primary square btn-labeled fa fa-plus" data-toggle="modal" data-target="#add_data">Employee</a>
                          <a href="attandance.php" class="btn btn-success square btn-labeled fa fa-exchange">Attadance</a>
                          <?php if (isset($_GET['search'])) { ?>
                            <a href="<?php echo DOMAIN; ?>/admin/employees/export_all.php?search_type=<?php echo $_GET['search_type']; ?>&search_value=<?php echo $_GET['search_value']; ?>&search=true" target="blank" class="btn btn-secondary square btn-labeled fa fa-print">Export All</a>
                          <?php } else { ?>
                            <a href="<?php echo DOMAIN; ?>/admin/employees/export_all.php" target="blank" class="btn btn-secondary square btn-labeled fa fa-print">Export All</a>
                          <?php } ?>
                        </div>

                        <div class="btn-group btn-group-sm w-100 m-r-20 m-l-5 m-b-10">
                          <form action="" method="GET" class="flex-s-b form-search-filter w-100">
                            <span class="w-100 p-1 text-right"><b>Search Employee</b></span>
                            <select name="search_type" class="form-control">
                              <option value="id">Employee ID</option>
                              <option value="name">Employee Name</option>
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
                            <a href="index.php" class="text-danger"><span class="text-white"><i class="fa fa-times"></i> Clear</span></a>
                          </p>
                        </center>
                      <?php } ?>
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>SNo</th>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>

                        <?php
                        if (isset($_GET['search'])) {
                          $search_value = $_GET['search_value'];
                          $search_type = $_GET['search_type'];
                          $GetUSERS = SELECT("SELECT * FROM users where $search_type like '%$search_value%' and company_relation='" . company_id . "' and user_status!='DELETED' and user_role_id='5'");
                          $CheckUsers = CHECK("SELECT * FROM users where $search_type like '%$search_value%' and company_relation='" . company_id . "' and user_status!='DELETED' and user_role_id='5'");
                        } else {
                          $GetUSERS = SELECT("SELECT * FROM users where company_relation='" . company_id . "' and user_status!='DELETED' and user_role_id='5'");
                        }

                        $CounTUsers = mysqli_num_rows($GetUSERS);

                        if ($CounTUsers == 0) { ?>

                          <?php } else {
                          while ($AllUsers = mysqli_fetch_array($GetUSERS)) {
                            $customersid[] = $AllUsers['id'];
                          }
                          $count = 0;
                          foreach ($customersid as $id) {
                            $getusers = SELECT("SELECT * FROM users, user_address, user_roles where users.company_relation='" . company_id . "' and users.id='$id' and users.user_role_id='5' and users.id=user_address.user_id and users.user_role_id=user_roles.role_id");
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
                              if ($user_status == "ACTIVE") {
                                $user_status_view = "<span class='text-success'><i class='fa fa-check-circle'></i> Active</span>";
                              } else {
                                $user_status_view = "<span class='text-danger'><i class='fa fa-warning'></i> Inactive</span>";
                              }
                              if ($customer_user_profile_img == "user.png") {
                                $customer_user_profile_img = DOMAIN . "/storage/sys-img/$customer_user_profile_img";
                              } else {
                                $customer_user_profile_img = DOMAIN . "/storage/users/$executedcustomer_id/img/$customer_user_profile_img";
                              } ?>
                              <tr>
                                <td><?php echo $count; ?></td>
                                <td>EMP00<?php echo $executedcustomer_id; ?></td>
                                <td>
                                  <img src="<?php echo $customer_user_profile_img; ?>" style="width:19px;height:19px;" alt="<?php echo $customer_name; ?>" title="<?php echo $customer_name; ?>">
                                  <a href="dashboard/?id=<?php echo $id; ?>" class="text-primary"><?php echo $customer_name; ?></a>
                                </td>
                                <td>
                                  <a href="mailto=<?php echo $customer_email; ?>" class="text-primary"><i class="fa fa-envelope text-danger"></i> <?php echo $customer_email; ?></a>
                                </td>
                                <td>
                                  <a href="tel=<?php echo $customer_phone; ?>" class="text-primary"><i class="fa fa-phone text-success"></i> <?php echo $customer_phone; ?></a>
                                </td>
                                <td>
                                  <?php echo $user_status_view; ?>
                                </td>
                                <td>
                                  <div class="btn-group-sm btn-group">
                                    <a href="dashboard/?id=<?php echo $id; ?>" class="btn btn-sm btn-success"><i class="fa fa-home"></i></a>
                                    <a href="details/?id=<?php echo $id; ?>" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                                    <a type="button" data-toggle="modal" data-target="#view_project_<?php echo $executedcustomer_id; ?>" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                                  </div>
                                </td>
                              </tr>
                              <!-- Modal  3-->
                              <div class="modal fade square" id="view_project_<?php echo $executedcustomer_id; ?>" role="dialog">
                                <div class="modal-dialog modal-lg">
                                  <div class="modal-content">
                                    <div class="modal-header app-bg text-white">
                                      <button type="button" class="close text-white m-r-8 m-t-1" data-dismiss="modal">&times;</button>
                                      <h4 class="modal-title text-white">Edit Employee Details</h4>
                                    </div>
                                    <div class="modal-body">
                                      <form action="../../controller/usercontroller.php" method="POST">
                                        <?php FormPrimaryInputs(true); ?>
                                        <div class="row">
                                          <div class="from-group col-md-6">
                                            <label>Full Name</label>
                                            <input type="text" name="name" value="<?php echo $customer_name; ?>" class="form-control" placeholder="" required="">
                                          </div>
                                          <div class="from-group col-md-6">
                                            <label>Email</label>
                                            <input type="email" name="email" value="<?php echo $customer_email; ?>" class="form-control" placeholder="">
                                          </div>
                                          <div class="from-group col-md-6">
                                            <label>Phone Number</label>
                                            <input type="text" name="phone" value="<?php echo $customer_phone; ?>" class="form-control" placeholder="" required="">
                                          </div>
                                          <div class="from-group col-md-6">
                                            <label>Address</label>
                                            <input type="text" name="user_street_address" value="<?php echo $user_street_address; ?>" class="form-control" placeholder="" required="">
                                          </div>
                                          <div class="from-group col-md-6">
                                            <label>Area Locality</label>
                                            <input type="text" name="user_area_locality" value="<?php echo $user_area_locality; ?>" class="form-control" placeholder="" required="">
                                          </div>
                                          <div class="from-group col-md-6">
                                            <label>City</label>
                                            <input type="text" name="user_city" value="<?php echo $user_city; ?>" class="form-control" placeholder="" required="">
                                          </div>
                                          <div class="from-group col-md-6">
                                            <label>State</label>
                                            <input type="text" name="user_state" value="<?php echo $user_state; ?>" class="form-control" placeholder="" required="">
                                          </div>
                                          <div class="from-group col-md-6">
                                            <label>Pincode</label>
                                            <input type="text" name="user_pincode" value="<?php echo $user_pincode; ?>" class="form-control" placeholder="" required="">
                                          </div>
                                          <div class="from-group col-md-6">
                                            <label>Change Status</label>
                                            <select name="user_status" class="form-control" required="">
                                              <?php if ($user_status == "ACTIVE") { ?>
                                                <option value="ACTIVE" selected="">ACTIVE</option>
                                                <option value="INACTIVE">INACTIVE</option>
                                              <?php } else { ?>
                                                <option value="INACTIVE" selected="">INACTIVE</option>
                                                <option value="ACTIVE">ACTIVE</option>
                                              <?php } ?>
                                            </select>
                                          </div>
                                          <div class="from-group col-md-6">
                                            <label>Change User Role</label>
                                            <select name="user_role_id" class="form-control text-uppercase" required="">
                                              <option value="<?php echo $user_role_id; ?>" selected=""><?php echo $user_role_name; ?></option>
                                              <?php
                                              $getuserroles = SELECT("SELECT * FROM user_roles where role_id!='$user_role_id'");
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
                                      <button type="submit" name="update_customers" value="<?php echo $executedcustomer_id; ?>" class="btn btn-success">Save Updates</button>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                        <?php }
                          }
                        } ?>
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
              <?php FormPrimaryInputs(
                true,
                ["user_country" => "India"]
              ); ?>
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
                    $getuserroles = SELECT("SELECT * FROM user_roles where role_id='5'");
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


    <!-- end -->
    <?php include '../sidebar.php'; ?>
    <?php include '../footer.php'; ?>
  </div>

  <?php include '../../include/footer_files.php'; ?>
</body>

</html>
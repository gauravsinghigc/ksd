<?php
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Module Settings | <?php echo company_name; ?></title>
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
        <!--===================================================-->
        <div id="page-content">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-12">
              <div class="panel square">
                <div class="panel-body">
                  <div class="row">
                    <div class="col-md-12">
                      <h3 class="m-t-3"><i class="fa fa-tree app-text"></i> All Modules</h3>
                    </div>
                    <div class="col-md-12">
                      <div class="flex-s-b">
                        <div class="btn-group btn-group-sm w-100 m-b-10">
                          <a class="btn btn-primary square btn-labeled fa fa-eye" href="../index.php">Module Access</a>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12 col-sm-12 p-l-0 p-r-0">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th style="width:5%;">ID</th>
                            <th>Name</th>
                            <th>Access</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $SQL_Module = SELECT("SELECT * FROM module_list ORDER BY module_id DESC");
                          while ($Modules = mysqli_fetch_array($SQL_Module)) {
                            $module_id = $Modules['module_id'];

                            $ModuleAccess = TOTAL("SELECT * FROM module_controls where moduleid='$module_id'"); ?>
                            <tr>
                              <td><?php echo $Modules['module_id']; ?></td>
                              <td><?php echo $Modules['module_name']; ?></td>
                              <td><i class="fa fa-user text-info"></i> <?php echo $ModuleAccess; ?></td>
                              <td><?php echo $Modules['status']; ?></td>
                            </tr>
                          <?php } ?>
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


    <!-- Modal  3-->
    <div class="modal fade square" id="add_data" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header app-bg text-white">
            <button type="button" class="close text-white m-r-8 m-t-1" data-dismiss="modal">&times;</button>
            <h4 class="modal-title text-white">Add Customer</h4>
          </div>
          <div class="modal-body overflow-auto">
            <form action="../../../controller/usercontroller.php" method="POST">
              <input type="text" name="user_country" value="INDIA" hidden="">
              <input type="text" name="access_url" value="../admin/customer/" hidden="">
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
      <!--===================================================-->
      <!--End page content-->
    </div>
    <!--===================================================-->
    <!--END CONTENT CONTAINER-->



    <!-- end -->
    <?php include '../../sidebar.php'; ?>
    <?php include '../../footer.php'; ?>
  </div>

  <?php include '../../../include/footer_files.php'; ?>
</body>

</html>
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
  <title>Dashboard | <?php echo company_name; ?></title>
  <?php include '../../../include/header_files.php'; ?>
</head>

<body>
  <div id="container" class="navbar-fixed mainnav-fixed mainnav-lg">
    <?php include '../../header.php';
    if (isset($_GET['id'])) {
      $ViewCustomerId = $_GET['id'];
      $_SESSION['USER_VIEW_ID'] = $_GET['id'];
    } else {
      $ViewCustomerId = $_SESSION['USER_VIEW_ID'];
    }
    $CustomerId = $ViewCustomerId;
    $Select_Users = "SELECT * FROM users where id='$CustomerId'";
    $Query = mysqli_query($DBConnection, $Select_Users);
    $Customers = mysqli_fetch_assoc($Query);
    $C_user_role_id = $Customers['user_role_id'];
    $C_name = $Customers['name'];
    $C_email = $Customers['email'];
    $C_phone = $Customers['phone'];
    $C_user_profile_img = $Customers['user_profile_img'];
    $C_created_at = $Customers['created_at'];
    $C_updated_at = $Customers['updated_at'];
    $C_password = $Customers['password'];
    $C_company_relation_id = $Customers['company_relation'];
    if ($C_user_profile_img == null or $C_user_profile_img == "user.png") {
      $C_user_profile_img = DOMAIN . "/storage/sys-img/user.png";
    } else {
      $C_user_profile_img = DOMAIN . "/storage/users/$CustomerId/img/$C_user_profile_img";
    }
    //customer address
    $C_FetchAddress = SELECT("SELECT * FROM user_address where user_id='$CustomerId'");
    $C_IfExits = mysqli_num_rows($C_FetchAddress);
    if ($C_IfExits == 0) {
      $C_user_street_address = "";
      $C_user_area_locality = "";
      $C_user_state = "";
      $C_user_city = "";
      $C_user_pincode = "";
      $C_created_at = "";
      $C_updated_at = "";
      $C_user_country = "";
    } else {
      $C_fetchAdd = mysqli_fetch_array($C_FetchAddress);
      $C_user_street_address = htmlentities($C_fetchAdd['user_street_address']);
      $C_user_area_locality = $C_fetchAdd['user_area_locality'];
      $C_user_city = $C_fetchAdd['user_city'];
      $C_user_state = $C_fetchAdd['user_state'];
      $C_user_pincode = $C_fetchAdd['user_pincode'];
      $C_user_country = $C_fetchAdd['user_country'];
      $C_created_at = $C_fetchAdd['created_at'];
      $C_updated_at = $C_fetchAdd['updated_at'];
    }

    //customer type
    $C_Select_UsersTypes = SELECT("SELECT * from user_roles where role_id='$C_user_role_id'");
    $C_UserTypes = mysqli_fetch_assoc($C_Select_UsersTypes);
    $C_role_name = $C_UserTypes['role_name']; ?>
    <!--END NAVBAR-->
    <div class="boxed">
      <!--CONTENT CONTAINER-->
      <!--===================================================-->
      <div id="content-container">
        <!--Page content-->
        <!--===================================================-->
        <div id="page-content">
          <div class="panel">
            <div class="panel-body">
              <div class="row">
                <div class="col-md-12">
                  <h3 class="m-t-3"><i class="fa fa-user app-text"></i> Employee Details</h3>
                </div>
                <?php include "c-profile.php"; ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xs-12 c-dashboard-padding">
                  <?php include "common-nav.php"; ?>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <h4 class="section-heading">Primary Information</h4>
                </div>
              </div>

              <form action="<?php echo CONTROLLER; ?>/empcontroller.php" method="POST">
                <?php FormPrimaryInputs(
                  true,
                  [
                    "edit_request_for" => $ViewCustomerId,
                  ]
                ); ?>
                <div class="row">
                  <div class="col-md-12">
                    <h5 class="app-sub-heading">Primary Information</h5>
                  </div>
                  <div class="col-md-3 form-group">
                    <label>FullName</label>
                    <input type="text" name="name" class="form-control" value="<?php echo $C_name; ?>" required="">
                  </div>
                  <div class="col-md-3 form-group">
                    <label>Phone Number</label>
                    <input type="tel" name="phone" class="form-control" value="<?php echo $C_phone; ?>" required="">
                  </div>
                  <div class="col-md-4 form-group">
                    <label>Email Id</label>
                    <input type="email" name="email" class="form-control" value="<?php echo $C_email; ?>" required="">
                  </div>
                  <div class="col-md-12">
                    <button type="submit" name="UpdateProfileDetails" class="btn btn-md btn-success"><i class="fa fa-check-circle-o"></i> Update Profile </button>
                  </div>
                </div>
              </form>
              <div class="row mb-5px">
                <div class="col-md-12">
                  <h5 class="app-sub-heading">Contact Address</h5>
                </div>
              </div>
              <form action="<?php echo CONTROLLER; ?>/empcontroller.php" method="POST">
                <?php FormPrimaryInputs(
                  true,
                  [
                    "edit_request_for" => $ViewCustomerId,
                  ]
                ); ?>
                <div class="row mb-10px">
                  <div class="form-group col-lg-6 col-md-6 col-12">
                    <label>House No/Flat no Address</label>
                    <input type="text" name="user_street_address" value="<?php echo $C_user_street_address; ?>" class="form-control">
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-12">
                    <label>Sector/Locality/Area/Landmark</label>
                    <input type="text" name="user_area_locality" value="<?php echo $C_user_area_locality; ?>" class="form-control">
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-12">
                    <label>City</label>
                    <input type="text" name="user_city" value="<?php echo $C_user_city; ?>" class="form-control">
                  </div>
                  <div class="form-group col-lg-4 col-md-4 col-12">
                    <label>State</label>
                    <input type="text" name="user_state" value="<?php echo $C_user_state; ?>" class="form-control">
                  </div>
                  <div class="form-group col-lg-4 col-md-4 col-12">
                    <label>Country</label>
                    <input type="text" name="user_country" value="<?php echo $C_user_country; ?>" class="form-control">
                  </div>
                  <div class="form-group col-lg-4 col-md-4 col-12">
                    <label>Pincode</label>
                    <input type="text" name="user_pincode" value="<?php echo $C_user_pincode; ?>" class="form-control">
                  </div>

                  <div class="col-md-12">
                    <button type="submit" name="UpdateAddress" class="btn btn-md btn-success">Update Address Details</button>
                  </div>
                </div>
              </form>
            </div>
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
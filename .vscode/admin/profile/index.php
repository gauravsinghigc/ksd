<?php
require '../../require/modules.php';
require "../../require/admin/sessionvariables.php";
require '../../include/admin/common.php';
$_SESSION['update_profile'] = VALIDATOR_REQ;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Profile | <?php echo company_name; ?></title>
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
        <!--===================================================-->
        <div id="page-content">
          <div class="panel">
            <div class="panel-body">
              <div class="row">
                <div class="col-md-12">
                  <h3 class="m-t-3"><i class="fa fa-user app-text"></i> Profile</h3>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-12 col-xs-12">
                  <form action="../../controller/authcontroller.php" method="POST" enctype="multipart/form-data" onsubmit="actionBtn('updateprofileimg', 'Uploading...')">
                    <?php FormPrimaryInputs(true); ?>
                    <label for="for-user-logo">
                      <div class="upload-logo fs-10" id="updateprofileimg">
                        <i class="fa fa-edit"></i> Update Profile Image
                      </div>
                    </label>
                    <input type="FILE" id="for-user-logo" name="user_profile_img" class="display-none" onchange="form.submit()">
                    <input type="text" name="ChangeProfileImg" value="<?php echo LOGIN_UserId; ?>" hidden="">
                  </form>
                  <div class="userWidget-1">
                    <div class="avatar app-bg">
                      <img src="<?php echo LOGIN_UserProfileImage; ?>" alt="avatar">
                      <div class="name osLight"> <?php echo LOGIN_UserFullName; ?> </div>
                    </div>
                    <div class="title"> <?php echo LOGIN_UserRoleName; ?> </div>
                    <div class="address"> <?php echo LOGIN_UserCity ?>, <?php echo LOGIN_UserState ?> </div>
                    <div class="panel-body mt-3 pt-3">
                      <table class="table">
                        <tbody>
                          <tr>
                            <td><i class="fa fa-envelope-o ph-5"></i></td>
                            <td> <a href="mailto:<?php echo LOGIN_UserEmailId ?>"><?php echo LOGIN_UserEmailId ?></a> </td>
                          </tr>
                          <tr>
                            <td><i class="fa fa-phone ph-5"></i></td>
                            <td><a href="<?php echo LOGIN_UserPhoneNumber ?>"><?php echo LOGIN_UserPhoneNumber ?></a> </td>
                          </tr>
                          <tr>
                            <td><i class="fa fa-map-marker ph-5"></i></td>
                            <td> <?php echo LOGIN_UserStreetAddess; ?>, <?php echo LOGIN_UserAreaLocality; ?>, <?php echo LOGIN_UserCity; ?>, <?php echo LOGIN_UserState; ?> <?php echo LOGIN_UserCountry; ?> - <?php echo LOGIN_UserPincode; ?></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="clearfix"> </div>
                  </div>

                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-12 col-xs-12">
                  <div class="panel">
                    <div class="panel-body pad-no">
                      <!--Default Tabs (Left Aligned)-->
                      <!--===================================================-->
                      <div class="tab-base">
                        <!--Nav Tabs-->
                        <ul class="nav nav-tabs">
                          <li class="active"> <a data-toggle="tab" href="#profile"> Profile </a> </li>
                          <li> <a data-toggle="tab" href="#security">Login & Security</a> </li>
                        </ul>
                        <!--Tabs Content-->
                        <div class="tab-content">

                          <div id="profile" class="tab-pane fade active in">
                            <h4 class="p-1r">Update Profile</h4>
                            <form action="../../controller/authcontroller.php" class="mt-3" method="POST">
                              <?php echo FormPrimaryInputs(true); ?>
                              <div class="row">
                                <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                                  <input id="name" class="form-control" type="text" value="<?php echo LOGIN_UserFullName; ?>" name="name" placeholder="Full Name" required="">
                                </div>
                                <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                                  <input id="email" class="form-control" type="email" name="email" value="<?php echo LOGIN_UserEmailId; ?>" placeholder="Email Id" required="">
                                </div>
                                <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                                  <input id="phone" class="form-control" type="text" name="phone" value="<?php echo LOGIN_UserPhoneNumber; ?>" placeholder="00000000" required="">
                                </div>
                                <div class="form-group col-md-12">
                                  <button class="btn btn-primary btn-md" name="update_profile" value="<?php echo LOGIN_UserId; ?>" type="submit" onclick="actionBtn('updateprofileinfo', 'Saving Updates...')" id="updateprofileinfo">Update Profile</button>
                                </div>
                              </div>
                            </form>
                          </div>

                          <div id="security" class="tab-pane fade in pb-4">
                            <h4 class="p-1r">Update Password</h4>
                            <a href="<?php echo DOMAIN; ?>/auth/forget/" class="btn btn-md btn-primary" target="_blank"><i class="fa fa-edit"></i> Change Password</a>
                            <hr>
                          </div>

                        </div>
                      </div>
                      <!--===================================================-->
                      <!--End Default Tabs (Left Aligned)-->
                    </div>
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
          <?php include '../sidebar.php'; ?>
          <?php include '../footer.php'; ?>
        </div>

        <?php include '../../include/footer_files.php'; ?>
</body>

</html>
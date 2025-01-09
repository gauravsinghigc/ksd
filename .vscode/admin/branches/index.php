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
  <title>Profile | <?php echo $company_name; ?></title>
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
        <div class="pageheader hidden-xs">
          <h3> Profile </h3>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li> <a href="/admin"> Home </a> </li>
              <li class="active"> <?php echo $name ?> </li>
            </ol>
          </div>
        </div>
        <!--Page content-->
        <!--===================================================-->
        <div id="page-content">
          <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-12 col-xs-12">
              <form action="../../controller/authcontroller.php" method="POST" enctype="multipart/form-data">
                <label for="for-user-logo">
                  <div class="upload-logo fs-10">
                    <i class="fa fa-edit"></i> Update Profile Image
                  </div>
                </label>
                <input type="FILE" id="for-user-logo" name="user_profile_img" class="display-none" onchange="form.submit()">
                <input type="text" name="ChangeProfileImg" value="<?php echo $Token; ?>" hidden="">
              </form>
              <div class="userWidget-1">
                <div class="avatar app-bg">
                  <img src="<?php echo $user_profile_img; ?>" alt="avatar">
                  <div class="name osLight"> <?php echo $name ?> </div>
                </div>
                <div class="title"> <?php echo $role_name ?> </div>
                <div class="address"> <?php echo $user_city ?>, <?php echo $user_state ?> </div>
                <div class="panel-body mt-3 pt-3">
                  <table class="table">
                    <tbody>
                      <tr>
                        <td><i class="fa fa-envelope-o ph-5"></i></td>
                        <td><a href="mailto:<?php echo $email ?>"><?php echo $email ?></a> </td>
                      </tr>
                      <tr>
                        <td><i class="fa fa-phone ph-5"></i></td>
                        <td><a href="<?php echo $phone ?>"><?php echo $phone ?></a> </td>
                      </tr>
                      <!--<tr>
          <td><i class="fa fa-map-marker ph-5"></i></td>
          <td> <?php echo $user_street_address ?>, <?php echo $user_area_locality ?>, <?php echo $user_city ?>, <?php echo $user_state ?> <?php echo $user_country ?> - <?php echo $user_pincode ?></td>
         </tr> -->
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
                          <div class="row">
                            <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                              <input id="name" class="form-control" type="text" value="<?php echo $name ?>" name="name" placeholder="Full Name" required="">
                            </div>
                            <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                              <input id="email" class="form-control" type="email" name="email" value="<?php echo $email ?>" placeholder="Email Id" required="">
                            </div>
                            <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                              <input id="phone" class="form-control" type="text" name="phone" value="<?php echo $phone ?>" placeholder="00000000" required="">
                            </div>
                            <div class="form-group col-md-12">
                              <button class="btn btn-primary btn-md" name="update_profile" value="<?php echo $Token; ?>" type="submit" id="updatebtn">Update Profile</button>
                            </div>
                          </div>
                        </form>
                      </div>

                      <div id="security" class="tab-pane fade in">
                        <h4 class="p-1r">Update Password</h4>
                        <form action="../../controller/authcontroller.php" class="mt-3" method="POST">
                          <div class="row">
                            <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                              <input id="password" class="form-control" type="text" name="c_password" placeholder="Full Name" required="">
                            </div>
                            <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                              <input id="password" class="form-control" type="password" name="n_pass" placeholder="*******" required="">
                            </div>
                            <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                              <input id="password" class="form-control" type="password" name="n_pass_r" placeholder="********" required="">
                            </div>
                            <div class="form-group col-md-12">
                              <button class="btn btn-primary btn-md" name="update_password" value="<?php echo $Token; ?>" type="submit" id="updatebtn">Update Password</button>
                            </div>
                          </div>
                        </form>

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
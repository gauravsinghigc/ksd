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
  <title>Profile | <?php echo company_name; ?></title>
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
    $C_agent_id = $Customers['agent_relation'];
    $C_father_name = $Customers['father_name'];
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
    $C_role_name = $C_UserTypes['role_name'];

    //agent involve
    $C_agents = SELECT("SELECT * FROM users where id='$C_agent_id'");
    $FetchAgents = mysqli_fetch_assoc($C_agents);
    $agent_name = $FetchAgents['name'];
    ?>
    <!--END NAVBAR-->
    <div class="boxed">
      <!--CONTENT CONTAINER-->
      <!--===================================================-->
      <div id="content-container">
        <!--===================================================-->
        <div id="page-content">
          <div class="panel">
            <div class="panel-body">
              <div class="row">
                <div class="col-md-12">
                  <h3 class="m-t-3 m-b-0"><i class="fa fa-user app-text"></i> <?php echo $C_name; ?></h3>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-12 col-xs-12">
                  <form action="../../../controller/usercontroller.php" method="POST" enctype="multipart/form-data" onsubmit="actionBtn('updateprofileimg', 'Uploading...')">
                    <?php FormPrimaryInputs(true); ?>
                    <label for="for-user-logo">
                      <div class="upload-logo fs-10" id="updateprofileimg">
                        <i class="fa fa-edit"></i> Update Profile Image
                      </div>
                    </label>
                    <input type="FILE" id="for-user-logo" name="user_profile_img" class="display-none" onchange="form.submit()">
                    <input type="text" name="ChangeProfileImg" value="<?php echo $CustomerId; ?>" hidden="">
                  </form>
                  <div class="userWidget-1">
                    <div class="avatar app-bg">
                      <img src="<?php echo $C_user_profile_img; ?>" alt="avatar">
                      <div class="name osLight"> <?php echo $C_name ?> </div>
                    </div>
                    <div class="title text-uppercase"> <?php echo $C_role_name ?> </div>
                    <div class="address"> <?php echo $C_user_city ?>, <?php echo $C_user_state ?> </div>
                    <div class="panel-body mt-3 pt-3">
                      <table class="table">
                        <tbody>
                          <tr>
                            <td><i class="fa fa-user text-info ph-5"></i></td>
                            <td>CUST_ID : <?php echo $ViewCustomerId; ?> </td>
                          </tr>
                          <tr>
                            <td><i class="fa fa-envelope-o text-danger ph-5"></i> </td>
                            <td> <a href="mailto:<?php echo $C_email ?>" class="m-l-3"><?php echo $C_email ?></a> </td>
                          </tr>
                          <tr>
                            <td><i class="fa fa-phone text-primary ph-5"></i></td>
                            <td> <a href="<?php echo $C_phone ?>"><?php echo $C_phone ?></a> </td>
                          </tr>
                          <tr>
                            <td><i class="fa fa-map-marker text-success ph-5"></i></td>
                            <td> <?php echo $C_user_street_address ?>, <?php echo $C_user_area_locality ?>, <?php echo $C_user_city ?>, <?php echo $C_user_state ?> <?php echo $C_user_country ?> - <?php echo $C_user_pincode ?></td>
                          </tr>
                          <tr>
                            <td><i class="fa fa-user text-warning ph-5"></i></td>
                            <td>
                              <div class="flex-s-b">
                                <span>
                                  AGENT ID : <?php echo $C_agent_id; ?> <br>
                                  <?php echo $agent_name; ?>
                                </span>
                                <span>
                                  <a href="<?php echo DOMAIN; ?>/admin/partner/details/?id=<?php echo $C_agent_id; ?>" class="btn btn-sm btn-success">View Agent</a>
                                </span>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="clearfix"> </div>
                  </div>

                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-12 col-xs-12 m-t-30">
                  <div class="panel">
                    <div class="tab-base">
                      <!--Nav Tabs-->
                      <ul class="nav nav-tabs">
                        <li> <a href="<?php echo DOMAIN; ?>/admin/customer/dashboard/">Dashboard</a> </li>
                        <li class="active"> <a data-toggle="tab" href="#profile"> Profile </a> </li>
                        <li> <a data-toggle="tab" href="#address"> Address </a> </li>
                        <li> <a data-toggle="tab" href="#security">Login & Security</a> </li>
                      </ul>
                      <!--Tabs Content-->
                      <div class="tab-content">

                        <div id="profile" class="tab-pane fade active in">
                          <h4 class="p-1r">Update Profile</h4>
                          <form action="../../../controller/usercontroller.php" class="mt-3" method="POST">
                            <?php FormPrimaryInputs(true); ?>
                            <div class="row">
                              <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                                <label>Name</label>
                                <input id="name" class="form-control" type="text" value="<?php echo $C_name ?>" name="name" placeholder="Full Name" required="">
                              </div>
                              <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                                <label>Email</label>
                                <input id="email" class="form-control" type="email" name="email" value="<?php echo $C_email ?>" placeholder="Email Id">
                              </div>
                              <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                                <label>Phone</label>
                                <input id="phone" class="form-control" type="text" name="phone" value="<?php echo $C_phone ?>" placeholder="00000000" required="">
                              </div>
                              <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                                <label>S/O, W/O, D/O</label>
                                <input type="text" name="father_name" value="<?php echo $C_father_name; ?>" class="form-control">
                              </div>
                            </div>
                            <div class="row">
                              <div class="from-group col-md-6">
                                <label>Edit Agent Relation</label>
                                <select name="agent_relation" class="form-control" required="">
                                  <?php
                                  $s_partners = SELECT("SELECT * from users where company_relation='" . company_id . "' and user_role_id='3' and user_status!='DELETED'");
                                  while ($partners = mysqli_fetch_array($s_partners)) {
                                    $partner_id = $partners['id'];
                                    $partner_name = $partners['name'];
                                    $partner_email = $partners['email'];
                                    $partner_phone = $partners['phone'];
                                    if ($C_agent_id == $partner_id) {
                                      $selected = "selected";
                                    } else {
                                      $selected = "";
                                    } ?>
                                    <option value="<?php echo $partner_id; ?>" <?php echo $selected; ?>><?php echo $partner_name; ?> : <?php echo $partner_phone; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                            <div class="form-group">
                              <button class="btn btn-primary btn-md" name="update_profile" value="<?php echo $CustomerId; ?>" type="submit" onclick="actionBtn('updateprofileinfo', 'Saving Updates...')" id="updateprofileinfo">Update Profile</button>
                            </div>
                          </form>
                        </div>

                        <div id="address" class="tab-pane fade in">
                          <h4 class="p-1r text-dark">Update Address</h4>
                          <form action="../../../controller/usercontroller.php" method="POST">
                            <?php FormPrimaryInputs(true); ?>
                            <div class="row">
                              <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                                <label>Street Address</label>
                                <textarea class="form-control" name="user_street_address" value="<?php echo $C_user_street_address; ?>" placeholder="House No/Plot No/Flat No/Street Address" rows="5" required=""><?php echo $C_user_street_address; ?></textarea>
                              </div>
                              <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                                <label>Area locality</label>
                                <input id="text" class="form-control" type="text" name="user_area_locality" value="<?php echo $C_user_area_locality; ?>" placeholder="00000000" required="">
                              </div>
                              <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                                <label>City</label>
                                <input id="text" class="form-control" type="text" name="user_city" value="<?php echo $C_user_city; ?>" placeholder="00000000" required="">
                              </div>
                              <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                                <label>State</label>
                                <input id="text" class="form-control" type="text" name="user_state" value="<?php echo $C_user_state; ?>" placeholder="00000000" required="">
                              </div>
                              <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                                <label>Pincode</label>
                                <input id="text" class="form-control" type="text" name="user_pincode" value="<?php echo $C_user_pincode; ?>" placeholder="00000000" required="">
                              </div>
                              <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                                <label>Country</label>
                                <input id="text" class="form-control" type="text" name="user_country" value="<?php echo $C_user_country; ?>" placeholder="00000000" required="">
                              </div>
                              <div class="form-group col-md-12">
                                <button class="btn btn-primary btn-md" name="update_address" value="<?php echo $CustomerId; ?>" type="submit" onclick="actionBtn('updatecompanyaddress', 'Updating Company Adress...')" id="updatecompanyaddress">Update
                                  Address</button>
                              </div>
                            </div>
                          </form>
                        </div>


                        <div id="security" class="tab-pane fade in">
                          <h4 class="p-1r">Update Password</h4>
                          <form action="../../../controller/usercontroller.php" class="mt-3" method="POST">
                            <?php FormPrimaryInputs(true); ?>
                            <div class="row">
                              <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                                <input id="password" class="form-control" type="text" name="c_password" placeholder="Current Password" required="">
                              </div>
                              <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                                <input id="password" class="form-control" type="password" name="n_pass" placeholder="New Password" required="">
                              </div>
                              <div class="form-group col-6 col-md-6 col-lg-6 col-sm-6">
                                <input id="password" class="form-control" type="password" name="n_pass_r" placeholder="Re-Enter New Password" required="">
                              </div>
                              <div class="form-group col-md-12">
                                <button class="btn btn-primary btn-md" name="update_password" value="<?php echo $CustomerId; ?>" type="submit" onclick="actionBtn('updatepassword', 'Update password...')" id="updatepassword">Update Password</button>
                              </div>
                            </div>
                          </form>
                        </div>

                        <!-- Modal  3-->
                        <div class="modal fade square" id="add_documents" role="dialog">
                          <div class="modal-dialog modal-md">
                            <div class="modal-content">
                              <div class="modal-header app-bg text-white">
                                <button type="button" class="close text-white m-r-8 m-t-1" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title text-white">Upload Documents</h4>
                              </div>
                              <div class="modal-body overflow-auto">
                                <form action="../../../controller/usercontroller.php" method="POST" enctype="multipart/form-data">
                                  <?php FormPrimaryInputs(true, [
                                    "user_country" => "India"
                                  ]); ?>
                                  <div class="row">
                                    <div class="from-group col-md-12">
                                      <label>Document Name</label>
                                      <input type="text" name="document_name" value="" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="from-group col-md-12">
                                      <label>Attache File</label><br>
                                      <span class="text-info"> <small>Accepted formates : png, jpeg</small></span>
                                      <input type="FILE" name="document_file" value="" accept="image/png, image/jpeg" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="from-group col-md-12">
                                      <label>Document Status</label>
                                      <select name="document_status" class="form-control" value="" required="">
                                        <option value="Received">Received!</option>
                                        <option value="Checking...">Checking...</option>
                                        <option value="Verified">Verified</option>
                                        <option value="Unverified">Unverified</option>
                                        <option value="Wrong Document">Wrong Documents</option>
                                      </select>
                                    </div>
                                  </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" name="upload_documents" value="" class="btn btn-success" onclick="actionBtn('uploaddocument', 'Uploading...')" id="uploaddocument">Upload</button>
                                </form>
                              </div>
                            </div>
                          </div>
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
        <?php include '../../sidebar.php'; ?>
        <?php include '../../footer.php'; ?>
      </div>

      <?php include '../../../include/footer_files.php'; ?>
</body>

</html>
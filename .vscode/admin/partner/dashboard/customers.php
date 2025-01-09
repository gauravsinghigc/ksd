<?php
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';

if (isset($_GET['id'])) {
  $ViewCustomerId = $_GET['id'];
  $_SESSION['USER_VIEW_ID_AGENT_DASHBOARD'] = $_GET['id'];
} else {
  $ViewCustomerId = $_SESSION['USER_VIEW_ID_AGENT_DASHBOARD'];
}
require "../../../include/admin/page-header-req/user-profile-req.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Dashboard | <?php echo company_name; ?></title>
  <?php include '../../../include/header_files.php'; ?>
  <script>
    window.onload = function() {
      document.getElementById("customers").classList.add("app-bg");
    }
  </script>
</head>

<body>
  <div id="container" class="navbar-fixed mainnav-fixed mainnav-lg">
    <?php include '../../header.php'; ?>
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
                <?php include 'user-info.php'; ?>
                <div class="col-md-12">
                  <h3 class="app-sub-heading">All Customers</h3>
                  <?php
                  $getusers = SELECT("SELECT * FROM users, user_address, user_roles where users.company_relation='$company_id' and agent_relation='$ViewCustomerId' and users.user_role_id='4' and users.id=user_address.user_id and users.user_role_id=user_roles.role_id ORDER BY id DESC");
                  $count = 0;
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
                    $id = $executedcustomer_id;
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
                    <div class="data-list flex-s-b">
                      <span class='w-pr-2'>
                        <span class="text-grey">Sno</span><br>
                        <span><?php echo $count; ?></span>
                      </span>
                      <span class='w-pr-3'>
                        <img src="<?php echo $customer_user_profile_img; ?>" class="img-fluid">
                      </span>
                      <span class='w-pr-23'>
                        <span class='text-grey'>Fullname</span><br>
                        <span class='bold'><a href="<?php echo DOMAIN; ?>/admin/customer/dashboard/?id=<?php echo $id; ?>" class='text-primary'> <?php echo $customer_name; ?></a></span>
                      </span>
                      <span class='w-pr-22'>
                        <span class='text-grey'>EmailId</span><br>
                        <span><a href="mailto:<?php echo $customer_email; ?>"><i class="fa fa-envelope text-danger"></i> <?php echo $customer_email; ?></a></span>
                      </span>
                      <span class='w-pr-15'>
                        <span>
                          <span class='text-grey'>PhoneNumber</span><br>
                          <a href="tel:<?php echo $customer_phone; ?>"><i class="fa fa-phone text-success"></i> <?php echo $customer_phone; ?></a>
                        </span>
                      </span>
                      <span class='w-pr-10'>
                        <span class='text-grey'>Bookings</span><br>
                        <span>
                          <?php echo TOTAL("SELECT * FROM bookings where customer_id='$id'"); ?> Bookings
                        </span>
                      </span>
                      <span class='w-pr-10'>
                        <span class='text-grey'>CreatedAt</span><br>
                        <span><?php echo DATE_FORMATE2("d M, Y", $created_at); ?></span>
                      </span>
                      <span class='w-pr-10 text-right'>
                        <span class='text-grey'>Action</span><br>
                        <a href="<?php echo DOMAIN; ?>/admin/customer/dashboard/?id=<?php echo $id; ?>" class="text-danger"><i class='fa fa-home'></i> Dashboard</a>
                      </span>
                    </div>
                  <?php } ?>
                </div>

              </div>
            </div>

          </div>
        </div>

      </div>

      <?php include '../../sidebar.php'; ?>
      <?php include '../../footer.php'; ?>
    </div>

    <?php include '../../../include/footer_files.php'; ?>
</body>

</html>
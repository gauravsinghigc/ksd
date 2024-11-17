<?php
require '../../require/modules.php';
require "../../require/admin/sessionvariables.php";
require '../../include/admin/common.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Export All Customers</title>
</head>

<body onload="doConvert()" style="font-size:13px !important;color: black !important;margin:auto;font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">

 <section style="border-style:groove; border-width:thin;margin: auto; width: 950px;border: 1px solid rgb(147 78 255);padding: 5px;">
  <small class="float:left;"><i></i></small>
  <div style="text-align:center;">
   <h3 style="line-height:1;margin-bottom:4px;margin-top:0px;font-size:24px !important;">
    ALL CUSTOMERS<br>
    <small style="color:grey; font-size:19px !important;">CUSTOMER DATA</small>
   </h3>
  </div>
  <?php include "../../include/export/rc-header.php"; ?>
  <hr>
  <table style="width: 100%;">
   <thead>
    <tr align="left">
     <th>id</th>
     <th>name</th>
     <th>email </th>
     <th>phone</th>
     <th>user_city</th>
     <th>user_state</th>
     <th>user_street_address</th>
    </tr>
   </thead>
   <tbody>
    <?php
    if (isset($_GET['search'])) {
     $search_value = $_GET['search_value'];
     $search_type = $_GET['search_type'];
     $GetUSERS = SELECT("SELECT * FROM users where $search_type like '%$search_value%' and company_relation='" . company_id . "' and user_status!='DELETED' and user_role_id='4'");
     $CheckUsers = CHECK("SELECT * FROM users where $search_type like '%$search_value%' and company_relation='" . company_id . "' and user_status!='DELETED' and user_role_id='4'");
    } else {
     $GetUSERS = SELECT("SELECT * FROM users where company_relation='$company_id' and user_status!='DELETED' and user_role_id='4'");
    }
    while ($custs = mysqli_fetch_array($GetUSERS)) {
     $id = $custs['id'];
     $getusers = SELECT("SELECT * FROM users, user_address, user_roles where users.company_relation='" . company_id . "' and users.id='$id' and users.user_role_id='4' and users.id=user_address.user_id and users.user_role_id=user_roles.role_id ORDER BY users.id ASC");
     $customers = mysqli_fetch_array($getusers);
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
    ?>
     <tr>
      <td><?php echo $customers['id']; ?></td>
      <td><?php echo $customers['name']; ?></td>
      <td><?php echo $customers['email']; ?></td>
      <td><?php echo $customers['phone']; ?></td>
      <td><?php echo $customers['user_city']; ?></td>
      <td><?php echo $customers['user_state']; ?>-<?php echo $customers['user_pincode']; ?></td>
      <td><?php echo $customers['user_street_address']; ?> <?php echo $customers['user_area_locality']; ?></td>
     </tr>
    <?php } ?>
   </tbody>
  </table>
  <p style="color:grey; font-size:10px;text-align:center;"><b>Exported On:</b> <?php echo date("D d M, Y"); ?> by (UID : <?php echo LOGIN_UserId; ?>) <?php echo LOGIN_UserFullName; ?>, <?php echo LOGIN_UserEmailId; ?>, <?php echo LOGIN_UserPhoneNumber; ?> | <b>UserType :</b> <?php echo LOGIN_UserRoleName; ?></p>

 </section>
</body>

</html>
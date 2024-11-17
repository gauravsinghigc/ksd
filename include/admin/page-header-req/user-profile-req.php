<?php
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
$C_role_name = $C_UserTypes['role_name'];

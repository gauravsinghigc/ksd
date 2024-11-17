<?php
if (empty($_SESSION['UserId'])) {
   LOCATION("info", "Please Login First!", "$DOMAIN/auth/login/");
} else {
   //Users Data
   $UserId = $_SESSION['UserId'];
   $Select_Users = "SELECT * FROM users where id='$UserId'";
   $Query = mysqli_query($DBConnection, $Select_Users);
   $Users = mysqli_fetch_assoc($Query);
   $user_role_id = $Users['user_role_id'];
   $name = $Users['name'];
   $email = $Users['email'];
   $phone = $Users['phone'];
   $user_profile_img = $Users['user_profile_img'];
   $created_at = $Users['created_at'];
   $updated_at = $Users['updated_at'];
   $password = $Users['password'];
   if ($user_profile_img == null) {
      $user_profile_img = "$DOMAIN/storage/img/user.png";
   } else {
      $user_profile_img = "$DOMAIN/storage/users/$UserId/img/$user_profile_img";
   }

   //user address
   $FetchAddress = SELECT("SELECT * FROM user_address where user_id='$UserId'");
   $IfExits = mysqli_num_rows($FetchAddress);
   if ($IfExits == 0) {
      $StreetAddress = "";
      $AreaLocality = "";
      $State = "";
      $City = "";
      $Pincode = "";
      $CreatedAt = "";
      $UpdatedAt = "";
      $Country = "";
   } else {
      $fetchAdd = mysqli_fetch_array($FetchAddress);
      $user_street_address = htmlentities($fetchAdd['user_street_address']);
      $user_area_locality = $fetchAdd['user_area_locality'];
      $user_city = $fetchAdd['user_city'];
      $user_state = $fetchAdd['user_state'];
      $user_pincode = $fetchAdd['user_pincode'];
      $user_country = $fetchAdd['user_country'];
      $created_at = $fetchAdd['created_at'];
      $updated_at = $fetchAdd['updated_at'];
   }

   //UserType
   $Select_UsersTypes = "SELECT * from user_roles where role_id='$user_role_id'";
   $Query = mysqli_query($DBConnection, $Select_UsersTypes);
   $UserTypes = mysqli_fetch_assoc($Query);
   $role_name = $UserTypes['role_name'];

   //Check User access right data 
   if ($role_name == "administrator") {
      LOCATION("success", "Welcome $name, Your are login Successfully!", "$DOMAIN/administrator");
   } elseif ($role_name == "admin") {
      LOCATION("success", "Welcome $name, Your are login Successfully!", "$DOMAIN/admin");
   } else if ($role_name == "partner") {
      LOCATION("success", "Welcome $name, Your are login Successfully!", "$DOMAIN/partner");
   } elseif ($role_name == "customer") {
      LOCATION("success", "Welcome $name, Your are login Successfully!", "$DOMAIN/customer");
   } else {
      LOCATION("danger", "Something Went Wrong!", "$DOMAIN/auth/login");
   }
}

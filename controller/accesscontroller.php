<?php

//add controller helper files
require 'helper.php';

//add aditional requirements
require '../require/admin/sessionvariables.php';

//start your actions from here
if (isset($_POST['GetAccessFOR'])) {
 $RUNNING_URL = $_SESSION['RUNNING_URL'];
 $GetAccessFOR = $_POST['GetAccessFOR'];
 $access_password = $_POST['access_password'];
 $requested_url = SECURE($_POST['requested_url'], "d");

 //check if the user is authorized to access this resource
 if (LOGIN_UserRoleName == "admin" or LOGIN_UserRoleName == "administrator") {

  //if login user is admin/administrator
  $CheckAdminModule = TOTAL("SELECT * FROM module_list where module_name='ADMIN' and status='ACTIVE'");

  if ($CheckAdminModule == 0) {

   //no admin module is registered! please registere a admin module first!
   LOCATION("warning", "Admin Access Denied!", $RUNNING_URL);
  } else {

   //if admin module is found! then check admin credentails for admin foundin admin control!
   $CheckAdminAccess = TOTAL("SELECT * FROM module_controls where moduleid='1' and userid='" . LOGIN_UserId . "' and modulepassword='$access_password' and status='ACTIVE'");
   if ($CheckAdminAccess == 0) {
    LOCATION("danger", "Admin Credentials Do not Match with the System!", $RUNNING_URL);
   } else {

    //if admin access credentails match
    LOCATION("success", "Welcome " . LOGIN_UserFullName . ", You are login successfully!", $requested_url);
   }
  }

  //check module access_url
 } else {

  //first check required module is available or not
  $CheckModule = TOTAL("SELECT * FROM module_list where module_name='$GetAccessFOR' and status='ACTIVE'");
  if ($CheckModule == 0) {

   //if requested module is not found!
   LOCATION("warning", "Requested module :<b>$GetAccessFOR</b> is not Found in the System!<br> Contact to System Support!", $RUNNING_URL);
  } else {

   //if requested module is found!
   //check access is permitted for user or not
   $CheckModuleAccess = TOTAL("SELECT * FROM module_list, module_controls where module_list.module_id=module_controls.moduleid and module_list.module_name='$GetAccessFOR' and module_controls.userid='$UserId'");
   if ($CheckModuleAccess == 0) {

    //ifmodule is not permitted for request submitted user
    LOCATION("warning", "Dear " . LOGIN_UserFullName . ", You are not allowed to access this module!", $RUNNING_URL);
   } else {

    //if module is permitted for request submitted user
    $CheckModuleCredentials = TOTAL("SELECT * FROM module_list, module_controls where module_list.module_id=module_controls.moduleid and module_list.module_name='$GetAccessFOR' and module_controls.userid='" . LOGIN_UserId . "' and module_controls.modulepassword='$access_password' and module_controls.status='ACTIVE'");
    if ($CheckModuleCredentials == "0") {

     //if access_password is wrong
     LOCATION("warning", "Module Password is incorrect!", $RUNNING_URL);
    } else {

     //if module password is OK
     LOCATION("success", "Welcome " . LOGIN_UserFullName . ", You are login in successfully into $GetAccessFOR Module.<br> Have a Nice Day!!!!", $requested_url);
    }
   }
  }
 }
}

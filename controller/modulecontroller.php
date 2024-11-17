<?php
//add controller helper files
require 'helper.php';

//add aditional requirements
require '../require/admin/sessionvariables.php';

//start request processing

//start your actions from here
if (isset($_POST['create_new_module_user'])) {
 $moduleid = $_POST['moduleid'];
 $userid = $_POST['userid'];
 $modulepassword = $_POST['modulepassword'];
 $status = $_POST['status'];
 $created_at = date("d M, Y");
 $createmoduleaccess = SAVE("module_controls", ["userid", "moduleid", "modulepassword", "created_at", "status"]);
 if ($createmoduleaccess == true) {
  LOCATION("success", "New module Access Created!", "$access_url");
 } else {
  LOCATION("danger", "Unable to create new Access for requested module!", "$access_url");
 }

 //delete module
} elseif (isset($_POST['update_module'])) {
 $modulecontrolid = $_POST['update_module'];
 $updated_at = date("d M, Y");
 $update = DELETE("DELETE from module_controls where modulecontrolid='$modulecontrolid'");
 if ($update == true) {
  LOCATION("success", "Module Access Deleted Successfully!", "$access_url");
 } else {
  LOCATION("danger", "Unable to Delete Module Access!", "$access_url");
 }

 //update module settings
} else if (isset($_POST['edit_module_access'])) {
 $modulecontrolid = $_POST['edit_module_access'];
 $moduleid = $_POST['moduleid'];
 $userid = $_POST['userid'];
 $modulepassword = $_POST['modulepassword'];
 $status = $_POST['status'];
 $updated_at = date("d M, Y");

 $update = UPDATE("UPDATE module_controls SET moduleid='$moduleid', userid='$userid', modulepassword='$modulepassword', status='$status', updated_at='$updated_at' where modulecontrolid='$modulecontrolid'");
 RESPONSE($act = $update, $msg = "Module Access is Updated!", "Unable to Update Module!");
}

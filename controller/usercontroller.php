<?php

//add controller helper files
require 'helper.php';

//add aditional requirements
require '../require/admin/sessionvariables.php';

//start request processing

//update customer details
if (isset($_POST['update_customers'])) {
 $customer_id = $_POST['update_customers'];
 $name = $_POST['name'];
 $father_name = $_POST['father_name'];
 if ($_POST['email'] == null or $_POST['email'] == "") {
  $email = "noemail@" . HOST;
 } else {
  $email = $_POST['email'];
 }
 $phone = $_POST['phone'];
 $user_street_address = $_POST['user_street_address'];
 $user_area_locality = $_POST['user_area_locality'];
 $user_city = $_POST['user_city'];
 $user_state = $_POST['user_state'];
 $user_pincode = $_POST['user_pincode'];
 $user_status = $_POST['user_status'];
 $user_role_id = $_POST['user_role_id'];
 $user_country = SECURE($_POST['user_country'], "d");

 $checkPhone = CHECK("SELECT * FROM users where phone='$phone' and id!='$customer_id'");
 if ($checkPhone == 0) {
  $update = UPDATE("UPDATE users SET name='$name', father_name='$father_name', email='$email', phone='$phone', user_status='$user_status', user_role_id='$user_role_id' where id='$customer_id'");
  if ($update == true) {

   //address variable
   $data = array(
    "user_id" => $customer_id,
    "user_street_address" => $_POST['user_street_address'],
    "user_area_locality" => $_POST['user_area_locality'],
    "user_city" => $_POST['user_city'],
    "user_state" => $_POST['user_state'],
    "user_pincode" => $_POST['user_pincode'],
    "user_country" => $user_country
   );

   $CheckAddress = CHECK("SELECT * FROM user_address WHERE user_id='$customer_id'");
   if ($CheckAddress == null) {
    $update = INSERT("user_address", $data);
   } else {
    $update = UPDATE_DATA("user_address", $data, "user_id='$customer_id'");
   }
  } else {
   $update = false;
  }
 } else {
  $update = false;
 }

 RESPONSE($update, "<b>" . $name . "</b> details are updated successfully!", "Unable to update details at the moment!");

 //create new user
} else if (isset($_POST['create_new_user'])) {
 $company_id = $_POST['create_new_user'];
 $company_relation = company_id;
 $complete_url = $access_url;
 $father_name = $_POST['father_name'];
 $name = $_POST['name'];
 if ($_POST['email'] == null or $_POST['email'] == "") {
  $email = "noemail@" . HOST;
 } else {
  $email = $_POST['email'];
 }
 $phone = $_POST['phone'];
 $user_street_address = $_POST['user_street_address'];
 $user_area_locality = $_POST['user_area_locality'];
 $user_city = $_POST['user_city'];
 $user_state = $_POST['user_state'];
 $user_pincode = $_POST['user_pincode'];
 $user_status = $_POST['user_status'];
 $user_role_id = $_POST['user_role_id'];
 $user_country = SECURE($_POST['user_country'], "d");
 $agent_relation = SECURE($_POST['agent_relation'], "d");
 $created_at = RequestDataTypeDate();

 $checkPhone = CHECK("SELECT * FROM users where phone='$phone'");
 if ($checkPhone == 0) {
  $createcustomer = SAVE("users", ["name", "father_name", "email", "phone", "password", "company_relation", "user_role_id", "agent_relation", "created_at"]);
  $selectcustomer = SELECT("SELECT * FROM users ORDER BY id DESC Limit 0, 1");
  $fetchcustomerid = mysqli_fetch_array($selectcustomer);
  $customer_id = $fetchcustomerid['id'];
  $user_id = $customer_id;
  $saveaddress = SAVE("user_address", ["user_id", "user_street_address", "user_area_locality", "user_city", "user_state", "user_pincode", "user_country"]);


  if ($saveaddress == true) {
   if (isset($_POST['booking_process'])) {
    $complete_url = ADMIN_URL . "/booking/project/?customer_id=$user_id";
   }
   LOCATION("success", "New User $name is created!", "$complete_url");
  } else {
   LOCATION("warning", "Unable to Create $name Profile!", "$complete_url");
  }
 } else {
  LOCATION("warning", "$phone is Already Exits", "$complete_url");
 }

 //delete users
} else if (isset($_POST['update_users'])) {
 $user_id = $_POST['update_users'];

 $delete = SELECT("UPDATE users SET user_status='DELETED' where id='$user_id'");
 if ($delete == true) {
  LOCATION("success", "User Deleted Successfully!", "$access_url");
 } else {
  LOCATION("warning", "Unable to Delete User!", "$access_url");
 }

 //update address
} else if (isset($_POST['update_address'])) {
 $action_id = $_POST['update_address'];
 $user_street_address = $_POST['user_street_address'];
 $user_area_locality = $_POST['user_area_locality'];
 $user_state = $_POST['user_state'];
 $user_city = $_POST['user_city'];
 $user_country = $_POST['user_country'];
 $user_pincode = $_POST['user_pincode'];
 $updated_at = RequestDataTypeDate();

 $DATA = array(
  "user_street_address" => $user_street_address,
  "user_area_locality" => $user_area_locality,
  "user_city" => $user_city,
  "user_state" => $user_state,
  "user_country" => $user_country,
  "user_pincode" => $user_pincode,
  "updated_at" => $updated_at,
  "created_at" => RequestDataTypeDate,
  "user_id" => $action_id
 );

 $check = CHECK("SELECT * FROM user_address where user_id='$action_id'");
 if ($check == null) {
  $update = INSERT("user_address", $DATA);
 } else {
  $update = UPDATE("UPDATE user_address SET user_street_address='$user_street_address', user_area_locality='$user_area_locality', user_state='$user_state', user_city='$user_city', user_pincode='$user_pincode', user_country='$user_country' where user_id='$action_id'");
 }
 RESPONSE($act = $update, "Address is Updated!", "Unable to update Address");

 //update profile
} elseif (isset($_POST['update_profile'])) {
 $action_id = $_POST['update_profile'];
 $father_name  = $_POST['father_name'];
 $runurl = $access_url;
 $UserId = $_SESSION['UserId'];
 $name = $_POST['name'];
 $email = $_POST['email'];
 $phone = $_POST['phone'];
 if (isset($_POST['agent_relation'])) {
  $agent_relation = $_POST['agent_relation'];
 } else {
  $agent_relation = "";
 }
 $UpdateProfile = UPDATE("UPDATE users SET name='$name', father_name='$father_name', email='$email', phone='$phone', agent_relation='$agent_relation', updated_at='$date_time_c' where id='$action_id'");
 if ($UpdateProfile == true) {
  LOCATION("success", "$name Profile is Updated!", "$runurl");
 } else {
  LOCATION("danger", "Unable to Update $name Profile", "$runurl");
 }

 //update password
} elseif (isset($_POST['update_password'])) {
 $action_id = $_POST['update_password'];
 $UserId = $_SESSION['UserId'];
 $c_password = $_POST['c_password'];
 $n_pass = $_POST['n_pass'];
 $n_pass_r = $_POST['n_pass_r'];

 if ($password == $c_password) {
  if ($n_pass == $n_pass_r) {

   $UpdatePASSWORD = UPDATE("UPDATE users SET password='$n_pass', updated_at='$date_time_c' where id='$action_id'");
   if ($UpdatePASSWORD == true) {
    LOCATION("success", "Password Changed Successfully!!", "$runurl");
   } else {
    LOCATION("warning", "Unable to change password!", "$runurl");
   }
  } else {
   LOCATION("warning", "New Password do not matched!", "$runurl");
  }
 } else {
  LOCATION("warning", "Current Password is Incorrect", "$runurl");
 }


 //change profile image
} elseif (isset($_POST['ChangeProfileImg'])) {
 $action_id = $_POST['ChangeProfileImg'];
 $UserId = $_SESSION['UserId'];
 $GetUserImg = SELECT("SELECT * FROM users where id='$action_id'");
 $FetchData = mysqli_fetch_array($GetUserImg);
 $user_profile_img = $FetchData['user_profile_img'];

 if ($user_profile_img == "user.png") {
 } else {
  unlink("../storage/users/$action_id/img/$user_profile_img");
 }
 if (!file_exists("../storage/users/$action_id/img/")) {
  mkdir("../storage/users/$action_id/img/", 0777, true);
 }

 $UserProfile = $_FILES['user_profile_img']['name'];
 $temp_name = $_FILES['user_profile_img']['tmp_name'];
 $Folder = "../storage/users/$action_id/img/";
 $temp = explode(".", $_FILES["user_profile_img"]["name"]);
 $newfilename = "navixuserimg_" . $action_id . "_" . rand(1111111, 999999999) . date("_d_M_Y_h_m_s") . '.' . end($temp);
 $FileType = strtolower(pathinfo($newfilename, PATHINFO_EXTENSION));
 if (in_array($FileType, $FileNotAllowed)) {
  LOCATION("warning", "Unable to Upload System File", $access_url);
 } else {
  move_uploaded_file($_FILES['user_profile_img']['tmp_name'], $Folder . $newfilename);
  $updateprofileimag = UPDATE("UPDATE users SET user_profile_img='$newfilename', updated_at='$date_time_c' where id='$action_id'");
  if ($updateprofileimag == true) {
   LOCATION("success", "Profile Image Changed!", "$access_url");
  } else {
   LOCATION("warning", "Unable to change profile img", "$access_url");
  }
 }

 //upload documents
 //upload documents
} elseif (isset($_POST['UploadDocuments']) or isset($_POST['upload_documents'])) {
 $user_id = SECURE($_POST['user_id'], "d");

 $data = array(
  "document_name" => $_POST['document_name'],
  "user_documents_no" => $_POST['user_documents_no'],
  "document_file" => UPLOAD_FILES("../storage/documents/$user_id", "null", $_POST['document_name'], $_POST['user_documents_no'], "document_file"),
  "document_status" => "VERIFIED",
  "document_created_at" => RequestDataTypeDate,
  "document_updated_at" => RequestDataTypeDate,
  "user_id" => $user_id
 );
 $save = INSERT("user_documents", $data);
 RESPONSE($save, $_POST['document_name'] . " is Uploaded Successfully!", "Unable to upload documents at the moment!");

 //edit documents
} elseif (isset($_POST['edit_documents'])) {
 $document_id = $_POST['edit_documents'];
 $document_name = $_POST['document_name'];
 $document_status = $_POST['document_status'];
 $user_documents_no = $_POST['user_documents_no'];
 $updated_at = $date_time_c;

 $update = UPDATE("UPDATE user_documents SET user_documents_no='$user_documents_no', document_name='$document_name', document_status='$document_status' where document_id='$document_id'");
 RESPONSE($act = $update, "$document_name is updated successfully!", "Unable to update $document_name");

 //update notification sound status
} elseif (isset($_POST['notification_update'])) {

 $alert_sound = $_POST["alert_sound"];

 if ($alert_sound == "OFF") {
  $alert_sound = "ON";
 } else {
  $alert_sound = "OFF";
 }

 $UPDATE = UPDATE("UPDATE users SET alert_sound='$alert_sound' where id='" . LOGIN_UserId . "'");
 RESPONSE($UPDATE, "Notification Sound Updated Successfully!", "Unable to Update Notification Sound!");

 //delete users
} elseif (isset($_GET['delete_agent_records'])) {
 $access_url = SECURE($_GET['access_url'], "d");
 $delete_agent_records = SECURE($_GET['delete_agent_records'], "d");

 if ($delete_agent_records == true) {
  $control_id = SECURE($_GET['control_id'], "d");
  $DELETE = DELETE_FROM("users", "id='$control_id'");
  $DELETE = DELETE_FROM("user_address", "user_id='$control_id'");
 } else {
  $DELETE = false;
 }
 RESPONSE($DELETE, "Entery Deleted Successfully!", "Unable to delete user enttry!");

 //delete documents
} elseif (isset($_GET['delete_customer_documents'])) {
 $access_url = SECURE($_GET['access_url'], "d");
 $delete_customer_documents = SECURE($_GET['delete_customer_documents'], "d");

 if ($delete_customer_documents == true) {
  $control_id = SECURE($_GET['control_id'], "d");
  $document_file = FETCH("SELECT * FROM user_documents where document_id='$control_id'", "document_file");
  $user_id = FETCH("SELECT * FROM user_documents where document_id='$control_id'", "user_id");
  unlink("../storage/documents/$user_id/$document_file");
  $DELETE = DELETE_FROM("user_documents", "document_id='$control_id'");
 } else {
  $DELETE = false;
 }
 RESPONSE($DELETE, "Document Deleted Successfully!", "Unable to delete documents");
}

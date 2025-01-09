<?php

//add controller helper files
require 'helper.php';

//add aditional requirements
require '../require/admin/sessionvariables.php';


//start your actions from here
if (isset($_POST['SaveWalkins'])) {
 $WalkinName = POST("WalkinName");
 $WalkinPhone = POST("WalkinPhone");
 $WalkinEmailid = POST("WalkinEmailid");
 $WalkinTypes = POST("WalkinTypes");
 $WalkinAddress = SECURE(POST("WalkinAddress"), "e");
 $WalkinsRemarks = SECURE(POST("WalkinsRemarks"), "e");
 $WalkinCreatedAt = date("d M, Y");

 $Save = SAVE("walkins", ["WalkinName", "WalkinPhone", "WalkinAddress", "WalkinEmailid", "WalkinTypes", "WalkinsRemarks", "WalkinCreatedAt"]);
 RESPONSE($Save, "$WalkinName is Saved in to Walkins Record", "Unable to Save $WalkinName into Walkin Records");

 //save web enuirye
} elseif (isset($_POST['ContactForm'])) {

 $array = array(
  "FullName" => $_POST['FullName'],
  "phone" => $_POST['phone'],
  "email" => $_POST['email'],
  "type" => $_POST['type'],
  "message" => SECURE($_POST['message'], "e"),
  "createdat" => RequestDataTypeDate,
  "status" => "0"
 );
 $Save = INSERT("equiries", $array);
 RESPONSE($Save, "Thanking you for contact us. We receive your query and contact you as soon as possible", "Unable to Send Query at the moment");

 //delete enquiries
} elseif (isset($_GET['delete_enquiries'])) {
 $access_url = SECURE($_GET['access_url'], "d");
 $delete_enquiries = SECURE($_GET['delete_enquiries'], "d");

 if ($delete_enquiries == true) {
  $control_id = SECURE($_GET['control_id'], "d");
  $Delete = DELETE_FROM("equiries", "enquiryid='$control_id'");
  RESPONSE($Delete, "Enquiry record delete successfully", "unable to delete eqnuiry at the momenmt!");
 } else {
  RESPONSE(false, "", "Unable to delete enquiry at the moment!");
 }

 //mark as read
} else if (isset($_POST['ReadEnquiry'])) {
 $enquiryid = SECURE($_POST['enquiryid'], "d");

 $array = array(
  "status" => SECURE($_POST['status'], "d")
 );
 $Update = UPDATE_DATA("equiries", $array, "enquiryid='$enquiryid'");
 RESPONSE($Update, "Enquiry marked as Read Successfully!", "Unable to mark as read!");
}

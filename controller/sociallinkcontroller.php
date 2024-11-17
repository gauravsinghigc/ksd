<?php
//add controller helper files
require 'helper.php';

//add aditional requirements
require '../require/admin/sessionvariables.php';

//start request processing
if (isset($_GET['delete_social_links'])) {
 $access_url = SECURE($_GET['access_url'], "d");
 $delete_social_links = SECURE($_GET['delete_social_links'], "d");

 if ($delete_social_links == true) {
  $control_id = SECURE($_GET['control_id'], "d");
  $Delete = DELETE_FROM("sociallinks", "linkid='$control_id'");
 } else {
  $Delete = false;
 }

 RESPONSE($Delete, "Social Account Link Deleted Successfully!", "Unable to delete social account link at the moment!");

 //update request
} elseif (isset($_POST['updateSocialLink'])) {
 $linkid = $_POST['updateSocialLink'];

 $array = array(
  "title" => $_POST['title'],
  "url" => $_POST['url'],
  "icon" => $_POST['icon'],
  "updated_at" => RequestDataTypeDate,
  "status" => $_POST['status']
 );

 $Update = UPDATE_DATA("sociallinks", $array, "linkid='$linkid'");
 RESPONSE($Update, "Social Media Account Updated Successfully", "Unable to update social media account!");

 //create new links
} else if (isset($_POST['CreateSocialLink'])) {

 $array = array(
  "title" => $_POST['title'],
  "icon" => $_POST['icon'],
  "url" => $_POST['url'],
  "created_at" => RequestDataTypeDate,
  "status" => 1
 );

 $Save = INSERT("sociallinks", $array);
 RESPONSE($Save, "Social Media Link Created successfully!", "Unable to create social media at the moment!");
}

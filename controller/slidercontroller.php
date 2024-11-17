<?php
//add controller helper files
require 'helper.php';

//add aditional requirements
require '../require/admin/sessionvariables.php';

//start request processing
if (isset($_POST['CreateNewSlider'])) {

 $sliders = array(
  "slidertitle" => $_POST['slidertitle'],
  "sliderdesc" => SECURE($_POST['sliderdesc'], "e"),
  "UpdatedAt" => RequestDataTypeDate,
  "CreatedAt" => RequestDataTypeDate,
  "Status" => "1",
  "sliderimg" => UPLOAD_FILES("../storage/website/slider", "null", "SliderImg", $_POST['slidertitle'], "sliderimg")
 );

 $Save = INSERT("sliders", $sliders, false);
 RESPONSE($Save, "Sliders Details Saved Successfully!", "Unable to Save Slider Details!");

 //delete slider
} elseif (isset($_GET['delete_slider_record'])) {
 $access_url = SECURE($_GET['access_url'], "d");
 $delete_slider_record = SECURE($_GET['delete_slider_record'], "d");

 if ($delete_slider_record == true) {
  $control_id = SECURE($_GET['control_id'], "d");
  $delete = DELETE_FROM("sliders", "sliderid='$control_id'");
 } else {
  $delete = false;
 }
 RESPONSE($delete, "Slider Deleted successfully!", "Unable to delete slider at the moment!");

 //update sliders
} elseif (isset($_POST['UpdateSliders'])) {
 $sliderid = SECURE($_POST['sliderid'], "d");
 $sliderimageold = SECURE($_POST['sliderimgold'], "d");

 if ($_FILES['sliderimgnew']['name'] == "null" || $_FILES['sliderimgnew']['name'] == null) {
  $sliderimage = $sliderimageold;
 } else {
  $sliderimage = UPLOAD_FILES("../storage/website/slider", "$sliderimage", "SliderImg", $_POST['slidertitle'], "sliderimgnew");
 }

 $array = array(
  "slidertitle" => $_POST['slidertitle'],
  "sliderdesc" => SECURE($_POST['sliderdesc'], "e"),
  "UpdatedAt" => RequestDataTypeDate,
  "Status" => $_POST['Status'],
  "sliderimg" => $sliderimage,
 );

 $UpdateSlider = UPDATE_DATA("sliders", $array, "sliderid='$sliderid'");
 RESPONSE($UpdateSlider, "Slider Details Updated Successfully!", "Unable to delete slider at the moment!");
}

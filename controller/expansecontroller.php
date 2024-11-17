<?php
//add controller helper files
require 'helper.php';

//add aditional requirements
require '../require/admin/sessionvariables.php';

//start request processing

//start your actions from here
if (isset($_POST['create_new_expanses'])) {
 $expanse_created_by = $UserId;
 $expanses_title = $_POST['expanses_title'];
 $expanses_tags = $_POST['expanses_tags'];
 $expanse_date = $_POST['expanse_date'];
 $expanse_amount = $_POST['expanse_amount'];
 $expanse_description = htmlentities($_POST['expanse_description']);
 $expanses_created_at = date("d M, Y");
 $year = date("Y", strtotime($expanse_date));
 $month = date("M", strtotime($expanse_date));

 if ($_FILES['expanse_file']['name'] == null || $_FILES['expanse_file']['name'] == "null" || $_FILES['expanse_file']['name'] == "" || $_FILES['expanse_file']['name'] == " ") {
  $expanse_file = "null";
 } else {
  if (!file_exists("../storage/expanses/$year/$month/")) {
   mkdir("../storage/expanses/$year/$month/", 0777, true);
  }
  $expanse_file = $_FILES['expanse_file']['name'];
  $temp_name = $_FILES['expanse_file']['tmp_name'];
  $Folder = "../storage/expanses/$year/$month/";
  $temp = explode(".", $_FILES["expanse_file"]["name"]);
  $newfilename = "expanses_" . $year . "_" . $month . "_" . rand(1111111, 999999999) . date("_d_M_Y_h_m_s") . '.' . end($temp);

  $FileType = strtolower(pathinfo($newfilename, PATHINFO_EXTENSION));
  if (in_array($FileType, $FileNotAllowed)) {
   LOCATION("warning", "Unable to Upload System File", $access_url);
  } else {
   move_uploaded_file($_FILES['expanse_file']['tmp_name'], $Folder . $newfilename);
   $expanse_file = $newfilename;
   $Save = Save("expanses", ["expanses_title", "expanses_tags", "expanse_date", "expanse_amount", "expanse_description", "expanse_file", "expanse_created_by", "expanses_created_at"]);
  }
 }

 //check if expanses is saved
 RESPONSE($act = $Save, "$expanses_title is Created Successfully!", "Unable to create $expanses_title");
}

<?php
//add controller helper files
require 'helper.php';

//add aditional requirements
require '../require/admin/sessionvariables.php';

//start request processing
if (isset($_POST['UpdatePageDetails'])) {

 $pagedetails = array(
  "PageTitle" => $_POST['PageTitle'],
  "PageDesc" => SECURE($_POST['PageDesc'], "e"),
  "UpdatedAt" => RequestDataTypeDate()
 );

 $UpdatePage = UPDATE_DATA("pages", $pagedetails, "PagesId='" . SECURE($_POST['PageId'], "d") . "'");
 RESPONSE($UpdatePage, "Page Details are Updated Successfully!", "Unable to update page details at the moment!");
}

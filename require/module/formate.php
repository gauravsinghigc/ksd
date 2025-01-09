<?php
//date formates
function DATE_FORMATE($format, $date)
{
 $newdateformate = date("$format", strtotime($_REQUEST["$date"]));
 return $newdateformate;
}

//date formates
function DATE_FORMATE2($format, $date)
{
 $newdateformate = $date;
 if ($date == null  || $date == "" || $date == "0000-00-00" || $date == " ") {
  $newdateformate = "No Update";
 } else {
  $newdateformate = date("$format", strtotime($date));
 }
 return $newdateformate;
}

//RequestDataTypeDate
function RequestDataTypeDate()
{
 date_default_timezone_set("Asia/Kolkata");
 $date = date('Y-m-d h:m:s A');
 return $date;
}

//request data type date as a contstant
define("RequestDataTypeDate", RequestDataTypeDate());

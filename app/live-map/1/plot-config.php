<?php

/**
 * Change mode live to dev by change MODE value as DEV or LIVE
 * also chnage PROJECT_ID as per newly created project whose map is this
 */
define("MODE", "PROD");
define("PROJECT_ID", 1);
ini_set("display_errors", "1");

//DEV
if (MODE == "DEV") {
 $Host = "localhost";
 $User = "root";
 $Pass = "";
 $DataBase = "sainikbuildcon";

 //LIVE
} else {
 $Host = "localhost";
 $User = "u965272668_ksd";
 $Pass = "Drc2][*Sp7";
 $DataBase = "u965272668_ksd";
}


//db and project initialisations
$DBConnection = mysqli_connect($Host, $User, $Pass, $DataBase);
$projectid = PROJECT_ID;

$TotalPlotsCount = 250;

//listing plots
$sql = "SELECT * FROM project_units where project_id='$projectid'";
$query = mysqli_query($DBConnection, $sql);
$TotalPlotsListing = mysqli_num_rows($query);

//unlisting
$TotalUnlistedPlots = $TotalPlotsCount - $TotalPlotsListing;

//active
$sql = "SELECT * FROM project_units where project_unit_status='ACTIVE' and project_id='$projectid'";
$query = mysqli_query($DBConnection, $sql);
$TotalPlotsActive = mysqli_num_rows($query);

//hold
$sql = "SELECT * FROM project_units where project_unit_status='HOLD' and project_id='$projectid'";
$query = mysqli_query($DBConnection, $sql);
$TotalPlotsHold = mysqli_num_rows($query);


//sold
$sql = "SELECT * FROM project_units where project_unit_status='SOLD' and project_id='$projectid'";
$query = mysqli_query($DBConnection, $sql);
$TotalPlotsSold = mysqli_num_rows($query);

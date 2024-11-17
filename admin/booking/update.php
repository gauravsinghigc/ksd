<?php
//include default require files files
require '../../require/modules.php';
require "../../require/admin/sessionvariables.php";
require '../../include/admin/common.php';


//start update activity in admin log table
//run booking update command
$GetBookings = SELECT("SELECT * FROM bookings ORDER BY bookingid DESC");
while ($Booking = mysqli_fetch_assoc($GetBookings)) {
 $BookingId[] = $Booking['bookingid'];
}

//foreachcommand update
foreach ($BookingId as $Bookingid) {
 $bookingid = FETCH("SELECT * FROM bookings WHERE bookingid='$Bookingid'", "bookingid");
 date_default_timezone_set('Asia/Kolkata');
 $booking_date = "" . FETCH("SELECT * FROM bookings WHERE bookingid='$bookingid'", "booking_date") . "";
 $emi_months = FETCH("SELECT * FROM bookings WHERE bookingid='$bookingid'", "emi_months");

 //adjustment
 $remove_char = str_replace(",", "", "$booking_date");
 $date2 = date_create($remove_char);
 $newbookingdate = date_format($date2, "Y-m-d");
 $clearing_date = date("d M, Y", strtotime("+$emi_months months", strtotime($newbookingdate)));

 //start update booking clearing date
 $Update = UPDATE("UPDATE bookings SET clearing_date='$clearing_date' where bookingid='$bookingid'");
 if ($Update == true) {
  echo "Booking id: $Bookingid : Updated from $newbookingdate to $clearing_date with $emi_months months<br>";
 } else {
  echo "Booking id: $Bookingid : Faild to Update from $newbookingdate to $clearing_date with $emi_months months<br>";
 }
}

<table style="text-align:left;line-height: 17px;">
  <tr>
    <th style="width:35%;">Customer ID : </th>
    <td>CUST00<?php echo $customer_id; ?></td>
  </tr>
  <tr>
    <th>Customer Name :</th>
    <td><?php echo $customer_name; ?></td>
  </tr>
  <tr>
    <th>Address & Contact Details :</th>
    <td><?php echo "$user_street_address $user_area_locality $user_city $user_state $user_pincode $user_country"; ?>
    <br><?php echo $customer_phone; ?>
    <br><?php echo $customer_email; ?>
    </td>
  </tr>
  <?php 
  $CoAllotySql = "SELECT * FROM booking_alloties where BookingAllotyMainBookingId='$bookingid' and BookingAllotyFullName!=''";?>
  <?php $Check = CHECK($CoAllotySql);
                if ($Check != null) { ?>
                <tr>
    <th>Co-Allotee Details:</th>
    <td>
        <?php echo FETCH($CoAllotySql, "BookingAllotyFullName"); ?>,<br>
                        <?php echo FETCH($CoAllotySql, "BookingAllotyRelation"); ?><br>
                        <?php echo FETCH($CoAllotySql, "BookingAllotyFatherName"); ?>
                        <?php
                        echo FETCH($CoAllotySql, "BookingAllotyStreetAddress") . " ";
                        echo FETCH($CoAllotySql, "BookingAllotyArea") . "<br>";
                        echo FETCH($CoAllotySql, "BookingAllotyCity") . " ";
                        echo FETCH($CoAllotySql, "BookingAllotyState") . " - ";
                        echo FETCH($CoAllotySql, "BookingAllotyPincode") . " <br>";
                        echo FETCH($CoAllotySql, "BookingAllotyPhoneNumber") . " <BR>";
                        echo FETCH($CoAllotySql, "BookingAllotyEmail") . " ";
                        ?>
    </td>
  </tr>
                <?php }
?>


</table>
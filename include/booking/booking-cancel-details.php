<?php
$CheckBookingCancel = CHECK("SELECT * FROM booking_cancelled where BookingCancelledBookingId='$bookingid'");
if ($CheckBookingCancel == false) {
 $hiddenbtn = ""; ?>
<?php } else {
 $hiddenbtn = "hidden"; ?>
 <div class="row">
  <div class="col-md-12 text-center">
   <h1 class="text-danger">Booking Cancelled!</h1>
   <h4 class="text-danger"><i class="fa fa-check-circle"></i> This Booking ID <b><?php echo $MainBookingID; ?></b> is Cancelled!</h4>
   <p>This booking id is Cancelled!</p>
   <hr>
   <a target="_blank" href="../refund-receipt.php?id=<?php echo $bookingid; ?>" class="btn btn-md btn-primary"><i class="fa fa-print"></i> Print Refund Receipt</a>
   <?php CONFIRM_DELETE_POPUP(
    "delete_cancell_bookings",
    [
     "delete_booking_cancel_record" => true,
     "control_id" => $bookingid
    ],
    "bookingcontroller",
    "<i class='fa fa-refresh'></i> Re-Generate Booking",
    "btn btn-md btn-warning"
   ); ?>
   <hr>
  </div>
  <div class="col-md-6">
   <h4 style="text-align:center;background-color:lightgrey;padding:7px;text-transform:uppercase;">Booking Cancel Details</h4>
   <?php
   $CancelSql = "SELECT * FROM booking_cancelled where BookingCancelledBookingId='$bookingid'"; ?>

   <table style="width:100%;" class="table table-striped">
    <tr class="striped">
     <th align="right">Cancel ID:</th>
     <td><?php echo FETCH($CancelSql, "BookingCancelledId"); ?><?php echo DATE_FORMATE2("/d/m/Y", FETCH($CancelSql, "BookingCancelledCreatedAt")); ?>
    </tr>
    <tr class="striped">
     <th align="right">Cancel Date:</th>
     <td><?php echo DATE_FORMATE2("d M, Y", FETCH($CancelSql, "BookingCancelledDate")); ?>
    </tr>
    <tr class="striped">
     <th align="right">Cancel Created At:</th>
     <td><?php echo DATE_FORMATE2("d M, Y", FETCH($CancelSql, "BookingCancelledCreatedAt")); ?>
    </tr>
    <tr class="striped">
     <th align="right">Cancel By:</th>
     <td><?php echo FETCH("SELECT * FROM users where id='" . FETCH($CancelSql, "BookingCancelledBy") . "'", "name"); ?> - <small>ID : <?php echo FETCH($CancelSql, "BookingCancelledBy"); ?></small>
    </tr>
    <tr class="striped">
     <th align="right">Cancel Detail/Reason:</th>
     <td><?php echo SECURE(FETCH($CancelSql, "BookingCancelledReason"), "d"); ?>
    </tr>
   </table>
  </div>
  <div class="col-md-6">
   <h4 style="text-align:center;background-color:lightgrey;padding:7px;text-transform:uppercase;">Booking Refund Details</h4>
   <?php
   $RefundSql = "SELECT * FROM booking_refund where BookingRefundMainBookingId='$bookingid'"; ?>

   <table style="width:100%;" class="table table-striped">
    <tr class="striped">
     <th align="right">Refund ID:</th>
     <td><?php echo FETCH($RefundSql, "BookingRefundId"); ?><?php echo DATE_FORMATE2("/d/m/Y", FETCH($RefundSql, "BookingRefundCreatedAt")); ?>
    </tr>
    <tr class="striped">
     <th align="right">Refund Date:</th>
     <td><?php echo DATE_FORMATE2("d M, Y", FETCH($RefundSql, "BookingRefundId")); ?>
    </tr>
    <tr class="striped">
     <th align="right">Refund Created At:</th>
     <td><?php echo DATE_FORMATE2("d M, Y", FETCH($RefundSql, "BookingRefundCreatedAt")); ?>
    </tr>
    <tr class="striped">
     <th align="right">Refund Updated At:</th>
     <td><?php echo DATE_FORMATE2("d M, Y", FETCH($RefundSql, "BookingRefundUpdatedAt")); ?>
    </tr>
    <tr class="striped">
     <th align="right">Refund By:</th>
     <td><?php echo FETCH("SELECT * FROM users where id='" . FETCH($RefundSql, "BookingRefundCreatedBy") . "'", "name"); ?> - <small>ID : <?php echo FETCH($RefundSql, "BookingRefundCreatedBy"); ?></small>
    </tr>
    <tr class="striped">
     <th align="right">Refund To:</th>
     <td><?php echo FETCH($RefundSql, "BookingRefundTo"); ?>
    </tr>
    <tr class="striped">
     <th align="right">Refund Amount:</th>
     <td>Rs.<?php echo FETCH($RefundSql, "BookingRefundAmount"); ?>
    </tr>
    <tr class="striped">
     <th align="right">Refund Mode:</th>
     <td><?php echo FETCH($RefundSql, "BookingRefundMode"); ?>
    </tr>
    <tr class="striped">
     <th align="right">Refund Status:</th>
     <td><?php echo FETCH($RefundSql, "BookingRefundStatus"); ?>
    </tr>
    <tr class="striped">
     <th align="right">Refund Detail:</th>
     <td><?php echo SECURE(FETCH($RefundSql, "BookingRefundDetails"), "d"); ?>
    </tr>
   </table>
  </div>
 </div>

<?php } ?>
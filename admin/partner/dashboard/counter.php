<div class="row mb-0">
 <div class="col-md-12"><br></div>
 <div class="col-lg-2 col-md-2 col-sm-4 col-6">
  <div class="panel-bdr p-2r">
   <h4 class="mb-0">
    <span class="count">
     <?php echo TOTAL("SELECT * FROM bookings where partner_id='$CustomerId'"); ?>
    </span>
   </h4>
   <span class="fs-13 text-grey">Bookings</span>
  </div>
 </div>
 <div class="col-lg-2 col-md-2 col-sm-4 col-6">
  <div class="panel-bdr p-2r">
   <h4 class="mb-0"><i class="fa fa-inr text-success"></i>
    <span class="count">
     <?php
     $TotalCommissionSQl = SELECT("SELECT sum(commission_amount) FROM commission where partner_id='$ViewCustomerId'");
     while ($TOTALCOMMISION = mysqli_fetch_array($TotalCommissionSQl)) {
      $TotalCommission = $TOTALCOMMISION['sum(commission_amount)'];
     }
     echo $TotalreceivableAmount = $TotalCommission; ?>
    </span>
   </h4>
   <span class="fs-13 text-grey">Total Commission</span>
  </div>
 </div>
 <div class="col-lg-2 col-md-2 col-sm-4 col-6">
  <div class="panel-bdr p-2r">
   <h4 class="mb-0"><i class="fa fa-inr text-success"></i>
    <span class="count">
     <?php
     $TotalCommissionSQl = SELECT("SELECT sum(payment_amount) FROM bookings, payments where bookings.partner_id='$ViewCustomerId' and bookings.bookingid=payments.bookingid");
     while ($TOTALCOMMISION = mysqli_fetch_array($TotalCommissionSQl)) {
      $TotalCustomerPaid = $TOTALCOMMISION['sum(payment_amount)'];
     }
     $NetAllCustomerPayable = AMOUNT("SELECT * FROM bookings where bookings.partner_id='$ViewCustomerId'", "net_payable_amount");
     echo $TotalCustomerPaid;
     ?>
    </span>
   </h4>
   <span class="fs-13 text-grey">Customer Paids</span>
  </div>
 </div>
 <div class="col-lg-2 col-md-2 col-sm-4 col-6">
  <div class="panel-bdr p-2r">
   <h4 class="mb-0"><i class="fa fa-inr text-success"></i>
    <span class="count">
     <?php
     $NetPercentageDifferencbetweenPaidAndBalance = round($TotalCustomerPaid / $NetAllCustomerPayable * 100);
     $NetEligibleCommission = round($TotalCommission / 100 * $NetPercentageDifferencbetweenPaidAndBalance);
     echo $NetEligibleCommission;
     ?>
    </span>
   </h4>
   <span class="fs-13 text-grey">Eligible Commission</span>
  </div>
 </div>
 <div class="col-lg-2 col-md-2 col-sm-4 col-6">
  <div class="panel-bdr p-2r">
   <h4 class="mb-0"><i class="fa fa-inr text-success"></i>
    <span class="count">
     <?php
     $TotalAmountPaid = SELECT("SELECT sum(commission_payout_amount) FROM commission_payouts where partner_id='$ViewCustomerId'");
     while ($fetchtotalpayment = mysqli_fetch_array($TotalAmountPaid)) {
      $commission_payout_amount = $fetchtotalpayment['sum(commission_payout_amount)'];
     }
     if ($commission_payout_amount == null) {
      $commission_payout_amount = 0;
     } else {
      $commission_payout_amount = $commission_payout_amount;
     }
     echo $TotalReceivedAmount = $commission_payout_amount; ?>
    </span>
   </h4>
   <span class="fs-13 text-grey">Commission Paid</span>
  </div>
 </div>
 <div class="col-lg-2 col-md-2 col-sm-4 col-6">
  <div class="panel-bdr p-2r">
   <h4 class="mb-0"><i class="fa fa-inr text-success"></i>
    <span class="">
     <?php $PendingCommission = $NetEligibleCommission - $TotalReceivedAmount;
     $PendingCommission;
     if ($PendingCommission < $NetEligibleCommission) {
      echo "+" . abs($PendingCommission);
     } else {
      echo $PendingCommission;
     }
     ?>
    </span>
   </h4>
   <span class="fs-13 text-grey">Pending</span>
  </div>
 </div>
</div>
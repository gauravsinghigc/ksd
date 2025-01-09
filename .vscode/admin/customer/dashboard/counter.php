<div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xs-12 c-dashboard-padding">
  <div class="row bg-white m-0">
    <div class="col-lg-2 col-md-3 col-sm-4 col-6">
      <div class="panel-bdr p-2r">
        <h4>
          <span class="count">
            <?php echo TOTAL("SELECT * FROM bookings where customer_id='$CustomerId'"); ?>
          </span>
        </h4>
        <span class="fs-14">Bookings</span>
      </div>
    </div>
    <div class=" col-lg-2 col-md-3 col-sm-4 col-6">
      <div class="panel-bdr p-2r">
        <h4><i class="fa fa-inr text-success"></i>
          <span class="count">
            <?php
            $TotalAmountPaid = SELECT("SELECT sum(net_payable_amount) FROM bookings where  bookings.company_id='" . company_id . "' and bookings.customer_id='$CustomerId'");
            while ($fetchtotalpayment = mysqli_fetch_array($TotalAmountPaid)) {
              $PaymentforProjects = $fetchtotalpayment['sum(net_payable_amount)'];
            }
            echo $TotalreceivableAmount = $PaymentforProjects; ?>
          </span>
        </h4>
        <span class="fs-14">Total <span class="text-grey">(<?php echo $Full = 100; ?> %)</span></span>
      </div>
    </div>
    <div class="col-lg-2 col-md-3 col-sm-3 col-6">
      <div class="panel-bdr p-2r">
        <h4><i class="fa fa-inr text-success"></i>
          <span class="count">
            <?php
            $PaymentWithoutCheck = SELECT("SELECT sum(net_paid) FROM payments, bookings where bookings.bookingid=payments.bookingid and bookings.company_id='" . company_id . "' and bookings.customer_id='$CustomerId' and payments.payment_mode!='check'");
            while ($fetchtotalpayment = mysqli_fetch_array($PaymentWithoutCheck)) {
              $TotalPaidAmountWithoutCheck = $fetchtotalpayment['sum(net_paid)'];
            }

            $PaymentWithCheck = SELECT("SELECT sum(net_paid) FROM payments, bookings, check_payments where bookings.bookingid=payments.bookingid and bookings.company_id='" . company_id . "' and bookings.customer_id='$CustomerId' and payments.payment_mode='check' and payments.payment_id=check_payments.payment_id and check_payments.checkstatus='Clear'");
            while ($fetchtotalpayment = mysqli_fetch_array($PaymentWithCheck)) {
              $TotalPaidAmountWithCheck = $fetchtotalpayment['sum(net_paid)'];
            }

            if ($TotalPaidAmountWithCheck == null or $TotalPaidAmountWithCheck == 0) {
              $TotalPaidAmountWithCheck = 0;
            } else {
              $TotalPaidAmountWithCheck = (int)$TotalPaidAmountWithCheck;
            }

            if ($TotalPaidAmountWithoutCheck == null or $TotalPaidAmountWithoutCheck == 0) {
              $TotalPaidAmountWithoutCheck = 0;
            } else {
              $TotalPaidAmountWithoutCheck = (int)$TotalPaidAmountWithoutCheck;
            }

            $netPaidAmount =  $TotalPaidAmountWithCheck + $TotalPaidAmountWithoutCheck;
            ?>
            <?php
            $PaymentWithoutCheck2 = SELECT("SELECT sum(payment_amount) FROM payments, bookings where bookings.bookingid=payments.bookingid and bookings.company_id='" . company_id . "' and bookings.customer_id='$CustomerId' and payments.payment_mode!='check'");
            while ($fetchtotalpayment2 = mysqli_fetch_array($PaymentWithoutCheck2)) {
              $TotalPaidAmountWithoutCheck2 = $fetchtotalpayment2['sum(payment_amount)'];
            }

            $PaymentWithCheck2 = SELECT("SELECT sum(payment_amount) FROM payments, bookings, check_payments where bookings.bookingid=payments.bookingid and bookings.company_id='" . company_id . "' and bookings.customer_id='$CustomerId' and payments.payment_mode='check' and payments.payment_id=check_payments.payment_id and check_payments.checkstatus='Clear'");
            while ($fetchtotalpayment2 = mysqli_fetch_array($PaymentWithCheck2)) {
              $TotalPaidAmountWithCheck2 = $fetchtotalpayment2['sum(payment_amount)'];
            }

            if ($TotalPaidAmountWithCheck2 == null or $TotalPaidAmountWithCheck2 == 0) {
              $TotalPaidAmountWithCheck2 = 0;
            } else {
              $TotalPaidAmountWithCheck2 = (int)$TotalPaidAmountWithCheck2;
            }

            if ($TotalPaidAmountWithoutCheck2 == null or $TotalPaidAmountWithoutCheck2 == 0) {
              $TotalPaidAmountWithoutCheck2 = 0;
            } else {
              $TotalPaidAmountWithoutCheck2 = (int)$TotalPaidAmountWithoutCheck2;
            }

            $netPaidAmount2 =  $TotalPaidAmountWithCheck2 + $TotalPaidAmountWithoutCheck2;

            $NetFeesandcharges = $netPaidAmount - $netPaidAmount2;
            ?>
            <?php
            $TotalPendingamount = $TotalreceivableAmount - $netPaidAmount;
            echo $TotalPendingamount;
            if ($TotalreceivableAmount == 0) {
              $PendingPercentage = 0;
            } else {
              $PendingPercentage = round((int)$netPaidAmount2 / (int)$TotalreceivableAmount * 100);
            } ?>
          </span>
        </h4>
        <span class="fs-14">Pending <span class="text-grey">(<?php echo $Pending = round(100 - $PendingPercentage); ?> %)</span></span>
      </div>
    </div>

    <div class=" col-lg-2 col-md-3 col-sm-4 col-6">
      <div class="panel-bdr p-2r">
        <h4><i class="fa fa-inr text-success"></i>
          <span class="count">
            <?php echo $netPaidAmount2; ?>
          </span>
        </h4>
        <span class="fs-14">Paid <span class="text-grey">(<?php echo round((int)$Full - (int)$Pending); ?>% )</span></span>
      </div>
    </div>

    <div class="col-lg-2 col-md-3 col-sm-3 col-6">
      <div class="panel-bdr p-2r">
        <span class="cal-icon"><i class="fa fa-plus fs-18 text-black"></i></span>
        <h4><i class="fa fa-inr text-success"></i>
          <span class="count">
            <?php echo $netPaidAmount - $netPaidAmount2; ?>
          </span>
        </h4>
        <span class="fs-14">Fees & Charges</span>
      </div>
    </div>

    <div class="col-lg-2 col-md-3 col-sm-3 col-6">
      <div class="panel-bdr p-2r">
        <span class="cal-icon"><i class="fa fa-equals fs-18 text-black">=</i></span>
        <h4><i class="fa fa-inr text-success"></i>
          <span class="count">
            <?php echo $netPaidAmount; ?>
          </span>
        </h4>
        <span class="fs-14">Net Paid</span>
      </div>
    </div>

  </div>
</div>
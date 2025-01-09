<section class="calculation">
  <div class='row m-t-10 m-b-5'>
    <div class="col-md-12">
      <hr>
    </div>
    <div class="col-md-3">
      <div class="card">
        <div class="card-body shadow-lg p-2">
          <div class="p-1">
            <h2>1</h2>
            <p>Total Re-Sales/Transfer</p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card">
        <div class="card-body shadow-lg p-2">
          <div class="p-1">
            <h2><?php
                $Payable = FETCH($BookingSql . " ORDER BY bookingid DESC limit 1", "net_payable_amount");
                if ($Payable == null) {
                  $Payable = 0;
                }
                echo Price($Payable, "text-success", "Rs."); ?></h2>
            <p>Net Payable By Current Owner</p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card">
        <div class="card-body shadow-lg p-2">
          <div class="p-1">
            <h2>
              <?php
              $BookingId = FETCH($BookingSql . " ORDER BY bookingid DESC limit 1", "bookingid");
              $CheckSqlForReSale = CHECK("SELECT * FROM booking_resales where booking_main_id='$BookingId' and booking_resale_type='TRANSFER'");
              if ($CheckSqlForReSale != null) {
                $PreviousBookingId = FETCH($BookingSql . " and bookingid!='$BookingId' ORDER BY bookingid DESC limit 1", "bookingid");
                $PreviousPayment = GetNetPaidAmount($PreviousBookingId);
              } else {
                $PreviousPayment = 0;
              }

              echo Price($NetPaid = GetNetPaidAmount(FETCH($BookingSql . " ORDER BY bookingid DESC limit 1", "bookingid")) + $PreviousPayment, "text-success", "Rs."); ?>
            </h2>
            <p>Net Paid By Current Owner</p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card">
        <div class="card-body shadow-lg p-2">
          <div class="p-1">
            <h2><?php echo Price($Payable - $NetPaid, "text-success", "Rs."); ?></h2>
            <p>Balance On Current Owner</p>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>
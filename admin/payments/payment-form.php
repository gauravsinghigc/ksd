<form action="<?php echo DOMAIN; ?>/controller/paymentcontroller.php" method="POST">
  <input type="text" name="access_url" value="<?php echo get_url(); ?>" hidden="">
  <input name="project_measure_unit" required="" value="<?php echo MeasurementUnit; ?>" hidden="">
  <div class="row">
    <div class="form-group col-12 col-md-6">
      <label>Select Booking</label>
      <select name="bookingid" class="form-control" required="">
        <?php
        $FetchPROJECT_TYPE = SELECT("SELECT * from bookings where company_id='" . company_id . "'");
        while ($FetchPROJECTST = mysqli_fetch_array($FetchPROJECT_TYPE)) {
          $bookingid = $FetchPROJECTST['bookingid'];
          $booking_date = date("m/Y", strtotime($FetchPROJECTST['created_at'])); ?>
          <option value="<?php echo $bookingid; ?>">B<?php echo $bookingid; ?>/<?php echo $booking_date; ?></option>
        <?php } ?>
      </select>
    </div>
    <div class="form-group col-12 col-md-6">
      <label>Payment Amount</label>
      <input type="text" name="payment_amount" oninput="getpaidamount()" id="paidamount" class="form-control" placeholder="" required="">
    </div>
  </div>
  <div class="row m-t-20">
    <div class="col-md-12">
      <h4><b>Payment Methods</b></h4>
    </div>
    <div class="col-md-12 m-b-20">
      <div class="btn-group-lg btn-group">
        <label class="btn btn-primary">
          <input type="radio" name="payment_mode" value="cash" onclick="PaymentMode('cash')" checked=""> Cash Payment
        </label>
        <label class="btn btn-primary">
          <input type="radio" name="payment_mode" value="banking" onclick="PaymentMode('banking')"> Online Banking
        </label>
        <label class="btn btn-primary">
          <input type="radio" name="payment_mode" value="check" onclick="PaymentMode('check')"> Check/DD Payment
        </label>
      </div>
    </div>
    <div class="col-md-12 col-12" style="display:none;" id="check">
      <div class="row">
        <div class="col-md-12">
          <h4>Check/DD Payment</h4>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
          <div class="form-group">
            <label>Name of Person For whom check is Issued</label>
            <input type="text" name="checkissuedto" value="" class="form-control">
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
          <div class="form-group">
            <label>Check/DD Number</label>
            <input type="text" name="checknumber" value="" class="form-control">
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
          <div class="form-group">
            <label>Bank Name</label>
            <input type="text" name="BankName" value="" class="form-control">
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
          <div class="form-group">
            <label>Bank IFSC Code</label>
            <input type="text" name="ifsc" value="" class="form-control">
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
          <div class="form-group">
            <label>Issue Date</label>
            <input type="date" name="checkissuedate" value="" class="form-control">
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
          <div class="form-group">
            <label>Cheque Status</label>
            <select class="form-control" name="checkstatus" id="checkissustatus" onchange="checkcheckstatus()">
              <option value="">Select Cheque Status</option>
              <option value="Issued">Issued</option>
              <option value="Clear">Clear</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-12 col-12" style="display:none;" id="banking">
      <div class="row">
        <div class="col-md-12">
          <h4>Online Payment</h4>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
          <div class="form-group">
            <label>Online Payment Type</label>
            <select name="onlinepaymenttype" class="form-control">
              <option value="NetBanking">Net Banking</option>
              <option value="CC/DC">Credit/Debit Card</option>
              <option value="Wallets">Online Wallets</option>
              <option value="UPI">UPI</option>
            </select>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
          <div class="form-group">
            <label>Bank/Wallet/Upi/Provider name</label>
            <input type="text" name="OnlineBankName" value="" class="form-control">
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
          <div class="form-group">
            <label>Transaction ID</label>
            <input type="text" name="transactionId" value="" class="form-control">
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
          <div class="form-group">
            <label>Transaction Status</label>
            <select name="transaction_status" class="form-control">
              <option value="Success">Success</option>
              <option value="Pending">Pending</option>
              <option value="Failed">Failed</option>
              <option value="Rejected">Rejected By Provider</option>
            </select>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
          <div class="form-group">
            <label>Transaction Details/Notes</label>
            <textarea class="form-control" name="payment_details" row="1"></textarea>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
          <div class="form-group">
            <label>Transaction Date</label>
            <input type="date" name="transactiondate" value="" class="form-control">
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-12 col-12" id="cash">
      <div class="row">
        <div class="col-md-12">
          <h4>Cash Payment</h4>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
          <div class="form-group">
            <label>Cash Received By</label>
            <input type="text" name="cashreceivername" value="" class="form-control">
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
          <div class="form-group">
            <label>Cash Amount</label>
            <input type="text" name="cashamount" id="cashamount" readonly="" value="" class="form-control">
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
          <div class="form-group">
            <label>Cash Received date</label>
            <input type="date" name="cashreceivedate" value="" class="form-control">
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row m-t-20">
    <div class="col-md-12">
      <h4><b>Discount & Charges</b></h4>
    </div>
    <div class="from-group col-md-12">
      <div class="row">
        <div class="col-md-8 col-12">
          <label>Charge name</label>
          <input type="text" name="chargename" oninput="chargesCalcu()" id="chargename" value="" class="form-control" placeholder="">
        </div>
        <div class="col-md-4 col-12">
          <label>Charges in (%)</label>
          <input type="text" name="charges" oninput="chargesCalcu()" id="chargevalue" class="form-control" placeholder="">
        </div>
      </div>
    </div>
    <div class="from-group col-md-12">
      <div class="row">
        <div class="col-md-8 col-12">
          <label>Discount name</label>
          <input type="text" name="discountname" oninput="chargesCalcu()" id="discountname" value="" class="form-control" placeholder="">
        </div>
        <div class="col-md-4 col-12">
          <label>Discount in (%)</label>
          <input type="text" name="discount" oninput="chargesCalcu()" id="discountvalue" class="form-control" placeholder="">
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 text-right">
      <label class="fs-17" id="chargeshow" style="display:none;"></label><br>
      <label class="fs-17" id="discountshow" style="display:none;"></label><br>
      <h4 class="fs-20">Rs.<span id="netpaidamount"></span></h4>
    </div>
  </div>
  <div class="row m-t-20">
    <div class="col-md-12">
      <h4><b>Slip No & Remark</b></h4>
    </div>
    <div class="from-group col-md-6">
      <label>Slip No </label>
      <input type="text" name="slip_no" class="form-control" placeholder="">
    </div>
    <div class="from-group col-md-6">
      <label>Remarks/Note </label>
      <input type="text" name="remark" class="form-control" placeholder="">
    </div>
  </div>
  </div>

  <div class="modal-footer">
    <input type="text" name="net_paid" id="net_payable" hidden="">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="submit" name="create_payment" value="<?php echo company_id; ?>" class="btn btn-success">Save</button>
</form>
<?php
require '../../require/modules.php';
require "../../require/admin/sessionvariables.php";
require '../../include/admin/common.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Print B<?php echo $_GET['id']; ?> Development Charges Receipts</title>
</head>

<body onload="doConvert()" style="font-size:13px !important;color: black !important;margin:auto;font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">
  <?php
  include "data-include.php";
  ?>



  <section style="border-style:groove; border-width:thin;margin: auto; width: 1000px;height:1470px;border: 1px solid rgb(147 78 255);padding: 5px;">
    <div style="text-align:center;">
      <br>
      <h3 style="line-height:1;margin-bottom:4px;margin-top:-19px;">
        ----------------- DEVELOPMENT CHARGES -----------------------
        <br>
      </h3>
    </div>
    <?php include "../../include/export/rc-header.php"; ?>
    <div style="display: flex;justify-content: space-between;margin-top:7px;">
      <div style="width:40%;">
        <table style="text-align:left;line-height: 17px;">
          <tr>
            <th style="width:35%;">REF No : </th>
            <td><?php echo $ref_no . "//CRN:" . $crn_no; ?></td>
          </tr>
          <tr>
            <th>Customer Name :</th>
            <td><?php echo $customer_name; ?></td>
          </tr>
          <tr>
            <th>Address :</th>
            <td><?php echo "$user_street_address $user_area_locality $user_city $user_state $user_pincode $user_country"; ?></td>
          </tr>
          <tr>
            <th>Phone Number :</th>
            <td><?php echo $customer_phone; ?></td>
          </tr>
          <tr>
            <th>Email ID :</th>
            <td><?php echo $customer_email; ?></td>
          </tr>

        </table>
      </div>
      <div>
        <table style="text-align:left;line-height: 17px;">
          <tr>
            <th>Project Name :</th>
            <td><?php echo $project_name; ?></td>
          </tr>
          <tr>
            <th>Unit No: :</th>
            <td><?php echo $unit_name; ?></td>
          </tr>
          <tr>
            <th>Unit Area :</th>
            <td><?php echo $unit_area; ?></td>
          </tr>
          <tr>
            <th>Rate:</th>
            <td>Rs.<?php echo $unit_rate; ?>/unit area</td>
          </tr>
          <tr>
            <th>Unit Cost:</th>
            <td>Rs.<?php echo $unit_cost; ?></td>
          </tr>
          <tr>
            <th>Possession:</th>
            <td><?php echo $possession; ?></td>
          </tr>
        </table>
      </div>
      <div>
        <table style="text-align:left;line-height: 15px;">
          <tr>
            <th>Booking Date :</th>
            <td><?php echo date("d M, Y", strtotime($booking_date)); ?></td>
          </tr>
          <tr>
            <th>Invoice No:</th>
            <td>B<?php echo $_GET['id']; ?>/<?php echo date("m/Y", strtotime($created_at)); ?></td>
          </tr>
          <tr>
            <th>Receipt At:</th>
            <td><?php echo date("d M, Y h:i A"); ?></td>
          </tr>

        </table>
      </div>
    </div>
    <style>
      table.striped {
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
      }

      tr.striped:nth-child(even) {
        background-color: #f2f2f2;
      }
    </style>
    <div>
      <div style="width:100% !important;">
        <h6 style="margin-top: 7px;
    margin-bottom: 0px !important;
    text-align: center;
    padding: 5px;
    background-color: lightgrey;
    color: black;
    font-size: 14px;">Development Charges</h6>
        <table class="striped" style="width:100%;text-align:left !important;padding:1px;">
          <thead>
            <tr>
              <th align="left">RefId</th>
              <th align="left">ChargeName</th>
              <th align="left">Type</th>
              <th align="left" style="width: 200px;">Details</th>
              <th align="left">CreatedAt</th>
              <th align="left">BookingAmount</th>
              <th align="left">Appliedin</th>
              <th align="right">Amount</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $SqlDevcharges = SELECT("SELECT * FROM developmentcharges, bookings where developmentcharges.bookingid='$bookingid' and developmentcharges.bookingid=bookings.bookingid ORDER by developmentcharges.devchargesid ASC");
            $netdevelopmentcharges = 0;
            while ($FetchDevCharges = mysqli_fetch_array($SqlDevcharges)) {
              $devchargesid = $FetchDevCharges['devchargesid'];
              $bookingid2 = $FetchDevCharges['bookingid'];
              $created_at2 = $FetchDevCharges['created_at'];
              $developmentchargetitle = $FetchDevCharges['developmentchargetitle'];
              $developmentchargetype = $FetchDevCharges['developmentchargetype'];
              $developmentcharge = $FetchDevCharges['developmentcharge'];
              $developementchargeamount = $FetchDevCharges['developementchargeamount'];
              $developmentchargepercentage = $FetchDevCharges['developmentchargepercentage'];
              $developmentchargecreatedat = $FetchDevCharges['developmentchargecreatedat'];
              $developmentchargestatus = $FetchDevCharges['developmentchargestatus'];
              $MainBookingID2 = "B$bookingid/" . date("m/Y", strtotime($created_at2));
              $netdevelopmentcharges += (int)$developementchargeamount;
              $net_payable_amount2 = $FetchDevCharges['net_payable_amount'];
              $developmentchargedescription = SECURE($FetchDevCharges['developmentchargedescription'], "d"); ?>
              <div style="display:block !important; width:100%;">
                <tr style="box-shadow:0px 1px 0px 0px #8080801f;">
                  <td>DC<?php echo $devchargesid; ?></td>
                  <td><?php echo $developmentchargetitle; ?></td>
                  <td><?php echo $developmentchargetype; ?></td>
                  <td><?php echo SECURE($developmentchargedescription, "d"); ?></td>
                  <td><?php echo $developmentchargecreatedat; ?></td>
                  <td>Rs.<?php echo $net_payable_amount2; ?></td>
                  <td>
                    <?php if ($developmentcharge == "PERCENTAGE") { ?>
                      <?php echo $developmentcharge; ?> (<?php echo $developmentchargepercentage; ?>%)
                    <?php } else { ?>
                      <?php echo $developmentcharge; ?>
                    <?php } ?>
                  </td>
                  <td align="right"><span class="text-success fs-14">Rs.<?php echo $developementchargeamount; ?></span></td>
                </tr>
              </div>
            <?php } ?>
            <tr>
              <td colspan="7" align="right"><b>Total Amount : </b></td>
              <td style="color:green;" align="right"> <b>Rs.<?php echo $netdevelopmentcharges; ?></b></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div style="width:100% !important;">
        <h6 style="margin-top: 10px;
    margin-bottom: 0px !important;
    text-align: center;
    padding: 5px;
    background-color: lightgrey;
    color: black;
    font-size: 14px;">Payment History</h6>
        <table class="striped" style="width:100%;text-align:left !important;padding:1px;">
          <thead>
            <tr class="text-right">
              <th align="left" class="text-right">RefID</th>
              <th align="left" class="text-right">Mode</th>
              <th align="left">BankName</th>
              <th align="left" style="width: 200px;">Details</th>
              <th align="left" style="width: 200px;">Notes</th>
              <th align="left">ReceivedBy</th>
              <th align="left" class="text-right">PaidAt</th>
              <th align="left" class="text-right">Status</th>
              <th align="right" class="text-right">Amount</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $TotalAmountPaid2 = SELECT("SELECT * FROM developmentchargepayments, developmentcharges where developmentcharges.bookingid='$bookingid' and developmentchargepayments.developmentchargeid=developmentcharges.devchargesid");
            $netdevelopmentchargespaid = 0;
            while ($fetchtotalpayment2 = mysqli_fetch_array($TotalAmountPaid2)) {
              $developmentchargeid = $fetchtotalpayment2['developmentchargeid'];
              $devchargepaymentmode = $fetchtotalpayment2['devchargepaymentmode'];
              $devchargepaymentamount = $fetchtotalpayment2['devchargepaymentamount'];
              $devchargepaymentnotes = html_entity_decode(SECURE($fetchtotalpayment2['devchargepaymentnotes'], "d"));
              $devpaymentreceivedby = $fetchtotalpayment2['devpaymentreceivedby'];
              $devpaymentbankname = $fetchtotalpayment2['devpaymentbankname'];
              if ($devpaymentbankname == null) {
                $devpaymentbankname = "-";
              } else {
                $devpaymentbankname = $devpaymentbankname;
              }
              $devpaymentreleaseddate = $fetchtotalpayment2['devpaymentreleaseddate'];
              $devpaymentstatus = $fetchtotalpayment2['devpaymentstatus'];
              $devpaymentdetails = html_entity_decode(SECURE($fetchtotalpayment2['devpaymentdetails'], "d"));
              $devpaymentcreatedat = $fetchtotalpayment2['devpaymentcreatedat'];
              $devpaymentupdatedat = $fetchtotalpayment2['devpaymentupdatedat'];
              $netdevelopmentchargespaid += $devchargepaymentamount;
            ?>
              <div style="display:block !important; width:100%;">
                <tr align="left" style="box-shadow:0px 1px 0px 0px #8080801f;">
                  <td><span class="text-info">DC<?php echo $developmentchargeid; ?></span></td>
                  <td><?php echo $devchargepaymentmode; ?></td>
                  <td><?php echo $devpaymentbankname; ?></td>
                  <td><?php echo $devpaymentdetails; ?></td>
                  <td><?php echo SECURE($devchargepaymentnotes, "d"); ?></td>
                  <td><?php echo $devpaymentreceivedby; ?></td>
                  <td><?php echo $devpaymentreleaseddate; ?></td>
                  <td><?php echo $devpaymentstatus; ?></td>
                  <td align="right"><span class="text-success fs-14">Rs.<?php echo $devchargepaymentamount; ?></span></td>
                </tr>
              </div>
            <?php } ?>
            <tr>
              <td colspan="8" align="right"><b>Total Paid Amount : </b></td>
              <td style="color:green;" align="right"> <b>Rs.<?php echo $netdevelopmentchargespaid; ?></b></td>
            </tr>
          </tbody>
        </table>
      </div>
      <hr>
      <div style="width:100%;text-align:right;">
        <p>
          <span>Total Paid Amount : <b>Rs.<?php echo $netdevelopmentchargespaid; ?></b></span><br>
          <span style="color:green;">Net Payable : <b> &nbsp; &nbsp;&nbsp;Rs.<?php echo $netdevelopmentcharges; ?></b></span><br>
          <span style="color:red;">Balance : <b> Rs.<?php echo $netdevelopmentcharges - $netdevelopmentchargespaid; ?></b></span><br>
        </p>
      </div>
    </div>
    <div style="height:70px;">
      <div style="text-align:right;">
        <p style="font-size:11px;margin-top:0px; margin-bottom:0px;width:200px;padding-top:50px;border-style:groove;border-width:thin;float: right;text-align: center;">Authorised Name & Signature</p>
      </div>
      <div style="text-align:left;">
        <p style="font-size:11px;padding-top: 25px; margin-bottom:0px;">
          <span>Remarks : <?php echo $remark; ?></span><br>
          <i>Ref No: <?php echo $refrenecenum; ?>/B<?php echo $bookingid; ?>/<?php echo date("m/Y"); ?></i><br>
          <span>UID<?php echo LOGIN_UserId; ?>/<?php echo LOGIN_UserFullName; ?></span>
        </p>
      </div>
    </div>

    <br>
  </section>

</body>

</html>
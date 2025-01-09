<?php
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';

if (isset($_GET['comid'])) {
  $commission_id = $_GET['comid'];
  $_SESSION['AGENT_COMMSSION_ID'] = $commission_id;
  $txnid = $_GET['txnid'];
  $_SESSION['txnid'] = $txnid;
} else {
  $commission_id = $_SESSION['AGENT_COMMSSION_ID'];
  $txnid = $_SESSION['txnid'];
}

$CommissionSql = "SELECT * FROM commission WHERE commission_id='$commission_id'";
$CommissionPayoutSql = "SELECT * FROM commission_payouts where commission_payout_id='$txnid'";
$AgentId = FETCH($CommissionSql, "partner_id");
$AgentSql = "SELECT * FROM users where id='$AgentId'";
$AgentAddressSql = "SELECT * FROM user_address where user_id='$AgentId'";
$BookingId = FETCH($CommissionSql, "booking_id");
$BookingSql = "SELECT * FROM bookings where bookingid='$BookingId'";
$ProjectId = FETCH($BookingSql, "project_list_id");
$ProjectSql = "SELECT * FROM projects where Projects_id='$ProjectId'";
$ProjectUnitId = FETCH($BookingSql, "project_unit_id");
$ProjectUnitSql = "SELECT * FROM project_units WHERE project_units_id='$ProjectUnitId'";

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset='utf-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <title>Agent Commission Receipt </title>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <style>
    section {
      width: 800px !important;
      height: 1000px !important;
    }
  </style>
</head>

<body onload="doConvert()" style="font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI' , Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans' , 'Helvetica Neue' , sans-serif !important;margin-left:1.5rem;font-size:0.9rem;">
  <section style="padding:0.5rem;margin:2% auto;display:block;">
    <img src="<?php echo STORAGE_URL; ?>/doc-img/header.jpg" style="width:100%;">
    <img src="<?php echo STORAGE_URL; ?>/doc-img/water.jpg" style="position: absolute;top: 25%;left: 26%;width: 50%;z-index: -1;">
    <div>
      <h2 style="text-align:center;margin-top: -1.5rem;margin-bottom:-0.2rem !important;">Agent Commission Receipt<br>
        <hr style="width:40%;margin-top:0.2rem;">
        </h4>

    </div>
    <div style="font-size:13px;">
      <div style="display:flex;justify-content:space-between;">
        <div style="width:50%;">
          <h3 style="margin-bottom:0px;">Agent Details</h3>
          <hr>
          <table style="width:100%;line-height:0.9rem;text-align:left;">
            <tr>
              <th style="width:25%;">Agent ID</th>
              <td style="width:5%;text-align:center;">:</td>
              <td style="text-align:left;">AGENT00<?php echo $AgentId; ?></td>
            </tr>
            <tr>
              <th>Full Name</th>
              <td style="width:5%;text-align:center;">:</td>
              <td style="text-align:left;"><?php echo FETCH($AgentSql, "name"); ?></td>
            </tr>
            <tr>
              <th>S/O, W/O, D/O</th>
              <td style="width:5%;text-align:center;">:</td>
              <td style="text-align:left;"><?php echo FETCH($AgentSql, "father_name"); ?></td>
            </tr>
            <tr>
              <th>Phone Number</th>
              <td style="width:5%;text-align:center;">:</td>
              <td style="text-align:left;"><?php echo FETCH($AgentSql, "phone"); ?></td>
            </tr>
            <tr>
              <th>Email ID</th>
              <td style="width:5%;text-align:center;">:</td>
              <td style="text-align:left;"><?php echo FETCH($AgentSql, "email"); ?></td>
            </tr>
            <tr>
              <th>Address Line</th>
              <td style="width:5%;text-align:center;">:</td>
              <td style="text-align:left;">
                <?php
                echo FETCH($AgentAddressSql, "user_street_address") . " ";
                echo FETCH($AgentAddressSql, "user_area_locality") . ""; ?>
              </td>
            </tr>
            <tr>
              <th>City, State</th>
              <td style="width:5%;text-align:center;">:</td>
              <td style="text-align:left;">
                <?php
                echo FETCH($AgentAddressSql, "user_city") . " ";
                echo FETCH($AgentAddressSql, "user_state") . " - ";
                echo FETCH($AgentAddressSql, "user_pincode") . " "; ?>
              </td>
            </tr>
          </table>
        </div>
        <div style="width:50%;">
          <h3 style="margin-bottom:0px;">Booking & Project Details</h3>
          <hr>
          <table style="width:100%;line-height:0.9rem;text-align:left;">
            <tr>
              <th style="width:25%;">Booking ID</th>
              <td style="width:5%;text-align:center;">:</td>
              <td style="text-align:left;">B<?php echo $BookingId . "/" . DATE_FORMATE2("m/Y", FETCH($BookingSql, "created_at")); ?></td>
            </tr>
            <tr>
              <th>Project Name</th>
              <td style="width:5%;text-align:center;">:</td>
              <td style="text-align:left;"><?php echo FETCH($BookingSql, "project_name"); ?> - (<?php echo FETCH($BookingSql, "project_area"); ?>) - <?php echo FETCH($ProjectSql, "project_type"); ?></td>
            </tr>
            <tr>
              <th><?php echo FETCH($ProjectUnitSql, "projects_unit_type"); ?> No</th>
              <td style="width:5%;text-align:center;">:</td>
              <td style="text-align:left;"><?php echo UpperCase(FETCH($BookingSql, "unit_name")); ?> - (<?php echo FETCH($BookingSql, "unit_area"); ?>) @ Rs.<?php echo FETCH($BookingSql, "unit_rate"); ?>/sq unit</td>
            </tr>
            <tr>
              <th>Unit Cost</th>
              <td style="width:5%;text-align:center;">:</td>
              <td style="text-align:left;"><?php echo Price(FETCH($BookingSql, "unit_cost"), "text-black", "Rs."); ?> (exclud. charges)</td>
            </tr>
            <tr>
              <th>Net Unit Cost</th>
              <td style="width:5%;text-align:center;">:</td>
              <td style="text-align:left;"><?php echo Price(FETCH($BookingSql, "net_payable_amount"), "text-black", "Rs."); ?> (includ. charges)</td>
            </tr>
            <tr>
              <th>Booking Date</th>
              <td style="width:5%;text-align:center;">:</td>
              <td style="text-align:left;"><?php echo DATE_FORMATE2("d M, Y", FETCH($BookingSql, "booking_date")); ?></td>
            </tr>
            <tr>
              <th>REF, CRN No</th>
              <td style="width:5%;text-align:center;">:</td>
              <td style="text-align:left;"><?php echo FETCH($BookingSql, "crn_no") . "-" . FETCH($BookingSql, "ref_no"); ?></td>
            </tr>
          </table>
        </div>
      </div>

      <div>
        <div style="width:100%;">
          <h3 style="margin-bottom:0px;">Commission Details</h3>
          <hr>
          <table style="width:100%;line-height:0.9rem;text-align:left;">
            <tr>
              <th style="width:30%;">Commission Id</th>
              <td style="width:5%;text-align:center;">:</td>
              <td style="text-align:left;">COMM000<?php echo $commission_id; ?></td>
            </tr>
            <tr>
              <th style="width:25%;">Type</th>
              <td style="width:5%;text-align:center;">:</td>
              <td style="text-align:left;"><?php echo UpperCase(FETCH($CommissionSql, "commission_type")); ?></td>
            </tr>
            <tr>
              <th style="width:25%;">Net Commission</th>
              <td style="width:5%;text-align:center;">:</td>
              <td style="text-align:left;"><?php echo Price(FETCH($CommissionSql, "commission_amount"), "", "Rs."); ?></td>
            </tr>
            <tr>
              <th style="width:25%;">Amount in Words</th>
              <td style="width:5%;text-align:center;">:</td>
              <td style="text-align:left;"><?php echo PriceInWords(FETCH($CommissionSql, "commission_amount")); ?></td>
            </tr>

            <tr>
              <th style="width:25%;">In Percentage</th>
              <td style="width:5%;text-align:center;">:</td>
              <td style="text-align:left;"><?php echo FETCH($CommissionSql, "commission_percentage"); ?>% of Net Unit Cost</td>
            </tr>

            <tr>
              <th style="width:25%;">Area Rate</th>
              <td style="width:5%;text-align:center;">:</td>
              <td style="text-align:left;">Rs.<?php echo FETCH($CommissionSql, "commission_rate_area"); ?>/sq unit</td>
            </tr>
            <tr>
              <th style="width:25%;">Create On</th>
              <td style="width:5%;text-align:center;">:</td>
              <td style="text-align:left;"><?php echo DATE_FORMATE2("d M, Y", FETCH($CommissionSql, "created_at")); ?></td>
            </tr>
            <tr>
              <th style="width:25%;">Notes & Remarks</th>
              <td style="width:5%;text-align:center;">:</td>
              <td style="text-align:left;"><?php echo FETCH($CommissionSql, "commission_remark"); ?></td>
            </tr>
          </table>
        </div>
        <div style="width:100%;">
          <h3 style="margin-bottom:0px;">Commission Payout Details</h3>
          <hr>
          <table style="width:100%;line-height:0.9rem;text-align:left;">
            <tr>
              <th style="width:30%;">Payout date</th>
              <td style="width:5%;text-align:center;">:</td>
              <td style="text-align:left;"><?php echo DATE_FORMATE2("d M, Y", FETCH($CommissionPayoutSql, "commission_payout_date")); ?></td>
            </tr>
            <tr>
              <th style="width:25%;">Net Payable</th>
              <td style="width:5%;text-align:center;">:</td>
              <td style="text-align:left;"><?php echo Price($NetPayble = FETCH($CommissionSql, "commission_amount"), "", "Rs."); ?></td>
            </tr>
            <tr>
              <th style="width:25%;">Total Paid</th>
              <td style="width:5%;text-align:center;">:</td>
              <td style="text-align:left;"><?php echo Price($NetPaid = AMOUNT($CommissionPayoutSql, "commission_payout_amount"), "", "Rs."); ?></td>
            </tr>
            <tr>
              <th style="width:25%;">Balance</th>
              <td style="width:5%;text-align:center;">:</td>
              <td style="text-align:left;"><?php echo Price($Balance = $NetPayble - $NetPaid, "", "Rs."); ?></td>
            </tr>
            <tr>
              <th>Payout date</th>
              <td style="width:5%;text-align:center;">:</td>
              <td style="text-align:left;"><?php echo FETCH($CommissionPayoutSql, "commission_payout_type"); ?></td>
            </tr>
            <tr>
              <th>Payout Mode</th>
              <td style="width:5%;text-align:center;">:</td>
              <td style="text-align:left;"><?php echo FETCH($CommissionPayoutSql, "commission_payout_payment_mode"); ?></td>
            </tr>
            <tr>
              <th>Payout Status</th>
              <td style="width:5%;text-align:center;">:</td>
              <td style="text-align:left;"><?php echo FETCH($CommissionPayoutSql, "commission_status"); ?></td>
            </tr>
            <tr>
              <th>Payout Note</th>
              <td style="width:5%;text-align:center;">:</td>
              <td style="text-align:left;"><?php echo SECURE(FETCH($CommissionPayoutSql, "commission_payout_notes"), "d"); ?></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div>
      <div style="padding-right:2rem !important; display:flex; justify-content:space-between;">
        <p style="text-align:right;">
          <br><br><br><br><br><br><br>
          <b>(Signatory of <?php echo FETCH($AgentSql, "name"); ?>)</b>
        </p>
        <p style="text-align:right;">
          <br><br><br><br><br><br><br>
          <b>(Authorised Signatory)</b>
        </p>
      </div>
    </div>
    <img src=" <?php echo STORAGE_URL; ?>/doc-img/footer.jpg" style="width:100%;">
  </section>

  <section style="height:100%;padding:0.5rem;margin:2% auto;display:block;">
    <img src="<?php echo STORAGE_URL; ?>/doc-img/header.jpg" style="width:100%;">
    <img src="<?php echo STORAGE_URL; ?>/doc-img/water.jpg" style="position: absolute;top: 90rem;left: 26%;width: 50%;z-index: -1;">
    <div style="font-size:14px !important;">
      <p>
        <b> NOTE:</b><br><br>
        ❖ This Acknowledgement is subject to realization of cheque and fulfilment of Terms and Conditions mentioned in the
        Application Form, Allotment Letter and/ or Buyer Agreement.<br>
        ❖ Any discrepancies shall be brought to the notice of the Company within 15 days of this receipt.<br>
        Please ensure that you indicate your name, CRN No and the telephone number/ mobile number on the reverse of the cheque/
        draft submitted by you.<br>
        ❖ Kindly inform us regarding any change of your address, telephone no., email ID immediately, if any.
        *Note: HRERA No. RERA-GRG-PROJ-347-2019, License No. 94 of 2017<br>
      </p>

      <br><br>
      <br><br><br><br><br><br><br>
      <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    </div>
    <img src="<?php echo STORAGE_URL; ?>/doc-img/footer.jpg" style="width:100%;">
  </section>
</body>

</html>
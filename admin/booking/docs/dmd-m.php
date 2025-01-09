<?php
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';
require "handler/HeaderRequest.php";

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset='utf-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <title>Maintenance Demand Letter</title>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <style>
    section {
      width: 800px !important;
      height: 1000px !important;
    }

    @media print {
      body {
        background-image: url('<?php echo ADMIN_URL; ?>/booking/docs/assets/bg.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        -webkit-print-color-adjust: exact;
        /* Ensures color fidelity */
        print-color-adjust: exact;
        /* For non-WebKit browsers */
      }
    }
  </style>
</head>

<body onload="doConvert()" style=" font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI' , Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans' , 'Helvetica Neue' , sans-serif !important;margin-left:1.5rem;">
  <section style="margin:0% auto;display:block;background-image:url('<?php echo ADMIN_URL; ?>/booking/docs/assets/bg.jpg');background-size: cover;padding: 4rem;padding-top:16rem;">
    <div>
      <h2 style="text-align:center;margin-top: -1.5rem;margin-bottom:-0.2rem !important;">Maintenance Demand Letter <br>
        <hr style="width:50%;margin-top:-0.1rem;">
      </h2><br>
      <p style="display:flex;justify-content:space-between;font-size:14px;margin-bottom:0px;">
        <span>
          <span><b>Reference No:</b> KSD-YV/Plot No: <?php echo $numbersOnly; ?></span><br>
          <span><b>Plot No:</b> <?php echo $numbersOnly; ?>/<?php echo FETCH($BookingSql, "project_name"); ?></span>
        </span>
        <span style="text-align:right;">
          <span><b>Demand Date :</b> <?php echo DATE_FORMATE2("d M, Y", FETCH($DMDSql, "PayReqDate")); ?></span><BR>
          <span><b>Due Date :</b> <?php echo DATE_FORMATE2("d M, Y", FETCH($DMDSql, "PayRequestDueDate")); ?></span>
        </span>
      </p>
    </div>
    <div style="font-size:14px !important;">
      <div style="display:flex;justify-content:space-between;">
        <p>
          <b>Allotee Details</b><br>
          <b><?php echo FETCH($CustomerSql, "name"); ?></b>,<br>
          <?php echo FETCH($CustomerSql, "father_name"); ?><br>
          <?php
          echo FETCH($CustomerAddress, "user_street_address") . " <br>";
          echo FETCH($CustomerAddress, "user_area_locality") . " <br>";
          echo FETCH($CustomerAddress, "user_city") . " ";
          echo FETCH($CustomerAddress, "user_state") . " - ";
          echo FETCH($CustomerAddress, "user_pincode") . " ";
          echo "<br>";
          echo FETCH($CustomerSql, "phone") . "<BR>";
          echo FETCH($CustomerSql, "email") . "<BR>";
          ?>
        </p>
        <?php $Check = CHECK($CoAllotySql);
        if ($Check != null) { ?>
          <p style="float:right;">
            <b>Co-Allotee Details</b><br>
            <b> <?php echo FETCH($CoAllotySql, "BookingAllotyFullName"); ?></b>,<br>
            <?php echo FETCH($CoAllotySql, "BookingAllotyRelation"); ?><br>
            <?php
            echo FETCH($CoAllotySql, "BookingAllotyStreetAddress") . " <br>";
            echo FETCH($CoAllotySql, "BookingAllotyArea") . " <br>";
            echo FETCH($CoAllotySql, "BookingAllotyCity") . " ";
            echo FETCH($CoAllotySql, "BookingAllotyState") . " - ";
            echo FETCH($CoAllotySql, "BookingAllotyPincode") . " <br>";
            echo FETCH($CoAllotySql, "BookingAllotyPhoneNumber") . " <BR>";
            echo FETCH($CoAllotySql, "BookingAllotyEmail") . " ";
            ?>
          </p>
        <?php }
        $inputString = FETCH($BookingSql, "unit_name"); // Your input string

        // Use preg_replace to remove alphabets and get only numbers
        $numbersOnly = preg_replace("/[^0-9]/", "", $inputString); ?>
      </div>
      <p style="margin-top:0px !important;">
        <b>Subject :</b> Demand of Maintenance Charges against your <b>Plot No. <?php echo $numbersOnly; ?></b>, having Area: <b><?php echo FETCH($BookingSql, "unit_area"); ?></b>
      <div style="box-shadow:0px 0px 2px black; padding:1rem;">
        <span>
          <b>Note:</b> - You have already paid maintenance of <b>Rs. 8 x (12 Months) x <?php echo FETCH($BookingSql, "unit_area"); ?></b> = Rs. <?php echo $MaintenanceAmount = Round((GetNumbers(FETCH($BookingSql, "unit_area")) * 8) * FETCH($DMDSql, "PayReqPayingMonths")); ?>/- for the year 2024-2025.
        </span>
      </div>
      <br>
      <b>Dear Mr/s <?php echo FETCH($CustomerSql, "name"); ?></b><br>
      <br>
      This is with reference to your allotment of <b>Plot No. <?php echo $numbersOnly; ?></b>, having Area: <b><?php echo FETCH($BookingSql, "unit_area"); ?></b>, where in, “Maintenance Charges as mentioned below is due for the year 2025-2026
      </p>
      <div style="padding-left:2rem;padding-right:2rem !important;">
        <table style="width:100%;" border="1">
          <thead>
            <tr>
              <th>Sno</th>
              <th>Payment Category</th>
              <th>Payment Particulars</th>
              <th>Due Amount</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td><?php echo FETCH($DMDSql, "PayReqTitle"); ?></td>
              <td>1 Year due maintenance charges @ Rs. 8 per sq. yards x (12 Months) x <?php echo FETCH($BookingSql, "unit_area"); ?> = Rs. <?php echo $MaintenanceAmount = Round((GetNumbers(FETCH($BookingSql, "unit_area")) * 8) * FETCH($DMDSql, "PayReqPayingMonths")); ?>/-
              </td>
              <td><?php echo Price($MaintenanceAmount, "", "Rs."); ?></td>
            </tr>
            <tr>
              <td colspan="2" align="right">In Words</td>
              <td colspan="2">
                <b><?php echo PriceinWords($MaintenanceAmount); ?></b>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <p STYLE="margin-bottom:0px !important;">
        Keeping in view of your interest in our Project “YASH VIHAR”, you are requested to pay the current outstanding within 10 days of this Demand Letter through cheque or Online Mode in favouring <b>“YASHVI HOSPITALITY & MANAGEMENT SERVICES", BANK NAME : NAINITAL BANK, A/C NO. 0511001000000329, IFSC CODE : NTBL0GUR051”,  BRANCH: SECTOR-15, PART-2  GURGAON”</b>.<br> All delayed payments made after due date shall be charged with an interest.
      </p>
      <p style="text-align:right;">
        For any query, you can reach our [support@yashvihar.com] at our office.<br><br>
        <b>WARM REGARDS</b>
        <br>
        For YASHVI HOSPITALITY & MANAGEMENT SERVICES.<br><br><br>
        (Authorised Signatory)
      </p>
      <p style="font-size:11px !important;line-height:12px;color:grey;">
        <b>NOTE:</b><br>
        1. You are requested to pay applicable Tax, if any, along with the demand
        amount.<br>
        2. Kindly mention your Name, CRN No., Plot No. and Telephone/Mobile number
        on the reverse side of the cheque/draft.<br>
        3. For applicable terms and condition please refer to the Application Form
        and/or BBA.<br>
        4. One sq. meter is equals to 10.7639 sq. ft.<br>
        5. The charges against dishonour of cheque(s) shall be applicable @ Rs. 1000/-
        for each case.<br>
        6. Ignore this letter if the demanded amount has already been paid<br>
        7. Kindly clear the due payment as per demand in favor of <b>“YASHVI HOSPITALITY & MANAGEMENT SERVICES", BANK NAME : NAINITAL BANK, A/C NO. 0511001000000329, IFSC CODE : NTBL0GUR051”,  BRANCH: SECTOR-15, PART-2  GURGAON”</b>.
        <br>
        9. If any payment is not timely made by the due date, in addition to the sum due there shall be a 9% late payment penalty and administrative penalty
      </p>
    </div>
  </section>
</body>

</html>
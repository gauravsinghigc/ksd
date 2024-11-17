<?php
require '../../require/modules.php';
require "../../require/admin/sessionvariables.php";
require '../../include/admin/common.php';

if (isset($_GET['id'])) {
    $bookingid = $_GET['id'];
    $_SESSION['bookingid'] = $_GET['id'];
} else {
    $bookingid = $_SESSION['id'];
}

$BookingSql = "SELECT * FROM bookings where bookingid='$bookingid'";
$customer_id = FETCH($BookingSql, "customer_id");
$partner_id = FETCH($BookingSql, "partner_id");
$CoAllotySql = "SELECT * FROM booking_alloties where BookingAllotyMainBookingId='$bookingid' and BookingAllotyFullName!=''";
$CustomerSql = "SELECT * FROM users where id='$customer_id'";
$PartnerSql = "SELECT * FROM users where id='$partner_id'";
$CustomerAddress = "SELECT * FROM user_address where user_id='$customer_id'";
$PartnerAddress = "SELECT * FROM user_address where user_id='$partner_id'";

//other variables
$area = FETCH($BookingSql, "unit_area");
$areaint = GetNumbers($area);

include "data-include.php";

$getpayments = SELECT("SELECT *, payments.created_at AS 'payment_created_at' FROM payments, bookings where payments.bookingid=bookings.bookingid and bookings.bookingid='$bookingid' order by payments.payment_id DESC");
$net_paid_amount2 = 0;
$SerialNo = 0;
while ($FetchAllPayments = mysqli_fetch_array($getpayments)) {
    $SerialNo++;
    $payment_id = $FetchAllPayments['payment_id'];
    $bookingid = $FetchAllPayments['bookingid'];
    $booking_date = $FetchAllPayments['booking_date'];
    $payment_date = date("d M, Y", strtotime($FetchAllPayments['payment_date']));
    $payment_mode = $FetchAllPayments['payment_mode'];
    $payment_amount = $FetchAllPayments['payment_amount'];
    $payment_created_at = $FetchAllPayments['payment_created_at'];
    $slip_no = $FetchAllPayments['slip_no'];
    $payment_id = $FetchAllPayments['payment_id'];
    $created_at = $FetchAllPayments['created_at'];
    $customer_id = $FetchAllPayments['customer_id'];
    $net_paid_amount = $FetchAllPayments['net_paid'];
    $partner_id = $FetchAllPayments['partner_id'];
    $payment_type = $FetchAllPayments['payment_type'];
    $clearing_date2 = $FetchAllPayments['clearing_date'];
    $emi_months = $FetchAllPayments['emi_months'];
    $net_paid_amount2 += (int)$net_paid_amount;

    if ($payment_mode == "check") {
        $payment_mode = "Cheque";
    } else {
        $$payment_mode = $payment_mode;
    }

    //select customer details
    $SelectCustomers = SELECT("SELECT * FROM users where id='$customer_id'");
    $CustomerDetails = mysqli_fetch_array($SelectCustomers);
    $CustomerName = $CustomerDetails['name'];

    //agent details
    $SelectAgents = SELECT("SELECT * FROM users where id='$partner_id'");
    $AgentDetails = mysqli_fetch_array($SelectAgents);
    $AgentName = $AgentDetails['name'];


    $GetPAYMENTS = SELECT("SELECT * FROM payments where payment_id='$payment_id' and bookingid='$bookingid' ORDER BY payment_id  DESC");
    $payments = mysqli_fetch_array($GetPAYMENTS);
    $payment_amount = $payments['payment_amount'];
    $payment_mode = $payments['payment_mode'];
    $slip_no = $payments['slip_no'];
    $remark = $payments['remark'];
    $payment_created_date = date("M, Y", strtotime($payments['payment_date']));
    $payment_created_date_full = date("d M, Y", strtotime($payments['payment_date']));
    $payment_created_date_full2 = date("dmY", strtotime($payments['payment_date']));
    $paymentcreatedat = $payments['created_at'];
    $payment_id = $payments['payment_id'];

    //payment modes
    if ($payment_mode == "check") {
        $SELECT_check_payments = SELECT("SELECT * from check_payments where payment_id='$payment_id'");
        $check_payments = mysqli_fetch_array($SELECT_check_payments);
        $txnid = $check_payments['check_payments'];
        $checknumber = $check_payments['checknumber'];
        $checkissuedto = $check_payments['checkissuedto'];
        $bankName = $check_payments['bankName'];
        $ifsc = $check_payments['ifsc'];
        $payment_status = $check_payments['checkstatus'];
        $check_issued_at = date("d M, Y", strtotime($check_payments['created_at']));
        $payment_note = "<br>by check no: $checknumber issued on $check_issued_at for $checkissuedto through $bankName | $ifsc e.i $payment_status";
    } else if (
        $payment_mode == "banking"
    ) {
        $SELECT_online_payments = SELECT("SELECT * FROM online_payments where payment_id='$payment_id'");
        $online_payments = mysqli_fetch_array($SELECT_online_payments);
        $txnid = $online_payments['online_payments_id'];
        $OnlineBankName = $online_payments['OnlineBankName'];
        $transactionId = $online_payments['transactionId'];
        $payment_details = $online_payments['payment_details'];
        $payment_mode = $online_payments['payment_mode'];
        $payment_status = $online_payments['transaction_status'];
        $payment_note = "<br>by Online Banking : Bank Name:$OnlineBankName, TxnId: $transactionId, Details: $payment_details, Status: $payment_status";
    } else if (
        $payment_mode == "cash"
    ) {
        $SELECT_cash_payments = SELECT("SELECT * FROM cash_payments where payment_id='$payment_id'");
        $cash_payments = mysqli_fetch_array($SELECT_cash_payments);
        $txnid = $cash_payments['cash_payments'];
        $cashreceivername = $cash_payments['cashreceivername'];
        $cashamount = $cash_payments['cashamount'];
        $payment_status = "done!";
        $payment_note = "<br>Cash " . $payment_amount . " is received by $cashreceivername on " . date("d M, Y h:m A", strtotime($paymentcreatedat));
    }
    $paymentreferenceid = "B$bookingid/P$payment_id/T$txnid/D$payment_created_date_full2";
}
?>
<?php
if (isset($_GET['payment_id'])) {
    $payment_id = $_GET['payment_id'];
    $getpayments = SELECT("SELECT * FROM payments where payment_id='$payment_id' and bookingid='$bookingid' order by payments.payment_id ASC");
} else {
    $getpayments = SELECT("SELECT * FROM payments where bookingid='$bookingid' order by payments.payment_id ASC");
}
$TotalPayment = 0;
$NetpaidTotal = 0;
$SerialNo = 0;
while ($FetchAllPayments = mysqli_fetch_array($getpayments)) {
    $SerialNo++;
    $payment_id = $FetchAllPayments['payment_id'];
    $bookingid = $FetchAllPayments['bookingid'];
    $payment_mode = $FetchAllPayments['payment_mode'];
    $payment_amount = $FetchAllPayments['payment_amount'];
    $payment_date = date("M, Y", strtotime($paymentcreatedat));
    $slip_no = $FetchAllPayments['slip_no'];
    $payment_id = $FetchAllPayments['payment_id'];
    $created_at = $FetchAllPayments['created_at'];
    $net_paid_amount = $FetchAllPayments['net_paid'];
    $payment_type = $FetchAllPayments['payment_type'];
    $charges2 = $FetchAllPayments['charges'];
    $chargeamount2 = $FetchAllPayments['chargeamount'];
    $discounts2 = $FetchAllPayments['discounts'];
    $discountamount2 = $FetchAllPayments['discountamount'];
    $TotalPayment += $payment_amount;
    $NetpaidTotal += $net_paid_amount;
    $remark = $FetchAllPayments['remark'];
    //payment status
    $SqlPayments = SELECT("SELECT * FROM payments where bookingid='$bookingid'");
    $FetchPayments = mysqli_fetch_array($SqlPayments);
    if ($payment_mode == "cash") {
        $paymentstatus = "Received";
        $cashreceivername = FETCH("SELECT * FROM cash_payments where payment_id='$payment_id'", "cashreceivername");
        $net_paid_amount = $net_paid_amount;
        $payment_Details = "Cash Payment received by $cashreceivername";
        $created_at = $FetchPayments['created_at'];
        $paid_date = $payment_created_date_full;
    } elseif ($payment_mode == "banking") {
        $checkbankpayment = SELECT("SELECT * FROM online_payments where payment_id='$payment_id'");
        $checkbankpaymentstatus = mysqli_fetch_assoc($checkbankpayment);
        $paymentstatus = $checkbankpaymentstatus['transaction_status'];
        $OnlineBankName = $checkbankpaymentstatus['OnlineBankName'];
        $transactionId = $checkbankpaymentstatus['transactionId'];
        $payment_details = $checkbankpaymentstatus['payment_details'];
        $payment_mode = $checkbankpaymentstatus['payment_mode'];
        $paid_date =  date("d M, Y", strtotime($checkbankpaymentstatus['created_at']));
        $transaction_status = $checkbankpaymentstatus['transaction_status'];
        $payment_Details = "Bank Name : $OnlineBankName<br>
       Txn ID : $transactionId<br>
       Details : $payment_details<br>
       Pay By : $payment_mode<br>
       Txn Status : $transaction_status<br>";

        if ($paymentstatus == "Success") {
            $net_paid_amount = $net_paid_amount;
        } else {
            $net_paid_amount = 0;
        }
    } elseif ($payment_mode == "check") {
        $SqlChequepayments = SELECT("SELECT * FROM check_payments where payment_id='$payment_id'");
        $FetchChequepayments = mysqli_fetch_assoc($SqlChequepayments);
        $paymentstatus = $FetchChequepayments['checkstatus'];
        $checkissuedto = $FetchChequepayments['checkissuedto'];
        $checknumber = $FetchChequepayments['checknumber'];
        $bankName = $FetchChequepayments['bankName'];
        $ifsc = $FetchChequepayments['ifsc'];
        $checkstatus = $FetchChequepayments['checkstatus'];
        if ($checkstatus == "Clear") {
            if ($FetchChequepayments['clearedat'] == null) {
                $paid_date = $paymentcreatedat;
            } else {
                $paid_date = date("d M, Y", strtotime($FetchChequepayments['clearedat']));
            }
        } else {
            if ($paid_date == null) {
                $paid_date = date("d M, Y", strtotime($payment_created_date_full));
                $clearedat = $paid_date;
            } else {
                $paid_date = "Check is $checkstatus";
            }
        }


        $clearedat = $FetchChequepayments['clearedat'];
        $bounceat = $FetchChequepayments['bounceat'];
        $inbankat = $FetchChequepayments['inbankat'];
        $issuedat = $FetchChequepayments['issuedat'];

        if ($bounceat == null) {
            $bounceat = "";
        } else {
            $bounceat = date("d M, Y", strtotime($FetchChequepayments['bounceat']));
        }

        if ($inbankat == null) {
            $inbankat = "";
        } else {
            $inbankat = date("d M, Y", strtotime($FetchChequepayments['inbankat']));
        }
        if ($issuedat == null) {
            $issuedat = "";
        } else {
            $issuedat = date("d M, Y", strtotime($FetchChequepayments['issuedat']));
        }

        if ($clearedat == null) {
            $clearedat = "";
        } else {
            $clearedat = date("d M, Y", strtotime($FetchChequepayments['clearedat']));
        }
        $payment_Details = "Cheque Received From : $checkissuedto<br>
       Cheque No :  $checknumber<br>
       Bank & IFSC : $bankName | $ifsc<br>
       Current Status : $checkstatus<br>
       Issue Date : $issuedat<br>
       Cleared At : $clearedat<br>
       Bounce At : $bounceat<br>
       InBank At : $inbankat";
        if ($paymentstatus == "Clear") {
            $net_paid_amount = $net_paid_amount;
        } else {
            $net_paid_amount = 0;
        }
        $payment_mode = "Cheque";
    }
} ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Receipt Acknowledge</title>
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
            <h2 style="text-align:center;margin-top: -1.5rem;margin-bottom:-0.2rem !important;">Receipt / Acknowledgement<br>
                <hr style="width:30%;margin-top:-0.1rem;">
                </h4>
                <p style="display:flex;justify-content:space-between;font-size:14px;">
                    <span>
                        <span><b>REF No:</b> <?php echo FETCH($BookingSql, "ref_no"); ?>//CRN:<?php echo FETCH($BookingSql, "crn_no"); ?></span><br>
                    </span>
                    <span>
                        <b>Plot No:</b> <?php echo FETCH($BookingSql, "unit_name"); ?>/<?php echo FETCH($BookingSql, "project_name"); ?>
                    </span>
                </p>
        </div>
        <div style="font-size:14px !important;">
            <div style="display:flex;justify-content:space-between;">
                <p>
                    <b>Allotee Details</b><br>
                    <?php echo FETCH($CustomerSql, "name"); ?>,<br>
                    <?php echo FETCH($CustomerSql, "father_name"); ?><br>
                    <?php
                    echo FETCH($CustomerAddress, "user_street_address") . " ";
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
                        <?php echo FETCH($CoAllotySql, "BookingAllotyFullName"); ?>,<br>
                        <?php echo FETCH($CoAllotySql, "BookingAllotyRelation"); ?><br>
                        <?php echo FETCH($CoAllotySql, "BookingAllotyFatherName"); ?><br>
                        <?php
                        echo FETCH($CoAllotySql, "BookingAllotyStreetAddress") . " ";
                        echo FETCH($CoAllotySql, "BookingAllotyArea") . " <br>";
                        echo FETCH($CoAllotySql, "BookingAllotyCity") . " ";
                        echo FETCH($CoAllotySql, "BookingAllotyState") . " <br>";
                        echo FETCH($CoAllotySql, "BookingAllotyPhoneNumber") . " <BR>";
                        echo FETCH($CoAllotySql, "BookingAllotyEmail") . " ";
                        ?>
                    </p>
                <?php } ?>
            </div>
            <p style="margin-top:0px !important;">
                <b style="font-size:1.2rem;">Dear <?php echo FETCH($CustomerSql, "name"); ?></b>
            </p>
            <div style="padding-right:2rem !important;">
                <table style="width:100%;line-height:1rem;">
                    <tr class="striped text-left">
                        <th class="text-left" style="width:40%;" align="left">Project, Plot No & Area:</th>
                        <th class="text-left" align="left"><?php echo $project_name; ?> @ <?php echo $unit_name; ?> having Area <?php echo $unit_area; ?></th>
                    </tr>
                    <tr class="striped text-left">
                        <th class="text-left" align="left">Payment Ref ID:</th>
                        <td>#<?php echo $paymentreferenceid; ?></td>
                    </tr>
                    <tr class="striped text-left">
                        <th class="text-left" align="left">Paid Amount</th>
                        <td>Rs.<?php echo $net_paid_amount; ?> (<span><?php echo PriceInWords($net_paid_amount); ?></span>)</td>
                    </tr>
                    <tr class="striped text-left">
                        <th class="text-left" align="left">Payment Mode</th>
                        <td><?php echo $payment_mode; ?></td>
                    </tr>
                    <tr class="striped text-left">
                        <th class="text-left" align="left">Payment Created At</th>
                        <td><?php echo DATE_FORMATE2("d M, Y h:i A", $paymentcreatedat); ?></td>
                    </tr>
                    <tr class="striped text-left">
                        <th class="text-left" align="left">Payment Date</th>
                        <td><?php echo $paid_date; ?></td>
                    </tr>
                    <tr class="striped text-left">
                        <th class="text-left" align="left">Payment Details</th>
                        <td><?php echo $payment_Details; ?></td>
                    </tr>
                </table>
                <hr>
                <table style="width:100%;line-height:1rem;">
                    <tr>
                        <th align="right">Descriptions</th>
                        <th align="right">Amounts</th>
                    </tr>
                    <tr>
                        <td align="right">Net Payable Amount</td>
                        <td align="right"><?php echo Price(number_format($net_payable_amount), "text-success", "Rs."); ?></td>
                    </tr>
                    <tr>
                        <td align="right">Net Paid</td>
                        <td align="right"><?php echo Price(number_format($net_paid_amount), "text-success", "Rs."); ?></td>
                    </tr>
                    <tr>
                        <td align="right" style="color:grey;">Balance</td>
                        <td align="right" style="color:grey;"><?php echo Price(number_format((int)$net_payable_amount - (int)$net_paid_amount), "text-success", "Rs."); ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right">
                            <p style="margin-bottom:0px;">
                                In Words <b><?php echo PriceInWords($net_paid_amount); ?></b>
                            </p>
                        </td>
                    </tr>
                </table>
                <p style="text-align:right;">
                    For any query, you can reach our [support@yashvihar.com] at our office.<br>
                    <b>WARM REGARDS</b>
                    <br>
                    For KSD Buildtech Private Limited.<br><br><br><br>
                    (Authorised Signatory)
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
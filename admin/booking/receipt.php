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
$project_unit_id = FETCH($BookingSql, "project_unit_id");

$UnitSQL = "SELECT * FROM project_units where project_units_id='$project_unit_id'";
$project_block_id = FETCH($UnitSQL, "project_block_id");
$project_floor_id = FETCH($UnitSQL, "project_floor_id");
$project_block_name = FETCH("SELECT project_block_name FROM project_blocks where project_block_id='$project_block_id'", "project_block_name");
$projects_floor_name = FETCH("SELECT projects_floor_name from projects_floors WHERE projects_floors_id='$project_floor_id'", "projects_floor_name");
$projects_floors_tag = FETCH("SELECT projects_floors_tag from projects_floors WHERE projects_floors_id='$project_floor_id'", "projects_floors_tag");
$project_unit_bhk_type = FETCH("SELECT project_unit_bhk_type FROM project_units where project_units_id='$project_unit_id'", "project_unit_bhk_type");
$project_unit_highlights = FETCH("SELECT project_unit_highlights FROM project_units where project_units_id='$project_unit_id'", "project_unit_highlights");
$unit_broker_rate = FETCH("SELECT unit_broker_rate FROM project_units where project_units_id='$project_unit_id'", "unit_broker_rate");


$AllDevSql = "SELECT * FROM developmentcharges where bookingid='$bookingid'";
$DevChargeSql = "SELECT * FROM developmentcharges, developmentchargepayments where developmentcharges.bookingid='$bookingid' and developmentcharges.devchargesid=developmentchargepayments.developmentchargeid";
$DevId = FETCH($DevChargeSql, "developmentchargeid");
$DevSql = "SELECT * FROM developmentcharges where devchargesid='$DevId'";
$AllDevSql = "SELECT * FROM developmentcharges where bookingid='$bookingid'";
$AllDevPaidCharges1 = "SELECT * FROM developmentcharges, developmentchargepayments where developmentcharges.bookingid='$bookingid' and developmentcharges.devchargesid=developmentchargepayments.developmentchargeid and devpaymentstatus like '%RECEIVED%'";
$AllDevPaidCharges2 = "SELECT * FROM developmentcharges, developmentchargepayments where developmentcharges.bookingid='$bookingid' and developmentcharges.devchargesid=developmentchargepayments.developmentchargeid and devpaymentstatus like '%PAID%'";
$AllDevPaidCharges3 = "SELECT * FROM developmentcharges, developmentchargepayments where developmentcharges.bookingid='$bookingid' and developmentcharges.devchargesid=developmentchargepayments.developmentchargeid and devpaymentstatus like '%CLEAR%'";
$NetDevPaidAmount = AMOUNT($AllDevPaidCharges1, "devchargepaymentamount") + AMOUNT($AllDevPaidCharges2, "devchargepaymentamount") + AMOUNT($AllDevPaidCharges3, "devchargepaymentamount");

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
    $payment_id = $_GET['payment_id'];
    $created_at = $FetchAllPayments['created_at'];
    $customer_id = $FetchAllPayments['customer_id'];
    $net_paid_amount = $FetchAllPayments['net_paid'];
    $partner_id = $FetchAllPayments['partner_id'];
    $payment_type = $FetchAllPayments['payment_type'];
    $clearing_date2 = $FetchAllPayments['clearing_date'];
    $emi_months = $FetchAllPayments['emi_months'];
    $net_paid_amount2 += $net_paid_amount;

    if ($payment_mode == "check") {
        $payment_mode = "Cheque";
    } else {
        $payment_mode = $payment_mode;
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
    $charges = $payments['charges'];
    $chargeamount = $payments['chargeamount'];
    $discounts = $payments['discounts'];
    $discountamount = $payments['discountamount'];

    //payment modes
    if ($payment_mode == "check") {
        $SELECT_check_payments = SELECT("SELECT * from check_payments where payment_id='$payment_id'");
        $check_payments = mysqli_fetch_array($SELECT_check_payments);
        $txnid = $check_payments['check_payments'];
        $checknumber = $check_payments['checknumber'];
        $checkissuedto = $check_payments['checkissuedto'];
        $bankName = $check_payments['bankName'];
        $ifsc = $check_payments['ifsc'];
        $paidamountnet = $check_payments['checkamount'];
        $payment_status = $check_payments['checkstatus'];
        $check_issued_at = date("d M, Y", strtotime($check_payments['created_at']));
        $payment_note = "<br>by Cheque no: $checknumber issued on $check_issued_at for $checkissuedto through $bankName | $ifsc e.i $payment_status";
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
        $paidamountnet = $online_payments['onlinepaidamount'];
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
        $paidamountnet = $cashamount;
        $payment_status = "done!";
        $payment_note = "<br>Cash " . $payment_amount . " is received by $cashreceivername on " . date("d M, Y h:m A", strtotime($paymentcreatedat));
    }
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
    $DisplayedPaymentdate = date("d M, Y", strtotime($FetchAllPayments['payment_date']));
    $paid_date = $payment_date;
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
}
$inputString = $unit_name; // Your input string

// Use preg_replace to remove alphabets and get only numbers
$numbersOnly = preg_replace("/[^0-9]/", "", $inputString);
?>
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

<body onload="doConvert()" style="font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI' , Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans' , 'Helvetica Neue' , sans-serif !important;margin-left:1.5rem;font-size:0.75rem;">
    <section style="padding:0.5rem;margin:0% auto;display:block;">
        <?php include "../../include/export/rc-header.php"; ?>
        <div>
            <h2 style="text-align:center;margin-bottom:-0.2rem !important;">Receipt / Acknowledgement<br>
                <hr style="width:30%;margin-top:-0.1rem;">
                </h4>
                <p style="display:flex;justify-content:space-between;font-size:14px;">
                    <span>
                        <span><b>Payment Date :</b> <?php echo DATE("d M, Y", strtotime($paid_date)); ?></span><br>
                        <span><b>Unit No:</b> <?php echo $numbersOnly; ?> (<?php echo $project_unit_bhk_type; ?>) /<?php echo $projects_floor_name; ?>/<?php echo $project_block_name; ?></span><br>
                    </span>
                    <span>
                        <b>Print Date :</b> <?php echo date("d M, Y h:m A"); ?><br>
                        <b>BookingID :</b> B<?php echo $_GET['id']; ?>/<?php echo date("m/Y", strtotime($created_at)); ?>
                    </span>
                </p>
        </div>
        <div style="font-size:14px !important;">
            <div style="display:flex;justify-content:space-between;">
                <p style='margin-top:0px;'>
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
                    </p>
                <?php }
                if ($discountamount2 == null) {
                    $discountamount2 = 0;
                }
                ?>
            </div>
            <p style="margin-top:0px !important;margin-bottom:0px;">
                <b style="font-size:1.2rem;">Dear <?php echo FETCH($CustomerSql, "name"); ?></b>
            </p>
            <div style="padding-right:0rem !important;">
                <table style="width:100%;line-height:1rem;">
                    <tr class="striped text-left">
                        <th class="text-left" style="width:40%;" align="left">Project, Unit No & Area:</th>
                        <td class="text-left" align="left"><?php echo $project_name; ?>, <b>Unit No: <?php echo $numbersOnly; ?></b> (<?php echo $project_unit_bhk_type; ?>) at <b><?php echo $projects_floor_name; ?></b> floor in <b><?php echo $project_block_name; ?></b> block/tower, having Area <b><?php echo $unit_area; ?></b></td>
                    </tr>
                    <tr class="striped text-left">
                        <th class="text-left" align="left">Payment Ref ID:</th>
                        <td>#<?php echo $paymentreferenceid; ?></td>
                    </tr>
                    <?php if ($discountamount2 != null) { ?>
                        <tr class="striped text-left">
                            <th class="text-left" align="left">Net Paying Amount</th>
                            <td>Rs.<?php echo Price($paidamountnet + $discountamount2, "", ""); ?></td>
                        </tr>
                        <tr class="striped text-left">
                            <th class="text-left" align="left">Applicable Discount</th>
                            <td>- Rs.<?php echo Price($discountamount2, "", ""); ?> (<?php echo $discounts2; ?>)</td>
                        </tr>
                        <tr class="striped text-left">
                            <th class="text-left" align="left">Paid Amount</th>
                            <td>Rs.<?php echo Price($paidamountnet, "", ""); ?></td>
                        </tr>
                    <?php } ?>

                    <?php if ($chargeamount2 != null) { ?>
                        <tr class="striped text-left">
                            <th class="text-left" align="left">Net Paying Amount</th>
                            <td>Rs.<?php echo Price($paidamountnet - $chargeamount2, "", ""); ?></td>
                        </tr>
                        <tr class="striped text-left">
                            <th class="text-left" align="left">Applicable Charges</th>
                            <td>+ Rs.<?php echo Price($chargeamount2, "", ""); ?> (<?php echo $charges2; ?>)</td>
                        </tr>
                        <tr class="striped text-left">
                            <th class="text-left" align="left">Net Paid Amount</th>
                            <td>Rs.<?php echo Price($paidamountnet, "", ""); ?></td>
                        </tr>
                    <?php } ?>
                    <tr class="striped text-left">
                        <th class="text-left" align="left">Amount in words</th>
                        <td><?php echo PriceInWords($paidamountnet); ?></td>
                    </tr>
                    <tr class="striped text-left">
                        <th class="text-left" align="left">Payment Mode</th>
                        <td><?php echo $payment_mode; ?></td>
                    </tr>
                    <tr class="striped text-left">
                        <th class="text-left" align="left">Payment Created At</th>
                        <td><?php echo DATE_FORMATE2("d M, Y h:i A", $created_at); ?></td>
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
                        <td align="right">Net Payable Amount (100%) :</td>
                        <td align="right"><?php echo Price($net_payable_amount, "text-success", "Rs."); ?></td>
                    </tr>
                    <?php if ($discountamount2 != null) { ?>
                        <tr>
                            <td align="right">Payable Amount :</td>
                            <td align="right">Rs.<?php echo Price($paidamountnet + $discountamount2, "", ""); ?></td>
                        </tr>
                        <tr>
                            <td align="right">Discount (<?php echo $discounts2; ?>) :</td>
                            <td align="right">- Rs.<?php echo Price($discountamount2, "", ""); ?></td>
                        </tr>
                    <?php } ?>

                    <?php if ($chargeamount2 != null) { ?>
                        <tr>
                            <td align="right">Payable Amount :</td>
                            <td align="right">Rs.<?php echo Price($paidamountnet - $chargeamount2, "", ""); ?></td>
                        </tr>
                        <tr>
                            <td align="right">Charges (<?php echo $charges2; ?>) :</td>
                            <td align="right">+ Rs.<?php echo Price($chargeamount2, "", ""); ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td align="right">Paid Amount :</td>
                        <td align="right">Rs.<?php echo Price($paidamountnet, "", ""); ?></td>
                    </tr>
                    <?php
                    $CurrentPaymentId = IfRequested("GET", "payment_id", 0, false);
                    $TotalPaidTillCurrentDate = AMOUNT("SELECT * FROM payments where payment_id<='$CurrentPaymentId' and bookingid='$bookingid' order by payments.payment_id ASC", "net_paid"); ?>
                    <tr>
                        <td align="right">Total Paid Amount (<?php echo $PaidPercentage = round($TotalPaidTillCurrentDate / $net_payable_amount * 100, 2); ?>%) :</td>
                        <td align="right"><?php echo Price($TotalPaidTillCurrentDate, "text-success", "Rs."); ?></td>
                    </tr>
                    <?php
                    $CheckSqlForReSale = CHECK("SELECT * FROM booking_resales where booking_main_id='$bookingid' and booking_resale_type='TRANSFER'");
                    if ($CheckSqlForReSale != null) {
                        $PreviousBookingId = FETCH("SELECT * FROM bookings where bookingid!='$bookingid' and project_unit_id='$project_unit_id' ORDER BY bookingid DESC limit 1", "bookingid");
                        $PreviousPayment = GetNetPaidAmount($PreviousBookingId);
                    } else {
                        $PreviousPayment = 0;
                    }
                    if ($PreviousPayment != 0) {
                    ?>
                        <tr>
                            <th align="right">Previously Paid :</th>
                            <td align="right">Rs.<?php echo Price($PreviousPayment, "", "Rs."); ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td align="right" style="color:grey;">Balance (<?php echo 100 - $PaidPercentage; ?>%) :</td>
                        <td align="right" style="color:grey;">
                            <?php
                            echo Price(round($net_payable_amount - $TotalPaidTillCurrentDate - $PreviousPayment, 2), "", "Rs.");
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" align="right">
                            <p style="margin-bottom:0px;">
                                In Words <b><?php echo PriceInWords($paidamountnet); ?></b>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right">
                            <p style="font-size:0.75rem !important;margin-bottom:0px;margin-top:0px;">* Please see the Development & Other Charges dues in next page.</p>
                        </td>
                    </tr>
                </table>
                <p style="text-align:right;">
                    For any query, you can reach our [<?php echo company_email; ?>] at our office.<br><br>
                    <b>WARM REGARDS</b>
                    <br>
                    For <?php echo company_name; ?>.<br><br><br>
                    (Authorised Signatory)<br><br>
                </p>
            </div>

            <div style="font-size:14px !important;">
                <hr>
                <h4 style='text-align:right;margin-bottom:0px;'>Development & Other Charges</h4>
                <table style="width:100%;line-height:1rem;">
                    <tr>
                        <th align="right">Descriptions</th>
                        <th align="right">Amounts</th>
                    </tr>
                    <tr>
                        <td align="right">Net Development & Other Charges :</td>
                        <td align="right">
                            <?php echo Price($AllDevCharges = AMOUNT($AllDevSql, "developementchargeamount"), "text-success", "Rs."); ?></td>
                    </tr>
                    <tr>
                        <td align="right">Net Previously Paid Charges:</td>
                        <td align="right"><?php echo Price($NetDevPaidAmount, "text-success", "Rs."); ?></td>
                    </tr>
                    <tr>
                        <td align="right">Balance :</td>
                        <td align="right">
                            <?php
                            $tolerance = 1e-10;  // or any other small value based on your requirements
                            $result = $AllDevCharges - $NetDevPaidAmount;
                            echo Price($result, "text-success", "Rs.");
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div style='display:inline-block;width:100%;'>
                <p>
                    <b> NOTE:</b><br>
                    ❖ This Acknowledgement is subject to realization of cheque and fulfilment of Terms and Conditions mentioned in the
                    Application Form, Allotment Letter and/ or Buyer Agreement.<br>
                    ❖ Any discrepancies shall be brought to the notice of the Company within 15 days of this receipt.<br>
                    Please ensure that you indicate your name, CRN No and the telephone number/ mobile number on the reverse of the cheque/
                    draft submitted by you.<br>
                </p>
                <center><small>This is a computer generated receipt, signature will be required in special conditions only.</small></center>
                <br><br>
            </div>
        </div>
    </section>
</body>

</html>
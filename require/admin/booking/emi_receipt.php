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
    <title>Print B<?php echo $_GET['id']; ?> EMI Receipts</title>
</head>

<body onload="doConvert()" style="padding: 1rem;padding: 1rem;color: black;font-size:13px;margin:auto;font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">
    <?php
    include "data-include.php";
    $paymentreferenceid = "B$bookingid/P$payment_id/T$txnid/D$payment_created_date_full2";
    ?>
    <section style="border-style:groove; border-width:thin;margin: auto; width: 1000px;height:1470px;border: 1px solid rgb(147 78 255);padding: 5px;display:block;">
        <div style="text-align:center;">
            <br>
            <h5 style="line-height:1;margin-bottom:4px;margin-top:-19px;">
                <span style="font-size:1.5rem !important;">-------------- PAYMENT RECEIPT --------------</span><br>
            </h5>
        </div>
        <?php include "../../include/export/rc-header.php"; ?>
        <div style="display: flex;justify-content: space-between;margin-top:7px;">
            <div style="width:40%;">
                <table style="text-align:left;line-height: 15px;">
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
                <table style="text-align:left;line-height: 15px;">
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

        <h3 style="text-align:center; margin-top:2px; margin-bottom:2px;background-color:lightgray;padding:4px;">Payments Details</h3>
        <div style="display: flex;">
            <table class="striped" style="width:55%;padding:1px;font-size:13px;">
                <tbody>
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
                            $payment_Details = "Cheque Issued To : $checkissuedto<br>
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
                    ?>
                        <tr class="striped text-left">
                            <th class="text-left" align="left">Payment Ref ID:</th>
                            <td>#<?php echo $paymentreferenceid; ?></td>
                        </tr>
                        <tr class="striped text-left">
                            <th class="text-left" align="left">Paying EMI MONTH</th>
                            <td><?php echo $payment_created_date; ?></td>
                        </tr>
                        <tr class="striped text-left">
                            <th class="text-left" align="left">Paid Amount</th>
                            <td>Rs.<?php echo $net_paid_amount; ?> (<span><?php echo PriceInWords($net_paid_amount); ?></span>)</td>
                        </tr>
                        <tr class="striped text-left">
                            <th class="text-left" align="left">Paid Mode</th>
                            <td><?php echo $payment_mode; ?></td>
                        </tr>
                        <tr class="striped text-left">
                            <th class="text-left" align="left">Payment Created At</th>
                            <td><?php echo $paymentcreatedat; ?></td>
                        </tr>
                        <tr class="striped text-left">
                            <th class="text-left" align="left">Paid Date</th>
                            <td><?php echo $paid_date; ?></td>
                        </tr>
                        <tr class="striped text-left">
                            <th class="text-left" align="left">Paid Type</th>
                            <td><?php echo $payment_type; ?></td>
                        </tr>
                        <tr class="striped text-left">
                            <th class="text-left" align="left">Paid Details</th>
                            <td><?php echo $payment_Details; ?></td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
            <div style="width:45% !important;">
                <table style="text-align:right;line-height: 14px;font-size:14px !important;width:100% !important;margin-top:1rem !important;font-weight:600 !important;">
                    <tr>
                        <th>Total Unit Cost :</th>
                        <td>Rs.<?php echo $unit_cost; ?></td>
                    </tr>
                    <?php if ($chargename == null) {
                    } else { ?>
                        <tr>
                            <th><?php echo $chargename; ?> (<?php echo $charges; ?>%) :</th>
                            <td>+ Rs.<?php echo $unit_cost / 100 * $charges; ?></td>
                        </tr>
                    <?php } ?>
                    <?php if ($discountname == null) {
                    } else { ?>
                        <tr>
                            <th><?php echo $discountname; ?> (Rs.<?php echo $discount;  ?>/sq area) :</th>
                            <td>- Rs.<?php echo $unit_area_in_numbers * $discount; ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th>Net Payable :</th>
                        <td>Rs.<?php echo $net_payable_amount; ?></td>
                    </tr>
                    <tr>
                        <th>Previously Paid :</th>
                        <td>Rs.<?php echo (int)$TotalAmountPaid - (int)$net_paid_amount; ?></td>
                    </tr>
                    <tr>
                        <th>Receipt Amount :</th>
                        <td>Rs.<?php echo $net_paid_amount; ?></td>
                    </tr>
                    <tr>
                        <th>Total Paid :</th>
                        <td style="color:green;">Rs.<?php echo $TotalAmountPaid; ?></td>
                    </tr>
                    <tr>
                        <th>Balance :</th>
                        <td style="color:red;">Rs.<?php echo $net_payable_amount - $TotalAmountPaid; ?></td>
                    </tr>
                </table>
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
    </section>
</body>

</html>
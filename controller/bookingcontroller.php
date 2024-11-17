<?php

//add controller helper files
require 'helper.php';

//add aditional requirements
require '../require/admin/sessionvariables.php';

if (isset($_POST['completebookings'])) {
    //emivariable
    $emi_start_date = $_SESSION['emi_start_date'];
    $emi_per_month = $_SESSION['emi_per_month'];
    $emi_last_date = $_SESSION['emi_last_date'];
    $emi_day_of_month = $_SESSION['emi_day_of_month'];
    $emi_status = "NOT PAID";
    $emi_months = $_SESSION['emi_months'];
    $tally_no = $_SESSION['tally_no'];

    $start = 0;

    $created_at = RequestDataTypeDate();

    //booking
    $payment_amount = $_SESSION['booking_amount'];
    $rest_amount = $_SESSION['rest_amount'];
    $booking_date = date("Y-m-d", strtotime($_SESSION['booking_date']));
    $clearing_date = date("Y-m-d", strtotime("+$emi_months months", strtotime($_SESSION['booking_date'])));
    $possession = $_SESSION['possession'];
    $net_paid = $payment_amount;
    $checkamount = $net_paid;
    $onlinepaidamount = $net_paid;
    $project_list_id = $_SESSION['project_list_id'];
    $possession_notes = $_SESSION['possession_notes'];
    $parking_status = $_SESSION['parking_status'];

    //payment
    $payment_mode = $_SESSION['payment_mode'];

    //check
    $checkissuedto = $_SESSION['checkissuedto'];
    $checknumber = $_SESSION['checknumber'];
    $bankName = $_SESSION['BankName'];
    $ifsc = $_SESSION['ifsc'];

    //OnlineBankName
    $onlinepaymenttype = $_SESSION['onlinepaymenttype'];
    $OnlineBankName = $_SESSION['OnlineBankName'];
    $transactionId = $_SESSION['transactionId'];
    $payment_details = $_SESSION['payment_details'];
    $transaction_status = $_SESSION['transaction_status'];

    //cash payment
    $cashreceivername = $_SESSION['cashreceivername'];
    $cashamount = $payment_amount;

    //payment date
    if ($payment_mode == "cash") {
        $payment_date = $_SESSION['cashreceivedate'];
    } else if ($payment_mode == "check") {
        $payment_date = $_SESSION['checkissuedate'];
    } else {
        $payment_date = $_SESSION['transactiondate'];
    }

    //remark
    $crn_no = $_SESSION['slip_no'];
    $ref_no = $_SESSION['remark'];

    //project details
    $project_name = $_SESSION['project_name'];
    $project_area = $_SESSION['project_area'];
    $unit_name = $_SESSION['unit_name'];
    $unit_area = $_SESSION['unit_area'];
    $unit_rate = $_SESSION['unit_rate'];
    $unit_cost =  $_SESSION['unit_cost'];
    $net_payable_amount = $_SESSION['net_payable_amount'];
    $chargename = $_SESSION['chargename'];
    $charge = (int)$_SESSION['charges'];
    $charges = $charge;


    //Bank loan details
    $booking_bank_ifsc_code = $_SESSION['booking_bank_ifsc_code'];
    $booking_santion_amount = $_SESSION['booking_santion_amount'];
    $booking_receive_amount = $_SESSION['booking_receive_amount'];
    $booking_loan_notes = $_SESSION['booking_loan_notes'];

    if ($_SESSION['discountamount'] == null) {
        $discountname = null;
    } else {
        $discountname = $_SESSION['discountname'];
    }

    $discountamount = (int)$_SESSION['discount'];
    $discount = (int)$_SESSION['discount'];
    $project_unit_id = $_SESSION['project_unit_id'];

    //customer details
    $customer_id = $_SESSION['customer_id'];


    //if customer is already registered
    $partner_id = FETCH("SELECT * FROM commission_temps ORDER BY TempCommissionId DESC limit 1", "partner_id");

    //save booking project details
    $status = "ACTIVE";
    $savebookings = SAVE("bookings", ["possession_notes", "parking_status", "ref_no", "crn_no", "emi_months", "booking_date", "clearing_date", "possession", "customer_id", "partner_id", "company_id", "project_name", "project_area", "unit_name", "unit_area", "unit_rate", "unit_cost", "net_payable_amount", "chargename", "charges", "discountname", "discount", "status", "project_list_id", "project_unit_id", "created_at"]);
    if ($savebookings == true) {
        $SelectBooking = SELECT("SELECT * FROM bookings where customer_id='$customer_id' and partner_id='$partner_id' and company_id='$company_id' ORDER BY bookingid DESC");
        $fetchBooking = mysqli_fetch_array($SelectBooking);
        $bookingid = $fetchBooking['bookingid'];
        $booking_id = $bookingid;
        $_SESSION['booking_id'] = $booking_id;

        //save payments
        $payment_type = "BOOKING";
        $slip_no = $tally_no;
        $create_payments = SAVE("payments", ["bookingid", "payment_mode", "payment_amount", "slip_no", "remark", "payment_date", "net_paid", "payment_type", "created_at"]);
        if ($create_payments == true) {
            $selectpayments = SELECT("SELECT * FROM payments where bookingid='$bookingid' and payment_amount='$payment_amount' ORDER BY payment_id DESC");
            $payments = mysqli_fetch_array($selectpayments);
            $payment_id = $payments['payment_id'];

            //create payment modes
            if ($payment_mode == "check") {
                $created_at = $_SESSION['checkissuedate'];
                $issuedat = $_SESSION['checkissuedate'];
                if ($checkstatus == "Clear") {
                    $clearedat = $_SESSION['clearedat'];
                } else {
                    $clearedat = $_SESSION['clearedat'];
                }
                $savechecks = SAVE("check_payments", ["payment_id", "checkissuedto", "checknumber", "bankName", "ifsc", "checkstatus", "checkamount", "created_at", "issuedat", "clearedat"]);
                if ($savechecks == true) {
                    $payment = "save";
                } else {
                    $payment = "failed";
                }
            } else if ($payment_mode == "cash") {
                $created_at = $_SESSION['cashreceivedate'];
                $savecash = SAVE("cash_payments", ["payment_id", "cashreceivername", "cashamount", "created_at"]);
                if ($savecash == true) {
                    $payment = "save";
                } else {
                    $payment = "failed";
                }
            } else if ($payment_mode == "banking") {
                $payment_mode = $_SESSION['onlinepaymenttype'];
                $created_at = $_SESSION['transactiondate'];
                $saveonlinepayment = SAVE("online_payments", ["payment_id", "OnlineBankName", "transactionId", "onlinepaidamount", "created_at", "payment_details", "payment_mode", "transaction_status"]);
                if ($saveonlinepayment == true) {
                    $payment = "save";
                } else {
                    $payment = "failed";
                }
            }


            //save commission_amount
            if ($payment == "save") {
                //fetch commisssion
                $TempCommissionSessionId = $_SESSION['TEMP_BOOKING_SESSION'];

                //get all commission
                $Commission = FetchConvertIntoArray("SELECT * FROM commission_temps", true);
                if ($Commission != null) {
                    foreach ($Commission as $Com) {
                        $data = array(
                            "partner_id" => $Com->partner_id,
                            "booking_id" => $booking_id,
                            "commission_type" => $Com->commission_type,
                            "commission_amount" => $Com->commission_amount,
                            "commission_percentage" => $Com->commission_percentage,
                            "commission_rate_area" => $Com->commission_rate_area,
                            "commission_on_area" => $Com->commission_on_area,
                            "created_at" => RequestDataTypeDate,
                            "commission_remark" => $Com->commission_remark,
                            "total_area" => $Com->total_area,
                        );
                        $commsion = INSERT("commission", $data);
                        $commission_id = FETCH("SELECT * FROM commission ORDER BY commission_id DESC limit 1", "commission_id");
                    }
                } else {
                    $commsion = true;
                }
                if ($commsion == "save") {
                    $SaveBookingEMIs = SAVE("booking_emis", ["booking_id", "customer_id", "emi_start_date", "emi_last_date", "emi_per_month", "emi_day_of_month", "emi_status", "created_at", "emi_months"]);
                    if ($SaveBookingEMIs == true) {
                        $SearchEmiId = SELECT("SELECT * FROM booking_emis where booking_id='$booking_id' ORDER BY emi_id DESC limit 0, 1");
                        $SQ_EMI_ID = mysqli_fetch_array($SearchEmiId);
                        $emi_id = $SQ_EMI_ID['emi_id'];

                        while ($start < $emi_months) {
                            $monthinc = "+$start month";
                            $emi_dates = date("Y-m-d", strtotime("$monthinc", strtotime($emi_start_date)));
                            $emi_amount = $emi_per_month;
                            $emi_list_status = $emi_status;
                            $prefer_day = $emi_day_of_month;
                            $emi_paid = 0;
                            $emi_balance = $emi_amount;
                            $start++;
                            $emi_number = $start;
                            $SaveEMIs = SAVE("emi_lists", ["emi_id", "emi_dates", "emi_amount", "emi_paid", "emi_balance", "emi_list_status", "prefer_day", "emi_number"]);
                        }

                        if ($SaveEMIs == true) {
                            echo "true";
                        } else {
                            echo "false";
                        }
                    }

                    DELETE_FROM("commission_temps", "TempCommissionSessionId='" . $_SESSION['TEMP_BOOKING_SESSION'] . "'");

                    //check booking mode
                    if (isset($_SESSION['TYPE'])) {
                        $type = $_SESSION['TYPE'];
                        $plot_id = $_SESSION['plot_id'];
                        $project_id = $_SESSION['project_id'];

                        //get latest bookings
                        $booking_main_id = $booking_id;
                        $booking_sold_to = FETCH("SELECT * FROM bookings where project_unit_id='$plot_id' and project_list_id='$project_id' and bookingid<='$booking_id' ORDER BY bookingid DESC limit 1", "bookingid");
                        $booking_sale_from = FETCH("SELECT * FROM bookings where project_unit_id='$plot_id' and project_list_id='$project_id' and bookingid<='$booking_id' ORDER BY bookingid DESC limit 1", "customer_id");
                        $booking_resale_date = $booking_date;
                        $booking_payable_amount = $net_payable_amount;
                        $booking_plot_id = $plot_id;
                        $booking_resale_type = $type;
                        $booking_resale_created_at = RequestDataTypeDate;
                        $booking_resale_created_by = LOGIN_UserId;

                        $booking_resales = [
                            "booking_main_id" => $booking_main_id,
                            "booking_sold_to" => $booking_sold_to,
                            "booking_sale_from" => $booking_sale_from,
                            "booking_resale_date" => $booking_resale_date,
                            "booking_payable_amount" => $booking_payable_amount,
                            "booking_plot_id" => $booking_plot_id,
                            "booking_resale_type" => $booking_resale_type,
                            "booking_resale_created_at" => $booking_resale_created_at,
                            "booking_resale_created_by" => $booking_resale_created_by
                        ];
                        $Save = INSERT("booking_resales", $booking_resales);

                        if ($Save == true) {
                            unset($_SESSION['TYPE']);
                            unset($_SESSION['plot_id']);
                            unset($_SESSION['project_id']);
                        }
                    }

                    //save bank loan details
                    $booking_loans = [
                        "booking_main_id" => $booking_main_id,
                        "booking_bank_name" => $booking_bank_name,
                        "booking_santion_amount" => $booking_santion_amount,
                        "booking_receive_amount" => $booking_receive_amount,
                        "booking_loan_notes" => $booking_loan_notes,
                        "booking_loan_created_at" => date("Y-m-d"),
                        "booking_loan_updated_at" => date("Y-m-d"),
                        "booking_bank_ifsc_code" => $booking_bank_ifsc_code
                    ];
                    $Save = INSERT("booking_loans", $booking_loans);

                    $_SESSION['TEMP_BOOKING_SESSION'] = NULL;
                    header_remove();
                    LOCATION("success", "Booking BID$bookingid is created successfully!", "../admin/booking/success.php?bookingid=$bookingid");
                } else {
                    header_remove();
                    LOCATION("warning", "Booking BDI$bookingid creation fialed!!", "../admin/booking/failed.php");
                }
            } else {
                echo "payment details are not saved!";
            }
        } else {
            echo "Unable to create bookings";
        }
    }

    //update possesion details
} else if (isset($_POST['update_possession_status'])) {
    $bookingid = $_POST['update_possession_status'];
    $possession = $_POST['possession'];
    $possession_notes = $_POST["possession_notes"];
    $possession_update_date = RequestDataTypeDate();
    $clearing_date = date("Y-m-d", strtotime($_POST["clearing_date"]));
    $booking_date = $_POST['booking_date'];
    $created_at = $_POST['created_at'];
    $parking_status = $_POST['parking_status'];

    $Update = UPDATE("UPDATE bookings SET parking_status='$parking_status', booking_date='$booking_date', created_at='$created_at', clearing_date='$clearing_date', possession='$possession', possession_notes='$possession_notes', possession_update_date='$possession_update_date' where bookingid='$bookingid'");

    $Update = UPDATE("UPDATE bookings SET possession='$possession', possession_notes='$possession_notes', possession_update_date='$possession_update_date' where bookingid='$bookingid'");
    RESPONSE($Update, "Possession Details are updated!", "Unable to update Possession Details");

    //cancel bookings
} elseif (isset($_POST['CreateBookingCancellRequests'])) {

    //booking cancel details
    $bookings = array(
        "BookingCancelledBookingId" => SECURE($_POST['BookingCancelledBookingId'], "d"),
        "BookingCancelledDate" => $_POST['BookingCancelledDate'],
        "BookingCancelledReason" => SECURE($_POST['BookingCancelledReason'], "e"),
        "BookingCancelledCreatedAt" => RequestDataTypeDate,
        "BookingCancelledBy" => LOGIN_UserId
    );

    $SaveBookings = INSERT("booking_cancelled", $bookings);

    //refund details
    $refunds = array(
        "BookingRefundMainBookingId" => SECURE($_POST['BookingCancelledBookingId'], "d"),
        "BookingRefundReason" => SECURE($_POST['BookingRefundReason'], "d"),
        "BookingRefundDate" => $_POST['BookingRefundDate'],
        "BookingRefundTo" => $_POST['BookingRefundTo'],
        "BookingRefundMode" => $_POST['BookingRefundMode'],
        "BookingRefundDetails" => SECURE($_POST['BookingRefundDetails'], "d"),
        "BookingRefundStatus" => $_POST['BookingRefundStatus'],
        "BookingRefundCreatedAt" => RequestDataTypeDate,
        "BookingRefundUpdatedAt" => RequestDataTypeDate,
        "BookingRefundCreatedBy" => LOGIN_UserId,
        "BookingRefundAmount" => $_POST['BookingRefundAmount'],
    );
    $bookingid = SECURE($_POST['BookingCancelledBookingId'], "d");
    UPDATE("UPDATE bookings SET status='DELETED' where bookingid='$bookingid'");
    $SaveRefunds = INSERT("booking_refund", $refunds);
    RESPONSE($SaveRefunds, "Booking is Cancelled and Refund is " . $_POST['BookingRefundStatus'], "Unable to cancel bookings!");

    //delete booking cancel reports
} elseif (isset($_GET['delete_booking_cancel_record'])) {
    $access_url = SECURE($_GET['access_url'], "d");
    $delete_booking_cancel_record = SECURE($_GET['delete_booking_cancel_record'], "d");

    if ($delete_booking_cancel_record == true) {
        $control_id = SECURE($_GET['control_id'], "d");
        $delete = DELETE_FROM("booking_refund", "BookingRefundMainBookingId");
        $delete = DELETE_FROM("booking_cancelled", "BookingCancelledBookingId");
    } else {
        $delete = false;
    }

    RESPONSE($delete, "Booking Cancelled is remove, Now booking is Re-Continue!", "Unable to remove booking cancel status!");

    //delete bookings
} elseif (isset($_GET['delete_bookings_records'])) {
    $access_url = SECURE($_GET['access_url'], "d");
    $delete_bookings = SECURE($_GET['delete_bookings_records'], "d");

    if ($delete_bookings == true) {
        $control_id = SECURE($_GET['control_id'], "d");
        $DELETE = DELETE_FROM("bookings", "bookingid='$control_id'");
        $DELETE = DELETE_FROM("booking_alloties", "BookingAllotyMainBookingId='$control_id'");
        $DELETE = DELETE_FROM("booking_cancelled", "BookingCancelledBookingId='$control_id'");
        $DELETE = DELETE_FROM("booking_emis", "booking_id='$control_id'");
        $DELETE = DELETE_FROM("booking_refund", "BookingRefundMainBookingId='$control_id'");
        $DELETE = DELETE_FROM("commission", "booking_id='$control_id'");

        $payments = FetchConvertIntoArray("SELECT * FROM payments where bookingid='$bookingid'", true);
        if ($payments != null) {
            foreach ($payments as $payment) {
                $payment_id = $payment->payment_id;
                $payment_mode = $payment->payment_mode;

                if ($payment_mode == "cash") {
                    $DELETE = DELETE_FROM("cash_payments", "payment_id='$payment_id'");
                } else if ($payment_mode == "check") {
                    $DELETE = DELETE_FROM("check_payments", "payment_id='$payment_id'");
                } else {
                    $DELETE = DELETE_FROM("online_payments", "payment_id='$payment_id'");
                }
            }

            $DELETE = DELETE_FROM("payments", "payment_id='$payment_id'");
        }
        $unit_name = FETCH("SELECT * FROM bookings where bookingid='$control_id'", "unit_name");
        $update = UPDATE("UPDATE project_units SET project_unit_status='ACTIVE' where projects_unit_name='$unit_name'");
        $access_url = ADMIN_URL . "/booking/index.php";
    } else {
        $update = false;
    }
    RESPONSE($update, "Booking is Remove Succesfully!", "Unable to remove Booking at the moment!");

    //update booking details
} elseif (isset($_POST['UpdateBookingDetails'])) {
    $bookingid = SECURE($_POST['bookingid'], "d");
    $project_unit_id = $_POST['unit_name'];
    $PlotSql = "SELECT * FROM project_units where project_units_id='$project_unit_id'";
    $ProjectSql = "SELECT * FROM projects where Projects_id='" . FETCH($PlotSql, "project_id") . "'";
    $BookingSql = "SELECT * FROM bookings where bookingid='$bookingid'";

    $data = array(
        "customer_id" => $_POST['customer_id'],
        "partner_id" => $_POST['partner_id'],
        "project_list_id" => FETCH("SELECT * FROM projects where Projects_id='" . FETCH($PlotSql, "project_id") . "'", "Projects_id"),
        "project_name" => FETCH($ProjectSql, "project_title"),
        "project_area" => FETCH($ProjectSql, "project_area") . " " . FETCH($PlotSql, "project_unit_measurement_unit"),
        "unit_name" => FETCH($PlotSql, "projects_unit_name"),
        "unit_area" => FETCH($PlotSql, "project_unit_area") . " " . FETCH($PlotSql, "project_unit_measurement_unit"),
        "unit_rate" => FETCH($PlotSql, "unit_per_price"),
        "unit_cost" => FETCH($PlotSql, "project_unit_price"),
        "net_payable_amount" => FETCH($PlotSql, "project_unit_price"),
        "crn_no" => $_POST['crn_no'],
        "ref_no" => $_POST['ref_no'],
        "project_unit_id" => $project_unit_id
    );
    $Update = UPDATE("UPDATE users SET agent_relation='" . $_POST['partner_id'] . "' where id='" . $_POST['customer_id'] . "'");
    $Update = UPDATE_DATA("bookings", $data, "bookingid='$bookingid'", false);
    if ($Update == true) {
        $Update = UPDATE("UPDATE project_units SET project_unit_status='ACTIVE' where projects_unit_name like '%" . FETCH($PlotSql, "projects_unit_name") . "%'");
        $Update = UPDATE("UPDATE project_units SET project_unit_status='SOLD' where project_units_id='$project_unit_id'");
    } else {
        $Update = $Update;
    }
    RESPONSE($Update, "Booking Details Updated Succesfully!", "Unable to Update Booking Details at the moment!");

    //update alloty details
} elseif (isset($_POST['UpdateAllotyDetails'])) {
    $BookingAllotyMainBookingId = SECURE($_POST['BookingAllotyMainBookingId'], "d");

    $data = array(
        "BookingAllotyMainBookingId" => $BookingAllotyMainBookingId,
        "BookingAllotyFullName" => $_POST['BookingAllotyFullName'],
        "BookingAllotyPhoneNumber" => $_POST['BookingAllotyPhoneNumber'],
        "BookingAllotyEmail" => $_POST['BookingAllotyEmail'],
        "BookingAllotyStreetAddress" => $_POST['BookingAllotyStreetAddress'],
        "BookingAllotyArea" => $_POST['BookingAllotyArea'],
        "BookingAllotyCity" => $_POST['BookingAllotyCity'],
        "BookingAllotyState" => $_POST['BookingAllotyState'],
        "BookingAllotyPincode" => $_POST['BookingAllotyPincode'],
        "BookingAllotyCountry" => $_POST['BookingAllotyCountry'],
        "BookingAllotyRelation" => $_POST['BookingAllotyRelation'],
    );

    $Check = CHECK("SELECT * FROM booking_alloties WHERE BookingAllotyMainBookingId='$BookingAllotyMainBookingId'");
    if ($Check == null) {
        $Update = INSERT("booking_alloties", $data);
    } else {
        $Update = UPDATE_DATA("booking_alloties", $data, "BookingAllotyMainBookingId='$BookingAllotyMainBookingId'");
    }

    RESPONSE($Update, "Alloty Details Updated ", "Unable to update alloty details!");

    //save temp commissions
} elseif (isset($_POST['CreateAgentCommissionTemp'])) {

    if (!isset($_SESSION['TEMP_BOOKING_SESSION'])) {
        LOCATION("warning", "Booking Session Not Created!", ADMIN_URL . "/booking/new_booking.php");
    }


    //temp commsion id
    $BookingId_TEMP = $_SESSION['TEMP_BOOKING_SESSION'];

    //commison type and detais
    $commission_type = $_POST['commission_type'];
    if ($commission_type == "amount") {
        $commission_amount = $_POST['commission_amount'];
        $commission_rate_area = $_POST['commission_rate_area'];
        $commission_on_area = $_POST['commission_on_area'];
        $total_area = $_POST['total_unit_area'];
    } elseif ($commission_type == "area") {
        $commission_rate_area = $_POST['commission_rate_area'];
        $commission_on_area = $_POST['commission_on_area'];
        $total_area = $_POST['total_unit_area'];
        $commission_on_area = $_POST['commission_amount'];
    } else {
        $commission_percentage = $_POST['commission_percentage'];
        $total_area = $_POST['total_unit_area'];
        $commission_rate_area = $_POST['commission_rate_area'];
        $commission_on_area = $_POST['commission_on_area'];
    }
    $commission_remark = $_POST['commission_remark'];
    $commission_amount = $_POST['commission_amount'];
    $total_area = $_POST['total_unit_area'];
    $getareaa = GetNumbers($total_area);
    $commission_on_area = round((int)$commission_amount / (int)$getareaa);
    $commission_rate_area = round((int)$commission_amount / (int)$getareaa);

    $TempCommissionSessionId = $BookingId_TEMP;
    $partner_id = SECURE($_POST['partner_id'], "d");

    $data = array(
        "TempCommissionSessionId" => $TempCommissionSessionId,
        "partner_id" => SECURE($_POST['partner_id'], "d"),
        "commission_remark" => $_POST['commission_remark'],
        "commission_type" => $_POST['commission_type'],
        "commission_amount" => $commission_amount,
        "commission_percentage" => $_POST['commission_percentage'],
        "commission_rate_area" => $_POST['commission_rate_area'],
        "commission_on_area" => $commission_on_area,
        "total_area" => $_POST['total_unit_area'],
        "created_at" => RequestDataTypeDate
    );

    $Check = CHECK("SELECT * FROM commission_temps where TempCommissionSessionId='$BookingId_TEMP' and partner_id='$partner_id'");
    if ($Check == false) {
        $save = INSERT("commission_temps", $data);
        $err = "Unable to save Commission details into the session!";
    } else {
        $save = false;
        $err = "Commission Already Distributed to selected user!";
    }
    RESPONSE($save, "Commission Details Saved into Session!", "$err");

    //remove commission

} elseif (isset($_GET['delete_temp_commission_record'])) {
    $access_url = SECURE($_GET['access_url'], "d");
    $delete_temp_commission_record = SECURE($_GET['delete_temp_commission_record'], "d");

    if ($delete_temp_commission_record == true) {
        $control_id = SECURE($_GET['control_id'], "d");
        $DELETE = DELETE_FROM("commission_temps", "TempCommissionId='$control_id'");
    } else {
        $DELETE = false;
    }
    RESPONSE($DELETE, "Booking Commission Removed Succesfully!", "Unable to remove booking commission");

    //save commission
} elseif (isset($_POST['CreateCommission'])) {
    //commison type and detais
    $commission_type = $_POST['commission_type'];
    if ($commission_type == "amount") {
        $commission_amount = $_POST['commission_amount'];
        $commission_rate_area = $_POST['commission_rate_area'];
        $commission_on_area = $_POST['commission_on_area'];
        $total_area = $_POST['total_unit_area'];
    } elseif ($commission_type == "area") {
        $commission_rate_area = $_POST['commission_rate_area'];
        $commission_on_area = $_POST['commission_on_area'];
        $total_area = $_POST['total_unit_area'];
        $commission_on_area = $_POST['commission_amount'];
    } else {
        $commission_percentage = $_POST['commission_percentage'];
        $total_area = $_POST['total_unit_area'];
        $commission_rate_area = $_POST['commission_rate_area'];
        $commission_on_area = $_POST['commission_on_area'];
    }
    $commission_remark = $_POST['commission_remark'];
    $commission_amount = $_POST['commission_amount'];
    $total_area = $_POST['total_unit_area'];
    $commission_on_area = round((int)$commission_amount / (int)$total_area);
    $getareaa = GetNumbers($total_area);
    $commission_rate_area = round((int)$commission_amount / (int)$getareaa);

    $booking_id = SECURE($_POST['booking_id'], "d");
    $partner_id = SECURE($_POST['partner_id'], "d");

    $data = array(
        "booking_id" => $booking_id,
        "partner_id" => SECURE($_POST['partner_id'], "d"),
        "commission_remark" => $_POST['commission_remark'],
        "commission_type" => $_POST['commission_type'],
        "commission_amount" => $commission_amount,
        "commission_percentage" => $_POST['commission_percentage'],
        "commission_rate_area" => $commission_rate_area,
        "commission_on_area" => $commission_on_area,
        "total_area" => $_POST['total_unit_area'],
        "created_at" => RequestDataTypeDate
    );


    $save = INSERT("commission", $data);
    $err = "Unable to save Commission details into the session!";

    RESPONSE($save, "Commission Details Saved into Session!", "$err");

    //delete commission
} elseif (isset($_GET['delete_commission_record'])) {
    $access_url = SECURE($_GET['access_url'], "d");
    $delete_commission_record = SECURE($_GET['delete_commission_record'], "d");

    if ($delete_commission_record == true) {
        $control_id = SECURE($_GET['control_id'], "d");
        $DELETE = DELETE_FROM("commission", "commission_id='$control_id'", false);
    } else {
        $DELETE = false;
    }
    RESPONSE($DELETE, "Booking Commission Removed Succesfully!", "Unable to remove booking commission");

    //update commission
} elseif (isset($_POST['UpdateCommission'])) {

    $commission_id = SECURE($_POST['commission_id'], "d");
    $booking_id = SECURE($_POST['booking_id'], "d");
    $partner_id = SECURE($_POST['partner_id'], "d");

    //commison type and detais
    $commission_type = $_POST['commission_type'];
    if ($commission_type == "amount") {
        $commission_amount = $_POST['commission_amount'];
        $commission_rate_area = $_POST['commission_rate_area'];
        $commission_on_area = $_POST['total_unit_area'];
        $total_area = $_POST['total_unit_area'];
    } elseif ($commission_type == "area") {
        $commission_rate_area = $_POST['commission_rate_area'];
        $commission_on_area = $_POST['total_unit_area'];
        $total_area = $_POST['total_unit_area'];
        $commission_on_area = $_POST['commission_amount'];
    } else {
        $commission_percentage = $_POST['commission_percentage'];
        $total_area = $_POST['total_unit_area'];
        $commission_rate_area = $_POST['commission_rate_area'];
        $commission_on_area = $_POST['total_unit_area'];
    }

    $total_area = $_POST['total_unit_area'];
    $commission_remark = $_POST['commission_remark'];
    $commission_amount = $_POST['commission_amount'];
    $total_area = $_POST['total_unit_area'];
    $commission_on_area = round((int)$commission_amount / (int)$total_area);
    $getareaa = GetNumbers($total_area);
    $project_unit_id = FETCH("SELECT * FROM bookings where bookingid='" . $booking_id . "'", "project_unit_id");
    $Area = FETCH("SELECT * FROM project_units where project_units_id='$project_unit_id'", "project_unit_area");
    $commission_rate_area = round((int)$commission_amount / (int)$Area, 2);

    $data = array(
        "booking_id" => $booking_id,
        "partner_id" => SECURE($_POST['partner_id'], "d"),
        "commission_remark" => $_POST['commission_remark'],
        "commission_type" => $_POST['commission_type'],
        "commission_amount" => $commission_amount,
        "commission_percentage" => $_POST['commission_percentage'],
        "commission_rate_area" => $commission_rate_area,
        "commission_on_area" => $commission_on_area,
        "total_area" => $_POST['total_unit_area'],
    );

    $save = UPDATE_DATA("commission", $data, "commission_id='$commission_id'");
    $err = "Unable to save Commission details into the session!";

    RESPONSE($save, "Commission Details Saved into Session!", "$err");

    //remove co-allotee details
} elseif (isset($_GET['remove_co_allotee_details'])) {
    $access_url = SECURE($_GET['access_url'], "d");
    $remove_co_allotee_details = SECURE($_GET['remove_co_allotee_details'], "d");

    if ($remove_co_allotee_details == true) {
        $control_id = SECURE($_GET['control_id'], "d");
        $DELETE = DELETE_FROM("booking_alloties", "BookingAllotyId='$control_id'", false);
    } else {
        $DELETE = false;
    }
    RESPONSE($DELETE, "Booking Co-Allotee Removed Succesfully!", "Unable to remove booking co-allotee");

    //upload co-allotee documents
} else if (isset($_POST['UploadCoAlloteeDocuments'])) {
    $BookingAlloteeMainId = SECURE($_POST['BookingAlloteeMainId'], "d");
    $data = array(
        "BookingAlloteeMainId" => $BookingAlloteeMainId,
        "BookingAlloteeDocName" => $_POST['BookingAlloteeDocName'],
        "BookingAlloteeDocNumber" => $_POST['BookingAlloteeDocNumber'],
        "BookingAlloteeDocFile" => UPLOAD_FILES("../storage/bookings/$BookingAlloteeMainId/co-allotee", "NULL", $_POST['BookingAlloteeDocName'], $_POST['BookingAlloteeDocNumber'], "BookingAlloteeDocFile"),
    );
    $SAVE = INSERT("booking_alloty_documents", $data);
    RESPONSE($SAVE, "Booking Co-Allotee Documents are uploaded successfully!", "Unable to upload booking co-allotee documents at the moment!");

    //else remove co-allotee documents
} elseif (isset($_GET['remove_allotee_documents'])) {
    $access_url = SECURE($_GET['access_url'], "d");
    $remove_allotee_documents = SECURE($_GET['remove_allotee_documents'], "d");

    if ($remove_allotee_documents == true) {
        $control_id = SECURE($_GET['control_id'], "d");
        $DELETE = DELETE_FROM("booking_alloty_documents", "BookingAlloteeDocId='$control_id'", false);
    } else {
        $DELETE =  false;
    }
    RESPONSE($DELETE, "Booking Co-Allotee Documents Removed Succesfully!", "Unable to remove Co-Allotee Documents");

    // generate demand letters
} else if (isset($_POST['GenerateDemandLetter'])) {
    $PhonerNumber = SECURE($_POST['PhoneNumber'], "d");
    $EmailId = SECURE($_POST['EmailId'], "d");
    $Name = SECURE($_POST['Name'], "d");
    $PayReqBookingId = SECURE($_POST['PayReqBookingId'], "d");
    $duedate = DATE_FORMATE2("d M, Y", $_POST['PayRequestDueDate']);
    $PlotNo = FETCH("SELECT * FROM bookings where bookingid='$PayReqBookingId'", "unit_name");
    $PlotNo = "B$PayReqBookingId or Plot No:$PlotNo in Yash Vihar";


    $data = array(
        "PayReqBookingId" => $PayReqBookingId,
        "PayReqDate" => $_POST['PayReqDate'],
        "PayRequestingAmount" => $_POST['PayRequestingAmount'],
        "PayRequestDueDate" => $_POST['PayRequestDueDate'],
        "PayRequestDescriptions" => $_POST['PayRequestDescriptions'],
        "PayRequestSendBy" => LOGIN_UserId,
        "PayReqSendDate" => RequestDataTypeDate,
        "PayReqSendDescsriptions" => $_POST['PayReqSendDescsriptions'],
        "PayReqType" => SECURE($_POST['PayReqType'], "d")
    );

    $SAVE = INSERT("booking_pay_req", $data);
    $dmdid = FETCH("SELECT * FROM booking_pay_req ORDER BY PaymentRequestId DESC", "PaymentRequestId");

    $bookingid = $PayReqBookingId;
    $BookingSql = "SELECT * FROM bookings where bookingid='$bookingid'";
    $customer_id = FETCH($BookingSql, "customer_id");
    $partner_id = FETCH($BookingSql, "partner_id");
    $CoAllotySql = "SELECT * FROM booking_alloties where BookingAllotyMainBookingId='$bookingid' and BookingAllotyFullName!=''";
    $CustomerSql = "SELECT * FROM users where id='$customer_id'";
    $PartnerSql = "SELECT * FROM users where id='$partner_id'";
    $CustomerAddress = "SELECT * FROM user_address where user_id='$customer_id'";
    $PartnerAddress = "SELECT * FROM user_address where user_id='$partner_id'";
    $DMDSql = "SELECT * FROM booking_pay_req where PaymentRequestId='$dmdid'";

    //other variables
    $area = FETCH($BookingSql, "unit_area");
    $areaint = GetNumbers($area);

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
        } else if ($payment_mode == "banking") {
            $SELECT_online_payments = SELECT("SELECT * FROM online_payments where payment_id='$payment_id'");
            $online_payments = mysqli_fetch_array($SELECT_online_payments);
            $txnid = $online_payments['online_payments_id'];
            $OnlineBankName = $online_payments['OnlineBankName'];
            $transactionId = $online_payments['transactionId'];
            $payment_details = $online_payments['payment_details'];
            $payment_mode = $online_payments['payment_mode'];
            $payment_status = $online_payments['transaction_status'];
            $payment_note = "<br>by Online Banking : Bank Name:$OnlineBankName, TxnId: $transactionId, Details: $payment_details, Status: $payment_status";
        } else if ($payment_mode == "cash") {
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
    $net = $net_paid_amount2;
    $Percentage = round(FETCH($DMDSql, "PayRequestingAmount") / (FETCH($BookingSql, "net_payable_amount")) * 100, 2);
    $current = round(FETCH($BookingSql, "net_payable_amount") / 100 * $Percentage, 2);
    $currentdue = $current - $net;


    if (isset($_POST['sms']) == "true") {
        /** http://sms.tddigitalsolution.com/http-tokenkeyapi.php?authentic-key=383153414348494e3139393432301663417896&senderid=KSDBLD&route=1&number=8447572565&message=Dear {#var#}, Your payment of {#var#} for booking id {#var#} is payable/pending. Please clear the payment before {#var#}. Thanks {#var#} KSD BUILDTECH&templateid=1507166341523094529 */
        SMS(
            "383153414348494e3139393432301663417896",
            "KSDBLD",
            "1",
            "$PhonerNumber",
            "Dear $Name, Your payment of Rs." . number_format($currentdue) . " for booking id $PlotNo is payable/pending. Please clear the payment before $duedate. Thanks " . "-" . " KSD BUILDTECH",
            "1507166341523094529",
            "GET"
        );
    }
    if (isset($_POST['email']) == "true") {
        SENDMAILS(
            "Demand letter Shared!",
            "Dear $Name",
            "$EmailId",
            "Your payment of Rs." . $currentdue . " for booking id B$PayReqBookingId is payable/pending. Please clear the payment before $duedate. Thanks " . company_name . " KSD BUILDTECH<br><br><br>
        <a href='" . DOMAIN . "/admin/booking/docs/dmd-l.php?id=$PayReqBookingId&dmdid=dmdid'>View Demand letter</a>
        ",
        );
    }
    RESPONSE($SAVE, "Demand letter Generated", "Unable to generate demand letter at the moment!");

    //remove demand letters
} elseif (isset($_GET['remove_demand_letters'])) {
    $access_url = SECURE($_GET['access_url'], "d");
    $remove_demand_letters = SECURE($_GET['remove_demand_letters'], "d");

    if ($remove_demand_letters == true) {
        $control_id = SECURE($_GET['control_id'], "d");
        $DELETE = DELETE_FROM("booking_pay_req", "PaymentRequestId='$control_id'", false);
    } else {
        $DELETE =  false;
    }
    RESPONSE($DELETE, "Demand letter Removed Succesfully!", "Unable to remove demand letters");


    //update bank load details
} elseif (isset($_POST['booking_bank_name'])) {
    $booking_main_id = SECURE($_POST['booking_main_id'], "d");

    //save bank loan details
    $booking_loans = [
        "booking_main_id" => $booking_main_id,
        "booking_bank_name" => $_POST['booking_bank_name'],
        "booking_santion_amount" => $_POST['booking_santion_amount'],
        "booking_receive_amount" => $_POST['booking_receive_amount'],
        "booking_loan_notes" => SECURE($_POST['booking_loan_notes'], "e"),
        "booking_loan_created_at" => date("Y-m-d"),
        "booking_loan_updated_at" => date("Y-m-d"),
        "booking_bank_ifsc_code" => $_POST['booking_bank_ifsc_code']
    ];
    $CheckBankLoad = CHECK("SELECT * FROM booking_loans where booking_main_id='$booking_main_id'");
    if ($CheckBankLoad == null) {
        $Save = INSERT("booking_loans", $booking_loans);
    } else {
        $Save = UPDATE_DATA("booking_loans", $booking_loans, "booking_main_id='$booking_main_id'");
    }
    RESPONSE($Save, "Bank Load Details are updated successfully!", "Unable to update bank loan details!");
}

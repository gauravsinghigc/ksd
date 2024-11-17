<?php
require '../require/modules.php';
require "../require/admin/sessionvariables.php";
require '../include/admin/common.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard | <?php echo company_name; ?></title>
    <?php include '../include/header_files.php'; ?>
</head>

<body>
    <div id="container" class="navbar-fixed mainnav-fixed mainnav-lg">
        <?php include 'header.php'; ?>

        <!-- main content area -->
        <div class="boxed">
            <!--CONTENT CONTAINER-->
            <!--===================================================-->
            <div id="content-container">
                <!--Page content-->
                <div id="page-content">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-12">
                            <div class="panel square">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 class="m-t-3"><i class="fa fa-home app-text"></i> Dashboard</h>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-12 col-xs-6 col-sm-6 m-b-15">
                                            <div class="p-1r shadow-lg p-t-20 panel-bdr">
                                                <div class="header">
                                                    <h2 class="count"><?php echo TOTAL("SELECT * FROM projects where company_id='" . company_id . "'"); ?></h2>
                                                    <h5 class="m-t-0">Total Projects</h5>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-12 col-sm-12 m-b-15">
                                            <div class="p-1r shadow-lg p-t-20 panel-bdr">
                                                <div class="header">
                                                    <h2 class="count"><?php echo TOTAL("SELECT * FROM project_units, projects where project_units.project_id=projects.Projects_id and projects.company_id='" . company_id . "'"); ?></h1>
                                                        <div class="flex-s-b">
                                                            <h5 class="m-t-0">Total Plots</h5>
                                                            <h5 class="m-t-0">
                                                                <span> <span>Sold : <span class="text-success">
                                                                            <?php echo TOTAL("SELECT * FROM project_units, projects where project_units.project_id=projects.Projects_id and project_units.project_unit_status='SOLD' and projects.company_id='" . company_id . "'"); ?>
                                                                        </span></span></span> |
                                                                <span> <span>Unsold :
                                                                        <span class="text-danger">
                                                                            <?php echo TOTAL("SELECT * FROM project_units, projects where project_units.project_id=projects.Projects_id and project_units.project_unit_status='ACTIVE' and projects.company_id='" . company_id . "'"); ?>
                                                                        </span>
                                                                    </span> </span>
                                                            </h5>
                                                        </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-12 col-sm-12 m-b-15">
                                            <div class="p-1r shadow-lg p-t-20 panel-bdr">
                                                <div class="header">
                                                    <h2 class="count"><?php echo TOTAL("SELECT * FROM users where company_relation='" . company_id . "' and user_role_id='4'"); ?></h2>
                                                    <h5 class="m-t-0">Total Customers</h5>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-lg-3 col-md-3 col-12 col-sm-12 m-b-15">
                                            <div class="p-1r shadow-lg p-t-20 panel-bdr">
                                                <div class="header">
                                                    <h2 class="count"><?php echo TOTAL("SELECT * FROM users where company_relation='" . company_id . "' and user_role_id='3'"); ?></h2>
                                                    <h5 class="m-t-0">Total Agents</h5>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-lg-3 col-md-3 col-12 col-sm-12 m-b-15">
                                            <div class="p-1r shadow-lg p-t-20 panel-bdr">
                                                <div class="header">
                                                    <h2 class="count"><?php echo TOTAL("SELECT * FROM bookings where company_id='" . company_id . "'"); ?></h2>
                                                    <span class="flex-s-b">
                                                        <h5 class="m-t-0">Total Bookings</h5>
                                                        <h5 class="m-t-0">Today : <?php echo TOTAL("SELECT * FROM bookings where company_id='" . company_id . "' and created_at='" . date("d M, Y") . "'"); ?></h5>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-12 col-sm-12 m-b-15">
                                            <div class="p-1r shadow-lg p-t-20 panel-bdr">
                                                <div class="header">
                                                    <h2>
                                                        <i class="fa fa-inr text-success"></i>
                                                        <span class="count">
                                                            <?php
                                                            $TotalAmountPaid = SELECT("SELECT sum(net_payable_amount) FROM payments, bookings where bookings.bookingid=payments.bookingid and bookings.company_id='" . company_id . "'");
                                                            while ($fetchtotalpayment = mysqli_fetch_array($TotalAmountPaid)) {
                                                                $PaymentforProjects = $fetchtotalpayment['sum(net_payable_amount)'];
                                                            }
                                                            echo $TotalreceivableAmount = $PaymentforProjects; ?>
                                                        </span>
                                                        </h1>
                                                        <h5>Amount Receivable</h5>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-12 col-sm-12 m-b-15">
                                            <div class="p-1r shadow-lg p-t-20 panel-bdr">
                                                <div class="header">
                                                    <h2>
                                                        <i class="fa fa-inr text-success"></i>
                                                        <span class="count">
                                                            <?php
                                                            $TotalAmountPaid = SELECT("SELECT sum(cashamount) FROM payments, bookings, cash_payments where bookings.bookingid=payments.bookingid and bookings.company_id='" . company_id . "'  and payments.payment_id=cash_payments.payment_id");
                                                            while ($fetchtotalpayment = mysqli_fetch_array($TotalAmountPaid)) {
                                                                $cashamount = $fetchtotalpayment['sum(cashamount)'];
                                                            }
                                                            if ($cashamount == null) {
                                                                $cashamount = 0;
                                                            } else {
                                                                $cashamount = $cashamount;
                                                            } ?>

                                                            <?php
                                                            $TotalAmountPaid = SELECT("SELECT sum(checkamount) FROM payments, bookings, check_payments where bookings.bookingid=payments.bookingid and bookings.company_id='" . company_id . "' and payments.payment_id=check_payments.payment_id");
                                                            while ($fetchtotalpayment = mysqli_fetch_array($TotalAmountPaid)) {
                                                                $checkamount = $fetchtotalpayment['sum(checkamount)'];
                                                            }
                                                            if ($checkamount == null) {
                                                                $checkamount = 0;
                                                            } else {
                                                                $checkamount = $checkamount;
                                                            } ?>


                                                            <?php
                                                            $TotalAmountPaid = SELECT("SELECT sum(onlinepaidamount) FROM payments, bookings, online_payments where bookings.bookingid=payments.bookingid and bookings.company_id='" . company_id . "' and payments.payment_id=online_payments.payment_id");
                                                            while ($fetchtotalpayment = mysqli_fetch_array($TotalAmountPaid)) {
                                                                $onlinepaidamount = $fetchtotalpayment['sum(onlinepaidamount)'];
                                                            }
                                                            if ($onlinepaidamount == null) {
                                                                $onlinepaidamount = 0;
                                                            } else {
                                                                $onlinepaidamount = $onlinepaidamount;
                                                            }
                                                            echo $TotalReceivedAmount = $cashamount + $checkamount + $onlinepaidamount; ?>
                                                        </span>
                                                    </h2>
                                                    <span class="flex-s-b">
                                                        <h5 class="m-t-0">Amount Received!</h5>
                                                        <h5 class="m-t-0">Today : <i class="fa fa-inr text-success"></i>
                                                            <span class="count">
                                                                <?php
                                                                $TodayPaymentCollections = SELECT("SELECT sum(payment_amount) from payments where created_at='" . date('d M, Y') . "'");
                                                                while ($TodayCollections = mysqli_fetch_array($TodayPaymentCollections)) {
                                                                    $TodayPayment = $TodayCollections['sum(payment_amount)'];
                                                                }
                                                                if ($TodayPayment == null) {
                                                                    $TodayPayment = 0;
                                                                } else {
                                                                    $TodayPayment = $TodayPayment;
                                                                }
                                                                echo $TodayPayment; ?>
                                                            </span>
                                                        </h5>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-lg-3 col-md-3 col-12 col-sm-12 m-b-15">
                                            <div class="p-1r shadow-lg p-t-20 panel-bdr">
                                                <div class="header">
                                                    <h2>
                                                        <i class="fa fa-inr text-success"></i>
                                                        <span class="count">
                                                            <?php
                                                            echo (int)$TotalreceivableAmount - (int)$TotalReceivedAmount; ?>
                                                        </span>
                                                    </h2>
                                                    <h5>Balance Amount</h5>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-12 col-sm-12 m-b-15">
                                            <div class="p-1r shadow-lg p-t-20 panel-bdr">
                                                <div class="header">
                                                    <h2>
                                                        <i class="fa fa-inr text-success"></i>
                                                        <span class="count">
                                                            <?php
                                                            $TotalAmountPaid = SELECT("SELECT sum(expanse_amount) FROM expanses");
                                                            while ($fetchtotalpayment = mysqli_fetch_array($TotalAmountPaid)) {
                                                                $expanse_amount = $fetchtotalpayment['sum(expanse_amount)'];
                                                            }
                                                            echo $expanse_amount;
                                                            ?>
                                                        </span>
                                                    </h2>
                                                    <h5>Expanses</h5>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-12 col-sm-12 m-b-15">
                                            <div class="p-1r shadow-lg p-t-20 panel-bdr">
                                                <div class="header">
                                                    <h2>
                                                        <i class="fa fa-inr text-success"></i>
                                                        <span class="count">
                                                            <?php
                                                            $Totalcommission = SELECT("SELECT sum(commission_amount) from commission");
                                                            while ($Commission = mysqli_fetch_array($Totalcommission)) {
                                                                $CommissionAmount = $Commission['sum(commission_amount)'];
                                                            }
                                                            if ($CommissionAmount == null) {
                                                                $CommissionAmount = 0;
                                                            } else {
                                                                $CommissionAmount = $CommissionAmount;
                                                            }
                                                            echo $CommissionAmount; ?>
                                                        </span>
                                                    </h2>
                                                    <h5>Commission Amount</h5>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-12 col-sm-12 m-b-15">
                                            <div class="p-1r shadow-lg p-t-20 panel-bdr">
                                                <div class="header">
                                                    <h2>
                                                        <i class="fa fa-inr text-success"></i>
                                                        <span class="count">
                                                            <?php
                                                            $Totalcommissionpaid = SELECT("SELECT sum(commission_payout_amount) from commission_payouts");
                                                            while ($Commissionpaid = mysqli_fetch_array($Totalcommissionpaid)) {
                                                                $CommissionAmountpaid = $Commissionpaid['sum(commission_payout_amount)'];
                                                            }
                                                            if ($CommissionAmountpaid == null) {
                                                                $CommissionAmountpaid = 0;
                                                            } else {
                                                                $CommissionAmountpaid = $CommissionAmountpaid;
                                                            }
                                                            echo $CommissionAmountpaid; ?>
                                                        </span>
                                                    </h2>
                                                    <h5>Commission Paid</h5>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-12 col-sm-12 m-b-15">
                                            <div class="p-1r shadow-lg p-t-20 panel-bdr">
                                                <div class="header">
                                                    <h2>
                                                        <i class="fa fa-inr text-success"></i>
                                                        <span class="count">
                                                            <?php echo (int)$CommissionAmount - (int)$CommissionAmountpaid; ?>
                                                        </span>
                                                    </h2>
                                                    <h5>Commission Balance</h5>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 data-display">
                                            <div class="rounded-2">
                                                <h4 class="section-heading">Today Calls</h4>
                                                <ul class="calling-list">
                                                    <?php
                                                    $CurrentData = date("Y-m-d");
                                                    $FetchCalls = FetchConvertIntoArray("SELECT * FROM leads_calls where DATE(LeadCallingReminderDate)<='$CurrentData' and LeadCallStatus='FollowUp' ORDER BY LeadCallId DESC", true);
                                                    if ($FetchCalls != null) {
                                                        foreach ($FetchCalls as $Calls) { ?>
                                                            <li>
                                                                <span><?php echo Reminder(); ?></span>
                                                                <p>
                                                                    <span><b><?php echo DATE_FORMATE2("d M, Y", $Calls->LeadCallingReminderDate); ?> <?php echo DATE_FORMATE2("d:m A", $Calls->LeadCallingReminderTime); ?></b></span><br>
                                                                    <span><?php echo html_entity_decode(SECURE($Calls->LeadCallRemindNotes, "d")); ?></span><br>
                                                                    <span class="text-grey">By <?php echo FETCH("SELECT * FROM users where id='" . $Calls->CallCreatedBy . "'", "name"); ?></span>
                                                                    <a href="#update_call_reminder_<?php echo $Calls->LeadCallId; ?>" class="btn btn-xs btn-primary pull-right mt-2" data-toggle="modal" class="pull-right btn btn-sm btn btn-primary"><i class="fa fa-edit"></i> Update Call</a>
                                                                </p>
                                                            </li>
                                                            <!-- #modal-dialog -->
                                                            <div class="modal fade" id="update_call_reminder_<?php echo $Calls->LeadCallId; ?>">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header section-heading">
                                                                            <h4 class="modal-title">Update Call Reminder Details</h4>
                                                                        </div>
                                                                        <form action="<?php echo CONTROLLER; ?>/leads.php" method="POST">
                                                                            <?php FormPrimaryInputs(true, [
                                                                                "LeadMainid" => $Calls->LeadMainId,
                                                                                "LeadCallId" => $Calls->LeadCallId
                                                                            ]);  ?>
                                                                            <div class="modal-body">
                                                                                <div class="row">
                                                                                    <div class="form-group col-md-4">
                                                                                        <label>Call Type</label>
                                                                                        <select name="LeadCallType" onchange="CheckCallStatus_<?php echo $Calls->LeadCallId; ?>()" id="call_status_<?php echo $Calls->LeadCallId; ?>" class="form-control">
                                                                                            <option value="Incoming">Incoming</option>
                                                                                            <option value="Outgoing">Outgoing</option>
                                                                                            <option value="Reschedule">Re-Schedule</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div id="call_records_<?php echo $Calls->LeadCallId; ?>">
                                                                                    <div class="row">
                                                                                        <div class="form-group col-md-4">
                                                                                            <label>Call Date</label>
                                                                                            <input type="date" name="LeadCallingDate" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                                                                        </div>

                                                                                        <div class="form-group col-md-4">
                                                                                            <label>Call Time</label>
                                                                                            <input type="time" name="LeadCallingTime" class="form-control" value="<?php echo date('h:m'); ?>">
                                                                                        </div>

                                                                                        <div class="form-group col-md-4">
                                                                                            <label>Call Status</label>
                                                                                            <select name="LeadCallStatus" class="form-control" id="call_status_type_<?php echo $Calls->LeadCallId; ?>">
                                                                                                <?php InputOptions(CALL_STATUS); ?>
                                                                                            </select>
                                                                                        </div>

                                                                                        <div class="col-md-12">
                                                                                            <label>Call Notes/Remarks</label>
                                                                                            <textarea class="form-control" name="LeadCallNotes" rows="5"></textarea>
                                                                                        </div>
                                                                                        <div class="form-group col-md-6">
                                                                                            <label>Calling By</label>
                                                                                            <select class="form-control" name="CallCreatedBy">
                                                                                                <?php
                                                                                                $Users = FetchConvertIntoArray("SELECT * FROM users ORDER BY name ASC", true);
                                                                                                foreach ($Users as $User) {
                                                                                                    if ($User->id == LOGIN_UserId) {
                                                                                                        $selected = "selected";
                                                                                                    } else {
                                                                                                        $selected = "";
                                                                                                    }
                                                                                                    echo "<option value='" . $User->id . "' $selected>" . $User->name . " @ " . $User->phone . "</option>";
                                                                                                }
                                                                                                ?>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div style="display:none;" id="reschedule_<?php echo $Calls->LeadCallId; ?>">
                                                                                    <div class="row">
                                                                                        <div class="col-md-4">
                                                                                            <label>Call Reminding Date</label>
                                                                                            <input type="date" name="LeadCallingReminderDate" class="form-control" value="<?php echo date("Y-m-d", strtotime("+1 days")); ?>">
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <label>Call Reminding Time</label>
                                                                                            <input type="time" name="LeadCallingReminderTime" class="form-control" value="<?php echo date("h:m", strtotime("+1 days")); ?>">
                                                                                        </div>
                                                                                        <div class="col-md-12">
                                                                                            <label>Remind Notes</label>
                                                                                            <textarea class="form-control" name="LeadCallRemindNotes" row="3"></textarea>
                                                                                        </div>
                                                                                        <div class="form-group col-md-6">
                                                                                            <label>Calling By</label>
                                                                                            <select class="form-control" name="CallCreatedBy">
                                                                                                <?php
                                                                                                $Users = FetchConvertIntoArray("SELECT * FROM users ORDER BY name ASC", true);
                                                                                                foreach ($Users as $User) {
                                                                                                    if ($User->id == LOGIN_UserId) {
                                                                                                        $selected = "selected";
                                                                                                    } else {
                                                                                                        $selected = "";
                                                                                                    }
                                                                                                    echo "<option value='" . $User->id . "' $selected>" . $User->name . " @ " . $User->phone . "</option>";
                                                                                                }
                                                                                                ?>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button class="btn btn-success mt-0 mb-0" name="UpdateCallReminderDetails" value="<?php echo SECURE($Calls->LeadCallId, "e"); ?>" type="Submit">Update Call Record</button>
                                                                                <button href="javascript:;" type="button" class="btn btn-white mt-0 mb-0" data-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <script>
                                                                function CheckCallStatus_<?php echo $Calls->LeadCallId; ?>() {
                                                                    var call_status_<?php echo $Calls->LeadCallId; ?> = document.getElementById("call_status_<?php echo $Calls->LeadCallId; ?>");
                                                                    var call_records_<?php echo $Calls->LeadCallId; ?> = document.getElementById("call_records_<?php echo $Calls->LeadCallId; ?>");
                                                                    var reschedule_<?php echo $Calls->LeadCallId; ?> = document.getElementById("reschedule_<?php echo $Calls->LeadCallId; ?>");
                                                                    var call_status_type_<?php echo $Calls->LeadCallId; ?> = document.getElementById("call_status_type_<?php echo $Calls->LeadCallId; ?>");

                                                                    if (call_status_<?php echo $Calls->LeadCallId; ?>.value == "Reschedule") {
                                                                        call_records_<?php echo $Calls->LeadCallId; ?>.style.display = "none";
                                                                        reschedule_<?php echo $Calls->LeadCallId; ?>.style.display = "block";
                                                                    } else {
                                                                        call_records_<?php echo $Calls->LeadCallId; ?>.style.display = "block";
                                                                        reschedule_<?php echo $Calls->LeadCallId; ?>.style.display = "none";
                                                                    }
                                                                }
                                                            </script>
                                                    <?php }
                                                    } ?>

                                                </ul>
                                            </div>
                                            <a href="<?php echo DOMAIN; ?>/admin/leads/calls/" class="btn btn-sm btn-primary pull-right">View All Calls <i class="fa fa-angle-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- end -->
        <?php include 'sidebar.php'; ?>
        <?php include 'footer.php'; ?>
    </div>

    <?php include '../include/footer_files.php'; ?>
</body>

</html>
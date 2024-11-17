<?php
$Dir = "../../..";
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';
//pagevariables
$PageName = "All Calls";
$PageDescription = "Manage all Calls";
$btntext = "Add New Domain";
$DomainExpireInCurrentMonth = date("Y-m-d", strtotime("+1 month"));
$CurrentData = date("Y-m-d");


if (isset($_GET['search'])) {
  $search = $_GET['search'];
  $_SESSION['search'] = $search;
} elseif (isset($_SESSION['search'])) {
  $search = $_SESSION['search'];
} else {
  $search = "";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title><?php echo $PageName; ?> | <?php echo APP_NAME; ?></title>
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
  <meta name="keywords" content="<?php echo APP_NAME; ?>">
  <meta name="description" content="<?php echo SHORT_DESCRIPTION; ?>">
  <?php include '../../../include/header_files.php'; ?>
  <script type="text/javascript">
    function SidebarActive() {
      document.getElementById("leads").classList.add("active");
      document.getElementById("all_calls").classList.add("active");
    }
    window.onload = SidebarActive;
  </script>
</head>

<body class='pace-top'>
  <div id="container" class="navbar-fixed mainnav-fixed mainnav-lg">
    <?php include '../../header.php'; ?>

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
                      <h3 class="m-t-3"><i class="fa fa-phone app-text"></i> <?php echo $PageName; ?>
                      </h3>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-8">
                      <div class="mb-3 d-sm-flex fw-bold p-1">
                        <div class="mt-sm-0">
                          <a href="../add.php" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> New Leads</a>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 text-center">
                      <form action="" method="GET">
                        <div class="form-group">
                          <input type="text" name="search" value="<?php echo $search; ?>" list="DomainName" onchange="form.submit()" class="form-control" placeholder="Search call record...">
                        </div>
                      </form>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-4">
                      <div class="rounded-2">
                        <h4 class="app-heading bg-success p-2">All Latest Call Records</h4>
                        <div class="row">
                          <div class="col-md-6 col-xs-6 col-6 mb-5px">
                            <div class="car card-body border-1 rounded-2 shadow-sm">
                              <h2 class="count text-success mb-0"><?php echo TOTAL("SELECT * FROM leads_calls where LeadCallType='Incoming'"); ?></h2>
                              <p class="mb-0">Incoming Calls</p>
                            </div>
                          </div>
                          <div class="col-md-6 col-xs-6 col-6 mb-5px">
                            <div class="car card-body border-1 rounded-2 shadow-sm">
                              <h2 class="count text-danger mb-0"><?php echo TOTAL("SELECT * FROM leads_calls where LeadCallType='Outgoing'"); ?></h2>
                              <p class="mb-0">Outgoing Calls</p>
                            </div>
                          </div>
                        </div>
                        <ul class="calling-list">
                          <?php
                          $FetchCalls = FetchConvertIntoArray("SELECT * FROM leads_calls where LeadCallStatus!='FollowUp' ORDER BY LeadCallId DESC", true);
                          if ($FetchCalls != null) {
                            foreach ($FetchCalls as $Calls) { ?>
                              <li>
                                <span><?php echo CallTypes("" . $Calls->LeadCallType . ""); ?></span>
                                <p>
                                  <span><b><?php echo DATE_FORMATE2("d M, Y", $Calls->LeadCallingDate); ?> <?php echo DATE_FORMATE2("d:m A", $Calls->LeadCallingTime); ?></b> <span class="text-grey">- <?php echo $Calls->LeadCallStatus; ?></span></span><br>
                                  <span><i class="fa fa-user text-primary"></i>
                                    <span class="text-grey"><?php echo FETCH("SELECT * FROM leads where LeadsId='" . $Calls->LeadMainId . "'", "LeadSalutations"); ?></span>
                                    <span><?php echo FETCH("SELECT * FROM leads where LeadsId='" . $Calls->LeadMainId . "'", "LeadPersonFullname"); ?></span> |
                                    <span><?php echo FETCH("SELECT * FROM leads where LeadsId='" . $Calls->LeadMainId . "'", "LeadPersonPhoneNumber"); ?></span>
                                  </span><br>
                                  <span><?php echo html_entity_decode(SECURE($Calls->LeadCallNotes, "d")); ?></span><br>
                                  <span class="text-grey">By <?php echo FETCH("SELECT * FROM users where id='" . $Calls->CallCreatedBy . "'", "name"); ?></span>
                                </p>
                              </li>
                          <?php }
                          } ?>

                        </ul>
                      </div>
                    </div>


                    <div class="col-md-4">
                      <div class="rounded-2">
                        <h4 class="app-heading bg-danger p-2">Today Scheduled Calls</h4>
                        <div class="row">
                          <div class="col-md-6 col-xs-6 col-6 mb-5px">
                            <div class="car card-body border-1 rounded-2 shadow-sm">
                              <h2 class="count text-success mb-0"><?php echo TOTAL("SELECT * FROM leads_calls where DATE(LeadCallingReminderDate)<='$CurrentData' and LeadCallStatus='FollowUp'"); ?></h2>
                              <p class="mb-0">Total Calls</p>
                            </div>
                          </div>
                        </div>
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
                                  <span><i class="fa fa-user text-primary"></i>
                                    <span class="text-grey"><?php echo FETCH("SELECT * FROM leads where LeadsId='" . $Calls->LeadMainId . "'", "LeadSalutations"); ?></span>
                                    <span><?php echo FETCH("SELECT * FROM leads where LeadsId='" . $Calls->LeadMainId . "'", "LeadPersonFullname"); ?></span> |
                                    <span><?php echo FETCH("SELECT * FROM leads where LeadsId='" . $Calls->LeadMainId . "'", "LeadPersonPhoneNumber"); ?></span>
                                  </span><br>
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
                                        "LeadMainid" => FETCH("SELECT * FROM leads_calls where LeadCallId='" . $Calls->LeadCallId . "'", "LeadMainId"),
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
                                                <option value="Fresh">Fresh</option>
                                                <option value="Ringing">Ringing...</option>
                                                <option value="Out Of Reach">Out Of Reach</option>
                                                <option value="Switch Off">Switch Off</option>
                                                <option value="Invalid Number">Invalid Number</option>
                                                <option value="Busy">Busy</option>
                                                <option value="FollowUp">FollowUp</option>
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
                    </div>

                    <div class="col-md-4">
                      <div class="rounded-2">
                        <h4 class="app-heading bg-warning p-2">All Scheduled Calls</h4>
                        <div class="row">
                          <div class="col-md-6 col-xs-6 col-6 mb-5px">
                            <div class="car card-body border-1 rounded-2 shadow-sm">
                              <h2 class="count text-danger mb-0"><?php echo TOTAL("SELECT * FROM leads_calls where LeadCallStatus='FollowUp'"); ?></h2>
                              <p class="mb-0">Total Scheduled Calls</p>
                            </div>
                          </div>
                        </div>
                        <ul class="calling-list">
                          <?php
                          $CurrentData = date("Y-m-d");
                          $FetchCalls = FetchConvertIntoArray("SELECT * FROM leads_calls where LeadCallStatus='FollowUp' ORDER BY LeadCallId DESC", true);
                          if ($FetchCalls != null) {
                            foreach ($FetchCalls as $Calls) { ?>
                              <li>
                                <span><?php echo Reminder(); ?></span>
                                <p>
                                  <span><b><?php echo DATE_FORMATE2("d M, Y", $Calls->LeadCallingReminderDate); ?> <?php echo DATE_FORMATE2("d:m A", $Calls->LeadCallingReminderTime); ?></b></span><br>
                                  <span><i class="fa fa-user text-primary"></i>
                                    <span class="text-grey"><?php echo FETCH("SELECT * FROM leads where LeadsId='" . $Calls->LeadMainId . "'", "LeadSalutations"); ?></span>
                                    <span><?php echo FETCH("SELECT * FROM leads where LeadsId='" . $Calls->LeadMainId . "'", "LeadPersonFullname"); ?></span> |
                                    <span><?php echo FETCH("SELECT * FROM leads where LeadsId='" . $Calls->LeadMainId . "'", "LeadPersonPhoneNumber"); ?></span>
                                  </span><br>
                                  <span><?php echo html_entity_decode(SECURE($Calls->LeadCallRemindNotes, "d")); ?></span><br>
                                  <span class="text-grey">By <?php echo FETCH("SELECT * FROM users where id='" . $Calls->CallCreatedBy . "'", "name"); ?></span>
                                </p>
                              </li>
                          <?php }
                          } ?>

                        </ul>
                      </div>
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
    <?php include '../../sidebar.php'; ?>
    <?php include '../../footer.php'; ?>
  </div>

  <?php include '../../../include/footer_files.php'; ?>


</body>

</html>
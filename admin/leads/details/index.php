<?php
$Dir = "../../..";
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';
//pagevariables
$PageName = "Lead Details";
$PageDescription = "Manage all customers";

if (isset($_GET['LeadsId'])) {
  $_SESSION['REQ_LeadsId'] = SECURE($_GET['LeadsId'], "d");
  $REQ_LeadsId = $_SESSION['REQ_LeadsId'];
} else {
  $REQ_LeadsId = $_SESSION['REQ_LeadsId'];
}

$PageSqls = "SELECT * FROM leads where LeadsId='$REQ_LeadsId'";

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title><?php echo FETCH($PageSqls, "LeadPersonFullname"); ?> | <?php echo APP_NAME; ?></title>
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
  <meta name="keywords" content="<?php echo APP_NAME; ?>">
  <meta name="description" content="<?php echo SHORT_DESCRIPTION; ?>">
  <?php include '../../../include/header_files.php'; ?>
  <script type="text/javascript">
    function SidebarActive() {
      document.getElementById("leads").classList.add("active");
      document.getElementById("all_leads").classList.add("active");
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
                    <div class="col-md-12 m-b-10">
                      <h3 class="m-t-3 m-b-10"><i class="fa fa-phone app-text"></i> <?php echo $PageName; ?> : <small><?php echo LEADID($REQ_LeadsId); ?></small>
                      </h3>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <a href="edit-deals.php?dealsid=<?php echo SECURE($REQ_LeadsId, "e"); ?>" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> Edit Details</a>
                      <a href="edit-requirements.php?dealsid=<?php echo SECURE($REQ_LeadsId, "e"); ?>" class="btn btn-xs btn-default"><i class="fa fa-edit"></i> Edit Requirements</a>
                      <a data-target="#updatestagestatus" class="btn btn-xs btn-primary" data-toggle="modal"><i class="fa fa-edit"></i> Update Status</a>
                      <a data-target="#addcallrecords" class="btn btn-xs btn-success" data-toggle="modal"><i class="fa fa-phone"></i> Add Call Records</a>
                      <a data-target="#setcallreminder" data-toggle="modal" class="btn btn-xs btn-danger"><i class="fa fa-bell"></i> Set Reminder</a>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-md-5">
                      <div class="p-3 rounded-2 p-2 shadow-sm">
                        <h4><i class="fa fa-tag text-warning"></i> <span class="text-grey"><?php echo FETCH($PageSqls, "LeadSalutations"); ?></Span> <?php echo FETCH($PageSqls, "LeadPersonFullname"); ?></h4>
                        <h5><?php echo LeadStage(FETCH($PageSqls, "LeadPersonStatus")); ?> | <?php echo LeadStatus(FETCH($PageSqls, "LeadPriorityLevel")); ?></h5>
                        <p class="description mt-3 flex-column">
                          <span>
                            <?php echo PHONE(FETCH($PageSqls, "LeadPersonPhoneNumber"), "link", "text-black", "fa fa-phone text-primary"); ?>
                          </span><br>
                          <span>
                            <?php echo EMAIL(FETCH($PageSqls, "LeadPersonEmailId"), "link", "text-black", "fa fa-envelope text-danger"); ?>
                          </span><br>
                          <span>
                            <?php echo ADDRESS(FETCH($PageSqls, "LeadPersonAddress"), "link", "text-black", "fa fa-map-marker text-success"); ?>
                          </span>
                        </p>

                        <p class="flex-s-b">
                          <span>
                            <span class="text-grey">Created By</span><br>
                            <span class="team-list">
                              <i class="fa fa-user"></i>
                              <?php echo FETCH("SELECT * FROM users where id='" . FETCH($PageSqls, 'LeadPersonCreatedBy') . "'", "name"); ?>
                            </span>
                          </span>
                          <span>
                            <span class="text-grey">Managed By / Assigned To</span><br>
                            <span class="team-list">
                              <i class="fa fa-user"></i>
                              <?php echo FETCH("SELECT * FROM users where id='" . FETCH($PageSqls, 'LeadPersonManagedBy') . "'", "name"); ?>
                            </span>
                          </span>
                        </p>

                        <p class="desc flex-s-b">
                          <span>
                            <span class="text-grey">Work Profile/Working As</span><br>
                            <span class="text">
                              <?php echo FETCH($PageSqls, "LeadPersonCompanyName"); ?>
                            </span>
                          </span>
                          <span>
                            <span class="text-grey">Company Type</span><br>
                            <span class="text">
                              <?php echo FETCH($PageSqls, "LeadPersonCompanyType"); ?>
                            </span>
                          </span>
                        </p>
                        <p class="desc flex-s-b">
                          <span>
                            <span class="text-grey">Created At</span><br>
                            <span class="text"><?php echo DATE_FORMATE2("d M, Y", FETCH($PageSqls, "LeadPersonCreatedAt")); ?></span>
                          </span>

                          <span>
                            <span class="text-grey">Last Updated At</span><br>
                            <span class="text"><?php echo DATE_FORMATE2("d M, Y", FETCH($PageSqls, "LeadPersonLastUpdatedAt")); ?></span>
                          </span>
                        </p>

                        <p class="desc flex-s-b">
                          <span>
                            <span class="text-grey">Need & Requirements</span><br>
                            <span class="text">
                              <?php $fetchRequirements = FetchConvertIntoArray("SELECT * FROM lead_requirements where LeadMainId='$REQ_LeadsId'", true);
                              if ($fetchRequirements != null) {
                                foreach ($fetchRequirements as $Req) {
                                  $SqlProjectUnits = "SELECT * FROM project_units where project_units_id='" . $Req->LeadRequirementDetails . "'";
                                  $ProjectID = FETCH($SqlProjectUnits, "project_id");
                                  $Sqlprojects = "SELECT * FROM projects where Projects_id='$ProjectID'";
                              ?>
                                  <h5 class='form-check-label text-grey p-1 m-b-0 m-t-0'><i class="fa fa-check-circle text-success"></i>
                                    <b class="text-info"><?php echo FETCH($Sqlprojects, "project_title"); ?></b><br>
                                    <span class='text-primary'>
                                      <b><?php echo strtoupper(FETCH($SqlProjectUnits, "projects_unit_name")); ?></b>
                                    </span> - <?php echo FETCH($SqlProjectUnits, "project_unit_area"); ?> <?php echo FETCH($SqlProjectUnits, "project_unit_measurement_unit"); ?> - <span class="text-warning"><?php echo FETCH($SqlProjectUnits, "project_unit_status"); ?></span><br>
                                    (Rs.<?php echo FETCH($SqlProjectUnits, "unit_per_price"); ?>/<?php echo FETCH($SqlProjectUnits, "project_unit_measurement_unit"); ?>)<br> @
                                    <span class="text-success"> <b>Rs.<?php echo FETCH($SqlProjectUnits, "project_unit_price"); ?></b></span>
                                  </h5>
                              <?php }
                              } ?>
                            </span>
                          </span>
                        </p>

                        <p class="desc flex-s-b">
                          <span>
                            <span class="text-grey">Notes/Remarks</span><br>
                            <span class="text"><?php echo html_entity_decode(SECURE(FETCH($PageSqls, "LeadPersonNotes"), "d")); ?></span>
                          </span>
                        </p>
                      </div>
                    </div>

                    <div class="col-md-7">
                      <div class="row">
                        <div class="col-md-6 data-display">
                          <div class="rounded-2">
                            <h4 class="section-heading">Today Calls</h4>
                            <ul class="calling-list">
                              <?php
                              $CurrentData = date("Y-m-d");
                              $FetchCalls = FetchConvertIntoArray("SELECT * FROM leads_calls where DATE(LeadCallingReminderDate)<='$CurrentData' and LeadCallStatus='FollowUp' and LeadMainId='$REQ_LeadsId' ORDER BY LeadCallId DESC", true);
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
                                            "LeadMainid" => FETCH($PageSqls, "LeadsId"),
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
                        </div>

                        <div class="col-md-6 data-display">
                          <div class="rounded-2">
                            <h4 class="section-heading bg-warning">All Scheduled Calls</h4>
                            <ul class="calling-list">
                              <?php
                              $CurrentData = date("Y-m-d");
                              $FetchCalls = FetchConvertIntoArray("SELECT * FROM leads_calls where LeadCallStatus='FollowUp' and LeadMainId='$REQ_LeadsId' ORDER BY LeadCallId DESC", true);
                              if ($FetchCalls != null) {
                                foreach ($FetchCalls as $Calls) { ?>
                                  <li>
                                    <span><?php echo Reminder(); ?></span>
                                    <p>
                                      <span><b><?php echo DATE_FORMATE2("d M, Y", $Calls->LeadCallingReminderDate); ?> <?php echo DATE_FORMATE2("d:m A", $Calls->LeadCallingReminderTime); ?></b></span><br>
                                      <span><?php echo html_entity_decode(SECURE($Calls->LeadCallRemindNotes, "d")); ?></span><br>
                                      <span class="text-grey">By <?php echo FETCH("SELECT * FROM users where id='" . $Calls->CallCreatedBy . "'", "name"); ?></span>
                                    </p>
                                  </li>
                              <?php }
                              } ?>

                            </ul>
                          </div>
                        </div>

                        <div class="col-md-6 data-display">
                          <div class="rounded-2">
                            <h4 class="section-heading">Call Records</h4>
                            <ul class="calling-list">
                              <?php
                              $FetchCalls = FetchConvertIntoArray("SELECT * FROM leads_calls where LeadCallStatus!='FollowUp' and LeadMainId='$REQ_LeadsId' ORDER BY LeadCallId DESC", true);
                              if ($FetchCalls != null) {
                                foreach ($FetchCalls as $Calls) { ?>
                                  <li>
                                    <span><?php echo CallTypes("" . $Calls->LeadCallType . ""); ?></span>
                                    <p>
                                      <span><b><?php echo DATE_FORMATE2("d M, Y", $Calls->LeadCallingDate); ?> <?php echo DATE_FORMATE2("d:m A", $Calls->LeadCallingTime); ?></b> <span class="text-grey">- <?php echo $Calls->LeadCallStatus; ?></span></span><br>
                                      <span><?php echo html_entity_decode(SECURE($Calls->LeadCallNotes, "d")); ?></span><br>
                                      <span class="text-grey">By <?php echo FETCH("SELECT * FROM users where id='" . $Calls->CallCreatedBy . "'", "name"); ?></span>
                                    </p>
                                  </li>
                              <?php }
                              } ?>

                            </ul>
                          </div>
                        </div>

                        <div class="col-md-6 data-display">
                          <div class="rounded-2">
                            <h4 class="section-heading">Stage Updates</h4>
                            <ul class="lead-stage-status">
                              <?php
                              $FetchLeadsStages = FetchConvertIntoArray("SELECT * FROM lead_stages where LeadMainid='$REQ_LeadsId' ORDER BY LeadStageId ASC", true);
                              if ($FetchLeadsStages != null) {
                                foreach ($FetchLeadsStages as $Stages) { ?>
                                  <li>
                                    <p class="desc-desc mb-2">
                                      <span><i class="fa fa-angle-double-right right-btn-i bg-success text-white"></i> <?php echo LeadStage($Stages->LeadStage); ?></span><br>
                                      <span class="text-black italic"><?php echo DATE_FORMATE2("d M, Y", $Stages->LeadStageCreatedAt); ?></span><br>
                                      <span><?php echo html_entity_decode(SECURE($Stages->LeadStageDescriptions, "d")); ?></span><br>
                                      <span class="text-grey"><i>By <?php echo FETCH("SELECT * FROM users where id='" . $Stages->LeadStageCreatedBy . "'", "name"); ?></i></span><br>
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

                <!-- #modal-dialog -->
                <div class="modal fade" id="updatestagestatus">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header section-heading">
                        <h4 class="modal-title">Update Stage Status</h4>
                      </div>
                      <form action="<?php echo CONTROLLER; ?>/leads.php" method="POST">
                        <?php FormPrimaryInputs(true, [
                          "LeadMainid" => FETCH($PageSqls, "LeadsId")
                        ]);  ?>
                        <div class="modal-body">
                          <div class="row">
                            <div class="form-group col-md-6">
                              <label>Lead Stage</label>
                              <select class="form-control" name="LeadStage">
                                <?php
                                foreach (LEAD_STAGES as $key => $lstages) {
                                  $FetchLeadsStages2 = SELECT("SELECT * FROM lead_stages where LeadStage!='$key' and LeadMainid='$REQ_LeadsId' ORDER BY LeadStageId ASC");
                                  $FetchStages = CHECK("SELECT * FROM lead_stages where LeadStage='$key' and LeadMainid='$REQ_LeadsId'");
                                  if ($FetchStages != null) {
                                    $CurrentStages = FETCH("SELECT * FROM lead_stages where LeadStage='$key' and LeadMainid='$REQ_LeadsId'", "LeadStage");
                                    if ($CurrentStages != $key)
                                      echo "<option value='$key'>$lstages</option>";
                                  } else {
                                    echo "<option value='$key'>$lstages</option>";
                                  }
                                }
                                ?>
                              </select>
                            </div>
                            <div class="form-group col-md-6">
                              <label>Update Date</label>
                              <input type="date" class="form-control" value="<?php echo date("Y-m-d"); ?>" name="LeadStageCreatedAt">
                            </div>
                            <div class="form-group col-md-6">
                              <label>Stage Updated By</label>
                              <select class="form-control" name="LeadStageCreatedBy">
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
                            <div class="form-group col-md-12">
                              <label>Update Note/Remarks</label>
                              <textarea name="LeadStageDescriptions" rows="4" class="form-control"></textarea>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button class="btn btn-success mt-0 mb-0" name="UpdateLeadStage" value="<?php echo SECURE($REQ_LeadsId, "e"); ?>" type="Submit">Update Stage</button>
                          <button href="javascript:;" type="button" class="btn btn-white mt-0 mb-0" data-dismiss="modal">Close</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <!-- #modal-dialog -->
                <div class="modal fade" id="addcallrecords">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header section-heading">
                        <h4 class="modal-title">Add Call Records</h4>
                      </div>
                      <form action="<?php echo CONTROLLER; ?>/leads.php" method="POST">
                        <?php FormPrimaryInputs(true, [
                          "LeadMainid" => FETCH($PageSqls, "LeadsId")
                        ]);  ?>
                        <div class="modal-body">
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
                              <label>Call Type</label>
                              <select name="LeadCallType" class="form-control">
                                <option value="Incoming">Incoming</option>
                                <option value="Outgoing">Outgoing</option>
                              </select>
                            </div>

                            <div class="form-group col-md-8">
                              <label>Call Status</label>
                              <select name="LeadCallStatus" class="form-control">
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
                        <div class="modal-footer">
                          <button class="btn btn-success mt-0 mb-0" name="ADDCallRecords" value="<?php echo SECURE($REQ_LeadsId, "e"); ?>" type="Submit">Save Call Record</button>
                          <button href="javascript:;" type="button" class="btn btn-white mt-0 mb-0" data-dismiss="modal">Close</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <!-- #modal-dialog -->
                <div class="modal fade" id="setcallreminder">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header section-heading">
                        <h4 class="modal-title">Set Call Reminders</h4>
                      </div>
                      <form action="<?php echo CONTROLLER; ?>/leads.php" method="POST">
                        <?php FormPrimaryInputs(true, [
                          "LeadMainid" => FETCH($PageSqls, "LeadsId"),
                          "LeadCallStatus" => "FollowUp"
                        ]);  ?>
                        <div class="modal-body">
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
                        <div class="modal-footer">
                          <button class="btn btn-success mt-0 mb-0" name="SetCallReminders" value="<?php echo SECURE($REQ_LeadsId, "e"); ?>" type="Submit">Save Call Reminder</button>
                          <button href="javascript:;" type="button" class="btn btn-white mt-0 mb-0" data-dismiss="modal">Close</button>
                        </div>
                      </form>
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
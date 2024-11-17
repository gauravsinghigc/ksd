<?php
//add controller helper files
require 'helper.php';

//add aditional requirements
require '../require/admin/sessionvariables.php';

//save leads 
if (isset($_POST['CreateLeads'])) {
 $Tablerows = array(
  "LeadPersonFullname", "LeadSalutations", "LeadPersonPhoneNumber", "LeadPersonEmailId", "LeadPersonAddress", "LeadPersonCreatedBy",
  "LeadPersonCompanyType", "LeadPersonStatus", "LeadPersonNotes", "LeadPersonCreatedAt", "LeadPersonCompanyDomain", "LeadPersonCompanyName",
  "LeadPersonManagedBy", "LeadPriorityLevel", "LeadPersonNeeddate"
 );
 FormRequests($Tablerows, "post", null);

 $LeadPersonCreatedAt = RequestDataTypeDate();
 $LeadPersonNotes = POST("LeadPersonNotes");
 $SAVE = SAVE("leads", $Tablerows, false);

 //get Lead id
 $LeadsId = FETCH("SELECT * FROM leads ORDER BY LeadsId DESC LIMIT 1", "LeadsId");
 $LeadMainid = $LeadsId;

 //save lead stage
 $LeadStage = $LeadPersonStatus;
 $LeadStageDescriptions = $LeadPersonNotes;
 $LeadStageCreatedAt = $LeadPersonCreatedAt;
 $LeadStageCreatedBy = $LeadPersonCreatedBy;
 $Save = SAVE("lead_stages", array("LeadMainid", "LeadStage", "LeadStageDescriptions", "LeadStageCreatedAt", "LeadStageCreatedBy"), false);

 //save lead requirement
 $LeadRequirementCreatedAt = $LeadPersonCreatedAt;
 $LeadRequirementStatus = "1";
 $LeadMainId = FETCH("SELECT * FROM leads ORDER BY LeadsId DESC LIMIT 1", "LeadsId");
 foreach ($_POST['LeadRequirementDetails'] as $LeadReq) {
  $LeadRequirementDetails = $LeadReq;
  $save = SAVE("lead_requirements", array("LeadMainId", "LeadRequirementDetails", "LeadRequirementCreatedAt", "LeadRequirementStatus"), false);
 }

 //save call details
 $Tablerows = array("LeadMainId", "LeadCallingDate", "LeadCallingTime", "LeadCallingReminderTime", "LeadCallingReminderDate", "LeadCallType", "LeadCallStatus", "LeadCallNotes", "LeadCallRemindNotes", "CallCreatedAt", "CallCreatedBy");
 FormRequests($Tablerows, "post", null);
 $CallCreatedAt = $LeadPersonCreatedAt;
 $CallCreatedBy = $LeadPersonCreatedBy;
 $LeadMainId = FETCH("SELECT * FROM leads ORDER BY LeadsId DESC LIMIT 1", "LeadsId");
 $LeadCallNotes = POST("LeadCallNotes");
 $LeadCallRemindNotes = POST("LeadCallRemindNotes");

 $Save = SAVE("leads_calls", $Tablerows, false);
 RESPONSE($Save, "Leads Saved Successfully", "Leads Not Saved Successfully");

 //update lead stage
} elseif (isset($_POST['UpdateLeadStage'])) {

 $LeadStageCreatedBy = $_POST['LeadStageCreatedBy'];
 $LeadStage = $_POST['LeadStage'];
 $LeadMainid  = SECURE($_POST['LeadMainid'], "d");
 $LeadStageDescriptions = POST("LeadStageDescriptions");
 $LeadPersonStatus = $LeadStage;
 $LeadPersonLastUpdatedAt = RequestDataTypeDate();
 $LeadPersonManagedBy = $LeadStageCreatedBy;
 $LeadStageCreatedAt = RequestDataTypeDate();

 $SAVE = SAVE("lead_stages", ["LeadMainid", "LeadStage", "LeadStageCreatedBy", "LeadStageDescriptions", "LeadStageCreatedAt"], false);
 $UPDATE = UPDATE_TABLE("leads", ["LeadPersonStatus", "LeadPersonLastUpdatedAt", "LeadPersonManagedBy"], "LeadsId='$LeadMainid'", false);

 if ($LeadStage == "BOOKING_COMPLETED") {

  //save lead details into customer details
  $LSql = "SELECT * FROM leads where LeadsId='$LeadMainid'";
  $array = array(
   "name" => FETCH($LSql, "LeadPersonFullname"),
   "email" => FETCH($LSql, "LeadPersonPhoneNumber"),
   "phone" => FETCH($LSql, "LeadPersonEmailId"),
   "agent_relation" => 0,
   "password" => rand(1111, 99999),
   "created_at" => RequestDataTypeDate,
   "user_status" => "ACTIVE",
   "company_relation" => 1,
   "user_role_id" => 4
  );
  $saveUsers = INSERT("users", $array);
  $user_id = FETCH("SELECT * FROM users ORDER BY id DESC limit 1", "id");

  //save lead details into address details
  $address = array(
   "user_street_address" => FETCH($LSql, "LeadPersonAddress"),
   "user_area_locality" => FETCH($LSql, ""),
   "user_city" => FETCH($LSql, ""),
   "user_state" => FETCH($LSql, ""),
   "user_pincode" => FETCH($LSql, ""),
   "user_country" => FETCH($LSql, ""),
   "user_id" => $user_id,
   "created_at" => RequestDataTypeDate,
   "updated_at" => RequestDataTypeDate
  );
  $saveaddress = INSERT("user_address", $address);

  $access_url = ADMIN_URL . "/booking/new_booking.php?customer_id=$user_id&BOOKING_STEP_2=true";
 } else {
  $access_url = $access_url;
 }

 RESPONSE($SAVE, "Lead Stage Updated Successfully", "Lead Stage Not Updated Successfully");

 //add new calls
} elseif (isset($_POST['ADDCallRecords'])) {
 $LeadMainId = SECURE($_POST['LeadMainid'], "d");
 $LeadCallingDate = $_POST['LeadCallingDate'];
 $LeadCallingTime = $_POST['LeadCallingTime'];
 $LeadCallType = $_POST['LeadCallType'];
 $LeadCallStatus = $_POST['LeadCallStatus'];
 $LeadCallNotes = POST("LeadCallNotes");
 $CallCreatedAt = RequestDataTypeDate();
 $CallCreatedBy = $_POST['CallCreatedBy'];

 $Save = SAVE("leads_calls", array("LeadMainId", "LeadCallingDate", "LeadCallingTime", "LeadCallingReminderTime", "LeadCallingReminderDate", "LeadCallType", "LeadCallStatus", "LeadCallNotes", "LeadCallRemindNotes", "CallCreatedAt", "CallCreatedBy"), false);
 RESPONSE($Save, "Call Added Successfully", "Call Not Added Successfully");

 //set call reminders
} elseif (isset($_POST['SetCallReminders'])) {
 $LeadMainId = SECURE($_POST['LeadMainid'], "d");
 $LeadCallingReminderDate = $_POST['LeadCallingReminderDate'];
 $LeadCallingReminderTime = $_POST['LeadCallingReminderTime'];
 $LeadCallRemindNotes = POST("LeadCallRemindNotes");
 $CallCreatedAt = RequestDataTypeDate();
 $CallCreatedBy = $_POST['CallCreatedBy'];
 $LeadCallStatus = SECURE($_POST['LeadCallStatus'], "d");
 $Save = SAVE("leads_calls", array("LeadMainId", "LeadCallStatus", "LeadCallingReminderDate", "LeadCallingReminderTime", "LeadCallRemindNotes", "CallCreatedAt", "CallCreatedBy"), false);
 RESPONSE($Save, "Call Reminder Added Successfully", "Call Reminder Not Added Successfully");

 //update call record or re-schedule call reminders
} elseif (isset($_POST['UpdateCallReminderDetails'])) {
 $LeadCallId = SECURE($_POST['UpdateCallReminderDetails'], "d");
 $LeadMainid = SECURE($_POST['LeadMainid'], "d");

 //call type
 $LeadCallType = $_POST['LeadCallType'];

 //new call details
 $LeadCallingDate = $_POST['LeadCallingDate'];
 $LeadCallingTime = $_POST['LeadCallingTime'];
 $LeadCallStatus = $_POST['LeadCallStatus'];
 $LeadCallNotes = POST("LeadCallNotes");
 $CallCreatedBy = $_POST['CallCreatedBy'];

 //call re-schedule details
 $LeadCallingReminderDate = $_POST['LeadCallingReminderDate'];
 $LeadCallingReminderTime = $_POST['LeadCallingReminderTime'];
 $LeadCallRemindNotes = POST("LeadCallRemindNotes");
 $CallCreatedBy = $_POST['CallCreatedBy'];


 //check and arrange call as per new update provided
 if ($_POST['LeadCallType'] == "Reschedule") {

  //save previous call details
  $LeadCallMainId = $LeadCallId;
  $LeadCallPreviousStatus = FETCH("SELECT * FROM leads_calls WHERE LeadCallId='$LeadCallId'", "LeadCallStatus");
  $LeadCallPreviousDate = FETCH("SELECT * FROM leads_calls where LeadCallId='$LeadCallId'", "LeadCallingReminderDate");
  $LeadCallPreviousTime = FETCH("SELECT * FROM leads_calls where LeadCallId='$LeadCallId'", "LeadCallingReminderTime");
  $LeadCallPreviousCreatedAt = FETCH("SELECT * FROM leads_calls where LeadCallId='$LeadCallId'", "CallCreatedAt");
  $LeadCallPreviousUpdatedAt = RequestDataTypeDate();
  $LeadCallPreviousManagedBy = FETCH("SELECT * FROM leads_calls where LeadCallId='$LeadCallId'", "CallCreatedBy");
  $LeadCallPreviousDetails = FETCH("SELECT * FROM leads_calls where LeadCallId='$LeadCallId'", "LeadCallRemindNotes");
  $LeadCallPreviousCreatedBy = LOGIN_UserId;
  $Save = SAVE("lead_call_reschedules", ["LeadCallMainId", "LeadCallPreviousCreatedBy", "LeadCallPreviousStatus", "LeadCallPreviousDate", "LeadCallPreviousTime", "LeadCallPreviousCreatedAt", "LeadCallPreviousUpdatedAt", "LeadCallPreviousManagedBy", "LeadCallPreviousDetails", "LeadCallPreviousCreatedBy"], false);

  //update call reminder with new details;
  $CallCreatedAt = RequestDataTypeDate();
  $LeadCallType = "";
  $LeadCallStatus = "FollowUp";
  $Update = UPDATE_TABLE("leads_calls", ["LeadCallStatus", "LeadCallType", "LeadCallingReminderDate", "LeadCallingReminderTime", "LeadCallRemindNotes", "CallCreatedAt", "CallCreatedBy"], "LeadCallId='$LeadCallId'");

  //update call if call is not rescheduled and called for update
 } else {
  $Update = UPDATE_TABLE("leads_calls", ["LeadCallType", "LeadCallNotes", "LeadCallingDate", "LeadCallingTime", "LeadCallStatus", "CallCreatedBy", "CallCreatedAt"], "LeadCallId='$LeadCallId'");
 }

 // send response to the requestor
 RESPONSE($Update, "Call Updated Successfully", "Call Not Updated Successfully");

 //update deal details
} else if (isset($_POST['UpdateLeads'])) {
 $LeadsId = SECURE($_POST['UpdateLeads'], "d");
 $Tablerows = array(
  "LeadPersonFullname", "LeadSalutations", "LeadPersonPhoneNumber", "LeadPersonEmailId", "LeadPersonAddress", "LeadPersonCreatedBy",
  "LeadPersonCompanyType", "LeadPersonStatus", "LeadPersonNotes", "LeadPersonLastUpdatedAt", "LeadPersonCompanyDomain", "LeadPersonCompanyName",
  "LeadPersonManagedBy", "LeadPriorityLevel"
 );
 FormRequests($Tablerows, "post", null);

 $LeadPersonLastUpdatedAt = RequestDataTypeDate();
 $LeadPersonNotes = POST("LeadPersonNotes");

 $UpdateLeads = UPDATE_TABLE("leads", $Tablerows, "LeadsId='$LeadsId'");
 RESPONSE($UpdateLeads, "Lead Updated Successfully", "Lead Not Updated Successfully");

 //update deals requirements
} elseif (isset($_POST['UpdateLeadRequirements'])) {
 $LeadMainId = SECURE($_POST['UpdateLeadRequirements'], "d");

 $LeadRequirementCreatedAt = RequestDataTypeDate();
 $LeadRequirementStatus = "1";
 foreach ($_POST['LeadRequirementDetails'] as $key => $LeadReq) {
  $LeadRequirementDetails = $LeadReq;
  $FetchRequiements = FetchConvertIntoArray("SELECT * FROM lead_requirements where LeadMainId='$LeadMainId' and LeadRequirementDetails='$LeadRequirementDetails'", true);

  if ($FetchRequiements == null) {
   $save = SAVE("lead_requirements", array("LeadMainId", "LeadRequirementDetails", "LeadRequirementCreatedAt", "LeadRequirementStatus"), false);
  }
 }

 RESPONSE($save, "Lead Requirements Updated Successfully", "Lead Requirements Not Updated Successfully");

 //delete lead requirements
} elseif (isset($_GET['delete_lead_requirements'])) {
 $access_url = SECURE($_GET['access_url'], "d");
 $delete_lead_requirements = SECURE($_GET['delete_lead_requirements'], "d");

 if ($delete_lead_requirements == true) {
  $control_id = SECURE($_GET['control_id'], "d");
  $Delete = DELETE_FROM("lead_requirements",  "LeadRequirementID='$control_id'");
  RESPONSE($Delete, "Lead Requirement Deleted Successfully", "Lead Requirement Not Deleted Successfully");
 } else {
  RESPONSE(false, "Lead Requirement Not Deleted Successfully", "Lead Requirement Not Deleted Successfully");
 }
}

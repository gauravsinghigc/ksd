<?php
//lead stage
DEFINE("LEAD_STAGES", array(
 "ENQUIRY_CALL" => "Enquiry Call",
 "SCHEDULE_VISIT" => "Schedule Visits",
 "VISITED" => "Visited",
 "WAITING_FOR_CONFIRMATION" => "Waiting for Confirmation",
 "CONFIRMED" => "Confirmed",
 "WAITING_FOR_FIRST_PAYMENT" => "Waiting for First Payment",
 "BOOKING_COMPLETED" => "Booking Completed",
 "CANCELLED" => "Cancelled",
 "POSTPOND" => "Postpond"
));


//function for lead call reminders
function DisplayReminder($REQ_LeadsId)
{
 $CurrentData = date("Y-m-d");
 $FetchCalls = FetchConvertIntoArray("SELECT * FROM leads_calls where DATE(LeadCallingReminderDate)<='$CurrentData' and LeadCallStatus='FollowUp' and LeadMainId='$REQ_LeadsId' ORDER BY LeadCallId DESC limit 1", true);
 if ($FetchCalls != null) {
  foreach ($FetchCalls as $Calls) {
   return Reminder();
  }
 }
}

//function display lead id
function LEADID($id)
{
 echo "LEADID00" . $id;
}

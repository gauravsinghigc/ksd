<?php
//add controller helper files
require 'helper.php';

//add aditional requirements
require '../require/admin/sessionvariables.php';

//start request processing

//access url

//start your actions from here
if (isset($_POST['supportrequest'])) {
  $packagename = $_POST["packagename"];
  $supportype = $_POST["supportype"];
  $supportcategory = $_POST["supportcategory"];
  $supportpriority = $_POST["supportpriority"];
  $email = $_POST["contactmailid"];
  $companyemail = $_POST["companymailid"];
  $phone = $_POST["contactphonenumber"];
  $companyphone = $_POST["companyphonenumber"];
  $supportdetails = $_POST["supportdetails"];
  $created_at = date("D d M, Y h:i A");

  $supportid = rand(1, 999999);
  $supportrefrencenumber = DATE("d/M/Y/") . $supportid;

  //provider mail
  $SendMailtoProvider = SENDMAILS("#$supportrefrencenumber - $supportype @$packagename", "Dear $CREATED_BY Team,", "$DEV_EMAIL", "M/s <b>$packagename</b> send us a request on <b>$created_at</b> by using our built-in support system in the provided Application. Details are briefly mention below.<br>
<p>
<b>Receive Date:</b><br>
$created_at<br><br>
<b>Reference ID:</b><br>
$supportrefrencenumber<br><br>
<b>Package/Organisation Name:</b><br>
$packagename<br><br>
<b>Request Type:</b><br>
$supportype<br><br>
<b>Request Category:</b><br>
$supportcategory<br><br>
<b>Priority Number:</b>
$supportpriority<br><br>
<b>Contact Emails:</b><br>
<b>Company Mail:</b> $companyemail &nbsp; &nbsp;| &nbsp; &nbsp; <b>Admin Mail:</b> $email<br><br>
<b>Contact Phone:</b><br>
<b>Company Phone:</b> $companyphone &nbsp; &nbsp;| &nbsp; &nbsp; <b>Admin Phone:</b> $phone<br><br>
<b>Request Details:</b><br>$supportdetails
</p>");


  if ($SendMailtoProvider == true) {
    LOCATION("success", "Your Support Request Having Ref ID : $supportrefrencenumber is Sent Successfully to Provider. To continue check your registered mail id.", "$access_url");
  } else {
    LOCATION("warning", "Unable to Send Support Request at Moment from the System, Please try again after sometime. <br> You can also send Support Request via your registered mail/company mail at $DEV_EMAIL. In case of change in mail id please mention previous mail id too.", "$access_url");
  }
}

<?php
require "../../require/modules.php";
require "../../require/admin/sessionvariables.php";

$_SESSION['url'] = "../auth/forget";

//company_details
$SelectCompany = SELECT("SELECT * FROM companies where company_id='1'");
$FetchCompany = mysqli_fetch_array($SelectCompany);
$company_id = $FetchCompany['company_id'];
$company_name = $FetchCompany['company_name'];
$company_email = $FetchCompany['company_email'];
$company_phone = $FetchCompany['company_phone'];
$company_desc = $FetchCompany['company_desc'];
$company_tagline = $FetchCompany['company_tagline'];
$company_status = $FetchCompany['company_status'];
$created_at = $FetchCompany['created_at'];
$updated_at = $FetchCompany['updated_at'];
$company_logo = $FetchCompany['company_logo'];

if ($company_logo == "demo-logo.png") {
 $company_logo = DOMAIN . "/storage/sys-img/demo-logo.png";
} else {
 $company_logo = DOMAIN . "/storage/company/$company_id/img/$company_logo";
}

$OTP = $_POST['OTP_SUBMITED'];
$REQUIRE_OTP = $_SESSION['SUBMITED_OTP'];
$_SESSION['ORIGINAL_OTP'] = $_SESSION['SUBMITED_OTP'];
$_SESSION['OTP_SUBMITTED'] = POST("OTP_SUBMITED");
if ($REQUIRE_OTP === $OTP) {
 echo $REQUIRE_OTP;
 $_SESSION['REQUESTED_MAIL_ID'] = $_SESSION['REQUESTED_MAIL_ID'];
} else {
 $_SESSION['warning'] = "Please Enter Valid OTP.";
 LOCATION("warning", "Please Enter Valid OTP. Submited OTP is incorrect!", "../verify");
}

$DeviceType = DEVICE_TYPE();
if ($DeviceType == "Computer") {
 $loginBG = "auth-bg.gif";
} else {
 $loginBG = "login-bg2.jpg";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <title>Change Password | <?php echo $APP_NAME; ?></title>
 <?php include '../../include/header_files.php'; ?>
</head>

<body data-new-gr-c-s-check-loaded="0 !important" class="login-bg" style="background-image: url('<?php echo $APP_DOMAIN; ?>/storage/sys-img/<?php echo $loginBG; ?>');">
 <div id="container">
  <!-- LOGIN FORM -->
  <!--===================================================-->
  <div class="lock-wrapper">
   <div class="row">
    <div class="col-md-12 p-3 text-center">
     <div class="lock-box">
      <div class="main">
       <center>
        <span class="w-100 justify-content-center d-block mx-auto p-5">
         <img src="<?php echo $company_logo; ?>" class="img-fluid login-logo" style="width:25% !important;">
        </span>
        <h3 class="mt-0 mb-0"><?php echo $company_name; ?></h3>
       </center>
       <h3 class="mt-0 mb-0 text-left"> Change Password <?php echo $OTP; ?> | <?php echo $REQUIRE_OTP; ?></h3>
       <HR class="mt-1 mb-1">
       <form class="login-form" action="" method="POST">
        <div class="form-group text-left">
         <p><small>Please Enter Your New Password</small></p>
         <label for="inputUsernameEmail">New Password</label>
         <input type="text" name="NEW_PASSWORD" class="form-control" value="" required="">
        </div>
        <div class="form-group text-left">
         <label for="inputUsernameEmail">Re-Enter Password</label>
         <input type="text" name="NEW_PASSWORD_2" class="form-control" value="" required="">
        </div>
        <button type="submit" name="UPDATE_PASSWORD" value="<?php echo $Token; ?>" class="btn btn-block btn-primary">
         Change Password
        </button>
       </form>
       <hr>
       <?php include '../../include/extra/auth_footer.php'; ?>
       <?php include '../../include/extra/created_by.php'; ?>
      </div>
     </div>
    </div>

   </div>
  </div>
 </div>
 <script>
  timeLeft = 31;

  function countdown() {
   timeLeft--;
   document.getElementById("countdown").innerHTML = String(timeLeft);
   if (timeLeft > 0) {
    setTimeout(countdown, 1000);
   }
   if (timeLeft === 0) {
    document.getElementById("sendagainbtn").classList.remove("disabled");
    document.getElementById("datahide").style.display = "none";
   }
  };

  setTimeout(countdown, 1000);
 </script>
 <?php include '../../include/footer_files.php'; ?>
</body>

</html>
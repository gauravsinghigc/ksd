<?php
if (!isset($_SESSION['UserId'])) {
  $_SESSION['UserId'] = 0;
}
ini_set("display_errors", 1);
require "../../require/modules.php";
require "../../require/admin/sessionvariables.php";
$_SESSION['loginRequest'] = VALIDATOR_REQ;
$_SESSION['url'] = "../auth/forget";


//send again OTP o
if (isset($_POST['SEND_AGAIN_OTP'])) {
  $SubmittedEmail = $_SESSION['REQUESTED_MAIL_ID'];

  $ifMailExits = SELECT("SELECT * FROM users where email='$SubmittedEmail'");
  $CountEmails = mysqli_num_rows($ifMailExits);
  if ($CountEmails != 0) {
    $FetchData = mysqli_fetch_array($ifMailExits);
    $UserName = $FetchData['name'];
    $_SESSION['success'] = "One Time Password (OTP) is sent successully at registered mail id : $SubmittedEmail";

    //create OTP
    $OTP_CREATED = Rand(111111, 9999999);
    $_SESSION['SUBMITED_OTP'] = $OTP_CREATED;
    SENDMAILS(
      "One Time Password Received : $OTP_CREATED",
      "Dear, $UserName",
      "$SubmittedEmail",
      "<span style='font-size:2rem;'>$OTP_CREATED</span>,<br> is your one time password for reset password. Please verify your account first and then reset password"
    );
  } else {
    $true = false;
    $_SESSION['warning'] = "$SubmittedEmail is not linked to any User";
    RESPONSE($true, "", "No Registered Account is found with $SubmittedEmail!");
  }
}

//check otp submitted or generated
if (isset($_POST['CHECK_OTP_STATUS'])) {
  $OTP_SUBMITED = $_POST["OTP_SUBMITED"];
  $_SESSION['OTP_GIVEN'] = $OTP_SUBMITED;
  $OTP_GENERATED = $_SESSION['SUBMITED_OTP'];

  if ($OTP_SUBMITED == $OTP_GENERATED) {
    $DisplayPasswordResetOptions = "";
    $OTPSteps = "hidden=''";
    $_SESSION["success"] = "OTP Verified!";
  } else {
    $DisplayPasswordResetOptions = "hidden=''";
    $OTPSteps = "";
    $_SESSION["warning"] = "Invalid OTP Provided!";
  }
} else {
  $DisplayPasswordResetOptions = "hidden=''";
  $OTPSteps = "";
}

//update password
if (isset($_POST["UPDATE_PASSWORD"])) {
  $NEW_PASSWORD = $_POST["NEW_PASSWORD"];
  $NEW_PASSWORD_2 = $_POST["NEW_PASSWORD_2"];

  if ($NEW_PASSWORD == $NEW_PASSWORD_2) {
    $EnteredMailId = $_SESSION['REQUESTED_MAIL_ID'];

    $Update  = UPDATE("UPDATE users SET password='$NEW_PASSWORD' where email='$EnteredMailId'");
    if ($Update == true) {
      $ifMailExits = SELECT("SELECT * FROM users where email='$SubmittedEmail'");
      $FetchData = mysqli_fetch_array($ifMailExits);
      $UserName = $FetchData['name'];

      SENDMAILS(
        "Password Changed @ " . APP_NAME,
        "Dear, $UserName",
        "$EnteredMailId",
        "Your Password at <b>" . APP_NAME . "</b> is changed successfully. If this is done by you then Login with new password from this time. <br> If this is not done by you we request you to change your Password as soon as possible. <br> To Change your password visit: $DOMAIN. <br>"
      );

      $_SESSION['success'] = "Password Changed!";
      header("location: ../login/");
    } else {
      $_SESSION['warning'] = "Unable to Change Password! Please try again...";
      header("location: ../forget/");
    }
  } else {
    $DisplayPasswordResetOptions = "";
    $OTPSteps = "hidden=''";
    $_SESSION["warning"] = "Password Do Not Matched!";
  }
}

if (DEVICE_TYPE == "Computer") {
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
  <title>Verify | <?php echo APP_NAME; ?></title>
  <?php include '../../include/header_files.php'; ?>
</head>

<body data-new-gr-c-s-check-loaded="0 !important" class="login-bg" style="background-image: url('<?php echo STORAGE_URL; ?>/sys-img/<?php echo $loginBG; ?>');">
  <div id="container">
    <!-- LOGIN FORM -->
    <!--===================================================-->
    <div class="lock-wrapper" <?php echo $OTPSteps; ?>>
      <div class="row">
        <div class="col-md-12 p-3 text-center">
          <div class="lock-box">
            <div class="main">
              <center>
                <span class="w-100 justify-content-center d-block mx-auto p-5">
                  <img src="<?php echo company_logo; ?>" class="img-fluid login-logo" style="width:25% !important;">
                </span>
                <h3 class="mt-0 mb-0"><?php echo company_name; ?></h3>
              </center>
              <h3 class="mt-0 mb-0 text-left"> Verify Account</h3>
              <HR class="mt-1 mb-1">
              <form class="login-form" action="" method="POST">
                <?php FormPrimaryInputs(true); ?>
                <div class="form-group text-left">
                  <p><small>Enter OTP sent on : <b><?php echo $_SESSION['REQUESTED_MAIL_ID']; ?></b></small></p>
                  <label>Enter OTP</label>
                  <input type="text" name="OTP_SUBMITED" class="form-control" value="" placeholder="******" style="height: 45px !important;font-size: 1.5rem !important;letter-spacing: 2rem;text-align: center !important;font-weight:700;">
                </div>
                <button type="submit" name="CHECK_OTP_STATUS" value="<?php echo $Token; ?>" onclick="actionBtn('checkaccount', 'Checking OTP...')" id="checkaccount" class="btn btn-block btn-primary">
                  Verify Account
                </button>
              </form>
              <form action="" class="flex-s-b p-t-10" method="POST">
                <button class="btn btn-sm btn-dark disabled" type="submit" name="SEND_AGAIN_OTP" onclick="actionBtn('sendagainbtn', 'Sending...')" id="sendagainbtn">Send Again</button>
                <span class="p-2 bg-info br30" id="datahide"><span><i class="fa fa-spinner fa-spin"></i> <span id="countdown"></span></span></span>
              </form>
              <p class="p-3 text-center m-b-0"><a href="<?php echo DOMAIN; ?>/auth/login">Know Password?</a></p>
              <?php include '../../include/extra/auth_footer.php'; ?>
              <?php include '../../include/extra/created_by.php'; ?>


            </div>

          </div>
        </div>
      </div>
    </div>

    <br><br><br><br>
    <div class="lock-wrapper" <?php echo $DisplayPasswordResetOptions; ?>>
      <div class="row mt-5">
        <div class="col-md-12 pt-5 text-right">
          <div class="lock-box mt-lg-5">
            <br><br>
            <div class="main mt-5 mt-lg-4">
              <center>
                <span class="w-100 justify-content-center d-block mx-auto p-5">
                  <img src="<?php echo company_logo; ?>" class="img-fluid login-logo" style="width:25% !important;">
                </span>
                <h3 class="mt-0 mb-0"><?php echo company_name; ?></h3>
              </center>
              <h3 class="mt-0 mb-0 text-left">| Change Password</h3>
              <HR class="mt-1 mb-1">
              <form class="login-form" action="" method="POST">
                <div class="form-group text-left">
                  <p><small id="passwordmsg"></small></p>
                  <label for="inputUsernameEmail">New Password</label>
                  <input type="password" name="NEW_PASSWORD" id="pass1" class="form-control" oninput="CheckPassword()" value="" required="">
                </div>
                <div class="form-group text-left">
                  <label for="inputUsernameEmail">Re-Enter Password</label>
                  <input type="password" name="NEW_PASSWORD_2" id="pass2" class="form-control" oninput="CheckPassword()" value="" required="">
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
    function CheckPassword() {
      var pass1 = document.getElementById("pass1").value;
      var pass2 = document.getElementById("pass2").value;
      if (pass1 === pass2 && pass1 != "" && pass2 != "") {
        document.getElementById("passwordmsg").classList.remove("text-danger");
        document.getElementById("passwordmsg").classList.add("text-success");
        document.getElementById("passwordmsg").innerHTML = " <i class='fa fa-check-circle'></i> Password Matched!";
      } else if (pass1 == "" && pass2 == "") {
        document.getElementById("passwordmsg").innerHTML = "";
      } else {
        document.getElementById("passwordmsg").classList.remove("text-success");
        document.getElementById("passwordmsg").classList.add("text-danger");
        document.getElementById("passwordmsg").innerHTML = "<i class='fa fa-warning'></i> Password Do Not Matched!";
      }
    }
  </script>

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
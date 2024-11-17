<?php
require "../../require/modules.php";
require "../../require/admin/sessionvariables.php";

$_SESSION['loginRequest'] = VALIDATOR_REQ;
$_SESSION['url'] = "../auth/forget";

if (DEVICE_TYPE == "Computer") {
  $loginBG = "auth-bg.gif";
} else {
  $loginBG = "login-bg2.jpg";
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Password Reset | <?php echo APP_NAME; ?></title>
  <?php include '../../include/header_files.php'; ?>
</head>

<body data-new-gr-c-s-check-loaded="0 !important" class="login-bg" style="background-image: url('<?php echo STORAGE_URL; ?>/sys-img/<?php echo $loginBG; ?>');">
  <?php include '../../include/body_files.php'; ?>

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
                  <img src="<?php echo company_logo; ?>" class="img-fluid login-logo" style="width:25% !important;">
                </span>
                <h3 class="mt-0 mb-0"><?php echo company_name; ?></h3>
              </center>
              <h3 class="mt-0 mb-0 text-left"> Password Reset</h3>
              <HR class="mt-1 mb-1">
              <form class="login-form" action="<?php echo CONTROLLER; ?>/authcontroller.php" method="POST">
                <?php FormPrimaryInputs(true); ?>
                <div class="form-group text-left">
                  <p><small>Enter Your Registered Mail Id</small></p>
                  <label for="inputUsernameEmail">Email Id</label>
                  <input type="email" name="email" class="form-control" id="inputUsernameEmail">
                </div>
                <button type="submit" name="PasswordReseteRequest" class="btn btn-block btn-primary" onclick="actionBtn('Checkaccount', 'Searching Account...')" id="Checkaccount">
                  Reset Password
                </button>
                <p class="p-3 text-center m-b-0"><a href="<?php echo DOMAIN; ?>/auth/login">Know Password?</a></p>
                <?php include '../../include/extra/auth_footer.php'; ?>
                <?php include '../../include/extra/created_by.php'; ?>
              </form>

            </div>

          </div>
        </div>

      </div>
    </div>

    <?php include '../../include/footer_files.php'; ?>
</body>

</html>
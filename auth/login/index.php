<?php
require "../../require/modules.php";
require "../../require/admin/sessionvariables.php";
$_SESSION['loginRequest'] = VALIDATOR_REQ;
$_SESSION['url'] = "../auth/login";

//check login status
if (isset($_SESSION['UserId'])) {
    header("location: " . DOMAIN . "/dashboard");
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
    <title>Login | <?php echo APP_NAME; ?></title>
    <?php include '../../include/header_files.php'; ?>
</head>

<body data-new-gr-c-s-check-loaded="0 !important" class="login-bg" style="background-image: url('<?php echo STORAGE_URL; ?>/sys-img/<?php echo $loginBG; ?>');">
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
                            <h3 class="mt-0 mb-0 text-center"><i class="fa fa-user text-success"></i> Login into Your Account</h3>
                            <div>
                                <hr class="mb-1 mt-1 pt-1 pb-1">
                            </div>
                            <form class="login-form" action="../../controller/authcontroller.php" method="POST">
                                <?php FormPrimaryInputs(true); ?>
                                <div class="form-group text-left">
                                    <label for="inputUsernameEmail">Email Id</label>
                                    <input type="email" name="email" class="form-control m-t-2 fs-15" style="margin-top:0.3rem !important;">
                                </div>
                                <div class="form-group text-left">
                                    <label for="inputPassword">Password</label>
                                    <input type="password" name="password" class="form-control" style="margin-top:0.3rem !important;">
                                </div>
                                <button type="submit" name="loginRequest" value="<?php echo VALIDATOR_REQ; ?>" class="btn btn-block display-1 btn-lg btn-primary">
                                    <i class="fa fa-lock fs-14"></i> Secured Login
                                </button>
                                <p class="p-3 text-center m-b-0"><a href="<?php echo DOMAIN; ?>/auth/forget">Forgot password?</a></p>
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
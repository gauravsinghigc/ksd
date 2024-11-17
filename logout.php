<?php
session_start();
session_destroy();
if (isset($_COOKIE['UserId'])) {
  $UserId = $_COOKIE['UserId'];
  setcookie('UserId', $UserId, time() - 60 * 60 * 365);
  header("location: auth/index.php?msg=Logout!");
} else {
  session_start();
  $_SESSION['info'] = "Logout Successfully!";
  header("location: auth/index.php?msg=Logout!");
}

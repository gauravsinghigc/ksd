<?php
if (isset($_GET['proid'])) {
 $ProjectId = $_GET['proid'];
 $_SESSION['VIEW_PROJECT_ID'] = $ProjectId;
} else {
 if (isset($_SESSION['VIEW_PROJECT_ID'])) {
  if (isset($_GET['proid'])) {
   $ProjectId = $_GET['proid'];
   $_SESSION['VIEW_PROJECT_ID'] = $ProjectId;
  } else {
   $ProjectId = $_SESSION['VIEW_PROJECT_ID'];
  }
 } else {
  $ProjectId = $_SESSION['VIEW_PROJECT_ID'];
 }
}

if (isset($_GET['GetProjectBlock'])) {
 $ProjectBlockID = $_GET['GetProjectBlock'];
 $_SESSION['VIEW_PROJECT_BLOCK_ID'] = $ProjectBlockID;
} else {
 if (isset($_SESSION['VIEW_PROJECT_BLOCK_ID'])) {
  if (isset($_GET['GetProjectBlock'])) {
   $ProjectBlockID = $_GET['GetProjectBlock'];
   $_SESSION['VIEW_PROJECT_BLOCK_ID'] = $ProjectBlockID;
  } else {
   $ProjectBlockID = $_SESSION['VIEW_PROJECT_BLOCK_ID'];
  }
 } else {
  $ProjectBlockID = null;
 }
}

$ProjectSQL = "SELECT * FROM projects where Projects_id='$ProjectId'";

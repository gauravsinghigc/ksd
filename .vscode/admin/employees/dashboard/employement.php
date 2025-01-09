<?php
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Dashboard | <?php echo company_name; ?></title>
   <?php include '../../../include/header_files.php'; ?>
</head>

<body>
   <div id="container" class="navbar-fixed mainnav-fixed mainnav-lg">
      <?php include '../../header.php';
      if (isset($_GET['id'])) {
         $ViewCustomerId = $_GET['id'];
         $_SESSION['USER_VIEW_ID'] = $_GET['id'];
      } else {
         $ViewCustomerId = $_SESSION['USER_VIEW_ID'];
      }
      $CustomerId = $ViewCustomerId;
      $Select_Users = "SELECT * FROM users where id='$CustomerId'";
      $Query = mysqli_query($DBConnection, $Select_Users);
      $Customers = mysqli_fetch_assoc($Query);
      $C_user_role_id = $Customers['user_role_id'];
      $C_name = $Customers['name'];
      $C_email = $Customers['email'];
      $C_phone = $Customers['phone'];
      $C_user_profile_img = $Customers['user_profile_img'];
      $C_created_at = $Customers['created_at'];
      $C_updated_at = $Customers['updated_at'];
      $C_password = $Customers['password'];
      $C_company_relation_id = $Customers['company_relation'];
      if ($C_user_profile_img == null or $C_user_profile_img == "user.png") {
         $C_user_profile_img = DOMAIN . "/storage/sys-img/user.png";
      } else {
         $C_user_profile_img = DOMAIN . "/storage/users/$CustomerId/img/$C_user_profile_img";
      }
      //customer address
      $C_FetchAddress = SELECT("SELECT * FROM user_address where user_id='$CustomerId'");
      $C_IfExits = mysqli_num_rows($C_FetchAddress);
      if ($C_IfExits == 0) {
         $C_user_street_address = "";
         $C_user_area_locality = "";
         $C_user_state = "";
         $C_user_city = "";
         $C_user_pincode = "";
         $C_created_at = "";
         $C_updated_at = "";
         $C_user_country = "";
      } else {
         $C_fetchAdd = mysqli_fetch_array($C_FetchAddress);
         $C_user_street_address = htmlentities($C_fetchAdd['user_street_address']);
         $C_user_area_locality = $C_fetchAdd['user_area_locality'];
         $C_user_city = $C_fetchAdd['user_city'];
         $C_user_state = $C_fetchAdd['user_state'];
         $C_user_pincode = $C_fetchAdd['user_pincode'];
         $C_user_country = $C_fetchAdd['user_country'];
         $C_created_at = $C_fetchAdd['created_at'];
         $C_updated_at = $C_fetchAdd['updated_at'];
      }

      //customer type
      $C_Select_UsersTypes = SELECT("SELECT * from user_roles where role_id='$C_user_role_id'");
      $C_UserTypes = mysqli_fetch_assoc($C_Select_UsersTypes);
      $C_role_name = $C_UserTypes['role_name'];

      //employeement 
      $EmpSql = "SELECT * FROM user_employments where UserEmpMainUserId='$ViewCustomerId'"; ?>
      <!--END NAVBAR-->
      <div class="boxed">
         <!--CONTENT CONTAINER-->
         <!--===================================================-->
         <div id="content-container">
            <!--Page content-->
            <!--===================================================-->
            <div id="page-content">
               <div class="panel">
                  <div class="panel-body">
                     <div class="row">
                        <div class="col-md-12">
                           <h3 class="m-t-3"><i class="fa fa-user app-text"></i> Employee Details</h3>
                        </div>
                        <?php include "c-profile.php"; ?>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xs-12 c-dashboard-padding">
                           <?php include "common-nav.php"; ?>
                        </div>
                     </div>

                     <div class="row">
                        <div class="col-md-12">
                           <h4 class="section-heading">Employement Information</h4>
                        </div>
                     </div>

                     <form action="<?php echo CONTROLLER; ?>/empcontroller.php" method="POST">
                        <?php FormPrimaryInputs(
                           true,
                           [
                              "req_data_for" => $ViewCustomerId,
                           ]
                        ); ?>
                        <div class="row mb-10px">
                           <div class="form-group col-lg-4 col-md-4 col-sm-4">
                              <label>Company Work Fields/Environment</label>
                              <input type="text" name="UserWorkFeilds" list="UserWorkFeilds" value="<?php echo FETCH($EmpSql, "UserWorkFeilds"); ?>" class="form-control" placeholder="electronics, garments, media etc">
                              <?php echo SUGGEST("user_employments", "UserWorkFeilds", "ASC"); ?>
                           </div>
                           <div class="form-group col-lg-4 col-md-4 col-sm-4">
                              <label>Work Department</label>
                              <input type="text" name="UserDepartment" list="UserDepartment" value="<?php echo FETCH($EmpSql, "UserDepartment"); ?>" class="form-control" placeholder="IT, HR, Account, Sales, Marketing etc">
                              <?php echo SUGGEST("user_employments", "UserDepartment", "ASC"); ?>
                           </div>
                           <div class="form-group col-lg-4 col-md-4 col-sm-4">
                              <label>Designation</label>
                              <input type="text" name="UserDesignation" list="UserDesignation" value="<?php echo FETCH($EmpSql, "UserDesignation"); ?>" class="form-control" placeholder="accountant, hr, sale executing, director etc">
                              <?php echo SUGGEST("user_employments", "UserDesignation", "ASC"); ?>
                           </div>
                        </div>
                        <div class="row mb-10px">
                           <div class="form-group col-md-3">
                              <label>Joining Date</label>
                              <input type="date" name="UserJoinningDate" value="<?php echo FETCH($EmpSql, 'UserJoinningDate'); ?>" class="form-control">
                           </div>
                           <div class="form-group col-md-3">
                              <label>Work Days (in Month)</label>
                              <input type="text" name="UserEmpWorkDays" value="<?php echo FETCH($EmpSql,  "UserEmpWorkDays"); ?>" class="form-control">
                           </div>
                           <div class="form-group col-md-3">
                              <label>Working Hour (in Day)</label>
                              <input type="text" name="UserEmpWorkHours" value="<?php echo FETCH($EmpSql,  "UserEmpWorkHours"); ?>" class="form-control">
                           </div>
                        </div>
                        <div class="row mb-10px">
                           <div class="col-md-12">
                              <button type="submit" name="UpdateEmploymentDetails" class="btn btn-md btn-success">Update Employement Details</button>
                           </div>
                        </div>
                     </form>

                     <form action="<?php echo CONTROLLER; ?>/empcontroller.php" method="POST">
                        <?php FormPrimaryInputs(true, [
                           "req_data_for" => $ViewCustomerId,
                        ]); ?>
                        <div class="row">
                           <div class="col-md-12">
                              <h5 class="app-sub-heading">Pay Scale Details</h5>
                           </div>
                           <div class="col-md-3 form-group">
                              <label>Pay Rate</label>
                              <input type="text" name="UserPayScale" value="<?php echo FETCH("SELECT * FROM user_pay_scale where UserMainUserId='$ViewCustomerId'", "UserPayScale"); ?>" class="form-control" placeholder="Rs.100">
                           </div>
                           <div class="col-md-3 form-group">
                              <label>Pay Frequency</label>
                              <select class="form-control" name="UserPayFrequency" required="">
                                 <?php InputOptions(["PerWork", "Daily", "Weekly", "Weekly", "Monthly"], FETCH("SELECT * FROM user_pay_scale where UserMainUserId='$ViewCustomerId'", "UserPayFrequency")); ?>
                              </select>
                           </div>
                           <div class="col-md-3 form-group">
                              <label>Pay Type</label>
                              <select class="form-control" name="UserPayType" required="">
                                 <?php InputOptions(["Salary", "Reimbursement", "Incentive", "Stipends", "ServiceCost"], FETCH("SELECT * FROM user_pay_scale where UserMainUserId='$ViewCustomerId'", "UserPayType")); ?>
                              </select>
                           </div>
                           <div class="col-md-3 form-group">
                              <label>Pay Start From</label>
                              <input type="date" name="UserPayStartFrom" class="form-control" value="<?php echo FETCH("SELECT * FROM user_pay_scale where UserMainUserId='$ViewCustomerId'", "UserPayStartFrom"); ?>" value="<?php echo date('Y-m-d'); ?>">
                           </div>
                           <div class="col-md-3 form-group">
                              <label>Paying Date</label>
                              <input type="date" name="UserPayDate" class="form-control" value="<?php echo FETCH("SELECT * FROM user_pay_scale where UserMainUserId='$ViewCustomerId'", "UserPayDate"); ?>" value="<?php echo date('Y-m-d'); ?>">
                           </div>
                           <div class="col-md-12 form-group">
                              <label>Pay Notes</label>
                              <textarea name="UserPayNotes" class="form-control" rows="3"><?php echo SECURE(FETCH("SELECT * FROM user_pay_scale where UserMainUserId='$ViewCustomerId'", "UserPayNotes"), "d"); ?></textarea>
                           </div>
                           <div class="col-md-12">
                              <button type="submit" name="UpdatePayScaleRecords" class="btn btn-md btn-success">Update Pay Records</button>
                           </div>
                        </div>
                     </form>
                     <form action="<?php echo CONTROLLER; ?>/empcontroller.php" method="POST">
                        <?php FormPrimaryInputs(true, [
                           "UserBankMainUserId" => $ViewCustomerId,
                        ]); ?>
                        <div class="row">
                           <div class="col-md-12">
                              <h5 class="app-sub-heading">Bank Details</h5>
                           </div>
                           <div class="col-md-4 form-group">
                              <label>Bank Name</label>
                              <input type="text" name="UserBankName" value="<?php echo FETCH("SELECT * FROM user_bank_details where UserBankMainUserId='$ViewCustomerId'", "UserBankName"); ?>" class="form-control">
                           </div>
                           <div class="col-md-4 form-group">
                              <label>Account Holder Name</label>
                              <input type="text" name="UserBankAccounHolderName" value="<?php echo FETCH("SELECT * FROM user_bank_details where UserBankMainUserId='$ViewCustomerId'", "UserBankAccounHolderName"); ?>" class="form-control">
                           </div>
                           <div class="col-md-4 form-group">
                              <label>Account Number</label>
                              <input type="text" name="UserBankAccountNumber" value="<?php echo FETCH("SELECT * FROM user_bank_details where UserBankMainUserId='$ViewCustomerId'", "UserBankAccountNumber"); ?>" class="form-control">
                           </div>
                           <div class="col-md-4 form-group">
                              <label>Bank IFSC Code</label>
                              <input type="text" name="UserBankAccountIFSC" value="<?php echo FETCH("SELECT * FROM user_bank_details where UserBankMainUserId='$ViewCustomerId'", "UserBankAccountIFSC"); ?>" class="form-control">
                           </div>
                           <div class="col-md-12 form-group">
                              <label>Notes/Remarks</label>
                              <textarea class="form-control" name="UserBankOtherDetails" rows="3"><?php echo SECURE(FETCH("SELECT * FROM user_bank_details where UserBankMainUserId='$ViewCustomerId'", "UserBankOtherDetails"), "d"); ?></textarea>
                           </div>
                           <div class="col-md-12 text-right">
                              <button class="btn btn-success btn-md" name="UpdateBankDetails">Update Bank Details</button>
                              <hr>
                           </div>
                        </div>
                     </form>

                  </div>
               </div>
            </div>
         </div>
      </div>

      <!-- end -->
      <?php include '../../sidebar.php'; ?>
      <?php include '../../footer.php'; ?>
   </div>

   <?php include '../../../include/footer_files.php'; ?>
</body>

</html>
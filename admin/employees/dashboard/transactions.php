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
  $EmpSql = "SELECT * FROM user_employments where UserEmpMainUserId='$ViewCustomerId'";
  $REQ_UserId = $ViewCustomerId; ?>
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
         <h4 class="section-heading">Transactions Record</h4>
        </div>
       </div>

       <form method="post" action="<?php echo CONTROLLER; ?>/empcontroller.php">
        <?php FormPrimaryInputs(true, [
         "UserTxnMainUserId" => $REQ_UserId
        ]); ?>
        <div class="row">
         <div class="col-md-2 form-group">
          <label>Txn Date</label>
          <input type="date" name="UserTxnDate" class="form-control" value="<?php echo date("Y-m-d"); ?>">
         </div>

         <div class="col-md-2 form-group">
          <label>Txn Type</label>
          <select name="UserTxnType" class="form-control" required="">
           <option value="Others">Select Txn Type</option>
           <?php InputOptions(EMP_TXN_TYPES, null); ?>
          </select>
         </div>

         <div class="col-md-2 form-group">
          <label>Txn Amount</label>
          <input type="text" name="UserTxnAmount" class="form-control" value="" required placeholder="Rs.10,000">
         </div>

         <div class="col-md-2 form-group">
          <label>Txn Status</label>
          <select name="UserTxnStatus" class="form-control" required>
           <option value="null">Select Payment Status</option>
           <?php InputOptions(PAID_UNPAID_STATUS, null); ?>
          </select>
         </div>

         <div class="col-md-3 form-group">
          <label>Notes/Remarks</label>
          <textarea class="form-control" name="UserTxnDetails" rows="1"></textarea>
         </div>
         <div class="col-md-12 text-right">
          <button class="btn btn-md btn-success" name="UserTransactionRecords">Add Txn Record <i class="fa fa-angle-right"></i></button>
         </div>
        </div>
       </form>

       <div class="row">
        <div class="col-md-12">
         <h5 class="app-sub-heading">Transactions History</h5>
         <table class="table table-striped">
          <thead>
           <tr>
            <th>Sno</th>
            <th>RefId</th>
            <th>TxnDate</th>
            <th>TxnAmount</th>
            <th>Type</th>
            <th>TxnStatus</th>
            <th>TxnCreatedAt</th>
            <th>Note</th>
            <th>Action</th>
           </tr>
          </thead>
          <tbody>
           <?php
           $UserTxnSqls = "SELECT * FROM user_transactions where UserTxnMainUserId='$REQ_UserId' ORDER BY DATE('UserTxnDate') DESC";
           $FetchTxnRecords = FetchConvertIntoArray($UserTxnSqls, true);
           if ($FetchTxnRecords == null) {
            NoDataTableView("No Txn Record Found", 8);
           } else {
            $Sno = 0;
            $TotalCalculatedAmount = 0;
            foreach ($FetchTxnRecords as $Data) {
             $Sno++;
             $TotalCalculatedAmount += $Data->UserTxnAmount;  ?>
             <tr>
              <td><?php echo $Sno; ?></td>
              <td><span class="bold text-primary"><?php echo $Data->TxnCustomRefId; ?></span></td>
              <td><?php echo DATE_FORMATE2("d M, Y", $Data->UserTxnDate); ?></td>
              <td><?php echo Price(number_format($Data->UserTxnAmount), "text-success", "Rs."); ?></td>
              <td><?php echo $Data->UserTxnType; ?></td>
              <td><?php echo PayStatus($Data->UserTxnStatus); ?></td>
              <td><?php echo DATE_FORMATE2("d M, Y", $Data->UserTxnCreatedAt); ?></td>
              <td><?php echo SECURE($Data->UserTxnDetails, "d"); ?></td>
              <td>
               <a href="<?php echo E_DOC_URL; ?>/txn-receipt.php?txnid=<?php echo SECURE($Data->UserTxnid, "e"); ?>">View Receipt</a>
              </td>
             </tr>
            <?php } ?>
            <tr>
             <td colspan="3"></td>
             <td><?php echo Price($TotalCalculatedAmount, "text-success bold", "Rs."); ?></td>
             <td colspan="5"></td>
            </tr>
           <?php
           } ?>
          </tbody>
         </table>
        </div>
       </div>
      </div>
     </div>
    </div>
   </div>


   <!--=====
    </==============================================-->
   <!--End page content-->
  </div>
  <!--===================================================-->




  <!-- end -->
  <?php include '../../sidebar.php'; ?>
  <?php include '../../footer.php'; ?>
 </div>

 <?php include '../../../include/footer_files.php'; ?>
</body>

</html>
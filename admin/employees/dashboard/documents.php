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
                           <h4 class="section-heading">Add Documents</h4>
                        </div>
                     </div>

                     <form method="post" action="<?php echo CONTROLLER; ?>/empcontroller.php" enctype="multipart/form-data">
                        <?php FormPrimaryInputs(true, [
                           "UserDocMainUserid" => $REQ_UserId
                        ]) ?>
                        <div class="row">
                           <div class="col-md-3 form-group">
                              <label>Document Name</label>
                              <input type="text" name="document_name" list="doc_name" class="form-control" required="">
                              <datalist id="doc_name">
                                 <?php foreach (DOC_NAME as $docs) { ?>
                                    <option value="<?php echo $docs; ?>"></option>
                                 <?php } ?>
                              </datalist>
                           </div>
                           <div class="col-md-3 form-group">
                              <label>Document Number/ID No</label>
                              <input type="text" name="user_documents_no" class="form-control text-uppercase uppercase" required="">
                           </div>
                           <div class="col-md-4 form-group">
                              <label>Select Document (png, jpeg, pdf, images)</label>
                              <input type="file" name="document_file" class="form-control" required="" accept="image/*">
                           </div>
                           <div class="col-md-2 form-group">
                              <button class="btn btn-md btn-success mt-25px" name="UploadDocuments">Upload Documents</button>
                           </div>
                        </div>
                     </form>

                     <div class="row">
                        <div class="col-md-12">
                           <h5 class="app-sub-heading">Available Documents</h5>
                           <table class="table table-striped">
                              <thead>
                                 <tr>
                                    <th>Sno</th>
                                    <th>Name</th>
                                    <th>Number</th>
                                    <th>UploadAt</th>
                                    <th>File</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php
                                 $GetDocumnets = FetchConvertIntoArray("SELECT * FROM user_documents where user_id='$REQ_UserId'", true);
                                 if ($GetDocumnets == null) {
                                    NoDataTableView("No Documents Found, PLease upload documents firsts", 6);
                                 } else {
                                    $Sno = 0;
                                    foreach ($GetDocumnets as $Documents) {
                                       $Sno++; ?>
                                       <tr>
                                          <td><?php echo $Sno; ?></td>
                                          <td><?php echo $Documents->document_name; ?></td>
                                          <td><?php echo $Documents->user_documents_no; ?></td>
                                          <td><?php echo DATE_FORMATE2("d M, Y", $Documents->document_created_at); ?></td>
                                          <td>
                                             <a target="_blank" href="<?php echo STORAGE_URL_U; ?>/documents/<?php echo $Documents->document_file; ?>" class="text-primary"><?php echo $Documents->document_file; ?></a>
                                          </td>

                                       </tr>
                                    <?php }
                                    ?>
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
      </div>


      <!-- end -->
      <?php include '../../sidebar.php'; ?>
      <?php include '../../footer.php'; ?>
   </div>

   <?php include '../../../include/footer_files.php'; ?>
</body>

</html>
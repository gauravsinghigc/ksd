<?php
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';

if (isset($_GET['id'])) {
  $ViewCustomerId = $_GET['id'];
  $_SESSION['USER_VIEW_ID_CUSTOMER_DASHBOARD'] = $_GET['id'];
} else {
  $ViewCustomerId = $_SESSION['USER_VIEW_ID_CUSTOMER_DASHBOARD'];
}
require "../../../include/admin/page-header-req/user-profile-req.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Dashboard | <?php echo company_name; ?></title>
  <?php include '../../../include/header_files.php'; ?>
  <script>
    window.onload = function() {
      document.getElementById("agent_documents").classList.add("app-bg");
    }
  </script>
</head>

<body>
  <div id="container" class="navbar-fixed mainnav-fixed mainnav-lg">
    <?php include '../../header.php'; ?>
    <!--END NAVBAR-->
    <div class="boxed">
      <!--CONTENT CONTAINER-->
      <!--===================================================-->
      <div id="content-container">
        <!--===================================================-->
        <div id="page-content">
          <div class="panel">
            <div class="panel-body">
              <div class="row">
                <?php include 'user-info.php'; ?>
                <div class="col-md-12">
                  <h4 class="app-sub-heading">All Documents
                    <a href="#" class="btn btn-xs btn-primary float-right" data-toggle="modal" data-target="#add_documents"><i class="fa fa-upload"></i> Upload Document</a>
                  </h4>
                  <div class='row'>
                    <div class="col-md-12">
                      <?php
                      $CustomerId = $ViewCustomerId;
                      $SQL_documents = SELECT("SELECT * FROM user_documents where user_id='$CustomerId'");
                      $SerailNo = 0;
                      while ($FetchDocuments = mysqli_fetch_assoc($SQL_documents)) {
                        $SerailNo++; ?>
                        <div class="data-list flex-s-b">
                          <span class='w-pr-3'>
                            <span class='text-grey'> SNo </span>
                            <br><b><?php echo $SerailNo; ?></b>
                          </span>
                          <span class='w-pr-10'>
                            <span class='text-grey'> DocName</span>
                            <br>
                            <a href="<?php echo DOMAIN; ?>/storage/documents/<?php echo $CustomerId; ?>/<?php echo $FetchDocuments['document_file']; ?>" class="text-primary" target="_blank"><i class='fa fa-print text-danger'></i> <?php echo $FetchDocuments['document_name']; ?></a>
                          </span>
                          <span class='w-pr-15'>
                            <span class='text-grey'> DocumentNo </span>
                            <br><b><?php echo $FetchDocuments['user_documents_no']; ?></b>
                          </span>
                          <span>
                            <span class='text-grey'> DocStatus </span>
                            <br><b><?php echo $FetchDocuments['document_status']; ?></b>
                          </span>
                          <span>
                            <span class='text-grey'> UploadedAt </span>
                            <br><b><?php echo DATE_FORMATE2("d M, Y", $FetchDocuments['document_created_at']); ?></b>
                          </span>
                          <span>
                            <span class='text-grey'> ViewFile </span>
                            <br><a href="<?php echo DOMAIN; ?>/storage/documents/<?php echo $CustomerId; ?>/<?php echo $FetchDocuments['document_file']; ?>" class="text-primary" target="_blank"><i class="fa fa-eye text-success"></i> View File</a>
                          </span>
                          <span>
                            <span class='text-grey'> Action </span><br>
                            <a href="#" class="text-primary" data-toggle="modal" data-target="#edit_documents_<?php echo $FetchDocuments['document_id']; ?>"><i class="fa fa-edit text-info"></i> Update</a>
                          </span>
                        </div>
                        <!-- Modal  3-->
                        <div class="modal fade square" id="edit_documents_<?php echo $FetchDocuments['document_id']; ?>" role="dialog">
                          <div class="modal-dialog modal-md">
                            <div class="modal-content">
                              <div class="modal-header app-bg text-white">
                                <button type="button" class="close text-white m-r-8 m-t-1" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title text-white">Edit Documents</h4>
                              </div>
                              <div class="modal-body overflow-auto">
                                <form action="../../../controller/usercontroller.php" method="POST" enctype="multipart/form-data">
                                  <?php FormPrimaryInputs(true); ?>
                                  <div class="row">
                                    <div class="from-group col-md-12">
                                      <label>Document Name</label>
                                      <input type="text" name="document_name" value="<?php echo $FetchDocuments['document_name']; ?>" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="from-group col-md-12">
                                      <label>Document No</label>
                                      <input type="text" name="user_documents_no" value="<?php echo $FetchDocuments['user_documents_no']; ?>" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="from-group col-md-12">
                                      <label>Attache File</label><br>
                                      <span class="text-info"> <small>Document is not editable, you have to upload next one in case of incorrect and other issue with documents</small></span><br>
                                      <span class="form-control"><?php echo $FetchDocuments['document_file']; ?></span>
                                      <a href="<?php echo DOMAIN; ?>/storage/users/<?php echo $CustomerId; ?>/documents/<?php echo $FetchDocuments['document_file']; ?>" class="btn btn-sm btn-primary" target="_blank"><i class="fa fa-eye"></i> view File</a>
                                    </div>
                                    <div class="from-group col-md-12"><br>
                                      <label>Document Status</label>
                                      <select name="document_status" class="form-control" value="" required="">
                                        <option value="<?php echo $FetchDocuments['document_status']; ?>" selected=""><?php echo $FetchDocuments['document_status']; ?></option>
                                        <option value="Received">Received!</option>
                                        <option value="Checking...">Checking...</option>
                                        <option value="Verified">Verified</option>
                                        <option value="Unverified">Unverified</option>
                                        <option value="Wrong Document">Wrong Documents</option>
                                      </select>
                                    </div>
                                  </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" name="edit_documents" value="<?php echo $FetchDocuments['document_id']; ?>" class="btn btn-success" onclick="actionBtn('edit_<?php echo $FetchDocuments['document_id']; ?>', 'Updating...')" id="edit_<?php echo $FetchDocuments['document_id']; ?>">Save Updates</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php } ?>
                    </div>
                  </div>

                  <!-- Modal  3-->
                  <div class="modal fade square" id="add_documents" role="dialog">
                    <div class="modal-dialog modal-md">
                      <div class="modal-content">
                        <div class="modal-header app-bg text-white">
                          <button type="button" class="close text-white m-r-8 m-t-1" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title text-white">Upload Documents</h4>
                        </div>
                        <div class="modal-body overflow-auto">
                          <form action="../../../controller/usercontroller.php" method="POST" enctype="multipart/form-data">
                            <?php FormPrimaryInputs(
                              true,
                              [
                                "user_id" => $ViewCustomerId,
                              ]
                            ); ?>
                            <div class="row">
                              <div class="from-group col-md-12">
                                <label>Document Name</label>
                                <input type="text" class="form-control" list="documentslist" name="document_name" value="" placeholder="">
                                <datalist id="documentslist">
                                  <option value="PAN CARD"></option>
                                  <option value="ADHAAR CARD"></option>
                                  <option value="VOTAR CARD"></option>
                                  <option value="DRIVING LISCENCE"></option>
                                  <option value="PASSPORT"></option>
                                  <option value="RATION CARD"></option>
                                  <option value="PROPERTY PAPERS"></option>
                                  <option value="REGISTRY"></option>
                                  <option value="GENERAL POWER OF ATTORNY"></option>
                                  <option value="ELECTRICITY BILL"></option>
                                  <option value="WATER BILL"></option>
                                  <option value="MAINTENANCE BILL"></option>
                                  <option value="POSSESSION CERTIFICATE"></option>
                                  <option value="ALLOTMENT LETTER"></option>
                                  <option value="NO OBJECTION CERTIFICATE (NOC)"></option>
                                  <?php $FetchDocuments = FetchConvertIntoArray("SELECT * FROM user_documents GROUP BY document_name ORDER BY document_name DESC", true);
                                  if ($FetchDocuments != null) {
                                    foreach ($FetchDocuments as $Docs) { ?>
                                      <option value="<?php echo $Docs->document_name; ?>"></option>
                                  <?php }
                                  } ?>
                                </datalist>
                              </div>
                              <div class="from-group col-md-12">
                                <label>Document No</label>
                                <input type="text" name="user_documents_no" value="" class="form-control" placeholder="" required="">
                              </div>
                              <div class="from-group col-md-12">
                                <label>Attache File</label><br>
                                <span class="text-info"> <small>Accepted formates : any media file</small></span>
                                <input type="FILE" name="document_file" value="" class="form-control" placeholder="">
                              </div>
                              <div class="from-group col-md-12">
                                <label>Document Status</label>
                                <select name="document_status" class="form-control" value="">
                                  <option value="Received">Received!</option>
                                  <option value="Checking...">Checking...</option>
                                  <option value="Verified">Verified</option>
                                  <option value="Unverified">Unverified</option>
                                  <option value="Wrong Document">Wrong Documents</option>
                                </select>
                              </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="submit" name="upload_documents" value="" class="btn btn-success">Upload Documents</button>
                          </form>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
              <!--===================================================-->
              <!--End Default Tabs (Left Aligned)-->
            </div>
          </div>
        </div>
      </div>
      <!--===================================================-->
      <!--End page content-->
    </div>
    <!--===================================================-->
    <!--END CONTENT CONTAINER-->

    <script>
      function showpayments(data) {
        if (data === "cash") {
          document.getElementById("cash_view").style.visibility = "visible";
          document.getElementById("banking_view").style.visibility = "hidden";
          document.getElementById("check_view").style.visibility = "hidden";
        } else if (data === "banking") {
          document.getElementById("cash_view").style.visibility = "hidden";
          document.getElementById("banking_view").style.visibility = "visible";
          document.getElementById("check_view").style.visibility = "hidden";
        } else if (data === "check") {
          document.getElementById("cash_view").style.visibility = "hidden";
          document.getElementById("banking_view").style.visibility = "hidden";
          document.getElementById("check_view").style.visibility = "visible";
        } else {
          document.getElementById("cash_view").style.visibility = "visible";
          document.getElementById("banking_view").style.visibility = "visible";
          document.getElementById("check_view").style.visibility = "visible";
        }
      }
    </script>

    <!-- end -->
    <?php include '../../sidebar.php'; ?>
    <?php include '../../footer.php'; ?>
  </div>

  <?php include '../../../include/footer_files.php'; ?>
</body>

</html>
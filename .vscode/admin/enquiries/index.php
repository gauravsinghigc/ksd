<?php
require '../../require/modules.php';
require "../../require/admin/sessionvariables.php";
require '../../include/admin/common.php';


$PageName = "Enquiries";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php echo $PageName; ?> | <?php echo company_name; ?></title>
  <?php include '../../include/header_files.php'; ?>
</head>

<body>
  <div id="container" class="navbar-fixed mainnav-fixed mainnav-lg">
    <?php include '../header.php'; ?>

    <!-- main content area -->
    <div class="boxed">
      <!--CONTENT CONTAINER-->
      <!--===================================================-->
      <div id="content-container">
        <!--Page content-->
        <div id="page-content">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-12">
              <div class="panel square">
                <div class="panel-body">
                  <div class="row">
                    <div class="col-md-12">
                      <h3 class="m-t-3"><i class="fa fa-info-circle app-text"></i> Enquiries</h3>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12 col-sm-12 p-l-0 p-r-0">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>S.No</th>
                            <th>Full Name</th>
                            <th>Phone Number</th>
                            <th>Interested In</th>
                            <th>Received At</th>
                            <th>Status</th>
                            <th class="w-pr-15">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $Select = SELECT("SELECT * from equiries ORDER BY status ASC");
                          if ($Select == true) {
                            $Count = 0;
                            while ($Fetch = mysqli_fetch_array($Select)) {
                              $Count++; ?>
                              <tr>
                                <td><?php echo $Count; ?></td>
                                <td><?php echo $Fetch['FullName']; ?></td>
                                <td><?php echo $Fetch['phone']; ?></td>
                                <td><?php echo $Fetch['type']; ?></td>
                                <td><?php echo $Fetch['createdat']; ?></td>
                                <td>
                                  <?php if ($Fetch['status'] == "0") {
                                    echo '<span class="btn text-danger btn-sm font-10">Unread</span>';
                                  } else {
                                    echo '<span class="btn btn-sm text-success font-10">Read</span>';
                                  } ?></span>
                                </td>
                                <td>
                                  <a href="tel:<?php echo $Fetch['phone']; ?>" class="btn btn-sm btn-info"><i class="fa fa-phone"></i></a>
                                  <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#view_enq<?php echo $Fetch['enquiryid']; ?>"><i class="fa fa-eye"></i></a>
                                  <?php CONFIRM_DELETE_POPUP(
                                    "eqnuries",
                                    [
                                      "delete_enquiries" => true,
                                      "control_id" => $Fetch['enquiryid']
                                    ],
                                    "enquirycontroller",
                                    "<i class='fa fa-trash'></i>",
                                    "btn btn-sm btn-danger"
                                  ); ?>
                                  <div class="modal square fade" id="view_enq<?php echo $Fetch['enquiryid']; ?>">
                                    <div class="modal-dialog square">
                                      <div class="modal-content square">
                                        <div class="modal-header app-bg">
                                          <h4 class="modal-title">Enquiry Details</h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                          <h5><b>Name</b> : <?php echo $Fetch['FullName']; ?></h5>
                                          <h5><b>Phone</b> : <?php echo $Fetch['phone']; ?> : <a href="tel:<?php echo $Fetch['phone']; ?>" class="btn btn-sm btn-info">Call</a></h5>
                                          <h5><b>Email</b> : <?php echo $Fetch['email']; ?></h5>
                                          <h5><b>Interested In</b> : <?php echo $Fetch['type']; ?></h5>
                                          <h5><b>Message</b> : <?php echo SECURE("" . $Fetch['message'] . "", "d"); ?></h5>
                                          <form action="<?php echo CONTROLLER; ?>/enquirycontroller.php" method="POST">
                                            <?php FormPrimaryInputs(true, [
                                              "status" => 1,
                                              "enquiryid" => $Fetch['enquiryid']
                                            ]); ?>
                                            <div class="modal-footer justify-content-between">
                                              <button type="button" class="btn btn-default square" data-dismiss="modal">Close</button>
                                              <button type="submit" class="btn btn-md btn-primary" name="ReadEnquiry">Mark as Read</button>
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                      <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                  </div>
                                  <!-- /.modal -->

                                </td>
                              </tr>
                          <?php }
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

      </div>
    </div>




    <!-- end -->
    <?php include '../sidebar.php'; ?>
    <?php include '../footer.php'; ?>
  </div>

  <?php include '../../include/footer_files.php'; ?>
</body>

</html>
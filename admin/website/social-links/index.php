<?php
$Dir = "../../..";
require $Dir . '/require/modules.php';
require $Dir . "/require/admin/sessionvariables.php";
require $Dir . '/include/admin/common.php';

$PageName = "Social Media Links";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title> <?php echo $PageName; ?> | <?php echo company_name; ?></title>
  <?php include $Dir . '/include/header_files.php'; ?>
</head>

<body>
  <div id="container" class="navbar-fixed mainnav-fixed mainnav-lg">
    <?php include '../../header.php'; ?>

    <!--END NAVBAR-->
    <div class="boxed">
      <div id="content-container">
        <div id="page-content">

          <div class="panel">
            <div class="panel-body">
              <div class="row">
                <div class="col-md-12">
                  <h3 class="m-t-3"><i class="fa fa-file app-text"></i> <?php echo $PageName; ?></h3>
                </div>

                <div class="col-md-12">
                  <a href="#" data-toggle="modal" data-target="#add_link" class="btn btn-sm btn-success">Add New</a>
                </div>
                <div class="col-md-12 m-t-4">
                  <table id="example1" class="table table-striped">
                    <thead>
                      <tr>
                        <th>S.No</th>
                        <th>ICON</th>
                        <th>Profile Name</th>
                        <th>test link</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $Select = SELECT("SELECT * from sociallinks");
                      if ($Select == true) {
                        $Count = 0;
                        while ($Fetch = mysqli_fetch_array($Select)) {
                          $Count++; ?>
                          <tr>
                            <td><?php echo $Count; ?></td>
                            <td><span class="bg-primary text-white" style="width:20px !important;height:15px !important;text-align:center !important;padding:0.2rem !important;"><i class="fa <?php echo $Fetch['icon']; ?> text-white"></i></span></td>
                            <td><?php echo $Fetch['title']; ?></td>
                            <td><a href="<?php echo $Fetch['url']; ?>" class="text-primary">Open Link</a></td>
                            <td>
                              <?php STATUS("updatesociallink", "" . $Fetch['linkid'] . "", "" . $Fetch['status'] . ""); ?>
                            </td>
                            <td>
                              <a href="<?php echo $Fetch['url']; ?>" class="btn btn-sm btn-dark" target="_blank"><i class="fa fa-share"></i></a>
                              <a href="#" class="btn btn-info btn-sm square" data-toggle="modal" data-target="#update_link<?php echo $Fetch['linkid']; ?>"><i class="fa fa-edit"></i></a>
                              <?php CONFIRM_DELETE_POPUP(
                                "links",
                                [
                                  "delete_social_links" => true,
                                  "control_id" => $Fetch['linkid']
                                ],
                                "sociallinkcontroller",
                                "<i class='fa fa-trash'></i>",
                                "btn-sm btn btn-danger"
                              ) ?>
                              <div class="modal square fade" id="update_link<?php echo $Fetch['linkid']; ?>">
                                <div class="modal-dialog square modal-lg">
                                  <div class="modal-content square">
                                    <div class="modal-header app-bg">
                                      <h4 class="modal-title">Update Social Links</h4>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <form action="<?php echo CONTROLLER; ?>/sociallinkcontroller.php" method="POST" enctype="multipart/form-data">
                                        <?php FormPrimaryInputs(true); ?>
                                        <div class="form-group">
                                          <label for="ServiceTitle"> Profile Title</label>
                                          <input type="text" name="title" value="<?php echo $Fetch['title']; ?>" class="form-control" required="">
                                        </div>
                                        <div class="form-group">
                                          <label for="ServiceImg">Account Icon</label>
                                          <select class="form-control" name="icon">
                                            <?php echo InputOptions([
                                              "fa-facebook" => "Facebook",
                                              "fa-twitter" => "Twitter",
                                              "fa-instagram" => "Instagra",
                                              "fa-youtube" => "Youtube",
                                              "fa-snapchat" => "Snapchat",
                                              "fa-whatsapp" => "Whatsapp",
                                              "fa-phone" => "Phone",
                                            ], $Fetch['icon']); ?>
                                          </select>
                                        </div>
                                        <div class="form-group">
                                          <label for="ServiceDesc">Profile Link <small>paste your profile link
                                              here</small></label>
                                          <input name="url" type="url" class="form-control" required="" value="<?php echo $Fetch['url']; ?>" placeholder="http://">
                                        </div>
                                        <div class="form-group">
                                          <label>Change Status</label>
                                          <select name="status" class="form-control">
                                            <?php InputOptions(["1" => "Active", "2" => "Inactive"], $Fetch['status']); ?>
                                          </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                      <button type="button" class="btn btn-default square" data-dismiss="modal">Close</button>
                                      <button type="Submit" Name="updateSocialLink" class="btn btn-primary square" value="<?php echo $Fetch['linkid']; ?>">Update Link</button>
                                      </form>
                                    </div>
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
  <?php include '../../sidebar.php'; ?>
  <?php include '../../footer.php'; ?>
  </div>
  <div class="modal square fade" id="add_link">
    <div class="modal-dialog square">
      <div class="modal-content square">
        <div class="modal-header app-bg">
          <h4 class="modal-title">Add Social Links</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="<?php echo CONTROLLER; ?>/sociallinkcontroller.php" method="POST" enctype="multipart/form-data">
            <?php FormPrimaryInputs(true); ?>
            <div class="form-group">
              <label for="ServiceTitle"> Profile Title</label>
              <input type="text" name="title" class="form-control" required="">
            </div>
            <div class="form-group">
              <label for="ServiceImg">Account Selection</label>
              <select class="form-control" name="icon">
                <option value="fa-facebook">facebook</option>
                <option value="fa-twitter">Twitter</option>
                <option value="fa-instagram">Instagram</option>
                <option value="fa-youtube">Youtube</option>
                <option value="fa-snapchat">Snapchat</option>
                <option value="fa-whatsapp">Whatsapp</option>
                <option value="fa-phone">Phone</option>
              </select>
            </div>
            <div class="form-group">
              <label for="ServiceDesc">Profile Link <small>paste your profiel link here</small></label>
              <input name="url" class="form-control" type="url" required="" placeholder="http://">
            </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default square" data-dismiss="modal">Close</button>
          <button type="Submit" Name="CreateSocialLink" class="btn btn-primary square">Create Link</button>
          </form>
        </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <?php include $Dir . '/include/footer_files.php'; ?>
</body>

</html>
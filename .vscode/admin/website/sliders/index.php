<?php
$Dir = "../../..";
require $Dir . '/require/modules.php';
require $Dir . "/require/admin/sessionvariables.php";
require $Dir . '/include/admin/common.php';

$PageName = "All Sliders";
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
                  <a href="add-slider.php" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Add Slider</a>
                </div>
              </div>

              <div class="row m-t-10">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>S.No</th>
                          <th>Sliderimg</th>
                          <th>Slider Name</th>
                          <th>CreatedAt</th>
                          <th>LastUpdated</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $CHECK = CHECK("SELECT * from sliders");
                        $Select = SELECT("SELECT * from sliders");
                        if ($CHECK != null) {
                          $Count = 0;
                          while ($Fetch = mysqli_fetch_array($Select)) {
                            $Count++; ?>
                            <tr>
                              <td><?php echo $Count; ?></td>
                              <td><img src="<?php echo STORAGE_URL; ?>/website/slider/<?php echo $Fetch['sliderimg']; ?>" class="img-fluid" style="width:20px !important;"></td>
                              <td><?php echo $Fetch['slidertitle']; ?></td>
                              <td><?php echo $Fetch['CreatedAt']; ?></td>
                              <td><?php echo $Fetch['UpdatedAt']; ?></td>
                              <td>
                                <?php STATUS("updateslider", "" . $Fetch['sliderid'] . "", "" . $Fetch['Status'] . ""); ?>
                              </td>
                              <td>
                                <a href="#" data-toggle="modal" data-target="#view_slider<?php echo $Fetch['sliderid']; ?>" class="btn btn-dark btn-sm square"><i class="fa fa-eye"></i></a>
                                <a href="slider_edit.php?edit=<?php echo $Fetch['sliderid']; ?>" class="btn btn-info btn-sm square"><i class="fa fa-edit"></i></a>
                                <?php
                                CONFIRM_DELETE_POPUP(
                                  "sliders",
                                  [
                                    "delete_slider_record" => true,
                                    "control_id" => $Fetch['sliderid']
                                  ],
                                  "slidercontroller",
                                  "<i class='fa fa-trash'></i>",
                                  "btn btn-sm btn-danger"
                                ) ?>
                                <div class="modal square fade" id="view_slider<?php echo $Fetch['sliderid']; ?>">
                                  <div class="modal-dialog square modal-lg">
                                    <div class="modal-content square">
                                      <div class="modal-header">
                                        <h4 class="modal-title">Slider Details</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <h5><?php echo $Fetch['slidertitle']; ?></h5><br>
                                        <p><?php echo SECURE("" . strip_tags($Fetch['sliderdesc']) . "", "d"); ?></p>
                                        <img src="<?php echo STORAGE_URL; ?>/website/slider/<?php echo $Fetch['sliderimg']; ?>" class="img-fluid w-pr-50 d-block mx-auto"><br>
                                        <div class="modal-footer justify-content-between">
                                          <button type="button" class="btn btn-default square" data-dismiss="modal">Close</button>
                                          <a href="slider_edit.php?edit=<?php echo $Fetch['sliderid']; ?>" Name="CreateServices" class="btn btn-primary square">Edit Slider</a>
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
                        } else {
                          NoDataTableView("No Slider Found!", 8);
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

    <!-- end -->
    <?php include  '../../sidebar.php'; ?>
    <?php include  '../../footer.php'; ?>
  </div>

  <?php include $Dir . '/include/footer_files.php'; ?>
</body>

</html>
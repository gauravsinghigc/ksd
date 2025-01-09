<?php
require '../../require/modules.php';
require '../../require/admin/sessionvariables.php';
require "../../include/admin/common.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Projects | <?php echo company_name; ?></title>
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
                      <h3 class="m-t-3"><i class="fa fa-briefcase app-text"></i> Projects</h3>
                    </div>
                    <div class="col-md-12">
                      <div class="flex-s-b">
                        <div class="btn-group btn-group-sm w-100">
                          <a class="btn btn-primary square btn-labeled fa fa-plus" data-toggle="modal" data-target="#add_data">Projects</a>
                          <a href="<?php echo DOMAIN; ?>/admin/projects/project-types" class="btn btn-info square btn-labeled fa fa-list">Projects Types</a>
                          <a href="<?php echo DOMAIN; ?>/admin/projects/project-stages" class="btn btn-primary square btn-labeled fa fa-list">Projects Stages</a>
                          <?php if (isset($_GET['search'])) { ?>
                            <a href="<?php echo DOMAIN; ?>/admin/projects/export_all.php?search_type=<?php echo $_GET['search_type']; ?>&search_value=<?php echo $_GET['search_value']; ?>&search=true" target="blank" class="btn btn-secondary square btn-labeled fa fa-print">Export All</a>
                          <?php } else { ?>
                            <a href="<?php echo DOMAIN; ?>/admin/projects/export_all.php" target="blank" class="btn btn-secondary square btn-labeled fa fa-print">Export All</a>
                          <?php } ?>
                        </div>

                        <div class="btn-group btn-group-sm w-100">
                          <form action="" method="GET" class="flex-s-b form-search-filter w-100">
                            <span class="w-100 p-1 text-right"><b>Search Projects</b></span>
                            <select name="search_type" class="form-control">
                              <option value="project_title">By Project Title</option>
                              <option value="project_type">By Project Type</option>
                              <option value="project_area">By Project Area</option>
                              <option value="created_at">By Created Date</option>
                            </select>
                            <input type="text" name="search_value" class="form-control" placeholder="Enter Search Value">
                            <button type="submit" class="btn btn-sm btn-default m-l-5" name="search">Search</button>
                          </form>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12 col-sm-12 p-t-10">
                      <?php if (isset($_GET['search'])) { ?>
                        <center>
                          <p class="text-center app-bg shadow-lg br10 p-1 w-50 flex-s-b m-b-20">
                            <span><span>Search Results :</span> <?php echo $_GET['search_value']; ?></span>
                            <a href="index.php" class="text-danger"><span class="text-white"><i class="fa fa-times"></i> Clear</span></a>
                          </p>
                        </center>
                      <?php
                      } ?>
                    </div>
                    <div class="col-md-12">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>S.NO</th>
                            <th>ProjectTitle</th>
                            <th>ProjectType</th>
                            <th>ProjectArea</th>
                            <th>Status</th>
                            <th>Plots</th>
                            <th>CreatedAt</th>
                            <th>UpdatedAt</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          if (isset($_GET['search_type'])) {
                            $search_type = $_GET['search_type'];
                            $search_value = $_GET['search_value'];
                            $SelectProjects = SELECT("SELECT * from projects where company_id='" . company_id . "' and project_status!='DELETED' and $search_type like '%$search_value%' ORDER BY Projects_id DESC");
                          } else {
                            $SelectProjects = SELECT("SELECT * from projects where company_id='" . company_id . "' and project_status!='DELETED' ORDER BY Projects_id DESC");
                          }
                          $count = 0;
                          while ($FetchProjects = mysqli_fetch_array($SelectProjects)) {
                            $count++;
                            $Projects_id = $FetchProjects['Projects_id'];
                            $project_title = $FetchProjects['project_title'];
                            $project_type = $FetchProjects['project_type'];
                            $project_area = $FetchProjects['project_area'];
                            $project_measure_unit = $FetchProjects['project_measure_unit'];
                            $project_status = $FetchProjects['project_status'];
                            $project_descriptions = $FetchProjects['project_descriptions'];
                            $project_created_at = $FetchProjects['created_at'];
                            $project_updated_at = $FetchProjects['updated_at'];
                            if ($project_status == "ACTIVE") {
                              $project_status_view = "<span class='text-success'><i class='fa fa-check-circle'></i> Active</span>";
                            } else {
                              $project_status_view = "<span class='text-danger'><i class='fa fa-warning'></i> Inactive</span>";
                            }

                            $CountTotalProjectUntits = TOTAL("SELECT * FROM projects, project_units where projects.Projects_id=project_units.project_id and projects.Projects_id='$Projects_id'");
                            if ($CountTotalProjectUntits == 0) {
                              $CountTotalProjectUntits = 0;
                              $BtnStatus = "";
                            } else {
                              $CountTotalProjectUntits = $CountTotalProjectUntits;
                              $BtnStatus = "hidden";
                            } ?>
                            <tr>
                              <td><?php echo $count; ?></td>
                              <td class="text-primary link"><?php echo $project_title; ?></td>
                              <td><?php echo $project_type; ?></td>
                              <td><?php echo $project_area; ?> <?php echo $project_measure_unit; ?></td>
                              <td><?php echo $project_status_view; ?></td>
                              <td><?php echo $CountTotalProjectUntits; ?></td>
                              <td><?php echo DATE_FORMATE2("d M, Y", $project_created_at); ?></td>
                              <td><?php echo DATE_FORMATE2("d M, Y", $project_updated_at); ?></td>
                              <td>
                                <div class="btn-group flex-center" role="group" aria-label="Basic example">
                                  <a type="button" data-toggle="modal" data-target="#view_project_<?php echo $Projects_id; ?>" class="btn btn-secondary btn-sm btn-info"><I class="fa fa-edit"></I></a>
                                  <?php CONFIRM_DELETE_POPUP(
                                    "delete_pro_list",
                                    [
                                      "delete_projects" => true,
                                      "control_id" => $Projects_id,
                                      "project_name" => $project_title
                                    ],
                                    "projectcontroller",
                                    "<i class='fa fa-trash'></i> Remove",
                                    "text-danger btn $BtnStatus"
                                  ); ?>
                                </div>
                              </td>
                              <!-- Modal  3-->
                              <div class="modal fade square" id="view_project_<?php echo $Projects_id; ?>" role="dialog">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header app-bg text-white">
                                      <button type="button" class="close text-white m-r-8 m-t-1" data-dismiss="modal">&times;</button>
                                      <h4 class="modal-title text-white">Edit Project</h4>
                                    </div>
                                    <div class="modal-body">
                                      <form action="../../controller/projectcontroller.php" method="POST" encrypt="multipart/form-data">
                                        <?php FormPrimaryInputs(true); ?>
                                        <input name="project_measure_unit" required="" value="<?php echo MeasurementUnit; ?>" hidden="">
                                        <div class="row">

                                          <div class="form-group col-md-12 col-lg-12 col-sm-12">
                                            <label>Project Title</label>
                                            <input type="text" name="project_title" value="<?php echo $project_title; ?>" class="form-control w-100" required="" placeholder="Project Name">
                                          </div>
                                          <div class="form-group col-md-12">
                                            <label>Project Type</label>
                                            <select name="project_type" class="form-control w-100" required="">
                                              <option value="<?php echo $project_type; ?>" selected><?php echo $project_type; ?></option>
                                              <?php
                                              $FetchPROJECT_TYPE = SELECT("SELECT * from project_types where company_id='" . company_id . "' and project_type_status='ACTIVE' and project_type_name!='$project_type'");
                                              while ($FetchPROJECTST = mysqli_fetch_array($FetchPROJECT_TYPE)) {
                                                $project_type_name = $FetchPROJECTST['project_type_name']; ?>
                                                <option value="<?php echo $project_type_name; ?>"><?php echo $project_type_name; ?></option>
                                              <?php } ?>
                                            </select>
                                          </div>
                                          <div class="form-group col-md-12">
                                            <label>Project Total Area (<?php echo MeasurementUnit; ?>)</label>
                                            <input type="number" name="project_area" value="<?php echo $project_area; ?>" class="form-control w-100" require="" placeholder="12234">
                                          </div>
                                          <div class="form-group col-md-12">
                                            <label>Project Description</label>
                                            <textarea class="form-control w-100" placeholder="" value="<?php echo $project_descriptions; ?>" name="project_descriptions" rows="3"><?php echo $project_descriptions; ?></textarea>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      <button type="submit" name="update_projects" value="<?php echo $Projects_id; ?>" class="btn btn-success">Save</button>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </tr>
                          <?php } ?>
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


    <!-- Modal  3-->
    <div class="modal fade square" id="add_data" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header app-bg text-white">
            <button type="button" class="close text-white m-r-8 m-t-1" data-dismiss="modal">&times;</button>
            <h4 class="modal-title text-white">Add Project</h4>
          </div>
          <div class="modal-body overflow-auto">
            <form action="../../controller/projectcontroller.php" method="POST" enctype="multipart/form-data">
              <?php FormPrimaryInputs(true); ?>
              <input name="project_measure_unit" required="" value="<?php echo MeasurementUnit; ?>" hidden="">
              <div class="row">
                <div class="form-group col-12 col-md-12">
                  <label>Project Title</label>
                  <input type="text" name="project_title" class="form-control" required="" placeholder="Project Name">
                </div>
                <div class="form-group col-12 col-md-12">
                  <label>Project Type</label>
                  <select name="project_type" class="form-control" required="">
                    <?php
                    $FetchPROJECT_TYPE = SELECT("SELECT * from project_types where company_id='" . company_id . "' and project_type_status='ACTIVE'");
                    while ($FetchPROJECTST = mysqli_fetch_array($FetchPROJECT_TYPE)) {
                      $project_type_name = $FetchPROJECTST['project_type_name']; ?>
                      <option value="<?php echo $project_type_name; ?>"><?php echo $project_type_name; ?></option>
                    <?php } ?>
                  </select>
                </div>

                <div class="form-group col-12 col-md-12">
                  <label>Project Total Area (<?php echo MeasurementUnit; ?>)</label>
                  <input type="text" name="project_area" class="form-control" require="" placeholder="12234">
                </div>
                <div class="form-group col-12 col-md-12">
                  <label>Project Description</label>
                  <textarea class="form-control" placeholder="" name="project_descriptions" rows="3"></textarea>
                </div>
                <div class="form-group col-md-12">
                  <label>Project Image</label>
                  <input type="FILE" name="ProjectMediaFileAttachements" accept="image/*" class="form-control">
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" name="create_new_project" value="<?php echo company_id; ?>" class="btn btn-success">Save</button>
            </form>
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
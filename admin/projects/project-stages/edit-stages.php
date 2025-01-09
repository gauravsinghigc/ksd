<?php
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';

if (isset($_GET['refid'])) {
  $ProjectStageId = $_GET['refid'];
  $_SESSION['ProjectStageId'] = $ProjectStageId;
} else {
  $ProjectStageId = $_SESSION['ProjectStageId'];
}

$StageSql = "SELECT * FROM project_stages where ProjectStageId='$ProjectStageId'";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Edit Project Stages | <?php echo company_name; ?></title>
  <?php include '../../../include/header_files.php'; ?>
</head>

<body>
  <div id="container" class="navbar-fixed mainnav-fixed mainnav-lg">
    <?php include '../../header.php'; ?>

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
                      <h3 class="m-t-3"><i class="fa fa-exchange app-text"></i> Edit Project Stages</h3>
                    </div>
                    <div class="col-md-12">
                      <div class="flex-s-b">
                        <div class="btn-group btn-group-sm w-100 m-r-20 m-l-5 m-b-10">
                          <a class="btn btn-primary square btn-labeled fa fa-plus" data-toggle="modal" data-target="#add_data">Project Stages</a>
                          <a href="<?php echo DOMAIN; ?>/admin/projects/" class="btn btn-info square btn-labeled fa fa-list">Projects</a>
                          <?php if (isset($_GET['search'])) { ?>
                            <a href="<?php echo DOMAIN; ?>/admin/projects/project-stages/export_all.php?search_type=<?php echo $_GET['search_type']; ?>&search_value=<?php echo $_GET['search_value']; ?>&search=true" target="blank" class="btn btn-secondary square btn-labeled fa fa-print">Export All</a>
                          <?php } else { ?>
                            <a href="<?php echo DOMAIN; ?>/admin/projects/project-stages/export_all.php" target="blank" class="btn btn-secondary square btn-labeled fa fa-print">Export All</a>
                          <?php } ?>
                        </div>
                        <div class="btn-group btn-group-sm w-100 m-r-20 m-l-5 m-b-10">

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
                      <?php } ?>
                      <form action="../../../controller/projectcontroller.php" method="POST">
                        <?php FormPrimaryInputs(
                          true,
                          [
                            "ProjectStageId" => $ProjectStageId,
                          ]
                        ); ?>
                        <div class="row">
                          <div class="form-group col-12 col-md-6">
                            <label>Select Project</label>
                            <select name="ProjectStageMainProjectId" class="form-control" required="">
                              <?php
                              $fetchPROJECTS = SELECT("SELECT * FROM projects where company_id='" . company_id . "' and project_status='ACTIVE'");
                              while ($F_PROJECTS = mysqli_fetch_array($fetchPROJECTS)) {
                                $project_title = $F_PROJECTS['project_title'];
                                $Projects_id = $F_PROJECTS['Projects_id'];
                                if ($Projects_id ==  FETCH($StageSql, "ProjectStageMainProjectId")) {
                                  $selected = "selected";
                                } else {
                                  $selected = "";
                                } ?>
                                <option value="<?php echo $Projects_id; ?>" <?php echo $selected; ?>><?php echo $project_title; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="form-group col-12 col-md-6">
                            <label>Project Stage Name</label>
                            <input type="text" name="ProjectStageName" value="<?php echo FETCH($StageSql, "ProjectStageName"); ?>" class="form-control" required="" placeholder="">
                          </div>
                          <div class="form-group col-12 col-md-6">
                            <label>Stage Create Date</label>
                            <input type="date" name="ProjectStageCreatedAt" value="<?php echo FETCH($StageSql, "ProjectStageCreatedAt"); ?>" class="form-control" placeholder="" required="">
                          </div>
                          <div class="form-group col-12 col-md-6">
                            <label>Stage Acceptable Payment (in %)</label>
                            <input type="text" name="ProjectStagePaymentPercentage" value="<?php echo FETCH($StageSql, "ProjectStagePaymentPercentage"); ?>" class="form-control" placeholder="" required="">
                          </div>
                          <div class="form-group col-12 col-md-12">
                            <label>Plot Description</label>
                            <textarea class="form-control" placeholder="" name="ProjectStageDescriptions" rows="5"><?php echo SECURE(FETCH($StageSql, "ProjectStageDescriptions"), "d"); ?></textarea>
                          </div>

                          <div class="col-md-12">
                            <a href="index.php" class="btn btn-lg btn-default"><i class="fa fa-angle-left"></i> Back to All Stages</a>
                            <button type="submit" name="UpdateProjectStage" class="btn btn-lg btn-primary">Update Details</button>
                          </div>
                        </div>
                      </form>
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
    <?php include '../../sidebar.php'; ?>
    <?php include '../../footer.php'; ?>
  </div>

  <?php include '../../../include/footer_files.php'; ?>
</body>

</html>
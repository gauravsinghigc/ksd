<?php
require '../../require/modules.php';
require '../../include/extra/web_body.php';
require '../../include/extra/web_common.php';

if (isset($_GET['id'])) {
  $Id = $_GET['id'];
  $_SESSION['ids'] = $Id;
} else {
  $Id = $_SESSION['ids'];
}
$SelectServices = SELECT("SELECT * FROM projects where project_status='ACTIVE' and Projects_Id='$Id'");
$FetchServices = mysqli_fetch_array($SelectServices); ?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="generator" content="<?php echo DEVELOPED_BY; ?>, App Version <?php echo APP_VERSION; ?>; ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <?php include '../include/meta.php'; ?>

  <title><?php echo $FetchServices['project_title']; ?> | <?php echo company_name; ?></title>
  <?php include '../include/header_files.php'; ?>
  <style>
    p {
      font-size: calc(1.07rem + (1.2 - 1.07) * ((100vw - 20rem) / (48 - 20))) !important;
      line-height: calc(1.4 * (1.07rem + (1.2 - 1.07) * ((100vw - 20rem) / (48 - 20)))) !important;
    }
  </style>
</head>

<body>
  <?php include '../include/header.php'; ?>
  <section class="content5 cid-swlMFugAXk" id="content5-f">

    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-4">
          <a href="<?php echo STORAGE_URL; ?>/projects/media/<?php echo FETCH("SELECT * FROM project_media_files where ProjectMainProjectId='" . $Id . "' ORDER BY ProjectMediaFileId DESC LIMIT 1", "ProjectMediaFileAttachements"); ?>" target="_blank">
            <img src="<?php echo STORAGE_URL; ?>/projects/media/<?php echo FETCH("SELECT * FROM project_media_files where ProjectMainProjectId='" . $Id . "' ORDER BY ProjectMediaFileId DESC LIMIT 1", "ProjectMediaFileAttachements"); ?>" class="img-fluid">
          </a>

          <a href="<?php echo FETCH("SELECT * FROM project_media_files where ProjectMediaFileType='image' and ProjectMainProjectId='" . $Id . "' ORDER BY ProjectMediaFileId DESC LIMIT 1", "ProjectMediaFileAttachements"); ?>" class="btn btn-primary btn-md mb-0" download="<?php echo FETCH("SELECT * FROM project_media_files where ProjectMediaFileType='image' and ProjectMainProjectId='" . $Id . "' ORDER BY ProjectMediaFileId DESC LIMIT 1", "ProjectMediaFileAttachements"); ?>" target="blank">
            <i class="fa fa-download mr-1"></i> Download
          </a>
        </div>
        <div class="col-md-8">
          <h3 class="mbr-section-title mbr-fonts-style mb-3 pt-4 pb-2">
            <strong><?php echo $FetchServices['project_title']; ?> <br><small>By
                <?php echo company_name; ?></small></strong>
          </h3>
          <p>
            <b>Project Area :</b> <?php echo $FetchServices['project_area']; ?> <?php echo $FetchServices['project_measure_unit']; ?><br>
            <b>Total Unit : </b> <?php echo TOTAL("SELECT * FROM project_units where project_id='" . $FetchServices['Projects_id'] . "'"); ?> Plots
          </p>
          <?php echo $FetchServices['project_descriptions']; ?>

        </div>
      </div>
    </div>
  </section>

  <section class="container">
    <div class="row">
      <div class="col-md-12">
        <h4 class="p-3 text-center bg-primary mt-3 text-white"><i class="fa fa-search"></i> Search Plots</h4>
      </div>
      <div class="col-md-12">
        <h5 class="p-2 text-center">Search Active, Sold, & Hold Plots.</h4>
          <hr>
      </div>
    </div>
    <form action="" method="GET">
      <div class="row">
        <div class="form-group col-lg-5 col-md-5 col-sm-5 col-5">
          <input type="text" value="<?php echo NeedReqData("projects_unit_name"); ?>" name="projects_unit_name" list="projects_unit_name" class="form-control" placeholder="Enter plot no name : plot1, p1, Plot A">
          <?php SUGGEST("project_units where project_id='$Id'", "projects_unit_name", "ASC"); ?>
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-4 col-4">
          <button class="btn btn-md btn-primary" name="search" value="true">Search Plot</button>
        </div>
        <div class="form-group col-lg-3 col-md-3 col-sm-3 col-3">
          <a href="<?php echo DOMAIN; ?>/app/live-map/<?php echo $Id; ?>/" class="btn btn-md btn-success" target="_blank"><i class="fa fa-map-marker"></i>&nbsp; View Live Map</a>
        </div>
      </div>
      <hr>
    </form>
    <div class="row">
      <div class="col-md-12">
        <table class="table table-striped" id="example">
          <thead>
            <tr>
              <th style=" width:5%;">S.NO</th>
              <th>PLOT NO</th>
              <th>Type</th>
              <th>Area</th>
              <th>Price</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $SelectProjects = SELECT("SELECT * from project_units where project_id='$Id' ORDER BY project_units.project_units_id DESC");
            $count = 0;
            while ($FetchProjects = mysqli_fetch_array($SelectProjects)) {
              $count++;
              $project_units_id  = $FetchProjects['project_units_id'];
              $projects_unit_name = $FetchProjects['projects_unit_name'];
              $projects_unit_type = $FetchProjects['projects_unit_type'];
              $project_unit_area = $FetchProjects['project_unit_area'];
              $project_unit_measurement_unit = $FetchProjects['project_unit_measurement_unit'];
              $project_unit_price = $FetchProjects['project_unit_price'];
              $unit_per_price = $FetchProjects['unit_per_price'];
              $updated_at = date("d M, Y h:m a", strtotime($FetchProjects['updated_at']));
              $project_id = $FetchProjects['project_id'];
              $project_unit_description = $FetchProjects['project_unit_description'];
              $project_unit_id = $project_units_id;
              $project_unit_status = $FetchProjects['project_unit_status'];

              if ($project_unit_status == "ACTIVE") {
                $project_status_view = "<span class='btn-success btn-md'><i class='fa fa-check-circle'></i> Active</span>";
              } else if ($project_unit_status == "SOLD") {
                $project_status_view = "<span class='btn-danger btn-md'><i class='fa fa-check-circle-o'></i> SOLD</span>";
              } else {
                $project_status_view = "<span class='btn-danger'><i class='fa fa-warning'></i> Inactive</span>";
              }

              $CountTotalProjectUntits = TOTAL("SELECT * FROM project_units, bookings where project_units.project_units_id=bookings.project_unit_id and bookings.project_unit_id='$project_units_id'");
              if (
                $CountTotalProjectUntits == 0
              ) {
                $CountTotalProjectUntits = 0;
                $BtnStatus = "";
              } else {
                $CountTotalProjectUntits = $CountTotalProjectUntits;
                $BtnStatus = "hidden";
              }

              if (isset($_GET['projects_unit_name'])) {
                $SearchUnits = $_GET['projects_unit_name'];
                if ($SearchUnits == $projects_unit_name) {
                  $SelectedPlot = "bg-danger";
                } else {
                  $SelectedPlot = "";
                }
              } else {
                $SelectedPlot = "";
              }
            ?>
              <tr class="<?php echo $SelectedPlot; ?>">
                <td><?php echo $count; ?></td>
                <td class="text-uppercase"><?php echo $projects_unit_name; ?></td>
                <td><?php echo $projects_unit_type; ?></td>
                <td><?php echo $project_unit_area; ?> <?php echo $project_unit_measurement_unit; ?></td>
                <td>
                  <span class="text-success"><i class="fa fa-inr"></i><?php echo $project_unit_price; ?></span> -
                  <small>(<i class="fa fa-inr"></i><?php echo $unit_per_price; ?>/<?php echo $project_unit_measurement_unit; ?>)</small>
                </td>
                <td><?php echo $project_status_view; ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>


  <?php
  include '../include/follow.php';
  ?>

  <?php
  include '../include/footer.php';
  include '../include/scripts.php'; ?>
</body>

</html>
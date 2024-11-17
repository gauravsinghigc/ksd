<?php
require '../../require/modules.php';
require '../../include/extra/web_body.php';
require '../../include/extra/web_common.php'; ?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="generator" content="<?php echo DEVELOPED_BY; ?>, App Version <?php echo APP_VERSION; ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <?php include '../include/meta.php'; ?>

  <title>Search Properties | <?php echo company_name; ?></title>
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
  <section class="content5 cid-swlMFugAXk" id="content5-f" style="background-image:url('<?php echo DOMAIN; ?>/storage/web-img/slider-background1.jpg') !important;">

    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-md-12 col-lg-11">
          <h3 class="mbr-section-title mbr-fonts-style mb-4 display-2">
            <strong>Search Properties | <?php echo company_name; ?></strong>
          </h3>
        </div>
      </div>
    </div>
  </section>

  <section class="container">
    <div class="row">
      <div class="col-md-12">
        <h4 class="p-3 text-center bg-primary mt-3 text-white"><i class="fa fa-search"></i> Search Properties</h4>
      </div>
      <div class="col-md-12">
        <h5 class="p-2 text-center">Search Available Projects, Plots, and Sold Status</h4>
          <hr>
      </div>
    </div>
    <form action="" method="GET">
      <div class="row">
        <div class="form-group col-lg-4 col-md-4 col-sm-4 col-4">
          <select class="form-control" name="project_id">
            <option value="0">Select Projects</option>
            <?php
            $SQL_project_types2 = SELECT("SELECT * FROM projects where project_status='ACTIVE' ORDER BY Projects_id ASC");
            while ($FETCH_project_types2 = mysqli_fetch_array($SQL_project_types2)) {
              $selected = "";
              if (isset($_GET['project_id'])) {
                if ($_GET['project_id'] == $FETCH_project_types2['Projects_id']) {
                  $selected = "selected=''";
                } else {
                  $selected = "";
                }
              } ?>
              <option value="<?php echo $FETCH_project_types2['Projects_id']; ?>" <?php echo $selected; ?>><?PHP echo $FETCH_project_types2['project_title']; ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-4 col-4">
          <select class="form-control" name="project_unit_status">
            <option value="0">Select Property Status</option>
            <?php if (isset($_GET['project_unit_status'])) {
              if ($_GET['project_unit_status'] == "SOLD") { ?>
                <option value="SOLD" selected="">Sold</option>
                <option value="ACTIVE">Active</option>
              <?php } else { ?>
                <option value="SOLD">Sold</option>
                <option value="ACTIVE" selected="">Active</option>
              <?php  } ?>

            <?php } else { ?>
              <option value="SOLD">Sold</option>
              <option value="ACTIVE">Active</option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-4 col-4">
          <button class="btn btn-md btn-primary" name="search" value="true">Search Property</button>
        </div>
      </div>
      <hr>
    </form>

    <?php if (isset($_GET['search'])) { ?>
      <div class="row">
        <div class="col-md-12">
          <table class="table table-striped" id="example">
            <thead>
              <tr>
                <th style=" width:5%;">S.NO</th>
                <th>PLOT NO</th>
                <th>Project Name</th>
                <th>Type</th>
                <th>Area</th>
                <th>Price</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if (isset($_GET['project_id'])) {
                $id = $_GET['project_id'];
                $status = $_GET['project_unit_status'];
                $SelectProjects = SELECT("SELECT *, project_units.created_at AS 'project_units_created_at' from projects, project_units where project_units.project_id='$id' and project_units.project_unit_status='$status' and projects.Projects_id=project_units.project_id and projects.company_id='" . company_id . "' and project_units.project_unit_status!='DELETED' and project_units.projects_unit_type='PLOT' and project_units.project_unit_status!='Inactive' ORDER BY project_units.project_units_id DESC");
              } else {
                $SelectProjects = SELECT("SELECT *, project_units.created_at AS 'project_units_created_at' from projects, project_units where projects.Projects_id=project_units.project_id and projects.company_id='" . company_id . "' and project_units.project_unit_status!='DELETED' and project_units.projects_unit_type='PLOT' and project_units.project_unit_status!='Inactive' ORDER BY project_units.project_units_id DESC");
              }
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
                $project_unit_status = $FetchProjects['project_unit_status'];
                $project_title = $FetchProjects['project_title'];
                $project_id = $FetchProjects['project_id'];
                $project_unit_description = $FetchProjects['project_unit_description'];
                $project_units_created_at = $FetchProjects['project_units_created_at'];
                $project_title = $FetchProjects['project_title'];
                $project_unit_id = $project_units_id;

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
              ?>
                <tr>
                  <td><?php echo $count; ?></td>
                  <td class="text-uppercase"><?php echo $projects_unit_name; ?></td>
                  <td class="text-uppercase"><?php echo $project_title; ?></td>
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
    <?php } ?>
  </section>

  <?php
  include '../include/footer.php';
  include '../include/scripts.php'; ?>
</body>

</html>
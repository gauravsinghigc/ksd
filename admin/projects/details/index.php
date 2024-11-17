<?php
require '../../../require/modules.php';
require '../../../require/admin/sessionvariables.php';
require "../../../include/admin/common.php";
require "sections/HeaderRequestHandler.php";

$PageName = "Project Dashboard";

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php echo $PageName; ?> | <?php echo company_name; ?></title>
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
                  <?php include __DIR__ . "/sections/HeaderMenus.php"; ?>

                  <div class="row">
                    <div class="col-md-3">
                      <div class="shadow-sm p-1 br10">
                        <h4 class='app-sub-heading m-t-0 mt-0'>Project Details</h4>
                        <p class="m-b-5">
                          <span>
                            <span class="small text-grey">Project Name</span><br>
                            <span class="text-black"><?php echo FETCH($ProjectSQL, "project_title"); ?></span>
                          </span><br>
                          <span>
                            <span class="small text-grey">Project Area</span><br>
                            <span class="text-black">
                              <?php echo FETCH($ProjectSQL, "project_area"); ?>
                              <?php echo FETCH($ProjectSQL, "project_measure_unit"); ?>
                            </span>
                          </span>
                        </p>
                        <p class="flex-s-b m-b-5">
                          <span>
                            <span class="small text-grey">Project Type</span><br>
                            <span class="text-black"><?php echo FETCH($ProjectSQL, "project_type"); ?></span>
                          </span>
                          <span>
                            <span class="small text-grey">Created at</span><br>
                            <span class="text-black"><?php echo DATE_FORMATE2("d M, Y", FETCH($ProjectSQL, "created_at")); ?></span>
                          </span>
                        </p>
                        <p class="m-b-5">
                          <span class="small text-grey">Description</span><br>
                          <span class="text-black"><?php echo FETCH($ProjectSQL, "project_descriptions"); ?></span>
                        </p>
                        <p>
                          <span class="small text-grey">Status</span><br>
                          <span class="text-black">
                            <?php echo StatusViewWithText(FETCH($ProjectSQL, "project_status")); ?>
                          </span>
                        </p>
                      </div>
                    </div>

                    <div class="col-md-9">
                      <div class="shadow-sm p-1">
                        <h4 class="app-sub-heading m-t-0 mt-0">Project Block/Tower, Floors and Units</h4>

                        <div class="flex-s-b">
                          <div class="property-blocks">
                            <?php
                            $GetProjectsBlocks = FetchConvertIntoArray("SELECT * FROM project_blocks where project_main_id='$ProjectId'", true);
                            if ($GetProjectsBlocks != null) {
                              foreach ($GetProjectsBlocks as $ProjectBlocks) {
                                if ($ProjectBlockID == $ProjectBlocks->project_block_id) {
                                  $BlockStatus = "active";
                                } else {
                                  $BlockStatus = "";
                                }
                            ?>
                                <a href="?GetProjectBlock=<?php echo $ProjectBlocks->project_block_id; ?>" class='<?php echo $BlockStatus; ?>'><?php echo $ProjectBlocks->project_block_name; ?></a>
                            <?php
                              }
                            } else {
                              echo "<a href=''>NO Block/Tower Found!</a>";
                            } ?>
                          </div>
                          <div class="property-units">
                            <?php
                            if ($ProjectBlockID != null) {
                              $BlockSQL = "SELECT * FROM project_blocks where project_block_id='$ProjectBlockID'"; ?>
                              <div class='flex-s-b'>
                                <h5 class="m-b-0 w-pr-90 m-r-5"><i class="fa fa-home"></i> <?php echo FETCH($BlockSQL, "project_block_name"); ?></h5>
                                <a data-toggle="modal" data-target="#Update_blocks" class="btn btn-md btn-default m-r-5">Update Block</a>
                                <a data-toggle="modal" data-target="#property_units" class="btn btn-md btn-dark">Add Unit</a>
                              </div>
                              <p class="text-secondary small m-t-7 m-b-7">
                                <?php echo SECURE(FETCH($BlockSQL, "project_block_descriptions"), "d"); ?>
                              </p>
                              <hr>
                              <div class="modal fade" id="Update_blocks" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h4 class='app-bg p-2 mt-0 m-b-0'>Update Project Block/Tower</h4>
                                    </div>
                                    <div class="modal-body">
                                      <form action="<?php echo CONTROLLER; ?>/projectcontroller.php" method="POST" class="access-form">
                                        <?php FormPrimaryInputs(true, [
                                          "project_block_id" => $ProjectBlockID,
                                        ]); ?>
                                        <div class="row">
                                          <div class="col-md-12 form-group">
                                            <label>Block/Tower Name</label>
                                            <input type="text" name="project_block_name" value='<?php echo FETCH($BlockSQL, "project_block_name"); ?>' class="form-control" required>
                                          </div>
                                          <div class="col-md-12 form-group">
                                            <label>Block/Tower Details</label>
                                            <textarea name="project_block_descriptions" class="form-control" rows="3"><?php echo SECURE(FETCH($BlockSQL, "project_block_name"), "d"); ?></textarea>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                      <button type="submit" class="btn app-bg" name="UpdateProjectBlockRecord">Update Records</button>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <?php
                              $GetBlockFloors = FetchConvertIntoArray("SELECT * FROM projects_floors where projects_floors_block_id='$ProjectBlockID' ORDER BY projects_floors_id DESC", true);
                              if ($GetBlockFloors != null) {
                                foreach ($GetBlockFloors as $Floors) { ?>
                                  <div class="flex-s-b listings">
                                    <div class="property-floors link" data-toggle="modal" data-target="#property_floors_<?php echo $Floors->projects_floors_id; ?>">
                                      <span><?php echo $Floors->projects_floor_name; ?></span>
                                    </div>
                                    <div class="project_units">
                                      <div class="units">

                                        <?php
                                        $ProjectUnits = FetchConvertIntoArray("SELECT * FROM project_units where project_floor_id='" . $Floors->projects_floors_id . "'", true);
                                        if ($ProjectUnits != null) {
                                          foreach ($ProjectUnits as $Unit) {
                                            $UnitId = $Unit->project_units_id;
                                            $UnitStatus = TOTAL("SELECT * FROM bookings where project_unit_id='$UnitId'");

                                            if ($UnitStatus != 0) {
                                              $status = "sold";
                                            } else {
                                              $status = "active";
                                            }
                                        ?>
                                            <a data-toggle="modal" data-target="#property_units_<?php echo $Unit->project_units_id; ?>" class='<?php echo $status; ?>'>
                                              <span class='unit-no'><?php echo $Unit->projects_unit_name; ?></span><br>
                                              <span class='unit-type'><?php echo $Unit->project_unit_bhk_type; ?></span>
                                            </a>

                                            <div class="modal fade" id="property_units_<?php echo $Unit->project_units_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                              aria-hidden="true">
                                              <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h4 class='app-bg p-2 mt-0 m-b-0'>Add Property Units</h4>
                                                  </div>
                                                  <div class="modal-body">
                                                    <form action="<?php echo CONTROLLER; ?>/projectcontroller.php" method="POST" class="access-form">
                                                      <?php FormPrimaryInputs(true, [
                                                        "project_units_id" => $Unit->project_units_id,
                                                      ]); ?>
                                                      <div class="row">
                                                        <div class="col-md-4 form-group">
                                                          <label>Select Floors Number</label>
                                                          <select name="project_floor_id" class="form-control" required>
                                                            <?php
                                                            if ($GetBlockFloors != null) {
                                                              foreach ($GetBlockFloors as $ProjectFloors) {
                                                                if ($Unit->project_floor_id == $ProjectFloors->projects_floors_id) {
                                                                  $selected = "selected";
                                                                } else {
                                                                  $selected = "";
                                                                }
                                                            ?>
                                                                <option value="<?php echo $ProjectFloors->projects_floors_id; ?>" <?php echo $selected; ?>><?php echo $ProjectFloors->projects_floor_name; ?></option>
                                                            <?php
                                                              }
                                                            } else {
                                                              echo '<option value="0">No Floor found</option>';
                                                            } ?>
                                                          </select>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                          <label>Unit Type</label>
                                                          <select name='projects_unit_type' class="form-control" required>
                                                            <?php echo InputOptions([
                                                              "FLAT" => "FLAT",
                                                              "PLOT" => "PLOT",
                                                              "SHOP" => "SHOP",
                                                              "STORE" => "STORE",
                                                              "VILLA" => "VILLA",
                                                              "PARKING" => "PARKING",
                                                              "STUDIO_APARTMENT" => "Studio Apartment",
                                                              "APARTMENT" => "APARTMENT",
                                                              "CONDOMINIUM" => "CONDOMINIUM",
                                                              "OFFICE" => "OFFICE",
                                                              "LAND" => "LAND",
                                                              "ROOM" => "ROOM",
                                                              "OPEN_SPACE" => "Open Space"
                                                            ], $Unit->projects_unit_type); ?>
                                                          </select>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                          <label>Unit Number</label>
                                                          <input type="text" name="projects_unit_name" value='<?php echo $Unit->projects_unit_name; ?>' class="form-control" required>
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                          <label>Unit Area</label>
                                                          <input type="text" id='UnitArea_<?php echo $Unit->project_floor_id; ?>' oninput="CalculatePrice_<?php echo $Unit->project_floor_id; ?>()" name="project_unit_area" value='<?php echo $Unit->project_unit_area; ?>' class="form-control" required>
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                          <label>Unit Measure Type</label>
                                                          <select name="project_unit_measurement_unit" class="form-control">
                                                            <?php echo InputOptions([
                                                              "sq. yards" => "Sq. Yards",
                                                              "sq. ft" => "Sq. ft",
                                                              "sq. m" => "Sq. m",
                                                              "acres" => "Acres",
                                                              "hectares" => "Hectares",
                                                              "square meters" => "Square meters",
                                                            ], $Unit->project_unit_measurement_unit); ?>
                                                          </select>
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                          <label>Unit Sale Rate</label>
                                                          <input type="text" id='UnitRate_<?php echo $Unit->project_floor_id; ?>' oninput="CalculatePrice_<?php echo $Unit->project_floor_id; ?>()" value='<?php echo $Unit->unit_per_price; ?>' name="unit_per_price" class="form-control" required>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                          <label>Unit Price</label>
                                                          <input type="text" readonly id='UnitNetRate_<?php echo $Unit->project_floor_id; ?>' value='<?php echo $Unit->project_unit_price; ?>' name="project_unit_price" class="form-control">
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                          <label>Broker Rate</label>
                                                          <input type="text" name="unit_broker_rate" value='<?php echo $Unit->unit_broker_rate; ?>' class="form-control">
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                          <label>Unit BHK Type</label>
                                                          <select name='project_unit_bhk_type' class="form-control" required>
                                                            <?php echo InputOptions([
                                                              "1BHK" => "1 BHK",
                                                              "2BHK" => "2 BHK",
                                                              "3BHK" => "3 BHK",
                                                              "4BHK" => "4 BHK",
                                                              "5BHK" => "5 BHK",
                                                              "6BHK" => "6 BHK",
                                                              "OPEN_SPACE" => "OPEN_SPACE",
                                                              "PARKING" => "PARKING",
                                                              "STUDIO_APARTMENT" => "STUDIO APARTMENT"
                                                            ], $Unit->project_unit_bhk_type); ?>
                                                          </select>
                                                        </div>
                                                        <div class="col-md-12 form-group">
                                                          <label>Unit Highlights/Tag</label>
                                                          <input type="text" name="project_unit_highlights" value='<?php echo $Unit->project_unit_highlights; ?>' class="form-control">
                                                        </div>
                                                        <div class="col-md-12 form-group">
                                                          <label>Unit More details</label>
                                                          <textarea name="project_unit_description" class="form-control" rows="3"><?php echo SECURE($Unit->project_unit_description, "d"); ?></textarea>
                                                        </div>
                                                      </div>
                                                  </div>
                                                  <div class="modal-footer">
                                                    <?php
                                                    $UnitStatus = CHECK("SELECT * FROM bookings where project_unit_id='$UnitId'");
                                                    if ($UnitStatus == null) {
                                                      echo CONFIRM_DELETE_POPUP(
                                                        "units",
                                                        [
                                                          "remove_project_units" => true,
                                                          "control_id" => $Unit->project_units_id,
                                                        ],
                                                        "projectcontroller",
                                                        "<i class='fa fa-trash'></i> Remove Permanent",
                                                        "btn btn-lg text-danger pull-left"
                                                      );
                                                    } ?>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn app-bg" name="UpdateProjectBlockFloorUnitsRecord">Update Records</button>
                                                    </form>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>

                                            <script>
                                              function CalculatePrice_<?php echo $Unit->project_floor_id; ?>() {
                                                var UnitArea_<?php echo $Unit->project_floor_id; ?> = document.getElementById('UnitArea_<?php echo $Unit->project_floor_id; ?>').value;
                                                var UnitRate_<?php echo $Unit->project_floor_id; ?> = document.getElementById('UnitRate_<?php echo $Unit->project_floor_id; ?>').value;
                                                var UnitNetRate_<?php echo $Unit->project_floor_id; ?> = document.getElementById('UnitNetRate_<?php echo $Unit->project_floor_id; ?>');
                                                UnitNetRate_<?php echo $Unit->project_floor_id; ?>.value = parseFloat(UnitArea_<?php echo $Unit->project_floor_id; ?>) * parseFloat(UnitRate_<?php echo $Unit->project_floor_id; ?>);
                                              }
                                            </script>
                                        <?php }
                                        } ?>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="modal fade" id="property_floors_<?php echo $Floors->projects_floors_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h4 class='app-bg p-2 mt-0 m-b-0'>Update Block/Tower Floors</h4>
                                        </div>
                                        <div class="modal-body">
                                          <form action="<?php echo CONTROLLER; ?>/projectcontroller.php" method="POST" class="access-form">
                                            <?php FormPrimaryInputs(true, [
                                              "projects_floors_id" => $Floors->projects_floors_id,
                                            ]); ?>
                                            <div class="row">
                                              <div class="col-md-6 form-group">
                                                <label>Select Block/Tower Number</label>
                                                <select name="projects_floors_block_id" class="form-control" required>
                                                  <?php
                                                  $Blocks = FetchConvertIntoArray("SELECT * FROM project_blocks where project_main_id='$ProjectId'", true);
                                                  if ($Blocks != null) {
                                                    foreach ($Blocks as $Block) {
                                                      if ($Floors->projects_floors_block_id == $Block->project_block_id) {
                                                        $selected = "selected";
                                                      } else {
                                                        $selected = "";
                                                      }
                                                  ?>
                                                      <option value="<?php echo $Block->project_block_id; ?>" <?php echo $selected; ?>><?php echo $Block->project_block_name; ?></option>
                                                  <?php
                                                    }
                                                  } else {
                                                    echo '<option value="0">No Block/Tower found</option>';
                                                  } ?>
                                                </select>
                                              </div>
                                              <div class="col-md-6 form-group">
                                                <label>Floor Number/Name</label>
                                                <input type="text" name="projects_floor_name" value='<?php echo $Floors->projects_floor_name; ?>' class="form-control" required>
                                              </div>
                                              <div class="col-md-12 form-group">
                                                <label>Floor Highlights/Tag</label>
                                                <input type="text" name="projects_floors_tag" value='<?php echo $Floors->projects_floors_tag; ?>' class="form-control" required>
                                              </div>
                                              <div class="col-md-12 form-group">
                                                <label>Floor Details</label>
                                                <textarea name="project_floors_desc" class="form-control" rows="3"><?php echo SECURE($Floors->project_floors_desc, "d"); ?></textarea>
                                              </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                          <?php
                                          $CheckUnits = CHECK("SELECT * FROM project_units where project_floor_id='" . $Floors->projects_floors_id . "'");
                                          if ($CheckUnits == null) {
                                            echo CONFIRM_DELETE_POPUP(
                                              "floors",
                                              [
                                                "remove_project_floors" => true,
                                                "control_id" => $Floors->projects_floors_id,
                                              ],
                                              "projectcontroller",
                                              "<i class='fa fa-trash'></i> Remove Permanent",
                                              "btn btn-lg text-danger pull-left"
                                            );
                                          } ?>
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                          <button type="submit" class="btn app-bg" name="UpdateProjectBlockFloorRecord">Update Records</button>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                              <?php }
                              } else {
                                echo "<a href=''>NO Floor Found!</a><br>";
                                echo CONFIRM_DELETE_POPUP(
                                  "blocks",
                                  [
                                    "remove_project_blocks" => true,
                                    "control_id" => $ProjectBlockID,
                                  ],
                                  "projectcontroller",
                                  "<i class='fa fa-trash'></i> Remove Block Permanently",
                                  "btn btn-lg text-danger pull-right"
                                );
                              } ?>
                            <?php } else {
                              echo NoData("Please select any block");
                            } ?>

                          </div>
                        </div>
                      </div>
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

  <div class="modal fade" id="property_units" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class='app-bg p-2 mt-0 m-b-0'>Add Property Units</h4>
        </div>
        <div class="modal-body">
          <form action="<?php echo CONTROLLER; ?>/projectcontroller.php" method="POST" class="access-form">
            <?php FormPrimaryInputs(true, [
              "project_id" => $ProjectId,
              "project_block_id" => $ProjectBlockID,
            ]); ?>
            <div class="row">
              <div class="col-md-4 form-group">
                <label>Select Floors Number</label>
                <select name="project_floor_id" class="form-control" required>
                  <?php
                  if ($GetBlockFloors != null) {
                    foreach ($GetBlockFloors as $ProjectFloors) {
                  ?>
                      <option value="<?php echo $ProjectFloors->projects_floors_id; ?>"><?php echo $ProjectFloors->projects_floor_name; ?></option>
                  <?php
                    }
                  } else {
                    echo '<option value="0">No Floor found</option>';
                  } ?>
                </select>
              </div>
              <div class="col-md-4 form-group">
                <label>Unit Type</label>
                <select name='projects_unit_type' class="form-control" required>
                  <?php echo InputOptions([
                    "FLAT" => "FLAT",
                    "PLOT" => "PLOT",
                    "SHOP" => "SHOP",
                    "STORE" => "STORE",
                    "VILLA" => "VILLA",
                    "PARKING" => "PARKING",
                    "STUDIO_APARTMENT" => "Studio Apartment",
                    "APARTMENT" => "APARTMENT",
                    "CONDOMINIUM" => "CONDOMINIUM",
                    "OFFICE" => "OFFICE",
                    "LAND" => "LAND",
                    "ROOM" => "ROOM",
                    "OPEN_SPACE" => "Open Space"
                  ], "FLAT"); ?>
                </select>
              </div>
              <div class="col-md-4 form-group">
                <label>Unit Number</label>
                <input type="text" name="projects_unit_name" class="form-control" required>
              </div>
              <div class="col-md-3 form-group">
                <label>Unit Area</label>
                <input type="text" id='UnitArea' oninput="CalculatePrice()" name="project_unit_area" class="form-control" required>
              </div>
              <div class="col-md-3 form-group">
                <label>Unit Measure Type</label>
                <select name="project_unit_measurement_unit" class="form-control">
                  <?php echo InputOptions([
                    "sq. yards" => "Sq. Yards",
                    "sq. ft" => "Sq. ft",
                    "sq. m" => "Sq. m",
                    "acres" => "Acres",
                    "hectares" => "Hectares",
                    "square meters" => "Square meters",
                  ], "sq. ft"); ?>
                </select>
              </div>
              <div class="col-md-6 form-group">
                <label>Unit Sale Rate</label>
                <input type="text" id='UnitRate' oninput="CalculatePrice()" name="unit_per_price" class="form-control" required>
              </div>
              <div class="col-md-4 form-group">
                <label>Unit Price</label>
                <input type="text" readonly id='UnitNetRate' name="project_unit_price" class="form-control">
              </div>
              <div class="col-md-4 form-group">
                <label>Broker Rate</label>
                <input type="text" name="unit_broker_rate" class="form-control">
              </div>
              <div class="col-md-4 form-group">
                <label>Unit BHK Type</label>
                <select name='project_unit_bhk_type' class="form-control" required>
                  <?php echo InputOptions([
                    "1BHK" => "1 BHK",
                    "2BHK" => "2 BHK",
                    "3BHK" => "3 BHK",
                    "4BHK" => "4 BHK",
                    "5BHK" => "5 BHK",
                    "6BHK" => "6 BHK",
                    "OPEN_SPACE" => "OPEN_SPACE",
                    "PARKING" => "PARKING",
                    "STUDIO_APARTMENT" => "STUDIO APARTMENT"
                  ], "2BHK"); ?>
                </select>
              </div>
              <div class="col-md-12 form-group">
                <label>Unit Highlights/Tag</label>
                <input type="text" name="project_unit_highlights" class="form-control">
              </div>
              <div class="col-md-12 form-group">
                <label>Unit More details</label>
                <textarea name="project_unit_description" class="form-control" rows="3"></textarea>
              </div>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn app-bg" name="SaveProjectBlockFloorUnitsRecord">Save Records</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    function CalculatePrice() {
      var UnitArea = document.getElementById('UnitArea').value;
      var UnitRate = document.getElementById('UnitRate').value;
      var UnitNetRate = document.getElementById('UnitNetRate');
      UnitNetRate.value = parseFloat(UnitArea) * parseFloat(UnitRate);
    }
  </script>
  <?php include '../../../include/footer_files.php'; ?>
</body>

</html>
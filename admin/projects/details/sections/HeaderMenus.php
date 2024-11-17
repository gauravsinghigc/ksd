<div class="row">
  <div class="col-md-12">
    <h3 class="m-t-3 m-b-0"><i class="fa fa-briefcase app-text"></i> <?php echo $PageName; ?></h3>
  </div>
  <div class="col-md-12 text-right m-b-7">
    <a data-toggle="modal" data-target="#property_blocks" class="btn btn-md btn-info">Add Block/Tower</a>
    <a data-toggle="modal" data-target="#property_floors" class="btn btn-md btn-primary">Add Floor</a>
  </div>
</div>

<div class="modal fade" id="property_floors" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class='app-bg p-2 mt-0 m-b-0'>Add Block/Tower Floors</h4>
      </div>
      <div class="modal-body">
        <form action="<?php echo CONTROLLER; ?>/projectcontroller.php" method="POST" class="access-form">
          <?php FormPrimaryInputs(true, [
            "project_main_id" => $ProjectId,
          ]); ?>
          <div class="row">
            <div class="col-md-6 form-group">
              <label>Select Block/Tower Number</label>
              <select name="projects_floors_block_id" class="form-control" required>
                <?php
                $GetProjects = FetchConvertIntoArray("SELECT * FROM project_blocks where project_main_id='$ProjectId'", true);
                if ($GetProjects != null) {
                  foreach ($GetProjects as $ProjectBlocks) {
                    if ($ProjectBlocks->project_block_id == IfRequested("GET", "GetProjectBlock", 1, false)) {
                      $selected = "selected";
                    } else {
                      $selected = "";
                    }
                ?>
                    <option value="<?php echo $ProjectBlocks->project_block_id; ?>" <?php echo $selected; ?>><?php echo $ProjectBlocks->project_block_name; ?></option>
                <?php
                  }
                } else {
                  echo '<option value="0">No Block/Tower found</option>';
                } ?>
              </select>
            </div>
            <div class="col-md-6 form-group">
              <label>Floor Number/Name</label>
              <input type="text" name="projects_floor_name" class="form-control" required>
            </div>
            <div class="col-md-12 form-group">
              <label>Floor Highlights/Tag</label>
              <input type="text" name="projects_floors_tag" class="form-control" required>
            </div>
            <div class="col-md-12 form-group">
              <label>Floor Details</label>
              <textarea name="project_floors_desc" class="form-control" rows="3"></textarea>
            </div>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn app-bg" name="SaveProjectBlockFloorRecord">Save Records</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="property_blocks" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class='app-bg p-2 mt-0 m-b-0'>Add Project Block/Tower</h4>
      </div>
      <div class="modal-body">
        <form action="<?php echo CONTROLLER; ?>/projectcontroller.php" method="POST" class="access-form">
          <?php FormPrimaryInputs(true, [
            "project_main_id" => $ProjectId,
          ]); ?>
          <div class="row">
            <div class="col-md-12 form-group">
              <label>Block/Tower Name</label>
              <input type="text" name="project_block_name" class="form-control" required>
            </div>
            <div class="col-md-12 form-group">
              <label>Block/Tower Details</label>
              <textarea name="project_block_descriptions" class="form-control" rows="3"></textarea>
            </div>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn app-bg" name="SaveProjectBlockRecord">Save Records</button>
        </form>
      </div>
    </div>
  </div>
</div>
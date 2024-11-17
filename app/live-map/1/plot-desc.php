<!-- plot details -->
<div class="plot-desc">
 <h4>Search Plot</h4>
 <form action="" method="get">
  <div class="row">
   <div class="col-md-9 col-sm-9 col-xs-9 col pr-0">
    <div class="form-group">
     <input type="text" name="plot_no" onchange="form.submit()" class="form-control form-control-sm" list="plots" placeholder="Enter Plot no like p1, plot1, p-1" required="">
     <datalist id="plots">
      <?php
      $sql = "SELECT * FROM project_units where projects_unit_type='PLOT' and project_id='$projectid'";
      $query = mysqli_query($DBConnection, $sql);
      $TotalPlots = mysqli_num_rows($query);
      while ($fetch = mysqli_fetch_array($query)) { ?>
       <option value="<?php echo $fetch['projects_unit_name']; ?>"></option>
      <?php
      } ?>
     </datalist>
    </div>
   </div>
   <div class="col-md-3 col-sm-3 col-xs-3 col pl-0 pr-0">
    <button type="submit" name="search" value="true" class="btn btn-sm btn-primary">Search</button>
   </div>
   <div class="col-md-12">
    <p style="font-size:0.8rem !important;margin-bottom:0px;margin-top:0.5rem !important;"><b class="text-danger">Hint
      <br></b> Move cursor on plots
     and
     details will be
     here or search plot no then their
     details
     will also be here... </p>
   </div>
  </div>
 </form>

 <hr>

 <?php if (isset($_GET['plot_no'])) { ?>
  <h6>Search Results : <b><?php echo $_GET['plot_no']; ?></b></h6>

  <?php
  $plot_no = $_GET['plot_no'];
  $sql = "SELECT * FROM project_units where projects_unit_type='PLOT' and projects_unit_name='$plot_no' and project_id='$projectid'";
  $query = mysqli_query($DBConnection, $sql);
  $CountPLots = mysqli_num_rows($query);
  if ($CountPLots == 0 || $CountPLots == null) { ?>
   <h6 class="text-danger"><i class="fa fa-warning"></i> No Details Available</h6>
   <p>It seems plot no <b><?php echo $plot_no; ?></b> is not listed in the database or not available at the moment!</p>
  <?php
  } else { ?>
   <?php
   $sql = "SELECT * FROM project_units where projects_unit_type='PLOT' and projects_unit_name='$plot_no' and project_id='$projectid'";
   $query = mysqli_query($DBConnection, $sql);
   $TotalPlots = mysqli_num_rows($query);
   while ($fetch = mysqli_fetch_array($query)) {
    $project_units_id = $fetch['project_units_id'];
    $projects_unit_name = $fetch['projects_unit_name'];
    $project_unit_measurement_unit = $fetch['project_unit_measurement_unit'];
    $project_unit_description = $fetch['project_unit_description'] . "<br>Area : " . $fetch['project_unit_area'] . $fetch['project_unit_measurement_unit'] . "<br> Cost : Rs." . $fetch['project_unit_price'] . "<br> Unit Price : Rs." . $fetch['unit_per_price'] . "/" . $project_unit_measurement_unit;
    $Status = $fetch['project_unit_status'];
    $CreatedAt = $fetch['created_at'];
    $updatedat = $fetch['updated_at'];
    if ($Status == "HOLD") { ?>
     <script>
      var PLOT_<?php echo $projects_unit_name; ?> = document.getElementById("<?php echo $projects_unit_name; ?>");
      PLOT_<?php echo $projects_unit_name; ?>.classList.add("hold");
      PLOT_<?php echo $projects_unit_name; ?>.classList.remove("sold");
      PLOT_<?php echo $projects_unit_name; ?>.classList.remove("active");
      PLOT_<?php echo $projects_unit_name; ?>.classList.add("zoomed");
     </script>
    <?php
    } else if ($Status == "SOLD") { ?>
     <script>
      var PLOT_<?php echo $projects_unit_name; ?> = document.getElementById("<?php echo $projects_unit_name; ?>");
      PLOT_<?php echo $projects_unit_name; ?>.classList.remove("hold");
      PLOT_<?php echo $projects_unit_name; ?>.classList.add("sold");
      PLOT_<?php echo $projects_unit_name; ?>.classList.remove("active");
      PLOT_<?php echo $projects_unit_name; ?>.classList.add("zoomed");
     </script>
    <?php
    } else { ?>
     <script>
      var PLOT_<?php echo $projects_unit_name; ?> = document.getElementById("<?php echo $projects_unit_name; ?>");
      PLOT_<?php echo $projects_unit_name; ?>.classList.remove("hold");
      PLOT_<?php echo $projects_unit_name; ?>.classList.remove("sold");
      PLOT_<?php echo $projects_unit_name; ?>.classList.add("active");
      PLOT_<?php echo $projects_unit_name; ?>.classList.add("zoomed");
     </script>
    <?php
    } ?>
    <?php if ($Status == "SOLD") {
     $Status = "<span class='btn btn-sm btn-danger'>SOLD</span>"; ?>
    <?php
    } else if ($Status == "HOLD") {
     $Status = "<span class='btn btn-sm btn-warning'>HOLD</span>"; ?>
    <?php
    } else {
     $Status = "<span class='btn btn-sm btn-success'>ACTIVE</span>";
    } ?>
    <!-- area description -->
    <div class="area-description">
     <h4 class="text-primary"><strong>PLOT ID : </strong><span id="PlotNo"> <?php echo $projects_unit_name; ?></span></h4>
     <hr>
     <h5 class="">Plot Description :</h5>
     <h6 class="" id="areadesc">
      <?php echo $project_unit_description; ?><br>
      Created at : <?php echo $CreatedAt; ?><br>
      Last Updated at : <?php echo $updatedat; ?>
     </h6>
     <h5 class=""><strong>STATUS :</strong> <span id="status"><?php echo $Status; ?></span></h5>
     <hr>
    </div>


  <?php
   }
  } ?>
  <hr>
  <a href="index.php" class="btn btn-sm btn-danger">Remove Search & View All</a>
 <?php
 } else { ?>
  <h6><b>Plot Details</b></h6>
  <?php
  $sql = "SELECT * FROM project_units where projects_unit_type='PLOT' and project_id='$projectid'";
  $query = mysqli_query($DBConnection, $sql);
  $TotalPlots = mysqli_num_rows($query);
  while ($fetch = mysqli_fetch_array($query)) {
   $project_units_id = $fetch['project_units_id'];
   $projects_unit_name = $fetch['projects_unit_name'];
   $project_unit_measurement_unit = $fetch['project_unit_measurement_unit'];

   $project_unit_description = $fetch['project_unit_description'] . "<br>Area : " . $fetch['project_unit_area'] . $fetch['project_unit_measurement_unit'] . "<br> Cost :" . $fetch['project_unit_price'] . "<br> Unit Price : Rs." . $fetch['unit_per_price'] . "/" . $project_unit_measurement_unit;
   $Status = $fetch['project_unit_status'];
   $CreatedAt = $fetch['created_at'];
   $updatedat = $fetch['updated_at'];
   if ($Status == "HOLD") { ?>
    <script>
     var PLOT_<?php echo $projects_unit_name; ?> = document.getElementById("<?php echo $projects_unit_name; ?>");
     PLOT_<?php echo $projects_unit_name; ?>.classList.add("hold");
     PLOT_<?php echo $projects_unit_name; ?>.classList.remove("sold");
     PLOT_<?php echo $projects_unit_name; ?>.classList.remove("active");
     PLOT_<?php echo $projects_unit_name; ?>.classList.add("zoom");
    </script>
   <?php
   } else if ($Status == "SOLD") { ?>
    <script>
     var PLOT_<?php echo $projects_unit_name; ?> = document.getElementById("<?php echo $projects_unit_name; ?>");
     PLOT_<?php echo $projects_unit_name; ?>.classList.remove("hold");
     PLOT_<?php echo $projects_unit_name; ?>.classList.add("sold");
     PLOT_<?php echo $projects_unit_name; ?>.classList.remove("active");
     PLOT_<?php echo $projects_unit_name; ?>.classList.add("zoom");
    </script>
   <?php
   } else { ?>
    <script>
     var PLOT_<?php echo $projects_unit_name; ?> = document.getElementById("<?php echo $projects_unit_name; ?>");
     PLOT_<?php echo $projects_unit_name; ?>.classList.remove("hold");
     PLOT_<?php echo $projects_unit_name; ?>.classList.remove("sold");
     PLOT_<?php echo $projects_unit_name; ?>.classList.add("active");
     PLOT_<?php echo $projects_unit_name; ?>.classList.add("zoom");
    </script>
   <?php
   } ?>
   <?php if ($Status == "SOLD") {
    $Status = "<span class='btn btn-sm btn-danger'>SOLD</span>"; ?>
   <?php
   } else if ($Status == "HOLD") {
    $Status = "<span class='btn btn-sm btn-warning'>HOLD</span>"; ?>
   <?php
   } else {
    $Status = "<span class='btn btn-sm btn-success'>ACTIVE</span>";
   } ?>
   <!-- area description -->
   <div class="area-description" id="Description<?php echo $projects_unit_name; ?>" style="display:none;">
    <h4 class="text-primary"><strong>PLOT ID : </strong><span id="PlotNo"><?php echo $projects_unit_name; ?></span></h4>
    <hr>
    <h5 class="">Plot Description :</h5>
    <h6 class="" id="areadesc">
     <?php echo $project_unit_description; ?><br>
     Created at : <?php echo $CreatedAt; ?><br>
     Last Updated at : <?php echo $updatedat; ?>
    </h6>
    <br>
    <h5 class=""><strong>STATUS :</strong> <span id="status"><?php echo $Status; ?></span></h5>
    <?php if ($Status == "ACTIVE") { ?>
     <a href="" class="btn btn-md btn-warning">Get Enquiry</a>
    <?php   } else { ?>
    <?php } ?>
    <hr>
   </div>

   <script>
    let PLOT_<?php echo $projects_unit_name; ?>_LIST = document.getElementById("<?php echo $projects_unit_name; ?>");

    // This handler will be executed only once when the cursor
    // moves over the unordered list
    PLOT_<?php echo $projects_unit_name; ?>_LIST.addEventListener("mouseenter", function(event) {
     // highlight the mouseenter target
     document.getElementById("Description<?php echo $projects_unit_name; ?>").style.display = "block";
     // reset the color after a short delay

    }, false);

    // This handler will be executed every time the cursor
    // is moved over a different list item
    PLOT_<?php echo $projects_unit_name; ?>_LIST.addEventListener("mouseover", function(event) {
     // highlight the mouseover target
     event.target.document.getElementById("Description<?php echo $projects_unit_name; ?>").style.display = "block";

    }, false);

    PLOT_<?php echo $projects_unit_name; ?>_LIST.addEventListener("mouseout", function(event) {
     // highlight the mouseover target
     document.getElementById("Description<?php echo $projects_unit_name; ?>").style.display = "none";
    }, false);
   </script>

 <?php
  }
 }
 $ProjectSelect = "SELECT * FROM projects where Projects_id='$projectid'";
 $Query = mysqli_query($DBConnection, $ProjectSelect);
 $Fetch = mysqli_fetch_array($Query); ?>
</div>
<div class="project-desc">
 <div class="c-box">
  <h4>Project Details</h4>
  <table class="table table-striped">
   <tr>
    <th>Project Name</th>
    <td><?php echo $Fetch['project_title']; ?></td>
   </tr>
   <tr>
    <th>Project Type</th>
    <td><?php echo $Fetch['project_type']; ?></td>
   </tr>
   <tr>
    <th>Area</th>
    <td><?php echo $Fetch['project_area']; ?> <?php echo $Fetch['project_measure_unit']; ?></td>
   </tr>
   <tr>
    <th>Status</th>
    <td><?php echo $Fetch['project_status']; ?></td>
   </tr>
   <tr>
    <th>Created At</th>
    <td><?php echo $Fetch['created_at']; ?></td>
   </tr>
   <tr>
    <th>Updated At</th>
    <td><?php echo $Fetch['updated_at']; ?></td>
   </tr>
   <tr>
    <th>Descriptions</th>
    <td><?php echo $Fetch['project_descriptions']; ?></td>
   </tr>
  </table>

  <h6>Plot Details</h6>
  <table class="table table-striped">
   <tr>
    <th>Total Plots</th>
    <td><?php echo $TotalPlotsCount; ?> Plots</td>
   </tr>
   <tr>
    <th>Listed</th>
    <td><?php echo $TotalPlotsListing; ?> Plots</td>
   </tr>
   <tr>
    <th>Unlisted</th>
    <td><?php echo $TotalUnlistedPlots; ?> Plots</td>
   </tr>
   <tr>
    <th>Active</th>
    <td><?php echo $TotalPlotsActive; ?> Plots</td>
   </tr>
   <tr>
    <th>Sold</th>
    <td><?php echo $TotalPlotsSold; ?> Plots</td>
   </tr>
   <tr>
    <th>Hold</th>
    <td><?php echo $TotalPlotsHold; ?> Plots</td>
   </tr>
  </table>
  <h6>Color Definitions</h6>
  <table class="table table-striped">
   <tr>
    <th style="width:15%;">Color</th>
    <th>Meaning</th>
   </tr>
   <tr>
    <td>
     <div class="p-2 bg-white" style="box-shadow:0px 0px 1px black !important;"></div>
    </td>
    <td>
     UNLISTED
    </td>
   </tr>
   <tr>
    <td>
     <div class="p-2 active"></div>
    </td>
    <td>
     ACTIVE (UNSOLD)
    </td>
   </tr>
   <tr>
    <td>
     <div class="p-2 sold"></div>
    </td>
    <td>
     SOLD
    </td>
   </tr>
   <tr>
    <td>
     <div class="p-2 hold"></div>
    </td>
    <td>
     HOLD
    </td>
   </tr>
  </table>
 </div>
</div>
<script>
 function ShowDetails(data) {

 }
</script>
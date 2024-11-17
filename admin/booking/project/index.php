<?php
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';

if (isset($_SESSION['TEMP_BOOKING_SESSION'])) {
   if ($_SESSION['TEMP_BOOKING_SESSION'] == NULL) {
      LOCATION("warning", "Please Start Fresh Bookings", ADMIN_URL . "/booking/new_booking.php");
   }
}

if (isset($_GET['customer_id'])) {
   $_SESSION['customer_id'] = $_GET['customer_id'];
} else {
   $_SESSION['customer_id'] = $_SESSION['customer_id'];
}

if (isset($_GET['p_search'])) {
   $required_project_id = $_GET['p_search'];
   $_SESSION['p_search'] = $_GET['p_search'];
} else {
   if (isset($_SESSION['p_search'])) {
      $required_project_id = $_SESSION['p_search'];
   } else {
      $required_project_id = "0";
   }
}

if (isset($_GET['block_search'])) {
   $block_search_id = $_GET['block_search'];
   $_SESSION['block_search_id'] = $_GET['block_search'];
} else {
   if (isset($_SESSION['block_search_id'])) {
      $block_search_id = $_SESSION['block_search_id'];
   } else {
      $block_search_id = "0";
   }
}

if (isset($_GET['floor_search'])) {
   $floor_search_id = $_GET['floor_search'];
   $_SESSION['floor_search_id'] = $_GET['floor_search'];
} else {
   if (isset($_SESSION['floor_search_id'])) {
      $floor_search_id = $_SESSION['floor_search_id'];
   } else {
      $floor_search_id = "0";
   }
}

if (isset($_GET['mode'])) {
   $type = $_SESSION['TYPE'];
   $plot_id = $_SESSION['plot_id'];
   $project_id = $_SESSION['project_id'];
   $required_project_id = $_SESSION['project_id'];
   $_SESSION['p_search'] = $required_project_id;
   header("location: index.php?unit_id=$plot_id");
} elseif (isset($_SESSION['project_id'])) {
   $required_project_id = $_SESSION['project_id'];
   $_SESSION['p_search'] = $required_project_id;
}

//fresh booking data
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Add Project | <?php echo company_name; ?></title>
   <?php include '../../../include/header_files.php'; ?>
</head>

<body>
   <div id="container" class="navbar-fixed mainnav-fixed mainnav-lg">
      <?php include '../../header.php'; ?>

      <!--END NAVBAR-->
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
                              <div class="col-md-12 text-center m-t-2">
                                 <div class="steps">
                                    <a href="../new_booking.php">
                                       <span class="step active"><i class="fa fa-check-circle"></i></span>
                                       <span class="step-text">Customer Selected</span>
                                    </a>
                                    <a>
                                       <span class="step run">2</span>
                                       <span class="step-text">Units Details</span>
                                    </a>
                                    <a>
                                       <span class="step">3</span>
                                       <span class="step-text">Add Payment</span>
                                    </a>
                                    <a>
                                       <span class="step">4</span>
                                       <span class="step-text">Agent Details</span>
                                    </a>
                                    <a>
                                       <span class="step run">5</span>
                                       <span class="step-text">Upload Documents</span>
                                    </a>
                                 </div>
                                 <hr>
                              </div>
                           </div>
                           <?php if (isset($_SESSION['TYPE'])) {
                           ?>
                              <div class="row">
                                 <div class="col-md-12">
                                    <h4 class="bg-danger p-1"><i class='fa fa-check'></i> <?php echo $_SESSION['TYPE']; ?> the <?php echo FETCH("SELECT * FROM project_units where project_units_id='" . $_SESSION['plot_id'] . "'", "projects_unit_name"); ?> of project <?php echo FETCH("SELECT * FROM projects where Projects_Id='" . $_SESSION['project_id'] . "'", "project_title"); ?></h4>
                                 </div>
                              </div>
                           <?php
                              $Z_Mode = "&mode=true";
                           } else {
                              $Z_Mode = "";
                           } ?>
                           <div class="row">
                              <div class="col-md-3 col-12">
                                 <form action="" method="GET">
                                    <div class="from-group">
                                       <label>Select Projects <span class="text-danger">*</span></label>
                                       <select class="form-control demo-chosen-select" name="p_search" required="" onchange="form.submit()">
                                          <option>Choose Project</option>
                                          <?php $s_p = SELECT("SELECT * FROM projects where company_id='" . company_id . "'");
                                          while ($f_p = mysqli_fetch_array($s_p)) {
                                             $projects_id = $f_p['Projects_id'];
                                             $project_title2 = $f_p['project_title'];
                                             $project_area = $f_p['project_area'];
                                             $project_measure_unit = $f_p['project_measure_unit'];
                                             if ($required_project_id == $projects_id) {
                                                $selected = "selected";
                                             } else {
                                                $selected = "";
                                             } ?>
                                             <option value="<?php echo $projects_id; ?>" <?php echo $selected; ?>> <?php echo $project_title2; ?> </option>
                                          <?php } ?>
                                       </select>
                                    </div>
                                 </form>
                              </div>
                              <div class="col-md-3 col-12">
                                 <form action="" method="GET">
                                    <div class="from-group">
                                       <label>Select Block/Tower <span class="text-danger">*</span></label>
                                       <select class="form-control demo-chosen-select" name="block_search" required="" onchange="form.submit()">
                                          <option>Choose Block/Tower</option>
                                          <?php
                                          $s_p_b = SELECT("SELECT * FROM project_blocks where project_main_id='" . $required_project_id . "'");
                                          while ($f_p_b = mysqli_fetch_array($s_p_b)) {
                                             $project_block_id = $f_p_b['project_block_id'];
                                             $project_block_name = $f_p_b['project_block_name'];
                                             if ($block_search_id == $project_block_id) {
                                                $selected = "selected";
                                             } else {
                                                $selected = "";
                                             } ?>
                                             <option value="<?php echo $project_block_id; ?>" <?php echo $selected; ?>> <?php echo $project_block_name; ?> </option>
                                          <?php } ?>
                                       </select>
                                    </div>
                                 </form>
                              </div>
                              <div class="col-md-3 col-12">
                                 <form action="" method="GET">
                                    <div class="from-group">
                                       <label>Select Floor number <span class="text-danger">*</span></label>
                                       <select class="form-control demo-chosen-select" name="floor_search" required="" onchange="form.submit()">
                                          <option>Choose Floor</option>
                                          <?php
                                          $s_p_b_f = SELECT("SELECT * FROM projects_floors where projects_floors_block_id='" . $block_search_id . "'");
                                          while ($f_p_b_f = mysqli_fetch_array($s_p_b_f)) {
                                             $projects_floors_id = $f_p_b_f['projects_floors_id'];
                                             $projects_floor_name = $f_p_b_f['projects_floor_name'];
                                             $projects_floors_tag = $f_p_b_f['projects_floors_tag'];
                                             if ($floor_search_id == $projects_floors_id) {
                                                $selected = "selected";
                                             } else {
                                                $selected = "";
                                             } ?>
                                             <option value="<?php echo $projects_floors_id; ?>" <?php echo $selected; ?>> <?php echo $projects_floor_name . " - " . $projects_floors_tag; ?> </option>
                                          <?php } ?>
                                       </select>
                                    </div>
                                 </form>
                              </div>
                              <div class="col-md-3 col-12">
                                 <form action="" method="GET">
                                    <div class="from-group">
                                       <label>Choose Project Unit <span class="text-danger">*</span></label>
                                       <select name='unit_id' class="form-control" onchange='form.submit()'>
                                          <option value="">Choose Units</option>
                                          <?php if ($required_project_id == "0") {
                                             echo "<option>Please Select Project First!</option>";
                                          } else { ?>
                                             <?php $s_p = SELECT("SELECT * FROM project_units where project_floor_id='$floor_search_id' and project_block_id='$block_search_id' and project_id='$required_project_id'");
                                             $countunits = mysqli_num_rows($s_p);
                                             if ($countunits == 0 or $countunits == null) {
                                             } else {
                                                while ($f_p = mysqli_fetch_array($s_p)) {
                                                   $project_units_id  = $f_p['project_units_id'];
                                                   $projects_unit_name = $f_p['projects_unit_name'];
                                                   $project_unit_area = $f_p['project_unit_area'];
                                                   $project_measure_unit = $f_p['project_unit_measurement_unit'];
                                                   $project_unit_price = $f_p['project_unit_price'];
                                                   $unit_per_price = $f_p['unit_broker_rate'];
                                                   $project_unit_bhk_type = $f_p['project_unit_bhk_type'];
                                                   $project_unit_highlights = $f_p['project_unit_highlights'];
                                                   $unit_broker_rate = $f_p['unit_broker_rate'];
                                                   $projects_unit_type = $f_p['projects_unit_type'];

                                                   if (isset($_GET['unit_id'])) {
                                                      if ($project_units_id == $_GET['unit_id']) {
                                                         $selected = "selected";
                                                      } else {
                                                         $selected = "";
                                                      }
                                                   } else {
                                                      $selected = "";
                                                   }
                                             ?>
                                                   <option value="<?php echo $project_units_id; ?>" <?php echo $selected; ?>> <?php echo $projects_unit_name; ?> - <?php echo $project_unit_bhk_type; ?> @ (<?php echo $project_unit_area; ?> <?php echo MeasurementUnit; ?>) : Rs.<?php echo $project_unit_price; ?> @ Rs.<?php echo $unit_broker_rate; ?> / <?php echo $project_measure_unit; ?></option>
                                          <?php }
                                             }
                                          } ?>
                                       </select>
                                    </div>
                                 </form>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-12">
                                 <hr class="m-t-0">
                                 <h4 class="section-heading p-1r">Add & Update Units Details</h4>
                              </div>
                              <?php
                              if (isset($_GET['unit_id'])) {
                                 $project_unit_id = $_GET['unit_id'];
                                 $projects = SELECT("SELECT * FROM projects where company_id='" . company_id . "' and Projects_id='$required_project_id'");
                                 $f_projects = mysqli_fetch_array($projects);
                                 $projects_id = $required_project_id;
                                 $project_title = FETCH("SELECT project_title FROM projects where projects_id='$projects_id'", "project_title");
                                 $project_area = FETCH("SELECT project_area FROM projects where projects_id='$projects_id'", "project_area");
                                 $project_measure_unit = FETCH("SELECT project_measure_unit FROM projects where projects_id='$projects_id'", "project_measure_unit");

                                 $project_block_name = FETCH("SELECT project_block_name FROM project_blocks where project_block_id='$block_search_id'", "project_block_name");
                                 $projects_floor_name = FETCH("SELECT projects_floor_name from projects_floors WHERE projects_floors_id='$floor_search_id'", "projects_floor_name");
                                 $projects_floors_tag = FETCH("SELECT projects_floors_tag from projects_floors WHERE projects_floors_id='$floor_search_id'", "projects_floors_tag");
                                 $project_unit_bhk_type = FETCH("SELECT project_unit_bhk_type FROM project_units where project_units_id='$project_unit_id'", "project_unit_bhk_type");
                                 $project_unit_highlights = FETCH("SELECT project_unit_highlights FROM project_units where project_units_id='$project_unit_id'", "project_unit_highlights");
                                 $unit_broker_rate = FETCH("SELECT unit_broker_rate FROM project_units where project_units_id='$project_unit_id'", "unit_broker_rate");


                                 $s_p = SELECT("SELECT * FROM project_units where project_units_id='$project_unit_id'");
                                 $countunits = mysqli_num_rows($s_p);
                                 if ($countunits == null or $countunits == 0) {
                                    $projects_id = $required_project_id;
                                    $project_title = FETCH("SELECT * FROM projects where projects_id='$projects_id'", "project_title");
                                    $project_area = FETCH("SELECT * FROM projects where projects_id='$projects_id'", "project_area");
                                    $project_measure_unit = FETCH("SELECT * FROM projects where projects_id='$projects_id'", "project_measure_unit");
                                    $project_measure_unit = "";
                                    $project_units_id  = "NEW";
                                    $projects_unit_name = "";
                                    $project_unit_area = "";
                                    $project_unit_price = "";
                                    $unit_per_price = "";
                                 } else {
                                    $f_p = mysqli_fetch_array($s_p);
                                    $project_units_id  = $f_p['project_units_id'];
                                    $projects_unit_name = $f_p['projects_unit_name'];
                                    $project_unit_area = $f_p['project_unit_area'];
                                    $project_unit_measurement_unit = $f_p['project_unit_measurement_unit'];
                                    $project_unit_price = (int)$project_unit_area * (int)$unit_broker_rate;
                                    $unit_per_price = $f_p['unit_per_price'];
                                 }
                              } else {
                                 $projects_id = $required_project_id;
                                 $project_title = FETCH("SELECT * FROM projects where projects_id='$projects_id'", "project_title");
                                 $project_area = FETCH("SELECT * FROM projects where projects_id='$projects_id'", "project_area");
                                 $project_measure_unit = "";
                                 $project_units_id  = "NEW";
                                 $projects_unit_name = "";
                                 $project_unit_area = "";
                                 $project_measure_unit = FETCH("SELECT * FROM projects where projects_id='$projects_id'", "project_measure_unit");
                                 $project_unit_price = "";
                                 $unit_per_price = "";
                                 $project_unit_id = "NEW";
                              }
                              ?>

                              <form class="form p-1" action="payment" method="GET">
                                 <input type="text" name="discountamount" value="" id="discountedamount" hidden="">
                                 <input type="text" name="project_unit_id" value="<?php echo $project_unit_id; ?>" hidden="">
                                 <div class="row">
                                    <div class="from-group col-md-3">
                                       <label>Project Name</label>
                                       <input type="text" name="project_name" class="form-control" value="<?php echo IfRequested("GET", "p_search", $project_title, false); ?>" placeholder="" readonly="">
                                    </div>
                                    <div class="from-group col-md-3">
                                       <label>Project Area</label>
                                       <input type="text" name="project_area" class="form-control" value="<?php echo $project_area; ?> <?php echo $project_measure_unit; ?>" placeholder="" readonly="">
                                    </div>

                                    <div class="from-group col-md-3">
                                       <label>Block Name</label>
                                       <input type="text" name="block_name" value="<?php echo $project_block_name; ?>" readonly="" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="from-group col-md-3">
                                       <label>Floor Number</label>
                                       <input type="text" name="floor_number" value="<?php echo $projects_floor_name . " - " . $projects_floors_tag; ?>" readonly="" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="from-group col-md-3">
                                       <label>Units Name</label>
                                       <input type="text" name="unit_name" value="<?php echo $projects_unit_name; ?>" readonly="" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="from-group col-md-3">
                                       <label>Unit BHK Details</label>
                                       <input type="text" name="unit_bhk_type" value="<?php echo $project_unit_bhk_type . " - " . $project_unit_highlights; ?>" readonly="" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="from-group col-md-3">
                                       <label>Units Area (<?php echo MeasurementUnit; ?>)</label>
                                       <input type="text" name="unit_area" value="<?php echo $project_unit_area; ?> <?php echo $project_measure_unit; ?>" readonly="" class=" form-control" placeholder="" required="">
                                    </div>
                                    <div class="from-group col-md-3">
                                       <label>Sale Rate per unit @ Login Rate</label>
                                       <input type="text" name="unit_rate" id="rate" readonly value="<?php echo $unit_broker_rate; ?>" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="from-group col-md-3">
                                       <label>Units Cost (Rs.)</label>
                                       <input type="text" id="unit_cost" oninput="calculatepayment()" name="unit_cost" value="<?php echo (int)$project_unit_area * (int)$unit_broker_rate; ?>" class="form-control" placeholder="" required="">
                                    </div>
                                 </div>

                                 <div style="display:none;" id="chargesaddareas">
                                    <div class="row m-t-20">
                                       <div class="col-md-12">
                                          <h4 class="section-heading">Discount & Charges</h4>
                                       </div>
                                       <div class="from-group col-md-6">
                                          <div class="row">
                                             <div class="col-md-8 col-12">
                                                <label>Charge name</label>
                                                <input type="text" name="chargename" oninput="chargesCalcu()" id="chargename" value="" class="form-control" placeholder="">
                                             </div>
                                             <div class="col-md-4 col-12">
                                                <label>Charges in (%)</label>
                                                <input type="text" name="charges" oninput="chargesCalcu()" id="chargevalue" class="form-control" placeholder="">
                                             </div>
                                          </div>
                                       </div>

                                       <div class="from-group col-md-6">
                                          <div class="row">
                                             <div class="col-md-8 col-12">
                                                <label>Discount as Per Unit Area</label>
                                                <input type="text" name="discountname" oninput="chargesCalcu()" id="discountname" value="PER UNIT AREA" readonly="" class="form-control" placeholder="">
                                             </div>
                                             <div class="col-md-4 col-12">
                                                <label>Rs./<?php echo MeasurementUnit; ?></label>
                                                <input type="text" name="discount" value="" oninput="chargesCalcu()" id="discountareaamount" class="form-control" placeholder="">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-12">
                                       <a class="btn btn-md btn-primary" onclick="Databar('chargesaddareas', 'btncharges', 'RemoveCharges', 'Add Charges', 'Remove Charges')" id="btncharges"><span id="RemoveCharges"><i class="fa fa-plus"></i> Add Charges</span></a>
                                    </div>
                                    <div class="from-group col-md-12 text-right">
                                       <label class="fs-17">Total Cost : <span id="unitprice_txt" class="fs-18 text-black">Rs.<?php echo $project_unit_price; ?></span></label><br>
                                       <label class="fs-17" id="chargeshow_txt"></label>
                                       <label class="fs-17" id="discountareashow_txt"></label>
                                       <label class="fs-17">Net Payable Amount : <span id="netprice_txt" class="fs-25 text-success">Rs.<?php echo $project_unit_price; ?></span></label>
                                       <br>
                                       <span class="fs-12"><span class="text-danger">Note:</span> All values are in round figure and removed decimal values.</span>
                                       <input type="hidden" id="net_payable" name="net_payable_amount" value="<?php echo $project_unit_price; ?>" class="form-control" placeholder="" required="">
                                    </div>

                                    <div class="from-group col-md-12 text-center m-t-5 m-b-20">
                                       <a href="../new_booking.php" class="btn btn-lg btn-default"><i class="fa fa-angle-left"></i> Back to Customers </a>
                                       <button class="btn btn-lg btn-primary square" type="SUBMIT" name="continueforpayment">Continue <i class="fa fa-angle-right"></i></button>
                                    </div>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <!-- end -->
         </div>
         <!--===================================================-->
         <!--END CONTENT CONTAINER-->

         <script>
            function chargesCalcu() {

               //integer values
               var chargevalue = document.getElementById('chargevalue');
               var net_payable = document.getElementById('net_payable');
               var discountareaprice = document.getElementById('discountareaprice');
               var unit_cost = document.getElementById('unit_cost');
               var project_unit_area = <?php echo $project_unit_area; ?>;

               //text values
               var unitprice_txt = document.getElementById('unitprice_txt');
               var chargeshow_txt = document.getElementById('chargeshow_txt');
               var netprice_txt = document.getElementById('netprice_txt');
               var chargename = document.getElementById('chargename');

               //input values
               var discountname = document.getElementById('discountname');
               var discountareaamount = document.getElementById("discountareaamount");

               //text innerhtml
               var discountareashow_txt = document.getElementById('discountareashow_txt');

               //conditions
               if (chargevalue.value == "" || chargevalue.value == null || chargevalue.value == 0 || chargevalue.value == " ") {
                  var chargepercentage = null;
               } else {
                  var chargepercentage = chargevalue.value;
               }

               if (chargename.value != null && chargename.value != "" && chargename.value != " ") {
                  if (chargepercentage == null) {
                     chargeshow_txt.style.display = "none";
                     var netchargeamount = 0;
                  } else {
                     chargeshow_txt.style.display = "block";
                     var chargeamounts = Math.round(+unit_cost.value / 100 * +chargepercentage);
                     chargeshow_txt.innerHTML = chargename.value + " (" + chargepercentage + "%)  : <span class='text-black'>+ Rs." + chargeamounts + " </span>";
                     var netchargeamount = chargeamounts;
                  }
               } else {
                  chargeshow_txt.style.display = "none";
                  var netchargeamount = 0;
               }

               if (discountareaamount.value == null || discountareaamount.value == "" || discountareaamount.value == " " || discountareaamount.value == 0) {
                  var discountamount = null;
               } else {
                  var discountamount = discountareaamount.value;
               }
               if (discountamount == null) {
                  discountareashow_txt.style.display = "none";
                  var netdiscountamount = 0;
               } else {
                  discountareashow_txt.style.display = "block";
                  var discountamounts = +project_unit_area * discountamount;
                  discountareashow_txt.innerHTML = discountname.value + " (Rs." + discountamount + ")  : <span class='text-black'>- Rs." + discountamounts + " </span>";
                  var netdiscountamount = discountamounts;
                  document.getElementById("discountedamount").value = discountamounts;
               }

               //add to form
               netpayableamount = (+unit_cost.value + +netchargeamount) - +netdiscountamount;
               net_payable.value = netpayableamount;
               netprice_txt.innerHTML = "Rs." + netpayableamount;
            }
         </script>

         <!-- end -->
         <?php include '../../sidebar.php'; ?>
         <?php include '../../footer.php'; ?>
         <script>
            function goBack() {
               window.history.back();
            }
         </script>
      </div>

      <?php include '../../../include/footer_files.php'; ?>
      <script>
         function calculatepayment() {
            var unit_rate = document.getElementById("rate").value;
            var unit_area = "<?php echo $project_unit_area; ?>";
            var unit_cost = document.getElementById("unit_cost").value;

            total_fresh_price = unit_cost;
            unit_fresh_rate = (unit_cost / unit_area).toFixed(3);

            document.getElementById("unit_cost").value = total_fresh_price;
            document.getElementById("net_payable").value = total_fresh_price;
            document.getElementById("netprice_txt").innerHTML = "Rs." + total_fresh_price;
            document.getElementById("unitprice_txt").innerHTML = "Rs." + total_fresh_price;
            document.getElementById("rate").value = unit_fresh_rate;
         }
      </script>
      <script>
         function calculatepayment2() {
            var unit_rate2 = document.getElementById("rate2").value;
            var unit_area2 = document.getElementById("unit_area2").value;

            total_fresh_price2 = unit_rate2 * unit_area2;

            document.getElementById("unit_cost2").value = total_fresh_price2;
            document.getElementById("net_payable").value = total_fresh_price2;
            document.getElementById("netprice_txt").innerHTML = "Rs." + total_fresh_price2;
            document.getElementById("unitprice_txt").innerHTML = "Rs." + total_fresh_price2;
         }
      </script>
</body>

</html>
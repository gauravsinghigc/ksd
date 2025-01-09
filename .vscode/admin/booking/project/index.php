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
                                       <span class="step-text">Plot Details</span>
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
                              <div class="col-md-6 col-12">
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
                              <div class="col-md-6 col-12">
                                 <form action="?p_search=<?php echo IfRequested("GET", "p_search", false); ?>&" method="GET">
                                    <div class="from-group">
                                       <label>Choose Project Unit <span class="text-danger">*</span></label>
                                       <input class="form-control" list="plots" data-placeholder="Choose a Plot No..." name="unit_id" required="" onchange="form.submit()">
                                       <datalist id="plots">
                                          <option value="">Choose Plot</option>
                                          <?php if ($required_project_id == "0") {
                                             echo "<option>Please Select Project First!</option>";
                                          } else { ?>
                                             <?php $s_p = SELECT("SELECT * FROM project_units where project_id='$required_project_id'");
                                             $countunits = mysqli_num_rows($s_p);
                                             if ($countunits == 0 or $countunits == null) {
                                             } else {
                                                while ($f_p = mysqli_fetch_array($s_p)) {
                                                   $project_units_id  = $f_p['project_units_id'];
                                                   $projects_unit_name = $f_p['projects_unit_name'];
                                                   $project_unit_area = $f_p['project_unit_area'];
                                                   $project_measure_unit = $f_p['project_unit_measurement_unit'];
                                                   $project_unit_price = $f_p['project_unit_price'];
                                                   $unit_per_price = $f_p['unit_per_price'];
                                             ?>
                                                   <option value="<?php echo $project_units_id; ?>"> <?php echo $projects_unit_name; ?> (<?php echo $project_unit_area; ?> <?php echo MeasurementUnit; ?>) : Rs.<?php echo $project_unit_price; ?> @ Rs.<?php echo $unit_per_price; ?> / <?php echo $project_measure_unit; ?></option>
                                          <?php }
                                             }
                                          } ?>
                                          <option value="NEW">Create New Plot</option>
                                       </datalist>
                                    </div>
                                 </form>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-12">
                                 <hr class="m-t-0">
                                 <h4 class="section-heading p-1r">Add & Update Plot Details</h4>
                              </div>
                              <?php
                              if (isset($_GET['unit_id'])) {
                                 $project_unit_id = $_GET['unit_id'];
                                 $projects = SELECT("SELECT * FROM projects where company_id='" . company_id . "' and Projects_id='$required_project_id'");
                                 $f_projects = mysqli_fetch_array($projects);
                                 $projects_id = $required_project_id;
                                 $project_title = FETCH("SELECT * FROM projects where projects_id='$projects_id'", "project_title");
                                 $project_area = FETCH("SELECT * FROM projects where projects_id='$projects_id'", "project_area");
                                 $project_measure_unit = FETCH("SELECT * FROM projects where projects_id='$projects_id'", "project_measure_unit");


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
                                    $project_unit_price = $f_p['project_unit_price'];
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
                              <?php if ($project_unit_id == "NEW") { ?>
                                 <form class="form p-1" action="../../../controller/projectcontroller.php" method="POST">
                                    <?php FormPrimaryInputs(true, [
                                       "project_unit_measurement_unit" => MeasurementUnit,
                                    ]); ?>
                                    <input type="text" name="project_id" value="<?php echo $projects_id; ?>" hidden>
                                    <div class="row">
                                       <div class="from-group col-md-6">
                                          <label>Plot Name (suggestive plot name are already exits)</label>
                                          <input type="text" name="projects_unit_name" LIST="projects_unit_name" value="" class="form-control" placeholder="" required="">
                                          <?php SUGGEST("project_units", "projects_unit_name", "ASC"); ?>
                                       </div>
                                       <div class="from-group col-md-6">
                                          <label>Plot Area (<?php echo MeasurementUnit; ?>)</label>
                                          <input type="text" name="project_unit_area" id="unit_area2" value="" class=" form-control" placeholder="" required="">
                                       </div>
                                       <div class="from-group col-md-6">
                                          <label>Rate per <?php echo MeasurementUnit; ?> (Rs.)</label>
                                          <input type="text" name="unit_per_price" id="rate2" oninput="calculatepayment2()" value="<?php echo $unit_per_price; ?>" class="form-control" placeholder="" required="">
                                       </div>
                                       <div class="from-group col-md-6">
                                          <label>Plot Cost (Rs.)</label>
                                          <input type="text" readonly="" id="unit_cost2" name="project_unit_price" value="<?php echo $project_unit_price; ?>" class="form-control" placeholder="" required="">
                                       </div>
                                       <div class="col-md-12 text-right">
                                          <button type="submit" name="create_new_project_unit" class="btn btn-md btn-success">Save Plot Details <i class="fa fa-angle-right"></i></button>
                                       </div>
                                    </div>
                                 </form>
                              <?php  } else { ?>
                                 <form class="form p-1" action="payment" method="GET">
                                    <input type="text" name="discountamount" value="" id="discountedamount" hidden="">
                                    <input type="text" name="project_unit_id" value="<?php echo $project_unit_id; ?>" hidden="">
                                    <div class="row">
                                       <div class="from-group col-md-6">
                                          <label>Project Name</label>
                                          <input type="text" name="project_name" class="form-control" value="<?php if (isset($_GET['p_search'])) {
                                                                                                                  echo $project_title2;
                                                                                                               } else {
                                                                                                                  echo $project_title;
                                                                                                               } ?>" placeholder="" readonly="">
                                       </div>
                                       <div class="from-group col-md-6">
                                          <label>Project Area</label>
                                          <input type="text" name="project_area" class="form-control" value="<?php echo $project_area; ?> <?php echo $project_measure_unit; ?>" placeholder="" readonly="">
                                       </div>
                                       <div class="from-group col-md-6">
                                          <label>Plot Name</label>
                                          <input type="text" name="unit_name" value="<?php echo $projects_unit_name; ?>" readonly="" class="form-control" placeholder="" required="">
                                       </div>
                                       <div class="from-group col-md-6">
                                          <label>Plot Area (<?php echo MeasurementUnit; ?>)</label>
                                          <input type="text" name="unit_area" value="<?php echo $project_unit_area; ?> <?php echo $project_measure_unit; ?>" readonly="" class=" form-control" placeholder="" required="">
                                       </div>
                                       <div class="from-group col-md-6">
                                          <label>Rate per <?php echo MeasurementUnit; ?> (Rs.)</label>
                                          <input type="text" name="unit_rate" id="rate" oninput="calculatepayment()" value="<?php echo $unit_per_price; ?>" class="form-control" placeholder="" required="">
                                       </div>
                                       <div class="from-group col-md-6">
                                          <label>Plot Cost (Rs.)</label>
                                          <input type="text" readonly="" id="unit_cost" name="unit_cost" value="<?php echo $project_unit_price; ?>" class="form-control" placeholder="" required="">
                                       </div>
                                    </div>
                                 <?php } ?>
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

            total_fresh_price = unit_rate * unit_area;

            document.getElementById("unit_cost").value = total_fresh_price;
            document.getElementById("net_payable").value = total_fresh_price;
            document.getElementById("netprice_txt").innerHTML = "Rs." + total_fresh_price;
            document.getElementById("unitprice_txt").innerHTML = "Rs." + total_fresh_price;
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
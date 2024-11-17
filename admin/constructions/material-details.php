<?php
require '../../require/modules.php';
require '../../require/admin/sessionvariables.php';
require "../../include/admin/common.php";

if (isset($_GET['matid'])) {
 $MaterialId = $_GET['matid'];
 $_SESSION['MATERIAL_ID'] = $MaterialId;
} else {
 $MaterialId = $_SESSION['MATERIAL_ID'];
}

$MaterialSQL = "SELECT * FROM vendor_materials where vendor_material_id='$MaterialId'";
$vendorid = FETCH($MaterialSQL, "vendor_main_id");
if ($vendorid == null) {
 header("Location: vendor-details.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <title>Constructions | <?php echo company_name; ?></title>
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
           <h3 class="m-t-5 m-b-0"><i class="fa fa-truck app-text"></i> Vendor Materials Items</h3>
           <a href="index.php" class="btn btn-md btn-default m-t-10"><i class="fa fa-angle-left"></i> Back to Dashboard</a>
           <a href="all-vendors.php" class="btn btn-md btn-default m-t-10"><i class="fa fa-angle-left"></i> Back to All Vendors</a>
           <a href="vendor-payments.php" class="btn btn-md btn-info m-t-10"><i class="fa fa-exchange"></i> View Payments</a>
           <a href="vendor-details.php" class="btn btn-md btn-info m-t-10"><i class="fa fa-file-pdf-o"></i> View Materials</a>
          </div>
         </div>

         <div class="row m-t-5">
          <div class="col-md-4">
           <h4 class="app-heading"> Vendor & Material Bill Details</h4>
           <?php
           $VendorSQL = "SELECT * FROM vendors where vendor_id='$vendorid'";
           $VendorSQL = FetchConvertIntoArray($VendorSQL, true);
           if ($VendorSQL != null) {
            foreach ($VendorSQL as $Vendor) {
           ?>
             <div class="shadow-sm p-2 b-r-1 m-b-3">
              <h5 class="app-sub-heading">Vendor Details</h5>
              <h4 class="bold m-b-2 m-t-2"><?php echo $Vendor->vendor_display_name; ?></h4>
              <h4 class="m-t-1 m-b-0 small italic"><?php echo $Vendor->vendor_highlight_details; ?></h4>
              <p class="small">
               <span><i class="fa fa-user"></i> <?php echo $Vendor->vendor_person_name; ?></span><br>
               <span><i class="fa fa-info-circle"></i> <?php echo $Vendor->vendor_person_phone; ?>, </span>
               <span><?php echo $Vendor->vendor_person_email_id; ?></span><br>
               <span><i class="fa fa-building"></i> <?php echo $Vendor->vendor_company_name; ?></span><br>
               <span><i class="fa fa-map-marker"></i>
                <?php echo $Vendor->vendor_person_street_address; ?>
                <?php echo $Vendor->vendor_person_area_locality; ?>
                <?php echo $Vendor->vendor_person_city; ?>
                <?php echo $Vendor->vendor_person_state; ?>
                <?php echo $Vendor->vendor_person_country; ?> -
                <?php echo $Vendor->vendor_person_pincode; ?>
               </span><br>
               <span><b>GST NO :</b> <?php echo $Vendor->vendor_gst_no; ?></span>
              </p>
              <hr>
              <h5 class="app-sub-heading">Bill Details</h5>
              <p class="flex-s-b">
               <span>
                <span class="fs-12 text-grey">Item Total Amount</span><br>
                <span class="text-danger">Rs. <?php echo Price(AMOUNT("SELECT vendor_material_item_net_price FROM vendor_material_items where vendor_material_main_id='$MaterialId'", "vendor_material_item_net_price"), "", ""); ?></span>
               </span>
               <span>
                <span class="fs-12 text-grey">Billing Amount</span><br />
                <span class="text-success">Rs.<?php echo Price(FETCH($MaterialSQL, "vendor_material_net_amount"), "", ""); ?></span>
               </span>
              </p>
              <p class="flex-s-b m-t-5">
               <span>
                <span class="fs-12 text-grey">Bill No</span><br>
                <span><?php echo FETCH($MaterialSQL, "vendor_material_bill_no"); ?></span>
               </span>
               <span>
                <span class="fs-12 text-grey">Bill Date</span><br>
                <span><?php echo date('d M, Y', strtotime(FETCH($MaterialSQL, "vendor_material_receive_date"))); ?></span>
               </span>
              </p>
              <p class="m-t-5">
               <span>
                <span class="fs-12 text-grey">Note/Remarks</span><br>
                <span><?php echo SECURE(FETCH($MaterialSQL, "vendor_material_remarks"), "d"); ?></span>
               </span>
              </p>
              <hr>
              <h6 class='app-sub-heading'>Upload Bill</h6>
              <?php if (FETCH($MaterialSQL, "vendor_material_uploaded_bill") != null) { ?>
               <a target="_blank" href="<?php echo STORAGE_URL; ?>/vendor/material/<?php echo $vendorid; ?>/<?php echo FETCH($MaterialSQL, "vendor_material_uploaded_bill"); ?>" class="bold text-primary link fs-12">
                <i class="fa fa-file-pdf-o text-danger"></i> <?php echo FETCH($MaterialSQL, "vendor_material_uploaded_bill"); ?>
               </a>
              <?php } else { ?>
               <span class="text-danger">No File</span>
              <?php } ?>
              <hr>
              <a class='btn btn-md btn-default' data-toggle='modal' data-target='#update_material_details'><i class='fa fa-edit'></i> Update Bill Details</a>
             </div>
           <?php
            }
           } else {
            echo "<div class='alert alert-info'>No matching vendor found.</div>";
           }
           ?>
          </div>
          <div class="col-md-8">
           <h4 class="font-bold app-heading">Bills & Materials Details</h4>
           <?php
           $VendorId = $vendorid; ?>
           <div class="row m-t-10">
            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
             <a href="">
              <div class="shadow-sm p-2r">
               <?php
               $TotalPayable = AMOUNT("SELECT vendor_material_item_net_price from vendor_materials, vendor_material_items where vendor_materials.vendor_main_id='$VendorId' and vendor_materials.vendor_material_id=vendor_material_items.vendor_material_main_id", "vendor_material_item_net_price");
               $TotalPaid = AMOUNT("SELECT vendor_paid_amount FROM vendor_transactions where vendor_main_id='$VendorId'", "vendor_paid_amount");
               $Balance = $TotalPayable - $TotalPaid;
               ?>
               <h2 class='m-b-0 m-t-0'>
                <span class="text-grey small"></span>
                <?php echo TOTAL("SELECT * FROM vendor_material_items where vendor_material_main_id='$MaterialId'"); ?>
               </h2>
               <p>
                <span class="text-grey">Total Items</span><br>
               </p>
              </div>
             </a>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
             <a href="">
              <div class="shadow-sm p-2r">
               <h2 class='m-b-0 m-t-0'>
                <span class="text-grey small">Rs.</span>
                <?php echo Price(FETCH($MaterialSQL, "vendor_material_net_amount"), "", ""); ?>
               </h2>
               <p>
                <span class="text-grey">Billing Amount</span><br>
               </p>
              </div>
             </a>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
             <a href="">
              <div class="shadow-sm p-2r">
               <h2 class='m-b-0 m-t-0'>
                <span class="text-grey small">Rs.</span>
                <?php echo Price(AMOUNT("SELECT vendor_material_item_net_price FROM vendor_material_items where vendor_material_main_id='$MaterialId'", "vendor_material_item_net_price"), "", ""); ?>
               </h2>
               <p>
                <span class="text-grey">Item Total Amount</span><br>
               </p>
              </div>
             </a>
            </div>
           </div>
           <div class="row m-t-10">
            <div class="col-md-12">
             <h4 class='app-sub-heading'>All Items Records</h4>
             <div class="w-100">
              <form action='../../controller/vendorcontroller.php' method="POST">
               <?php echo FormPrimaryInputs(true, [
                "vendor_material_main_id" => $MaterialId
               ]); ?>
               <div class="flex-s-b item-forms">
                <div class="form-group m-r-2">
                 <label>Item Name</label>
                 <input type='text' required name='vendor_material_item_name' value='' class='form-control'>
                </div>
                <div class="form-group m-r-2">
                 <label>Serial No</label>
                 <input type='text' required name='vendor_material_item_serial_no' value='' class='form-control'>
                </div>
                <div class="form-group m-r-2">
                 <label>SOS-No</label>
                 <input type='text' name='vendor_material_item_sos_number' value='' class='form-control'>
                </div>
                <div class="form-group m-r-2">
                 <label>Unit Rate</label>
                 <input type='text' id='UnitRate' oninput="GeneratePrice()" required name='vendor_material_item_unit_rate' value='' class='form-control'>
                </div>
                <div class="form-group m-r-2">
                 <label>Quantity</label>
                 <input type='number' id='Qty' oninput="GeneratePrice()" min='1' required name='vendor_material_item_qty' value='' class='form-control'>
                </div>
                <div class="form-group m-r-2">
                 <label>Qty Type</label>
                 <select name='vendor_material_item_qty_type' class='form-control' required="">
                  <?php echo InputOptions([
                   "" => "Select Qty Type",
                   "Kg" => "Kg",
                   "Litre" => "Litre",
                   "TON" => "TON",
                   "Packet" => "Packet",
                   "Bags" => "Bags",
                   "Pieces" => "Pieces",
                   "Foot" => "Foot",
                   "Meter" => "Meter",
                   "Unit" => "Unit",
                   "Gram" => "Gram",
                   "Container" => "Container"
                  ], ""); ?>
                 </select>
                </div>
                <div class="form-group m-r-2">
                 <label>Total</label>
                 <input type='number' readonly id='NetPrice' min='1' name='vendor_material_item_net_price' value='' class='form-control'>
                </div>
                <div class="form-group">
                 <button type='submit' name='AddMaterialItems' class="btn btn-lg btn-success fs-19"><i class='fa fa-plus'></i></button>
                </div>

               </div>
              </form>
             </div>
             <div class="flex-s-b bg-dark data-list">
              <div class="w-pr-5 text-white">S.No</div>
              <div class="w-pr-15 text-white">ItemName</div>
              <div class="w-pr-15 text-white">SerialNo</div>
              <div class="w-pr-15 text-white">SOSNo</div>
              <div class="w-pr-15 text-white">Rate</div>
              <div class="w-pr-15 text-white">Qty</div>
              <div class="w-pr-15 text-white">NetPrice</div>
              <div class="w-pr-15 text-white text-right">Action</div>
             </div>
             <?php
             $AllMaterialItems = FetchConvertIntoArray("SELECT * FROM vendor_material_items where vendor_material_main_id='$MaterialId'", TRUE);
             if ($AllMaterialItems != null) {
              $SerialNo = 0;
              foreach ($AllMaterialItems as $Items) {
               $SerialNo++;
             ?>
               <div class="flex-s-b data-list">
                <div class="w-pr-5">
                 <?php echo $SerialNo; ?>
                </div>
                <div class="w-pr-15 text-primary bold">
                 <?php echo $Items->vendor_material_item_name; ?>
                </div>
                <div class="w-pr-15">
                 <?php echo $Items->vendor_material_item_serial_no; ?>
                </div>
                <div class="w-pr-15">
                 <?php echo $Items->vendor_material_item_sos_number; ?>
                </div>
                <div class="w-pr-15">
                 Rs.<?php echo $Items->vendor_material_item_unit_rate; ?> /
                 <span class="text-gray"><?php echo $Items->vendor_material_item_qty_type; ?></span>
                </div>
                <div class="w-pr-15">
                 <?php echo $Items->vendor_material_item_qty; ?>
                 <?php echo $Items->vendor_material_item_qty_type; ?>
                </div>
                <div class="w-pr-15">
                 Rs.<?php echo $Items->vendor_material_item_net_price; ?>
                </div>
                <div class="w-pr-15 text-right">
                 <a class='btn btn-md btn-default' data-toggle='modal' data-target='#update_material_items_<?php echo $Items->vendor_material_item_id; ?>'><i class='fa fa-edit'></i> Update Bill Details</a>

                </div>
               </div>
               <div class="modal fade square" id="update_material_items_<?php echo $Items->vendor_material_item_id; ?>" role="dialog">
                <div class="modal-dialog modal-lg">
                 <div class="modal-content">
                  <div class="modal-header app-bg text-white">
                   <button type="button" class="close text-white m-r-8 m-t-1" data-dismiss="modal">&times;</button>
                   <h4 class="modal-title text-white">Update Vendor Bill Record</h4>
                  </div>
                  <div class="modal-body overflow-auto">
                   <form action="../../controller/vendorcontroller.php" method="POST" enctype="multipart/form-data">
                    <?php FormPrimaryInputs(true, [
                     "vendor_material_item_id" => $Items->vendor_material_item_id,
                    ]); ?>
                    <div class="row">
                     <div class="form-group col-md-4">
                      <label>Item Name</label>
                      <input type='text' required name='vendor_material_item_name' value='<?php echo $Items->vendor_material_item_name; ?>' class='form-control'>
                     </div>
                     <div class="form-group col-md-4">
                      <label>Serial No</label>
                      <input type='text' required name='vendor_material_item_serial_no' value='<?php echo $Items->vendor_material_item_serial_no; ?>' class='form-control'>
                     </div>
                     <div class="form-group col-md-4">
                      <label>SOS-No</label>
                      <input type='text' name='vendor_material_item_sos_number' value='<?php echo $Items->vendor_material_item_sos_number; ?>' class='form-control'>
                     </div>
                     <div class="form-group col-md-3">
                      <label>Unit Rate</label>
                      <input type='text' id='UnitRate_<?php echo $Items->vendor_material_item_id; ?>' oninput="GeneratePrice_<?php echo $Items->vendor_material_item_id; ?>()" required name='vendor_material_item_unit_rate' value='<?php echo $Items->vendor_material_item_unit_rate; ?>' class='form-control'>
                     </div>
                     <div class="form-group col-md-3">
                      <label>Quantity</label>
                      <input type='number' id='Qty_<?php echo $Items->vendor_material_item_id; ?>' oninput="GeneratePrice_<?php echo $Items->vendor_material_item_id; ?>()" min='1' required name='vendor_material_item_qty' value='<?php echo $Items->vendor_material_item_qty; ?>' class='form-control'>
                     </div>
                     <div class="form-group col-md-3">
                      <label>Qty Type</label>
                      <select name='vendor_material_item_qty_type' class='form-control' required="">
                       <?php echo InputOptions([
                        "" => "Select Qty Type",
                        "Kg" => "Kg",
                        "Litre" => "Litre",
                        "TON" => "TON",
                        "Packet" => "Packet",
                        "Bags" => "Bags",
                        "Pieces" => "Pieces",
                        "Foot" => "Foot",
                        "Meter" => "Meter",
                        "Unit" => "Unit",
                        "Gram" => "Gram",
                        "Container" => "Container"
                       ], $Items->vendor_material_item_qty_type); ?>
                      </select>
                     </div>
                     <div class="form-group col-md-3">
                      <label>Total</label>
                      <input type='number' readonly id='NetPrice_<?php echo $Items->vendor_material_item_id; ?>' min='1' name='vendor_material_item_net_price' value='<?php echo $Items->vendor_material_item_net_price; ?>' class='form-control'>
                     </div>
                    </div>
                    <div class="modal-footer">
                     <?php echo CONFIRM_DELETE_POPUP(
                      "items",
                      [
                       "remove_material_item" => "true",
                       "control_id" => $Items->vendor_material_item_id
                      ],
                      "vendorcontroller",
                      "<i class='fa fa-trash'></i> Remove Permanently",
                      "btn btn-md text-danger pull-left"
                     ); ?>
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                     <button type="submit" name="UpdateMaterialItems" class="btn btn-success">Update Item Details</button>
                    </div>
                   </form>
                  </div>
                 </div>
                </div>
               </div>

               <script>
                function GeneratePrice_<?php echo $Items->vendor_material_item_id; ?>() {
                 var UnitRate_<?php echo $Items->vendor_material_item_id; ?> = parseFloat(document.getElementById("UnitRate_<?php echo $Items->vendor_material_item_id; ?>").value);
                 var Qty_<?php echo $Items->vendor_material_item_id; ?> = parseFloat(document.getElementById("Qty_<?php echo $Items->vendor_material_item_id; ?>").value);
                 document.getElementById("NetPrice_<?php echo $Items->vendor_material_item_id; ?>").value = UnitRate_<?php echo $Items->vendor_material_item_id; ?> * Qty_<?php echo $Items->vendor_material_item_id; ?>;
                }
               </script>
             <?php
              }
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

  <div class="modal fade square" id="update_material_details" role="dialog">
   <div class="modal-dialog modal-lg">
    <div class="modal-content">
     <div class="modal-header app-bg text-white">
      <button type="button" class="close text-white m-r-8 m-t-1" data-dismiss="modal">&times;</button>
      <h4 class="modal-title text-white">Update Vendor Bill Record</h4>
     </div>
     <div class="modal-body overflow-auto">
      <form action="../../controller/vendorcontroller.php" method="POST" enctype="multipart/form-data">
       <?php FormPrimaryInputs(true, [
        "vendor_material_id" => FETCH($MaterialSQL, "vendor_material_id"),
        "vendor_main_id" => $VendorId
       ]); ?>
       <div class="row">
        <div class="col-md-4 form-group">
         <label>Bill Number</label>
         <input type='text' name='vendor_material_bill_no' value='<?php echo FETCH($MaterialSQL, "vendor_material_bill_no"); ?>' class='form-control'>
        </div>
        <div class="col-md-4 form-group">
         <label>Receiving date</label>
         <input type='date' value='<?php echo FETCH($MaterialSQL, "vendor_material_receive_date"); ?>' name='vendor_material_receive_date' class='form-control'>
        </div>
        <div class="col-md-4 form-group">
         <label>Billing Amount</label>
         <input type='text' value='<?php echo FETCH($MaterialSQL, "vendor_material_net_amount"); ?>' name='vendor_material_net_amount' class='form-control'>
        </div>
        <div class="col-md-12 form-group">
         <label>Upload Bill/Material Receipt</label>
         <input type="FILE" value='<?php echo FETCH($MaterialSQL, "vendor_material_uploaded_bill"); ?>' name='vendor_material_uploaded_bill' class="form-control">
        </div>
        <div class="col-md-12 form-group">
         <label>Note/Remarks</label>
         <textarea class="form-control" rows='2' name="vendor_material_remarks"><?php echo SECURE(FETCH($MaterialSQL, "vendor_material_remarks"), "d"); ?></textarea>
        </div>
       </div>
       <div class="modal-footer">
        <?php echo CONFIRM_DELETE_POPUP(
         "materials",
         [
          "remove_vendor_materials" => "true",
          "control_id" => FETCH($MaterialSQL, "vendor_material_id")
         ],
         "vendorcontroller",
         "<i class='fa fa-trash'></i> Remove Permanently",
         "btn btn-md text-danger pull-left"
        ); ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name="UpdateMaterialRecord" class="btn btn-success">Update Material Details</button>
       </div>
      </form>
     </div>
    </div>
   </div>
  </div>

  <script>
   function GeneratePrice() {
    var UnitRate = parseFloat(document.getElementById("UnitRate").value);
    var Qty = parseFloat(document.getElementById("Qty").value);
    document.getElementById("NetPrice").value = UnitRate * Qty;
   }
  </script>
  <!-- end -->
  <?php include '../sidebar.php'; ?>
  <?php include '../footer.php'; ?>
 </div>

 <?php include '../../include/footer_files.php'; ?>
</body>

</html>
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
                      <h3 class="m-t-5 m-b-0"><i class="fa fa-truck app-text"></i> Add New Material Record</h3>
                      <a href="index.php" class="btn btn-md btn-default m-t-10"><i class="fa fa-angle-left"></i> Back to Construction Dashboard</a>
                      <a class='btn btn-md btn-danger m-t-10' data-toggle='modal' data-target='#add_new_vendor'><i class='fa fa-plus'></i> Add New Vendor</a>
                    </div>
                  </div>

                  <div class="row m-t-5">
                    <div class="col-md-4">
                      <h4 class="app-heading"><i class="fa fa-search"></i> Search Existing Vendor</h4>
                      <form>
                        <label>Search Vendor/Person Name</label>
                        <input type='search' onchange='form.submit()' list='vendor_display_name' value="<?php echo IfRequested('GET', 'search_vendor', "", false); ?>" name='search_vendor' class="form-control form-control-lg">
                        <?php echo SUGGEST("vendors", "vendor_display_name", "ASC", null); ?>
                      </form>
                      <?php
                      if (isset($_GET['search_vendor'])) {
                        if ($_GET['search_vendor'] != null) {
                          $search_vendor = $_GET['search_vendor'];
                          $VendorSQL = "SELECT * FROM vendors where vendor_display_name like '%$search_vendor%'";
                          $VendorSQL = FetchConvertIntoArray($VendorSQL, true);
                          if ($VendorSQL != null) {
                            foreach ($VendorSQL as $Vendor) {
                      ?>
                              <div class="shadow-sm p-2 b-r-1 m-b-3">
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
                                <a data-toggle='modal' data-target='#update_vendor_<?php echo $Vendor->vendor_id; ?>' class="btn btn-md btn-default"><i class="fa fa-edit"></i> Edit Details</a>
                                <?php if (isset($_GET['selected'])) {
                                  if ($_GET['selected'] == $Vendor->vendor_id) {
                                    $BtnClass = "btn-danger";
                                    $BtnName = "Selected";
                                  } else {
                                    $BtnClass = "btn-success";
                                    $BtnName = "Select & Continue";
                                  }
                                } else {
                                  $BtnClass = "btn-success";
                                  $BtnName = "Select & Continue";
                                } ?>
                                <a href="?search_vendor=<?php echo IfRequested("GET", "search_vendor", "", false); ?>&selected=<?php echo $Vendor->vendor_id; ?>" class="btn btn-md <?php echo $BtnClass; ?>"><?php echo $BtnName; ?> <i class='fa fa-angle-right'></i></a>
                              </div>

                              <div class="modal fade square" id="update_vendor_<?php echo $Vendor->vendor_id; ?>" role="dialog">
                                <div class="modal-dialog modal-lg">
                                  <div class="modal-content">
                                    <div class="modal-header app-bg text-white">
                                      <button type="button" class="close text-white m-r-8 m-t-1" data-dismiss="modal">&times;</button>
                                      <h4 class="modal-title text-white">Update Vendor Details</h4>
                                    </div>
                                    <div class="modal-body overflow-auto">
                                      <form action="../../controller/vendorcontroller.php" method="POST">
                                        <?php FormPrimaryInputs(true, [
                                          "vendor_id" => $Vendor->vendor_id
                                        ]); ?>
                                        <div class="row">
                                          <div class="from-group col-md-6">
                                            <label>Vendor/Company Name</label>
                                            <input type="text" name="vendor_company_name" value="<?php echo $Vendor->vendor_company_name; ?>" class="form-control" placeholder="" required>
                                          </div>
                                          <div class="from-group col-md-6">
                                            <label>Contact Person Full Name</label>
                                            <input type="text" name="vendor_person_name" value="<?php echo $Vendor->vendor_person_name; ?>" class="form-control" placeholder="" required>
                                          </div>
                                          <div class="from-group col-md-6">
                                            <label>Email</label>
                                            <input type="email" name="vendor_person_email_id" value="<?php echo $Vendor->vendor_person_email_id; ?>" class="form-control" placeholder="">
                                          </div>
                                          <div class="from-group col-md-6">
                                            <label>Phone Number</label>
                                            <input type="text" name="vendor_person_phone" value="<?php echo $Vendor->vendor_person_phone; ?>" class="form-control" placeholder="" required>
                                          </div>
                                          <div class="form-group col-md-6">
                                            <label>Specialised In/Supplier Of</label>
                                            <input type="text" name="vendor_highlight_details" value="<?php echo $Vendor->vendor_highlight_details; ?>" class="form-control" placeholder="">
                                          </div>
                                          <div class="from-group col-md-12">
                                            <label>Address</label>
                                            <input type="text" name="vendor_person_street_address" value="<?php echo $Vendor->vendor_person_street_address; ?>" class="form-control" placeholder="">
                                          </div>
                                          <div class="from-group col-md-6">
                                            <label>Area Locality</label>
                                            <input type="text" name="vendor_person_area_locality" value="<?php echo $Vendor->vendor_person_area_locality; ?>" class="form-control" placeholder="">
                                          </div>
                                          <div class="from-group col-md-6">
                                            <label>City</label>
                                            <input type="text" name="vendor_person_city" value="<?php echo $Vendor->vendor_person_city; ?>" class="form-control" placeholder="">
                                          </div>
                                          <div class="from-group col-md-6">
                                            <label>State</label>
                                            <select name='vendor_person_state' class="form-control">
                                              <?php echo InputOptions(STATES, $Vendor->vendor_person_state); ?>
                                            </select>
                                          </div>
                                          <div class="from-group col-md-6">
                                            <label>Pincode</label>
                                            <input type="text" name="vendor_person_pincode" value="<?php echo $Vendor->vendor_person_pincode; ?>" class="form-control" placeholder="">
                                          </div>
                                          <div class="from-group col-md-6">
                                            <label>GST No</label>
                                            <input type="text" name="vendor_gst_no" value="<?php echo $Vendor->vendor_gst_no; ?>" class="form-control" placeholder="">
                                          </div>
                                          <div class="from-group col-md-6">
                                            <label>User Status</label>
                                            <select name="vendor_status" class="form-control" required="">
                                              <?php echo InputOptions([
                                                "1" => "Active",
                                                "2" => "Inactive",
                                              ], $Vendor->vendor_status) ?>
                                            </select>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      <button type="submit" name="UpdateVendorDetails" class="btn btn-success">Update Vendor Details</button>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                      <?php
                            }
                          } else {
                            echo "<div class='alert alert-info'>No matching vendor found.</div>";
                            echo "<a class='btn btn-md btn-danger' data-toggle='modal' data-target='#add_new_vendor'><i class='fa fa-plus'></i> Add New Vendor</a>";
                          }
                        } else {
                          echo "<div class='alert alert-info'>Please search vendor for material entry.</div>";
                        }
                      } else {
                        echo "<div class='alert alert-info'>Please search vendor for material entry.</div>";
                      }
                      ?>
                    </div>
                    <div class="col-md-8">
                      <?php if (isset($_GET['selected'])) {
                        if ($_GET['selected'] != null || $_GET['selected'] != "") { ?>
                          <h4 class="app-heading"><i class="fa fa-plus"></i> Add New Material Entry</h4>
                          <form class='row' action="../../controller/vendorcontroller.php" method="POST" enctype="multipart/form-data">
                            <?php echo FormPrimaryInputs(true, [
                              "vendor_id" => IfRequested("GET", "selected", "0", false)
                            ]); ?>
                            <div class="col-md-4 form-group">
                              <label>Bill Number</label>
                              <input type='text' name='vendor_material_bill_no' class='form-control'>
                            </div>
                            <div class="col-md-4 form-group">
                              <label>Receiving date</label>
                              <input type='date' value='<?php echo date("Y-m-d"); ?>' name='vendor_material_receive_date' class='form-control'>
                            </div>
                            <div class="col-md-4 form-group">
                              <label>Billing Amount</label>
                              <input type='number' required name='vendor_material_net_amount' class='form-control'>
                            </div>
                            <div class="col-md-12 form-group">
                              <label>Upload Bill/Material Receipt</label>
                              <input type="FILE" required name='vendor_material_uploaded_bill' class="form-control">
                            </div>
                            <div class="col-md-12 form-group">
                              <label>Note/Remarks</label>
                              <textarea class="form-control" rows='2' name="vendor_material_remarks" id="vendor_material_remarks"></textarea>
                              <div class='flex-end p-1 p-t-5'>
                                <input type='checkbox' id='EnablePayment' name='PaymentDetails' value='true'>
                                <span>Add Payment Details for previous or current items</span>
                              </div>
                              <div id='PayDetails' style='display:none;' class="shadow-sm p-1 b-r-1">
                                <?php
                                $VendorId = IfRequested("GET", "selected", "0", false);
                                $TotalPayable = AMOUNT("SELECT vendor_material_item_net_price from vendor_materials, vendor_material_items where vendor_materials.vendor_main_id='$VendorId' and vendor_materials.vendor_material_id=vendor_material_items.vendor_material_main_id", "vendor_material_item_net_price");
                                $TotalPaid = AMOUNT("SELECT vendor_paid_amount FROM vendor_transactions where vendor_main_id='$VendorId'", "vendor_paid_amount");
                                $Balance = $TotalPayable - $TotalPaid; ?>
                                <div class="row">
                                  <div class="col-md-12">
                                    <h4 class='app-sub-heading'>Enter Payment Details</h4>
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label>Previous Unpaid Amount</label>
                                    <input readonly type='text' id='PayableAmount' value='<?php echo $Balance; ?>' class="form-control">
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label>Current Paid Amount</label>
                                    <input type='text' id='PayingAmount' oninput="GetBalance()" name='vendor_paid_amount' class="form-control">
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label>Balance</label>
                                    <input readonly type='text' id='BalanceAmount' class="form-control">
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label>Payment Mode</label>
                                    <select name='vendor_pay_mode' class="form-control">
                                      <?php echo InputOptions([
                                        "" => "Select Pay Mode",
                                        "Cash" => "Cash",
                                        "Online" => "Online",
                                        "NetBanking" => "NetBanking",
                                        "Cheque_DD" => "Cheque/DD",
                                        "UPI_APP" => "Phonepay/Googlepay/UPI"
                                      ], ""); ?>
                                    </select>
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label>Payment Ref no</label>
                                    <input type='text' name='vendor_pay_ref_no' class="form-control">
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label>Payment Date</label>
                                    <input type='date' name='vendor_payment_date' class="form-control" value='<?php echo date("Y-m-d"); ?>'>
                                  </div>
                                  <div class="form-group col-md-12">
                                    <label>Payment More Details & remarks</label>
                                    <textarea name='vendor_payment_details' class="form-control" rows='3'></textarea>
                                  </div>
                                  <div class="form-group col-md-12">
                                    <label>Upload Receipt</label>
                                    <input type='FILE' name='vendor_payment_have_receipt' class="form-control">
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-12 text-right">
                              <hr>
                              <button type="reset" class="btn btn-lg btn-default">RESET</button>
                              <button type="submit" name="AddVendorMaterialEntry" class="btn btn-lg btn-success">Add Material Entry </button>
                            </div>
                          </form>
                      <?php } else {
                          echo "<div class='alert alert-warning'>Please select a vendor for material entry.</div>";
                        }
                      } else {
                        echo "<div class='alert alert-warning'>Please select a vendor for material entry.</div>";
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

    <div class="modal fade square" id="add_new_vendor" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header app-bg text-white">
            <button type="button" class="close text-white m-r-8 m-t-1" data-dismiss="modal">&times;</button>
            <h4 class="modal-title text-white">Add New Vendor</h4>
          </div>
          <div class="modal-body overflow-auto">
            <form action="../../controller/vendorcontroller.php" method="POST">
              <?php FormPrimaryInputs(true); ?>
              <div class="row">
                <div class="from-group col-md-6">
                  <label>Vendor/Company Name</label>
                  <input type="text" name="vendor_company_name" value="" class="form-control" placeholder="" required>
                </div>
                <div class="from-group col-md-6">
                  <label>Contact Person Full Name</label>
                  <input type="text" name="vendor_person_name" value="" class="form-control" placeholder="" required>
                </div>
                <div class="from-group col-md-6">
                  <label>Email</label>
                  <input type="email" name="vendor_person_email_id" value="" class="form-control" placeholder="">
                </div>
                <div class="from-group col-md-6">
                  <label>Phone Number</label>
                  <input type="text" name="vendor_person_phone" value="" class="form-control" placeholder="" required>
                </div>
                <div class="form-group col-md-6">
                  <label>Specialised In/Supplier Of</label>
                  <input type="text" name="vendor_highlight_details" value="" class="form-control" placeholder="">
                </div>
                <div class="from-group col-md-12">
                  <label>Address</label>
                  <input type="text" name="vendor_person_street_address" value="" class="form-control" placeholder="">
                </div>
                <div class="from-group col-md-6">
                  <label>Area Locality</label>
                  <input type="text" name="vendor_person_area_locality" value="" class="form-control" placeholder="">
                </div>
                <div class="from-group col-md-6">
                  <label>City</label>
                  <input type="text" name="vendor_person_city" value="" class="form-control" placeholder="">
                </div>
                <div class="from-group col-md-6">
                  <label>State</label>
                  <select name='vendor_person_state' class="form-control">
                    <?php echo InputOptions(STATES, ""); ?>
                  </select>
                </div>
                <div class="from-group col-md-6">
                  <label>Pincode</label>
                  <input type="text" name="vendor_person_pincode" value="" class="form-control" placeholder="">
                </div>
                <div class="from-group col-md-6">
                  <label>GST No</label>
                  <input type="text" name="vendor_gst_no" value="" class="form-control" placeholder="">
                </div>
                <div class="from-group col-md-6">
                  <label>User Status</label>
                  <select name="vendor_status" class="form-control" required="">
                    <option value="1" selected="">ACTIVE</option>
                    <option value="2">INACTIVE</option>
                  </select>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" name="SaveNewVendor" class="btn btn-success">Save Vendor Details</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script>
      document.getElementById('EnablePayment').addEventListener('change', function() {
        var paymentDetailsDiv = document.getElementById('PayDetails');
        if (this.checked) {
          paymentDetailsDiv.style.display = 'block'; // Show the div
        } else {
          paymentDetailsDiv.style.display = 'none'; // Hide the div
        }
      });

      function GetPrice() {
        var Qty = document.getElementById("Qty").value;
        var Rate = document.getElementById("Rate").value;
        var TotalPrice = Qty * Rate;
        document.getElementById("TotalCost").value = TotalPrice;
      }

      function GetBalance() {
        var PayableAmount = document.getElementById("PayableAmount").value;
        var PayingAmount = document.getElementById("PayingAmount").value;
        var Balance = PayableAmount - PayingAmount;
        document.getElementById("BalanceAmount").value = Balance;
      }
    </script>

    <!-- end -->
    <?php include '../sidebar.php'; ?>
    <?php include '../footer.php'; ?>
  </div>

  <?php include '../../include/footer_files.php'; ?>
</body>

</html>
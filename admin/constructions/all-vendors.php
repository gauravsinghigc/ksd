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
                      <h3 class="m-t-5 m-b-0"><i class="fa fa-truck app-text"></i> All Vendors</h3>
                      <a href="index.php" class="btn btn-md btn-default m-t-10"><i class="fa fa-angle-left"></i> Back to Construction Dashboard</a>
                      <a class='btn btn-md btn-danger m-t-10' data-toggle='modal' data-target='#add_new_vendor'><i class='fa fa-plus'></i> Add New Vendor</a>
                    </div>
                  </div>

                  <div class="row m-t-5">
                    <div class="col-md-12">
                      <h4 class="app-heading"><i class="fa fa-list"></i> All Vendor</h4>
                      <form>
                        <label>Search Vendor/Person Name</label>
                        <input type='search' onchange='form.submit()' list='vendor_display_name' value="<?php echo IfRequested('GET', 'search_vendor', "", false); ?>" name='search_vendor' class="form-control form-control-lg">
                        <?php echo SUGGEST("vendors", "vendor_display_name", "ASC", null); ?>
                      </form>
                      <div class="data-list flex-s-b bg-dark">
                        <div class='w-pr-5'>
                          <span class='text-white'>Sno</span>
                        </div>
                        <div class='w-pr-20'>
                          <span class='text-white'>VendorName</span>
                        </div>
                        <div class='w-pr-15'>
                          <span class='text-white'>PersonName</span>
                        </div>
                        <div class='w-pr-10'>
                          <span class='text-white'>Phone</span>
                        </div>
                        <div class='w-pr-20'>
                          <span class='text-white'>EmailId</span>
                        </div>
                        <div class='w-pr-20'>
                          <span class='text-white'>ProviderOf</span>
                        </div>
                        <div class='w-pr-15'>
                          <span class='text-white'>Area/City</span>
                        </div>
                        <div class='w-pr-10'>
                          <span class='text-white'>AddedAt</span>
                        </div>
                        <div class='w-pr-10'>
                          <span class='text-white'>NetPayable</span>
                        </div>
                        <div class='w-pr-10'>
                          <span class='text-white'>Paid</span>
                        </div>
                        <div class='w-pr-10'>
                          <span class='text-white'>Balance</span>
                        </div>
                        <div class='w-pr-10 text-right'>
                          <span class='text-white'>Action</span>
                        </div>
                      </div>
                      <?php
                      $VendorSQL = "SELECT * FROM vendors";
                      $VendorSQL = FetchConvertIntoArray($VendorSQL, true);
                      if ($VendorSQL != null) {
                        $SerialNo = 0;
                        foreach ($VendorSQL as $Vendor) {
                          $SerialNo++;
                          $VendorId = $Vendor->vendor_id;
                          $TotalPayable = AMOUNT("SELECT vendor_material_net_amount from vendor_materials where vendor_main_id='$VendorId'", "vendor_material_net_amount");
                          $TotalPaid = AMOUNT("SELECT vendor_paid_amount FROM vendor_transactions where vendor_main_id='$VendorId'", "vendor_paid_amount");
                          $Balance = $TotalPayable - $TotalPaid;

                      ?>
                          <div class="data-list flex-s-b">
                            <div class='w-pr-5'>
                              <span><?php echo $SerialNo; ?></span>
                            </div>
                            <div class='w-pr-20'>
                              <a href="vendor-details.php?vendorid=<?php echo $Vendor->vendor_id; ?>" class="text-primary bold link">
                                <?php echo $Vendor->vendor_company_name; ?>
                              </a>
                            </div>
                            <div class='w-pr-15'>
                              <span><?php echo $Vendor->vendor_person_name; ?></span>
                            </div>
                            <div class='w-pr-10'>
                              <span><?php echo $Vendor->vendor_person_phone; ?></span>
                            </div>
                            <div class='w-pr-20'>
                              <span><?php echo $Vendor->vendor_person_email_id; ?></span>
                            </div>
                            <div class='w-pr-20'>
                              <span><?php echo $Vendor->vendor_highlight_details; ?></span>
                            </div>
                            <div class='w-pr-15'>
                              <span>
                                <?php echo $Vendor->vendor_person_area_locality; ?>,
                                <?php echo $Vendor->vendor_person_city; ?>
                              </span>
                            </div>
                            <div class='w-pr-10'>
                              <span><?php echo DATE_FORMATE2("d M, Y", $Vendor->vendor_created_at); ?></span>
                            </div>
                            <div class='w-pr-10'>
                              <span><?php echo Price($TotalPayable, "text-primary", "Rs."); ?></span>
                            </div>
                            <div class='w-pr-10'>
                              <span><?php echo Price($TotalPaid, "text-success", "Rs."); ?></span>
                            </div>
                            <div class='w-pr-10'>
                              <span><?php echo Price($Balance, "text-danger", "Rs."); ?></span>
                            </div>
                            <div class='w-pr-10 text-right'>
                              <a data-toggle='modal' data-target='#update_vendor_<?php echo $Vendor->vendor_id; ?>' class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit Details</a>
                            </div>
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
                        echo "<div class='alert alert-info'>No vendor found.</div>";
                        echo "<a class='btn btn-md btn-danger' data-toggle='modal' data-target='#add_new_vendor'><i class='fa fa-plus'></i> Add New Vendor</a>";
                      }
                      ?>
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
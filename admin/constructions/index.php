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
                      <div class="flex-s-b">
                        <h3 class="m-t-5 m-b-0"><i class="fa fa-truck app-text"></i> Constructions Materials</h3>
                        <div class="btn-group btn-group-lg">
                          <a href="all-vendors.php" class="btn btn-ld btn-default m-r-4">All Vendors</a>
                          <a href="all-materials.php" class="btn btn-ld btn-default m-r-4">All Materials</a>
                          <a href="add-record.php" class="btn btn-ld btn-danger">Add New Record</a>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row m-t-10">
                    <div class="col-lg-2 col-md-3 col-sm-6 col-12">
                      <a href="">
                        <div class="shadow-sm p-2r">
                          <h2 class='m-b-0 m-t-0'>
                            <?php echo TOTAL("SELECT vendor_material_id FROM vendor_materials"); ?>
                          </h2>
                          <p>
                            <span class="text-grey">Total Material Entries</span><br>
                          </p>
                        </div>
                      </a>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-6 col-12">
                      <a href="">
                        <div class="shadow-sm p-2r">
                          <h2 class='m-b-0 m-t-0'>
                            <?php echo TOTAL("SELECT vendor_material_id FROM vendor_materials where DATE(vendor_material_receive_date)='" . DATE('Y-m-d') . "'"); ?>
                          </h2>
                          <p>
                            <span class="text-grey">Today Material Entries</span><br>
                          </p>
                        </div>
                      </a>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-6 col-12">
                      <a href="">
                        <div class="shadow-sm p-2r">
                          <?php
                          $TotalPayable = AMOUNT("SELECT vendor_material_net_amount from vendor_materials", "vendor_material_net_amount");
                          $TotalPaid = AMOUNT("SELECT vendor_paid_amount FROM vendor_transactions", "vendor_paid_amount");
                          $Balance = $TotalPayable - $TotalPaid;
                          ?>
                          <h2 class='m-b-0 m-t-0'>
                            <span class="text-grey small">Rs.</span>
                            <?php echo Price($TotalPayable, "text-primary", ""); ?>
                          </h2>
                          <p>
                            <span class="text-grey">Net Payable</span><br>
                          </p>
                        </div>
                      </a>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-6 col-12">
                      <a href="">
                        <div class="shadow-sm p-2r">
                          <h2 class='m-b-0 m-t-0'>
                            <span class="text-grey small">Rs.</span>
                            <?php echo Price($TotalPaid, "text-success", ""); ?>
                          </h2>
                          <p>
                            <span class="text-grey">Amount Paid</span><br>
                          </p>
                        </div>
                      </a>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-6 col-12">
                      <a href="">
                        <div class="shadow-sm p-2r">
                          <h2 class='m-b-0 m-t-0'>
                            <span class="text-grey small">Rs.</span>
                            <?php echo Price($Balance, "text-danger", ""); ?>
                          </h2>
                          <p>
                            <span class="text-grey">Balance</span><br>
                          </p>
                        </div>
                      </a>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-6 col-12">
                      <a href="">
                        <div class="shadow-sm p-2r">
                          <h2 class='m-b-0 m-t-0'>
                            <span class="text-grey small">Rs.</span>
                            <?php echo AMOUNT("SELECT vendor_material_net_amount from vendor_materials where DATE(vendor_material_receive_date)='" . DATE('Y-m-d') . "'", "vendor_material_net_amount"); ?>
                          </h2>
                          <p>
                            <span class="text-grey">Today Bill Amount</span><br>
                          </p>
                        </div>
                      </a>
                    </div>
                  </div>

                  <div class="row m-t-10">
                    <div class="col-md-8">
                      <h4 class="app-heading"><i class='fa fa-exchange'></i> All Material Entries</h4>
                      <div class="data-list flex-s-b bg-dark text-white">
                        <div class="w-pr-5">
                          <span class='text-white'>Sno</span>
                        </div>
                        <div class="w-pr-10">
                          <span class='text-white'>Receipt</span>
                        </div>
                        <div class="w-pr-15">
                          <span class='text-white'>BillNo</span>
                        </div>
                        <div class="w-pr-25">
                          <span class='text-white'>VendorDetails</span>
                        </div>
                        <div class="w-pr-10">
                          <span class='text-white'>ItemCount</span>
                        </div>
                        <div class="w-pr-10">
                          <span class='text-white'>BillDate</span>
                        </div>
                        <div class="w-pr-10">
                          <span class='text-white'>AddDate</span>
                        </div>
                        <div class="w-pr-10">
                          <span class='text-white'>BillAmount</span>
                        </div>
                        <div class="w-pr-10 text-right">
                          <span class="text-white">Action</span>
                        </div>
                      </div>
                      <?php
                      $AllMaterialSQL = FetchConvertIntoArray("SELECT * FROM vendor_materials ORDER BY DATE(vendor_material_receive_date) DESC limit 0,25", true);
                      if ($AllMaterialSQL != null) {
                        $SerialNo = 0;
                        foreach ($AllMaterialSQL as $Material) {
                          $SerialNo++;
                          $VendorId = $Material->vendor_main_id;
                          $VendorSQL = "SELECT * FROM vendors where vendor_id='$VendorId'";
                      ?>
                          <div class="data-list flex-s-b">
                            <div class="w-pr-5">
                              <span><?php echo $SerialNo; ?></span>
                            </div>
                            <div class="w-pr-10">
                              <a target="_blank" href="<?php echo STORAGE_URL; ?>/vendor/material/<?php echo $VendorId; ?>/<?php echo $Material->vendor_material_uploaded_bill; ?>" class="bold text-primary link">
                                <i class="fa fa-file-pdf-o text-danger"></i> Receipt
                              </a>
                            </div>
                            <div class="w-pr-15">
                              <a href="material-details.php?matid=<?php echo $Material->vendor_material_id; ?>" class="bold text-primary link">
                                <?php echo $Material->vendor_material_bill_no; ?>
                              </a>
                            </div>
                            <div class="w-pr-25">
                              <a href="<?php echo ADMIN_URL; ?>/constructions/vendor-details.php?vendorid=<?php echo $VendorId; ?>" class="text-primary link bold"><?php echo FETCH($VendorSQL, "vendor_display_name"); ?></a>
                            </div>
                            <div class="w-pr-10">
                              <span>
                                <?php echo TOTAL("SELECT vendor_material_main_id FROM vendor_material_items where vendor_material_main_id='" . $Material->vendor_material_id . "'"); ?>
                                <span class="text-grey">Items</span>
                              </span>
                            </div>
                            <div class="w-pr-10">
                              <span><?php echo DATE_FORMATE2("d M, Y", $Material->vendor_material_receive_date); ?></span>
                            </div>
                            <div class="w-pr-10">
                              <span><?php echo DATE_FORMATE2("d M, Y", $Material->vendor_material_created_at); ?></span>
                            </div>
                            <div class="w-pr-10">
                              <span>
                                <?php
                                $BillingAmount = AMOUNT("SELECT vendor_material_net_amount from vendor_materials where vendor_materials.vendor_main_id='" . $Material->vendor_main_id . "'", "vendor_material_net_amount");
                                echo Price($Material->vendor_material_net_amount, "text-primary", "Rs."); ?>
                              </span>
                            </div>
                            <div class="w-pr-10 text-right">
                              <a data-toggle='modal' data-target='#update_material_<?php echo $Material->vendor_material_id; ?>' class="text-primary"><i class="fa fa-edit"></i> Edit Details</a>
                            </div>
                          </div>
                          <div class="modal fade square" id="update_material_<?php echo $Material->vendor_material_id; ?>" role="dialog">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header app-bg text-white">
                                  <button type="button" class="close text-white m-r-8 m-t-1" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title text-white">Add New Vendor</h4>
                                </div>
                                <div class="modal-body overflow-auto">
                                  <form action="../../controller/vendorcontroller.php" method="POST" enctype="multipart/form-data">
                                    <?php FormPrimaryInputs(true, [
                                      "vendor_material_id" => $Material->vendor_material_id,
                                      "vendor_main_id" => $Material->vendor_main_id
                                    ]); ?>
                                    <div class="row">
                                      <div class="col-md-4 form-group">
                                        <label>Bill Number</label>
                                        <input type='text' name='vendor_material_bill_no' value='<?php echo $Material->vendor_material_bill_no; ?>' class='form-control'>
                                      </div>
                                      <div class="col-md-4 form-group">
                                        <label>Receiving date</label>
                                        <input type='date' value='<?php echo $Material->vendor_material_receive_date; ?>' name='vendor_material_receive_date' class='form-control'>
                                      </div>
                                      <div class="col-md-4 form-group">
                                        <label>Billing Amount</label>
                                        <input type='text' value='<?php echo $Material->vendor_material_net_amount; ?>' name='vendor_material_net_amount' class='form-control'>
                                      </div>
                                      <div class="col-md-12 form-group">
                                        <label>Upload Bill/Material Receipt</label>
                                        <input type="FILE" value='<?php echo $Material->vendor_material_uploaded_bill; ?>' name='vendor_material_uploaded_bill' class="form-control">
                                      </div>
                                      <div class="col-md-12 form-group">
                                        <label>Note/Remarks</label>
                                        <textarea class="form-control" rows='2' name="vendor_material_remarks"><?php echo SECURE($Material->vendor_material_remarks, "d"); ?></textarea>
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                      <?php echo CONFIRM_DELETE_POPUP(
                                        "materials",
                                        [
                                          "remove_vendor_materials" => "true",
                                          "control_id" => $Material->vendor_material_id
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
                      <?php
                        }
                      } else {
                        echo NoData("No Material Entry Found!");
                      } ?>
                    </div>
                    <div class="col-md-4">
                      <h4 class="app-heading"><i class='fa fa-truck'></i> Recently Added Vendors</h4>
                      <?php
                      $VendorSQL = "SELECT * FROM vendors ORDER BY vendor_id DESC limit 0, 10";
                      $VendorSQL = FetchConvertIntoArray($VendorSQL, true);
                      if ($VendorSQL != null) {
                        foreach ($VendorSQL as $Vendor) {
                          $VendorId = $Vendor->vendor_id;
                          $TotalPayable = AMOUNT("SELECT vendor_material_net_amount from vendor_materials where vendor_materials.vendor_main_id='$VendorId'", "vendor_material_net_amount");
                          $TotalPaid = AMOUNT("SELECT vendor_paid_amount FROM vendor_transactions where vendor_main_id='$VendorId'", "vendor_paid_amount");
                          $Balance = $TotalPayable - $TotalPaid;
                      ?>
                          <a href="<?php echo ADMIN_URL; ?>/constructions/vendor-details.php?vendorid=<?php echo $VendorId; ?>" class="shadow-sm p-2 b-r-1 m-b-3" style="display:block;">
                            <div class="flex-s-b">
                              <div class="w-50">
                                <h4 class="bold m-b-2 m-t-0 small"><?php echo $Vendor->vendor_company_name; ?></h4>
                                <h4 class="text-grey small italic m-b-0 m-t-0 small"><?php echo $Vendor->vendor_highlight_details; ?></h4>
                                <p class="small fs-13">
                                  <span><i class="fa fa-user"></i> <?php echo $Vendor->vendor_person_name; ?></span><br>
                                  <span><i class="fa fa-info-circle"></i> <?php echo $Vendor->vendor_person_phone; ?>, </span>
                                  <br>
                                  <span><?php echo $Vendor->vendor_person_email_id; ?></span>
                                </p>
                              </div>
                              <div class="w-100">
                                <p class="flex-s-b shadow-sm p-2 m-t-20 line-height-normal small p-t-12">
                                  <span>
                                    <span class="small text-grey italic">Net Payable</span><br>
                                    <span class="text-primary"><?php echo Price($TotalPayable, "", "Rs."); ?></span>
                                  </span>
                                  <span>
                                    <span class="small text-grey italic">Paid</span><br>
                                    <span class="text-success"><?php echo Price($TotalPaid, "", "Rs."); ?></span>
                                  </span>
                                  <span>
                                    <span class="small text-grey italic">Balance</span><br>
                                    <span class="text-danger"><?php echo Price($Balance, "", "Rs."); ?></span>
                                  </span>
                                </p>
                              </div>
                            </div>
                          </a>
                      <?php
                        }
                      } else {
                        echo "<div class='alert alert-info'>No vendor found.</div>";
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


    <!-- end -->
    <?php include '../sidebar.php'; ?>
    <?php include '../footer.php'; ?>
  </div>

  <?php include '../../include/footer_files.php'; ?>
</body>

</html>
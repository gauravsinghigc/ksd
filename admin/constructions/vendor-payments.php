<?php

use Random\Engine\Secure;

require '../../require/modules.php';
require '../../require/admin/sessionvariables.php';
require "../../include/admin/common.php";

if (isset($_GET['vendorid'])) {
  $vendorid = $_GET['vendorid'];
  $_SESSION['VENDOR_ID'] = $vendorid;
} else {
  if (isset($_SESSION['VENDOR_ID'])) {
    $vendorid = $_SESSION['VENDOR_ID'];
  } else {
    $vendorid = "";
  }
}

if (isset($_GET['selected'])) {
  $vendorid = $_GET['selected'];
  $_SESSION['VENDOR_ID'] = $vendorid;
} else {
  if (isset($_SESSION['VENDOR_ID'])) {
    $vendorid = $_SESSION['VENDOR_ID'];
  } else {
    $vendorid = "";
  }
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
                      <h3 class="m-t-5 m-b-0"><i class="fa fa-truck app-text"></i> Vendor Payments </h3>
                      <a href="index.php" class="btn btn-md btn-default m-t-10"><i class="fa fa-angle-left"></i> Back to Dashboard</a>
                      <a href="all-vendors.php" class="btn btn-md btn-default m-t-10"><i class="fa fa-angle-left"></i> Back to All Vendors</a>
                      <a href="vendor-details.php" class="btn btn-md btn-info m-t-10"><i class="fa fa-file-pdf-o"></i> View Bills & Materials</a>
                      <a class='btn btn-md btn-primary m-t-10' data-toggle='modal' data-target='#add_payment_record'><i class='fa fa-plus'></i> Add Payment Record</a>
                    </div>
                  </div>

                  <div class="row m-t-5">
                    <div class="col-md-3">
                      <h4 class="app-heading"> Vendor Details</h4>
                      <?php
                      if (isset($_GET['search_vendor'])) {
                        if ($_GET['search_vendor'] != null) {
                          $search_vendor = $_GET['search_vendor'];
                          $VendorSQL = "SELECT * FROM vendors where vendor_display_name like '%$search_vendor%'";
                        } else {
                          $VendorSQL = "SELECT * FROM vendors where vendor_id='$vendorid'";
                        }
                      } else {
                        $VendorSQL = "SELECT * FROM vendors where vendor_id='$vendorid'";
                      }
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
                            <a data-toggle='modal' data-target='#update_vendor_<?php echo $Vendor->vendor_id; ?>' class="btn btn-md btn-default"><i class="fa fa-edit"></i> Update Details</a>
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
                      ?>
                    </div>
                    <div class="col-md-9">
                      <h4 class="font-bold app-heading">Vendor Payments Details</h4>
                      <?php
                      $VendorId = $vendorid; ?>
                      <div class="row m-t-10">
                        <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                          <a href="">
                            <div class="shadow-sm p-2r">
                              <?php
                              $TotalPayable = AMOUNT("SELECT vendor_material_item_net_price from vendor_materials, vendor_material_items where vendor_materials.vendor_main_id='$VendorId' and vendor_materials.vendor_material_id=vendor_material_items.vendor_material_main_id", "vendor_material_item_net_price");
                              $TotalPaid = AMOUNT("SELECT vendor_paid_amount FROM vendor_transactions where vendor_main_id='$VendorId'", "vendor_paid_amount");
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
                        <div class="col-lg-3 col-md-3 col-sm-6 col-12">
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
                        <div class="col-lg-3 col-md-3 col-sm-6 col-12">
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
                        <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                          <a href="">
                            <div class="shadow-sm p-2r">
                              <h2 class='m-b-0 m-t-0'>
                                <span class="text-grey small">Rs.</span>
                                <?php echo Price(AMOUNT("SELECT vendor_material_item_net_price from vendor_materials, vendor_material_items where vendor_main_id='$VendorId' and vendor_materials.vendor_material_id=vendor_material_items.vendor_material_main_id and DATE(vendor_material_receive_date)='" . DATE('Y-m-d') . "'", "vendor_material_item_net_price"), "text-primary", ""); ?>
                              </h2>
                              <p>
                                <span class="text-grey">Today Bill Amount</span><br>
                              </p>
                            </div>
                          </a>
                        </div>
                      </div>

                      <div class="row m-t-10">
                        <div class="col-md-12">
                          <h4 class='app-sub-heading'>All Transactions</h4>
                          <div class="data-list flex-s-b bg-dark text-white">
                            <div class="w-pr-5">
                              <span class='text-white'>Sno</span>
                            </div>
                            <div class="w-pr-20">
                              <span class='text-white'>PaidAt</span>
                            </div>
                            <div class="w-pr-15">
                              <span class='text-white'>PayMode</span>
                            </div>
                            <div class="w-pr-15">
                              <span class='text-white'>ReferenceNo</span>
                            </div>
                            <div class="w-pr-20">
                              <span class='text-white'>AddedAt</span>
                            </div>
                            <div class="w-pr-20">
                              <span class='text-white'>PaidAmount</span>
                            </div>
                            <div class="w-pr-15">
                              <span class='text-white'>Receipt</span>
                            </div>
                            <div class="w-pr-15">
                              <span class='text-white'>Action</span>
                            </div>
                          </div>
                          <?php
                          $AllTransactions = FetchConvertIntoArray("SELECT * FROM vendor_transactions where vendor_main_id='$VendorId' ORDER BY DATE(vendor_payment_date)", true);
                          if ($AllTransactions != null) {
                            $SerialNo = 0;
                            foreach ($AllTransactions as $Transactions) {
                              $SerialNo++;
                          ?>
                              <div class="data-list flex-s-b">
                                <div class="w-pr-5">
                                  <span><?php echo $SerialNo; ?></span>
                                </div>
                                <div class="w-pr-20">
                                  <a href="" class="bold text-primary link">
                                    <?php echo DATE_FORMATE2("d M, Y", $Transactions->vendor_payment_date); ?>
                                  </a>
                                </div>
                                <div class="w-pr-15">
                                  <span><?php echo $Transactions->vendor_pay_mode; ?></span>
                                </div>
                                <div class="w-pr-15">
                                  <span><?php echo $Transactions->vendor_pay_ref_no; ?></span>
                                </div>
                                <div class="w-pr-20">
                                  <span><?php echo DATE_FORMATE2("d M, Y", $Transactions->vendor_payment_created_at); ?></span>
                                </div>
                                <div class="w-pr-20">
                                  <span><?php echo Price($Transactions->vendor_paid_amount, "text-success bold", "Rs."); ?></span>
                                </div>
                                <div class="w-pr-15">
                                  <?php if ($Transactions->vendor_payment_have_receipt != null) { ?>
                                    <a target="_blank" href="<?php echo STORAGE_URL; ?>/vendor/payments/<?php echo $VendorId; ?>/<?php echo $Transactions->vendor_payment_have_receipt; ?>" class="bold text-primary link">
                                      <i class="fa fa-file-pdf-o text-danger"></i> Receipt
                                    </a>
                                  <?php } else { ?>
                                    <span class='text-danger'>No File</span>
                                  <?php } ?>
                                </div>
                                <div class="w-pr-15">
                                  <a data-toggle='modal' data-target='#update_vendor_payment_<?php echo $Transactions->vendor_transactions_id; ?>' class="text-primary"><i class="fa fa-edit"></i> Edit Details</a>
                                </div>
                              </div>
                              <div class="modal fade square" id="update_vendor_payment_<?php echo $Transactions->vendor_transactions_id; ?>" role="dialog">
                                <div class="modal-dialog modal-lg">
                                  <div class="modal-content">
                                    <div class="modal-header app-bg text-white">
                                      <button type="button" class="close text-white m-r-8 m-t-1" data-dismiss="modal">&times;</button>
                                      <h4 class="modal-title text-white">Update Payment Record</h4>
                                    </div>
                                    <div class="modal-body overflow-auto">
                                      <form action="../../controller/vendorcontroller.php" method="POST" enctype="multipart/form-data">
                                        <?php FormPrimaryInputs(true, [
                                          "vendor_transactions_id" => $Transactions->vendor_transactions_id,
                                          "vendor_main_id" => $vendorid
                                        ]); ?>
                                        <?php
                                        $VendorId = $vendorid;
                                        $TotalPayable = AMOUNT("SELECT vendor_material_item_net_price from vendor_materials, vendor_material_items where vendor_materials.vendor_main_id='$VendorId' and vendor_materials.vendor_material_id=vendor_material_items.vendor_material_main_id", "vendor_material_item_net_price");
                                        $TotalPaid = AMOUNT("SELECT vendor_paid_amount FROM vendor_transactions where vendor_main_id='$VendorId'", "vendor_paid_amount");
                                        $Balance = $TotalPayable - $TotalPaid; ?>
                                        <div class="row">
                                          <div class="col-md-12">
                                            <h4 class='app-sub-heading'>Enter Payment Details</h4>
                                          </div>
                                          <div class="form-group col-md-4">
                                            <label>Paid Amount</label>
                                            <input type='text' name='vendor_paid_amount' value='<?php echo $Transactions->vendor_paid_amount; ?>' class="form-control">
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
                                              ], $Transactions->vendor_pay_mode); ?>
                                            </select>
                                          </div>
                                          <div class="form-group col-md-4">
                                            <label>Payment Ref no</label>
                                            <input type='text' name='vendor_pay_ref_no' value='<?php echo $Transactions->vendor_pay_ref_no; ?>' class="form-control">
                                          </div>
                                          <div class="form-group col-md-4">
                                            <label>Payment Date</label>
                                            <input type='date' name='vendor_payment_date' value='<?php echo $Transactions->vendor_payment_date; ?>' class="form-control" value='<?php echo date("Y-m-d"); ?>'>
                                          </div>
                                          <div class="form-group col-md-12">
                                            <label>Payment More Details & remarks</label>
                                            <textarea name='vendor_payment_details' class="form-control" rows='3'><?php echo SECURE($Transactions->vendor_payment_details, "d"); ?></textarea>
                                          </div>
                                          <div class="form-group col-md-12">
                                            <label>Upload Receipt</label>
                                            <input type='FILE' name='vendor_payment_have_receipt' value='<?php echo $Transactions->vendor_payment_have_receipt; ?>' class="form-control">
                                          </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                      <?php echo CONFIRM_DELETE_POPUP(
                                        "transactions",
                                        [
                                          "remove_vendor_transactions" => true,
                                          "control_id" => $Transactions->vendor_transactions_id
                                        ],
                                        "vendorcontroller",
                                        "<i class='fa fa-trash'></i> Remove Permanently",
                                        "btn btn-md text-danger pull-left",
                                      ); ?>
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      <button type="submit" name="UpdatePaymentRecord" class="btn btn-success">Update Payment Details</button>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                          <?php
                            }
                          } else {
                            echo NoData("No Transaction History Found!");
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

    <div class="modal fade square" id="add_payment_record" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header app-bg text-white">
            <button type="button" class="close text-white m-r-8 m-t-1" data-dismiss="modal">&times;</button>
            <h4 class="modal-title text-white">Add New Payment Record</h4>
          </div>
          <div class="modal-body overflow-auto">
            <form action="../../controller/vendorcontroller.php" method="POST" enctype="multipart/form-data">
              <?php FormPrimaryInputs(true, [
                "vendor_main_id" => $vendorid
              ]); ?>
              <?php
              $VendorId = $vendorid;
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
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" name="AddPaymentRecord" class="btn btn-success">Save Payment Details</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script>
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
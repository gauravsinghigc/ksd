<?php
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';

if (isset($_GET['id'])) {
  $bookingid = $_GET['id'];
  $_SESSION['bookingid'] = $_GET['id'];
} else {
  $bookingid = $_SESSION['id'];
}

$BookingSql = "SELECT * FROM bookings where bookingid='$bookingid'";
$customer_id = FETCH($BookingSql, "customer_id");
$partner_id = FETCH($BookingSql, "partner_id");
$CoAllotySql = "SELECT * FROM booking_alloties where BookingAllotyMainBookingId='$bookingid'";
$CustomerSql = "SELECT * FROM users where id='$customer_id'";
$PartnerSql = "SELECT * FROM users where id='$partner_id'";
$CustomerAddress = "SELECT * FROM user_address where user_id='$customer_id'";
$PartnerAddress = "SELECT * FROM user_address where user_id='$partner_id'";

//other variables
$area = FETCH($BookingSql, "unit_area");
$areaint = GetNumbers($area);
$MainBookingID = "B" . $bookingid . "/" . date('m/Y', strtotime(FETCH($BookingSql, 'created_at')));
?>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Edit Booking : <?php echo company_name; ?></title>
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
                  <div class="row">
                    <div class="col-md-12">
                      <h3 class="m-t-0">

                        <i class="fa fa-edit text-danger"></i> Edit CO-Allotee Details : <span class="text-grey">
                          <?php echo $MainBookingID; ?></span>
                      </h3>
                      <a href="index.php" class="btn btn-md btn-default"><i class="fa fa-angle-left"></i> Back to Booking Dashboard</a>

                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <h4 class="section-heading">Booking Details</h4>
                      <p class="data-list flex-s-b">
                        <span>Ref No : </span>
                        <b><?php echo FETCH($BookingSql, 'crn_no'); ?>//<?php echo FETCH($BookingSql, "ref_no"); ?></b>
                      </p>
                      <p class="data-list flex-s-b">
                        <span>BookingID : </span>
                        <b><?php echo $MainBookingID; ?></b>
                      </p>
                      <p class="data-list flex-s-b">
                        <span>Project Name :</span>
                        <b><?php echo FETCH($BookingSql, "project_name"); ?></b>
                      </p>
                      <p class="data-list flex-s-b">
                        <span>Project Area :</span>
                        <b><?php echo FETCH($BookingSql, "project_area"); ?></b>
                      </p>
                      <p class="data-list flex-s-b">
                        <span>Plot No :</span>
                        <b><?php echo strtoupper(FETCH($BookingSql, "unit_name")); ?></b>
                      </p>
                      <p class="data-list flex-s-b">
                        <span>Plot Area :</span>
                        <b><?php
                            $matches = preg_replace('/[^0-9.]+/', '', FETCH($BookingSql, "unit_area"));
                            $unit_area_in_numbers = (int)$matches;
                            echo FETCH($BookingSql, "unit_area"); ?></b>
                      </p>
                      <p class="data-list flex-s-b">
                        <span>Plot Rate :</span>
                        <b>Rs.<?php echo FETCH($BookingSql, "unit_rate"); ?>/sq yards</b>
                      </p>
                      <p class="data-list flex-s-b">
                        <span>Plot Cost :</span>
                        <b><?php echo Price(FETCH($BookingSql, "unit_cost"), "text-primary", "Rs."); ?></b>
                      </p>
                      <?php if (FETCH($BookingSql, "charges") != 0) { ?>
                        <tr>
                          <th>Charges <span class="text-grey fs-11 m-l-5"><?php echo FETCH($BookingSql, "chargename"); ?> (
                              <?php echo FETCH($BookingSql, "charges"); ?>% )</span></th>
                          <td>+ Rs.<?php echo $unit_cost / 100 * (int)FETCH($BookingSql, "charges"); ?></td>
                        </tr>
                      <?php } ?>
                      <?php if (FETCH($BookingSql, "discount") != 0) { ?>
                        <tr>
                          <th>Discount <span class="text-grey fs-11 m-l-5"><?php echo FETCH($BookingSql, "discountname"); ?> (
                              Rs.<?php echo FETCH($BookingSql, "discount");  ?> )</span></th>
                          <td>- Rs.<?php echo $unit_area_in_numbers * FETCH($BookingSql, "discount"); ?></td>
                        </tr>
                      <?php } ?>
                      <p class="data-list flex-s-b">
                        <span>Net Plot Cost :</span>
                        <b><?php echo Price(FETCH($BookingSql, "net_payable_amount"), "text-primary", "Rs."); ?></b>
                      </p>
                    </div>
                    <div class="col-md-4">
                      <h4 class="section-heading">Allotee Details</h4>
                      <p>
                        <b>Allotee Details</b><br>
                        <?php echo FETCH($CustomerSql, "name"); ?>,<br>
                        <?php echo FETCH($CustomerSql, "father_name"); ?><br>
                        <?php
                        echo FETCH($CustomerAddress, "user_street_address") . " ";
                        echo FETCH($CustomerAddress, "user_area_locality") . "<br>";
                        echo FETCH($CustomerAddress, "user_city") . " ";
                        echo FETCH($CustomerAddress, "user_state") . "<br>";
                        echo FETCH($CustomerAddress, "user_pincode") . " ";
                        echo FETCH($CustomerAddress, "user_country");
                        echo "<br>";
                        echo FETCH($CustomerSql, "phone") . "<BR>";
                        echo FETCH($CustomerSql, "email") . "<BR>";
                        ?>
                      </p>
                    </div>
                    <div class="col-md-4">
                      <h4 class="section-heading">Co-Allotee Details</h4>
                      <?php $Check = CHECK($CoAllotySql);
                      if ($Check != null) {
                        $BookingAllotyId = FETCH($CoAllotySql, "BookingAllotyId"); ?>
                        <p>
                          <b>Co-Allotee Details</b><br>
                          <?php echo FETCH($CoAllotySql, "BookingAllotyFullName"); ?><br>
                          <?php echo FETCH($CoAllotySql, "BookingAllotyRelation"); ?><br>
                          <?php echo FETCH($CoAllotySql, "BookingAllotyFatherName"); ?><br>
                          <?php
                          echo FETCH($CoAllotySql, "BookingAllotyStreetAddress");
                          echo FETCH($CoAllotySql, "BookingAllotyArea") . "<br>";
                          echo FETCH($CoAllotySql, "BookingAllotyCity");
                          echo FETCH($CoAllotySql, "BookingAllotyState") . "<br>";
                          echo FETCH($CoAllotySql, "BookingAllotyCountry") . "";
                          echo FETCH($CoAllotySql, "BookingAllotyPincode");
                          echo "<br>";
                          echo FETCH($CoAllotySql, "BookingAllotyPhoneNumber") . "<BR>";
                          echo FETCH($CoAllotySql, "BookingAllotyEmail") . "<BR>";
                          ?>
                        </p>
                      <?php } else {
                        $BookingAllotyId = 0;
                        NoData("No Co-Allotee Details found!");
                      } ?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <h3 class="section-heading">Add Co-Allotee Details</h3>
                    </div>
                    <div class="col-md-7">
                      <h4 class='app-sub-heading'>Enter Co-Allotee Details</h4>
                      <form action="../../../controller/bookingcontroller.php" method="POST">
                        <?php FormPrimaryInputs(true, [
                          "BookingAllotyMainBookingId" => $bookingid
                        ]); ?>
                        <div class="row">
                          <div class="col-md-6 form-group">
                            <label> Co Allotee Full Name</label>
                            <input type="text" name="BookingAllotyFullName" value="<?php echo FETCH($CoAllotySql, "BookingAllotyFullName"); ?>" class="form-control">
                          </div>
                          <div class="col-md-6 form-group">
                            <label>S/O, D/O, W/O </label>
                            <input type="text" name="BookingAllotyRelation" class="form-control" value="<?php echo FETCH($CoAllotySql, "BookingAllotyRelation"); ?>">
                          </div>
                          <div class="col-md-6 form-group">
                            <label> Co Allotee Phone</label>
                            <input type="text" name="BookingAllotyPhoneNumber" value="<?php echo FETCH($CoAllotySql, "BookingAllotyPhoneNumber"); ?>" class=" form-control">
                          </div>
                          <div class="col-md-6 form-group">
                            <label> Co Allotee Email-ID</label>
                            <input type="text" name="BookingAllotyEmail" value="<?php echo FETCH($CoAllotySql, "BookingAllotyEmail"); ?>" class="form-control">
                          </div>
                          <div class="col-md-6 form-group">
                            <label> Co Allotee Father name</label>
                            <input type="text" name="BookingAllotyFatherName" value="<?php echo FETCH($CoAllotySql, "BookingAllotyFatherName"); ?>" class="form-control">
                          </div>
                          <div class="col-md-6 form-group">
                            <label> Co Allotee Mother Name</label>
                            <input type="text" name="BookingAllotyMotherName" value="<?php echo FETCH($CoAllotySql, "BookingAllotyMotherName"); ?>" class=" form-control">
                          </div>
                          <div class="col-md-6 form-group">
                            <label> Co Allotee Street Address</label>
                            <input type="text" name="BookingAllotyStreetAddress" value="<?php echo FETCH($CoAllotySql, "BookingAllotyStreetAddress"); ?>" class="form-control">
                          </div>
                          <div class="col-md-6 form-group">
                            <label> Co Allotee Sector/area</label>
                            <input type="text" name="BookingAllotyArea" value="<?php echo FETCH($CoAllotySql, "BookingAllotyArea"); ?>" class="form-control">
                          </div>
                          <div class="col-md-6 form-group">
                            <label> Co Allotee City</label>
                            <input type="text" name="BookingAllotyCity" value="<?php echo FETCH($CoAllotySql, "BookingAllotyCity"); ?>" class="form-control">
                          </div>
                          <div class="col-md-6 form-group">
                            <label> Co Allotee State</label>
                            <input type="text" name="BookingAllotyState" value="<?php echo FETCH($CoAllotySql, "BookingAllotyState"); ?>" class="form-control">
                          </div>
                          <div class="col-md-6 form-group">
                            <label> Co Allotee Pincode</label>
                            <input type="text" name="BookingAllotyPincode" value="<?php echo FETCH($CoAllotySql, "BookingAllotyPincode"); ?>" class="form-control">
                          </div>
                          <div class="col-md-6 form-group hidden">
                            <label> Co Allotee Country</label>
                            <input type="text" name="BookingAllotyCountry" value="<?php echo FETCH($CoAllotySql, "BookingAllotyCountry"); ?>" class=" form-control">
                          </div>
                          <div class="col-md-12">
                            <a href="index.php" class="btn btn-md btn-default"><i class="fa fa-angle-left"></i> Back to Booking
                              Dashboard</a>
                            <button class="btn btn-md btn-primary" type="submit" name="UpdateAllotyDetails">Update Details</button>
                            <?php CONFIRM_DELETE_POPUP(
                              "remove_co_allotee",
                              [
                                "remove_co_allotee_details" => true,
                                "control_id" => $BookingAllotyId,
                              ],
                              "bookingcontroller",
                              "<i class='fa fa-trash'></i> Remove Co-Allotee",
                              "btn btn-md btn-danger"
                            ); ?>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="col-md-5">
                      <h4 class="app-sub-heading">Upload Documents</h4>
                      <?php if ($BookingAllotyId == 0) {
                        NoData("Please add Co-Allotee first!");
                      } else {
                      ?>
                        <form action="../../../controller/bookingcontroller.php" method="POST" enctype="multipart/form-data">
                          <?php FormPrimaryInputs(true, [
                            "BookingAlloteeMainId" => $bookingid
                          ]); ?>
                          <div class="row">
                            <div class="col-md-6 form-group">
                              <label>Document Type</label>
                              <input type="text" list="documentslist" name="BookingAlloteeDocName" required="" class="form-control">
                              <datalist id="documentslist">
                                <option value="PAN CARD"></option>
                                <option value="ADHAAR CARD"></option>
                                <option value="VOTAR CARD"></option>
                                <option value="DRIVING LISCENCE"></option>
                                <option value="PASSPORT"></option>
                                <option value="RATION CARD"></option>
                                <option value="PROPERTY PAPERS"></option>
                                <option value="REGISTRY"></option>
                                <option value="GENERAL POWER OF ATTORNY"></option>
                                <option value="ELECTRICITY BILL"></option>
                                <option value="WATER BILL"></option>
                                <option value="MAINTENANCE BILL"></option>
                                <option value="POSSESSION CERTIFICATE"></option>
                                <option value="ALLOTMENT LETTER"></option>
                                <option value="NO OBJECTION CERTIFICATE (NOC)"></option>
                              </datalist>
                            </div>
                            <div class="col-md-6 form-group">
                              <label>Document No</label>
                              <input type="text" name="BookingAlloteeDocNumber" class="form-control" required="">
                            </div>
                            <div class="col-md-12 form-group">
                              <label>Document File</label>
                              <input type="file" name="BookingAlloteeDocFile" class="form-control">
                            </div>
                            <div class="col-md-12">
                              <button type="submit" name="UploadCoAlloteeDocuments" class="btn btn-md btn-success"><i class="fa fa-upload"></i> Upload Documents</button>
                            </div>
                          </div>
                        </form>
                        <h4 class="app-sub-heading">Uploaded Documents</h4>
                        <?php $Documents = FetchConvertIntoArray("SELECT * FROM booking_alloty_documents where BookingAlloteeMainId='$bookingid'", true);
                        if ($Documents != null) {
                          foreach ($Documents as $docs) {
                        ?>
                            <p class="data-list flex-s-b">
                              <span>
                                <?php echo $docs->BookingAlloteeDocName; ?>
                                (<?php echo $docs->BookingAlloteeDocNumber; ?>)

                              </span>
                              <span>
                                <a href="<?php echo STORAGE_URL; ?>/bookings/<?php echo $bookingid; ?>/co-allotee/<?php echo $docs->BookingAlloteeDocFile; ?>" target="_blank" class="text-primary btn btn-sm btn-default p-1">View File <i class="fa fa-file-pdf-o"></i></a>
                                <?php CONFIRM_DELETE_POPUP(
                                  "remove_docs",
                                  [
                                    "remove_allotee_documents" => true,
                                    "control_id" => $docs->BookingAlloteeDocId,
                                  ],
                                  "bookingcontroller",
                                  "Remove",
                                  "btn btn-sm btn-danger"
                                ); ?>
                              </span>
                            </p>
                        <?php
                          }
                        } else {
                          NoData("No Documents found!");
                        }   ?>
                      <?php } ?>
                    </div>
                  </div>


                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include '../../payments/payment-popup.php'; ?>


    <!-- end -->
    <?php include '../../sidebar.php'; ?>
    <?php include '../../footer.php'; ?>
  </div>

  <?php include '../../../include/footer_files.php'; ?>

</html>
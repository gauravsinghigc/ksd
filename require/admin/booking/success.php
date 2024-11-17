<?php
require '../../require/modules.php';
require "../../require/admin/sessionvariables.php";
require '../../include/admin/common.php';

if (isset($_GET['bookingid'])) {
  $bookingid = $_GET['bookingid'];
  $_SESSION['booking_id'] = $bookingid;
} else {
  $bookingid = $_SESSION['booking_id'];
}

$BSql = "SELECT * FROM bookings where bookingid='$bookingid'";
$MainBookingID = "B$bookingid/" . date("m/Y", strtotime(FETCH($BSql, "created_at")));
$customer_id = FETCH($BSql, "customer_id");
$partner_id = FETCH($BSql, "partner_id");

$agent_relation = FETCH("SELECT * FROM users where id='$customer_id'", "agent_relation");
if ($agent_relation == 0) {
  $Update = UPDATE("UPDATE users SET agent_relation='$partner_id' where id='$customer_id'");
}

$getusers = SELECT("SELECT * FROM users, user_address, user_roles where users.company_relation='" . company_id . "' and users.id='$customer_id' and users.id=user_address.user_id and users.user_role_id=user_roles.role_id");
$count = 0;
$customers = mysqli_fetch_array($getusers);
$count++;
$customer_name = $customers['name'];
$customer_phone = $customers['phone'];
$customer_email = $customers['email'];
$user_street_address = $customers['user_street_address'];
$user_area_locality = $customers['user_area_locality'];
$user_city = $customers['user_city'];
$user_state = $customers['user_state'];
$user_pincode = $customers['user_pincode'];
$user_country = $customers['user_country'];
$executedcustomer_id = $customers['user_id'];
$customer_user_profile_img = $customers['user_profile_img'];
$user_status = $customers['user_status'];
$created_at_c = $customers['created_at'];
$user_role_id = $customers['user_role_id'];
$user_role_name = $customers['role_name'];
$agent_relation = $customers['agent_relation'];
if ($user_status == "ACTIVE") {
  $user_status_view = "<span class='text-success'><i class='fa fa-check-circle'></i> Active</span>";
} else {
  $user_status_view = "<span class='text-danger'><i class='fa fa-warning'></i> Inactive</span>";
}
if ($customer_user_profile_img == "user.png") {
  $customer_user_profile_img = DOMAIN . "/storage/sys-img/$customer_user_profile_img";
} else {
  $customer_user_profile_img = DOMAIN . "/storage/users/$executedcustomer_id/img/$customer_user_profile_img";
}
$CoAllotySql = "SELECT * FROM booking_alloties where BookingAllotyMainBookingId='$bookingid'";
?>
<?php $Check = CHECK($CoAllotySql);
if ($Check != null) {
  $BookingAllotyId = FETCH($CoAllotySql, "BookingAllotyId"); ?>
<?php } else {
  $BookingAllotyId = 0;
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Booking Created| <?php echo company_name; ?></title>
  <?php include '../../include/header_files.php'; ?>
</head>

<body>
  <div id="container" class="navbar-fixed mainnav-fixed mainnav-lg">
    <?php include '../header.php'; ?>

    <!--END NAVBAR-->
    <div class="boxed">
      <!--CONTENT CONTAINER-->
      <!--===================================================-->
      <div id="content-container">
        <!--Page content-->
        <div id="page-content">
          <div class="panel square">
            <div class="panel-body">
              <div class="row">
                <div class="col-md-4">
                  <h4 class="app-bg br5 p-3 pl-1">Booking Details</h4>
                  <table class="table table-striped">
                    <tr>
                      <th>Booking ID</th>
                      <td><span class="text-info text-decoration-underline"><?php echo $MainBookingID; ?></span></td>
                    </tr>
                    <tr>
                      <th>Project Name</th>
                      <td><?php echo FETCH($BSql, "project_name"); ?></td>
                    </tr>
                    <tr>
                      <th>Project Area</th>
                      <td><?php echo FETCH($BSql, "project_area"); ?></td>
                    </tr>
                    <tr>
                      <th>Unit No:</th>
                      <td><?php echo FETCH($BSql, "unit_name"); ?></td>
                    </tr>
                    <tr>
                      <th>Unit Area</th>
                      <td><?php echo FETCH($BSql, "unit_area"); ?></td>
                    </tr>
                    <tr>
                      <th>Unit Rate</th>
                      <td>Rs.<?php echo FETCH($BSql, "unit_rate"); ?> / sq area</td>
                    </tr>
                    <tr>
                      <th>Unit Cost</th>
                      <td><span>Rs.<?php echo FETCH($BSql, "unit_cost"); ?></span></td>
                    </tr>
                    <?php if (FETCH($BSql, "charges") != 0) { ?>
                      <tr>
                        <th>Charges <span class="text-grey fs-11 m-l-5"><?php echo FETCH($BSql, "chargename"); ?> (
                            <?php echo FETCH($BSql, "charges"); ?>% )</span></th>
                        <td>+ Rs.<?php echo (int)FETCH($BSql, "unit_cost") / 100 * (int)FETCH($BSql, "charges"); ?></td>
                      </tr>
                    <?php } ?>
                    <?php if (FETCH($BSql, "discount") != 0) { ?>
                      <tr>
                        <th>Discount <span class="text-grey fs-11 m-l-5"><?php echo FETCH($BSql, "discountname"); ?> (
                            Rs.<?php echo FETCH($BSql, "discount");  ?> )</span></th>
                        <td>- Rs.<?php echo (int)FETCH($BSql, "unit_area_in_numbers") * (int)FETCH($BSql, "discount"); ?></td>
                      </tr>
                    <?php } ?>
                    <tr>
                      <th>Net Payable Amount</th>
                      <td><span class="text-success fs-14">Rs.<?php echo FETCH($BSql, "net_payable_amount"); ?></span></td>
                    </tr>
                  </table>
                </div>

                <div class="col-md-4 col-lg-4 col-4">
                  <h4 class="section-heading">Customer Details</h4>
                  <a href="<?php echo DOMAIN; ?>/admin/customer/dashboard/?id=<?php echo $customer_id; ?>">
                    <div class="p-1r shadow-lg p-t-20 br10 hover-shadow app-bdr-top">
                      <div class="header">
                        <div class="row">
                          <div class="col-lg-2 col-md-2 col-sm-2 col-2 col-xs-2">
                            <div class="avatar m-t-15">
                              <img src="<?php echo $customer_user_profile_img; ?>" class="img-fluid" alt="<?php echo $customer_name; ?>" title="<?php echo $customer_name; ?>">
                            </div>
                          </div>
                          <div class="col-lg-10 col-md-10 col-sm-10 col-10 col-xs-10">
                            <h5 class="m-t-4 m-b-3 fs-13 text-right text-grey italic">CUST ID : <?php echo $customer_id; ?></h5>
                            <h5 class="m-t-4 m-b-3 fs-15"><b><?php echo $customer_name; ?></b></h5>
                            <p class="lh-1-5 m-b-1 m-t-5">
                              <i class="fa fa-envelope-o text-danger"></i> <?php echo $customer_email; ?><br>
                              <i class="fa fa-phone text-info"></i> <?php echo $customer_phone; ?>
                            </p>
                          </div>
                          <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xs-12">
                            <p class="lh-1-4 m-t-5">
                              <i class="fa fa-map-marker text-success"></i>
                              <?php echo "$user_street_address,  $user_area_locality, $user_city, $user_state $user_country - $user_pincode"; ?>
                            </p>
                          </div>
                          <div class="clearfix"></div>
                        </div>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                  </a>
                </div>
                <div class="col-md-4 col-lg-4 col-4 text-center">
                  <img src="https://gatesbbq.com/wp-content/uploads/2017/04/checkmarksuccess.gif" class="img-fluid w-50" style="width:30% !important;"><br>
                  <h3 class="app-text">Booking Created Successfully!</h3><br>
                  <a href="<?php echo DOMAIN; ?>/admin/booking/index.php" class="btn btn-info"><i class="fa fa-angle-left"></i>
                    Back to Bookings</a>
                  <a class="btn btn-primary" target="blank" href="<?php echo DOMAIN; ?>/admin/booking/booking_exports.php?id=<?php echo $_SESSION['booking_id']; ?>"><i class="fa fa-print"></i> Print Receipt <i class="fa fa-angle-right"></i></a>
                  <br><br>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 col-lg-6">
                  <h4 class="section-heading">Upload Documents</h4>
                  <form action="../../controller/usercontroller.php" method="POST" enctype="multipart/form-data">
                    <?php FormPrimaryInputs(true, [
                      "user_id" => FETCH($BSql, "customer_id"),
                    ]);  ?>
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label>Document Name</label>
                        <input type="text" class="form-control" list="documents" name="document_name" value="" placeholder="">
                        <datalist id="documents">
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
                          <?php $FetchDocuments = FetchConvertIntoArray("SELECT * from user_documents GROUP BY document_name DESC ORDER BY document_name", true);
                          if ($FetchDocuments != null) {
                            foreach ($FetchDocuments as $Docs) { ?>
                              <option value="<?php echo $Docs->document_name; ?>"></option>
                          <?php }
                          } ?>
                        </datalist>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>Document No</label>
                        <input type="text" class="form-control" name="user_documents_no" value="" placeholder="">
                      </div>
                      <div class="col-md-12 form-group">
                        <label>Document File</label>
                        <input type="FILE" class="form-control" name="document_file" value="">
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12 text-center">
                        <hr>
                        <a href="details/index.php?id=<?php echo $_SESSION['booking_id']; ?>" class="btn btn-lg btn-default">View
                          Booking Dashboard</a>
                        <button type="submit" name="UploadDocuments" class="btn btn-lg btn-success">Upload Documents <i class="fa fa-angle-double-right"></i></button>
                      </div>
                    </div>
                  </form>

                  <hr>
                  <h4 class="section-heading">Uploaded Documents</h4>
                  <?php $Documents = FetchConvertIntoArray("SELECT * FROM user_documents where user_id='$customer_id'", true);
                  if ($Documents == null) {
                    echo "<p class='data-list'>No Document Found!</p>";
                  } else {
                    foreach ($Documents as $Docs) { ?>
                      <p class="data-list">
                        <span>
                          <b class="text-primary"><?php echo $Docs->document_name; ?></b> |
                          <?php echo $Docs->user_documents_no; ?> @ <?php echo DATE_FORMATE2("d M, Y", $Docs->document_created_at); ?>
                          |
                        </span>
                        <span>
                          <a href="<?php echo STORAGE_URL; ?>/documents/<?php echo $customer_id; ?>/<?php echo $Docs->document_file; ?>" class="text-primary" target="_blank">View File <i class="fa fa-print"></i></a>
                          <?php CONFIRM_DELETE_POPUP(
                            "delete_documents",
                            [
                              "delete_customer_documents" => true,
                              "control_id" => $Docs->document_id,
                            ],
                            "usercontroller",
                            "Remove File",
                            "text-danger"
                          ); ?>
                        </span>
                      </p>
                    <?php } ?>
                  <?php } ?>
                </div>

                <div class="col-md-6">
                  <h4 class="section-heading">Update Co-Allotee Details</h4>
                  <form action="../../controller/bookingcontroller.php" method="POST">
                    <?php FormPrimaryInputs(true, [
                      "BookingAllotyMainBookingId" => $bookingid
                    ]);
                    $CoAllotySql = "SELECT * FROM booking_alloties where BookingAllotyMainBookingId='$bookingid'"; ?>
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
                        <button class="btn btn-md btn-primary" type="submit" name="UpdateAllotyDetails">Update Co-Allotee
                          Details</button>
                        <a href="docs/welcome-letter.php?id=<?php echo $bookingid; ?>" target="_blank" class="btn btn-sm btn-info"><i class="fa fa-print"></i> Welcome Letter</a>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="col-md-7">
                  <h4 class="app-sub-heading">Uploaded Co-Allotee Documents</h4>
                  <?php if ($Check  == null) {
                    NoData("Please add Co-Allotee first!");
                  } else {
                  ?>

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
                <div class="col-md-5">
                  <h4 class="app-sub-heading">Upload Co-Allotee Documents</h4>
                  <?php if ($BookingAllotyId == 0) {
                    NoData("Please add Co-Allotee first!");
                  } else {
                  ?>
                    <form action="../../controller/bookingcontroller.php" method="POST" enctype="multipart/form-data">
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
                  <?php } ?>
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



    <!-- end -->
    <?php include '../sidebar.php'; ?>
    <?php include '../footer.php'; ?>
  </div>

  <?php include '../../include/footer_files.php'; ?>
</body>

</html>
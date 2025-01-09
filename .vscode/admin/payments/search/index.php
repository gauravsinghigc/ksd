<?php
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';

$PageTitle = "Search Customers";
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title><?php echo $PageTitle; ?> | <?php echo company_name; ?></title>
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
                                 <h3 class="m-t-3"><i class="fa fa-search app-text"></i> Search Customers & Receive Payments</h3>
                              </div>
                              <div class="col-md-5">
                                 <h4 class="app-sub-heading">Search Customers</h4>
                                 <form>
                                    <div class="row">
                                       <div class="col-md-5">
                                          <div class="form-group">
                                             <label>Search Type</label>
                                             <select name="search_type" onchange="form.submit()" class="form-control">
                                                <?php InputOptions(
                                                   [
                                                      "id" => "CUSTOMER ID (00XX)",
                                                      "name" => "Name (Keshave)",
                                                      "email" => "Email-ID (abc@domain.tld)",
                                                      "phone" => "Phone Number (9876543210)"
                                                   ],
                                                   IfRequested("GET", "search_type", "name", false)
                                                ); ?>

                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-md-7">
                                          <div class="form-group">
                                             <label>Enter Search Value</label>
                                             <input type="text" name="search_value" onchange="form.submit()" class="form-control" placeholder="" list="datalist">
                                             <datalist id="datalist">
                                                <?php
                                                if (isset($_GET['search_type'])) {
                                                   $search_type = IfRequested("GET", "search_type", "", false);
                                                   $search_value = IfRequested("GET", "search_value", "", false);
                                                   $Sql = "SELECT * FROM users where user_role_id='4'";
                                                   $SearchSql = FetchConvertIntoArray($Sql, true);
                                                   if ($SearchSql != null) {
                                                      foreach ($SearchSql as $Search) {
                                                ?>
                                                         <option value="<?php echo $Search->$search_type; ?>"></option>
                                                      <?php
                                                      }
                                                   }
                                                } else {
                                                   $Sql = "SELECT * FROM users where user_role_id='4'";
                                                   $SearchSql = FetchConvertIntoArray($Sql, true);
                                                   if ($SearchSql != null) {
                                                      foreach ($SearchSql as $Search) {
                                                      ?>
                                                         <option value="<?php echo $Search->name; ?>"></option>
                                                <?php
                                                      }
                                                   }
                                                } ?>
                                             </datalist>
                                          </div>
                                       </div>
                                    </div>
                                 </form>
                                 <h4 class="app-sub-heading">Search Results</h4>
                                 <div class="row">
                                    <?php
                                    if (isset($_GET['search_value'])) {
                                       if ($_GET['search_value'] != null || $_GET['search_value'] != "") {
                                          $Sql = "SELECT * FROM users where $search_type like '%$search_value%'";
                                          $SearchSql = FetchConvertIntoArray($Sql, true);
                                          $Check = CHECK($Sql);
                                          if ($Check == null) {
                                    ?>
                                             <div class="col-md-12">
                                                <h3>No Customer Found</h3>
                                                <p>No customer fround from <b><?php echo $search_type; ?></b> having value <b><?php echo $search_value; ?></b>. Please try to add this customer by clicking below button.</p>
                                             </div>
                                             <?php
                                          } else {

                                             foreach ($SearchSql as $Customer) {
                                                $executedcustomer_id = $Customer->id;
                                                $customer_user_profile_img = $Customer->user_profile_img;
                                                if ($customer_user_profile_img == "user.png") {
                                                   $customer_user_profile_img = DOMAIN . "/storage/sys-img/$customer_user_profile_img";
                                                } else {
                                                   $customer_user_profile_img = DOMAIN . "/storage/users/$executedcustomer_id/img/$customer_user_profile_img";
                                                }
                                                $AddSql = "SELECT * FROM users, user_address, user_roles where users.id='$executedcustomer_id' and users.company_relation='" . company_id . "' and users.id=user_address.user_id and users.user_role_id=user_roles.role_id";
                                                $AddressSql = FetchConvertIntoArray($AddSql, true);
                                             ?>
                                                <div class="col-md-12 m-b-10">
                                                   <div class="row shadow-lg rounded-3 p-1">
                                                      <div class="col-md-2">
                                                         <img src="<?php echo $customer_user_profile_img; ?>" class="img-fluid m-t-35">
                                                      </div>
                                                      <div class="col-md-10">
                                                         <h4 class="bold black"><?php echo $Customer->name; ?> <?php echo $Customer->father_name; ?> <small class="text-grey"> | CUST00<?php echo $Customer->id; ?></small></h4>
                                                         <p>
                                                            <span><?php echo $Customer->phone; ?></span><br>
                                                            <span><?php echo $Customer->email; ?></span><br>
                                                            <?php
                                                            if (CHECK($AddSql) != null) {
                                                               foreach ($AddressSql as $Address) {
                                                                  $user_address_id = $Address->user_address_id; ?>
                                                                  <span><i class="fa fa-map-marker text-success"></i> <?php echo $Address->user_street_address; ?> <?php echo $Address->user_area_locality; ?> <?php echo $Address->user_city; ?> <?php echo $Address->user_state; ?> <?php echo $Address->user_country; ?> - <?php echo $Address->user_pincode; ?></span>
                                                            <?php }
                                                            } ?>
                                                         </p>
                                                         <hr>
                                                         <a href="#" class="btn btn-md btn-default" data-toggle="modal" data-target="#edit_customer_<?php echo $executedcustomer_id; ?>"><i class='fa fa-edit'></i> Edit Details</a>
                                                         <a href="?customer_id=<?php echo $executedcustomer_id; ?>&BOOKING_STEP=true" class="btn btn-md btn-success">Select & Continue <i class="fa fa-angle-right"></i></a>
                                                      </div>
                                                   </div>
                                                </div>

                                                <div class="modal fade square" id="edit_customer_<?php echo $executedcustomer_id; ?>" role="dialog">
                                                   <div class="modal-dialog modal-lg">
                                                      <div class="modal-content">
                                                         <div class="modal-header app-bg text-white">
                                                            <button type="button" class="close text-white m-r-8 m-t-1" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title text-white">Edit Customer Details</h4>
                                                         </div>
                                                         <div class="modal-body overflow-auto">
                                                            <form action="../../controller/usercontroller.php" method="POST">
                                                               <?php FormPrimaryInputs(true, [
                                                                  "user_country" => "India",
                                                                  "customer_id" => $executedcustomer_id,
                                                                  "agent_relation" => 0,
                                                                  "booking_process" => true
                                                               ]); ?>
                                                               <div class="row">
                                                                  <div class="from-group col-md-6">
                                                                     <label>Full Name</label>
                                                                     <input type="text" name="name" value="<?php echo $Customer->name; ?>" class="form-control" placeholder="" required="">
                                                                  </div>
                                                                  <div class="from-group col-md-6">
                                                                     <label>S/O, W/O, D/O Name</label>
                                                                     <input type="text" name="father_name" value="<?php echo $Customer->father_name; ?>" class="form-control" placeholder="" required="">
                                                                  </div>
                                                                  <div class="from-group col-md-6">
                                                                     <label>Email</label>
                                                                     <input type="email" name="email" value="<?php echo $Customer->email; ?>" class="form-control" placeholder="">
                                                                  </div>
                                                                  <div class="from-group col-md-6">
                                                                     <label>Phone Number</label>
                                                                     <input type="text" name="phone" value="<?php echo $Customer->phone; ?>" class="form-control" placeholder="" required="">
                                                                  </div>
                                                                  <div class="from-group col-md-6">
                                                                     <label>Address</label>
                                                                     <input type="text" name="user_street_address" value="<?php echo FETCH($AddSql, "user_street_address"); ?>" class="form-control" placeholder="" required="">
                                                                  </div>
                                                                  <div class="from-group col-md-6">
                                                                     <label>Area Locality</label>
                                                                     <input type="text" name="user_area_locality" value="<?php echo FETCH($AddSql, "user_area_locality"); ?>" class="form-control" placeholder="" required="">
                                                                  </div>
                                                                  <div class="from-group col-md-6">
                                                                     <label>City</label>
                                                                     <input type="text" name="user_city" value="<?php echo FETCH($AddSql, "user_city"); ?>" class="form-control" placeholder="" required="">
                                                                  </div>
                                                                  <div class="from-group col-md-6">
                                                                     <label>State</label>
                                                                     <input type="text" name="user_state" value="<?php echo FETCH($AddSql, "user_state"); ?>" class="form-control" placeholder="" required="">
                                                                  </div>
                                                                  <div class="from-group col-md-6">
                                                                     <label>Pincode</label>
                                                                     <input type="text" name="user_pincode" value="<?php echo FETCH($AddSql, "user_pincode"); ?>" class="form-control" placeholder="" required="">
                                                                  </div>
                                                                  <div class="from-group col-md-6">
                                                                     <label>User Status</label>
                                                                     <select name="user_status" class="form-control" required="">
                                                                        <?php InputOptions(
                                                                           [
                                                                              "ACTIVE" => "Active",
                                                                              "INACTIVE" => "Inactive",
                                                                           ],
                                                                           $Customer->user_status
                                                                        ); ?>
                                                                     </select>
                                                                  </div>
                                                                  <div class="from-group col-md-6">
                                                                     <label>User Role</label>
                                                                     <select name="user_role_id" class="form-control text-uppercase" required="">
                                                                        <?php
                                                                        $getuserroles = SELECT("SELECT * FROM user_roles where role_id='4'");
                                                                        while ($user_roles = mysqli_fetch_array($getuserroles)) {
                                                                           $role_id = $user_roles['role_id'];
                                                                           $role_name = $user_roles['role_name']; ?>
                                                                           <option value="<?php echo $role_id; ?>" class="text-uppercase"><?php echo $role_name; ?></option>
                                                                        <?php } ?>
                                                                     </select>
                                                                  </div>
                                                               </div>
                                                         </div>
                                                         <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            <button type="submit" name="update_customers" value="<?php echo $executedcustomer_id; ?>" class="btn btn-success">Update Details</button>
                                                            </form>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                    <?php
                                             }
                                          }
                                       }
                                    } ?>
                                    <?php
                                    if (isset($_GET['customer_id'])) {
                                       $customer_id = $_GET['customer_id'];
                                       $Sql = "SELECT * FROM users where id='$customer_id'";
                                       $SearchSql = FetchConvertIntoArray($Sql, true);
                                       $Check = CHECK($Sql);
                                       if ($Check == null) {
                                    ?>
                                          <div class="col-md-12">
                                             <h3>No Customer Found</h3>
                                             <p>No customer fround from <b><?php echo $search_type; ?></b> having value <b><?php echo $search_value; ?></b>. Please try to add this customer by clicking below button.</p>
                                          </div>
                                          <?php
                                       } else {

                                          foreach ($SearchSql as $Customer) {
                                             $executedcustomer_id = $Customer->id;
                                             $customer_user_profile_img = $Customer->user_profile_img;
                                             if ($customer_user_profile_img == "user.png") {
                                                $customer_user_profile_img = DOMAIN . "/storage/sys-img/$customer_user_profile_img";
                                             } else {
                                                $customer_user_profile_img = DOMAIN . "/storage/users/$executedcustomer_id/img/$customer_user_profile_img";
                                             }
                                             $AddSql = "SELECT * FROM users, user_address, user_roles where users.id='$executedcustomer_id' and users.company_relation='" . company_id . "' and users.id=user_address.user_id and users.user_role_id=user_roles.role_id";
                                             $AddressSql = FetchConvertIntoArray($AddSql, true);
                                          ?>
                                             <div class="col-md-12 m-b-10">
                                                <div class="row shadow-lg rounded-3 p-1">
                                                   <div class="col-md-2">
                                                      <img src="<?php echo $customer_user_profile_img; ?>" class="img-fluid m-t-35">
                                                   </div>
                                                   <div class="col-md-10">
                                                      <h4 class="bold black"><?php echo $Customer->name; ?> <?php echo $Customer->father_name; ?> <small class="text-grey"> | CUST00<?php echo $Customer->id; ?></small></h4>
                                                      <p>
                                                         <span><?php echo $Customer->phone; ?></span><br>
                                                         <span><?php echo $Customer->email; ?></span><br>
                                                         <?php foreach ($AddressSql as $Address) {
                                                            $user_address_id = $Address->user_address_id; ?>
                                                            <span><i class="fa fa-map-marker text-success"></i> <?php echo $Address->user_street_address; ?> <?php echo $Address->user_area_locality; ?> <?php echo $Address->user_city; ?> <?php echo $Address->user_state; ?> <?php echo $Address->user_country; ?> - <?php echo $Address->user_pincode; ?></span>
                                                         <?php } ?>
                                                      </p>
                                                      <hr>
                                                      <a href="#" class="btn btn-md btn-default" data-toggle="modal" data-target="#edit_customer_<?php echo $executedcustomer_id; ?>"><i class='fa fa-edit'></i> Edit Details</a>
                                                      <a href="?customer_id=<?php echo $executedcustomer_id; ?>&BOOKING_STEP=true" class="btn btn-md btn-success">Select & Continue <i class="fa fa-angle-right"></i></a>
                                                   </div>
                                                </div>
                                             </div>

                                             <div class="modal fade square" id="edit_customer_<?php echo $executedcustomer_id; ?>" role="dialog">
                                                <div class="modal-dialog modal-lg">
                                                   <div class="modal-content">
                                                      <div class="modal-header app-bg text-white">
                                                         <button type="button" class="close text-white m-r-8 m-t-1" data-dismiss="modal">&times;</button>
                                                         <h4 class="modal-title text-white">Edit Customer Details</h4>
                                                      </div>
                                                      <div class="modal-body overflow-auto">
                                                         <form action="../../controller/usercontroller.php" method="POST">
                                                            <?php FormPrimaryInputs(true, [
                                                               "user_country" => "India",
                                                               "customer_id" => $executedcustomer_id,
                                                               "agent_relation" => 0,
                                                               "booking_process" => true
                                                            ]); ?>
                                                            <div class="row">
                                                               <div class="from-group col-md-6">
                                                                  <label>Full Name</label>
                                                                  <input type="text" name="name" value="<?php echo $Customer->name; ?>" class="form-control" placeholder="" required="">
                                                               </div>
                                                               <div class="from-group col-md-6">
                                                                  <label>S/O, W/O, D/O Name</label>
                                                                  <input type="text" name="father_name" value="<?php echo $Customer->father_name; ?>" class="form-control" placeholder="" required="">
                                                               </div>
                                                               <div class="from-group col-md-6">
                                                                  <label>Email</label>
                                                                  <input type="email" name="email" value="<?php echo $Customer->email; ?>" class="form-control" placeholder="">
                                                               </div>
                                                               <div class="from-group col-md-6">
                                                                  <label>Phone Number</label>
                                                                  <input type="text" name="phone" value="<?php echo $Customer->phone; ?>" class="form-control" placeholder="" required="">
                                                               </div>
                                                               <div class="from-group col-md-6">
                                                                  <label>Address</label>
                                                                  <input type="text" name="user_street_address" value="<?php echo FETCH($AddSql, "user_street_address"); ?>" class="form-control" placeholder="" required="">
                                                               </div>
                                                               <div class="from-group col-md-6">
                                                                  <label>Area Locality</label>
                                                                  <input type="text" name="user_area_locality" value="<?php echo FETCH($AddSql, "user_area_locality"); ?>" class="form-control" placeholder="" required="">
                                                               </div>
                                                               <div class="from-group col-md-6">
                                                                  <label>City</label>
                                                                  <input type="text" name="user_city" value="<?php echo FETCH($AddSql, "user_city"); ?>" class="form-control" placeholder="" required="">
                                                               </div>
                                                               <div class="from-group col-md-6">
                                                                  <label>State</label>
                                                                  <input type="text" name="user_state" value="<?php echo FETCH($AddSql, "user_state"); ?>" class="form-control" placeholder="" required="">
                                                               </div>
                                                               <div class="from-group col-md-6">
                                                                  <label>Pincode</label>
                                                                  <input type="text" name="user_pincode" value="<?php echo FETCH($AddSql, "user_pincode"); ?>" class="form-control" placeholder="" required="">
                                                               </div>
                                                               <div class="from-group col-md-6">
                                                                  <label>User Status</label>
                                                                  <select name="user_status" class="form-control" required="">
                                                                     <?php InputOptions(
                                                                        [
                                                                           "ACTIVE" => "Active",
                                                                           "INACTIVE" => "Inactive",
                                                                        ],
                                                                        $Customer->user_status
                                                                     ); ?>
                                                                  </select>
                                                               </div>
                                                               <div class="from-group col-md-6">
                                                                  <label>User Role</label>
                                                                  <select name="user_role_id" class="form-control text-uppercase" required="">
                                                                     <?php
                                                                     $getuserroles = SELECT("SELECT * FROM user_roles where role_id='4'");
                                                                     while ($user_roles = mysqli_fetch_array($getuserroles)) {
                                                                        $role_id = $user_roles['role_id'];
                                                                        $role_name = $user_roles['role_name']; ?>
                                                                        <option value="<?php echo $role_id; ?>" class="text-uppercase"><?php echo $role_name; ?></option>
                                                                     <?php } ?>
                                                                  </select>
                                                               </div>
                                                            </div>
                                                      </div>
                                                      <div class="modal-footer">
                                                         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                         <button type="submit" name="update_customers" value="<?php echo $executedcustomer_id; ?>" class="btn btn-success">Update Details</button>
                                                         </form>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                    <?php
                                          }
                                       }
                                    }
                                    ?>
                                 </div>
                              </div>
                              <div class="col-md-7">
                                 <?php
                                 if (isset($_GET['customer_id'])) {
                                    $customer_id = $_GET['customer_id'];
                                    $GetBookings = SELECT("SELECT * FROM bookings where customer_id='$customer_id' ORDER BY bookingid DESC");
                                    if ($GetBookings == false) {
                                       echo "<h3 class='text-danger'>No Bookings Found!</h3>";
                                    }
                                    while ($Bookings = mysqli_fetch_array($GetBookings)) {
                                       $bookingid = $Bookings['bookingid'];
                                       $project_name = $Bookings['project_name'];
                                       $project_area = $Bookings['project_area'];
                                       $unit_name = strtoupper($Bookings['unit_name']);
                                       $unit_area = $Bookings['unit_area'];
                                       $unit_rate = $Bookings['unit_rate'];
                                       $unit_cost = $Bookings['unit_cost'];
                                       $net_payable_amount = $Bookings['net_payable_amount'];
                                       $booking_date = $Bookings['booking_date'];
                                       $clearing_date = $Bookings['clearing_date'];
                                       $possession = $Bookings['possession'];
                                       $chargename = $Bookings['chargename'];
                                       $charges = $Bookings['charges'];
                                       $discountname = $Bookings['discountname'];
                                       $discount = $Bookings['discount'];
                                       $created_at = $Bookings['created_at'];
                                       $customer_id = $Bookings['customer_id'];
                                       $matches = preg_replace('/[^0-9.]+/', '', $unit_area);
                                       $unit_area_in_numbers = (int)$matches;
                                       $possession_notes = SECURE($Bookings['possession_notes'], "d");
                                       $possession_update_date = $Bookings['possession_update_date'];
                                       $emi_months = $Bookings['emi_months'];
                                       $MainBookingID = "B$bookingid/" . date("m/Y", strtotime($created_at));
                                       $emi_id = FETCH("SELECT * FROM booking_emis where booking_id='$bookingid'", "emi_id");
                                 ?>
                                       <div class="col-md-6">
                                          <h4 class="app-bg br5 p-3 pl-1">Booking : <?php echo $MainBookingID; ?></h4>
                                          <table class="table table-striped">
                                             <tr>
                                                <th>Booking ID</th>
                                                <td><span class="text-info text-decoration-underline"><?php echo $MainBookingID; ?></span></td>
                                             </tr>
                                             <tr>
                                                <th>Project Name</th>
                                                <td><?php echo $project_name; ?></td>
                                             </tr>
                                             <tr>
                                                <th>Project Area</th>
                                                <td><?php echo $project_area; ?></td>
                                             </tr>
                                             <tr>
                                                <th>Unit No:</th>
                                                <td><?php echo $unit_name; ?></td>
                                             </tr>
                                             <tr>
                                                <th>Unit Area</th>
                                                <td><?php echo $unit_area; ?></td>
                                             </tr>
                                             <tr>
                                                <th>Unit Rate</th>
                                                <td>Rs.<?php echo $unit_rate; ?> / sq area</td>
                                             </tr>
                                             <tr>
                                                <th>Unit Cost</th>
                                                <td><span>Rs.<?php echo $unit_cost; ?></span></td>
                                             </tr>
                                             <?php if ($charges != 0) { ?>
                                                <tr>
                                                   <th>Charges <span class="text-grey fs-11 m-l-5"><?php echo $chargename; ?> ( <?php echo $charges; ?>% )</span></th>
                                                   <td>+ Rs.<?php echo $unit_cost / 100 * $charges; ?></td>
                                                </tr>
                                             <?php } ?>
                                             <?php if ($discount != 0) { ?>
                                                <tr>
                                                   <th>Discount <span class="text-grey fs-11 m-l-5"><?php echo $discountname; ?> ( Rs.<?php echo $discount;  ?> )</span></th>
                                                   <td>- Rs.<?php echo $unit_area_in_numbers * $discount; ?></td>
                                                </tr>
                                             <?php } ?>
                                             <tr>
                                                <th>Net Payable Amount</th>
                                                <td><span class="text-success fs-14">Rs.<?php echo $net_payable_amount; ?></span></td>
                                             </tr>
                                          </table>

                                          <a href="<?php echo DOMAIN; ?>/admin/payments/emi-payments/emi-pay.php?bid=<?php echo $bookingid; ?>&emi_id=<?php echo $emi_id; ?>" class="btn btn-lg btn-block btn-success p-2"><i class="fa fa-plus"></i> Receive Payments</a>
                                       </div>
                                 <?php }
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


         <?php include '../payment-popup.php'; ?>

         <!-- end -->
         <?php include '../../sidebar.php'; ?>
         <?php include '../../footer.php'; ?>
      </div>

      <?php include '../../../include/footer_files.php'; ?>

      <script>
         function PaymentMode(data) {
            if (data == "cash") {
               document.getElementById("cash").style.display = "block";
               document.getElementById("check").style.display = "none";
               document.getElementById("banking").style.display = "none";
            } else if (data == "check") {
               document.getElementById("cash").style.display = "none";
               document.getElementById("check").style.display = "block";
               document.getElementById("banking").style.display = "none";
            } else if (data == "banking") {
               document.getElementById("cash").style.display = "none";
               document.getElementById("check").style.display = "none";
               document.getElementById("banking").style.display = "block";
            } else {
               document.getElementById("cash").style.display = "block";
               document.getElementById("check").style.display = "none";
               document.getElementById("banking").style.display = "none";
            }
         }
      </script>

      <script>
         function getpaidamount() {
            document.getElementById("cashamount").value = document.getElementById("paidamount").value;
            document.getElementById("netpaidamount").innerHTML = document.getElementById("paidamount").value;
            document.getElementById("net_payable").value = document.getElementById("paidamount").value;
         }
      </script>

      <script>
         function chargesCalcu() {
            var chargevalue = document.getElementById("chargevalue").value;
            var chargeshow = document.getElementById("chargeshow");
            var net_payable = document.getElementById("net_payable").value;
            var unit_cost = document.getElementById("paidamount").value;
            var chargename = document.getElementById("chargename").value;
            var discountvalue = document.getElementById("discountvalue").value;
            var discountshow = document.getElementById("discountshow");
            var discountname = document.getElementById("discountname").value;

            if (chargevalue > 0 || discountvalue > 0) {
               chargeshow.style.display = "block";

               if (discountvalue > 0) {
                  discountshow.style.display = "block";
                  discountamount = Math.round(unit_cost / 100 * discountvalue);
                  discountableamount = +unit_cost - +discountamount;
                  discountshow.innerHTML = discountname + " (" + discountvalue + "%) : <b> - Rs." + discountamount + "</b>";
                  discountname.value = discountname;
                  chargeableamount = Math.round(unit_cost / 100 * chargevalue);
                  new_net_payable = (+unit_cost + +chargeableamount) - +discountamount;

                  document.getElementById("net_payable").value = new_net_payable;
                  chargeshow.innerHTML = chargename + " (" + chargevalue + "%): <b> + Rs." + chargeableamount + "</b>";

                  document.getElementById("netpaidamount").innerHTML = new_net_payable;
                  document.getElementById("paidamount").innerHTML = unit_cost;
                  chargename.value = chargename;

               } else {
                  discountshow.style.display = "none";
                  discountableamount = 0;
                  chargename.value = "";
                  discountname.value = "";
                  chargeableamount = Math.round(unit_cost / 100 * chargevalue);
                  new_net_payable = +unit_cost + +chargeableamount;

                  document.getElementById("net_payable").value = new_net_payable;
                  chargeshow.innerHTML = chargename + " (" + chargevalue + "%): <b> + Rs." + chargeableamount + "</b>";

                  document.getElementById("netpaidamount").innerHTML = new_net_payable;
                  document.getElementById("paidamount").innerHTML = unit_cost;
                  chargename.value = chargename;

               }

            } else {
               chargeshow.style.display = "none";
               discountshow.style.display = "none";

               document.getElementById("net_payable").value = unit_cost;
               document.getElementById("netpaidamount").innerHTML = unit_cost;
               document.getElementById("paidamount").innerHTML = unit_cost;
               chargename.value = "";
               discountname.value = "";
            }

            if (discountvalue > 0) {
               discountshow.style.display = "block";
            } else if (discountvalue == 0) {
               discountshow.style.display = "none";
            } else {
               discountshow.style.display = "none";
            }

            if (chargevalue > 0) {
               chargeshow.style.display = "block";
            } else if (chargevalue == 0) {
               chargeshow.style.display = "none";
            } else {
               chargeshow.style.display = "none";
            }
         }
      </script>

</body>

</html>
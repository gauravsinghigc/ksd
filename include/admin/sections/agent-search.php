 <?php
  if (isset($_GET['search_value'])) {
    if ($_GET['search_value'] != null || $_GET['search_value'] != "") {
      $search_type = $_GET['search_type'];
      $search_value = $_GET['search_value'];
      $Sql = "SELECT * FROM users where $search_type like '%$search_value%'";
      $SearchSql = FetchConvertIntoArray($Sql, true);
      $Check = CHECK($Sql);
      if ($Check == null) {
  ?>
       <div class="col-md-12">
         <h3>No Agents Found</h3>
         <p>No Agents fround from <b><?php echo $search_type; ?></b> having value <b><?php echo $search_value; ?></b>. Please try to add this customer by clicking below button.</p>
         <a class="btn btn-primary square btn-labeled fa fa-plus" data-toggle="modal" data-target="#add_data">Add New Agent</a>
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

          if (isset($_GET['partner_id'])) {
            if ($Customer->id == $_GET['partner_id']) {
              $selected = "btn-danger";
              $text = "<i class='fa fa-check'></i> Selected";
            } else {
              $selected = "btn-success";
              $text = "Select & Continue";
            }
          } else {
            $selected = "btn-success";
            $text = "Select & Continue";
          }
        ?>
         <div class="col-md-12 m-b-15">
           <div class="row shadow-lg rounded-3 p-1 fs-12 p-b-10">
             <div class="col-md-2">
               <img src="<?php echo $customer_user_profile_img; ?>" class="img-fluid m-t-35">
             </div>
             <div class="col-md-10">
               <h4 class="bold black"><?php echo $Customer->name; ?> <?php echo $Customer->father_name; ?> <small class="text-grey"> | AGENT00<?php echo $Customer->id; ?></small></h4>
               <p class="m-t-3">
                 <span>
                   <b>
                     <?php $user_role_id = $Customer->user_role_id;
                      echo UpperCase(FETCH("select * from user_roles where role_id='$user_role_id'", "role_name")); ?> | </b>
                   <?php echo $Customer->phone; ?></span><br>
                 <span><?php echo $Customer->email; ?></span><br>
                 <?php
                  if (CHECK($AddSql) != null) {
                    foreach ($AddressSql as $Address) {
                      $user_address_id = $Address->user_address_id; ?>
                     <span><i class="fa fa-map-marker text-success"></i> <?php echo $Address->user_street_address; ?> <?php echo $Address->user_area_locality; ?> <?php echo $Address->user_city; ?> <?php echo $Address->user_state; ?> <?php echo $Address->user_country; ?> - <?php echo $Address->user_pincode; ?></span>
                 <?php }
                  } ?>
               </p>
               <hr class="m-b-5 m-t-0">
               <a href="#" class="btn btn-sm btn-default" data-toggle="modal" data-target="#edit_customer_<?php echo $executedcustomer_id; ?>"><i class='fa fa-edit'></i> Edit Details</a>
               <a href="<?php echo RUNNING_URL; ?>&partner_id=<?php echo $Customer->id; ?>" class="btn btn-sm <?php echo $selected; ?>"><?php echo $text; ?></a>
             </div>
             <br>
           </div>
         </div>

         <div class="modal fade square" id="edit_customer_<?php echo $executedcustomer_id; ?>" role="dialog">
           <div class="modal-dialog modal-lg">
             <div class="modal-content">
               <div class="modal-header app-bg text-white">
                 <button type="button" class="close text-white m-r-8 m-t-1" data-dismiss="modal">&times;</button>
                 <h4 class="modal-title text-white">Edit Agent Details</h4>
               </div>
               <div class="modal-body overflow-auto">
                 <form action="../../../../../controller/usercontroller.php" method="POST">
                   <?php FormPrimaryInputs(true, [
                      "user_country" => "India",
                      "customer_id" => $executedcustomer_id,
                      "agent_relation" => 0,
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
                          $getuserroles = SELECT("SELECT * FROM user_roles where role_id='$user_role_id'");
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
  } else {  ?>
   <h3>Search Agents</h3>
   <p>You can search or add agents from here without creating agents first, if your need then you can create agents here too.</p>
   <a class="btn btn-primary square btn-labeled fa fa-plus" data-toggle="modal" data-target="#add_data">Add New Agent</a>
 <?php } ?>
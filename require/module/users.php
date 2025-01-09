<?php
//get user address 
function UserAddress($CustomerId)
{
  $UserStreetAddress = FETCH("SELECT * FROM user_addresses where UserAddressUserId='$CustomerId'", "UserStreetAddress");
  $UserLocality = FETCH("SELECT * FROM user_addresses where UserAddressUserId='$CustomerId'", "UserLocality");
  $UserCity = FETCH("SELECT * FROM user_addresses where UserAddressUserId='$CustomerId'", "UserCity");
  $UserState = FETCH("SELECT * FROM user_addresses where UserAddressUserId='$CustomerId'", "UserState");
  $UserCountry = FETCH("SELECT * FROM user_addresses where UserAddressUserId='$CustomerId'", "UserCountry");
  $UserPincode = FETCH("SELECT * FROM user_addresses where UserAddressUserId='$CustomerId'", "UserPincode");
  $UserAddressType = FETCH("SELECT * FROM user_addresses where UserAddressUserId='$CustomerId'", "UserAddressType");

  $CompleteAddress = "($UserAddressType)<br>$UserStreetAddress $UserLocality $UserCity $UserState $UserCountry $UserPincode";

  return $CompleteAddress;
}

//user salutation 
define("SALUTATION", array("Mr.", "Mrs.", "Miss", "M/s", "Prof", "Dr."));

//function 
function UserDetails($UserId)
{
  $Sql = "SELECT * FROM users where id='$UserId'";
  $SearchSql = FetchConvertIntoArray($Sql, true);
  if ($SearchSql != null) {
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
          </div>
        </div>
      </div>
<?php
    }
  } else {
    NoData("No User Found!");
  }
}

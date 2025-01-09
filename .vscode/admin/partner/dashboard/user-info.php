<div class="col-md-12">
 <h3 class="m-t-3"><i class="fa fa-user app-text"></i> Agent Details</h3>
</div>
<div class="col-md-12">
 <div class="userWidget-1 m-b-0">
  <div class="avatar app-bg">
   <img src="<?php echo $C_user_profile_img; ?>" alt="avatar">
   <div class="name osLight fs-20 p-b-2"> <?php echo $C_name ?> </div>
  </div>
  <div class="title text-uppercase"> <?php echo $C_role_name ?> ID : 000<?php echo $ViewCustomerId; ?> </div>
  <div class="address p-b-10 p-t-5">
   <p class="text-grey fs-14 p-l-0 m-l-0">
    <span><i class="fa fa-phone fs-14 text-info p-0"></i> : <?php echo $C_phone; ?></span> &nbsp; &nbsp;|
    <span><i class="fa fa-envelope fs-14 text-danger p-0"></i> : <?php echo $C_email; ?></span><br>
    <span><i class="fa fa-map-marker fs-14 text-success p-0"></i> : <?php echo "$C_user_street_address, $C_user_area_locality, $C_user_city $C_user_state - $C_user_country $C_user_pincode"; ?></span><br>
   </p>
  </div>
  <div class="clearfix"> </div>
 </div>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xs-12 m-b-0">
 <?php include "counter.php"; ?>
</div>
<?php include "c-nav.php"; ?>
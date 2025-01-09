<?php
require '../../require/modules.php';
require "../../require/admin/sessionvariables.php";
require '../../include/admin/common.php';


$PageName = "Add Enquiries/Walkins";
?>
<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <title><?php echo $PageName; ?> | <?php echo $company_name; ?></title>
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
           <h3 class="m-t-3"><i class="fa fa-info-circle app-text"></i> Add New Walk-in / Visitings</h3>
          </div>
          <div class="col-lg-12 col-md-12 col-12 col-sm-12">
           <h4>Person Details</h4>
           <form class="form row" action="../../controller/enquirycontroller.php" method="POST">
            <input type="text" name="access_url" value="../admin/enquiries/add-enquiry.php" hidden="">
            <div class="form-group col-md-6 col-lg-6 col-sm-6 col-12">
             <label>Person Full Name</label>
             <input name="WalkinName" type="text" class="form-control" required="">
            </div>
            <div class="form-group col-md-6 col-lg-6 col-sm-6 col-12">
             <label>Phone Number</label>
             <input name="WalkinPhone" type="phone" class="form-control" required="">
            </div>
            <div class="form-group col-md-6 col-lg-6 col-sm-6 col-12">
             <label>Email Id</label>
             <input name="WalkinEmailid" type="email" class="form-control">
            </div>
            <div class="form-group col-md-6 col-lg-6 col-sm-6 col-12">
             <label>Walkin Purpose</label>
             <select name="WalkinTypes" class="form-control" required="">
              <option value="Fresh">Fresh</option>
              <option value="Enquiry">Enquiry</option>
              <option value="Services">Services</option>
              <option value="Payments">Payments</option>
              <option value="SiteVisits">Site Visits</option>
              <option value="Meetings">Meetings</option>
              <option value="Marketings">Marketing</option>
              <option value="Technical & IT's">Technical & IT's</option>
              <option value="Maintenance">Maintenance</option>
              <option value="Courier">Courier</option>
              <option value="Purchase">Purchase</option>
              <option value="Informative">Informative</option>
             </select>
            </div>
            <div class="form-group col-md-6 col-lg-6 col-sm-6 col-12">
             <label>Address/Location</label>
             <textarea name="WalkinAddress" type="text" rows="3" class="form-control"></textarea>
            </div>
            <div class="form-group col-md-6 col-lg-6 col-sm-6 col-12">
             <label>Notes/Remarks</label>
             <textarea name="WalkinsRemarks" type="text" rows="3" class="form-control"></textarea>
            </div>
            <div class="col-md-12 col-lg-12 col-sm-12 col-12">
             <button class="btn btn-md btn-success" name="SaveWalkins">Save Walkins</button>
             <a class="btn btn-danger btn-md square btn-labeled fa fa-angle-left" href="index.php"> Back to All</a>
            </div>
           </form>
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
<?php
$Dir = "../../..";
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';

//pagevariables
$PageName = "Edit Deal Details";
$PageDescription = "Manage all leads";

if (isset($_GET['dealsid'])) {
 $_SESSION['REQ_LeadsId'] = SECURE($_GET['dealsid'], "d");
 $REQ_LeadsId = $_SESSION['REQ_LeadsId'];
} else {
 $REQ_LeadsId = $_SESSION['REQ_LeadsId'];
}

$PageSqls = "SELECT * FROM leads where LeadsId='$REQ_LeadsId'";

?>
<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="utf-8" />
 <title><?php echo $PageName; ?> | <?php echo APP_NAME; ?></title>
 <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
 <meta name="keywords" content="<?php echo APP_NAME; ?>">
 <meta name="description" content="<?php echo SHORT_DESCRIPTION; ?>">
 <?php include '../../../include/header_files.php'; ?>
 <script type="text/javascript">
  function SidebarActive() {
   document.getElementById("leads").classList.add("active");
   document.getElementById("all_leads").classList.add("active");
  }
  window.onload = SidebarActive;
 </script>
</head>

<body class='pace-top'>
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

        <d class="panel-body">
         <div class="row">
          <div class="col-md-12 m-b-10">
           <h3 class="m-t-3 m-b-10"><i class="fa fa-phone app-text"></i> <?php echo $PageName; ?> : <small><?php echo LEADID($REQ_LeadsId); ?></small>
           </h3>
          </div>
         </div>

         <form action="<?php echo CONTROLLER; ?>/leads.php" method="POST">
          <?php FormPrimaryInputs(true); ?>
          <div class="row">
           <div class="col-md-7">
            <h4 class="app-heading"><?php echo FETCH($PageSqls, "LeadPersonFullname"); ?> : <?php echo LEADID($REQ_LeadsId); ?></h4>
            <div class="row mb-5px">
             <div class="form-group col-md-3">
              <label>Salutation</label>
              <select name="LeadSalutations" class="form-control">
               <?php InputOptions(["Mr.", "Mrs.", "Miss.", "Ms.", "Dr.", "Prof.", "Sir"], FETCH($PageSqls, "LeadSalutations")); ?>
              </select>
             </div>
             <div class="form-group col-md-9">
              <label>Full Name</label>
              <input type="text" name="LeadPersonFullname" value="<?php echo FETCH($PageSqls, "LeadPersonFullname"); ?>" list="LeadPersonFullname" class="form-control" placeholder="Gaurav Singh" required="">
              <?php SUGGEST("leads", "LeadPersonFullname", "ASC") ?>
             </div>
            </div>

            <div class="row mb-5px">
             <div class="form-group col-md-5">
              <label>Phone Number</label>
              <input type="phone" name="LeadPersonPhoneNumber" value="<?php echo FETCH($PageSqls, "LeadPersonPhoneNumber"); ?>" list="LeadPersonPhoneNumber" placeholder="without +91" class="form-control" required="">
              <?php SUGGEST("leads", "LeadPersonPhoneNumber", "ASC") ?>
             </div>
             <div class="form-group col-md-7">
              <label>Email</label>
              <input type="email" name="LeadPersonEmailId" value="<?php echo FETCH($PageSqls, "LeadPersonEmailId"); ?>" list="LeadPersonEmailId" class="form-control" placeholder="example@domain.tld">
              <?php SUGGEST("leads", "LeadPersonEmailId", "ASC") ?>
             </div>
            </div>
            <div class="row mb-5px">
             <div class="form-group col-md-6">
              <label>Company Name</label>
              <input type="phone" name="LeadPersonCompanyName" value="<?php echo FETCH($PageSqls, "LeadPersonCompanyName"); ?>" list="LeadPersonCompanyName" placeholder="ABC PVT LTD" class="form-control">
              <?php SUGGEST("leads", "LeadPersonCompanyName", "ASC") ?>
             </div>
             <div class="form-group col-md-6">
              <label>Company Work Type</label>
              <input type="text" name="LeadPersonCompanyType" value="<?php echo FETCH($PageSqls, "LeadPersonCompanyType"); ?>" list="LeadPersonCompanyType" class="form-control" placeholder="electronic, garments, services">
              <?php SUGGEST("leads", "LeadPersonCompanyType", "ASC") ?>
             </div>
            </div>
            <div class="row mb-5px">
             <div class="form-group col-md-6">
              <label>Company Domain</label>
              <input type="domain" name="" list="LeadPersonCompanyDomain" value="<?php echo FETCH($PageSqls, "LeadPersonFullname"); ?>" placeholder="abc.com" class="form-control">
              <?php SUGGEST("leads", "LeadPersonCompanyDomain", "ASC") ?>
             </div>
             <div class="form-group col-md-3">
              <label>Lead Stage </label>
              <select class="form-control" name="LeadPersonStatus">
               <?php
               foreach (LEAD_STAGES as $key => $lstages) {
                if ($key == FETCH($PageSqls, "LeadPersonStatus")) {
                 $selected = "selected";
                } else {
                 $selected = "";
                }
                echo '<option value="' . $key . '" ' . $selected . '>' . $lstages . '</option>';
               } ?>
              </select>
             </div>
             <div class="form-group col-md-3">
              <label>Lead Priority level </label>
              <select class="form-control" name="LeadPriorityLevel">
               <?php InputOptions(["Low", "Average", "High"], FETCH($PageSqls, "LeadSalutations")); ?>
              </select>
             </div>
            </div>
            <div class="row mb-5px">
             <div class="form-group col-md-12">
              <label>Address</label>
              <textarea name="LeadPersonAddress" row="3" class="form-control" placeholder="Address"><?php echo FETCH($PageSqls, "LeadPersonAddress"); ?></textarea>
             </div>
            </div>

            <div class="row mb-5px">
             <div class="form-group col-md-6">
              <label>Lead Created By</label>
              <select class="form-control" name="LeadPersonCreatedBy">
               <?php
               $Users = FetchConvertIntoArray("SELECT * FROM users ORDER BY name ASC", true);
               foreach ($Users as $User) {
                if ($User->id == FETCH($PageSqls, "LeadPersonCreatedBy")) {
                 $selected = "selected";
                } else {
                 $selected = "";
                }
                echo "<option value='" . $User->id . "' $selected>" . $User->name . " @ " . $User->phone . "</option>";
               }
               ?>
              </select>
             </div>
             <div class="form-group col-md-6">
              <label>Lead Assigned To</label>
              <select class="form-control" name="LeadPersonManagedBy">
               <?php
               $Users = FetchConvertIntoArray("SELECT * FROM users ORDER BY name ASC", true);
               foreach ($Users as $User) {
                if ($User->id == FETCH($PageSqls, "LeadPersonManagedBy")) {
                 $selected = "selected";
                } else {
                 $selected = "";
                }
                echo "<option value='" . $User->id . "' $selected>" . $User->name . " @ " . $User->phone . "</option>";
               }
               ?>
              </select>
             </div>
            </div>

            <div class="row mb-5px">
             <div class="form-group col-md-12">
              <label>Notes/Remarks</label>
              <textarea name="LeadPersonNotes" class="form-control" rows="3"><?php echo SECURE(FETCH($PageSqls, "LeadPersonNotes"), "d"); ?></textarea>
             </div>
            </div>

            <div class="row mb-5px">
             <div class="col-md-12">
              <a href="index.php" class="btn btn-lg btn-default" value="<?php echo SECURE($REQ_LeadsId, "e"); ?>"><i class="fa fa-angle-double-left"></i> Back To Details</a>
              <button class="btn btn-lg btn-success mt-4" name="UpdateLeads" value="<?php echo SECURE($REQ_LeadsId, "e"); ?>" TYPE="submit">Update Lead Details</button>
             </div>
            </div>
           </div>
          </div>
         </form>
         <script>
          function CheckCallStatus() {
           var call_status = $("#call_status").val();
           if (call_status == "FollowUp") {
            $("#call_reminder").removeClass("hidden");
           } else {
            $("#call_reminder").addClass("hidden");
           }
          }
         </script>
         <script>
          function GetExpireDate() {
           var date = document.getElementById("purchasedate").value;
           var period = document.getElementById("purchaseperiod").value;
           var expire = new Date(date);
           expire.setFullYear(expire.getFullYear() + parseInt(period));
           document.getElementById("expiredate").value = expire.toISOString().substring(0, 10);
          }

          function DomainPreview() {
           var domain = document.getElementById("domain").value;
           document.getElementById("domain_preview").src = "https://www.whois.com/whois/" + domain;
          }
         </script>

       </div>
      </div>
     </div>
    </div>
   </div>
  </div>
  <!-- end -->
  <?php include '../../sidebar.php'; ?>
  <?php include '../../footer.php'; ?>
 </div>

 <?php include '../../../include/footer_files.php'; ?>

</body>

</html>
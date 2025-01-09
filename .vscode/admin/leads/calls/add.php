<?php
$Dir = "../../..";
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';
//pagevariables
$PageName = "ADD New Domain";
$PageDescription = "Manage all domains";
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
   document.getElementById("lead_add_calls").classList.add("active");
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

        <div class="panel-body">
         <div class="row">
          <div class="col-md-12 m-b-10">
           <h3 class="m-t-3 m-b-10"><i class="fa fa-phone app-text"></i> <?php echo $PageName; ?>
           </h3>
          </div>
         </div>

         <form action="<?php echo CONTROLLER; ?>/domains.php" method="POST">
          <?php FormPrimaryInputs(true); ?>
          <div class="row">
           <div class="col-md-6">
            <h4 class="app-heading">New Domain Details</h4>
            <div class="row mb-10px">
             <div class="form-group col-md-12">
              <label>Select Users/Owner</label>
              <select class="form-control" name="DomainUserId">
               <?php
               $Users = FetchConvertIntoArray("SELECT * FROM users ORDER BY UserFullName ASC", true);
               foreach ($Users as $User) {
                echo "<option value='" . $User->UserId . "'>" . $User->UserFullName . " (" . $User->UserDesignation . ") " . " @  " . $User->UserPhoneNumber . " - " . $User->UserCompanyName . "</option>";
               }
               ?>
              </select>
             </div>
            </div>
            <div class="row mb-10px">
             <div class="form-group col-md-8">
              <label>Domain Name</label>
              <input type="domain" oninput="DomainPreview()" id="domain" name="DomainName" class="form-control" placeholder="example.com" required="">
             </div>
             <div class="form-group col-md-4">
              <label>Domain Provider</label>
              <input type="text" name="DomainProvider" placeholder="Godaddy, Hostinger" list="DomainProvider" class="form-control" required="">
              <?php SUGGEST("domains", "DomainProvider", "ASC"); ?>
             </div>
            </div>

            <div class="row mb-10px">
             <div class="form-group col-md-6">
              <label>Purchase Date</label>
              <input type="date" id="purchasedate" value="<?php echo date("Y-m-d"); ?>" name="DomainPurchaseDate" class="form-control" required="">
             </div>
             <div class="form-group col-md-6">
              <label>Buy Period (in Years)</label>
              <select class="form-control" id="purchaseperiod" onchange="GetExpireDate()" name="DomainPurchasePeriod" required="">
               <?php
               $start = 0;
               while ($start <= 12) {
                $start++; ?>
                <option value="<?php echo $start; ?>"><?php echo $start; ?> Year</option>
               <?php } ?>
              </select>
             </div>
             <div class="form-group col-md-6">
              <label>Domain Expire Date</label>
              <input type="date" id="expiredate" value="<?php echo date("Y-m-d", strtotime("+365 days")); ?>" name="DomainExpireDate" class="form-control" required="">
             </div>
             <div class="form-group col-md-6">
              <label>Remind me Before (in Days)</label>
              <select name="DomainRenewReminderDate" class="form-control">
               <?php InputOptions(["5", "10", "15", "20", "25", "30"], "10"); ?>
              </select>
             </div>
            </div>
            <div class="row mb-10px">
             <div class="form-group col-md-4">
              <label>Domain Status</label>
              <select class="form-control" name="DomainStatus">
               <option value="1">Active</option>
               <option value="2">Inactive</option>
               <option value="3">Expired</option>
              </select>
             </div>
             <div class="form-group col-md-8">
              <label>Domain Category</label>
              <input type="text" name="DomainServiceCategory" placeholder="electronics, ecommerce, interior, book" list="DomainServiceCategory" class="form-control">
              <?php SUGGEST("domains", "DomainServiceCategory", "ASC"); ?>
             </div>
            </div>

            <div class="row mb-10px">
             <div class="form-group col-md-9">
              <label>Domain Provider Url</label>
              <input type="url" name="DomainProviderUrl" placeholder="http://" list="DomainProviderUrl" class="form-control">
              <?php SUGGEST("domains", "DomainProviderUrl", "ASC"); ?>
             </div>
             <div class="form-group col-md-3">
              <label>Domain Price</label>
              <input type="price" name="DomainPrice" placeholder="Rs.529" list="DomainPrice" class="form-control">
              <?php SUGGEST("domains", "DomainPrice", "ASC"); ?>
             </div>
            </div>

            <div class="row mb-10px">
             <div class="form-group col-md-12">
              <label>Domain Notes</label>
              <textarea name="DomainDescription" class="form-control editor" rows="5"></textarea>
             </div>
            </div>

            <div class="row mb-10px">
             <div class="form-group col-md-6">
              <label>Nameserver 1</label>
              <input type="text" name="DomainNameServer1" list="DomainNameServer1" class="form-control">
              <?php SUGGEST("domain_nameservers", "DomainNameServer1", "ASC"); ?>
             </div>
             <div class="form-group col-md-6">
              <label>Nameserver 2</label>
              <input type="text" name="DomainNameServer2" list="DomainNameServer2" class="form-control">
              <?php SUGGEST("domain_nameservers", "DomainNameServer2", "ASC"); ?>
             </div>
            </div>

            <div class="row mb-20px">
             <div class="col-md-12">
              <button class="btn btn-md btn-success" name="CreateDomains" TYPE="submit">Create Domain Record</button>
             </div>
            </div>
           </div>
           <div class="col-md-6">
            <div class="app-heading flex-s-b">
             <h4 class="mb-0 mt-0">Domain Preview</h4>
            </div>
            <div class="mt-10">
             <iframe src=" http://localhost/projects/navixcrm/admin/domains/add.php" id="domain_preview" class="domain-preview"></iframe>
            </div>
           </div>
          </div>
         </form>
        </div>
       </div>
      </div>
     </div>
    </div>
   </div>
  </div>

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

  <!-- end -->
  <?php include '../../sidebar.php'; ?>
  <?php include '../../footer.php'; ?>
 </div>

 <?php include '../../../include/footer_files.php'; ?>

</body>

</html>
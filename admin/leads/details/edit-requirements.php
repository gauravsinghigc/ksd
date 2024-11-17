<?php
$Dir = "../../..";
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';

//pagevariables
$PageName = "Edit Deal Requirements";
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

                                                <div class="panel-body">
                                                      <div class="row">
                                                            <div class="col-md-12 m-b-10">
                                                                  <h3 class="m-t-3 m-b-10"><i class="fa fa-phone app-text"></i>
                                                                        <?php echo $PageName; ?> :
                                                                        <small><?php echo LEADID($REQ_LeadsId); ?></small>
                                                                  </h3>
                                                            </div>
                                                      </div>

                                                      <form action="<?php echo CONTROLLER; ?>/leads.php" method="POST">
                                                            <?php FormPrimaryInputs(true); ?>
                                                            <div class="row">
                                                                  <div class="col-md-12">
                                                                        <h4 class="app-heading">
                                                                              <?php echo FETCH($PageSqls, "LeadPersonFullname"); ?>
                                                                              : <?php echo LEADID($REQ_LeadsId); ?></h4>
                                                                        <div class="row mb-5px pt-3">
                                                                              <div class="col-md-6">
                                                                                    <h5 class="bg-info p-2 rounded-1 text-white">
                                                                                          Add New Requirements</h5>
                                                                                    <table class="table table-striped" id="example">
                                                                                          <?php

                                                                                          $SqlProjects = "SELECT * FROM project_units, Projects where Projects.Projects_id=project_units.project_id and project_units.project_unit_status='ACTIVE'";
                                                                                          $TotalProjectUnits = TOTAL("$SqlProjects");
                                                                                          $GetProjectNames = FetchConvertIntoArray("$SqlProjects", true);
                                                                                          foreach ($GetProjectNames as $List) {
                                                                                                echo "
                                  <tr>
                                  <td>
                                  <input class='form-check-input checkbox-list' type='checkbox' name='LeadRequirementDetails[]' value='" . $List->project_units_id . "'> 
              </td>
              <td>
                  <h5 class='form-check-label text-grey p-1 m-b-0 m-t-0'><span class='text-primary'>" . $List->projects_unit_name . " (" . $List->project_unit_area . " " . $List->project_unit_measurement_unit . ") </span> - Rs." . $List->unit_per_price . "/" . $List->project_unit_measurement_unit . " @ Rs." . $List->project_unit_price . "<b> - " . $List->project_title . "</b></h5>
                  </td>
                  </tr>
                ";
                                                                                          }
                                                                                          ?>
                                                                                    </table>

                                                                                    <button class="btn btn-sm btn-success mt-4" name="UpdateLeadRequirements" value="<?php echo SECURE($REQ_LeadsId, "e"); ?>" TYPE="submit">Save New
                                                                                          Requirements</button>

                                                                              </div>
                                                                              <div class="col-md-6">
                                                                                    <h5 class="bg-info p-2 rounded-1 text-white">
                                                                                          Remove Old Requirements</h5>
                                                                                    <ul class="pl-0">
                                                                                          <?php
                                                                                          $FetchRequiements = FetchConvertIntoArray("SELECT * FROM lead_requirements where LeadMainId='$REQ_LeadsId'", true);
                                                                                          if ($FetchRequiements != null) {

                                                                                                foreach ($FetchRequiements as $Req) {
                                                                                                      $SqlProjectUnits = "SELECT * FROM project_units where project_units_id='" . $Req->LeadRequirementDetails . "'";
                                                                                                      $ProjectID = FETCH($SqlProjectUnits, "project_id");
                                                                                                      $Sqlprojects = "SELECT * FROM projects where Projects_id='$ProjectID'";
                                                                                                      CONFIRM_DELETE_POPUP(
                                                                                                            "LeadReq",
                                                                                                            [
                                                                                                                  "delete_lead_requirements" => true,
                                                                                                                  "control_id" => $Req->LeadRequirementID
                                                                                                            ],
                                                                                                            "leads",
                                                                                                            "<i class='fa fa-trash'></i> Remove",
                                                                                                            "btn btn-xs btn-danger pull-right m-t-10"
                                                                                                      );
                                                                                          ?>
                                                                                                      <h5 class='form-check-label text-grey p-1 m-b-0 m-t-0'><i class="fa fa-check-circle text-success"></i>
                                                                                                            <b class="text-info"><?php echo FETCH($Sqlprojects, "project_title"); ?></b><br>
                                                                                                            <span class='text-primary'>
                                                                                                                  <b><?php echo strtoupper(FETCH($SqlProjectUnits, "projects_unit_name")); ?></b>
                                                                                                            </span> - <?php echo FETCH($SqlProjectUnits, "project_unit_area"); ?> <?php echo FETCH($SqlProjectUnits, "project_unit_measurement_unit"); ?> - <span class="text-warning"><?php echo FETCH($SqlProjectUnits, "project_unit_status"); ?></span><br>
                                                                                                            (Rs.<?php echo FETCH($SqlProjectUnits, "unit_per_price"); ?>/<?php echo FETCH($SqlProjectUnits, "project_unit_measurement_unit"); ?>)<br> @
                                                                                                            <span class="text-success"> <b>Rs.<?php echo FETCH($SqlProjectUnits, "project_unit_price"); ?></b></span>
                                                                                                <?php

                                                                                                      echo "</h5>";
                                                                                                }
                                                                                          } else {
                                                                                                echo "<span class='inline-list'>
          <h1><i class='fa fa-warning fs-1 text-warning mt-3'></i></h1>
          <h4>No Requirement Found!</h4>
          <p>Please add some requirements, then it will be display here...</p>
          </span>";
                                                                                          } ?>
                                                                                    </ul>
                                                                              </div>
                                                                        </div>

                                                                        <div class="row mb-5px">
                                                                              <div class="col-md-12">
                                                                                    <a href="index.php" class="btn btn-sm btn-default" value="<?php echo SECURE($REQ_LeadsId, "e"); ?>"><i class="fa fa-angle-double-left"></i>
                                                                                          Back To Details</a>
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
            </div>

            <!-- end -->
            <?php include '../../sidebar.php'; ?>
            <?php include '../../footer.php'; ?>
      </div>

      <?php include '../../../include/footer_files.php'; ?>

</body>

</html>
</body>

</html>
<?php
require '../../require/modules.php';
require "../../require/admin/sessionvariables.php";
require '../../include/admin/common.php';

//pagevariables
$PageName = "ADD New Lead";
$PageDescription = "Manage all leads";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title><?php echo $PageName; ?> | <?php echo APP_NAME; ?></title>
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
  <meta name="keywords" content="<?php echo APP_NAME; ?>">
  <meta name="description" content="<?php echo SHORT_DESCRIPTION; ?>">
  <?php include '../../include/header_files.php'; ?>
  <script type="text/javascript">
    function SidebarActive() {
      document.getElementById("leads").classList.add("active");
      document.getElementById("leads_add").classList.add("active");
    }
    window.onload = SidebarActive;
  </script>
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
                    <div class="col-md-12 m-b-10">
                      <h3 class="m-t-3 m-b-10"><i class="fa fa-phone app-text"></i> <?php echo $PageName; ?></h3>
                    </div>
                  </div>
                  <form action="<?php echo CONTROLLER; ?>/leads.php" method="POST">
                    <?php FormPrimaryInputs(true); ?>
                    <div class="row">
                      <div class="col-md-6">
                        <h4 class="section-heading m-t-0">New Lead Details</h4>
                        <div class="row mb-5px">
                          <div class="form-group col-md-3">
                            <label>Salutation</label>
                            <select name="LeadSalutations" class="form-control">
                              <option value="Mr." selected>Mr</option>
                              <option value="Mrs.">Mrs</option>
                              <option value="Miss.">Miss</option>
                              <option value="Ms.">Ms</option>
                              <option value="Dr.">Dr</option>
                              <option value="Prof.">Prof</option>
                              <option value="Sir.">Sir</option>
                            </select>
                          </div>
                          <div class="form-group col-md-9">
                            <label>Full Name</label>
                            <input type="text" name="LeadPersonFullname" list="LeadPersonFullname" class="form-control" placeholder="Gaurav Singh" required="">
                            <?php SUGGEST("leads", "LeadPersonFullname", "ASC") ?>
                          </div>
                        </div>

                        <div class="row mb-5px">
                          <div class="form-group col-md-5">
                            <label>Phone Number</label>
                            <input type="phone" name="LeadPersonPhoneNumber" list="LeadPersonPhoneNumber" placeholder="without +91" class="form-control" required="">
                            <?php SUGGEST("leads", "LeadPersonPhoneNumber", "ASC") ?>
                          </div>
                          <div class="form-group col-md-7">
                            <label>Email</label>
                            <input type="email" name="LeadPersonEmailId" list="LeadPersonEmailId" class="form-control" placeholder="example@domain.tld">
                            <?php SUGGEST("leads", "LeadPersonEmailId", "ASC") ?>
                          </div>
                        </div>
                        <div class="row mb-5px">
                          <div class="col-md-6 form-group">
                            <label>Work Profile/Working As</label>
                            <input type="text" name="LeadPersonCompanyName" list="LeadPersonCompanyName" class="form-control" placeholder="Lawyer, Doctor, Engineer" required="">
                            <?php SUGGEST("leads", "LeadPersonCompanyName", "ASC") ?>
                          </div>
                          <div class="col-md-6 form-group">
                            <label>Company Name</label>
                            <input type="text" name="LeadPersonCompanyType" list="LeadPersonCompanyType" class="form-control" placeholder="Abc Pvt Ltd" required="">
                            <?php SUGGEST("leads", "LeadPersonCompanyType", "ASC") ?>
                          </div>
                        </div>
                        <div class="row mb-5px">
                          <div class="form-group col-md-4">
                            <label>Lead Stage </label>
                            <select class="form-control" name="LeadPersonStatus">
                              <?php
                              foreach (LEAD_STAGES as $key => $lstages) {
                                echo '<option value="' . $key . '">' . $lstages . '</option>';
                              } ?>
                            </select>
                          </div>
                          <div class="form-group col-md-4">
                            <label>Lead Priority level </label>
                            <select class="form-control" name="LeadPriorityLevel">
                              <option value="Low">Low</option>
                              <option value="Average">Average</option>
                              <option value="High">High</option>
                            </select>
                          </div>
                          <div class="form-group col-md-4">
                            <label>Approx Purchase date</label>
                            <input type="date" name="LeadPersonNeeddate" class="form-control" value="<?php echo date("Y-m-d", strtotime("+1 month")); ?>">
                          </div>
                        </div>
                        <div class="row mb-5px">
                          <div class="form-group col-md-12">
                            <label>Address</label>
                            <textarea name="LeadPersonAddress" row="3" class="form-control" placeholder="Address"></textarea>
                          </div>
                        </div>

                        <div class="row mb-5px">
                          <div class="form-group col-md-6">
                            <label>Lead Created By</label>
                            <select class="form-control" name="LeadPersonCreatedBy">
                              <?php
                              $Users = FetchConvertIntoArray("SELECT * FROM users ORDER BY name ASC", true);
                              foreach ($Users as $User) {
                                if ($User->id == LOGIN_UserId) {
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
                                if ($User->id == LOGIN_UserId) {
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
                            <label>Notes/Remarks About Requirements</label>
                            <textarea name="LeadPersonNotes" class="form-control" rows="3"></textarea>
                          </div>
                        </div>

                        <div class="row mb-5px">
                          <div class="col-md-12">
                            <a href="index.php" class="btn btn-lg btn-default"><i class="fa fa-angle-left"></i> Back to All Leads</a>
                            <button class="btn btn-lg btn-success" name="CreateLeads" TYPE="submit">Save Lead Record</button>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="section-heading">
                          <h4 class="mb-0 mt-0">Interested In</h4>
                        </div>
                        <div class="row mb-5px p-t-10">
                          <?php
                          $SqlProjects = "SELECT * FROM project_units, Projects where Projects.Projects_id=project_units.project_id and project_units.project_unit_status='ACTIVE'";
                          $TotalProjectUnits = TOTAL("$SqlProjects");
                          $GetProjectNames = FetchConvertIntoArray("$SqlProjects", true);
                          if ($GetProjectNames == null) {
                            NoData("No Active Projects Found", [
                              "url" => ADMIN_URL . "/projects/index.php",
                              "name" => "Add Projects",
                              "target" => "_blank",
                              "class" => "btn btn-sm btn-primary m-l-5"
                            ]);
                          } else {
                          ?>
                            <div class="col-md-12">
                              <h4 class="m-b-1 m-t-1">Select From Available Plots : <span class="text-success"><b><?php echo $TotalProjectUnits; ?></b> Plots</span></h4>
                            </div>
                            <div class='col-md-12 lead-need-area'>
                              <table class="table table-striped" id="example">
                                <?php
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
                            </div>
                            <div class="col-md-12 m-t-5 text-right">
                              <a href="<?php echo DOMAIN; ?>/app/projects/" class="btn btn-xs btn-info" target="_blank">View Projects <i class="fa fa-list"></i></a>
                              <a href="<?php echo DOMAIN; ?>/app/live-map/index.php" class="btn btn-xs btn-primary" target="_blank">View Live Project Map <i class="fa fa-map-marker"></i></a>
                            </div>
                          <?php } ?>
                        </div>
                        <div class="row mb-5px">
                          <div class="col-md-12">
                            <h4 class="section-heading">Add Call Details</h4>
                          </div>
                          <div class="form-group col-md-4">
                            <label>Call Date</label>
                            <input type="date" name="LeadCallingDate" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                          </div>

                          <div class="form-group col-md-4">
                            <label>Call Time</label>
                            <input type="time" name="LeadCallingTime" class="form-control" value="<?php echo date('h:m'); ?>">
                          </div>

                          <div class="form-group col-md-4">
                            <label>Call Type</label>
                            <select name="LeadCallType" class="form-control">
                              <option value="Incoming">Incoming</option>
                              <option value="Outgoing">Outgoing</option>
                            </select>
                          </div>

                          <div class="form-group col-md-8">
                            <label>Call Status</label>
                            <select name="LeadCallStatus" onchange="CheckCallStatus()" id="call_status" class="form-control">
                              <?php InputOptions(CALL_STATUS); ?>
                            </select>
                          </div>

                          <div class="col-md-12">
                            <label>Call Notes</label>
                            <textarea class="form-control" name="LeadCallNotes" row="3"></textarea>
                          </div>

                        </div>

                        <div class="hidden" id="call_reminder">
                          <div class="row mb-5px">
                            <div class="col-md-12">
                              <h4 class="section-heading">Schedule or Set Reminder Call</h4>
                            </div>
                            <div class="col-md-4">
                              <label>Call Reminder Date</label>
                              <input type="date" name="LeadCallingReminderDate" class="form-control" value="<?php echo date("Y-m-d", strtotime("+1 days")); ?>">
                            </div>
                            <div class="col-md-4">
                              <label>Call Reminder Time</label>
                              <input type="time" name="LeadCallingReminderTime" class="form-control" value="<?php echo date("h:m", strtotime("+1 days")); ?>">
                            </div>
                            <div class="col-md-12">
                              <label>Remind Notes</label>
                              <textarea class="form-control" name="LeadCallRemindNotes" row="3"></textarea>
                            </div>
                          </div>
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

    <?php include '../sidebar.php'; ?>
    <?php include '../footer.php'; ?>
  </div>
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

  <?php include '../../include/footer_files.php'; ?>

</body>

</html>
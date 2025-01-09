<?php
require '../../require/modules.php';
require "../../require/admin/sessionvariables.php";
require '../../include/admin/common.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Module Settings | <?php echo company_name; ?></title>
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
        <!--===================================================-->
        <div id="page-content">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-12">
              <div class="panel square">
                <div class="panel-body">
                  <div class="row">
                    <div class="col-md-12">
                      <h3 class="m-t-3"><i class="fa fa-gears app-text"></i> Module Settings </h3>
                    </div>
                    <div class="col-md-12">
                      <div class="flex-s-b">
                        <div class="btn-group btn-group-sm w-100 m-b-10">
                          <a class="btn btn-primary square btn-labeled fa fa-plus" data-toggle="modal" data-target="#add_data">Module Access</a>
                          <a class="btn btn-success square btn-labeled fa fa-eye" href="list">View Module</a>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12 col-sm-12 p-l-0 p-r-0">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th style="width:5%;">ID</th>
                            <th>MODULE</th>
                            <th>AccessTo</th>
                            <th>UserRole</th>
                            <th>Password</th>
                            <th>CreatedAt</th>
                            <th>Status</th>
                            <th style="width:15%;">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $SQL_module_controls = SELECT("SELECT * FROM module_controls, module_list, users, user_roles where module_controls.moduleid=module_list.module_id and module_controls.userid=users.id and module_controls.status!='DELETED' and user_roles.role_id=users.user_role_id ORDER BY module_controls.modulecontrolid DESC");
                          while ($ModuleAccess = mysqli_fetch_array($SQL_module_controls)) { ?>
                            <tr>
                              <td><?php echo $ModuleAccess['modulecontrolid']; ?></td>
                              <td><a href="#" data-toggle="modal" data-target="#edit_data_<?php echo $ModuleAccess['modulecontrolid']; ?>" class="text-primary"><?php echo $ModuleAccess['module_name']; ?></a></td>
                              <td><?php echo $ModuleAccess['name']; ?></td>
                              <td><?php echo $ModuleAccess['role_name']; ?></td>
                              <td>
                                <code id="pass_<?php echo $ModuleAccess['modulecontrolid']; ?>">*********</code>
                              </td>
                              <td><?php echo date("d M, Y h:m a", strtotime($ModuleAccess['created_at'])); ?></td>
                              <td>
                                <?php if ($ModuleAccess['status'] == "ACTIVE") { ?>
                                  <span class="text-success"><i class="fa fa-check-circle"></i> Active</span>
                                <?php } else { ?>
                                  <span class="text-danger"><i class="fa fa-warning"></i> <?php echo $ModuleAccess['status']; ?></span>

                                <?php } ?>
                              </td>
                              <td>
                                <div class="btn-group">
                                  <a href="" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                                  <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#edit_data_<?php echo $ModuleAccess['modulecontrolid']; ?>"><i class="fa fa-edit"></i></a>
                                  <a href="#" class="btn btn-sm btn-dark" onclick="show_<?php echo $ModuleAccess['modulecontrolid']; ?>()"><i class="fa fa-key"></i></a>
                                  <script>
                                    var pass_<?php echo $ModuleAccess['modulecontrolid']; ?> = document.getElementById("pass_<?php echo $ModuleAccess['modulecontrolid']; ?>");

                                    function show_<?php echo $ModuleAccess['modulecontrolid']; ?>() {
                                      if (pass_<?php echo $ModuleAccess['modulecontrolid']; ?>.innerHTML === "*********") {
                                        pass_<?php echo $ModuleAccess['modulecontrolid']; ?>.innerHTML = "<?php echo $ModuleAccess['modulepassword']; ?>";
                                      } else {
                                        pass_<?php echo $ModuleAccess['modulecontrolid']; ?>.innerHTML = "*********";
                                      }
                                    }
                                  </script>
                                  <?php
                                  if ($ModuleAccess['modulecontrolid'] == 1 or $ModuleAccess['modulecontrolid'] == 2 or $ModuleAccess['modulecontrolid'] == 3) { ?>
                                  <?php } else { ?>
                                    <form action="../../controller/modulecontroller.php" method="POST" class="float-right">
                                      <?php FormPrimaryInputs(true); ?>
                                      <button type="submit" name="update_module" value="<?php echo $ModuleAccess['modulecontrolid']; ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    </form>
                                  <?php } ?>
                                </div>
                                <div class="modal fade square" id="edit_data_<?php echo $ModuleAccess['modulecontrolid']; ?>" role="dialog">
                                  <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                      <div class="modal-header app-bg text-white">
                                        <button type="button" class="close text-white m-r-8 m-t-1" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title text-white">Edit Module Access: <?php echo $ModuleAccess['module_name']; ?> <i class="fa fa-angle-right"></i> <?php echo $ModuleAccess['name']; ?></h4>
                                      </div>
                                      <div class="modal-body overflow-auto">
                                        <form action="../../controller/modulecontroller.php" method="POST">
                                          <?php FormPrimaryInputs(true); ?>
                                          <div class="row">
                                            <div class="from-group col-md-6 col-lg-6 col-12">
                                              <label>Select Module</label>
                                              <select name="moduleid" class="form-control" required="">
                                                <?php
                                                if ($ModuleAccess['module_id'] == 1 or $ModuleAccess['module_id'] == 2 or $ModuleAccess['module_id'] == 3) { ?>
                                                  <option value="<?php echo $ModuleAccess['module_id']; ?>"><?php echo $ModuleAccess['module_name']; ?></option>
                                                <?php } else { ?>
                                                  <option value="<?php echo $ModuleAccess['module_id']; ?>" selected=""><?php echo $ModuleAccess['module_name']; ?></option>
                                                  <?php
                                                  $SQL_Module = SELECT("SELECT * FROM module_list where module_id!='" . $ModuleAccess['module_id'] . "' ORDER BY module_name ASC");
                                                  while ($Modules = mysqli_fetch_array($SQL_Module)) {
                                                    $module_id = $Modules['module_id'];
                                                    $module_name = $Modules['module_name']; ?>
                                                    <option value="<?php echo $module_id; ?>"><?php echo $module_name; ?></option>
                                                  <?php } ?>
                                                <?php } ?>
                                              </select>
                                            </div>
                                            <div class="from-group col-md-6">
                                              <label>Select Users</label>
                                              <select name="userid" class="form-control" placeholder="" required="">
                                                <option value="<?php echo $ModuleAccess['id']; ?>" selected=""><?php echo $ModuleAccess['name']; ?> : <?php echo $ModuleAccess['phone']; ?></option>
                                                <?php
                                                $SQL_users = SELECT("SELECT * FROM users where company_relation='$company_id' and user_status='ACTIVE' and user_role_id='5' and id!='" . $ModuleAccess['id'] . "'");
                                                while ($SelectEmployees = mysqli_fetch_array($SQL_users)) {
                                                  $employeeid = $SelectEmployees['id'];
                                                  $emp_name = $SelectEmployees['name'];
                                                  $emp_phone = $SelectEmployees['phone']; ?>
                                                  <option value="<?php echo $employeeid; ?>"><?php echo $emp_name; ?> : <?php echo $emp_phone; ?></option>
                                                <?php } ?>
                                              </select>
                                            </div>
                                            <div class="from-group col-md-6">
                                              <label>New Module Password</label>
                                              <input type="password" name="modulepassword" value="<?php echo $ModuleAccess['modulepassword']; ?>" class="form-control" placeholder="" required="">
                                            </div>
                                            <div class="from-group col-md-6">
                                              <label>Re-Enter Module Password</label>
                                              <input type="password" name="modulepassword2" value="<?php echo $ModuleAccess['modulepassword']; ?>" class="form-control" placeholder="" required="">
                                            </div>
                                            <div class="from-group col-md-6">
                                              <label>Module Status</label>
                                              <select name="status" class="form-control" required="">
                                                <?php if ($ModuleAccess['status'] == "ACTIVE") { ?>
                                                  <option value="ACTIVE" selected="">ACTIVE</option>
                                                  <option value="INACTIVE">INACTIVE</option>
                                                <?php } else { ?>
                                                  <option value="INACTIVE" selected="">INACTIVE</option>
                                                  <option value="ACTIVE">ACTIVE</option>
                                                <?php } ?>
                                              </select>
                                            </div>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" name="edit_module_access" value="<?php echo $ModuleAccess['modulecontrolid']; ?>" class="btn btn-success" onclick="actionBtn('updatemodule_<?php echo $ModuleAccess['modulecontrolid']; ?>', 'Saving Updates...')" id="updatemodule_<?php echo $ModuleAccess['modulecontrolid']; ?>">Save Updates</button>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>

                              </td>
                            </tr>

                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>


    <!-- Modal  3-->
    <div class="modal fade square" id="add_data" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header app-bg text-white">
            <button type="button" class="close text-white m-r-8 m-t-1" data-dismiss="modal">&times;</button>
            <h4 class="modal-title text-white">Add Module Access</h4>
          </div>
          <div class="modal-body overflow-auto">
            <form action="../../controller/modulecontroller.php" method="POST">
              <?php FormPrimaryInputs(true); ?>
              <div class="row">
                <div class="from-group col-md-6">
                  <label>Select Module</label>
                  <select name="moduleid" class="form-control" required="">
                    <?php
                    $SQL_Module = SELECT("SELECT * FROM module_list ORDER BY module_name ASC");
                    while ($Modules = mysqli_fetch_array($SQL_Module)) {
                      $module_id = $Modules['module_id'];
                      $module_name = $Modules['module_name']; ?>
                      <option value="<?php echo $module_id; ?>"><?php echo $module_name; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="from-group col-md-6">
                  <label>Select Users</label>
                  <select name="userid" class="form-control" placeholder="" required="">
                    <?php
                    $SQL_users = SELECT("SELECT * FROM users where company_relation='$company_id' and user_status='ACTIVE' and user_role_id='5'");
                    while ($SelectEmployees = mysqli_fetch_array($SQL_users)) {
                      $employeeid = $SelectEmployees['id'];
                      $emp_name = $SelectEmployees['name'];
                      $emp_phone = $SelectEmployees['phone']; ?>
                      <option value="<?php echo $employeeid; ?>"><?php echo $emp_name; ?> : <?php echo $emp_phone; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="from-group col-md-6">
                  <label>New Module Password</label>
                  <input type="password" name="modulepassword" value="" class="form-control" placeholder="" required="">
                </div>
                <div class="from-group col-md-6">
                  <label>Re-Enter Module Password</label>
                  <input type="text" name="modulepassword2" value="" class="form-control" placeholder="" required="">
                </div>
                <div class="from-group col-md-6">
                  <label>Module Status</label>
                  <select name="status" class="form-control" required="">
                    <option value="ACTIVE" selected="">ACTIVE</option>
                    <option value="INACTIVE">INACTIVE</option>
                  </select>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" name="create_new_module_user" value="<?php echo company_id; ?>" class="btn btn-success">Create Access</button>
            </form>
          </div>
        </div>
      </div>
      <!--===================================================-->
      <!--End page content-->
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
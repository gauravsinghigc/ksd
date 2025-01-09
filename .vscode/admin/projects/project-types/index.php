<?php
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Projects Types| <?php echo company_name; ?></title>
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
                                            <h3 class="m-t-3"><i class="fa fa-list app-text"></i> Projects Types</h3>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="flex-s-b">
                                                <div class="btn-group btn-group-sm w-100 m-r-20 m-l-5 m-b-10">
                                                    <a class="btn btn-primary square btn-labeled fa fa-plus" data-toggle="modal" data-target="#new_project_type">Project Type</a>
                                                    <a href="<?php echo DOMAIN; ?>/admin/projects/" class="btn btn-info square btn-labeled fa fa-list">Projects</a>
                                                </div>
                                                <div class="btn-group btn-group-sm w-100 m-r-20 m-l-5 m-b-10">
                                                    <form action="" method="GET" class="flex-s-b form-search-filter w-100">
                                                        <span class="w-100 p-1 text-right"><b>Search Projects</b></span>
                                                        <select name="search_type" class="form-control">
                                                            <option value="project_type_name">By Project Type</option>
                                                            <option value="created_at">By Create Date</option>
                                                            <option value="project_type_status">By Status</option>
                                                        </select>
                                                        <input type="text" name="search_value" class="form-control" placeholder="Enter Search Value">
                                                        <button type="submit" class="btn btn-sm btn-default m-l-5" name="search">Search</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-12 col-sm-12 p-l-0 p-r-0 p-t-10">
                                            <?php if (isset($_GET['search'])) { ?>
                                                <center>
                                                    <p class="text-center app-bg shadow-lg br10 p-1 w-50 flex-s-b m-b-20">
                                                        <span><span>Search Results :</span> <?php echo $_GET['search_value']; ?></span>
                                                        <a href="index.php" class="text-danger"><span class="text-white"><i class="fa fa-times"></i> Clear</span></a>
                                                    </p>
                                                </center>
                                            <?php } ?>

                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th style=" width:5%;">S.NO</th>
                                                        <th>Project Type</th>
                                                        <th>Projects</th>
                                                        <th>Created At</th>
                                                        <th>Updated At</th>
                                                        <th>Status</th>
                                                        <th style="width:15%;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (isset($_GET['search'])) {
                                                        $search_type = $_GET['search_type'];
                                                        $search_value = $_GET["search_value"];

                                                        $SelectProjects = SELECT("SELECT * from project_types where $search_type LIKE '%$search_value%' and company_id='" . company_id . "' ORDER BY project_type_id DESC");
                                                    } else {
                                                        $SelectProjects = SELECT("SELECT * from project_types where company_id='" . company_id . "' and project_type_status!='DELETED' ORDER BY project_type_id DESC");
                                                    }
                                                    $count = 0;
                                                    while ($FetchProjects = mysqli_fetch_array($SelectProjects)) {
                                                        $count++;
                                                        $project_type_id = $FetchProjects['project_type_id'];
                                                        $project_type_name = $FetchProjects['project_type_name'];
                                                        $updated_at = $FetchProjects['udpated_at'];
                                                        if ($updated_at == null) {
                                                            $updated_at = "";
                                                        } else {
                                                            $updated_at = $updated_at;
                                                        }
                                                        $created_at = $FetchProjects['created_at'];
                                                        $project_type_status = $FetchProjects['project_type_status'];
                                                        if ($project_type_status == "ACTIVE") {
                                                            $project_status_view = "<span class='text-success'><i class='fa fa-check-circle'></i> Active</span>";
                                                        } else {
                                                            $project_status_view = "<span class='text-danger'><i class='fa fa-warning'></i> Inactive</span>";
                                                        }

                                                        $AvailableProjects = TOTAL("SELECT * FROM projects where project_type='$project_type_name'"); ?>
                                                        <tr>
                                                            <td><?php echo $count; ?></td>
                                                            <td><?php echo $project_type_name; ?></td>
                                                            <td><?php echo $AvailableProjects; ?> Project</td>
                                                            <td><?php echo $created_at; ?></td>
                                                            <td><?php echo $updated_at; ?></td>
                                                            <td><?php echo $project_status_view; ?></td>
                                                            <td>
                                                                <div class="btn-group flex-center" role="group" aria-label="Basic example">
                                                                    <a type="button" data-toggle="modal" data-target="#view_project_types_<?php echo $project_type_id; ?>" class="btn btn-secondary btn-sm btn-info"><I class="fa fa-edit"></I></a>

                                                                    <?php if ($AvailableProjects == 0) { ?>
                                                                        <form action="../../../controller/projectcontroller.php" method="POST">
                                                                            <?php echo FormPrimaryInputs(true); ?>
                                                                            <input type="text" name="project_name" value="<?php echo $project_type_name; ?>" hidden="">
                                                                            <button type="submit" name="delete_projects_types" value="<?php echo SECURE($project_type_id, "e"); ?>" class="btn btn-sm btn-danger <?php echo $BtnStatus; ?>"><i class="fa fa-trash"></i></button>
                                                                        </form>
                                                                    <?php } ?>
                                                                </div>
                                                                <!-- Modal  3-->
                                                                <div class="modal fade square" id="view_project_types_<?php echo $project_type_id; ?>" role="dialog">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header app-bg text-white">
                                                                                <button type="button" class="close text-white m-r-8 m-t-1" data-dismiss="modal">&times;</button>
                                                                                <h4 class="modal-title text-white">Edit Project Types</h4>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form action="../../../controller/projectcontroller.php" method="POST">
                                                                                    <div class="row">
                                                                                        <div class="form-group col-12 col-md-12">
                                                                                            <label>Created At</label>
                                                                                            <input type="date" readonly="" name="created_at" class="form-control" value="<?php echo date("Y-m-d", strtotime($created_at)); ?>" required="" placeholder="Created At">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="form-group col-12 col-md-12">
                                                                                            <label>Title</label>
                                                                                            <input type="text" name="project_type_name" class="form-control" value="<?php echo $project_type_name; ?>" required="" placeholder="Project Type Name">
                                                                                        </div>
                                                                                    </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                <button type="submit" name="update_project_type" value="<?php echo $project_type_id; ?>" class="btn btn-success">Update</button>
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
                                            <a href="../index.php" class="btn btn-sm btn-default"><i class="fa fa-angle-left font-2r"></i> Back to All Projects</a>
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
        <div class="modal fade square" id="new_project_type" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header app-bg text-white">
                        <button type="button" class="close text-white m-r-8 m-t-1" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title text-white">Add Project Types</h4>
                    </div>
                    <div class="modal-body">
                        <form action="../../../controller/projectcontroller.php" method="POST">
                            <?php FormPrimaryInputs(true); ?>
                            <div class="row">
                                <div class="form-group col-12 col-md-12">
                                    <label>Title</label>
                                    <input type="text" name="project_type_name" class="form-control" required="" placeholder="Project Type Name">
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" name="create_new_project_type" value="<?php echo company_id; ?>" class="btn btn-success">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal  3-->
        <div class="modal fade square" id="add_data" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header app-bg text-white">
                        <button type="button" class="close text-white m-r-8 m-t-1" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title text-white">Add Project</h4>
                    </div>
                    <div class="modal-body overflow-auto">
                        <form action="../../controller/projectcontroller.php" method="POST">
                            <?php FormPrimaryInputs(true); ?>
                            <input name="project_measure_unit" required="" value="<?php echo MeasurementUnit; ?>" hidden="">
                            <div class="row">
                                <div class="form-group col-12 col-md-12">
                                    <label>Project Title</label>
                                    <input type="text" name="project_title" class="form-control" required="" placeholder="Project Name">
                                </div>
                                <div class="form-group col-12 col-md-12">
                                    <label>Project Type</label>
                                    <select name="project_type" class="form-control" required="">
                                        <?php
                                        $FetchPROJECT_TYPE = SELECT("SELECT * from project_types where company_id='" . company_id . "' and project_type_status='ACTIVE'");
                                        while ($FetchPROJECTST = mysqli_fetch_array($FetchPROJECT_TYPE)) {
                                            $project_type_name = $FetchPROJECTST['project_type_name']; ?>
                                            <option value="<?php echo $project_type_name; ?>"><?php echo $project_type_name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group col-12 col-md-12">
                                    <label>Project Total Area (<?php echo MeasurementUnit; ?>)</label>
                                    <input type="number" name="project_area" class="form-control" require="" placeholder="12234">
                                </div>
                                <div class="form-group col-12 col-md-12">
                                    <label>Project Description</label>
                                    <textarea class="form-control" placeholder="" name="project_descriptions" rows="3"></textarea>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" name="create_new_project" value="<?php echo company_id; ?>" class="btn btn-success">Save</button>
                        </form>
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
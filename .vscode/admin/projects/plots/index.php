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
    <title>Plots | <?php echo company_name; ?></title>
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
                                            <h3 class="m-t-3"><i class="fa fa-map-marker app-text"></i> Plots</h3>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="flex-s-b">
                                                <div class="btn-group btn-group-sm w-100 m-r-20 m-l-5 m-b-10">
                                                    <a class="btn btn-primary square btn-labeled fa fa-plus" data-toggle="modal" data-target="#add_data">Plots</a>
                                                    <a href="<?php echo DOMAIN; ?>/admin/projects/" class="btn btn-info square btn-labeled fa fa-list">Projects</a>
                                                    <?php if (isset($_GET['search'])) { ?>
                                                        <a href="<?php echo DOMAIN; ?>/admin/projects/plots/export_all.php?search_type=<?php echo $_GET['search_type']; ?>&search_value=<?php echo $_GET['search_value']; ?>&search=true" target="blank" class="btn btn-secondary square btn-labeled fa fa-print">Export All</a>
                                                    <?php } else { ?>
                                                        <a href="<?php echo DOMAIN; ?>/admin/projects/plots/export_all.php" target="blank" class="btn btn-secondary square btn-labeled fa fa-print">Export All</a>
                                                    <?php } ?>
                                                </div>
                                                <div class="btn-group btn-group-sm w-100 m-r-20 m-l-5 m-b-10">
                                                    <form action="" method="GET" class="flex-s-b form-search-filter w-100">
                                                        <span class="w-100 p-1 text-right"><b>Search Plots</b></span>
                                                        <select name="search_type" class="form-control">
                                                            <option value="projects.project_title">Project Name</option>
                                                            <option value="project_units.projects_unit_name">Plot No</option>
                                                            <option value="project_units.projects_unit_type">Plot Type</option>
                                                            <option value="project_units.project_unit_area">Plot Area</option>
                                                            <option value="project_units.project_unit_price">Plot Price</option>
                                                            <option value="project_units.unit_per_price">Unit Per Rate</option>
                                                            <option value="project_units.project_unit_status">Status</option>
                                                            <option value="project_units.created_at">Created At</option>
                                                        </select>
                                                        <input type="text" name="search_value" class="form-control" placeholder="Enter Search Value">
                                                        <button type="submit" class="btn btn-sm btn-default m-l-5" name="search">Search</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="flex-s-b">
                                                <p class="data-list w-pr-19">
                                                    <span class="bold">Total Plots :</span>
                                                    <span class="text-success"> <?php echo TOTAL("SELECT * from project_units"); ?></span>
                                                </p>
                                                <p class="data-list w-pr-19">
                                                    <span class="bold">Active Plots :</span>
                                                    <span class="text-success"> <?php echo TOTAL("SELECT * from project_units where project_unit_status='ACTIVE'"); ?></span>
                                                </p>
                                                <p class="data-list w-pr-19">
                                                    <span class="bold">Sold Plots :</span>
                                                    <span class="text-success"> <?php echo TOTAL("SELECT * from project_units where project_unit_status='SOLD'"); ?></span>
                                                </p>
                                                <p class="data-list w-pr-19">
                                                    <span class="bold">Hold Plots :</span>
                                                    <span class="text-success"> <?php echo TOTAL("SELECT * from project_units where project_unit_status='HOLD'"); ?></span>
                                                </p>
                                                <p class="data-list w-pr-19">
                                                    <span class="bold">Net Plot Cost :</span>
                                                    <span class="text-success"> <?php echo Price(AMOUNT("SELECT * from project_units", "project_unit_price"), "text-success", "Rs."); ?></span>
                                                </p>
                                            </div>
                                        </div>


                                        <div class="col-lg-12 col-md-12 col-12 p-l-0 p-r-0 p-t-10">
                                            <?php if (isset($_GET['search'])) { ?>
                                                <center>
                                                    <p class="text-center app-bg shadow-lg br10 p-1 w-50 flex-s-b m-b-20">
                                                        <span><span>Search Results :</span> <?php echo $_GET['search_value']; ?></span>
                                                        <a href="index.php" class="text-danger"><span class="text-white"><i class="fa fa-times"></i> Clear</span></a>
                                                    </p>
                                                </center>
                                            <?php } ?>
                                            <?php
                                            $TotalItems = TOTAL("SELECT *, project_units.created_at AS 'project_units_created_at' from projects, project_units where projects.Projects_id=project_units.project_id and projects.company_id='" . company_id . "' and project_units.project_unit_status!='DELETED' ORDER BY project_units.project_units_id DESC");
                                            include "../../../include/extra/data-counter.php";
                                            ?>
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th style=" width:10%;">S.NO</th>
                                                        <th>PLOT NO</th>
                                                        <th>Project Name</th>
                                                        <th>Type</th>
                                                        <th>Area</th>
                                                        <th>Price</th>
                                                        <th>CreatedAt</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (isset($_GET['search'])) {
                                                        $search_type = $_GET['search_type'];
                                                        $search_value = $_GET['search_value'];
                                                        $SelectProjects = SELECT("SELECT *, project_units.created_at AS 'project_units_created_at' from projects, project_units where $search_type like '%$search_value%' and projects.Projects_id=project_units.project_id and projects.company_id='" . company_id . "' and project_units.project_unit_status!='DELETED' ORDER BY project_units.project_units_id DESC limit $start, $listcounts");
                                                    } else {
                                                        $SelectProjects = SELECT("SELECT *, project_units.created_at AS 'project_units_created_at' from projects, project_units where projects.Projects_id=project_units.project_id and projects.company_id='" . company_id . "' and project_units.project_unit_status!='DELETED' ORDER BY project_units.project_units_id DESC limit $start, $listcounts");
                                                    }

                                                    $CountTotalProjectUntits = 0;
                                                    $SerialNo = 0;
                                                    while ($FetchProjects = mysqli_fetch_array($SelectProjects)) {
                                                        $SerialNo++;
                                                        $project_units_id = $FetchProjects['project_units_id'];
                                                        $Update = UPDATE("UPDATE project_units SET project_unit_status='ACTIVE' where project_units_id='$project_units_id'");
                                                        $project_units_id  = $FetchProjects['project_units_id'];
                                                        $projects_unit_name = $FetchProjects['projects_unit_name'];
                                                        $projects_unit_type = $FetchProjects['projects_unit_type'];
                                                        $project_unit_area = $FetchProjects['project_unit_area'];
                                                        $project_unit_measurement_unit = $FetchProjects['project_unit_measurement_unit'];
                                                        $project_unit_price = $FetchProjects['project_unit_price'];
                                                        $unit_per_price = $FetchProjects['unit_per_price'];
                                                        $updated_at = date("d M, Y h:m a", strtotime($FetchProjects['updated_at']));
                                                        $project_unit_status = $FetchProjects['project_unit_status'];
                                                        $project_title = $FetchProjects['project_title'];
                                                        $project_id = $FetchProjects['project_id'];
                                                        $project_unit_description = $FetchProjects['project_unit_description'];
                                                        $project_units_created_at = $FetchProjects['project_units_created_at'];
                                                        $project_title = $FetchProjects['project_title'];
                                                        $project_unit_id = $project_units_id;

                                                        if ($project_unit_status == "ACTIVE") {
                                                            $project_status_view = "<span class='text-success'><i class='fa fa-check-circle'></i> Active</span>";
                                                        } else if ($project_unit_status == "SOLD") {
                                                            $project_status_view = "<span class='text-info'><i class='fa fa-check-circle-o'></i> SOLD</span>";
                                                        } else {
                                                            $project_status_view = "<span class='text-danger'><i class='fa fa-warning'></i> Inactive</span>";
                                                        }

                                                        $CountTotalProjectUntits = TOTAL("SELECT * FROM project_units, bookings where project_units.project_units_id=bookings.project_unit_id and bookings.project_unit_id='$project_units_id'");
                                                        if (
                                                            $CountTotalProjectUntits == 0
                                                        ) {
                                                            $CountTotalProjectUntits = 0;
                                                            $BtnStatus = "";
                                                        } else {
                                                            $CountTotalProjectUntits = $CountTotalProjectUntits;
                                                            $BtnStatus = "hidden";
                                                        }
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $SerialNo; ?> - <span class="text-grey">ID(<?php echo $project_units_id; ?>)</span></td>
                                                            <td class="text-uppercase">
                                                                <a href="details/?plotid=<?php echo SECURE($project_unit_id, "e"); ?>" class='text-info link'><?php echo $projects_unit_name; ?></a>
                                                            </td>
                                                            <td class="text-uppercase"><?php echo $project_title; ?></td>
                                                            <td><?php echo $projects_unit_type; ?></td>
                                                            <td><?php echo $project_unit_area; ?> <?php echo $project_unit_measurement_unit; ?></td>
                                                            <td><span class="text-success"><i class="fa fa-inr"></i> <?php echo Price($project_unit_price, "text-success", ''); ?></span> -
                                                                <small>(<i class="fa fa-inr"></i><?php echo $unit_per_price; ?>/<?php echo $project_unit_measurement_unit; ?>)</small>
                                                            </td>
                                                            <td><?php echo DATE_FORMATE2("d M, Y", $project_units_created_at); ?></td>
                                                            <td><?php echo $project_status_view; ?></td>
                                                            <td>
                                                                <div class="btn-group flex-center">
                                                                    <a href="#" data-toggle="modal" data-target="#view_details_<?php echo $project_units_id; ?>" class="btn-sm btn btn-info"><i class="fa fa-edit"></i></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <!-- Modal  3-->
                                                        <div class="modal fade square" id="view_details_<?php echo $project_units_id; ?>" role="dialog">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header app-bg text-white">
                                                                        <button type="button" class="close text-white m-r-8 m-t-1" data-dismiss="modal">&times;</button>
                                                                        <h4 class="modal-title text-white">Unit : <?php echo $projects_unit_name; ?></h4>
                                                                    </div>
                                                                    <div class="modal-body overflow-auto">
                                                                        <form action="../../../controller/projectcontroller.php" method="POST">
                                                                            <?php FormPrimaryInputs(true, [
                                                                                "project_unit_measurement_unit" => MeasurementUnit,
                                                                                "projects_unit_type" => "PLOT",
                                                                                "created_at2" => $project_units_created_at
                                                                            ]); ?>
                                                                            <input type="text" id="formscounts<?php echo $project_units_id; ?>" value="1" hidden="">
                                                                            <div class="row">
                                                                                <div class="form-group col-12 col-md-6">
                                                                                    <label>Project Name</label>
                                                                                    <select name="project_id" class="form-control" required="">
                                                                                        <option value="<?php echo $project_id; ?>" selected><?php echo $project_title; ?></option>
                                                                                        <?php
                                                                                        $fetchPROJECTS = SELECT("SELECT * FROM projects where company_id='$company_id' and project_status='ACTIVE' and Projects_id!='$project_id'");
                                                                                        while ($F_PROJECTS = mysqli_fetch_array($fetchPROJECTS)) {
                                                                                            $project_title = $F_PROJECTS['project_title'];
                                                                                            $Projects_id = $F_PROJECTS['Projects_id']; ?>
                                                                                            <option value="<?php echo $Projects_id; ?>"><?php echo $project_title; ?></option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="form-group col-12 col-md-6">
                                                                                    <label>Unit No:</label>
                                                                                    <input type="text" name="projects_unit_name" list="projects_unit_name" class="form-control" required="" value="<?php echo $projects_unit_name; ?>" placeholder="ex: p-1, f1">
                                                                                    <?php SUGGEST("project_units", "projects_unit_name", "ASC"); ?>
                                                                                </div>
                                                                                <div class="form-group col-12 col-md-6">
                                                                                    <label>Unit Area (<?php echo MeasurementUnit; ?>)</label>
                                                                                    <input type="text" name="project_unit_area" value="<?php echo $project_unit_area; ?>" oninput="UnitPrice_<?php echo $project_units_id; ?>()" id="project_unit_area_<?php echo $project_units_id; ?>" class="form-control" placeholder="" required="">
                                                                                </div>
                                                                                <div class="form-group col-12 col-md-6">
                                                                                    <label>Rate Per <?php echo MeasurementUnit; ?> in Rs.</label>
                                                                                    <input type="text" name="unit_per_price" value="<?php echo $unit_per_price; ?>" id="unit_per_price_<?php echo $project_units_id; ?>" oninput="UnitPrice_<?php echo $project_units_id; ?>()" class="form-control" placeholder="" required="">
                                                                                </div>
                                                                                <div class="form-group col-12 col-md-6">
                                                                                    <label>Unit Price</label>
                                                                                    <input type="text" name="project_unit_price" id="project_unit_price_<?php echo $project_units_id; ?>" class="form-control" placeholder="00" value="<?php echo $project_unit_price; ?>" readonly="">
                                                                                </div>
                                                                                <div class="form-group col-12 col-md-6">
                                                                                    <label>Unit Description</label>
                                                                                    <textarea class="form-control" placeholder="" name="project_unit_description" value="<?php echo $project_unit_description; ?>" rows="1"><?php echo $project_unit_description; ?></textarea>
                                                                                </div>
                                                                                <div class="form-group col-12 col-md-6">
                                                                                    <label>Unit Status</label>
                                                                                    <select name="project_unit_status" class="form-control" required="">
                                                                                        <?php InputOptions(["ACTIVE" => "ACTIVE", "SOLD" => "SOLD", "HOLD" => "HOLD"], $project_unit_status); ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <h4 class="section-heading">Plot Attributes</h4>
                                                                                </div>
                                                                                <div id="contactperson" class="border-bottom">
                                                                                    <?php
                                                                                    $SelectAttributes = SELECT("SELECT * FROM project_unit_attributes where ProjectUnitListId='$project_units_id' ORDER BY ProjectUnitAttributeId ASC");
                                                                                    while ($FetchAttributes = mysqli_fetch_array($SelectAttributes)) { ?>
                                                                                        <input type="text" name="ProjectUnitAttributeId[]" value="<?php echo $FetchAttributes['ProjectUnitAttributeId']; ?>" hidden="">
                                                                                        <div class="form-group col-lg-5 col-md-5 col-sm-5 col-5">
                                                                                            <label>Attribute Name</label>
                                                                                            <input name="ProjectUnitAttributeName[]" value="<?php echo SECURE($FetchAttributes['ProjectUnitAttributeName'], "d"); ?>" type="text" value="" class="form-control">
                                                                                        </div>
                                                                                        <div class="form-group col-lg-5 col-md-5 col-sm-5 col-5">
                                                                                            <label>Attribute Value</label>
                                                                                            <input name="ProjectUnitAttributeValue[]" value="<?php echo SECURE($FetchAttributes['ProjectUnitAttributeValue'], "d"); ?>" type="text" value="" class="form-control">
                                                                                        </div>
                                                                                        <div class="col-lg-2 col-md-2 col-sm-2 col-2">
                                                                                            <a href="<?php echo DOMAIN; ?>/controller/projectcontroller.php?del_attributes=<?php echo SECURE($FetchAttributes['ProjectUnitAttributeId'], "e"); ?>&access_url=<?php echo SECURE(get_url(), "e"); ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                                                                        </div>
                                                                                    <?php } ?>
                                                                                    <div id="contactperson<?php echo $project_unit_id; ?>" class="border-bottom" style="display:none;">
                                                                                        <div class=" form-group col-lg-6 col-md-6 col-sm-6 col-6">
                                                                                            <label>Attribute Name</label>
                                                                                            <input name="ProjectUnitAttributeName2[]" type="text" value="" class="form-control">
                                                                                        </div>
                                                                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-6">
                                                                                            <label>Attribute Value</label>
                                                                                            <input name="ProjectUnitAttributeValue2[]" type="text" value="" class="form-control">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div id="forms-person_<?php echo $project_unit_id; ?>">

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row m-t-5 m-b-5">
                                                                                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                                                                    <a class="btn btn-sm btn-default" onclick="AddMoreForms_<?php echo $project_unit_id; ?>()"><i class="fa fa-plus"></i> More Attribute</a>
                                                                                </div>
                                                                            </div>
                                                                            <script>
                                                                                function AddMoreForms_<?php echo $project_unit_id; ?>() {
                                                                                    var formscounts<?php echo $project_units_id; ?> = document.getElementById("formscounts<?php echo $project_units_id; ?>");
                                                                                    var personform_<?php echo $project_unit_id; ?> = '<div class="border-bottom"><div class="form-group col-lg-6 col-md-6 col-sm-6 col-6"><label>Attribute Name</label><input name="ProjectUnitAttributeName[]" type="text" value="" class="form-control"></div><div class="form-group col-lg-6 col-md-6 col-sm-6 col-6"><label>Attribute value</label><input name="ProjectUnitAttributeValue[]" type="text" value="" class="form-control"></div></div>';
                                                                                    var PersonFillableForsm_<?php echo $project_unit_id; ?> = "";
                                                                                    for (var start_<?php echo $project_unit_id; ?> = 1; start_<?php echo $project_unit_id; ?> <= +document.getElementById("formscounts<?php echo $project_units_id; ?>").value; start_<?php echo $project_unit_id; ?>++) {
                                                                                        PersonFillableForsm_<?php echo $project_unit_id; ?> += personform_<?php echo $project_unit_id; ?>;
                                                                                    }
                                                                                    document.getElementById("formscounts<?php echo $project_unit_id; ?>").value = start_<?php echo $project_unit_id; ?>;
                                                                                    document.getElementById("forms-person_<?php echo $project_unit_id; ?>").innerHTML = PersonFillableForsm_<?php echo $project_unit_id; ?>;
                                                                                }
                                                                            </script>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                        <button type="submit" name="update_project_unit" value="<?php echo $project_units_id; ?>" class="btn btn-success">Save</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <script>
                                                            function UnitPrice_<?php echo $project_units_id; ?>() {
                                                                var project_unit_area = document.getElementById("project_unit_area_<?php echo $project_units_id; ?>").value;
                                                                var unit_per_price = document.getElementById("unit_per_price_<?php echo $project_units_id; ?>").value;
                                                                document.getElementById("project_unit_price_<?php echo $project_units_id; ?>").value = project_unit_area * unit_per_price;
                                                            }
                                                        </script>

                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            <?php include "../../../include/extra/pagination.php"; ?>
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
                        <h4 class="modal-title text-white">Add Plots</h4>
                    </div>
                    <div class="modal-body overflow-auto">
                        <form action="../../../controller/projectcontroller.php" method="POST">
                            <?php FormPrimaryInputs(true, [
                                "project_unit_measurement_unit" => MeasurementUnit,
                                "projects_unit_type" => "PLOT",
                            ]); ?>
                            <input type="text" id="formscounts" value="0" hidden="">
                            <div class="row">
                                <div class="form-group col-12 col-md-6">
                                    <label>Project Name</label>
                                    <select name="project_id" class="form-control" required="">
                                        <?php
                                        $fetchPROJECTS = SELECT("SELECT * FROM projects where company_id='" . company_id . "' and project_status='ACTIVE'");
                                        while ($F_PROJECTS = mysqli_fetch_array($fetchPROJECTS)) {
                                            $project_title = $F_PROJECTS['project_title'];
                                            $Projects_id = $F_PROJECTS['Projects_id']; ?>
                                            <option value="<?php echo $Projects_id; ?>"><?php echo $project_title; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label>Plot Name</label>
                                    <input type="text" name="projects_unit_name" class="form-control" required="" placeholder="ex: p-1, f1">
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label>Plot Area (<?php echo MeasurementUnit; ?>)</label>
                                    <input type="text" name="project_unit_area" value="" oninput="UnitPriced()" id="project_unit_aread" class="form-control" placeholder="" required="">
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label>Rate Per <?php echo MeasurementUnit; ?> in Rs.</label>
                                    <input type="text" name="unit_per_price" id="unit_per_priced" oninput="UnitPriced()" class="form-control" placeholder="" required="">
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label>Plot Price</label>
                                    <input type="text" name="project_unit_price" id="project_unit_priced" class="form-control" placeholder="00" value="" readonly="">
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label>Plot Description</label>
                                    <textarea class="form-control" placeholder="" name="project_unit_description" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="section-heading">Plot Attributes</h4>
                                </div>
                                <div id="forms-person">

                                </div>
                            </div>
                            <div class="row m-t-5 m-b-5">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                    <a class="btn btn-sm btn-default" onclick="AddMoreForms()"><i class="fa fa-plus"></i> More Attribute</a>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" name="create_new_project_unit" value="<?php echo company_id; ?>" class="btn btn-success">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function AddMoreForms() {
                var formscounts = document.getElementById("formscounts");
                var personform = '<div class="border-bottom"><div class="form-group col-lg-6 col-md-6 col-sm-6 col-6"><label>Attribute Name</label><input name="ProjectUnitAttributeName[]" type="text" value="" class="form-control"></div><div class="form-group col-lg-6 col-md-6 col-sm-6 col-6"><label>Attribute value</label><input name="ProjectUnitAttributeValue[]" type="text" value="" class="form-control"></div></div>';
                var PersonFillableForsm = "";
                for (var start = 1; start <= +document.getElementById("formscounts").value; start++) {
                    PersonFillableForsm += personform;
                }
                document.getElementById("formscounts").value = start;
                document.getElementById("forms-person").innerHTML = PersonFillableForsm;
            }
        </script>


        <!-- end -->
        <?php include '../../sidebar.php'; ?>
        <?php include '../../footer.php'; ?>

        <script>
            function UnitPrice() {
                var project_unit_area = document.getElementById("project_unit_aread").value;
                var unit_per_price = document.getElementById("unit_per_priced").value;

                document.getElementById("project_unit_priced").value = project_unit_area * unit_per_price;
            }
        </script>
        <script>
            function UnitPriced() {
                var project_unit_area = document.getElementById("project_unit_aread").value;
                var unit_per_price = document.getElementById("unit_per_priced").value;

                document.getElementById("project_unit_priced").value = project_unit_area * unit_per_price;
            }
        </script>
    </div>

    <?php include '../../../include/footer_files.php'; ?>
</body>

</html>
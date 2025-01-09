<?php
//add controller helper files
require 'helper.php';

//add aditional requirements
require '../require/admin/sessionvariables.php';

//start request processing

//create new projects
if (isset($_POST['create_new_project'])) {
    $project_title = strtoupper($_POST['project_title']);
    $project_type = $_POST['project_type'];
    $project_measure_unit = $_POST['project_measure_unit'];
    $project_area = $_POST['project_area'];
    $project_descriptions = $_POST['project_descriptions'];
    $created_at = RequestDataTypeDate();
    $company_id = $_POST['create_new_project'];

    $savenewproject = SAVE("projects", ["company_id", "project_title", "project_type", "project_measure_unit", "project_area", "project_descriptions", "created_at"]);
    if ($savenewproject == true) {
        $ProjectMainProjectId = FETCH("SELECT * FROM projects ORDER BY Projects_id DESC limit 1", "Projects_id");

        //create live map directory
        $mydir = dirname(__FILE__) . "/../app/live-map/$ProjectMainProjectId";
        if (!is_dir($mydir)) {
            mkdir("../app/live-map/$ProjectMainProjectId");
        }

        //copy default coming soon file to new dir
        copy('../app/live-map/default/index.php', "../app/live-map/$ProjectMainProjectId/index.php");

        $ProjectMediaFileType = "image";
        $ProjectMediaFileAttachements = UPLOAD_FILES("../storage/projects/media", "null", $project_title, $ProjectMainProjectId, "ProjectMediaFileAttachements");
        $Save = SAVE("project_media_files", ["ProjectMainProjectId", "ProjectMediaFileType", "ProjectMediaFileAttachements"]);
        LOCATION("success", "new project $project_title is created successfully!", "../admin/projects");
    } else {
        LOCATION("warning", "Project creation of $project_title is failed!", "../admin/projects");
    }

    //create new project types
} else if (isset($_POST['create_new_project_type'])) {
    $project_type_name = $_POST['project_type_name'];
    $created_at = RequestDataTypeDate();
    $company_id = $_POST['create_new_project_type'];

    $savenewprojecttype = SAVE("project_types", ["project_type_name", "created_at", "company_id"]);
    if ($savenewprojecttype == true) {
        LOCATION("success", "New project type : <b>$project_type_name</b> is created!", "../admin/projects/project-types");
    } else {
        LOCATION("warning", "Unable to create new project type: <b>$project_type_name</b>!", "../admin/projects/project-types");
    }

    //update projects
} else if (isset($_POST['update_projects'])) {
    $Projects_id = $_POST['update_projects'];
    $project_title = $_POST['project_title'];
    $project_type = $_POST['project_type'];
    $project_measure_unit = $_POST['project_measure_unit'];
    $project_area = $_POST['project_area'];
    $project_descriptions = $_POST['project_descriptions'];
    $updated_at = RequestDataTypeDate();
    $created_at = DATE_FORMATE("y-m-d", "created_at");

    $update = UPDATE("UPDATE projects SET  project_title='$project_title', project_type='$project_type', project_measure_unit='$project_measure_unit', project_area='$project_area', project_descriptions = '$project_descriptions', updated_at='$updated_at' where Projects_id='$Projects_id'");
    if ($update == true) {
        LOCATION("success", "$project_title is updated!", "../admin/projects/");
    } else {
        LOCATION("warning", "unable to update $project_title!", "../admin/projects/");
    }

    //update project types
} elseif (isset($_POST['update_project_type'])) {
    $project_type_id = $_POST['update_project_type'];
    $project_type_name = $_POST['project_type_name'];
    $updated_at = RequestDataTypeDate();
    $created_at = DATE_FORMATE("Y-m-d", "created_at");

    $update = UPDATE("UPDATE project_types SET  project_type_name='$project_type_name', udpated_at='$updated_at' where project_type_id='$project_type_id'");

    if ($update == true) {
        LOCATION("success", "$project_type_name is updated!", "../admin/projects/project-types");
    } else {
        LOCATION("danger", "unable to update $project_type_name!", "../admin/projects/project-types");
    }

    //projects unitcreations
} else if (isset($_POST['create_new_project_unit'])) {
    $project_unit_measurement_unit = SECURE($_POST['project_unit_measurement_unit'], "d");
    $projects_unit_type = "PLOT";
    $project_id = $_POST['project_id'];
    $projects_unit_name = strtolower($_POST['projects_unit_name']);
    $project_unit_area = $_POST['project_unit_area'];
    $unit_per_price = $_POST['unit_per_price'];
    $project_unit_price = $project_unit_area * $unit_per_price;
    $project_unit_description = $_POST['project_unit_description'];
    $created_at = RequestDataTypeDate();
    $project_unit_status = "ACTIVE";

    $check = CHECK("SELECT * FROM project_units where projects_unit_name='$projects_unit_name'");
    if ($check == null) {
        //save project unit details
        $Save = SAVE("project_units", ["projects_unit_name", "projects_unit_type", "project_unit_description", "project_unit_area", "project_unit_measurement_unit", "project_unit_status", "project_unit_price", "unit_per_price", "project_id", "created_at"]);

        //get project unit id name
        $ProjectUnitListId = FETCH("SELECT * FROM project_units ORDER BY project_units_id DESC LIMIT 0, 1", "project_units_id");

        //project unit attributes
        foreach ($_POST['ProjectUnitAttributeName'] as $key => $value) {
            $ProjectUnitAttributeName = SECURE($_POST['ProjectUnitAttributeName'][$key], "e");
            $ProjectUnitAttributeValue = SECURE($_POST['ProjectUnitAttributeValue'][$key], "e");
            $Save = SAVE("project_unit_attributes", ["ProjectUnitAttributeName", "ProjectUnitListId", "ProjectUnitAttributeValue"]);
        }

        if ($Save == true) {
            LOCATION("success", "$projects_unit_name is created successfully!", $access_url);
        } else {
            LOCATION("warning", "Failed to create $projects_unit_name!", $access_url);
        }
    } else {
        LOCATION("danger", "Unable to create project Unit No:d as $projects_unit_name!", $access_url);
    }

    //update project units
} else if (isset($_POST['update_project_unit'])) {
    $project_units_id = $_POST['update_project_unit'];
    $projects_unit_type = "PLOT";
    $project_id = $_POST['project_id'];
    $projects_unit_name = $_POST['projects_unit_name'];
    $project_unit_area = $_POST['project_unit_area'];
    $unit_per_price = $_POST['unit_per_price'];
    $project_unit_price = $project_unit_area * $unit_per_price;
    $project_unit_description = $_POST['project_unit_description'];
    $project_unit_status = $_POST['project_unit_status'];
    $created_at = DATE_FORMATE("y-m-d", "created_at");
    $updated_at = RequestDataTypeDate();
    $ProjectUnitListId = $project_units_id;

    if ($created_at == null) {
        $created_at = POST("created_at2");
    } else {
        $created_at = $created_at;
    }

    $update = UPDATE("UPDATE project_units SET updated_at='$updated_at', project_unit_status='$project_unit_status', projects_unit_name='$projects_unit_name', projects_unit_type='$projects_unit_type', project_unit_area='$project_unit_area', unit_per_price='$unit_per_price', project_unit_price='$project_unit_price', project_unit_description='$project_unit_description', updated_at=NOW() where project_units_id='$project_units_id'");

    //project unit attributes
    foreach ($_POST['ProjectUnitAttributeName'] as $key => $value) {
        $ProjectUnitAttributeId = $_POST['ProjectUnitAttributeId'][$key];
        $ProjectUnitAttributeName = SECURE($_POST['ProjectUnitAttributeName'][$key], "e");
        $ProjectUnitAttributeValue = SECURE($_POST['ProjectUnitAttributeValue'][$key], "e");
        $Save = UPDATE("UPDATE project_unit_attributes SET ProjectUnitAttributeName='$ProjectUnitAttributeName', ProjectUnitAttributeValue='$ProjectUnitAttributeValue' where ProjectUnitAttributeId='$ProjectUnitAttributeId'");
    }

    //project unit attributes
    foreach ($_POST['ProjectUnitAttributeName2'] as $key => $value) {
        $ProjectUnitAttributeName = SECURE($_POST['ProjectUnitAttributeName2'][$key], "e");
        $ProjectUnitAttributeValue = SECURE($_POST['ProjectUnitAttributeValue2'][$key], "e");
        $Save = SAVE("project_unit_attributes", ["ProjectUnitAttributeName", "ProjectUnitListId", "ProjectUnitAttributeValue"]);
    }

    if ($update == true) {
        LOCATION("success", "$projects_unit_name is updated successfully!", "../admin/projects/plots");
    } else {
        LOCATION("warning", "unable to update $projects_unit_name!", "../admin/projects/plots");
    }

    //projects unitcreations
} else if (isset($_GET['delete_projects'])) {
    $access_url = SECURE($_GET['access_url'], "d");
    $delete_projects = SECURE($_GET['delete_projects'], "d");
    $project_name = SECURE($_GET['project_name'], "d");

    if ($delete_projects == true) {
        $control_id = SECURE($_GET['control_id'], "d");
        $Delete = DELETE_FROM("projects", "Projects_id='$control_id'");
    } else {
        $Delete = false;
    }

    RESPONSE($Delete, "<b>$project_name</b> is Deleted Successfully!", "Unable to Deleted <b>$project_name</b>");

    //delete project units
} else if (isset($_GET['delete_project_units'])) {
    $access_url = SECURE($_GET['access_url'], "d");
    $delete_project_units = SECURE($_GET['delete_project_units'], "d");

    if ($delete_project_units == true) {
        $control_id = SECURE($_GET['control_id'], "d");
        $Delete = DELETE_FROM("project_units", "project_units_id='$control_id'");
        RESPONSE($Delete, "Project Unit is deleted successfully!", "Unable to delete project unit");
    } else {
        RESPONSE(false, "", "Unable to delete project units");
    }

    //delete project types
} else if (isset($_POST['delete_projects_types'])) {
    $project_type_id = SECURE($_POST["delete_projects_types"], "d");
    $project_name = $_POST['project_name'];

    $Response = DELETE("DELETE from project_types where project_type_id='$project_type_id'");
    $Msg = "$project_name is Deleted Successfully!";
    $Err = "Unable to Delete $project_name";
    RESPONSE($Response, "$Msg", "$Err");

    //delete project unit attributes
} elseif (isset($_GET['del_attributes'])) {
    $ProjectUnitAttributeId = SECURE($_GET['del_attributes'], "d");
    $access_url = SECURE($_GET['access_url'], "d");
    $Delete = DELETE("DELETE from project_unit_attributes where ProjectUnitAttributeId='$ProjectUnitAttributeId'");
    RESPONSE($Delete, "Project Attribute Deleted Successfully!", "Unable to delete project attributes!");

    //create project stages
} elseif (isset($_POST['CreateProjectStages'])) {

    SIU(
        "project_stages",
        "ProjectStageId",
        $Req = [
            "ProjectStageMainProjectId" => $_POST['ProjectStageMainProjectId'],
            "ProjectStageName" => $_POST['ProjectStageName'],
            "ProjectStageCreatedAt" => $_POST['ProjectStageCreatedAt'],
            "ProjectStageUpdatedAt" => RequestDataTypeDate,
            "ProjectStagePaymentPercentage" => $_POST['ProjectStagePaymentPercentage'],
            "ProjectStageDescriptions" => SECURE($_POST['ProjectStageDescriptions'], "e")
        ],
        $msg = array(
            "true" => "Project Stage Created Successfully!",
            "false" => "Unable to create project stage at the moment!"
        )
    );

    //delete project stages
} else if (isset($_GET['delete_stages_of_projects'])) {
    $access_url = SECURE($_GET['access_url'], "d");
    $delete_stages_of_projects = SECURE($_GET['delete_stages_of_projects'], "d");

    if ($delete_stages_of_projects == true) {
        $control_id = SECURE($_GET['control_id'], "d");
        $Delete = DELETE_FROM("project_stages", "ProjectStageId='$control_id'");
    } else {
        $Delete = false;
    }
    RESPONSE($Delete, "Project Stage deleted successfully!", "unable to delete project stage at the moment!");

    //update project stages
} elseif (isset($_POST['UpdateProjectStage'])) {
    $ProjectStageId = SECURE($_POST['ProjectStageId'], "d");

    $data = array(
        "ProjectStageMainProjectId" => $_POST['ProjectStageMainProjectId'],
        "ProjectStageName" => $_POST['ProjectStageName'],
        "ProjectStageCreatedAt" => $_POST['ProjectStageCreatedAt'],
        "ProjectStageUpdatedAt" => RequestDataTypeDate,
        "ProjectStagePaymentPercentage" => $_POST['ProjectStagePaymentPercentage'],
        "ProjectStageDescriptions" => SECURE($_POST['ProjectStageDescriptions'], "e"),
    );

    $Update = UPDATE_DATA("project_stages", $data, "ProjectStageId='$ProjectStageId'", false);
    RESPONSE($Update, "Project Stage Details are updated successfully!", "Unable to update project Stage Details!");
}

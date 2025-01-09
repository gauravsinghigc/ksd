<?php
require '../../../require/modules.php';
require "../../../require/admin/sessionvariables.php";
require '../../../include/admin/common.php';

$count = 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title><?php echo company_name; ?> All Plots</title>
</head>

<body onload="doConvert()" style="font-size:13px !important;color: black !important;margin:auto;font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">

 <section style="border-style:groove; border-width:thin;margin: auto; width: 1000px;border: 1px solid rgb(147 78 255);padding: 5px;">
  <small class="float:left;"><i></i></small>
  <div style="text-align:center;">
   <h3 style="line-height:1;margin-bottom:4px;margin-top:0px;font-size:24px !important;">
    ALL PLOTS<br>
    <small style="color:grey;font-size:19px !important;">PLOT REPORTS</small>
   </h3>
  </div>
  <?php include "../../../include/export/rc-header.php"; ?>
  <hr>
  <table style="width:100%;box-shadow: 0px 0px 1px grey;">
   <thead>
    <tr style="box-shadow:0px 0px 1px grey;background-color:lightgray;">
     <th>S.No</th>
     <th>project_name</th>
     <th>unit_name</th>
     <th>unit_type</th>
     <th>unit_description</th>
     <th>unit_area</th>
     <th>unit_price</th>
     <th>rate</th>
     <th>status</th>
     <th>created_at</th>
    </tr>
   </thead>
   <tbody>
    <?php
    if (isset($_GET['search'])) {
     $search_type = $_GET['search_type'];
     $search_value = $_GET['search_value'];
     $Getprojectsunits = SELECT("SELECT *, project_units.created_at AS 'project_units_created_at' from projects, project_units where $search_type='$search_value' and projects.Projects_id=project_units.project_id and projects.company_id='$company_id' and project_units.projects_unit_type='PLOT' ORDER BY project_units.project_units_id DESC");
    } else {
     $Getprojectsunits = SELECT("SELECT *, project_units.created_at AS 'project_units_created_at' from projects, project_units where projects.Projects_id=project_units.project_id and projects.company_id='$company_id' and project_units.projects_unit_type='PLOT' ORDER BY project_units.project_units_id DESC");
    }
    while ($projectunits = mysqli_fetch_array($Getprojectsunits)) {
     $count++;
     $project_name = $projectunits['project_title'];
     $projects_unit_name = $projectunits['projects_unit_name'];
     $projects_unit_type = $projectunits['projects_unit_type'];
     $project_unit_description = $projectunits['project_unit_description'];
     $project_unit_area = $projectunits['project_unit_area'];
     $project_unit_price = $projectunits['project_unit_price'];
     $rate = $projectunits['unit_per_price'];
     $project_unit_status = $projectunits['project_unit_status'];
     $created_at = $projectunits['created_at'];
     $project_unit_measurement_unit = $projectunits['project_unit_measurement_unit'];
    ?>
     <tr>
      <td><?php echo $count; ?></td>
      <td><?php echo $project_name; ?></td>
      <td><?php echo $projects_unit_name; ?></td>
      <td><?php echo $projects_unit_type; ?></td>
      <td style="width:15% !important;"><?php echo $project_unit_description; ?></td>
      <td><?php echo $project_unit_area; ?> <?php echo $project_unit_measurement_unit; ?></td>
      <td>Rs.<?php echo $project_unit_price; ?></td>
      <td>Rs.<?php echo $rate; ?>/ <?php echo $project_unit_measurement_unit; ?></td>
      <td><?php echo $project_unit_status; ?></td>
      <td><?php echo $created_at; ?></td>
     </tr>
    <?php } ?>
   </tbody>
  </table>
  <p style="color:black; font-size:12px;text-align:center;"><b>Exported On:</b> <?php echo date("D d M, Y"); ?> by (UID : <?php echo $UserId; ?>) <?php echo $name; ?>, <?php echo $email; ?>, <?php echo $phone; ?> | <b>UserType :</b> <?php echo $role_name; ?></p>

 </section>
</body>

</html>
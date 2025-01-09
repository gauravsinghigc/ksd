<?php
require '../../require/modules.php';
require "../../require/admin/sessionvariables.php";
require '../../include/admin/common.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title><?php echo company_name; ?> All Projects</title>
</head>

<body onload="doConvert()" style="font-size:13px !important;color: black !important;margin:auto;font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">

 <section style="border-style:groove; border-width:thin;margin: auto; width: 1000px;border: 1px solid rgb(147 78 255);padding: 5px;">
  <small class="float:left;"><i></i></small>
  <div style="text-align:center;">
   <h3 style="line-height:1;margin-bottom:4px;margin-top:0px;font-size:24px !important;">
    ALL PROJECTS<br>
    <small style="color:grey; font-size:19px !important;">PROJECT REPORTS</small>
   </h3>
  </div>
  <?php include "../../include/export/rc-header.php"; ?>
  <hr>
  <table style="width:100%;">
   <thead>
    <tr style="background-color:lightgray;">
     <th>S.No</th>
     <th>project_title</th>
     <th>project_type</th>
     <th>project_descriptions</th>
     <th>project_area</th>
     <th>project_status</th>
     <th>Units</th>
     <th>created_at</th>
     <th>updated_at</th>
    </tr>
   </thead>
   <tbody>
    <?php
    if (isset($_GET['search_type'])) {
     $search_type = $_GET['search_type'];
     $search_value = $_GET['search_value'];
     $SelectProjects = SELECT("SELECT * from projects where company_id='" . company_id . "' and $search_type like '%$search_value%' ORDER BY Projects_id DESC");
    } else {
     $SelectProjects = SELECT("SELECT * from projects where company_id='" . company_id . "' ORDER BY Projects_id DESC");
    }
    $count = 0;
    while ($projects = mysqli_fetch_array($SelectProjects)) {
     $count++;
     $Projects_id = $projects['Projects_id'];
     $project_title = $projects['project_title'];
     $project_type = $projects['project_type'];
     $project_descriptions = $projects['project_descriptions'];
     $project_area = $projects['project_area'];
     $project_measure_unit = $projects['project_measure_unit'];
     $project_status = $projects['project_status'];
     $created_at = $projects['created_at'];
     $updated_at = $projects['updated_at'];
     $CountTotalProjectUntits = TOTAL("SELECT * FROM projects, project_units where projects.Projects_id=project_units.project_id and projects.Projects_id='$Projects_id'");
     if ($CountTotalProjectUntits == 0) {
      $CountTotalProjectUntits = 0;
      $BtnStatus = "";
     } else {
      $CountTotalProjectUntits = $CountTotalProjectUntits;
      $BtnStatus = "hidden";
     }  ?>
     <tr>
      <td><?php echo $count; ?></td>
      <td>(P<?php echo $Projects_id; ?>) <?php echo $project_title; ?></td>
      <td><?php echo $project_type; ?></td>
      <td style="width:30%;"><?php echo $project_descriptions; ?></td>
      <td><?php echo $project_area; ?> <?php echo $project_measure_unit; ?></td>
      <td><?php echo $project_status; ?></td>
      <td><?php echo $CountTotalProjectUntits; ?> Units</td>
      <td><?php echo $created_at; ?></td>
      <td><?php echo $updated_at; ?></td>
     </tr>
    <?php }
    ?>
   </tbody>
  </table>
  <p style="color:grey; font-size:10px;text-align:center;"><b>Exported On:</b> <?php echo date("D d M, Y"); ?> by (UID : <?php echo $UserId; ?>) <?php echo $name; ?>, <?php echo $email; ?>, <?php echo $phone; ?> | <b>UserType :</b> <?php echo $role_name; ?></p>
 </section>
</body>

</html>
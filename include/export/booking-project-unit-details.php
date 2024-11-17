<?php
//unit details
$UnitSQL = "SELECT * FROM project_units where project_units_id='$project_unit_id'";
$project_block_id = FETCH($UnitSQL, "project_block_id");
$project_floor_id = FETCH($UnitSQL, "project_floor_id");

$project_block_name = FETCH("SELECT project_block_name FROM project_blocks where project_block_id='$project_block_id'", "project_block_name");
$projects_floor_name = FETCH("SELECT projects_floor_name from projects_floors WHERE projects_floors_id='$project_floor_id'", "projects_floor_name");
$projects_floors_tag = FETCH("SELECT projects_floors_tag from projects_floors WHERE projects_floors_id='$project_floor_id'", "projects_floors_tag");
$project_unit_bhk_type = FETCH("SELECT project_unit_bhk_type FROM project_units where project_units_id='$project_unit_id'", "project_unit_bhk_type");
$project_unit_highlights = FETCH("SELECT project_unit_highlights FROM project_units where project_units_id='$project_unit_id'", "project_unit_highlights");
$unit_broker_rate = FETCH("SELECT unit_broker_rate FROM project_units where project_units_id='$project_unit_id'", "unit_broker_rate");
?>

<table style="text-align:left;line-height: 17px;">
  <tr>
    <th>Project Name :</th>
    <td><?php echo $project_name; ?></td>
  </tr>
  <tr>
    <th>Unit Details: :</th>
    <td><?php
        $inputString = $unit_name; // Your input string

        // Use preg_replace to remove alphabets and get only numbers
        $numbersOnly = preg_replace("/[^0-9]/", "", $inputString);
        echo $project_block_name . ", " . $projects_floor_name . ", " . $numbersOnly . "- $project_unit_bhk_type"; ?></td>
  </tr>
  <tr>
    <th>Unit Area :</th>
    <td><?php echo $unit_area; ?></td>
  </tr>
  <tr>
    <th>Rate:</th>
    <td>Rs.<?php echo $unit_rate; ?>/unit area</td>
  </tr>
  <tr>
    <th>Unit Cost:</th>
    <td>Rs.<?php echo $unit_cost; ?></td>
  </tr>
  <tr>
    <th>Possession:</th>
    <td><?php echo $possession; ?></td>
  </tr>
</table>
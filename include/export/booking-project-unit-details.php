<table style="text-align:left;line-height: 17px;">
  <tr>
    <th>Project Name :</th>
    <td><?php echo $project_name; ?></td>
  </tr>
  <tr>
    <th>Plot No: :</th>
    <td><?php
        $inputString = $unit_name; // Your input string

        // Use preg_replace to remove alphabets and get only numbers
        $numbersOnly = preg_replace("/[^0-9]/", "", $inputString);
        echo $numbersOnly; ?></td>
  </tr>
  <tr>
    <th>Plot Area :</th>
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
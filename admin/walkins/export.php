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
 <title><?php echo $company_name; ?> All Projects</title>
</head>

<body onload="doConvert()" style="color: #505050;margin:auto;font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">

 <section style="border-style:groove; border-width:thin;margin: auto; width: 950px;border: 1px solid rgb(147 78 255);padding: 5px;">
  <small class="float:left;"><i></i></small>
  <div style="text-align:center;">
   <h3 style="line-height:1;margin-bottom:4px;margin-top:0px;">
    ALL WALKINS/ENQUIRIES<br>
    <small style="color:grey; font-size:11px;">WALKINS REPORTS</small>
   </h3>
  </div>
  <?php include "../../include/export/rc-header.php"; ?>
  <hr>
  <table style="width:100%;box-shadow: 0px 0px 1px grey;font-size:10px;">
   <thead>
    <tr style="box-shadow:0px 0px 1px grey;background-color:lightgray;">
     <th style="width:5%;">WalkinId</th>
     <th>WalkinName</th>
     <th>WalkinPhone</th>
     <th>WalkinAddress</th>
     <th>WalkinEmailid</th>
     <th>WalkinTypes</th>
     <th>WalkinCreatedAt</th>
     <th>Details</th>
    </tr>
   </thead>
   <tbody>
    <?php
    if (isset($_GET['search'])) {
     $search_type = $_GET['search_type'];
     $search_value = $_GET['search_value'];
     $SQL_expanses = SELECT("SELECT * FROM walkins where $search_type like '%$search_value%' ORDER BY walkinsid DESC");
    } else {
     $SQL_expanses = SELECT("SELECT * FROM walkins ORDER BY walkinsid DESC");
    }
    $Count = 0;
    while ($Fetchexpanses = mysqli_fetch_array($SQL_expanses)) {
     $walkinsid  = $Fetchexpanses['walkinsid'];
     $WalkinName = $Fetchexpanses['WalkinName'];
     $WalkinPhone = $Fetchexpanses['WalkinPhone'];
     $WalkinAddress = SECURE($Fetchexpanses['WalkinAddress'], "d");
     $WalkinEmailid = $Fetchexpanses['WalkinEmailid'];
     $WalkinTypes = $Fetchexpanses['WalkinTypes'];
     $WalkinsRemarks = SECURE($Fetchexpanses['WalkinsRemarks'], "d");
     $WalkinCreatedAt = $Fetchexpanses['WalkinCreatedAt'];
     $Count++;
    ?>
     <tr>
      <td><?php echo $Count; ?></td>
      <td><?php echo $WalkinName; ?></td>
      <td><?php echo $WalkinPhone; ?></td>
      <td><?php echo $WalkinTypes; ?></td>
      <td><?php echo $WalkinEmailid; ?></td>
      <td><?php echo $WalkinAddress; ?></td>
      <td><?php echo $WalkinCreatedAt; ?></td>
      <td>
       <?php echo $WalkinsRemarks; ?>
      </td>
     </tr>
    <?php } ?>
   </tbody>
  </table>
  <p style="color:grey; font-size:10px;text-align:center;"><b>Exported On:</b> <?php echo date("D d M, Y"); ?> by (UID : <?php echo $UserId; ?>) <?php echo $name; ?>, <?php echo $email; ?>, <?php echo $phone; ?> | <b>UserType :</b> <?php echo $role_name; ?></p>
 </section>
</body>

</html>
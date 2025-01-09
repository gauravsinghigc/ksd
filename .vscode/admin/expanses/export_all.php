<?php
require '../../config.php';
require '../common.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>All Expanses</title>
</head>

<body onload="doConvert()" style="font-size:13px !important;color: black !important;margin:auto;font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">

 <section style="border-style:groove; border-width:thin;margin: auto; width: 950px;border: 1px solid rgb(147 78 255);padding: 5px;">
  <small class="float:left;"><i></i></small>
  <div style="text-align:center;">
   <h3 style="line-height:1;margin-bottom:4px;margin-top:0px;font-size:24px !important;">
    ALL EXPANSES<br>
    <small style="color:grey; font-size:19px !important;">EXPANSE REPORT</small>
   </h3>
  </div>
  <?php include "../../include/export/rc-header.php"; ?>
  <hr>
  <table class="table table-striped" id="example" style="width:100% !important;">
   <thead>
    <tr>
     <th style=" width:5%;">ExpanseId</th>
     <th>Title</th>
     <th>Tag</th>
     <th>Date</th>
     <th>Amount</th>
     <th style="width:15%;">Action</th>
    </tr>
   </thead>
   <tbody>
    <?php
    if (isset($_GET['search'])) {
     $search_type = $_GET['search_type'];
     $search_value = $_GET['search_value'];
     $SQL_expanses = SELECT("SELECT * FROM expanses where $search_type like '%$search_value%' ORDER BY expanses_id DESC");
    } else {
     $SQL_expanses = SELECT("SELECT * FROM expanses ORDER BY expanses_id DESC");
    }
    $Count = 0;
    while ($Fetchexpanses = mysqli_fetch_array($SQL_expanses)) {
     $Count++;
     $expanses_id = $Fetchexpanses['expanses_id'];
     $expanse_created_by = $Fetchexpanses['expanse_created_by'];
     $expanses_title = $Fetchexpanses['expanses_title'];
     $expanses_tags = $Fetchexpanses['expanses_tags'];
     $expanse_date = $Fetchexpanses['expanse_date'];
     $expanse_amount = $Fetchexpanses['expanse_amount'];
     $expanse_description = html_entity_decode($Fetchexpanses['expanse_description']);
     $expanses_created_at = $Fetchexpanses['expanses_created_at'];
     $expanse_file = $Fetchexpanses['expanse_file'];
     $year = date("Y", strtotime($expanse_date));
     $month = date("M", strtotime($expanse_date));
    ?>
     <tr>
      <td><?php echo $Count; ?></td>
      <td><?php echo $expanses_title; ?></td>
      <td><?php echo $expanses_tags; ?></td>
      <td><?php echo date("d M, Y", strtotime($expanse_date)); ?></td>
      <td><i class="fa fa-inr text-success"></i> <?php echo $expanse_amount; ?></td>
      <td>
       <?php if ($expanse_file == "null") {
        echo "No File";
       } else { ?>
        <a href="<?php echo $DOMAIN; ?>/storage/expanses/<?php echo $year; ?>/<?php echo $month; ?>/<?php echo $expanse_file; ?>" class="btn btn-sm btn-primary" target="_blank"><i class="fa fa-eye"></i> File</a>
       <?php } ?>
      </td>
     </tr>
    <?php } ?>
   </tbody>
  </table>
  <p style="color:grey; font-size:10px;text-align:center;"><b>Exported On:</b> <?php echo date("D d M, Y"); ?> by (UID : <?php echo $UserId; ?>) <?php echo $name; ?>, <?php echo $email; ?>, <?php echo $phone; ?> | <b>UserType :</b> <?php echo $role_name; ?></p>

 </section>
</body>

</html>
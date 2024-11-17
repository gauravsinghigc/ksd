<?php
require 'require/modules.php';
require 'include/extra/web_body.php';
require 'include/extra/web_common.php'; ?>
<!DOCTYPE html>
<html>

<head>
 <meta charset="UTF-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="generator" content="<?php echo DEVELOPED_BY; ?>, App Version <?php echo APP_VERSION; ?>">
 <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
 <title>Home | <?php echo company_name; ?></title>
 <?php include 'app/include/meta.php'; ?>

 <?php include 'app/include/header_files.php'; ?>
</head>

<body>

 <?php
 //Body Files
 require 'include/extra/web_body.php'; ?>

 <?php
 include 'app/include/header.php';
 include 'app/include/slider.php';
 include 'app/include/intro.php';
 include "app/include/pro_section.php";
 include 'app/include/contact_query.php';
 include 'app/include/follow.php';
 include 'app/include/footer.php';
 ?>

 <?php
 include 'app/include/scripts.php'; ?>
</body>

</html>
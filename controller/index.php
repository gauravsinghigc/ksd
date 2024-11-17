<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <meta name="Description" content="Enter your description here" />
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/css/bootstrap.min.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
 <link rel="stylesheet" href="assets/css/style.css">
 <title>Run Any Url</title>
</head>

<body>
 <div class="container">
  <div class="row">
   <div class='col-md-12'>
    <form class="row">
     <div class='col-md-8'>
      <label>Enter Url</label>
      <input type="url" name="url" class='form-control'>
     </div>
     <div class='col-md-4'>
      <button type="submit" name="go">View</button>
     </div>
    </form>
   </div>
  </div>
 </div>
 <?php
 if (isset($_GET['go'])) {
  $url = $_GET['url'];
  header("location: $url");
 }
 ?>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/js/bootstrap.min.js"></script>
</body>

</html>
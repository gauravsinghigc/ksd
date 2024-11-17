<?php
//date formates
function DATE_FORMATE($format, $date)
{
 $newdateformate = date("$format", strtotime($_REQUEST["$date"]));
 return $newdateformate;
}

//date formates
function DATE_FORMATE2($format, $date)
{
 $newdateformate = $date;
 if ($date == null  || $date == "" || $date == "0000-00-00" || $date == " ") {
  $newdateformate = "No Update";
 } else {
  $newdateformate = date("$format", strtotime($date));
 }
 return $newdateformate;
}

//RequestDataTypeDate
function RequestDataTypeDate()
{
 $date = date('Y-m-d h:m:s A');
 return $date;
}

//request data type date as a contstant
define("RequestDataTypeDate", RequestDataTypeDate());

// pagination 
function PaginationFooter(int $TotalItems = 0, $RedirectForAll = "index.php")
{
 $RecordLimit = 15;

 // Get current page number
 if (isset($_GET["view_page"])) {
  $page = $_GET["view_page"];
 } else {
  $page = 1;
 }
 $next_page = ($page + 1);
 if ($page == 1) {
  $previous_page = $page;
 } else {
  $previous_page = ($page - 1);
 }
 $NetPages = round(($TotalItems / $RecordLimit) + 0.5);
 if (isset($_GET)) {
  $Paramertre = "";
  $FormParam = "";
  foreach ($_GET as $get => $value) {
   if ($get != "view_page") {
    $Paramertre .= "&" . $get . "=" . $value;


    $FormParam .= "<input type='text' name='$get' value='$value' hidden>";
   }
  }
 } else {
  $Paramertre = "";
  $FormParam = "";
 }
?>
 <div class="col-md-12 flex-s-b mt-2 mb-1">
  <div class="">
   <h6 class="mb-0 text-light" style="font-size:0.75rem;"><span class='text-black bold'>Page</span> <b class="text-danger fs-12"><?php echo IfRequested("GET", "view_page", $page, false); ?></b> <span class='text-black bold'>from</span> <b class="text-success fs-12"><?php echo $NetPages; ?> </b> <span class='text-black'>pages</span> <br> <span class='text-black bold'>Total</span> <b class="text-primary fs-12"><?php echo $TotalItems; ?></b> <span class="text-black"> entries </span></h6>
  </div>
  <div class="flex">
   <span class="mr-1">
    <a href="?view_page=<?php echo $previous_page; ?><?php echo $Paramertre; ?>" class="btn btn-sm btn-default"><i class="fa fa-angle-double-left"></i></a>
   </span>
   <form id='PaginationForm'>
    <input type="number" name="view_page" onchange="document.getElementById('PaginationForm').submit()" class="form-control form-control-sm  mb-0" min="1" max="<?php echo $NetPages; ?>" value="<?php echo IfRequested("GET", "view_page", 1, false); ?>">
    <?php echo $FormParam; ?>
   </form>
   <span class="ml-1">
    <a href="?view_page=<?php echo $next_page; ?><?php echo $Paramertre; ?>" class="btn btn-sm btn-default"><i class="fa fa-angle-double-right"></i></a>
   </span>
   <?php if (isset($_GET['view_page'])) { ?>
    <span class="ml-1">
     <a href="<?php echo $RedirectForAll; ?>" class="btn btn-sm btn-danger mb-0"><i class="fa fa-times m-1"></i></a>
    </span>
   <?php } ?>
  </div>
 </div>
<?php
}

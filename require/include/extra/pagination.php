<div class="col-md-12 flex-s-b mt-2 mb-1">
 <div class="">
  <h6 class="mb-0 ml-0" style="font-size:0.8rem;color:grey;">Page <b><?php echo IfRequested("GET", "view_page", $view_page, false); ?></b> from <b><?php echo $NetPages; ?> </b> pages. Total <b><?php echo $TotalItems; ?></b> Entries</h6>
 </div>
 <div class="flex">
  <span class="mr-1">
   <a href="?view_page=<?php echo $previous_page; ?>" class="btn btn-sm btn-default"><i class="fa fa-angle-double-left"></i></a>
  </span>
  <form>
   <input type="number" name="view_page" onchange="form.submit()" class="form-control form-control-sm mb-0" min="1" max="<?php echo $NetPages; ?>" value="<?php echo IfRequested("GET", "view_page", 1, false); ?>">
  </form>
  <span class="ml-1">
   <a href="?view_page=<?php echo $next_page; ?>" class="btn btn-sm btn-default"><i class="fa fa-angle-double-right"></i></a>
  </span>
  <?php if (isset($_GET['view_page'])) { ?>
   <span class="ml-1">
    <a href="index.php" class="btn btn-sm btn-danger mb-0"><i class="fa fa-times m-1"></i></a>
   </span>
  <?php } ?>
 </div>
</div>
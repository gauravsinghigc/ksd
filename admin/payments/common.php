<div class="btn-group btn-group-sm w-100">
 <a class="btn btn-primary square" href="<?php echo DOMAIN; ?>/admin/payments/search/">Add Payments</a>
 <a href="<?php echo DOMAIN; ?>/admin/payments/cash-payments/" class="btn btn-success square">Cash</a>
 <a href="<?php echo DOMAIN; ?>/admin/payments/check-payments/" class="btn btn-warning square">Cheque</a>
 <a href="<?php echo DOMAIN; ?>/admin/payments/online-payments/" class="btn btn-info square">Online</a>
 <a href="<?php echo DOMAIN; ?>/admin/payments/" class="btn btn-primary square">All Payments</a>
 <?php if (isset($_GET['search'])) { ?>
  <a href="<?php echo DOMAIN; ?>/admin/payments/export_all.php?search_type=<?php echo $_GET['search_type']; ?>&search_value=<?php echo $_GET['search_value']; ?>&search=true" target="blank" class="btn btn-secondary square btn-labeled fa fa-print">Export All</a>
 <?php } else { ?>
  <a href="<?php echo DOMAIN; ?>/admin/payments/export_all.php" target="blank" class="btn btn-default square">Export All</a>
 <?php } ?>
 <a href="<?php echo DOMAIN; ?>/admin/payments/csv-export-payment.php" target="blank" class="btn btn-default square">Export CSV</a>

</div>
<?php
$SerialNo = 0;
if (isset($_GET['view_page'])) {
 if ($view_page == 1) {
  $SerialNo = 0;
 } elseif ($view_page != 1) {
  $SerialNo = 30 * ($view_page - 1);
 } else {
  $SerialNo = $start;
 }
} else {
 $SerialNo = $SerialNo;
}

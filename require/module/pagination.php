<?php
function CalculatePages($TotalItems, $end, $return)
{
  //paginations
  $start = 0;
  $end = $end;
  $view_page = 1;
  $listcounts = $end;
  if (isset($_GET['view_page'])) {
    $view_page = (int)$_GET['view_page'];
    if ($view_page != 1) {
      $start = $end;
      $end = $start + $end;
      $next_page = $view_page + 1;
      $previous_page = $view_page - 1;
    } else {
      $next_page = $view_page + 1;
      $previous_page = 1;
    }
  } else {
    $next_page = $view_page + 1;
    $previous_page = 1;
  }
  $NetPages = round((int)$TotalItems / $listcounts + 0.6);
  if ($NetPages == 0) {
    $NetPages = 1;
  } else {
    $NetPages = $NetPages;
  }

  if ($view_page == $NetPages) {
    $next_page = $NetPages;
  } else {
    $next_page = $next_page;
  }


  if ($return == "start") {
    return $start;
  } elseif ($return == "end") {
    return $end;
  } elseif ($return == "next_page") {
    return $next_page;
  } elseif ($return == "previous_page") {
    return $previous_page;
  } elseif ($return == "NetPages") {
    return $NetPages;
  } elseif ($return == "view_page") {
    return $view_page;
  } elseif ($return == "listcounts") {
    return $listcounts;
  } else {
    return null;
  }
}

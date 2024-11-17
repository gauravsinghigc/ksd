<?php
//get all files in a directory
function getDirContents($dir, &$results = array())
{
 $files = scandir($dir);

 foreach ($files as $key => $value) {
  $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
  if (!is_dir($path)) {
   $results[] = $path;
  } else if ($value != "." && $value != "..") {
   getDirContents($path, $results);
   $results[] = $path;
  }
 }

 foreach ($results as $value) {
  echo "<a href='" . $value . "'>File</a><br>";
 }
}

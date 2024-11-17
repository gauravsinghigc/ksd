<?php

//controller request
function CONTROLLER($controllername = null)
{

 if ($controllername == null) {
  $controller = "";
 } else if ($controllername == true) {
  $controller = RUNNING_URL;
 } else {
  $controller = CONTROLLER . "/" . $controllername . ".php";
 }

 return $controller;
}

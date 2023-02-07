<?php

function __autoload($className)
{
  if (file_exists("app/$className.php")) {
    require_once "app/$className.php";
  }
}
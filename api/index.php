<?php

require "./autoload.php";

$zipcode = new GetZipCode('38061050');
$data = $zipcode->getData();

if ($zipcode) {
  $data = $zipcode->getData();

  header('Content-type: application/json');
  die(json_encode($data));
}
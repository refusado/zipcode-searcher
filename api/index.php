<?php

require "./autoload.php";

header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");

if (isset($_GET['zipcode'])) {
  $zipcode = new GetZipCode($_GET['zipcode']);

  if ($zipcode) {
    $data = $zipcode->getData();
    die(json_encode($data));
  }
} else {
  $response = [
    "error" => "Nenhum CEP enviado"
  ];

  die(json_encode($response));
}

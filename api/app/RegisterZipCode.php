<?php

class RegisterZipCode
{
  private $BASE_URL = "https://viacep.com.br/ws";
  private $DB_PATH  = "db/database.sqlite";

  public function __construct($cep)
  {
    $data = $this->requestZipCode($cep);

    foreach ($data as $key => $value) {
      if (!is_string($value)) {
        $data->$key = "";
      }
    }

    $this->registerData($data);
  }

  private function requestZipCode($cep)
  {
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, "$this->BASE_URL/$cep/xml");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);
    
    curl_close($curl);

    $xml = simplexml_load_string($response);
    $json = json_encode($xml);
    $array = json_decode($json);

    return $array;
  }

  private function registerData($data)
  {
    $createTable = "CREATE TABLE IF NOT EXISTS zip_codes (
      cep TEXT (9) PRIMARY KEY,
      logradouro TEXT,
      complemento TEXT,
      bairro TEXT,
      localidade TEXT,
      uf TEXT (2),
      ibge INTEGER (7),
      gia INTEGER,
      ddd INTEGER (2),
      siafi TEXT )
    ";

    $insertData = "INSERT INTO zip_codes (
      cep, logradouro, complemento, bairro, localidade, uf, ibge, gia, ddd, siafi
    ) VALUES (
      '$data->cep',
      '$data->logradouro',
      '$data->complemento',
      '$data->bairro',
      '$data->localidade',
      '$data->uf',
      '$data->ibge',
      '$data->gia',
      '$data->ddd',
      '$data->siafi'
    )";

    $pdo = new PDO("sqlite:$this->DB_PATH");
    $pdo->exec($createTable);
    $pdo->exec($insertData);
  }
}



















/*
cep
logradouro
complemento
bairro
localidade
uf
ibge
gia
ddd
siafi
*/
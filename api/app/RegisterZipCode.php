<?php

class RegisterZipCode
{
  private $BASE_URL = "https://viacep.com.br/ws";
  private $DB_PATH  = "db/database.sqlite";

  private function requestZipCode($zipCode)
  {
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, "$this->BASE_URL/$zipCode/xml");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);
    
    curl_close($curl);

    $xml = simplexml_load_string($response);
    $json = json_encode($xml);
    $data = json_decode($json);

    if (@$data->erro) {
      return false;
    }

    return $data;
  }

  private function registerData($data)
  {
    $sqlCreateTable = "CREATE TABLE IF NOT EXISTS zip_codes (
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

    $sqlInsertData = "INSERT INTO zip_codes (
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

    $sqlGetLastRow = "SELECT * FROM zip_codes WHERE cep = '$data->cep'";

    $pdo = new PDO("sqlite:$this->DB_PATH");
    $pdo->exec($sqlCreateTable);
    $pdo->exec($sqlInsertData);

    $query = $pdo->query($sqlGetLastRow);
    return $query->fetchAll();
  }

  public function getRegister($zipCode)
  {
    $data = $this->requestZipCode($zipCode);

    if (!$data) {
      return false;
    }

    foreach ($data as $key => $value) {
      if (!is_string($value)) {
        $data->$key = "";
      }
    }

    return $this->registerData($data);
  }
}

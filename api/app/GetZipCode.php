<?php

class GetZipCode
{
  private $DB_PATH  = "db/database.sqlite";
  private $data;

  public function __construct($code)
  {
    $code = str_replace('-', '', $code);
    $code = str_replace(' ', '', $code);
    $formatted  = substr_replace($code, "-", 5, 0);

    $isValid = preg_match("/^[0-9]{5}-[0-9]{3}$/", $formatted);

    if (!$isValid) {
      $this->data = [
        "error" => "Formato de CEP inválido"
      ];

      return false;
    }

    $pdo = new PDO("sqlite:$this->DB_PATH");
    $query = $pdo->query("SELECT * FROM zip_codes WHERE cep = '$formatted '");

    $result = $query->fetchAll();

    if (!$result) {
      $searcher = new RegisterZipCode();
      $register = $searcher->getRegister($code);

      if (!$register) {
        $this->data = [
          "error" => "CEP não encontrado"
        ];

        return false;
      }

      $result = $register;
    }

    $this->data = [
      'cep'         => $result[0]['cep'],
      'logradouro'  => $result[0]['logradouro'],
      'complemento' => $result[0]['complemento'],
      'bairro'      => $result[0]['bairro'],
      'localidade'  => $result[0]['localidade'],
      'uf'          => $result[0]['uf'],
      'ibge'        => $result[0]['ibge'],
      'gia'         => $result[0]['gia'],
      'ddd'         => $result[0]['ddd'],
      'siafi'       => $result[0]['siafi'],
    ];
  }

  public function getData()
  {
    return $this->data;
  }
}
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
      return $this->data = [ "error" => "CEP inválido" ];
    }

    $pdo = new PDO("sqlite:$this->DB_PATH");
    $query = $pdo->query("SELECT * FROM zip_codes WHERE cep = '$formatted '");

    $result = $query->fetchAll();

    // SE O CEP NÃO ESTIVER REGISTRADO NO BANCO, REGISTRE E ATRIBUA OS DADOS
    if (!$result) {
      $register = new RegisterZipCode($code);
      $result = $register->getRegister();
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
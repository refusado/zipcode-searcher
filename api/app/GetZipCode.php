<?php

class GetZipCode
{
  private $DB_PATH  = "db/database.sqlite";

  public function __construct($zipCode)
  {
    $finalCode = substr_replace($zipCode, "-", 5, 0);

    $pdo = new PDO("sqlite:$this->DB_PATH");
    $query = $pdo->query("SELECT * FROM zip_codes WHERE cep = '$finalCode'");

    $result = $query->fetchAll();

    // SE O CEP NÃO ESTIVER REGISTRADO NO BANCO, REGISTRE-O E COLETE OS DADOS
    if (!$result) {
      $register = new RegisterZipCode($zipCode);
      $result = $register->getRegister();
    }

    echo '<pre>';
    print_r($result);
    echo '</pre>';
  }
}
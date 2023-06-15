
<?php

$username = "root";
$password = "";

try {

  $conn = new PDO('mysql:host=localhost;dbname=quiz_paises', $username, $password);

  $sql = "SELECT count(id) FROM paises";
  $stmt = $conn->prepare($sql);
  $stmt->execute();

  $rowsLength = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $rows = $rowsLength[0]['count(id)'];

  function returnArray($rows)
  {
    $arrayNumeros = [];

    for ($i = 0; $i <= 3; $i++) {
      # code...
      $numeroAleatorio = rand(1, $rows);
      array_push($arrayNumeros, $numeroAleatorio);
    }

    return $arrayNumeros;
  }

  while (true) {
    $array = array_unique(returnArray($rows));
    if (count($array) == 4) {
      break;
    }
  }

  $countryData = [];

  $arrayCountriesNames = [];

  for ($i = 0; $i < count($array); $i++) {
    # code...
    $contador = $array[$i];
    $sql = "SELECT * FROM paises WHERE id = $contador";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $dado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($i == 0) {
      $countryData = $dado;
    } else {
      array_push($arrayCountriesNames, $dado["nome"]);
    }
  }

  $arrayTeste = [
    "countryData" => $countryData,
    "countries" => $arrayCountriesNames
  ];

  echo json_encode($arrayTeste);
} catch (PDOException $e) {
  echo $e->getMessage();
}

?>

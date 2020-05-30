<?php

$hostname = "localhost";
$dbname = "my_carbase";
$username = "root";
$password = "";
$provincia = $_GET['dato'];

try {
    $conn = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Errore: " . $e->getMessage();
    die();
}
$sqlquery = "SELECT italy_cities.comune FROM italy_cities INNER JOIN italy_provincies ON (italy_cities.provincia = italy_provincies.sigla) WHERE (italy_provincies.provincia = \"$provincia\");";
$result = $conn->query($sqlquery);

if ($result->rowCount() == 0) {
    echo "<center><p>La ricerca non ha prodotto nessun risultato</p></center>";
} else {
    echo "<option value=\"\">Seleziona citt&agrave;...</option>";
    while ($row = $result->fetch()) {
        $value = $row["comune"];
        echo "<option value=\"" . $value . "\">" . $value . "</option>";
    }
    unset($result);
}
unset($conn);

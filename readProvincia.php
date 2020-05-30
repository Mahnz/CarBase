<?php

$hostname = "localhost";
$dbname = "my_carbase";
$username = "root";
$password = "";
$regione = $_GET['dato'];

try {
    $conn = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Errore: " . $e->getMessage();
    die();
}

$sqlquery = "SELECT DISTINCT italy_provincies.provincia FROM italy_provincies INNER JOIN italy_munic ON (italy_provincies.sigla = italy_munic.provincia) WHERE (italy_munic.regione = \"$regione\");";
$result = $conn->query($sqlquery);

if ($result->rowCount() == 0) {
    echo "<center><p>La ricerca non ha prodotto nessun risultato</p></center>";
} else {
    echo "<option value=\"\">Seleziona provincia...</option>";
    while ($row = $result->fetch()) {
        $value = $row["provincia"];
        echo "<option value=\"" . $value . "\">" . $value . "</option>";
    }
    unset($result);
}
unset($conn);

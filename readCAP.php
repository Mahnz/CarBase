<?php

$hostname = "localhost";
$dbname = "my_carbase";
$username = "root";
$password = "";
$citta = $_GET['dato'];

try {
    $conn = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Errore: " . $e->getMessage();
    die();
}

$sqlquery = "SELECT cap FROM italy_cap INNER JOIN italy_munic ON (italy_cap.istat = italy_munic.istat) WHERE (italy_munic.comune = \"$citta\");";
$result = $conn->query($sqlquery);

if ($result->rowCount() == 0) {
    echo "<center><p>La ricerca non ha prodotto nessun risultato</p></center>";
} else {
    while ($row = $result->fetch()) {
        $value = $row["cap"];
        echo $value;
    }
    unset($result);
}
unset($conn);

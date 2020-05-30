<?php
$hostname = "localhost";
$dbname = "my_carbase";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Errore: " . $e->getMessage();
    die();
}

if (isset($_POST['inputEmailAddress']) &&  isset($_POST['inputPassword'])) {
    $email = $_POST['inputEmailAddress'];
    $password = $_POST['inputPassword'];
} else {
    header("Location: login.php?role=" . $_POST['role'] . "&case=POST");
}
session_start();

if ($_POST['role'] == "cittadino") {
    $sqlquery = "SELECT count(*) AS num FROM Passwords INNER JOIN AccountCittadini INNER JOIN Email ON (Passwords.Codice = AccountCittadini.CodicePassword) WHERE (Passwords.valore = '$password' AND Email.valore = '$email');";
    $result = $conn->query($sqlquery);
    while ($row = $result->fetch()) {
        $value = $row["num"];
    }
    if ($value == 1) {
        $sqlquery = "SELECT Codice FROM Email INNER JOIN AccountCittadini ON (Email.Codice = AccountCittadini.CodiceEmail) WHERE (Email.valore = \"$email\");";
        $result = $conn->query($sqlquery);
        while ($row = $result->fetch()) {
            $codiceEmail = $row["Codice"];
        }
        $sqlquery = "SELECT CodiceCittadino FROM AccountCittadini INNER JOIN Email INNER JOIN Passwords ON (AccountCittadini.CodiceEmail = Email.Codice) WHERE (Email.Codice = \"$codiceEmail\");";
        $result = $conn->query($sqlquery);
        while ($row = $result->fetch()) {
            $codiceCittadino = $row["CodiceCittadino"];
        }
        $_SESSION['role'] = "cittadino";
        $_SESSION['codice'] = $codiceCittadino;
        $_SESSION['email'] = $email;
        header("Location: index_cittadino.php");
    } else {
        header("Location: login.php?role=" . $_POST['role'] . "&case=fail");
    }
} else if ($_POST['role'] == "assicurazione") {
    $sqlquery = "SELECT count(*) AS num FROM Passwords INNER JOIN AccountImpreseAssicuratrici INNER JOIN Email ON (Passwords.Codice = AccountImpreseAssicuratrici.CodicePassword) WHERE (Passwords.valore = \"$password\" AND Email.valore = \"$email\");";
    $result = $conn->query($sqlquery);
    while ($row = $result->fetch()) {
        $value = $row["num"];
    }
    if ($value == 1) {
        $sqlquery = "SELECT Codice FROM Email INNER JOIN AccountImpreseAssicuratrici ON (Email.Codice = AccountImpreseAssicuratrici.CodiceEmail) WHERE (Email.valore = \"$email\");";
        $result = $conn->query($sqlquery);
        while ($row = $result->fetch()) {
            $codiceEmail = $row["Codice"];
        }
        $sqlquery = "SELECT CodiceImpresa FROM AccountImpreseAssicuratrici INNER JOIN Email INNER JOIN Passwords ON (AccountImpreseAssicuratrici.CodiceEmail = Email.Codice) WHERE (Email.Codice = \"$codiceEmail\");";
        $result = $conn->query($sqlquery);
        while ($row = $result->fetch()) {
            $CodiceImpresa = $row["CodiceImpresa"];
        }
        $_SESSION['role'] = "assicurazione";
        $_SESSION['codice'] = $CodiceImpresa;
        $_SESSION['email'] = $email;
        header("Location: elenco_autoAssicurate.php");
    } else {
        header("Location: login.php?role=" . $_POST['role'] . "&case=fail");
    }
} else if ($_POST['role'] == "motorizzazione") {
    $sqlquery = "SELECT count(*) AS num FROM Passwords INNER JOIN AccountUfficiMotorizzazione INNER JOIN Email ON (Passwords.Codice = AccountUfficiMotorizzazione.CodicePassword) WHERE (Passwords.valore = \"$password\" AND Email.valore=\"$email\");";
    $result = $conn->query($sqlquery);
    while ($row = $result->fetch()) {
        $value = $row["num"];
    }
    if ($value == 1) {
        $sqlquery = "SELECT Codice FROM Email INNER JOIN AccountUfficiMotorizzazione ON (Email.Codice = AccountUfficiMotorizzazione.CodiceEmail) WHERE (Email.valore = \"$email\");";
        $result = $conn->query($sqlquery);
        while ($row = $result->fetch()) {
            $codiceEmail = $row["Codice"];
        }
        $sqlquery = "SELECT CodiceUfficio FROM AccountUfficiMotorizzazione INNER JOIN Email INNER JOIN Passwords ON (AccountUfficiMotorizzazione.CodiceEmail = Email.Codice) WHERE (Email.Codice = \"$codiceEmail\");";
        $result = $conn->query($sqlquery);
        while ($row = $result->fetch()) {
            $CodiceUfficio = $row["CodiceUfficio"];
        }
        $_SESSION['role'] = "motorizzazione";
        $_SESSION['codice'] = $CodiceUfficio;
        $_SESSION['email'] = $email;
        header("Location: index_motorizzazione.html");
    } else {
        header("Location: login.php?role=" . $_POST['role'] . "&case=fail");
    }
}

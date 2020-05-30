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

if ($_POST['soggetto'] == "cittadino") {
    $nome = $_POST['inputNome'];
    $cognome = $_POST['inputCognome'];
    $dataNascita = $_POST['inputData'];
    $sesso = $_POST['inputSesso'];
    $provinciaNascita = $_POST['inputProvinciaNascita'];
    $comuneNascita = $_POST['inputCittaNascita'];
    $codiceFiscale = $_POST['inputCodiceFiscale'];
    $cittaResid = $_POST['inputCittaResidenza'];
    $indirizzo = $_POST['inputIndirizzoResidenza'];
    $civico = $_POST['inputCivico'];
    $telefono = $_POST['inputTelefono'];
    $email = $_POST['inputEmailAddress'];
    $password = $_POST['inputPassword'];
    $conferma = $_POST['inputConfirmPassword'];

    $sqlquery = "SELECT count(*) AS num FROM Email WHERE (Email.valore = '$email');";
    $result = $conn->query($sqlquery);
    while ($row = $result->fetch()) {
        $value = $row["num"];
    }
    if ($value == 1) {
        header("Location: registerCittadino.php?signup=email");
    } else {
        $sqlquery = "SELECT count(*) AS num FROM ElencoTelefonico WHERE (ElencoTelefonico.valore = '$telefono');";
        $result = $conn->query($sqlquery);
        while ($row = $result->fetch()) {
            $value = $row["num"];
        }
        if ($value == 1) {
            header("Location: registerCittadino.php?signup=telefono");
        } else {
            if ($password != $conferma) {
                header("Location: registerCittadino.php?signup=password");
            } else {
                $sqlquery = "INSERT INTO ElencoTelefonico(valore) VALUES(?);";
                $stmt = $conn->prepare($sqlquery);
                $stmt->execute([$telefono]);
                $codiceTelefono = $conn->lastInsertId();

                $sqlquery = "INSERT INTO Email(valore) VALUES(?);";
                $stmt = $conn->prepare($sqlquery);
                $stmt->execute([$email]);
                $codiceEmail = $conn->lastInsertId();

                $sqlquery = "INSERT INTO Passwords (valore) VALUES(?);";
                $stmt = $conn->prepare($sqlquery);
                $stmt->execute([$password]);
                $codicePW = $conn->lastInsertId();

                $sqlquery = "SELECT istat FROM italy_munic WHERE (comune = '$comuneNascita');";
                $result = $conn->query($sqlquery);
                while ($row = $result->fetch()) {
                    $codiceComuneNascita = $row["istat"];
                }

                $sqlquery = "SELECT istat AS num FROM italy_munic WHERE (comune = '$cittaResid');";
                $result = $conn->query($sqlquery);
                while ($row = $result->fetch()) {
                    $codiceComuneResidenza = $row["num"];
                }

                $indirizzo = $indirizzo . ", " . $civico;
                $sqlquery = "INSERT INTO AnagraficaCittadini (Nome, Cognome, CodiceFiscale, Sesso, CodiceComuneNascita, DataNascita, CodiceComuneResidenza, Indirizzo, Telefono) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
                $stmt = $conn->prepare($sqlquery);
                $stmt->execute([$nome, $cognome, $codiceFiscale, $sesso, $codiceComuneNascita, $dataNascita, $codiceComuneResidenza, $indirizzo, $codiceTelefono]);
                $codiceCittadino = $conn->lastInsertId();

                $sqlquery = "INSERT INTO AccountCittadini VALUES(?, ?, ?);";
                $stmt = $conn->prepare($sqlquery);
                $stmt->execute([$codiceCittadino, $codiceEmail, $codicePW]);
                header("Location: login.php?role=cittadino");
            }
        }
    }
} else if ($_POST['soggetto'] == "assicurazione") {
    $denominazione = $_POST['inputDenominazione'];
    $ragioneSociale = $_POST['inputRagioneSociale'];
    $regione = $_POST['inputRegione'];
    $provincia = $_POST['inputProvincia'];
    $comune = $_POST['inputComune'];
    $website = $_POST['inputWebsite'];
    $telefono = $_POST['inputTelefono'];
    $email = $_POST['inputEmailAddress'];
    $password = $_POST['inputPassword'];
    $conferma = $_POST['inputConfirmPassword'];

    $sqlquery = "SELECT count(*) AS num FROM Email WHERE (Email.valore = '$email');";
    $result = $conn->query($sqlquery);
    while ($row = $result->fetch()) {
        $value = $row["num"];
    }

    if ($value == 1) {
        header("Location: registerAssicurazione.php?signup=email");
    } else {
        $sqlquery = "SELECT count(*) AS num FROM ElencoTelefonico WHERE (ElencoTelefonico.valore = '$telefono');";
        $result = $conn->query($sqlquery);

        while ($row = $result->fetch()) {
            $value = $row["num"];
        }
        if ($value == 1) {
            header("Location: registerAssicurazione.php?signup=telefono");
        } else {
            if ($password == $conferma) {
                $sqlquery = "INSERT INTO ElencoTelefonico(valore) VALUES(?);";
                $stmt = $conn->prepare($sqlquery);
                $stmt->execute([$telefono]);
                $codiceTelefono = $conn->lastInsertId();

                $sqlquery = "INSERT INTO Email(valore) VALUES(?);";
                $stmt = $conn->prepare($sqlquery);
                $stmt->execute([$email]);
                $codiceEmail = $conn->lastInsertId();

                $sqlquery = "INSERT INTO Passwords(valore) VALUES(?);";
                $stmt = $conn->prepare($sqlquery);
                $stmt->execute([$password]);
                $codicePW = $conn->lastInsertId();

                $sqlquery = "SELECT istat AS num FROM italy_munic WHERE (comune = '$comune');";
                $result = $conn->query($sqlquery);
                while ($row = $result->fetch()) {
                    $codiceComune = $row["num"];
                }

                $sqlquery = "INSERT INTO ImpreseAssicuratrici(Denominazione, RagSociale, CodiceComune, Telefono, Website, CodiceEmail) VALUES (?, ?, ?, ?, ?, ?);";
                $stmt = $conn->prepare($sqlquery);
                $stmt->execute([$denominazione, $ragioneSociale, $codiceComune, $codiceTelefono, $website, $codiceEmail]);
                $codiceImpresa = $conn->lastInsertId();

                $sqlquery = "INSERT INTO AccountImpreseAssicuratrici VALUES(?, ?, ?);";
                $stmt = $conn->prepare($sqlquery);
                $stmt->execute([$codiceImpresa, $codiceEmail, $codicePW]);
                header("Location: login.php?role=assicurazione");
            }
        }
    }
} else if ($_POST['soggetto'] == "motorizzazione") {
    $regione = $_POST['inputRegione'];
    $provincia = $_POST['inputProvincia'];
    $telefono = $_POST['inputTelefono'];
    $dirigente = $_POST['inputNominativo'];
    $email = $_POST['inputEmailAddress'];
    $password = $_POST['inputPassword'];
    $conferma = $_POST['inputConfirmPassword'];

    $value = 0;
    $sqlquery = "SELECT count(*) AS num FROM Email WHERE (Email.valore = '$email');";
    $result = $conn->query($sqlquery);
    while ($row = $result->fetch()) {
        $value = $row["num"];
    }

    if ($value == 1) {
        header("Location: registerMotorizzazione.php?signup=email");
    } else {
        $sqlquery = "SELECT count(*) AS num FROM ElencoTelefonico WHERE (ElencoTelefonico.valore = '$telefono');";
        $result = $conn->query($sqlquery);
        while ($row = $result->fetch()) {
            $value = $row["num"];
        }
        if ($value == 1) {
            header("Location: registerMotorizzazione.php?signup=telefono");
        } else {
            if ($password == $conferma) {
                $sqlquery = "INSERT INTO ElencoTelefonico(valore) VALUES(?);";
                $stmt = $conn->prepare($sqlquery);
                $stmt->execute([$email]);
                $codiceTelefono = $conn->lastInsertId();

                $sqlquery = "INSERT INTO Email(valore) VALUES(?);";
                $stmt = $conn->prepare($sqlquery);
                $stmt->execute([$email]);
                $codiceEmail = $conn->lastInsertId();

                $sqlquery = "INSERT INTO Passwords(valore) VALUES(?);";
                $stmt = $conn->prepare($sqlquery);
                $stmt->execute([$password]);
                $codicePassword = $conn->lastInsertId();

                $siglaProvincia = "";
                $sqlquery = "SELECT sigla FROM italy_provincies WHERE (provincia = '$provincia');";
                while ($row = $result->fetch()) {
                    $siglaProvincia = $row["sigla"];
                }

                $sqlquery = "INSERT INTO UfficiMotorizzazione (SiglaProvincia, NominativoDirigente, CodiceTelefono, CodiceEmail) VALUES (?, ?, ?, ?);";
                $stmt = $conn->prepare($sqlquery);
                $stmt->execute([$provincia, $dirigente, $codiceTelefono, $codiceEmail]);
                $codiceUfficio = $conn->lastInsertId();

                $sqlquery = "INSERT INTO AccountUfficiMotorizzazione(CodiceUfficio, CodiceEmail, CodicePassword) VALUES (?, ?, ?);";
                $stmt = $conn->prepare($sqlquery);
                $stmt->execute([$codiceUfficio, $codiceEmail, $codicePassword]);
                header("Location: login.php?role=motorizzazione");
            } else {
                header("Location: registerMotorizzazione.php?signup=password");
            }
        }
    }
}

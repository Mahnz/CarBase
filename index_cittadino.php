<?php
session_start();
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
$codiceCittadino = $_SESSION['codice'];
$email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="HandheldFriendly" content="true" />

  <title>Dati Cittadino</title>

  <link rel="icon" type="image/png" href="img/favicon.png">
  <link href="css/styles.css" rel="stylesheet" />
  <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous">
  </script>
</head>

<body class="sb-nav-fixed">
  <header>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
      <a class="navbar-brand" href="index_assicurazione.html">CarBase</a>
      <div class="collapse navbar-collapse flex-grow-1 text-right" id="myNavbar">
        <ul class="navbar-nav ml-auto flex-nowrap">
          <li class="nav-item">
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#">
              <i class="fas fa-bars"></i>
            </button>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <div id="layoutSidenav">
    <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
          <div class="nav">
            <div class="sb-sidenav-menu-heading">Assicurazione</div>
            <a class="nav-link" href="elenco_autoAssicurate.php" selected>
              <div class="sb-nav-link-icon">
                <i class="fas fa-table"></i>
              </div>Automobili assicurate
            </a>
            <a class="nav-link" href="elenco_auto.php">
              <div class="sb-nav-link-icon">
                <i class="fas fa-book-open"></i>
              </div>Elenco delle automobili
            </a>
            <div class="sb-sidenav-menu-heading">Opzioni utente</div>
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
              <div class="sb-nav-link-icon">
                <i class="fas fa-columns"></i>
              </div>Opzioni utente
              <div class="sb-sidenav-collapse-arrow">
                <i class="fas fa-angle-down"></i>
              </div>
            </a>
            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
              <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="index_cittadino.php" selected>Visualizza i tuoi dati</a>
                <a class="nav-link" href="logout.php">Logout</a>
              </nav>
            </div>
          </div>
        </div>
        <div class="sb-sidenav-footer">
          <div class="small">Accesso effettuato come:</div>
          <?php
          $codiceCittadino = $_SESSION['codice'];
          $sqlquery = "SELECT Nome, Cognome FROM AnagraficaCittadini WHERE (Codice = '$codiceCittadino');";
          $result = $conn->query($sqlquery);
          while ($row = $result->fetch()) {
            $nome = $row["Nome"];
            $cognome = $row["Cognome"];
          }
          echo $nome . " " . $cognome;
          ?>
        </div>
      </nav>
    </div>
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid">
          <h1 class="mt-4">Anagrafica del cittadino</h1>
          <div id="col1">
            <h4>Nome:</h4>
            <?php
            $sqlquery = "SELECT Nome FROM AnagraficaCittadini WHERE (Codice = $codiceCittadino);";
            $result = $conn->query($sqlquery);
            while ($row = $result->fetch()) {
              $nome = $row["Nome"];
            }
            echo $nome;
            ?>
            <h4>Cognome:</h4>
            <?php
            $sqlquery = "SELECT Cognome FROM AnagraficaCittadini WHERE (Codice = $codiceCittadino);";
            $result = $conn->query($sqlquery);
            while ($row = $result->fetch()) {
              $cognome = $row["Cognome"];
            }
            echo $cognome;
            ?>
            <h4>Codice Fiscale:</h4>
            <?php
            $sqlquery = "SELECT CodiceFiscale FROM AnagraficaCittadini WHERE (Codice = $codiceCittadino);";
            $result = $conn->query($sqlquery);
            while ($row = $result->fetch()) {
              $cf = $row["CodiceFiscale"];
            }
            echo $cf;
            ?>
            <h4>Sesso:</h4>
            <?php
            $sqlquery = "SELECT Sesso FROM AnagraficaCittadini WHERE (Codice = $codiceCittadino);";
            $result = $conn->query($sqlquery);
            while ($row = $result->fetch()) {
              $sesso = $row["Sesso"];
            }
            echo $sesso;
            ?>
            <h4>Data di nascita:</h4>
            <?php
            $sqlquery = "SELECT DataNascita FROM AnagraficaCittadini WHERE (Codice = $codiceCittadino);";
            $result = $conn->query($sqlquery);
            while ($row = $result->fetch()) {
              $datanascita = $row["DataNascita"];
            }
            $newDate = date("d/m/Y", strtotime($datanascita));
            echo $newDate;
            ?>
          </div>
          <div id="col2">
            <div style="float: left; width: 47%;">

              <h4>Comune di residenza:</h4>
              <?php
              $sqlquery = "SELECT CodiceComuneResidenza FROM AnagraficaCittadini WHERE (Codice = $codiceCittadino);";
              $result = $conn->query($sqlquery);
              while ($row = $result->fetch()) {
                $datanascita = $row["CodiceComuneResidenza"];
              }
              $newDate = date("d/m/Y", strtotime($datanascita));
              echo $newDate;
              ?>

              <h4>Numero della patente:</h4>
              <?php
              $sqlquery = "SELECT count(*) AS num FROM Patenti WHERE (CodiceCittadino = $codiceCittadino);";
              $result = $conn->query($sqlquery);
              while ($row = $result->fetch()) {
                $value = $row["num"];
              }
              if ($value == 0) {
                echo "Nessuna patente registrata";
              } else {
                $sqlquery = "SELECT DISTINCT NumeroDocumento FROM Patenti WHERE (CodiceCittadino = $codiceCittadino);";
                $result = $conn->query($sqlquery);
                $documento = "";
                while ($row = $result->fetch()) {
                  $documento = $row["NumeroDocumento"];
                }
                echo $documento;
              }
              ?>

              <h4>Indirizzo di residenza:</h4>
              <?php
              $sqlquery = "SELECT Indirizzo FROM AnagraficaCittadini WHERE (Codice = $codiceCittadino);";
              $result = $conn->query($sqlquery);
              while ($row = $result->fetch()) {
                $indirizzo = $row["Indirizzo"];
              }
              echo $indirizzo;
              ?>

              <h4>Numero di telefono:</h4>
              <?php
              $sqlquery = "SELECT valore FROM ElencoTelefonico INNER JOIN AnagraficaCittadini ON (ElencoTelefonico.codice = AnagraficaCittadini.Telefono) WHERE (ElencoTelefonico.codice = (SELECT Telefono FROM AnagraficaCittadini WHERE(Codice = $codiceCittadino)));";
              $result = $conn->query($sqlquery);
              while ($row = $result->fetch()) {
                $telefono = $row["valore"];
              }
              echo $telefono;
              ?>
            </div>
            <div style="clear: both;">
            </div>
          </div>
      </main>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous">
  </script>
  <script src="js/scripts.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
  <script src="js/datatables-demo.js"></script>
</body>

</html>
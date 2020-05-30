<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="HandheldFriendly" content="true" />

  <title>Anagrafica cittadino</title>

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
            <a class="nav-link" href="index_assicurazione.html">
              <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div> Automobili assicurate
            </a>
            <a class="nav-link" href="elenco_auto_assicurazione.html">
              <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div> Elenco delle automobili
            </a>
            <div class="sb-sidenav-menu-heading">Opzioni utente</div>
            <a class="nav-link" href="login.html">
              <div class="sb-nav-link-icon" href="logout.php">
                <i class="fas fa-user"></i>
              </div> Logout
            </a>
          </div>
          <div class="sb-sidenav-footer">
            <div class="small">Accesso effettuato come:</div>
            <?php
            $codiceAssicurazione = $_SESSION['codice'];
            $sqlquery = "SELECT Denominazione FROM ImpreseAssicuratrici WHERE (Codice = $codice);";
            $result = $conn->query($sqlquery);
            while ($row = $result->fetch()) {
              $denominazione = $row["Denominazione"];
            }
            echo $denominazione;
            ?>
          </div>
      </nav>
    </div>
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid">
          <h1 class="mt-4">
            <?php
            $codiceAssicurazione = $_SESSION['codice'];
            $sqlquery = "SELECT Denominazione FROM ImpreseAssicuratrici WHERE (Codice = $codice);";
            $result = $conn->query($sqlquery);
            while ($row = $result->fetch()) {
              $denominazione = $row["Denominazione"];
            }
            echo $denominazione;
            ?>
            - Automobili assicurate
          </h1>
          <br />
          <div class="card mb-4">
            <div class="card-header"><i class="fas fa-table mr-1"></i>Visualizzazione</div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Targa</th>
                      <th>Codice telaio</th>
                      <th>Marca</th>
                      <th>Modello</th>
                      <th>Anno di immatricolazione</th>
                      <th>Alimentazione</th>
                      <th>Cambio</th>
                      <th>Numero di posti</th>
                      <th>Numero di porte</th>
                      <th>Valore commerciale</th>
                      <th>Validità assicurazione</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Targa</th>
                      <th>Codice telaio</th>
                      <th>Marca</th>
                      <th>Modello</th>
                      <th>Anno di immatricolazione</th>
                      <th>Alimentazione</th>
                      <th>Cambio</th>
                      <th>Numero di posti</th>
                      <th>Numero di porte</th>
                      <th>Valore commerciale</th>
                      <th>Validità assicurazione</th>
                    </tr>
                  </tfoot>
                  <tbody>
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

                    $sqlquery = "SELECT ID, Targa, CodiceTelaio, CodiceProduttore, Modello, AnnoImmatricolazione, Alimentazione, TipologiaCambio, NPosti, NPorte, ValoreVendita FROM Automobili INNER JOIN ContrattoAssicurativo INNER JOIN ImpreseAssicuratrici ON (Automobili.ID = ContrattoAssicurativo.CodiceAutomobile) WHERE (ImpreseAssicuratrici.Denominazione = \"$nomeAssicurazione\");";
                    $result = $conn->query($sqlquery);

                    if ($result->rowCount() != 0) {
                      while ($row = $result->fetch()) {
                        echo "<tr>";
                        echo "<td>" . $row['ID'] . "</td>";
                        echo "<td>" . $row['Targa'] . "</td>";
                        echo "<td>" . $row['CodiceTelaio'] . "</td>";
                        echo "<td>" . $row['CodiceProduttore'] . "</td>";
                        echo "<td>" . $row['Modello'] . "</td>";
                        echo "<td>" . $row['AnnoImmatricolazione'] . "</td>";
                        echo "<td>" . $row['Alimentazione'] . "</td>";
                        echo "<td>" . $row['TipologiaCambio'] . "</td>";
                        echo "<td>" . $row['NPosti'] . "</td>";
                        echo "<td>" . $row['NPorte'] . "</td>";
                        echo "<td>" . $row['ValoreVendita'] . "</td>";
                        echo "</tr>";
                      }
                      unset($result);
                    }
                    unset($conn);
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </main>
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
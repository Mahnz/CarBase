<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="HandheldFriendly" content="true" />

    <title>Registrazione cittadini</title>

    <link href="css/signUp.css" rel="stylesheet" />
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/navbar.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" />
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
</head>

<body class="bg-primary">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <a class="navbar-brand" href="index.html">
                <img src="img/logo.png" width="60" height="60" alt="" loading="lazy" />
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.html">Chi siamo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contactUs.html">Contattaci</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <main>
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Registrazione</h3>
                                </div>
                                <div class="card-body">
                                    <form action="registerValidation.php" method="POST" class="signup-form needs-validation" novalidate>
                                        <?php
                                        $URL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                        if (strpos($URL, "signup=email") == true) {
                                            echo "<div class=\"alert alert-danger text-center\" role=\"alert\">" .
                                                "Email già registrata!" .
                                                "</div>";
                                        } else if (strpos($URL, "signup=telefono") == true) {
                                            echo "<div class=\"alert alert-danger text-center\" role=\"alert\">" .
                                                "Numero telefonico già registrato!" .
                                                "</div>";
                                        }
                                        ?>
                                        <input type="hidden" name="soggetto" value="cittadino">
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="initialism mb-1" for="inputNome">Nome</label>
                                                    <input class="form-control " id="inputNome" name="inputNome" type="text" placeholder="Inserisci nome" required />
                                                    <div class="invalid-feedback">Nome non inserito</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="initialism mb-1" for="inputCognome">Cognome</label>
                                                    <input class="form-control " id="inputCognome" name="inputCognome" type="text" placeholder="Inserisci cognome" required />
                                                    <div class="invalid-feedback">Cognome non inserito</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="initialism mb-1" for="inputData">Data di nascita</label>
                                                    <input class="form-control " id="inputData" name="inputData" type="text" placeholder="GG/MM/AAAA" required />
                                                    <div class="invalid-feedback">Data di nascita non selezionata</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="initialism mb-1" for="inputSesso">Sesso</label>
                                                    <select name="inputSesso" id="inputSesso" class="custom-select form-control" required>
                                                        <option value="" selected>Seleziona sesso...</option>
                                                        <option value="maschio">Maschio</option>
                                                        <option value="femmina">Femmina</option>
                                                    </select>
                                                    <div class="invalid-feedback">Sesso non selezionato</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="initialism mb-1" for="inputProvinciaNascita">LUOGO DI NASCITA (PROVINCIA)</label>
                                                    <select name="inputProvinciaNascita" id="inputProvinciaNascita" class="custom-select form-control" onchange="show(this.value, 4)" required>
                                                        <option value="" selected>Seleziona provincia...</option>
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

                                                        $sqlquery = "select provincia from italy_provincies;";
                                                        $result = $conn->query($sqlquery);

                                                        if ($result->rowCount() == 0) {
                                                            echo "<center><p>La ricerca non ha prodotto nessun risultato</p></center>";
                                                        } else {
                                                            while ($row = $result->fetch()) {
                                                                $value = $row["provincia"];
                                                                echo "<option value=\"$value\">" . $value . "</option>";
                                                            }
                                                            unset($result);
                                                        }
                                                        unset($conn);
                                                        ?>
                                                    </select>
                                                    <div class="invalid-feedback">Provincia non selezionata</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="initialism mb-1" for="inputCittaNascita">(Citt&agrave;)</label>
                                                    <select name="inputCittaNascita" id="inputCittaNascita" class="custom-select form-control" required disabled>
                                                        <option value="" selected>Seleziona citt&agrave;...</option>
                                                    </select>
                                                    <div class="invalid-feedback">Citt&agrave; di nascita non
                                                        selezionata</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="initialism mb-1" for="inputCodiceFiscale">Codice fiscale</label>
                                            <input class="form-control " name="inputCodiceFiscale" id="inputCodiceFiscale" type="text" style="text-transform: uppercase" placeholder="Inserisci codice fiscale" maxlength="16" required />
                                            <div class="invalid-feedback">Codice fiscale errato</div>
                                        </div>
                                        <hr />
                                        <p class="lead">RESIDENZA</p>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="initialism mb-1" for="inputRegioneResidenza">Regione</label>
                                                    <select name="inputRegioneResidenza" id="inputRegioneResidenza" class="custom-select form-control" onchange="show(this.value, 1)" required>
                                                        <option value="" selected>Seleziona regione...</option>
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

                                                        $sqlquery = "SELECT regione FROM italy_regions;";
                                                        $result = $conn->query($sqlquery);

                                                        if ($result->rowCount() == 0) {
                                                            echo "<center><p>La ricerca non ha prodotto nessun risultato</p></center>";
                                                        } else {
                                                            while ($row = $result->fetch()) {
                                                                $value = $row["regione"];
                                                                echo "<option value=\"$value\">" . $value . "</option>";
                                                            }
                                                            unset($result);
                                                        }
                                                        unset($conn);
                                                        ?>
                                                    </select>
                                                    <div class="invalid-feedback">Regione non inserita</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="initialism mb-1" for="inputProvinciaResidenza">Provincia</label>
                                                    <select name="inputProvinciaResidenza" id="inputProvinciaResidenza" class="custom-select form-control" onchange="show(this.value, 2)" required disabled>
                                                        <option value="" selected>Seleziona provincia...</option>
                                                    </select>
                                                    <div class="invalid-feedback">Provincia non selezionata</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="initialism mb-1" for="inputCittaResidenza">Citt&agrave;</label>
                                                    <select name="inputCittaResidenza" id="inputCittaResidenza" class="custom-select form-control" onchange="show(this.value, 3)" required disabled>
                                                        <option value="" selected>Seleziona città...</option>
                                                    </select>
                                                    <div class="invalid-feedback">Citt&agrave; non selezionata</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="initialism mb-1" for="inputCAPResidenza">CAP</label>
                                                    <input type="number" name="inputCAPResidenza" id="inputCAPResidenza" class="form-control" placeholder="Inserisci CAP" required disabled style="background-color: white!important;" />
                                                    <div class="invalid-feedback">CAP non inserito</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="initialism mb-1" for="inputIndirizzoResidenza">Indirizzo di residenza</label>
                                                    <input type="text" name="inputIndirizzoResidenza" id="inputIndirizzoResidenza" class="form-control" placeholder="Inserisci indirizzo di residenza" required />
                                                    <div class="invalid-feedback">Indirizzo non inserito</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="initialism mb-1" for="inputCivico">Numero civico</label>
                                                    <input type="text" name="inputCivico" id="inputCivico" class="form-control" placeholder="Inserisci il numero civico" required />
                                                    <div class="invalid-feedback">Numero civico non inserito</div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr />
                                        <div class="form-group">
                                            <label class="initialism mb-1" for="inputTelefono">Contatto telefonico</label>
                                            <input class="form-control" id="inputTelefono" name="inputTelefono" type="text" placeholder="Inserisci contatto telefonico" maxlength="10" required />
                                            <div class="invalid-feedback">Contatto telefonico non inserito</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="initialism mb-1" for="inputEmailAddress">Email</label>
                                            <input class="form-control" id="inputEmailAddress" name="inputEmailAddress" type="email" placeholder="Inserisci indirizzo email" required />
                                            <div class="invalid-feedback">Indirizzo email incorretto o non inserito</div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="initialism mb-1" for="inputPassword">Password</label>
                                                    <input class="form-control" id="inputPassword" name="inputPassword" type="password" placeholder="Inserisci una password" required />
                                                </div>
                                                <div class="invalid-feedback">Password non inserita</div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="initialism mb-1" for="inputConfirmPassword">Conferma Password</label>
                                                    <input class="form-control" id="inputConfirmPassword" name="inputConfirmPassword" type="password" placeholder="Conferma password" required />
                                                </div>
                                                <div class="invalid-feedback">Conferma la password</div>
                                            </div>
                                        </div>

                                        <div class="form-group mt-4 mb-0">
                                            <input type="submit" class="btn btn-primary btn-block" value="Crea Account">
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center">
                                    <div class="initialism">Sei gi&agrave; registrato? <a href="loginCittadino.php">Accedi</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    </script>
    <!--<script src="js/scripts.js"></script>-->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="js/bootstrap.js" type="text/javascript"></script>

    <script type="text/javascript">
        /* Filtri per campi di testo */
        function setInputFilter(textbox, inputFilter) {
            ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(
                event) {
                textbox.addEventListener(event, function() {
                    if (inputFilter(this.value)) {
                        this.oldValue = this.value;
                        this.oldSelectionStart = this.selectionStart;
                        this.oldSelectionEnd = this.selectionEnd;
                    } else if (this.hasOwnProperty("oldValue")) {
                        this.value = this.oldValue;
                        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                    } else {
                        this.value = "";
                    }
                });
            });
        }
        setInputFilter(document.getElementById("inputTelefono"), function(value) {
            return /^-?\d*$/.test(value);
        });
        setInputFilter(document.getElementById("inputNome"), function(value) {
            return /^[a-z]*$/i.test(value);
        });
        setInputFilter(document.getElementById("inputCognome"), function(value) {
            return /^[a-z]*$/i.test(value);
        });

        function show(str, key) {
            var xhttp;
            if (key == 1) {
                if (str != "") {
                    xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("inputProvinciaResidenza").innerHTML = this.responseText;
                        }
                    };
                    document.getElementById("inputProvinciaResidenza").disabled = false;
                    xhttp.open("GET", "readProvincia.php?dato=" + str, true);
                    xhttp.send();
                } else {
                    var num_option = document.getElementById("inputProvinciaResidenza").options.length;
                    document.getElementsByName("inputProvinciaResidenza")[0].options[0].innerHTML = "Seleziona provincia...";
                    for (a = num_option; a >= 1; a--) {
                        document.getElementById("inputProvinciaResidenza").options[a] = null;
                    }
                    num_option = document.getElementById("inputCittaResidenza").options.length;
                    document.getElementsByName("inputCittaResidenza")[0].options[0].innerHTML = "Seleziona citt&agrave;...";
                    for (a = num_option; a >= 1; a--) {
                        document.getElementById("inputCittaResidenza").options[a] = null;
                    }
                    document.getElementById("inputCAPResidenza").value = "";
                    document.getElementById("inputProvinciaResidenza").disabled = true;
                    document.getElementById("inputCittaResidenza").disabled = true;
                    document.getElementsByName("inputProvinciaResidenza")[0].options[0].innerHTML = "Seleziona provincia...";
                    return;
                }
            } else if (key == 2) {
                if (str != "") {
                    xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("inputCittaResidenza").innerHTML = this.responseText;
                        }
                    };
                    document.getElementById("inputCittaResidenza").disabled = false;
                    xhttp.open("GET", "readCitta.php?dato=" + str, true);
                    xhttp.send();
                } else {
                    document.getElementById("inputCittaResidenza").disabled = true;
                    return;
                }
            } else if (key == 3) {
                if (str != "") {
                    xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("inputCAPResidenza").value = this.responseText;
                        }
                    };
                    xhttp.open("GET", "readCAP.php?dato=" + str, true);
                    xhttp.send();
                } else {
                    return;
                }
            } else if (key == 4) {
                if (str != "") {
                    xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("inputCittaNascita").innerHTML = this.responseText;
                        }
                    };
                    document.getElementById("inputCittaNascita").disabled = false;
                    xhttp.open("GET", "readCitta.php?dato=" + str, true);
                    xhttp.send();
                } else {
                    num_option = document.getElementById("inputCittaNascita").options.length;
                    document.getElementsByName("inputCittaNascita")[0].options[0].innerHTML = "Seleziona citt&agrave;...";
                    for (a = num_option; a >= 1; a--) {
                        document.getElementById("inputCittaNascita").options[a] = null;
                    }
                    document.getElementById("inputCittaNascita").disabled = true;
                    return;
                }
            }
        }
    </script>
    <script type="text/javascript">
        $(function() {
            $("#inputData").datepicker({
                changeYear: true,
                changeMonth: true,
                dateFormat: 'dd/mm/yy',
                maxDate: '-14Y'
            });
        });
        var form = document.querySelector(".needs-validation");

        form.addEventListener("submit", function(event) {
            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add("was-validated");
        });
    </script>
</body>

</html>
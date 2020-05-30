<?php
if (!isset($_GET['role'])) {
    header("Location: index.html");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="HandheldFriendly" content="true" />

    <title>Entra in CarBase</title>

    <link href="css/signUp.css" rel="stylesheet" />
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/navbar.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" />
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
    </script>
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
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Bentornato</h3>
                                </div>
                                <div class="card-body">
                                    <form action="loginValidation.php" method="POST" class="signup-form needs-validation" novalidate>
                                        <?php
                                        $URL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                        if (isset($_GET['role'])) {
                                            echo "<input type=\"hidden\" name=\"role\" id=\"role\" value=\"" . $_GET['role'] . "\"/>";
                                        }
                                        if (isset($_GET['case'])) {
                                            echo "<div class=\"alert alert-danger text-center\" role=\"alert\">" .
                                                "Email o password non corretti!" .
                                                "</div>";
                                        }
                                        ?>
                                        <div class="form-group">
                                            <label class="initialism mb-1" for="inputEmailAddress">Email</label>
                                            <input class="form-control py-4" name="inputEmailAddress" id="inputEmailAddress" type="email" placeholder="Inserisci indirizzo email" required />
                                            <div class="invalid-feedback">Email non inserita o incorretta</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="initialism mb-1" for="inputPassword">Password</label>
                                            <input class="form-control py-4" name="inputPassword" id="inputPassword" type="password" placeholder="Inserisci password" required />
                                            <div class="invalid-feedback">Password non inserita</div>
                                        </div>
                                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="password.html">PASSWORD DIMENTICATA?</a>
                                            <input type="submit" class="btn btn-primary" value="Login" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="js/bootstrap.js"></script>
</body>

</html>